<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Mantenimientos</title>
    <link rel="icon" href="img/logo.png">
</head>
<body>
<div id="divExcluir">
<?php include 'header.php'; ?>
</div>
<section>
<div id="divExcluir" class='Filtrar'>
<h3>Filtrar por:</h3>
<div id="divExcluir"class="BotonesFiltro">
<button id="divExcluir" class='Filtros' onclick="toggleDiv();cambiarValor('Lista de Mantenimientos')">General</button>
<button id="divExcluir" class='Filtros' onclick="toggleDiv1();cambiarValor('Mantenimientos realizados el dia de hoy')">Hoy</button>
<button id="divExcluir" class='Filtros' onclick="toggleDiv2();cambiarValor('Mantenimientos realizados el dia de ayer')">Ayer</button>
<button id="divExcluir" class='Filtros' onclick="toggleDiv3();cambiarValor('Mantenimientos realizados el dia de antier')">Antier</button>
<button id="divExcluir" class='Filtros Imprimir' onclick="imprimirPagina()">Imprimir</button>
</div>       
</div>
<hr>
<div>
<h2 id="titulo" class="h2listas">Mantenimientos realizados el día de hoy</h2>
<hr>
</div>

<div id="miDiv" style="display: none;">
<?php
// Incluye el archivo de conexión
require 'conexion/conexion.php';

try {
    // Crear una instancia de la clase de conexión
    $conexion = new Conexion();
    // Conecta a la base de datos
    $pdo = $conexion->conectar();
    // Prepara la consulta SQL
    $consulta = "SELECT pk_mantenimiento, fecha_mant, folio_mant, persona_cargo, hora_inicio_mant, hora_fin_mant,tiempo_mant, observaciones_mant,
    li.folio AS folio_limp FROM mantenimiento mn
    INNER JOIN limpieza li ON mn.fk_limpieza = li.pk_limpieza WHERE mn.estatus=1";
    $man= $pdo->prepare($consulta);
    $man->execute();
    // Recupera los resultados
    $resultados = $man->fetchAll(PDO::FETCH_ASSOC);
    // Verifica si hay datos
    if (count($resultados) > 0) {
        echo "<table id='miTabla'>";
        echo "<tr>";
        echo "<th>Folio</th>";
        echo "<th>Limpieza</th>";
        echo "<th>Fecha</th>";
        echo "<th>Persona a cargo</th>";
        echo "<th>Hora de inicio</th>";
        echo "<th>Hora de fin</th>";
        echo "<th>Duración</th>";
        echo "<th>Observaciones</th>";
        echo "<th>ACCIONES</th>";
        echo "</tr>";

        foreach ($resultados as $fila) {
            echo "<tr>";
            echo "<td>{$fila['folio_mant']}</td>";
            echo "<td>{$fila['folio_limp']}</td>";
            echo "<td>{$fila['fecha_mant']}</td>";
            echo "<td>{$fila['persona_cargo']}</td>";
            echo "<td>" . date("h:i a", strtotime($fila['hora_inicio_mant'])) . "</td>";
            echo "<td>" . date("h:i a", strtotime($fila['hora_fin_mant'])) . "</td>";  
            echo "<td>{$fila['tiempo_mant']}</td>";
            echo "<td>{$fila['observaciones_mant']}</td>";
            echo "<td>";
            $pk_mantenimiento = $fila ['pk_mantenimiento'];
            echo "<a href='formulario_editar_mantenimiento.php?pk={$pk_mantenimiento}'><img src='img/actualizar.png' width='35' height='35'></a>";
            echo "<a onclick='confirmarBaja(" . $pk_mantenimiento . ")'><img style='cursor: pointer;' src='img/eliminar.png' width='35' height='35'></a>";            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<div id='divExcluir'>";
        echo "<div id='paginacion'></div>";
        echo "</div>";

        echo "<script src='css/paginacion.js'></script>";
    } else {
        echo "<div class='no-registros'>No se encontraron registros.</div>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
</div>

<div id="miDiv1" style="display: block;">
<?php
// Incluye el archivo de conexión

try {
    // Crear una instancia de la clase de conexión
    $conexion = new Conexion();
    // Conecta a la base de datos
    $pdo = $conexion->conectar();
    // Prepara la consulta SQL
    $consulta = "SELECT pk_mantenimiento, fecha_mant, folio_mant, persona_cargo, hora_inicio_mant, hora_fin_mant,tiempo_mant, observaciones_mant,
    li.folio AS folio_limp FROM mantenimiento mn
    INNER JOIN limpieza li ON mn.fk_limpieza = li.pk_limpieza WHERE mn.estatus=1 AND DATE(fecha_mant) = CURDATE()";

    $mant= $pdo->prepare($consulta);
    $mant->execute();
    // Recupera los resultados
    $resultados = $mant->fetchAll(PDO::FETCH_ASSOC);
    // Verifica si hay datos
    if (count($resultados) > 0) {
        echo "<table>";
        echo "<tr>";
        echo "<th>Folio</th>";
        echo "<th>Limpieza</th>";
        echo "<th>Fecha</th>";
        echo "<th>Persona a cargo</th>";
        echo "<th>Hora de inicio</th>";
        echo "<th>Hora de fin</th>";
        echo "<th>Duración</th>";
        echo "<th>Observaciones</th>";
        echo "<th>ACCIONES</th>";
        echo "</tr>";

        foreach ($resultados as $fila) {
            echo "<tr>";
            echo "<td>{$fila['folio_mant']}</td>";
            echo "<td>{$fila['folio_limp']}</td>";
            echo "<td>{$fila['fecha_mant']}</td>";
            echo "<td>{$fila['persona_cargo']}</td>";
            echo "<td>" . date("h:i a", strtotime($fila['hora_inicio_mant'])) . "</td>";
            echo "<td>" . date("h:i a", strtotime($fila['hora_fin_mant'])) . "</td>";  
            echo "<td>{$fila['tiempo_mant']}</td>";
            echo "<td>{$fila['observaciones_mant']}</td>";
            echo "<td>";
            $pk_mantenimiento = $fila ['pk_mantenimiento'];
            echo "<a href='formulario_editar_mantenimiento.php?pk={$pk_mantenimiento}'><img src='img/actualizar.png' width='35' height='35'></a>";
            echo "<a onclick='confirmarBaja(" . $pk_mantenimiento . ")'><img style='cursor: pointer;' src='img/eliminar.png' width='35' height='35'></a>";            echo "</td>";
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
</div>

<div id="miDiv2" style="display: none;">
<?php
// Incluye el archivo de conexión

try {
    // Crear una instancia de la clase de conexión
    $conexion = new Conexion();
    // Conecta a la base de datos
    $pdo = $conexion->conectar();
    // Prepara la consulta SQL
    $consulta = "SELECT pk_mantenimiento, fecha_mant, folio_mant, persona_cargo, hora_inicio_mant, hora_fin_mant,tiempo_mant, observaciones_mant,
    li.folio AS folio_limp FROM mantenimiento mn
    INNER JOIN limpieza li ON mn.fk_limpieza = li.pk_limpieza WHERE mn.estatus=1 AND DATE(fecha_mant) = CURDATE() - INTERVAL 1 DAY";

    $mant= $pdo->prepare($consulta);
    $mant->execute();
    // Recupera los resultados
    $resultados = $mant->fetchAll(PDO::FETCH_ASSOC);
    // Verifica si hay datos
    if (count($resultados) > 0) {
        echo "<hr>";
        echo "<table>";
        echo "<tr>";
        echo "<th>Folio</th>";
        echo "<th>Limpieza</th>";
        echo "<th>Fecha</th>";
        echo "<th>Persona a cargo</th>";
        echo "<th>Hora de inicio</th>";
        echo "<th>Hora de fin</th>";
        echo "<th>Duración</th>";
        echo "<th>Observaciones</th>";
        echo "<th>ACCIONES</th>";
        echo "</tr>";

        foreach ($resultados as $fila) {
            echo "<tr>";
            echo "<td>{$fila['folio_mant']}</td>";
            echo "<td>{$fila['folio_limp']}</td>";
            echo "<td>{$fila['fecha_mant']}</td>";
            echo "<td>{$fila['persona_cargo']}</td>";
            echo "<td>" . date("h:i a", strtotime($fila['hora_inicio_mant'])) . "</td>";
            echo "<td>" . date("h:i a", strtotime($fila['hora_fin_mant'])) . "</td>";  
            echo "<td>{$fila['tiempo_mant']}</td>";
            echo "<td>{$fila['observaciones_mant']}</td>";
            echo "<td>";
            $pk_mantenimiento = $fila ['pk_mantenimiento'];
            echo "<a href='formulario_editar_mantenimiento.php?pk={$pk_mantenimiento}'><img src='img/actualizar.png' width='35' height='35'></a>";
            echo "<a onclick='confirmarBaja(" . $pk_mantenimiento . ")'><img style='cursor: pointer;' src='img/eliminar.png' width='35' height='35'></a>";
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
</div>

<div id="miDiv3" style="display: none;">
<?php
// Incluye el archivo de conexión

try {
    // Crear una instancia de la clase de conexión
    $conexion = new Conexion();
    // Conecta a la base de datos
    $pdo = $conexion->conectar();
    // Prepara la consulta SQL
    $consulta = "SELECT pk_mantenimiento, fecha_mant, folio_mant, persona_cargo, hora_inicio_mant, hora_fin_mant,tiempo_mant, observaciones_mant,
    li.folio AS folio_limp FROM mantenimiento mn
    INNER JOIN limpieza li ON mn.fk_limpieza = li.pk_limpieza WHERE mn.estatus=1 AND DATE(fecha_mant) = CURDATE() - INTERVAL 2 DAY";

    $mant= $pdo->prepare($consulta);
    $mant->execute();
    // Recupera los resultados
    $resultados = $mant->fetchAll(PDO::FETCH_ASSOC);
    // Verifica si hay datos
    if (count($resultados) > 0) {
        echo "<hr>";
        echo "<table>";
        echo "<tr>";
        echo "<th>Folio</th>";
        echo "<th>Limpieza</th>";
        echo "<th>Fecha</th>";
        echo "<th>Persona a cargo</th>";
        echo "<th>Hora de inicio</th>";
        echo "<th>Hora de fin</th>";
        echo "<th>Duración</th>";
        echo "<th>Observaciones</th>";
        echo "<th>ACCIONES</th>";
        echo "</tr>";

        foreach ($resultados as $fila) {
            echo "<tr>";
            echo "<td>{$fila['folio_mant']}</td>";
            echo "<td>{$fila['folio_limp']}</td>";
            echo "<td>{$fila['fecha_mant']}</td>";
            echo "<td>{$fila['persona_cargo']}</td>";
            echo "<td>" . date("h:i a", strtotime($fila['hora_inicio_mant'])) . "</td>";
            echo "<td>" . date("h:i a", strtotime($fila['hora_fin_mant'])) . "</td>";  
            echo "<td>{$fila['tiempo_mant']}</td>";
            echo "<td>{$fila['observaciones_mant']}</td>";
            echo "<td>";
            $pk_mantenimiento = $fila ['pk_mantenimiento'];
            echo "<a href='formulario_editar_mantenimiento.php?pk={$pk_mantenimiento}'><img src='img/actualizar.png' width='35' height='35'></a>";
            echo "<a onclick='confirmarBaja(" . $pk_mantenimiento . ")'><img style='cursor: pointer;' src='img/eliminar.png' width='35' height='35'></a>";            echo "</td>";
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
</div>

<style>
        /* Estilos normales que se aplican en la pantalla */
        #divExcluir {
        }

        /* Estilos específicos para la impresión */
        @media print {
            #divExcluir {
                display: none; /* Oculta el div al imprimir */
            }

            /* Oculta la última columna de la tabla al imprimir */
            table tr th:last-child,
            table tr td:last-child {
                display: none;
            }
        }
    </style>
<script>
     function confirmarBaja(pk_mantenimiento) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción dará de baja el mantenimiento. ¿Deseas continuar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, dar de baja',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'funciones/eliminar/eliminar_mantenimiento.php?pk_mantenimiento='+pk_mantenimiento
        } 
    });
    }   

        function toggleDiv() {
            var miDiv = document.getElementById('miDiv');
            var miDiv1 = document.getElementById('miDiv1');
            var miDiv2 = document.getElementById('miDiv2');
            var miDiv3 = document.getElementById('miDiv3');

        miDiv.style.display = (miDiv.style.display === 'none' || miDiv.style.display === '') ? 'block' : 'none';

        miDiv1.style.display = 'none';
        miDiv2.style.display = 'none';
        miDiv3.style.display = 'none';
        }
        
        function toggleDiv1() {
            var miDiv = document.getElementById('miDiv');
            var miDiv1 = document.getElementById('miDiv1');
            var miDiv2 = document.getElementById('miDiv2');
            var miDiv3 = document.getElementById('miDiv3');

        miDiv1.style.display = (miDiv1.style.display === 'none' || miDiv1.style.display === '') ? 'block' : 'none';

        miDiv.style.display = 'none';
        miDiv2.style.display = 'none';
        miDiv3.style.display = 'none';
        }
        function toggleDiv2() {
            var miDiv = document.getElementById('miDiv');
            var miDiv1 = document.getElementById('miDiv1');
            var miDiv2 = document.getElementById('miDiv2');
            var miDiv3 = document.getElementById('miDiv3');

        miDiv2.style.display = (miDiv2.style.display === 'none' || miDiv2.style.display === '') ? 'block' : 'none';

        miDiv.style.display = 'none';
        miDiv1.style.display = 'none';
        miDiv3.style.display = 'none';
        }
        function toggleDiv3() {
            var miDiv = document.getElementById('miDiv');
            var miDiv1 = document.getElementById('miDiv1');
            var miDiv2 = document.getElementById('miDiv2');
            var miDiv3 = document.getElementById('miDiv3');

        miDiv3.style.display = (miDiv3.style.display === 'none' || miDiv3.style.display === '') ? 'block' : 'none';

        miDiv.style.display = 'none';
        miDiv1.style.display = 'none';
        miDiv2.style.display = 'none';
        }
        function cambiarValor(nuevoValor) {
        document.getElementById("titulo").innerHTML = nuevoValor;
        }
        function imprimirPagina() {
        window.print();
        }
    </script>  
    <br>
    <br>
</body>
</html>