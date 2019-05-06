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

function haeKalenteri()
{
    var s = document.getElementById('majoitus');
    var str = s.options[s.selectedIndex].value;

    if (str.length == 0) { 
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("scriptcontainer").innerHTML = this.responseText;
                //sulje();
                luoKalenteri(null, 0, true);
                console.log("joo");
            }
        };
        xmlhttp.open("GET", "haekalenteri.php?q=" + str, true);
        xmlhttp.send();
    }
    //document.getElementById('alkupvm').focus();
}

function haeKalenteriHakusanalla(str)
{
    if (str.length == 0) { 
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("scriptcontainer").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "haekalenteri.php?q=" + str, true);
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