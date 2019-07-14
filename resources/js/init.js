
class MagicBox {

    /**
     * @param { jquery Object } button the button that will gonna trigger the add-object event.
     * @param { jquery Object } display the place where the objects-inside-box is going to be displayed.
     * @param { jquery Object } arrayValue the input-hidden that will gonna store the objects in string format.
     * @param { jquery Object } input where are the objects going to be taken.
     * @param { string } separator the separator of the object-list.
     */

    constructor (button, display, arrayValue, input, separator = ",") {

        this._button = button;
        this._display = display;
        this._arrayValue = arrayValue;
        this._input = input;
        this._separator = separator;

        //items del input tipo hidden en forma de array
        // this._items = (this._arrayValue.val()).split(this._separator);
    }

    /** @param { any } newButton */

    set button (newButton){
        this._button = newButton;
    }

    /** @param { any } newDisplay */

    set display (newDisplay){
        this._display = newDisplay;
    }

    /** @param { any } newArrayValue */

    set arrayValue (newArrayValue){
        this._arrayValue = newArrayValue;
    }

    /** @param { any } newInput */

    set input (newInput){
        this._input = newInput;
    }

    /** @param { any } newSeparator */

    set separator (newSeparator){
        this._separator = newSeparator;
    }

    get button () { return this._button; }

    get display () { return this._display; }

    get arrayValue () { return this._arrayValue; }

    get input () { return this._input; }

    get separator () { return this._separator; }

    // get items (){
    //     return this._items;
    // }

    printTable () {
        this._display.empty();

        let cont = 1;

        const items = (this.arrayValue.val()).split(this._separator);
        items.forEach( item => {
            this._display.append(`
                <tr class="item" data-id="${cont}" data-item="${item}">
                    <td>${cont}</td>
                    <td>${item}</td>
                </tr>
            `);
            cont++;
        });
    }

    deleteItem (id){
        let items = (this.arrayValue.val()).split(this._separator);
        items.splice(id, 1);//borrando el elemento indicado
        if(items.length > 0){
            //si aun quedan elementos, se reconstruye la tabla con los elementos que quedan
            const newItems = items.reduce( (tapon,current,index) =>{
                return tapon += index == 0 ? current : this._separator + current;
            });
            //Se actualiza el valor del input hidden
            this._arrayValue.val(newItems);

            this.printTable();
        }else{
            this._display.empty();
            this._arrayValue.val("");
        }
    }

    addNewItem (items = null){

        let objetos = items != null ? items.split(this._separator) : (this._input.val()).split(this._separator);//valor del input donde se introducen objetos

        if(objetos.length > 0 && (objetos[0] != "" || (objetos[1] && objetos[1] != ""))){

            for(let i = 0; i < objetos.length; i++){
                let insert = this._arrayValue.val() == "" ? objetos[i] : this._separator + objetos[i];
                    insert = this._arrayValue.val() + insert;
                
                this._arrayValue.val(insert);

                let fil = objetos[i].replace(/\(/gmi, '<mark class="subrrallar">');
                fil = fil.replace(/\)/gmi, '</mark>');

                if(this._display != null){

                    const num_objetos = insert.split(this._separator).length;
                    
                    this._display.append(`
                        <tr class="item" data-item="${objetos[i]}" data-id="${num_objetos}">
                            <td>${num_objetos}</td>
                            <td>${fil}</td>
                        </tr>
                    `);
                }
            }
        }else{
            //por si añade un campo vacio
            console.log("El campo esta vacio");
        }
    }

    click(){
        if( this._input.val() != null && this._input.val() != ""){
            this.addNewItem( this._input.val() );
            this._input.val("");
            this._input.focus();
        }
    }
}