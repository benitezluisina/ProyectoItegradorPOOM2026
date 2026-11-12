<?php
namespace app\controllers;
use app\models\Novedad;
use DateTime;

//recibe las peticiones http relacionadas con novedades

class NovedadController{
    private Novedad $modelo;

    public function __construct()
    {
        $this->modelo = new Novedad();
    }

    public function index(): void{
        $termino = trim((string) ($_GET['q'] ?? ''));
        $seccion = (string) ($_GET['seccion'] ?? '');
        if (!in_array($seccion, Novedad::SECCIONES, true)) {
            $seccion = '';
        }

        $this->render('novedades/index', [
            'novedades' => $this->modelo->buscar($termino, $seccion),
            'termino'   => $termino,
            'seccion'   => $seccion,
            'mensaje'   => $this->tomarMensaje(),
        ]);
    }

    //ALTA: formulario vacío con fecha y hora actuales
    public function crear(): void{
        $this->mostrarFormulario('novedades/crear', [
            'datos' => ['novedad' => '', 'fecha_hora' => date('Y-m-d\TH:i'), 'seccion' => Novedad::SECCIONES[0], 'responsable_id' => ''],
            'errores' => [],
        ]);
    }

    public function guardar(): void{
        $this->exigirPost();
        $datos = $this->leerFormulario();
        $errores = $this->validar($datos);

        if (empty($errores)) {
            $this->cargarModelo($datos);
            if ($this->modelo->crear()) {
                $this->guardarMensaje('success', 'Novedad registrada correctamente');
                $this->redirigir('novedades', 'index');
            }
            $errores['general'] = 'No se pudo guardar la novedad. Intentá nuevamente.';
        }
        $this->mostrarFormulario('novedades/crear', compact('datos', 'errores'));
    }

    //MODIFICACIÓN
    public function editar(): void{
        $id = $this->leerId(INPUT_GET);
        $novedad = $id !== null ? $this->modelo->obtenerPorId($id) : false;

        if (!$novedad) {
            $this->guardarMensaje('danger', 'La novedad que querés editar no existe');
            $this->redirigir('novedades', 'index');
        }
        $novedad['fecha_hora'] = (new DateTime($novedad['fecha_hora']))->format('Y-m-d\TH:i');
        $this->mostrarFormulario('novedades/editar', ['id' => $id, 'datos' => $novedad, 'errores' => []]);
    }

    public function actualizar(): void{
        $this->exigirPost();
        $id = $this->leerId(INPUT_POST);

        if ($id === null || !$this->modelo->obtenerPorId($id)) {
            $this->guardarMensaje('danger', 'La novedad que querés editar no existe');
            $this->redirigir('novedades', 'index');
        }

        $datos = $this->leerFormulario();
        $errores = $this->validar($datos);

        if (empty($errores)) {
            $this->cargarModelo($datos);
            if ($this->modelo->actualizar($id)) {
                $this->guardarMensaje('success', 'Novedad actualizada correctamente');
                $this->redirigir('novedades', 'index');
            }
            $errores['general'] = 'No se pudo actualizar la novedad. Intentá nuevamente.';
        }
        $this->mostrarFormulario('novedades/editar', compact('id', 'datos', 'errores'));
    }

    public function eliminar(): void{
        $this->exigirPost();
        $id = $this->leerId(INPUT_POST);

        if ($id === null) {
            $this->guardarMensaje('danger', 'El identificador de la novedad no es válido');
        } elseif ($this->modelo->eliminar($id)) {
            $this->guardarMensaje('success', 'Novedad eliminada correctamente');
        } else {
            $this->guardarMensaje('danger', 'No se pudo eliminar la novedad');
        }
        $this->redirigir('novedades', 'index');
    }

    //VALIDACIÓN: devuelve [campo => mensaje]; vacío = todo correcto
    private function validar(array $datos): array{
        $errores = [];

        $largo = mb_strlen($datos['novedad']);
        if ($largo === 0) {
            $errores['novedad'] = 'La novedad es obligatoria.';
        } elseif ($largo < 5) {
            $errores['novedad'] = 'Describí la novedad con al menos 5 caracteres.';
        } elseif ($largo > 1000) {
            $errores['novedad'] = 'La novedad no puede superar los 1000 caracteres.';
        }

        if ($datos['fecha_hora'] === '') {
            $errores['fecha_hora'] = 'La fecha y hora son obligatorias.';
        } elseif ($this->parsearFecha($datos['fecha_hora']) === null) {
            $errores['fecha_hora'] = 'Ingresá una fecha y hora válidas.';
        }

        if (!in_array($datos['seccion'], Novedad::SECCIONES, true)) {
            $errores['seccion'] = 'Elegí una sección de la lista.';
        }

        $responsable = filter_var($datos['responsable_id'], FILTER_VALIDATE_INT);
        if ($datos['responsable_id'] === '') {
            $errores['responsable_id'] = 'Elegí el responsable de la novedad.';
        } elseif ($responsable === false || $responsable < 1 || !$this->modelo->existeResponsable($responsable)) {
            $errores['responsable_id'] = 'El responsable elegido no existe.';
        }

        return $errores;
    }

    //MÉTODOS AUXILIARES
    private function leerFormulario(): array{
        return [
            'novedad'        => trim((string) ($_POST['novedad'] ?? '')),
            'fecha_hora'     => trim((string) ($_POST['fecha_hora'] ?? '')),
            'seccion'        => (string) ($_POST['seccion'] ?? ''),
            'responsable_id' => trim((string) ($_POST['responsable_id'] ?? '')),
        ];
    }

    //El input datetime-local envía "2026-11-12T14:30"; devuelve null si no es una fecha real
    private function parsearFecha(string $texto): ?DateTime{
        $f = DateTime::createFromFormat('Y-m-d\TH:i', $texto);
        $errs = DateTime::getLastErrors();
        if ($f === false || ($errs && ($errs['warning_count'] > 0 || $errs['error_count'] > 0))) {
            return null;
        }
        return $f;
    }

    private function cargarModelo(array $datos): void{
        $this->modelo->setNovedad($datos['novedad']);
        $this->modelo->setFechaHora($this->parsearFecha($datos['fecha_hora'])->format('Y-m-d H:i:s'));
        $this->modelo->setSeccion($datos['seccion']);
        $this->modelo->setResponsableId((int) $datos['responsable_id']);
    }

    //Renderiza un formulario agregando la lista de responsables
    private function mostrarFormulario(string $vista, array $datos): void{
        $datos['responsables'] = $this->modelo->obtenerResponsables();
        $this->render($vista, $datos);
    }

    private function leerId(int $tipoEntrada): ?int{
        $id = filter_input($tipoEntrada, 'id', FILTER_VALIDATE_INT);
        return ($id !== false && $id !== null && $id > 0) ? $id : null;
    }

    private function exigirPost(): void{
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('novedades', 'index');
        }
    }

    private function render(string $vista, array $datos = []): void{
        extract($datos);
        require __DIR__ . '/../views/' . $vista . '.php';
    }

    private function redirigir(string $ctrl, string $accion): void{
        header('Location: ' . BASE_URL . "/index.php?ctrl={$ctrl}&accion={$accion}");
        exit;
    }

    private function guardarMensaje(string $tipo, string $texto): void{
        $_SESSION['mensaje'] = ['tipo' => $tipo, 'texto' => $texto];
    }

    private function tomarMensaje(): ?array{
        $mensaje = $_SESSION['mensaje'] ?? null;
        unset($_SESSION['mensaje']);
        return $mensaje;
    }
}
