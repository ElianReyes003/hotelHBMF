<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
   <title>Eliminar Empleado</title>
</head>
<body>
  
<?php
include('../clases/Empleado.php');

$empleado = new Empleado();

$pk_empleado = $_GET['pk_empleado'];

$respuesta = $empleado->baja($pk_empleado);

if ($respuesta == true) {
   echo '<script>
   Swal.fire({
       title:"Exito",
       text:"Empleado(a) dada de baja con exito",
       icon: "success",
       ConfirmButtonText: "Aceptar",
     }).then(function(){
     window.location.href = "../../lista_empleados.php"; 
     });
     </script>';
} else {
   echo '<script>
   Swal.fire({
       title:"Error",
       text:"Empleado(a) no dado de baja",
       icon: "error",
       ConfirmButtonText: "Aceptar",
     }).then(function(){
     window.location.href = "../../lista_empleados.php"; 
     });
     </script>';
}
?>
 
</body>
</html>

