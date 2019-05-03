// tarkistetaan, että kaikki kentät on täytetty
function validateSubmit() {
    var inputs = document.getElementsByTagName('input');

    for (var i = 0; i < inputs.length; i++ ) {
        if(inputs[i].type.toLowerCase() == 'text') {
            if (inputs[i].value == "") {
                alert("Kaikki pakolliset kentät eivät ole täytetty.");
                return false;
            }
        }
    }
    return confirm('Haluatko varmasti tallentaa tiedot?');
}

function validateSearch() {
    var inputs = document.getElementsByTagName('input');

    for (var i = 0; i < inputs.length; i++ ) {
        if(inputs[i].type.toLowerCase() == 'date') {
            if (inputs[i].value == "") {
                alert("Kaikki pakolliset kentät eivät ole täytetty.");
                return false;
            }
        }
    }
    return confirm('Haluatko varmasti tallentaa tiedot?');
}



