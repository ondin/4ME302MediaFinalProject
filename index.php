<?php
require 'include/db.php';
session_start();
?>
<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title> Final Project</title>
    <link type="text/css" href="css/css.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
    <script src="http://dimplejs.org/dist/dimple.v2.1.0.min.js"></script>
    <script src="http://colineberhardt.github.io/d3fc/Layout.js"></script>
    <script src="https://github.com/ScottLogic/d3fc/releases/download/v0.4.0/d3fc.min.js"></script>
    <link href="http://colineberhardt.github.io/d3fc/d3fc.css" rel="stylesheet"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script type="text/javascript" src="js/ajax.js"></script>
</head>
<body>
<?php
if(!isset($_SESSION['user'])&&(!isset($_SESSION['googleUserId']))&&(!isset($_SESSION['twitterUserId']))):
?>
Login with the following services:
<br />
<a href="http://ondindavid.dk/FinalProjectBitacora/facebook.php"> Facebook </a><br />
<a href="http://ondindavid.dk/FinalProjectBitacora/google.php"> Google </a> <br />
<a href="http://ondindavid.dk/FinalProjectBitacora/twitter.php"> Twitter </a> <br />
<?php
endif;
?>
<?php
if(isset($_SESSION['user'])){
    echo "<br /><a href='http://ondindavid.dk/FinalProjectBitacora/logout.php'>Log out</a> <br/>";
    echo 'Welcome, ' . $_SESSION['user'] -> name . '<br /> Your id is: '. $_SESSION['user']->id . '<br />';
    echo 'You are logged in as ' .$_SESSION['roleName'] . "<br />";

    require 'content.php';
}
elseif(isset($_SESSION['googleUserId'])){
    echo "<br /><a href='http://ondindavid.dk/FinalProjectBitacora/logout.php'>Log out</a> <br/>";
    echo 'Welcome, ' . $_SESSION['googleName']. '<br /> Your id is: '. $_SESSION['googleUserId']. '<br />';
    echo 'You are logged in as ' .$_SESSION['roleName'] . "<br />";

    require 'content.php';
}
elseif(isset($_SESSION['userRoleId'])){
    echo "<br /><a href='http://ondindavid.dk/FinalProjectBitacora/logout.php'>Log out</a> <br/>";
    echo 'Welcome, ' . $_SESSION['twitterUserName']. '<br /> Your id is: '. $_SESSION['twitterUserId']. '<br />';
    echo 'You are logged in as ' .$_SESSION['roleName'] . "<br />";

    require 'content.php';
}
?>
</body>
</html>