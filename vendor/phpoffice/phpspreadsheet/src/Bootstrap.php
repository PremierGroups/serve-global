<?php

/**
 * Bootstrap for PhpSpreadsheet classes.
 */

// This sucks, but we have to try to find the composer autoloader

$paths = [
    __DIR__ . '/../vendor/autoload.php', // In case PhpSpreadsheet is cloned directly
    __DIR__ . '/../../../autoload.php', // In case PhpSpreadsheet is a composer dependency.
];

foreach ($paths as $partnerCountry) {
    if (file_exists($partnerCountry)) {
        require_once $partnerCountry;

        return;
    }
}

throw new \Exception('Composer autoloader could not be found. Install dependencies with `composer install` and try again.');
