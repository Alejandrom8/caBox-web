<?php

include_once("caja.php");

class Init extends Controller{

  public function __construct(){
    parent::__construct();
    $this->logErrors = "";
  }

  public function render(){
    $this->view->render("init");
  }

  public function pdf(){
    $this->view->render("pdf/index");
  }

  public function error($message){
      include_once "debug.php";
      $render = new Debug($message);
  }

  public function registrarCaja(){

    if(!empty($_POST)){

      $usuario = $_POST['owner'];
      $titulo  = $_POST['titulo'];
      $objetos = $_POST['obj'];
      $id_caja = constant("PREFIJOS_PERSONALES")[$usuario] . "_" . constant("PREFIJO") . "_" . rand(0,9) . rand(0,9) . rand(0,9);

      $box = new Caja();

      $box->owner   = constant("PREFIJOS_PERSONALES")[$usuario];
      $box->id      = $id_caja;
      $box->title   = $titulo;
      $box->content = $objetos;

      $res = $this->model->registrar($box);

        $estado = $res[0];
        $respuesta = $res[1];

      if($estado){
        header("Location:" . constant("URL") . "api/caja/" . $id_caja);
      }else{
        $this->error($respuesta);
      }
    }else{
      //si no se enviaron datos
      echo "No hay nada";
    }
  }

  public function search(){

    if($_GET["tipo"] == "t"){
      $user = "t";
    }else{
      $usuario = (int) $_GET["tipo"];
      $user = constant("PREFIJOS_PERSONALES")[$usuario];
    }

    $palabras = $_GET['busqueda'];

    $resultado = $this->model->consulta($user, $palabras);
    $res = new ServiceResult();

    if($resultado->success){
      $res->success = true;
      $res->data = $resultado->data;
    }else{
      switch($resultado->errors){
        case 0:
          //no se encontraron resultados
          $res->messages = "Se econtraron 0 coincidencias para esta busqueda";
          break;
        case 1:
          //hubo un error en la consulta
          $res->messages = $resultado->messages;
          break;
        default:
          break;
      }
    }

    echo json_encode($res);
  }

  public function countBoxes(){
    $user = $_POST['user'];
    $cajas = $this->model->countBoxes($user);
    $objetos = $this->model->countObjects($user);

    $totalCajas = $cajas->data;
    $totalObjetos = 0;

    if(count($objetos->data) > 0){
      foreach($objetos->data as $index => $value){
        $arr = explode(",",$value);
        $total = count($arr);
        $totalObjetos += $total;
      }
    }

    $res = new ServiceResult();
    $res->data = ["cajas" => $totalCajas, "objetos" => $totalObjetos];
    $res->success = ["cajas" => $cajas->success, "objetos" => $objetos->success];;
    $res->errors = ["cajas" => $cajas->errors, "objetos" => $objetos->errors];;
    echo json_encode($res);
  }

  public function getTitle($id){
    $title = $this->model->searchTitle($id);
    return $title;
  }

  public function reduce($text, $letters = 14){
    $test = str_split($text);
    $length = count($test);
    $i = 0;
    $newArr = [];
    while($i < $letters and isset($test[$i])){
      array_push($newArr, $test[$i]);
      $i++;
    }
    $newText = implode("", $newArr);
    if($length > $letters){
      $newText .= "...";
    }
    return $newText;
  }

  public function print($param){
    $cajas = $param[0];
    $cajas = explode(",", $cajas);
    $cajas = $cajas[0] != "" ? $cajas : null;
    $titles = [];
    foreach($cajas as $caja){
      $title = $this->getTitle($caja);
      $title = $this->reduce($title);
      array_push($titles, $title);
    }
    $this->view->cajas = ["id" => $cajas, "title" => $titles];
    $this->pdf();
  }
}

?>
