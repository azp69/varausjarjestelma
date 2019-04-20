<?php
    if ($_GET['q'] && $_GET['p'])
    {
        include_once("modules/tietokanta.php");
        include_once("modules/palvelu.php");
        include_once("modules/asiakas.php");
        
        $tk = new Tietokanta;
        $palvelut = $tk->haeToimipisteeseenKuuluvatPalvelut($_GET['q'], $_GET['p']);

        if ($_GET['p'] == 1) // majoitus
        {
            echo "<select id='majoitus' onclick='haeKalenteri();'>\n";
         
            foreach ($palvelut as $palvelu)
            {
                echo "<option value='" . $palvelu->getPalveluId() . "'>" . $palvelu->getNimi() . "</option>\n";
            }
            
            echo "</select>\n";
        }

        else // lisäpalvelut
        {
            foreach ($palvelut as $palvelu)
            {
                echo "<input type='checkbox' name='lisapalvelu' value='"  . $palvelu->getPalveluId() . "'/>" . $palvelu->getNimi() . "<br />\n";
            }
        }

        
    }
?>