<?php
  namespace controllers;

  class baseController
  {

    public function indexAction()
    {
      header("HTTP/1.0 404 Not Found");
    }

  }

?>
