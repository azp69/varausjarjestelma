<?php 

class Toimipiste {

    public function __construct($toimipiste_id, $nimi, $lahiosoite, $postitoimipaikka, $postinro, $email, $puhelinnro) {
        $this->toimipiste_id = $toimipiste_id;
        $this->nimi = $nimi;
        $this->lahiosoite = $lahiosoite;
        $this->postitoimipaikka = $postitoimipaikka;
        $this->postinro = $postinro;
        $this->email = $email;
        $this->puhelinnro = $puhelinnro;
    }

    public function __deconstruct()
    {

    }

    function getToimipisteId() {
        return $this->toimipiste_id;
    }

    function getNimi() {
        return $this->nimi;
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

    function setToimipisteId($toimipiste_id) {
        $this->toimipiste_id = $toimipiste_id;
    }

    function setNimi($nimi) {
        $this->nimi = $nimi;
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