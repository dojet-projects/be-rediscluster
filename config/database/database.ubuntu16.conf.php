<?php
define('DBLEAPCODE',    'DBLEAPCODE');

$__c = &Config::configRefForKeyPath('database');

$__c[C_RUNTIME_UBUNTU16] = array(
    DBLEAPCODE => array(
        'r' => array(
            'hosts' => array(
                array('h' => '10.37.129.2', 'p' => 3306),
                ),
            'username' => 'root',
            'password' => 'root',
            'dbname' => 'leap',
            'charset' => 'utf8',
            'timeout' => 1, //sec
        ),
        'w' => array(
            'hosts' => array(
                array('h' => '10.37.129.2', 'p' => 3306),
                ),
            'username' => 'root',
            'password' => 'root',
            'dbname' => 'leap',
            'charset' => 'utf8',
            'timeout' => 1, //sec
        ),
    ),
);

unset($__c);
