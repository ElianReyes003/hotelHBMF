<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

   <title>Actualizar Limpieza</title>
</head>
<body>
<?php
include('../../conexion/conexion.php');
$conexion = new Conexion();
$db = $conexion->conectar();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pk = $_POST['pk'];
    $fk_actividad = isset($_POST['nombre_actividad']) ? $_POST['nombre_actividad'] : array();
    $fk_empleado = $_POST['fk_empleado'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];
    
    //Tiempo
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
    $observacion = ($_POST['mtto'] == 'Si') ? $_POST['observacion'] : null;

    // Eliminar relaciones existentes
    $delete_actividad_sql = "DELETE FROM limpieza_actividad WHERE fk_limpieza = :fk_limpieza";
    $delete_actividad_stmt = $db->prepare($delete_actividad_sql);
    $delete_actividad_stmt->bindParam(':fk_limpieza', $pk, PDO::PARAM_INT);
    $delete_actividad_stmt->execute();

    // Insertar nuevas relaciones de actividad
    foreach ($fk_actividad as $actividad_id) {
        $insert_actividad_sql = "INSERT INTO limpieza_actividad (fk_limpieza, fk_actividad) VALUES (:fk_limpieza, :fk_actividad)";
        $insert_actividad_stmt = $db->prepare($insert_actividad_sql);
        $insert_actividad_stmt->bindParam(':fk_limpieza', $pk, PDO::PARAM_INT);
        $insert_actividad_stmt->bindParam(':fk_actividad', $actividad_id, PDO::PARAM_INT);
        $insert_actividad_stmt->execute();
    }

    $query = $db->prepare('UPDATE limpieza SET fk_empleado = :fk_empleado, hora_inicio = :hora_inicio, hora_fin = :hora_fin, tiempo = :tiempo, mtto = :mtto, observacion = :observacion WHERE pk_limpieza = :pk');
   
    $query->bindParam(':fk_empleado', $fk_empleado, PDO::PARAM_INT);
    $query->bindParam(':hora_inicio', $hora_inicio, PDO::PARAM_STR);
    $query->bindParam(':hora_fin', $hora_fin, PDO::PARAM_STR);
    $query->bindParam(':tiempo', $tiempo, PDO::PARAM_STR);
    $query->bindParam(':mtto', $mtto, PDO::PARAM_STR);
    $query->bindParam(':observacion', $observacion, PDO::PARAM_STR);
    $query->bindParam(':pk', $pk, PDO::PARAM_INT);

    if ($query->execute()) {
        echo '<script>
        Swal.fire({
            title:"Exito",
            text:"Limpieza actualizada con exito",
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
            text:"Error al actualizar limpieza",
            icon: "error",
            ConfirmButtonText: "Aceptar",
          }).then(function(){
          window.location.href = "../../formulario_limpieza.php"; 
          });
          </script>';
    }
}
?>

</body>
</html>
