<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("app/views/head.php"); ?>
    <title>Caja</title>
    <link rel="stylesheet" type="text/css" href="<?php echo constant("URL"); ?>resources/css/registro.css">
    <style>
        @media print{
            .no-print{
                display:none !important;
            }
            #QR{
                width:500px;
                height:400px;
            }
        }
        #titulo{
            font-size:2rem;
            font-family:"OpenSans bold";
            text-align:center;
            border:0;
        }
        #tablaObjetos{
            max-height:68vh;
            overflow-y:scroll;
        }
        @media screen and (max-width: 800px){
            #caja_img{
                width:250px;
                height:250px;
            }
        }
        header{
            padding:3%;
            font-family:"OpenSans bold";
            font-size:3rem;
            color:#333;
            display:flex;
            align-content:center;
            justify-content:space-around;
        }
        header div h1{
            float:left;
            line-height:5rem;
        }
        header div img{
            width:100px;
            height:80px;
            float:left;
        }
    </style>
    <script>
        let items = '<?php echo $this->box->content; ?>';
    </script>
</head>
<body>
    <header class="col-md-12">
            <div>
                <h1>CucaBox</h1>
                <img src="<?php echo constant("URL"); ?>resources/img/logo.png">
            </div>
    </header>
    <div id="display">
        <?php 
            if(isset($this->box) and $this->box != ""){   
        ?>
            <div class="webpage row" style="padding-bottom:5%;">
                <div class="col-md-6 no-print">
                    <div class="window">
                        <div class="margin row">
                            <div class="col-lg-12">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <a class="page-link " href="<?php echo constant("URL"); ?>"> <- Home</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col">
                                <img id="caja_img" src="<?php echo constant("URL"); ?>resources/img/caja.jpg">
                            </div>
                            <div class="col">
                                <form action="<?php echo constant("URL"); ?>api/update" method="POST" id="update">
                                    <div class="form-group">
                                        <input type="text" name="titulo" id="titulo" 
                                        value="<?php echo $this->box->title; ?>" class="form-control"required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon3">Propietario: </span>
                                        </div>
                                        <input type="text" class="form-control" id="owner" name="owner"
                                        value="<?php echo $this->box->owner; ?>" placeholder="dueño" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon3">ID: </span>
                                        </div>
                                        <input type="text" class="form-control" id="id" name="id"
                                        value="<?php echo $this->box->id; ?>" placeholder="id de la caja" readonly="readonly">
                                    </div>
                                    <section class="form-group">
                                        <div id="addObjects" class="input-group mb-3">
                                            <input type="text" name="add" id="add" class="form-control" placeholder="Añadir objeto">
                                            <div class="input-group-append">
                                                <button type="button" id="ObjectAdded" class="btn btn-success" 
                                                style="font-weight:bold;font-family:'OpenSans bold';width:80px;">  +  </button>
                                            </div>
                                        </div>
                                    </section>
                                    <input type="hidden" name="obj" id="obj">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-warning btn-block">Actualizar</button>
                                        <button type="button" id="delete" class="btn btn-danger btn-block">Eliminar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 row">
                    <div class="col-md-12">
                        <div class="window">
                            <div class="margin">
                                <img id="QR" class="img-fluid float-left" alt="Codigo QR" src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=<?php echo constant("URL") . "api/caja/" . $this->box->id; ?>">
                                <p class="no-print">
                                    Este es el codigo qr de tu caja, imprimelo y pegalo en ella.
                                <p>
                                <div class="form-group">
                                    <label for="cuantosQR">¿Cuántos quieres imprimir?</label>
                                    <input type="number" id="cuantosQR" name="cuantosQR" class="form-control" 
                                    value="1" min="1" max="100" pattern="^[0-9]+">
                                </div>
                                <div class="form-group">
                                    <button id="imprimir" class="btn btn-info btn-block no-print"
                                    target="_blank" data-href="<?php echo constant("URL") . "init/print/"; ?>"
                                    data-id = "<?php echo $this->box->id; ?>">
                                        Imprimir
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 no-print">
                        <div class="window" id="tablaObjetos">
                            <div class="margin">
                                <section class="col-md-12">
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Objetos dentro de esta caja</th>
                                            </tr>
                                        </thead>
                                        <tbody id="display_objects">

                                        </tbody>
                                    </table>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <script src="<?php echo constant("URL");?>resources/js/init.js"></script>
    <script>
        const button = $("#ObjectAdded");
        const arrayValue = $("#obj");//array escondido que contiene los objetos enlistados
        const display = $("#display_objects");//display de la caja
        const entrada = $("#add");

        const magicBox = new MagicBox(button, display, arrayValue, entrada);

        magicBox.addNewItem(items);

        if (performance.navigation.type == 1) {
            arrayValue.val("");
            arrayValue.val(items);
        }else{
            arrayValue.val(items);
        }

        button.on("click", function (){ magicBox.click(); });

        display.on("click", ".item", function(){
            //posible error al tratar de usar this dentro de este contexto :'(
            const text = this.dataset.item;
            const conf = confirm("Quieres borrar \"" + text + "\" de tu lista?");

            if(conf){
                const id = parseInt(this.dataset.id) - 1;
                magicBox.deleteItem(id);//should be 'this' of the object MagicBox
            }
        });

        $("#delete").on("click", function(){
            if(confirm("Seguro de que quieres borrar esta caja?")){
                window.location = "<?php echo constant("URL") . "api/delete/" . $this->box->id; ?>";
            }
        });

        $("#imprimir").on("click", function(){
            let cuantos = $("#cuantosQR").val();
            if(cuantos > 0 && cuantos <= 100){
                const href = this.dataset.href;
                const id = this.dataset.id;
                let totalId = "";
                for(let i = 0; i < cuantos; i++){
                    totalId += i == 0 ? id : "," + id;
                }
                let where = href + totalId;
                window.open(where);
            }else{
                alert("Seleccione una cantidad valida (1-100)");
            }
        });
    </script>
        <?php 
            }
        ?>
    </div>
    <div id="mensajes" class="no-print">
        <?php echo $this->mensaje; ?>
    </div>
    <div id="errors" class="no-print">
        <?php echo $this->errors; ?>
    </div>
</body>
</html>