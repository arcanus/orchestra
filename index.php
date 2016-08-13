<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Vista por defecto</title>
  </head>
  <body>

    <?php
      ini_set('display_errors', 'On');
      require_once 'entities/userEntity.php';

      echo "<h1> Pagina index de prueba </h1>";
      echo "<h2> Usuarios: </h2>";

      /*
      $usuario = new userEntity('Juancho', 'Llalalala1234', 'ROLE_ADMIN');

      if ($usuario->insert())
      {
        echo "Usuario creado! <br>";
      }
      else
      {
        echo "No se pudo crear el usuario. <br>";
      }
      */

      /*
      echo "User ID: <strong>" . $usuario->getId() . " </strong> <br>";
      echo "Username: <strong>" . $usuario->getUsername() . " </strong> <br>";
      echo "Password: <strong>" . $usuario->getPassword() . " </strong> <br>";
      echo "Role: <strong>" . $usuario->getRole() . " </strong> <br>";
      echo "Is Active: <strong>" . $usuario->getIs_active() . " </strong> <br>";
      */

      $lista_usuarios = userEntity::getAll();

      foreach ($lista_usuarios as $usuario)
      {
        echo "<h3>" . $usuario['id'] . " ||| " .
        $usuario["username"] . " ||| " .
        $usuario['password'] . " ||| " .
        $usuario['role'] .
        "</h3>";
      }

      $lista_usuarios = null;

      require_once 'entities/employeeEntity.php';


      /*$employee = new employeeEntity("Pedro", "lalala 2222", "564654","9999");
      $employee->insert();
      $employee = null;
      */
      /*
      $employee = new employeeEntity();

      $employee->setFullname("pepe el empleado");
      $employee->setAdress("la conchinchina 359");
      $employee->setPhone("555-7755632");
      $employee->setLegajo("23796");


      if($employee->insert())
      {
        echo "Empleado creado exitosamente! <br> <br>";
      }

      */

      $lista_empleados = employeeEntity::getAll();

      foreach ($lista_empleados as $empleado)
      {
        echo "<h3>" . $empleado['id'] . " ||| " .
        $empleado["fullname"] . " ||| " .
        $empleado['adress'] . " ||| " .
        $empleado['phone'] . " ||| " .
        $empleado['legajo'] .
        "</h3>";
      }

      $lista_usuarios = null;



     ?>

  </body>
</html>
