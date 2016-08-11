<?php

  function createEntity($nombre, $campos)
  {
      try
      {
          $file = fopen('entities/' . $nombre . "Entity.php", 'w') or die('No se puede crear la entidad.');
          fwrite($file, "<?php\n");
          fwrite($file, "ini_set('display_errors', 'On');\n");
          fwrite($file, "require_once('core/connection.php');\n");
          fwrite($file, "require_once('vendor/autoload.php');\n\n");
          fwrite($file, "//Las entidades deben extender la entidad base BaseEntity\n");
          fwrite($file, "//para así heredar sus métodos y atributos.\n");
          fwrite($file, "class $nombre" . "Entity\n");
          fwrite($file, "{\n");
          fwrite($file, "//--------------------------------PROPIEDADES----------------------------------//\n");

          foreach($campos as $campo)
          {
            fwrite($file, "\tprivate \$" . $campo['campo'] . ";\n");
          }

          fwrite($file, "//-------------------------------------------------------------------------------\n\n"
                        . "//-------------------------------CONSTRUCTORES-----------------------------------\n");

          fwrite($file, "\tpublic function __construct(\n");

          foreach($campos as $campo)
          {
            fwrite($file, "\t\t\$" . $campo['campo'] . " = null,\n");
          }

          fwrite($file, "\t\t)\n");
          fwrite($file, "\t{\n\n");

          fwrite($file, "\t\t\$this->setId(null);\n");

          foreach($campos as $campo)
          {
            fwrite($file, "\t\t\$this->set" . ucFirst($campo['campo']) .  "(\$" . $campo['campo'] . ");\n");
          }

          fwrite($file, "\t\t\$this->setIs_active(1);\n");
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
          fwrite($file, "\t\t\$this->is_value = \$value;\n");
          fwrite($file, "\t}\n\n");

          fwrite($file, "\t//-------------------------------------------------------------------------------\n\n");

          fwrite($file, "\t//---------------------------------METODOS---------------------------------------\n");

          fwrite($file, "\tprivate function validate()\n");
          fwrite($file, "\t{\n");

          $usar_and = false; // Variable booleana para armar las lineas siguientes
                            // Si es true entonces la linea lleva un && al principio.
          foreach($campos as $campo)
          {
            if(!$usar_and)
              {
                fwrite($file, "\t\tif (\n\t\t\tisset(\$this->" . $campo['campo'] . ")\n");
                $usar_and = true;
              }
            else
              fwrite($file, "\t\t\t&& isset(\$this->" . $campo['campo'] . ")\n");
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

          fwrite($file, "\t}\n");






          fwrite($file, "}\n");
          //fwrite($file, "\n");
          //fwrite($file, "\n");
          //fwrite($file, "\n");
          //fwrite($file, "\n");



          fclose($file);



      } catch (Exception $e) {

      }

  }

?>
