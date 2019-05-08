<?php
session_start();
if (!isset($_SESSION["luokka"]))
{
    die("Kirjaudu sisään.");
}
?>

<script src="scripts/varaus.js">
</script>

<h2>Etsi varauksista</h2>
Hae asiakkaan nimellä tai varausnumerolla<br />
<input type="text" class="textinput" name="haku" value="" onkeyup="haeVarauksista(this.value)" />

<hr class="erotin" />

<h2>Listaa toimipisteen varaukset</h2>

<select class="dropdownmenu" name="toimipisteid" id="toimipiste" onclick="haeVaraukset()">

<?php
    haeToimipisteet();
?>

</select>

<hr class="erotin"/>

<div id="hakucontainer">
</div>

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