## About simple-task-manager-lumen
A simple task manager using Lumen

Developed taking into:
- Apply good programming practices: consistency in names, spacing, indentation, etc.
- RESTful: URIs with nouns, using corresponding HTTP methods for CRUD.
- Validation of input data.
- Structure of BBDD created with migrations.
- Data access always made with Eloquent.
- "Eager loading" for loading related data.
- Always return Json.
- Simple Testing for PHPUnit Samples.
- CORS.
- JWT Authentication.
- Filters in collections returned (field filter returned, "Eager loading").


## Installation

1 - Clone the project:

```shell
git clone https://github.com/emiliogrv/simple-task-manager-lumen.git
```

2 - Enter the folder simple-task-manager-lumen

3 - Copy file .env.example to .env

4 - Open the `.env` file and configure the following with your data:

```shell
APP_KEY=

DB_DATABASE=db_db
DB_USERNAME=db_user
DB_PASSWORD=db_pass
```
The APP_KEY must be a string of 32 characters

5 - Execute:

```shell
$ php artisan jwt:secret
$ php artisan migrate:refresh --seed
```

With this and everything will be configured, now to use, you can create a VirtualHost with Apache / NGINX or use the following command for quick tests in place:

```shell
$ php -S localhost:8000 -t public
```

Ready!, available for testing at: http://localhost:8000


## Features

- Authentication.
- Simple CRUD for the three sections (users, tasks, priorities).
- Pagination of the main GETs.
- You can choose the fields returned with the "fields=foo,bar,..." attribute for the GET methods.
- For "users" you can bring your assigned tasks with the "with=tasks" attribute for the GET method (foo/{id}).
- CRUD verbs:
    - GET: foo -> (main), get all, default has a paging of 15.
    - GET: foo / {id} -> get a particular element, for "users" you can add the "with = tasks"
    - POST: foo -> creates a new element
    - PUT: foo / {id} -> updates the element fields with the provided attributes.
    - PUT: foo / {id} / restore -> restores a selected element, makes it accessible again.
    - DELETE: foo / {id} -> makes an element inaccessible using softDelete.
- .json file for use with Postman.


## License

[MIT License] (https://opensource.org/licenses/MIT) (MIT)