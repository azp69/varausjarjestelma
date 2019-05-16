<?php
session_start();
if (!isset($_SESSION["luokka"]))
{
    die("Kirjaudu sisään.");
}
?>

<h2>Käyttäjätunnusten hallinta</h2>



<?php
    if (isset($_POST['id']) && isset($_POST['VaihdaSalasana']) && isset($_POST['salasana']) && isset($_POST['uusisalasana']))
    {
        if ($_POST['salasana'] == $_POST['uusisalasana'])
        {
            $onnistuiko = $tk->VaihdaKayttajanSalasana($_POST['id'], $_POST['salasana']);
            if ($onnistuiko)
            {
                echo 'Salasana vaihdettiin onnistuneesti.<br />';
            }
            else
            {
                echo 'Salasanaa ei voitu vaihtaa.<br />';
            }
        }
        else
        {
            echo 'Salasanat eivät täsmää. Salasanaa ei vaihdettu.<br />';
        }
    }
    else if (isset($_POST['uusiKayttaja']) && isset($_POST['tunnus']) && isset($_POST['salasana']) && isset($_POST['uusisalasana']))
    {
        if ($_POST['salasana'] == $_POST['uusisalasana'])
        {
            $onnistuiko = $tk->LuoUusiKayttajatunnus($_POST['tunnus'], $_POST['salasana']);
            
            if ($onnistuiko)
            {
                echo 'Käyttäjä luotiin onnistuneesti.<br />';
            }
            else
            {
                echo 'Käyttäjää ei voitu luoda.<br />';
            }

        }
        else
        {
            echo 'Salasanat eivät täsmää. Käyttäjää ei luotu.<br />';
        }
    }

    if (isset($_GET['toiminto']) && isset($_GET['id']))
    {
        $tunnus = $tk->HaeKayttajatunnus($_GET['id']);

        if ($_GET['toiminto'] == 'muokkaa')
        {
            MuokkaaTunnusta($tunnus);
        }
        else if ($_GET['toiminto'] == 'poista')
        {
            // PoistaTunnus($tunnus);
            $onnistuiko = $tk->PoistaKayttajatunnus($tunnus->getId());

            if ($onnistuiko)
            {
                echo 'Käyttäjä poistettiin.<br />';
            }
            else
            {
                echo 'Käyttäjää ei voitu poistaa.<br />';
            }
        }
        else if ($_GET['toiminto'] == 'VaihdaSalasanaLomake')
        {
            VaihdaSalasanaLomake($tunnus);
        }
        
    }
    else if(isset($_GET['toiminto']))
    {
        if ($_GET['toiminto'] == 'luokayttaja')
        {
            LuoUusiKayttajaLomake();
        }
    }
    else
    {
        $tunnukset = $tk->HaeKayttajatunnukset();
        ?>
        <a href="?sivu=hallinta&toiminto=luokayttaja">Luo uusi käyttäjä</a><br />

        <h3>Käyttäjät</h3>
        <table>
        <tr>
        <th>ID</th><th>Käyttäjätunnus</th>
        </tr>
        <?php
        foreach ($tunnukset as $tunnus)
        {
            echo '<tr><td>'. $tunnus->getId() . '</td><td><a href="?sivu=hallinta&toiminto=muokkaa&id=' . $tunnus->getId() . '">' . $tunnus->getTunnus() . '</a></td></tr>';
        }
        echo "</table>\n";
    }

    function LuoUusiKayttajaLomake()
    {
        echo '<form method="post" action="?sivu=hallinta">';
        echo 'Käyttäjätunnus <br />';
        echo '<input type="text" class="textinput" name="tunnus" value="" /><br />';
        echo 'Salasana<br/> <input type="password" class="textinput" name="salasana" value="" /><br />';
        echo 'Salasana uudelleen<br /> <input type="password" class="textinput" name="uusisalasana" value="" /><br />';
        echo '<input type="submit" class="button_default" name="uusiKayttaja" value="OK">';
        echo '</form>';
    }

    function VaihdaSalasanaLomake($tunnus)
    {
        echo '<form method="post" action="?sivu=hallinta">';
        echo '<input type="hidden" name="id" value="' . $tunnus->getId() . '">';
        echo 'Syötä uusi salasana alle<br/> <input type="password" class="textinput" name="salasana" value="" /><br />';
        echo 'Syötä salasana uudelleen<br /> <input type="password" class="textinput" name="uusisalasana" value="" /><br />';
        echo '<input type="submit" class="button_default" name="VaihdaSalasana" value="OK">';
        echo '</form>';
    }

    function PoistaTunnus($tunnus)
    {
        
        
    }
    
    function MuokkaaTunnusta($tunnus)
    {
        echo "<h3>Muokkaa käyttäjää " . $tunnus->getTunnus() . "</h3>";
        echo '<a href="?sivu=hallinta&toiminto=poista&id='. $tunnus->getId() . '" onclick="return confirm(\'Haluatko varmasti poistaa käyttäjän?\')">Poista käyttäjä</a></br>';
        echo '<a href="?sivu=hallinta&toiminto=VaihdaSalasanaLomake&id='. $tunnus->getId() .'">Vaihda salasana</a><br />';
        echo '<br />';
        echo '<a href="?sivu=hallinta">Takaisin</a>';
    }

?>
</div>