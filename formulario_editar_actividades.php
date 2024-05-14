<?php 
include ('conexion/conexion.php');
$conexion = new Conexion();
$db = $conexion->conectar();

$pk = $_GET['pk'];

$query = $db -> prepare('SELECT * FROM actividad WHERE pk_actividad='.$pk);
$query->execute();
$result = $query->fetch();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Actualizar Actividad</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="icon" href="img/logo.png">
</head>
<body>
<?php include 'header.php'; ?>
<form action="funciones/editar/editar_actividad.php" method="POST" class="custom-form">
    <h1>Actualizar Actividad</h1>
    <input type="hidden" value="<?= $pk?>" name="pk">
    <label for="nombre_actividad">Nombre de la Actividad:</label>
    <input value="<?=$result['nombre_actividad']?>" type="text" id="nombre_actividad" name="nombre_actividad" required>
    <input type="hidden" name="estatus" value="1">
    <div class="cont_submit">
        <input type="submit" value="Actualizar Actividad">
    </div>
</form>
</body>
</html>

