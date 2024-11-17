<?php

//cogemos todas las carpetas del directorio de usuarios en un array a excepcion del puno, de los dos puntos, del archivo ini y del usuario de la sesion
if(isset($_SESSION["usuario"])){
    $usuario = $_SESSION["usuario"];
    $carpetasUsu = mostrarCarpetasUsuarios($usuario);
}

if (isset($_REQUEST["accionMuro"])) {
    //convertir a minuscula y quitar espacios el request de los botones del muro
    $accionM = str_replace(" ", "", strtolower($_REQUEST["accionMuro"]));

    switch ($accionM){
        case "publicar":    //cuando le doy al f5 se publica otra vez el mismo archivo
            //cogemos la fecha en segundos que sera el nombre del archivo
            $fecha = date("U");

            //cogemos la rura que sera donde lo guardaremos y le añadiremos el nombre, en este caso la fecha
            $rutaGuardar = "./usuarios/" . $_SESSION["usuario"] . DIRECTORY_SEPARATOR . $fecha . ".txt";

            //impedimos que si apretamos publicar con el text area vacio te cree un archivo vacio
            if ($_REQUEST["contenido"] != ""){
                $exito = subirPublicacion($rutaGuardar, $_REQUEST["contenido"]);
            }else{
                $exito = false;
            }

            //mostrar mensaje en caso de que algo falle o de que si se publique
            if ($exito ==false){
                $mensaje = "Algo ha fallado";
            }else{
                $mensaje = "Archivo creado con éxito";
            }

            //NO FUNCIONAAAAA
            //Redirigimos de nuevo a nuestro muro
            $vista = "muro.php";
            break;

        case "añadircomentario":
            //cogemos el contenido del imput text de la respuesta
            //el \n y el - es para que antes del contenido le ponga un retorno de carro y un guión
            $respuesta = "\n"."-".$_REQUEST["contenidoRespuesta"];

            //cogemos el valor del campo oculto que es el nombre del fichero
            $nombreArchivo = $_REQUEST["nombreFichero"];

            //la ruta del archivo a editar
            $rutaArchivoEditar = "./usuarios/".$_SESSION["usuario"]. DIRECTORY_SEPARATOR .$nombreArchivo;

            //editamos el fichero
            editar($rutaArchivoEditar, $respuesta);

            $vista = "muro.php";
            break;

        case "borrarpost":
            //coger el valor del campo oculto
            $nombreArchivo = $_REQUEST["nombreFichero"];
            //ruta al archivo a borrar
            $rutaArchivoBorrar = "./usuarios/".$_SESSION["usuario"]. DIRECTORY_SEPARATOR .$nombreArchivo;
            
            //if para que si no existe el archivo muestre un mensaje
            if (file_exists($rutaArchivoBorrar)){
                unlink($rutaArchivoBorrar);
            }else{
                $mensaje = "El archivo no existe";
            }
            $vista = "muro.php";
            break;
    }
}

if (isset($_REQUEST["accionB"])){
    //convertir a minuscula y quitar espacios el request de los botones del muro
    $accionB = str_replace(" ", "", strtolower($_REQUEST["accionB"]));

    //creo una variable de sesion con el nombre del usuario al que quieres entrar para ver su muro
    $_SESSION["usuarioAjeno"] = $accionB;

    $muroDe = "Muro de ".$accionB;
    $_SESSION["nombreMuro"] = "Muro de ".$accionB;

    $ficheros = mostrarFicheros($accionB);
    $_SESSION["ficheros"] = mostrarFicheros($accionB);

    //nos movemos al muro ageno
    $vista = "muroAjeno.php";
}

if (isset($_REQUEST["accionMuroAjeno"])){
    //convertir a minuscula y quitar espacios el request de los botones del muro
    $accionB = str_replace(" ", "", strtolower($_REQUEST["accionMuroAjeno"]));

    $muroDe = $_SESSION["nombreMuro"];
    $ficheros = $_SESSION["ficheros"];


    //bajo la variable de sesion del nombre de usuario ageno para ponerla en la ruta de los archivos
    $usuAj = $_SESSION["usuarioAjeno"];

    //cogemos el contenido del imput text de la respuesta
    //el \n y el - es para que antes del contenido le ponga un retorno de carro y un guión
    $respuesta = "\n"."-".$_REQUEST["contenidoRespuestaAgeno"];

    //cogemos el valor del campo oculto que es el nombre del fichero
    $nombreArchivo = $_REQUEST["nombreFicheroAjeno"];

    //la ruta del archivo a editar
    $rutaArchivoEditar = "./usuarios/".$usuAj. DIRECTORY_SEPARATOR .$nombreArchivo;

    if (!empty($respuesta)){
        //editamos el fichero
        editar($rutaArchivoEditar, $respuesta);
    } 

    //$vista = "muro.php";
    $vista = "muroAjeno.php";
}

if (isset($_REQUEST["accionMuroAjenoVolver"])){
    $vista = "muro.php";
}
?>