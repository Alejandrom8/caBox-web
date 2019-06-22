<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("app/views/head.php"); ?>
    <title>Mudanza</title>
    <link rel="stylesheet" type="text/css" href="<?php echo constant("URL");?>resources/css/registro.css">
</head>
<body>
    <div class="webpage row" style="padding-bottom:5%;">
        <header class="col-md-12">
            <div>
                <h1>CucaBox</h1>
                <img src="<?php echo constant("URL"); ?>resources/img/logo.png">
            </div>
        </header>
        <div class="col-lg-12">
            <ul class="nav justify-content-center nav-tabs" style="color:#3f7bff;cursor:pointer;">
                <li class="nav-item" data-show="create">
                    <a class="nav-link active" >Crear</a>
                </li>
                <li class="nav-item" data-show="admin">
                    <a class="nav-link" >Administrar</a>
                </li>
                <li class="nav-item" data-show="statistics">
                    <a class="nav-link" >Estadisticas</a>
                </li>
            </ul>
        </div>
        <div id="create" class="col-lg-12 row bloque">
            <div class="col-md-6 " style="float:left;">
                <div class="window">
                    <div class="margin">
                        <form role="form" action="<?php echo constant("URL"); ?>init/registrarCaja" method="POST" id="registro">
                            <div class="form-group">
                                <label for="titulo">Titulo de la caja </label>
                                <input type="text" name="titulo" id="titulo" class="form-control"
                                placeholder="ejem: cocina, baño, sala, etc..." aria-label="titulo" required>
                            </div>
                            <div class="form-group">
                                <label for="owner">Dueño de la caja</label>
                                <select type="text" name="owner" id="owner" class="form-control"
                                placeholder="Dueño" aria-label="Dueño de la caja" required>
                                        <option value="">Seleccionar</option>
                                        <option value="0">Jaru</option>
                                        <option value="1">Mom</option>
                                        <option value="2">Yuni</option>
                                        <option value="3">Alex</option>
                                        <option value="4">Dani</option>
                                        <option value="5">Migue</option>
                                        <option value="6">Laska</option>
                                </select>
                            </div>
                            <section class="form-group">
                                <label for="add">Añade el contenido de la caja</label>
                                <div id="addObjects" class="input-group mb-3">
                                    <input type="text" name="add" id="add" class="form-control" placeholder="Escribe un objeto y añadelo">
                                    <div class="input-group-append">
                                        <button type="button" id="ObjectAdded" class="btn btn-success" style="font-weight:bold;font-family:'OpenSans bold';width:80px;">  +  </button>
                                    </div>
                                </div>
                            </section>
                            <br><br>
                            <div class="form-group">
                                <input type="hidden" name="obj" id="obj">
                                <button type="submit" name="registrar" id="registrar" class="btn btn-primary btn-block">Registrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6" style="float:left;">
                <div class="window">
                    <div class="margin">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-dark">
                                <th>#</th>
                                <th>Objetos añadidos</th>
                            </thead>
                            <tbody id="boxContent">                         
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- fin de create section -->
        <div id="admin" class="bloque">
            <div class="row">
                <div class="col-md-4 row">
                    <div class="col-md-12 window">
                        <div class="margin">
                            <form class="form" action="<?php echo constant("URL"); ?>init/search" method="GET" id="B">
                                <div class="form-group">
                                    <label for="tipo">mostrar cajas de: </label>
                                    <select class="form-control" id="tipo" name="tipo" required>
                                        <option value="">Seleccionar</option>
                                        <option value="t">Todos</option>
                                        <?php 
                                            foreach(constant("PREFIJOS_PERSONALES") as $i => $val){
                                                echo "<option value='$i'>" . strtolower($val) . "</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="busqueda">Buscar</label>
                                    <input type="text" class="form-control" id="busqueda" name="busqueda"
                                    placeholder="Escribe un titulo, nombre de usuario o contenido de la caja">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">Mostrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-12 window">
                        <div class="margin">
                            Print QR by box-group option
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="window">
                        <div class="margin">
                            <div class="table-responsive" id="displayResults"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="statistics" class="bloque">
             <div class="window">
                <div class="margin">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="3">Datos Generales</th>
                            </tr>
                        </thead>
                        <thead>
                            <tr>
                                <th>usuario</th>
                                <th>cajas</th>
                                <th>objetos</th>
                            </tr>
                        </thead>
                        <tbody id="Estadisticas">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        let usuarios = ["JARU","MOM","YUNI","ALEX","DANI","MIGUE","LASKA"];
        let URL = "http://192.168.1.71/mudanza/";
    </script>
    <script>
        const button = $("#ObjectAdded");
        const arrayValue = $("#obj");//array escondido que contiene los objetos enlistados
        const display = $("#boxContent");//display de la caja
        const separador = ",";
        const entrada = $("#add");

        $(document).ready(function(){
            let totalCajas = 0, totalObjetos = 0;
            for(let i = 0; i < usuarios.length; i++){
                $.ajax({
                    url: `${URL}init/countBoxes`,
                    data: {user: usuarios[i]},
                    type: "POST",
                    dataType: "JSON",
                    success: function (res){
                        if(res.success.cajas && res.success.objetos){
                            let tabla = `<tr>
                                        <td>${usuarios[i].toLowerCase()}</td>
                                        <td>${res.data.cajas}</td>
                                        <td>${res.data.objetos}</td>
                                    </tr>`;

                            $("#Estadisticas").append(tabla);
                            totalCajas += parseInt(res.data.cajas);
                            totalObjetos += parseInt(res.data.objetos);

                            if(i == usuarios.length - 1){
                                let tabla = `<tr>
                                        <td>total</td>
                                        <td>${totalCajas}</td>
                                        <td>${totalObjetos}</td>
                                    </tr>`;

                                $("#Estadisticas").append(tabla);
                            }

                        }else{
                            console.log(res.errors.cajas);
                            console.log(res.errors.objetos);
                        }
                    },
                    error: function (){
                        console.log("Error al cargar datos estadisticos");
                    }
                });
            }  
        });

        if (performance.navigation.type == 1) {
            arrayValue.val("");
        }

        const show = id => {
            $(".bloque").css("display", "none");
            $("#" + id).css("display", "block");
        };
        
        const nav = document.querySelectorAll(".nav-item");
        nav.forEach( item => {
            item.addEventListener("click", function(){
                const id = this.dataset.show;
                show(id);
                $(".nav-link").removeClass("active");
                $(this).children().addClass("active");
            });
        });


        $("body").on("click", ".caja", function(){
            $("body").css("overflow", "hidden");
            $(".webpage").append(`
                <div class="windowFloatBlur">
                    <div class="alertOptions window">
                        <div class="margin">
                            <div class="col">
                                <ul class="list-group">
                                    <li class="list-group-item">Caja: ${this.dataset.title}</li>
                                    <li class="list-group-item">Dueño: ${this.dataset.owner}</li>
                                    <li class="list-group-item">id: ${this.dataset.id}</li>
                                </ul>
                            </div>
                            <div class="col btn-group">
                                <a class="btn btn-info" href="${"<?php echo constant("URL"); ?>"}api/caja/${this.dataset.id}">Ver</a>
                                <a class="btn btn-danger" 
                                href="${"<?php echo constant("URL"); ?>"}api/delete/${this.dataset.id}"
                                onclick="return confirm('Seguro de que quieres eliminar esta caja? ');">
                                    Borrar
                                </a>
                                <button class="btn btn-warning" id="cancelar">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            `);

            const removerBlur = () => {
                $(".windowFloatBlur").remove();
                $("body").css("overflow", "auto");
            };

            $(document).mouseup(function(e) {
                let container = $(".alertOptions");
                // if the target of the click isn't the container nor a descendant of the container
                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    removerBlur();
                }
            });

            $("#cancelar").on("click", function(){
                removerBlur();
            });
        });

        show("create");

        const recortar = (txt, comp) => {

                let textoManejado = txt.reduce((acumulator, current, index) => {
                    acumulator += index == 0 ? current : "," + current;
                    return acumulator;
                });
                textoManejado += "...";
                return textoManejado;
        }

        const resultados = $("#displayResults");

        $("#B").on("submit", function(e){
            e.preventDefault();
            $.ajax({
                url: $(this).attr("action"),
                type: "GET",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function (data){
                    console.log(data);
                    resultados.empty();

                    if(data.success){
                        let toPrint = `
                            <table class="table table-bordered table-hover table-sm">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Propietario</th>
                                        <th>Caja</th>
                                        <th>Objetos</th>
                                    </tr>
                                </thead>
                                <tbody>
                        `;

                        for(let i = 0; i < Object.keys(data.data).length; i++){

                            let textoManejado = data.data[i].content.split(',').slice(0,3);
                            textoManejado = recortar(textoManejado, this.texto);

                            toPrint += `
                                <tr class="caja" data-id="${data.data[i].id}" 
                                data-title="${data.data[i].title}" data-owner="${data.data[i].owner}">
                                    <td>${i+1}.</td>
                                    <td>${data.data[i].owner}</td>
                                    <td>${data.data[i].title}</td>
                                    <td title="${data.data[i].content}">${textoManejado}</td>
                                </tr>
                            `;
                        }

                        toPrint += `
                                </tbody>
                            </table>
                        `;

                        resultados.append(toPrint);

                    }else{
                        resultados.append(`<p>${data.messages}</p>`);
                    }
                },
                error: function (){
                    console.log("error al cargar los resultados de la busqueda");
                }
            });
            return false;
        });

    </script>
    <script src="<?php echo constant("URL");?>resources/js/init.js"></script>
</body>
</html>