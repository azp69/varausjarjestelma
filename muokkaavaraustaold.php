<?php
    
    include_once("modules/palvelu.php");
    include_once("modules/tietokanta.php");
    // include_once("modules/toimipiste.php");

    if (isset($_GET['varausid']))
    {
        $tk = new Tietokanta;
        $palvelut = array();
        $palvelut = $tk->HaeVaraukseenKuuluvatPalvelut($_GET['varausid']);
        
        foreach ($palvelut as $palvelu)
        {
            echo $palvelu->getNimi();
            echo $palvelu->getKuvaus();
            echo $palvelu->getHinta();
            echo $palvelu->getAlv();
        }
    }
?>

<script src="scripts/varaus.js">
</script>
