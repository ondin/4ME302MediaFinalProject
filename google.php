<?php
/*
 * Copyright 2011 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
session_start();

require_once realpath(dirname(__FILE__) . '/src/Google/autoload.php');

/************************************************
ATTENTION: Fill in these values! Make sure
the redirect URI is to this page, e.g:
http://localhost:8080/user-example.php
 ************************************************/
$client_id = '19335729464-mu1k7590g0ukcbeb7nnai45erklsb1d0.apps.googleusercontent.com';
$client_secret = '5qWt2Lj2ojNheZnKCPFg8q-1';
$redirect_uri = 'http://ondindavid.dk/FinalProjectBitacora/google.php';

/************************************************
Make an API request on behalf of a user. In
this case we need to have a valid OAuth 2.0
token for the user, so we need to send them
through a login flow. To do this we need some
information from our API console project.
 ************************************************/
$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("https://www.googleapis.com/auth/urlshortener");
$client->setScopes(array('https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/userinfo.profile'));

/************************************************
When we create the service here, we pass the
client to it. The client then queries the service
for the required scopes, and uses that when
generating the authentication URL later.
 ************************************************/
$service = new Google_Service_Urlshortener($client);
$user = new Google_Service_Oauth2($client);

/************************************************
If we're logging out we just need to clear our
local access token in this case
 ************************************************/
if (isset($_REQUEST['logout'])) {
    unset($_SESSION['access_token']);
}

/************************************************
If we have a code back from the OAuth 2.0 flow,
we need to exchange that with the authenticate()
function. We store the resultant access token
bundle in the session, and redirect to index.
 ************************************************/
if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();

    //store the user name and user id in session variables
    $_SESSION['googleName'] = (string) $user ->userinfo ->get()->getName();
    $_SESSION['googleUserId'] = (string) $user ->userinfo ->get()->getId();




    //just like facebook and twitter, here should be the place to do a database call for the google id
    //however, the google id is too large and need special treatment (google ID exceeds BIGINT value)
    //the small table containing the facebook, twitter and xml IDs wil not contain the google ID
    //for test purposes. whenever the Google service is used for login, I will use 3 different accounts
    // one for driver, one for analyst and one for director.

    $xml_id = 1; //CTO
    $_SESSION['xml_id'] = $xml_id;

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


    //create a redirect link and redirect to index
    $redirect = 'http://ondindavid.dk/FinalProjectBitacora/index.php';
    header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

/************************************************
If we have an access token, we can make
requests, else we generate an authentication URL.
 ************************************************/
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
} else {
    echo  "<a class='login' href='" .$authUrl = $client->createAuthUrl() . "'>Log in using Google</a>";
}

if (strpos($client_id, "googleusercontent") == false) {
    echo missingClientSecretsWarning();
    exit;
}


