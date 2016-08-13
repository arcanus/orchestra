<?php
require_once('core/connection.php');
require_once('vendor/autoload.php');
if ($global['env'] == 'dev') ini_set('display_errors', 'On');

//Las entidades deben extender la entidad base BaseEntity
//para así heredar sus métodos y atributos.
class employeeEntity
{
//--------------------------------PROPIEDADES----------------------------------//
	private $id;
	private $fullname;
	private $adress;
	private $phone;
	private $legajo;
	private $is_active;
//-------------------------------------------------------------------------------

//-------------------------------CONSTRUCTORES-----------------------------------
	public function __construct(
		$fullname = null,
		$adress = null,
		$phone = null,
		$legajo = null,
		$is_active = true
		)
	{

		$this->setId(null);
		$this->setFullname($fullname);
		$this->setAdress($adress);
		$this->setPhone($phone);
		$this->setLegajo($legajo);
		$this->setIs_active($is_active);
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

	public function getFullname()
	{
		return $this->fullname;
	}

	public function setFullname($value)
	{
		$this->fullname = $value;
	}

	public function getAdress()
	{
		return $this->adress;
	}

	public function setAdress($value)
	{
		$this->adress = $value;
	}

	public function getPhone()
	{
		return $this->phone;
	}

	public function setPhone($value)
	{
		$this->phone = $value;
	}

	public function getLegajo()
	{
		return $this->legajo;
	}

	public function setLegajo($value)
	{
		$this->legajo = $value;
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
			isset($this->fullname)
			&& isset($this->legajo)
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
					'fullname' => $this->fullname,
					'adress' => $this->adress,
					'phone' => $this->phone,
					'legajo' => $this->legajo,
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
										->set(array('is_active' => false))
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

			$resul = $fpdo->from(self::getTableName())->where("id = $id AND is_active = true");

			$fpdo = null;
			$conn = null;

			if($resul)
			{
				$db_user = $resul->fetch();
				$employee = new employeeEntity();

				$employee->setId($db_user['id']);
				$employee->setFullname($db_user['fullname']);
				$employee->setAdress($db_user['adress']);
				$employee->setPhone($db_user['phone']);
				$employee->setLegajo($db_user['legajo']);
				$employee->setIs_active($db_user['is_active']);

				return $employee;
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
										->set(array('is_active' => false))
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
