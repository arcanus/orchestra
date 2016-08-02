<?php
  require_once 'entities/baseEntity.php';

  echo "<h1> Pagina index de prueba </h1>";
  echo "<h2> Usuarios: </h2>";

  $usuarios = new baseEntity("user");

  $lista_users = $usuarios->getAll();

  foreach($lista_users as $user)
  {
    echo $user["username"] . "<br>";
  }

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
