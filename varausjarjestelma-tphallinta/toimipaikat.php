<?php
session_start();
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Otsikko</title>
        <link rel="stylesheet" type="text/css" href="styles/style.css">
        <link rel="stylesheet" type="text/css" href="styles/muokkaa_lisaa_tp.css">
        <script src="scripts/menuscript.js"></script>
    </head>

    <body>
        <div id="header" class="header">
            <div id="banner" class="banner">
                <p>Mökkivaraamo</p>
            </div>

            <?php
                include("navi.php");
            ?>
        </div>
        
        <?php
        include_once("modules/tietokanta.php");
        $tk = new Tietokanta;

        if($_GET["sivu"] != "") // Ollaan kirjauduttu ja halutaan näyttää joku alasivu 
        {
            if (file_exists($_GET["sivu"].".php") && $_GET["sivu"] != "index") // Ei sallita indexiä
            {
                include($_GET["sivu"].".php");
            }
        } else {
            
            $toimipaikat = array();
            $toimipaikat = $tk->HaeToimipaikat();

            if ($toimipaikat == null) {
                echo "Ei hakutuloksia";
            } else { ?> 

        <div class="listaus">

            <?php

                foreach ($toimipaikat as &$toimipaikka){
                    
                    echo "<div class='keskita'> <a href='toimipaikat.php?sivu=tiedot&id=" . $toimipaikka->getToimipisteId() . "'>" . $toimipaikka->getNimi() . "</a></div>";
                }
            }
        }
        ?>
        </div>
            
    </body>
    
</html>