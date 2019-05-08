var lisapalveluidenRaportointi;

/**
 * Luo mökkikohtaisen kaavion mökkien täyttöasteista
 * @param {Objektitaulukko, joka sisältää mökkien täyttöasteet} datas 
 * @param {Raportoinnin valittu aloituspvm} apvm 
 * @param {Raportoinnin valittu lopeutspvm} lpvm 
 */
function initPalveluidenOstomaarat(datas, apvm, lpvm) {

    var dataPoints = [];

    if (datas == null) {
        document.getElementById("chartContainer").innerHTML = "<div style='text-align: center;'><p>Valitulla aikavälillä ei näytettävää</p></div>";
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
                text: "Lisäpalveluiden ostomäärät"
            },
            subtitles: [{
                text: "Aikavälillä " + apvm + " - " + lpvm
            }],
            axisY: {
                title: "Kappalemäärä",
                titleFontSize: 24
            },
            data: [{
                type: "column",
                yValueFormatString: "# kappaletta",
                dataPoints: dataPoints
            }]
        });
        
        // pushataan datas-arrayn rivit dataPointteihin
        for (var i = 0; i < datas.length; i++) {
            dataPoints.push({
                label: datas[i].palvelu,
                y: parseInt(datas[i].lkm)
            });
        }
        chart.render();
    }
}

function initOsuudetLiikevaihdosta(datas, apvm, lpvm) {

    var dataPoints = [];

    var aikavalinLisapalveluidenLiikevaihtoYhteensa = 0;
    
    if (datas == null) {
        document.getElementById("chartContainer").innerHTML = "<div style='text-align: center;'><p>Valitulla aikavälillä ei näytettävää</p></div>";
    } else {
        for (var i = 0; i < datas.length; i++) {
            aikavalinLisapalveluidenLiikevaihtoYhteensa += parseInt(datas[i].lkm) * parseFloat(datas[i].hinta);
        }
    
        if (aikavalinLisapalveluidenLiikevaihtoYhteensa == 0) {
            return;
        }

        var chart = new CanvasJS.Chart("chartContainerOsuudet", {
    
            animationEnabled: true,
            title: {
                text: "Osuudet lisäpalveluiden liikevaihdosta aikavälillä"
            },
            subtitles: [{
                text: "Lisäpalveluiden liikevaihto toimipisteensä yhteensä: " + aikavalinLisapalveluidenLiikevaihtoYhteensa + "€"
            }],
            data: [{
                type: "pie",
                startAngle: 240,
                yValueFormatString: "##0.00\"%\"",
                indexLabel: "{label} {y}",
                dataPoints: dataPoints
            }]
        });
    
        // pushataan datas-arrayn rivit dataPointteihin
        for (var i = 0; i < datas.length; i++) {
            dataPoints.push({
                label: datas[i].palvelu,
                y: (parseInt(datas[i].lkm) * parseFloat(datas[i].hinta) / aikavalinLisapalveluidenLiikevaihtoYhteensa) * 100
            });
        }
    
        chart.render();
    }

}



/**
 * Hakee tietokannasta toimipisteen lisäpalveluiden ostomäärät ja kutsuu kaavion luovaa funktiota
 * @param {valitun toimipisteen id} toimipiste_id 
 * @param {Raportoinnin valittu aloituspvm} apvm 
 * @param {Raportoinnin valittu lopeutspvm} lpvm 
 */
function haeToimipisteenLisapalveluidenOstomaaratAikavalilla(toimipiste_id, apvm, lpvm) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            lisapalveluidenRaportointi = JSON.parse(this.responseText);
            initPalveluidenOstomaarat(lisapalveluidenRaportointi, apvm, lpvm);
            initOsuudetLiikevaihdosta(lisapalveluidenRaportointi, apvm, lpvm);
        }
    };
    xmlhttp.open("GET", "haeToimipisteenLisapalveluidenOstomaaratAikavalilla.php?id=" + toimipiste_id + "&apvm=" + apvm + "&lpvm=" + lpvm, true);
    xmlhttp.send();
}