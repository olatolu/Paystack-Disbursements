<?php

/*
 * Configuring environmental variable
 *
 * NUBAN, PERPAGE, CURRENCY, AUTH, HOST INCLUDE PATH
 *
 * @INCLUDE PATH, The line commented is for the local environment
 *
 * Heroku line is active
 *
 */

define('TYPE','nuban');

define('PERPAGE',10);

define('CURRENCY','NGN');

define('AUTH','Authorization: Bearer sk_test_3323644da3a719b70c0e54e7da4b877e9e644d9b');

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

/*--------------------------------------------------------------*/
/* For local environment XAMPP
 *
 */

define('SITE_ROOT', DS . 'Applications' . DS . 'XAMPP' . DS . 'xamppfiles' . DS . 'htdocs' . DS . 'Paystack-Disbursements');

/*--------------------------------------------------------------*/
/* For Heroku Environment
 *
 */

//define('SITE_ROOT', DS . 'app');

defined('INCLUDES_PATH') ? null : define('INCLUDES_PATH', SITE_ROOT . DS . 'admin'.DS.'includes');

/*--------------------------------------------------------------*/
/* Require/load all the necessary classes
 *
 */

require_once(INCLUDES_PATH. DS ."functions.php");
require_once(INCLUDES_PATH. DS ."supplier.php");
require_once(INCLUDES_PATH. DS ."transfer.php");
require_once(INCLUDES_PATH. DS ."session.php");

?>

