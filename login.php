<?php

require_once('./controller/db_connect.php');

use crudframework\Db_control;

if (isset($_POST['email'], $_POST['password'])) {
   $password = $_POST['password'];
   $email = $_POST['email'];
   $dbc = new Db_control();
   $control = $dbc->password_control($email, $password);
   var_dump($control);
   if ($control) {
      $row = $dbc->find_name($email);

      if (isset($row[0]['name'], $row[0]['role']) && !empty($row[0]['name']) && !empty($row[0]['role'])) {

         session_start();
         $_SESSION['role'] = $row[0]['role'];
         $_SESSION['email'] = $email;
         $_SESSION['name'] = $row[0]['name'];
         header('Location: ./media.php');
         var_dump($_SESSION);
      } else {
         header('Location: ./index.html');
         die();
      }
   }
} else {
   header('Location: ./index.html');
}
