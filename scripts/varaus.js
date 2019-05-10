var edellinenValinta = null;

    function ValitsePaivaKalenterista(palveluid, paivamaara)
    {
        var alkupaiva = document.getElementById('alkupvm');
        var loppupaiva = document.getElementById('loppupvm');

        if (edellinenValinta == null || edellinenValinta == 'loppupaiva')
            {
                alkupaiva.value = paivamaara;
                edellinenValinta = 'alkupaiva';
            }
        else
            {
                var ap = new Date(alkupaiva.value + " 00:00");
                var lp = new Date(paivamaara + " 00:00");

                if (ap < lp)
                {
                    edellinenValinta = 'loppupaiva';
                    TarkistaVaraus(palveluid, alkupaiva.value, paivamaara);
                    loppupaiva.value = paivamaara;
                }
                else
                {
                    document.getElementById('alkupvm').value = "";
                    document.getElementById('loppupvm'). value = "";
                    edellinenValinta = 'loppupaiva';
                }
            }
        

        var valittupaiva = document.getElementById(paivamaara);
        //valittupaiva.setAttribute("style", "background-color: #0F0");
    }

function TarkistaVaraus(palveluid, alkupaiva, loppupaiva)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText == 'varattu')
            {
                window.alert('Valitsemillasi päivillä ei ole mahdollista varata kyseistä majoitusta.');
                document.getElementById('alkupvm').value = "";
                document.getElementById('loppupvm'). value = "";
            }
        }
    };
    xmlhttp.open("GET", "tarkastavaraus.php?a=" + alkupaiva + "&l=" + loppupaiva + "&palveluid=" + palveluid, true);
    xmlhttp.send();
}

function haeAsiakas(str)
{
    if (str.length == 0) { 
        document.getElementById("asiakascontainer").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("asiakascontainer").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "haeasiakkaat.php?q=" + str, true);
        xmlhttp.send();
    }
}

function haeAsiakkaat(str)
{
    
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("asiakaslistaus").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "haeasiakkaat.php?q=" + str + "&asiakaslistaus=1", true);
        xmlhttp.send();
}


function haePalvelut()
{
    var s = document.getElementById('toimipiste');
    var str = s.options[s.selectedIndex].value;

    if (str.length == 0) { 
        document.getElementById("majoituscontainer").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("majoituscontainer").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "haepalvelut.php?p=1&q=" + str, true);
        xmlhttp.send();
    }
}

function haeLisapalvelut()
{
    var s = document.getElementById('toimipiste');
    var str = s.options[s.selectedIndex].value;
    
    if (str.length == 0) { 
        document.getElementById("lisapalvelucontainer").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lisapalvelucontainer").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "haepalvelut.php?p=2&q=" + str, true);
        xmlhttp.send();
    }
}

function haeVarauksenLisapalvelut(toimipisteid, varausid)
{
    if (toimipisteid.length == 0) { 
        document.getElementById("lisapalvelucontainer").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lisapalvelucontainer").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "haepalvelut.php?p=2&q=" + toimipisteid + "&varausid=" + varausid, true);
        xmlhttp.send();
    }
}

function haeKalenteriKuukausiJaVuosi(kuukausi, vuosi)
{
    var s = document.getElementById('majoitusid');
    var str = s.options[s.selectedIndex].value;

    if (str.length == 0) { 
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("kalenteri").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "luovarauskalenteri.php?palveluid=" + str + "&k=" + kuukausi + "&v=" + vuosi, true);
        xmlhttp.send();
    }
}

function haeKalenteri()
{
    var s = document.getElementById('majoitusid');
    var str = s.options[s.selectedIndex].value;

    if (str.length == 0) { 
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("kalenteri").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "luovarauskalenteri.php?palveluid=" + str, true);
        xmlhttp.send();
    }
    //document.getElementById('alkupvm').focus();
}

function haeMajoituksenKalenteriKuukausiJaVuosi(palveluid, kuukausi, vuosi, omavarausA, omavarausL)
{
    if (palveluid.length == 0) { 
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("kalenteri").innerHTML = this.responseText;
            }
        };
        if (typeof omavarausA === 'undefined' && typeof omavarausL === 'undefined')
        {
            xmlhttp.open("GET", "luovarauskalenteri.php?palveluid=" + palveluid + "&k=" + kuukausi + "&v=" + vuosi, true);
            xmlhttp.send();
        }
        else
        {
            
            xmlhttp.open("GET", "luovarauskalenteri.php?palveluid=" + palveluid + "&k=" + kuukausi + "&v=" + vuosi + "&omavarausA=" + omavarausA + "&omavarausL=" + omavarausL, true);
            xmlhttp.send();
        }
    }
}

function haeKalenteriHakusanalla(str)
{
    if (str.length == 0) { 
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("kalenteri").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "luovarauskalenteri.php?palveluid=" + str, true);
        xmlhttp.send();
    }
}

function haeVaraukset()
{
    var s = document.getElementById('toimipiste');
    var str = s.options[s.selectedIndex].value;

    if (str.length == 0) { 
        document.getElementById("hakucontainer").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("hakucontainer").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "haevaraukset.php?&toimipiste=" + str, true);
        xmlhttp.send();
    }
}

function haeVarauksista(str)
{
    if (str.length == 0) { 
        document.getElementById("hakucontainer").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("hakucontainer").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "haevaraukset.php?&hakusana=" + str, true);
        xmlhttp.send();
    }
}

function poistaVaraus()
{
    var varausid = document.getElementById("varausid").value;
    
    if (confirm('Haluatko varmasti poistaa varauksen?')) 
    {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                window.location='?sivu=varaukset';
            }
        };
        xmlhttp.open("GET", "poistavaraus.php?&q=" + varausid, true);
        xmlhttp.send();
    } else {
        // Do nothing!
    }
}

function haeLaskuttamattomatVaraukset()
{
    var s = document.getElementById('toimipiste');
    var str = s.options[s.selectedIndex].value;

    if (str.length == 0) { 
        document.getElementById("hakucontainer").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("hakucontainer").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "haelaskuttamattomatvaraukset.php?&toimipiste=" + str, true);
        xmlhttp.send();
    }
}

function haeLaskuttamattomistaVarauksista(str)
{
    if (str.length == 0) { 
        document.getElementById("hakucontainer").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("hakucontainer").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "haelaskuttamattomatvaraukset.php?&hakusana=" + str, true);
        xmlhttp.send();
    }
}
