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
            }
        };
        xmlhttp.open("GET", "haekalenteri.php?q=" + str, true);
        xmlhttp.send();
    }
    //document.getElementById('alkupvm').focus();
}