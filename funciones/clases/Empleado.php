<?php
class Empleado {
    function __construct(){
        require_once('../../conexion/Conexion2.php');
        $this->conexion=new Conexion2();
    }function actualizar($pk_empleado, $nombres, $apaterno, $amaterno, $contacto){
        $consulta="UPDATE empleado SET nombres= '{$nombres}', apaterno='{$apaterno}', amaterno='{$amaterno}', contacto='{$contacto}' WHERE pk_empleado='{$pk_empleado}'";
        $resultado=$this->conexion->query($consulta);
        return $resultado;
    }
    function baja($pk_empleado){
        $consulta="UPDATE empleado SET estatus=0 WHERE pk_empleado='{$pk_empleado}'";
        $resultado=$this->conexion->query($consulta);
        return $resultado;
    }
    function alta($pk_empleado){
        $consulta="UPDATE empleado SET estatus=1 WHERE pk_empleado='{$pk_empleado}'";
        $resultado=$this->conexion->query($consulta);
        return $resultado;
    }
}