# Actualizar registros con Eloquent en la base de datos
Para dar continuidad sobre el proyecto que se esta realizando, sobre la vista de show de los projects en views, crearemos un enlace para editar el proyecto selecciondo.
En el archivo web.php de las rutas creamos la ruta 
**Route::get('/portafolio/{project}/editar', 'ProjectController@edit')->name('projects.edit');**
Crear en el controlardor ProjectController.php crear el metodo, donde se especifica el parametro del proyecto, posteriormente se retorna la información a la vista donde se visualizara la información.
~~~
    public function edit(Project $project)
    {
        return view('projects.edit',[
            'project' => $project
        ]);
    }
~~~

En el archivo de la vista crear el siguiente enlace
~~~
     <a href="{{route('projects.edit')}}">{{__('Edit')}}</a>
~~~

Dentro del archivo que se crea en projects llamado edit.blade.php se reutiliza el código del create para visualizar el fómulario e imprimir los values que se pasan por la variable del array de project
Dentro del término de REST se maneja el UPDATE el cual es para actualizar, pero se trabaja por medio de la petición de put
En el archivo web.php de las rutas definimos la ruta de tipo **put** o **path** para enviar los datos, ademas de esto se debe crear en el controlador el método.
La ruta quedaría de la siguiente forma: 
**Route::put('/portafolio/{project}', 'ProjectController@update')->name('projects.update');**
o tambien así si manejamos el path
**Route::path('/portafolio/{project}', 'ProjectController@update')->name('projects.update');**

Como los navegadores en la parte del fórmulario no intrepreta el put o path en los métodos que se brinda, una opción es crear manualmente un campo oculto la descripción del método de REST  utilizar
~~~
    <input type="hidder" name"_method" value="PATCH">
    <input type="hidder" name"_method" value="put>
~~~
Pero laravel nos soluciona la vida, pues por medio de la sintaxis de blade se tiene un método llamado **@mehtod('')** donde se especifica que tipo de método se va ejecutar, para este casa es el put o path, con esto nos genera un campo oculto 
**@method('PUT')**

Una vez ya configuarado el formulario se procede a términar el método de update en el ProjectController
Por lo que se recibe los datos del proyecto en los parametros que se tienen en el método

Primera forma de hacer el update, sin validar los datos 
~~~
    public function update(Project $project)
    {
        $project->update([
            'title' => request('title'),
            'url' => request('url'),
            'description' => request('description'),
        ]);

        return redirect()->route('projects.show',$project);
    }
~~~
Se redireciona a la vista para visualizar los cambios editados

Anteriormente se habia creado unos form request, los cuales validaban el formulario por medio de los campos del name
Se cambia el nobmre del archivo de CreateProjectRequest.php a SaveProjectRequest.php tambien donde se importa y el nombre de la clase, para hacerlo mas general. 

El método del update nos quedaría de la siguiente forma: 
~~~
    public function update(Project $project, SaveProjectRequest $request)
    {
        /* $project->update([
            'title' => request('title'),
            'url' => request('url'),
            'description' => request('description'),
        ]); */
        $project->update( $request->validated());

        return redirect()->route('projects.show',$project);
    }
~~~
Por medio de project se hara el update, y del SaveProjectRequest realizara la validación. 
Finalmente después de realizar la validación y la actualización se procede a redireccionar a la misma vista de show con los datos actualizados. 

Resulta que si estamos editando el formulario con los nuevos campos y al ejecutarse el método y realizar las validaciones se tiene un campo incorrecto, perdemos los nuevos datos que habiamos modificado y toca volver a realizar el proceso. En las vistas de blade hemos utilizado en el value en los fórmularios el old('nombreCampo') donde este recibe un segundo parametro el cual sería su valor por defecto. 

Nuestro fórmulario quedaría de la siguiente forma: 
~~~
    <form action="{{route('projects.update',$project)}}" method="post">
        @csrf @method('PUT')
        <div class="form-group">
            <label for="tituloProyecto">Título del proyecto</label><br>
            <input id="tituloProyecto" class="form-control" type="text" name="title"  value="{{old('title', $project->title)}}"><br>
        </div>

        <div class="form-group">
            <label for="urlProyecto">Url del proyecto</label><br>
            <input id="urlProyecto" class="form-control" type="text" name="url" value="{{old('url',$project->url)}}" ><br>
        </div>

        <div class="form-group">
            <label for="descripcionProjecto">Descripción del proyecto</label><br>
            <textarea name="description" id="description"  rows="2">
                {{old('description',$project->description)}}
            </textarea><br>
        </div>

        <button type="submit">{{__('Update')}}</button>
    
    </form>
~~~