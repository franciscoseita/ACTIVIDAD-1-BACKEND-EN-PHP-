<?php
include('conn.php');

//Leemos raw POST data del request body
$data = json_decode(file_get_contents('php://input'), true);

//Verficamos la accion
if(isset($_GET['accion'])) {
    $accion=$_GET['accion'];

    //Leer datos de la tabla de usuarios
    if($accion== 'leer'){
        $sql = "select * from clientes where 1";
        $result = $db->query($sql);

        if($result ->num_rows>0){
            while($fila = $result->fetch_assoc()){
                $item['id']= $fila['id'];
                $item['nombre']= $fila['nombre'];
                $item['email']= $fila['email'];
                $arrclientes[] = $item;
            }
            $response["status"] = "ok";
            $response["mensaje"] = $arrclientes;
        }
        else{
            $response["status"] = "Error";
            $response["mensaje"] = "No hay clientes registrados";
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
        $nombre = $data["nombre"];
        $email = $data["email"];

        $qry = "INSERT INTO clientes (nombre, email) values ('$nombre','$email')";
        
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
        $nombre = $data["nombre"];
        $email = $data["email"];

        $qry = "UPDATE clientes set nombre = '$nombre', email = '$email' where id = '$id'";
        
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

        $qry = "delete from clientes where id = '$id'";
        
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