<?php
define('PRJ', realpath(dirname(__FILE__).'/../').'/');
include_once(PRJ.'../be-dojet/dojet.php');
include_once(PRJ.'MainCliService.class.php');
include_once(PRJ.'init.php');

startCliService(new MainCliService());
