<?php
namespace app\config;

use PDO;
use PDOException;

class Database{
    private static ?Database $instancia = null;

    private PDO $conexion;

    //configuración de conexión a BD
    private string $host = "localhost";
    private string $puerto = "3306";
    private string $basedatos = "gc_novedades";
    private string $usuario = "root";
    private string $clave = "";

    private function __construct(){
        $dns = "mysql:host={$this->host};port={$this->puerto};dbname={$this->basedatos};chartset=utf8mb4";
        try{
            $this->conexion = new PDO($dns, $this->usuario, $this->clave, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false,]);
        }catch(PDOException $e){
            die("Error al conectar la base de datos: ".$e->getMessage());
        }
    }

    //Punto de acces único a la instancia 
    public static function obtenerInstancia(): Database{
        if(self::$instancia == null){
            self::$instancia = new Database();
        }
        return self::$instancia;
    }

    //Devuelve el PDO ya conectado para que los modelos lo usen al armar las consultas
    public function obtenerConexion(): PDO{
        return $this->conexion;
    }

    //Evitar que la instancia pueda clonarse
    private function __clone(): void
    {
    }
}
?>