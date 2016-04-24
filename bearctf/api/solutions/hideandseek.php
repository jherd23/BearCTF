<?php
  if($_POST['answer'] === '{out_of_sight_out_of_mind}'){
    $response = array('success' => 'yes','response' => 'Correct!');
  }else{
    $response = array('success' => 'no','reason' => 'Incorrect!');
  }
?>
