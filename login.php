<?php
    session_start();

    include_once("modules/tietokanta.php");
    include_once("/var/www/private/salt.php");

    if ($_POST['tunnus'] && $_POST['salasana'])
    {
        $tk = new Tietokanta;
        $passu = hash('sha256', $suola . $_POST['salasana']);
        $luokka = $tk->KirjauduSisaan($_POST['tunnus'], $passu);
        

        header("Location:index.php");
    }
?>