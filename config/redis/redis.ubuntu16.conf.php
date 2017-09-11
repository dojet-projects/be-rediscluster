<?php
$__c = &Config::configRefForKeyPath('redis');

//*
$__c['server'][C_RUNTIME_UBUNTU16] = array(
    'hosts' => array('127.0.0.1'),
    'port' => 6379,
    'password' => '',
    'timeout' => 1, //sec
);
//*/

$__c['keyprefix'] = 'lp:';

unset($__c);
