<?php
    session_start();

    include_once("modules/tietokanta.php");

    if ($_POST['tunnus'] && $_POST['salasana'])
    {
        $tk = new Tietokanta;
        $passu = hash('sha256', $_POST['salasana']);
        $luokka = $tk->KirjauduSisaan($_POST['tunnus'], $passu);
        
        if ($luokka != null)
        {
            $_SESSION["luokka"] = $luokka;
            header("Location: http://varaamo.palikka.org/index.php");
        }
        else
        {
            header("Location: http://varaamo.palikka.org/index.php");
        }
    }
?>