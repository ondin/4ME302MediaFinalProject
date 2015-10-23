<?php

$config = dirname(__FILE__) . '/library/config.php';
require_once( "library/Hybrid/Auth.php" );
require_once("library/Hybrid/Endpoint.php");

if (isset($_REQUEST['hauth_start']) || isset($_REQUEST['hauth_done']))
{
    Hybrid_Endpoint::process();
}

try{
    $hybridauth = new Hybrid_Auth( $config );

    $twitter = $hybridauth->authenticate( "Twitter" );

    $user_profile = $twitter->getUserProfile();
    $_SESSION['twitterUserId'] = $user_profile->identifier;
    $_SESSION['twitterUserName'] = $user_profile->firstName;


    //include the database class
    require 'include/db.php';

    //create a new database object
    $db = new db();

    //execute the function declared inside the db class using the twitter user id
    $node = $db->getXmlId($_SESSION['twitterUserId']);

    //store the result from the query
    $entry = mysqli_fetch_assoc($node);

    //check if there was something to retrieve from the database
    if($entry){

        //store the twitter user id into a session variable
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
    //display the access denied message in case the user does not match the user from the database
    else{
        echo "<br /><a href='http://ondindavid.dk/FinalProjectBitacora/logout.php'>Log out</a> <br/>";
        echo 'Welcome, ' . $_SESSION['twitterUserName']. '<br /> Your id is: '. $_SESSION['twitterUserId']. '<br />';
        echo 'Unfortunately, your credentials do not match in our database. You do not have access to this system.';
    }

    if(isset($_SESSION['userRoleId'])){
        header ("Location: http://ondindavid.dk/FinalProjectBitacora/index.php");
    }
    //$twitter->setUserStatus( "Hello world!" );

    //$user_contacts = $twitter->getUserContacts();
}
catch( Exception $e ){
    //echo "Ooophs, we got an error: " . $e->getMessage();
}