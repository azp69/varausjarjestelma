<?php
    class Kayttajatunnus
    {
        public function __construct($id, $tunnus, $salasana)
        {
            $this->id = $id;
            $this->tunnus = $tunnus;
            $this->salasana = $salasana;
        }

        public function __destruct()
        {

        }

        public function getId() { return $this->id; }
        public function getTunnus() { return $this->tunnus; }
        
        public function setTunnus($tunnus) { $this->tunnus = $tunnus; }
        public function setSalasana($salasana) { $this->salasana = $salasana; }

    }
?>