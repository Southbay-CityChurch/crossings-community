<?php


class Define {

   function _try($const, $value) {
      $const = strtoupper($const);
      if(!defined($const)){
         define($const, $value);
         return true;
      } else 
         return false;
   }
   
}

class Defined {

   function orUse($const, $value) {
      if(defined($const))
         return constant($const);
      else
         return $value;
   }
   
   function is($conts) {
      return defined($const);
   }
}

?>