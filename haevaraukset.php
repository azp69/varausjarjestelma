<?php
    include_once("modules/tietokanta.php");
    include_once("modules/asiakas.php");
    include_once("modules/varaus.php");
    
    if (isset($_GET['toimipiste']) || isset($_GET['hakusana']))
    {
        $tk = new Tietokanta;
        $varaukset = "";

        if (isset($_GET['toimipiste']))
        {
            $varaukset = $tk->HaeVarauksistaToimipisteella($_GET['toimipiste']);
        }
        else if (isset($_GET['hakusana']))
        {
            $varaukset = $tk->HaeVarauksista($_GET['hakusana']);
        }
        ?>

        <table>
        <tr>
        <td>VarausID</td><td>Asiakkaan nimi</td><td>Varauspäivä</td><td>Vahvistuspäivä</td><td>Varauksen aloituspäivä</td><td>Varauksen päättymispäivä</td>
        </tr>
        
        <?php 
        foreach ($varaukset as $varaus)
        {
            ?>
            <tr>
            <td>
            <a href="?sivu=muokkaavarausta&varausid=<?php echo $varaus->getVarausID(); ?>">
            <?php echo $varaus->getVarausID(); ?>
            </a>
            </td>
            <td>
            <a href="?sivu=asiakkaat&asiakasid=<?php echo $varaus->getAsiakas()->getAsiakasId(); ?>">
            <?php echo $varaus->getAsiakas()->getSukunimi() . " " . $varaus->getAsiakas()->getEtunimi(); ?>
            </a>
            </td>
            <td>
            <?php echo date("d.m.Y", strtotime($varaus->getVarattuPvm())); ?>
            </td>
            <td>
            <?php echo date("d.m.Y", strtotime($varaus->getVahvistusPvm())); ?>
            </td>
            <td>
            <?php echo date("d.m.Y", strtotime($varaus->getVarattuAlkupvm())); ?>
            </td>
            <td>
            <?php echo date("d.m.Y", strtotime($varaus->getVarattuLoppupvm())); ?>
            </td>
            </tr>
            <?php
        }
        echo "</table>\n";
    }
?>