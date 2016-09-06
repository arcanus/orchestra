<?php

    //Función muy útil a la hora de debuggear. Hace un dump y un die al mismo tiempo.
    function dumpAndDie($var)
    {
      die(var_dump($var));
    }

    //Renderiza una vista.  El formato del valor $view debe ser controller/vista.
    /*function renderView($view, $params = null)
    {
      include __DIR__ . '/../' .  '/views/' . $view;
  }*/

    //Escribe el valor de un parámetro
    function getParam(string $name, array $params)
    {
        echo $params[$name];
    }

    function renderView($view, $params = array())
    {
        $loader = new \Twig_Loader_Filesystem(\config\globalConfig::getTemplates());
        $twig = new \Twig_Environment($loader);

        echo $twig->render($view, $params);
    }

?>
