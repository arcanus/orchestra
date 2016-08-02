<?php
  require_once 'entities/userEntity.php';

  echo "<h1> Pagina index de prueba </h1>";
  echo "<h2> Usuarios: </h2>";

  $users = new userEntity("user");

  $lista_usuarios = $users->getById(2);

  $users = null;

  echo $lista_usuarios["username"];

  /*
  foreach($lista_usuarios as $user)
  {
    echo $user["username"] . "<br>";
  }

  */

  /*
  $connection = new connection();
  $conn = $connection->connect();
  $usuarios = array();

  $stmt =  $conn->prepare("SELECT * FROM user where is_active = 1");
  $stmt->execute();

  while ($user = $stmt->fetch())
  {
    $usuarios[] = array(
      "id"        =>  $user["id"],
      "username"  =>  $user["username"],
      "password"  =>  $user["password"],
      "role"      =>  $user["role"],
      "activo"    =>  $user["is_active"]
    );
  }

  foreach($usuarios as $usuario)
  {
    echo "<h3>" . $usuario["username"] . " | " . $usuario["password"] . " | " . $usuario["role"] . "</h3>";
  }

  $conn = null;
*/
 ?>
