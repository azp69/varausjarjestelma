<?php 
class Lasku {

    public function __construct($lasku_id, $asiakas_id, $varaus_id, $sukunimi, $lahiosoite, $postitoimipaikka, $postinro, $summa, $alv) {
        $this->lasku_id = $lasku_id;
        $this->asiakas_id = $asiakas_id;
        $this->varaus_id = $varaus_id;
        $this->sukunimi = $sukunimi;
        $this->lahiosoite = $lahiosoite;
        $this->postitoimipaikka = $postitoimipaikka;
        $this->postinro = $postinro;
        $this->summa = $summa;
        $this->alv = $alv;
    }

    public function __deconstruct()
    {

    }

    function getLaskuId() {
        return $this->lasku_id;
    }

    function getAsiakasId() {
        return $this->asiakas_id;
    }

    function getVarausId() {
        return $this->varaus_id;
    }
        
    function getSukunimi() {
        return $this->sukunimi;
    }

    function getLahiosoite() {
        return $this->lahiosoite;
    }

    function getPostitoimipaikka() {
        return $this->postitoimipaikka;
    }

    function getPostinro() {
        return $this->postinro;
    }

    function getSumma() {
        return $this->summa;
    }
    function getAlv() {
        return $this->alv;
    }

    function setLaskuId($lasku_id) {
        $this->lasku_id = $lasku_id;
    }
    
    function setAsiakasId($asiakas_id) {
        $this->asiakas_id = $asiakas_id;
    }

    function setVarausId($varaus_id) {
        $this->varaus_id = $varaus_id;
    }

    function setSukunimi($sukunimi) {
        $this->sukunimi = $sukunimi;
    }

    function setLahiosoite($lahiosoite) {
        $this->lahiosoite = $lahiosoite;
    }

    function setPostitoimipaikka($postitoimipaikka) {
        $this->postitoimipaikka = $postitoimipaikka;
    }

    function setPostinro($postinro) {
        $this->postinro = $postinro;
    }
        
    function setSumma($summa) {
        $this->summa = $summa;
    }

    function setAlv($alv) {
        $this->alv = $alv;
    }

}

?>