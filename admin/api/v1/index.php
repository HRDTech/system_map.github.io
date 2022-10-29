<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $baseDeDatos = new PDO("sqlite:/Applications/MAMP/htdocs/map/admin/marker.sqlite");
    $baseDeDatos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $resource = $_SERVER['REQUEST_METHOD'];

    switch ($resource){
        case 'GET':
            $data = $baseDeDatos->query("select * from point order by date asc");
            $result = $data->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($result);
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);
            $uid = $data['uid'];
            $lat = $data['lat'];
            $lon = $data['lon'];
            $date = $data['date'];

            $sentencia = $baseDeDatos->prepare("INSERT INTO point('uid', 'lat', 'lon', 'date')	
                                                        VALUES(:uid, :lat, :lon, :date);");
            $sentencia->bindParam(":uid", $uid);
            $sentencia->bindParam(":lat", $lat);
            $sentencia->bindParam(":lon", $lon);
            $sentencia->bindParam(":date", $date);

            $resultado = $sentencia->execute();
            if($resultado === true){
                echo json_encode(array("code" => 1, "msg" => "Insert Ok"));
            }else{
                echo json_encode(array("code" => 0, "msg" => "Insert Error"));
            }
            break;
        default:

            break;
    }
