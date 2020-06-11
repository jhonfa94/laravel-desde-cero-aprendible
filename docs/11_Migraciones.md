# Migraciones
Son un control que se llevan para el control de la base de datos.
Permiten crear y modificar facilmente las tablas de una forma mas sencilla en donde se permite destruir y reconstuir el esquema de una base de datos sin ninguna dificulta
Todo esto se hace a partir de un comando en la térmianal.
Por defecto laravel trae las migraciones en la carpeta database/migrations, las cuales son las tablas para crear usuarios y el restablecimiento de las contraseñas
Estan creadas por la fecha en que fueron creadas, seguidas por la acción que se realiza,

Toda migración debe llevar dos métodos el up y el down
- El método up se utiliza para agregar tablas y columnas o index a la base de  datos
- El método down revirte las operaciones realizadas por el método up, en conclusión hace lo contrario

# EJECUTAR LA MIGRACIÓN 
Para ejecutar la migración se hace a través de la consola o términal, no olvidar que se debe tener configurada la base de datos en en las variables de entorno.
El comando para ejecutar la migración es: 
* php artisan migrate
Automáticamente se ejecuta la migración, y se crean las tablas en la base de datos.

El comando para deshacer las migraciones o borrar las tablas es:
* php artisan migrate:rollback
Con esto se borran todas las tablas que llevan migraciones y en la tabla de migraciones se borran lo registros que se tienen

# Ejecutar el rollback para la última migración que se ha relizado
Solament se debe especificar en el comando que se realice al paso anterior 
* php artisan migrate:rollback --step=1

# Referescar la migración.
Si se hacen cambios durante el desarrollo, por ejemplo se anexa el campo telefono a la tabla usuarios, implicaria volver a ejecutar el rollback y volver a ejecutar nuevamente la migración para que se pueda ver todo actualizado.
Para ello se utilzia el migrate:refresh 
Con este comando quita y vuelve a crear las tablas 
* ph artisan migrate:fresh

Si luego de tener información en la base de datos vamos a agregar un nuevo campo, por ejemplo dirección al ejecutar el comando php artisan migrate:fresh agrega el nuevo campo, 
pero se pierde la información, esto se soluciona de la siguiente manera.

Al momento de ejecutar la migración al inicio debemos darle un nombre
Tomando como ejemplo la migración que laravel nos da de la tabla de los usuarios, 
restablecemos todo a por defecto, es decir se quitara el  campo de telefono y se creara nuevamente la tabla ejecutando el fresh

Si se agregamos cambios a la base de datos en nuevos campos se debe especificar despues de el comando de migrade una descripción.

* php artisan make:migration add_phone_to_users_table
Laravel detecta que automaticamente entre el **_to_** nombre de la tabla se va hacer una nueva migración para configurar el nuevo campo, al ejecutar el comando se nos crea el archivo 
add_phone_to_users_table dentro de las migraciones listo para ser configrado, en donde se debe crear el campo de phone en el método up y luego en down borrar la columna 

Procedemos a crear los nuevos campos.
En el método up para crar el nuevo campo
- $table->string('phone')->nullable();
Se especifica que se creara una nuevo campo de tipo string llamado phone y que es null

En el método down
$table->dropColumn('phone');
Se especifica que se eliminara la columna con el nombre phone

Si estamos utilziando una base de datos sqlite debemos instalar  el paquete dbal
* composer require doctrine/dbal

Ya con los cambios realizados se procede a ejecutar la migración para que el campo phone sea agregado a la tabla y no altere o borre el resto de la información.

Si queremos que el campo phone se agregue despues del email se debe especificar lo siguiente:
* $table->string('phone')->after('email')->nullable();
Especificar el after despues de, y se especifica el nombre de la columna.

Para ejecutar el cambio, se debe deshacer el último cambio de la migración con el rollback
* php artisan migrate:rollback
Y luego volver a ejecutar la migración.
* php artisan migrate

# Creando la migración para la tabla de proyectos
* php artisan make:migration create_projects_table