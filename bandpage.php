<?php
error_reporting(E_ERROR);
include "indiebands.php";
        $id = $_GET['id'];
        session_start();
        $_SESSION['id'] = $id;

    if (!isset($_SESSION['username'])){
        include "twitter_login.php";
    }

    if (isset($_POST['submit']) && isset($_SESSION['username'])){
        $_SESSION['status'] = $_POST['status'];
        include "posttweets.php";
        $status = $_SESSION['status'];
        include "twitter_login.php";
    }

    include "bandgigs.php";
    include "calculatedistance.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tip Top Music Assignment</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/app.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/app.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCS3yZMHAmGq6sWoEnXLC6KOtUXKvvzHiE&sensor=false"></script>


</head>
<body>
<div id="main">
    <div id="header">
        <div class="left">
            <div class="logo">
                <h1>TipTop Music</h1>
            </div>
            <a id="fb-logout" href="#" onclick="logout()">Logout</a>
            <fb:login-button
                scope="public_profile,email,user_posts"
                onlogin="checkLoginState();"
                id="fb-button">
            </fb:login-button>
        </div>
        <div class="right">
            <div class="navlinks">
                <a href="index.html">home</a>
                <a class="active" href="ourmusic.php">our music</a>
                <a href="analysis.html">analysis</a>
            </div>
        </div>
    </div>
    <?php
        if (!$error) {
            $bands = json_decode($result); /* Turn JSON into PHP Object */
            $_SESSION['searchTerm'] = $bands[$id-1]->BandName;
            if ($id === "1") {
                echo "<div id=\"band-image-container1\">
                        <h1 class='band-title'>" . $bands[$id-1]->BandName. "</h1>
                     </div>";
            } else if ($id === "2") {
                echo "<div id=\"band-image-container2\">
                        <h1 class='band-title'>" . $bands[$id-1]->BandName. "</h1>
                     </div>";
            } else if ($id === "3") {
                echo "<div id=\"band-image-container3\">
                        <h1 class='band-title'>" . $bands[$id-1]->BandName. "</h1>
                     </div>";
            } else {
                echo "<div id=\"band-image-container4\">
                        <h1 class='band-title'>" . $bands[$id-1]->BandName. "</h1>
                     </div>";
            }
        }
    ?>
    <div id="tweet-wrapper">
        <div id="tweetscontainer">
            <div id="tweet-heading">
                <h1>Band Related Tweets</h1>
                <input type="button" id="refresh-tweets" value="Refresh"/>
            </div>

            <div id="tweet-list">
            </div>
        </div>
        <div id="post-tweet-container">
            <div id="post-tweet-title">
                <h1>Post a Tweet</h1>
            </div>
            <div id="post-tweet-form">

                <?php
                if (isset($_SESSION['access_token'])) {
                    echo "<form id=\"\" action=\"\" method=\"POST\">
                    <textarea type=\"text\" id=\"tweetinput\" name=\"status\"></textarea>
                    <br/><br/>
                    <input id=\"tweet-submit\" type=\"submit\" name=\"submit\"/>
                    </form>";
                } else {
                    echo "<form action=\"twitter_login.php\" method=\"POST\">
                    <textarea type=\"text\" id=\"tweetinput\" name=\"status\"></textarea>
                    <br/><br/>
                    <input id=\"tweet-submit\" type=\"submit\" name=\"submit\"/>
                    </form>";
                }
                ?>

            </div>

        </div>
    </div>
    <div id="google-wrapper">
        <div id="google-wrapper-left">
            <script>
                function initialize()
                {
                    var map;
                    var myCenter = new google.maps.LatLng(54.974606, -1.604476);

                    var mapProp = {
                        center: myCenter,
                        zoom: 6
                    };

                    map = new google.maps.Map(document.getElementById("google-wrapper-left"), mapProp);

                    var icons = {
                        user: {
                            icon: './images/home.png'
                        },
                        gig: {
                            icon: './images/gig.png'
                        }
                    };

                    <?php
                        include "bandgigs.php";
                        $gig_object = json_decode($result2); /* Turn JSON into PHP Object */
                        $i = 0;
                        $len = count($gig_object);

                        echo "var features = [";
                        echo "{";
                        echo "position: new google.maps.LatLng(54.974606, -1.604476),";
                        echo "type: 'user'";
                        echo "},";
                        foreach ($gig_object as $gigs) {
                            $convertedAddress = convertLat($gigs->Address, $gigs->Postcode).",".convertLong($gigs->Address, $gigs->Postcode);
                            if ($i === $len - 1){
                                echo "{";
                                echo "position: new google.maps.LatLng(" . $convertedAddress .  "),";
                                echo "type: 'gig'";
                                echo "}";
                            } else {
                                echo "{";
                                echo "position: new google.maps.LatLng(" . $convertedAddress .  "),";
                                echo "type: 'gig'";
                                echo "},";
                            }
                            $i++;
                        }
                        echo "];";
                    ?>

                    var infowindow = new google.maps.InfoWindow();
                    //create markers
                    features.forEach(function(feature) {
                        <?php
                            echo "var contentString = '" . $gigs->Location .  "';";
                        ?>
                        var marker = new google.maps.Marker({
                            position: feature.position,
                            icon: icons[feature.type].icon,
                            map: map
                        });
                        google.maps.event.addListener(marker,'click', (function(marker,contentString,infowindow){
                            return function()
                            {
                                infowindow.setContent(contentString);
                                infowindow.open(map,marker);
                            };
                        })(marker, contentString ,infowindow));
                    });
                    marker.setMap(map);
                }
                //add an eventlistener to the dom to call the initialize function when the window is loaded
                google.maps.event.addDomListener(window, 'load', initialize);

            </script>
        </div>
        <div id="google-wrapper-right">
            <div
            <?php


                $originAddress = "54.974606,-1.604476";
                $gig_object = json_decode($result2); /* Turn JSON into PHP Object */
                foreach ($gig_object as $gigs) {
                    $convertedAddress = convertLat($gigs->Address, $gigs->Postcode).",".convertLong($gigs->Address, $gigs->Postcode);
                    $distance = calculateDistance($originAddress, $convertedAddress);

                    echo "<div class='giglocation'>";
                        echo "<h3>" . $gigs->Location . "</h3><br/>";
                        echo "<p>" . $gigs->Address . "</p>";
                        echo "<p>" . $gigs->Postcode . "</p><br/>";
                        echo "<p>" . date("jS F Y", strtotime($gigs->GigDate)) . "</p>";
                        echo "<p class='distanceevent'>Distance from your location: <br/> " . $distance . "</p>";
                    echo "</div>";
                }
            ?>
        </div>
    </div>
    <div id="facebook-wrapper">
        <div id="facebook-heading">
            <h3>Log in to view Facebook Social Graph Information</h3>
        </div>

        <div id="facebook-container">
        </div>
        <div id="fb-feed"></div>
    </div>
</div>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '322128904871539',
                cookie     : true,
                xfbml      : true,
                version    : 'v2.8'
            });
            FB.getLoginStatus(function(response) {
                statusChangeCallback(response);
            });
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        function statusChangeCallback(response)
        {
            if (response.status === 'connected'){
                console.log('logged in and authenticated');
                setElements(true);
                testAPI();
            } else {
                console.log('not authenticated');
                setElements(false);

            }
        }

        function checkLoginState() {
            FB.getLoginStatus(function(response) {
                statusChangeCallback(response);
            });
        }

        function testAPI(){
            FB.api('/<?php
                //include "indiebands.php";
                $bands = json_decode($result);
                $name = $bands[$id-1]->BandName;
                $name = str_replace(' ', '', $name);
                $name = strtolower($name);
                if ($name === 'thekooks'){
                    echo $name.'official';
                } else {
                    echo $name;
                }
                ?>?fields=name,fan_count,picture', function(response){
                if(response && !response.error){
                    //console.log(response);
                    retrieveArtistDetails(response);
                }

                FB.api('/<?php
                    //include "indiebands.php";
                    $bands = json_decode($result);
                    $name = $bands[$id-1]->BandName;
                    $name = str_replace(' ', '', $name);
                    $name = strtolower($name);
                    if ($name === 'thekooks'){
                        echo $name.'official';
                    } else {
                        echo $name;
                    }
                    ?>/posts', function(response) {
                    if(response && !response.error){
                        //console.log(response);
                        buildFeed(response);
                    }
                    });
                });
            }


        //adds commas to a large number
        function addCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function retrieveArtistDetails(artist){
            var profile = `
                <h1>Facebook Information</h1>
                <h3>${artist.name}</h3>
                <img src='http://graph.facebook.com/${artist.id}/picture?type=large'/>
                Likes: ${addCommas(artist.fan_count)}
                `;

            document.getElementById('facebook-container').innerHTML=profile;

        }

        function buildFeed(feed){
            var output = '<h3>Latest posts</h3>';
            for (var i=0; i < 6; i++){
                if (feed.data[i].message){
                    output += `
                    <div class='post'>
                    <br>
                        ${feed.data[i].message}
                    <br>
                        <hr>

                    </div>
                    `;
                }
            }
            document.getElementById('fb-feed').innerHTML = output;
            console.log(output);
        }

        function setElements(isLoggedIn){
            if(isLoggedIn){
                document.getElementById('facebook-container').style.display = 'flex';
                document.getElementById('fb-button').style.display = 'none';
                document.getElementById('fb-logout').style.display = 'block';
                document.getElementById('fb-feed').style.display = 'flex';
                document.getElementById('facebook-heading').style.display = 'none';

            } else{
                document.getElementById('facebook-container').style.display = 'none';
                document.getElementById('fb-button').style.display = 'block';
                document.getElementById('fb-logout').style.display = 'none';
                document.getElementById('facebook-heading').style.display = 'block';
                document.getElementById('fb-feed').style.display = 'none';
            }
        }

        function logout(){
            FB.logout(function(response){
                setElements(false);
            });
        }
    </script>

</body>
</html>
