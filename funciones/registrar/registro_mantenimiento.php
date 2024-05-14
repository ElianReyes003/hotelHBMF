<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>Registrar Mantenimiento</title>
</head>
<body>
<?php

function getFormattedFolio($db) {
    // Fetch the maximum folio only once
    $sqlUltimoFolio = "SELECT MAX(folio_mant) as ultimoFolio FROM mantenimiento";
    $stmtUltimoFolio = $db->prepare($sqlUltimoFolio);
    $stmtUltimoFolio->execute();
    $ultimoFolio = $stmtUltimoFolio->fetch(PDO::FETCH_ASSOC)['ultimoFolio'];
    session_start();
    $fol_formateado = (isset($_SESSION['ultimoFolio'])) ? ($_SESSION['ultimoFolio'] + 1) : 1;
    $_SESSION['ultimoFolio'] = $fol_formateado;
    return 'MANT_' . $fol_formateado;
}

function calculateTime($hora_inicio, $hora_fin) {
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
    return $tiempo;
}

try {
    require_once('../../conexion/conexion.php');

    $conexion = new Conexion();
    $db = $conexion->conectar();

    $folio = getFormattedFolio($db);

    $fecha = $_POST['fecha'];
    $fk_limpieza = $_POST['fk_limpieza'];
    $persona_cargo = $_POST['persona_cargo'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];

    $tiempo = calculateTime($hora_inicio, $hora_fin);

    $observaciones = $_POST['observaciones'];

    $sql = "INSERT INTO mantenimiento (folio_mant,fk_limpieza, fecha_mant, persona_cargo, hora_inicio_mant, hora_fin_mant, tiempo_mant, observaciones_mant) 
            VALUES (:folio_mant,:fk_limpieza, :fecha_mant, :persona_cargo, :hora_inicio_mant, :hora_fin_mant, :tiempo_mant, :observaciones_mant)";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':folio_mant', $folio, PDO::PARAM_INT);
    $stmt->bindParam(':fk_limpieza', $fk_limpieza, PDO::PARAM_INT);
    $stmt->bindParam(':fecha_mant', $fecha, PDO::PARAM_STR);
    $stmt->bindParam(':persona_cargo', $persona_cargo, PDO::PARAM_STR);
    $stmt->bindParam(':hora_inicio_mant', $hora_inicio, PDO::PARAM_STR);
    $stmt->bindParam(':hora_fin_mant', $hora_fin, PDO::PARAM_STR);
    $stmt->bindParam(':tiempo_mant', $tiempo, PDO::PARAM_STR);
    $stmt->bindParam(':observaciones_mant', $observaciones, PDO::PARAM_STR);
    $stmt->execute();

    $update_mtto = "UPDATE limpieza SET mtto = 'No', observacion = ''
                     WHERE pk_limpieza = :fk_limpieza";
    $update_mtto = $db->prepare($update_mtto);
    $update_mtto->bindParam(':fk_limpieza', $fk_limpieza, PDO::PARAM_INT);
    $update_mtto->execute();

    echo '<script>
            Swal.fire({
                title:"Exito",
                text:"Mantenimiento registrado con exito",
                icon: "success",
                ConfirmButtonText: "Aceptar",
              }).then(function(){
              window.location.href = "../../formulario_mantenimiento.php"; 
              });
          </script>';
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
} finally {
    $db = null; 
}
?>

</body>
</html>
