<?php
  $flag = '{"flag":"{homer_was_a_fan_of_javascript}"}';
  if(isset($_POST['auth'])){
    echo $flag;
  }else{
    die("");
  }
?>
