<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tip Top Music Assignment</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/app.css" />
</head>
<body>
<div id="main">
    <div id="header">
        <div class="left">
            <div class="logo">
                <h1>TipTop Music</h1>
            </div>
            <input type="input" placeholder="Search our site">
        </div>
        <div class="right">
            <div class="navlinks">
                <a href="index.html">home</a>
                <a href="about.html">about</a>
                <a href="ourmusic.php">our music</a>
                <a class="active" href="analysis.html">analysis</a>
            </div>
        </div>

    </div>
    <div id="contentwrapper">
        <div class="content">
            <h1>Our Bands</h1>

            <div id="band-wrapper">
                <?php
                    include "indiebands.php";

                if (!$error) {
                    $band_object = json_decode($result); /* Turn JSON into PHP Object */

                    /* Formatted output */

                    foreach ($band_object as $bands) {
                        $id = $bands->ID;


                        if ($id === "1") {
                            echo "<div id='band-container1'>";
                            echo "<div class='name-container'>";
                            echo "<h1>" . $bands->BandName . "</h1>"; /* Get fields from object */
                            echo "</div>";
                            echo "<div class='link-container'>";
                            echo "<a href='bandpage.php?id=" . $id . "'>Visit band page >></a>"; /* Get fields from object */
                            echo "</div>";
                            //echo "<p>ID: " . $bands->ID . "</p>";
                            echo "</div>";
                        } else if ($id === "2") {
                            echo "<div id='band-container2'>";
                            echo "<div class='name-container'>";
                            echo "<h1>" . $bands->BandName . "</h1>"; /* Get fields from object */
                            echo "</div>";
                            echo "<div class='link-container'>";
                            echo "<a href='bandpage.php?id=" . $id . "'>Visit band page >></a>"; /* Get fields from object */
                            echo "</div>";

                            //echo "<p>ID: " . $bands->ID . "</p>";
                            echo "</div>";
                        } else if ($id === "3") {
                            echo "<div id='band-container3'>";
                            echo "<div class='name-container'>";
                            echo "<h1>" . $bands->BandName . "</h1>"; /* Get fields from object */
                            echo "</div>";
                            echo "<div class='link-container'>";
                            echo "<a href='bandpage.php?id=" . $id . "'>Visit band page >></a>"; /* Get fields from object */
                            echo "</div>";
                            //echo "<p>ID: " . $bands->ID . "</p>";
                            echo "</div>";
                        } else {
                            echo "<div id='band-container4'>";
                            echo "<div class='name-container'>";
                            echo "<h1>" . $bands->BandName . "</h1>"; /* Get fields from object */
                            echo "</div>";
                            echo "<div class='link-container'>";
                            echo "<a href='bandpage.php?id=" . $id . "'>Visit band page >></a>"; /* Get fields from object */
                            echo "</div>";
                            //echo "<p>ID: " . $bands->ID . "</p>";
                            echo "</div>";
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
