<?php
  if($_POST['answer'] === '{areasonablylongandquirkyflag}'){
    $response = array('success' => 'yes','response' => 'Correct!');
  }else{
    $response = array('success' => 'no','reason' => 'Incorrect!');
  }
?>
