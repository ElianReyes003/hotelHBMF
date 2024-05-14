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
  
     // Prepara la consulta SQL
     $consulta = "SELECT pk_mantenimiento, fecha_mant, folio_mant, persona_cargo, hora_inicio_mant, hora_fin_mant,tiempo_mant, observaciones_mant, 
     li.folio AS folio_limp FROM mantenimiento mn
     INNER JOIN limpieza li ON mn.fk_limpieza = li.pk_limpieza WHERE mn.estatus=0";
     $consulta= $pdo->prepare($consulta);
     $consulta->execute();
     
     // Recupera los resultados
     $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
     
     // Verifica si hay datos
     if (count($resultados) > 0) {
         echo "<h2 class='h2listas'>Lista de Mantenimientos</h2>";
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
             echo "<a href='./funciones/alta/alta_mantenimiento.php?pk_mantenimiento={$pk_mantenimiento}'><img src='img/alta.png' width='35' height='35'></a>";
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