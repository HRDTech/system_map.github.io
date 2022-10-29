<?php

    if (empty($_POST['nameForm'])){
        echo "Lo siento, ocurrió un error: nameForm vacío";
    } else{
        $name = $_POST['nameForm'];
        $uid = uniqid();
        $date = Date("Y-m-d H:i:s");

        $baseDeDatos = new PDO("sqlite:" .__DIR__. "/marker.sqlite");
        $baseDeDatos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sentencia = $baseDeDatos->prepare("INSERT INTO device('name', 'uid', 'date')	VALUES(:name, :uid, :date);");
        $sentencia->bindParam(":name", $name);
        $sentencia->bindParam(":uid", $uid);
        $sentencia->bindParam(":date", $date);

        $resultado = $sentencia->execute();
        if($resultado === true){
            echo "<center><h2>Dispositivo creado ...</h2></center></br>";
            echo "<center><a href='from.html'> Otro dispositivo: Si </a>";
            echo "<a href='../index.php'> No </a></center>";
        }else{
            echo "Lo siento, ocurrió un error";
        }

    }