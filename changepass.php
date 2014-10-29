<?php
/*
# Shane Kirk - OSA - Call Log ^2
#
# @changepass.php - allow for password changes
*/

// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {

    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");

} elseif (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once 'libraries/password_compatibility_library.php';
}

if (!defined('ROOT')) {
    define('ROOT', __DIR__);
}

//include initial config for application
require_once ("config/config.php");

if (!isset($_SESSION)) {
     session_start();
 }

// ... ask if we are logged in here:
if ($_SESSION['user_login_status']) {

    // create the changepass object. when this object is created, it will do all password stuff automatically
    $changepass = new Changepass();

    // show the changepass view (with the change password form, and messages/errors)
    include("views/cpass.php");

} else {
    // the user is not logged in.
    include("views/login.php");
}
