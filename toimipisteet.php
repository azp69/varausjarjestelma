<?php
    // haetaan toimipisteet tietokannasta
    $toimipisteet = array();
    $toimipisteet = $tk->haeKaikkiToimipisteet();

    if ($toimipisteet == null) {
        echo "Ei hakutuloksia";
    } else { ?> 

    <div class="listaus">
        <h1>Toimipaikan valinta</h1>
        <?php
            // listataan kaikki toimipisteet linkkeinä, joista pääsee tarkastelemaan toimipisteiden tietoja
            foreach ($toimipisteet as &$toimipiste){   
                echo "<div class='keskita'> <a href='index.php?sivu=toimipisteentiedot&id=" . $toimipiste->getToimipisteId() . "'>" . $toimipiste->getNimi() . "</a></div>";
            }
        }
    ?>
    </div>