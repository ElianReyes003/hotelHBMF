<?php
include('conexion/conexion.php');
$conexion = new Conexion();
$db = $conexion->conectar();
$pk_mantenimiento = $_GET['pk'];

$query = $db->prepare('SELECT * FROM mantenimiento 
INNER JOIN limpieza li ON fk_limpieza = li.pk_limpieza
WHERE pk_mantenimiento = :pk_mantenimiento');

$query->bindParam(':pk_mantenimiento', $pk_mantenimiento, PDO::PARAM_INT);
$query->execute();
$result = $query->fetch(); 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Actualizar Mantenimiento</title>
    <link rel="icon" href="img/logo.png">
</head>
<body>
<?php include 'header.php'; ?>
<form action="funciones/editar/editar_mantenimiento.php" method="post" class="custom-form">
    <h1>Actualizar Mantenimiento</h1>
    <input type="hidden" value="<?= $pk_mantenimiento?>" name="pk_mantenimiento">

    <label>Folio del mantenimiento:</label>
    <input value="<?=$result['folio_mant']?>" type="text" disabled name="folio_mant">

    <label>Limpieza:</label>
    <select disabled>
    <?php
    $query_limpieza = $db->prepare('SELECT * FROM limpieza');
    $query_limpieza->execute();
    $limpiezas = $query_limpieza->fetchAll();
    foreach ($limpiezas as $limpieza):
    ?>
    <option value="<?= $area['pk_limpieza'] ?>" <?= ($result['fk_limpieza'] == $limpieza['pk_limpieza']) ? 'selected' : '' ?>>
    <?= $limpieza['folio'] ?>
    </option>
    <?php endforeach; ?>
    </select>

    <label>Fecha de mantenimiento:</label>
    <input value="<?=$result['fecha_mant']?>" type="date" name="fecha">

    <label>Observaciones:</label>
    <input value="<?=$result['observaciones_mant']?>" type="text" name="observaciones">

    <label>Persona a cargo:</label>
    <input value="<?=$result['persona_cargo']?>" type="text" name="persona_cargo">

    <label>Hora de inicio:</label>
    <input value="<?=$result['hora_inicio_mant']?>" type="time" name="hora_inicio">

    <label>Hora de fin:</label>
    <input value="<?=$result['hora_fin_mant']?>" type="time" name="hora_fin">

    <div class="cont_submit">
        <input type="submit" value="Actualizar Mantenimiento">  
    </div>
</form>
</body>
</html>
