<?php 
class Asiakkaat {

    public function __construct($asiakas_id, $etunimi, $sukunimi, $lahiosoite, $postitoimipaikka, $postinro, $email, $puhelinnro) {
        $this->asiakas_id = $asiakas_id;
        $this->etunimi = $etunimi;
        $this->sukunimi = $sukunimi;
        $this->lahiosoite = $lahiosoite;
        $this->postitoimipaikka = $postitoimipaikka;
        $this->postinro = $postinro;
        $this->email = $email;
        $this->puhelinnro = $puhelinnro;
    }

    public function __deconstruct()
    {

    }

    function getAsiakasId() {
        return $this->asiakas_id;
    }

    function getEtunimi() {
        return $this->etunimi;
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

    function getEmail() {
        return $this->email;
    }

    function getPuhelinnro() {
        return $this->puhelinnro;
    }

    function setAsiakasId($asiakas_id) {
        $this->asiakas_id = $asiakas_id;
    }

    function setEtunnimi($etunimi) {
        $this->etunimi = $etunimi;
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
        
    function setEmail($email) {
        $this->email = $email;
    }

    function setPuhelinnro($puhelinnro) {
        $this->puhelinnro = $puhelinnro;
    }

}

?>