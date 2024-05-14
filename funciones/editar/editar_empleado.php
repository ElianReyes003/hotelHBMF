<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

   <title>Actualizar Empleado</title>
</head>
<body>
<?php
include ('../../conexion/conexion.php');
$conexion = new Conexion();
$db = $conexion->conectar();

$pk_empleado =  $_POST['pk'];
$nombres = $_POST['nombres'];
$apaterno= $_POST['apaterno'];
$amaterno = $_POST['amaterno'];
$contacto = $_POST['contacto'];


$query = $db -> prepare("UPDATE empleado SET nombres= '{$nombres}', apaterno= '{$apaterno}', amaterno= '{$amaterno}', contacto= '{$contacto}' WHERE pk_empleado='{$pk_empleado}'");
$query->execute();

if ( $query -> execute() ){   
    echo '<script>
    Swal.fire({
        title:"Exito",
        text:"Empleado(a) actualizado con exito",
        icon: "sucess",
        ConfirmButtonText: "Aceptar",
      }).then(function(){
      window.location.href = "../../lista_empleados.php"; 
      });
      </script>';
 }else{
    echo '<script>
    Swal.fire({
        title:"Error",
        text:"Error al actualizar empleado(a)",
        icon: "error",
        ConfirmButtonText: "Aceptar",
      }).then(function(){
      window.location.href = "../../formulario_empleado.php"; 
      });
      </script>';
 }

?>
</body>
</html>



