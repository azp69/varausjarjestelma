<?php
session_start();
if (!isset($_SESSION["luokka"]))
{
    die("Kirjaudu sisään.");
}
?>

<?php
    include_once("modules/tietokanta.php");
    include_once("modules/toimipiste.php");
    
    if (isset($_GET['hakusana']))
    {
        $tk = new Tietokanta;
        
        if ($_GET['hakusana'] != "") {
            $toimipisteet = $tk->haeLike($_GET['hakusana'], 1);
        } else {
            $toimipisteet = $tk->haeKaikkiToimipisteet();
        }

        if ($toimipisteet != null) {
            foreach ($toimipisteet as &$toimipiste){   
                echo "<div class='keskita'> <a href='index.php?sivu=toimipisteentiedot&id=" . $toimipiste->getToimipisteId() . "'>" . $toimipiste->getNimi() . "</a></div>\n";
            }
        } else {
            echo "<p>Ei osumia</p>";
        }
        
    }
?>