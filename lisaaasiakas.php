<?php
session_start();
if (!isset($_SESSION["luokka"]))
{
    die("Kirjaudu sisään.");
}
?>

    <?php
    

    if (isset($_POST['submit'])) {
        $etunimi = $_POST['etunimi'];
        $sukunimi = $_POST['sukunimi'];
        $lahiosoite = $_POST['lahiosoite'];
        $postitoimipaikka = $_POST['postitoimipaikka'];
        $postinro = $_POST['postinro'];
        $email = $_POST['email'];
        $puhelinnro = $_POST['puhelinnro'];
        // tarkistaa, onko kaikki kentät täytetty
        if ($etunimi != null && $sukunimi != null && $lahiosoite != null && $postitoimipaikka != null && $postinro != null && $email != null && $puhelinnro != null) {
        $tk->LisaaAsiakas($etunimi, $sukunimi, $lahiosoite, $postitoimipaikka, $postinro, $email, $puhelinnro);
        }
        
        else {
            echo "<p style= 'color:red; text-align:center;'> Kaikki kentät ovat pakollisia. </p>";
        }
    }
    ?>

    <div class="form-container">
        <h1>Lisää asiakas</h1>

        <form action="" method="post">

            <div class="customergrid-container">
                <input type="hidden" name="id" value="">
                <p id="p-etunimi">Etunimi</p>
                <input type="text" name="etunimi" class="textinput" id="textinput-etunimi" value="">
                <p id="p-sukunimi">Sukunimi</p>
                <input type="text" name="sukunimi" class="textinput" id="textinput-sukunimi" value="">
                <p id="p-osoite">Lähiosoite</p>
                <input type="text" name="lahiosoite" class="textinput" id="textinput-osoite" value="" style="">
                <p id="p-postitoimipaikka">Postitoimipaikka</p>
                <input type="text" name="postitoimipaikka" class="textinput" id="textinput-postitoimipaikka" value="">
                <p id="p-postinro">Postinumero</p>
                <input type="text" name="postinro" class="textinput" id="textinput-postinro" value="">
                <p id="p-email">Sähköposti</p>
                <input type="text" name="email" class="textinput" id="textinput-email" value="">
                <p id="p-puhelinnro">Puhelinnumero</p>
                <input type="text" name="puhelinnro" class="textinput" id="textinput-puhelinnro" value="">
                <p id="p-submit"></p>
                <input type="submit" value="Lisää" class="button_submit" name="submit" id="button-submit">
            </div>
        </form>
    </div>
