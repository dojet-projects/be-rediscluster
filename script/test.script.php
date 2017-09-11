<?php
$class = new ReflectionClass('Redis');
$methods = $class->getMethods();
print_r($methods);