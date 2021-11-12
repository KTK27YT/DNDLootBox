<?php
    // Name: main php
    // Description: Main page for the website
    // Author: KTK27
require_once('config.php');
require_once('core/email_sender.php');
require_once('core/controller.class.php');
require_once('core/welcome_template.php');
require_once('redeem.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DND - main page</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src='https://www.google.com/recaptcha/api.js' async defer></script>
  <link rel="stylesheet" href="styles/main.css">
  <link rel="stylesheet" href="styles/loading.css">
  <link rel="stylesheet" href="styles/inventoryoverlay.css">
</head>

<body style="margin: none; padding: none;">

  <script>
    window.addEventListener("load", function () {
    const loader = document.querySelector(".loader-wrapper");
    setTimeout(remove(), 3000);
    function remove() {
      loader.className += " hidden"; ;
    };
    
});
  </script>
  <?php
  if (isset($_COOKIE['id']) && isset($_COOKIE["sess"])) {
    $Controller = new Controller;
    if ($Controller->checkUserStatus($_COOKIE['id'], $_COOKIE['sess'])) {
      $Controller->session_create($_COOKIE['id'], $_COOKIE['sess']);
    } else {;
      header("location: index.php");
      die();
    }
  } else {
    header("location: index.php");
    die();
  }
  ?>
 <!-- Loader class -->
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
</div>
<?php 
// This is for redeeming the code
  if(isset($_POST['Redeem'])){
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
          // captcha truely valid alrighty lets reward the user lmao
          if(isset($_POST['redeemcode'])) {
            // code inserted now validating
            $code = strval($_POST['redeemcode']);
            if(Validate2($_POST['redeemcode'])){
              //Code exists in DB
  
              $playerprofile = "store/" . $_SESSION['playerprofile'];
              if(checkvalidate($code,$playerprofile)){
                // code is new
                addValue($code,$_COOKIE['id']);
                appendCode($code,$playerprofile);
                success("code redeemed");
                $url1=$_SERVER['REQUEST_URI'];
                header("Refresh: 5; URL=$url1");
              } else {
                // code has been used
                error("Code has been Already redeemed!");
               
              }
            } else {
              error("Code Doesn't exist!");
            }
          } else {
            error("Insert Code please!");
          }
        } else {
          error("Captcha invalid");
        }
      }
    }
  }


?>
  <!-- End of loader class -->
<?php 

// For handling msgs and errors from backend
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
</div>
<?php 
if (isset($_GET['insufficent'])){
  $money2 = 100 - intval($_SESSION['money']);
  error("Insufficent value for wish! you need " . strval($money2) . " more!");
}


?>

<div id="redeem" style="display: none;">
  <!-- Redeem Section box  -->
   <div class="redeem-container">
     <div class="redeem-wrapper"> 
     <form id="redeem_form" action="main.php" method="post">
       <span class="redeem-title"> Redeem Code </span> 
       <div class="form__group field">
        <input type="redeemcode" name="redeemcode" class="form__field" placeholder="Code here" id='name' required />
        <label for="code" class="form__label">Code</label>
        </div>
        <div class="button-wrapper">
        <div class="g-recaptcha" class="captcha" data-sitekey=<?php echo $captchakey ?>></div>
        <button type="submit" class="btn btn-danger btn-lg" name="Redeem" value="Redeem">Redeem</button>
        </div>
  </form>
  </div>
</div>
</div>
<!-- this is for allowing the user to click outside the box and hide the shown box" -->
<div class="removal" onclick="redeemof();"></div>
<div id="inventory-overlay" style="display:none;">
  <iframe class="portal" style="width: 1000px;" src="inventory.php"></iframe>
</div>
<!-- this is for allowing the user to click outside the box and hide the shown box" -->
<div class="removal" onclick="inventoryof();"></div>

  <div class="header">
    <img class="header-img" src="https://images.pexels.com/photos/460659/pexels-photo-460659.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" style="    object-fit: cover;">
    <div class="centered">Hello,</div>
    <div class="Name_Human"><?php echo $_SESSION["Name"] ?></div>
    <img class="profile_picture_header" src=<?php echo "\"" . $_SESSION['avatar'] . "\"" ?>>
  </div>
  <div class="money" style="background-color: #000000">
    <h3 style="text-align: center; padding-top: 10px; color: green; font-family: 'Open Sans', sans-serif;"><?php
                                                                      if ($_SESSION["money"] == 0) {
                                                                        echo "$" . " YOU HAVE NO MONEY BROKE ASS HA";
                                                                      } else {
                                                                        echo "$" . $_SESSION["money"];
                                                                      }


                                                                      ?> </h3>
  </div>
<div class="ccontainer">
  <div class="links" style="color: white;">
    <div class="Wish"><img class="link-img" onclick="wish();" src="images/wish-min.png" > </img> </div>
    <div class="inventory" onclick="inventory();"><img class="link-img" src="images/inventory-min.png"> </img> </div>

  </div>
  <div class="links">
  <div class="redeem" onclick="redeem();"> <img class="link-img" src="images/redeem-min.png"> </img></div>
    <div class="logout" onclick="logout();"> <img  class="link-img"  src="images/logout-min.png"> </img></div>
  </div>
                                                                    </div>
  <script>
    function logout(){
      window.location.href = "logout.php";
    };
    function redeem(){
      document.getElementById("redeem").style.display = "block";
      console.log("sup!");
    };
    function redeemof(){
      document.getElementById("redeem").style.display = "none";
    }
    function inventory(){
      document.getElementById("inventory-overlay").style.display = "block";
    }
    function inventoryof(){
      document.getElementById("inventory-overlay").style.display = "none";
    }
    function wish(){
      window.location.href = "wish.php";
    }
</script>
<script> 
$(document).mouseup(function(e) 
{
    // redeem remover
    var container = $(".redeem-container");

    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0) 
    {
        container.hide()
        redeemof();
        container.show();
    }
});
</script>
<script>
$(document).mouseup(function(e){
  //inventory remover
  var container = $(".portal");
  if(!container.is(e.target) && container.has(e.target).length === 0)
  {
    container.hide();
    inventoryof();
    container.show();
  }
});
</script>
<script>
 // Closes inventory iframe
  function closeIFrame(){
     inventoryof();
}
function exit(){
  inventoryof();
}
</script>
<footer>
  <div class="footerwrapper">
    <div class="space-around"></div>
    <div class="footer_img">
      <img class="imgfooter" src="logo/bannertrans.png"></img>
    </div>
    <div class="space-around"></div>
  </div>
</footer>

</body>

</html>