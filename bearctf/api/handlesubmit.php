<?php
	#updated to support whitelist
	#updates team's points

	date_default_timezone_set('America/New_York');

	include 'authenticateuser.php';
	$userJSON = $userdata;
	if(!isset($userJSON['team'])){
		die('{"success":"no","reason":"You must be part of a team to answer questions."}');
	}
	$teamwlp = 'teams/teams.wlist';
	$teamwlh = fopen($teamwlp,'r');
	$teamwld = json_decode(fread($teamwlh,filesize($teamwlp)),true);
	fclose($teamwlh);
	if(!isset($teamwld[$userJSON['team']])){
		die('{"success":"no","reason":"Internal error."}');
	}
	$teamJSON = $teamwld[$userJSON['team']];
	$problistfile = fopen('problems/listing.lst','r');
	$problemlist = json_decode(fread($problistfile,filesize('problems/listing.lst')),true);
	fclose($problistfile);
	if(!isset($problemlist[$_POST['problem']])){
		die('{"success":"nope","reason":"Problem ' . $_POST['problem'] . ' does not exist!"}');
	}
	$problemPath = 'problems/' . $problemlist[$_POST['problem']]['problempath'] . '.prb';
	if(!file_exists($problemPath)){
		die('{"success":"nope","reason":"Problem does not exist!!!  Path=' . $problemPath . '"}');
	}
	$problemFile = fopen($problemPath, 'r');
	$problemJSON = json_decode(fread($problemFile, filesize($problemPath)),true);
	fclose($problemFile);
	if($teamJSON['points'] < $problemJSON['pointRequirement']){
		die('{"success":"nope","reason":"You have not progressed far enough to answer this problem!"}');
	}
	$solutionPath = $problemJSON['path'];
	if(!file_exists($solutionPath)){
		die('{"success":"nope","reason":"Internal error."}');
	}
	if($_POST['answer'] == ""){
		die('{"success":"nope","reason":"Please enter a solution"}');
	}
	include $solutionPath;
	if(isset($response)){
		if(time() < mktime(15,5,0,4,23,2016) && $response['success'] === 'yes'){
			$teamJSON['points'] += $problemJSON['pointValue'];
			$teamJSON['completed'][$_POST['problem']] = "check!";
			$teamwld[$userJSON['team']] = $teamJSON;
			$teamFileOverwrite = fopen('teams/teams.wlist', 'w');
			fwrite($teamFileOverwrite, json_encode($teamwld));
			fclose($teamFileOverwrite);
		}
		echo json_encode($response);
	}else{
		echo '{"success":"no","reason":"Incorrect flag!"}';
	}
?>
