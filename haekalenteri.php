<?php
    if ($_GET['q'])
    {
        include_once("modules/tietokanta.php");
        include_once("modules/palvelu.php");
        // include_once("modules/toimipiste.php");
        include_once("modules/asiakas.php");
        $tk = new Tietokanta;
        $varauskalenteri = $tk->HaePalvelunVarauskalenteri($_GET['q']);
        
        ?>
        const varaus = {
                alkupaiva: '',
                loppupaiva: ''
            }

            let varaukset = [];
            var v;
        <?php
        foreach ($varauskalenteri as $varaus)
        {
            echo "v = Object.create(varaus);\n";
            echo "v.alkupaiva = '" . $varaus["varauksen_aloituspvm"] . "';\n";
            echo "v.loppupaiva = '" . $varaus["varauksen_lopetuspvm"] . "';\n";
            echo "varaukset.push(v);\n";
        }
        
        echo "luoKalenteri(null, 0, true);\n";
    }
?>