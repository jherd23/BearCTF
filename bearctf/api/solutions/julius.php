<?php
  if($_POST['answer'] === '{the_fault_dear_brutus_is_in_our_cipher}'){
    $response = array('success' => 'yes','response' => 'Correct!');
  }else{
    $response = array('success' => 'no','reason' => 'Incorrect!');
  }
?>
