<?php
class App {
  public function __construct(){
    $url = isset($_GET['url']) ? $_GET['url'] : null;
    $url = rtrim($url, "/");
    $url = explode("/", $url);

    $vista = $url[0];

    if(empty($vista)){
      require("app/controllers/init.php");
      $init = new Init();
      $init->loadModel("init");
      $init->render();
      return false;
    }else{
      $archivo = "app/controllers/" . $vista . ".php";
      if(file_exists($archivo)){
        require($archivo);
        $page = new $vista();
        $page->loadModel($vista);
        $parametros = sizeof($url);

        if($parametros > 1){
          if(method_exists($page, $url[1])){
            if($parametros > 2){
              $param = [];
              for($i = 2; $i < $parametros; $i++){
                array_push($param, $url[$i]);
              }
              $page->{$url[1]}($param);
            }else{
              $page->{$url[1]}();
            }
          }else{
            $page = new ManageError();
          }
        }else{
          $page->render();
        }
        
      }else{
        $page = new ManageError();
      }
    }
  }//fin del constructor
}
?>
