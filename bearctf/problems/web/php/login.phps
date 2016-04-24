<?php
  include "accounts.php"; #gets the $realUsername, $realPassword, and $flag variables
  $givenUsername = $_GET['u'];
  $givenPassword = $_GET['p'];
  if(strcmp($givenUsername,$realUsername) == 0 && strcmp($givenPassword,$realPassword) == 0){
    echo "<h1>The flag is " . $flag . ".</h1>";
  }else{
    echo "<h1>Invalid credentials</h1>";
  }
?>
