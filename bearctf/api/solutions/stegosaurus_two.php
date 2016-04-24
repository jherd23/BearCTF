<?php
  if($_POST['answer'] === '{this_is_probably_a_good_enough_flag}'){
    $response = array('success' => 'yes','response' => 'Correct!');
  }else{
    $response = array('success' => 'no','reason' => 'Incorrect!');
  }
?>
