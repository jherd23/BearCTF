<?php
  $teamwlp = 'teams/teams.wlist';
  $teamwlh = fopen($teamwlp,'r');
  $teamwld = fread($teamwlh,filesize($teamwlp));
  fclose($teamwlh);
  $wrapper = '{"success":"yes","teams":' . $teamwld . '}';
  echo $wrapper;
?>
