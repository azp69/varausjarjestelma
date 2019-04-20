<?php

    include_once("modules/tietokanta.php");
    include_once("modules/palvelu.php");
    include_once("modules/toimipiste.php");

    $tk = new Tietokanta;

    if ($_GET['toimipiste'] == "")
    {
        $toimipisteet = array();

        $toimipisteet = $tk->HaeToimipisteet();
    
        ?>
        <h2>Valitse toimipiste</h2>
    
        <?php
        foreach ($toimipisteet as $tp)
        {
            echo "<a href='?sivu=varaukset&toimipiste=" . $tp->getToimipisteId() . "'>" . $tp->getNimi() . "</a><br />";
        }

    }

    else if ($_GET['toimipiste'] && $_GET['palveluid']) // toimipiste ja palvelu valittuna
    {
        

        ?>
        <script>
            const varaus = {
                alkupaiva: '',
                loppupaiva: ''
            }

            var varaukset = [];
            var v;
        
        <?php

        $varauskalenteri = $tk->HaePalvelunVarauskalenteri($_GET['palveluid']);
        
        foreach ($varauskalenteri as $varaus)
        {
            echo "v = Object.create(varaus);\n";
            echo "v.alkupaiva = '" . $varaus["varauksen_aloituspvm"] . ";'\n";
            echo "v.loppupaiva = '" . $varaus["varauksen_lopetuspvm"] . ";'\n";
            echo "varaukset.push(v);\n";
        }
        echo "</script>\n";
                

        $toimipiste = $tk->HaeToimipiste($_GET['toimipiste']);
        $palvelu = $tk->haePalvelu($_GET['palveluid']);

        echo "Valittu toimipiste: <b>" . $toimipiste->getNimi() . "</b><br />";
        echo "Valittu palvelu: <b>" . $palvelu->getNimi() . "</b><br />";        
        
        include('kalenteri.php');
    }
    
    else
    {
        ?>
        <h2>Valitse majoitus</h2>
        
        <?php

        $palvelunTyyppi = 1;
        $palvelut = array();
        $palvelut = $tk->haeToimipisteeseenKuuluvatPalvelut($_GET['toimipiste'], $palvelunTyyppi);

        foreach ($palvelut as $palvelu)
        {
            echo "<a href='?sivu=varaukset&toimipiste=" . $_GET['toimipiste'] . "&palveluid=" . $palvelu->getPalveluId() . "'> " . $palvelu->getNimi() . "</a><br />";
        }
        
    }
   
 
?>

