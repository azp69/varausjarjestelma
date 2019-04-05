<?php
    session_start();
    include_once('modules/perustiedot.php');
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
                if ($_SESSION["luokka"] > 0) // Mikäli ollaan kirjauduttu sisään, näytetään valikko
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
            if ($_SESSION["luokka"] > 0) // Ollaan sisällä
                {
                    if($_GET["sivu"] != "") // Ollaan kirjauduttu ja halutaan näyttää joku alasivu
                    {
                        if (file_exists($_GET["sivu"].".php") && $_GET["sivu"] != "index") // Ei sallita indexiä
                        {
                            include($_GET["sivu"].".php");
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