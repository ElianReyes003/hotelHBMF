<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>Registrar Empleado</title>
</head>
<body>
<?php

require_once('../../conexion/conexion.php');

$conexion = new Conexion();
$db = $conexion->conectar();

$nombres = $_POST['nombres'];
$apaterno = $_POST['apaterno'];
$amaterno = $_POST['amaterno'];
$contacto = $_POST['contacto'];
$estatus = 1;

// Verificar si ya existe una actividad con el mismo nombre
$checkSql = "SELECT COUNT(*) FROM empleado WHERE nombres = :nombres";
$checkStmt = $db->prepare($checkSql);
$checkStmt->bindParam(':nombres', $nombres, PDO::PARAM_STR);
$checkStmt->execute();
$count = $checkStmt->fetchColumn();

if ($count > 0) {
    echo '<script>
        Swal.fire({
            title:"Error",
            text:"Esta Empleado ya existe",
            icon: "warning",
            ConfirmButtonText: "Aceptar",
          }).then(function(){
          window.location.href = "../../formulario_empleado.php"; 
          });
          </script>';
} else {
    $sql = "INSERT INTO empleado (nombres,apaterno,amaterno,contacto,estatus) VALUES (:nombres,:apaterno,:amaterno,:contacto,:estatus)";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':nombres', $nombres, PDO::PARAM_STR);
    $stmt->bindParam(':apaterno', $apaterno, PDO::PARAM_STR);
    $stmt->bindParam(':amaterno', $amaterno, PDO::PARAM_STR);
    $stmt->bindParam(':contacto', $contacto, PDO::PARAM_STR);
    $stmt->bindParam(':estatus', $estatus, PDO::PARAM_INT);

    try {
        $stmt->execute();
        echo '<script>
        Swal.fire({
            title:"Exito",
            text:"Empleado registrado con exito",
            icon: "success",
            ConfirmButtonText: "Aceptar",
          }).then(function(){
          window.location.href = "../../formulario_empleado.php"; 
          });
          </script>';

    } catch (PDOException $e) {
        echo '<script>
        Swal.fire({
            title:"Error",
            text:"Error al registrar empleado",
            icon: "error",
            ConfirmButtonText: "Aceptar",
          }).then(function(){
          window.location.href = "../../formulario_empleado.php"; 
          });
          </script>';
    }
}

$db = null;
?>
</body>
</html>