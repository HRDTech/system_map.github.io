<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $baseDeDatos = new PDO("sqlite:/Applications/MAMP/htdocs/map/admin/marker.sqlite");
    $baseDeDatos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        $geoJson = array('type' => 'FeatureCollection', 'features' => array());

        $data = $baseDeDatos->query("select * from point order by id asc");
        while($result = $data->fetch(PDO::FETCH_ASSOC)){
            $marker = array(
                'type' => 'Feature',
                "geometry" => array(
                    'type' => 'Point',
                    'coordinates' => array(
                        $result['lon'],
                        $result['lat']
                    )
                ),
                "properties" => array (
                    "name" => $result['uid'],
                    "title" => "Test"),
                "id" => $result['uid']
            );
            $geoJson['features'][] = $marker;
        }
        echo json_encode($geoJson);
    } else{
        header('HTTP/1.1 405 Method not allowed');
        header('Allow: GET');
    }
