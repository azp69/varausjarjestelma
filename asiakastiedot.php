<?php
session_start();
if (!isset($_SESSION["luokka"]))
{
    die("Kirjaudu sisään.");
}
?>


<div class="container">
    <div>
        <h1>Asiakkaan tiedot</h1>
    </div>

    <?php

    $asiakas = $tk->HaeAsiakas($_GET['id']);
    $href = '?sivu=muokkaaasiakasta&id=' . $asiakas->getAsiakasId() . '';


    if ($asiakas == null) {
        echo "<p>ei näytettäviä tietoja</p><br><a href='Asiakaslistaus.php'>Palaa</a>";
    } 
    else if (isset($_POST['poistaAsiakas'])) {
        $asiakasid = $asiakas->getAsiakasId();
        $tk->PoistaAsiakas($asiakasid);
    } else {

        ?>

        <form action="" method="post">
            <div class="tiedot-container">
                <p>Etunimi: <?php echo $asiakas->getEtunimi(); ?></p>
                <p>Sukunimi: <?php echo $asiakas->getSukunimi(); ?></p>
                <p>Lähiosoite: <?php echo $asiakas->getLahiosoite(); ?></p>
                <p>Postinumero: <?php echo $asiakas->getPostinro(); ?></p>
                <p>Postitoimipaikka: <?php echo $asiakas->getPostitoimipaikka(); ?></p>
                <p>Sähköpostiosoite: <?php echo $asiakas->getEmail(); ?></p>
                <p>Puhelinnumero: <?php echo $asiakas->getPuhelinnro(); ?></p><br>
            </div>

            <div class="row">
                <input type="button" value="Muokkaa" class="button_submit" name="muokkaaAsiakasta" onclick="window.location.href='<?php echo $href ?>'">
                <input type="submit" value="Poista" class="button_submit" name="poistaAsiakas" onclick="return confirm('Haluatko varmasti poistaa asiakkaan?');">
            </div>
        </form>

    <?php
} ?>
</div>