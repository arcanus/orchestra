<?php
  namespace config;

  class globalConfig
  {
    private static $env = 'dev';
    private static $defaultController = 'base';
    private static $defaultAction = 'index';

    //Siempre que se cree un nuevo controlador con vistas propias en un nuevo directorio dentro de /views/ se debe agregar el nombre del mismo en este array;
    private static $templates = array(
      'templates',
      'base'
    );


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

    public static function getTemplates()
    {
      $templates_path = array();

      foreach(self::$templates as $template)
      {
        $templates_path[] = getcwd() . '/../views/' . $template;
      }

      return $templates_path;

    }

  }
?>
