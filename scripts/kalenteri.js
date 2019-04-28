function luoKalenteri(inputti, kkOffset) // inputti = aloitus / lopetuspvm, kkOffset = kuukauden offset vrt. nyt
{
    if (inputti==null)
        inputti = "alkupvm";

    var varauksenAlkupaiva = new Date(document.getElementById('alkupvm').value + " 00:00"); // varauksen alkupäivä
    var varauksenLoppupaiva = new Date(document.getElementById('loppupvm').value + " 00:00"); // varauksen loppupäivä
    
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
        taulukonSarake.style = "font-weight:bold";
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
        
        if (juoksevaPaiva >= kkEkaViikonpaiva -1)
        {
            linkki.setAttribute('href', '#kal');
            taulukonSarake.onclick = function() { valitsePaiva(inputti, this) };
            
            var paivaString = muodostaPaivamaara(kkEkaPaiva, kkPaiva);
            var paivamaara = new Date(paivaString + " 00:00");

            taulukonSarake.setAttribute('id', paivaString);
            
            for (var i = 0; i < varaukset.length; i++)
            {
                var alkupaiva = new Date(varaukset[i].alkupaiva + " 00:00");
                var loppupaiva = new Date(varaukset[i].loppupaiva + " 00:00");

                if ((paivamaara >= alkupaiva) && (paivamaara <= (loppupaiva - 1)))
                {
                    taulukonSarake.setAttribute("style", "background-color: #F00");
                }
            }

            if (varauksenAlkupaiva <= paivamaara && (varauksenLoppupaiva) >= paivamaara)
                taulukonSarake.setAttribute("style", "background-color: #0F0");
                        
            linkki.textContent = kkPaiva++;
            taulukonSarake.appendChild(linkki);
        }

        taulukonRivi.appendChild(taulukonSarake);

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
    // kalenteriContainer.appendChild(suljelinkki);
   
}

function valitsePaiva(inp, el)
{
    var inputti = document.getElementById(inp);
    inputti.value = el.id;
        
    var alkupaiva = new Date(document.getElementById("alkupvm").value + " 00:00");
    var loppupaiva = new Date(document.getElementById("loppupvm").value + " 00:00");
                
    var konflikti = false;

    for (var i = 0; i < varaukset.length; i++)
    {
        var varattuAlkupaiva = new Date(varaukset[i].alkupaiva);
        var varattuLoppupaiva = new Date(varaukset[i].loppupaiva);
    
        
        if (alkupaiva <= varattuAlkupaiva && loppupaiva >= varattuLoppupaiva)
        {
            console.log("Konflikti edellisen varauksen kanssa.");
            konflikti = true;
        }
        if (loppupaiva > varattuAlkupaiva && loppupaiva <= varattuLoppupaiva)
        {
            konflikti = true;
        }
        if (alkupaiva < varattuLoppupaiva && loppupaiva > varattuLoppupaiva)
        {
            konflikti = true;
        }
        if (alkupaiva > loppupaiva)
            konflikti = true;

    }

    if (!konflikti)
    {
        luoKalenteri(inp, 0);
        if (inp=="alkupvm")
            document.getElementById("loppupvm").focus();
        else
        document.getElementById("alkupvm").focus();
    }
    else
    {
        document.getElementById("alkupvm").value = el.id;
        document.getElementById("loppupvm").value = "";
        document.getElementById("loppupvm").focus();
    }
        
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