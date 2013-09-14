<?php

register_shutdown_function('__auto_run_unit_tests');


class UnitTest {
    var $assertion_count = 0;
    var $failure_count = 0;
    var $test_count = 0;
    var $show_passes = false;
    var $message_queue = '';
    
    function runTests() {$this->runUnitTests();}
    function runUnitTests() {
       
       echo "<h1> Running Unit Testing</h1>";
       
       // Run the initial setup method
       $this->initial_setup();
       
       $this->announce_if_limited_testing();
       
       
        foreach (get_class_methods($this) as $method_name) {
            if (strpos(' ' . strtolower($method_name), 'test_') >= 1 && 
               $this->can_test($method_name)) {
               
               $this->test_count++;
               $pre_failure_count = $this->failure_count;
               $this->message_queue = '';

               $eval_string = ('$this->' . $method_name . '();');               
               
               // sometime down the road it'd be nice to impliment this
               //set_error_handler ( 'handle_errors')
               
               // Run the initial setup method
                  $this->setup();
                  eval($eval_string);
                  
                  
               //restore_error_handler();
               
               
               echo "\n".'<hr />';
               echo "\n Testing: <strong>$method_name" . '</strong><br />' . "\n";
               // if ($this->failure_count > pre_failure_count || $this->show_passes){
                  echo $this->message_queue;
               // }
               if($this->show_passes && $this->failure_count == pre_failure_count) echo ' ...Passed';
               
            }
        }
        $this->summary();
    }
    
    
    function showPasses($bool=true) {
       $this->show_passes = $bool;
       echo '<p>Showing all tests...</p>';
    }
   
   
   
    function assert($thing, $message = null){
        $this->assrt();
        if($thing !== true) 
            $this->failure( $this->orEqual($message, "Expecting " . var_export($thing) . " to be true, but it was false"));     
    }
    
    function assert_not_equal($not_expected, $actual, $message = null){
        $this->assrt();
        if($expected === $actual) 
            $this->failure( $this->orEqual($message, "Expected anything except $not_expected, but got $actual."));
    }
    
    function assert_not_equal2($not_expected, $actual, $message = null){
        $this->assrt();
        if($expected == $actual) 
            $this->failure( $this->orEqual($message, "Expected anything except $not_expected, but got $actual."));
    }
    
    function assert_equal($expected, $actual, $message = null){
        $this->assrt();
        if($expected != $actual) 
            $this->failure( $this->orEqual($message, "Expected \"$expected\", but got \"$actual\"."));
    }
    
    function assert_strict_equal($expected, $actual, $message = null){
        $this->assrt();
        if($expected !== $actual) 
            $this->failure( $this->orEqual($message, "Strictly expected \"$expected\", but got \"$actual\"."));
    }
    
    function assert_class_type ($expected_class, $object, $message = null){
        $this->assrt();
        if(!is_a($object,$expected_class)) 
            $this->failure( $this->orEqual($message, "Expected class $expected_class, but got a " . get_class($object) . "."));
    }


    function assert_parent_class ($expected_parent_class, $object, $message = null){
        if (is_object($expected_parent_class)) 
            $expected_parent_class = get_class($expected_parent_class);
        $this->assrt();
        if(!is_subclass_of($object,$expected_parent_class)) 
            $this->failure( $this->orEqual($message, "Expected parent class \"$expected_parent_class\", but got a " . get_parent_class($object) . "."));
    }
    
    
    function assert_type ($expected_type, $actual, $message = null){
        $this->assrt();
        $result = true;
        
        $expected_type = str_replace('integer', 'int', $expected_type);
        $eval_string = '$result = is_' . strtolower($expected_type) . '($actual);';
        eval($eval_string);
        
        if(!$result) 
             $this->failure( $this->orEqual($message, "Expected type $expected_type but got type " . get_class($actual) . "."));
    }
    
    function assert_includes($expected_string, $actual, $message = null){
       $this->assrt();
       
       switch (gettype($actual)) {
          
          case 'float':
          case 'integer':
          case 'double':
          case 'boolean':
          case 'string': $actual_string = $actual; break;
          
          case 'array' : $actual_string = implode($actual, ' '); break;
          
          default: $actual_string = var_export($actual, true);
       }
       
       if(strpos(' ' . $actual_string, $expected_string) <= 0 )
         $this->failure( $this->orEqual($message, "Expected to find \"$expected_string\" in \"$actual_string\", but its not there."));
       
    }
    
    /** 
     * This is a tiny little method that will assign the variable
     * $thing to $new_thing if $thing is either null or blank
     * I miss ruby's ||=
     */
    function orEqual($thing, $new_thing) {
       if (is_null($thing) || trim($thing)=='')
         $thing = $new_thing;
       return $thing;
    }
    
    // used for some callbacks
    function setup() {}
    function initial_setup() {}
    
    // private
    
    function can_test($method_name){
      // allow all!  so by default it tests everything
      $can_test = true;
      
      // also look for method names without test so we don't need to
      // keep writing test_THE_THING_TO_TEST
      
      $method_name_alt = substr($method_name,5);
      
      switch ( true )
      {
         case is_string($this->test_only):   $this->test_only = array($this->test_only); // no break   
         case is_array($this->test_only):    
            $can_test = (in_array($method_name, $this->test_only) || (in_array($method_name_alt, $this->test_only)));
            break;
         
         case is_string($this->test_all_except): $this->test_all_except = array($this->test_all_except);
         case is_array ($this->test_all_except): 
            $can_test = (!in_array(method_name, $this->test_all_except) && !in_array($method_name_alt, $this->test_all_except));
            break;
            
         
         case (!isset($this->test_all_except) && !isset($this->test_only));
            $can_test = true; break;
            
         default: $can_test =  true; break;
      }
      return $can_test;
    }
    
    function announce_if_limited_testing() {
       $this->can_test('test_dummy_method_name');
            
      if (isset($this->test_only) || isset($this->test_all_except))     echo "\n <h1> TESTING IS LIMITED </h1> ";
      
      if (isset($this->test_only))        echo "\n <p>Testing Only: ". implode($this->test_only, ', ') .'</p>';
      if (isset($this->test_all_except))  echo "\n <p>Testing All Except: ". implode($this->test_all_except, ', ').'</p>';
    }
    
    function assrt(){
       $this->assert_count++;
       $this->message_queue.='.';
    }
    
    
    function summary(){
       echo "\n<hr />";
       echo "\n<h2>Summary</h2>";
       echo "\n<p> $this->test_count Tests, $this->assert_count Assertions, $this->failure_count Failures, ? Errors";
    }



    function failure($message) {
       $backwards = debug_backtrace();
       $line_number = $backwards[1]['line'];
       
       $this->message_queue.= "\n".'<p>FAILED:: ' . $message . ' (at line ' . $line_number . ')</p>';
       $this->failure_count++;       
    }
    

}

function __auto_run_unit_tests(){
   foreach( get_declared_classes() as $klass ){
      $parent_class = get_parent_class($klass);
      if (!empty($parent_class)) {
         //echo "\n" . $klass . ' ' . $parent_class;
         if (strtolower($parent_class) == 'unittest') {
            $eval_this =  '$object_to_run_test_on = new '. $klass. '(); ';
            $eval_this.= ' $object_to_run_test_on->runUnitTests();';
            //echo "\n evaling: ".$eval_this;
            eval($eval_this);
         }
      }  
   }
}

?>