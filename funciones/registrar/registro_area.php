<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>Registrar Área</title>
</head>
<body>
<?php

require_once('../../conexion/conexion.php');

$conexion = new Conexion();
$db = $conexion->conectar();

$nombre_area = $_POST['nombre_area'];
$estatus = 1;

$checkSql = "SELECT COUNT(*) FROM area WHERE nombre_area = :nombre_area";
$checkStmt = $db->prepare($checkSql);
$checkStmt->bindParam(':nombre_area', $nombre_area, PDO::PARAM_STR);
$checkStmt->execute();
$count = $checkStmt->fetchColumn();

if ($count > 0) {
    echo '<script>
        Swal.fire({
            title:"Error",
            text:"Esta Area ya existe",
            icon: "warning",
            ConfirmButtonText: "Aceptar",
          }).then(function(){
          window.location.href = "../../formulario_area.php"; 
          });
          </script>';
} else {
    $sql = "INSERT INTO area (nombre_area, estatus) VALUES (:nombre_area, :estatus)";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':nombre_area', $nombre_area, PDO::PARAM_STR);
    $stmt->bindParam(':estatus', $estatus, PDO::PARAM_INT);

    try {
        $stmt->execute();
        echo '<script>
        Swal.fire({
            title:"Exito",
            text:"Area registrada con exito",
            icon: "success",
            ConfirmButtonText: "Aceptar",
          }).then(function(){
          window.location.href = "../../formulario_area.php"; 
          });
          </script>';

    } catch (PDOException $e) {
        echo '<script>
        Swal.fire({
            title:"Error",
            text:"Error al registrar el area",
            icon: "error",
            ConfirmButtonText: "Aceptar",
          }).then(function(){
          window.location.href = "..././formulario_area.php"; 
          });
          </script>';
    }
}

$db = null;
?>
</body>
</html>