<?php
session_start();
if (isset($_SESSION['usernamename'], $_SESSION['role'], $_SESSION['email'])) {
   ?>
   <div class="greetings">
      <p><?= $_SESSION['username']?></p>
      <p><?= $_SESSION['email']?></p>
      <p><?= $_SESSION['role']?></p>
   </div>
   <?php
}

