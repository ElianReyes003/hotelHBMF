<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Actividades</title>
    <link rel="icon" href="img/logo.png">
</head>
<body>
<?php include 'header.php'; ?>
<?php
require 'conexion/conexion.php';

try {
    $conexion = new Conexion();
    
    $pdo = $conexion->conectar();

    $consulta = "SELECT * FROM actividad where estatus=0";
    
    $stmt = $pdo->prepare($consulta);
    $stmt->execute();
    
    // Recupera los resultados
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Verifica si hay datos
    if (count($resultados) > 0) {
        echo "<h2 class='h2listas'>Lista de Actividades dadas de baja</h2>";
        echo "<hr>";
        echo "<table>";
        echo "<tr>";
        echo "<th>Nombre de la actividad</th>";
        echo "<th>ACCIONES</th>";
        echo "</tr>";

        foreach ($resultados as $fila) {
            echo "<tr>";
            echo "<td>{$fila['nombre_actividad']}</td>";
            echo "<td>";

            $pk_actividad = $fila['pk_actividad'];

            echo "<a href='formulario_editar_actividades.php?pk={$pk_actividad}'><img src='img/actualizar.png' width='35' height='35'></a>";
            echo "<a href='funciones/alta/alta_actividades.php?pk_actividad={$pk_actividad}'><img src='img/alta.png' width='35' height='35'></a>";
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