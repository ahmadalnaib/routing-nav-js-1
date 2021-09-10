<?php
$uploadDir = "uploads";
require_once __DIR__ . "/../config/db.php";

function filterString($field)
{
  $field = filter_var(trim($field), FILTER_SANITIZE_STRING);
  if (empty($field)) {
    return false;
  } else {
    return $field;
  }
}

function filterEmail($field)
{
  $field = filter_var(trim($field), FILTER_SANITIZE_EMAIL);

  if (filter_var($field, FILTER_VALIDATE_EMAIL)) {

    return $field;
  } else {
    return false;
  }
}


function canUpload($file)
{
  $allowedFiles = [
    'jpg' => 'image/jpeg',
    'png' => 'image/png',
    'gif' => 'image/gif'
  ];

  $MaxFileSize = 10 * 1024 * 1024;

  $fileType = mime_content_type($file['tmp_name']);
  $fileSize = $file['size'];

  if (!in_array($fileType, $allowedFiles)) {
    return 'file type not support 🧐';
  }
  if ($fileSize > $MaxFileSize) {
    return "file size is big 🤯 Max size is" . $MaxFileSize;
  }
  return true;
}


/* errors message */
$nameErr = $EmailErr = $fileErr = $messageErr = '';
$name = $email = $message = $services = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $name = filterString($_POST['name']);
  if (!$name) {
    $nameErr = "name is required";
  }

  $email = filterEmail($_POST['email']);
  if (!$email) {
    $EmailErr = "email is invalid";
  }

  $message = filterString($_POST['message']);
  if (!$message) {
    $messageErr = "message is required";
  }

  $services = filterString($_POST['services']);






  // file upload

  if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {

    $uploadFile = canUpload($_FILES['file']);

    if ($uploadFile === true) {
      // $uploadDir = "uploads";

      if (!is_dir($uploadDir)) {
        umask(0);
        mkdir($uploadDir, 0775);
      }
      $fileName = time() . $_FILES['file']['name'];
      move_uploaded_file($_FILES['file']['tmp_name'], $uploadDir . '/' . $fileName);
    } else {
      $fileErr = $uploadFile;
    }
  }

  if (!$nameErr && !$EmailErr && !$messageErr && !$fileErr) {
    $fileName ? $filePath = $uploadDir . '/' . $fileName : $filePath = '';

    $insertMessage = "INSERT INTO messages (name,email,file,message,service_id)" .
      "VALUES ('$name','$email','$fileName','$message','$services')";
    $mysqli->query($insertMessage);

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html; charset=UTF-8" . "\r\n";

    $headers .= "From: " . $email . "\r\n";
    'Reply-To:' . $email . "\r\n";
    'X-Mailer: PHP/' . phpversion();

    $htmlMessage = '<html><body>';
    $htmlMessage .= '<p style="color:#ff0000;">' . $message . '</p>';
    $htmlMessage .= '</body></html>';

    if (mail($config['admin_email'], 'You have new msg', $htmlMessage, $headers)) {

      session_destroy();
      header('Location:contact.php');
    } else {
      echo "the email not sent check your internet";
    }
  }
}
