<?php
include('conexion/conexion.php');
$conexion = new Conexion();
$db = $conexion->conectar();

$pk = $_GET['pk'];

$query = $db->prepare('SELECT * FROM limpieza WHERE pk_limpieza = :pk');
$query->bindParam(':pk', $pk, PDO::PARAM_INT);
$query->execute();
$result = $query->fetch();

$habSelectStyle = ($result['fk_habitacion'] === null) ? 'display: none;' : 'display: block;';
$habLabelStyle = ($result['fk_habitacion'] === null) ? 'display: none;' : 'display: block;';
$areaSelectStyle = ($result['fk_area'] === null) ? 'display: none;' : 'display: block;';
$areaLabelStyle = ($result['fk_area'] === null) ? 'display: none;' : 'display: block;';
$ValidObservacion = ($result['mtto'] === 'No') ? 'display: none;' : (($result['mtto'] === 'Si') ? 'display: block;' : 'display: none;');

$query = $db->prepare("SELECT nombre_actividad, pk_actividad FROM actividad WHERE estatus = '1'");
$query->execute();
$actividad = $query->fetchAll();

// Obtener las actividades seleccionadas para la limpieza actual
$query_actividades_seleccionadas = $db->prepare('SELECT fk_actividad FROM limpieza_actividad WHERE fk_limpieza = :pk');
$query_actividades_seleccionadas->bindParam(':pk', $pk, PDO::PARAM_INT);
$query_actividades_seleccionadas->execute();
$actividades_seleccionadas = $query_actividades_seleccionadas->fetchAll(PDO::FETCH_COLUMN);
$query_mantenimiento = $db->prepare('SELECT mtto FROM limpieza WHERE pk_limpieza = :pk');
$query_mantenimiento->bindParam(':pk', $pk, PDO::PARAM_INT);
$query_mantenimiento->execute();
$result_mantenimiento = $query_mantenimiento->fetch();
$mtto_seleccionado = $result_mantenimiento['mtto'];


$observacion = $result['observacion'];

?>

<!DOCTYPE html>
<html>

<head>
    <title>Actualizar Limpieza</title>
    <link rel="icon" href="img/logo.png">
</head>

<body>
    <?php include 'header.php'; ?>
    <form action="funciones/editar/editar_limpieza.php" method="POST" class="custom-form">
        <h1>Actualizar Limpieza</h1>
        <input type="hidden" value="<?= $pk ?>" name="pk">

        <label for="fecha">Fecha de la limpieza:</label>
        <input value="<?= $result['fecha'] ?>" type="date" id="fecha" name="fecha" disabled>

        <label for="fk_habitacion" id="label_habitacion" style="<?= $habSelectStyle ?>">Habitación:</label>
        <select id="fk_habitacion" name="fk_habitacion" style="<?= $habSelectStyle ?>" disabled>
            <option value="">Seleccione una Habitación</option>
            <?php
            $query_habitacion = $db->prepare('SELECT * FROM habitacion');
            $query_habitacion->execute();
            $habitaciones = $query_habitacion->fetchAll();

            foreach ($habitaciones as $habitacion) :
            ?>
                <option value="<?= $habitacion['pk_habitacion'] ?>" <?= ($result['fk_habitacion'] == $habitacion['pk_habitacion']) ? 'selected' : '' ?>>
                    <?= $habitacion['num_habitacion'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="fk_area" id="label_area" style="<?= $areaSelectStyle ?>">Área:</label>
        <select id="fk_area" name="fk_area" style="<?= $areaSelectStyle ?>" disabled>
            <option value="">Seleccione una Área</option>
            <?php
            $query_area = $db->prepare('SELECT * FROM area');
            $query_area->execute();
            $areas = $query_area->fetchAll();
            foreach ($areas as $area) :
            ?>
                <option value="<?= $area['pk_area'] ?>" <?= ($result['fk_area'] == $area['pk_area']) ? 'selected' : '' ?>>
                    <?= $area['nombre_area'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Actividades realizadas:</label>
        <div class="panel-scroll">
            <div class="lista-checkboxes">
                <?php foreach ($actividad as $opciones) : ?>
                    <div class="opcion">
                        <div class="box-opcion">
                            <label for="<?= $opciones['pk_actividad'] ?>"><?= $opciones['nombre_actividad'] ?></label>
                        </div>
                        <div class="box-opcion">
                            <?php
                            $actividadSeleccionada = in_array($opciones['pk_actividad'], $actividades_seleccionadas) ? 'checked' : '';
                            ?>
                            <input class="check" id="<?= $opciones['pk_actividad'] ?>" name="nombre_actividad[]" type="checkbox" value="<?= $opciones['pk_actividad'] ?>" <?= $actividadSeleccionada ?>>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>

        <br>
        <label for="fk_empleado">Empleado:</label>
        <select id="fk_empleado" name="fk_empleado" required>
            <?php
            $query_empleado = $db->prepare('SELECT * FROM empleado');
            $query_empleado->execute();
            $empleados = $query_empleado->fetchAll();

            foreach ($empleados as $empleado) :
            ?>
                <option value="<?= $empleado['pk_empleado'] ?>" <?= ($result['fk_empleado'] == $empleado['pk_empleado']) ? 'selected' : '' ?>>
                    <?= $empleado['nombres'] . ' ' . $empleado['apaterno'] . ' ' . $empleado['amaterno'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="hora_inicio">Hora de inicio:</label>
        <input value="<?= $result['hora_inicio'] ?>" type="time" id="hora_inicio" name="hora_inicio" required>

        <label for="hora_fin">Hora de fin:</label>
        <input value="<?= $result['hora_fin'] ?>" type="time" id="hora_fin" name="hora_fin" required>

        <label>¿Se requiere mantenimiento?</label>
        <select name="mtto" id="mtto" onchange="obsrvcion()" required>
            <option value="">Seleccione una opcion</option>
            <option id="SI" value="Si" <?php echo ($result['mtto'] == 'Si') ? 'selected' : ''; ?>>Si</option>
            <option id="NO" value="No" <?php echo ($result['mtto'] == 'No') ? 'selected' : ''; ?>>No</option>
        </select>

        <label id="label_observacion" style="<?= $ValidObservacion ?>">Observaciones para mantenimiento:</label>
        <input type="text" id="observacion" name="observacion" value="<?= $result['observacion'] ?>" style="<?= $ValidObservacion ?>">

        <div class="cont_submit">
            <input type="submit" value="Actualizar Limpieza">
        </div>
    </form>

    <script>
        function obsrvcion() {
            var mtto = document.getElementById("mtto");
            var observacion = document.getElementById("observacion");
            var label_observacion = document.getElementById("label_observacion");

            if (mtto.value === 'Si') {
                observacion.style.display = 'block';
                label_observacion.style.display = 'block';
            } else {
                observacion.style.display = 'none';
                label_observacion.style.display = 'none';
            }
        }
    </script>

</body>

</html>