<?php // TÄMÄ LISTAA ASIAKKAAT
session_start();
?>
        
<?php
    include_once("modules/asiakas.php"); //<== Tämä on se minun luoma asiakasluokka. 
    include_once("modules/tietokanta.php");
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

            foreach ($asiakkaat as &$asiakas)
            {
                    // tämä koodi luo linkit jokaisesta asiakkaasta eli muuta tuo 'laskutusA.php' osoite oman sivusi mukaan.
                echo "<div class='keskita'> <a href='?sivu=asiakastiedot&id=" . $asiakas->getAsiakasId() . "'>" . $asiakas->getEtunimi() . "</a></div>";
            }
        }
    ?>
        </div>
            
   
