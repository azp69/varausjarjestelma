<?php
session_start();
?>
        
        <?php
        include_once("modules/asiakas.php");
        include_once("modules/tietokanta.php");
        include_once("modules/lasku.php");
        $tk = new Tietokanta;
            
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