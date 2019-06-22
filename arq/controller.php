<?php

class Controller {
  public function __construct(){
    $this->view = new View();
  }

  public function loadModel($model){
      $modelName = $model  . "Model";
      $url = 'app/models/' . $modelName . ".php";
      if(file_exists($url)){
        require $url;
        $this->model = new $modelName();
      }
  }
}

?>
