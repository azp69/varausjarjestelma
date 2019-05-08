<?php
session_start();
if (!isset($_SESSION["luokka"]))
{
    die("Kirjaudu sisään.");
}
?>

<?php
    include_once("modules/tietokanta.php");
    include_once("modules/palvelu.php");
    include_once("modules/asiakas.php");
    include_once("modules/varauksenpalvelut.php");
    
    if ($_GET['q'] && $_GET['p'] && $_GET['varausid'])
    {
        $tk = new Tietokanta;
        $palvelut = $tk->haeToimipisteeseenKuuluvatPalvelut($_GET['q'], $_GET['p']);
        $varausid = $_GET['varausid'];
        $varauksenpalvelut = array();
        $varauksenpalvelut = $tk->HaeVaraukseenKuuluvatPalvelut($varausid);

        foreach ($palvelut as $palvelu)
        {
            echo "<input type='hidden' name='lisapalveluid[]' value='"  . $palvelu->getPalveluId() . "'/>\n";
            echo "<li>" . $palvelu->getNimi() . "<input type='text' maxlength=2 class='textinput' style='width:4em' name='lisapalvelu" . $palvelu->getPalveluId() . "' value='" . palvelunLukumaara($varauksenpalvelut, $palvelu->getPalveluId()) ."' /> kpl</li>\n";
        }
        
    }

    else if ($_GET['q'] && $_GET['p'])
    {
        $tk = new Tietokanta;
        $palvelut = $tk->haeToimipisteeseenKuuluvatPalvelut($_GET['q'], $_GET['p']);

        if ($_GET['p'] == 1) // 1 = majoitus, 2 = muu palvelu
        {
            echo "<select name='majoitusid' id='majoitusid' class='dropdownmenu' onchange='haeKalenteri();'>\n";
            echo "<option value='' disabled selected>Valitse majoitus</option>\n";
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
    
    function palvelunLukumaara($varauksenpalvelut, $palveluid)
    {
        foreach($varauksenpalvelut as $p)
        {
            $palvelu = $p->getPalveluId();
            if ($palvelu->getPalveluId() == $palveluid)
                return $p->getLkm();
        }
    }
?>