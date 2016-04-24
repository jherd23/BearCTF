<?php
  #works
  $teamtoaddto = $_POST['team'];
  $userToAdd = $_COOKIE['username'];
  include 'authenticateuser.php';
  $userJSON = $userdata;
  if(isset($userJSON['team'])){
    die('{"success":"no","reason":"You are already part of a team."}');
  }
  $teamwlp = 'teams/teams.wlist';
	$teamwlh = fopen($teamwlp,'r');
	$teamwld = json_decode(fread($teamwlh,filesize($teamwlp)),true);
	fclose($teamwlh);
  if(!isset($teamwld[$teamtoaddto])){
    die('{"success":"no","reason":"This team does not exist"}');
  }
  if(isset($teamwld[$teamtoaddto]['2'])){
    die('{"success":"no","reason":"The team is full"}');
  }else if(isset($teamwld[$teamtoaddto]['1'])){
    $teamwld[$teamtoaddto]['2'] = $userToAdd;
  }else{
    $teamwld[$teamtoaddto]['1'] = $userToAdd;
  }
  $teamwlhw = fopen($teamwlp,'w');
  fwrite($teamwlhw,json_encode($teamwld));
  fclose($teamwlhw);
  $userJSON['team'] = $teamtoaddto;
  $userfilewrite = fopen($userpath,'w');
  fwrite($userfilewrite,json_encode($userJSON));
  fclose($userfilewrite);
  echo '{"success":"yes","response":"You have been successfully added."}';
?>
