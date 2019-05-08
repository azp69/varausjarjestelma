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

                foreach ($asiakkaat as &$asiakas){
                    
                    echo "<div class='keskita'> <a href='?sivu=tiedot&id=" . $asiakas->getAsiakasId() . "'>" . $asiakas->getEtunimi() . "</a></div>";
                }
            }
        ?>
        </div>