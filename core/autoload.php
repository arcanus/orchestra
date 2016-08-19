<?php

  require_once 'vendor/autoload.php';

  spl_autoload_register(function($class)
  {
    try
    {      
      require_once str_replace('\\', '/', $class) . ".php";
    }
    catch(Exception $e)
    {
      die("No se puede cargar $class\n" . $e->getMessage);
    }

  });

?>
