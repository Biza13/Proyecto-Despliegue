<ul>
    <?php foreach ($_SESSION["archivos"] as $archivo): ?>
        <?php if (!is_dir($archivo)): ?>
            <li>

                <!--
                                Tambien se puede hacer con un enlace hay que quitar los comentarios de dentro del codigo php
                                <a href="controladorBlock.php?accion=abrir&nombre_fichero=<?php /*echo $archivo;*/ ?>">
                                <?php /*echo $archivo;*/ ?>
                                </a>
                                -->

                <form action="controladorBlock.php">
                    <label for="abrir"><?php echo $archivo ?></label>
                    <input type="submit" value="Abrir" name="accion">
                    <input type="hidden" name="escondido" value="<?php echo $archivo ?>">
                </form>

            </li>
        <?php endif; ?>
        <br>
    <?php endforeach; ?>
</ul>