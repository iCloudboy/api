<?php

function convertLat($address, $postcode){
    $address = urlencode($address);
    $postcode = urlencode($postcode);
    $geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$address.',' . $postcode . '&sensor=false&key=AIzaSyCS3yZMHAmGq6sWoEnXLC6KOtUXKvvzHiE');
    $output= json_decode($geocode);
    $latitude = $output->results[0]->geometry->location->lat;
    return $latitude;
}
function convertLong($address, $postcode){
    $address = urlencode($address);
    $postcode = urlencode($postcode);
    $geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$address.',' . $postcode . '&sensor=false&key=AIzaSyCS3yZMHAmGq6sWoEnXLC6KOtUXKvvzHiE');
    $output= json_decode($geocode);
    $longitude = $output->results[0]->geometry->location->lng;
    return $longitude;
}
function calculateDistance ($originAddress, $destinationAddress){
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=". $originAddress . "&destinations=" . $destinationAddress . "&key=AIzaSyCS3yZMHAmGq6sWoEnXLC6KOtUXKvvzHiE";
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_PROXYPORT, 3128);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($curl);
    curl_close($curl);

    $response_a = json_decode($response, true);
    return $response_a['rows'][0]['elements'][0]['distance']['text'];
    //$distance = $response_a['rows'][0]['elements'][0]['distance'['text']];
}

