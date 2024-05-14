<?php 
include ('conexion/conexion.php');
$conexion = new Conexion();
$db = $conexion->conectar();

$pk = $_GET['pk'];

$query = $db -> prepare('SELECT * FROM habitacion hb INNER JOIN area ar ON hb.fk_area = ar.pk_area WHERE pk_habitacion='.$pk);
$query->execute();
$result = $query->fetch();

$query = $db -> prepare('SELECT * FROM area');
$query->execute();
$result2 = $query->fetchAll();

$query = $db -> prepare('SELECT * FROM empleado');
$query->execute();
$result3 = $query->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Actualizar Habitación</title>
    <link rel="icon" href="img/logo.png">
</head>
<body>
<?php include 'header.php'; ?>
<form action="funciones/editar/editar_habitacion.php" method="POST" class="custom-form">
    <h1>Actualizar Habitación</h1>
    <input type="hidden" value="<?= $pk?>" name="pk">
    <label for="nombre_actividad">Numero de la habitación:</label>
    <input value="<?=$result['num_habitacion']?>" type="text" name="num_habitacion" required>
    <label>¿En que estado se encuentra la habitación?</label>
    <select name="estado" id="estado">
        <option value="<?= $result['estado']?>"> <?= $result['estado']?></option>
        <option id="Disponible" value="Disponible">Disponible</option>
        <option id="En limpieza" value="En limpieza">En limpieza</option>
        <option id="En mantenimiento" value="En mantenimiento">En mantenimiento</option>
        <option id="Indispuesta" value="Indispuesta">Indispuesta</option>
    </select>
    <label for="nombre_actividad">Área:</label>
    <select class="form-control" name="fk_area">
    <option value="<?= $result['fk_area']?>"> <?= $result['nombre_area']?> </option>
    <?php 
    foreach ($result2 as $opciones):
    ?>
    <option value="<?php echo $opciones['pk_area']?>">
    <?php echo $opciones['nombre_area']?></option>
    <?php endforeach?>
    </select>

    <label>Empleado que verifico la habitación</label>
    <select name="fk_empleado" id="fk_empleado" required>
        <option value="">Seleccione un empleado</option>
    <?php 
    foreach ($result3 as $opciones):
    ?>
    <option value="<?php echo $opciones['pk_empleado']?>">
    <?php echo $opciones['nombres']?></option>
    <?php endforeach?>
    </select>
    
    <label>Fecha:</label>
    <input type="date" name="fecha_ver" required>

    <input type="hidden" name="estatus" value="1">
    <input type="submit" value="Actualizar Habitación">
</form>
</body>
</html>
