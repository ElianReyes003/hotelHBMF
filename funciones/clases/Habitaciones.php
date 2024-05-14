<?php
class Habitaciones {
    function __construct(){
        require_once('../../conexion/Conexion2.php');
        $this->conexion=new Conexion2();
    }function actualizar($pk_habitacion, $num_habitacion){
        $consulta="UPDATE habitacion SET num_habitacion= '{$num_habitacion}' WHERE pk_habitacion='{$pk_habitacion}'";
        $resultado=$this->conexion->query($consulta);
        return $resultado;
    }
    function baja($pk_habitacion){
        $consulta="UPDATE habitacion SET estatus=0 WHERE pk_habitacion='{$pk_habitacion}'";
        $resultado=$this->conexion->query($consulta);
        return $resultado;
    }
    function alta($pk_habitacion){
        $consulta="UPDATE habitacion SET estatus=1 WHERE pk_habitacion='{$pk_habitacion}'";
        $resultado=$this->conexion->query($consulta);
        return $resultado;
    }
}
?>