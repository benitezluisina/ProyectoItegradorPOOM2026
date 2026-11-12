<?php
/**
 * app/views/novedades/Formulario.php
 * Formulario compartido por crear.php y editar.php.
 * Variables: $datos, $errores, $responsables, $urlAccion, $textoBoton, $id (solo en edición)
 */
$claseCampo = fn(string $campo): string => isset($errores[$campo]) ? ' is-invalid' : '';
$esEdicion = isset($id);
?>
<form method="post" action="<?= htmlspecialchars($urlAccion) ?>" novalidate>

    <?php if ($esEdicion): ?>
        <input type="hidden" name="id" value="<?= (int) $id ?>">
    <?php endif; ?>

    <?php if (!empty($errores)): ?>
        <div class="alert alert-danger" role="alert">
            <?= isset($errores['general'])
                ? htmlspecialchars($errores['general'])
                : 'Revisá los campos marcados en rojo antes de continuar.' ?>
        </div>
    <?php endif; ?>

    <div class="row g-3">

        <div class="col-12">
            <label for="novedad" class="form-label fw-medium">Novedad</label>
            <textarea id="novedad" name="novedad" rows="4" maxlength="1000" required
                      class="form-control<?= $claseCampo('novedad') ?>"><?= htmlspecialchars((string) ($datos['novedad'] ?? '')) ?></textarea>
            <?php if (isset($errores['novedad'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errores['novedad']) ?></div>
            <?php endif; ?>
        </div>

        <div class="col-12 col-md-4">
            <label for="fecha_hora" class="form-label fw-medium">Fecha y hora</label>
            <input type="datetime-local" id="fecha_hora" name="fecha_hora" required
                   class="form-control<?= $claseCampo('fecha_hora') ?>"
                   value="<?= htmlspecialchars((string) ($datos['fecha_hora'] ?? '')) ?>">
            <?php if (isset($errores['fecha_hora'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errores['fecha_hora']) ?></div>
            <?php endif; ?>
        </div>

        <div class="col-12 col-md-4">
            <label for="seccion" class="form-label fw-medium">Sección</label>
            <select id="seccion" name="seccion" class="form-select<?= $claseCampo('seccion') ?>">
                <?php foreach (\app\models\Novedad::SECCIONES as $s): ?>
                    <option value="<?= htmlspecialchars($s) ?>" <?= ($datos['seccion'] ?? '') === $s ? 'selected' : '' ?>>
                        <?= htmlspecialchars($s) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errores['seccion'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errores['seccion']) ?></div>
            <?php endif; ?>
        </div>

        <div class="col-12 col-md-4">
            <label for="responsable_id" class="form-label fw-medium">Responsable</label>
            <select id="responsable_id" name="responsable_id" class="form-select<?= $claseCampo('responsable_id') ?>">
                <option value="">Elegí un responsable…</option>
                <?php foreach ($responsables as $r): ?>
                    <option value="<?= (int) $r['id'] ?>" <?= (string) ($datos['responsable_id'] ?? '') === (string) $r['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($r['apellido'] . ', ' . $r['nombre']) ?><?= $r['estado'] === 'Inactivo' ? ' (inactivo)' : '' ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errores['responsable_id'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errores['responsable_id']) ?></div>
            <?php endif; ?>
        </div>

    </div>

    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
        <a href="<?= BASE_URL ?>/index.php?ctrl=novedades&accion=index" class="btn btn-outline-secondary">Cancelar</a>
        <button type="submit" class="btn btn-accent">
            <i class="bi bi-check-lg me-1"></i> <?= htmlspecialchars($textoBoton) ?>
        </button>
    </div>
</form>
