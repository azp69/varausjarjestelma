<?php

    include_once("modules/tietokanta.php");
    $tk = new Tietokanta;

    $palvelut = $tk->ListaaPalvelut();

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
?>