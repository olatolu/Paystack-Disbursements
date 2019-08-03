<?php

define('TYPE','nuban');

define('PERPAGE',10);

define('CURRENCY','NGN');

define('AUTH','Authorization: Bearer sk_test_3323644da3a719b70c0e54e7da4b877e9e644d9b');

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

define('SITE_ROOT', DS . 'Applications' . DS . 'XAMPP' . DS . 'xamppfiles' . DS . 'htdocs' . DS . 'Paystack-Disbursements');

defined('INCLUDES_PATH') ? null : define('INCLUDES_PATH', SITE_ROOT . DS . 'admin'.DS.'includes');

require_once(INCLUDES_PATH. DS ."functions.php");
require_once(INCLUDES_PATH. DS ."supplier.php");
require_once(INCLUDES_PATH. DS ."transfer.php");
require_once(INCLUDES_PATH. DS ."session.php");



 ?>

