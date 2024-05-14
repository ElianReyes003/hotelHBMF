<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Eliminar Mantenimiento</title>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
<?php
include('../clases/Mantenimientos.php');

$mantenimientos = new Mantenimiento();

$pk_mantenimiento = $_GET['pk_mantenimiento'];

$respuesta = $mantenimientos->baja($pk_mantenimiento);

if ($respuesta == true) {
   echo '<script>
   Swal.fire({
       title:"Exito",
       text:"Mantenimiento dado de baja con exito",
       icon: "success",
       ConfirmButtonText: "Aceptar",
     }).then(function(){
     window.location.href = "../../lista_mantenimientos.php"; 
     });
     </script>';
} else {
   echo '<script>
   Swal.fire({
       title:"Error",
       text:"Mantenimiento no dado de baja",
       icon: "error",
       ConfirmButtonText: "Aceptar",
     }).then(function(){
     window.location.href = "../../lista_mantenimientos.php"; 
     });
     </script>';
}
?>
</body>
</html>
