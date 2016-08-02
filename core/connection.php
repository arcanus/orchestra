<?php
  ini_set('display_errors', 'On');

  class connection{

      private $driver;
      private $server_host, $db_name, $db_user, $db_pass, $db_charset;

      public function __construct()
      {
        $db_config = require_once 'config/database.php';
        $this->driver = $db_config["driver"];
        $this->server_host = $db_config["host"];
        $this->db_name = $db_config["database"];
        $this->db_user = $db_config["user"];
        $this->db_pass = $db_config["pass"];
        $this->db_charset = $db_config["charset"];
      }

      public function connect()
      {
        try {

          if ($this->driver == "mysql")
          {
            $conn = new PDO("mysql:host=$this->server_host;dbname=$this->db_name;charset=$this->db_charset", $this->db_user, $this->db_pass);            

            //Activamos el modo error->exception de PDO:
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
          }
        } catch (PDOException $e) {
          echo "Connection failed. " . $e->getMessage();
        }
      }
  }

?>
