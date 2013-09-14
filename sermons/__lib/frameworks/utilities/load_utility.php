<?php 

define('DIRECTORY_UP', DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
define('DIRECTORY_BACK', DIRECTORY_UP);


class LoadUtility {

   /**
    * This handy method loads up any files in a directory that holds file that the framework
    * might need to load
    * if the directory does not exist, it doesn't complain it just exists.
    */
   function loadMyDirectory($my_file_name, $chatty = false){

      $directory = dirname($my_file_name) . DIRECTORY_SEPARATOR . basename($my_file_name,'.php');
      return LoadUtility::loadFilesThatEndWith('.php', $directory, $chatty);
   }
   
   /** Simple one liner to load frameworks
    * without having to worry about paths... how I hate those
    * LoadUtility::loadFramework('test_suite');
    * call it like:
    */
    
   function loadFramework($framework_name) {      
      if (strpos(' '.strtolower($framework_name), '.php') == 0)   $framework_name.= '.php';
      require_once(LoadUtility::frameworkDirectory() . DIRECTORY_SEPARATOR . $framework_name);
   }
   
   // this is fragile right now
   // Includes trailing slash
   function frameworkDirectory() {return dirname(__FILE__) . DIRECTORY_UP;}
   
   function whatIsLoaded($loud = false) {
      if ($loud) {
         echo '<pre>';
         print_r(get_included_files());
         echo '</pre>';  
      }
      return get_included_files();

   }
   
   function whatIsDefined($loud = false) {
      if ($loud) {
         echo '<pre>';
         print_r(get_defined_constants());
         echo '</pre>';  
      }
      return get_defined_constants();
   }
   
   function loadConfigurations() {
      return LoadUtility::loadFilesThatEndWith('config.php', LoadUtility::frameworkDirectory().'..' . DIRECTORY_SEPARATOR . 'config');
   }
   
   
   //private
   
   /*
    * Does what it says, loads files that end with a certain string ($pattern)
    * from a specified directory ($directory).
    * if $chatty is true then it prints out what its loading.
    */
   
   function loadFilesThatEndWith($pattern, $directory, $chatty = false) {
      if (!is_dir($directory)) return false;
      
      $handle = opendir($directory);
   
      while (false !== ($file = readdir($handle))) { 
         if(strtolower(substr($file,(strlen($pattern) * -1))) == strtolower($pattern) && (substr($file,0,1) != '_' )) {
            if ($chatty)   echo "\n loading $directory/$file \n";
            require_once $directory . DIRECTORY_SEPARATOR . $file;
         }
      }
      closedir($handle);
      return true;
   }
   
}

?>