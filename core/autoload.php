<?php

  require_once(__DIR__ . "/../vendor/autoload.php");

  spl_autoload_register(function($class)
  {
    try
    {
      require_once(__DIR__ . "/../" . str_replace('\\', '/', $class) . ".php");
    }
    catch(Exception $e)
    {
      die("No se puede cargar $class\n" . $e->getMessage);
    }

  });

?>
