<?php

// Inicializamos las variables
$_SESSION["contenido"] = "";
$_SESSION["nombre_fichero"] = "";

// Si hemos recibido el botón ....
if (isset($_REQUEST["accion"])) {
    // Convertimos a minúscula y eliminamos los espacios en blanco y 
    $accionB = str_replace(" ", "", strtolower($_REQUEST["accionBlock"]));
    // Recogemos el nombre del fichero y el contenido
    $_SESSION["nombre_fichero"] = $_REQUEST["nombre_fichero"];
    $_SESSION["contenido"] = $_REQUEST["contenido"];
    // Preguntamos por el botón que hemos pulsado    
    switch ($accionB) {

        case "guardar": // Construimos la ruta y el nombre de fichero 
            $path = $_SESSION["usuario"] . DIRECTORY_SEPARATOR . $_SESSION["nombre_fichero"];
            $ok = guardar($path, $_SESSION["contenido"]);
            if ($ok == false) {
                $_SESSION["mensaje"] = "No se ha podido guardar el fichero $path";
            } else {
                $_SESSION["mensaje"] = "El fichero $path se ha guardado correctamente";
            }
            header("Location: blockDeNotas.php");
            break;

            case "abrir":   // Construimos la ruta y el nombre de fichero 
                
                $hidden = $_REQUEST["escondido"];

                if (isset($hidden)){
                    $_SESSION["nombre_fichero"] = $hidden;
                }

                $path = $_SESSION["usuario"].DIRECTORY_SEPARATOR.$_SESSION["nombre_fichero"];
                $_SESSION["contenido"] = abrir($path);

                if (!$_SESSION["contenido"]) {
                    // Dejamos un mensaje de aviso
                    $_SESSION["mensaje"] = "No se ha podido abrir el archivo $path";
                }

                header("Location: blockDeNotas.php");
                break;

            case "explorar":
                $path = $_SESSION["usuario"];
                $_SESSION["archivos"] = scandir($path);
                header("Location: block2.php");
                break;

            case "imprimirenpdf":
                $fichero = $_REQUEST["nombre_fichero"];
                imprimirPDF($fichero);
                break;

            case "descargar":
                $path = $_SESSION["usuario"].DIRECTORY_SEPARATOR.$_SESSION["nombre_fichero"];
                if (file_exists($path)) {
                header('Content-Description: File Transfer');
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename='.$path);
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($path));
                ob_clean();
                flush();
                readfile($path);
                exit;
                }else {
                    echo 'Archivo no disponible.';
                }
                break;
    }
}
