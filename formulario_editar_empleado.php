<?php 
include ('conexion/conexion.php');
$conexion = new Conexion();
$db = $conexion->conectar();

$pk = $_GET['pk'];

$query = $db -> prepare('SELECT * FROM empleado WHERE pk_empleado='.$pk);
$query->execute();
$result = $query->fetch();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Actualizar Empleado</title>
    <link rel="icon" href="img/logo.png">
</head>
<body>
<?php include 'header.php'; ?>
<form action="funciones/editar/editar_empleado.php" method="POST" class="custom-form">
    <h1>Actualizar Empleado</h1>
    <input type="hidden" value="<?= $pk?>" name="pk">
    <label for="nombre_actividad">Nombre del empleado:</label>
    <input value="<?=$result['nombres']?>" type="text" id="nombres" name="nombres" required>
    <label for="nombre_actividad">Apellido paterno del empleado:</label>
    <input value="<?=$result['apaterno']?>" type="text" id="apaterno" name="apaterno" required>
    <label for="nombre_actividad">Apellido materno del empleado:</label>
    <input value="<?=$result['amaterno']?>" type="text" id="amaterno" name="amaterno" required>
    <label for="nombre_actividad">Contacto del empleado:</label>
    <input value="<?=$result['contacto']?>" type="text" id="contacto" name="contacto" required>
    <input type="hidden" name="estatus" value="1">
    <div class="cont_submit">
      <input type="submit" value="Actualizar Empleado">
    </div>
</form>
</body>
</html>
