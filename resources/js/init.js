const printTable = items => {
    display.empty();

    let cont = 1;

    items.forEach( item => {
        display.append(`
            <tr class="item" data-id="${cont}" data-item="${item}">
                <td>${cont}</td>
                <td>${item}</td>
            </tr>
        `);
        cont++;
    });
};

const borrarItem = id => {
    //items del input tipo hidden en forma de array
    const items = arrayValue.val().split(",");
    items.splice(id, 1);//borrando el elemento indicado
    console.log(items);
    if(items.length > 0){
        //si aun quedan elementos, se reconstruye la tabla con los elementos que quedan
        printTable(items);

        const newItems = items.reduce( (tapon,current,index) =>{
            return tapon += index == 0 ? current : separador + current;
        });
        //Se actualiza el valor del input hidden
        console.log(newItems);
        arrayValue.val(newItems);
    }else{
        display.empty();
    }
};

button.on("click", function (){

    const objeto = entrada.val();//valor del input donde se introducen objetos

    if(objeto != ""){

        let insert = arrayValue.val() == "" ? objeto : separador + objeto;
            insert = arrayValue.val() + insert;
        arrayValue.val(insert);

        let num_objetos = insert.split(separador).length;

        display.append(`
            <tr class="item" data-item="${objeto}" data-id="${num_objetos}">
                <td>${num_objetos}</td>
                <td>${objeto}</td>
            </tr>
        `);

        entrada.val("");
        entrada.focus();

    }else{
        //por si añade un campo vacio
        console.log("El campo esta vacio");
    }
});

display.on("click", ".item", function(){
    //item agrgado
    const text = this.dataset.item;

    let conf = confirm("Quieres borrar \"" + text + "\" de tu lista?");

    if(conf){
        const id = parseInt(this.dataset.id) -1;
        console.log(`Borrando ${id}`);
        borrarItem(id);
    }
});