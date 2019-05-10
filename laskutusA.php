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

        <div class="listaus">
            <h1>Asiakkaan valinta</h1>
            
            <?php
            echo "<div class='keskita'>\n";
            echo '<table style="padding:2em;">';
            echo '<tr style="text-align:left;">';
            echo "<th>Nimi</th><th>Puhelinnumero</th><th>Postitoimipaikka</th>\n</tr>";

            foreach ($asiakkaat as &$asiakas)
            {
                echo "<tr>";
                echo '<td><a href="?sivu=tiedot&id=' . $asiakas->getAsiakasId() . '">' . $asiakas->getSukunimi() . ' ' . $asiakas->getEtunimi() . '</a></td>';
                echo '<td>' . $asiakas->getPuhelinnro() . '</td>';
                echo '<td>' . $asiakas->getPostitoimipaikka() . '</td>';
                echo '</tr>';
                // echo "<div class='keskita'> <a href='?sivu=tiedot&id=" . $asiakas->getAsiakasId() . "'>" . $asiakas->getSukunimi() . " " . $asiakas->getEtunimi() . "</a></div>";
            }
            echo "</table>\n";
        }
            ?>
        </div>