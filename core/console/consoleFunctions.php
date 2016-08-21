<?php
  namespace core\console;

  class consoleFunctions
  {

    //Crea el archivo de entidad
    public static function createEntity($nombre, $campos)
    {
        try
        {
            $file = fopen('entities/' . $nombre . "Entity.php", 'w') or die(" -> No se puede crear la entidad.\n\n");

            fwrite($file, "<?php\n");
            fwrite($file, "namespace entities;\n\n");

            fwrite($file, "class $nombre" . "Entity implements \\core\\iEntity\n");
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

            fwrite($file, "\t\t\t\t\$conn = \\core\\connection::connect();\n");
            fwrite($file, "\t\t\t\t\$fpdo = new \\FluentPDO(\$conn); \n\n");

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

            fwrite($file, "\t\t\t\t\$conn = \\core\\connection::connect();\n");
            fwrite($file, "\t\t\t\t\$fpdo = new \\FluentPDO(\$conn); \n\n");

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

            fwrite($file, "\t\t\t\$conn = \\core\\connection::connect();\n");
            fwrite($file, "\t\t\t\$fpdo = new \\FluentPDO(\$conn); \n\n");

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

            fwrite($file, "\t\t\t\$conn = \\core\\connection::connect();\n");
            fwrite($file, "\t\t\t\$fpdo = new \\FluentPDO(\$conn); \n\n");

            fwrite($file, "\t\t\t\$resul = \$fpdo->from(self::getTableName())->where(\"id = \$id AND is_active = true\");\n\n");

            fwrite($file, "\t\t\t\$fpdo = null;\n");
            fwrite($file, "\t\t\t\$conn = null;\n\n");

            fwrite($file, "\t\t\tif(\$resul)\n");
            fwrite($file, "\t\t\t{\n");

            fwrite($file, "\t\t\t\t\$db_user = \$resul->fetch(); \n");
            fwrite($file, "\t\t\t\t\$" . $nombre .  " = new \\entities\\" . $nombre . "Entity(); \n\n");
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

            fwrite($file, "\t\t\t\t\$conn = \\core\\connection::connect();\n");
            fwrite($file, "\t\t\t\t\$fpdo = new \\FluentPDO(\$conn); \n\n");

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
          echo "ERROR: " . $e->getMessage();
        }

    }

    //Crea la tabla en la base de datos en base a la entidad
    public static function createEntityTable()
    {
      $config = require(__DIR__ . '/../../config/database.php');
      $conn = \core\connection::connect();
      $nombre_campo = "";
      $campos = array();

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
        echo "\n -> Nombre de la entidad: ";

        $nombre = strtolower(trim(fgets(STDIN)));
      }while(!$nombre);

      self::verificarEntidad($nombre);

      echo "\n -> Nombre de campo / propiedad [presione enter para finalizar]: ";
      $nombre_campo = strtolower(trim(fgets(STDIN)));

      if(!$nombre_campo) die("\n -> No se ha creado ningúna entidad.\n\n");

      while($nombre_campo)
      {
        do
        {
          echo "\n\tTipos de dato validos: VARCHAR(len), INT, TINYINT, SMALLINT, MEDIUMINT, BIGINT,\n"; echo "\tFLOAT, DOUBLE, DATE, TIME, DATETIME, YEAR, TEXT, TINYTEXT, MEDIUMTEXT, LONGTEXT,\n"; echo "\tENUM('A', 'B', 'C', etc...)\n\n";
          echo " -> Tipo De Dato: ";

          $aux = strtoupper(trim(fgets(STDIN)));

          $tipo_dato = \core\console\consoleFunctions::validarTipoDeDato($aux);

          if($tipo_dato == null)
          {
            echo "\n\tTipo de dato incorrecto. Por favor, verifique que el tipo de dato sea válido.\n";
          }

        } while(!isset($tipo_dato));

        do
        {
          echo "\n -> ¿Acepta Nulo? [si/no]: ";
          $nulo = trim(fgets(STDIN));
        } while($nulo != 'si' && $nulo != 'no');

        do
        {
          echo "\n -> ¿El campo es único? [si/no]: ";
          $unico = trim(fgets(STDIN));
        } while($unico != 'si' && $unico != 'no');


        echo "\n * RESUMEN:";
        echo "\n **********\n";
        echo "\n -> Nombre De Campo: " . $nombre_campo;
        echo "\n -> Tipo De Dato: " . $tipo_dato;
        echo "\n -> Acepta Nulo: " . $nulo;
        echo "\n -> Campo Único: " . $unico;
        echo "\n";

        do
        {
          echo "\n -> ¿Es Correcto? si/no: ";
          $campo_correcto = strtolower(trim(fgets(STDIN)));
        } while($campo_correcto != 'si' && $campo_correcto != 'no');

        if ($campo_correcto == 'si')
        {
          $campos[] = array(
            'campo'     =>  $nombre_campo,
            'tipo_dato' =>  strtoupper($tipo_dato),
            'nulo'      =>  $nulo == 'no' ? 'NOT NULL' : null,
            'unico'     =>  $unico == 'si' ? 'UNIQUE' : null
          );
        }

        echo "\n -> Nombre de campo / propiedad [presione enter para finalizar]: ";
        $nombre_campo = strtolower(trim(fgets(STDIN)));

      } while($nombre_campo);

      if(count($campos) < 1) die("\n -> No se creó la entidad.\n\n");

      $sql = "CREATE TABLE $nombre (id int NOT NULL AUTO_INCREMENT, PRIMARY KEY (id)) DEFAULT CHARSET= " . $config['charset'];

      $conn->exec($sql);

      foreach ($campos as $campo)
      {
        $sql = "ALTER TABLE $nombre ADD "
                . $campo['campo'] . " "
                . $campo['tipo_dato'] . " "
                . $campo['nulo'] . " "
                . $campo['unico'];
        $conn->exec($sql);
      }

      $sql = "ALTER TABLE $nombre ADD is_active BIT NOT NULL";
      $conn->exec($sql);

      echo "\n\n *** TABLA CREADA CORRECTAMENTE ***\n\n";

      $info_entity = array();

      $info_entity = array(
        'nombre' => $nombre,
        'campos' => $campos
      );

      return $info_entity;
    }

    //Valida que los tipos de datos ingresados por el usuario
    //sean tipos de datos validos.
    public static function validarTipoDeDato($aux)
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

    //Asistente para crear el archivo /config/database.php
    public static function createConfig()
    {
      try
      {

        echo "Bienvenido al asistente para la configuración de orchestra:\n";
        echo "***********************************************************\n";

        do
        {

          //MOTOR DE BASE DE DATOS:
          echo "\n -> Motor [mysql]: ";

          $db_driver = strtolower(trim(fgets(STDIN)));

          if(!$db_driver)
          {
            $db_driver = "mysql";
          }

          //HOST DE BASE DE DATOS:
          echo "\n -> Host [localhost]: ";

          $db_host = strtolower(trim(fgets(STDIN)));

          if(!$db_host)
          {
            $db_host = "localhost";
          }

          //USUARIO DE BASE DE DATOS:
          echo "\n -> Usuario [root]: ";

          $db_user = strtolower(trim(fgets(STDIN)));

          if(!$db_user)
          {
            $db_user = "root";
          }

          //PASS DE BASE DE DATOS:
          echo "\n -> Password: ";

          $db_pass = strtolower(trim(fgets(STDIN)));

          //NOMBRE DE BASE DE DATOS:
          do
          {
            echo "\n -> Nombre de base de datos: ";

            $db_name = strtolower(trim(fgets(STDIN)));
          } while(!$db_name);

          //CHARSET:
          echo "\n -> Charset [utf8]: ";

          $db_charset = strtolower(trim(fgets(STDIN)));

          if(!$db_charset)
          {
            $db_charset = "utf8";
          }

          $db_charset = strtoupper($db_charset);

          //*******************************
          //******** VERIFICACION *********
          //*******************************

          echo "\n***********************************************************";
          echo "\n***********************************************************\n\n";

          echo "   DATOS:\n";
          echo "   ======\n\n";
          echo " * Driver -> " . $db_driver . "\n";
          echo " * Host -> " . $db_host . "\n";
          echo " * User -> " . $db_user . "\n";
          echo " * Pass -> " . $db_pass . "\n";
          echo " * Name -> " . $db_name . "\n";
          echo " * Charset -> " . $db_charset . "\n\n";

          echo " -> ¿Son correctos estos datos? si/no: ";
          $confirm = strtolower(trim(fgets(STDIN)));

        } while($confirm != 'si');

        echo "\n * Creando el fichero de configuración...\n\n";

        //CREACION DEL FICHERO CONFIG:
        $file = fopen('config/database.php', 'w')
                or die(" -> No se puede crear la entidad.\n\n");

        fwrite($file, "<?php\n");
        fwrite($file, "\treturn array(\n");
        fwrite($file, "\t\t\"driver\" => \"$db_driver\",\n");
        fwrite($file, "\t\t\"host\" => \"$db_host\",\n");
        fwrite($file, "\t\t\"user\" => \"$db_user\",\n");
        fwrite($file, "\t\t\"pass\" => \"$db_pass\",\n");
        fwrite($file, "\t\t\"database\" => \"$db_name\",\n");
        fwrite($file, "\t\t\"charset\" => \"$db_charset\"\n");
        fwrite($file, "\t);\n");
        fwrite($file, "?>\n");

        fclose($file);

        echo " * Fichero de configuración creado.\n";

        //SI EL DIRECTORIO /entities/ NO EXISTE, LO CREA.
        if(!file_exists('entities'))
        {
          echo "\n * Creando directorios...\n\n";

          $old_mask = umask(0);

          mkdir('entities', 0755);

          umask($old_mask);

          $old_mask = null;

          echo " * Directorio creado correctamente.\n";
        }

        \core\console\consoleFunctions::createDatabase();

        \core\console\consoleFunctions::checkConfig();

      } catch (Exception $e) {
        die("ERROR: " . $e->getMessage());
      }

    }

    //Crea la base de datos que esté seteada en la config
    //(/config/database.php)
    public static function createDatabase()
    {
      try
      {
        $db_config = include(__DIR__ . '/../../config/database.php');

        $conn = \core\connection::connectWithoutDb();

        //CONSULTAMOS SI EXISTE LA BASE DE DATOS
        $stmt = $conn->query("SHOW DATABASES LIKE '" . $db_config['database'] . "'");
        $databases = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        //SI NO EXISTE LA CREAMOS
        if($databases)
        {
          do
          {
            echo "\n * La base de datos ya existe.\n";
            echo " * ¿Desea eliminarla? si/no: ";
            $eliminar_db = strtolower(trim(fgets(STDIN)));
          } while($eliminar_db != 'si' && $eliminar_db != 'no');

          if($eliminar_db == 'si')
          {
            try {
              $conn->exec("DROP DATABASE " . $db_config['database']);
              echo "\n * Base de datos eliminada.\n";
            } catch (Exception $e) {
              "\n * Error: No se puedo eliminar la base de datos\n";
            }

          }
          else
          {
            return true;
          }
        }

        $conn->exec("CREATE DATABASE " . $db_config['database'])
          or die("Error creando la base de datos.\n");
        echo "\n * Base de datos creada correctamente.\n\n";

        $conn = null;
        $stmt = null;
      }
      catch (Exception $e)
      {
        die("ERROR: " . $e->getMessage());
      }

    }

    //Realiza un chequeo para ver si la configuración
    //permite conectarse a la base de datos.
    public static function checkConfig()
    {
      try
      {
        if(\core\connection::connect(0))
        {
          echo "\n * La configuración es correcta.\n\n";
        }
        else
        {
          echo "\n * La configuración es incorrecta.\n";
          echo " * Por favor, ejecute php core/console create:config \n\n";
        }

        $conn = null;

      }
      catch (Exception $e)
      {
        die("ERROR: " . $e->getMessage());
      }

    }

    //Imprime el menú de la consola en pantalla.
    public static function mostrarMenu()
    {
      echo "\n * Bienvenido a la consola interactiva:\n";
      echo "   ************************************\n\n";
      echo " * USO:\n";
      echo "   ****\n\n";
      echo " -> Crear nueva entidad:  \t\tphp core/console create:entity\n";
      echo " -> Crear nueva base de datos:  \tphp core/console create:database\n";
      echo " -> Crear nueva configuración:  \tphp core/console create:config\n";
      echo " -> Chequear configuración existente:  \tphp core/console check:config\n";

      echo "\n";
    }

    //Limpia la consola
    public static function clearConsole()
    {
      echo shell_exec('clear');
    }

    //Verificar si existe la tabla y el archivo de entidad.
    private static function verificarEntidad($nombre)
    {
      try
      {
        
      }
      catch (Exception $e)
      {


      }
    }
  }
?>
