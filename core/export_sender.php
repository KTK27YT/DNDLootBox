<?php
// Name: export_sender php
// Description: To provide users with their full inventory. This file is normally used with email_sender
// Author: KTK27
session_start();
require_once('config.php');
require_once('core/email_sender.php');
require_once('core/controller.class.php');
require_once('core/welcome_template.php');
?>

<?php


function export_sender()
{
    $inv = [];
    // handle the user profile selection
    $profilelink = "store/" . $_SESSION['playerprofile'];
    $items = "store/items.json";
    $profiletempget = file_get_contents($profilelink);
    $profiledecode = json_decode($profiletempget, true);
    $inventory =  $profiledecode['profile']['inventory'];
    $itemstempget = file_get_contents($items);
    $itemsdecode = json_decode($itemstempget, true);
    foreach ($inventory as $item) {
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
                $table = $table . '</tr>';
                break;
            case 3:
                $table = $table . "<tr>";
                $table = $table . "<th scope='row'><span class='uncommon'> Uncommon </span> </th>";
                $table = $table . "<td>" . $item . "</td>";
                $table = $table . "<td>" . $itemsdecode[$item][0]['Description'];
                $table = $table . '</tr>';
                break;
            case 4:
                $table = $table . "<tr>";
                $table = $table . "<th scope='row'><span class='rare'> Rare </span></th>";
                $table = $table . "<td>" . $item . "</td>";
                $table = $table .  "<td>" . $itemsdecode[$item][0]['Description'];
                $table = $table . '</tr>';
                break;
            case 5:
                $table = $table . "<tr>";
                $table = $table . "<th scope='row'><span class='legendary'> Legendary </span></th>";
                $table = $table . "<td>" . $item . "</td>";
                $table = $table . "<td>" . $itemsdecode[$item][0]['Description'];
                $table = $table . '</tr>';
                break;
        }
    }
    $message = "<!DOCTYPE html>
        <html lang'en'>
        
        <head>
            <meta charset='UTF-8'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Wilison DND template</title>
        </head>
        
        <body>
            <div class='header'>
                <div class='header-text'>
                    <div class='top-header'>
                        " . $_SESSION['Name'] . "
                        $" .  $_SESSION['money'] . "
                    </div>
                </div>
                <table style='border-collapse: collapse;' id='customers'>
                <thead>
                <tr>
                <th scope='col'> Rarity</th>
                <th scope ='col'> Name </th>
                <th scope ='col'> Description </th>
                </tr>
                    <tbody>
                        " .
        $table
        . "
                    </tbody>
                </table>
        </body>
        <style>
        <style>
        #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        }

        #customers td, #customers th {
         border: 1px solid #ddd;
        padding: 8px;
        }

        #customers tr:nth-child(even){background-color: #f2f2f2;}

        #customers tr:hover {background-color: #ddd;}

        #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
}
</style>
        </style>
        <style>
            .header {
                width: auto;
                height: 120px;
                display: flex;
                flex-direction: row;
                border-bottom: 3px solid #BD3944;
            }
        
            .header-text {
                margin-left: 50px;
            }
        
            .header-profile {
                align-items: right;
                justify-content: right;
                justify-self: right;
                margin-right: 50px;
            }
        
            .wrapper {
                margin-top: 50px;
            }
        
            .space {
                flex-grow: 3;
            }
        
            .top-header {
                margin-top: 5px;
                font-size: 30px;
                font-weight: bold;
                color: #BD3944;
            }
        
            .bottom-header {
                margin-top: 5px;
                color: #27ae60;
                font-size: 20px;
            }
        
            .rare {
                text-shadow:
                    0 0 5px #9b59b6,
                    0 0 10px #9b59b6;
            }
        
            .legendary {
                text-shadow:
                    0 0 5px #f1c40f,
                    0 0 10px #f1c40f;
            }
        
            .uncommon {
                text-shadow:
                    0 0 5px #2ecc71,
                    0 0 10px #2ecc71;
            }
        
           
        </style>
        
        </html>";

    return $message;
}


?>