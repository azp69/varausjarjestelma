<?php 
include_once("modules/asiakas.php");
include_once("modules/tietokanta.php");
include_once("modules/lasku.php");
$tk = new Tietokanta;
?>

<div class ="container">

    <?php
                
        $lasku = $tk->HaeLaskunTiedot($_GET['id']);
        
        if ($lasku == "") {
            echo "<p>ei näytettäviä tietoja</p><br><a href='?sivu=laskutusA'>Palaa</a>";
        } else {

        ?>

    <div class="tiedot-header"><h1>Lasku ID: <?php echo $lasku->getLaskuId()?></h1></div>

    <div id="perustiedot" class="tiedot-container">

        <p>Maksajan Nimi: <?php echo $lasku->getSukunimi()?></p>
        <p>Asiakkaan ID: <?php echo $lasku->getAsiakasId()?></p>
        <p>Varaus ID: <?php echo $lasku->getVarausId()?></p>
        <p>Lahiosoite: <?php echo $lasku->getLahiosoite()?></p>
        <p>Postitoimipaikka: <?php echo $lasku->getPostitoimipaikka()?></p>
        <p>Postinro.: <?php echo $lasku->getPostinro()?></p>
        <p>Hinta: <?php echo $lasku->getSumma() . "€ + ALV (" . $lasku->getAlv() . "%)";?></p>
        <div class="muokkaa-nappi"><a href=<?php echo '"?sivu=muokkaalaskua&id='. $lasku->getLaskuId() . '"';?>>Muokkaa</a></div>
        
    </div>
        <?php  
        } ?>
</div>