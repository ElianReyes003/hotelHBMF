<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>Registrar Habitación</title>
</head>
<body>
<?php

require_once('../../conexion/conexion.php');

$conexion = new Conexion();
$db = $conexion->conectar();

$query= $db -> prepare("SELECT nombre_area, pk_area FROM area;");
$query -> execute();            
$resultado= $query -> fetchAll();

$num_habitacion = $_POST['num_habitacion'];
$estado = "Disponible";
$fk_area = $_POST['fk_area'];
$estatus = 1;

// Verificar si ya existe una actividad con el mismo nombre
$checkSql = "SELECT COUNT(*) FROM habitacion WHERE num_habitacion = :num_habitacion";
$checkStmt = $db->prepare($checkSql);
$checkStmt->bindParam(':num_habitacion', $num_habitacion, PDO::PARAM_STR);
$checkStmt->execute();
$count = $checkStmt->fetchColumn();

if ($count > 0) {
    echo '<script>
        Swal.fire({
            title:"Error",
            text:"Esta Habitacion ya existe",
            icon: "warning",
            ConfirmButtonText: "Aceptar",
          }).then(function(){
          window.location.href = "../../formulario_habitacion.php"; 
          });
          </script>';
} else {
    $sql = "INSERT INTO habitacion (num_habitacion,estado,fk_area,estatus) VALUES (:num_habitacion,:estado,:fk_area,:estatus)";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':num_habitacion', $num_habitacion, PDO::PARAM_STR);
    $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
    $stmt->bindParam(':fk_area', $fk_area, PDO::PARAM_STR);
    $stmt->bindParam(':estatus', $estatus, PDO::PARAM_INT);

    try {
        $stmt->execute();
        echo '<script>
        Swal.fire({
            title:"Exito",
            text:"Habitacion registrada con exito",
            icon: "success",
            ConfirmButtonText: "Aceptar",
          }).then(function(){
          window.location.href = "../../formulario_habitacion.php"; 
          });
          </script>';

    } catch (PDOException $e) {
        echo '<script>
        Swal.fire({
            title:"Error",
            text:"Error al registrar la habitacion",
            icon: "error",
            ConfirmButtonText: "Aceptar",
          }).then(function(){
          window.location.href = "../../formulario_habitacion.php"; 
          });
          </script>';
    }
}

$db = null;
?>
</body>
</html>