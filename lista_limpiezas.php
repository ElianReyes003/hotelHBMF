<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Limpiezas</title>
    <link rel="icon" href="img/logo.png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
<div id="divExcluir">
<?php include 'header.php'; ?>
</div>
<section>
<div id="divExcluir" class='Filtrar'>
<h3>Filtrar por:</h3>
<div id="divExcluir"class="BotonesFiltro">
<button id="divExcluir" class='Filtros' onclick="toggleDiv4();cambiarValor('Lista de Limpiezas')">General</button>
<button id="divExcluir" class='Filtros' onclick="toggleDiv3();cambiarValor('Limpiezas realizadas el dia de hoy')">Hoy</button>
<button id="divExcluir" class='Filtros' onclick="toggleDiv();cambiarValor('Limpiezas realizadas el dia de ayer')">Ayer</button>
<button id="divExcluir" class='Filtros' onclick="toggleDiv2();cambiarValor('Limpiezas realizadas el dia de antier')">Antier</button>
<button id="divExcluir" class='Filtros Imprimir' onclick="imprimirPagina()">Imprimir</button>
</div>       
</div>

<hr >
<div>
<h2 id="titulo" class="h2listas">Limpiezas realizadas el dia de hoy</h2>
<hr>
</div>
<div id="miDiv4" style="display: none;">
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
WHERE li.estatus = 1
GROUP BY li.pk_limpieza";


    $stmt = $pdo->prepare($consulta);
    $stmt->execute();
    
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($resultados) > 0) {
        echo "<table id='miTabla'>";
        echo "<tr id='tbody'>";
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
            echo "<a onclick='confirmarBaja(" . $pk_limpieza . ")'><img style='cursor: pointer;' src='img/eliminar.png' width='35' height='35'></a>";
            echo "</td>";
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

<div id="miDiv3" style="display: block;">
<?php

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
WHERE li.estatus = 1 AND DATE(li.fecha) = CURDATE()
GROUP BY li.pk_limpieza";


    $stmt = $pdo->prepare($consulta);
    $stmt->execute();

    // Inicializar la variable con un valor predeterminado

    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($resultados) > 0) {
       
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
            echo "<a onclick='confirmarBaja(" . $pk_limpieza . ")'><img style='cursor: pointer;' src='img/eliminar.png' width='35' height='35'></a>";
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


<div id="miDiv" style="display: none;">
<?php

//Registros de ayer
try {
    $conexion = new Conexion();
    $pdo = $conexion->conectar();
$consulta2 = "SELECT li.folio, li.fecha, hb.num_habitacion, ar.nombre_area,GROUP_CONCAT(ac.nombre_actividad) AS actividades, 
em.nombres, li.hora_inicio, li.hora_fin, li.tiempo, li.mtto, li.pk_limpieza, li.observacion
FROM limpieza li
LEFT JOIN habitacion hb ON li.fk_habitacion = hb.pk_habitacion
LEFT JOIN area ar ON li.fk_area = ar.pk_area
INNER JOIN limpieza_actividad la ON la.fk_limpieza = li.pk_limpieza
INNER JOIN actividad ac ON la.fk_actividad = ac.pk_actividad
INNER JOIN empleado em ON li.fk_empleado = em.pk_empleado
WHERE li.estatus = 1 AND DATE(li.fecha) =  CURDATE() - INTERVAL 1 DAY
GROUP BY li.pk_limpieza";


    $stmtt = $pdo->prepare($consulta2);
    $stmtt->execute();

    $resulta2 = $stmtt->fetchAll(PDO::FETCH_ASSOC);
    if (count($resulta2) > 0) {
       
        echo "<table id='miTabla'>";
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

        foreach ($resulta2 as $fil) {
            echo "<tr>";
            echo "<td>{$fil['folio']}</td>";
            echo "<td>{$fil['fecha']}</td>";
            if (!empty($fil['num_habitacion'])) {
                echo "<td>{$fil['num_habitacion']}</td>";
            } else {
                echo "<td>------</td>"; 
            }
            if (!empty($fil['nombre_area'])) {
                echo "<td>{$fil['nombre_area']}</td>";
            } else {
                echo "<td>------</td>";
            }
            echo "<td>{$fil['actividades']}</td>"; 
            echo "<td>{$fil['nombres']}</td>";
            echo "<td>" . date("h:i a", strtotime($fil['hora_inicio'])) . "</td>";
            echo "<td>" . date("h:i a", strtotime($fil['hora_fin'])) . "</td>"; 
            echo "<td>{$fil['tiempo']}</td>";
            echo "<td>{$fil['mtto']}</td>";
            echo "<td>";
            if($fil['observacion']==''){
                echo "------";
            }else{
                echo "{$fil['observacion']}";
            }
            echo "</td>";
            echo "<td>";
            $pk_limpieza = $fil ['pk_limpieza'];
            echo "<a href='formulario_editar_limpieza.php?pk={$pk_limpieza}'><img src='img/actualizar.png' width='35' height='35'></a>";
            echo "<a onclick='confirmarBaja(" . $pk_limpieza . ")'><img style='cursor: pointer;' src='img/eliminar.png' width='35' height='35'></a>";
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

<div id="miDiv2" style="display: none;">
<?php

//Registros de antier
try {
    $conexion = new Conexion();
    $pdo = $conexion->conectar();
$consulta2 = "SELECT li.folio, li.fecha, hb.num_habitacion, ar.nombre_area,GROUP_CONCAT(ac.nombre_actividad) AS actividades, 
em.nombres, li.hora_inicio, li.hora_fin, li.tiempo, li.mtto, li.pk_limpieza, li.observacion
FROM limpieza li
LEFT JOIN habitacion hb ON li.fk_habitacion = hb.pk_habitacion
LEFT JOIN area ar ON li.fk_area = ar.pk_area
INNER JOIN limpieza_actividad la ON la.fk_limpieza = li.pk_limpieza
INNER JOIN actividad ac ON la.fk_actividad = ac.pk_actividad
INNER JOIN empleado em ON li.fk_empleado = em.pk_empleado
WHERE li.estatus = 1 AND DATE(li.fecha) =  CURDATE() - INTERVAL 2 DAY
GROUP BY li.pk_limpieza";


    $stmtt = $pdo->prepare($consulta2);
    $stmtt->execute();

    $resulta2 = $stmtt->fetchAll(PDO::FETCH_ASSOC);
    if (count($resulta2) > 0) {
       
        echo "<table id='miTabla'>";
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

        foreach ($resulta2 as $fil) {
            echo "<tr>";
            echo "<td>{$fil['folio']}</td>";
            echo "<td>{$fil['fecha']}</td>";
            if (!empty($fil['num_habitacion'])) {
                echo "<td>{$fil['num_habitacion']}</td>";
            } else {
                echo "<td>------</td>"; 
            }
            if (!empty($fil['nombre_area'])) {
                echo "<td>{$fil['nombre_area']}</td>";
            } else {
                echo "<td>------</td>";
            }
            echo "<td>{$fil['actividades']}</td>"; 
            echo "<td>{$fil['nombres']}</td>";
            echo "<td>" . date("h:i a", strtotime($fil['hora_inicio'])) . "</td>";
            echo "<td>" . date("h:i a", strtotime($fil['hora_fin'])) . "</td>"; 
            echo "<td>{$fil['tiempo']}</td>";
            echo "<td>{$fil['mtto']}</td>";
            echo "<td>";
            if($fil['observacion']==''){
                echo "------";
            }else{
                echo "{$fil['observacion']}";
            }
            echo "</td>";
            echo "<td>";
            $pk_limpieza = $fil ['pk_limpieza'];
            echo "<a href='formulario_editar_limpieza.php?pk={$pk_limpieza}'><img src='img/actualizar.png' width='35' height='35'></a>";
            echo "<a onclick='confirmarBaja(" . $pk_limpieza . ")'><img style='cursor: pointer;' src='img/eliminar.png' width='35' height='35'></a>";
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
    function confirmarBaja(pk_limpieza) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción dará de baja la limpieza. ¿Deseas continuar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, dar de baja',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'funciones/eliminar/eliminar_limpiezas.php?pk_limpieza='+pk_limpieza
        } 
    });
    }       
 
// Función para mostrar u ocultar el div al hacer clic en el botón
        function toggleDiv() {
            var miDiv3 = document.getElementById('miDiv3');
            var miDiv4 = document.getElementById('miDiv4');
            var miDiv = document.getElementById('miDiv');
            var miDiv2 = document.getElementById('miDiv2');

        miDiv.style.display = (miDiv.style.display === 'none' || miDiv.style.display === '') ? 'block' : 'none';

        miDiv4.style.display = 'none';
        miDiv3.style.display = 'none';
        miDiv2.style.display = 'none';
        }
        
        function toggleDiv2() {
            var miDiv3 = document.getElementById('miDiv3');
            var miDiv4 = document.getElementById('miDiv4');
            var miDiv = document.getElementById('miDiv');
            var miDiv2 = document.getElementById('miDiv2');

        miDiv2.style.display = (miDiv2.style.display === 'none' || miDiv2.style.display === '') ? 'block' : 'none';

        miDiv4.style.display = 'none';
        miDiv3.style.display = 'none';
        miDiv.style.display = 'none';
        }
        function toggleDiv3() {
            var miDiv3 = document.getElementById('miDiv3');
            var miDiv4 = document.getElementById('miDiv4');
            var miDiv = document.getElementById('miDiv');
            var miDiv2 = document.getElementById('miDiv2');

        miDiv3.style.display = (miDiv3.style.display === 'none' || miDiv3.style.display === '') ? 'block' : 'none';

        miDiv4.style.display = 'none';
        miDiv.style.display = 'none';
        miDiv2.style.display = 'none';
        }
        function toggleDiv4() {
            var miDiv3 = document.getElementById('miDiv3');
            var miDiv4 = document.getElementById('miDiv4');
            var miDiv = document.getElementById('miDiv');
            var miDiv2 = document.getElementById('miDiv2');

        miDiv4.style.display = (miDiv4.style.display === 'none' || miDiv4.style.display === '') ? 'block' : 'none';

        miDiv3.style.display = 'none';
        miDiv.style.display = 'none';
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