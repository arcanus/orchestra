<?php
ini_set('display_errors', 'On');
require_once './vendor/autoload.php';

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
      $fpdo = new FluentPDO($this->conn);

      $sql = $fpdo->from($this->table)->where("id = $id AND is_active = 1");

      $resul = ($sql) ? $sql->fetch() : null;

      if ($resul)
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
      $fpdo = new FluentPDO($this->conn);

      $sql = $fpdo->from($this->table)->where('is_active = 1');

      if ($sql)
      {
        return $sql->fetchAll();
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

          $fpdo = new FluentPDO($this->conn);
          $sql = $fpdo
                      ->update($this->table)
                      ->set(array('is_active' => 0))
                      ->where("id = $this->id");
          $sql->execute();

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
          $fpdo = new FluentPDO($this->conn);
          $sql = $fpdo
                      ->update($this->table)
                      ->set(array('is_active' => 0))
                      ->where("id = $id");
          $sql->execute();

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
