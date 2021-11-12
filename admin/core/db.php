<?php

use Connect as GlobalConnect;
use Google\Service\BigQueryConnectionService\Connection;
// Name: db php
// Description: For admin db page for checking admin
// Author: KTK27
class Connect extends PDO{
    public function __construct(){
        require_once("admin_config.php");
        parent::__construct("mysql:host=". $dbhostname .";dbname=" . $dbname  , $dbUSERNAME , $dbpassword,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}


}
class AdminController {
    
    function geteverythin(){
        $db = new Connect;
        $sql = $db -> prepare("SELECT * FROM id WHERE id=:id");
        $sql->execute([
            ":id"=>intval(1)
        ]);
        $answer = $sql->fetchAll();
        return $answer;
    }
    function testuserexistence($email,$password){
        $db = new Connect;
        $email = stripcslashes($email);
        $password = stripcslashes($password);
        $sql = $db->prepare("SELECT id , auth FROM id WHERE email=:email AND password=:password");
        $sql->execute([
            ":email"=>$email,
            ":password"=>$password
        ]);
        $answer = $sql -> fetchAll(PDO::FETCH_ASSOC);
        if(!$answer){
            return false;
        } else {
            return true;
        }
        
    }
    function check2fa($email,$password,$code){
        include_once 'includes/FixedBitNotation.php';
        include_once 'includes/GoogleAuthenticatorInterface.php';
        include_once 'includes/GoogleAuthenticator.php';
        include_once  'includes/GoogleQrUrl.php';
        $db = new Connect;
        $email = stripcslashes($email);
        $password = stripcslashes($password);
        $sql = $db->prepare("SELECT auth FROM id WHERE email=:email AND password=:password");
        $sql->execute([
            ":email"=>$email,
            ":password"=>$password
        ]);
        $info = $sql-> fetchAll(PDO::FETCH_ASSOC);
        $g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
        if($g->checkCode($info[0]['auth'],$code)){
            return true;
        } else {
            return false;
        }
    }
    function createsession($email,$password){
        $db = new Connect;
        $email = stripcslashes($email);
        $password = stripcslashes($password);
        $sql = $db->prepare("SELECT id FROM id WHERE email=:email AND password=:password");
        $sql->execute([
            ":email"=>$email,
            ":password"=>$password
        ]);
        $info = $sql-> fetchAll(PDO::FETCH_ASSOC);
        $_SESSION["id"] = $info[0]['id'];
        $_SESSION["email"] = $email;
    }
    
}