<?php
ob_start();

$uploadDir = '.\audio';
$files = rearrange($_FILES);

var_dump($files);

foreach ($files as $file) {
   if (UPLOAD_ERR_OK === $file['error']) {
      $fileName = basename($file['name']);
      move_uploaded_file($file['tmp_name'], $uploadDir . DIRECTORY_SEPARATOR . $fileName);
   }
}

function rearrange($files)
{
   foreach ($files as $key1 => $val1) {
      foreach ($val1 as $key2 => $val2) {
         for ($i = 0, $count = count($val2); $i < $count; $i++) {
            $newFiles[$i][$key2] = $val2[$i];
         }
      }
   }
   return $newFiles;
}

header('Location: ./index.php?upload=true ');

