<?php
session_start();
if (!isset($_SESSION["luokka"]))
{
    die("Kirjaudu sisään.");
}
?>

<div class ="container">
    <div class="tiedot-header"><h1>Toimipisteen tiedot</h1></div>

    <?php
        // haetaan tietokannasta valittu toimipiste
        $toimipiste = $tk->HaeToimipiste($_GET['id']);
        // jos tietokannasta ei löydy id:tä vastaavaa toimipistettä, HaeToimipiste palautta null-arvon
        if ($toimipiste == null) {
            echo "<p>Hakemaasi tietoa ei löytynyt.</p><br><a href='index.php'>Palaa</a>";
        } else {

        ?>

    <div id="perustiedot" class="tiedot-container">

        <h2>Perustiedot</h2>

        <p>Nimi: <?php echo $toimipiste->getNimi();?></p>
        <p>Lähiosoite: <?php echo $toimipiste->getLahiosoite();?></p>
        <p>Postinumero: <?php echo $toimipiste->getPostinro();?></p>
        <p>Postitoimipaikka: <?php echo $toimipiste->getPostitoimipaikka();?></p>
        <p>Sähköpostiosoite: <?php echo $toimipiste->getEmail();?></p>
        <p>Puhelinnumero: <?php echo $toimipiste->getPuhelinnro();?></p><br>
    </div>
    <div class="nappi-container" id="nappi-container-muokkaatoimipisteentietoja">
        <div class="linkki">
            <a href=<?php echo '"index.php?sivu=muokkaa&id='. $toimipiste->getToimipisteId() . '"'?>>Muokkaa</a>
        </div>
    </div>
    <div id="muuttiedot" style="">
        <div id="mokit" class="tiedot-container">
            <h2>Toimipisteen mökit</h2>
        

            <?php
            // haetaan toimipisteeseen kuuluvat mökit
            $tpnmokit = $tk->haeToimipisteeseenKuuluvatPalvelut($toimipiste->getToimipisteId(), 1);
            foreach ($tpnmokit as &$mokki) {
                ?>
                <a href=<?php echo '"index.php?sivu=palveluntiedot&id=' . $mokki->getPalveluId() . '"';?>><?php echo $mokki->getNimi();?></a>
                <?php echo "<br>";
            }
            ?>
        </div>

        <div id="palvelut" class="tiedot-container">
            <h2>Toimipisteen muut palvelut</h2>
    

            <?php
            // haetaan toimipisteeseen kuuluvuvat muut palvelut
            $tpnpalvelut = $tk->haeToimipisteeseenKuuluvatPalvelut($toimipiste->getToimipisteId(), 2);
            foreach ($tpnpalvelut as &$palvelu) {
            ?>
            <a href=<?php echo '"index.php?sivu=palveluntiedot&id=' . $palvelu->getPalveluId() . '"';?>><?php echo $palvelu->getNimi();?></a>
            <?php echo "<br>";
            } ?>
        </div>
        
        <?php  } ?>

    </div>
    <div class="nappi-container" id="nappi-container-lisaapalvelu">
        <div class="linkki">
            <a href="index.php?sivu=muokkaapalvelua&id=0&tid=<?php echo $toimipiste->getToimipisteId();?>">Lisää mökki tai palvelu</a>
        </div>
    </div>
</div>

