<?php
  namespace controllers;

  class baseController
  {

    public function indexAction(array $par)
    {
      renderView("base/indexView.php", array(
        'nombre'    => $par[0],
        'apellido'  => $par[1]
      ));
    }

  }

?>
