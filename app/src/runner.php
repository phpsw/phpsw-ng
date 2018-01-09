#!/usr/bin/php
<?php

use Phpsw\Website\Container\Container;
use Symfony\Component\Console\Application;

include __DIR__.'/bootstrap.php';

$container = new Container($environment);

/** @var Application $application */
$application = $container->get('app.cli');
$application->run();
