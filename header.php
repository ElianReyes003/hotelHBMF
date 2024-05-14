<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&family=Unbounded:wght@900&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <header>
  <a href="index.php"><img src="img/logo.jpg" alt="Logo de la Empresa"></a>
  <a href="index.php">INICIO</a>
  <a href="lista_habitaciones.php">LISTA HABITACIONES</a>
  <a href="lista_limpiezas.php">LISTA DE LIMPIEZAS</a>
  <a href="lista_mantenimientos.php">LISTA DE MANTENIMIENTOS</a>
  <div>
      <div class="dropdown">
          <button>MENÚ</button>
            <div class="dropdown-content">
              <a href="lista_areas.php">LISTA DE ÁREAS</a>
              <a href="lista_actividades.php">LISTA DE ACTIVIDADES</a>
              <a href="lista_empleados.php">LISTA DE EMPLEADOS</a>
            </div>
      </div>
      <div class="dropdown">
          <button class="button_bajas">BAJA</button>
            <div class="dropdown-content">
              <a href="lista_limpiezas_baja.php">LIMPIEZAS DADAS DE BAJA</a>
              <a href="lista_mantenimientos_baja.php">MANTENIMIENTOS DADOS DE BAJA</a>
              <a href="lista_actividades_baja.php">ACTIVIDADES DADAS DE BAJA</a>
              <a href="lista_areas_baja.php">ÁREAS DADAS DE BAJA</a>
              <a href="lista_habitaciones_baja.php">HABITACIONES DADAS DE BAJA</a>
              <a href="lista_empleados_baja.php">EMPLEADOS DADOS DE BAJA</a>
            </div>
      </div>
  </div>
  </header>
</body>
</html>