<?php
session_start();
header('Content-type: application/json');
require "twitteroauth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;
$consumer_key = "mGBhomwo07BXDJRyD0wRuaOgm";
$consumerkey_secret = "3AOIM4HyBEsLWf9Oz5NDgNQb8hWvr835OoOHtiqOP5XpswVW49";
$accessToken = "94911925-YiGVw7welWGk1mb1GXdlrfbodnBTOuRjKS0xwE7a9";
$accessTokenSecret = "w04N23QkbOVJXckDyfJTJCsEIvY9808woI4eJplfttQbA";

$connection = new TwitterOAuth($consumer_key, $consumerkey_secret, $accessToken, $accessTokenSecret);

$content = $connection->get("account/verify_credentials");
$bandname = $_SESSION['searchTerm'];
$statuses = $connection->get("search/tweets", array("q" => "\"$bandname\" filter:safe")); //the quotes make sure the search finds tweets containing the exact phrase. Potentially sensitive tweets are removed.

$user_timeline = $connection->get('statuses/user_timeline');

echo(json_encode($statuses, JSON_PRETTY_PRINT));

