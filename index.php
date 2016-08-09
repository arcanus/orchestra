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

      $usuario = new userEntity('Paul', '1234');

      /*
      die(var_dump($usuario));

      if ($usuario->insert())
      {
        echo "Usuario creado! <br>";
      }
      */

      $lista_usuarios = userEntity::getAll();

      foreach ($lista_usuarios as $usuario)
      {
        echo "<h3>" . $usuario['id'] . " ||| " .  $usuario["username"] . " ||| " . $usuario['password'] . "</h3>";
      }

      $lista_usuarios = null;

     ?>

  </body>
</html>
