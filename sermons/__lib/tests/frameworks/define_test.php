<?php

require_once('../../../config/init.php');

require_once(TEST_SUITE_FRAMEWORK);
// require_once(LAYOUT_FRAMEWORK);


class DefineTest extends UnitTest {
   
   function initial_setup(){
      define('ALREADY_DEFINED','i exist');
   }
   
   function test_no_problem() {
      $this->assert(Define::try('I_do_not_exist', 'but now I do'));
      $this->assert(defined('I_DO_NOT_EXIST'));
   }
   
   function test_already_defined() {
      $value = 'should not error or change';
      $this->assert(!Define::try('ALREADY_DEFINED', $value));
      $this->assert_not_equal(ALREADY_DEFINED, $value);
   }
   
   function test_defined_or_use() {
      $value = 'new';
      
      $this->assert_equal($value, Defined::orUse('BRIAN', $value));
      $this->assert_not_equal($value, Defined::orUse('ALREADY_DEFINED', $value));
   }
   
}


?>