# GestorTareas

**GestorTareas** es una aplicación web sencilla y moderna para la gestión de tareas, desarrollada con Symfony y Twig. Permite crear, listar, editar, marcar como completadas y eliminar tareas de forma intuitiva y eficiente.  

---

## Características principales

- Interfaz limpia y responsiva con Bootstrap y diseño personalizado.
- CRUD completo para tareas: crear, editar, eliminar y actualizar estado.
- Confirmación antes de eliminar para evitar borrados accidentales.
- Marcado visual claro de tareas completadas con estilo CSS.
- Feedback con mensajes flash para informar al usuario sobre acciones realizadas.
- Uso de AJAX para cambiar el estado de la tarea sin recargar la página.
- Header y footer personalizados para una experiencia agradable.

---

## Tecnologías utilizadas

- Symfony 5/6 (PHP)
- Twig para plantillas
- Bootstrap 5 para estilos y diseño responsive
- Fetch API para llamadas AJAX
- Doctrine ORM para gestión de base de datos

---

## Requisitos previos

- PHP 8.x
- Composer
- Servidor web (Apache, Nginx o Symfony CLI)
- Base de datos MySQL/MariaDB o compatible

---

## Instalación

1. Clonar el repositorio:

   ```bash
   git clone https://github.com/marcos318888/GestorTareas.git
   cd GestorTareas
   
Instalar las dependencias con Composer:
composer install

Configurar la base de datos en el archivo .env (ajusta los parámetros de conexión):
DATABASE_URL="mysql://usuario:contraseña@127.0.0.1:3306/nombre_base_datos"

Crear la base de datos (si no existe):
php bin/console doctrine:database:create

Ejecutar las migraciones para crear las tablas:
php bin/console doctrine:migrations:migrate

Uso
Ejecutar el servidor de desarrollo Symfony:
symfony server:start

Abrir el navegador y acceder a:
http://127.0.0.1:8000/

Utiliza la interfaz para crear, editar, completar o eliminar tareas.

Cómo funciona
La página principal muestra un listado con todas las tareas.
Cada tarea puede marcarse como completada o no con un botón que usa AJAX para no recargar.
Se puede editar o eliminar cada tarea usando formularios seguros.
Al eliminar, el sistema pide confirmación para evitar borrados accidentales.
Mensajes de éxito o advertencia se muestran tras cada acción.

