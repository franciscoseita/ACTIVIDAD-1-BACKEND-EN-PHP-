<?php
include('conn.php');

//Leemos raw POST data del request body
$data = json_decode(file_get_contents('php://input'), true);

//Verficamos la accion
if(isset($_GET['accion'])) {
    $accion=$_GET['accion'];

    //Leer datos de la tabla de usuarios
    if($accion== 'leer'){
        $sql = "select * from autos where 1";
        $result = $db->query($sql);

        if($result ->num_rows>0){
            while($fila = $result->fetch_assoc()){
                $item['id']= $fila['id'];
                $item['marca']= $fila['marca'];
                $item['modelo']= $fila['modelo'];
                $item['ano']= $fila['ano'];
                $item['no_serie']= $fila['no_serie'];
                $arrAutos[] = $item;
            }
            $response["status"] = "ok";
            $response["mensaje"] = $arrAutos;
        }
        else{
            $response["status"] = "Error";
            $response["mensaje"] = "No hay autos registrados";
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
        $marca = $data["marca"];
        $modelo = $data["modelo"];
        $ano = $data["ano"];
        $no_serie = $data["no_serie"];

        $qry = "INSERT INTO autos (marca, modelo, ano, no_serie) values ('$marca','$modelo','$ano','$no_serie')";
        
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
        $marca = $data["marca"];
        $modelo = $data["modelo"];
        $ano = $data["ano"];
        $no_serie = $data["no_serie"];

        $qry = "UPDATE autos set marca = '$marca', modelo = '$modelo', ano = '$ano', no_serie = '$no_serie' where id = '$id'";
        
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

        $qry = "delete from autos where id = '$id'";
        
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