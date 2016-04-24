<?php
	#updated to support whitelist
	$username = $_POST['username'];
	if($username == ''){
		die('{"success":"nope","reason":"No username given."}');
	}
	$redirect = "";
	if($_POST['redirect'] !== "none"){
		$redirect = ",\"redirect\":\"" . $_POST['redirect'] . "\"";
	}
	$whitelistPath = 'db/db.wlist';
	$whiteListHandle = fopen($whitelistPath, 'r');
	$whiteListData = json_decode(fread($whiteListHandle, filesize($whitelistPath)),true);
	fclose($whiteListHandle);
	if(isset($whiteListData[$username])){
		die('{"success":"nope","reason":"Username already taken"}');
	}
	$username_sanitized = '';
	for($i = 0; $i < strlen($username); $i++){
		if($username[$i] === '/'){
			$username_sanitized .= '_slash_';
		}else{
			$username_sanitized .= $username[$i];
		}
	}
	while(file_exists('db/' . $username_sanitized . '.usr')){
		$username_sanitized .= "_";
	}
	$whiteListData[$username] = array("userPath" => 'db/' . $username_sanitized . '.usr');
	$whiteListHandleForWriting = fopen($whitelistPath,'w');
	fwrite($whiteListHandleForWriting,json_encode($whiteListData));
	fclose($whiteListHandleForWriting);
	$newUser = fopen('db/' . $username_sanitized . '.usr','w');
	$password = $_POST['password'];
	$jason = '{"username":"' . $username . '","password":"' . sha1($password) .'","cookie":"' . sha1(sha1($username) . 'supersalty' . sha1($password)) . '","points":0,"completed":[]}';
	fwrite($newUser, $jason);
	fclose($newUser);
	echo '{"success":"yes","response":' . json_encode('User '.$username.' has been successfully registered!') . $redirect . '}';
?>
