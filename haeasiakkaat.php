<?php
session_start();
if (!isset($_SESSION["luokka"]))
{
    die("Kirjaudu sisään.");
}
?>

<?php
    session_start();
    // Apuskripti asiakkaiden listausta varten
    if (isset($_GET['q']) && isset($_GET['asiakaslistaus'])) // asiakas-sivun listaus
    {
        include_once("modules/tietokanta.php");
        include_once("modules/asiakas.php");

        $tk = new Tietokanta;
        $asiakkaat = $tk->HaeAsiakkaatHakusanalla($_GET['q']);
        
        if ($asiakkaat != null)
        {
            echo '<tr style="text-align:left;">';
            echo "<th>Nimi</th><th>Puhelinnumero</th><th>Lähiosoite</th><th>Postinumero</th><th>Postitoimipaikka</th>\n</tr>";

            foreach ($asiakkaat as &$asiakas)
            {
                echo "<tr>";
                echo '<td><a href="?sivu=asiakastiedot&id=' . $asiakas->getAsiakasId() . '">' . $asiakas->getSukunimi() . ' ' . $asiakas->getEtunimi() . '</a></td>';
                echo '<td>' . $asiakas->getPuhelinnro() . '</td>';
                echo '<td>' . $asiakas->getLahiosoite() . '</td>';
                echo '<td>' . $asiakas->getPostinro() . '</td>';
                echo '<td>' . $asiakas->getPostitoimipaikka() . '</td>';
                echo '</tr>';
            }
        }

    }
    else if ($_GET['q']) // varauksen luontiin asiakkaiden listaus
    {
        include_once("modules/tietokanta.php");
        include_once("modules/asiakas.php");
        
        $tk = new Tietokanta;
        $asiakkaat = $tk->HaeAsiakkaatHakusanalla($_GET['q']);
        
        if ($asiakkaat != null)
        {
            echo "<select name='asiakasid' class='dropdownmenu'>\n";

            foreach ($asiakkaat as $asiakas)
            {
                echo "<option value='" . $asiakas->getAsiakasId() . "'>". $asiakas->getSukunimi() . " " . $asiakas->getEtunimi() ."</option>\n";
            }
            echo "</select>\n";
        }
    }

    
?>