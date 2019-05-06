<div class="kalenteri_container" id="kal">
    <h2>Valitse ajankohta</h2>
    Alkaen
    <?php if ($_GET['sivu'] == 'luovaraus')
    { ?>
    <input type="text" class="textinput" id="alkupvm" name="alkupvm" readonly onFocus="luoKalenteri('alkupvm', 0, true); return false;" value="Valitse aloituspvm" />
    <?php 
    }
    else
    {
    ?>
    <input type="text" class="textinput" id="alkupvm" name="alkupvm" readonly onFocus="luoKalenteri('alkupvm', 0, false); return false;" value="Valitse aloituspvm" />
    <?php
    }
    ?>
    Päättyen
    <?php if ($_GET['sivu'] == 'luovaraus')
    { ?>
    <input type="text" class="textinput" id="loppupvm" name="loppupvm" readonly onFocus="luoKalenteri('loppupvm', 0, true); return false;" value="Valitse aloituspvm" />
    <?php 
    }
    else
    {
    ?>
    <input type="text" class="textinput" id="loppupvm" name="loppupvm" readonly onFocus="luoKalenteri('loppupvm', 0, false); return false;" value="Valitse päättymispvm" />
    <?php
    }
    ?>
    <div id="kalenteri" class="kalenteri">
    </div>
</div>