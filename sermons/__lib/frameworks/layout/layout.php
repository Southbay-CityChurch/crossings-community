<?php
// write_log("-");
// write_log(basename(__FILE__) . " Being Loaded");

	$__layout = new Layout();

	class Layout {
	   var $layout_directory = null;
	   var $layout_file = null;
	   var $buffer = '';
	   // var $buffer_processed = false;
   
	   function layout() {
      
	      // remove any previous output buffers
			if (ob_get_length() > 0) {
				ob_end_clean();
			}            
	      // start the real output buffer
	      ob_start(array($this, 'getContent'));
      
	      // This is the magic, 
	      //    after I get the buffer I need to display the buffer in the layout
	      // I love callbacks...
	      register_shutdown_function(array($this, "loadLayout"));
	   }
   
	   function getContent($buffer_content, $flag) {
	      $this->buffer = $buffer_content;
	      return '';
	   }
   
	   function loadLayout() {
            
	      // Do this here so we can set the content of these constants in our app since this
	      // class definition gets loaded and instantiated before our script begins to execute
	      $this->figureOutLayoutFilePath();
      
	      // turn off output buffering
	      // TODO: make this multiple-depth;
	      ob_end_clean();
      
	      if(!is_null($this->layout_file)) {
                  
	         $__layout = $this;
	// echo '<pre style="color: #fff;text-align: left;">';
	// print_r($this->layout_directory);
	// echo '<br>';
	// print_r($this->layout_file);
	// echo '</pre>';
	         include_once($this->layout_directory.$this->layout_file);
         
	      } else {
	         // If there is no layout just echo out the buffer
	         echo $this->buffer;
	      }
	   }
   
	   function figureOutLayoutFilePath(){
	      $this->layout_directory = Defined::orUse('LAYOUT_DIRECTORY', ROOT . URL_ROOT . 'layouts/');
	      $this->layout_file = Defined::orUse('LAYOUT', null);
	      if(!is_null($this->layout_file)) {
	         // Add .php to the layout if not already there...
	         if(substr(strtolower(trim($this->layout_file)),-4) != '.php')  $this->layout_file.='.php';
	      }
	   }
   
	   // This is what the layout calls when it wants the contents of the buffer
	   function yield($return = false) {
	      if($return !== true)    echo   $this->buffer;
	      else                    return $this->buffer;
	   }
   
	}


// function write_log($string) {
//    global $__log_lines;
//    $__log_lines++;
//    
//    $logger = fopen(ROOT . "logs/test.txt", "a+");
//       fwrite($logger, "\n" . $__log_lines . ".\t" . $string);
//    fclose($logger);
// }


?>