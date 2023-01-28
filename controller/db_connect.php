<?php

namespace crudframework;

use PDO;
use PDOException;

include_once '../conf/conf.php';

class Db_control
{
   private $db = '';
   private $host;
   private $dbname;
   private $user;
   private $password;

   public function __construct()
   {
      $this->host = $this->conf('../conf/conf.json')['host'];
      $this->dbname = $this->conf('../conf/conf.json')['dbname'];
      $this->user = $this->conf('../conf/conf.json')['user'];
      $this->password = $this->conf('../conf/conf.json')['password'];
      //echo "host = " . $this->host . ", db =  " . $this->dbname . ", user = " . $this->user . " " . $this->password;
      $this->db = $this->connect('localhost', 'userdb', 'root', '') or die('non è possibile connettersi al db');
   }
   public function getconf()
   {
      $c = array(
         $this->host,
         $this->dbname,
         $this->user,
         $this->password,
      );
      return $c;
   }

   public function conf($config_file)
   {
      $get_conf = file_get_contents($config_file);
      $conf = json_decode($get_conf, true);
      return $conf;
   }


   private function connect($hostname, $dbname, $user, $pass)
   {
      try {
         $conn = new PDO("mysql:host=$hostname;dbname=$dbname;", $user, $pass);
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
      $sql = "SELECT username, role FROM `users` WHERE email = '{$email}'";
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

   ## CONTROLLO EMAIL ##
   private function email_validation($email)
   {
      return filter_var($email, FILTER_VALIDATE_EMAIL);
   }

   ## CONTROLLO USERNAME ##
   public function username_validation($username)
   {
      if (preg_match('/^[a-zA-Z][0-9a-zA-Z_]{2,23}[0-9a-zA-Z]$/', $username)) {
         return true;
      } else {
         return false;
      }
   }

   ##  CREA ID UNICO + CONTROLLOO  ##
   private function unique_id()
   {
      $uid = uniqid();
      $sql = "SELECT * FROM users WHERE uniqueid = '{$uid}'";
      $query = $this->db->prepare($sql);

      if ($query->execute()) {
         $count = $query->rowCount();
      } else {
         echo $query->errorInfo();
      }
      if ($count > 0) {
         $this->unique_id();
      }
      return $uid;
   }

   ##  PUSH NEL DB UTENTE REGISTRATO  ##
   public function push_user($username, $email, $password)
   {
      if ($this->email_validation($email)) {
         if ($this->username_validation($username)) {

            $uniqueid = $this->unique_id();
            $username_format = strtolower($username);

            $sql = "INSERT INTO users (username, email, password, uniqueid) VALUES (:username, :email, :password, :uniqueid)";

            $query = $this->db->prepare($sql);
            $query->bindParam(':username', $username_format, PDO::PARAM_STR);
            $query->bindParam(':password', $password, PDO::PARAM_STR);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':uniqueid', $uniqueid, PDO::PARAM_STR);

            if ($query->execute()) {
               return true;
            } else {
               var_dump($query->errorInfo());
               return false;
            }
         } else {
            echo '<p>username non valido, consentiti solo caratteri alfanumerici</p>';
            return false;
         }
      } else {
         echo '<p>email non valida</p>';
         return false;
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
