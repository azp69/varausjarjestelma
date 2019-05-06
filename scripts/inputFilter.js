
var txtinputHinta = document.getElementById("textinput-hinta");
if (txtinputHinta != null){
    // Restrict input to digits and '.' by using a regular expression filter.
    setInputFilter(txtinputHinta, function(value) {
    return /^\d*\.?\d*$/.test(value);
    });
}

var txtinputPostiNro = document.getElementById("textinput-postinro");
if (txtinputPostiNro != null){
    setInputFilter(txtinputPostiNro, function(value) {
    return /^(\d{0}|\d{1}|\d{2}|\d{3}|\d{4}|\d{5})$/.test(value);
    });
}

var txtinputPuhNro = document.getElementById("textinput-puhelinnro");
if (txtinputPuhNro != null){
    setInputFilter(txtinputPuhNro, function(value) {
    return /^(\d{0}|\d{1}|\d{2}|\d{3}|\d{4}|\d{5}|\d{6}|\d{7}|\d{8}|\d{9}|\d{10})$/.test(value);
    });
}

// Restricts input for the given textbox to the given inputFilter.
function setInputFilter(textbox, inputFilter) {
    ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
      textbox.addEventListener(event, function() {
        if (inputFilter(this.value)) {
            this.oldValue = this.value;
            this.oldSelectionStart = this.selectionStart;
            this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
            this.value = this.oldValue;
            this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        }
      });
    });
}