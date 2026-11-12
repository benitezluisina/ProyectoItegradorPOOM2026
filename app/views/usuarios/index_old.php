<?php
$tituloPagina = "Usuarios";
$seccionActiva = "usuarios";
$hayFiltros = ($termino !== '' || $estado !== '');

require_once __DIR__ . '/../partials/header.php';
//include("../partials/header.php");
require_once __DIR__ . '/../partials/navbar.php';
//include("../partials/encabezado2.php");
require_once __DIR__ . '/../partials/encabezado2.php';
//include("../partials/navbar.php");

?>

<main class="container-fluid px-3 px-lg-4">
 
    <!-- Encabezado de la sección (breadcrumb + título + acción principal) -->
    <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/ProyectoIntegradorPOOM2026/public/index.php?ctrl=usuarios&accion=index" class="text-decoration-none">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
                </ol>
            </nav>
            <h1>Gestión de usuarios</h1>
            <p class="text-muted mb-0" style="font-size:0.88rem;">Alta, baja y modificación de registros del sistema</p>
        </div>
        <div>
            <a href="/ProyectoIntegradorPOOM2026/public/index.php?ctrl=usuarios&accion=crear" class="btn btn-accent">
                <i class="bi bi-plus-lg me-1"></i> Nuevo usuario
            </a>
        </div>
    </div>
 
    <?php if ($mensaje): ?>
        <div class="alert alert-<?= htmlspecialchars($mensaje['tipo']) ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($mensaje['texto']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    <?php endif; ?>
 
    <!-- Tarjeta con la tabla de datos -->
    <div class="app-card p-3 p-lg-4">
 
        <!-- Buscador y filtro (GET: se aplican al enviar el formulario) -->
        <form method="get" action="/ProyectoIntegradorPOOM2026/public/index.php"
              class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
            <input type="hidden" name="ctrl" value="usuarios">
            <input type="hidden" name="accion" value="index">
 
            <div class="input-group" style="max-width: 360px;">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                <input type="text" name="q" class="form-control border-start-0"
                       placeholder="Buscar por nombre o correo..."
                       value="<?= htmlspecialchars($termino) ?>">
                <button type="submit" class="btn btn-accent">Buscar</button>
            </div>
 
            <div class="d-flex gap-2">
                <select name="estado" class="form-select" style="max-width: 190px;" onchange="this.form.submit()">
                    <option value="">Todos los estados</option>
                    <option value="Activo"   <?= $estado === 'Activo'   ? 'selected' : '' ?>>Activo</option>
                    <option value="Inactivo" <?= $estado === 'Inactivo' ? 'selected' : '' ?>>Inactivo</option>
                </select>
                <?php if ($hayFiltros): ?>
                    <a href="/ProyectoIntegradorPOOM2026/public/index.php?ctrl=usuarios&accion=index"
                       class="btn btn-outline-secondary" title="Quitar filtros">
                        <i class="bi bi-x-lg"></i>
                    </a>
                <?php endif; ?>
            </div>
        </form>
 
        <div class="table-responsive">
            <table class="table table-app align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Correo electrónico</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($usuarios)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <?php if ($hayFiltros): ?>
                                Ningún usuario coincide con la búsqueda. Probá con otro nombre o quitá los filtros.
                            <?php else: ?>
                                Todavía no hay usuarios cargados. Usá «Nuevo usuario» para crear el primero.
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
 
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td>#<?= htmlspecialchars((string)$usuario['id']) ?></td>
                        <td class="fw-medium"><?= htmlspecialchars($usuario['nombre']) ?></td>
                        <td class="text-muted"><?= htmlspecialchars($usuario['email']) ?></td>
                        <td><?= htmlspecialchars($usuario['rol']) ?></td>
                        <td>
                            <?php if ($usuario['estado'] === 'Activo'): ?>
                                <span class="badge-estado-activo"><i class="bi bi-check-circle me-1"></i>Activo</span>
                            <?php else: ?>
                                <span class="badge-estado-inactivo"><i class="bi bi-x-circle me-1"></i>Inactivo</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <a href="/ProyectoIntegradorPOOM2026/public/index.php?ctrl=usuarios&accion=editar&id=<?= (int)$usuario['id'] ?>"
                               class="btn btn-icon btn-outline-accent me-1" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <!-- La baja se envía por POST: nunca debe ejecutarse con un link GET -->
                            <form method="post"
                                  action="/ProyectoIntegradorPOOM2026/public/index.php?ctrl=usuarios&accion=eliminar"
                                  class="d-inline">
                                <input type="hidden" name="id" value="<?= (int)$usuario['id'] ?>">
                                <button type="submit" class="btn btn-icon btn-outline-danger" title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
 
        <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
            <span class="text-muted" style="font-size:0.85rem;">
                <?= count($usuarios) ?> <?= count($usuarios) === 1 ? 'registro' : 'registros' ?><?= $hayFiltros ? ' encontrados' : '' ?>
            </span>
        </div>
    </div>
 
</main>
 
<?php require_once __DIR__ . '/../partials/footer.php'; ?>