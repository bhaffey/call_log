<?php

if ($_SERVER['SERVER_NAME'] == 'localhost' || '127.0.0.1') {

    $GLOBALS['config'] = array(
        'oci' => array(
            'username' => '',
            'password' => '',
            'db' => ''),
        'mysql' => array(
             'host' => '',
             'username' => '',
             'password' => '',
             'db' => '')
        );
    
} else {
    putenv("TNS_ADMIN=/etc");

    $GLOBALS['config'] = array(
        'oci' => array(
            'username' => '',
            'password' => '',
            'db' => ''),
        'mysql' => array(
             'host' => '',
             'username' => '',
             'password' => '',
             'db' => '')
        );
}

require_once (ROOT . "/Classes/Changepass.php");
require_once (ROOT . "/Classes/Config.php");
require_once (ROOT . "/Classes/DB.php");
require_once (ROOT . "/Classes/Login.php");
require_once (ROOT . "/Classes/Registration.php");

require_once (ROOT . "/includes/sanitize.php");
