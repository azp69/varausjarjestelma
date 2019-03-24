<?php

    class Tietokanta
    {
        
        public function __construct()
        {
            require_once("db_connection.php");
            $this->db_servername = $db_servername;
            $this->db_username = $db_username;
            $this->db_password = $db_password;
            $this->db_name = $db_name;
        }

        public function __deconstruct()
        {

        }

        public function ListaaMokit()
        {
            echo $db_username;
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
            $conn->close();
        }
    }
?>