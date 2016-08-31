<?php
  include("../core/autoload.php");

  if(\config\globalConfig::getEnv() == 'dev')
  {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
  }
?>

<?php

  $controller = $_GET['controller'] ?? null;
  $action = $_GET['action'] ?? null;
  $params = $_GET['params'] ?? null;

  if(!isset($controller))
    $controller = \config\globalConfig::getDefaultController() . 'Controller';
  else
    $controller .= 'Controller';

  if(!isset($action))
    $action = \config\globalConfig::getDefaultAction() . 'Action';
  else
    $action .= 'Action';

  $cont_path = "\\controllers\\$controller";

  $cont = new $cont_path;

  $par_array = isset($params) ? explode("/", $params) : null;

  $cont->$action($par_array);

?>
