<?php

use Connect as GlobalConnect;
// Name: controller default php
// Description: For interfacing the admin page with the user DB
// Author: KTK27
class Connect extends PDO{
    public function __construct(){
        require_once("../../core/config.php");
        parent::__construct("mysql:host=". $dbhost . ";dbname=" . $dbname,  $dbusername,  $dbpassword, 
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }


}
Class Controller {
    function fetch_users2(){
        $db = new Connect;
        $sql = $db -> prepare("SELECT email FROM users");
        $sql->execute([]);
        $users = $sql->fetchAll();
        $cool = array_unique($users, SORT_REGULAR);
        return $cool;
    }
    function fetch_user_info($name){
        $db = new Connect;
        $sql = $db -> prepare("SELECT money,avatar,f_name,l_name,playerprofile FROM users WHERE email = :email");
        $sql->execute([
            ":email" => $name
        ]);
        return $sql->fetchAll();
    }
    function updat_function($operand,$email,$money){
        if($operand == "+"){
            $db = new Connect;
            $fetchsql = $db->prepare("SELECT money FROM users WHERE email = :email");
            $fetchsql->execute([
                ":email" => $email
            ]);
            $tempmoney = $fetchsql->fetchAll(PDO::FETCH_ASSOC);
            $currentmoney = $tempmoney[0]["money"];
            $sql = $db -> prepare("UPDATE users SET money = :money WHERE email = :email");
            $sql->execute([
                ":money" => intval($currentmoney + $money),
                ":email" => $email
            ]);
            echo "<script>";
            echo "alert(\"" . "Successfuly added $" . $currentmoney + $money . " to " . $email . "\");";
            echo "<script>";
        }
        if($operand == "-"){
            $db = new Connect;
            $db = new Connect;
            $fetchsql = $db->prepare("SELECT money FROM users WHERE email = :email");
            $fetchsql->execute([
                ":email" => $email
            ]);
            $tempmoney = $fetchsql->fetchAll(PDO::FETCH_ASSOC);
            $currentmoney = $tempmoney[0]["money"];
            $sql = $db -> prepare("UPDATE users SET money = :money WHERE email = :email");
            $sql->execute([
                ":money" => intval($currentmoney - $money),
                ":email" => $email
            ]);
        }
    }
}