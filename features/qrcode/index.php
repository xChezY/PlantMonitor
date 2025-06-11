<?php
require_once '../../vendor/autoload.php';
use Dotenv\Dotenv;
use chillerlan\QRCode\{QRCode, QROptions};
$dotenv = Dotenv::createImmutable(__DIR__ . "/../../");
$dotenv->load();
$baseUrl = $_ENV['BASE_URL'];
$data   = $baseUrl."features?plant=".$_GET["plant"];


$options = new QROptions;
$options->version      = 7;
$options->outputBase64 = false; // output raw image instead of base64 data URI

header('Content-type: image/svg+xml'); // the image type is SVG by default

echo (new QRCode($options))->render($data);