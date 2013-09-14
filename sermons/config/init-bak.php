<?php 


   /* here is all the stuff that gets loaded 
    * everytime we call a script
    */

    set_include_path(dirname(__FILE__) . '/../vendor/'. PATH_SEPARATOR . get_include_path() );

    require_once( dirname(__FILE__) . '/../__lib/frameworks/utilities.php');
    
   /* The order here is important as the frameworks might require vendor libraries
   * and the models might require vendors or frameworks
   */
   Constantize::defineConstantsForEachVendorLibrary();
   Constantize::defineConstantsForEachFramework();
   Constantize::defineConstantsForEachModel();
   LoadUtility::loadConfigurations();

   // Environment::Server('crossings');
   Environment::Server('dreamhostProd');


?>