<?php

require 'vendor/autoload.php';
require 'Convertor.php';

$args = array();
for ($i = 1; $i < count($argv); $i++) {
    if (preg_match('/^--([^=]+)=(.*)/', $argv[$i], $match)) {
        $args[$match[1]] = $match[2];
    }
}

if (is_null($args['to'])) {
    print_r('Incorrect arguments. Please, provide currency iso as argument --to=[iso].');
    return null;
}
if (!isset($args['from'])) {
    $args['from'] = null;
}

$convertor = new Convertor();
$result = $convertor->convert($args['from'], $args['to']);

print_r($result);
return $result;