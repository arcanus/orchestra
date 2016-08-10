<?php
ini_set('display_errors', 'On');
require_once('core/connection.php');
require_once('vendor/autoload.php');

//Las entidades deben extender la entidad base BaseEntity
//para así heredar sus métodos y atributos.
class employeeEntity
{
//--------------------------------PROPIEDADES----------------------------------//
	private $username;
	private $pass;
	private $email;
//-------------------------------------------------------------------------------

//-------------------------------CONSTRUCTORES-----------------------------------
	public function __construct(
		$username = null,
		$pass = null,
		$email = null,
		)
	{

		$this->setId(null);
		$this->setUsername($username);
		$this->setPass($pass);
		$this->setEmail($email);
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

	public function getPass()
	{
		return $this->pass;
	}

	public function setPass($value)
	{
		$this->pass = $value;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setEmail($value)
	{
		$this->email = $value;
	}

	public function getIs_active()
	{
		return $this->is_active;
	}

	public function setIs_active($value)
	{
		$this->is_value = $value;
	}

}
