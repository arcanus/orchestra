<?php
  ini_set('display_errors', 'On');

  class connection{

      private static $driver;
      private static $server_host, $db_name, $db_user, $db_pass, $db_charset;

      private static function config()
      {
        $db_config = require 'config/database.php';
        self::$driver = $db_config["driver"];
        self::$server_host = $db_config["host"];
        self::$db_name = $db_config["database"];
        self::$db_user = $db_config["user"];
        self::$db_pass = $db_config["pass"];
        self::$db_charset = $db_config["charset"];        
      }

      public static function connect()
      {
        try
        {

          self::config();

          if (self::$driver == "mysql")
          {
            $conn = new PDO("mysql:host=" . self::$server_host . ";dbname=" . self::$db_name . ";charset=" . self::$db_charset, self::$db_user, self::$db_pass);

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
