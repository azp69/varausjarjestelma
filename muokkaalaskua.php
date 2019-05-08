<?php
session_start();
if (!isset($_SESSION["luokka"]))
{
    die("Kirjaudu sisään.");
}
?>

<?php

    
if (isset($_POST['SubmitButton'])) {

    $lasku = new Lasku("", "", "", "", "", "", "", "", "");
    
    $lasku->setVarausId($_POST["invarausid"]);
    $lasku->setAsiakasId($_POST["inasiakasid"]);
    $lasku->setSukunimi($_POST["insukunimi"]);
    $lasku->setLahiosoite($_POST["inlahiosoite"]);
    $lasku->setPostitoimipaikka($_POST["inptpaikka"]);
    $lasku->setPostinro($_POST["inpostinro"]);
    $lasku->setSumma($_POST["insumma"]);
    $lasku->setAlv($_POST["inalv"]);

    // jos ei ole uusi lasku, päivitetään vanhaa
    if ($_GET['id'] != 0) {
        $lasku->setLaskuId($_POST["inlaskuid"]);
        $message = $tk->PaivitaLasku($lasku);
    } else {
        $lasku->setLaskuId($_POST["inlaskuid"]);
        $message = $tk->LisaaLasku($lasku);
    }

} else if ($_GET['id'] == 0 && isset($_GET['varausid'])) {
    $varaus = $tk->HaeVaraus($_GET['varausid']);
    $asiakas = $varaus->getAsiakas();
    $varauksenPalvelut = $tk->HaeVaraukseenKuuluvatPalvelut($_GET['varausid']);
    $palvelut = [];
    $laskunSumma = 0;
    $alvnMaara = 0;
    foreach ($varauksenPalvelut as $vp){
        $p = $vp->getPalveluID();
        $palvelut[] = $p;
        $alv = ((($p->getHinta() / 100) * $p->getAlv()) * $vp->getLkm());
        $alvnMaara += $alv;
        $laskunSumma += (($p->getHinta() * $vp->getLkm()) + $alv);
        
    }
    $lasku = new Lasku(0, $asiakas->getAsiakasId(), $varaus->getVarausID(), $asiakas->getSukunimi(), $asiakas->getLahiosoite(), 
    $asiakas->getPostitoimipaikka(), $asiakas->getPostinro(), $laskunSumma, $alvnMaara);
} else if ($_GET['id'] == 0) {
    $lasku = new Lasku("", "", "", "", "", "", "", "", "");
} else if (isset($_POST['DeleteButton'])){
    $meesage = $tk->PoistaLasku($_GET['id']);
}else {
    $lasku = $tk->HaeLaskunTiedot($_GET['id']);
    $varauksenPalvelut = $tk->HaeVaraukseenKuuluvatPalvelut($_GET['varausid']);
}
// class="grid-container-laskut"
?>

<div class="lasku-form-container">
    <h1>Laskun tiedot</h1>
    <?php 
        if (isset($_POST['SubmitButton'])) {
            if ($lasku->getLaskuId() != "") {
                echo "<p>" . $message . "</p><br><p><a href='laskutusA.php?sivu=haelasku&id=" . $lasku->getLaskuId() . "'>Palaa</a></p>";
            } else {
                echo "<p>" . $message . "</p><br><p><a href='laskutusA.php'>Palaa</a></p>";
            }
        } else if (isset($_POST['DeleteButton'])) {
            
            echo "<p>" . $message . "</p><br><p><a href='laskutusA.php'>Palaa</a></p>";
  
        } else if ($lasku != null) {
        ?>

        <form action="" method="post">
            <div class="form-subheader">
                    <h2>Laskun tiedot</h2>
                </div>
            <div class="lasku-form-grid1">
                <p id="p-llaskuid"><b>Lasku ID:</b> <?php if ($lasku->getLaskuId() != 0) {echo $lasku->getLaskuId();} else {echo "Uusi lasku";}?></p>    
                <p id="p-lvarausid"><b>Varaus ID:</b> <?php echo $lasku->getVarausId();?></p>
                <p id="p-palvnimi"><b>Palvelu</b></p>
                <p id="p-palvmaara"><b>Kpl</b></p>
                <p id="p-palvhinta"><b>Kpl hinta</b></p>
                <p id="p-palvalvpros"><b>ALV %</b></p>
                <p id="p-palvalv"><b>ALV:n määrä</b></p>
                <h3 id="valiotsikko">Varauksessa ostetut palvelut</h3>
                <?php 
                foreach ($varauksenPalvelut as $vp){
                    $p = $vp->getPalveluID();
                    echo "<p>" . $p->getNimi() . "</p>\n";
                    echo "<p>" . $vp->getLkm() . "</p>\n";
                    echo "<p>" . $p->getHinta() . "</p>\n";
                    echo "<p>" . $p->getAlv() . "</p>\n";
                    echo "<p>" . (($p->getHinta() / 100) * $p->getAlv()) . "</p>\n";
                }
                ?>
            </div>
            <input type="hidden" name="invarausid" value=<?php echo "'" . $lasku->getVarausId() . "'" ;?>>
            <input type="hidden" name="inasiakasid" value=<?php echo "'" . $lasku->getAsiakasId() . "'" ;?>>
            <div class="lasku-form-grid2">
                <p id="p-lsumma"><b>Laskun loppusumma</b></p>
                <p id="textinput-lsumma"><?php echo $lasku->getSumma(); ?></p>
                <p id="p-lalv"><b>Alv</b></p>
                <p id="textinput-lalv"><?php echo $lasku->getAlv(); ?></p>
            </div>
            <input type="hidden" name="insumma" value=<?php echo "'" . $lasku->getSumma() . "'" ;?>>
            <input type="hidden" name="inalv" value=<?php echo "'" . $lasku->getAlv() . "'" ;?>>
            <div class="form-subheader">
                <h2>Laskutusosoite</h2>
            </div>
            <div class="lasku-form-grid3">
                <p id="p-lasiakasid"><b>Asiakas ID:</b> <?php echo $lasku->getAsiakasId();?></p>  
                <p id="p-lsukunimi"><b>Nimi</b></p>
                <input type="text" name="insukunimi" class="textinput" id="textinput-lsukunimi" value=<?php echo "'" . $lasku->getSukunimi() . "'" ?>>
                <p id="p-llahiosoite"><b>Lähiosoite</b></p>
                <input type="text" name="inlahiosoite" class="textinput" id="textinput-llahiosoite" value=<?php echo "'" . $lasku->getLahiosoite() . "'" ?>>
                <p id="p-lpostitoimipaikka"><b>Postitoimipaikka</b></p>
                <input type="text" name="inptpaikka" class="textinput" id="textinput-lpostitoimipaikka" value=<?php echo "'" . $lasku->getPostitoimipaikka() . "'" ?>>
                <p id="p-lpostinro"><b>Postinumero</b></p>
                <input type="text" name="inpostinro" class="textinput" id="textinput-lpostinro" value=<?php echo "'" . $lasku->getPostinro() . "'" ?>>
                
            </div>

            <input type="submit" name="SubmitButton" value="Tallenna">
            <input type="submit" name="DeleteButton" value="Poista">

        <?php
        } else {
            echo "<p>ei näytettäviä tietoja</p><p><a href='?sivu=laskutusA.php'>Palaa</a></p>";
        }
        ?>
    
    

    </form>
</div>
