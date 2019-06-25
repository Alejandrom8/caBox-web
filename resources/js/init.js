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
        arrayValue.val(newItems);
    }else{
        display.empty();
        arrayValue.val("");
    }
};

const addNewItem = (input,array,disp = null) => {
    /*
        @param input , texto de los objetos introducidos.
        @param array , id jquery del input hidden donde se almacenara la 
        lista a enviar de objetos en la caja.
        @param disp , id de la div donde se imprimiran los datos añadidos.
    */
    const objetos = input.split(separador);//valor del input donde se introducen objetos

    if(objetos.length > 0){

        for(let i = 0; i < objetos.length; i++){
            let insert = array.val() == "" ? objetos[i] : separador + objetos[i];
                insert = array.val() + insert;
            array.val(insert);

            if(disp != null){

                let num_objetos = insert.split(separador).length;
                
                disp.append(`
                    <tr class="item" data-item="${objetos[i]}" data-id="${num_objetos}">
                        <td>${num_objetos}</td>
                        <td>${objetos[i]}</td>
                    </tr>
                `);
            }
        }

    }else{
        //por si añade un campo vacio
        console.log("El campo esta vacio");
    }
};

button.on("click", function (){
    addNewItem(entrada.val(), arrayValue, display);
    entrada.val("");
    entrada.focus();
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