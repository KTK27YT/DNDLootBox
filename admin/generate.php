<?php 
// Name: generate php
// Description: For generating admin page please provide your own 2fa code!
// Author: KTK27
declare(strict_types=1);
include_once 'includes/FixedBitNotation.php';
include_once 'includes/GoogleAuthenticatorInterface.php';
include_once 'includes/GoogleAuthenticator.php';
include_once  'includes/GoogleQrUrl.php';
$secret = 'YOURSECRET';
if(isset($_POST["auth"])){
   $g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
   if ($g->checkCode($secret,$_POST["auth"])){
       echo "YES \n";
   } else {
       echo $_POST['auth'] . " : is invalid";
   }
}
?>
<div>
    <form id="test" name="form" action="generate.php" method="POST">
        <input type="text" name="auth"></input>
        <button type="submit" name="submit"></button>
    </form>
</div>