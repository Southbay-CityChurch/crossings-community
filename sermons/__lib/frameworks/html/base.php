<?php

class HTMLBase {
   function tag ($tag, $value='', $options = null){
      $options_string = '';
      $string = '';
      
      if(!is_null($options)) {
         foreach($options as $opt_attribute => $opt_value) {
            $opts[] = "$opt_attribute=\"$opt_value\"";
         }
         $options_string = ' ' . implode(' ',$opts);
      }
      if (HTMLBase::isSingle($tag)) {
         $string = "<$tag$options_string />";
      } else {
         $string = "<$tag$options_string>$value</$tag>";
      }
      
      return $string;
   }
   
   function isSingle ($tag){
      $single_tags = array('br', 
                           'meta', 
                           'link',
                           );
      return in_array(strtolower($tag), $single_tags);
   }
}

?>