
<?php
    // Name: wish_main.php
    // Description: This is for testing and debugging but also contains functions for the main page (wish.php) to work
    // Author: KTK27
function roll()
{
    require_once('core/controller.class.php');
    // Check for login
    if (isset($_COOKIE['id']) && isset($_COOKIE["sess"])) {
        $Controller = new Controller;
        if ($Controller->checkUserStatus($_COOKIE['id'], $_COOKIE['sess'])) {
            $Controller->session_create($_COOKIE['id'], $_COOKIE['sess']);
        } else {
            // setcookie("id", "", time() - 3600);
            //  setcookie("sess", "", time() - 3600);
            header("location: index.php");
            die();
        }
    } else {
        header("location: index.php");
        die();
    }
    // create the seeds and shit
    $inv = [];
    $profilelink = "store/" . $_SESSION['playerprofile'];
    $items = "store/items.json";
    $profiletempget = file_get_contents($profilelink);
    $profiledecode = json_decode($profiletempget, true);
    $inventory =  $profiledecode['profile']['inventory'];
    $itemstempget = file_get_contents($items);
    $itemstore = json_decode($itemstempget, true);
    $award = "";
    function append_inventory($profilelink,$award){
        $profiletempget = file_get_contents($profilelink);
        $profiledecoded = json_decode($profiletempget, true);
       // $profiledecoded['profile']['inventory'] += $award;
       array_push($profiledecoded['profile']['inventory'], $award);
        $dataappend = json_encode($profiledecoded);
        file_put_contents($profilelink, $dataappend);
    }
    foreach ($inv as $invitem) {
        //removes previously granted items
        unset($itemstore[$invitem]);
    }
    function reset_4star($profiledecode, $profilelink)
    {
        //$tempdat = $profiledecode['profile']['4pity'];
        $profiledecode['profile']['4pity'] = "0";
        $dataappend = json_encode($profiledecode);
        file_put_contents($profilelink, $dataappend);
    }
    function reset_5star($profiledecode, $profilelink)
    {
        //$tempdat = $profiledecode['profile']['4pity'];
        $profiledecode['profile']["5pity"] = strval(10 - $profiledecode['profile']["5pity"]);
        $dataappend = json_encode($profiledecode);
        file_put_contents($profilelink, $dataappend);
    }
    function add_4star($profiledecode, $profilelink)
    {
        $tempdat = $profiledecode['profile']['4pity'];
        $profiledecode['profile']['4pity'] = strval($tempdat + 1);
        $dataappend = json_encode($profiledecode);
        file_put_contents($profilelink, $dataappend);
    }
    function add_5star($profiledecode, $profilelink)
    {
        $tempdat = $profiledecode['profile']['5pity'];
        $profiledecode['profile']['5pity'] = strval($tempdat + 1);
        $dataappend = json_encode($profiledecode);
        file_put_contents($profilelink, $dataappend);
    }
    $fouritempool = [];
    $fiveitempool = [];
    $threeitempool = [];
    $twoitempool = [];
    foreach ($itemstore as $item) {
        $stars = $item[0]["stars"];
        switch ($stars) {
            case 2:
                array_push($twoitempool, $item);
                break;
            case 3:
                array_push($threeitempool, $item);
                break;
            case 4:
                array_push($fouritempool, $item);
                break;
            case 5:
                array_push($fiveitempool, $item);
        }
    }
    // PHP is retarded so we gotta use it to find said key
    function search_key($STRING, $itemstore)
    {
        foreach ($itemstore as $key => $val) {
            if ($val[0]['Description'] === $STRING) {
                return $key;
            }
        }
    }
    foreach ($inventory as $item) {
        array_push($inv, $item);
    }
    // inventory of user created
    // create pregen shit time
    $fourstarpity = $profiledecode['profile']['4pity'];
    $fivestarpity = $profiledecode['profile']['5pity'];
    $fourmaxpity = false;
    $fivemaxpity = false;
    if ($fivestarpity == 10) {
        $fivemaxpity = true;
        $random = $fiveitempool[array_rand($fiveitempool)][0]['Description'];
        $award = search_key($random, $itemstore);
        $profiledecode['profile']['5pity'] = "0";
        $profiledecode['profile']['4pity'] = strval($profiledecode['profile']['4pity'] + 1);
        $dataappend = json_encode($profiledecode);
        file_put_contents($profilelink, $dataappend);
        append_inventory($profilelink,$award);
        return $award;
        die();
    } elseif ($fourstarpity == 5) {
        $random = $fouritempool[array_rand($fouritempool)][0]['Description'];
        $award = search_key($random, $itemstore);
        $profiledecode['profile']['4pity'] = "0";
        $profiledecode['profile']['5pity'] = strval($profiledecode['profile']['5pity'] + 1);
        $dataappend = json_encode($profiledecode);
        file_put_contents($profilelink, $dataappend);
        append_inventory($profilelink,$award);
        return $award;
        die();
    }
    if ($fourmaxpity == true or $fivemaxpity == true) {
        if ($fourmaxpity == true) {
            die();
        } else {
            die();
        }
    } else {
        // run code for normal wishes
        //  Math Notes:
        //  for 4 star = (n * 10) * 2
        //  for 5 star = (n * 10) 
        //  1000 * n% = RC
        // RC = real chance
        // determine rarity
        // for commons and uncommons the pool is @ 10000 to ensure unfairness no I mean FAIRNESS
        $forstarseed = 1000 * ($fourstarpity * 10 * 3 / 100);
        $fivestarseed = 1000 * ($fivestarpity * 10 * 2 / 100);
        if ($forstarseed <= 0) {
            $forstarseed = 0;
        }
        if ($fivestarseed <= 0) {
            $fivestarseed = 0;
        }
        $masterseed = 10000 - $forstarseed - $fivestarseed;
        $determine = rand(1, 4);
        switch ($determine) {
            case 1:
                $threestarseed = $masterseed * 0.6;
                $twostarseed = $masterseed * 0.4;
                break;
            case 2:
                $threestarseed = $masterseed * 0.4;
                $twostarseed = $masterseed * 0.6;
                break;
            case 3:
                $threestarseed = $masterseed * 0.6;
                $twostarseed = $masterseed * 0.4;
                break;
            case 4:
                $threestarseed = $masterseed * 0.4;
                $twostarseed = $masterseed * 0.6;
                break;
        }
        $seedpool = [];
        $fourstarpoolseed = array_fill(0, $forstarseed, "Rare");
        $fivestarpoolseed =  array_fill(0, $fivestarseed, "Legendary");
        $threestarpoolseed = array_fill(0, $threestarseed, "Uncommon");
        $twostarpoolseed = array_fill(0, $twostarseed, "Common");
        $seedpool = array_merge($fourstarpoolseed, $fivestarpoolseed, $threestarpoolseed, $twostarpoolseed);
        $rarity = $seedpool[array_rand($seedpool)];
        // now we find the item to award
        // now we award said item
        switch ($rarity) {
            case "Common":
                $random = $twoitempool[array_rand($twoitempool)][0]['Description'];
                //echo $random;
                // echo "<br>";
                $award = search_key($random, $itemstore);
                //echo $itemstore[$temp];
                $profiledecode['profile']['4pity'] = strval($profiledecode['profile']['4pity'] + 1);
                $profiledecode['profile']['5pity'] = strval($profiledecode['profile']['5pity'] + 1);
                $dataappend = json_encode($profiledecode);
                file_put_contents($profilelink, $dataappend);
                break;
            case "Uncommon":
                $random = $threeitempool[array_rand($threeitempool)][0]['Description'];
                $award = search_key($random, $itemstore);
                $profiledecode['profile']['4pity'] = strval($profiledecode['profile']['4pity'] + 1);
                $profiledecode['profile']['5pity'] = strval($profiledecode['profile']['5pity'] + 1);
                $dataappend = json_encode($profiledecode);
                file_put_contents($profilelink, $dataappend);
                break;
            case "Rare":
                $random = $fouritempool[array_rand($fouritempool)][0]['Description'];
                $award = search_key($random, $itemstore);
                $profiledecode['profile']['4pity'] = strval($profiledecode['profile']['4pity'] + 1);
                $profiledecode['profile']['5pity'] = strval($profiledecode['profile']['5pity'] + 1);
                $dataappend = json_encode($profiledecode);
                file_put_contents($profilelink, $dataappend);
                break;
            case "Legendary":
                $random = $fiveitempool[array_rand($fiveitempool)][0]['Description'];
                $award = search_key($random, $itemstore);
                $profiledecode['profile']['4pity'] = strval($profiledecode['profile']['4pity'] + 1);
                $profiledecode['profile']['5pity'] = strval($profiledecode['profile']['5pity'] + 1);
                $dataappend = json_encode($profiledecode);
                file_put_contents($profilelink, $dataappend);
                break;
        }
        append_inventory($profilelink,$award);
        return $award;
    }
}
?>
