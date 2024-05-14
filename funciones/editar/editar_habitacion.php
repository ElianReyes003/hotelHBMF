<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

   <title>Actualizar Habitacion</title>
</head>
<body>
<?php
include ('../../conexion/conexion.php');
$conexion = new Conexion();
$db = $conexion->conectar();

$pk_habitacion =  $_POST['pk'];
$num_habitacion = $_POST['num_habitacion'];
$estado = $_POST['estado'];
$fk_area= $_POST['fk_area'];
$fk_empleado = ($_POST["fk_empleado"]) ? $_POST["fk_empleado"] : null;
$fecha_ver= $_POST['fecha_ver'];

$query = $db -> prepare("UPDATE habitacion SET num_habitacion= '{$num_habitacion}', fk_area= '{$fk_area}', fk_empleado= '{$fk_empleado}',fecha_ver= '{$fecha_ver}',estado= '{$estado}' WHERE pk_habitacion='{$pk_habitacion}'");
$query->execute();

if ( $query -> execute() ){   
    echo '<script>
    Swal.fire({
        title:"Exito",
        text:"Habitacion actualizada con exito",
        icon: "sucess",
        ConfirmButtonText: "Aceptar",
      }).then(function(){
      window.location.href = "../../lista_habitaciones.php"; 
      });
      </script>';
 }else{
    echo '<script>
    Swal.fire({
        title:"Error",
        text:"Error al actualizar habitacion",
        icon: "error",
        ConfirmButtonText: "Aceptar",
      }).then(function(){
      window.location.href = "../../formulario_habitacion.php"; 
      });
      </script>';
 }

?>
</body>
</html>



