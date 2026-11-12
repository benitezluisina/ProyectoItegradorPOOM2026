<?php
namespace app\models;

use app\config\Database;
use PDO;
use PDOException;

class Usuario{
    /** Valores permitidos (los usan la validación y los <select> de los formularios) */
    public const ROLES   = ['Administrador', 'Editor', 'Lector'];
    public const ESTADOS = ['Activo', 'Inactivo'];

    private PDO $db;

    //propiedades del objeto usuario
    private ?int $id = null;
    private string $nombre = "";
    private string $apellido = "";
    private string $email = "";
    private string $rol = "Lector";
    private string $estado = "Activo";
    private int $dni = 0;   //valor inicial: una propiedad tipada sin valor da error fatal al usarla
    private string $fechaCreacion = "";

    public function __construct()
    {
        //obtiene la conexión unica definida en database.php
        $this->db = Database::obtenerInstancia()->obtenerConexion();
    }

    //METODOS DE ALTA, BAJA, MODIFICACIÓN Y LECTURA DE USUARIOS
    //método crear
    public function crear(): bool{
        $sql = "INSERT INTO usuarios (nombre, apellido, email, rol, estado, dni) VALUES (:nombre, :apellido, :email, :rol, :estado, :dni)";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apellido', $this->apellido, PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':rol', $this->rol, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $this->estado, PDO::PARAM_STR);
        $stmt->bindParam(':dni', $this->dni, PDO::PARAM_INT);

        try{
            return $stmt->execute();
        }catch(PDOException $e){
            error_log("Error al crear el usuario: " . $e->getMessage());
            return false;
        }
    }

    //Lectura de los registros de la tabla usuarios
    public function obtenerTodos():array{
        $sql = "SELECT id, nombre, email, apellido, dni, rol, estado, fecha_creacion
                FROM usuarios
                ORDER BY  id DESC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    //Lectura de un sólo usuario. Se va utilizar para el formulario ver y editar
    public function obtenerPorId(int $id): array | false{
        $sql = "SELECT id, nombre, email, apellido, dni, rol, estado, fecha_creacion
                FROM usuarios
                WHERE id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    //Búsqueda de usuarios por nombre, apellido o mail, y opcionalmente por estado.
    //Con ATTR_EMULATE_PREPARES = false MySQL no permite repetir un mismo parámetro nombrado
    //en la consulta (error HY093): por eso :nombre, :apellido y :email son tres parámetros distintos.
    public function buscar(string $termino, string $estado = ''): array{
        $sql = "SELECT id, nombre, email, apellido, dni, rol, estado, fecha_creacion
                FROM usuarios
                WHERE (nombre LIKE :nombre OR apellido LIKE :apellido OR email LIKE :email)";

        if($estado !== ''){
            $sql .= " AND estado = :estado";
        }
        $sql .= " ORDER BY id DESC";

        $stmt = $this->db->prepare($sql);
        $valorbusqueda = '%'.$termino.'%';
        $stmt->bindParam(':nombre', $valorbusqueda, PDO::PARAM_STR);
        $stmt->bindParam(':apellido', $valorbusqueda, PDO::PARAM_STR);
        $stmt->bindParam(':email', $valorbusqueda, PDO::PARAM_STR);
        if($estado !== ''){
            $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
        }
        $stmt->execute();

        return $stmt->fetchAll();
    }

    //Modificación de los registros (el DNI no se modifica)
    public function actualizar(int $id): bool{
        $sql = "UPDATE usuarios
                SET nombre = :nombre,
                    apellido = :apellido,
                    email = :email,
                    rol = :rol,
                    estado = :estado
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apellido', $this->apellido, PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':rol', $this->rol, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $this->estado, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        try{
            return $stmt->execute();
        }catch (PDOException $e){
            error_log("Error al actualizar el usuario: ". $e->getMessage());
            return false;
        }
    }

    //Baja de usuarios
    public function eliminar(int $id): bool{
        $sql = "DELETE FROM usuarios
                    WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        try{
            return $stmt->execute();
        }catch (PDOException $e){
            error_log("Error al eliminar el usuario: ". $e->getMessage());
            return false;
        }
    }

    //Baja lógica: no borra el registro, lo pasa a Inactivo
    public function eliminarBis(int $id): bool{
        $sql = "UPDATE usuarios
                SET estado = :estado
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $estadoAct = "Inactivo";
        $stmt->bindParam(':estado', $estadoAct, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        try{
            return $stmt->execute();
        }catch (PDOException $e){
            error_log("Error al inhabilitar el usuario: ". $e->getMessage());
            return false;
        }
    }

    /**
     * VALIDACIÓN: indica si ya existe un usuario con ese correo.
     * Al editar se pasa $excluirId para no compararlo consigo mismo.
     */
    public function existeEmail(string $email, ?int $excluirId = null): bool
    {
        $sql = "SELECT COUNT(*) FROM usuarios WHERE email = :email";
        if ($excluirId !== null) {
            $sql .= " AND id <> :id";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        if ($excluirId !== null) {
            $stmt->bindParam(':id', $excluirId, PDO::PARAM_INT);
        }
        $stmt->execute();

        return (int) $stmt->fetchColumn() > 0;
    }

    //Getters y Setters
    public function getId(): ?int{
        return $this->id;
    }
    public function setId(int $id): void{
        $this->id = $id;
    }

    public function getNombre(): string{
        return $this->nombre;
    }
    public function setNombre(string $nombre): void{
        $this->nombre = $nombre;
    }

    public function getApellido(): string{
        return $this->apellido;
    }
    public function setApellido(string $apellido): void{
        $this->apellido = $apellido;
    }

    public function getEmail(): string{
        return $this->email;
    }
    public function setEmail(string $email): void{
        $this->email = $email;
    }

    public function getRol(): string{
        return $this->rol;
    }
    public function setRol(string $rol): void{
        $this->rol = $rol;
    }

    public function getEstado(): string{
        return $this->estado;
    }
    public function setEstado(string $estado): void{
        $this->estado = $estado;
    }

    public function getDni(): int{
        return $this->dni;
    }
    public function setDni(int $dni): void{
        $this->dni = $dni;
    }

    public function getFechaCreacion(): string{
        return $this->fechaCreacion;
    }
    public function setFechaCreacion(string $fechaCreacion): void{
        $this->fechaCreacion = $fechaCreacion;
    }

}
