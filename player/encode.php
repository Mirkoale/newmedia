<?php
ob_start();

$directory = './audio';
$contenuto = scandir($directory);

function get_json_from_dir($dir, $content)
{
   $a = array();
   $i = 0;
   foreach ($content as $item) {
      if ($item == '.' || $item == '..')
         continue;
      $item_path = $dir . '/' . $item;
      $item = str_replace(array('.mp3'), '', $item);
      $a[$i]['name'] = $item;
      $a[$i]['dir'] = $item_path;
      $i++;
   }
   return $a;
}

$to_json = get_json_from_dir($directory, $contenuto);
//var_dump($to_json);

$media_encoded = json_encode($to_json, JSON_UNESCAPED_SLASHES);
$media = './mediaread/mediaencoded.json'; //indica sempre il percorso !!!

$file = fopen($media, 'w');

if (fwrite($file, $media_encoded) !== false) {
   echo 'PRINTED!';
   header('location: ./?update=true');
} else {
   echo 'Error';
}
fclose($file);


