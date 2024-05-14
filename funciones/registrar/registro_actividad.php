<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>Registrar Actividad</title>
</head>
<body>
<?php

require_once('../../conexion/conexion.php');

$conexion = new Conexion();
$db = $conexion->conectar();

$nombre_actividad = $_POST['nombre_actividad'];
$estatus = 1;

// Verificar si ya existe una actividad con el mismo nombre
$checkSql = "SELECT COUNT(*) FROM actividad WHERE nombre_actividad = :nombre_actividad";
$checkStmt = $db->prepare($checkSql);
$checkStmt->bindParam(':nombre_actividad', $nombre_actividad, PDO::PARAM_STR);
$checkStmt->execute();
$count = $checkStmt->fetchColumn();

if ($count > 0) {
    echo '<script>
        Swal.fire({
            title:"Error",
            text:"Esta actividad ya existe",
            icon: "warning",
            ConfirmButtonText: "Aceptar",
          }).then(function(){
          window.location.href = "../../formulario_actividad.php"; 
          });
          </script>';
} else {
    $sql = "INSERT INTO actividad (nombre_actividad, estatus) VALUES (:nombre_actividad, :estatus)";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':nombre_actividad', $nombre_actividad, PDO::PARAM_STR);
    $stmt->bindParam(':estatus', $estatus, PDO::PARAM_INT);

    try {
        $stmt->execute();
        echo '<script>
        Swal.fire({
            title:"Exito",
            text:"Actividad registrada con exito",
            icon: "success",
            ConfirmButtonText: "Aceptar",
          }).then(function(){
          window.location.href = "../../formulario_actividad.php"; 
          });
          </script>';
    } catch (PDOException $e) {
        echo '<script>
        Swal.fire({
            title:"Error",
            text:"Error al registrar la actividad",
            icon: "error",
            ConfirmButtonText: "Aceptar",
          }).then(function(){
          window.location.href = "../../formulario_actividad.php"; 
          });
          </script>';
    }
}

$db = null;
?>
</body>
</html>
