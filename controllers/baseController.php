<?php
  namespace controllers;

  class baseController
  {

    public function indexAction($par = null)
    {
        renderView('indexView.html.twig', array('nombre' => 'Paul'));
    }

  }

?>
