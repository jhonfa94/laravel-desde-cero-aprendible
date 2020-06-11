# Eloquent insertar datos en DB
Primero se debe  crerar la ruta con el formulario en el archivo web.php del manejo de rutas. 
* Route::get('/portafolio/crear','ProjectController@create')->name('projects.create');

Luego de crear el formulario debemos definir la ruta para almacenar los datos, para ello se crea la 
ruta de tipo post donde se llamara al controlador para que ejecute la accion de guardar los registros en la DB 
* Route::post('/portafolio','ProjectController@store')->name('projects.store');

Ya en el controlador en el método store (ProjectController@store), por medio de la función del request que es la que se encarga de recibir todas la peticiones del formulario se procede a especificar los name de cada input, los cuales se van almacenar en el modelo de la tabla.

En el método store se llama el modelo, que es Project y su método de create para crear el registro el cual hace el insert en la DB. 

//PRIMERA OPCIÓN
Project::create([
    'title' => $request->title,
    'url' => $request->url,
    'description' => $request->description,
]);

Pero en el Project.php del modelo se debe especificar el fillable, el cual indica que campos se van a insertar en la DB.
* protected $fillable = ['title','url','description'];

En el controlador en el método store tenemos una opcion para no tener que especificar campo por campo del formulario, se puede llamar el método all,el cual toma todos los name del formulario y los manda al modelo para ser almacenados.

//SEGUNDA OPCIÓN Y MEJOR UTILIZADA
* Project::create($request->all());

Con esto ya se puede guardar los registros en la tabla de la DB

Al final en el cotrolador retornamos una redirección para que lo lleve al index
* return redirect()->route('projects.index');

















