<?php
  #works
  include 'authenticateuser.php';
  $whiteListPath = 'teams/teams.wlist';
  $whiteListHandle = fopen($whiteListPath,'r');
  $whiteListData = json_decode(fread($whiteListHandle,filesize($whiteListPath)),true);
  fclose($whiteListHandle);
  $teamname = $_POST['teamname'];
  if(isset($whiteListData[$teamname])){
    die('{"success":"no","reason":"Team already exists"}');
  }
  $whiteListData[$teamname] = array('0' => $username,'points' => 0,'completed' => array());
  $whiteListHandleForWriting = fopen($whiteListPath,'w');
  fwrite($whiteListHandleForWriting,json_encode($whiteListData));
  fclose($whiteListHandleForWriting);
  $userdata['team'] = $teamname;
  $userfileforwriting = fopen($userpath,'w');
  fwrite($userfileforwriting,json_encode($userdata));
  fclose($userfileforwriting);
  echo '{"success":"yes","response":"Team successfully created"}';
?>
