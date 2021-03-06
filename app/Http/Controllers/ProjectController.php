<?php

namespace App\Http\Controllers;

use App\Category;
use App\Project;
use App\Events\ProjectSaved;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SaveProjectRequest;
use League\CommonMark\Inline\Element\Strong;

// use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth')->only(['create']);
        $this->middleware('auth')->except(['index', 'show']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* $proyectos = [
            ['title' => 'Proyecto #1'],
            ['title' => 'Proyecto #2'],
            ['title' => 'Proyecto #3'],
            ['title' => 'Proyecto #4'],
        ]; */

        // $proyectos = DB::table('projects')->get(); # Query Builder
        // $proyectos = Project::get(); # Eloquent muestra todos los datos
        // $proyectos = Project::orderBy('created_at','DESC')->get(); # Muestra de forma descendente por el campo create_at
        // $proyectos = Project::latest()->get(); # Por defecto filtra sobre el campo create_at, si quiere ordernar por otro campo se le especifica el campo en el método
        // $proyectos = Project::latest()->paginate(2); # Por defecto filtra sobre el campo create_at, y el paginate muestra por defecto 15 registros y se personaliza dentro del método en este caso para visualizar 2 registros como maximo por página

        return view('projects.index', [
            'newProject' => new Project,
            'projects' => Project::with('category')->latest()->paginate(6),
            'deletedProjects' => Project::onlyTrashed()->get(),
        ]);
    }


    // Mostrar projecto
    public function show(Project $project)
    {
        // $project =  Project::find($id);

        return view('projects.show', [
            // 'project' => Project::find($id)
            // 'project' => Project::findOrFail($id)
            'project' => $project
        ]);
    }


    //Crear un nuevo proyecto
    public function create()
    {
        # En caso de no pasar la validación aborta y muestra el error 403 de acceso prohibido
        // Gate::authorize('create-projects');
        //$this->authorize('create-projects');
        $this->authorize('create', $project =  new Project);

        return view('projects.create', [
            'project' => $project,
            'categories' => Category::pluck('name','id'),
        ]);
    }

    // Método store para almacenar la información.
    public function store(SaveProjectRequest $request)
    {
        $this->authorize('create', $project =  new Project);

        $project = new Project($request->validated());

        $project->image = $request->file('image')->store('images');

        $project->save();

        //SE DISPARA EVENTO
        ProjectSaved::dispatch($project);

        //Optimización  de la imagen
        // this->optimizeImage($project);


        return redirect()->route('projects.index')->with('status', 'El proyecto fue creado con éxito');
    }

    //Método para editar el proyecto que se seleccione
    public function edit(Project $project)
    {
        $this->authorize('update',$project);

        return view('projects.edit', [
            'project' => $project,
            'categories' => Category::pluck('name','id')
        ]);
    }


    // Método para hacer el update
    public function update(Project $project, SaveProjectRequest $request)
    {
        /* $project->update([
            'title' => request('title'),
            'url' => request('url'),
            'description' => request('description'),
        ]); */
        $this->authorize('create', $project);

        # En caso de no pasar la validación aborta y muestra el error 403 de acceso prohibido
        # $this->authorize('create-projects');

        if ($request->hasFile('image')) {

            Storage::delete($project->image); //Eliminamos la imagen existente

            $project->fill($request->validated());

            $project->image = $request->file('image')->store('images');

            $project->save();

            //SE DISPARA EL EVENTO PARA OPTIIMIZAR LA IMAGEN
            ProjectSaved::dispatch($project);

            //Optimización  de la imagen
            //$this->optimizeImage($project);
        } else {
            $project->update(array_filter($request->validated()));
        }


        return redirect()->route('projects.show', $project)->with('status', 'El proyecto fue actualizado con éxito');
    }


    // Método Destroy para eliminar el proyecto
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        //Storage::delete($project->image); //Eliminamos la imagen existente

        // Project::destroy($project); # Primera opcion
        $project->delete();
        return redirect()->route('projects.index')->with('status', 'El proyecto se ha eliminado con éxito');
    }

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

    // Método para la optimización de la imagen
    /*protected function optimizeImage($project)
    {
        $image = Image::make(Storage::get($project->image))
            ->widen(600)
            ->limitColors(255)
            ->encode();

        Storage::put($project->image, (string) $image);
    }*/

}
