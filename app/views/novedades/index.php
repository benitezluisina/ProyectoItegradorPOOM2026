<?php
/**
 * app/views/novedades/index.php
 * Variables: $novedades (array)  $termino (string)  $seccion (string)  $mensaje (array|null)
 */
$tituloPagina = "Novedades";
$seccionActiva = "novedades";
$hayFiltros = ($termino !== '' || $seccion !== '');

require_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../partials/navbar.php';
require_once __DIR__ . '/../partials/encabezado2.php';
?>

<main class="container-fluid px-3 px-lg-4">

    <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/index.php" class="text-decoration-none">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Novedades</li>
                </ol>
            </nav>
            <h1>Novedades</h1>
            <p class="text-muted mb-0" style="font-size:0.88rem;">Registro de novedades por sección</p>
        </div>
        <div>
            <a href="<?= BASE_URL ?>/index.php?ctrl=novedades&accion=crear" class="btn btn-accent">
                <i class="bi bi-plus-lg me-1"></i> Nueva novedad
            </a>
        </div>
    </div>

    <?php if ($mensaje): ?>
        <div class="alert alert-<?= htmlspecialchars($mensaje['tipo']) ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($mensaje['texto']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    <?php endif; ?>

    <div class="app-card p-3 p-lg-4">

        <form method="get" action="<?= BASE_URL ?>/index.php"
              class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
            <input type="hidden" name="ctrl" value="novedades">
            <input type="hidden" name="accion" value="index">

            <div class="input-group" style="max-width: 400px;">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                <input type="text" name="q" class="form-control border-start-0"
                       placeholder="Buscar en el texto de la novedad..."
                       value="<?= htmlspecialchars($termino) ?>">
                <button type="submit" class="btn btn-accent">Buscar</button>
            </div>

            <div class="d-flex gap-2">
                <select name="seccion" class="form-select" style="max-width: 220px;" onchange="this.form.submit()">
                    <option value="">Todas las secciones</option>
                    <?php foreach (\app\models\Novedad::SECCIONES as $s): ?>
                        <option value="<?= htmlspecialchars($s) ?>" <?= $seccion === $s ? 'selected' : '' ?>><?= htmlspecialchars($s) ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if ($hayFiltros): ?>
                    <a href="<?= BASE_URL ?>/index.php?ctrl=novedades&accion=index"
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
                        <th>Fecha y hora</th>
                        <th>Sección</th>
                        <th>Novedad</th>
                        <th>Responsable</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($novedades)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <?= $hayFiltros
                                ? 'Ninguna novedad coincide con la búsqueda. Probá con otro texto o quitá los filtros.'
                                : 'Todavía no hay novedades registradas. Usá «Nueva novedad» para cargar la primera.' ?>
                        </td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($novedades as $n): ?>
                    <tr>
                        <td>#<?= (int) $n['id'] ?></td>
                        <td class="text-nowrap"><?= htmlspecialchars((new DateTime($n['fecha_hora']))->format('d/m/Y H:i')) ?></td>
                        <td><span class="badge text-bg-secondary"><?= htmlspecialchars($n['seccion']) ?></span></td>
                        <td style="min-width: 260px; white-space: pre-line;"><?= htmlspecialchars($n['novedad']) ?></td>
                        <td>
                            <?php if ($n['responsable_nombre'] !== null): ?>
                                <?= htmlspecialchars($n['responsable_apellido'] . ', ' . $n['responsable_nombre']) ?>
                            <?php else: ?>
                                <span class="text-muted">Usuario eliminado</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end text-nowrap">
                            <a href="<?= BASE_URL ?>/index.php?ctrl=novedades&accion=editar&id=<?= (int) $n['id'] ?>"
                               class="btn btn-icon btn-outline-accent me-1" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="post"
                                  action="<?= BASE_URL ?>/index.php?ctrl=novedades&accion=eliminar"
                                  class="d-inline"
                                  onsubmit="return confirm('¿Confirmás que querés eliminar esta novedad?');">
                                <input type="hidden" name="id" value="<?= (int) $n['id'] ?>">
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
                <?= count($novedades) ?> <?= count($novedades) === 1 ? 'registro' : 'registros' ?><?= $hayFiltros ? ' encontrados' : '' ?>
            </span>
        </div>
    </div>

</main>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
