<?php
namespace app\controllers;
use app\models\Usuario;

//recibe las peticiones http relacionadas con usuarios

class UsuarioController{
    private Usuario $modelo;

    public function __construct()
    {
       $this->modelo = new Usuario();
    }

    //función para mostrar el listado de todos los usuarios
    public function index():void{
        $termino = trim($_GET['q'] ?? '');
        $estado = $_GET['estado'] ?? '';

        if(!in_array($estado, ['Activo', 'Inactivo'], true)){
            $estado = '';
        }

        $usuarios = ($termino !== '' || $estado !== '')
            ? $this->modelo->buscar($termino)
            : $this->modelo->obtenerTodos();

        $this->render('usuarios/index', [
            'usuarios' => $usuarios,
            'termino' => $termino,
            'estado' => $estado,
            'mensaje' => $this->tomarMensaje(),
        ]);
    }

    //ALTA NUEVO USUARIO
    public function crear():void{
        $this->render('usuarios/crear',
        ['datos' => ['nombre'=>'', 'email'=> '', 'rol'=>'Lector', 'estado'=>'Activo' ],
        'errores' => [],
        ]);
    }

    //FUNCION DE VALIDAR FORMULARIO DE ALTA SI ES CORRECTO INSERTA EL USUARIO
    public function guardar():void{
        $this->exigirPost();
        $datos = $this->leerFormulario();
        $errores = $this->validar($datos);

        if(empty($errores)){
            $this->cargarModelo($datos);
            
            if($this->modelo->crear()){
                $this->guardarMensaje('success', 'Usuario creado correctamente');
                $this->redirigir('usuarios', 'index');
            }
            $errores['general'] = 'No se pudo guardar el usuario. Intente nuevamente';
        }
        //hubo errores: se vuelve a mostrar el formulario conservando lo que escribio
        $this->render('usuarios/crear', compact('datos', 'errores'));
    }

    //FUNCION MODIFICACION
    public function editar():void {
        $id = $this->leerId(INPUT_GET);
        $usuario = $id != null ? $this->modelo->obtenerPorId($id): false;

        if(!$usuario){
            $this->guardarMensaje('danger', 'El usuario que queres editar no existe');
            $this->redirigir('usuarios', 'index');
        }
        $this->render('usuarios/editar', [
            'id' => $id,
            'datos' => $usuario,
            'errores' => [],
        ]);
    }

    //VALIDAR EL FORMULARIO DE EDICION Y SI ESTA CORRECTO ACTUALIZA EL USUARIO
    public function actualizar():void{
        $this->exigirPost();
        $id = $this->leerId(INPUT_GET);

        if($id == null || !$this->modelo->obtenerPorId($id)){
            $this->guardarMensaje('danger', 'El usuario que queres editar no existe');
            $this->redirigir('usuarios', 'index');
        }

        $datos = $this->leerFormulario();
        $errores = $this->validar($datos, $id);

        if(empty($errores)){
            $this->cargarModelo($datos);

            if($this->modelo->actualizar($id)){
                $this->guardarMensaje('success', 'Usuario actualizado correctamente');
                $this->redirigir('usuarios', 'index');
            }
            $errores['general'] = 'No se pudieron actualizar los datos correctamente, intentá de nuevo';

        }
        $this->render('usuarios/editar', compact('id', 'datos', 'errores'));
    }

    public function eliminar(): void{
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            $this->redirigir('Usuarios', 'index');
        }

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if($id == false || $id == null || $id <= 0){
            $this->guardarMensaje('danger', 'El identificador del usuaro no es válido');
        }elseif($this->modelo->eliminar($id)){
            $this->guardarMensaje('success', 'Usuario eliminado correctamente');
        }else{
            $this->guardarMensaje('danger', 'No se pudo eliminar el usuario');
        }

        $this->redirigir('usuarios', 'index');
    }

    private function validar(array $datos, ?int $idActual = null): array
    {
        $errores = [];
 
        // --- Nombre ---
        $largoNombre = mb_strlen($datos['nombre']);
        if ($largoNombre === 0) {
            $errores['nombre'] = 'El nombre es obligatorio.';
        } elseif ($largoNombre < 2) {
            $errores['nombre'] = 'El nombre debe tener al menos 2 caracteres.';
        } elseif ($largoNombre > 100) {
            $errores['nombre'] = 'El nombre no puede superar los 100 caracteres.';
        }
 
        // --- Correo ---
        if ($datos['email'] === '') {
            $errores['email'] = 'El correo electrónico es obligatorio.';
        } elseif (mb_strlen($datos['email']) > 150) {
            $errores['email'] = 'El correo no puede superar los 150 caracteres.';
        } elseif (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
            $errores['email'] = 'Ingresá un correo con formato válido, por ejemplo nombre@dominio.com.';
        } elseif ($this->modelo->existeEmail($datos['email'], $idActual)) {
            $errores['email'] = 'Ya existe un usuario registrado con ese correo.';
        }
 
        // --- Rol y estado (vienen de un <select>, pero un POST puede manipularse) ---
        if (!in_array($datos['rol'], Usuario::ROLES, true)) {
            $errores['rol'] = 'Elegí un rol de la lista.';
        }
        if (!in_array($datos['estado'], Usuario::ESTADOS, true)) {
            $errores['estado'] = 'Elegí un estado de la lista.';
        }
 
        return $errores;
    }

    //MÉTODOS AUXILIARES
    /** Lee y limpia los campos del formulario de alta/edición. */
    private function leerFormulario(): array
    {
        return [
            'nombre' => trim((string) ($_POST['nombre'] ?? '')),
            'email'  => strtolower(trim((string) ($_POST['email'] ?? ''))),
            'rol'    => (string) ($_POST['rol'] ?? ''),
            'estado' => (string) ($_POST['estado'] ?? ''),
        ];
    }

     /** Lee el parámetro "id" (GET o POST); devuelve null si no es un entero positivo. */
    private function leerId(int $tipoEntrada): ?int
    {
        $id = filter_input($tipoEntrada, 'id', FILTER_VALIDATE_INT);
        return ($id !== false && $id !== null && $id > 0) ? $id : null;
    }

      /** Pasa los datos ya validados al modelo. */
    private function cargarModelo(array $datos): void
    {
        $this->modelo->setNombre($datos['nombre']);
        $this->modelo->setEmail($datos['email']);
        $this->modelo->setRol($datos['rol']);
        $this->modelo->setEstado($datos['estado']);
    }

        /** Corta la ejecución si la petición no es POST. */
    private function exigirPost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('Usuarios', 'index');
        }
    }

    //Cargar una vista y le pasa las variables somo si fueran locales
    private function render(string $vista, array $datos = []):void{
        extract($datos);
        require __DIR__ . '/../views/' . $vista . '.php';
    }

    //Redirigir  (patrón Post/redirect/Get) y cortar la ejecución
    private function redirigir(string $ctrl, string $accion): void{
        header("Location: /ProyectoIntegradorPOOM2026/public/index.php?ctrl={$ctrl}&accion={$accion}");
        exit;
    }

    //Guardar los mensajes en sesión para mostrarlos en la próxima pantalla
    private function guardarMensaje(string $tipo, string $texto ):void{
        $_SESSION['mensaje'] = ['tipo' => $tipo, 'texto' => $texto];
    }

    //Lee el mensaje de sesión y lo borra (se muestra una sola vez)
    private function tomarMensaje(): ?array{
        $mensaje = $_SESSION['mensaje'] ?? null;
        unset($_SESSION['mensaje']);
        return $mensaje;
    }

}
?>