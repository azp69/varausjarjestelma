<?php
session_start();
        include_once("modules/asiakas.php");
        include_once("modules/tietokanta.php");
        include_once("modules/lasku.php");
        $tk = new Tietokanta;
?>

<div class ="container">
    <div class="tiedot-header"><h1>Asiakkaan laskut</h1></div>

    <?php
        $laskut = array();
        $laskut = $tk->HaeLaskut($_GET['id']);
        
       if ($laskut == null) {
           echo "<p>ei näytettäviä laskuja tietokannassa</p><br><a href='?sivu=laskutusA'>Palaa</a>";
       } else {

        ?>

    <div class="listaus">

        <h2>Valitse lasku</h2>

        <?php
                foreach ($laskut as &$lasku){
                    
                    echo "<div class='keskita'> <a href='?sivu=haelasku&id=" . $lasku->getLaskuId() . "'> Lasku ID: " . $lasku->getLaskuId() . "</a></div>";
                }
                echo "<div class='muokkaa-nappi'><a href='?sivu=muokkaalaskua&id=0'>Lisää uusi lasku</a></div>"
        ?>
    </div>
    
        
    <?php } ?>

  

</div>

