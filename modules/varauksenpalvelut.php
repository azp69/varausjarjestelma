<?php
    class VarauksenPalvelut
    {
        public function __construct($varaus_id, $palvelu, $lkm)
        {
            $this->varaus_id = $varaus_id;
            $this->palvelu = $palvelu;
            $this->lkm = $lkm;
        }

        public function __destruct()
        {

        }

        function getVarausId() { return $this->varaus_id; }
        function getPalveluId() { return $this->palvelu; }
        function getLkm() { return $this->lkm; }

        function setVarausId($varaus_id) { $this->varaus_id = $varaus_id; }
        function setPalveluId($palvelu_id) { $this->palvelu = $palvelu; }
        function setLkm($lkm) { $this->lkm = $lkm; }
    }