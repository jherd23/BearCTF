<?php
  if($_POST['answer'] === '{RSA_Encryption_is_not_that_hard}'){
    $response = array('success' => 'yes','response' => 'Correct!');
  }else{
    $response = array('success' => 'no','reason' => 'Incorrect!');
  }
?>
