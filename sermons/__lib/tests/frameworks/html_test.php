<?php
require_once('../../../config/init.php');

require_once(TEST_SUITE_FRAMEWORK);
require_once(HTML_FRAMEWORK);

class HTMLTest extends UnitTest {
   function test_html_basic(){
      $this->assert_equal('<p>Test</p>', HTMLBase::tag('p','Test'));
      $this->assert_equal('<p class="test">Test</p>', HTMLBase::tag('p','Test', array('class' => 'test')));
      $this->assert_equal('<br />', HTMLBase::tag('br'));
   }
   
   function test_meta(){
      $this->assert_equal('<meta name="MSSmartTagsPreventParsing" content="true" />', 
                           HTMLMeta::simple(array("name" => "MSSmartTagsPreventParsing",
                                              "content" => "true")));
   }
   
   function test_css_link(){
      $this->assert_equal('<link href="test.css" type="text/css" media="all" rel="stylesheet" />', 
                           HTMLMeta::css('test'));
   }
   
   function test_mulitple_css_files() {
      $this->assert_equal('<link href="test.css" type="text/css" media="all" rel="stylesheet" /><link href="test2.css" type="text/css" media="all" rel="stylesheet" />', 
                           HTMLMeta::css(array('test', 'test2')));
   }
}
