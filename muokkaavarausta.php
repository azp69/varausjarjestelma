<?php
    include_once('modules/tietokanta.php');
    include_once('modules/varaus.php');
    include_once('modules/asiakas.php');
    include_once('modules/palvelu.php');

    if (isset($_POST['submit']) && isset($_POST['asiakasid']))
    {
        $lisapalvelut = array();
        $lisapalveluidenlkm = array();

        foreach ($_POST['lisapalveluid'] as $palveluid)
        {
            array_push($lisapalvelut, $palveluid);
            array_push($lisapalveluidenlkm, $_POST['lisapalvelu' . $palveluid]);
        }
        
        $tk = new Tietokanta;
        //$tk->LisaaVaraus($_POST['asiakasid'], $_POST['toimipisteid'], date("Y-m-d"), date("Y-m-d"), $_POST['alkupvm'], $_POST['loppupvm'], $_POST['majoitusid'], $lisapalvelut, $lisapalveluidenlkm);
    }
?>

<?php

    $tk = new Tietokanta;
    $varaus = $tk->HaeVaraus($_GET['varausid']);

    $varausalkupvm = $varaus->getVarattuAlkupvm();
    $varausloppupvm = $varaus->getVarattuLoppupvm();

    $alku = explode(" ", $varausalkupvm);
    $loppu = explode(" ", $varausloppupvm);

    $majoitusid = $varaus->getMajoitusID();

    $asiakas = $varaus->getAsiakas();
?>

<form name="muokkaa_varausta" method="post" action="?sivu=muokkaavarausta">
<script src="scripts/varaus.js">
</script>

<h2>Muokkaa varausta</h2>

<h2>Asiakkaan tiedot</h2>
<b>Asiakas</b> <?php echo $asiakas->getEtunimi() . " " . $asiakas->getSukunimi(); ?><br />
<b>Puhelinnumero</b> <?php echo $asiakas->getPuhelinnro(); ?><br />
<b>Sähköposti</b> <?php echo $asiakas->getEmail(); ?><br />
<b>Osoite</b><br />
<?php echo $asiakas->getLahiosoite(); ?><br />
<?php echo $asiakas->getPostinro() . " " . $asiakas->getPostitoimipaikka(); ?>

<hr class="erotin" />

<div id="majoituscontainer">
</div>


<div class="kalenteri_container" id="kal">
    <h2>Muuta varauksen ajankohtaa</h2>
    Alkaen
    <input type="text" class="textinput" id="alkupvm" name="alkupvm" readonly onFocus="luoKalenteri('alkupvm', 0); return false;" value="<?php echo $alku[0]; ?>" />
    Päättyen
    <input type="text" class="textinput" id="loppupvm" name="loppupvm" readonly onFocus="luoKalenteri('loppupvm', 0); return false;" value="<?php echo $loppu[0]; ?>" />
    <div id="kalenteri" class="kalenteri">
    </div>
</div>

<script src="scripts/kalenteri.js"></script>

<script>
const varaus = {
                alkupaiva: '',
                loppupaiva: ''
            }

            var varaukset = [];
            var v;

    <?php
    $varauskalenteri = $tk->HaePalvelunVarauskalenteri($majoitusid);
       
    foreach ($varauskalenteri as $v)
    {
        echo "v = Object.create(varaus);\n";
        echo "v.alkupaiva = '" . $v["varauksen_aloituspvm"] . ";'\n";
        echo "v.loppupaiva = '" . $v["varauksen_lopetuspvm"] . ";'\n";
        echo "varaukset.push(v);\n";
    }
    echo "luoKalenteri(null, 0);\n";
    echo "haeVarauksenLisapalvelut(" . $varaus->getToimipisteID() . "," . $varaus->getVarausId() .");";
?>

// haeToimipisteeseenKuuluvatPalvelut($toimipisteenID, $palvelunTyyppi)

</script>
<script id="scriptcontainer"></script>

<hr class="erotin"/>

<h2>Lisäpalvelut</h2>
<div id="lisapalvelucontainer"></div>
<hr class="erotin"/>

<input type="submit" class="button_default" value="Vahvista" />
<input type="button" class="button_default" value="Peruuta" onclick="window.location='?sivu=varaukset';" />
<input type="submit" class="button_default" value="Poista" />

</form>