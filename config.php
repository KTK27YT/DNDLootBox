<?php
// Name: config php
// Description: Config file for google
// Author: KTK27
require_once('google-api/vendor/autoload.php');
$gClient = new Google_Client();
// Your Client Settings
$gClient->setClientId("");
$gClient->setClientSecret("");
// Application settings for OAUTH2
$gClient->setApplicationName("");
$gClient->setRedirectUri("");
$gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");

$login_url = $gClient->createAuthUrl();

$captchakey = "";
$captchasecretkey = "";

?>