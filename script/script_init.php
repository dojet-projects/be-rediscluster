<?php
define('PRJ', realpath(dirname(__FILE__).'/../').'/');
include(PRJ.'../be-dojet/dojet.php');
include(PRJ.'MainCliService.class.php');

startCliService(new MainCliService());
