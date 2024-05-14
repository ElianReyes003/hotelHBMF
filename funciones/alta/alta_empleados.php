<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
   <title>Dar de alta Empleado</title>
</head>
<body>
  
<?php
include('../clases/Empleado.php');

$empleado = new Empleado();

$pk_empleado = $_GET['pk_empleado'];

$respuesta = $empleado->alta($pk_empleado);

if ($respuesta == true) {
   echo '<script>
   Swal.fire({
       title:"Exito",
       text:"Empleado(a) dado de alta con exito",
       icon: "success",
       ConfirmButtonText: "Aceptar",
     }).then(function(){
     window.location.href = "../../lista_empleados_baja.php"; 
     });
     </script>';
} else {
   echo '<script>
   Swal.fire({
       title:"Error",
       text:"Empleado(a) no dado de alta",
       icon: "error",
       ConfirmButtonText: "Aceptar",
     }).then(function(){
     window.location.href = "../../lista_empleados_baja.php"; 
     });
     </script>';
}
?>
 
</body>
</html>

