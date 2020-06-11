# Eloquent: Obetner datos
Para obtener la información de la base de datos, lo hacemos mediante Eloquent, que nos ayuda a realizar las consultas con la base de datos y asi visualizar la información en la vista.

El query builder es un constructor de consultas.

Para esto vamos a trabajar en el controlardor del protafolio.
Podemos llamar la información de la tabla de la siguiente forma:
* $portafolio = DB::table('projects')->get();
Donde: 
- portafolio es la varibale donde se esta almacenando la consulta
- DB LLama a la clase para hacer la instancia de la base de datos
- ::table('projects') se especifica que se esta llamando  a la tabla de projects
- ->get() especificamos que los metodos van a hacer por medio de get, trae todo.

Sin embargo Laravel tiene su propia forma de hacer consultas a la DB, por medio su ORM llamdo Eloquent

# ORM => Object-Relational Mapping || Mapeo Objeto-Relacional
Se trata de convertir Datos de la DB => Calse/Objeto PHP o viceversa

Eloquent tiene el patron Active Record, en el que basicamente añade metodos como save(), delete(), update() ....
Para interactuar con la DB en forma de objetos
Por cada tabla de la Base de datos debemos especificar un modelo que la represente en Laravel

# Crear un modelo
Podemos ver la ayuda que nos da la consola
* php artisan make:model -h
Nos visualiza todo lo que se tiene disponible 

Temos la opción para crear la migración directamente y asi ahorrarnos tiempo
* php artisan make:model MyModel -m

Para crear los modelos se deben hacer en camel case
* php artisan make:model Project

Por defecto los modelos se crean en la carpeta app a raiz de carpeta

Eloquent asume en su configuración por defecto que de acuerdo al nombre que se le dio en forma singular se conectara a la tabla, ejemplo:
- Creamos  una tabla en la DB llamada projects, pero el modelo fue creado llmado Project, internamente en el modelo de Project asume que hay una tabla llamada projects, sino es el caso podemos especificar internamente en el modelo de la siguiente forma: 
protected $table = 'my_table';

Utilizando el query builder para realizar consultas a la DB en el controlador
~~~
    $portafolio = DB::table('projects')->get();
~~~

Con esto ya no utilizamos la clase DB en el controlador.

Utilizando el modelo Eloquent en el controlador quedaria de la siguiente forma para adquiir los datos
**$portafolio = Project::get();**
Automáticamente nos muestra los registros en la visata tal cual se llaman de la base de datos, pero si queremos especificar el orden lo hacemos de la siguiente forma
**$portafolio = Project::orderBy('created_at','DESC')->get();**
En lo anterior especificamos que se ordenen de forma descendente por el campo de la db llamado create_at

Tambien tenemos el método lastest que lo que hace es ordenar de forma descendente
**$portafolio = Project::lastest('updated_at')->get();**

~~~
    // $portafolio = Project::get(); # Eloquent muestra todos los datos
    // $portafolio = Project::orderBy('created_at','DESC')->get(); # Muestra de forma descendente por el campo create_at
    // $portafolio = Project::latest()->get(); # Por defecto filtra sobre el campo create_at, si quiere ordernar por otro campo se le especifica el campo en el método
    $portafolio = Project::latest()->paginate(2); # Por defecto filtra sobre el campo create_at, y el paginate muestra por defecto 15 registros y se personaliza dentro del método en este caso para visualizar 2 registros como maximo por página
~~~

https://carbon.nesbot.com/docs/las 
En laravel podemos tratar las fechas que tenemos en la tabla como objetos, con carbon nos ayuda a personlizar la fecha
En nuestro portafolio.blade.php temos el siguiente código
<ul>        
    @forelse ($portafolio as $portafolioItem)
            <li> {{ $portafolioItem->title }} <br> 
            <small> {{ $portafolioItem->description }}  </small> <br>
            {{ $portafolioItem->created_at->format('Y-m-d') }} <br>
            {{ $portafolioItem->updated_at->diffForHumans() }} 
            {{-- <small> {{ $loop->first ? 'Es el Primero' : ''}}  </small> 
            <small> {{ $loop->last ? 'Es el último' : ''}}  </small>  --}} 
        </li>    
    @empty
            <li> No hay proyectos para mostrar </li>                
    @endforelse    
</ul>

# Paginación
Disponemos de una paginación en laravel utilizando el paginate, por defecto lista 15 registros por pagina pero 
podemos personalizar esto, asignadole el valor que deseemos.Esto se hace en el controaldor
**$portafolio = Project::orderBy('created_at','DESC')->paginate(3); || Escificando el número de paginación**
**$portafolio = Project::orderBy('created_at','DESC')->paginate(); || Paginación por defecto que es de 15**

# Links de navegación 
Podemos imprimir los links de navegación debajo del loop en la vista de blade 
A través del objeto portafolio se imprime los links 
{{ $portafolio->links() }}
Automaticamente se crea los links de navegación de acuerdo a número de paginación. 
 <ul>        
    @forelse ($projects as $project)
            <li> {{ $project->title }} <br> 
            <small> {{ $project->description }}  </small> <br>
            {{ $project->created_at->format('Y-m-d') }} <br>
            {{ $project->updated_at->diffForHumans() }} 
            {{-- <small> {{ $loop->first ? 'Es el Primero' : ''}}  </small> 
            <small> {{ $loop->last ? 'Es el último' : ''}}  </small>  --}} 
        </li>    
    @empty
            <li> No hay proyectos para mostrar </li>                
    @endforelse    
    {{ $projects->links() }}
</ul>

# Eloquent: Obtener registros individuales.
Dentro de la lista que se esta mostrando los proyectos, modificamos agregandole la etiqueta a para hacer el vinculo, 
para ello especificamos que el vinculo vaya a una ruta, la cual visualizara el contenido, pero se debe especificar en la ruta el parametro, el cual se llamara el id.
En el archivo de las rutas web.php  creamos al ruta con el nombre portafolio.show
* Route::get('/portfolio/{id}','PortfolioController@show')->name('portafolio.show');
A nivel de la ruta se especifica que se pasa un parametro llamado id. 
En la vista de nuestro archivo portfolio.blade.php la lista queda de la siguiente manera: 
* <li> <a href="{{ route('portafolio.show', $project ) }}"> {{ $project->title }} </a> </li>    
Cuando le pasamos el $project, laravel automaticamente toma esto como el id 
* $porject->getRouteKey() => 1

En el controlador del PortfolioController en el método show,le pasamos el $id el cual se esta pasando en la ruta, 
luego lo retornamos para verificar como va en el navegador
~~~
    public function show($id)
    {
        return $id;
    }
~~~

Ahora solo queda hacer la consulta que cuando se de clic en la el item nos muestreel registro de la db en la vista.

Para realizar esto se hace mediante el metodo find, nuestro metodo quedaria de la siguiente forma:
~~~
    public function show($id)
    {
        return Project::find($id);
    }
~~~

Cuando utilizamos Eloquent, laravel nos trae el resultado en un objeto json

El resultado obtenido lo guaramos en una variable el cual se le pasara a una vista
Nuestro metodo quedaria de la siguiente forma:
public function show($id)
{
    return view('projects.show',[
        'project' =>  Project::find($id)
    ]);
}

En caso de que se trate de mostrar un projecto con un id que no existe, Laravel nos mostrara el error.
Para esto debemos cambiar el metodo find por findOrFail, el cual permitira que en caso de que el id no exista no se muestre el error 
public function show($id)
{
    return view('projects.show',[
        'project' =>  Project::findOrFail($id)
    ]);
}

Dado que nos muestra un error la pagina cuando se busca el id que no existe podemo crear nuestra pagina 404 personalizada en las vistas.
Creamos una carpeta en views llamada errors, luego el archivo 404.blade.php 
y alli personlizamos la página con el mensaje que queremos mostrar.




