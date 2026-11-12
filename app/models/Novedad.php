<?php
namespace app\models;

use app\config\Database;
use PDO;
use PDOException;

class Novedad{
    public const SECCIONES = ['Máquina', 'Cubierta', 'Comunicaciones'];

    private PDO $db;

    private string $novedad = "";
    private string $fechaHora = "";        //formato MySQL: Y-m-d H:i:s
    private string $seccion = "Máquina";
    private int $responsableId = 0;

    public function __construct()
    {
        $this->db = Database::obtenerInstancia()->obtenerConexion();
    }

    //Consulta base: une con usuarios para mostrar el nombre del responsable
    private const SELECT = "SELECT n.id, n.novedad, n.fecha_hora, n.seccion, n.responsable_id,
                                   u.nombre AS responsable_nombre, u.apellido AS responsable_apellido
                            FROM novedades n
                            LEFT JOIN usuarios u ON u.id = n.responsable_id";

    public function crear(): bool{
        $sql = "INSERT INTO novedades (novedad, fecha_hora, seccion, responsable_id)
                VALUES (:novedad, :fecha_hora, :seccion, :responsable_id)";
        return $this->ejecutar($sql, [
            ':novedad' => $this->novedad, ':fecha_hora' => $this->fechaHora,
            ':seccion' => $this->seccion, ':responsable_id' => $this->responsableId,
        ], 'crear');
    }

    public function actualizar(int $id): bool{
        $sql = "UPDATE novedades
                SET novedad = :novedad, fecha_hora = :fecha_hora, seccion = :seccion, responsable_id = :responsable_id
                WHERE id = :id";
        return $this->ejecutar($sql, [
            ':novedad' => $this->novedad, ':fecha_hora' => $this->fechaHora,
            ':seccion' => $this->seccion, ':responsable_id' => $this->responsableId, ':id' => $id,
        ], 'actualizar');
    }

    public function eliminar(int $id): bool{
        return $this->ejecutar("DELETE FROM novedades WHERE id = :id", [':id' => $id], 'eliminar');
    }

    public function obtenerPorId(int $id): array | false{
        $stmt = $this->db->prepare(self::SELECT . " WHERE n.id = :id LIMIT 1");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    //Listado con filtros opcionales: texto de la novedad y sección. Más recientes primero.
    public function buscar(string $termino = '', string $seccion = ''): array{
        $sql = self::SELECT . " WHERE 1 = 1";
        $params = [];
        if ($termino !== '') {
            $sql .= " AND n.novedad LIKE :termino";
            $params[':termino'] = '%' . $termino . '%';
        }
        if ($seccion !== '') {
            $sql .= " AND n.seccion = :seccion";
            $params[':seccion'] = $seccion;
        }
        $sql .= " ORDER BY n.fecha_hora DESC, n.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    //Usuarios que pueden ser responsables (para el <select> del formulario)
    public function obtenerResponsables(): array{
        return $this->db->query("SELECT id, nombre, apellido, estado FROM usuarios ORDER BY apellido, nombre")->fetchAll();
    }

    public function existeResponsable(int $id): bool{
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM usuarios WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return (int) $stmt->fetchColumn() > 0;
    }

    private function ejecutar(string $sql, array $params, string $accion): bool{
        try{
            return $this->db->prepare($sql)->execute($params);
        }catch(PDOException $e){
            error_log("Error al {$accion} la novedad: " . $e->getMessage());
            return false;
        }
    }

    public function setNovedad(string $v): void{ $this->novedad = $v; }
    public function setFechaHora(string $v): void{ $this->fechaHora = $v; }
    public function setSeccion(string $v): void{ $this->seccion = $v; }
    public function setResponsableId(int $v): void{ $this->responsableId = $v; }
}
