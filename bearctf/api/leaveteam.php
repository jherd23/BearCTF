<?php
  #works
  include "authenticateuser.php";
  $givenPassword = $_POST['password'];
  if($userdata['password'] !== sha1($givenPassword)){
    die('{"success":"no","reason":"Invalid password."}');
  }
  $teamName = $userdata['team'];
  $teamwlp = 'teams/teams.wlist';
  $teamwlh = fopen($teamwlp,'r');
  $teamwld = json_decode(fread($teamwlh,filesize($teamwlp)),true);
  fclose($teamwlh);
  if(!isset($teamwld[$teamName])){
    die('{"success":"no","reason":"Interal Error."}');
  }
  if($teamwld[$teamName]['0'] === $userdata['username']){
    $teamwld[$teamName]['0'] = $teamwld[$teamName]['1'];
    $teamwld[$teamName]['1'] = $teamwld[$teamName]['2'];
    unset($teamwld[$teamName]['2']);
  }else if($teamwld[$teamName]['1'] === $userdata['username']){
    $teamwld[$teamName]['1'] = $teamwld[$teamName]['2'];
    unset($teamwld[$teamName]['2']);
  }else if($teamwld[$teamName]['2'] === $userdata['username']){
    unset($teamwld[$teamName]['2']);
  }else{
    die('{"success":"no","reason":"Internal Error"}');
  }
  if(!(isset($teamwld[$teamName]['0']) || isset($teamwld[$teamName]['1']) || isset($teamwld[$teamName]['2']) || isset($teamwld[$teamName]['3']))){
    unset($teamwld[$teamName]);
  }
  unset($userdata['team']);
  $teamwlhow = fopen($teamwlp,'w');
  fwrite($teamwlhow,json_encode($teamwld));
  fclose($teamwlhow);
  $userfileoverwriter = fopen($userpath,'w');
  fwrite($userfileoverwriter,json_encode($userdata));
  fclose($userfileoverwriter);
  echo '{"success":"yes","response":"You have successfully been removed from the team."}';
?>
