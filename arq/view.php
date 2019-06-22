<?php

class View {
  public function render($element){
    require_once "app/views/" . $element . ".php";
  }
}

?>
