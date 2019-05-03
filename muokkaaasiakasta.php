<?php
session_start()
?>

<?php
include_once("modules/tietokanta.php");
include_once("modules/asiakas.php");
$tk = new Tietokanta;

if (isset($_POST['muokkaa'])) {
    $asiakas = new Asiakas("", "", "", "", "", "", "", "");
    $asiakas->setAsiakasId($_POST['id']);
    $asiakas->setEtunimi($_POST['etunimi']);
    $asiakas->setSukunimi($_POST['sukunimi']);
    $asiakas->setLahiosoite($_POST["lahiosoite"]);
    $asiakas->setPostitoimipaikka($_POST['postitoimipaikka']);
    $asiakas->setPostinro($_POST['postinro']);
    $asiakas->setEmail($_POST['email']);
    $asiakas->setPuhelinnro($_POST['puhelinnro']);
    echo $tk->PaivitaAsiakas($asiakas);
}
?>



<div class="form-container">
    <div>
        <h1>Muokkaa asiakasta</h1>
    </div>

    <?php
    $asiakas = $tk->HaeAsiakas($_GET['id']);


    if ($asiakas == null) {
        echo "<p>ei näytettäviä tietoja</p><br><a href='Asiakaslistaus.php'>Palaa</a>";
    } else {

        ?>

        <form action="" method="post">

            <div class="customergrid-container">
                <input type="hidden" name="id" value=<?php echo "'" . $asiakas->getAsiakasId() . "'" ?>>
                <p id="p-etunimi">Etunimi</p>
                <input type="text" name="etunimi" class="textinput" id="textinput-etunimi" value=<?php echo "'" . $asiakas->getEtunimi() . "'" ?>>
                <p id="p-sukunimi">Sukunimi</p>
                <input type="text" name="sukunimi" class="textinput" id="textinput-sukunimi" value=<?php echo "'" . $asiakas->getSukunimi() . "'" ?>>
                <p id="p-osoite">Lähiosoite</p>
                <input type="text" name="lahiosoite" class="textinput" id="textinput-osoite" value=<?php echo "'" . $asiakas->getLahiosoite() . "'" ?>>
                <p id="p-postitoimipaikka">Postitoimipaikka</p>
                <input type="text" name="postitoimipaikka" class="textinput" id="textinput-postitoimipaikka" value=<?php echo "'" . $asiakas->getPostitoimipaikka() . "'" ?>>
                <p id="p-postinro">Postinumero</p>
                <input type="text" name="postinro" class="textinput" id="textinput-postinro" value=<?php echo "'" . $asiakas->getPostinro() . "'" ?>>
                <p id="p-email">Sähköposti</p>
                <input type="text" name="email" class="textinput" id="textinput-email" value=<?php echo "'" . $asiakas->getEmail() . "'" ?>>
                <p id="p-puhelinnro">Puhelinnumero</p>
                <input type="text" name="puhelinnro" class="textinput" id="textinput-puhelinnro" value=<?php echo "'" . $asiakas->getPuhelinnro() . "'" ?>>
            </div>

            <div>
                <input type="submit" value="Tallenna" class="button_submit" name="muokkaa">
            </div>
        </form>


    <?php
} ?>