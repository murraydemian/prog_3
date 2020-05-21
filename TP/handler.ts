///<reference path="node_modules/@types/jquery/index.d.ts"/>

function VerificarSesion(){
    let data = {'action' : "check"}
    $.ajax({
        method: 'POST',
        url: 'TP/src/api.php',
        type: 'text',
        async: true,
        data: data
    }).done(function (response){
        console.log(response);
        if(response == '0'){
            HideAll();
            alert("Sesion no iniciada.");
            $("#divLogin").attr("style", "display: block");
        }
    }).fail(function(){
        console.log(this.response);
    })
}
function Login() : void{
    let data = { 'action': 'login', 'data' : {'dni': $('#txtDniLogin').val(), 'apellido': $('#txtApellidoLogin').val()}};
    $.ajax({
        method: 'POST',
        url: 'TP/src/api.php',
        type: "text",
        async: true,
        data: data
    }).done(function (response){
        if(response != "0"){
            document.cookie = 'usrkey=' + response +"; Max-Age=2600000; Secure"
            HideAll();
            $("#divEmpleado").attr("style", "display: block");
        }else{
            alert("Datos invalidos");
        }
    }).fail(function (){
        console.log(this.status);
    })
}
function Empleado_Agregar(){

}
function Listar_TableRow(o : object) : HTMLTableRowElement{
    let tr = document.createElement('tr');
    Object.keys(o).forEach(key =>{
        let td = document.createElement('td');
        td.appendChild(o[key].toString());
        tr.appendChild(td);
    });
    return tr;
}
function GetCookie(cname){
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return null;
}
function HideAll(){
    $("#divLogin").attr("style", "display: none");
    $("#divEmpleado").attr("style", "display: none");
    $("#divListar").attr("style", "display: none");
}
function Empleado_Verificar(){
    Empleado_Verificar_Dni();
    Empleado_Verificar_Nombre('txtNombre');
    Empleado_Verificar_Nombre('txtApellido');
}
function Empleado_Verificar_Nombre(id : string) : void{
    let value : string = $('#' + id).val().toString();
    value.length > 0 && !(value.match(/[^A-Za-z]+$/)) ?
        $('#' + id).attr('style', '') :
        $('#' + id).attr('style', 'border-color:red');
}
function Empleado_Verificar_Dni(){
    let value;
    let foo;
    isNaN(foo = parseInt($('#txtDni').val().toString())) ? value = null: value = foo;
    if(value != null){
        value >= 10000000 && value <= 55000000 ? 
            $('#txtDni').attr('style', '') :
            $('#txtDni').attr('style', 'border-color:red');
    }
}
function Empleado_Verificar_Cbo(){
    $('#cboSexo').val().toString() != "---" ?
        $('#cboSexo').attr('style', '') : 
        $('#cboSexo').attr('style', 'border-color:red');
}