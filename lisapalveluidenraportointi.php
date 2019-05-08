<?php
    include_once("modules/tietokanta.php");
    include_once("modules/toimipiste.php");
    include_once("modules/lisapalaveluidenraportointiluokka.php");
    
    $tk = new Tietokanta;

    session_start();

    if (isset($_POST['SubmitButton']) && $_POST["alkupvm"] && $_POST["loppupvm"] && $_POST["alkupvm"] < $_POST["loppupvm"] && $_POST["toimipisteid"] != "") {

        $toimipiste = $tk->HaeToimipiste($_POST["toimipisteid"]);
?>
    <div class="form-header">
        <h1><?php echo $toimipiste->getNimi();?></h1>
    </div>

<?php ?>

<div class="chartContainer" id="chartContainer"></div>
<div class="chartContainer" id="chartContainerOsuudet"></div>
<script src="scripts/canvasjs.min.js"></script>
<script src="scripts/lisapalveluidenRaportointi.js"></script>
<?php
    // echotaan scripti, jossa kutsutaan funktioita, jotka luovat chartit
    echo '<script type="text/javascript"> haeToimipisteenLisapalveluidenOstomaaratAikavalilla('. $_POST["toimipisteid"] .', "'. $_POST["alkupvm"] .'", "'. $_POST["loppupvm"].'");</script>';

      //////////////////////////////////////////
     // TODO: Nappi, josta voi palata hakuun //
    //////////////////////////////////////////

    } else {
        $toimipisteet = $tk->haeKaikkiToimipisteet();
?>
        <div class="form-container">
            <form action="" method="post" id="raportointiform" class="raportointiform">
                <div class="form-header">
                    <h1>Lisäpalveluiden raportointi</h1>
                </div>
                <hr class="erotin"/>
                <div class="form-subheader">
                    <h2>Valitse toimipiste</h2>
                </div>
                
                <div class="toimipisteenvalinta">
                    <select class="dropdownmenu" name="toimipisteid" id="toimipiste">
                        <option value="" disabled selected>Valitse toimipiste</option>
                    <?php 
                        foreach ($toimipisteet as &$tp) {
                    ?>
                        <option value=<?php echo $tp->getToimipisteId();?>><?php echo $tp->getNimi(); ?></option>
                    <?php 
                        }
                    ?>
                    </select>
                </div>
                <hr class="erotin"/>
                <?php include('kalenteri.php'); ?>
                <script src="scripts/kalenteri.js"></script>
                <script src="scripts/varaus.js"></script>
                <hr class="erotin"/>
                <div class="tallenna-peruuta-napit">
                    <div class="nappi-container">
                        <div class="linkki">
                            <input type="submit" name="SubmitButton" value="Hae">
                        </div>
                    </div>
                </div>
                <hr class="erotin"/>
            </form>
            <script src="scripts/formValidationScript.js"></script>
        </div>
<?php 
    }
?>