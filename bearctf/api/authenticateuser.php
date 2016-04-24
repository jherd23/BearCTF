<?php
  #works
  if(!isset($_COOKIE['username']) || !isset($_COOKIE['id'])){
    die('{"success":"nope","reason":"You are not logged in properly."}');
  }
  $username = $_COOKIE['username'];
  $dbwlp = 'db/db.wlist';
  $dbwlh = fopen($dbwlp,'r');
  $dbwld = json_decode(fread($dbwlh,filesize($dbwlp)),true);
  if(!isset($dbwld[$username])){
    die('{"success":"nope","reason":"You are not logged in properly."}');
  }
  fclose($dbwlh);
  $userpath = $dbwld[$username]['userPath'];
  $userfile = fopen($userpath,'r');
  $userdata = json_decode(fread($userfile,filesize($userpath)),true);
  if($userdata['cookie'] !== $_COOKIE['id']){
    die('{"success":"nope","reason":"You are not logged in properly."}');
  }
  fclose($userfile);
?>
