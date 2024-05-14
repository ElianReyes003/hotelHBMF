<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Habitaciones</title>
    <link rel="icon" href="img/logo.png">
</head>
<body>
<?php include 'header.php'; ?>
<?php
// Incluye el archivo de conexión
require 'conexion/conexion.php';

try {
    // Crear una instancia de la clase de conexión
    $conexion = new Conexion();
    
    // Conecta a la base de datos
    $pdo = $conexion->conectar();
    
    // Prepara la consulta SQL
    $consulta = "SELECT hb.*, a.nombre_area,e.nombres,hb.fecha_ver,l.fecha as ultima_fecha_limpieza, l.hora_inicio, l.hora_fin
    FROM habitacion hb
    INNER JOIN area a ON hb.fk_area = a.pk_area
    LEFT JOIN empleado e ON hb.fk_empleado = e.pk_empleado
    LEFT JOIN limpieza l ON hb.pk_habitacion = l.fk_habitacion
    WHERE hb.estatus = 1
    GROUP BY hb.pk_habitacion
    ORDER BY hb.pk_habitacion";


    // Ejecuta la consulta
    $stmt = $pdo->prepare($consulta);
    $stmt->execute();
    
    // Recupera los resultados
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Verifica si hay datos
    if (count($resultados) > 0) {
        echo "<h2 class='h2listas'>Lista de Habitaciones</h2>";
        echo "<hr>";
        echo "<table>";
        echo "<tr>";
        echo "<th>Numero de habitación</th>";
        echo "<th>Área</th>";
        echo "<th>Estado de habitación</th>";
        echo "<th>Última fecha y hora de Limpieza</th>";
        echo "<th>Empleado y fecha de verificación</th>";
        echo "<th>ACCIONES</th>";
        echo "</tr>";

        foreach ($resultados as $fila) {
            echo "<tr>";
            echo "<td>{$fila['num_habitacion']}</td>";
            echo "<td>{$fila['nombre_area']}</td>";
            echo "<td style='color:";
            if ($fila['estado'] == 'Disponible') {
            echo "green";
            } else if ($fila['estado'] == 'En limpieza') {
            echo "rgb(241, 225, 0)";
            } else if ($fila['estado'] == 'En mantenimiento') {
            echo "orange";
            } else if ($fila['estado'] == 'Indispuesta') {
            echo "red";
            }
            echo "' class='fondo_estado'>{$fila['estado']}</td>";
           
            echo "<td>";
            if ($fila['ultima_fecha_limpieza'] !== null) {
            echo "{$fila['ultima_fecha_limpieza']} ";
            if ($fila['hora_inicio'] !== null && $fila['hora_fin'] !== null) {
            $hora_inicio_am_pm = date("g:i A", strtotime($fila['hora_inicio']));
            $hora_fin_am_pm = date("g:i A", strtotime($fila['hora_fin']));

            echo "de {$hora_inicio_am_pm} a las {$hora_fin_am_pm}";
            }
            } else {
            echo "------";
            }
            echo "</td>";

            echo "<td>";
            if($fila['nombres']==''){
                echo "------";
            }else{
                echo "{$fila['nombres']} {$fila['fecha_ver']}";
            }
            echo "</td>";
            echo "<td>";

            $pk_habitacion = $fila['pk_habitacion'];

            echo "<a href='formulario_editar_habitaciones.php?pk={$pk_habitacion}'><img src='img/actualizar.png' width='35' height='35'></a>";
            echo "<a onclick='confirmarBaja(" . $pk_habitacion . ")'><img  style='cursor: pointer;'  src='img/eliminar.png' width='35' height='35'></a>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<div class='no-registros'>No se encontraron registros.</div>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<script>
     function confirmarBaja(pk_habitacion) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción dará de baja la habitacion. ¿Deseas continuar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, dar de baja',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'funciones/eliminar/eliminar_habitaciones.php?pk_habitacion='+pk_habitacion
        } 
    });
    }     
</script>
</body>
</html>