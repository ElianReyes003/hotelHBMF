<?php

class Conexion2 extends mysqli
{

    function __construct()
    {
        parent::__construct("localhost", "root", "", "bd_hbmf");
    }
}
?>