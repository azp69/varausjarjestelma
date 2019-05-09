<?php
session_start();
if (!isset($_SESSION["luokka"]))
{
    die("Kirjaudu sisään.");
}
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
        <div class="muokkaa-nappi"><a href=<?php echo '"?sivu=muokkaalaskua&id='. $lasku->getLaskuId() . '&varausid='. $lasku->getVarausId(). '"';?>>Muokkaa</a></div>
        <div class="muokkaa-nappi"><a href=<?php echo '"generoilasku.php?laskuid='. $lasku->getLaskuId() . '"';?> target="_blank">Tulosta lasku</a></div>
        <div class="muokkaa-nappi"><a href=<?php echo '"?sivu=generoilasku&laskuid='. $lasku->getLaskuId() . '&toiminto=sahkoposti'. '"';?>>Lähetä lasku sähköpostilla</a></div>
        
    </div>
        <?php  
        } ?>
</div>