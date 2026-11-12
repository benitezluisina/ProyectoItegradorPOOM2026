<?php

/**
 * public/index.php  —  FRONT CONTROLLER
 *
 * Único punto de entrada de la aplicación. Recibe todas las peticiones
 * y las deriva al controlador y acción indicados por URL:
 *
 *   index.php?ctrl=usuarios&accion=index
 *   index.php?ctrl=usuarios&accion=crear
 *   index.php?ctrl=usuarios&accion=guardar      (POST)
 *   index.php?ctrl=usuarios&accion=editar&id=3
 *   index.php?ctrl=usuarios&accion=actualizar   (POST)
 *   index.php?ctrl=usuarios&accion=eliminar     (POST)
 *   index.php?ctrl=novedades&accion=index  (idem crear, guardar, editar, actualizar, eliminar)
 */

session_start();

require_once __DIR__ . '/../config/config.php';      // define BASE_URL
require_once __DIR__ . '/../core/autoload.php';

// Lista blanca: solo estos controladores y acciones son accesibles por URL.
$rutasPermitidas = [
    'usuarios' => [
        'controlador' => \app\controllers\UsuarioController::class,
        'acciones'    => ['index', 'crear', 'guardar', 'editar', 'actualizar', 'eliminar'],
    ],
    'novedades' => [
        'controlador' => \app\controllers\NovedadController::class,
        'acciones'    => ['index', 'crear', 'guardar', 'editar', 'actualizar', 'eliminar'],
    ],
];

$ctrl   = $_GET['ctrl']   ?? 'usuarios';
$accion = $_GET['accion'] ?? 'index';

// Si ctrl o accion llegan como array (?ctrl[]=x) o con un valor inesperado, 404.
if (!is_string($ctrl) || !is_string($accion)
    || !isset($rutasPermitidas[$ctrl])
    || !in_array($accion, $rutasPermitidas[$ctrl]['acciones'], true)) {
    http_response_code(404);
    echo '404 - Página no encontrada';
    exit;
}

$clase       = $rutasPermitidas[$ctrl]['controlador'];
$controlador = new $clase();
$controlador->$accion();
