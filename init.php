<?php
use Mod\SimpleUser\ModuleSimpleUser;

require dirname(__FILE__).'/../be-dojet/dojet.php';
require dirname(__FILE__).'/../be-global/init.php';

define('UI', PRJ.'ui/');
define('CONFIG', PRJ.'config/');
define('MODEL', PRJ.'model/');
define('UTIL', PRJ.'util/');
define('TEMPLATE', PRJ.'template/');

Config::loadConfig(CONFIG.'const');
Config::loadConfig(CONFIG.'runtime');
Config::loadConfig(CONFIG.'global');
Config::loadConfig(CONFIG.'database/database');
Config::loadConfig(CONFIG.'redis/redis');

DAutoloader::getInstance()->addAutoloadPathArray(
    array(
        dirname(__FILE__).'/dal/',
        dirname(__FILE__).'/lib/',
        MODEL,
    )
);

Config::loadConfig(CONFIG.'route');

$rc = Config::runtimeConfigForKeyPath('redis.server');
DRedis::init(array(
    'host' => $rc['hosts'][0],
    'port' => $rc['port'],
    'password' => $rc['password'],
    'timeout' => $rc['timeout'],
    'key_prefix' => 'lp:',
    )
);
