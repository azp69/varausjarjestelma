<?php
    if ($_GET['q'] && $_GET['p'])
    {
        include_once("modules/tietokanta.php");
        include_once("modules/palvelu.php");
        include_once("modules/asiakas.php");
        
        $tk = new Tietokanta;
        $palvelut = $tk->haeToimipisteeseenKuuluvatPalvelut($_GET['q'], $_GET['p']);

        if ($_GET['p'] == 1) // 1 = majoitus, 2 = muu palvelu
        {
            echo "<select name='majoitusid' id='majoitus' class='dropdownmenu' onclick='haeKalenteri();'>\n";
         
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
                echo "<input type='hidden' name='lisapalveluid[]' value='"  . $palvelu->getPalveluId() . "'/>\n";
                echo "<li>" . $palvelu->getNimi() . "<input type='text' maxlength=2 class='textinput' style='width:4em' name='lisapalvelu" . $palvelu->getPalveluId() . "'/> kpl</li>\n";
                //echo "<input type='checkbox' name='lisapalveluid[]' value='"  . $palvelu->getPalveluId() . "'/>" . $palvelu->getNimi() . "<br />\n";
            }
        }

        
    }
?>