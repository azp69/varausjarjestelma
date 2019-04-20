<?php
    if ($_GET['q'] && $_GET['p'])
    {
        include_once("modules/tietokanta.php");
        include_once("modules/palvelu.php");
        // include_once("modules/toimipiste.php");
        include_once("modules/asiakas.php");
        
        $tk = new Tietokanta;
        $palvelut = $tk->haeToimipisteeseenKuuluvatPalvelut($_GET['q'], $_GET['p']);
        
        echo "<select>\n";

        foreach ($palvelut as $palvelu)
        {
            echo "<option value='" . $palvelu->getPalveluId() . "'>". $palvelu->getNimi() . "</option>\n";
        }
        echo "</select>\n";
    }
?>