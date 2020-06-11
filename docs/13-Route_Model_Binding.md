# Route Model Binding
Cuando utilizamos el route model binding, este nos permite configurar todo lo que se necesita para configurar las urls 
y sean lo mas amigables para el usuario y el navegador indexarlas en los buscadores. 

Para obtener rutas mas amigables lo debemos  sobreescribir el método **getRouteKeyName()**, por defecto este método busca por el id de la tabla pero al ser sobreescrito se le puede expresar sobre que campo va ser la busqueda, 
el cual le indicaremos porque queremos buscar en nuestra base para generar las rutas amigables.

En este caso va buscar en el campo url de la tabla de proyectos
~~~
    public function getRouteKeyName(){
       return 'url';
    }
~~~

Para realizar esto se debe crear un nuevo campo en la tabla de proyectos llamado url, el cual nos permitira almacenar la url correspondiente
Debemos ir a la migración adicionar dicho campo o tambien desde la nueva migración donde se adiciono el telefono en migraciones anterirores.



