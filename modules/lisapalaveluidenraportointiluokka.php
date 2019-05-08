<?php
class ToimipisteenLisapalveluidenVarauksetAikavalilla {
    public function __construct($palvelu, $lkm, $hinta) {
        $this->palvelu = $palvelu;
        $this->lkm = $lkm;
        $this->hinta = $hinta;
    }

    public function __deconstruct() {
    }
    public function getPalvelu() {
        return  $this->palvelu;
    }
    public function getLkm() {
        return  $this->lkm;
    }
    public function getHinta() {
        return  $this->hinta;
    }
}

?>