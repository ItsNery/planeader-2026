# Planeader

Sistema de Gestión de Planeación y Desarrollo Estatal y Municipal.

## Descripcion

Planeader es una plataforma web desarrollada en Laravel diseñada para facilitar la administración, publicación y consulta de instrumentos de planeación, como el Plan Estatal de Desarrollo (PED), Planes Municipales, programas derivados y documentos de los comités de planeación (COPLADEP y COPLADEMUN).

La aplicación cuenta con un portal público para la ciudadanía y un panel administrativo completo para la gestión de contenidos.

## Caracteristicas Principales

- **Gestion de Documentos:** Administración de documentos metodológicos, marcos jurídicos y herramientas de planeación.
- **Comites de Planeación:** Secciones dedicadas para COPLADEP y COPLADEMUN, incluyendo registro de usuarios y repositorio de documentos.
- **Planes de Desarrollo:** Visualización y descarga de Planes Estatales y Municipales.
- **Buscador y Regionalización:** Herramientas para filtrar información por regiones y municipios.
- **Capacitación:** Módulo para la difusión de cursos y materiales de capacitación municipal.
- **Panel Administrativo:** Interfaz segura gestionada con Laravel Jetstream y Livewire para el control total (CRUD) de los módulos.
- **Participacion Ciudadana:** Integración de formularios de contacto y consultas ciudadanas.

## Tecnologias Utilizadas

- **Backend:** PHP ^7.3 | ^8.0, Laravel 8.75
- **Frontend:** Blade, Livewire 2.5, Tailwind CSS
- **Autenticación:** Laravel Jetstream, Laravel Sanctum
- **Base de Datos:** MySQL (Compatible con MariaDB)
- **HTTP Client:** Guzzle
- **Seguridad:** No Captcha

## Requisitos del Sistema

Asegurate de tener instalado lo siguiente antes de comenzar:

- [PHP](https://www.php.net/) >= 7.3
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) & NPM

## Instalacion

Sigue estos pasos para desplegar el proyecto en tu entorno local:

1.  **Clonar el repositorio**

    ```bash
    git clone <URL_DEL_REPOSITORIO>
    cd planeader
    ```

2.  **Instalar dependencias de PHP**

    ```bash
    composer install
    ```

3.  **Configurar variables de entorno**
    Duplica el archivo de configuración de ejemplo y ajústalo a tu entorno local (Base de datos, URL, etc.).

    ```bash
    cp .env.example .env
    ```

4.  **Generar llave de la aplicación**

    ```bash
    php artisan key:generate
    ```

5.  **Base de Datos**
    Asegurate de crear una base de datos vacía y configurar las credenciales en el archivo `.env`. Luego ejecuta las migraciones:

    ```bash
    php artisan migrate
    ```

6.  **Instalar dependencias de Frontend**
    Compila los activos (CSS/JS).

    ```bash
    npm install && npm run dev
    ```

7.  **Crear enlace simbólico (Storage)**
    Necesario para la visualización de imágenes y documentos cargados.
    ```bash
    php artisan storage:link
    ```

## Uso

Para iniciar el servidor local de desarrollo:

```bash
php artisan serve
```

- **Portal Público:** Accede a `http://localhost:8000`
- **Panel Administrativo:** Accede a `http://localhost:8000/login` o `/dashboard` tras iniciar sesión.

## Licencia

Este proyecto está bajo la Licencia MIT. Consulta el archivo [LICENSE](LICENSE) para más detalles.
