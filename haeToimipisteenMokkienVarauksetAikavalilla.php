<?php
session_start();
if (!isset($_SESSION["luokka"]))
{
    die("Kirjaudu sisään.");
}
?>

<?php 

if ($_GET['id'] && $_GET['apvm'] && $_GET['lpvm']) {
    include_once("modules/tietokanta.php");
    include_once("modules/majoituksenraporttiluokka.php");
    $tk = new Tietokanta;
    $myArr = array();
    $myArr = $tk->haeToimipisteenMokkienVarauksetAikavalilla($_GET['id'], $_GET['apvm'], $_GET['lpvm']);
    
    $myJSON = json_encode($myArr);
    
    echo $myJSON;
}


?>