<?php


class Replace {
   function lastOccurance($string,$needle,$replacemet) {
      $rstring = strrev($string);
      $rneedle = strrev($needle);
      $rpos = strpos(' '.$rstring, $rneedle);
      
      if ($rpos >= 1) {
         $pos = strlen($string) - $rpos - 1 ;
         $right_end = substr($string,(strlen($needle) + $pos));
         $string = substr($string, 0, $pos) . $replacemet . $right_end;
      }
      return $string;
   }
   
   function pattern($string,$pattern, $replacement){
      return preg_replace($pattern, $replacement, $string);
   }
}


?>