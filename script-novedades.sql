-- Módulo Novedades. Ejecutar en phpMyAdmin sobre la base gc_novedades (pestaña SQL).
USE gc_novedades;

CREATE TABLE IF NOT EXISTS novedades (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    novedad        TEXT NOT NULL,
    fecha_hora     DATETIME NOT NULL,
    seccion        ENUM('Máquina','Cubierta','Comunicaciones') NOT NULL,
    responsable_id INT NOT NULL,              -- id del usuario responsable (tabla usuarios)
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_fecha_hora (fecha_hora),
    INDEX idx_seccion (seccion),
    INDEX idx_responsable (responsable_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- OPCIONAL: clave foránea. Solo funciona si usuarios.id es del mismo tipo (INT, y mismo UNSIGNED o no).
-- Si da error 3780 / 1215, omitila: la aplicación ya valida que el responsable exista.
-- ALTER TABLE novedades ADD CONSTRAINT fk_novedad_usuario
--     FOREIGN KEY (responsable_id) REFERENCES usuarios(id);
