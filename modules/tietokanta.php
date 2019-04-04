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

        public function LisaaMokki($nimi, $kuvaus, $sijainti, $hinta)
        {
            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);

            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $ni = mysqli_real_escape_string($connection, $nimi);
            $ku = mysqli_real_escape_string($connection, $kuvaus);
            $si = mysqli_real_escape_string($connection, $sijainti);
            $hi = mysqli_real_escape_string($connection, $hinta);

            $query = "INSERT INTO mokit (nimi, kuvaus, sijainti, hinta) VALUES ('$ni' ,'$ku', '$si', '$hi')";

            if($connection->query($query) === TRUE)
            {
                echo "OK.";
            }
            else
            {
                echo "Pieleen meni.";
            }

            $connection->close();
        
        }

        public function ListaaMokit()
        {
            $connection = new mysqli($this->db_servername, $this->db_username, $this->db_password, $this->db_name);

            if ($connection->connect_error)
            {
                die("Ei saada yhteyttä tietokantaan.");
            }

            $query = "SELECT * FROM mokit";

            $result = $connection->query($query);

            if ($result->num_rows > 0) 
            {
                while($row = $result->fetch_assoc()) {
                    echo "ID: " . $row["id"] . ". Nimi: " . $row["nimi"] . ". Kuvaus: " . $row["kuvaus"] . ". Sijainti: " . $row["sijainti"] . ". Hinta: " . $row["hinta"] . ".</br>";
                }
            } 
        
            else 
            {
                echo "Ei yhtään tulosta.";
            }
            $connection->close();
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
                    $connection->close();
                    return $luokka;
                }
            } 
        
            else 
            {
                return null;
            }
            $connection->close();
        }
    }
?>