<?php

    include_once("modules/tietokanta.php");
        
    $tk = new Tietokanta;

    if ($_POST['nimi'] && $_POST['kuvaus'] && $_POST['sijainti'] && $_POST['hinta'])
    {
        $tk->LisaaMokki($_POST['nimi'], $_POST['kuvaus'], $_POST['sijainti'], $_POST['hinta']);
    }
    else
    {
        ?>
        <form method="post" action="lisaamokki.php">
        Mökin nimi <input type="text" name="nimi" value="" /><br />
        Mökin kuvaus <input type="text" name="kuvaus" value="" /><br />
        Mökin sijainti <input type="text" name="sijainti" value="" /><br />
        Mökin hinta <input type="text" name="hinta" value="" /><br />
        <input type="submit" value="Lisää" />
        </form>
        <?php
    }
    

?>
