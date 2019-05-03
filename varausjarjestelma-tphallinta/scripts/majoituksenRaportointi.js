var majoituksenRaportointi;

/**
 * Luo mökkikohtaisen kaavion mökkien täyttöasteista
 * @param {Objektitaulukko, joka sisältää mökkien täyttöasteet} datas 
 * @param {Raportoinnin valittu aloituspvm} apvm 
 * @param {Raportoinnin valittu lopeutspvm} lpvm 
 */
function initMokkikohtainen(datas, apvm, lpvm) {

    var dataPoints = [];

    if (datas == null) {
        document.getElementById("chartContainer").innerHTML = "<p>Valitulla aikavälillä ei näytettävää</p>";
    } else {

        CanvasJS.addColorSet("green",
                [//colorSet Array
                "#4F914F"
                ]);

        var chart = new CanvasJS.Chart("chartContainer", {
            
            colorSet: "green",

            animationEnabled: true,
            theme: "light2",
            title: {
                text: "Mökkien täyttöaste"
            },
            subtitles: [{
                text: "Aikavälillä " + apvm + " - " + lpvm
            }],
            axisY: {
                title: "Prosenttia",
                titleFontSize: 24
            },
            data: [{
                type: "column",
                yValueFormatString: "#.## prosenttia",
                dataPoints: dataPoints
            }]
        });
        
        // pushataan datas-arrayn rivit dataPointteihin
        for (var i = 0; i < datas.length; i++) {
            dataPoints.push({
                label: datas[i].palvelu,
                y: parseFloat(datas[i].tayttoaste)
            });
        }
        chart.render();
    }
}

/**
 * Luo taulukon toimipisteen täyttöasteesta päiväkohtaisesti
 * @param {Objektitaulukko, joka sisältää toimipisteen täyttöasteen yhteensä päiväkohtaisesti} datas 
 * @param {Raportoinnin valittu aloituspvm} apvm 
 * @param {Raportoinnin valittu lopeutspvm} lpvm 
 * @param {Toimipisteen mökkien lukumäärä} varattavissaOlevienMokkienLkm 
 */
function initPaivakohtainen(datas, apvm, lpvm, varattavissaOlevienMokkienLkm) {

    var dataPoints = [];

    if (datas == null) {
        document.getElementById("chartContainer").innerHTML = "<p>Valitulla aikavälillä ei näytettävää</p>";
    } else {

        CanvasJS.addColorSet("green",
                [//colorSet Array
                "#4F914F"
                ]);

        var chart = new CanvasJS.Chart("chartContainerPaivakohtainen", {
            animationEnabled: true,

            colorSet: "green",

            theme: "light2",
            title: {
                text: "Toimipisteen mökkien päiväkohtainen täyttöaste yhteensä"
            },
            subtitles: [{
                text: "Aikavälillä " + apvm + " - " + lpvm
            }],
            axisY: {
                title: "Prosenttia",
                titleFontSize: 24
            },
            data: [{
                type: "column",
                yValueFormatString: "#.## prosenttia",
                dataPoints: dataPoints
            }]
        });
        
        // luodaan data-array
        var dataArr = createDataArray(apvm, lpvm, datas, varattavissaOlevienMokkienLkm);

        for (var i = 0; i < dataArr.length; i++) {
            dataPoints.push({
                label: dataArr[i].paiva,
                y: parseFloat(dataArr[i].ta)
            });
        }
        chart.render();
    }
}

/**
 * Hakee tietokannasta toimipisteen mökkikohtaisen täyttöasteen ja kutsuu kaavion luovaa funktiota
 * @param {valitun toimipisteen id} toimipiste_id 
 * @param {Raportoinnin valittu aloituspvm} apvm 
 * @param {Raportoinnin valittu lopeutspvm} lpvm 
 */
function haeToimipisteenMokkienTayttoaste(toimipiste_id, apvm, lpvm) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            majoituksenRaportointi = JSON.parse(this.responseText);
            initMokkikohtainen(majoituksenRaportointi, apvm, lpvm);
        }
    };
    xmlhttp.open("GET", "haeToimipisteenMokkienTayttoaste.php?id=" + toimipiste_id + "&apvm=" + apvm + "&lpvm=" + lpvm, true);
    xmlhttp.send();
}

/**
 * Hakee tietokannasta mökkienvaraustiedot valitulla aikavälillä ja kutsuu kaavion luovaa funktiota
 * @param {valitun toimipisteen id} toimipiste_id 
 * @param {Raportoinnin valittu aloituspvm} apvm 
 * @param {Raportoinnin valittu lopeutspvm} lpvm 
 * @param {Toimipisteen mökkien lukumäärä} varattavissaOlevienMokkienLkm
 */
function haeToimipisteenMokkienVarauksetAikavalilla(toimipiste_id, apvm, lpvm, varattavissaOlevienMokkienLkm) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            toimipisteenMokkienVarauksetAikavalilla = JSON.parse(this.responseText);
            initPaivakohtainen(toimipisteenMokkienVarauksetAikavalilla, apvm, lpvm, varattavissaOlevienMokkienLkm);
        }
    };
    xmlhttp.open("GET", "haeToimipisteenMokkienVarauksetAikavalilla.php?id=" + toimipiste_id + "&apvm=" + apvm + "&lpvm=" + lpvm, true);
    xmlhttp.send();
}

/**
 * Luo taulukon valitun aikavälin päivämääristä
 * @param {Raportoinnin valittu aloituspvm} startDate 
 * @param {Raportoinnin valittu lopeutspvm} endDate 
 */
function createDateArray(startDate, endDate) {
    var arr = new Array();
    var dt = new Date(startDate);
    var endt = new Date(endDate);
    while (dt <= endt) {
        arr.push(new Date(dt));
        dt.setDate(dt.getDate() + 1);
    }
    return arr;
}

/**
 * 
 * @param {Raportoinnin valittu aloituspvm} startDate 
 * @param {Raportoinnin valittu lopeutspvm} endDate 
 * @param {Mökkienvaraustiedot valitulla aikavälillä} dataArray 
 * @param {Toimipisteen mökkien lukumäärä} varattavissaOlevienMokkienLkm 
 */
function createDataArray(startDate, endDate, dataArray, varattavissaOlevienMokkienLkm) {
    // luodaan taulukko aikavälin päivistä
    var dateArray = createDateArray(startDate, endDate);

    if (dateArray.length != 0){
        var varattavatPaivatYhteensa = parseInt(varattavissaOlevienMokkienLkm);
    }
    var data = [];

    // käydään läpi mökkien varaustiedot ja verrataan aikavälin taulukon päivään,
    // jotta saadaan laskettua montako varausta yhtenä päivänä on
    for(var i = 0; i < dateArray.length; i++) {
        var vuokrapaivat = 0;
        for (var n = 0; n < dataArray.length; n++) {
            var sdt = new Date(dataArray[n].aloituspvm);
            var edt = new Date(dataArray[n].lopetuspvm);
            if (dateArray[i] >= sdt && dateArray[i] <= edt) {
                vuokrapaivat++;
            }
        }
        var tayttoaste = 0;
        if (varattavatPaivatYhteensa != 0) {
            tayttoaste = (vuokrapaivat / varattavatPaivatYhteensa) * 100;
            if (tayttoaste > 100){
                tayttoaste = 100;
            }
        }
        
        data.push({
            paiva: dateArray[i].getDate() + "." + (dateArray[i].getMonth() + 1) + "." + dateArray[i].getFullYear(),
            ta: tayttoaste
        });
    }

    return data;

}




