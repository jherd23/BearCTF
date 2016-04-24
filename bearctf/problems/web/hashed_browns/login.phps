<?php
  include "accounts.php"; #gets $flag
  include "hash.php"; #gets hash function
  $username = "admin";
  $hashedPassword = "5004555";
  if($_GET['u'] === $username && custom_hash($_GET['p']) === $hashedPassword){
    echo "The flag is:" . $flag . ".";
  }else{
    echo "<h1>Invalid Credentials</h1>";
  }
?>
