# Sistema ABM — Gestión de Novedades (PHP OOP + PDO + MVC)

Aplicación web para la **gestión de datos (Alta, Baja y Modificación)** desarrollada en **PHP orientado a objetos**, con conexión a base de datos mediante **PDO (sentencias preparadas con parámetros)**, siguiendo el patrón de arquitectura **MVC (Modelo-Vista-Controlador)**. El frontend está construido con **Bootstrap 5**.

## 🧱 Stack tecnológico

- **Backend:** PHP (POO)
- **Base de datos:** MySQL / MariaDB, acceso vía **PDO** con parámetros (prepared statements)
- **Arquitectura:** MVC (Modelo - Vista - Controlador)
- **Frontend:** Bootstrap 5.3 + Bootstrap Icons
- **Tipografía:** Google Fonts (Poppins / Inter)
- **Entorno local:** XAMPP (Apache + MySQL)

## 📌 Estado actual del proyecto

### ✅ Completado

- **Definición de la estructura de directorios** del proyecto, separando responsabilidades según el patrón MVC (`app/models`, `app/controllers`, `app/views`, `config`, `public`).
- **Diseño del frontend base**, con componentes visuales diferenciados y reutilizables:
  - `header.php` → `<head>` del documento (metadatos, fuentes, Bootstrap, íconos).
  - `navbar.php` → barra de navegación superior, independiente y reutilizable en todas las vistas.
  - `footer.php` → pie de página con accesos rápidos, información del entorno y carga de scripts.
  - Vista de **listado de usuarios** (`app/views/usuarios/index.php`) con tabla de datos, buscador, filtro por estado, badges de estado y acciones (editar/eliminar).
- **Identidad visual propia** sobre Bootstrap (`public/css/estilos.css`): paleta de colores personalizada (azul noche + verde esmeralda), tipografía diferenciada y componentes propios (cards, badges, botones de acción).

### 🔜 Próximos pasos

- [ ] Clase `Database.php` (conexión PDO tipo Singleton) en `config/`.
- [ ] Modelo `Usuario.php` con métodos CRUD (`crear`, `obtenerTodos`, `obtenerPorId`, `actualizar`, `eliminar`) usando sentencias preparadas.
- [ ] Controlador `UsuarioController.php` para coordinar peticiones entre modelo y vista.
- [ ] Vistas de **alta** (`crear.php`) y **edición** (`editar.php`) de usuarios.
- [ ] Front controller (`public/index.php`) con enrutamiento básico por parámetros (`?ctrl=usuarios&accion=index`).
- [ ] Validaciones de formulario (frontend y backend).
- [ ] Conexión real a la base de datos y reemplazo de los datos de ejemplo por datos dinámicos.

## 📂 Estructura de carpetas (avance actual)

```
mi_proyecto/
├── app/
│   └── views/
│       ├── partials/
│       │   ├── header.php
│       │   ├── navbar.php
│       │   └── footer.php
│       └── usuarios/
│           └── index.php
│
└── public/
    ├── css/
    │   └── estilos.css
    └── js/
        └── scripts.js
```

> La estructura completa del proyecto (incluyendo `config/`, `app/models/`, `app/controllers/`) se irá incorporando a medida que avancemos con la lógica de conexión y el CRUD.

## ⚙️ Instalación local (XAMPP)

1. Cloná o copiá este repositorio dentro de la carpeta `htdocs` de XAMPP:
   - Windows: `C:\xampp\htdocs\mi_proyecto`
   - Linux: `/opt/lampp/htdocs/mi_proyecto`
   - macOS: `/Applications/XAMPP/htdocs/mi_proyecto`
2. Iniciá los servicios **Apache** y **MySQL** desde el panel de control de XAMPP.
3. Accedé desde el navegador a `http://localhost/mi_proyecto/public/index.php`.

## 📝 Notas

- Las rutas de assets (`css`, `js`) y de navegación están armadas con ruta absoluta `/mi_proyecto/public/...`. Si el nombre de la carpeta del proyecto cambia, hay que actualizar esas rutas (o migrar a una constante `BASE_URL`).
- Actualmente la vista de usuarios utiliza **datos de ejemplo estáticos** solo para maquetar el diseño; serán reemplazados por datos reales una vez implementada la capa de conexión (PDO) y el modelo correspondiente.

---

*Proyecto en desarrollo — próxima actualización: capa de conexión a base de datos (PDO) y CRUD del modelo `Usuario`.*
