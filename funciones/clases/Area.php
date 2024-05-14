<?php
class Area {
    function __construct(){
        require_once('../../conexion/Conexion2.php');
        $this->conexion=new Conexion2();
    }
    function actualizar($pk_area, $nombre_area){
        $consulta="UPDATE area SET nombre_area= '{$nombre_area}' WHERE pk_area='{$pk_area}'";
        $resultado=$this->conexion->query($consulta);
        return $resultado;
        
    }
    function baja($pk_area){
        $consulta="UPDATE area SET estatus=0 WHERE pk_area='{$pk_area}'";
        $resultado=$this->conexion->query($consulta);
        return $resultado;
    }
    function alta($pk_area){
        $consulta="UPDATE area SET estatus=1 WHERE pk_area='{$pk_area}'";
        $resultado=$this->conexion->query($consulta);
        return $resultado;
    }
    }
?>