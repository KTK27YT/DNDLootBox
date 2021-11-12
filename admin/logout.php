<?php 
// Name: logout php
// Description: logout page for admins
// Author: KTK27
session_destroy();
header("location: index.php");
die();