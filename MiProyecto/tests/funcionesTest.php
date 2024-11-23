<?php 
use PHPUnit\Framework\TestCase;
/* require_once("/../modelo/funciones.php");
require_once("/../vendor/autoload.php"); */

require_once __DIR__ . '/../modelo/funciones.php';
require_once __DIR__ . '/../vendor/autoload.php';

class funcionesTest extends TestCase{

    private $usuariosDir;

    protected function setUp(): void
    {
        // Inicializar el directorio de pruebas
        $this->usuariosDir = __DIR__ . '/../usuarios';
        if (!file_exists($this->usuariosDir)) {
            mkdir($this->usuariosDir, 0777, true);
        }
    }

    protected function tearDown(): void
    {
        // Eliminar todos los archivos y directorios creados durante las pruebas
        $this->deleteDirectory($this->usuariosDir);
    }

    private function deleteDirectory($dir)
    {
        if (!file_exists($dir)) {
            return;
        }
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $path = $dir . DIRECTORY_SEPARATOR . $file;
            is_dir($path) ? $this->deleteDirectory($path) : unlink($path);
        }
        rmdir($dir);
    }

    public function testExiste()
    {
        // Crear un archivo usuarios.ini con un usuario de prueba
        file_put_contents($this->usuariosDir . '/usuarios.ini', "testuser=testpassword\n");

        // Comprobar que la función encuentra el usuario
        $this->assertEquals('testpassword', existe('testuser'));

        // Comprobar que devuelve NULL para un usuario inexistente
        $this->assertNull(existe('inexistente'));
    }

    public function testRegUsuario()
    {
        // Registrar un usuario
        $resultado = regUsuario('testuser', 'testpassword');

        // Comprobar que se registra correctamente
        $this->assertGreaterThan(0, $resultado);

        // Verificar que el usuario está en usuarios.ini
        $usuarios = parse_ini_file($this->usuariosDir . '/usuarios.ini');
        $this->assertArrayHasKey('testuser', $usuarios);
        $this->assertEquals('testpassword', $usuarios['testuser']);
    }

    public function testRegistrar()
    {
        // Registrar un nuevo usuario
        $resultado = registrar('testuser', 'testpassword');

        // Verificar que el usuario se registra y la carpeta se crea
        $this->assertTrue($resultado);
        $this->assertDirectoryExists($this->usuariosDir . '/testuser');
    }

    public function testAcceder()
    {
        // Configurar un usuario existente
        file_put_contents($this->usuariosDir . '/usuarios.ini', "testuser=testpassword\n");

        // Comprobar acceso con credenciales correctas
        $this->assertTrue(acceder('testuser', 'testpassword'));

        // Comprobar acceso con credenciales incorrectas
        $this->assertFalse(acceder('testuser', 'wrongpassword'));
    }

    public function testSubirPublicacion()
    {
        $archivo = $this->usuariosDir . '/testfile.txt';
        $contenido = "Contenido de prueba";

        // Subir una publicación
        $resultado = subirPublicacion($archivo, $contenido);

        // Verificar que el archivo se crea correctamente
        $this->assertGreaterThan(0, $resultado);
        $this->assertFileExists($archivo);
        $this->assertEquals($contenido, file_get_contents($archivo));
    }

    public function testEditar()
    {
        $archivo = $this->usuariosDir . '/testfile.txt';

        // Crear archivo inicial
        file_put_contents($archivo, "Línea 1\n");

        // Editar el archivo añadiendo contenido
        editar($archivo, "Línea 2\n");

        // Verificar el contenido
        $contenidoEsperado = "Línea 1\nLínea 2\n";
        $this->assertEquals($contenidoEsperado, file_get_contents($archivo));
    }

    public function testMostrarFicheros()
    {
        // Crear archivos en un directorio de usuario
        mkdir($this->usuariosDir . '/testuser');
        file_put_contents($this->usuariosDir . '/testuser/file1.txt', 'Contenido 1');
        file_put_contents($this->usuariosDir . '/testuser/file2.txt', 'Contenido 2');

        // Obtener la lista de ficheros
        $ficheros = mostrarFicheros('testuser');

        // Verificar que se encuentran los archivos
        $this->assertContains('file1.txt', $ficheros);
        $this->assertContains('file2.txt', $ficheros);
    }

    public function testMostrarCarpetasUsuarios()
    {
        // Crear directorios para usuarios
        mkdir($this->usuariosDir . '/testuser1');
        mkdir($this->usuariosDir . '/testuser2');
        file_put_contents($this->usuariosDir . '/usuarios.ini', "admin=adminpassword\n");

        // Obtener la lista de carpetas
        $carpetas = mostrarCarpetasUsuarios('admin');

        // Verificar que las carpetas de otros usuarios están listadas
        $this->assertContains('testuser1', $carpetas);
        $this->assertContains('testuser2', $carpetas);

        // Verificar que no incluye `usuarios.ini` ni la carpeta del usuario actual
        $this->assertNotContains('usuarios.ini', $carpetas);
        $this->assertNotContains('admin', $carpetas);
    }

    public function testContenidoArchivos()
    {
        $archivo = $this->usuariosDir . '/testfile.txt';
        $contenido = "Contenido del archivo";

        // Crear un archivo con contenido
        file_put_contents($archivo, $contenido);

        // Verificar que el contenido es correcto
        $this->assertEquals($contenido, contenidoArchivos($archivo));
    }
}