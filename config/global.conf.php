<?php
$__c = &Config::configRefForKeyPath('global');

$__c['log_path'] = [
    C_RUNTIME_UBUNTU16 => '/tmp',
    C_RUNTIME_ALIYUN => '/data/logs/leapcode.cn',
];

$__c['traceLevel'] = array(
    C_RUNTIME_UBUNTU16 => Trace::TRACE_ALL,
    C_RUNTIME_ALIYUN => Trace::TRACE_ALL,
);

$__c['conf'] = [
    C_RUNTIME_UBUNTU16 => '/var/php-rc/rc.json',
];

unset($__c);
