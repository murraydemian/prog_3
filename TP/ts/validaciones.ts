/**ValidarCamposVacios(string): boolean. Recibe como parámetro el valor del atributo
id del campo a ser validado. Retorna true si no está vacío o false caso contrario. */
function ValidarCamposVacios(idCampo : string) : boolean{
    let completo : boolean = false;
    let value : string =  (<HTMLInputElement>document.getElementById(idCampo)).value;
    if(value != null && value != "" && value != "---"){
        completo = true;
    }
    return completo;
}

/**ValidarRangoNumerico(number, number, number): boolean. Recibe como
parámetro el valor a ser validado y los valores mínimos y máximos del rango.
Retorna true si el valor pertenece al rango o false caso contrario. */
function ValidarRangoNumerico(val : number, min : number, max : number) : boolean{
    let isValid : boolean = true;
    if(val <= max && val >= min){
        isValid = true;
    }
    return isValid;
}

/**ValidarCombo(string, string): boolean. Recibe como parámetro el valor del atributo
id del combo a ser validado y el valor que no debe de tener. Retorna true si no
coincide o false caso contrario. */
function ValidarCombo(idCampo : string, target : string) : boolean{
    let value : string =  (<HTMLInputElement>document.getElementById(idCampo)).value;
    if(value != null){
        if(value == target){
            return true;
        }
        return false;
    }
}

/**ObtenerTurnoSeleccionado(): string. Retorna el valor del elemento (type=radio)
seleccionado por el usuario. Verificar atributo checked. */
function ObtenerTurnoSeleccionado() : string{
    let val : string = null;
    let lista : NodeList = <NodeList> document.getElementsByName("rdoTurno");
    lista.forEach(element => {
        if((<HTMLInputElement>element).checked){
            val = (<HTMLInputElement>element).value;                      
        }
    });
    return val;
}

/**ObtenerSueldoMaximo(string): number. Recibe como parámetro el valor del turno
elegido y retornará el valor del sueldo máximo. */
function ObtenerSueldoMaximo(turno : string) : number{
    let max : number = 0;
    if(turno == "Mañana"){
        max = 20000;
    }
    else if(turno == "Tarde"){
        max = 18500;
    }
    else if(turno == "Noche"){
        max = 25000;
    }
    return max;
}

/**La función se llamará AdministrarValidaciones y será la encargada de invocar a otras funciones que
 * Campos no vacios
 * Rangos numericos correctos
 * Seleccin de sexo
 * Verificacion del turono y sueldo maximo
*/
function AdministrarValidaciones(): void{
    AdministrarSpanError("tgDni", ValidarCamposVacios("txtDni") &&
                        ValidarRangoNumerico(parseInt((<HTMLInputElement>document.getElementById("txtDni")).value),
                        1000000, 55000000));
    AdministrarSpanError("tgApellido", ValidarCamposVacios("txtApellido"));
    AdministrarSpanError("tgNombre", ValidarCamposVacios("txtNombre"));
    AdministrarSpanError("tgSexo", !ValidarCombo("cboSexo", "---"));
    AdministrarSpanError("tgLegajo", ValidarCamposVacios("txtLegajo"));
    AdministrarSpanError("tgSueldo", (ValidarCamposVacios("txtSueldo") && ValidarRangoNumerico(
                        parseInt((<HTMLInputElement>document.getElementById("txtSueldo")).value),
                        8000, ObtenerSueldoMaximo(ObtenerTurnoSeleccionado()))));
    AdministrarSpanError("tgFoto", ValidarCamposVacios("imgEmp"));
    if(VerificarValidacionesLogin()){
        (<HTMLFormElement>document.getElementById("frmEmpleado")).submit();
    }
}

function AdministrarValidacionesLogin(){
    
    AdministrarSpanError("txtDni", ValidarCamposVacios("txtDni"));
    AdministrarSpanError("txtApellido", ValidarCamposVacios("txtApellido"));
    if(VerificarValidacionesLogin()){
        (<HTMLFormElement>document.getElementById("frmLogin")).submit();
    }
}
/**Oculta o muetra una etiqueta tipo <span> segun se le ordene */
function AdministrarSpanError(idCampo : string, ocultar : boolean) : void{
    if(!ocultar){        
        document.getElementById(idCampo).style.display = "block";
    }
    else{
        document.getElementById(idCampo).style.display = "none";
    }
}
/**Verifica los campos del login y se encarga de llamar a la funcion que oculta/muestra las
 * etiquetas tipo <span>
 */
function VerificarValidacionesLogin() : boolean{
    let ok : boolean = true;
    let spans : HTMLCollectionOf<HTMLSpanElement> = <HTMLCollectionOf<HTMLSpanElement>>document.getElementsByTagName("span");
    for(let i = 0; i < spans.length; i++){
        if(spans[i].style.display == "block"){
            ok = false;
            break;
        }
    }
    return ok;
}
function AdministrarModificar(dni : string) : void{
    if(dni != null){
        (<HTMLInputElement>document.getElementById("hidDNI")).value = dni;
        (<HTMLFormElement>document.getElementById("frmModificar")).submit();
        console.log(dni);
    }else{
        console.log("DNI invalido");
    }
}