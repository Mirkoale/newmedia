<?php

namespace crudframework;

use PDO;
use PDOException;

class Db_control
{
   private $db = '';
   public function __construct()
   {
      $this->db = $this->connect();
   }

   private function connect($hostname = 'localhost', $dbname = 'userdb', $user = 'root', $password = '')
   {
      try {
         $conn = new PDO("mysql:host=$hostname;dbname=$dbname;", $user, $password);
      } catch (PDOException $e) {
         echo 'Errore: ' . $e->getMessage();
         die();
      }
      return $conn;
   }

   ##  CONTROLLO EMAIL ESISTE  ##
   public function email_control($email)
   {
      $exist = false;
      $sql = "SELECT * FROM users WHERE email = '{$email}'";
      $query = $this->db->prepare($sql);

      if ($query->execute()) {
         $count = $query->rowCount();
      } else {
         echo $query->errorInfo();
      }
      $count > 0 ? $exist = true : $exist = false;
      return $exist;
   }

   ##  CONTROLLO PASSWORD ED EMAIL ESISTE  ##
   public function password_control($email, $password)
   {
      //$exist = false;
      $match = '';
      $sql = "SELECT password FROM users WHERE email = '{$email}'";
      $query = $this->db->prepare($sql);

      if ($query->execute()) {
         $cryptet_psw =  $query->fetchAll(PDO::FETCH_ASSOC);
         $verify = password_verify($password, $cryptet_psw[0]['password']);
      } else {
         echo $query->errorInfo();
      }
      return $verify;
   }


   ##  TROVA NOME UTENTE e RUOLO  ##
   public function find_name($email)
   {
      $sql = "SELECT name, role FROM `users` WHERE email = '{$email}'";
      $query = $this->db->prepare($sql);
      if ($query->execute()) {
         $result =  $query->fetchAll(PDO::FETCH_ASSOC);
      } else {
         echo $query->errorInfo();
      }
      return $result;
   }


   ##  READ ALL  ##
   public function readUsers()
   {
      $sql = "SELECT * FROM users";
      $query = $this->db->prepare($sql);
      if ($query->execute()) {

         $rows = $query->fetchAll(PDO::FETCH_ASSOC);
      } else {
         echo $query->errorInfo();
      }
      return $rows;
   }

   ##  READ BY ID  ##
   public function read_by_id($id)
   {
      $sql = "SELECT * FROM users WHERE id = $id";

      $query = $this->db->prepare($sql);

      if ($query->execute()) {

         $row = $query->fetch(PDO::FETCH_ASSOC);
         return $row;
      } else {
         echo $query->errorInfo();
         return false;
      }
   }

   ##  PUSH NEL DB UTENTE REGISTRATO  ##
   public function push_user($nome, $email, $password)
   {
      $sql = "INSERT INTO users (name, email, password) VALUES (:nome, :email, :password)";

      $query = $this->db->prepare($sql);
      $query->bindParam(':nome', $nome, PDO::PARAM_STR);
      $query->bindParam(':password', $password, PDO::PARAM_STR);
      $query->bindParam(':email', $email, PDO::PARAM_STR);

      if ($query->execute()) {
         return true;
      } else {
         var_dump($query->errorInfo());
      }
   }

   public function delete_by_id($id)
   {
      $sql = "DELETE FROM users WHERE id = $id";

      $query = $this->db->prepare($sql);

      if ($query->execute()) {

         header("location: display.php?deleted=true");
         return true;
      } else {
         echo $query->errorInfo();
         return false;
      }
   }

   public function modify($id, $nome, $cognome, $email)
   {
      $sql = "UPDATE users SET nome=:nome, cognome=:cognome, email=:email WHERE id=$id";

      $query = $this->db->prepare($sql);

      $query->bindParam(':nome', $nome, PDO::PARAM_STR);
      $query->bindParam(':cognome', $cognome, PDO::PARAM_STR);
      $query->bindParam(':email', $email, PDO::PARAM_STR);

      if ($query->execute()) {
         echo '<div class="warning">' . 'Utente aggiornato con successo!' . '</div>';
      } else {
         echo $query->errorInfo();
      }
   }
}
