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

  public function error($message){
    $this->logErrors = $message;
    $this->view->render("app/error");
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
    $usuario = $_GET['tipo'] == "t" ? "t" : constant("PREFIJOS_PERSONALES")[(int)$_GET["tipo"]];
    $palabras = $_GET['busqueda'];

    $resultado = $this->model->consulta($usuario, $palabras);
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
  
}

?>
