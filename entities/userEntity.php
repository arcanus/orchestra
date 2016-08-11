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
  public function __construct(
    $username   = null,
    $password   = null,
    $role       = 'ROLE_USER'
    )
  {

    $this->setId(null);
    $this->setUsername($username);
    $this->setPassword($password);
    $this->setRole($role);
    $this->setIs_active(1);
  }
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
      {
        return true;
      }
      else
      {
        return false;
      }
  }

  public function insert()
  {
    try
    {
      if ($this->validate())
      {
        $conn = connection::connect();
        $fpdo = new FluentPDO($conn);

        $values = array(
          'username'  =>  $this->username,
          'password'  =>  $this->password,
          'role'      =>  $this->role,
          'is_active' =>  $this->is_active
        );

        $query = $fpdo->insertInto(self::getTableName())->values($values);
        $resul = $query->execute();

        $query = null;
        $conn = null;
        $fpdo = null;

        $this->id = $resul;

        return true;
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
          $conn = connection::connect();
          $fpdo = new FluentPDO($conn);
          $sql = $fpdo
                      ->update(self::getTableName())
                      ->set(array('is_active' => 0))
                      ->where("id", $this->id);

          $sql->execute();

          $sql = null;
          $conn = null;
          $fpdo = null;

          return true;
        }
        else
          return null;

    } catch (Exception $e) {
      die("ERROR: " . $e->getMessage());
    }
  }

  //---------------------------------METODOS ESTATICOS-----------------------------

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

  public static function deleteById($id)
  {
    try
    {
        if (isset($id))
        {
          $conn = connection::connect();
          $fpdo = new FluentPDO($conn);
          $sql = $fpdo
                      ->update(self::getTableName())
                      ->set(array('is_active' => 0))
                      ->where("id = $id");

          $sql->execute();

          $sql = null;
          $conn = null;
          $fpdo = null;

          return true;
        }
        else
          return null;

    } catch (Exception $e) {
      die("ERROR: " . $e->getMessage());
    }

  }

}
  //-------------------------------------------------------------------------------

?>
