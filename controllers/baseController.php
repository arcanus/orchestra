<?php
  namespace controllers;

  class baseController
  {

    public function indexAction($par = null)
    {      
      renderView("base/indexView.php", array('nombre' => $par[0]));
    }

  }

?>
