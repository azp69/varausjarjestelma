<?php
    include_once("modules/tietokanta.php");
    $tk = new Tietokanta;

    if ($_GET['a'] && $_GET['l'] && $_GET['palveluid'])
    {
        $onkoVarausta = $tk->OnkoVaraustaAjalla($_GET['palveluid'], $_GET['a'], $_GET['l']);
        if ($onkoVarausta === true)
        {
            echo "varattu"; // Varattu
        }
        else
        {
            echo "vapaa";
        }
    }
?>