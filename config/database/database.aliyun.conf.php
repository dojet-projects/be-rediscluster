<?php
define('DBLEAPCODE',    'DBLEAPCODE');

$__c = &Config::configRefForKeyPath('database');

$db_pass = file_get_contents('/var/db_pass');
$db_pass = trim($db_pass);

$__c[C_RUNTIME_ALIYUN] = array(
    DBLEAPCODE => array(
        'r' => array(
            'hosts' => array(
                array('h' => '127.0.0.1', 'p' => 3306),
                ),
            'username' => 'root',
            'password' => $db_pass,
            'dbname' => 'leap',
            'charset' => 'utf8',
            'timeout' => 1, //sec
        ),
        'w' => array(
            'hosts' => array(
                array('h' => '127.0.0.1', 'p' => 3306),
                ),
            'username' => 'root',
            'password' => $db_pass,
            'dbname' => 'leap',
            'charset' => 'utf8',
            'timeout' => 1, //sec
        ),
    ),
);

unset($__c);
