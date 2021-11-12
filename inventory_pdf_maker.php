<?php
    // Name: inventory_pdf_maker php
    // Description: CREATE A PDF WITH INVENTORY GIVEN
    // Author: KTK27
    function pdf_create(){
        session_start();
        // read and grab all the stuff required
     $profilelink = "store/" . $_SESSION['playerprofile'];
         $items = "store/items.json";
         $inv = [];
        $profiletempget = file_get_contents($profilelink);
             $profiledecode = json_decode($profiletempget, true);
      $inventory =  $profiledecode['profile']['inventory'];
     $itemstempget = file_get_contents($items);
      $itemsdecode = json_decode($itemstempget, true);
       foreach($inventory as $item){
           array_push($inv, $item);
         }
         $table = "";
         foreach ($inv as $item) {
            $itemstar = $itemsdecode[$item][0]['stars'];
            switch ($itemstar) {
                case 2:
                    $table = $table . "<tr>";
                    $table = $table . "<th scope='row'> common </th>";
                    $table = $table . "<td>" . $item . "</td>";
                    $table = $table . "<td>" . $itemsdecode[$item][0]['Description'];
                    $table = $table . "<br>";
                    $table = $table . '</tr>';
                    break;
                case 3:
                    $table = $table . "<tr>";
                    $table = $table . "<th scope='row'><span class='uncommon' style=' color: #16a085; '> Uncommon </span> </th>";
                    $table = $table . "<td>" . $item . "</td>";
                    $table = $table . "<td>" . $itemsdecode[$item][0]['Description'];
                    $table = $table . "<br>";
                    $table = $table . '</tr>';
                    break;
                case 4:
                    $table = $table . "<tr>";
                    $table = $table . "<th scope='row'><span class='rare' style='color: #9b59b6;'> Rare </span></th>";
                    $table = $table . "<td>" . $item . "</td>";
                    $table = $table .  "<td>" . $itemsdecode[$item][0]['Description'];
                    $table = $table . "<br>";
                    $table = $table . '</tr>';
                    break;
                case 5:
                    $table = $table . "<tr>";
                    $table = $table . "<th scope='row'><span class='legendary' style=' color: #f39c12;'> Legendary </span></th>";
                    $table = $table . "<td>" . $item . "</td>";
                    $table = $table . "<td>" . $itemsdecode[$item][0]['Description'];
                    $table = $table . "<br>";
                    $table = $table . '</tr>';
                    break;
            }
        }
        $name = $_SESSION['Name'];
        $money = $_SESSION['money'];
        $avatar = $_SESSION['avatar'];
         $bootstrap_css = "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU' crossorigin='anonymous'>";
         $inventory_css = file_get_contents('styles/inventory.css');
         $tables_css = file_get_contents('tables.css');
         // create new pdf instance
         require_once __DIR__ . '/vendor/autoload.php';
         $mpdf = new \Mpdf\Mpdf();
         $mpdf->WriteHTML($tables_css,\Mpdf\HTMLParserMode::HEADER_CSS);
         date_default_timezone_set("Asia/Hong_Kong");
         $message = '<table id="customer" style="  border-collapse: collapse;">
         <thead>
           <tr>
             <th scope="col">Rarity</th>
             <th scope="col">Item Name</th>
             <th scope="col">Description</th>
           </tr>
         </thead>
         <tbody>
          ' . $table . '
         </tbody>
       </table>';
       $header = '<div class="wrapper">
       <div class="header">
               <div class="top-header">
                   ' . $name . '
               </div>
               <div class="bottom-header">
                    $ '.   $money . ' 
                    <br>
                    <p style="color: #BD3944; font-size: 13px;"> Generated at : ' . date("l  d-m-y  h:i:sa") . '  HKT</p>
               </div>
     </div>
       ';
      
       $mpdf->WriteHTML($header);
       $mpdf->WriteHTML('<h1></h1>');
       $mpdf->WriteHTML($message);
       $filename = $name . "'s inventory(" . date("d-m-y@H:i:s") . " HKT).pdf" ;
       ob_clean(); 
         $mpdf->Output($filename,\Mpdf\Output\Destination::DOWNLOAD);
         echo '<div class="alerts" id="hideMe" style="z-index: 100;">';
         echo '<div class="alert alert-success" style="z-index: 100;"  role="alert">
         ' . $success . '
       </div>';
       echo '</div>';
       return true;
    }
?>