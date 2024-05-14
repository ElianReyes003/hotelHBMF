<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Registro de Área</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="sweetalert2.min.js"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">
    <link rel="icon" href="img/logo.png">
</head>
<body>
<?php include 'header.php'; ?>
<form action="funciones/registrar/registro_area.php" method="post" class="custom-form" onsubmit="return validarFormulario()">
    <h1>Registro de Área</h1>
    <label for="nombre_area">Nombre de la Área:</label>
    <input id="nombre_area" type="text" name="nombre_area">
    <input type="hidden" name="estatus" value="1">
    <input type="submit" value="Registrar Área">
</form>

<script>
    function validarFormulario() {
        // Validar campos de texto
        var nombre_area = document.getElementById("nombre_area").value;
        //Validacion
        if (
            nombre_area === ""
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
