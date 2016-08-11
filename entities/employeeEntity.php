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
	private $role;
//-------------------------------------------------------------------------------

//-------------------------------CONSTRUCTORES-----------------------------------
	public function __construct(
		$username = null,
		$pass = null,
		$role = null,
		)
	{

		$this->setId(null);
		$this->setUsername($username);
		$this->setPass($pass);
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

	public function getPass()
	{
		return $this->pass;
	}

	public function setPass($value)
	{
		$this->pass = $value;
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
		$this->is_value = $value;
	}

	//-------------------------------------------------------------------------------

	//---------------------------------METODOS---------------------------------------
	private function validate()
	{
		if (
			isset($this->username)
			&& isset($this->pass)
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

	private function insert()
	{
		try
		{
			if ($this->validate())
			{
				$conn = connection::connect();
				$fpdo = new FluentPDO($conn); 

				$values = array(
					'username' => $this->username,
					'pass' => $this->pass,
					'role' => $this->role,
					'is_active' => $this->is_active
				);

				$query = $fpdo->insertInto(self::getTableName())->values($values); 
				$resul = $query->execute();

				$query = null
				$fpdo = null
				$conn = null

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
}
