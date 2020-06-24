# Como mostrar imagenes en Laravel 

Para acceder a las imagenes que se tienen en laravel en el directorio de store/app/public, lo hacemos a través de un **Symlink o Symbolic Link**, esto nos permite 
apuntar a una carpeta de un directorio real. 
Para este caso necesitamos crear un Symlink  que apunte a la carpeta de storage
**public/storage => storage/app/public**
Dentro de laravel tenemos un comando llamdado storage link
* php artisan storage:link -h 
"Create the symbolic links configured for the application"
Nos muestra los parametros que necesita para crear el Symlink
* php artisan storage:link
Con este comando al ejecutar se habilita la ruta para que se pueda acceder a través de la url a las imagenes 

Dentro de la carpeta de public se puede ver una cargpea con un link o acceso directo que hace el vinculo para mostrar las imagenes que se tienen públicas en el storage



Lo que nos realiza este comando es que cuadno estemos accediento a nuestro proyecto para ver las imagenes las trae desde otro directorio 
https://laravel.test/storage => storage/app/public

Aplicado esto al proyecto accederiamos a una imagen de la siguiente forma: 
http://localhost:8000/storage/images/PN57dj2z8jD55rjCkgxLxqfe20uRkZcewW5Z0fRM.png

Para visualizar la imagen de nuestro proyecto nos vamos a las vistas, donde tenemos el directorio de las vistas de blade y buscamos en projects el archivo de index y show, por lo que validamos que exista al imagen con la url para ser visualizada. 
Cambiamos las listas por los card, tarjetas de presentación para los proyectos. 
