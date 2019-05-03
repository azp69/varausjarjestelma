<?php
session_start();
?>

<div class ="container">

    <?php
        //haetaan palvelun tiedot tietokannasta 
        $palvelu = $tk->haePalvelu($_GET['id']);
        
        if ($palvelu == null) {
            echo "<p>Hakemaasi tietoa ei löytynyt.</p><br><a href='index.php'>Palaa</a>";
        } else {

        ?>

    <div class="tiedot-header"><h1>Palvelun tiedot</h1></div>

    <div id="perustiedot" class="tiedot-container">
        <p>Nimi: <?php echo $palvelu->getNimi();?></p>
        <p>Kuvaus: <?php echo "<br>" . $palvelu->getKuvaus();?></p>
        <p>Hinta: <?php echo $palvelu->getHinta() . "€ + ALV (" . $palvelu->getAlv() . "%)";?></p>
    </div>
    <div class="nappi-container">
        <div class="linkki">
            <a href=<?php echo '"index.php?sivu=muokkaapalvelua&id='. $palvelu->getPalveluId() . '"';?>>Muokkaa</a>
        </div>
    </div>
        <?php  
        } ?>
</div>

