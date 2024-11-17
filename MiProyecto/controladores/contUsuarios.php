<?php 

//cuando se pulsen los botones de acceder o registrar recogemos los campos
if (isset($_REQUEST["accionUsuario"])){
    //convertir a minuscula los values de los submit
    $accionU = str_replace(" ", "", strtolower($_REQUEST["accionUsuario"]));

    switch ($accionU){
        case "registrar":
            //le asigno a la variable ok el true o false dependiendo de si se ha registrado o no el usuario
            $ok = registrar($_REQUEST["usuario"], $_REQUEST["clave"]);

            //compruebo si se ha registrado o no y muestro las vistas correspondientes
            if ($ok){
                $mensaje = "Usuario registrado";
                $vista = "identificacion.php";
            }else{
                $mensaje = "Error: el usuario no se ha podido registrar.";
            }

            break;

        case "acceder":
            //comprobar si el usuario existe en el archivo ini
            $ok = acceder($_REQUEST["usuario"], $_REQUEST["clave"]);

            if ($ok){
                //guardar el usuario en la sesion
                $_SESSION["usuario"] = $_REQUEST["usuario"];

                //redirigir al blog
                $vista = "muro.php";
            }else{
                //mostrar mensaje de eroor
                $mensaje = "Usuario o contraseña incorrecto";

                //redirigir a l apagina de identificación
                $vista = "identificacion.php";
            }
            break;

        case "cerrarsesión":
                //elimino las variables de sesión
                session_unset();
                //destruyo la sesion
                session_destroy();
                //redirigimos a la vista de la identificación
                $vista = "identificacion.php";
            break;
    }
}

?>