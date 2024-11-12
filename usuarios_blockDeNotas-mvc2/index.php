<?php 
session_start();

//establocemos una variable con la ruta del directorio de las vistas
$ruta = "vistas" .DIRECTORY_SEPARATOR;

//incluimos las funciones
require ("modelo".DIRECTORY_SEPARATOR."Funciones.php");

//incluimos los controladores
require ("controladores" .DIRECTORY_SEPARATOR. "controladorUsuarios.php");
require ("controladores" .DIRECTORY_SEPARATOR. "controladorBlock.php");

//si la variable de sesion usuario esta definida, abrimos el block de notas y sino vamos a la pagina de identificacion
if (isset($_SESSION["usuario"])){
    $vista = $ruta. "blockDeNotas.php";
}else{
    $vista = $ruta. "identificacion.php";
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- El include si no existe no lo pone, sin embargo el require si no lo encuentra te da error -->
    <?php include $ruta."mensajes.php" ?>
    <!-- Para incluir las vistas de cada una de las paginas es decir la identificacion, el block ... (seria la ruta)-->
    <?php require $vista; ?> 
</body>
</html>