<?php

use Google\Service\AdExchangeBuyerII\ListCreativeStatusBreakdownByDetailResponse;
    // Name: wish.php
    // Description: This is for showing the rolled result
    // Author: KTK27
require_once('core/controller.class.php');
require_once('wish_main.php');
// Check for login
  if (isset($_COOKIE['id']) && isset($_COOKIE["sess"])) {
    $Controller = new Controller;
  if ($Controller->checkUserStatus($_COOKIE['id'], $_COOKIE['sess'])) {
   $Controller->session_create($_COOKIE['id'], $_COOKIE['sess']);
     } else {
 setcookie("id", "", time() - 3600);
      setcookie("sess", "", time() - 3600);
      header("location: index.php");
     die();
       }
    } else {
    header("location: index.php");
   die();
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="styles/loading.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="wish_src/wish.css">
    <title>DND - Wish</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="script.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
<div class="loader-wrapper" style=" 
  background-color: #242f3f;
  z-index: 19;">
    <span class="loader"><span class="loader-inner"></span></span>
  </div>
<script>
  // Background music
  function music2(){
            musicplayer.play();
            var musicplayer2 = document.getElementById("musicplayer");
            musicplayer2.volume = 0.1;
    }
</script>
<div id="wrapper">
  <div id="warner" style="z-index: 3;">
      <div id="centered">
        
        <p>
        <?php 
        $Controller = new Controller();
        $SESS = $_SESSION['sess'];
        $id = $_SESSION['id'];
        $check_init = $Controller->checkwishmoney($SESS,$id);
        if($check_init == "yes"){
          echo "<h1> Hello! </h1>
          <p> If you want to dodge this alert enable autoplay in your browser </p>
          <p> due to autoplay policies, to continue please press the button below </p>
          <button class=\"btn btn-secondary\" onclick=\"music2();document.getElementById('warner').style.display = 'none';document.getElementById('money').style.display = 'block';document.getElementById('activate').style.display = 'block';\">click</button>";
        } else {
          echo "<script> alert('insufficient value') </script>";
          header("location: main.php?insufficent");
          die("Insufficent value");
        }
        ?>    
      
      </p>
        
      </div>
  </div>

<?php
$init = strval($check_init);
if($init){
  $roll = roll(); // This is the worst possible way to implement this. Essentially PHP rolls it and just echoes the result out into Javascript. I would like to use ajax but couldn't figure a proper way of implementing and suggestions would be appreciated!
  $Controller = new Controller();
  $Controller->wish_taker($SESS,$id);
  $_SESSION['money'] = $Controller->updatemoney($SESS,$id);
} else {  
  echo "<script> alert('insufficent funds! you only have:" . $_SESSION['money'] . "')</script>";
  header("location: main.php?insufficent");
  die("Insufficent Funds");
}
echo "<button id='activate' style='display: none;' onclick='run2(\"{$init}\",\"{$roll}\")'></button>";
?>
<div id="money" style="z-index: 4; display:'none';">
  <p><?php echo $_SESSION['money']; ?></p>
</div>
<audio id="fourstarplayer" preload="auto" >
        <source src="wish_src/mp3/4star_continuation.mp3">
</audio>
<audio id="5starjojoplayer" preload="auto">
        <source src="wish_src/mp3/5_star_jojo_continuation.mp3">
</audio>
<audio id="5starjudgeplayer" preload = "auto">
        <source src="wish_src/mp3/5_star_judgement.mp3">
</audio>
<audio id="musicplayer" autoplay preload="auto">
        <source src="wish_src/mp3/main_menu.mp3"> 
  </audio>
<video id="5starjojo" style="display:none;"  preload="auto" >
</video>
<video id="5starjudge" style="display:none;" preload="auto">
</video>
<video id="4star" style="display:none;" preload="auto">
</video>
<video id="3star" style="display:none;" preload="auto">
</video>
<video id="2star" style="display:none;" preload="auto">
</video>
</div>
<script>
//preloading
//2star
// Essentially it just requests the video and stores in the broswers cache!
var req = new XMLHttpRequest();
req.open('GET', "wish_src/vids/normal.mp4", true);
req.responseType = "blob";
req.onload=function(){
  if(this.status === 200){
    var videoBlob = this.response;
    var vid = URL.createObjectURL(videoBlob);
    document.getElementById('2star').src = vid;
  }
}
req.onerror = function() {
  console.log("error preloading 2 star video")
  console.log("lemme yolo it lets just append it !");
  document.getElementById('2star').src = "wish_src/vids/normal.mp4";
}
req.send();
//3star preloading
var req = new XMLHttpRequest();
req.open('GET', "wish_src/vids/3star.mp4", true);
req.responseType = "blob";
req.onload = function(){
  if(this.status === 200){
    var videoBlob = this.response;
    var vid = URL.createObjectURL(videoBlob);
    document.getElementById('3star').src = vid;
  }
req.onerror = function() {
  console.log("error preloading 3 star video");
  console.log("lemme yolo it just append it!");
  document.getElementById('3star').src = "wish_src/vids/3star.mp4";
}

}
req.send();
//4star preloading
var req = new XMLHttpRequest();
req.open('GET', "wish_src/vids/4star.mp4", true);
req.responseType = "blob";
req.onload=function(){
  if(this.status === 200){
    var videoBlob = this.response;
    var vid = URL.createObjectURL(videoBlob);
    document.getElementById('4star').src = vid;
  }
}
req.onerror = function() {
  console.log("error preloading 4 star video")
  console.log("lemme yolo it just append it");
  document.getElementById('4star').src = "wish_src/vids/4star.mp4";
}
req.send();
//5starjojo preloading
var req = new XMLHttpRequest();
req.open('GET', "wish_src/vids/5star_jojo.mp4", true);
req.responseType = "blob";
req.onload=function(){
  if(this.status === 200){
    var videoBlob = this.response;
    var vid = URL.createObjectURL(videoBlob);
    document.getElementById('5starjojo').src = vid;
  }
}
req.onerror = function() {
  console.log("error preloading 5 star jojo video")
  console.log("lemme yolo it just append it");
  document.getElementById('5starjojo').src = "wish_src/vids/5star_jojo.mp4";
}
req.send();
//5starjudgement preloading
var req = new XMLHttpRequest();
req.open('GET', "wish_src/vids/5star_judgement.mp4", true);
req.responseType = "blob";
req.onload=function(){
  if(this.status === 200){
    var videoBlob = this.response;
    var vid = URL.createObjectURL(videoBlob);
    document.getElementById('5starjudge').src = vid;
  }
}
req.onerror = function() {
  console.log("error preloading 5 star judgement video")
  console.log("lemme yolo it just append it");
  document.getElementById("5starjudge").src = "wish_src/vids/5star_judgement.mp4";
}
req.send();

</script>
<script>
    $(window).on("load", function(){
      $(".loader-wrapper").fadeOut("slow");
     console.log("sup");
   } );
  </script>
<div id="result" style="display: none;">
<div id="container">
<div id="item-info">
  <div id="item-header"></div>
  <hr>
  <div id="item-status"></div>
</div>
<div id="description"></div>
</div>
<button class="btn btn-primary" style="margin-top: 15px;" onclick="window.location.href = 'main.php'">Go back</button>
</div>

</body>
</html>