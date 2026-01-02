<?php

$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$segments = $path === '' ? [] : explode('/', $path);
$route = $segments[0] ?? '';

switch ($route) {

    case '':
        require '2020.html';
        break;

    case 'youtubei':
         require 'innertube.php';
         break;
    default:
         http_response_code(404);
         break;
}