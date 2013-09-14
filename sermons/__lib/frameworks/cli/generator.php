<?php

class Generator {


   // function framework($framework_name) {
   //    
   // }
   

   //private (but they are static so why does it matter?)
   function copy_and_rename_template_directories($type, $new_name) {
      $base_directory = LoadUtility::frameworkDirectory() . '../../';
      $copy_from_directory = dirname(__FILE__) . '/' . 'generator_templates/';
      $replacement_string = 'RENAME_ME';

      switch( $type ) {
         case 'framework' : 
            $create_in_directory = $base_directory . '__lib/frameworks/'; 
            $copy_from_directory.= 'frameworks/';
            break;
            
         default: trigger_error("Unknown type ($type), what do I do?");
         
      }
      
      if (!is_dir($copy_from_directory))   trigger_error("This is not a valid directory ($copy_from_directory)");

      
   }
   
   /**
    * Use this to copy any file/directory structure to a new location
    * the $from should include the full path to the entire tree/file/directory to copy
    * but the $to should just contain the basename of where this is going (it should be a directory)
    */
   function deep_copy($from, $to, $over_write = false) {
      if(!is_dir($to))  trigger_error('Expecting $to (' . $to . ') to be a valid directory.');
      
      if (is_dir($from)) {
         // copy the directory
         
         mkdir($to . '/' . $from);
         
         $from_handle = opendir($copy_from_directory);
         while (false !== ($file = readdir($handle))) { 
            if ( $file == '.' || $file == '..' ) continue;
            // nice way to not worry what this function or class is named while still being recursive
            eval(__CLASS__ . '::' . __FUNCTION__ . '( ' . $file . ', ("' . $to . '/' . $file . '"), ' . $over_write . ');');
         }
         closedir($from_handle);
      } elseif (is_file($from)) {
         copy($from, $to.'/'.$from);
      }
   }
   
   function diffPaths($first, $second){
      // $first = realpath($first);
      // $second = realpath($second);
      if(substr($first,-1) != '/')  $first.='/';
      if(substr($second,-1) != '/')  $second.='/';
      
      if( strpos(' '.$second, $first) == 1 && substr($second,0,1) == '/' )
         return substr($second, strlen($first));
      else
         return $second;
   }
   
}

?>