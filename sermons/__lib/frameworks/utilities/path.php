<?php


   class Path{
      function isAbsolute($path) {
         return substr(trim($path),0,1) == DIRECTORY_SEPARATOR;
      }
      
      function shouldEndWith($path, $ending = '.php'){
         if(substr(strtolower($path),strlen($ending)) != $ending)   $path.= $ending;
         return $path;
      }
      
      function shouldBeginWith($path, $begining) {
         if(substr($path,0,strlen($begining)) != $begining)          $path = $begining . $path;
         return $path;
      }
      
   }

?>