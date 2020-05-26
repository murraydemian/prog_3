///<reference path="node_modules/@types/jquery/index.d.ts"/>
function CerrarSesion() {
    document.cookie = 'usrkey="0"; Max-Age=2600000; Secure;';
    HideAll();
    $("#divLogin").attr("style", "display: block");
}
function VerificarSesion() {
    var data = { 'action': "check" };
    $.ajax({
        method: 'POST',
        url: 'TP/src/api.php',
        type: 'text',
        async: true,
        data: data
    }).done(function (response) {
        console.log(response);
        if (response == '0') {
            HideAll();
            alert("Sesion no iniciada.");
            $("#divLogin").attr("style", "display: block");
        }
        else {
            $("#divCerrar").attr("style", "display: block");
        }
    }).fail(function () {
        console.log(this.response);
    });
}
function Login() {
    var data = { 'action': 'login', 'data': { 'dni': $('#txtDniLogin').val(), 'apellido': $('#txtApellidoLogin').val() } };
    $.ajax({
        method: 'POST',
        url: 'TP/src/api.php',
        type: "text",
        async: true,
        data: data
    }).done(function (response) {
        var r = JSON.parse(response);
        console.log(response);
        if (r.key != "0") {
            //console.log(r);
            r.key != '0' ? document.cookie = 'usrkey="' + r.key + "; Max-Age=2600000; Secure;" :
                document.cookie = 'usrkey="0"; Max-Age=2600000; Secure;';
            HideAll();
            $('#divCerrar').attr("style", "display: block");
            $("#divEmpleado").attr("style", "display: block");
        }
        else {
            alert('Datos invalidos');
        }
    }).fail(function () {
        console.log(this.status);
    });
}
function Empleado_DivEmpleado() {
    HideAll();
    $('#frmEmpleado').trigger('reset');
    $('#divCerrar').attr("style", "display: block");
    $('#divEmpleado').attr("style", "display: block");
    $('#btnEnviar').attr('onclick', 'Empleado_Agregar()');
    $('#btnEnviar').val('Enviar');
    $('#tituloCarga').html('Cargar Empleado');
    $('#rdoMañana').attr('checked', '');
}
function Empleado_Eliminar(dni) {
    var ok = confirm('Esta seguro que desea eliminar el empleado?');
    if (ok) {
        var emp = '{"dni":"' + dni + '"}';
        var frmDta = PrepararFormData(emp, 'eliminar');
        $.ajax({
            dataType: 'json',
            url: 'TP/src/api.php',
            type: "POST",
            contentType: false,
            processData: false,
            async: true,
            data: frmDta
        }).done(function (response) {
            if (response.todoOk == '1') {
                alert(response.accion);
                Empleado_MostrarTodos();
            }
            else {
                alert(response.error);
            }
        }).fail(function () {
            console.log(this.status);
        });
    }
}
function Empleado_ModificarPage(dni) {
    var emp = '{"dni":"' + dni + '"}';
    var frmDta = PrepararFormData(emp, 'mostrar');
    $.ajax({
        dataType: 'json',
        url: 'TP/src/api.php',
        type: "POST",
        contentType: false,
        processData: false,
        async: true,
        data: frmDta
    }).done(function (response) {
        var emp = response.datos;
        Empleado_DivEmpleado();
        $('#txtDni').val(emp.dni);
        $('#txtDni').attr('readonly', '');
        $('#txtNombre').val(emp.nombre);
        $('#txtApellido').val(emp.apellido);
        $('#txtLegajo').val(emp.legajo);
        $('#txtLegajo').attr('readonly', '');
        $('#txtSueldo').val(emp.sueldo);
        $('#btnEnviar').val('Modificar');
        $('#btnEnviar').attr('onclick', 'Empleado_Modificar()');
        $('#tituloCarga').html('Modificar Empleado');
        $('#opt' + emp.sexo).attr('selected', '');
        $('#rdo' + emp.turno).attr('checked', '');
    }).fail(function () {
        console.log(this.status);
    });
}
function Empleado_Modificar() {
    VerificarSesion();
    var emp = Empleado_Crear_Json();
    var frmDta = new FormData();
    if ($('#imgEmp').val().toString() == '') {
        frmDta.append('action', 'modificarsfoto');
        frmDta.append('data', emp);
    }
    else {
        var foto = $('#imgEmp')[0];
        frmDta.append('action', 'modificarcfoto');
        frmDta.append('data', emp);
        frmDta.append('photo', foto.files[0]);
    }
    $.ajax({
        dataType: 'json',
        url: 'TP/src/api.php',
        type: "POST",
        contentType: false,
        processData: false,
        async: true,
        data: frmDta
    }).done(function (response) {
        if (response.todoOk == '1') {
            alert(response.accion);
            Empleado_DivEmpleado();
        }
        else {
            alert(response.error);
        }
    }).fail(function () {
        console.log(this.status);
    });
}
function Empleado_Mostrar(dni) {
    var emp = '{"dni":"' + dni + '"}';
    var frmDta = PrepararFormData(emp, 'mostrar');
    $.ajax({
        dataType: 'json',
        url: 'TP/src/api.php',
        type: "POST",
        contentType: false,
        processData: false,
        async: true,
        data: frmDta
    }).done(function (response) {
        var tabla = Tabla('{"datos":' + JSON.stringify(response.datos) + '}');
        $('#divListar').empty();
        document.getElementById('divListar').appendChild(tabla);
        HideAll();
        $('#divCerrar').attr("style", "display: block");
        $('#divListar').attr('style', 'display: block;');
    }).fail(function () {
        console.log(this.status);
    });
}
function Empleado_MostrarTodos() {
    var emp = '{"dni":"0"}';
    var frmDta = PrepararFormData(emp, 'mostrartodos');
    $.ajax({
        dataType: 'json',
        url: 'TP/src/api.php',
        type: "POST",
        contentType: false,
        processData: false,
        async: true,
        data: frmDta
    }).done(function (response) {
        var tabla = Tabla(JSON.stringify(response.datos));
        $('#divListar').empty();
        document.getElementById('divListar').appendChild(tabla);
        HideAll();
        $('#divCerrar').attr("style", "display: block");
        $('#divListar').attr('style', 'display: block;');
    }).fail(function () {
        console.log(this.status);
    });
}
function Empleado_Agregar() {
    VerificarSesion();
    if (Empleado_Verificar('')) {
        var emp = Empleado_Crear_Json();
        var frmDta = PrepararFormData(emp, 'append');
        $.ajax({
            dataType: 'json',
            url: 'TP/src/api.php',
            type: "POST",
            contentType: false,
            processData: false,
            async: true,
            data: frmDta
        }).done(function (response) {
            console.log(JSON.stringify(response));
            if (response.todoOk == "1") {
                Empleado_DivEmpleado();
            }
            else {
                alert(response.error);
            }
        }).fail(function () {
            console.log(this.status);
        });
    }
}
function GetCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
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
function Tabla(response) {
    var count = 0;
    var table = document.createElement('table');
    table.setAttribute('aling', 'center');
    table.setAttribute('style', 'border: 1px solid black;padding: 5px');
    var jsonArray = JSON.parse(response);
    Object.keys(jsonArray).forEach(function (campo) {
        var tr = Tabla_TableRow(jsonArray[campo]);
        if (count % 2 == 0) {
            tr.setAttribute('style', 'background-color:lightgray');
        }
        table.appendChild(tr);
        count++;
    });
    return table;
}
function Tabla_TableRow(objeto) {
    var tr = document.createElement('tr');
    Object.keys(objeto).forEach(function (keys) {
        var td = document.createElement('td');
        td.setAttribute('style', 'width: 100px;border: 1px solid black;padding= 3px');
        if (keys.toString() == 'pathFoto') {
            var img = document.createElement('img');
            img.setAttribute('src', './TP/fotos/' + objeto[keys] + '?' + new Date()); //cambiar path acorde al proyecto
            img.setAttribute('style', 'width:100px;height:100px');
            td.appendChild(img);
        }
        else {
            var text = document.createTextNode(objeto[keys]);
            td.appendChild(text);
        }
        //console.log(keys);
        tr.appendChild(td);
    });
    var btnMod = document.createElement('button');
    btnMod.setAttribute('onclick', "Empleado_ModificarPage('" + objeto.dni + "')"); //modificar llamado
    btnMod.appendChild(document.createTextNode('Modificar'));
    var btnElim = document.createElement('button');
    btnElim.setAttribute('onclick', "Empleado_Eliminar('" + objeto.dni + "')"); //modificar llamado
    btnElim.appendChild(document.createTextNode('Eliminar'));
    tr.appendChild(btnMod);
    tr.appendChild(btnElim);
    ///
    return tr;
}
function HideAll() {
    $("#divCerrar").attr("style", "display: none");
    $("#divLogin").attr("style", "display: none");
    $("#divEmpleado").attr("style", "display: none");
    $("#divListar").attr("style", "display: none");
}
function Empleado_Verificar(field) {
    var ok = false;
    //console.log(field);
    switch (field) {
        case 'dni':
            ok = Empleado_Verificar_Dni('txtDni', 55000000, 10000000, 'tgDni');
            break;
        case 'nombre':
            ok = Empleado_Verificar_Nombre('txtNombre', 'tgNombre');
            break;
        case 'apellido':
            ok = Empleado_Verificar_Nombre('txtApellido', 'tgApellido');
            break;
        case 'sexo':
            ok = Empleado_Verificar_Cbo('cboSexo', 'tgSexo');
            break;
        case 'legajo':
            ok = Empleado_Verificar_Dni('txtLegajo', 500, 100, 'tgLegajo');
            break;
        case 'sueldo':
            ok = Empleado_Verificar_Dni('txtSueldo', Empleado_SueldoMaximo(Empleado_TurnoSeleccionado()), 8000, 'tgSueldo');
            break;
        case 'foto':
            ok = Empleado_Verificar_Foto('imgEmp', 'tgFoto');
            break;
        default:
            ok = Empleado_Verificar_Dni('txtDni', 55000000, 10000000, 'tgDni') &&
                Empleado_Verificar_Nombre('txtNombre', 'tgNombre') &&
                Empleado_Verificar_Nombre('txtApellido', 'tgApellido') &&
                Empleado_Verificar_Cbo('cboSexo', 'tgSexo') &&
                Empleado_Verificar_Dni('txtLegajo', 500, 100, 'tgLegajo') &&
                Empleado_Verificar_Dni('txtSueldo', Empleado_SueldoMaximo(Empleado_TurnoSeleccionado()), 8000, 'tgSueldo') &&
                Empleado_Verificar_Foto('imgEmp', 'tgFoto');
    }
    return ok;
}
function Empleado_Verificar_Nombre(id, tg) {
    var value = $('#' + id).val().toString();
    var ok = value.length > 0 && !(value.match(/[^A-Za-z]+$/));
    BorderTg(id, tg, ok);
    return ok;
}
function Empleado_Verificar_Dni(id, max, min, tg) {
    var value = parseInt($('#' + id).val().toString());
    var ok = value <= max && value >= min;
    BorderTg(id, tg, ok);
    return ok;
}
function Empleado_Verificar_Cbo(id, tg) {
    var ok = $('#' + id).val().toString() != "---";
    BorderTg(id, tg, ok);
    return ok;
}
function Empleado_Verificar_Foto(id, tg) {
    var ok = $('#' + id).val().toString() != '';
    BorderTg(id, tg, ok);
    return ok;
}
function BorderTg(id, tg, ok) {
    if (ok) {
        $('#' + id).css({ "border": '' });
        $('#' + tg).attr('style', 'display:none');
    }
    else {
        $('#' + id).css({ "border": '#FF0000 2px inset' });
        $('#' + tg).attr('style', 'display:block');
    }
}
function Empleado_SueldoMaximo(turno) {
    var max = 0;
    if (turno == "Mañana") {
        max = 20000;
    }
    else if (turno == "Tarde") {
        max = 18500;
    }
    else if (turno == "Noche") {
        max = 25000;
    }
    return max;
}
function Empleado_TurnoSeleccionado() {
    var val = null;
    var lista = document.getElementsByName("rdoTurno");
    lista.forEach(function (element) {
        if (element.checked) {
            val = element.value;
        }
    });
    return val;
}
function Empleado_Crear_Json() {
    var str = '{' +
        '"dni":"' + $('#txtDni').val().toString() + '",' +
        '"nombre":"' + $('#txtNombre').val().toString() + '",' +
        '"apellido":"' + $('#txtApellido').val().toString() + '",' +
        '"sexo":"' + $('#cboSexo').val().toString() + '",' +
        '"legajo":"' + $('#txtLegajo').val().toString() + '",' +
        '"sueldo":"' + $('#txtSueldo').val().toString() + '",' +
        '"turno":"' + Empleado_TurnoSeleccionado() + '"' +
        '}';
    return str;
}
function PrepararFormData(objeto, action) {
    var frmDta = new FormData();
    var foto = $('#imgEmp')[0];
    frmDta.append('action', action);
    frmDta.append('data', objeto);
    frmDta.append('photo', foto.files[0]);
    return frmDta;
}
