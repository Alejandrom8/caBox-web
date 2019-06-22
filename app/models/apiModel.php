<?php 

include_once("app/controllers/caja.php");

class apiModel extends Model{
    public function __construct(){
        parent::__construct();
        $this->con = $this->connection->connect();
    }

    public function getDataBox($id){
        try{
            $sql = "SELECT * FROM cajas WHERE caja = :id LIMIT 1";
            $e = $this->con->prepare($sql);
            $e->bindParam(":id", $id);
            $e->execute();

            if($e->rowCount() > 0){

                $data = $e->fetch(PDO::FETCH_ASSOC);

                $box = new Caja();
                $box->owner   = $data["usuario"];
                $box->id      = $data["caja"];
                $box->title   = $data["titulo"];
                $box->content = $data["objetos"];
                
                return [true, $box];
            }else{
                return [false, "No existe una caja con esta id"];
            }

        }catch(PDOException $e){
            return [false, $e];
        }
    }

    public function actualizar($box){
        try{
            $sql = "UPDATE cajas SET 
                        usuario = '$box->owner',
                        titulo = '$box->title',
                        objetos = '$box->content'
                    WHERE caja = '$box->id'
            ";
            $e = $this->con->prepare($sql);
            $e->execute();

            return [true, "Actualizado"];
        }catch(PDOException $e){
            return [false, $e];
        }
    }

    public function borrar($id){
        try{
            $sql = "DELETE FROM cajas WHERE caja = :id";
            $e = $this->con->prepare($sql);
            $e->bindParam(":id", $id);
            $e->execute();

            return [true, ""];
        }catch(PDOException $e){
            return [false, $e];
        }
    }
}

?>