<?php
//These files are directly taken from https://twitteroauth.com/redirect.php
// March 2015
//
// NB Calling header so avoid output
require 'config.php';
require 'twitteroauth/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

session_start();
//twitter oauth
$request_token = [];
$request_token['oauth_token'] = $_SESSION['oauth_token'];
$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];

if (isset($_REQUEST['oauth_token']) && 
    $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
  // Abort! Something is wrong.
  // Something's missing, go back to square 1
  header('Location: twitter_login.php');    
}
//Now we make a TwitterOAuth instance with the temporary request token.
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);

//At this point we will use the temporary request token to get the long lived access_token that authorized to act as the user.
$access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier']));

// Save it in a session var
$_SESSION['access_token'] = $access_token;

$status = $_SESSION['status'];

//Now we make a TwitterOAuth instance with the users access_token
$twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

$user_info = $twitter->get('account/verify_credentials');

$username = $user_info->screen_name;

$_SESSION['username'] = $username;

$twitter->post("statuses/update", array("status" => "" . $status . " #CM0667"));

//Only for debugging :) should re-direct
header("location: bandpage.php?id=1")

?>
