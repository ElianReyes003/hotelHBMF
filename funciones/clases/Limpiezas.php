<?php
class Limpiezas {
    function __construct(){
        require_once('../../conexion/Conexion2.php');
        $this->conexion=new Conexion2();
    }function actualizar($pk_habitacion, $num_habitacion){
        $consulta="UPDATE habitacion SET num_habitacion= '{$num_habitacion}' WHERE pk_habitacion='{$pk_habitacion}'";
        $resultado=$this->conexion->query($consulta);
        return $resultado;
    }
    function baja($pk_limpieza){
        $consulta="UPDATE limpieza SET estatus=0 WHERE pk_limpieza='{$pk_limpieza}'";
        $resultado=$this->conexion->query($consulta);
        return $resultado;
    }
    function alta($pk_limpieza){
        $consulta="UPDATE limpieza SET estatus=1 WHERE pk_limpieza='{$pk_limpieza}'";
        $resultado=$this->conexion->query($consulta);
        return $resultado;
    }
}
?>