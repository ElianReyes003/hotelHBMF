<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

   <title>Eliminar Actividad</title>
</head>
<body>
<?php
include('../clases/Actividad.php');

$actividad = new Actividad();

$pk_actividad = $_GET['pk_actividad'];

$respuesta = $actividad->alta($pk_actividad);

if ($respuesta == true) {
   echo '<script>
   Swal.fire({
       title:"Exito",
       text:"Actividad dada de alta con exito",
       icon: "success",
       ConfirmButtonText: "Aceptar",
     }).then(function(){
     window.location.href = "../../lista_actividades_baja.php"; 
     });
     </script>';
} else {
   echo '<script>
   Swal.fire({
       title:"Error",
       text:"Actividad no dada de alta",
       icon: "error",
       ConfirmButtonText: "Aceptar",
     }).then(function(){
     window.location.href = "../../lista_actividades_baja.php"; 
     });
     </script>';
}
?>
</body>
</html>



