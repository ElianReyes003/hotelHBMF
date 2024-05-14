<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Eliminar Limpieza</title>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
<?php
include('../clases/Limpiezas.php');

$limpiezas = new Limpiezas();

$pk_limpieza= $_GET['pk_limpieza'];

$respuesta = $limpiezas->baja($pk_limpieza);

if ($respuesta == true) {
   echo '<script>
   Swal.fire({
       title:"Exito",
       text:"Limpieza dada de baja con exito",
       icon: "success",
       ConfirmButtonText: "Aceptar",
     }).then(function(){
     window.location.href = "../../lista_limpiezas.php"; 
     });
     </script>';
} else {
   echo '<script>
   Swal.fire({
       title:"Error",
       text:"Limpieza no dada de baja",
       icon: "error",
       ConfirmButtonText: "Aceptar",
     }).then(function(){
     window.location.href = "../../lista_limpiezas.php"; 
     });
     </script>';
}
?>
</body>
</html>
