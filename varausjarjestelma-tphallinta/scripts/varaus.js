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