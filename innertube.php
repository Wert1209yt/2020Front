<?php
require('get.php');
$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

function getResponse($path) {
header('Content-Type: application/json');
$endpoint = 'https://youtube.com/' . $path;
$context = json_decode(file_get_contents('php://input'));
$context['context']['client']['clientVersion'] = '2.20250101.00.00';
$payload = json_encode($context);
echo innertubeRequest($endpoint, $payload);
}

getResponse($path);
?>
