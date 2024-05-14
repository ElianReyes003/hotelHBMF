<?php
require_once('conexion/conexion.php');

$conexion = new Conexion();
$db = $conexion->conectar();

$sql = "SELECT pk_limpieza, folio, num_habitacion, nombre_area, observacion FROM limpieza li
LEFT JOIN habitacion hb ON li.fk_habitacion=hb.pk_habitacion
LEFT JOIN area ar ON li.fk_area=ar.pk_area
WHERE mtto='Si'";
$limpieza = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Registro de Mantenimiento</title>
    <link rel="icon" href="img/logo.png">
</head>
<body>
<?php include 'header.php'; ?>
<form action="funciones/registrar/registro_mantenimiento.php" method="post" class="custom-form">
    <h1>Registro de Mantenimiento</h1>

    <label>Habitación o área a la que se le realizó Mantenimiento:</label>
    <select id="seleccionado" name="fk_limpieza" onchange="actualizarDetalles()" required>
        <option value="">Seleccione una opción</option>
        <?php foreach ($limpieza as $value): ?>
            <option value="<?php echo $value['pk_limpieza']; ?>" data-observacion="<?php echo $value['observacion']; ?>">
                <?php echo $value['folio']; ?> (<?php echo $value['nombre_area'] . $value['num_habitacion']; ?>) 
            </option>
        <?php endforeach; ?>
    </select>
    
    <label>Detalles:</label>
    <input type="text" id="detalles" name="observaciones" required>

    <label>Fecha:</label>
    <input type="date" id="fecha" name="fecha" required>

    <label>Persona quién realizó el Mantenimiento:</label>
    <input type="text" name="persona_cargo" required>

    <label>Hora de inicio:</label>
    <input type="time" id="hora_inicio" name="hora_inicio" required>

    <label>Hora de fin:</label>
    <input type="time" id="hora_fin" name="hora_fin" required>

    <input type="submit" value="Registrar Mantenimiento">  
</form>

<script>
        function actualizarDetalles() {
            var select = document.getElementById("seleccionado");
            var seleccionado = select.options[select.selectedIndex];

            var observacion = seleccionado.getAttribute("data-observacion");

            document.getElementById("detalles").value = observacion;
        }
    </script>
</body>
</html>
