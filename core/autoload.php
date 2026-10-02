<?php
spl_autoload_register(function(string $claseCompleta): void{
    //mapa: prefijo de namespace => carpeta real en el proyecto
    $mapaNamespace = [
        'app\\config\\' => __DIR__ . '/../config/',
        'app\\models\\' => __DIR__ . '/../app/models/',
        'app\\controllers\\' => __DIR__ . '/../app/controllers/',
    ];

    foreach($mapaNamespace as $prefijo => $directorio){
        if(str_starts_with($claseCompleta, $prefijo)){
            $nombreClase = substr($claseCompleta, strlen($prefijo));
            $rutaArchivo = $directorio . $nombreClase . 'php';

            if(file_exists($rutaArchivo)){
                require_once $rutaArchivo;
                return;
            }
        }
    }

});
?>