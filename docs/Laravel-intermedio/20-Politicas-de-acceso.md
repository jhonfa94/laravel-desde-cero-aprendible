# Que son lsa políticas de Acceso y cómo utilizarlas.

Son clases que nos permiten agrupar reglas de autorización de un modelo especifico

Creando capo de rol en la tabla de user para realizar la prueba de las políticas de acceso
~~~
    php artisan make:migration add_role_to_users_table
~~~

Agregamos en los métodos la funcionalidad
~~~
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role',['admin','userr'])->default('user')->after('id');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }

~~~
Ejecutamos al migración **php artisan migrate**

Para agregar una política de acceso lo hacemos a través de la términal
Por convinción se debe asignar el nombre del modelo, seguido de Policy para indicarle a laravel
**php artisan make:policy ProjectPolicy -m Project**
Al ejecutar el comando en la términal podemos ver que en la carpeta de App se crea la carpeta de Polices de las Políticas

Asignamos el retorno que se configuro en el gate, para los métodos de create y update en la política que se creo.
~~~
    return $user->role === 'admin'; 
~~~ 
Para hacer uso de estas políticas en nuestro Gate se debe especificar que método se va utilizar
~~~
    Gate::define('create-projects', 'App\Policies\ProjectPolicy@create');
~~~
Pero resulta que en nuestro AuthServiceProvider se tiene ya implementado el uso de las políticas por defecto, donde si
se maneja la misa convención laravel toma todo esto por defecto sin necesidad de ser configurado, 
para ello se tiene una linea comentada, donde se da el ejemplo de que si se tiene al mismo nivel esta política la toma
por defecto
~~~
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];
~~~
Al ser implementada esta nueva opción ya no se necesita el Gate, por lo que en nuestra visa del index.blade de projects
no se daria la implementación de esta política, para ello se debe volver a configurar el **can** done se especifica 
el método de la políica y del modelo que se provee
Directiva de blade can que se tenía por defecto
~~~
@can('create-projects')
~~~

Directiva modificada 
~~~
 @can('create', new App\Project)
     <a class="btn btn-primary "
         href="{{route('projects.create')}}">
         Crear proyecto
     </a>
 @endcan  
~~~
Para tener las vistas mas limpias pasaremos la instancia que se asigno al can al controlador en el método del index, y 
ya en la vista llamamos la variable que fue pasada en el controlador 

~~~
    return view('projects.index', [
        'newProject' => new Project,
        'projects' => Project::with('category')->latest()->paginate(5)
    ]);
~~~
Nuestro directiva de blade can quedaría asi: **@can('create', $newProject)**

En los demás métodos que se tienen de create, update, edit, delete, aplicamos las póliticas.

Muchas veces en nuestros proyectos queremos tener un usuario llamado superadmin o también conocido como el superusuario,
el cual puede acceder a todo con total libertad
Para verificar que un usuario sea superadmin se crea un método llamado before el cual recibe el usuario y la habilidad 
~~~
    public function before($user, $ability)
    {
        if ($user->role === 'superadmin'){
            return true;
        }
    }
~~~ 
Si la verificación da como verdadero puede acceder a todos los métodos que se tienen establecidos en la política. 


















