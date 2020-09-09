<?php
//solo funciona el get y con usuario Cambiar a cedula
//revisar como colocar autenticacion cookie o token o un tercero
//nota revision en git con hostpapa
include 'conexionApiSimple.php';

header('Access-Control-Allow-Origin: *');

if($_SERVER['REQUEST_METHOD']=='GET'){
    if(isset($_GET['usuario_documento'])){
        $query="select `usuario_nombre`,`usuario_apellido`,`usuario_id`,`usuario_documento` from usuarios where usuario_documento=".$_GET['usuario_documento'];
        $resultado=metodoGet($query);
        echo json_encode($resultado->fetch(PDO::FETCH_ASSOC));
        $query="select `meSientoMal`,`meSientoBien`,`date`,`usuario_id` from sintomas where usuario_id='usuario_id'";
        $resultado=metodoGet($query);
        echo json_encode($resultado->fetch(PDO::FETCH_ASSOC));
    }else{
        $query="select * from usuarios";
        $resultado=metodoGet($query);
        echo json_encode($resultado->fetchAll()); 
    }
    header("HTTP/1.1 200 OK");
    exit();
}

if($_POST['METHOD']=='POST'){
    unset($_POST['METHOD']);
    $nombre=$_POST['nombre'];
    $lanzamiento=$_POST['lanzamiento'];
    $desarrollador=$_POST['desarrollador'];
    $query="insert into usuarios(nombre, lanzamiento, desarrollador) values ('$nombre', '$lanzamiento', '$desarrollador')";
    $queryAutoIncrement="select MAX(usuario_id) as usuario_id from usuarios";
    $resultado=metodoPost($query, $queryAutoIncrement);
    echo json_encode($resultado);
    header("HTTP/1.1 200 OK");
    exit();
}

if($_POST['METHOD']=='PUT'){
    unset($_POST['METHOD']);
    $usuario_id=$_GET['usuario_id'];
    $nombre=$_POST['nombre'];
    $lanzamiento=$_POST['lanzamiento'];
    $desarrollador=$_POST['desarrollador'];
    $query="UPDATE usuarios SET nombre='$nombre', lanzamiento='$lanzamiento', desarrollador='$desarrollador' WHERE usuario_id='$usuario_id'";
    $resultado=metodoPut($query);
    echo json_encode($resultado);
    header("HTTP/1.1 200 OK");
    exit();
}

if($_POST['METHOD']=='DELETE'){
    unset($_POST['METHOD']);
    $usuario_id=$_GET['usuario_id'];
    $query="DELETE FROM usuarios WHERE usuario_id='$usuario_id'";
    $resultado=metodoDelete($query);
    echo json_encode($resultado);
    header("HTTP/1.1 200 OK");
    exit();
}

header("HTTP/1.1 400 Bad Request");

//Comentario En Api Esteban Tarrifa
?>
