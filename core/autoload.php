<?php

  include 'config/global.php';
  include 'vendor/autoload.php';

  spl_autoload_register(function($class)
  {
    if(!require_once str_replace('\\', '/', $class) . ".php")
    {
      die("No se puede cargar $class");
    }
  });

?>
