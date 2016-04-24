<?php
	#updated to support whitelist
	$username = $_COOKIE['username'];
	$whitelistPath = 'db/db.wlist';
	$whiteListHandle = fopen($whitelistPath, 'r');
	$whiteListData = json_decode(fread($whiteListHandle, filesize($whitelistPath)),true);
	fclose($whiteListHandle);
	if(!isset($whiteListData[$username])){
		die('{"success":"nope","reason":"Username not registered"}');
	}
	$userPath = $whiteListData[$username]['userPath'];
	$userFile = fopen($userPath, 'r');
	$userJSON = json_decode(fread($userFile, filesize($userPath)),true);
	fclose($userFile);
	if($userJSON['cookie'] !== $_COOKIE['id']){
		die('{"success":"no","reason":"Invalid credentials."}');
	}
	$userJSON['points'] = 0;
	foreach ($userJSON['completed'] as $key => $value) {
		unset($userJSON['completed'][$key]);
	}
	$userOverwrite = fopen($userPath, 'w');
	fwrite($userOverwrite, json_encode($userJSON));
	fclose($userOverwrite);
	echo '{"success":"yes","response":"Reset successful."}';
?>
