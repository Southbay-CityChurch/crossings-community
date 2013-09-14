<?php 

/**
 * Active Record Pattern for php,
 * I feel like I am reinventing the wheel here.
 * anyway this will be the basis for all the models that are going
 * to interact with the database.
 *
 * The basic Active Record pattern wraps each row in the DB as an object
 * allows for easy finding, C(reate), R(ead), U(pdate), D(estroy) (thats CRUD)
 * 
 * We'll manage collections of rows later
 */

LoadUtility::loadMyDirectory(__FILE__);

?>