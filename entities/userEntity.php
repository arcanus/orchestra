<?php
ini_set('display_errors', 'On');
require_once('baseEntity.php');

//Las entidades deben extender la entidad base BaseEntity
//para así heredar sus métodos y atributos.
class userEntity extends baseEntity
{
  //--------------------------------PROPIEDADES----------------------------------//
  private $username;
  private $password;
  private $role;
  //-------------------------------------------------------------------------------

  //-------------------------------CONSTRUCTORES-----------------------------------
  public function __construct()
  {
    //Se debe llamar primeramente al constructor de la clase base
    parent::__construct();
    //Ahora configuramos el nombre de la tabla que se corresponde
    //con la entidad
    $this->table = chop(basename(__FILE__, '.php'), "Entity");
  }
  //-------------------------------------------------------------------------------

  //-------------------------------GETERS/SETERS-----------------------------------
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

  public function insert()
  {
    try
    {
        if ($this->validate())
        {
          $stmt = $this->conn->prepare("INSERT INTO " . $this->table .
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
