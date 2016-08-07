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


      $lista_usuarios = userEntity::getAll();

      foreach ($lista_usuarios as $usuario)
      {
        echo "<h3>" . $usuario["username"] . " ||| " . $usuario['password'] . "</h3>";
      }

      unset($lista_usuarios);

      $u = userEntity::getById(1);

      echo $u->getUsername();


     ?>

  </body>
</html>
