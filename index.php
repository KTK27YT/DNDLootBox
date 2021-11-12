<?php
require_once("config.php");
// Name: index php
// Description: Home Page for DND
// Author: KTK27
?>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>DND - HOME</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="styles/index2.css">
  <link rel="stylesheet" href="styles/loading.css">
</head>

<body>
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
  <!-- End of loader class -->
  <div class="bg"></div>
  <div class="centered">
  <!--  <button onclick="window.location = '<?php echo $login_url ?>'" type="button" class="btn btn-danger">Login With Google</button> --> 
  <div class="google-btn" onclick="window.location = '<?php echo $login_url ?>'">
  <div class="google-icon-wrapper">
    <img class="google-icon" onclick="window.location = '<?php echo $login_url ?>'" src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg"/>
  </div>
  <p class="btn-text"><b>Sign in with google</b></p>
</div>


  </div>

  <style>
    @import url(https://fonts.googleapis.com/css?family=Roboto:500);
.google-btn {
  width: 184px;
  height: 42px;
  background-color: #4285f4;
  border-radius: 2px;
  box-shadow: 0 3px 4px 0 rgba(0, 0, 0, 0.25);
  cursor: pointer;
}
.google-btn .google-icon-wrapper {
  position: absolute;
  margin-top: 1px;
  margin-left: 1px;
  width: 40px;
  height: 40px;
  border-radius: 2px;
  background-color: #fff;
}
.google-btn .google-icon {
  position: absolute;
  margin-top: 11px;
  margin-left: -10px;
  width: 18px;
  height: 18px;
}
.google-btn .btn-text {
  float: right;
  margin: 11px 11px 0 0;
  color: #fff;
  font-size: 14px;
  letter-spacing: 0.2px;
  font-family: "Roboto";
}
.google-btn:hover {
  box-shadow: 0 0 6px #4285f4;
}
.google-btn:active {
  background: #1669F2;
}
    .loader {
      display: inline-block;
      width: 30px;
      height: 30px;
      position: relative;
      border: 4px solid #Fff;
      animation: loader 2s infinite ease;
    }

    .loader-wrapper {
      width: 100%;
      height: 100%;
      position: absolute;
      top: 0;
      left: 0;
      background-color: #0000;
      display: flex;
      justify-content: center;
      align-items: center;

    }

    .loader-inner {
      vertical-align: top;
      display: inline-block;
      width: 100%;
      background-color: #fff;
      animation: loader-inner 2s infinite ease-in;
    }

    @keyframes loader {
      0% {
        transform: rotate(0deg);
      }

      25% {
        transform: rotate(180deg);
      }

      50% {
        transform: rotate(180deg);
      }

      75% {
        transform: rotate(360deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    @keyframes loader-inner {
      0% {
        height: 0%;
      }

      25% {
        height: 0%;
      }

      50% {
        height: 100%;
      }

      75% {
        height: 100%;
      }

      100% {
        height: 0%;
      }
    }
  </style>
</body>

</html>