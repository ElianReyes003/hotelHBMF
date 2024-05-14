<?php
class Mantenimiento {
    function __construct(){
        require_once('../../conexion/Conexion2.php');
        $this->conexion=new Conexion2();
    }
    function baja($pk_mantenimiento){
        $consulta="UPDATE mantenimiento SET estatus=0 WHERE pk_mantenimiento='{$pk_mantenimiento}'";
        $resultado=$this->conexion->query($consulta);
        return $resultado;
    }
    function alta($pk_mantenimiento){
        $consulta="UPDATE mantenimiento SET estatus=1 WHERE pk_mantenimiento='{$pk_mantenimiento}'";
        $resultado=$this->conexion->query($consulta);
        return $resultado;
    }
}
?>