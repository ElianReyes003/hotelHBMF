<?php

require_once('conexion/conexion.php');

$conexion = new Conexion();
$db = $conexion->conectar();

$query= $db -> prepare("SELECT nombre_area, pk_area FROM area;");
$query -> execute();
$resultado= $query -> fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Registro de Habitación</title>
    <link rel="icon" href="img/logo.png">
</head>
<body>
<?php include 'header.php'; ?>
<form action="funciones/registrar/registro_habitacion.php" method="post" class="custom-form" onsubmit="return validarFormulario();">
    <h1>Registro de habitación</h1>
    <label>Numero de la habitación:</label>
    <input type="number" id="numero" name="num_habitacion">
    <label>Area:</label>
    <select class="form-control" name="fk_area" id="fk_area">
    <option value="">Seleccione una opcion</option>
    <?php 
    foreach($resultado as $resultad => $value){
    ?>
    <option value="<?php echo $value['pk_area'];?>">
    <?php echo $value['nombre_area'];?>
    </option>
    <?php
    }
    ?>    
    </select>
    <input type="hidden" name="estatus" value="1">
    <input type="submit" value="Registrar Habitación">
</form>

<script>
     function validarFormulario() {
        // Validar campos de texto
        var numero = document.getElementById("numero").value;
        var area = document.getElementById("fk_area").value;
        //Validacion
        if (
           numero === "" || area === ""
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
