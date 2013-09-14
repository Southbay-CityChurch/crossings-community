<?php

   // class HTMLMeta extends HTMLBase{
   //    //<link href="" rel="stylesheet" type="text/css" media="all">
   //    
   //    function css ($file,$options = array()){
   //             
   //       //  A little trick to try.... variable function arguments... yummy
   //       //  HTMLMeta::css('undohtml','basic', 'week');
   //       if(func_num_args() > 2) {
   //          $css_files = array();
   //          $options = array(); // need to reset this.
   //          
   //          foreach(func_get_args() as $argument) {
   //             if(is_string($argument))      $css_files[] = $argument;
   //             elseif(is_array($argument))   $options =     $argument;
   //          }
   //          $file = $css_files;
   //       }
   //       
   //       
   //       
   //       if(is_array($file)){
   //          foreach($file as $a_file)
   //             $string.= HTMLMeta::css($a_file, $options);
   //       } else {
   //          if(substr(strtolower($file),-4) != '.css')  $file.='.css';
   // 
   //          if(substr($file,0,1) != '/' && defined('URL_ROOT'))  $file = URL_ROOT . 'public/stylesheets/' . $file ;
   //          
   //          $defaults = array("href" => $file,
   //                            "type" => "text/css", 
   //                            "media" => "all",
   //                            "rel" => "stylesheet");
   //          $string = HTMLMeta::tag('link','',array_merge($defaults,$options));
   //       }
   //       return $string;
   //    }
   //    
   //    function simple($options = null){
   //       return HTMLMeta::tag('meta','',$options);
   //    }
   //    
   //    
   // }

?>
