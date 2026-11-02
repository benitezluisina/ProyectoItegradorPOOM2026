<?php
spl_autoload_register(function (string $claseCompleta): void {
 
    // Mapa: prefijo de namespace => carpeta real en el proyecto
    $mapaNamespaces = [
        'App\\Config\\'      => __DIR__ . '/../config/',
        'App\\Models\\'      => __DIR__ . '/../app/models/',
        'App\\Controllers\\' => __DIR__ . '/../app/controllers/',
    ];
 
    foreach ($mapaNamespaces as $prefijo => $directorio) {
        // Comparación sin distinguir mayúsculas: en PHP los namespaces son
        // case-insensitive, así que "app\models\Usuario" == "App\Models\Usuario".
        if (strncasecmp($claseCompleta, $prefijo, strlen($prefijo)) === 0) {
            $nombreClase = substr($claseCompleta, strlen($prefijo));
            $rutaArchivo = $directorio . $nombreClase . '.php';
 
            if (file_exists($rutaArchivo)) {
                require_once $rutaArchivo;
                return;
            }
        }
    }
});
?>