<?php
    if ($_GET['q'])
    {
        include_once("modules/tietokanta.php");
        // include_once("modules/palvelu.php");
        // include_once("modules/toimipiste.php");
        include_once("modules/asiakas.php");
        
        $tk = new Tietokanta;
        $asiakkaat = $tk->HaeAsiakkaat($_GET['q']);

        echo "<select id='asiakas'>\n";

        foreach ($asiakkaat as $asiakas)
        {
            echo "<option value='" . $asiakas->getAsiakasId() . "'>". $asiakas->getSukunimi() . " " . $asiakas->getEtunimi() ."</option>\n";
        }
        echo "</select>\n";
    }
?>