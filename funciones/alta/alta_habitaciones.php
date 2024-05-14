<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dar de alta Habitacion</title>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
<?php
include('../clases/Habitaciones.php');

$habitaciones = new Habitaciones();

$pk_habitacion = $_GET['pk_habitacion'];

$respuesta = $habitaciones->alta($pk_habitacion);

if ($respuesta == true) {
   echo '<script>
   Swal.fire({
       title:"Exito",
       text:"Habitación dada de alta con exito",
       icon: "success",
       ConfirmButtonText: "Aceptar",
     }).then(function(){
     window.location.href = "../../lista_habitaciones_baja.php"; 
     });
     </script>';
} else {
   echo '<script>
   Swal.fire({
       title:"Error",
       text:"Habitacion no dada de alta",
       icon: "error",
       ConfirmButtonText: "Aceptar",
     }).then(function(){
     window.location.href = "../../lista_habitaciones_baja.php"; 
     });
     </script>';
}
?>
</body>
</html>
