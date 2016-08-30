<?php
  namespace config;

  class globalConfig
  {
    private static $env = 'dev';
    private static $defaultController = 'base';
    private static $defaultAction = 'index';

    public static function getEnv(): string
    {
      return self::$env;
    }

    public static function getDefaultController(): string
    {
      return self::$defaultController;
    }

    public static function getDefaultAction(): string
    {
      return self::$defaultAction;
    }

    public static function getConfig(): array
    {
      $config = array(
        'env'                 =>  self::$env,
        'defaultController'   =>  self::$defaultController,
        'defaultAction'       =>  self::$defaultAction
      );
      return $config;
    }

  }
?>
