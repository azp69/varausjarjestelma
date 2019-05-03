<?php
    session_start();

    if (isset($_POST['SubmitButton']) && $_POST["apvm"] && $_POST["lpvm"] && $_POST["apvm"] < $_POST["lpvm"]) {
        // haetaan toimipisteen mökkien lukumäärä
        $mokkienLukumaara = $tk->laskeToimipisteenPalvelut($_POST['toimipisteid'], 1);
      ///////////////////////////////////////////////////////////////////
     // TODO: Toimipisteen nimen haku otsikkoa varten, otsikon luonti //
    ///////////////////////////////////////////////////////////////////
?>

<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<div id="chartContainerPaivakohtainen" style="height: 370px; width: 100%;"></div>
<script src="scripts/canvasjs.min.js"></script>
<script src="scripts/majoituksenRaportointi.js"></script>
<?php
    // echotaan scripti, jossa kutsutaan funktioita, jotka luovat chartit
    echo '<script type="text/javascript"> haeToimipisteenMokkienTayttoaste('. $_POST["toimipisteid"] .', "'. $_POST["apvm"] .'", "'. $_POST["lpvm"].'"); 
    haeToimipisteenMokkienVarauksetAikavalilla('. $_POST["toimipisteid"] .', "'. $_POST["apvm"] .'", "'. $_POST["lpvm"].'", '. $mokkienLukumaara .'); </script>';

      //////////////////////////////////////////
     // TODO: Nappi, josta voi palata hakuun //
    //////////////////////////////////////////

    } else {
        $toimipisteet = $tk->haeKaikkiToimipisteet();
?>
<p id="testi"></p>

<form action="" method="post" id="raportointiform">
    <input type="date" name="apvm" id="apvm-picker">
    <input type="date" name="lpvm" id="lpvm-picker"><br>
    <select class="dropdownmenu" name="toimipisteid" id="toimipiste">
    <?php 
        foreach ($toimipisteet as &$tp) {
    ?>
        <option value=<?php echo $tp->getToimipisteId();?>><?php echo $tp->getNimi(); ?></option>
    <?php 
        }
    ?>
    </select>
    <script src="scripts/varaus.js"></script>
    <div id="majoituscontainer"></div>
    <div class="tallenna-peruuta-napit">
        <div class="nappi-container">
            <div class="linkki">
                <input type="submit" name="SubmitButton" value="Hae">
            </div>
        </div>
    </div>
</form>
<script src="scripts/formValidationScript.js"></script>
<?php 
    }
?>