<?php
class ToimipisteenMokkienVarauksetAikavalilla {
    public function __construct($palvelu_id, $palvelu, $aloituspvm, $lopetuspvm) {
        $this->palvelu_id = $palvelu_id;
        $this->palvelu = $palvelu;
        $this->aloituspvm = $aloituspvm;
        $this->lopetuspvm = $lopetuspvm;
    }

    public function __deconstruct() {
    }

    public function getPalveluID() {
        return  $this->palvelu_id;
    }
    public function getPalvelu() {
        return  $this->palvelu;
    }
    public function getAloitusPvm() {
        return  $this->aloituspvm;
    }
    public function getLopetusPvm() {
        return  $this->lopetuspvm;
    }
}

class ToimipisteenMokkienTayttoaste {
    public function __construct($palvelu_id, $palvelu, $vuokrapaivat, $aikavali, $tayttoaste) {
        $this->palvelu_id = $palvelu_id;
        $this->palvelu = $palvelu;
        $this->vuokrapaivat = $vuokrapaivat;
        $this->aikavali = $aikavali;
        $this->tayttoaste = $tayttoaste;
    }

    public function __deconstruct() {
    }

    public function getPalveluID() {
        return  $this->palvelu_id;
    }
    public function getPalvelu() {
        return  $this->palvelu;
    }
    public function getVuokrapaivat() {
        return  $this->vuokrapaivat;
    }
    public function getAikavali() {
        return  $this->aikavali;
    }
    public function getTayttoaste() {
        return  $this->tayttoaste;
    }
}
?>