<?php

$app_id = "875041249216770";
$app_secret = "b7f79082869d6a61a2ae4340792d324c";
$my_url = "http://ondindavid.dk/FinalProjectBitacora/facebook.php";

session_start();
$code = isset($_REQUEST['code']) ? $_REQUEST['code'] : NULL;

if(empty($code)) {
    $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
    $dialog_url = "http://www.facebook.com/dialog/oauth?client_id="
        . $app_id . "&redirect_uri=" . urlencode($my_url) . "&state="
        . $_SESSION['state'];

    echo("<script> top.location.href='" . $dialog_url . "'</script>");
}

if($_REQUEST['state'] == $_SESSION['state']) {
    $token_url = "https://graph.facebook.com/oauth/access_token?"
        . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
        . "&client_secret=" . $app_secret . "&code=" . $code;

    $response = file_get_contents($token_url);
    $params = null;
    parse_str($response, $params);

    $graph_url = "https://graph.facebook.com/me?access_token="
        . $params['access_token'];

    $user = json_decode(file_get_contents($graph_url));


    $_SESSION['user'] = $user;

    //include the database class
    require 'include/db.php';

    //create a new database object
    $db = new db();

    //execute the function declared inside the db class using the facebook user id
    $node = $db->getXmlId($_SESSION['user']->id);

    //store the result from the query
    $entry = mysqli_fetch_assoc($node);

    //check if there was something to retrieve from the database
    if($entry){

        //store the Facebook user id into a session variable
        $_SESSION['xml_id'] = $entry['xml_id'];

        //create the url to get user details for the userId = $xml_id
        $userUrl = "http://4me302-ht15.host22.com/index.php?table=User&id=".$_SESSION['xml_id'];

        //get the user role
        $xmlUser = new SimpleXMLElement(file_get_contents($userUrl));
        foreach($xmlUser ->children() as $userX){
            //store the userRole value in a session variable
            $_SESSION['userRoleId'] = (string) $userX ->Role_idRole2;
        }

        //get the name of the role
        $roleUrl = "http://4me302-ht15.host22.com/index.php?table=Role&id=".$_SESSION['userRoleId'];
        $role = new SimpleXMLElement(file_get_contents($roleUrl));
        foreach($role ->children() as $node){
            //get the name of the role
            $_SESSION['roleName'] = (string) $node ->name;
        }
    }
    else{
        echo "<br /><a href='http://ondindavid.dk/FinalProjectBitacora/logout.php'>Log out</a> <br/>";
        echo 'Welcome, ' . $_SESSION['user'] ->name. '<br /> Your id is: '. $_SESSION['user'] ->id. '<br />';
        echo 'Unfortunately, your credentials do not match in our database. You do not have access to this system.';
    }


    if(isset($_SESSION['userRoleId'])){
        header("Location: http://ondindavid.dk/FinalProjectBitacora/index.php");
    }
}
else {
    echo("The state does not match. You may be a victim of CSRF.");
}
