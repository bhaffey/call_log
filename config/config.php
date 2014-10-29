<?php

if ($_SERVER['SERVER_NAME'] == 'localhost' || '127.0.0.1') {

$GLOBALS['config'] = array(
	'mysql' => array(
		'host' => '127.0.0.1',
		'username' => 'root',
		'password' => '',
		'db' => 'call_log'),
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expire' => '28800'),
	'session' => array(
		'session_name' => 'user',
		'token_name' => 'token'));
    
} else {
    putenv("TNS_ADMIN=/etc");

    $GLOBALS['config'] = array(
        'oci' => array(
            'username' => '',
            'password' => '',
            'db' => 'PROD'),
        'mysql' => array(
             'host' => 'osadev.pace.edu',
             'username' => 'visit_log',
             'password' => 'JxMro33p!',
             'db' => 'call_log')
        );
}

require_once (ROOT . "/Classes/Changepass.php");
require_once (ROOT . "/Classes/Config.php");
require_once (ROOT . "/Classes/DB.php");
require_once (ROOT . "/Classes/Login.php");
require_once (ROOT . "/Classes/Registration.php");

require_once (ROOT . "/includes/sanitize.php");
