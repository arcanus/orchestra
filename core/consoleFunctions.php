<?php

  //Crea el archivo de entidad
  function createEntity($nombre, $campos)
  {
      try
      {
          $file = fopen('entities/' . $nombre . "Entity.php", 'w') or die('No se puede crear la entidad.');
          fwrite($file, "<?php\n");
          fwrite($file, "require_once('core/connection.php');\n");
          fwrite($file, "require_once('vendor/autoload.php');\n");
          fwrite($file, "if (\$global['env'] == 'dev') ini_set('display_errors', 'On');\n\n");
          fwrite($file, "class $nombre" . "Entity\n");
          fwrite($file, "{\n");
          fwrite($file, "//--------------------------------PROPIEDADES----------------------------------//\n");

          fwrite($file, "\tprivate \$id;\n");

          foreach($campos as $campo)
          {
            fwrite($file, "\tprivate \$" . $campo['campo'] . ";\n");
          }

          fwrite($file, "\tprivate \$is_active;\n");

          fwrite($file, "//-------------------------------------------------------------------------------\n\n"
        . "//-------------------------------CONSTRUCTORES-----------------------------------\n");

          fwrite($file, "\tpublic function __construct(\n");

          $poner_coma = true; //Variable para saber si llevan coma los argumentos

          foreach($campos as $campo)
          {
            fwrite($file, "\t\t\$" . $campo['campo'] . " = null,\n");
          }

          fwrite($file, "\t\t\$is_active = true\n");

          fwrite($file, "\t\t)\n");
          fwrite($file, "\t{\n\n");

          fwrite($file, "\t\t\$this->setId(null);\n");

          foreach($campos as $campo)
          {
            fwrite($file, "\t\t\$this->set" . ucFirst($campo['campo']) .  "(\$" . $campo['campo'] . ");\n");
          }

          fwrite($file, "\t\t\$this->setIs_active(\$is_active);\n");
          fwrite($file, "\t}\n");
          fwrite($file, "\t//-------------------------------------------------------------------------------\n\n");

          fwrite($file, "\t//-------------------------------GETERS/SETERS-----------------------------------\n");

          fwrite($file, "\tpublic function getId()\n");
          fwrite($file, "\t{\n");
          fwrite($file, "\t\treturn \$this->id;\n");
          fwrite($file, "\t}\n\n");

          fwrite($file, "\tpublic function setId(\$value)\n");
          fwrite($file, "\t{\n");
          fwrite($file, "\t\t\$this->id = \$value;\n");
          fwrite($file, "\t}\n\n");

          foreach($campos as $campo)
          {
            fwrite($file, "\tpublic function get" . ucFirst($campo['campo']) . "()\n");
            fwrite($file, "\t{\n");
            fwrite($file, "\t\treturn \$this->" . $campo['campo'] . ";\n");
            fwrite($file, "\t}\n\n");

            fwrite($file, "\tpublic function set" . ucFirst($campo['campo']) . "(\$value)\n");
            fwrite($file, "\t{\n");
            fwrite($file, "\t\t\$this->" . $campo['campo'] . " = \$value;\n");
            fwrite($file, "\t}\n\n");
          }

          fwrite($file, "\tpublic function getIs_active()\n");
          fwrite($file, "\t{\n");
          fwrite($file, "\t\treturn \$this->is_active;\n");
          fwrite($file, "\t}\n\n");

          fwrite($file, "\tpublic function setIs_active(\$value)\n");
          fwrite($file, "\t{\n");
          fwrite($file, "\t\t\$this->is_active = \$value;\n");
          fwrite($file, "\t}\n\n");

          fwrite($file, "\t//-------------------------------------------------------------------------------\n\n");

          fwrite($file, "\t//---------------------------------METODOS---------------------------------------\n");

          //COMIENZO METODO VALIDATE()

          fwrite($file, "\tprivate function validate()\n");
          fwrite($file, "\t{\n");

          $usar_and = false; // Variable booleana para armar las lineas siguientes
                            // Si es true entonces la linea lleva un && al principio.
          foreach($campos as $campo)
          {
            if(!$usar_and)
              {
                if($campo['nulo'])
                {
                  fwrite($file, "\t\tif (\n\t\t\tisset(\$this->" . $campo['campo'] . ")\n");
                  $usar_and = true;
                }
              }
            else
              {
                if($campo['nulo'])
                {
                  fwrite($file, "\t\t\t&& isset(\$this->" . $campo['campo'] . ")\n");
                }
              }
          }

          fwrite($file, "\t\t\t&& isset(\$this->is_active)\n");

          fwrite($file, "\t\t\t)\n");
          fwrite($file, "\t\t\t{\n");
          fwrite($file, "\t\t\t\treturn true;\n");
          fwrite($file, "\t\t\t}\n");
          fwrite($file, "\t\t\telse\n");
          fwrite($file, "\t\t\t{\n");
          fwrite($file, "\t\t\t\treturn false;\n");
          fwrite($file, "\t\t\t}\n");

          fwrite($file, "\t}\n\n");

          //COMIENZO METODO INSERT()

          fwrite($file, "\tpublic function insert()\n");
          fwrite($file, "\t{\n");

          fwrite($file, "\t\ttry\n");
          fwrite($file, "\t\t{\n");

          fwrite($file, "\t\t\tif (\$this->validate())\n");
          fwrite($file, "\t\t\t{\n");

          fwrite($file, "\t\t\t\t\$conn = connection::connect();\n");
          fwrite($file, "\t\t\t\t\$fpdo = new FluentPDO(\$conn); \n\n");

          fwrite($file, "\t\t\t\t\$values = array(\n");

          foreach($campos as $campo)
          {
            fwrite($file, "\t\t\t\t\t'" . $campo['campo'] ."' => \$this->" . $campo['campo'] . ",\n");
          }

          fwrite($file, "\t\t\t\t\t'is_active' => \$this->is_active\n");
          fwrite($file, "\t\t\t\t);\n\n");

          fwrite($file, "\t\t\t\t\$query = \$fpdo->insertInto(self::getTableName())->values(\$values); \n");
          fwrite($file, "\t\t\t\t\$resul = \$query->execute();\n\n");

          fwrite($file, "\t\t\t\t\$query = null;\n");
          fwrite($file, "\t\t\t\t\$fpdo = null;\n");
          fwrite($file, "\t\t\t\t\$conn = null;\n\n");

          fwrite($file, "\t\t\t\t\$this->id = \$resul;\n\n");

          fwrite($file, "\t\t\t\treturn true;\n");
          fwrite($file, "\t\t\t}\n");
          fwrite($file, "\t\t\telse\n");
          fwrite($file, "\t\t\t{\n");
          fwrite($file, "\t\t\t\treturn null;\n");
          fwrite($file, "\t\t\t}\n");

          fwrite($file, "\t\t} catch (Exception \$e) {\n");
          fwrite($file, "\t\t\tdie(\"ERROR: \" . \$e->getMessage()); \n");
          fwrite($file, "\t\t}\n");

          fwrite($file, "\t}\n\n");

          //COMIENZO METODO DELETE

          fwrite($file, "\tpublic function delete()\n");
          fwrite($file, "\t{\n");

          fwrite($file, "\t\ttry\n");
          fwrite($file, "\t\t{\n");

          fwrite($file, "\t\t\tif (isset(\$this->id))\n");
          fwrite($file, "\t\t\t{\n");

          fwrite($file, "\t\t\t\t\$conn = connection::connect();\n");
          fwrite($file, "\t\t\t\t\$fpdo = new FluentPDO(\$conn); \n\n");

          fwrite($file, "\t\t\t\t\$sql = \$fpdo->update(self::getTableName())\n");
          fwrite($file, "\t\t\t\t\t\t\t\t\t\t->set(array('is_active' => false))\n");
          fwrite($file, "\t\t\t\t\t\t\t\t\t\t->where('id', \$this->id);\n\n");

          fwrite($file, "\t\t\t\t\$sql->execute();\n\n");

          fwrite($file, "\t\t\t\t\$sql = null;\n");
          fwrite($file, "\t\t\t\t\$fpdo = null;\n");
          fwrite($file, "\t\t\t\t\$conn = null;\n\n");

          fwrite($file, "\t\t\t\treturn true;\n");
          fwrite($file, "\t\t\t}\n");
          fwrite($file, "\t\t\telse\n");
          fwrite($file, "\t\t\t{\n");
          fwrite($file, "\t\t\t\treturn null;\n");
          fwrite($file, "\t\t\t}\n");

          fwrite($file, "\t\t} catch (Exception \$e) {\n");
          fwrite($file, "\t\t\tdie(\"ERROR: \" . \$e->getMessage()); \n");
          fwrite($file, "\t\t}\n");

          fwrite($file, "\t}\n\n");

          //COMIENZO METODOS ESTATICOS

          fwrite($file, "\t//---------------------------------METODOS ESTATICOS-----------------------------\n");

          //COMIENZO METODO getTableName()

          fwrite($file, "\tpublic static function getTableName()\n");
          fwrite($file, "\t{\n");
          fwrite($file, "\t\treturn chop(basename(__FILE__, '.php'), 'Entity');\n");
          fwrite($file, "\t}\n\n");

          //COMIENZO METODO getAll()

          fwrite($file, "\tpublic static function getAll()\n");
          fwrite($file, "\t{\n");

          fwrite($file, "\t\ttry\n");
          fwrite($file, "\t\t{\n");

          fwrite($file, "\t\t\t\$conn = connection::connect();\n");
          fwrite($file, "\t\t\t\$fpdo = new FluentPDO(\$conn); \n\n");

          fwrite($file, "\t\t\t\$resul = \$fpdo->from(self::getTableName())->where('is_active', 1);\n");

          fwrite($file, "\t\t\t\$fpdo = null;\n");
          fwrite($file, "\t\t\t\$conn = null;\n\n");

          fwrite($file, "\t\t\tif(\$resul)\n");
          fwrite($file, "\t\t\t{\n");
          fwrite($file, "\t\t\t\treturn \$resul->fetchAll();\n");
          fwrite($file, "\t\t\t}\n");
          fwrite($file, "\t\t\telse\n");
          fwrite($file, "\t\t\t{\n");
          fwrite($file, "\t\t\t\treturn null;\n");
          fwrite($file, "\t\t\t}\n");

          fwrite($file, "\t\t} catch (Exception \$e) {\n");
          fwrite($file, "\t\t\tdie(\"ERROR: \" . \$e->getMessage()); \n");
          fwrite($file, "\t\t}\n");

          fwrite($file, "\t}\n\n");

          //COMIENZO METODO getById

          fwrite($file, "\tpublic static function getById(\$id)\n");
          fwrite($file, "\t{\n");

          fwrite($file, "\t\ttry\n");
          fwrite($file, "\t\t{\n");

          fwrite($file, "\t\t\t\$conn = connection::connect();\n");
          fwrite($file, "\t\t\t\$fpdo = new FluentPDO(\$conn); \n\n");

          fwrite($file, "\t\t\t\$resul = \$fpdo->from(self::getTableName())->where(\"id = \$id AND is_active = true\");\n\n");

          fwrite($file, "\t\t\t\$fpdo = null;\n");
          fwrite($file, "\t\t\t\$conn = null;\n\n");

          fwrite($file, "\t\t\tif(\$resul)\n");
          fwrite($file, "\t\t\t{\n");

          fwrite($file, "\t\t\t\t\$db_user = \$resul->fetch(); \n");
          fwrite($file, "\t\t\t\t\$" . $nombre .  " = new " . $nombre . "Entity(); \n\n");
          fwrite($file, "\t\t\t\t\$" . $nombre . "->setId(\$db_user['id']); \n");

          foreach($campos as $campo)
          {
            fwrite($file, "\t\t\t\t\$" . $nombre . "->set" . ucfirst($campo['campo']) . "(\$db_user['" . $campo['campo'] . "']); \n");
          }

          fwrite($file, "\t\t\t\t\$" . $nombre . "->setIs_active(\$db_user['is_active']); \n\n");

          fwrite($file, "\t\t\t\treturn \$" . $nombre . ";\n");

          fwrite($file, "\t\t\t}\n");
          fwrite($file, "\t\t\telse\n");
          fwrite($file, "\t\t\t{\n");
          fwrite($file, "\t\t\t\treturn null;\n");
          fwrite($file, "\t\t\t}\n");

          fwrite($file, "\t\t} catch (Exception \$e) {\n");
          fwrite($file, "\t\t\tdie(\"ERROR: \" . \$e->getMessage()); \n");
          fwrite($file, "\t\t}\n");

          fwrite($file, "\t}\n\n");

          //COMIENZO METODO deleteById

          fwrite($file, "\tpublic static function deleteById(\$id)\n");
          fwrite($file, "\t{\n");

          fwrite($file, "\t\ttry\n");
          fwrite($file, "\t\t{\n");

          fwrite($file, "\t\t\tif (isset(\$id))\n");
          fwrite($file, "\t\t\t{\n");

          fwrite($file, "\t\t\t\t\$conn = connection::connect();\n");
          fwrite($file, "\t\t\t\t\$fpdo = new FluentPDO(\$conn); \n\n");

          fwrite($file, "\t\t\t\t\$sql = \$fpdo->update(self::getTableName())\n");
          fwrite($file, "\t\t\t\t\t\t\t\t\t\t->set(array('is_active' => false))\n");
          fwrite($file, "\t\t\t\t\t\t\t\t\t\t->where('id', \$id);\n\n");

          fwrite($file, "\t\t\t\t\$sql->execute();\n\n");

          fwrite($file, "\t\t\t\t\$sql = null;\n");
          fwrite($file, "\t\t\t\t\$fpdo = null;\n");
          fwrite($file, "\t\t\t\t\$conn = null;\n\n");

          fwrite($file, "\t\t\t\treturn true;\n");
          fwrite($file, "\t\t\t}\n");
          fwrite($file, "\t\t\telse\n");
          fwrite($file, "\t\t\t{\n");
          fwrite($file, "\t\t\t\treturn null;\n");
          fwrite($file, "\t\t\t}\n");

          fwrite($file, "\t\t} catch (Exception \$e) {\n");
          fwrite($file, "\t\t\tdie(\"ERROR: \" . \$e->getMessage()); \n");
          fwrite($file, "\t\t}\n");

          fwrite($file, "\t}\n\n");

          fwrite($file, "}\n");


          fclose($file);



      } catch (Exception $e) {

      }

  }

  //Crea la tabla en la base de datos en base a la entidad
  function createEntityTable()
  {
    $config = require './config/database.php';
    $conn = connection::connect();
    $nombre_campo = "";

    echo "Crear Nueva Entidad:\n";
    echo "********************\n\n";
    echo "\tDesde aqui vamos a proceder a crear una nueva entidad.\n";
    echo "\tTenga en cuenta que el nombre de la entidad tiene que ser el mismo que el de la tabla\n";
    echo "\ta la que corresponde en la base de datos.\n";
    echo "\tPor ejemplo: Si usted tiene una tabla llamada 'usuarios', el nombre de la entidad que tiene\n";
    echo "\tque ingresar es: 'usaurios'.\n";
    echo "\tLos campos 'id' y 'is_active' son agregados de forma automática, por tanto no los ingrese.\n\n";

    do
    {
      echo " -> Nombre de la entidad: ";

      $nombre = strtolower(trim(fgets(STDIN)));
    }while(!$nombre);

    do
    {

      echo " -> Nombre de campo / propiedad [presione enter para finalizar]: ";
      $nombre_campo = strtolower(trim(fgets(STDIN)));

      do
      {
        echo "\n\tTipos de dato validos: VARCHAR(len), INT, TINYINT, SMALLINT, MEDIUMINT, BIGINT,\n"; echo "\tFLOAT, DOUBLE, DATE, TIME, DATETIME, YEAR, TEXT, TINYTEXT, MEDIUMTEXT, LONGTEXT,\n"; echo "\tENUM('A', 'B', 'C', etc...)\n\n";
        echo " -> Tipo De Dato: ";

        $aux = strtoupper(trim(fgets(STDIN)));

        $tipo_dato = validarTipoDeDato($aux);

        if($tipo_dato == null)
        {
          echo "\n\tTipo de dato incorrecto. Por favor, verifique que el tipo de dato sea válido.\n";
        }

      }
      while(!isset($tipo_dato));

    do
    {
      echo "\n -> ¿Acepta Nulo? [si/no]: ";
      $nulo = trim(fgets(STDIN));
    } while(!$nulo);

    $campos[] = array(
      'campo'     =>  $nombre_campo,
      'tipo_dato' =>  strtoupper($tipo_dato),
      'nulo'      =>  $nulo == 'no' ? 'NOT NULL' : null
    );
    
  } while($nombre_campo);

    $sql = "CREATE TABLE $nombre (id int NOT NULL AUTO_INCREMENT, PRIMARY KEY (id)) DEFAULT CHARSET= " . $config['charset'];

    $conn->exec($sql);

    foreach ($campos as $campo)
    {
      $sql = "ALTER TABLE $nombre ADD "
              . $campo['campo'] . " "
              . $campo['tipo_dato'] . " "
              . $campo['nulo'];
      $conn->exec($sql);
    }

    $sql = "ALTER TABLE $nombre ADD is_active BIT NOT NULL";
    $conn->exec($sql);

    echo "\n\n*** TABLA CREADA CORRECTAMENTE ***\n\n";

    $info_entity = array();

    $info_entity = array(
      'nombre' => $nombre,
      'campos' => $campos
    );

    return $info_entity;
  }

  //Valida que los tipos de datos ingresados por el usuario
  //sean tipos de datos validos.
  function validarTipoDeDato($aux)
  {
      if (isset($aux))
      {
        switch ($aux)
        {
          case 'VARCHAR':
          {
            return 'VARCHAR(200)';
            break;
          }
          case 'INT':
          {
            return $aux;
            break;
          }
          case 'TINYINT':
          {
            return $aux;
            break;
          }
          case 'SMALLINT':
          {
            return $aux;
            break;
          }
          case 'MEDIUMINT':
          {
            return $aux;
            break;
          }
          case 'BIGINT':
          {
            return $aux;
            break;
          }
          case 'FLOAT':
          {
            return $aux;
            break;
          }
          case 'DOUBLE':
          {
            return $aux;
            break;
          }
          case 'DATE':
          {
            return $aux;
            break;
          }
          case 'TIME':
          {
            return $aux;
            break;
          }
          case 'DATETIME':
          {
            return $aux;
            break;
          }
          case 'YEAR':
          {
            return $aux;
            break;
          }
          case 'TEXT':
          {
            return $aux;
            break;
          }
          case 'TINYTEXT':
          {
            return $aux;
            break;
          }
          case 'MEDIUMTEXT':
          {
            return $aux;
            break;
          }
          case 'LONGTEXT':
          {
            return $aux;
            break;
          }
          default:
          {
            if(substr($aux, 0, 4) == 'ENUM')
            {
              return $aux;
            }
            elseif(substr($aux, 0, 7) == 'VARCHAR')
            {
              return $aux;
            }
            else
            {
              return null;
            }
            break;
          }
        }
      }
  }

?>
