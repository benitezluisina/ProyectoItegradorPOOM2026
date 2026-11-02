<?php
//archivo temporal solo para verificar que la conexion pdo y el modelo usuario funciona correctamente

require_once __DIR__.'/core/autoload.php';
use app\models\Usuario;

echo "<h2>Prueba de conexión PDO</h2>";

try{
    $usuarioModelo = new Usuario();
    $usuarios = $usuarioModelo->obtenerTodos();
    echo "<p>Conexión Exitosa. Usuarios encontrados: ".count($usuarios)."</p>";
    echo "<pre>";
    print_r($usuarios);
    echo "</pre>";
}catch (\Throwable $e){
    echo "<p>Error: ".$e->getMessage()."</p>";
}

?>