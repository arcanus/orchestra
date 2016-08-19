<?php
  namespace core;
  /*
  Toda entidad que se cree, ya sea con la consola interactiva o manualmente debe implementar esta interface para así mantener un funcionamiento homogeneo de las clases y del framework en si.
  */
  interface iEntity
  {

    public function getId();

    public function setId($value);

    public function getIs_active();

    public function setIs_active($value);

    public function insert();

    public function delete();

    public static function getTableName();

    public static function getAll();

    public static function getById($id);

    public static function deleteById($id);

  }

?>
