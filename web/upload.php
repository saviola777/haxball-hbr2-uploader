<?php

$uploadDir = './files/';

$response = array(
  'status' => 0,
  'message' => 'File upload failed, please try again.',
);

function sendResponse() {
  global $response;
  echo json_encode($response);
  exit(0);
}

try {
    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    if (!isset($_FILES['file']['error']) ||
        is_array($_FILES['file']['error'])) {

        throw new RuntimeException('Invalid parameters.');
    }

    // Check $_FILES['file']['error'] value.
    switch ($_FILES['file']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }

    // You should also check filesize here.
    if ($_FILES['file']['size'] > 300000) {
        throw new RuntimeException('Exceeded filesize limit.');
    }

    // File path config
    $fileName = basename($_FILES['file']['name']);
    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

    // Allow certain file formats
    $allowedTypes = array('hbr2');

    // DO NOT TRUST $_FILES['file']['mime'] VALUE !!
    // Check MIME Type by yourself.
    if(!in_array($fileType, $allowedTypes)){
        throw new RuntimeException('Invalid file type.');
    }

    // You should name it uniquely.
    // DO NOT USE $_FILES['file']['name'] WITHOUT ANY VALIDATION !!
    // On this example, obtain safe unique name from its binary data.
    $hash = md5_file($_FILES['file']['tmp_name']);
    $targetSubdirectory = substr($hash, 0, 2);
    $targetDirectory = $uploadDir . $targetSubdirectory;
    if (!is_dir($targetDirectory) && !@mkdir($targetDirectory, 0755)) {
      throw new RuntimeException('Failed to create upload directory, please contact maintainer');
    }
    if (!move_uploaded_file(
        $_FILES['file']['tmp_name'],
        sprintf($targetDirectory . '/%s.%s',
            $hash,
            $fileType
        )
    )) {
        throw new RuntimeException('Failed to move uploaded file.');
    }

    $response['message'] = 'https://hax.saviola.de/r/?h=' . $hash;
    $response['status'] = 1;

    sendResponse();
} catch (RuntimeException $e) {
  $response['message'] = $e->getMessage();
  sendResponse();
}


?>
