<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Vista por defecto</title>
  </head>
  <body>

    <?php
      require_once 'entities/userEntity.php';

      echo "<h1> Pagina index de prueba </h1>";
      echo "<h2> Usuarios: </h2>";

      $users = new userEntity("user");

      $users->setUsername("Pepito");
      $users->validate();

      $lista_usuarios = $users->getById(2);

      $users = null;

      echo $lista_usuarios["username"];

     ?>

  </body>
</html>
