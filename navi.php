<?php
    session_start();

    if ($_SESSION["luokka"] > 0)
    {

    
?>

<div id="navi" class="navi">
    <div class="navilink_selected" onmouseover="avaaValikko('toimipaikat_submenu')" onmouseout="suljeValikko('toimipaikat_submenu')">
        <a href="?">
            <p>Toimipaikat</p>
        </a>
        <div class="navi_submenu" id="toimipaikat_submenu" style="display:none;">
            <p>Listaa</p>
            <p>Lisää</p>
            <p>Muokkaa</p>
            <p>Poista</p>
        </div>
    </div>
        
    <div class="navilink" onmouseover="avaaValikko('mokit_submenu')" onmouseout="suljeValikko('mokit_submenu')">
        <a href="?">
            <p>Mökit</p>
        </a>
        <div class="navi_submenu" id="mokit_submenu" style="display:none;">
            <p>Listaa</p>
            <p>Lisää</p>
            <p>Muokkaa</p>
            <p>Poista</p>
        </div>
    </div>
        
    <div class="navilink" onmouseover="avaaValikko('palvelut_submenu')" onmouseout="suljeValikko('palvelut_submenu')">
        <a href="?">
            <p>Palvelut</p>
        </a>
        <div class="navi_submenu" id="palvelut_submenu" style="display:none;">
            <p>Jotain</p>
            <p>Shittiä</p>
        </div>
    </div>

    <div class="navilink" onmouseover="avaaValikko('varaukset_submenu')" onmouseout="suljeValikko('varaukset_submenu')">
        <a href="?sivu=varaukset">
            <p>Varaukset</p>
        </a>
        <div class="navi_submenu" id="varaukset_submenu" style="display:none;">
            <a href="?sivu=luovaraus">
                <p>Uusi varaus</p>
            </a>
        </div>
    </div>

    <div class="navilink" onmouseover="avaaValikko('laskutus_submenu')" onmouseout="suljeValikko('laskutus_submenu')">
        <a href="?">
            <p>Laskutus</p>
        </a>
        <div class="navi_submenu" id="laskutus_submenu" style="display:none;">
            <p>Listaa</p>
            <p>Lisää</p>
            <p>Muokkaa</p>
            <p>Poista</p>
        </div>
    </div>
        
    <div class="navilink" onmouseover="avaaValikko('kayttajat_submenu')" onmouseout="suljeValikko('kayttajat_submenu')">
        <a href="?">
            <p>Käyttäjät</p>
        </a>
        <div class="navi_submenu" id="kayttajat_submenu" style="display:none;">
            <p>Listaa</p>
            <p>Lisää</p>
            <p>Muokkaa</p>
            <p>Poista</p>
        </div>
    </div>

    <?php
    }
    else
    {

    }

    if ($_SESSION["luokka"] > 1) // admin valikko
    {

    ?>

    <div class="navilink" onmouseover="avaaValikko('admin_submenu')" onmouseout="suljeValikko('admin_submenu')">
        <a href="?">
            <p>Admin</p>
        </a>
        <div class="navi_submenu" id="admin_submenu" style="display:none;">
            <p>Listaa</p>
            <p>Lisää</p>
            <p>Muokkaa</p>
            <p>Poista</p>
        </div>
    </div>

        <?php
    }
    else
    {

    }
?>

</div>
