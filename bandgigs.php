<?php
$curl = curl_init();

$bandURL  ="http://unn-izje1.newnumyspace.co.uk/CM0677/indiejson.php?BandEvents=". $_SESSION['id'] . "";
curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($curl, CURLOPT_HEADER, false);
//curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($curl, CURLOPT_URL, $bandURL);

$result2 = curl_exec($curl);

$error = false;

// Check if any error occurred
if(curl_errno($curl))
{
    echo 'Curl error: ' . curl_error($curl);
    $error = true;
}
curl_close($curl);
