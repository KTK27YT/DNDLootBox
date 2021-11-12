<!DOCTYPE html>
<html lang="en">
    <?php
// Name: index php
// Description: login page for admins
// Author: KTK27
session_start();
require_once("../config.php");
    require_once("core/db.php");
    if(isset($_POST["email"])){
        if(isset($_POST["password"])){
            if(isset($_POST["2FA"])){
              if(isset($_POST['g-recaptcha-response'])){
                $captcha=$_POST['g-recaptcha-response'];
                if(!$captcha){
                    error("Please complete the captcha");
                } else {
                    $ip = $_SERVER['REMOTE_ADDR'];
                    $url = "https://www.google.com/recaptcha/api/siteverify?secret=" . urlencode($captchasecretkey) . '&response=' . urlencode($captcha);
                    $response = file_get_contents($url);
                    $responseKeys = json_decode($response, true);
                    if($responseKeys["success"]){
                        // lets do the fun
                        $email = $_POST["email"];
                        $password = $_POST["password"];
                        $salted = "uO36d6Ivpu".$password."egzfchGyH4";
                        $hashed = hash('sha512',$salted);
                        $code = $_POST['2FA'];
                        $controller = new AdminController;
                        if($controller->testuserexistence($email,$hashed)){
                            if($controller->check2fa($email,$hashed,$code)){
                               // success("LESS GO!");
                               $controller->createsession($email,$hashed);
                               success("Logged In");
                               header("location: main.php");
                            } else {
                                error("invalid 2FA");
                            }
                        } else {
                            error("Incorrect Username / Password");
                        }
                    } else {
                        error("Captcha Invalid!");
                    }
                }
              } 
            } else {
                error("Please insert a 2FA token");
            }
        } else {
            error("Please put in a password");
        }
    }
    ?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DND - Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../styles/loading.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>
    <link rel="stylesheet" href="index.css">
</head>
<body>

<!-- loading class -->
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
<div class="sidenav">
         <div class="login-main-text">
            <h2>DND<br>Admin Login Page</h2>
            <p>Login to continue</p>
         </div>
      </div>
      <div class="main">
         <div class="col-md-6 col-sm-12">
            <div class="login-form">
               <form id="login-form" name="form" action="index.php" method="POST">
                  <div class="form-group">
                     <label>Email</label>
                     <input type="text" class="form-control" name="email" placeholder="User Name">
                  </div>
                  <div class="form-group">
                     <label>Password</label>
                     <input type="password" class="form-control" name="password" placeholder="Password">
                  </div>
                  <div class="form-group">
                      <label> 2FA Code </label>
                      <input type="text" class="form-control" name="2FA" placeholder="2FA Code">
                  </div>
                  <div class="form-group">
                  <div class="g-recaptcha" class="captcha" data-sitekey=<?php echo $captchakey ?>></div>
                  </div>
                  <button type="submit" class="btn btn-black">Login</button>
               </form>
            </div>
         </div>
      </div>
</body>
</html>