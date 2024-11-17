<?php 

function existe($usuario){
    //partimos de la pbase que el usuario no existe
    $ok = NULL;

    //cargar en un array asociativo (clave valor) el fichero usuarion.ini
    $usuarios = parse_ini_file("usuarios/usuarios.ini");

    //preguntar si existe el usuario introducido por parametro en la array de la lista de usuarios del fichero
    if (isset($usuarios[$usuario])){
        //si existe le asignamos a la variable ok el valor de la clave siendo la clave el usuario y el valor la contraseña
        $ok = $usuarios[$usuario];
    }
    //devolvera null si no existe el usuario y la contraseña en caso de que si exista el usuario
    return $ok;
}

function regUsuario($usuario, $clave){
    //partimos de que no se va a poder guardar
    $ok = false;

    // Abrimos el fichero en modo de añadir "a+" Ver los diferentes modos de apertura: 
    // https://www.php.net/manual/es/function.fopen.php
    // Abrimos el fichero y obtenemos un descriptor de fichero a través del cual realizar las operaciones de lectura, escritura, cierre, etc
    $fichero = fopen(".".DIRECTORY_SEPARATOR."usuarios".DIRECTORY_SEPARATOR."usuarios.ini", "a+");

    //en caso de que SI se pueda abrir
    if ($fichero != NULL){
        //grabamos en el fichero la linea del usuario con su contraseña y le añadimos un salto de linea
        $ok = fwrite($fichero, "$usuario=$clave".PHP_EOL);

        //cerrar el fichero
        fclose($fichero);
    }
    //si se ha grabado $ok devolvera la cantidad de elementos grabados correctamente y si devuelve false es que no ha podido grabar
    return $ok;
}

function registrar($usuario, $clave){
    //partimos de que no se va a poder registrar
    $ok = false;

    //preguntar si el usuario que se quiere registrar NO existe en el fichero
    if (!existe($usuario)){
        //guardamos el usuario en caso de que no exiasta ningun usuario con el mismo nombre
        $ok = regUsuario($usuario, $clave);

        //si SI se ha podido registrar
        if ($ok != false){
            //Creamos la carpeta del usuario
            $ok = mkdir(".".DIRECTORY_SEPARATOR."usuarios".DIRECTORY_SEPARATOR.$usuario, 0777, true);
        }
    }
    //Si toda ha salido bien $ok devolvera true y false en caso de que algo no haya salido bien
    return $ok;
}

function acceder($usuario, $clave){
    // Partimos de la hipótesis de que el usuario no existe
    $ok = false;

    //Llamamos a la función existe para recoger la contraseña del usuario si existe 
    // o NULL en caso contrario
    $clave_usuario = existe($usuario);

    // Si es distinto de NULL comparamos con la clave introducida en el formulario
    if ($clave_usuario != NULL && $clave_usuario == $clave) {
        // Si coinciden, devolveremos true como valor indicativo de acceso autorizado 
        $ok = true;
    }
    return $ok;
}

/**
 * Guarda en un fichero de nombre `nombre_fichero` el contenido que se le pasa como parámetro.
 *
 * @param string $nombre_fichero Nombre del fichero a guardar, incluyendo la ruta.
 * @param string $contenido Contenido del fichero.
 *
 * @return int|false Devuelve el número de bytes escritos en caso de éxito, o false en caso de error.
 */
function subirPublicacion($segundos, $contenido){
    $ok = file_put_contents($segundos, $contenido);
    return $ok;
}

function editar($rutaNombreArchivo, $contenido){
    //abrir el archivo y asignarlo a una variable y con el parametro a lo abre en modo escritura que añade al final del contenido
    $archivo = fopen($rutaNombreArchivo, "a");

    if ($archivo) {
        //contenido que queremos añadir al fichero
        fwrite($archivo, $contenido);
        // Cerramos el archivo después de escribir en él.
        fclose($archivo); 
    } else {
        echo "No se pudo abrir el archivo.";
    }
}

function mostrarFicheros($usuario){
    $ficheros = [];
    //escanear los ficheros
    $todo = scandir("usuarios/".$usuario.DIRECTORY_SEPARATOR);

    foreach($todo as $uno){
        if ($uno != "." && $uno != ".."){
            array_push($ficheros, $uno);
        }
    }
    return $ficheros;
}

/**
 * Funcion que dado por parametro el usuario de la session nos saca todos los directorios
 * del directorio usuarios a excepcion del archivo .ini, y la carpeta del usuario registrado en la sesion
 *
 * @param [string] $usuario Usuario registrado en la sesion
 * @return [] devuelve un array con los directorios de la carpeta usuario
 */
function mostrarCarpetasUsuarios($usuario){
    $carpetas = [];
    //escanear los ficheros
    $todo = scandir("usuarios/");

    foreach($todo as $uno){
        if ($uno != "." && $uno != ".." && $uno != "usuarios.ini" && $uno != $usuario){
            array_push($carpetas, $uno);
        }
    }
    return $carpetas;
}

function contenidoArchivos($rutaArchivo){
    $contenido = file_get_contents($rutaArchivo);
    return $contenido;
}
?>