<?php
  include("../core/autoload.php");

  if(\config\globalConfig::getEnv() == 'dev')
  {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
  }
?>

<?php

  $controller = $_GET['controller'] ?? \config\globalConfig::getDefaultController() . 'Controller';
  $action = $_GET['action'] ?? \config\globalConfig::getDefaultAction() . 'Action';

  $cont_path = "\\controllers\\$controller";

  $cont = new $cont_path;

  $cont->indexAction();

?>
