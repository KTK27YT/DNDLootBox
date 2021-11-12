<?php
session_start();
// Name: main php
// Description: home page for admins
// Author: KTK27
if(isset($_SESSION["id"]) && isset($_SESSION["email"])){
    
} else {
    header("Location: index.php");
    die();
}

require_once("core/controller_default.php")
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DND - Admin</title>
    <link rel="stylesheet" href="styles/main.css">
    <script src="https://kit.fontawesome.com/5440f038fb.js" crossorigin="anonymous"></script>
    <script src="main.js"></script>
    <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&display=swap"
    rel="stylesheet"
  />
</head>
<body>
<script>
function codes(){
    document.getElementById("main").style.display = "none";
    document.getElementById("codes").style.display = "block";
    document.getElementById("users").style.display = "none";
}
function users(){
    document.getElementById("main").style.display = "none";
    document.getElementById("users").style.display = "block";
    document.getElementById("codes").style.display = "none";
}
</script>
    <nav class="navbar">
        <ul class="navbar-nav">
            <li class="nav-item" onclick="users();">
                <a href="#" class="nav-link">
                    <span class="link-text">Users </span>
                    <i class="fas fa-user-cog"></i>
                </a>
            </li>
            <li class="nav-item" onclick="codes();">
                <a href="#" class="nav-link">
                    <span class="link-text">Codes </span>
                    <i class="far fa-credit-card"></i>
                </a>
            </li>
            <li class="nav-item" onclick="window.location.href = 'logout.php';">
                <a href="logout.php" onclick="window.location.href = 'logout.php';" class="nav-link">
                    <span class="link-text">Logout </span>
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </li>
        </ul>
    </nav>
    <main> 
        <div id="main">
            <H1>Hello! <?php echo $_SESSION['email'] ?></H1>
            <h3>How may I be of service today?</h3>
            <?php 
            $db = new Controller;
            $users = array_unique($db->fetch_users2(), SORT_REGULAR);
           
            ?>
        </div>
        <div id="codes" style="display: none;">
            <H1>Codes</H1>
            <form action="" method="POST">
                <input type="text" name="code" placeholder="Name of Code"></input>
                <input type="number" name="value" placeholder="value"></input>
                <button type="submit">Submit</button>
            </form>
            <?php
            if(isset($_POST["code"])){
                $json = file_get_contents('../store/codes.json');

                $temparray = json_decode($json, true);
                $temparray["codes"][0][$_POST["code"]] = $_POST["value"];
              file_put_contents("../store/codes.json",json_encode($temparray));
            }



?>
        </div>
        <div id="users" style="display: none;">
            <h1>Users</h1>

            
            <form action="" method="POST">
                <select name="user" id="user">
                    <?php
                    foreach($users as $element){
                        echo "<option value=" . $element[0] . ">" . $element[0] . "</option>";
                    }
                    
                    ?>
                </select>
                <button type="submit">Submit</button>
            </form>
            <?php 
            global $user;
            global $data;
            global $currrentmoney;
            if(isset($_POST["user"])){
                global $user;
                $GLOBALS["user"] = $_POST["user"];
                echo "<script>";
                echo "users();";
                echo "document.getElementById('user').value = \"" . strval($_POST["user"]) . "\";";
                echo "</script>";
                echo "<h1>" . $_POST["user"] . "<h1>";
               $db = new Controller; 
              $GLOBALS["data"] = $db->fetch_user_info($_POST["user"]);
               echo "<h3> Money: $" . $GLOBALS["data"][0]["money"];
               $tempdata = $db->fetch_user_info($_POST["user"]);
               $GLOBALS["currrentmoney"] = $tempdata[0]["money"];
               echo "<form action ='' method='post'>";
               echo "<select name='option'>";
               echo "<option value='+'>+</option>";
               echo "<option value='-'>-</option>";
               echo "<input type='text' name='money'></input>";
               echo "<button type='submit'>Submit</button>";
               echo "<select name='user2' id='user2' method='POST'>";
               foreach($users as $element){
                   echo "<option value=" . $element[0] . ">" . $element[0] . "</option>";
               }
               echo "</select>";
               echo "<script>";
               echo "document.getElementById('user2').value = \"" . strval($_POST["user"]) . "\";";
               echo "</script>";
               echo "</form>";
            }
            
            ?>
            <?php
            if(isset($_POST["money"])){
              $user2 = $_POST["user2"];
              $operand = $_POST["option"];
              $money = $_POST["money"];
              $db = new Controller;
              $db->updat_function($operand,$user2,$_POST["money"]);
              if($operand == "+"){
                $message = "Successfuly added " . $_POST["money"] . " to " . $_POST["user2"];
                echo "alert('$message');";
                echo $message;
              }
              if($operand == "-"){
                $message = "Successfuly minus " . $_POST["money"] . " to " . $_POST["user2"];
                echo "alert('$message');";
                echo $message;
              }
            }
            
            
            ?>
            </div>
</div>
        </div>
</main>

</body>
</html>