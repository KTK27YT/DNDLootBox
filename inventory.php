<?php 
    // Name: inventory php
    // Description: Displays inventory of user Used thru IFRAME
    // Author: KTK27
require_once('config.php');
require_once('core/email_sender.php');
require_once('core/controller.class.php');
require_once('core/welcome_template.php');
if(isset($_COOKIE['id']) && isset($_COOKIE["sess"])){
    $Controller = new Controller;
    if($Controller -> checkUserStatus($_COOKIE['id'], $_COOKIE['sess'])){
   //   $Controller -> session_create($_COOKIE['id'], $_COOKIE['sess']);
    } else {
        setcookie("id", "", time() - 3600);
        setcookie("sess", "", time() - 3600);
        header("location: index.php");
    }
} else {
    header("location: index.php");
}
?>
<?php
    $inv = [];
    // handle the user profile selection
    $profilelink = "store/" . $_SESSION['playerprofile'];
    $items = "store/items.json";
    $profiletempget = file_get_contents($profilelink);
    $profiledecode = json_decode($profiletempget, true);
    $inventory =  $profiledecode['profile']['inventory'];
    $itemstempget = file_get_contents($items);
    $itemsdecode = json_decode($itemstempget, true);
   foreach($inventory as $item){
       array_push($inv, $item);
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DND  - Inventory Iframe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles/inventory.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="styles/loading.css">
</head>
<body>
<div class="loader-wrapper" style=" 
  background-color: #242f3f;
  z-index: 19;">
    <span class="loader"><span class="loader-inner"></span></span>
  </div>
  <script>
    $(window).on("load", function(){
      $(".loader-wrapper").fadeOut("slow");
   } );
  </script>
    <div class="wrapper">
  <div class="header">
      <div class="header-text">
          <div class="top-header">
              <?php  echo $_SESSION['Name']?>
          </div>
          <div class="bottom-header">
              <?php echo "$" .  $_SESSION['money'] ?>
          </div>
      </div>
      <div class="space"></div>
      <div class="header-profile">
          <img class="rounded-circle" src="<?php echo $_SESSION['avatar']; ?>">
      </div>
</div>
<table class="table table-striped table-dark">
<tbody>
    <?php 
    foreach($inv as $item){ // This is for printing the items
      $itemstar = $itemsdecode[$item][0]['stars'];
      switch($itemstar){
          case 2:
            echo "<tr>";
            echo "<th scope='row'> common </th>";
            echo "<td>" . $item . "</td>";
            echo "<td>" . $itemsdecode[$item][0]['Description'];
            echo '</tr>';
            break;
        case 3:
            echo "<tr>";
            echo "<th scope='row'><span class='uncommon'> Uncommon </span> </th>";
            echo "<td>" . $item . "</td>";
            echo "<td>" . $itemsdecode[$item][0]['Description'];
            echo '</tr>';
            break;
        case 4:
            echo "<tr>";
            echo "<th scope='row'><span class='rare'> Rare </span></th>";
            echo "<td>" . $item . "</td>";
            echo "<td>" . $itemsdecode[$item][0]['Description'];
            echo '</tr>';
            break;
        case 5:
            echo "<tr>";
            echo "<th scope='row'><span class='legendary'> Legendary </span></th>";
            echo "<td>" . $item . "</td>";
            echo "<td>" . $itemsdecode[$item][0]['Description'];
            echo '</tr>';
            break;
      }

    }
    ?>
</tbody>
</table>
<div class="export " >
    <button  type="button" class="btn btn-danger btn-lg btn-block" onclick="export2()">Export</button>
    <button type="button" class="btn btn-primary btn-lg btn-block" onclick ="parent.exit();"> Exit </button>
</div>
</div>
<script>
function export2(){
    window.location.href = "export.php";
}

</script>
</body>
</html>