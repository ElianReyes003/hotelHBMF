<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Registro de Actividad</title>
    <link rel="icon" href="img/logo.png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
<?php include 'header.php'; ?>
<form action="funciones/registrar/registro_actividad.php" method="post" class="custom-form" onsubmit="return validarFormulario();">
    <h1>Registro de Actividad</h1>
    <label for="nombre_actividad">Nombre de la Actividad:</label>
    <input id="nombre_actividad" type="text" name="nombre_actividad">
    <input type="hidden" name="estatus" value="1">
    <div class="cont_submit">
        <input type="submit" value="Registrar Actividad">
    </div>
</form>

<script>
 function validarFormulario() {
        // Validar campos de texto
        var nombre_actividad = document.getElementById("nombre_actividad").value;
        //Validacion
        if (
            nombre_actividad === ""
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

