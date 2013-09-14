<?php
   class Includes {
      function pattern($string, $pattern) {
         return (preg_match($pattern, $string) >= 1);
      }
   }

?>

