<?php
  if($_POST['answer'] === '{homer_was_a_fan_of_javascript}'){
    $response = array('success' => 'yes','response' => 'Correct!');
  }else{
    $response = array('success' => 'no','reason' => 'Incorrect!');
  }
?>
