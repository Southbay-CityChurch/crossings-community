<?php 
class Plurals {
   
   
   function pluralize($string){      
      
      $string = trim($string);
      $stringi = strtolower($string);
      
      $special_cases_plurals = array_flip(Plurals::specialCases());
      $special_cases = Plurals::specialCases();
      
      $plural = $string.'s';
      switch ( true ){
         case (array_search($string, $special_cases_plurals)):
            $plural = $special_cases[$string];
            break;
         
         case( Includes::pattern($stringi, '/sis$/')): $plural = Replace::pattern($string,'/sis$/', 'ses'); break;
         case( Includes::pattern($stringi, '/ss$/')):  $plural = Replace::pattern($string,'/ss$/', 'sses'); break;
         case( Includes::pattern($stringi, '/x$/')):   $plural = Replace::pattern($string,'/x$/', 'xes'); break;

         // case (Plurals::endsWith($string, 'x')):      $plural = Replace::lastOccurance($string, 'x', 'xes'); break;
         
      }
      return $plural;
   }
   
   function depluralize($string) {return Plurals::singularize($string);}
   function singularize($string) {
      $string = trim($string);
      $stringi = strtolower($string);
      $special_cases_plurals = array_flip(Plurals::specialCases());
      $special_cases = Plurals::specialCases();
      
      switch(true) {
         //special cases
         case (array_search($string, $special_cases)):   $singlular = $special_cases_plurals[$string];   break;
         
         case(Includes::pattern($stringi, '/sses$/')):  $singlular = Replace::pattern($string, '/sses/','ss'); break;
         case(Includes::pattern($stringi, '/xes$/')):      $plural = Replace::pattern($string,'/xes$/', 'x'); break;
         
         
         case(substr($stringi,-1,1) == 's'):
            $singlular = substr($stringi,0,-1);
            break;
      }
      
      return $singlular;
   }

   function specialCases() {
      return array(  'person' => 'people',
                     'child'  => 'children',
                     'man'    => 'men',
                     'ox'     => 'oxen');


   }
         
   function endsWith($string,$ends){
      return (substr(strtolower($string),(-1 * strlen($ends)) ) == strtolower($ends));
   }
   

}

?>