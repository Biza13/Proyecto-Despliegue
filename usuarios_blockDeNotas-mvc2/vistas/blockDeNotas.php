    <h4>
        <?php if (isset($_SESSION["mensaje"])) {
            echo $_SESSION["mensaje"];
            unset($_SESSION["mensaje"]);
        }  ?>
    </h4>
    <form action="">
        <input type="submit" value="Cerrar sesión" name="accionusuario" />
    </form>
    <br>
    <form action="">
        <div>
            <textarea rows="10" cols="120" name="contenido"><?php if (isset($_SESSION["contenido"])) {
                                                                echo $_SESSION["contenido"];
                                                                unset($_SESSION["contenido"]);
                                                            } ?></textarea>
        </div>
        <label>Fichero</label>
        <input type="text" name="nombre_fichero" value="<?php if (isset($_SESSION["nombre_fichero"])) {
                                                            echo $_SESSION["nombre_fichero"];
                                                            unset($_SESSION["nombre_fichero"]);
                                                        } ?>" />
        <input type="submit" value="Abrir" name="accionBolck" />
        <input type="submit" value="Guardar" name="accionBolck" />
        <input type="submit" value="Imprimir en pdf" name="accionBolck" />
        <input type="submit" value="Explorar" name="accionBolck" />
        <input type="submit" value="Copiar" name="accionBolck">
        <input type="submit" value="Descargar" name="accionBolck">
        <form>