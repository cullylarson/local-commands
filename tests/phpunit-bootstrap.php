<?php

/*
 * Composer Autoloader
 */

call_user_func(function() {
    $autoloadPaths = array(
        __DIR__ . '/../../../autoload.php',  // composer dependency
        __DIR__ . '/../vendor/autoload.php', // stand-alone package
    );

    foreach($autoloadPaths as $path) {
        if(file_exists($path)) {
            require($path);
            break;
        }
    }

    // if we didn't find the autoloader, your autoloader is in a stupid place,
    // and you're on your own
});

/*
 * Config
 */

call_user_func(function() {
    $envParams = [
    ];

    foreach($envParams as $param) {
        defined($param) || define($param, getenv($param));
    }
});