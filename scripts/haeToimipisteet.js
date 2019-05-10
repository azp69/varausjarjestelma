function haeToimipisteista(str)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("listaus").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "haetoimipisteet.php?&hakusana=" + str, true);
    xmlhttp.send();
}
