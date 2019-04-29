<?php

    

    class Tietokanta
    {
        
        public function __construct() {
            require_once("db_connection.php");
            $this->db_servername = $db_servername;
            $this->db_username = $db_username;
            $this->db_password = $db_password;
            $this->db_name = $db_name;
        }

        public function __deconstruct() {

        }

        public function KirjauduSisaan($tunnus, $salasana)
        {
            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);

            if ($connection->connect_error) {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $user = mysqli_real_escape_string($connection, $tunnus);
            $pass = mysqli_real_escape_string($connection, $salasana);

            $query = "SELECT * FROM Kayttajatunnus WHERE tunnus = '$user' AND salasana = '$pass'";

            $result = $connection->query($query);
            
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $luokka = $row["luokka"];
                    $connection->close();
                    return $luokka;
                }
            } 
            else {
                return null;
            }
            $connection->close();
        }
        
        // Tommin osaa

        /** 
         * hakee tietokannasta kaikki toimipisteet
         * palauttaa listan toimipiste-objekteja
         */
        public function haeKaikkiToimipisteet() {

            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);
            
            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $query = "SELECT * FROM toimipiste";

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

            $id = $connection->real_escape_string($toimipisteenID);
            
            $query = "SELECT * FROM Toimipiste WHERE toimipiste_id = '$id'";

            $result = $connection->query($query);

            if ($result->num_rows > 0) 
            {
                $row = $result->fetch_assoc();
                $toimipiste = new Toimipiste($row["toimipiste_id"], $row["nimi"], $row["lahiosoite"], 
                    $row["postitoimipaikka"], $row["postinro"], $row["email"], $row["puhelinnro"]);
                
            } 
            else {
                $toimipiste = null;
            }

            $connection->close();

            return $toimipiste;
        }

        public function haeLike($like, $tyyppi) {
            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);
            
            $lista = array();

            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $lista = array();

            $li = mysqli_real_escape_string($connection, $like);

            switch($tyyppi) {
            // haetaan kaikki toimipisteet, joissa esiintyy hakusana
                case 1:
                    $query = "SELECT * FROM Toimipiste WHERE nimi LIKE '%$li%' OR lahiosoite LIKE '%$li%' 
                    OR postitoimipaikka LIKE '%$li%' OR postinro LIKE '%$li%' OR email LIKE '%$li%' OR puhelinnro LIKE '%$li%'";
                    $result = $connection->query($query);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {

                            $toimipiste = new Toimipiste($row["toimipiste_id"], $row["nimi"], $row["lahiosoite"], 
                            $row["postitoimipaikka"], $row["postinro"], $row["email"], $row["puhelinnro"]);

                            $lista[] = $toimipiste;
                        }
                    } else {
                        $lista = null;
                    }
                    break;
                case 2:
                    // haetaan kaikki mökit, joissa esiintyy hakusana
                    $query = "SELECT * FROM Palvelu WHERE nimi LIKE '%$li%' AND tyyppi='1' OR kuvaus 
                    LIKE '%$li%' AND tyyppi='1' OR hinta LIKE '%$li%' AND tyyppi='1'";

                    $result = $connection->query($query);
        
                    if ($result->num_rows > 0) {
                        $lista = array();
                        while($row = $result->fetch_assoc()) {
                            $palvelu = new Palvelu($row["palvelu_id"], $row["toimipiste_id"], $row["nimi"], 
                            $row["tyyppi"], $row["kuvaus"], $row["hinta"], $row["alv"]);
        
                            $lista[] = $palvelu;
                        }
                    } 
                    else {
                        $lista = null;
                    }
                    break;
                case 3:
                // haetaan kaikki muut palvelut, joissa esiintyy hakusana
                    $query = "SELECT * FROM Palvelu WHERE nimi LIKE '%$li%' AND tyyppi='2' OR kuvaus 
                    LIKE '%$li%' AND tyyppi='2' OR hinta LIKE '%$li%' AND tyyppi='2'";

                    $result = $connection->query($query);
        
                    if ($result->num_rows > 0) {
                        $lista = array();
                        while($row = $result->fetch_assoc()) {
                            $palvelu = new Palvelu($row["palvelu_id"], $row["toimipiste_id"], $row["nimi"], 
                            $row["tyyppi"], $row["kuvaus"], $row["hinta"], $row["alv"]);
        
                            $lista[] = $palvelu;
                        }
                    } 
                    else {
                        $lista = null;
                    }
                    break;
            }

            $connection->close();

            return $lista;
        }

        /**
         * Ottaa vastaan toimipiste-objektin
         * päivittää toimipisteen tiedot tietokantaan
         */
        public function PaivitaToimipiste($toimipiste) {

            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);
            
            if ($connection->connect_error) {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $toimipiste_id = $connection->real_escape_string($toimipiste->getToimipisteId());
            $nimi = $connection->real_escape_string($toimipiste->getNimi());
            $lahiosoite = $connection->real_escape_string($toimipiste->getLahiosoite());
            $postitoimipaikka = $connection->real_escape_string($toimipiste->getPostitoimipaikka());
            $postinro = $connection->real_escape_string($toimipiste->getPostinro());
            $email = $connection->real_escape_string($toimipiste->getEmail());
            $puhelinnro = $connection->real_escape_string($toimipiste->getPuhelinnro());

            $query = "UPDATE Toimipiste SET nimi='$nimi', lahiosoite='$lahiosoite', postitoimipaikka='$postitoimipaikka', 
            postinro='$postinro', email='$email', puhelinnro='$puhelinnro' WHERE toimipiste_id='$toimipiste_id'";

            $result = $connection->query($query);

            if ($result){
                $message = "Tietojen tallentaminen onnistui";
                
            } else {
                $message = "Sattui odottamaton virhe, yritä myöhemmin uudelleen";
            }

            $connection->close();
            return $message;
        }

        /**
         * Ottaa vastaan toimipiste-objektin
         * lisää tietokantaan uuden toimipisterivin
         */
        public function lisaaToimipiste($toimipiste) {

            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);
            
            if ($connection->connect_error) {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $nimi = $connection->real_escape_string($toimipiste->getNimi());
            $lahiosoite = $connection->real_escape_string($toimipiste->getLahiosoite());
            $postitoimipaikka = $connection->real_escape_string($toimipiste->getPostitoimipaikka());
            $postinro = $connection->real_escape_string($toimipiste->getPostinro());
            $email = $connection->real_escape_string($toimipiste->getEmail());
            $puhelinnro = $connection->real_escape_string($toimipiste->getPuhelinnro());

            $query = "INSERT INTO Toimipiste (nimi, lahiosoite, postitoimipaikka, postinro, email, puhelinnro) 
            VALUES ('$nimi' ,'$lahiosoite', '$postitoimipaikka', '$postinro', '$email', '$puhelinnro')";

            if($connection->query($query) === TRUE) {
                $message = "Tietojen tallentaminen onnistui";
            }
            else {
                $message = "Sattui odottamaton virhe, yritä myöhemmin uudelleen";
            }

            $connection->close();
            return $message;
        }

        public function poistaToimipiste($id) {

            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);
            
            if ($connection->connect_error) {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $tp_id = $connection->real_escape_string($id);
            
            $query = "DELETE FROM Toimipiste WHERE toimipiste_id = '$tp_id'";

            if($connection->query($query) === TRUE) {
                $message = "Tietojen poistaminen onnistui";
            }
            else {
                $message = "Sattui odottamaton virhe, yritä myöhemmin uudelleen";
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

            if ($connection->connect_error) {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $id = mysqli_real_escape_string($connection, $toimipisteenID);
            $pt = mysqli_real_escape_string($connection, $palvelunTyyppi);

            $query = "SELECT * FROM Palvelu WHERE tyyppi='$pt' AND toimipiste_id='$id'";

            $result = $connection->query($query);

            if ($result->num_rows > 0) {
                $palvelulista = array();
                while($row = $result->fetch_assoc()) {
                    $palvelu = new Palvelu($row["palvelu_id"], $row["toimipiste_id"], $row["nimi"], 
                    $row["tyyppi"], $row["kuvaus"], $row["hinta"], $row["alv"]);

                    $palvelulista[] = $palvelu;
                }
            } 
            else {
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

            if ($connection->connect_error) {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $id = mysqli_real_escape_string($connection, $palvelunID);

            $query = "SELECT * FROM Palvelu WHERE palvelu_id='$id'";

            $result = $connection->query($query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $palvelu = new Palvelu($row["palvelu_id"], $row["toimipiste_id"], $row["nimi"], 
                    $row["tyyppi"], $row["kuvaus"], $row["hinta"], $row["alv"]);
            } 
            else {
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
            
            if ($connection->connect_error) {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $palvelu_id = $connection->real_escape_string($palvelu->getPalveluId());
            $toimipiste_id = $connection->real_escape_string($palvelu->getToimipisteId());
            $nimi = $connection->real_escape_string($palvelu->getNimi());
            $tyyppi = $connection->real_escape_string($palvelu->getTyyppi());
            $kuvaus = $connection->real_escape_string($palvelu->getKuvaus());
            if (is_float($palvelu->getHinta()) || is_numeric($palvelu->getHinta())) {
                $hinta = $connection->real_escape_string($palvelu->getHinta());
            } else {
                $hinta = 0.00;
            }
            $alv = $connection->real_escape_string($palvelu->getAlv());

            $query = "UPDATE Palvelu SET toimipiste_id='$toimipiste_id', nimi='$nimi', tyyppi='$tyyppi', 
            kuvaus='$kuvaus', hinta='$hinta', alv='$alv' WHERE palvelu_id='$palvelu_id'";

            $result = $connection->query($query);

            if ($result){
                $message = "Tietojen tallentaminen onnistui";
                
            } else {
                $message = "Sattui odottamaton virhe, yritä myöhemmin uudelleen";
            }

            $connection->close();
            return $message;
        }

        public function lisaaPalvelu($palvelu) {

            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);
            
            if ($connection->connect_error) {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $toimipiste_id = $connection->real_escape_string($palvelu->getToimipisteId());
            $nimi = $connection->real_escape_string($palvelu->getNimi());
            $tyyppi = $connection->real_escape_string($palvelu->getTyyppi());
            $kuvaus = $connection->real_escape_string($palvelu->getKuvaus());
            if (is_float($palvelu->getHinta()) || is_numeric($palvelu->getHinta())) {
                $hinta = $connection->real_escape_string($palvelu->getHinta());
            } else {
                $hinta = 0.00;
            }
            $alv = $connection->real_escape_string($palvelu->getAlv());

            $query = "INSERT INTO Palvelu (toimipiste_id, nimi, tyyppi, kuvaus, hinta, alv) 
            VALUES ('$toimipiste_id', '$nimi' ,'$tyyppi', '$kuvaus', '$hinta', '$alv')";

            if($connection->query($query) === TRUE) {
                $message = "Tietojen tallentaminen onnistui";
            } else {
                $message = "Sattui odottamaton virhe, yritä myöhemmin uudelleen";
            }

            $connection->close();
            return $message;
        }

        public function poistaPalvelu($id) {

            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);
            
            if ($connection->connect_error) {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $p_id = $connection->real_escape_string($id);
            
            $query = "DELETE FROM Palvelu WHERE palvelu_id = '$p_id'";

            if($connection->query($query) === TRUE) {
                $message = "Tietojen poistaminen onnistui";
            } else {
                $message = "Sattui odottamaton virhe, yritä myöhemmin uudelleen";
            }

            $connection->close();
            return $message;
        }

    }
?>