<?php
require_once('../../../config/init.php');

require_once(TEST_SUITE_FRAMEWORK);
require_once(STRING_FRAMEWORK);

class PluralsTest extends UnitTest {


   function test_simple(){
      $this->assert_equal('computers', Plurals::pluralize('computer'));
      
   }
   
   function test_ends_with(){
      $this->assert(Plurals::endsWith('computer', 'er'));
      $this->assert(Plurals::endsWith('monkey', 'ey'));
      $this->assert(!Plurals::endsWith('monkey', 'es'));
   }
   
   
   function test_replace_end(){
      $this->assert_equal('on brian andersizzle is cool', Replace::lastOccurance("on brian anderson is cool",'on','izzle'));
   }
   
   function test_advanced(){
      $this->assert_equal('monkeys', Plurals::pluralize('monkey'));
      $this->assert_equal('keys', Plurals::pluralize('key'));
      $this->assert_equal('people', Plurals::pluralize('person'));
      $this->assert_equal('businesses', Plurals::pluralize('business'));
      $this->assert_equal('boxes', Plurals::pluralize('box'));
      $this->assert_equal('oxen', Plurals::pluralize('ox'));

   }
   
   function test_singularization(){
      $this->assert_equal('boy', Plurals::singularize('boys'));
      $this->assert_equal('monkey', Plurals::singularize('monkeys'));
      $this->assert_equal('child', Plurals::singularize('children'));
      $this->assert_equal('business', Plurals::singularize('businesses'));
      $this->assert_equal('ox', Plurals::singularize('oxen'));
      $this->assert_equal('specie', Plurals::singularize('species'));
      
      
   }
   
   
}
