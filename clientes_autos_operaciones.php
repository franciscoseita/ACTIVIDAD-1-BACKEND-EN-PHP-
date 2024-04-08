<?php
include('connection.php');

//Leemos raw POST data del request body
$data = json_decode(file_get_contents('php://input'), true);

//Verficamos la accion
if(isset($_GET['accion'])) {
    $accion=$_GET['accion'];

    //Leer datos de la tabla de usuarios
    if($accion== 'leer'){
        $sql = "select * from dueno_auto where 1";
        $result = $db->query($sql);

        if($result ->num_rows>0){
            while($fila = $result->fetch_assoc()){
                $item['id']= $fila['id'];
                $item['id_auto']= $fila['id_auto'];
                $item['id_cliente']= $fila['id_cliente'];
                $arrdueno[] = $item;
            }
            $response["status"] = "ok";
            $response["mensaje"] = $arrdueno;
        }
        else{
            $response["status"] = "Error";
            $response["mensaje"] = "No hay dueno registrado";
        }

        header('content-type: application/json');
        echo json_encode($response);
    }

}

//Si yo paso los datos como JSON a traves del body
if(isset($data)){
    //Obtengo la accion
    $data = json_decode(file_get_contents('php://input'), true);
    $accion = $data["accion"];

    //Verifico el tipo de accion
    if($accion =='insertar'){
        //Obtener los demas datos del body
        $id_auto  = $data["id_auto"];
        $id_cliente = $data["id_cliente"];

        $qry = "INSERT INTO dueno_auto (id_auto, id_cliente) values ('$id_auto','$id_cliente')";
        
        if($db->query($qry)){
            $response["status"] = 'OK';
            $response["mensaje"] = 'El registro se creo correctamente';
        }
        else{
            $response["status"] = 'ERROR';
            $response["mensaje"] = 'El registro no se creo correctamente';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    if($accion == 'modificar'){
        $id = $data["id"];
        $id_auto  = $data["id_auto"];
        $id_cliente = $data["id_cliente"];

        $qry = "UPDATE dueno_auto set id_auto = '$id_auto', id_cliente = '$id_cliente' where id = '$id'";
        
        if($db->query($qry)){
            $response["status"] = 'OK';
            $response["mensaje"] = 'El registro se modifico correctamente';
        }
        else{
            $response["status"] = 'ERROR';
            $response["mensaje"] = 'El registro no se modifico correctamente';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    if($accion == 'borrar'){
        $id = $data["id"];

        $qry = "delete from dueno_auto where id = '$id'";
        
        if($db->query($qry)){
            $response["status"] = 'OK';
            $response["mensaje"] = 'El registro se elimino correctamente';
        }
        else{
            $response["status"] = 'ERROR';
            $response["mensaje"] = 'El registro no se elimino correctamente';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}