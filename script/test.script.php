<?php
include __DIR__.'/script_init.php';

require_once GLUTIL.'redis/require.inc.php';

$i = 0;
/*
$address = '10.211.55.7';
/*/
$address = '10.103.116.193';
//*/
$redis = DRedisIns::redis(['address' => $address, 'port' => 6380]);
$cluster = Cluster::fromRedis($redis);

while (true) {
    $key = "test:".time().crc32(serialize([microtime(), $i]));
    $cluster->set($key, $i);
    $i++;
    $i %= 10000000;
}
