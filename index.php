<?php  
  include 'core/autoload.php';
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Vista por defecto</title>
  </head>
  <body>

    <h1>Pagina Index De Pruebas</h1>

    <h2>Empleados:</h2>

    <?php
      //$emp = new \entities\employeesEntity("pepe", 11252326, "la rioja 296", "2994563632");
      //$emp->insert() or die("No se puede insertar empleado");

      $empleados = \entities\employeesEntity::getAll();

      echo "<ul>";

      foreach($empleados as $e)
      {
        echo "\t<li>" . $e['nombre'] . "</li>";
      }

      echo "</ul>";
     ?>

  </body>
</html>
