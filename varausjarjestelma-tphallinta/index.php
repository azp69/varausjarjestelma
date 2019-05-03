<?php
    session_start();
    include_once('modules/perustiedot.php');
    include_once("modules/toimipiste.php");
    include_once("modules/palvelu.php");
    include_once("modules/tietokanta.php");
    include_once("modules/majoituksenraporttiluokka.php");
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>
            <?php
                echo $sivuston_nimi;
            ?>
        </title>
        <link rel="stylesheet" type="text/css" href="styles/style.css">
        <link rel="stylesheet" type="text/css" href="styles/muokkaa_lisaa_tp.css">
        <script src="scripts/menuscript.js"></script>
    </head>

    <body>
        <div id="header" class="header">
            <div id="banner" class="banner">
                <p>
                    <?php
                        echo $sivuston_nimi;
                    ?>
            </p>
            </div>

            <!-- Ylämenu -->
            <?php

                include("navi.php");

            ?>
            <!-- End of ylämenu -->

        </div>
        <div id="main_container" class="main_container">
        <!-- Sisältö -->

            <?php
                $tk = new Tietokanta;
                if($_GET["sivu"] != "") // Ollaan kirjauduttu ja halutaan näyttää joku alasivu
                {
                    if (file_exists($_GET["sivu"].".php") && $_GET["sivu"] != "index") // Ei sallita indexiä
                    {
                        include($_GET["sivu"].".php");
                    }
                }
                else // Ei olla kirjauduttu, joten näytetään login screeni
                { 
                    echo "hei";
                }
            ?>

        <!-- End of sisältö -->
        </div>
    </body>
</html>