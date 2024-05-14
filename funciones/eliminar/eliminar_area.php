<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
   <title>Eliminar Aréa</title>
</head>
<body>
  
<?php
include('../clases/Area.php');

$area = new Area();

$pk_area = $_GET['pk_area'];

$respuesta = $area->baja($pk_area);

if ($respuesta == true) {
   echo '<script>
   Swal.fire({
       title:"Exito",
       text:"Área dada de baja con exito",
       icon: "success",
       ConfirmButtonText: "Aceptar",
     }).then(function(){
     window.location.href = "../../lista_areas.php"; 
     });
     </script>';
} else {
   echo '<script>
   Swal.fire({
       title:"Error",
       text:"Area no dada de baja",
       icon: "error",
       ConfirmButtonText: "Aceptar",
     }).then(function(){
     window.location.href = "../../lista_areas.php"; 
     });
     </script>';
}
?>
 
</body>
</html>


