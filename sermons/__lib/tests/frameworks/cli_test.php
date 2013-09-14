<?php
require_once('../../../config/init.php');

require_once(TEST_SUITE_FRAMEWORK);
require_once(CLI_FRAMEWORK);

class cliTest extends UnitTest {
   
   
   function initial_setup() {
      $this->test_only = 'diff_paths';
      // $this->test_all_except = 'deep_copy';
      
      
      $this->sandbox = dirname(__FILE__) . '/../' . 'test_sandbox/';
   }
   
   function test_cli_is_properly_loaded() {
      $this->assert_includes('generator', LoadUtility::whatIsLoaded());
   }
   
   function test_deep_copy() {
      $this->assert(is_dir($this->sandbox));
      $this->assert(is_dir(dirname(__FILE__).'/../models'));
      
      // Generator::deep_copy(dirname(__FILE__).'/../models', $this->sandbox);
      
      // $this->assert(is_dir($this->sandbox . '/models'));
   }
   
   function test_diff_paths(){
      
      $want_to_get_to = '/Users/banders/Sites/camel_cart/__lib/tests/frameworks/../test_sandbox/';
      $currently_at = '/Users/banders/Sites/camel_cart/__lib/tests/frameworks';
      
      $difference = Generator::diffPaths($currently_at, $want_to_get_to);
      
      $this->assert_equal('../test_sandbox/', $difference);
      
   }
   
}

