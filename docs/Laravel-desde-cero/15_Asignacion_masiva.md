# Asignación masiva
Laravel nos proteje de la asignación que se da de forma masiva, es decir que un usuario puede inspeccionar nuestro formulario a nivel de fronted en el HTML y puede crear campos de la db y ser guardados en la DB.

Cuando creamos en el modelo el fillable especificamos que campos se van a guardar es decir que si el controlador recive mas campos no se permitiran almacenar solo que esten el array del fillable.
* protected $fillable = ['title','url','description'];

Tambien tenemos en el guarded, en el que se especifica que se proteje ciertos campos como puede ser el id, fechas de creación, actualización etc.
* protected $guarded = ['title','url','description'];

Si queremos desprotejer en el modelo para que se guarde todo lo que hacemos es especificar en el modelo del Project
que el guarded este en modo vacio
* protected $guarded = [];

Pero si en el controlador se sigue especificando que tiene el método all(), el cual permite tomar todos los valores de los inputs quedamos expuestos a la inyección de campos de la db, esto si el usuario conoce los campos, par ello debemos cambiar el método all() por only, donde se especifica los campos a mandar al modelo. 
En nuestro controlador en el método store quedaría de la siguiente forma para enviar los datos.
Project::create($request->only('title','url','description'));

Siempre es recomendable hacer la validación en el contorlador para no tener problemas, y de esta forma pasamos los datos al modelo, con esto no hay necesidad de utilizar el método only
public function store(Request $request)
{             
    // fields es campo
    $fields =  $request->validate([
        'title' => 'required',
        'url' => 'required',
        'description' => 'required',
    ]);

    Project::create($fields);
    
    return redirect()->route('projects.index');
}

En conclusión en el modelo Projects podemos desabilitar la proteción siempre y cuando no enviemos el metodo request-all()




