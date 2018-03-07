#!/usr/bin/env php
<?php

use Phpsw\Website\Container\Container;
use Symfony\Component\Console\Application;

include __DIR__.'/app/src/bootstrap.php';

$container = new Container('live');

/** @var Application $application */
$application = $container->get('app.cli');
$application->run();
