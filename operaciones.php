<?php
    include('conn.php');  //include the database connection php script
    $data = json_decode(file_get_contents('php://input'),true); 

    //Verificar la accion
    if(isset($_GET['accion'])){   
        $accion=$_GET['accion'];
        //leer los datos de la tabla usuario
        if($accion=="leer"){
            $sql = "SELECT * FROM  alumnos where 1";
            $result = $db->query($sql);

            if($result->num_rows>0){
                while ($fila = $result->fetch_assoc()) {
                    $item['id'] = $fila['id'];
                    $item['nombre']= $fila["nombre"];
                    $item['apellido_paterno'] = $fila["apellido_paterno"];
                    $item['apellido_materno'] = $fila["apellido_materno"];
                    $arrAlumnos[]=$item;
                }
                $response["status"]="ok";
                $response["mensaje"]=$arrAlumnos;
            }  else{
               $response["status"] = "Error";
               $response["message"] = "No hay registros en la base de datos";
            }
            echo json_encode($response);//mostrar el resultado del json
        }
            header('Content-Type: application/json');
            echo json_encode($response);
            
        }

    //si yo paso los datos como json atraves del body 
    if(isset($data)){
        //obtener la accion
        $accion= $data['accion'];
        if($accion=='insertar'){
            $apellido_paterno = $data["apellido_paterno"];
            $apellido_materno = $data["apellido_materno"];
            $nombre = $data["nombre"];
            $qry=  "INSERT INTO `alumnos` (`apellido_paterno`, `apellido_materno`, `nombre`) VALUES ('$apellido_paterno','$apellido_materno','nombre')";
                if($db->query($qry)){
                    $response["status"]='ok';
                    $response["message"]='Se ha insertado correctamente el dato';
                }else{
                    $response["status"]='error';
                    $response["message"]='Ocurrio un error al intentar guardar el dato';	
                 }

            header('Content-Type: application/json');
            echo json_encode($response);
        
         }
    }

   
    
?>