<?php
class Palvelu {

    public function __construct($palvelu_id, $toimipiste_id, $nimi, $tyyppi, $kuvaus, $hinta, $alv) {
        $this->palvelu_id = $palvelu_id;
        $this->toimipiste_id = $toimipiste_id;
        $this->nimi = $nimi;
        $this->tyyppi = $tyyppi;
        $this->kuvaus = $kuvaus;
        $this->hinta = $hinta;
        $this->alv = $alv;
    }

    public function __deconstruct()
    {

    }

    function getPalveluId() {
        return $this->palvelu_id;
    }

    function getToimipisteId() {
        return $this->toimipiste_id;
    }

    function getNimi() {
        return $this->nimi;
    }

    function getTyyppi() {
        return $this->tyyppi;
    }

    function getKuvaus() {
        return $this->kuvaus;
    }

    function getHinta() {
        return $this->hinta;
    }

    function getAlv() {
        return $this->alv;
    }

    function setPalveluId($palvelu_id) {
        $this->palvelu_id = $palvelu_id;
    }

    function setToimipisteId($toimipiste_id) {
        $this->toimipiste_id = $toimipiste_id;
    }

    function setNimi($nimi) {
        $this->nimi = $nimi;
    }

    function setTyyppi($tyyppi) {
        $this->tyyppi = $tyyppi;
    }

    function setKuvaus($kuvaus) {
        $this->kuvaus = $kuvaus;
    }

    function setHinta($hinta) {
        $this->hinta = $hinta;
    }

    function setAlv($alv) {
        $this->alv = $alv;
    }

}
?>