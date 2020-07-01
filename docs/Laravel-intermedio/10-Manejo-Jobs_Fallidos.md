# Manejo de Jobs Fallidos 

Que hacer cuando un jobs falla? 
Laravel implementa en la base de datos una tabla llamada **failed_jobs** la cual almacena los jobs que no se ejecutan 
correctamente. 
En caso de no tener la tabla en la base de datos,  se puede ejecutar los siguientes comandos para generar el archivo
de la migración y posteriormente ejecutarla
~~~
    php artisan queue:failed-table
    php artisan migrate
~~~

Cuando solucionamos el job que no se estaba ejecutando, se debe detener el work(Ctrl+C) del que y ejecutar el comando 
de **php artisan queue:retry** el cual se le pasa el id que se tiene en la tabla o si queremos pasar todos los jobs 
fallidos se utiliza el **all**, para pasarlos nuevamente a la tabla de los jobs para ser ejecutados por el worker.

En resumen: 
1. Cuando un Job falla se almacena en la tabla de de failed_jobs
2. Inspeccionamos el Job
3. Corregimos
4. Reintentamos el job
    php artisan queue:retry all
5. Reiniciamos el worker, parando la ejecución y continuando
    php artisan queue:worker

