<?php
ini_set('display_errors', 'On');
require_once('baseEntity.php');

//Las entidades deben extender la entidad base BaseEntity
//para así heredar sus métodos y atributos.
class userEntity extends baseEntity
{

  public function __construct()
  {
    //Se debe llamar primeramente al constructor de la clase base
    parent::__construct();
    //Ahora configuramos el nombre de la tabla que se corresponde
    //con la entidad
    $this->table = chop(basename(__FILE__, '.php'), "Entity");
  }

}

?>
