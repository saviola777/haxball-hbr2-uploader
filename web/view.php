<?php

define("BASE_URL", "https://hax.saviola.de/r/");

if (!isset($_GET['h'])) {
  header('Location: ./index.php');
}

$uploadDir = './files/';

$download = false;
$hash = $_GET['h'];

if (strlen($hash) == 37) {
  $hash = substr($hash, 0, 32);
  $download = true;
}
else if (strlen($hash) != 32) {
  die('Invalid replay hash');
}

$uploadDir .= substr($hash, 0, 2);

if ($download) {
  header('Access-Control-Allow-Origin: *');
  header('Content-type: application/octet-stream');
  header('Content-Disposition: attachment; filename="' . $hash . '.hbr2"');
  readfile($uploadDir . '/' . $hash . '.hbr2');
} else {
  $downloadUrl = BASE_URL . '?h=' . $hash . '.hbr2';
  $replayerUrl = 'https://www.haxball.com/replay?v=3#' . $downloadUrl;

  header('Location: ' . $replayerUrl);
}

