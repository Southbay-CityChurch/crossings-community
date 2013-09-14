<?php

/* so the framework loader got annoying, now its just
 * require(CART_MODEL); or something like that.
 */
class Constantize {
   
   /**
    * Defines a constant for each framework so require TEST_SUITE_FRAMEWORK loads the framework
    * no need to worry about paths
    * Each framekwork in the framework directory gets 
    * FILE_NAME_FRAMEWORK, where 'FILE_NAME' is the file name minus '.php'
    */
   function defineConstantsForEachFramework(){
      Constantize::defineConstantsForEachFileIn(LoadUtility::frameworkDirectory(),'','_FRAMEWORK');
   }
   
   /**
    * Defines a constant for each model so require CART_MODEL loads the model, no need to worry about paths
    * Each model in the model directory gets FILE_NAME_MODEL, where 'FILE_NAME' is the file name minus '.php'
    */
   function defineConstantsForEachModel(){
      Constantize::defineConstantsForEachFileIn(LoadUtility::frameworkDirectory().'..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR,'','_MODEL');
   }
   
   function defineConstantsForEachVendorLibrary(){
      Constantize::defineConstantsForEachFileIn(LoadUtility::frameworkDirectory().'..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR,'EXTERNAL_','');
      Constantize::defineConstantsForEachFileIn(LoadUtility::frameworkDirectory().'..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR,'VENDOR_','');
      
   }
   
   /** This does the heavy hitting */
   function defineConstantsForEachFileIn($directory, $prefix='', $suffix='') {
      if (substr($directory,-1) != DIRECTORY_SEPARATOR) $directory.= DIRECTORY_SEPARATOR;
      $handle = opendir($directory);
      while (false !== ($file = readdir($handle))) { 
         if(strtolower(substr($file,-4)) == '.php') {
            $constant_name = $prefix . strtoupper(basename($file, '.php') . $suffix);
            
            // Its nice, it doesn't die when there is another one defined.
            if(!defined($constant_name))    define($constant_name, $directory . $file);
         }
      }
      closedir($handle);
   }
   
}

?>