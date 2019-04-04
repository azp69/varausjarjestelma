<?php
session_start();
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Otsikko</title>
        <link rel="stylesheet" type="text/css" href="styles/style.css">
        <script src="scripts/menuscript.js"></script>
    </head>

    <body>
        <div id="header" class="header">
            <div id="banner" class="banner">
                <p>Mökkivaraamo</p>
            </div>

            <?php
                if ($_SESSION["luokka"] > 0)
                {
                    include("navi.php");
                }
                else
                {
                    
                }
            ?>

        </div>
        <div id="main_container" class="main_container">

            <?php
            
            if ($_SESSION["luokka"] > 0)
                {
                    echo "Sisällä<br />";
                    echo "<a href='logout.php'>Kirjaudu ulos</a>";
                }
                else
                {

            ?>

            <div id="loginscreen" class="loginscreen">
                <h2>Tervetuloa!</h2>
                Kirjaudu sisään, ole hyvä.
                <hr class="erotin" />
                <br />
                <br />
                <form action="login.php" method="post">
                    Käyttäjätunnus<br />
                    <input type="text" name="tunnus" class="textinput" /><br />
                    Salasana<br />
                    <input type="password" name="salasana" class="textinput" /><br />
                    <br />
                    <input type="submit" name="submit" value="Kirjaudu" class="button_default" />
                </form>                
            </div>

            <?php
                }
            ?>

        </div>
    </body>
</html>