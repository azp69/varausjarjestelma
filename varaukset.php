<?php

    include_once("modules/tietokanta.php");
    include_once("modules/palvelu.php");
    include_once("modules/toimipiste.php");

    $tk = new Tietokanta;

    if ($_GET['toimipiste'] == "")
    {
        $toimipisteet = array();

        $toimipisteet = $tk->HaeToimipisteet();
    
        ?>
        <h2>Valitse toimipiste</h2>
    
        <?php
        foreach ($toimipisteet as $tp)
        {
            echo "<a href='?sivu=varaukset&toimipiste=" . $tp->getToimipisteId() . "'>" . $tp->getNimi() . "</a><br />";
        }

    }

    else if ($_GET['toimipiste'] && $_GET['palveluid'])
    {

        ?>
        <script>
            const varaus = {
                alkupaiva: '',
                loppupaiva: ''
            }

            var varaukset = [];
            var v;
        
        <?php

        $varauskalenteri = $tk->HaePalvelunVarauskalenteri($_GET['palveluid']);
        
        foreach ($varauskalenteri as $varaus)
        {
            echo "v = Object.create(varaus);\n";
            echo "v.alkupaiva = '" . $varaus["varauksen_aloituspvm"] . ";'\n";
            echo "v.loppupaiva = '" . $varaus["varauksen_lopetuspvm"] . ";'\n";
            echo "varaukset.push(v);\n";
        }
        echo "</script>\n";

        include('kalenteri.php');
    }
    
    else
    {
        ?>
        <h2>Valitse majoitus</h2>
        <?php

        $palvelunTyyppi = 1;
        $palvelut = array();
        $palvelut = $tk->haeToimipisteeseenKuuluvatPalvelut($_GET['toimipiste'], $palvelunTyyppi);

        foreach ($palvelut as $palvelu)
        {
            echo "<a href='?sivu=varaukset&toimipiste=" . $_GET['toimipiste'] . "&palveluid=" . $palvelu->getPalveluId() . "'> " . $palvelu->getNimi() . "</a><br />";
        }
        
    }

    

    /*
    $palvelut = $tk->ListaaPalvelut($toimipisteid);
    $asiakkaat = $tk->ListaaAsiakkaat();
    

    foreach ($palvelut as $rivi)
    {
        $palvelu_id = $rivi["palvelu_id"];
        $toimipiste_id = $rivi["toimipiste_id"];
        $nimi = $rivi["nimi"];
        $tyyppi = $rivi["tyyppi"];
        $kuvaus = $rivi["kuvaus"];
        $hinta = $rivi["hinta"];
        $alv = $rivi["alv"];

        echo "Palveluid: " . $palvelu_id . "<br />Toimipisteid: " . $toimipiste_id . "<br />Nimi:  " . $nimi  ."<br />";
        
    }
    */

?>

