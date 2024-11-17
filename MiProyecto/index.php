<?php 
session_start();

//establocemos una variable con la ruta del directorio de las vistas
$ruta = "vistas" .DIRECTORY_SEPARATOR;

//si la variable de sesion usuario esta definida, abrimos el blog y sino vamos a la pagina de identificacion
if (!isset($_SESSION["usuario"])){
    $vista = "identificacion.php";
}

/* if (isset($_SESSION["usuario"])){
    $vista = "muro.php";
}else{
    $vista = "identificacion.php";
} */

//incluir las funciones
require ("modelo".DIRECTORY_SEPARATOR."Funciones.php");

//incluir los controladores
require ("controladores" .DIRECTORY_SEPARATOR. "contUsuarios.php");
require ("controladores" .DIRECTORY_SEPARATOR. "contMuros.php");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
            box-sizing: border-box;
        }

        body{
            background-image: url("./paven.png");
        }

        h1{
            text-align: center;
            background-color: rgb(177, 175, 175);
            width: 100%;
            height: 80px;
            line-height: 80px; /* tiene que ser Igual al height para alinear verticalmente*/
        }

        h2{
            width: 50%;
            text-align: center;
            background-color: rgb(177, 175, 175);
            position: absolute;
            left: 25%;
        }

        #titulos{
            width: 100%;
            height: 50px;
            position: relative;
        }

        .barra-lateral{
            background-color: lightslategray;
            position:fixed;
            top: 130px;
            right: 50px;
            width: 300px;
            border-radius: 30px;
            padding: 1em;
        }

        pre{
            /*Cambiar el estilo a los pre porque el formato es horrible*/
            font-family:system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            font-size: medium;
        }

        input[type="submit"]{
            border-radius: 10px;
        }

        #publicaciones>article>div{
            background-color: rgb(223, 217, 217);
            padding: 2em;
            border: 1px solid black;
            margin: 20px;
            border-radius: 20px;
        }

        .pubAjenas>div{
            background-color: rgb(223, 217, 217);
            padding: 2em;
            border: 1px solid black;
            margin: 20px;
            border-radius: 20px;
        }

        .pubAjenas{
            padding: 2em;
        }

        textarea{
            margin-top: 2em;
        }

        .cerrarSesion{
            margin-left: 100px;
        }

        .publicar{
            margin-left: 100px;
        }
    </style>
</head>
<body>
    <nav>

    </nav>
    <main>
        <?php include $ruta."mensajes.php"; ?>
        <?php require $ruta . $vista; ?>
    </main>
</body>
</html>