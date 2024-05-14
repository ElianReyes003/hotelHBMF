<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Limpiezas</title>
    <link rel="icon" href="img/logo.png">
</head>
<body>
<?php include 'header.php'; ?>

<section>
<?php

require 'conexion/conexion.php';

try {
    $conexion = new Conexion();
    $pdo = $conexion->conectar();
  
$consulta = "SELECT li.folio, li.fecha, hb.num_habitacion, ar.nombre_area,GROUP_CONCAT(ac.nombre_actividad) AS actividades, 
em.nombres, li.hora_inicio, li.hora_fin, li.tiempo, li.mtto, li.pk_limpieza, li.observacion
FROM limpieza li
LEFT JOIN habitacion hb ON li.fk_habitacion = hb.pk_habitacion
LEFT JOIN area ar ON li.fk_area = ar.pk_area
INNER JOIN limpieza_actividad la ON la.fk_limpieza = li.pk_limpieza
INNER JOIN actividad ac ON la.fk_actividad = ac.pk_actividad
INNER JOIN empleado em ON li.fk_empleado = em.pk_empleado
WHERE li.estatus = 0
GROUP BY li.pk_limpieza";


    $stmt = $pdo->prepare($consulta);
    $stmt->execute();
    
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($resultados) > 0) {
        echo "<h2 class='h2listas'>Lista de Limpiezas dadas de baja</h2>";
        echo "<hr>";
        echo "<table>";
        echo "<tr>";
        echo "<th>Folio</th>";
        echo "<th>Fecha</th>";
        echo "<th>Numero de habitación</th>";
        echo "<th>Área</th>";
        echo "<th>Actividades realizadas</th>";
        echo "<th>Relizada por</th>";
        echo "<th>Hora de inicio</th>";
        echo "<th>Hora de fin</th>";
        echo "<th>Duración</th>";
        echo "<th>¿Se requiere mantenimiento?</th>";
        echo "<th>Observaciones para mantenimiento</th>";
        echo "<th>ACCIONES</th>";
        echo "</tr>";

        foreach ($resultados as $fila) {
            echo "<tr>";
            echo "<td>{$fila['folio']}</td>";
            echo "<td>{$fila['fecha']}</td>";
            if (!empty($fila['num_habitacion'])) {
                echo "<td>{$fila['num_habitacion']}</td>";
            } else {
                echo "<td>------</td>"; 
            }
            
            if (!empty($fila['nombre_area'])) {
                echo "<td>{$fila['nombre_area']}</td>";
            } else {
                echo "<td>------</td>";
            }

            echo "<td>{$fila['actividades']}</td>"; 
            echo "<td>{$fila['nombres']}</td>";
            echo "<td>" . date("h:i a", strtotime($fila['hora_inicio'])) . "</td>";
            echo "<td>" . date("h:i a", strtotime($fila['hora_fin'])) . "</td>";            
            echo "<td>{$fila['tiempo']}</td>";
            echo "<td>{$fila['mtto']}</td>";
            echo "<td>";
            if($fila['observacion']==''){
                echo "------";
            }else{
                echo "{$fila['observacion']}";
            }
            echo "</td>";
            echo "<td>";
            $pk_limpieza = $fila ['pk_limpieza'];
            echo "<a href='formulario_editar_limpieza.php?pk={$pk_limpieza}'><img src='img/actualizar.png' width='35' height='35'></a>";
            echo "<a href='./funciones/alta/alta_limpiezas.php?pk_limpieza={$pk_limpieza}'><img src='img/alta.png' width='35' height='35'></a>";
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
</body>
</html>