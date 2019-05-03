<?php
// jos on painettu tallenna, luodaan uusi Toimipiste-olio ja haetaan tiedot formilta
if (isset($_POST['SubmitButton'])) {

    $toimipiste = new Toimipiste("", "", "", "", "", "", "");

    $toimipiste->setNimi($_POST["nimi"]);
    $toimipiste->setLahiosoite($_POST["lahiosoite"]);
    $toimipiste->setPostitoimipaikka($_POST["postitoimipaikka"]);
    $toimipiste->setPostinro($_POST["postinro"]);
    $toimipiste->setEmail($_POST["email"]);
    $toimipiste->setPuhelinnro($_POST["puhelinnro"]);

    // jos ei ole uusi toimipiste, päivitetään vanhaa
    if ($_POST['id'] != 0) {
        $toimipiste->setToimipisteId($_POST["id"]);
        $message = $tk->PaivitaToimipiste($toimipiste);
    } else {
        $toimipiste->setToimipisteId(0);
        $message = $tk->lisaaToimipiste($toimipiste);
    }
// jos id = 0, luodaan uusi Toimipiste-opio
} else if ($_GET['id'] == 0) {
    $toimipiste = new Toimipiste("", "", "", "", "", "", "");
// jos ei ole uusi toimipiste, haetaan toimipisteen tiedot tietokannasta
} else {
    $toimipiste = $tk->HaeToimipiste($_GET['id']);
}

?>

<div class="form-container">
    <h1>Toimipisteen tiedot</h1>
    <?php 
        // jos on painettu tallenna, näytetään käyttäjälle onnistuiko tietojen tallentaminen
        if (isset($_POST['SubmitButton'])) {
            if ($toimipiste->getToimipisteId() != "") {
                echo "<p>" . $message . "</p><br><p><a href='index.php?sivu=toimipisteentiedot&id=" . $toimipiste->getToimipisteId() . "'>Palaa</a></p>";
            } else {
                echo "<p>" . $message . "</p><br><p><a href='index.php'>Palaa</a></p>";
            }
        // jos toimipiste löytyy tietokannasta, tai luodaan uusi toimipiste (on luotu uusi olio), näytetään formi jossa voi asettaa toimipisteen tiedot
        } else if ($toimipiste != null) {
        ?>

            <form action="" method="post" id="toimipisteenmuokkausform" onsubmit="return validateSubmit();">

                <div class="grid-container" id="toimipisteenmuokkausform-grid-container">
                    <p id="p-nimi">Nimi</p>
                    <input type="hidden" name="id" value=<?php echo "'" . $toimipiste->getToimipisteId() . "'" ?>>
                    <input type="text" name="nimi" class="textinput" id="textinput-nimi" value=<?php echo "'" . $toimipiste->getNimi() . "'" ?>>
                    <p id="p-lahiosoite">Lähiosoite</p>
                    <input type="text" name="lahiosoite" class="textinput" id="textinput-lahiosoite" value=<?php echo "'" . $toimipiste->getLahiosoite() . "'" ?>>
                    <p id="p-postitoimipaikka">Postitoimipaikka</p>
                    <input type="text" name="postitoimipaikka" class="textinput" id="textinput-postitoimipaikka" value=<?php echo "'" . $toimipiste->getPostitoimipaikka() . "'" ?>>
                    <p id="p-postinro">Postinumero</p>
                    <input type="text" name="postinro" class="textinput" id="textinput-postinro" value=<?php echo "'" . $toimipiste->getPostinro() . "'" ?>>
                    <p id="p-email">Sähköposti</p>
                    <input type="text" name="email" class="textinput" id="textinput-email" value=<?php echo "'" . $toimipiste->getEmail() . "'" ?>>
                    <p id="p-puhelinnro">Puhelinnumero</p>
                    <input type="text" name="puhelinnro" class="textinput" id="textinput-puhelinnro" value=<?php echo "'" . $toimipiste->getPuhelinnro() . "'" ?>>
                </div>

                <div class="tallenna-peruuta-napit">
                    <div class="nappi-container">
                        <div class="linkki">
                            <input type="submit" name="SubmitButton" value="Tallenna">
                        </div>
                    </div>
                    <div class="nappi-container">
                        <div class="linkki">
                        <a href='?' onclick="return confirm('Haluatko varmasti poistua sivulta?\nTekemäsi muutokset eivät tallennu.');">Peruuta</a>
                        </div>
                    </div>
                </div>
                <script src="scripts/inputFilter.js"></script>
                <script src="scripts/formValidationScript.js"></script>
            </form>
            <?php
            // jos ei ole uusi toimipiste, näytetään myös poista-nappi
            if ($_GET['id'] != 0) {
            ?>
            <div class="nappi-container">
                <div class="linkki">
                    <a href=<?php echo '"index.php?sivu=poistatoimipiste&id='. $toimipiste->getToimipisteId() . '"';?> onclick="return confirm('Haluatko varmasti poistaa pysyvästi valitun toimipisteen?');">Poista</a>
                </div>
            </div>
            <?php 
            }
            ?>
        <?php
        // jos toimipiste-olio on null (= id:llä ei löydy toimipistettä tietokannassta)
        } else {
            echo "<p>Valitettavasti hakemaasi tietoa ei löytynyt.</p><p><a href='index.php'>Palaa</a></p>";
        }       
        ?>
</div>
