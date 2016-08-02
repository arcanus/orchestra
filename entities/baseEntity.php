<?php
ini_set('display_errors', 'On');
class baseEntity
{

  protected $table;
  protected $conn;

  public function __construct()
  {

    $this->table = chop(basename(__FILE__, '.php'), "Entity");
    //$this->table = $table;
    require_once ('./core/connection.php');
    $connection = new connection();
    $this->conn = $connection->connect();
  }

  public function __destruct()
  {
    $this->conn = null;
  }

  public function getById($id)
  {
    try
    {
      $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE id = :id AND is_active = 1");

      $stmt->bindParam(':id', $id);

      $stmt->execute();

      //Indicamos que queremos que nos devuelva un array asociativo
      //con el indice basado en el nombre de la columnda.
      //para esto usamos la constante PDO::FETCH_ASSOC
      if ($resul = $stmt->fetch(PDO::FETCH_ASSOC))
      {
        return $resul;
      }
      else
      {
        return null;
      }
    } catch (Exception $e) {
      die("ERROR: " . $e->getMessage());
    }

  }

  public function getAll()
  {
    try
    {
      $stmt = $this->conn->prepare("SELECT * FROM $this->table");

      $stmt->execute();

      //Indicamos que queremos que nos devuelva un array asociativo
      //con el indice basado en el nombre de la columnda.
      //para esto usamos la constante PDO::FETCH_ASSOC
      if ($resul = $stmt->fetchAll(PDO::FETCH_ASSOC))
      {
        return $resul;
      }
      else
      {
        return null;
      }
    } catch (Exception $e) {
      die("ERROR: " . $e->getMessage());
    }

  }

}

?>
