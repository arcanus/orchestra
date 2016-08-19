<?php
  namespace config;

  class globalConfig
  {
    private static $env = 'dev';

    public static function getEnv()
    {
      return self::$env;
    }

  }
?>
