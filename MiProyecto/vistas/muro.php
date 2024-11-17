<h1>Mi muro</h1>

<section>
    <form>
        <input type="submit" value="Cerrar Sesión" name="accionUsuario" class="cerrarSesion">
    </form>
    <div id="titulos">
        <h2>Crear nueva publicación</h2>
    </div>
    <form action="">
        <textarea name="contenido" rows="15" cols="150"><?php 
        if (isset($contenidoPost)) echo $contenidoPost;
        ?></textarea>
        <p>
            <input type="submit" value="Publicar" name="accionMuro" class="publicar">
        </p>
    </form>
    <section id="publicaciones">
        
        <div id="titulos">
        <h2>Mis publicaciones</h2> 
        </div>

        <article>
            <?php foreach($archivosPersonales = mostrarFicheros($usuario) as $archivo): ?>
            <div>
                <form>
                    <b><u><?php echo $archivo ?></u></b>
                    <br>
                    <pre><?php echo file_get_contents("./usuarios/".$usuario.DIRECTORY_SEPARATOR.$archivo) ?></pre>
                    <input type="text" name="contenidoRespuesta">
                    <input type='submit' value='Añadir comentario' name='accionMuro'>
                    <input type='submit' value='Borrar post' name='accionMuro'>
                    <input type='hidden' value= <?php echo $archivo ?>  name='nombreFichero'>
                </form>
            </div>
            <?php endforeach ?>
        </article>
    </section>

    <section class="barra-lateral">
            <article>
                <?php foreach($carpetasUsu as $carpeta): ?>
                <form action="">
                    <input type='submit' value=<?php echo $carpeta ?> name='accionB'>
                </form>
                </p>
                <ul>
                <?php foreach($archivosPersonales = mostrarFicheros($carpeta) as $archivo): ?>
                    <li><?php echo $archivo ?></li>
                <?php endforeach ?>
                </ul>
                    <?php endforeach ?>
            </article>
    </section>

</section>