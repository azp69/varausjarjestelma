<?php

    

    class Tietokanta
    {
        
        public function __construct()
        {
            require_once("/var/www/private/db_connection.php");
            $this->db_servername = $db_servername;
            $this->db_username = $db_username;
            $this->db_password = $db_password;
            $this->db_name = $db_name;
        }

        public function __deconstruct()
        {

        }
      
        public function KirjauduSisaan($tunnus, $salasana)
        {
            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);

            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $user = mysqli_real_escape_string($connection, $tunnus);
            $pass = mysqli_real_escape_string($connection, $salasana);

            $query = "SELECT * FROM Kayttajatunnus WHERE tunnus = '$user' AND salasana = '$pass'";

            $result = $connection->query($query);
            
            
            if ($result->num_rows > 0) 
            {
                while($row = $result->fetch_assoc()) {
                    $luokka = $row["luokka"];
                    $tunnus = $row["tunnus"];

                    $_SESSION["luokka"] = $luokka;
                    $_SESSION["tunnus"] = $tunnus;
                    $connection->close();
                    
                }
            } 
        
            else 
            {
                return null;
            }
            $connection->close();
        }

        /*
            Palauttaa mökin (palvelun) varaukset taulukossa, eli siis varauksen aloituspvm ja lopetuspvm
        */
        public function HaePalvelunVarauskalenteri($palveluId)
        {
            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);
            
            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $query = "SELECT * FROM mokin_varauskalenteri WHERE palvelu_id = '" . $palveluId . "'";

            $result = $connection->query($query);

            $varauskalenteri = array();

            $i = 0;

            if ($result->num_rows > 0) 
            {
                while($row = $result->fetch_assoc()) 
                {
                    $varauskalenteri[$i++] = $row;
                } 
            } 

            else {
                $varauskalenteri = null;
                echo "Ei yhtään tulosta.";
            }

            $connection->close();

            return $varauskalenteri;
        }


        /*
            Etsii asiakasta etu- ja/tai sukunimen perusteella ja palauttaa taulukon Asiakas-objekteista
        */
        public function HaeAsiakkaat($hakusana)
        {
            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);
            
            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }
            $q = mysqli_real_escape_string($connection, $hakusana);
            $query = "SELECT * FROM Asiakas WHERE etunimi LIKE '" . $q . "%' OR sukunimi LIKE '" . $q . "%'";

            $result = $connection->query($query);

            $asiakkaat = array();

            $i = 0;

            if ($result->num_rows > 0) 
            {
                while($row = $result->fetch_assoc()) 
                {
                    $asiakas = new Asiakas($row["asiakas_id"], $row["etunimi"], $row["sukunimi"], $row["lahiosoite"], $row["postitoimipaikka"], $row["postinro"], $row["email"], $row["puhelinnro"]);
                    $asiakkaat[$i++] = $asiakas;
                } 
            } 

            else {
                $asiakkaat = null;
                echo "Ei yhtään tulosta.";
            }

            $connection->close();

            return $asiakkaat;
        }

        // Tommin osaa

        /** 
         * hakee tietokannasta kaikki toimipisteet
         * palauttaa listan toimipiste-objekteja
         */
        public function HaeToimipisteet() {

            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);
            
            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $query = "SELECT * FROM Toimipiste";

            $listToimipisteet = array();

            $result = $connection->query($query);

            if ($result->num_rows > 0) 
            {
                while($row = $result->fetch_assoc()) {

                    $toimipiste = new Toimipiste($row["toimipiste_id"], $row["nimi"], $row["lahiosoite"], 
                    $row["postitoimipaikka"], $row["postinro"], $row["email"], $row["puhelinnro"]);

                    $listToimipisteet[] = $toimipiste;
                }

                
            } 
            else {
                $listToimipisteet = null;
                echo "Ei yhtään tulosta.";
            }

            $connection->close();

            return $listToimipisteet;
        }
        
        /** 
         * Ottaa vastaan toimipisteen id:n
         * hakee sen perusteella toimipisteen tietokannasta
         * palauttaa yhden toimipiste-objektin
         */
        public function HaeToimipiste($toimipisteenID) {

            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);
            
            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $query = "SELECT * FROM Toimipiste WHERE toimipiste_id = '$toimipisteenID'";

            $result = $connection->query($query);

            if ($result->num_rows > 0) 
            {
                $row = $result->fetch_assoc();
                $toimipiste = new Toimipiste($row["toimipiste_id"], $row["nimi"], $row["lahiosoite"], 
                    $row["postitoimipaikka"], $row["postinro"], $row["email"], $row["puhelinnro"]);
                
            } 
            else {
                $toimipiste = null;
                // echo "Ei yhtään tulosta.";
            }

            $connection->close();

            return $toimipiste;
        }

        /**
         * Ottaa vastaan toimipiste-objektin
         * päivittää toimipisteen tiedot tietokantaan
         */
        public function PaivitaToimipiste($toimipiste) {

            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);
            
            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $toimipiste_id = $connection->real_escape_string($toimipiste->getToimipisteId());
            $nimi = $connection->real_escape_string($toimipiste->getNimi());
            $lahiosoite = $connection->real_escape_string($toimipiste->getLahiosoite());
            $postitoimipaikka = $connection->real_escape_string($toimipiste->getPostitoimipaikka());
            $postinro = $connection->real_escape_string($toimipiste->getPostinro());
            $email = $connection->real_escape_string($toimipiste->getEmail());
            $puhelinnro = $connection->real_escape_string($toimipiste->getPuhelinnro());

            $query = "UPDATE Toimipiste SET nimi='$nimi', lahiosoite='$lahiosoite', postitoimipaikka='$postitoimipaikka', postinro='$postinro', email='$email', puhelinnro='$puhelinnro' WHERE toimipiste_id='$toimipiste_id'";

            $result = $connection->query($query);

            if ($result){
                $message = "Tietojen tallentaminen onnistui";
                
            } else {
                $message = "Sattui odottamaton virhe, koeta hiukan myöhemmin uudelleen";
            }

            $connection->close();
            return $message;
        }
        
        /** 
         * Ottaa vastaan toimipisteen id:n ja palvelun tyypin,
         * hakee näiden perusteella toimipisteeseen kuuluvat palvelut
         * Palauttaa listan palvelu-objekteista
         */
        public function haeToimipisteeseenKuuluvatPalvelut($toimipisteenID, $palvelunTyyppi) {

            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);

            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $query = "SELECT * FROM Palvelu WHERE tyyppi='$palvelunTyyppi' AND toimipiste_id='$toimipisteenID'";

            $result = $connection->query($query);

            if ($result->num_rows > 0) 
            {
                $palvelulista = array();
                while($row = $result->fetch_assoc()) {
                    $palvelu = new Palvelu($row["palvelu_id"], $row["toimipiste_id"], $row["nimi"], 
                    $row["tyyppi"], $row["kuvaus"], $row["hinta"], $row["alv"]);

                    $palvelulista[] = $palvelu;
                }
            } 
            else 
            {
                $palvelulista = null;
            }

            $connection->close();
            return $palvelulista;
        }

        /** 
         * Ottaa vastaan palvelun id:n
         * hakee sen perusteella palvelun tietokannasta
         * palauttaa yhden palvelu-objektin
         */
        public function haePalvelu($palvelunID) {

            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);

            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $query = "SELECT * FROM Palvelu WHERE palvelu_id='$palvelunID'";

            $result = $connection->query($query);

            if ($result->num_rows > 0) 
            {
                $row = $result->fetch_assoc();
                $palvelu = new Palvelu($row["palvelu_id"], $row["toimipiste_id"], $row["nimi"], 
                    $row["tyyppi"], $row["kuvaus"], $row["hinta"], $row["alv"]);
            } 
            else 
            {
                $palvelu = null;
            }

            $connection->close();
            return $palvelu;
        }

        /**
         * Ottaa vastaan palvelu-objektin
         * päivittää palvelun tiedot tietokantaan
         */
        public function PaivitaPalvelu($palvelu) {

            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);
            
            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $palvelu_id = $connection->real_escape_string($palvelu->getPalveluId());
            $toimipiste_id = $connection->real_escape_string($palvelu->getToimipisteId());
            $nimi = $connection->real_escape_string($palvelu->getNimi());
            $tyyppi = $connection->real_escape_string($palvelu->getTyyppi());
            $kuvaus = $connection->real_escape_string($palvelu->getKuvaus());
            $hinta = $connection->real_escape_string($palvelu->getHinta());
            $alv = $connection->real_escape_string($palvelu->getAlv());

            $query = "UPDATE Palvelu SET toimipiste_id='$toimipiste_id', nimi='$nimi', tyyppi='$tyyppi', kuvaus='$kuvaus', hinta='$hinta', alv='$alv' WHERE palvelu_id='$palvelu_id'";

            $result = $connection->query($query);

            if ($result){
                $message = "Tietojen tallentaminen onnistui";
                
            } else {
                $message = "Sattui odottamaton virhe, koeta hiukan myöhemmin uudelleen";
            }

            $connection->close();
            return $message;
        }

    }
?>