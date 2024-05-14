<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

   <title>Actualizar Área</title>
</head>
<body>
<?php
include ('../../conexion/conexion.php');
$conexion = new Conexion();
$db = $conexion->conectar();

$pk_area =  $_POST['pk'];
$nombre_area = $_POST['nombre_area'];

$query = $db -> prepare("UPDATE area SET nombre_area= '{$nombre_area}' WHERE pk_area='{$pk_area}'");
$query->execute();

if ( $query -> execute() ){   
    echo '<script>
    Swal.fire({
        title:"Exito",
        text:"Área actualizada con exito",
        icon: "sucess",
        ConfirmButtonText: "Aceptar",
      }).then(function(){
      window.location.href = "../../lista_areas.php"; 
      });
      </script>';
 }else{
    echo '<script>
    Swal.fire({
        title:"Error",
        text:"Error al actualizar la área",
        icon: "error",
        ConfirmButtonText: "Aceptar",
      }).then(function(){
      window.location.href = "../../formulario_area.php"; 
      });
      </script>';
 }

?>
</body>
</html>



