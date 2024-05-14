<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="icon" href="img/logo.png">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
<?php include 'header.php'; ?>
<!--Apartado botones - links-->
<section class="rgstrs">
    <a href="formulario_limpieza.php" class="reg_lpza" href="registro_limpieza.php" >
        <h3>Registrar limpieza</h3>
        <img class="img_box" src="img/lista.png" alt="logo de registro de limpieza">
    </a>
    <div class="reg_gen">
        <a href="formulario_mantenimiento.php" class="reg_mn">
            <h3>Registrar mantenimiento</h3>
            <img class="img_box" src="img/mantenimiento.png" alt="logo de registro de mantenimiento">
        </a>
        <a href="formulario_actividad.php" class="reg_ac">
            <h3>Registrar actividad</h3>
            <img class="img_box" src="img/limpieza.png" alt="logo de registro de actividad">
        </a>
    </div>
    <div class="reg_gen">
        <a href="formulario_habitacion.php" class="reg_hb">
            <h3>Registrar habitación</h3>
            <img class="img_box" src="img/habitacion.png" alt="logo de registro de habitacion">
        </a>
        <a href="formulario_area.php" class="reg_ar">
            <h3>Registrar área</h3>
            <img class="img_box" src="img/area.png" alt="logo de registro de area">
        </a>
        <a href="formulario_empleado.php" class="reg_em">
            <h3>Registrar empleado</h3>
            <img class="img_box" src="img/empleados.png" alt="logo de registro de empleado">
        </a>
    </div>
</section>


<script>
        // Función para mostrar u ocultar el div al hacer clic en el botón
        function toggleDiv() {
            var miDiv = document.getElementById('miDiv');
            miDiv.style.display = (miDiv.style.display === 'none' || miDiv.style.display === '') ? 'block' : 'none';
        }
        function toggleDiv2() {
            var miDiv = document.getElementById('miDiv2');
            miDiv.style.display = (miDiv.style.display === 'none' || miDiv.style.display === '') ? 'block' : 'none';
        }
    </script>

</body>
</html>