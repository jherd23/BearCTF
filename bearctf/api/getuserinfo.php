<?php
	include 'authenticateuser.php';
	$userJSON = $userdata;
	$teamwlp = 'teams/teams.wlist';
	$teamwlh = fopen($teamwlp,'r');
	$teamwld = json_decode(fread($teamwlh,filesize($teamwlp)),true);
	fclose($teamwlh);
	$userInfoJSONText = "{";
	$userInfoJSONText .= '"0":{"name":"Username","info":"' . $userJSON['username'] . '"}';
	if(!isset($userJSON['team']) || !isset($teamwld[$userJSON['team']])){
		$userInfoJSONText .= ',"1":{"name":"Notice","info":"You must join a team to access problems and participate."}';
	}else{
		$userInfoJSONText .= ',"1":{"name":"Team","info":"' . $userJSON['team'] . '"}';
		$userInfoJSONText .= ',"2":{"name":"Points","info":"' . $teamwld[$userJSON['team']]['points'] . '"}';
		$userInfoJSONText .= ',"3":{"name":"Problems Completed","info":"' . count($teamwld[$userJSON['team']]['completed']) . '"}';
	}
	$userInfoJSONText .= '}';
	$wrappedUserInfo = "{";
	$wrappedUserInfo .= '"success":"yes","attrs":';
	$wrappedUserInfo .= $userInfoJSONText;
	$wrappedUserInfo .= "}";
	echo $wrappedUserInfo;
?>
