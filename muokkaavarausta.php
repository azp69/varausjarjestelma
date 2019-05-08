<?php
    include_once('modules/tietokanta.php');
    include_once('modules/varaus.php');
    include_once('modules/asiakas.php');
    include_once('modules/palvelu.php');
    include_once('modules/varauksenpalvelut.php');

    if (isset($_POST['varausid']))
    {
        $aloituspvm = $_POST['alkupvm'];
        $lopetuspvm = $_POST['loppupvm'];
        
        $varauksenpalvelut = array();

        foreach ($_POST['lisapalveluid'] as $palveluid)
        {
            $varauksenpalvelu = new VarauksenPalvelut($_POST['varausid'], $palveluid, $_POST['lisapalvelu' . $palveluid]);
            $varauksenpalvelut[] = $varauksenpalvelu;
        }
        
        $tk = new Tietokanta;

        if ($tk->PaivitaVaraus($_POST['varausid'], $_POST['majoitusid'], $aloituspvm, $lopetuspvm, $varauksenpalvelut))
            echo "Varaus päivitettiin onnistuneesti!<br />";
    }
?>

<?php
    if ($_GET['varausid'])
    {
    }
    else
        die;

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
<input type="hidden" id="varausid" name="varausid" value="<?php echo $_GET['varausid']; ?>">
<input type="hidden" name="majoitusid" value="<?php echo $majoitusid; ?>">
<hr class="erotin" />

<div id="majoituscontainer">
</div>


<div class="kalenteri_container" id="kal">
    <h2>Muuta varauksen ajankohtaa</h2>
    Alkaen
    <input type="text" class="textinput" id="alkupvm" name="alkupvm" readonly value="<?php echo $alku[0]; ?>" />
    Päättyen
    <input type="text" class="textinput" id="loppupvm" name="loppupvm" readonly value="<?php echo $loppu[0]; ?>" />
    <div id="kalenteri" class="kalenteri">
    </div>
</div>

<script>

<?php
    $varauskalenteri = $tk->HaePalvelunVarauskalenteri($majoitusid);
    $aika = explode("-", $alku[0]);
    $kuukausi = $aika[1];
    $vuosi = $aika[0];

    echo "haeMajoituksenKalenteriKuukausiJaVuosi($majoitusid, $kuukausi, $vuosi, '$alku[0]', '$loppu[0]');\n";
    
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
<input type="button" class="button_default" value="Poista" onclick="poistaVaraus();"/>

</form>