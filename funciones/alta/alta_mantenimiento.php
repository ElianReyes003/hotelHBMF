<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dar de alta mantenimiento</title>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
<?php
include('../clases/Mantenimientos.php');

$mantenimiento = new Mantenimiento();

$pk_mantenimiento= $_GET['pk_mantenimiento'];

$respuesta = $mantenimiento->alta($pk_mantenimiento);

if ($respuesta == true) {
   echo '<script>
   Swal.fire({
       title:"Exito",
       text:"Mantenimiento dado de alta con exito",
       icon: "success",
       ConfirmButtonText: "Aceptar",
     }).then(function(){
     window.location.href = "../../lista_mantenimientos_baja.php"; 
     });
     </script>';
} else {
   echo '<script>
   Swal.fire({
       title:"Error",
       text:"Mantenimiento no dada de alta",
       icon: "error",
       ConfirmButtonText: "Aceptar",
     }).then(function(){
     window.location.href = "../../lista_mantenimientos_baja.php"; 
     });
     </script>';
}
?>
</body>
</html>
