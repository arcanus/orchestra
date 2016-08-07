<?php
ini_set('display_errors', 'On');
require_once('core/connection.php');
require_once('vendor/autoload.php');

//Las entidades deben extender la entidad base BaseEntity
//para así heredar sus métodos y atributos.
class userEntity
{
  //--------------------------------PROPIEDADES----------------------------------//
  private $id;
  private $username;
  private $password;
  private $role;
  private $is_active;
  //-------------------------------------------------------------------------------

  //-------------------------------CONSTRUCTORES-----------------------------------

  //-------------------------------------------------------------------------------

  //-------------------------------GETERS/SETERS-----------------------------------
  public function getId()
  {
    return $this->id;
  }

  public function setId($value)
  {
    $this->id = $value;
  }

  public function getUsername()
  {
    return $this->username;
  }

  public function setUsername($value)
  {
    $this->username = $value;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function setPassword($value)
  {
    $this->password = password_hash($value, PASSWORD_DEFAULT);
  }

  public function getRole()
  {
    return $this->role;
  }

  public function setRole($value)
  {
    $this->role = $value;
  }

  public function getIs_active()
  {
    return $this->is_active;
  }

  public function setIs_active($value)
  {
    $this->is_active = $value;
  }

  //-------------------------------------------------------------------------------

  //---------------------------------METODOS---------------------------------------
  private function validate()
  {
    if (
      isset($this->username)
      && isset($this->password)
      && isset($this->role)
      && isset($this->is_active)
      )
      return true;
      else
      return false;
  }

  private static function getTableName()
  {
    return chop(basename(__FILE__, '.php'), "Entity");
  }

  public static function getAll()
  {
    try
    {
      $conn = connection::connect();
      $fpdo = new FluentPDO($conn);

      $resul = $fpdo->from(self::getTableName())->where("is_active", 1);

      $conn = null;
      $fpdo = null;

      if ($resul)
      {
        return $resul->fetchAll();
      }
      else
      {
        return null;
      }

    } catch (Exception $e) {
      die("ERROR: " . $e->getMessage());
    }
  }

  public static function getById($id)
  {
    try
    {

      $fpdo = new FluentPDO(connection::connect());

      $resul = $fpdo->from(self::getTableName())->where("id = $id AND is_active = 1");

      $conn = null;
      $fpdo = null;

      if ($resul)
      {
        $db_user = $resul->fetch();
        $user = new userEntity();

        $user->setId($db_user['id']);
        $user->setUsername($db_user['username']);
        $user->setPassword($db_user['password']);
        $user->setRole($db_user['role']);
        $user->setIs_active($db_user['is_active']);

        return $user;
      }
      else
      {
        return null;
      }

    } catch (Exception $e) {
      die("ERROR: " . $e->getMessage());
    }
  }

  public function insert()
  {
    try
    {
        if ($this->validate())
        {
          $conn = connection::connect();
          $stmt = $conn->prepare("INSERT INTO " . self::getTableName() .
            "(username, password, role, is_active)
            VALUES (:username, :password, :role, 1)");

          $stmt->bindParam(":username", $this->username);
          $stmt->bindParam(":password", $this->password);
          $stmt->bindParam(":role", $this->role);

          $stmt->execute();

          return true;

        }
          return null;
    } catch (Exception $e) {
      die("ERROR: " . $e->getMessage());
    }

  }
  //-------------------------------------------------------------------------------
}

?>
