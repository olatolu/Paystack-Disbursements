<?php

/*--------------------------------------------------------------*/
/* Class Auto Load
 * Help load missing class file if exist
 */

function classAutoLoader($class)
{

    $class = strtolower($class);

    $path = INCLUDES_PATH . DS . "{$class}.php";

    if (is_file($path) && !class_exists($class)) {

        include $path;

    } else {

        die("The file name {$class}.php can not be found man..... Too Bad :)");
    }

}

spl_autoload_register('classAutoLoader');

/*--------------------------------------------------------------*/
/* App Redirect function
 *
 */

function redirect($location)
{

    header("Location: {$location}");
}

/*--------------------------------------------------------------*/
/* All Nigeria Bank List Function
 *
 */

function banks()
{

    // Get cURL resource
    $curl = curl_init();
    // Set some options
    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'https://api.paystack.co/bank',
    ]);

    // Send the request & save response to $resp
    $resp = curl_exec($curl);
    // Close request to clear up some resources
    curl_close($curl);

    $banks = json_decode($resp);

    return $banks->data;

}

/*--------------------------------------------------------------*/
/* Pagination helper
 *
 */

function pagination($total)
{

    if (PERPAGE % $total == 0) {

        return (int)$total / PERPAGE;

    } else {
        return (int)($total / PERPAGE) + 1;
    }
}


?>