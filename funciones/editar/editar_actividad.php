<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

   <title>Actualizar Actividad</title>
</head>
<body>
<?php
include ('../../conexion/conexion.php');
$conexion = new Conexion();
$db = $conexion->conectar();

$pk_actividad =  $_POST['pk'];
$nombre_actividad = $_POST['nombre_actividad'];

$query = $db -> prepare("UPDATE actividad SET nombre_actividad= '{$nombre_actividad}' WHERE pk_actividad='{$pk_actividad}'");
$query->execute();

if ( $query -> execute() ){   
    echo '<script>
    Swal.fire({
        title:"Exito",
        text:"Actividad actualizada con exito",
        icon: "sucess",
        ConfirmButtonText: "Aceptar",
      }).then(function(){
      window.location.href = "../../lista_actividades.php"; 
      });
      </script>';
 }else{
    echo '<script>
    Swal.fire({
        title:"Error",
        text:"Error al actualizar la actividad",
        icon: "error",
        ConfirmButtonText: "Aceptar",
      }).then(function(){
      window.location.href = "../../formulario_actividad.php"; 
      });
      </script>';
 }

?>
</body>
</html>



