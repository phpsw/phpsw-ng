<?php

/**
 * Bootstraps environment.
 */
use Doctrine\Common\Annotations\AnnotationRegistry;

$loader = include __DIR__.'/../../vendor/autoload.php';

// Required for annotation parsing
AnnotationRegistry::registerLoader([$loader, 'loadClass']);


