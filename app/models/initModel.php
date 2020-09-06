<?php 

include_once("../controllers/caja.php");

class initModel extends Model{

    public function __construct(){
        parent::__construct();
        $this->con = $this->connection->connect();
    }

    public function registrar($box){
        try{
            $sql = "INSERT INTO cajas(id, usuario, caja, titulo, objetos)
                    VALUE (
                        0,
                        '$box->owner',
                        '$box->id',
                        '$box->title',
                        '$box->content'
                    )";

            $e = $this->con->prepare($sql);
            $e->execute();

            return [true, ""];
        }catch(PDOException $e){
            return [false, $e];
        }
    }

    public function consulta($usuario, $palabras){

        $res = new ServiceResult();
        
        try{

            $sql = "SELECT * FROM cajas";

            if($usuario != "t"){
                $sql .= " WHERE usuario = '$usuario'";
            }

            if($palabras != ""){
                if($usuario != "t"){
                    $sql .= " AND";
                }else{
                    $sql .= " WHERE";
                }

                $sql .= " caja LIKE '%$palabras%' OR titulo LIKE '%$palabras%' OR objetos LIKE '%$palabras%'";
            }

            $sql .= " ORDER BY usuario ASC";

            $e = $this->con->prepare($sql);
            $e->execute();

            if($e->rowCount() > 0){
                $cajas = [];
                while($row = $e->fetch(PDO::FETCH_ASSOC)){
                    $box = new Caja();
                    $box->id = $row["caja"];
                    $box->owner = $row["usuario"];
                    $box->title = $row["titulo"];
                    $box->content = $row["objetos"];
                    array_push($cajas, $box);
                }
                $res->data = $cajas;
                $res->success = true;
            }else{
                $res->errors = 0;
                $res->messages = "No hay coincidencias";
            }

        }catch(PDOException $e){
            $res->errors = 1;
            $res->messages = $e;
        }finally{
            return $res;
        }
    }

    public function countBoxes($user){
        $res = new ServiceResult();
        try{
            $sql = "SELECT count(*) AS columns FROM cajas WHERE usuario = :name";
            $e = $this->con->prepare($sql);
            $e->bindParam(":name", $user);
            $e->execute();

            $data = $e->fetch(PDO::FETCH_ASSOC);
            $res->data = $data["columns"];
            $res->success = true;
        }catch(PDOException $e){
            $res->errors = $e;
        }finally{
            return $res;
        }
    }

    public function countObjects($user){
        $res = new ServiceResult();
        try{
            $sql = "SELECT objetos FROM cajas WHERE usuario = :name";
            $e = $this->con->prepare($sql);
            $e->bindParam(":name", $user);
            $e->execute();

            $objetos = [];
            while($row = $e->fetch(PDO::FETCH_ASSOC)){
                array_push($objetos, $row["objetos"]);
            }
            $res->data = $objetos;
            $res->success = true;

        }catch(PDOException $e){
            $res->errors = $e;
        }finally{
            return $res;
        }
    }

    public function searchTitle($id){
        try{
            $sql = "SELECT titulo FROM cajas WHERE caja = :id LIMIT 1";
            $e = $this->con->prepare($sql);
            $e->bindParam(":id", $id);
            $e->execute();
            $data = $e->fetch(PDO::FETCH_ASSOC);
            return $data["titulo"];
        }catch(PDOException $e){
            return null;
        }
    }
}

?>