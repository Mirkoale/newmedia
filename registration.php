<?php
ob_start();
require_once('./controller/db_connect.php');

use crudframework\Db_control;

## controlli registrazione in index ##

if (isset($_POST['name'], $_POST['password'], $_POST['email'])) {

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
   $dbc->push_user($_POST['name'], $email, $password);
   header('Location: ./index.html');
   }
} else {
   header('Location: ./index.html');
}
