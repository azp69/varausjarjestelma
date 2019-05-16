<?php
    session_start();

    if (isset($_SESSION["luokka"]))
    {

    
?>

<div id="navi" class="navi">
    <?php if ($_GET['sivu'] == "toimipisteet" || $_GET['sivu'] == "muokkaa")
    {
        ?>
    <div class="navilink_selected" onmouseover="avaaValikko('toimipaikat_submenu')" onmouseout="suljeValikko('toimipaikat_submenu')">
    <?php    
    }
    else
    {
        ?>
        <div class="navilink" onmouseover="avaaValikko('toimipaikat_submenu')" onmouseout="suljeValikko('toimipaikat_submenu')">
        <?php
    }
    ?>
        <a href="?sivu=toimipisteet">
            <p>Toimipisteet</p>
        </a>
        <div class="navi_submenu" id="toimipaikat_submenu" style="display:none;">
            <p><a href="?sivu=muokkaa&id=0">Luo uusi</p></a>
        </div>
    </div>
    
    <?php if ($_GET['sivu'] == "varaukset" || $_GET['sivu'] == "luovaraus")
    {
        ?>
    <div class="navilink_selected" onmouseover="avaaValikko('varaukset_submenu')" onmouseout="suljeValikko('varaukset_submenu')">
    <?php    
    }
    else
    {
    ?>
    <div class="navilink" onmouseover="avaaValikko('varaukset_submenu')" onmouseout="suljeValikko('varaukset_submenu')">
    <?php
    }
    ?>
        <a href="?sivu=varaukset">
            <p>Varaukset</p>
        </a>
        <div class="navi_submenu" id="varaukset_submenu" style="display:none;">
            <p><a href="?sivu=luovaraus">Luo uusi</p></a>
        </div>
    </div>


    <?php if ($_GET['sivu'] == "laskutusA" || $_GET['sivu'] == "muokkaalaskua")
    {
        ?>
    <div class="navilink_selected" onmouseover="avaaValikko('laskutus_submenu')" onmouseout="suljeValikko('laskutus_submenu')">
    <?php    
    }
    else
    {
    ?>
    <div class="navilink" onmouseover="avaaValikko('laskutus_submenu')" onmouseout="suljeValikko('laskutus_submenu')">
    <?php
    }
    ?>
        <a href="?sivu=laskutusA">
            <p>Laskutus</p>
        </a>
        <div class="navi_submenu" id="laskutus_submenu" style="display:none;">
            <p><a href="?sivu=valitselaskuttamattomatvaraukset">Luo uusi</a></p>
                     
        </div>
    </div>
        
    <?php if ($_GET['sivu'] == "asiakaslistaus" || $_GET['sivu'] == "lisaaasiakas")
    {
        ?>
    <div class="navilink_selected" onmouseover="avaaValikko('kayttajat_submenu')" onmouseout="suljeValikko('kayttajat_submenu')">
    <?php    
    }
    else
    {
    ?>
    <div class="navilink" onmouseover="avaaValikko('kayttajat_submenu')" onmouseout="suljeValikko('kayttajat_submenu')">
    <?php
    }
    ?>
        <a href="?sivu=asiakaslistaus">
            <p>Asiakkaat</p>
        </a>
        <div class="navi_submenu" id="kayttajat_submenu" style="display:none;">
            <p><a href="?sivu=lisaaasiakas">Luo uusi</a></p>
        </div>
    </div>

    <?php if ($_GET['sivu'] == "majoituksenraportointi")
    {
        ?>
    <div class="navilink_selected" onmouseover="avaaValikko('majoituksenraportointi_submenu')" onmouseout="suljeValikko('majoituksenraportointi_submenu')">
    <?php    
    }
    else
    {
    ?>
    <div class="navilink" onmouseover="avaaValikko('majoituksenraportointi_submenu')" onmouseout="suljeValikko('majoituksenraportointi_submenu')">
    <?php
    }
    ?>
        <a href="?sivu=majoituksenraportointi">
            <p>Raportointi</p>
        </a>
        <div class="navi_submenu" id="majoituksenraportointi_submenu" style="display:none;">
            <p><a href="?sivu=majoituksenraportointi">Majoitus</a></p>
            <p><a href="?sivu=lisapalveluidenraportointi">Lisäpalvelut</a></p>
        </div>
    </div>

    <?php
    }
    else
    {

    }

?>

<?php if ($_GET['sivu'] == "hallinta")
    {
        ?>
    <div class="navilink_selected" onmouseover="avaaValikko('hallinta_submenu')" onmouseout="suljeValikko('hallinta_submenu')">
    <?php    
    }
    else
    {
    ?>
    <div class="navilink" onmouseover="avaaValikko('hallinta_submenu')" onmouseout="suljeValikko('hallinta_submenu')">
    <?php
    }
    ?>
        <a href="?sivu=hallinta">
            <p>Hallinta</p>
        </a>
    </div>

    
    <div class="navilink">
            <a href="?sivu=logout">
            <p>Kirjaudu ulos</p>
        </a>
    </div>

</div>
