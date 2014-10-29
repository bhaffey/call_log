<?php
/*
# 
#
# @index.php  - launch page send to login or callog.php
#
#   Adapted from: "THE PHP LOGIN PROJECT"
#       @author Panique
#       @link https://github.com/panique/php-login-minimal/
#       @license http://opensource.org/licenses/MIT MIT License
 */

// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("libraries/password_compatibility_library.php");
}

if (!defined('ROOT')) {
    define('ROOT', __DIR__);
}

//include initial config for application
require_once ("config/config.php");

// create a login object. when this object is created, it will do all login/logout stuff automatically
$login = new Login();

// ... ask if we are logged in here:
if ($login->isUserLoggedIn()) {
    // the user is logged in.
    include("views/calllog.php");

} else {
    // the user is not logged in.
    include("views/login.php");
}