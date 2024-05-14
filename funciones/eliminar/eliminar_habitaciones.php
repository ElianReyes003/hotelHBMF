<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Eliminar Habitación</title>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
<?php
include('../clases/Habitaciones.php');

$habitaciones = new Habitaciones();

$pk_habitacion = $_GET['pk_habitacion'];

$respuesta = $habitaciones->baja($pk_habitacion);

if ($respuesta == true) {
   echo '<script>
   Swal.fire({
       title:"Exito",
       text:"Habitación dada de baja con exito",
       icon: "success",
       ConfirmButtonText: "Aceptar",
     }).then(function(){
     window.location.href = "../../lista_habitaciones.php"; 
     });
     </script>';
} else {
   echo '<script>
   Swal.fire({
       title:"Error",
       text:"Habitación no no dada de baja",
       icon: "error",
       ConfirmButtonText: "Aceptar",
     }).then(function(){
     window.location.href = "../../lista_habitaciones.php"; 
     });
     </script>';
}
?>
</body>
</html>
