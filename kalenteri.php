<script src="scripts/kalenteri.js"></script>
<div class="kalenteri_container">
    <h2>Valitse varauksen ajankohta</h2>
    Alkaen
    <input type="text" class="textinput" id="alkupvm" name="alkupvm" onClick="luoKalenteri('alkupvm', 0)" value="Valitse aloituspvm" />
    Päättyen
    <input type="text" class="textinput" id="loppupvm" name="loppupvm" onClick="luoKalenteri('loppupvm', 0)" value="Valitse päättymispvm" />
    <div id="kalenteri" class="kalenteri">
    </div>
</div>