<h1> <?php echo $muroDe; ?> </h1>

<form action="">
    <input type="submit" value="Volver a mi muro" name="accionMuroAjenoVolver">
</form>

<div id="titulos">
    <h2>Publicaciones</h2>
</div>

<section class="pubAjenas">
    <?php foreach($ficheros as $fichero): ?>
        <div>
            <b><u><?php echo $fichero; ?></u></b>
            <pre><?php echo file_get_contents("./usuarios/".$_SESSION["usuarioAjeno"].DIRECTORY_SEPARATOR.$fichero) ?></pre>
            <form action="">
                <input type="text" name="contenidoRespuestaAgeno">
                <input type='submit' value='Añadir comentario' name='accionMuroAjeno'>
                <input type='hidden' value= <?php echo $fichero ?>  name='nombreFicheroAjeno'>
                <input type="hidden" value=<?php echo $accionB ?> name="nombreUsuarioAjeno">
            </form>
        </div>

    <?php endforeach ?>
</section>

<section class="barra-lateral">
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
    </section>