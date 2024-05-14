<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Registro de Empleado</title>
    <link rel="icon" href="img/logo.png">
</head>
<body>
<?php include 'header.php'; ?>
<form action="funciones/registrar/registro_empleado.php" method="post" class="custom-form" onsubmit="return validarFormulario();">
    <h1>Registro de Empleado</h1>
    <label for="nombre_actividad">Nombre del empleado:</label>
    <input type="text" id="nombres" name="nombres">
    <label for="nombre_actividad">Apellido paterno del empleado:</label>
    <input type="text" id="apaterno" name="apaterno">
    <label for="nombre_actividad">Apellido materno del empleado:</label>
    <input type="text" id="amaterno" name="amaterno">
    <label for="nombre_actividad">Contacto del empleado:</label>
    <input type="text" id="contacto" name="contacto">
    <input type="hidden" name="estatus" value="1">
    <input type="submit" value="Registrar Empleado">
</form>

<script>
     function validarFormulario() {
        // Validar campos de texto
        var nombres = document.getElementById("nombres").value;
        var apaterno = document.getElementById("apaterno").value;
        var amaterno = document.getElementById("amaterno").value;
        var contacto = document.getElementById("contacto").value;
        //Validacion
        if (
            nombres === "" || apaterno === "" || amaterno === "" || contacto === ""
        ) {
            Swal.fire({
                position: 'top',
                text: 'Por favor, completa todos los campos.',
                timer: '3000'
            });
            return false;
        }
        return true;
    }
</script>
</body>
</html>
