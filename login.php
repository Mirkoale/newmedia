<?php
ob_start();
require_once('./controller/db_connect.php');

use crudframework\Db_control;

if (isset($_POST['email'], $_POST['password'])) {
   $password = $_POST['password'];
   $email = strtolower($_POST['email']);
   $dbc = new Db_control();
   $control = $dbc->password_control($email, $password);
  //var_dump($control);
   if ($control) {
      $row = $dbc->find_name($email); 

      if ( isset($row[0]['username'], $row[0]['role']) && !empty($row[0]['username']) && !empty($row[0]['role'])) {

         session_start();
         $_SESSION['role'] = $row[0]['role'];
         $_SESSION['email'] = $email;
         $_SESSION['username'] = $row[0]['username'];
         header('Location: ./player');
         
      } else {
         header('Location: ./index.html');
         die();
      }
   }else {
      header('Location: ./index.html');
   }
} else {
   header('Location: ./index.html');
}
