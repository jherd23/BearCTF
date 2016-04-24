<?php
  function custom_hash($inputString){
    $arr = array();
    array_pad($arr,iconv_strlen($inputString),array());
    for($i = 0; $i < iconv_strlen($inputString); $i++){
      $char = ord($inputString{$i}) & 255;
      for($j = 0; $j < 7; $j++){
        $arr[$i][$j] = ($char & (1 << $j)) / (1 << $j);
      }
    }
    $ret = "";
    for($i = 0; $i < 7; $i++){
      $place = 0;
      for($j = 0; $j < count($arr); $j++){
        $place = $place | ($arr[$j][$i] << ($j % 12));
      }
      $place_reduced = 0b101;
      while($place > 0){
        $place_reduced = $place_reduced ^ ($place & 7);
        $place = $place >> 3;
      }
      $ret .= $place_reduced;
    }
    return $ret;
  }
?>
