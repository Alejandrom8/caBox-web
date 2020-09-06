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
                <h1><?= constant("APPNAME") ?></h1>
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
        <div id="admin" class="bloque" style="max-height:170vh;">
            <div class="row">
                <div class="col-md-4 row" id="adminOptions" style="max-height:170vh;">
                    <div class="col-md-12 window">
                        <div class="margin">
                            <form class="form" action="<?php echo constant("URL"); ?>init/search" method="GET" id="B">
                                <div class="form-group">
                                    <h4>Buscar</h4>
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
                                    <button type="submit" class="btn btn-primary btn-block" id="mostrar">Mostrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-12 window">
                        <div class="margin printOptions">
                                <h4><span class="glyphicon glyphicon-print"></span>Imprimir QR de:</h4>
                                <div class="boxButton amarillo" onclick="sendToPrintViewBoxes()">
                                    <p>Las cajas en pantalla</p>
                                </div>
                                <div class="boxButton morado btn-disabled" disabled="disabled" onclick="sendToPrintSelectedBoxes()">
                                    <p>Las cajas seleccionadas</p>
                                </div>
                                <p class="text-justify float-right" style="padding:4%;">
                                    Da click en alguna caja, aparecera un menú contextual con algunas opciones, da click en
                                    seleccionar para añadir la caja a la selección.
                                </p>
                        </div>
                    </div>
                    <div id="Seleccionado" class="row col-md-12"></div>
                </div>
                <div class="col-md-8" style="margin:0;padding:0;">
                    <div class="window col-md-12" style="width:96%;margin:2%;">
                        <div class="margin" style="margin:0;padding:0;">
                            <h4 class="float-left mx-sm-3 mb-2">Cajas</h4>
                            <img class="amarillo" style="width:45px;height:45px;float:left;"
                            src="<?php echo constant("URL");?>resources/img/caja.jpg">
                            <div class="table-responsive" id="displayResults"></div>
                            <input type="hidden" name="cajas" id="cajas">
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
    <script src="<?= constant("URL") ?>resources/js/init.js"></script>
    <script>
        let usuarios = ["JARU","MOM","YUNI","ALEX","DANI","MIGUE","LASKA"];
        const URL = "<?= constant("URL") ?>";
    </script>
    <script>

    const resultados = $("#displayResults");
    const arrayPrint = $("#cajas");//id de cajas que se van a imprimir

    const button = $("#ObjectAdded");
    const display = $("#boxContent");//display de la caja
    const arrayValue = $("#obj");//array escondido que contiene los objetos enlistados
    const entrada = $("#add");

    if (performance.navigation.type == 1) {
        arrayValue.val("");
        arrayPrint.val("");
    }

    const magicBox = new MagicBox(button, display, arrayValue, entrada);

    let totalCajas = 0, totalObjetos = 0;
    
    const addResultStatistic = async user => {
        await $.ajax({
            url: `${URL}init/countBoxes`,
            data: { user : user },
            type: "POST",
            dataType: "JSON",
            success: function (res){
                if(res.success.cajas && res.success.objetos){

                    totalCajas += res.data.cajas;
                    totalObjetos += res.data.objetos;

                    let tabla = `<tr>
                                    <td>${ user.toLowerCase() }</td>
                                    <td>${ res.data.cajas }</td>
                                    <td>${ res.data.objetos }</td>
                                </tr>`;

                    $("#Estadisticas").append(tabla);

                }else{
                    console.log(res.errors.cajas);
                    console.log(res.errors.objetos);
                }
            },
            error: function (){
                console.log("Error al cargar datos estadisticos");
            }
        });
    };

    const loadStatistics = async () => {
        for(let i = 0; i < usuarios.length; i++){
            await addResultStatistic(usuarios[i]);
        }  
    }

    $(document).ready(function(){
        loadStatistics().then( () =>{
            let tabla = `<tr class="bg-warning">
                        <td>total</td>
                        <td>${totalCajas}</td>
                        <td>${totalObjetos}</td>
                    </tr>`;

            $("#Estadisticas").append(tabla);
        });
    });

    const show = id => {
        $(".bloque").css("display", "none");
        $("#" + id).css("display", "block");
    };
    
    const nav = document.querySelectorAll(".nav-item");
    nav.forEach( item => {
        item.addEventListener("click", function(){
            show(this.dataset.show);
            $(".nav-link").removeClass("active");
            $(this).children().addClass("active");
        });
    });

    const removerBlur = () => {
        $(".windowFloatBlur").remove();
    };

    const addToSelection = (i, owner, title, id) => {
        if(!$("#Seleccionado").html()){
            $("#Seleccionado").append(`
                <div class="window col-md-12" id="selectWindow" style="max-height:70vh;">
                    <button id="deleatSelection" 
                    class="btn btn-danger btn-sm" 
                    onclick="$('#Seleccionado').empty();$('#selection').val('');"
                    style="margin:4px;">x</button>
                    <div class="margin" style="margin:0;padding:0;">
                        <h4>Cajas Seleccionadas</h4>
                        <div class="table-responsive displaySelection">
                            <table class="table table-bordered table-striped" id="displaySelection"></table>
                        </div>
                        <button class="btn btn-secondary" id="deleatALotOfBoxes">Borrar cajas</button>
                        <input type="hidden" name="selection" id="selection">
                    </div>
                </div>
            `);
            $("#selectWindow").focus();
        }
        $("#displaySelection").append(`
            <tr>
                <td>${i}.</td>
                <td>${owner}</td>
                <td>${title}</td>
            </tr>
        `);
        addNewItem(id, $("#selection"));
        removerBlur();
    };

    $("body").on("click", ".caja", function(){
        const data = this.dataset;
        let mouseX = event.clientX + document.body.scrollLeft;
        let mouseY = event.clientY + document.body.scrollTop;
        let x = mouseX, y = mouseY;

        if(mouseX + 200 > $(window).width()){
            x = mouseX - 200;
        }

        if(mouseY + 267 > $(window).height()){
            y = mouseY - 267;
        }
        
        $(".webpage").append(`
            <div class="windowFloatBlur">
                <div class="alertOptions window" id="alertOptions" style="top:${y}px;left:${x}px;border-radius:8px;overflow:hidden;">
                    <div class="margin" style="padding:0;margin:0;">
                        <div class="card">
                            <div class="card-header">
                                <ul class="list">
                                    <li class="list-item">Caja: ${data.title}</li>
                                    <li class="list-item">Dueño: ${data.owner}</li>
                                    <li class="list-item">id: ${data.id}</li>
                                </ul>
                            </div>
                            <div class="card-body btn-group-vertical">
                                <a class="btn btn-success btn-block" href="${"<?= constant("URL") ?>"}api/caja/${data.id}">Editar</a>
                                <button class="btn btn-info btn-block" onclick="addToSelection('${data.index}','${data.owner}','${data.title}','${data.id}');">Seleccionar</button>
                                <a class="btn btn-danger btn-block" 
                                href="${"<?= constant("URL") ?>"}api/delete/${data.id}"
                                onclick="return confirm('Seguro de que quieres eliminar esta caja? ');">
                                    Borrar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `);

        $("#deleatALotOfBoxes").on("click", function(){
            if(confirm("Esta seguro de que desea borrar todas estas cajas?")){
                window.location = `${URL}api/delete/` + $("#selection").val();
            }
        });

        $(document).mouseup(function(e) {
            let container = $(".alertOptions");
            // if the target of the click isn't the container or a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                removerBlur();
            }
        });

        $("#cancelar").on("click", function(){
            removerBlur();
        });

        return false;
    });

    const recortar = (txt, comp) => {
        let textoManejado = txt.reduce((acumulator, current, index) => {
            acumulator += index == 0 ? current : "," + current;
            return acumulator;
        });
        textoManejado += "...";
        return textoManejado;
    }

    $("#B").on("submit", function(e){
        e.preventDefault();
        $.ajax({
            url: $(this).attr("action"),
            type: "GET",
            data: $(this).serialize(),
            dataType: "JSON",
            beforeSend: function(){
                $("#mostrar").val("cargando...");
                $("#mostrar").attr("disabled", "disabled");
            },
            complete: function(){
                $("#mostrar").val("Mostrar");
                $("#mostrar").removeAttr("disabled");
            },
            success: function (data){
                console.log(data);
                resultados.empty();

                if(data.success){
                    let toPrint = `
                        <table class="table table-bordered table-hover table-lg">
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

                    let idTotales = "";

                    for(let i = 0; i < Object.keys(data.data).length; i++){

                        let textoManejado = data.data[i].content.split(',').slice(0,3);
                        textoManejado = recortar(textoManejado, this.texto);

                        idTotales += i == 0 ? data.data[i].id : "," + data.data[i].id;

                        toPrint += `
                            <tr class="caja" data-id="${data.data[i].id}" 
                            data-title="${data.data[i].title}" data-owner="${data.data[i].owner}"
                            data-index="${i+1}">
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

                    arrayPrint.val(idTotales);
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

    const sendToPrintViewBoxes = () =>{
        let allid = arrayPrint.val();
        if(allid != "" && allid != null){
                window.open(URL + "init/print/" + allid);
        }else{
            alert("No hay cajas en pantalla, realize una busqueda primero");
        }
    };

    const sendToPrintSelectedBoxes = () => {
        if($("#selection").length){
            let allid = $("#selection").val();
            if(allid != "" && allid != null){
                window.open(URL + "init/print/" + allid);
            }else{
                alert("No ha seleccionado ninguna caja aún");
            }
        }else{
            alert("No ha seleccionado ninguna caja aún");
        }
    };

    show("create");
    </script>
</body>
</html>