<?php 
include ('conexion/conexion.php');
$conexion = new Conexion();
$db = $conexion->conectar();

$pk = $_GET['pk'];

$query = $db -> prepare('SELECT * FROM area WHERE pk_area='.$pk);
$query->execute();
$result = $query->fetch();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Actualizar Área</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="icon" href="img/logo.png">
</head>
<body>
<?php include 'header.php'; ?>
<form action="funciones/editar/editar_area.php" method="POST" class="custom-form">
    <h1>Actualizar Área</h1>
    <input type="hidden" value="<?= $pk?>" name="pk">
    <label for="nombre_area">Nombre de la Área:</label>
    <input value="<?=$result['nombre_area']?>" type="text" id="nombre_area" name="nombre_area" required>
    <input type="hidden" name="estatus" value="1">
    <div class="cont_submit">
        <input type="submit" value="Actualizar Área">
    </div>
</form>
</body>
</html>


