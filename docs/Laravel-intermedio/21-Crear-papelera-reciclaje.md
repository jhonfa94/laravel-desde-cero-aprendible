# Como crear una papelera de reciclaje

En el projecto se conoce como Soft Deletes ó Eliminación Suave, la cual consiste en recuperar registros eliminados 

Para habilitar el SofDeletes se debe ir al modelo y utilizar el trail
**use SoftDeletes;**
Se debe agregar la importación
**use Illuminate\Database\Eloquent\SoftDeletes;**

Agregar el campo de **deleted_at** a la tabla projects, dodne se eliminara la fecha de eliminación
**php artisan make:migration add_soft_deletes_to_projects_table**
Al ser creado podemos hacer uso de un método llamado softDeletes, lo que hace este métod es crear un campo 
en la tabla llamado deleted_at de tipo timestamp
~~~
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
~~~
Ejecutamos la migración 
**php artisan migrate**

Al realizar la eliminación de un proyecto, ya no elimina de la base de datos, pues en el campo deleted_at de projects de 
la base de datos se crea la fecha y hora en la que se ejecuto la eliminación mas no se borra del todo 

En el controlador le pasamos la variables con los proyectos que se han eliminado
**'deletedProjects' => Project::onlyTrashed()->get(),**
~~~
    return view('projects.index', [
        'newProject' => new Project,
        'projects' => Project::with('category')->latest()->paginate(6),
        'deletedProjects' => Project::onlyTrashed()->get(),
    ]);
~~~


Se creara una vista para mostrar los proyectos  eliminados y a su vez se validara por medio de un Gite si tiene 
autorización para visualizar el listado de los proyectos eliminados
~~~
    {{-- MOSTRAMOS LOS PROYECTOS ELIMINADOS         --}}
        @auth()
            @can('view-deleted-projects')
                <ul>
                    @foreach($deletedProjects as $deletedProject)
                        <li>
                            {{$deletedProject->title}}

                            @can('restore',$deletedProject)
                                <button class="btn btn-sm btn-info">Restaurar</button>
                            @endcan

                            @can('forceDelete',$deletedProject)
                                <button class="btn btn-sm btn-danger">Eliminar permanente</button>
                            @endcan
                        </li>
                    @endforeach
                </ul>
            @endcan
        @endauth
~~~
Para implementar las funcionalidades de los botones de resturar y eliminar permanentemente configuramos las rutas en el archivo web.php
~~~
    Route::patch('portafolio/{project}/restore','ProjectController@restore')->name('projects.restore');
    Route::delete('portafolio/{project}/force-delete','ProjectController@forceDelete')->name('projects.force-delete');
~~~
Implementamos los métodos en el controlador 
~~~
    //Método restore para restaurar el proyecto eliminado
    public function restore($projectUrl)
    {
        $project = Project::withTrashed()->where('url',$projectUrl)->firstOrFail();

        $this->authorize('restore', $project);
        $project->restore();
        return redirect()->route('projects.index')->with('status', 'El proyecto fue restaurado con éxito');
    }

    //Método restore para eliminar definitivamente el proyecto de la base de datos
    public function forceDelete($projectUrl)
    {
        $project = Project::withTrashed()->where('url',$projectUrl)->firstOrFail();
        $this->authorize('force-delete', $project);
        Storage::delete($project->image); //Eliminamos la imagen existente
        $project->forceDelete();
        return redirect()->route('projects.index')->with('status', 'El proyecto fue eliminado permanentemente');
    }
~~~
En los métodos que se implementaron se tiene: 
- Recibe como parámetro la url
- Verificamos que esa url sea correcta por médio del withTrashed se extrae el campo y se verica con el where
- Verificamos la utorización para el usuario. 
- Ejecutamos el método del restore o foreDelete
- retornamos al index con el mensaje personalizado
- En el caso del método de forceDelete se elimina por completa la imagen 

Fórmulario final quedaría de la siguiente forma: 
donde se agregan clases de Bootstra, confirmación con javascript antes de la eliminación. 
~~~
    {{-- MOSTRAMOS LOS PROYECTOS ELIMINADOS         --}}
    @auth()
        @can('view-deleted-projects')
            <h4>Papelera</h4>
            <ul class="list-group">
                @foreach($deletedProjects as $deletedProject)
                    <li class="list-group-item">
                        {{$deletedProject->title}}

                        @can('restore',$deletedProject)

                            <form method="POST" action="{{ route('projects.restore',$deletedProject) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-info">Restaurar</button>
                            </form>
                        @endcan

                        @can('force-delete',$deletedProject)
                            <form method="POST"
                                  action="{{ route('projects.force-delete',$deletedProject) }}"
                                  onsubmit="return confirm('Esta acción no se puede deshacer, ¿Estás seguro de querer eliminar este proyecto?')"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar permanente</button>

                                </form>
                            @endcan
                        </li>
                    @endforeach
                </ul>
            @endcan
    @endauth
~~~




