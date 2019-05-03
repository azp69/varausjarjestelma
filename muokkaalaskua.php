<?php
    include_once("modules/asiakas.php");
    include_once("modules/tietokanta.php");
    include_once("modules/lasku.php");
    $tk = new Tietokanta;
    
if (isset($_POST['SubmitButton'])) {

    $lasku = new Lasku("", "", "", "", "", "", "", "", "");
    
    $lasku->setVarausId($_POST["invarausid"]);
    $lasku->setAsiakasId($_POST["inasiakasid"]);
    $lasku->setSukunimi($_POST["insukunimi"]);
    $lasku->setLahiosoite($_POST["inlahiosoite"]);
    $lasku->setPostitoimipaikka($_POST["inptpaikka"]);
    $lasku->setPostinro($_POST["inpostinro"]);
    $lasku->setSumma($_POST["insumma"]);
    $lasku->setAlv($_POST["inalv"]);

    // jos ei ole uusi lasku, päivitetään vanhaa
    if ($_GET['id'] != 0) {
        $lasku->setLaskuId($_POST["inlaskuid"]);
        $message = $tk->PaivitaLasku($lasku);
    } else {
        $lasku->setLaskuId($_POST["inlaskuid"]);
        $message = $tk->LisaaLasku($lasku);
    }

} else if ($_GET['id'] == 0) {
    $lasku = new Lasku("", "", "", "", "", "", "", "", "");
} else if (isset($_POST['DeleteButton'])){
    $meesage = $tk->PoistaLasku($_GET['id']);
}else {
    $lasku = $tk->HaeLaskunTiedot($_GET['id']);
}
// class="grid-container-laskut"
?>

<div class="form-container">
    <h1>Laskun tiedot</h1>
    <?php 
        if (isset($_POST['SubmitButton'])) {
            if ($lasku->getLaskuId() != "") {
                echo "<p>" . $message . "</p><br><p><a href='laskutusA.php?sivu=haelasku&id=" . $lasku->getLaskuId() . "'>Palaa</a></p>";
            } else {
                echo "<p>" . $message . "</p><br><p><a href='laskutusA.php'>Palaa</a></p>";
            }
        } else if (isset($_POST['DeleteButton'])) {
            
            echo "<p>" . $message . "</p><br><p><a href='laskutusA.php'>Palaa</a></p>";
  
        } else if ($lasku != null) {
        ?>

            <form action="" method="post">

            <div>
                <p id="l-laskuid" name="llaskuid">Lasku ID</p>
                <input type="text" name="inlaskuid" class="textinput" id="textinput-llaskuid" value=<?php echo "'" . $lasku->getLaskuId() . "'" ?>>
                <p id="l-asiakasid">Asiakas ID</p>
                <input type="text" name="inasiakasid" class="textinput" id="textinput-lasiakasid" value=<?php echo "'" . $lasku->getAsiakasId() . "'" ?>>
                <p id="l-varausid">Varaus ID</p>                
                <input type="text" name="invarausid" class="textinput" id="textinput-lvarausid" value=<?php echo "'" . $lasku->getVarausId() . "'" ?>>
                <p id="l-sukunimi">Sukunimi</p>
                <input type="text" name="insukunimi" class="textinput" id="textinput-lsukunimi" value=<?php echo "'" . $lasku->getSukunimi() . "'" ?>>
                <p id="l-lahiosoite">Lähiosoite</p>
                <input type="text" name="inlahiosoite" class="textinput" id="textinput-llahiosoite" value=<?php echo "'" . $lasku->getLahiosoite() . "'" ?>>
                <p id="l-postitoimipaikka">Postitoimipaikka</p>
                <input type="text" name="inptpaikka" class="textinput" id="textinput-lpostitoimipaikka" value=<?php echo "'" . $lasku->getPostitoimipaikka() . "'" ?>>
                <p id="l-postinro">Postinumero</p>
                <input type="text" name="inpostinro" class="textinput" id="textinput-lpostinro" value=<?php echo "'" . $lasku->getPostinro() . "'" ?>>
                <p id="l-summa">Summa</p>
                <input type="text" name="insumma" class="textinput" id="textinput-lsumma" value=<?php echo "'" . $lasku->getSumma() . "'" ?>>
                <p id="l-alv">Alv %</p>
                <input type="text" name="inalv" class="textinput" id="textinput-lalv" value=<?php echo "'" . $lasku->getAlv() . "'" ?>>
            </div>

            <input type="submit" name="SubmitButton" value="Tallenna">
            <input type="submit" name="DeleteButton" value="Poista">

        <?php
        } else {
            echo "<p>ei näytettäviä tietoja</p><p><a href='?sivu=laskutusA.php'>Palaa</a></p>";
        }
        ?>
    
    

    </form>
</div>
