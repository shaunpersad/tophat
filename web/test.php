<?php
include '../includes/includes.php';

$cache = \TopHat\Core::getCache();

$stats = $cache->getStats();
if (!empty($stats)) {
    foreach ($stats as $key => $value) {
        echo "$key: $value <br />";
    }
}

$test = $cache->fetch('test');



if ($test) {

    echo 'test is in cache.  Its value is: '.$test;
} else {

    $cache->save('test', 'testing');

    echo 'test was not in the cache but it is now.';
}