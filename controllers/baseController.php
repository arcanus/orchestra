<?php
  namespace controllers;

  class baseController
  {

    public function indexAction()
    {
        renderView('indexView.html.twig');
    }

  }

?>
