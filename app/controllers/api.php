<?php 

include_once("caja.php");

class Api extends Controller{

    public function __construct(){
        parent::__construct();
        $this->view->id = "";
        $this->view->errors = "";
        $this->view->mensaje = "";
        $this->view->box = "";
    }

    public function render(){
        $this->view->render("api/index");
    }

    public function caja($param){
        // @param $id identificador de la caja
        $id = $param[0];
        $exists = $this->model->getDataBox($id);

            $estado = $exists[0];
            $respuesta = $exists[1];

        if($estado){
            //ya revisado que exista la caja
            $this->view->box = $respuesta;

        }else{
            $this->view->errors = $respuesta;
        }

        $this->render();
    }
    
    public function update(){
        if(!empty($_POST)){
            $user = $_POST['owner'];
            $id = $_POST['id'];
            $title = $_POST['titulo'];
            $objetos = $_POST['obj'];

            $box = new Caja();
            $box->owner = $user;
            $box->id = $id;
            $box->title = $title;
            $box->content = $objetos;

            $update = $this->model->actualizar($box);
                $estado = $update[0];
                $respuesta = $update[1];

            if(!$estado){
                $this->view->errors = $respuesta;   
            }

            header("Location: " . constant("URL") . "api/caja/" . $box->id);
        }
    }

    public function delete($param){
        $id = $param[0];
        $res = $this->model->borrar($id);
        if($res[0]){
            header("Location: " . constant("URL"));
        }else{
            $this->view->errors = $res[1];
            header("Location: " . constant("URL") . "api/caja/" . $box->id);
        }
    }
}

?>