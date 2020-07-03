# Problemas de consultas N+1
En esta lección aprendemos sobre el problema de consultas N+1, cómo detectarlo y cómo solucionarlo modificando las consultas con Eloquent.

A nivel de vista de blade se mejora la visualización de las categoría, y en vista de que no todos tienen categorías algunos campos que se tienen en null, al ejecutar 
la impresión del campo de category_id, se visualizara un error, por lo que se puede verificar mediante un if si el campo tiene category_id
~~~
    @if ($project->category_id)
        <a href="#" class="badge badge-secondary">{{$project->category->name}} </a>                                
    @endif
~~~

En el archivo web.php de rutas podemos escuchar todas las peticiones que se realizan a nivel de sql de consutlas
~~~
    DB::listen(function($query){
        var_dump($query->sql);
    });
~~~
Esto nos mostra las consutlas generadas en cada parte de nuestra página
Al ver tanto se puede conocer como el problema de **N+1**, esto quiere decir que por cada proyecto se esta haciendo una consulta adicional, lo cual a futuro al incrementar 
mas proyectos, se puede volver lenta nuestra aplicación.

Para solucionar esto se puede solucionar precargando la relacion que se tiene.
Nos ubicamose en el archivo del controlador de proyectos  en el método de index. 
En el retorno indicamos que se incluya la relación del metodo category
~~~
    'projects' => Project::with('category')->latest()->paginate(5)
~~~

Tenemos un paquete llamado laravel-debugbar, el cual nos muestra en una barra las estadisticas de las consultas que se generan y demás estadisticas importantes. 