<?php
// jos on painettu tallenna, luodaan uusi Palvelu-olio ja haetaan tiedot formilta
if (isset($_POST['SubmitButton'])) {

    $palvelu = new Palvelu("", "", "", "", "", "", "");

    $palvelu->setToimipisteId($_POST["toimipiste_id"]);
    $palvelu->setNimi($_POST["nimi"]);
    $palvelu->setTyyppi($_POST["tyyppi"]);
    $palvelu->setKuvaus($_POST["kuvaus"]);
    $palvelu->setHinta($_POST["hinta"]);
    $palvelu->setAlv($_POST["alv"]);
    
    if ($_POST['id'] != 0) { 
        $palvelu->setPalveluId($_POST["id"]);
        $message = $tk->PaivitaPalvelu($palvelu);
    } else {
        $palvelu->setPalveluId($_POST["id"]);
        $message = $tk->lisaaPalvelu($palvelu);
    }
// jos id = 0, luodaan uusi Palvelu-olio
} else if ($_GET['id'] == 0) {
    $toimipisteet = $tk->haeKaikkiToimipisteet();
    $palvelu = new Palvelu("", $_GET['tid'], "", "", "", "", "");
// jos id on jotain muuta kuin 0 niin haetaan palvelun tiedot tietokannasta
} else {
    $toimipisteet = $tk->haeKaikkiToimipisteet();
    $palvelu = $tk->haePalvelu($_GET['id']);
}


?>

<div class="form-container">
    <h1>Palvelun tiedot</h1>
    <?php 
        // jos on painettu tallenna, ilmoitetaan käyttäjälle onnistuiko tietojen tallentaminen tietokantaan
        if (isset($_POST['SubmitButton'])) {
            if ($palvelu->getPalveluId() != "") {
                echo "<p>" . $message . "</p><br><p><a href='index.php?sivu=palveluntiedot&id=" . $palvelu->getPalveluId() . "'>Palaa</a></p>";
            } else {
                echo "<p>" . $message . "</p><br><p><a href='index.php?sivu=toimipisteentiedot&id=" . $palvelu->getToimipisteId() . "'>Palaa</a></p>";
            }
        // jos palvelu löytyy tietokannasta, tai luodaan uusi palvelu (on luotu uusi olio), näytetään formi jossa voi asettaa palvelun tiedot
        } else if ($palvelu != null) {
    ?>

        <form action="" method="post" id="palveluform" onsubmit="return validateSubmit();">

            <div class="grid-container-palvelut">
                <p id="p-nimi">Nimi</p>
                <input type="hidden" name="id" value=<?php echo "'" . $palvelu->getPalveluId() . "'" ?>>
                <input type="text" name="nimi" class="textinput" id="textinput-nimi" value=<?php echo "'" . $palvelu->getNimi() . "'" ?>>
                <p id="p-hinta">Hinta</p>
                <input type="text" name="hinta" class="textinput" id="textinput-hinta" value=<?php echo "'" . $palvelu->getHinta() . "'" ?>>
                <p id="p-toimipiste">Toimipiste</p>
                <select name="toimipiste_id" id="select-toimipiste" form="palveluform">
                    <?php // lisätään toimipisteet pudotusvalikkoon, josta käyttäjä voi valita palvelun toimipisteen
                        foreach ($toimipisteet as &$tp) {
                            $tp_id = $tp->getToimipisteId();
                            $tp_nimi = $tp->getNimi();
                    ?>
                        <option value='<?php echo $tp_id ?>' <?php if($palvelu->getToimipisteId() == $tp_id) echo "selected='true'";?>><?php echo $tp_nimi ?></option>
                    <?php 
                        }
                    ?>
                </select>
                <p id="p-tyyppi">Tyyppi</p>
                <!-- palvelutyypin valinta pudotusvalikkona -->
                <select name="tyyppi" id="select-tyyppi" form="palveluform">
                    <option value="1" <?php if($palvelu->getTyyppi() == 1) echo "selected='true'";?>>Mökki</option>
                    <option value="2" <?php if($palvelu->getTyyppi() == 2) echo "selected='true'";?>>Muu palvelu</option>
                </select>
                <p id="p-alv">ALV</p>
                <!-- alv-prosentin valinta pudotusvalikkona -->
                <select name="alv" id="select-alv" form="palveluform">
                    <option value="24.00" <?php if($palvelu->getAlv() == 24.00) echo "selected='true'";?>>24.00</option>
                    <option value="14.00" <?php if($palvelu->getAlv() == 14.00) echo "selected='true'";?>>14.00</option>
                </select>
                <p id="p-kuvaus">Kuvaus</p>
                <textarea name="kuvaus" id="textarea-kuvaus" class="textareainput" cols="5" rows="5" ><?php echo $palvelu->getKuvaus() ?></textarea>
            </div>

            <div class="tallenna-peruuta-napit">
                <div class="nappi-container">
                    <div class="linkki">
                        <input type="submit" name="SubmitButton" value="Tallenna">
                    </div>
                </div>
                <div class="nappi-container">
                    <div class="linkki">
                    <a href=<?php if ($palvelu->getPalveluId() != 0) {echo '"index.php?sivu=palveluntiedot&id=' . $palvelu->getPalveluId() . 
                        '"';} else {echo '"index.php?sivu=toimipisteentiedot&id=' . $_GET['tid'] . '"';}?> 
                        onclick="return confirm('Haluatko varmasti poistua sivulta?\nTekemäsi muutokset eivät tallennu.');">Peruuta</a>
                    </div>
                </div>
            </div>
            <script src="scripts/inputFilter.js"></script>
        </form>
        <?php
            // jos ei ole uusi palvelu, näytetään myös poista-nappi
            if ($_GET['id'] != 0) {
        ?>
        <div class="nappi-container">
            <div class="linkki">
                <a href=<?php echo '"index.php?sivu=poistapalvelu&id='. $palvelu->getPalveluId() . '"';?> onclick="return confirm('Haluatko varmasti poistaa pysyvästis valitun palvelun?');">Poista palvelu</a>
            </div>
        </div>
        <?php
            }
    // jos palvelu on null (= id:llä ei löydy palvelua tietokannassta)
        } else { 
            echo "<p>Hakemaasi tietoa ei löytynyt.</p><p><a href='index.php'>Palaa</a></p>";
        }
    ?>
    
    
</div>

