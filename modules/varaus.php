<?php
    class Varaus
    {
        public function __construct($varaus_id, $asiakas, $toimipiste_id, $varattu_pvm, $vahvistus_pvm, $varattu_alkupvm, $varattu_loppupvm)
        {
            $this->varaus_id = $varaus_id;
            $this->asiakas = $asiakas;
            $this->toimipiste_id = $toimipiste_id;
            $this->varattu_pvm = $varattu_pvm;
            $this->vahvistus_pvm = $vahvistus_pvm;
            $this->varattu_alkupvm = $varattu_alkupvm;
            $this->varattu_loppupvm = $varattu_loppupvm;
        }

        public function __deconstruct()
        {

        }

        function getVarausID() { return $this->varaus_id; }
        function getAsiakas() { return $this->asiakas; }
        function getToimipisteID() { return $this->toimipiste_id; }
        function getVarattuPvm() { return $this->varattu_pvm; }
        function getVahvistusPvm() { return $this->vahvistus_pvm; }
        function getVarattuAlkupvm() { return $this->varattu_alkupvm; }
        function getVarattuLoppupvm() { return $this->varattu_loppupvm; }

        function getMajoitusID()
        {
            include_once('modules/tietokanta.php');
            $tk = new Tietokanta;
            $majoitusid = $tk->HaeVarauksenMajoitusID($this->varaus_id);
            return $majoitusid;
        }

        function setVarausID($varaus_id) { $this->varaus_id = $varaus_id; }
        function setAsiakas($asiakas) { $this->asiakas = $asiakas; }
        function setToimipisteID($toimipiste_id) { $this->toimipiste_id = $toimipiste_id; }
        function setVarattuPvm($varattu_pvm) { $this->varattu_pvm = $varattu_pvm; }
        function setVahvistusPvm($vahvistus_pvm) { $this->vahvistus_pvm = $vahvistus_pvm; }
        function setVarattuAlkupvm($varattu_alkupvm) { $this->varattu_alkupvm = $varattu_alkupvm; }
        function setVarattuLoppupvm($varattu_loppupvm) { $this->varattu_loppupvm = $varattu_loppupvm; }
        
    }
?>