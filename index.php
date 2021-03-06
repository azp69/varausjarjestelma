<?php
    session_start();

    include_once("modules/asiakas.php");
    include_once("modules/asiakkaat.php");
    include_once("modules/lasku.php");
    include_once("modules/lisapalaveluidenraportointiluokka.php");
    include_once("modules/majoituksenraporttiluokka.php");
    include_once("modules/palvelu.php");
    include_once('modules/perustiedot.php');
    include_once("modules/toimipiste.php");
    include_once("modules/varauksenpalvelut.php");
    include_once("modules/varaus.php");
    include_once("modules/kayttajatunnus.php");
    include_once("modules/tietokanta.php");
    
    $tk = new Tietokanta;

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
                if (isset($_SESSION["luokka"])) // Mikäli ollaan kirjauduttu sisään, näytetään valikko
                {
                    include("navi.php");
                }
                else
                {
                    
                }
            ?>
            <!-- End of ylämenu -->

        </div>
        <div id="main_container" class="main_container">
        <!-- Sisältö -->

            <?php
            if (isset($_SESSION["luokka"])) // Ollaan sisällä
                {
                    if($_GET["sivu"] != "") // Ollaan kirjauduttu ja halutaan näyttää joku alasivu
                    {
                        if (file_exists($_GET["sivu"].".php") && $_GET["sivu"] != "index" && (strpos($_GET['sivu'], "/") == false)) // Ei sallita indexiä
                        {
                            include($_GET["sivu"].".php");
                        }
                        else
                        {
                            echo "Virheellinen sivu.";
                        }
                    }
                    else
                    {
                        // todo, joku hieno welcome sivu
                        // include("welcome.php");
                        echo "<h1>Hei, " . $_SESSION["tunnus"] . "</h1>";
                        echo "<a href='logout.php'>Kirjaudu ulos</a>";
                    }
                }
                
                else // Ei olla kirjauduttu, joten näytetään login screeni
                { 
                    include("loginscreen.php");
                }
            ?>

        <!-- End of sisältö -->
        </div>
    </body>
</html>