<?php
	#updated to support whitelist
	$redirect = "";
	if(isset($_POST['redirect'])){
		$redirect = ',"redirect":"' . $_POST['redirect'] . '"';
	}
	if(!isset($_COOKIE['username']) || !isset($_COOKIE['id'])){
		$username = $_POST['username'];
		if($username == ''){
			die('{"success":"nope","reason":"No username given."}');
		}
		$whitelistPath = 'db/db.wlist';
		$whiteListHandle = fopen($whitelistPath, 'r');
		$whiteListData = json_decode(fread($whiteListHandle, filesize($whitelistPath)),true);
		fclose($whiteListHandle);
		if(!isset($whiteListData[$username])){
			die('{"success":"nope","reason":"Username not registered"}');
		}
		$userFilePath = $whiteListData[$username]['userPath'];
		if(!file_exists($userFilePath)){
			die('{"success":"nope","reason":"Internal error"}');
		}
		$userFile = fopen($userFilePath,'r');
		$inputPassword = $_POST['password'];
		$userObject = json_decode(fread($userFile,filesize($userFilePath)),true);
		fclose($userFile);
		if(sha1($inputPassword) === $userObject['password']){
			setcookie('username',$username,time() + 5 * 86400,'/');
			setcookie('id',$userObject['cookie'],time() + 5 * 86400,'/');
			echo '{"success":"yes","response":"Successfully logged in!"' . $redirect . '}';
		}else{
			echo '{"success":"nope","reason":"Incorrect Password"}';
		}
	}
?>
