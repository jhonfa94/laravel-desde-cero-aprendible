# Eliminar Registros de la tabla por medio de Eloquent

Para eliminar un recurso o registro necesitamos el método DELETE de Larave, por lo que se tendra que incluir en nuestras rutas del archivo web.php

En el archivo de show de projects, crearemos un fórmulario básico con un botón llamado eliminar y dentro de este formulario se utilizara la función del método de delete donde enviara una petición de tipo delete. 

Formulario creado en el archivo de show.blade
~~~
    <form method="POST" action="{{route('projects.destroy',$project)}}">
        @csrf
        @method('DELETE')
        <button type="submit">{{__('Delete')}}</button>
    </form>
~~~

Creación de la ruta en el archivo web.php 
**Route::delete('/portafolio/{project}', 'ProjectController@destroy')->name('projects.destroy');**

En el archivo ProjectController creamos el método destroy, donde se debe pasar el parametro del proyecto
~~~
    public function destroy(Project $project)
    {
        $project->delete();
    }
~~~
Para eliminar el projecto se puede llamar a la classe Project y luego implementar el método destroy el recibe el id o el projecto a eliminar
~~~
    Project::destroy($project);
~~~
Tambien podemos hacer uso del método delete ya que estamos recibiendo el proyecto directamente
~~~
     $project->delete();
~~~

