<?php

require_once('conexion/conexion.php');

$conexion = new Conexion();
$db = $conexion->conectar();

$query = $db->prepare("SELECT num_habitacion, pk_habitacion FROM habitacion WHERE estatus = '1'");
$query->execute();
$habitacion = $query->fetchAll();

$query = $db->prepare("SELECT nombre_area, pk_area FROM area WHERE estatus = '1'");
$query->execute();
$area = $query->fetchAll();

$query = $db->prepare("SELECT nombre_actividad, pk_actividad FROM actividad WHERE estatus = '1'");
$query->execute();
$actividad = $query->fetchAll();

$query = $db->prepare("SELECT nombres, apaterno, amaterno, pk_empleado FROM empleado WHERE estatus = '1'");
$query->execute();
$empleado = $query->fetchAll();

?>

<!DOCTYPE html>
<html>

<head>
    <title>Formulario de Registro de Limpieza</title>
    <link rel="icon" href="img/logo.png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <?php include 'header.php'; ?>
    <form action="funciones/registrar/registro_limpieza.php" method="post" class="custom-form" onsubmit="return validarFormulario()">
        <h1>Registro de Limpieza</h1>

        <label>Fecha:</label>
        <input type="date" id="fecha" name="fecha">

        <label id="label_habitacion">Habitación:</label>
        <select name="fk_habitacion" id="habitacionSelect" onchange="habilitarArea()">
            <option value="">Seleccione una Habitación</option>
            <?php
            foreach ($habitacion as $resultad => $value) {
            ?>
                <option value="<?php echo $value['pk_habitacion']; ?>">
                    <?php echo $value['num_habitacion']; ?>
                </option>
            <?php
            } ?>
        </select>

        <label id="label_area">Área:</label>
        <select name="fk_area" id="areaSelect" onchange="habilitarHabitacion()">
            <option value="">Seleccione una Área</option>
            <?php
            foreach ($area as $resultad => $value) {
            ?>
                <option value="<?php echo $value['pk_area']; ?>">
                    <?php echo $value['nombre_area']; ?>
                </option>
            <?php
            } ?>
        </select>

        <label>Actividades realizadas:</label>
        <ul class="cont_elements" name="fk_actividad">
            <?php foreach ($actividad as $opciones) : ?>
                <li class="subcont_elements">
                    <input name="nombre_actividad[]" type="checkbox" value="<?php echo $opciones['pk_actividad'] ?>">
                    <label><?= $opciones['nombre_actividad'] ?></label>
                </li>
            <?php endforeach ?>
        </ul>

        <label>Empleado:</label>
        <select name="fk_empleado">
            <option value="">Seleccione un Empleado</option>
            <?php
            foreach ($empleado as $resultad => $value) {
            ?>
                <option value="<?php echo $value['pk_empleado']; ?>">
                    <?php echo $value['nombres'] . ' ' . $value['apaterno'] . ' ' . $value['amaterno']; ?>
                </option>
            <?php
            } ?>
        </select>

        <label>Hora de inicio:</label>
        <input type="time" id="hora_inicio" name="hora_inicio">

        <label>Hora de fin:</label>
        <input type="time" id="hora_fin" name="hora_fin">

        <label>¿Se requiere mantenimiento?</label>
        <select name="mtto" id="mtto" onchange="obsrvcion()">
            <option value="">Seleccione una opcion</option>
            <option id="SI" value="Si">Si</option>
            <option id="NO" value="No">No</option>
        </select>

        <label id="label_observacion">Observaciones para mantenimiento:</label>
        <input type="text" id="observacion" name="observacion">

        <input type="submit" value="Registrar Limpieza">
    </form>

    <script>
        function validarFormulario() {
            var fecha = document.getElementById("fecha");
            var habitacionSelect = document.getElementById("habitacionSelect");
            var areaSelect = document.getElementById("areaSelect");
            var actividadesSeleccionadas = document.querySelectorAll("input[name='nombre_actividad[]']:checked");
            var empleado = document.querySelector("select[name='fk_empleado']");
            var horaInicio = document.getElementById("hora_inicio");
            var horaFin = document.getElementById("hora_fin");
            var mtto = document.getElementById("mtto");
            var observacion = document.getElementById("observacion");

            if (fecha.value === "" || (habitacionSelect.value === "" && areaSelect.value === "") || actividadesSeleccionadas.length === 0 || empleado.value === "" || horaInicio.value === "" || horaFin.value === "" || mtto.value === "") {
                Swal.fire({
                    icon: "warning",
                    position: 'top',
                    text: 'Por favor, complete todos los campos obligatorios.',
                    timer: '2000'
                });
                return false;
            }
            if (mtto.value === "Si" && observacion.value === "") {
                Swal.fire({
                    icon: "warning",
                    position: 'top',
                    text: 'Por favor, complete todos los campos obligatorios.',
                    timer: '2000'
                });
                return false;
            }

            return true;
        }

        function habilitarArea() {
            var habitacionSelect = document.getElementById("habitacionSelect");
            var areaSelect = document.getElementById("areaSelect");
            var label_habitacion = document.getElementById("label_habitacion");
            var label_area = document.getElementById("label_area");

            if (habitacionSelect.value === "") {
                areaSelect.style.display = 'block';
                label_area.style.display = 'block';
            } else {
                areaSelect.style.display = 'none';
                label_area.style.display = 'none';
            }
        }

        function habilitarHabitacion() {
            var habitacionSelect = document.getElementById("habitacionSelect");
            var areaSelect = document.getElementById("areaSelect");
            var label_habitacion = document.getElementById("label_habitacion");
            var label_area = document.getElementById("label_area");

            if (areaSelect.value === "") {
                habitacionSelect.style.display = 'block';
                label_habitacion.style.display = 'block';
            } else {
                habitacionSelect.style.display = 'none';
                label_habitacion.style.display = 'none';
            }
        }

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