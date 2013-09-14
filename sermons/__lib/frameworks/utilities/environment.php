<?php

class Environment {
   
   //function Server($environment, $environment_dir=null) { return Environment::server($environment, $environment_dir);}
   function server($environment, $environment_dir=null){
      if(empty($environment_dir))
         $environment_dir = LoadUtility::frameworkDirectory() . '../../config/environments/';

      $env_file = $environment_dir.$environment.'.env.php';

      if(is_file($env_file))
         require_once($env_file);
      else
         trigger_error("There is no environment file for $environment ($env_file)");
   }
   
   
   //function Database($env) {return Environment::database($env);}
   function database($env=null) {
      $environment_loaded = false;
      
      require_once($environment_dir = LoadUtility::frameworkDirectory() . '../../config/database.config.php');
      
      
      // Can set on a per file basis if needed (maybe for testing!?)
      if (defined(DB_ENVIRONMENT))  $env = DB_ENVIRONMENT;
      
      
      //LoadUtility::whatIsLoaded(true);
      
      $myself = new DatabaseConfig();
      foreach (get_class_methods($myself) as $method_name) {
         if (strtolower($method_name) == strtolower($env))  {
            eval('$myself->' . $env . '();');
            
            foreach(get_object_vars($myself) as $name => $value) {
               $constant_name = 'DB_'.strtoupper($name);
         
               if (!defined($constant_name))
                  define($constant_name, $value);
               else
                  trigger_error("$constant_name has already been defined with value: \"". constant($constant_name)."\"");
            }
            $environment_loaded = true;
         }
      }

      if (!$environment_loaded)  trigger_error('No database environment found matching "' . $env . '"');
      
   }
   
   
}

?>