<?php
	#updated to support whitelist
	#now checks team's points/completions when retrieving probelems

	#denies access to problem list before 4/19/2016

	date_default_timezone_set('America/New_York');

	if(time() < mktime(15,5,0,4,19,2016)){
		die('{"success":"no","reason":"Problems will not be released until 3:00pm on April 19th, 2016"}');
	}

	include 'authenticateuser.php';
	$jason = $userdata;
	$teamwlp = 'teams/teams.wlist';
	$teamwlh = fopen($teamwlp,'r');
	$teamwld = json_decode(fread($teamwlh,filesize($teamwlp)),true);
	fclose($teamwlh);
	if(!isset($jason['team'])){
		die('{"success":"no","reason":"You must be part of a team to access questions"}');
	}
	if(!isset($teamwld[$jason['team']])){
		die('{"success":"no","reason":"internal error."}');
	}
	$usersteam = $teamwld[$jason['team']];
	$ret = '{"success":"yes","probs":[';
	if(!file_exists('problems/listing.lst')){
		die('{"success":"no","reason":"Internal Error."}');
	}
	$problistfile = fopen('problems/listing.lst','r');
	$problemlist = json_decode(fread($problistfile,filesize('problems/listing.lst')),true);
	fclose($problistfile);
	foreach ($problemlist as $key => $value) {
		if($usersteam['points'] >= $value['pointrequirement']){
			if(file_exists('problems/' . $value['problempath'] . '.prb')){
				$newFile = fopen('problems/' . $value['problempath'] . '.prb', 'r');
				if($ret !== '{"success":"yes","probs":['){
					$ret .= ',';
				}
				$problemJSON = json_decode(fread($newFile, filesize('problems/' . $value['problempath'] . '.prb')),true);
				if(isset($usersteam['completed'][$value['problempath']])){
					$problemJSON['completed'] = "tru";
				}
				$ret .= json_encode($problemJSON);
				fclose($newFile);
			}
		}
	}
	$ret .= ']}';
	echo $ret;
?>
