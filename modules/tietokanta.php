<?php
    class Tietokanta
    {
        public function __construct()
        {
            include("/var/www/private/db_connection.php");
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
                //echo "Ei yhtään tulosta.";
            }

            $connection->close();

            return $varauskalenteri;
        }


        /*
            Etsii asiakasta etu- ja/tai sukunimen perusteella ja palauttaa taulukon Asiakas-objekteista
        */
        public function HaeAsiakkaatHakusanalla($hakusana)
        {
            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);
            
            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }
            $q = mysqli_real_escape_string($connection, $hakusana);
            $nimet = explode(" ", $q);
            $query = "SELECT * FROM Asiakas WHERE (etunimi LIKE '" . $q . "%' OR sukunimi LIKE '" . $q . "%') OR (etunimi LIKE '$nimet[0]' AND sukunimi LIKE '$nimet[1]%') OR (sukunimi LIKE '$nimet[0]' AND etunimi LIKE '$nimet[1]%');";

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

        function PoistaVaraus($varausid)
        {
            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);
            
            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $sql = "DELETE FROM Varaus WHERE varaus_id = '$varausid';";

            if ($connection->query($sql) === TRUE) 
            {

            }
            else 
            {
                echo "Error: " . $sql . "<br>" . $connection->error;
            }

            $connection->close();

        }
        function PaivitaVaraus($varausid, $majoitusid, $varauksen_aloituspvm, $varauksen_paattymispvm, $lisapalvelut)
        {
            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);
            
            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $sql = "UPDATE Varaus SET varattu_alkupvm='$varauksen_aloituspvm 16:00:00', varattu_loppupvm='$varauksen_paattymispvm 12:00:00' WHERE varaus_id = '$varausid';";

            $sql .= "UPDATE mokin_varauskalenteri SET varauksen_aloituspvm='$varauksen_aloituspvm 16:00:00', varauksen_lopetuspvm='$varauksen_paattymispvm 12:00:00' WHERE varaus_id = '$varausid';";

            $sql .= "DELETE FROM Varauksen_palvelut WHERE varaus_id = '$varausid';";

            $a = strtotime($varauksen_aloituspvm);
            $b = strtotime($varauksen_paattymispvm);
            $majoitusvuorokaudet = round(($b - $a) / (60 * 60 * 24));
            
            $sql .= "INSERT INTO Varauksen_palvelut (palvelu_id, varaus_id, lkm)
            VALUES ($majoitusid, $varausid, $majoitusvuorokaudet);"; // Majoituspalvelu

            foreach ($lisapalvelut as $palvelu)
            {
                if ($palvelu->getLkm() > 0)
                {
                    $sql .= "INSERT INTO Varauksen_palvelut (palvelu_id, varaus_id, lkm)
                    VALUES (" . $palvelu->getPalveluId() . ", $varausid, " . $palvelu->getLkm() . ");"; // Lisäpalvelut
                }
            }
            $onnistuiko = false;

            if ($connection->multi_query($sql) === TRUE) 
            {
                $onnistuiko = true;
            }
            else 
            {
                echo "Error: " . $sql . "<br>" . $connection->error;
            }

            $connection->close();
            if ($onnistuiko) 
                return true;
        }
        
        private function LisaaVarausMokinVarauskalenteriin($varaus_id, $majoitus_id, $varattu_alkupvm, $varattu_loppupvm, $connection)
        {
            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $sql = "INSERT INTO mokin_varauskalenteri (palvelu_id, varaus_id, varauksen_aloituspvm, varauksen_lopetuspvm) 
            VALUES ('$majoitus_id', '$varaus_id', '$varattu_alkupvm 16:00:00', '$varattu_loppupvm 12:00:00');";

            if ($connection->query($sql) === TRUE)
            {
                // OK
            }
            else
            {
                echo "Virhe lisätessä tietoa.";
            }
        }
        
        function LisaaVaraus($asiakas_id, $toimipiste_id, $varattu_pvm, $vahvistus_pvm, $varattu_alkupvm, $varattu_loppupvm, $majoitusid, $palvelut, $lkm)
        {
            // $majoitusid = majoituksen palvelu_id

            // Varaus: varaus_id, asiakas_id, toimipiste_id, varattu_pvm, vahvistus_pvm, varattu_alkupvm, varattu_loppupvm
            // mokin_varauskalenteri: palvelu_id, varauksen_aloituspvm, varauksen_lopetuspvm
            // varauksen_palvelut: palvelu_id, varaus_id, lkm
            
            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);
            
            $asiakas_id = mysqli_real_escape_string($connection, $asiakas_id);
            $toimipiste_id = mysqli_real_escape_string($connection, $toimipiste_id);
            $varattu_pvm = mysqli_real_escape_string($connection, $varattu_pvm);
            $vahvistus_pvm = mysqli_real_escape_string($connection, $vahvistus_pvm);
            $varattu_alkupvm = mysqli_real_escape_string($connection, $varattu_alkupvm);
            $varattu_loppupvm = mysqli_real_escape_string($connection, $varattu_loppupvm);
            $majoitusid = mysqli_real_escape_string($connection, $majoitusid);

            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $sql = "INSERT INTO Varaus (asiakas_id, toimipiste_id, varattu_pvm, vahvistus_pvm, varattu_alkupvm, varattu_loppupvm) 
            VALUES ('$asiakas_id', '$toimipiste_id', '$varattu_pvm', '$vahvistus_pvm', '$varattu_alkupvm 16:00:00', '$varattu_loppupvm 12:00:00');";

            $varausid = "";

            if ($connection->multi_query($sql) === TRUE) 
            {
                $varausid = $connection->insert_id;
                $this->LisaaVarausMokinVarauskalenteriin($varausid, $majoitusid, $varattu_alkupvm, $varattu_loppupvm, $connection); // Lisätään majoituksen varaus varauskalenteriin
                $this->LisaaPalvelutVaraukseen($varausid, $palvelut, $lkm, $varattu_alkupvm, $varattu_loppupvm, $majoitusid, $connection); // Lisätään palvelut varaukseen
            }
            else 
            {
                echo "Error: " . $sql . "<br>" . $connection->error;
            }

            $connection->close();
            
        }

        private function LisaaPalvelutVaraukseen($varaus_id, $palvelut, $lkm, $varattu_alkupvm, $varattu_loppupvm, $majoitusid, $connection)
        {
            // varauksen_palvelut: palvelu_id, varaus_id, lkm

            $a = strtotime($varattu_alkupvm);
            $b = strtotime($varattu_loppupvm);
            $majoitusvuorokaudet = round(($b - $a) / (60 * 60 * 24));
            
            $sql = "INSERT INTO Varauksen_palvelut (palvelu_id, varaus_id, lkm)
            VALUES ($majoitusid, $varaus_id, $majoitusvuorokaudet);"; // Majoituspalvelut
                                    
            for ($i = 0; $i < sizeof($palvelut); $i++) // Lisäpalvelut
            {
                if ($lkm[$i] != null)
                {
                    $palveluid = mysqli_real_escape_string($connection, $palvelut[$i]);
                    $palvelunlkm = mysqli_real_escape_string($connection, $lkm[$i]);
                    $sql .= "INSERT INTO Varauksen_palvelut (palvelu_id, varaus_id, lkm)
                    VALUES ($palveluid, $varaus_id, $palvelunlkm);";
                }
            }

            if ($connection->multi_query($sql) === TRUE)
            {
                
            }
            else 
            {
                echo "Error: " . $sql . "<br>" . $connection->error;
            }
        }

        function HaeVaraukseenKuuluvanPalvelunLukumaara($varausid, $palveluid)
        {
            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);
            
            $query = "SELECT lkm FROM Varauksen_palvelut WHERE varaus_id = '$varausid' AND palvelu_id = '$palveluid';";

            $lukumaara = "";

            $result = $connection->query($query);

            if ($result->num_rows > 0)
            {
                while($row = $result->fetch_assoc())
                {
                    $lukumaara = $row['lkm'];
                }
            }

            return $lukumaara;

            $connection->close();
        }

        function HaeVaraukseenKuuluvatPalvelut($varausid)
        {
            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);
            
            $query = "SELECT * FROM Palvelu INNER JOIN Varauksen_palvelut ON Palvelu.palvelu_id = Varauksen_palvelut.palvelu_id WHERE Varauksen_palvelut.varaus_id = $varausid;";

            $palvelut = array();

            $result = $connection->query($query);

            if ($result->num_rows > 0)
            {
                while($row = $result->fetch_assoc())
                {
                    // $palvelu_id, $toimipiste_id, $nimi, $tyyppi, $kuvaus, $hinta, $alv)
                    $palvelu = new Palvelu($row["palvelu_id"], $row["toimipiste_id"], $row["nimi"], $row["tyyppi"], $row["kuvaus"], $row["hinta"], $row["alv"]);
                    $vp = new VarauksenPalvelut($varausid, $palvelu, $row["lkm"]);
                    $palvelut[] = $vp;
                }
            }

            return $palvelut;

            $connection->close();

        }
        
        // Palauttaa Varaus-objektin (1kpl) varaus-id:n perusteella
        function HaeVaraus($varausid)
        {
        
            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);

            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $query = "SELECT Varaus.*, Asiakas.*
            FROM Varaus INNER JOIN Asiakas ON Asiakas.asiakas_id = Varaus.asiakas_id WHERE Varaus.varaus_id = '$varausid';";
            $result = $connection->query($query);

            $varaus = "";
            $asiakas = "";

            if ($result->num_rows > 0) 
            {
                while($row = $result->fetch_assoc())
                {
                    $asiakas = new Asiakas($row["asiakas_id"], $row["etunimi"], $row["sukunimi"], $row["lahiosoite"], $row["postitoimipaikka"], $row["postinro"], $row["email"], $row["puhelinnro"]);
                    $varaus = new Varaus($row["varaus_id"], $asiakas, $row["toimipiste_id"], $row["varattu_pvm"], $row["vahvistus_pvm"], $row["varattu_alkupvm"], $row["varattu_loppupvm"]);
                }
            }

            return $varaus;

            $connection->close();
            
        }


        function HaeVarauksista($hakusana)
        {
            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);

            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }
            $nimet = explode(" ", $hakusana);

            $query = "SELECT Varaus.*, Asiakas.*
            FROM Varaus INNER JOIN Asiakas ON Asiakas.asiakas_id = Varaus.asiakas_id WHERE ((etunimi LIKE '" . $hakusana . "%' OR sukunimi LIKE '" . $hakusana . "%') OR (etunimi LIKE '$nimet[0]' AND sukunimi LIKE '$nimet[1]%') OR (sukunimi LIKE '$nimet[0]' AND etunimi LIKE '$nimet[1]%')) OR (Varaus.varaus_id = '$hakusana');";
            $result = $connection->query($query);

            $varaukset = array();
            if ($result->num_rows > 0) 
            {
                while($row = $result->fetch_assoc())
                {
                    $asiakas = new Asiakas($row["asiakas_id"], $row["etunimi"], $row["sukunimi"], $row["lahiosoite"], $row["postitoimipaikka"], $row["postinro"], $row["email"], $row["puhelinnro"]);
                    $varaus = new Varaus($row["varaus_id"], $asiakas, $row["toimipiste_id"], $row["varattu_pvm"], $row["vahvistus_pvm"], $row["varattu_alkupvm"], $row["varattu_loppupvm"]);
                    $varaukset[] = $varaus;
                }
            }

            return $varaukset;

            $connection->close();
        }

        function HaeVarauksistaToimipisteella($hakusana)
        {
            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);

            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $query = "SELECT Varaus.*, Asiakas.*
            FROM Varaus INNER JOIN Asiakas ON Asiakas.asiakas_id = Varaus.asiakas_id WHERE Varaus.toimipiste_id = '$hakusana';";
            $result = $connection->query($query);

            $varaukset = array();
            if ($result->num_rows > 0) 
            {
                while($row = $result->fetch_assoc())
                {
                    $asiakas = new Asiakas($row["asiakas_id"], $row["etunimi"], $row["sukunimi"], $row["lahiosoite"], $row["postitoimipaikka"], $row["postinro"], $row["email"], $row["puhelinnro"]);
                    $varaus = new Varaus($row["varaus_id"], $asiakas, $row["toimipiste_id"], $row["varattu_pvm"], $row["vahvistus_pvm"], $row["varattu_alkupvm"], $row["varattu_loppupvm"]);
                    $varaukset[] = $varaus;
                }
            }

            return $varaukset;

            $connection->close();
        }

        function HaeVarauksenMajoitusID($varausid)
        {
            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);

            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $query = "SELECT * FROM Varauksen_palvelut INNER JOIN Palvelu ON Varauksen_palvelut.palvelu_id = Palvelu.palvelu_id WHERE varaus_id = '$varausid' AND tyyppi = '1';";
            $result = $connection->query($query);

            $majoitusid = "";

            if ($result->num_rows > 0) 
            {
                while($row = $result->fetch_assoc())
                {
                    $majoitusid = $row["palvelu_id"];
                }
            }

            return $majoitusid;

            $connection->close();
        }

        // Markus

        public function LisaaAsiakas($etunimi, $sukunimi, $lahiosoite, $postitoimipaikka, $postinro, $email, $puhelinnro)
        {
            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);

            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $_etunimi = mysqli_real_escape_string($connection, $etunimi);
            $_sukunimi = mysqli_real_escape_string($connection, $sukunimi);
            $_lahiosoite = mysqli_real_escape_string($connection, $lahiosoite);
            $_postitoimipaikka = mysqli_real_escape_string($connection, $postitoimipaikka);
            $_postinro = mysqli_real_escape_string($connection, $postinro);
            $_email = mysqli_real_escape_string($connection, $email);
            $_puhelinnro = mysqli_real_escape_string($connection, $puhelinnro);

            $query = "INSERT INTO Asiakas (etunimi, sukunimi, lahiosoite, postitoimipaikka, postinro, email, puhelinnro) VALUES ('$_etunimi', '$_sukunimi', '$_lahiosoite', '$_postitoimipaikka', '$_postinro', '$_email', '$_puhelinnro')";

            if($connection->query($query) === TRUE)
            {
                echo "<p style='text-align:center';'>Asiakas lisätty onnistuneesti.</p>";
            }
            else
            {
                echo "<p style='text-align:center';'>Virhe asiakkaan lisäämisessä. Yritä myöhemmin uudelleen.</p>";
            }

            $connection->close();
        }

        public function PoistaAsiakas($asiakasid)
        {
            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);

            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }
            
            $_asiakasid = mysqli_real_escape_string($connection, $asiakasid);

            $query = "DELETE FROM Asiakas WHERE asiakas_id= '$_asiakasid'";

            if($connection->query($query) === TRUE)
            {
                echo "<p style='text-align:center';'>Asiakas poistettu järjestelmästä.</p>";
            }
            else
            {
                echo "<p style='text-align:center';'>Virhe asiakkaan poistamisessa. Yritä myöhemmin uudelleen.</p>";
            }

            $connection->close();
        }
        
        public function PaivitaAsiakas($asiakas) {

            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);
            
            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $_asiakasid = $connection->real_escape_string($asiakas->getAsiakasId());
            $_etunimi = $asiakas->getEtunimi();
            $_sukunimi = $asiakas->getSukunimi();
            $_lahiosoite = $asiakas->getLahiosoite();
            $_postitoimipaikka = $asiakas->getPostitoimipaikka();
            $_postinro = $asiakas->getPostinro();
            $_email = $asiakas->getEmail();
            $_puhelinnro = $asiakas->getPuhelinnro();

            $query = "UPDATE Asiakas SET etunimi='$_etunimi', sukunimi='$_sukunimi', lahiosoite='$_lahiosoite', postitoimipaikka='$_postitoimipaikka', postinro='$_postinro', email='$_email', puhelinnro='$_puhelinnro' WHERE asiakas_id= '$_asiakasid'";

            $result = $connection->query($query);

            if ($result){
                $message = "<p style='text-align:center';'>Asiakkaan tiedot päivitetty.</p>";
                
            } else {
                $message = "<p style='text-align:center';'>Virhe asiakastietojen päivittämisessä. Yritä myöhemmin uudelleen.</p>";
            }

            $connection->close();
            return $message;
        }

        public function HaeAsiakkaat()
        {
            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);
        
            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }
        
            $query = "SELECT * FROM Asiakas";
                    
            $listAsiakkaat = array();

            $result = $connection->query($query);
                    
            if ($result->num_rows > 0) 
            {
                while($row = $result->fetch_assoc()) {
                    $asiakas = new Asiakas($row["asiakas_id"], $row["etunimi"], $row["sukunimi"],
                    $row["lahiosoite"], $row["postitoimipaikka"], $row["postinro"], $row["email"], $row["puhelinnro"]);
                                
                    $listAsiakkaat[] = $asiakas;
                }
            } 
            else {
                $listAsiakkaat = null;
            }
            $connection->close();
                    
            return $listAsiakkaat;
        }

        public function HaeAsiakas($asiakkaanID) {

            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);
            
            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $query = "SELECT * FROM Asiakas WHERE asiakas_id = '$asiakkaanID'";

            $result = $connection->query($query);

            if ($result->num_rows > 0) 
            {
                $row = $result->fetch_assoc();
                $asiakas = new Asiakas($row["asiakas_id"], $row["etunimi"], $row["sukunimi"], $row["lahiosoite"], 
                    $row["postitoimipaikka"], $row["postinro"], $row["email"], $row["puhelinnro"]);
                
            } 
            else {
                $asiakas = null;
                // echo "Ei yhtään tulosta.";
            }

            $connection->close();

            return $asiakas;
        }


        // End of Markus

        // Timon osa

        public function HaeLaskut($asiakkaanID)
        {
            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);

            if ($connection->connect_error)
            {
                die("HaeLaskut ei saa yhteyttä tietokantaan.");
            }

            $query = "SELECT * FROM Lasku WHERE asiakas_id ='$asiakkaanID'";

            $result = $connection->query($query);

            if ($result->num_rows > 0) 
            {
                while($row = $result->fetch_assoc()) {
                    $laskut = new Lasku($row["lasku_id"], $row["asiakas_id"], $row["varaus_id"], $row["nimi"],
                    $row["lahiosoite"], $row["postitoimipaikka"], $row["postinro"], $row["summa"], $row["alv"]);
                    $listLaskut[] = $laskut;     
                
                }
            } 
                
            else 
            {
                echo "Ei laskuja tietokannassa.";
            }
            $connection->close();

            return $listLaskut;
        }

        //Päivittää muokattavan laskun tiedot
        public function PaivitaLasku($lasku) {

            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);
            
            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $lasku_id = $connection->real_escape_string($lasku->getLaskuId());
            $varaus_id = $connection->real_escape_string($lasku->getVarausId());
            $asiakas_id = $connection->real_escape_string($lasku->getAsiakasId());
            $sukunimi = $connection->real_escape_string($lasku->getSukunimi());
            $lahiosoite = $connection->real_escape_string($lasku->getLahiosoite());
            $postitoimipaikka = $connection->real_escape_string($lasku->getPostitoimipaikka());
            $postinro = $connection->real_escape_string($lasku->getPostinro());
            $summa = $connection->real_escape_string($lasku->getSumma());
            $alv = $connection->real_escape_string($lasku->getAlv());

            $query = "UPDATE Lasku SET lasku_id='$lasku_id', varaus_id='$varaus_id', asiakas_id='$asiakas_id', nimi='$sukunimi', lahiosoite='$lahiosoite',
             postitoimipaikka='$postitoimipaikka', postinro='$postinro', summa='$summa', alv='$alv' WHERE lasku_id='$lasku_id'";

            $result = $connection->query($query);

            if ($result){
                $message = "Tietojen tallentaminen onnistui";
                
            } else {
                $message = "Sattui odottamaton virhe, yritä myöhemmin uudelleen";
            }

            $connection->close();
            return $message;
        }

        //Lisää uuden laskun tietokantaan
        public function LisaaLasku($lasku) {

            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);
            
            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }
            
            $varaus_id = $connection->real_escape_string($lasku->getVarausId());
            $asiakas_id = $connection->real_escape_string($lasku->getAsiakasId());
            $sukunimi = $connection->real_escape_string($lasku->getSukunimi());
            $lahiosoite = $connection->real_escape_string($lasku->getLahiosoite());
            $postitoimipaikka = $connection->real_escape_string($lasku->getPostitoimipaikka());
            $postinro = $connection->real_escape_string($lasku->getPostinro());
            $summa = $connection->real_escape_string($lasku->getSumma());
            $alv = $connection->real_escape_string($lasku->getAlv()); 
            
            $query = "INSERT INTO Lasku (varaus_id, asiakas_id, nimi, lahiosoite, postitoimipaikka, postinro, summa, alv) VALUES ('$varaus_id', '$asiakas_id', '$sukunimi' ,'$lahiosoite', '$postitoimipaikka', '$postinro', '$summa', '$alv')";

            if($connection->query($query) === TRUE)
            {
                $message = "Tietojen tallentaminen onnistui";
            }
            else
            {
                $message = "Sattui odottamaton virhe, yritä myöhemmin uudelleen";
                echo("Error description: " . mysqli_error($connection)); 
            }

            $connection->close();
            return $message;
        }
        // Hakee yksittäisen laskun tiedot
        public function HaeLaskunTiedot($laskunID) {

            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);

            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $query = "SELECT * FROM Lasku WHERE lasku_id='$laskunID'";

            $result = $connection->query($query);

            if ($result->num_rows > 0) 
            {
                
                while($row = $result->fetch_assoc()) {
                    $laskuntiedot = new Lasku($row["lasku_id"], $row["asiakas_id"], $row["varaus_id"], $row["nimi"],
                    $row["lahiosoite"], $row["postitoimipaikka"], $row["postinro"], $row["summa"], $row["alv"]);
                        
                
                }
            } 
            else 
            {
                $laskuntiedot = null;
            }

            $connection->close();
            return $laskuntiedot;
        } 
        // Poistaa laskun tietokanasta
        public function PoistaLasku($laskunID) {

            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);

            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $query = "DELETE FROM Lasku WHERE lasku_id='$laskunID'";

            //$result = $connection->query($query);

            if($connection->query($query) === TRUE)
            {
                $message = "Tietojen poistaminen onnistui";
            }
            else
            {
                $message = "Sattui odottamaton virhe, yritä myöhemmin uudelleen";
            }

            $connection->close();
            return $message;
        } 

        // End of Timo

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