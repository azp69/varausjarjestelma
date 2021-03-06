<?php
session_start();
if (!isset($_SESSION["luokka"]))
{
    die("Kirjaudu sisään.");
}
?>
        
<?php
    include_once('modules/tietokanta.php');
    if (isset($_POST['asiakasid']))
    {
        $lisapalvelut = array();
        $lisapalveluidenlkm = array();
        foreach ($_POST['lisapalveluid'] as $palveluid)
        {
            array_push($lisapalvelut, $palveluid);
            array_push($lisapalveluidenlkm, $_POST['lisapalvelu' . $palveluid]);
        }
        
        // LisaaVaraus($asiakas_id, $toimipiste_id, $varattu_pvm, $vahvistus_pvm, $varattu_alkupvm, $varattu_loppupvm, $majoitusid, $palvelut, $lkm)
        
        $tk = new Tietokanta;
        if ($tk->LisaaVaraus($_POST['asiakasid'], $_POST['toimipisteid'], date("Y-m-d"), date("Y-m-d"), $_POST['alkupvm'], $_POST['loppupvm'], $_POST['majoitusid'], $lisapalvelut, $lisapalveluidenlkm))
        {
            echo "Varaus luotiin onnistuneesti.";
        }
        else
        {
            echo "Virhe luotaessa varausta.";
        }

    }
?>
<script src="scripts/varaus.js"></script>

<form name="tee_varaus" method="post" action="?sivu=luovaraus">


<h2>Luo uusi varaus</h2>

<h3>Valitse asiakas</h3>
Etsi asiakasta nimellä: <br />
<div id="asiakascontainer">
</div>
<input type="text" class="textinput" name="asiakas" value="" onkeyup="haeAsiakas(this.value)" />

<hr class="erotin" />

<h3>Valitse toimipiste</h3>

<select class="dropdownmenu" name="toimipisteid" id="toimipiste" onclick="haePalvelut(); haeLisapalvelut();">

<?php
    haeToimipisteet();
?>

</select>
<hr class="erotin"/>

<h3>Valitse majoitus</h3>

<div id="majoituscontainer">
</div>


<script id="scriptcontainer"></script>

<!-- <script src="scripts/kalenteri.js"></script> -->


<?php include('kalenteri.php'); ?>
<hr class="erotin"/>

<h3>Valitse lisäpalvelut</h3>
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