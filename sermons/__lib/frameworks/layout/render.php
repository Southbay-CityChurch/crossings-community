<?php

class Render {
   
   /*
    * A partial is a file located in the same directory as where it is called from
    * that starts with a '_' and is a small snippet to get included.
    * example: 
    *          echo Render::partial('week', array('variable_1' => 'my data in here'));
    * 
    * this would look for the file called '_week.php' in the directory current directory
    * and extract the array passed in so that $variable_1 contains the value 'my data in here'
    * 
    * returns a string
    */
   function partial($file_name,$data) {
      $use_file = Render::figureOutFileLocation($file_name);
      
      // This wraps up the output into an output buffer
      // extracts the data then cleans it all up and returns
      // the partial as a string.... this is ripe for caching!
      ob_start();
         extract($data);
         require($use_file);
      return ob_get_clean();

   }
   
   
   
   function figureOutFileLocation($file_name) {
      
      if(!Path::isAbsolute($file_name)) {
         
         // Add '.php' to the end if it does not exist?
         $file_name = Path::shouldEndWith($file_name, '.php');         
         
         // Add '_' if the file name doesn't have it
         $file_name = Path::shouldBeginWith($file_name, '_');
         
         // Using backtrace to find out what directory I was called from....
         // So fancy :)
         $bt_data = debug_backtrace();
         $directory_i_was_called_from = dirname($bt_data[1]['file']);
         
         $file_name = $directory_i_was_called_from . '/' . $file_name;
   
         if(!is_readable($file_name))  trigger_error('The file you are trying to read (' . $file_name . ') is not readable or does not exist.');
      }
      return($file_name);
      
   }
   
}


?>
