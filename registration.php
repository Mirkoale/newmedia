<?php
ob_start();
require_once('./controller/db_connect.php');

use crudframework\Db_control;

## controlli registrazione in index ##
$error_unsername = '';
$error_email = '';

if (isset($_POST['username'], $_POST['password'], $_POST['email'])) {

   $username = $_POST['username'];   
   $email = strtolower($_POST['email']);
   $dbc = new Db_control();
   $row_count = $dbc->email_control($email);

   if ($row_count) {
?>
      <div class="error">
         <h2>email già esistente</h2>
      </div>
<?php
   }else{
   $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
   if($dbc->push_user($username, $email, $password)){
      header('Location: ./index.html');
   }   
   }
} else {
   header('Location: ./index.html');
}
