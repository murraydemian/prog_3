///<reference path="node_modules/@types/jquery/index.d.ts"/>
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
        if (response != "0") {
            document.cookie = 'usrkey=' + response + "; Max-Age=2600000; Secure";
            HideAll();
            $("#divEmpleado").attr("style", "display: block");
        }
        else {
            alert("Datos invalidos");
        }
    }).fail(function () {
        console.log(this.status);
    });
}
function Empleado_Agregar() {
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
        }).fail(function () {
            console.log(this.status);
        });
    }
}
function Listar_TableRow(o) {
    var tr = document.createElement('tr');
    Object.keys(o).forEach(function (key) {
        var td = document.createElement('td');
        td.appendChild(o[key].toString());
        tr.appendChild(td);
    });
    return tr;
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
function HideAll() {
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
