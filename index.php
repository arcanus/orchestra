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
      require_once 'vendor/autoload.php';

      echo "<h1> Pagina index de prueba </h1>";
      echo "<h2> Usuarios: </h2>";

      $user = new userEntity();

      $user->deleteById(6);

      //$user->getById(2);

      //echo = $user->getUsername();

      /*
      $user = new userEntity();

      $user->setUsername("pepito");
      $user->setPassword("12345");
      $user->setRole("ROLE_USER");

      if ($user->insert())
      {
        echo "Usuario creado: " . $user->getUsername() . "<br>";
      }
      */

     ?>

  </body>
</html>
