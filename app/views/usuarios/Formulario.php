<?php
/**
 * app/views/usuarios/partials/formulario.php
 * Formulario compartido por las vistas de alta (crear.php) y edición (editar.php).
 *
 * Variables que debe definir la vista que lo incluye:
 *   $datos      (array)  nombre, email, rol, estado  -> valores actuales de los campos
 *   $errores    (array)  [campo => mensaje]          -> errores de validación del servidor
 *   $urlAccion  (string) a dónde se envía el formulario (POST)
 *   $textoBoton (string) texto del botón principal
 *   $id         (int)    solo en edición: se envía como campo oculto
 *
 * La validación definitiva se hace en el servidor (UsuarioController::validar),
 * por eso el formulario lleva "novalidate": así siempre se ven los mismos mensajes.
 */

// Devuelve ' is-invalid' si el campo tiene error (Bootstrap marca el borde en rojo).
$claseCampo = fn(string $campo): string => isset($errores[$campo]) ? ' is-invalid' : '';
?>

<form method="post" action="<?= htmlspecialchars($urlAccion) ?>" novalidate>

    <?php if (isset($id)): ?>
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

        <div class="col-12 col-md-6">
            <label for="nombre" class="form-label fw-medium">Nombre completo</label>
            <input type="text" id="nombre" name="nombre" maxlength="100" required
                   class="form-control<?= $claseCampo('nombre') ?>"
                   value="<?= htmlspecialchars($datos['nombre']) ?>">
            <?php if (isset($errores['nombre'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errores['nombre']) ?></div>
            <?php endif; ?>
        </div>

        <div class="col-12 col-md-6">
            <label for="email" class="form-label fw-medium">Correo electrónico</label>
            <input type="email" id="email" name="email" maxlength="150" required
                   class="form-control<?= $claseCampo('email') ?>"
                   value="<?= htmlspecialchars($datos['email']) ?>">
            <?php if (isset($errores['email'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errores['email']) ?></div>
            <?php endif; ?>
        </div>

        <div class="col-12 col-md-6">
            <label for="rol" class="form-label fw-medium">Rol</label>
            <select id="rol" name="rol" class="form-select<?= $claseCampo('rol') ?>">
                <?php foreach (\App\Models\Usuario::ROLES as $rol): ?>
                    <option value="<?= htmlspecialchars($rol) ?>" <?= $datos['rol'] === $rol ? 'selected' : '' ?>>
                        <?= htmlspecialchars($rol) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errores['rol'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errores['rol']) ?></div>
            <?php endif; ?>
        </div>

        <div class="col-12 col-md-6">
            <label for="estado" class="form-label fw-medium">Estado</label>
            <select id="estado" name="estado" class="form-select<?= $claseCampo('estado') ?>">
                <?php foreach (\App\Models\Usuario::ESTADOS as $estadoOpcion): ?>
                    <option value="<?= htmlspecialchars($estadoOpcion) ?>" <?= $datos['estado'] === $estadoOpcion ? 'selected' : '' ?>>
                        <?= htmlspecialchars($estadoOpcion) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errores['estado'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errores['estado']) ?></div>
            <?php endif; ?>
        </div>

    </div>

    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
        <a href="/ProyectoIntegradorPOOM2026/public/index.php?ctrl=usuarios&accion=index" class="btn btn-outline-secondary">Cancelar</a>
        <button type="submit" class="btn btn-accent">
            <i class="bi bi-check-lg me-1"></i> <?= htmlspecialchars($textoBoton) ?>
        </button>
    </div>
</form>