<?php
    include_once('modules/tietokanta.php');

    if ($_POST['asiakasid'])
    {
        /*
        echo "ToimipisteID: " . $_POST['toimipisteid'] . "<br/>\n";
        echo "AsiakasID: " . $_POST['asiakasid'] . "<br/>\n";
        echo "MajoitusID: " . $_POST['majoitusid'] . "<br/>\n";
        echo "Majoituksen Alkupvm: " . $_POST['alkupvm'] . "<br/>\n";
        echo "Majoituksen Loppupvm: " . $_POST['loppupvm'] . "<br/>\n";
        echo "Lisäpalvelut: <br />\n";
        
        foreach ($_POST['lisapalveluid'] as $palveluid)
        {
            echo $palveluid . " <br/>\n";
            echo $_POST['lisapalvelu' . $palveluid] . " kpl";
        }
        */
        $lisapalvelut = array();
        $lisapalveluidenlkm = array();

        foreach ($_POST['lisapalveluid'] as $palveluid)
        {
            array_push($lisapalvelut, $palveluid);
            array_push($lisapalveluidenlkm, $_POST['lisapalvelu' . $palveluid]);
        }
        
        // LisaaVaraus($asiakas_id, $toimipiste_id, $varattu_pvm, $vahvistus_pvm, $varattu_alkupvm, $varattu_loppupvm, $majoitusid, $palvelut, $lkm)
        
        $tk = new Tietokanta;
        $tk->LisaaVaraus($_POST['asiakasid'], $_POST['toimipisteid'], date("Y-m-d"), date("Y-m-d"), $_POST['alkupvm'], $_POST['loppupvm'], $_POST['majoitusid'], $lisapalvelut, $lisapalveluidenlkm);
    }
?>

<form name="tee_varaus" method="post" action="?sivu=varaukset">
<script src="scripts/varaus.js">
</script>

<h2>Luo uusi varaus</h2>

<h2>Valitse asiakas</h2>
Etsi asiakasta nimellä: <br />
<div id="asiakascontainer">
</div>
<input type="text" class="textinput" name="asiakas" value="" onkeyup="haeAsiakas(this.value)" />

<hr class="erotin" />

<h2>Valitse toimipiste</h2>

<select class="dropdownmenu" name="toimipisteid" id="toimipiste" onclick="haePalvelut(); haeLisapalvelut();">

<?php
    haeToimipisteet();
?>

</select>
<hr class="erotin"/>

<h2>Valitse majoitus</h2>

<div id="majoituscontainer">
</div>

<script src="scripts/kalenteri.js"></script>
<script>
const varaus = {
                alkupaiva: '',
                loppupaiva: ''
            }

            var varaukset = [];
            var v;
</script>
<script id="scriptcontainer"></script>

<?php include('kalenteri.php'); ?>
<hr class="erotin"/>

<h2>Valitse lisäpalvelut</h2>
<div id="lisapalvelucontainer"></div>
<hr class="erotin"/>

<input type="submit" class="button_default" value="Vahvista" />

<?php
    
    function haeToimipisteet()
    {
        include_once("modules/tietokanta.php");
        include_once("modules/palvelu.php");
        include_once("modules/toimipiste.php");
        $tk = new Tietokanta;
        $toimipisteet = array();

        $toimipisteet = $tk->HaeToimipisteet();
    
        foreach ($toimipisteet as $tp)
        {   
            echo "<option value='" . $tp->getToimipisteId() . "'>" . $tp->getNimi() . "</option>\n";
        }
    }
    
?>
</form>