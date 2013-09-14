<?php
require_once('../../../config/init.php');

require_once(TEST_SUITE_FRAMEWORK);
require_once(CART_MODEL);
require_once(CART_ITEM_MODEL);

//LoadUtility::whatIsLoaded();

class Product {
    var $id;
    var $price;
    
    
    function product($id, $price) {
        $this->id = $id;
        $this->price = $price;
    }

    function id() { return $this->id; }
    function price() { return $this->price; }
}



/* Example unit test */
class CartTest extends UnitTest {
    function test_cart_instan() {
        $cart = new Cart();
        // if (is_a($cart,'Cart')) echo __FUNCTION__.' passed.' . "<br />\n";
        $this->assert_type('object',$cart);
        $this->assert_class_type('Cart',$cart);
    }
    
    function test_new_product() {
        $prod = new Product(2, 12.99);
        $cart = new Cart();
        
        $cart->addProduct($prod);
        $cart->addProduct($prod);
        $cart->addProduct($prod);

        $this->assert_equal((12.99 * 3), $cart->totalItemsPrice());
        $this->assert_equal(1, $cart->uniqueProductCount());
    }
    
    function test_no_parts_added(){
      $cart = new Cart();
      $this->assert_equal(0, $cart->totalItemsPrice());
      $this->assert_equal(0, $cart->uniqueProductCount());
    }
    
    // A function used to set up a unit test condition
    // this is nice because it reduces repeated code in ... your code? :)
    function setup() {
        $c = new Cart();
        $p = new Product(4, 25.99);
        $c->addProduct($p);
        return $c;
    }
}


?>