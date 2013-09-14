<?php

// phpinfo();

require_once('../../../config/init.php');

require_once(TEST_SUITE_FRAMEWORK);
require_once(ACTIVE_RECORD_FRAMEWORK);


class product extends ActiveRecordBase {
	
	var $table= 'products';
	
	function product($id=null) {
		parent::ActiveRecordBase($id);
	}
	
}


class TestActiveRecord extends UnitTest {
      
   function setup(){
      $this->product = new Product();
   }
   
   function test_never_fail() {
      $this->assert(true);
   }
   
   function test_is_object() {
      $this->assert_type('object', $this->product);
      $this->assert_parent_class('ActiveRecordBase', $this->product);
   }
   
   
   function test_collecting_column_names() {
      // make sure name occurs in the table columns
      $this->assert_includes('name', $this->product->table_columns);
   }
   
   
   function test_save_and_load() {
      $value_to_assign = 'Brian';
      $this->product->name = $value_to_assign;
      $this->product->save();
      $id = $this->product->id();
      
      $p2 = new Product($id);
      $this->assert_equal($value_to_assign, $p2->name);
   }
   
   function test_rogue_attributes_are_not_saved() {
      $value_to_assign = 'Brian';
      
      $this->product->some_wrong_value = 'Don\'t try to write me';
      $this->product->name = $value_to_assign;
      $this->product->save();
      
   }
   
   function test_can_have_values_assigned() {
      $value_to_assign = 'Brian';
            
      $this->product->name = $value_to_assign;
      $this->assert_equal($value_to_assign, $this->product->name);
   }
   
   function test_save() {
      $this->product->name = 'Tommy';
      $this->product->save();
      $this->assert_not_equal(null, $this->product->id());
   }
   
   function test_update() {
      $new_value = md5(date('r') . rand(0,10000));
      
      $p = new Product();
      $p->load(1);
      $p->name=$new_value;
      // print_r($p);
      $p->save();
      
      $p2 = new Product(1);
      $this->assert_equal($new_value, $p2->name);
   }
   
   function test_type_casting() {
      
      $p = new Product();
      $p->product_id='Brian';
      $p->unit_price = '12.44';
      $p->save();
      
      $this->assert_not_equal('Brian', $p->product_id);
      $this->assert_equal('12.44', $p->unit_price);
      
   }
   
}


?>