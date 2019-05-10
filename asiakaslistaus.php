<?php
session_start();
if (!isset($_SESSION["luokka"]))
{
    die("Kirjaudu sisään.");
}
?>
        
<?php
    $asiakkaat = array();
    $asiakkaat = $tk->HaeAsiakkaat();

    if ($asiakkaat == null) {
        echo "Ei hakutuloksia";
    } 
    else 
    { 
    ?> 
        
        <script src="scripts/varaus.js">
        </script>

        <div class="listaus" >
            <h1>Asiakkaan valinta</h1>
            Etsi asiakasta nimellä</br>
            <input type="text" class="textinput" name="haku" value="" onkeyup="haeAsiakkaat(this.value);">
            <br />
            <?php
            echo "<div class='keskita' style='max-width:100%;'>\n";
            echo '<table style="padding:2em; margin-left:auto; margin-right:auto;" cellpadding="5" id="asiakaslistaus">';
            echo '<tr style="text-align:left;">';
            echo "<th>Nimi</th><th>Puhelinnumero</th><th>Lähiosoite</th><th>Postinumero</th><th>Postitoimipaikka</th>\n</tr>";

            foreach ($asiakkaat as &$asiakas)
            {
                echo "<tr>";
                echo '<td><a href="?sivu=asiakastiedot&id=' . $asiakas->getAsiakasId() . '">' . $asiakas->getSukunimi() . ' ' . $asiakas->getEtunimi() . '</a></td>';
                echo '<td>' . $asiakas->getPuhelinnro() . '</td>';
                echo '<td>' . $asiakas->getLahiosoite() . '</td>';
                echo '<td>' . $asiakas->getPostinro() . '</td>';
                echo '<td>' . $asiakas->getPostitoimipaikka() . '</td>';
                echo '</tr>';
                // echo "<div class='keskita'> <a href='?sivu=tiedot&id=" . $asiakas->getAsiakasId() . "'>" . $asiakas->getSukunimi() . " " . $asiakas->getEtunimi() . "</a></div>";
            }
            echo "</table>\n";
        }
            ?>
        </div>
            
   
