<?php
define('PRJ', realpath(dirname(__FILE__).'/../').'/');
include(PRJ.'init.php');
include(PRJ.'MainWebService.class.php');

startWebService(MainWebService::service());
