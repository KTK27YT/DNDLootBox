<?php 
// Name: export php
// Description: This is used in an iframe. It exports inventory information to user! (Emailing and PDF)
// Author: KTK27
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DND  - Export Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles/inventory.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>
    <link rel="stylesheet" href="styles/loading.css">
</head>
<?php 
require_once('config.php');
require_once('core/email_sender.php');
require_once('core/controller.class.php');
require_once('core/welcome_template.php');
require_once('inventory_pdf_maker.php');
// checks if user is logged in already
if(isset($_COOKIE['id']) && isset($_COOKIE["sess"])){
    $Controller = new Controller;
    if($Controller -> checkUserStatus($_COOKIE['id'], $_COOKIE['sess'])){
    } else {
        setcookie("id", "", time() - 3600);
        setcookie("sess", "", time() - 3600);
        header("location: index.php");
    }
} else {
    header("location: index.php");
}
// handling the email 
if(isset($_POST['export'])){
    if(isset($_POST['g-recaptcha-response'])){ 
        $captcha=$_POST['g-recaptcha-response'];
        if(!$captcha){
          error("Captcha please");
        } else {
          // validate captcha origin
          $ip = $_SERVER['REMOTE_ADDR'];
          $url = "https://www.google.com/recaptcha/api/siteverify?secret=" . urlencode($captchasecretkey) . '&response=' . urlencode($captcha);
          $response = file_get_contents($url);
          $responseKeys = json_decode($response, true);
          if($responseKeys["success"]){
            // captcha validate
            inventory_export_mail($_SESSION['email'], $_SESSION['Name']); //sends the email for inventory

            $temp2 = pdf_create(); //creates the pdf for inventory
            if($temp2){
                echo "Finished !";
                echo "<script> parent.closeIFrame() </script>";
                $success = " Message has been sent";
                 success($success);
            } else {
                echo "Finished !";
                echo "<script> parent.closeIFrame() </script>";
                $success = " Message has been sent";
                 success($success);
            }
            echo "Finished !";
                echo "<script> parent.closeIFrame() </script>";
                $success = " Message has been sent";
                 success($success);
          } else {
            error("Captcha Error!");
          }
        }
    } else {
        error("Captcha Error");
    }
}
?>
<body>
<div class="wrapper">
<?php
function error($STRING) {
  echo '<div class="alerts" id="hideMe" style="z-index: 100;">';
  echo '<div class="alert alert-danger" style="z-index: 100;" role="alert">
  '. $STRING . '
</div>';
echo '</div>';
}
function success($STRING){
  echo '<div class="alerts" id="hideMe" style="z-index: 100;">';
  echo '<div class="alert alert-success" style="z-index: 100;"  role="alert">
  ' . $STRING . '
</div>';
echo '</div>';
}
?>
<div class="loader-wrapper" style=" 
  background-color: #242f3f;
  z-index: 19;">
    <span class="loader"><span class="loader-inner"></span></span>
  </div>
  <script>
    $(window).on("load", function(){
      $(".loader-wrapper").fadeOut("slow");
     console.log("sup");
   } );
  </script>
<div class="wrapper">
  <div class="header">
      <div class="header-text">
          <div class="top-header">
              <?php  echo $_SESSION['Name']?>
          </div>
          <div class="bottom-header">
              <?php echo "$" .  $_SESSION['money'] ?>
          </div>
      </div>
      <div class="space"></div>
      <div class="header-profile">
          <img class="rounded-circle" src="<?php echo $_SESSION['avatar']; ?>">
      </div>
</div>
<style>
/* spinning button */
.button {
    position: relative;
    padding: 8px 16px;
    background: #009579;
    border: none;
    outline: none;
    border-radius: 2px;
    cursor: pointer;
}
.button:active {
    background: #007a63;
}
.button__text {
    font: bold 20px 'Open Sans', sans-serif;
    color: #ffffff;
    transition: all 0.2s;
}
.button--loading .button__text{
    visibility: hidden;
    opacity: 0;
}
.button--loading::after{
    content: "";
    position: absolute;
    width: 16px;
    height: 16px;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    margin: auto;
    border: 4px solid transparent;
    border-top-color: #ffffff;
    border-radius: 50%;
    animation: button-loading-spinner 1s ease infinite;
}
@keyframes button-loading-spinner{
    from {
        transform: rotate(0turn);
    }
    to {
        transform: rotate(1turn);
    }
}
</style>
    <div class="form">
        <form id="export" action="export.php" method="POST">
        <div class="button-wrapper">
        <div class="g-recaptcha" class="captcha" data-sitekey=<?php echo $captchakey ?>></div>
        <div class="d-grid gap-2">
  <button type="submit" class="button" onclick="this.classList.toggle('button--loading')"  name="export" value="export"> <span class="button__text">Export</span> </button>
</div>
       <button  class="btn btn-danger btn-lg" onclick="parent.closeIFrame()" > Exit </button> 
       
        </div>
    </form>
    <button  class="btn btn-primary btn-lg" onclick="goback()" > Go back </button> 
    </div>
    </div>
<script>
function goback(){
    window.location.href = "inventory.php";
}



</script>
</body>
<style>
    .button-wrapper{
        align-items: center;
        justify-content: center;
    }
    .form{
        position: absolute;
        position: absolute;
    left: 50%;
    top: 50%;
    -webkit-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    justify-content: center;
    align-content: center;
    text-align: center;
    }
    .wrapper {
        width: 100%;
        height: 100%;
    }
body{
    overflow-y: visible;
    font-family: 'Open Sans', sans-serif;
    background-color: #000000;
}
.header {
    width: auto;
    height: 120px;
    display: flex;
    flex-direction: row;
}
.header-text {
    margin-left: 50px;
}
.header-profile {
    align-items: right;
    justify-content: right;
    justify-self: right; 
    margin-right: 50px;
}
.wrapper {
    margin-top: 50px;
}
.space {
    flex-grow: 3;
}
.top-header{
    margin-top:5px;
    font-size: 30px;
    font-weight: bold;
    color:#BD3944;
}
.bottom-header{
    margin-top: 5px;
    color: #27ae60;
    font-size: 20px;
}

</style>
</html>