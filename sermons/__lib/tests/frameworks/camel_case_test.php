<?php
require_once('../../../config/init.php');

require_once(TEST_SUITE_FRAMEWORK);
require_once(STRING_FRAMEWORK);

class StringTest extends UnitTest {
   function test_camelizer(){
      $this->assert_equal('ChangeToThis', CamelCase::camelize('change_to_this'));
      $this->assert_equal('changeToThis', CamelCase::camelize('change_to_this', false));
      
   }
   
   function test_decamelizer(){
      $this->assert_equal('change_to_this', CamelCase::decamelize('ChangeToThis'));
      $this->assert_equal('excellent_usage', CamelCase::decamelize('ExcellentUsage'));
      $this->assert_equal('nope', CamelCase::decamelize('Nope'));
   }
   
   function test_camelcase_finder(){
      $this->assert(CamelCase::isCamelized('ChangeToThis'));
      $this->assert(CamelCase::isCamelized('thisIsCamelCase'));
      $this->assert(CamelCase::isCamelized('ThisIsAlsoCamelCase'));
      
      $this->assert(!CamelCase::isCamelized('change_to_this'));
      $this->assert(!CamelCase::isCamelized('change to_this'));
      $this->assert(!CamelCase::isCamelized('not_Camel_case'));
      
   }
}
