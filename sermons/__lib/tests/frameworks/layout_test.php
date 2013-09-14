<?php

require_once('../../../config/init.php');

require_once(TEST_SUITE_FRAMEWORK);
require_once(LAYOUT_FRAMEWORK);

define('LAYOUT',    'site');


// print_r (ob_get_status());
// echo 'ob length: '. ob_get_length();
// ob_start();
echo '<h1>Cool!</h1>';

// print_r (ob_get_status());
// echo 'ob length: '. ob_get_length();
?>