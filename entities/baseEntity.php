<?php
ini_set('display_errors', 'On');

class baseEntity
{

  protected $table;
  protected $conn;
  protected $id;
  protected $is_active;

  public function __construct()
  {
    $this->table = chop(basename(__FILE__, '.php'), "Entity");
    require_once ('./core/connection.php');
    $connection = new connection();
    $this->conn = $connection->connect();
    $this->is_active = 1;
    $this->id = null;
  }

  public function getId()
  {
    return $this->id;
  }

  public function getIsActive()
  {
    return $this->is_active();
  }

  public function setIsActive(bool $value)
  {
    $this->is_active = $value;
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
        $this->id = $resul["id"];
        $this->is_active = $resul["is_active"];

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
      $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE is_active=1");

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

  public function delete()
  {
    try
    {
        if (isset($this->id))
        {
          $stmt = $this->conn->prepare("UPDATE $this->table SET is_active = 0 WHERE id = :id");
          $stmt->bindParam(":id", $this->id);

          $stmt->execute();

          return true;
        }
        else
          return null;

    } catch (Exception $e) {
      die("ERROR: " . $e->getMessage());
    }

  }

  public function deleteById($id)
  {
    try
    {
        if (isset($id))
        {
          $stmt = $this->conn->prepare("UPDATE $this->table SET is_active = 0 WHERE id = :id");
          $stmt->bindParam(":id", $id);

          $stmt->execute();

          return true;
        }
        else
          return null;

    } catch (Exception $e) {
      die("ERROR: " . $e->getMessage());
    }

  }

  public function __destruct()
  {
    //Cerramos la conexión
    $this->conn = null;
  }

}

?>
