<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Empleados</title>
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
    $consulta = "SELECT * FROM empleado where estatus=1";
    
    // Ejecuta la consulta
    $stmt = $pdo->prepare($consulta);
    $stmt->execute();
    
    // Recupera los resultados
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Verifica si hay datos
    if (count($resultados) > 0) {
        echo "<h2 class='h2listas'>Lista de Empleados</h2>";
        echo "<hr>";
        echo "<table>";
        echo "<tr>";
        echo "<th>Nombres</th>";
        echo "<th>Apellido paterno</th>";
        echo "<th>Apellido materno</th>";
        echo "<th>Contacto</th>";
        echo "<th>ACCIONES</th>";
        echo "</tr>";

        foreach ($resultados as $fila) {
            echo "<tr>";
            echo "<td>{$fila['nombres']}</td>";
            echo "<td>{$fila['apaterno']}</td>";
            echo "<td>{$fila['amaterno']}</td>";
            echo "<td>{$fila['contacto']}</td>";
            echo "<td>";

            $pk_empleado = $fila ['pk_empleado'];

            echo "<a href='formulario_editar_empleado.php?pk={$pk_empleado}'><img src='img/actualizar.png' width='35' height='35'></a>";
            echo "<a onclick='confirmarBaja(" . $pk_empleado . ")'><img style='cursor: pointer;' src='img/eliminar.png' width='35' height='35'></a>";
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
    function confirmarBaja(pk_empleado) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción dará de baja el empleado. ¿Deseas continuar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, dar de baja',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'funciones/eliminar/eliminar_empleados.php?pk_empleado='+pk_empleado
        } 
    });
    }    
</script>
</body>
</html>