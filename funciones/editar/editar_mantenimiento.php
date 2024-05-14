<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

   <title>Actualizar Mantenimiento</title>
</head>
<body>
<?php
include('../../conexion/conexion.php');
$conexion = new Conexion();
$db = $conexion->conectar();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pk_mantenimiento = $_POST['pk_mantenimiento'];
    $persona_cargo = $_POST['persona_cargo'];
    $fecha = $_POST['fecha'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];
    $observaciones = $_POST['observaciones'];

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

    $query = $db->prepare('UPDATE mantenimiento SET fecha_mant = :fecha_mant, persona_cargo = :persona_cargo, hora_inicio_mant = :hora_inicio_mant, hora_fin_mant = :hora_fin_mant, tiempo_mant = :tiempo_mant, observaciones_mant = :observaciones_mant
    WHERE pk_mantenimiento = :pk_mantenimiento');

    $query->bindParam(':fecha_mant', $fecha, PDO::PARAM_STR);
    $query->bindParam(':persona_cargo', $persona_cargo, PDO::PARAM_STR);
    $query->bindParam(':hora_inicio_mant', $hora_inicio, PDO::PARAM_STR);
    $query->bindParam(':hora_fin_mant', $hora_fin, PDO::PARAM_STR);
    $query->bindParam(':tiempo_mant', $tiempo, PDO::PARAM_STR);
    $query->bindParam(':observaciones_mant', $observaciones, PDO::PARAM_STR);
    $query->bindParam(':pk_mantenimiento', $pk_mantenimiento, PDO::PARAM_INT);

    if ($query->execute()) {
        echo '<script>
        Swal.fire({
            title:"Exito",
            text:"Mantenimiento actualizado con exito",
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
            text:"Error al actualizar mantenimiento",
            icon: "error",
            ConfirmButtonText: "Aceptar",
          }).then(function(){
          window.location.href = "../../formulario_mantenimiento.php"; 
          });
          </script>';
    }
}
?>
</body>
</html>