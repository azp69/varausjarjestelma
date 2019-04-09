function luoKalenteri(inputti, kkOffset) // inputti = aloitus / lopetuspvm, kkOffset = kuukauden offset vrt. nyt
{
    var varauksenAlkupaiva = new Date(document.getElementById('alkupvm').value); // varauksen alkupäivä
    var varauksenLoppupaiva = new Date(document.getElementById('loppupvm').value); // varauksen loppupäivä
    
    var kuukaudenOffset = 0;
    if (kkOffset == null)
        kuukaudenOffset = 0;
    else
        kuukaudenOffset = kkOffset;

    var viikonpaivat = ["Ma", "Ti", "Ke", "To", "Pe", "La", "Su"];
    var kuukaudet = ["Tammikuu", "Helmikuu", "Maaliskuu", "Huhtikuu", "Toukokuu", "Kesäkuu", "Heinäkuu", "Elokuu", "Syyskuu", "Lokakuu", "Marraskuu", "Joulukuu"];

    var kalenteriContainer = document.getElementById("kalenteri");

    var date = new Date();
    var kkEkaPaiva = new Date(date.getFullYear(), date.getMonth() + kuukaudenOffset, 1);
    var kkVikaPaiva = new Date(date.getFullYear(), date.getMonth() + kuukaudenOffset + 1, 0);

    kalenteriContainer.innerHTML = "<a href='javascript:luoKalenteri(\"" + inputti + "\", " + (kuukaudenOffset - 1) +")'> << </a>";
    kalenteriContainer.innerHTML += kuukaudet[kkEkaPaiva.getMonth()];
    kalenteriContainer.innerHTML += " " + kkEkaPaiva.getFullYear();
    kalenteriContainer.innerHTML += "<a href='javascript:luoKalenteri(\"" + inputti + "\", " + (kuukaudenOffset + 1) +")'> >> </a>";
        
    var taulukko = document.createElement("table");
    var taulukonRivi = document.createElement("tr");
    
    taulukko.setAttribute("style", "margin-left:auto; margin-right:auto");

    kalenteriContainer.appendChild(taulukko);
    taulukko.appendChild(taulukonRivi);
    
    var kkEkaViikonpaiva = kkEkaPaiva.getDay(); // Ensimmäisen päivän viikonpäivä: 0-6
    var paiviaKuukaudessa = kkVikaPaiva.getDate(); // Montako päivää kyseisessä kuussa

    for (var i = 0; i < 7; i++)
    {
        var taulukonSarake = document.createElement("td");
        taulukonRivi.appendChild(taulukonSarake);
        taulukonSarake.textContent = viikonpaivat[i];
    }    

    taulukonRivi = document.createElement("tr");
    taulukko.appendChild(taulukonRivi);

    var juoksevaPaiva = 0;
    var kkPaiva = 1;


    if (kkEkaViikonpaiva == 0)
        kkEkaViikonpaiva = 7; // vakiona viikko alkaa sunnuntaista, eli 0, joten muutetaan sunnuntai == 7
    do
    {
        var linkki = document.createElement("a");
        var taulukonSarake = document.createElement("td");
        taulukonRivi.appendChild(taulukonSarake);

        if (juoksevaPaiva >= kkEkaViikonpaiva -1)
        {
            linkki.setAttribute('href', '#');
            taulukonSarake.onclick = function() { valitsePaiva(inputti, this) };
            
            var paivaString = muodostaPaivamaara(kkEkaPaiva, kkPaiva);
            var paivamaara = new Date(paivaString);

            taulukonSarake.setAttribute('id', paivaString);
            
            if (varauksenAlkupaiva <= paivamaara && varauksenLoppupaiva >= paivamaara)
                taulukonSarake.setAttribute("style", "background-color: #F00");
            
            linkki.textContent = kkPaiva++;
            taulukonSarake.appendChild(linkki);
        }
              
        juoksevaPaiva++;  
        if (juoksevaPaiva % 7 == 0)
        {
            taulukonRivi = document.createElement("tr");
            taulukko.appendChild(taulukonRivi);
        }
    } while (kkPaiva <= paiviaKuukaudessa);

    var suljelinkki = document.createElement("a");
    suljelinkki.setAttribute("href", "javascript:sulje()");
    suljelinkki.textContent = "Sulje";
    kalenteriContainer.appendChild(suljelinkki);
}

function valitsePaiva(inp, el)
{
    var inputti = document.getElementById(inp);
    inputti.value = el.id;
    luoKalenteri(inp, 0);
}

function sulje()
{
    var container = document.getElementById("kalenteri");
    container.innerHTML = "";
}

function muutaPaivamaara(paivaString)
{
    var paivamaara = paivaString.split("-");
    return paivamaara[2] + "." + paivamaara[1] + "." + paivamaara[0];
}

function muodostaPaivamaara(kkEkaPaiva, kkPaiva)
{
    var kpaiva, kkuukausi, kvuosi;

    kvuosi = kkEkaPaiva.getFullYear();
    if ((kkEkaPaiva.getMonth()) < 10)
    {
        kkuukausi = "0" + (kkEkaPaiva.getMonth() + 1);
    }
    else
        kkuukausi = (kkEkaPaiva.getMonth() + 1);

    if (kkPaiva < 10)
    {
        kpaiva = "0" + kkPaiva;
    }
    else
        kpaiva = kkPaiva;

    var paivaString = "" + kvuosi + "-" + kkuukausi + "-" + kpaiva + "";
    return paivaString;
}