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

     ?>

  </body>
</html>
