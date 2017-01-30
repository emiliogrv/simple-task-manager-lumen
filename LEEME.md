## Acerca de simple-task-manager-lumen
Un simple manejador de tareas usando Lumen

Desarrollado tomando en cuenta:
- Aplicar buenas prácticas de programación: consistencia en nombres, espaciado, indentado, etc.
- RESTful: las URIs con sustantivos, utilizando para el CRUD los métodos HTTP correspondientes.
- Validación de los datos de entrada.
- Estructura de BBDD creada con migraciones.
- Acceso a datos realizado siempre con Eloquent.
- "Eager loading" para la carga de datos relacionados.
- Siempre devolver Json.
- Pruebas simples para muestra con PHPUnit.
- CORS.
- Autenticación por JWT.
- Filtros en las colecciones devueltas (filtro de campos devueltos, "Eager loading").


## Instalación

1 - Clona el proyecto:

```shell
git clone https://github.com/emiliogrv/simple-task-manager-lumen.git
```

2 - Entra en la carpeta simple-task-manager-lumen

3 - Copia el archivo .env.example a .env

4 - Abre el archivo `.env` y configura lo siguiente con tus datos:

```shell
APP_KEY=

DB_DATABASE=db_db
DB_USERNAME=db_user
DB_PASSWORD=db_pass
```

El APP_KEY debe ser una cadena de 32 caracteres

5 - Ejecuta:

```shell
$ php artisan jwt:secret
$ php artisan migrate:refresh --seed
```

Con esto ya todo estará configurado, ahora a usar, se puede crear una VirtualHost con Apache / NGINX o usar el siguiente comando para pruebas rápidas en local:

```shell
$ php -S localhost:8000 -t public
```

!listo¡, disponible para pruebas en: http://localhost:8000


## Características

- Autenticación.
- CRUD simple para las tres secciones (users, tasks, priorities).
- Paginado de los GET principales.
- Se pueden elegir los campos devueltos con el atributo "fields=foo,bar,..." para los métodos GET.
- Para los "users" se pueden traer sus tareas asignadas con el atributo "with=tasks" para el método GET (foo/{id}).
- Verbos del CRUD:
    - GET: foo -> (principal), obtiene todos, por defecto tiene un paginado de 15.
    - GET: foo/{id} -> obtiene un elemento en particular, para los "users" se puede agregar el atributo "with=tasks"
    - POST: foo -> crea un nuevo elemento
    - PUT: foo/{id} -> actualiza los campos del elemento con los atributos proporcionados.
    - PUT: foo/{id}/restore -> restaura un elemento seleccionado, hace que sea accesible de nuevo.
    - DELETE: foo/{id} -> hace inaccesible un elemento mediante softDelete.
- Archivo .json para usar con Postman.


## Licencia

[MIT License](https://opensource.org/licenses/MIT) (MIT)