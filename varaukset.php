<script>
function haeAsiakas(str)
{
    if (str.length == 0) { 
        document.getElementById("asiakascontainer").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("asiakascontainer").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "haeasiakkaat.php?q=" + str, true);
        xmlhttp.send();
    }
}

function haePalvelut()
{
    var s = document.getElementById('toimipiste');
    var str = s.options[s.selectedIndex].value;

    if (str.length == 0) { 
        document.getElementById("majoituscontainer").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("majoituscontainer").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "haepalvelut.php?p=1&q=" + str, true);
        xmlhttp.send();
    }
}

</script>

<h2>Valitse asiakas</h2>
Etsi asiakasta nimellä: <br />
<input type="text" name="asiakas" value="" onkeyup="haeAsiakas(this.value)" />
<div id="asiakascontainer">
</div>

<hr />

<h2>Valitse toimipiste</h2>

<select id="toimipiste" onclick="haePalvelut()">

<?php
    haePalvelut();
?>

</select>
<hr />

<h2>Valitse majoitus</h2>

<div id="majoituscontainer">
</div>

Palvelun varauskalenteri
<hr />

<?php
    
    function haePalvelut()
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