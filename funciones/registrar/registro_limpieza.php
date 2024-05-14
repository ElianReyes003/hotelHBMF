<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>Registrar Limpieza</title>
</head>
<body>
<?php

require_once('../../conexion/conexion.php');

$conexion = new Conexion();
$db = $conexion->conectar();

$query= $db -> prepare("SELECT nombre_area, pk_area FROM area;");
$query -> execute();            
$resultado= $query -> fetchAll();

$fecha = $_POST['fecha'];

$fk_habitacion = ($_POST["fk_habitacion"]) ? $_POST["fk_habitacion"] : null;
$fk_area = ($_POST["fk_area"]) ? $_POST["fk_area"] : null;
$fk_actividad = isset($_POST['nombre_actividad']) ? $_POST['nombre_actividad'] : array();
$fk_empleado = $_POST['fk_empleado'];
$hora_inicio = $_POST['hora_inicio'];
$hora_fin = $_POST['hora_fin'];

$inicio = new DateTime($hora_inicio);
$fin = new DateTime($hora_fin);
$diferencia = $inicio->diff($fin);
$horas = $diferencia->h + $diferencia->days * 24;
$minutos = $diferencia->i;

$horas_texto = ($horas == 1) ? "hora" : "horas";
$minutos_texto = ($minutos == 1) ? "minuto" : "minutos";
$tiempo = "";

if ($horas > 0) {
    $tiempo .= "$horas $horas_texto";
}
if ($horas > 0 && $minutos > 0) {
    $tiempo .= " y ";
}
if ($minutos > 0) {
    $tiempo .= "$minutos $minutos_texto";
}

$mtto = $_POST['mtto'];
$observacion = isset($_POST["observacion"]) ? $_POST["observacion"] : null;
$estatus = 1;

function obtenerNumeroHabitacion($pk_habitacion) {
global $db;
$sql = "SELECT num_habitacion FROM habitacion WHERE pk_habitacion = :pk_habitacion";
$stmt = $db->prepare($sql);
$stmt->bindParam(':pk_habitacion', $pk_habitacion, PDO::PARAM_INT);
$stmt->execute();
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
return $resultado['num_habitacion'];
}

function obtenerNombreArea($pk_area) {
global $db; 
$sql = "SELECT nombre_area FROM area WHERE pk_area = :pk_area";
$stmt = $db->prepare($sql);
$stmt->bindParam(':pk_area', $pk_area, PDO::PARAM_INT);
$stmt->execute();
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
return $resultado['nombre_area'];
}

/*
$contador_file = 'contador.txt';
$numero_aleatorio = file_get_contents($contador_file);
$numero_aleatorio++;
file_put_contents($contador_file, $numero_aleatorio);
*/
$tipo = ''; 
$nombre_tipo = ''; 
$numero_aleatorio = rand(0, 9999);
if (isset($_POST['fk_habitacion']) && !empty($_POST['fk_habitacion'])) {
    $tipo = 'HB';
    $numero_habitacion = obtenerNumeroHabitacion($_POST['fk_habitacion']); 
    $folio = "LIMP_$numero_aleatorio" . "_$fecha" . "_$tipo" . "_$numero_habitacion";
} elseif (isset($_POST['fk_area']) && !empty($_POST['fk_area'])) {
    $tipo = 'AR';
    $nombre_tipo = obtenerNombreArea($_POST['fk_area']); 
    $folio = "LIMP_$numero_aleatorio" . "_$fecha" . "_$tipo" . "_$nombre_tipo";
} 

$checkSql = "SELECT COUNT(*) FROM limpieza WHERE folio = :folio";
$checkStmt = $db->prepare($checkSql);
$checkStmt->bindParam(':folio', $folio, PDO::PARAM_STR);
$checkStmt->execute();
$count = $checkStmt->fetchColumn();

if ($count > 0) {
    echo '<script>
        Swal.fire({
            title:"Error",
            text:"Esta Limpieza ya existe",
            icon: "warning",
            ConfirmButtonText: "Aceptar",
          }).then(function(){
          window.location.href = "../../formulario_limpieza.php"; 
          });
          </script>';
} else {
    $sql = "INSERT INTO limpieza (folio,fecha,fk_habitacion,fk_area,fk_empleado,hora_inicio,hora_fin,tiempo,mtto,observacion,estatus) 
    VALUES (:folio,:fecha,:fk_habitacion,:fk_area,:fk_empleado,:hora_inicio,:hora_fin,:tiempo,:mtto,:observacion,:estatus)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':folio', $folio, PDO::PARAM_STR);
    $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
    $stmt->bindParam(':fk_habitacion', $fk_habitacion, PDO::PARAM_INT);
    $stmt->bindParam(':fk_area', $fk_area, PDO::PARAM_INT);
    $stmt->bindParam(':fk_empleado', $fk_empleado, PDO::PARAM_INT);
    $stmt->bindParam(':hora_inicio', $hora_inicio, PDO::PARAM_STR);
    $stmt->bindParam(':hora_fin', $hora_fin, PDO::PARAM_STR);
    $stmt->bindParam(':tiempo', $tiempo, PDO::PARAM_STR);
    $stmt->bindParam(':mtto', $mtto, PDO::PARAM_STR);
    $stmt->bindParam(':observacion', $observacion, PDO::PARAM_STR);
    $stmt->bindParam(':estatus', $estatus, PDO::PARAM_INT);
    
    try {
        $stmt->execute();
        $last_limpieza_id = $db->lastInsertId();
    
        foreach ($fk_actividad as $actividad_id) {
            $insert_actividad_sql = "INSERT INTO limpieza_actividad (fk_limpieza, fk_actividad) VALUES (:fk_limpieza, :fk_actividad)";
            $insert_actividad_stmt = $db->prepare($insert_actividad_sql);
            $insert_actividad_stmt->bindParam(':fk_limpieza', $last_limpieza_id, PDO::PARAM_INT);
            $insert_actividad_stmt->bindParam(':fk_actividad', $actividad_id, PDO::PARAM_INT);
            $insert_actividad_stmt->execute();
        }

        echo '<script>
        Swal.fire({
            title:"Exito",
            text:"Limpieza registrada con exito",
            icon: "success",
            ConfirmButtonText: "Aceptar",
          }).then(function(){
          window.location.href = "../../formulario_limpieza.php"; 
          });
          </script>';

    } catch (PDOException $e) {
        echo 'Error en la inserción: ' . $e->getMessage();
        echo '<script>
        Swal.fire({
            title:"Error",
            text:"Error al registrar la Limpieza",
            icon: "error",
            ConfirmButtonText: "Aceptar",
          }).then(function(){
          window.location.href = "../../formulario_limpieza.php"; 
          });
          </script>';
    }
}

$db = null;
?>


</body>
</html>