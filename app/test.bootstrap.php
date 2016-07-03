<?php

$console = function ($command) {
    passthru('php "' . __DIR__ . '/console" ' . $command);
};

$console('doctrine:schema:drop --force -e test -n');
$console('doctrine:schema:create -n -e test');

require __DIR__ . '/autoload.php';
