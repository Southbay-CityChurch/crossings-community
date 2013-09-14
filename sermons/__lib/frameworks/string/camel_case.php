<?php

class CamelCase {
   
   
   // Converts 'this_is_cool' to ThisIsCool
   function camelize($string, $first_word_lowercase = true){
      $string = str_replace(' ','',ucwords(strtolower(str_replace('_',' ', $string))));
      if (!$first_word_lowercase)
         $string[0] = strtolower($string[0]);
      
      return $string;
      
   }
   
   
   // Converts 'ThisIsCool' to 'this_is_cool'
   function decamelize($string){
      return strtolower(join('_',preg_split('/([A-Z]+[a-z]*)/', $string, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE)));
   }
   
   
   // Retusn true of false depending on whether a string seems to be camelized
   function isCamelized($string){
      
      preg_match('/[^A-Za-z]/', $string, $matches, PREG_OFFSET_CAPTURE);
      
      return ( (strpos(trim($string), ' ') == 0) &&
               (count($matches) == 0) && 
               (strtolower($string) != $string));
   }
   
}

class StringConverter extends CamelCase {}

?>