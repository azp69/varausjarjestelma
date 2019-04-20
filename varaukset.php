<script src="scripts/varaus.js">
</script>

<h2>Valitse asiakas</h2>
Etsi asiakasta nimellä: <br />
<input type="text" name="asiakas" value="" onkeyup="haeAsiakas(this.value)" />
<div id="asiakascontainer">
</div>

<hr />

<h2>Valitse toimipiste</h2>

<select id="toimipiste" onclick="haePalvelut(); haeLisapalvelut();">

<?php
    haeToimipisteet();
?>

</select>
<hr />

<h2>Valitse majoitus</h2>

<div id="majoituscontainer">
</div>

<h3>Palvelun varauskalenteri</h3>
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
<hr />

<h2>Valitse lisäpalvelut</h2>
<div id="lisapalvelucontainer"></div>
<hr />

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