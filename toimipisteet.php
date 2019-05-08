<?php
session_start();
if (!isset($_SESSION["luokka"]))
{
    die("Kirjaudu sisään.");
}
?>

<?php
    // haetaan toimipisteet tietokannasta
    $tk = new Tietokanta;
    $toimipisteet = array();
    $toimipisteet = $tk->haeKaikkiToimipisteet();

    if ($toimipisteet == null) {
        echo "Ei hakutuloksia";
    } else { ?> 

    <div class="listaus">
        <h1>Toimipaikan valinta</h1>
        <?php
            // listataan kaikki toimipisteet linkkeinä, joista pääsee tarkastelemaan toimipisteiden tietoja
            foreach ($toimipisteet as &$toimipiste){   
                echo "<div class='keskita'> <a href='index.php?sivu=toimipisteentiedot&id=" . $toimipiste->getToimipisteId() . "'>" . $toimipiste->getNimi() . "</a></div>";
            }
        }
    ?>
    </div>