<?php 
    // Name: redeem php
    // Description: For code redeeming
    // Author: KTK27
    require_once('core/controller.class.php');


?>
<?php 
// validates the code from codes.json
function Validate2($CODE){
    $codepath = "store/codes.json";
    $json = file_get_contents($codepath);
     $codejson = json_decode($json,true);
     if(isset($codejson['codes'][0][$CODE])){
         // exists
         return true;
     } else {
         // doesnt exist
         return false;
     }

}
// See if the code has been used
function checkvalidate($CODE,$profilejson){
    $tempprofileget = file_get_contents($profilejson);
    $tempprofilejson = json_decode($tempprofileget,true);
     if(in_array($CODE, $tempprofilejson['profile']['redeemed_codes'])){
         return false;
     } else {
         return  true;
     };
    }
// Adds codes money value to user
function addValue($CODE,$id){
    $codepath = "store/codes.json";
    $json = file_get_contents($codepath);
     $codejson = json_decode($json,true);
     $valueofcode = $codejson['codes'][0][$CODE];
    $Controller = new Controller;
    $Controller -> checkValue($valueofcode,$id);
}
//Adds code to used codes
function appendCode($CODE,$profilecode2){
    $profiledata = file_get_contents($profilecode2);
    $profiledata2 = json_decode($profiledata, true);
    array_push($profiledata2["profile"]["redeemed_codes"], $CODE);
    file_put_contents($profilecode2, json_encode($profiledata2));
}
?>