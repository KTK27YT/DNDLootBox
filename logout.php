<?php
    // Name: logout php
    // Description: Logs user out
    // Author: KTK27

require('config.php');

//Destroy entire session data.
session_destroy();

setcookie("id", "", time() - 3600);
setcookie("sess", "", time() - 3600);

//redirect page to index.php
header('location:index.php');
die();

?>