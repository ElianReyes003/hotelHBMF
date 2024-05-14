<?php
class Actividad {
    function __construct(){
        require_once('../../conexion/Conexion2.php');
        $this->conexion=new Conexion2();
    }
    function actualizar($pk_actividad, $nombre_actividad){
        $consulta="UPDATE actividad SET nombre_actividad= '{$nombre_actividad}' WHERE pk_actividad='{$pk_actividad}'";
        $resultado=$this->conexion->query($consulta);
        return $resultado;
    }
    function mostrar(){
        $consulta="SELECT * FROM actividad WHERE estatus=1;";
        $resultado=$this->conexion->query($consulta);
        return $resultado;
    }function mostrarPorId($pk_actividad){
        $consulta="SELECT * FROM actividad WHERE pk_actividad='{$pk_actividad}'";
        $resultado=$this->conexion->query($consulta);
        return $resultado;
    }
    function baja($pk_actividad){
        $consulta="UPDATE actividad SET estatus=0 WHERE pk_actividad='{$pk_actividad}'";
        $resultado=$this->conexion->query($consulta);
        return $resultado;
    }
    function alta($pk_actividad){
        $consulta="UPDATE actividad SET estatus=1 WHERE pk_actividad='{$pk_actividad}'";
        $resultado=$this->conexion->query($consulta);
        return $resultado;
    }
    function obtenerDatosDeLaActividad($pk_actividad) {
        $consulta = "SELECT * FROM actividad WHERE pk_actividad = '{$pk_actividad}'";
        $resultado = $this->conexion->query($consulta);

        if ($resultado && $resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            return $fila; // Devuelve los datos de la actividad como un array asociativo
        } else {
            return null; // En caso de que no se encuentren datos
        }
    }
}
?>