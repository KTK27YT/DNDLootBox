<?php 
// Name: Controller Class PHP
// Description: This is class is designed to interact with the DB for reading and writing.
// Author: KTK27
require_once("functions.php");
require_once("email_sender.php");
class Connect extends PDO{
    public function __construct(){
        require_once("config.php");
    // in the construct function you will need to put
    // parent::__construct("mysql:host=YOURHOST;dbname=YOURDBNAME,"username","password:,
        parent::__construct("mysql:host=" . $dbhost . ";dbname=". $dbname , $dbusername , $dbpassword, 
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }


}

class Controller {
    // Function for checking if there is enough money for a wish
    function checkwishmoney($sess,$id){
    $db = new Connect;
    $sql = $db -> prepare("SELECT money FROM users WHERE id=:id AND session=:sess");
    $sql->execute([
        ":id" => intval($id),
        ":sess" => $sess
    ]);
    $money = $sql-> fetchAll();
    $finalmoney = $money[0]["money"];
    if(strval($finalmoney) >= "100"){
        return "yes";
    } else {
        return "no";
    }


    }
    function fetch_users(){
        $db = new Connect;
        $sql = $db -> prepare("SELECT email FROM users");
        $sql->execute([]);
        $users = $sql->fetchAll();
        return $users;
    }
    // takes money from user when they wish(roll)
    function wish_taker($ses,$id){
        $db = new Connect;
        $sql = $db -> prepare("SELECT money FROM users WHERE id=:id AND session=:sess");
        $sql->execute([
            ":id" => intval($id),
            ":sess" => $ses
        ]);
        $money = $sql -> fetchAll();
        $finalmoney = $money[0]["money"];
        $updatmoney = $finalmoney - 100;
        $sqlcode = $db -> prepare("UPDATE users SET money = :money WHERE id = :id AND session = :sess");
        $sqlcode -> execute([
            ":money" => intval($updatmoney),
            ":id" => intval($id),
            ":sess" => $ses
        ]);
    }
    // Updates the Local Variable Money from DB
    function updatemoney($ses,$id){
        $db = new Connect;
        $sql = $db -> prepare("SELECT money FROM users WHERE id=:id AND session=:sess");
        $sql->execute([
            ":id" => intval($id),
            ":sess" => $ses
        ]);
        $money = $sql -> fetchAll();
        return $money[0]["money"];
    }
    //inserts new Money data
    function checkValue($value,$id){
        $db = new Connect;
      $SQLCODE = $db -> prepare("UPDATE users SET money = money + :number WHERE id = :id");
              $SQLCODE -> execute([
            ":id" => intval($id),
            ":number" => intval($value)
        ]);
    }
    // For logging into website
    function session_create($id,$sess){
        $db = new Connect;
        //ORDER BY id 
        $user = $db -> prepare("SELECT * FROM users WHERE id=:id AND  session=:sess");
        $user -> execute(
            [":id" => intval($id),
            ":sess" => $sess
            ]
            

        );
        while($userInfo = $user -> fetch(PDO::FETCH_ASSOC)){
            $_SESSION["Name"] = $userInfo["f_name"] . " " .  $userInfo["l_name"];
            $_SESSION["email"] = $userInfo["email"];
            $_SESSION["avatar"] = $userInfo["avatar"];
            $_SESSION['playerprofile'] = $userInfo["playerprofile"];
            $_SESSION['money'] = $userInfo["money"];
            
        }
        $_SESSION['id'] = $_COOKIE['id'];
        $_SESSION['sess'] = $_COOKIE['sess'];
        if(!file_exists("store/" . $_SESSION["playerprofile"])){
            //create the inventory json file
            $draftarray = Array (
                "profile" => Array(
                    "name" => $_SESSION["Name"],
                    "email" => $_SESSION["email"],
                    "4pity" => "0",
                    "5pity" => "0",
                    "redeemed_codes" => Array(

                    ),
                    "inventory" => Array(
                        
                    )
                )
               
            );
            $json = json_encode($draftarray);
            $filepath = "store/" . $_SESSION["playerprofile"];
            $myfile = fopen($filepath, "w+");
            fclose($myfile);
            file_put_contents($filepath , $json);
            welcome_mail($_SESSION["email"],$_SESSION["Name"],$_SESSION["avatar"]);
                
                
        };
    }
    // Checks if user is already logged in 
    function checkUserStatus($id, $sess){
        $db = new Connect;
        $user = $db -> prepare("SELECT id  FROM users WHERE id=:id AND session=:session");
        $user -> execute([
            ':id'   => intval($id),
            ":session"  => $sess
        ]);
        $userInfo = $user -> fetch(PDO::FETCH_ASSOC);
        if(!$userInfo['id']){
            return FALSE;
        }else{
            return TRUE;
        }
    }
    // inserts new user data into DB
    function insertData($data){
        session_start();
        $db = new Connect;
        $checkUser = $db->prepare("SELECT * FROM users WHERE email=:email");
        $checkUser->execute(['email' => $data["email"]]);
        $info = $checkUser->fetch(PDO::FETCH_ASSOC);
        $password = random_password(90);
        $json_create_name = random_str(16) . ".json";
        $session = random_str(90);
        if(!$info["id"]){
            $insertUser = $db -> prepare("INSERT INTO users (f_name, l_name, avatar, email, password, session, playerprofile, money) VALUES (:f_name, :l_name, :avatar, :email, :password, :session, :playerprofile , :money)");
            $insertUser -> execute([
                ':f_name' => $data["givenName"],
                ':l_name' => $data["familyName"],
                ':avatar' => $data["avatar"],
                ':email' => $data["email"],
                ':password' => $password,
                ':session' => $session,
                ':playerprofile' => $json_create_name,
                ':money' => 0
            ]);

            if($insertUser){
                setcookie("id", $db->lastInsertId(), time()+60*60*24*30, "/", NULL);
                 setcookie("sess", $session, time()+60*60*24*30, "/", NULL);
                header("location: main.php");
                exit();
            }else {
                return "Error inserting user!";
            }
        }else {
            setcookie("id", $info["id"], time()+60*60*24*30, "/", NULL);
            setcookie("sess", $info["session"], time()+60*60*24*30, "/", NULL);
            header("location: main.php");
            exit();
        }
    }
    
}




?>