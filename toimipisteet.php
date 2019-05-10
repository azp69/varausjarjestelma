<?php
session_start();
if (!isset($_SESSION["luokka"]))
{
    die("Kirjaudu sisään.");
}
    // haetaan toimipisteet tietokannasta
    $tk = new Tietokanta;
    $toimipisteet = array();
    $toimipisteet = $tk->haeKaikkiToimipisteet();
?> 

<div style="text-align: center; width: 100%;">
    <h2>Hae toimipisteistä</h2>

    <input type="text" class="textinput" name="haku" value="" onkeyup="haeToimipisteista(this.value)" />

    <h2>Toimipisteen valinta</h2>
</div>
<div class="listaus" id="listaus">
    <?php
        foreach ($toimipisteet as &$toimipiste){   
            echo "<div class='keskita'> <a href='index.php?sivu=toimipisteentiedot&id=" . $toimipiste->getToimipisteId() . "'>" . $toimipiste->getNimi() . "</a></div>\n";
        }
    ?>
</div>
<script src="scripts/haeToimipisteet.js"></script>