<?php
  namespace core;  

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
