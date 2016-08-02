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
    $this->password = $value;
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
  public function validate()
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

  }
  //-------------------------------------------------------------------------------
}

?>
