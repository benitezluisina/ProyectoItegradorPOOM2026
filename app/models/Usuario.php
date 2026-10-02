<?php
namespace app\models;

use app\config\Database;
use PDO;
use PDOException;

class Usuario{
    private PDO $db;

    //propiedades del objeto usuario
    private ?int $id = null;
    private string $nombre = "";
    private string $apellido = "";
    private string $email = "";
    private string $rol = "Lector";
    private string $estado = "Activo";
    private int $dni;

    public function __construct()
    {
        //obtiene la conexión unica definida en database.php
        $this->db = Database::obtenerInstancia()->obtenerConexion();
    }

    //METODOS DE ALTA, BAJA, MODIFICACIÓN Y LECTURA DE USUARIOS
    //método crar
    public function crear(): bool{
        $sql = "INSERT INTO usuarios (nombre, apellido, email, rol, estado, dni) VALUES (:nombre, :apellido, :email, :rol, :estado, :dni)";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apellido', $this->apellido, PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':rol', $this->rol, PDO::PARAM_STR);
        $stmt->bindParam('estado', $this->estado, PDO::PARAM_STR);
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
        $sql = "SELECT id, nombre, apellido, dni, rol, estado, fecha_creacion
                FROM usuarios
                ORDER BY  id DESC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

}

?>