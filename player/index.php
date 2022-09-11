<?php
session_start();
ob_start();
include_once './modules/header.php';
include_once './modules/cache.php';

if (isset($_SESSION['username'],$_SESSION['role'],$_SESSION['email'])) {
$username = $_SESSION['username']
?>
<body>

   <header>

      <div class="header">
         <h1>MY PLAYER 1.0 di <?= strtoupper($username) ?></h1>
      </div>

   </header>

   <section class="players">
      <div class="audiocontainer">
         <a href="./encode.php"><i class="fas fa-sync-alt " id="refresh" style="--fa-animation-duration: 15s;"></i></a>
         <h3>Audio</h3>
         <p>Seleziona un brano in elenco per ascoltare la musica</p>

         <div class="container">
            <div class="tracce" id="audioList"></div>
            <div class="lettore-audio">
               <section class="myplayer">
                  <audio id="audioDisplay" src=""></audio>
                  <div class="player">
                     <div class="control">
                        <i class="fas fa-play" id="playbtn"></i>
                     </div>
                     <div class="info">
                        <div id="musicTitle"></div>
                        <div class="volumebar"><i class="fas fa-volume" id="mute"></i><input type="range" min="0"
                              max="100" value="20" class="volume" id="volume">
                           <div id="previous"><i class="fas fa-backward"></i></div>
                           <div id="next"><i class="fas fa-forward"></i></div>
                        </div>

                        <div class="bar">
                           <div id="progress"></div>
                        </div>
                     </div>
                     <div id="tempo">0:00</div>

                  </div>
               </section>
               <audio id="audioDisplay">
                  <source src="" type="audio/mpeg">
               </audio>


            </div>
         </div>
         <div class="form">
            <form action="upload.php" method="post" enctype="multipart/form-data" id="upload">
               <input type="file" name="file[]" multiple>
               <input type="submit" name="upload" value="Carica file">
            </form>
         </div>
      </div>


   </section>

   <footer>
      <div class="footerelement"><h4>BUILT WITH ❤</h4></div>
      <div class="footerelement"><a href="./logout.php"><i class="fas fa-sign-out"></i></a></div>

   </footer>


   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   <script src="./mediaplayer.js"></script>



</body>

</html>
<?php
}else {
   session_unset();
   session_destroy();
   header ('Location : ../ ');
}
?>