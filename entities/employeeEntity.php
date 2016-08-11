<?php
require_once('core/connection.php');
require_once('vendor/autoload.php');
if ($global['env'] == 'dev') ini_set('display_errors', 'On');

//Las entidades deben extender la entidad base BaseEntity
//para así heredar sus métodos y atributos.
class employeeEntity
{
//--------------------------------PROPIEDADES----------------------------------//
	private $user;
	private $pass;
	private $role;
//-------------------------------------------------------------------------------

//-------------------------------CONSTRUCTORES-----------------------------------
	public function __construct(
		$user = null,
		$pass = null,
		$role = null,
		$is_active = 1
		)
	{

		$this->setId(null);
		$this->setUser($user);
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

	public function getUser()
	{
		return $this->user;
	}

	public function setUser($value)
	{
		$this->user = $value;
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
			isset($this->user)
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

	public function insert()
	{
		try
		{
			if ($this->validate())
			{
				$conn = connection::connect();
				$fpdo = new FluentPDO($conn); 

				$values = array(
					'user' => $this->user,
					'pass' => $this->pass,
					'role' => $this->role,
					'is_active' => $this->is_active
				);

				$query = $fpdo->insertInto(self::getTableName())->values($values); 
				$resul = $query->execute();

				$query = null;
				$fpdo = null;
				$conn = null;

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

				$sql = $fpdo->update(self::getTableName())
										->set(array('is_active' => 0))
										->where('id', $this->id);

				$sql->execute();

				$sql = null;
				$fpdo = null;
				$conn = null;

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

	//---------------------------------METODOS ESTATICOS-----------------------------
	public static function getTableName()
	{
		return chop(basename(__FILE__, '.php'), 'Entity');
	}

	public static function getAll()
	{
		try
		{
			$conn = connection::connect();
			$fpdo = new FluentPDO($conn); 

			$resul = $fpdo->from(self::getTableName())->where('is_active', 1);
			$fpdo = null;
			$conn = null;

			if($resul)
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
			$conn = connection::connect();
			$fpdo = new FluentPDO($conn); 

			$resul = $fpdo->from(self::getTableName())->where('id = $id AND is_active = 1');

			$fpdo = null;
			$conn = null;

			if($resul)
			{
				$db_user = $resul->fetch(); 
				$user = new userEntity(); 

				$user->setId($db_user['id']); 
				$user->setUser($db_user['user']); 
				$user->setPass($db_user['pass']); 
				$user->setRole($db_user['role']); 
				$user->is_active($db_user['is_active']); 

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

				$sql = $fpdo->update(self::getTableName())
										->set(array('is_active' => 0))
										->where('id', $id);

				$sql->execute();

				$sql = null;
				$fpdo = null;
				$conn = null;

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
