# Queues o colas de trabajo / tareas

Nos permiten postergar la ejecución de las tareas pesadas para asi reponder mas agilmente al usuario. 
Normalmente la aplicación realiza una petición al servidor, pero esta petición requiere de la ejecución de algunas taras 
que consumen tiempo y esta debe esperar que termine para retornar la respuesta.
Las colas o queues nos permiten es delegar al ejecución de estas tareas aun momento posterior y asi poder reponder al usuario inmediatamente.

En este caso vamos a implementar a la cola de trabajo el listener para la optimización de las imagenes

Se puede enviar los listener directamente a las colas de trabajo, para implementar de la cola de trabajo en el listener se debe hacer
implementar la clase **ShouldQueue**
La clase quedaría de la siguiente forma: **class OptimizeProjectImage implements ShouldQueue**

Al momento de ejecutar una actividad como de crear o actualizar una imagen se sigue llevando el mismo tiempo, por lo que si 
se revisa el archivo **.env** en el driver **QUEUE_CONNECTION=sync** esta de forma sincronica, es decir que las tareas se ejecutan 
en la misma petición que realiza el usuario
Si revisamos en el archivo de la carpeta o directorio de **config** en el archivo **queue.php**, se puede observar los drives que
se tienen disponibles para configurar la conexión del queue
~~~
    Drivers: "sync", "database", "beanstalkd", "sqs", "redis", "null"
~~~
Cambiamos el driver que se tienen de forma sincronica a database, al cambiar esto y ejecutar el método store o update se 
dispara un error en pantalla el cual informa que de se necesita una tabla en la base de datos para poder ejecutar el registro de la tarea, 
por lo que se debe realizar la migración y por medio de la línea de comandos o terminal con el siguiente comando
**php artisan queue:table**, crea el archivo necesario para la migración, se puede verificar en la carpeta de **database/migrations**
Para ejecutar la migración se ejecuta el comando de **php artisan migrate**

Al vovler y ejecutar una acción del método de store o update se puede notar que la página web se ejecuta más rapida, pero la cola de trabajo
no se ha ejecutado ya que se guardo en la tabla de jobs de la base de datos. 
Para que se ejecute las colas de trabajo automaticamente es necesario tener encencido un **QUEUEWORKER**
**php artisan queue:work**
Con esto el job ya no esta en la tabla de la base de datos, por lo que ya se ejecuto.

* En resumen:
1. Defininir el dirver en .env: database, beanstalkd, sqs, redis
2. Driver database:
    - php artisan queue:table
    - php artisan migrate
3. Implementar la interfaz ShouldQueue
4. Encender el worker
    - php artisan queue:work


























