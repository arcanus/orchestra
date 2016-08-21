<?php
  namespace core;

  class connection
  {

      private static $driver;
      private static $server_host, $db_name, $db_user, $db_pass, $db_charset;

      private static function config()
      {
        $db_config = include(__DIR__ . '/../config/database.php');

        self::$driver = $db_config["driver"];
        self::$server_host = $db_config["host"];
        self::$db_name = $db_config["database"];
        self::$db_user = $db_config["user"];
        self::$db_pass = $db_config["pass"];
        self::$db_charset = $db_config["charset"];
      }

      public static function connect($verbose = 1)
      {
        try
        {

          self::config();

          if (self::$driver == "mysql")
          {
            $conn = new \PDO("mysql:host=" . self::$server_host . ";dbname=" . self::$db_name . ";charset=" . self::$db_charset, self::$db_user, self::$db_pass);

            //Activamos el modo error->exception de PDO:
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $conn->query("SET NAMES " . self::$db_charset);
            return $conn;
          }
        } catch (\PDOException $e) {
          if($verbose == 1) echo "Connection failed. " . $e->getMessage() . "\n";
        }
      }

      public static function connectWithoutDb($verbose = 1)
      {
        try
        {

          self::config();

          if (self::$driver == "mysql")
          {
            $conn = new \PDO("mysql:host=" . self::$server_host . ";charset=" . self::$db_charset, self::$db_user, self::$db_pass);

            //Activamos el modo error->exception de PDO:
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $conn->query("SET NAMES " . self::$db_charset);
            return $conn;
          }
        } catch (\PDOException $e) {
          if($verbose == 1) echo "Connection failed. " . $e->getMessage() . "\n";
        }
      }
  }

?>
