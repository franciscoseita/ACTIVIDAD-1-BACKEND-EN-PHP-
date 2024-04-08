<?php
    $db_host = 'localhost';
    $db_username= 'sysAdm';
    $db_password=  'Badminton2001';
    $db_database = 'venta_autos';

$db = new mysqli($db_host,$db_username, $db_password, $db_database);
mysqli_query($db,"SET NAMES 'utf8'"); //Para que se muestren los acentos correctamente en la base de datos.
if ($db->connect_errno>0) {
    die('no es possible conectar a la base ['. $db->connect_error .']');
}
?>