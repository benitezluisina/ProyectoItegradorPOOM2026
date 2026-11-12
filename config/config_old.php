<?php
/**
 * config/config.php
 *
 * Configuración general. Se incluye una sola vez, al principio de public/index.php.
 *
 * BASE_URL es la ruta WEB de la carpeta "public". Se calcula sola a partir de la
 * URL con la que se abrió la aplicación, así que no importa cómo se llame la
 * carpeta del proyecto en htdocs (ni cómo esté escrita):
 *
 *   http://localhost/ProyectoItegradorPOOM2026/public/index.php
 *       -> BASE_URL = "/ProyectoItegradorPOOM2026/public"
 *
 * En las vistas se usa así:
 *   <link href="<?= BASE_URL ?>/css/estilos.css" rel="stylesheet">
 *   <a href="<?= BASE_URL ?>/index.php?ctrl=usuarios&accion=index">Usuarios</a>
 *
 * Regla: todo href / src / action del HTML empieza con <?= BASE_URL ?>.
 * Los require / include de PHP usan __DIR__ (ver las vistas).
 */
define('BASE_URL', rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/'));
