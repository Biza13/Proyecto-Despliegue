<?php

// Si se ha pulsado el botón 'acción' recojo los campos 
// usuario y clave
if (isset($_REQUEST["accionusuario"])) {
    // Convetimos a minúscula y eliminamos los espacios
    $accionU = str_replace(" ", "", strtolower($_REQUEST["accionusuario"]));

    $usuario = "";
    $clave = "";

    switch ($accionU) {
        case "acceder":
            $usuario = $_REQUEST["usuario"];
            $clave = $_REQUEST["clave"];
            // Preguntamos si existe el usuario con esa clave en el fichero de usuarios
            $ok = acceder($usuario, $clave);
            if ($ok) {
                // Creamos la variable de sesión 'usurio y guardamos el nombre de usuario y creamos 
                $_SESSION["usuario"] = $usuario;
                // Redirigimos hacia el bloc de notas
                $vista = "blockDeNotas.php";
            } else {
                //una forma de hacerlo seria poner en la misma url el valor de mnesaje.Abajo
                //header("Location: index.php?mensaje=Usuario incorrecto");
                //otra forma seria subir la variable mensaje en la sesion para recuperarla despues en el index y luego redirigir al index
                $_SESSION["mensaje"] = "Usuario incorrecto";
                $vista = "identificacion.php";
            }
            break;
        case "registrarme":
            $usuario = $_REQUEST["usuario"];
            $clave = $_REQUEST["clave"];
            $ok = registrar($usuario, $clave);
            if ($ok) {
                $mensaje = "Usuario registrado.";
                $vista = "identificacion.php";
            } else {
                $mensaje = "Error: el usuario no se ha podido registrar";
            }
            break;
        case "cerrarsesión": // Elimino las variables de sesión
            session_unset();
            // Destruyo la sesión
            session_destroy();
            // Y nos redirigimos a la página de login
            $vista = "identificacion.php";
            break;
    }
}
