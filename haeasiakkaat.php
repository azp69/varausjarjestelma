<?php
    if ($_GET['q'])
    {
        include_once("modules/tietokanta.php");
        // include_once("modules/palvelu.php");
        // include_once("modules/toimipiste.php");
        include_once("modules/asiakas.php");
        
        $tk = new Tietokanta;
        $asiakkaat = $tk->HaeAsiakkaatHakusanalla($_GET['q']);
        
        if ($asiakkaat != null)
        {
            echo "<select name='asiakasid' class='dropdownmenu'>\n";

            foreach ($asiakkaat as $asiakas)
            {
                echo "<option value='" . $asiakas->getAsiakasId() . "'>". $asiakas->getSukunimi() . " " . $asiakas->getEtunimi() ."</option>\n";
            }
            echo "</select>\n";
        }
    }
?>