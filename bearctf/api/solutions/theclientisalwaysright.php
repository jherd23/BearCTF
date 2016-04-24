<?php
  if($_POST['answer'] === "{132458100982469}"){
    $response = array('success' => 'yes','response' => 'Correct!');
  }else{
    $response = array('success' => 'no','reason' => 'Incorrect!');
  }
?>
