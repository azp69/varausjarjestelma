<?php
session_start();
if (!isset($_SESSION["luokka"]))
{
    die("Kirjaudu sisään.");
}
?>

<?php
    include_once("modules/tietokanta.php");

    if (isset($_GET['q']))
    $tk = new Tietokanta;

    $tk->PoistaVaraus($_GET['q']);
?>