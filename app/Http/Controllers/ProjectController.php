<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use App\Http\Requests\SaveProjectRequest;
use Illuminate\Support\Facades\Storage;

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
            'projects' => Project::latest()->paginate(5)
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
        return view('projects.create', [
            'project' => new Project
        ]);
    }

    // Método store para almacenar la información.
    public function store(SaveProjectRequest $request)
    {

        $project = new Project( $request->validated());

        $project->image = $request->file('image')->store('images');

        $project->save();


        return redirect()->route('projects.index')->with('status', 'El proyecto fue creado con éxito');
    }

    //Método para editar el proyecto que se seleccione
    public function edit(Project $project)
    {
        return view('projects.edit', [
            'project' => $project
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

        if ($request->hasFile('image')) {

            Storage::delete($project->image); //Eliminamos la imagen existente

            $project->fill( $request->validated());
            $project->image = $request->file('image')->store('images');
            $project->save();
        } else {
            $project->update(array_filter($request->validated()));
            
        }



        return redirect()->route('projects.show', $project)->with('status', 'El proyecto fue actualizado con éxito');
    }


    // Método Destroy para eliminar el proyecto
    public function destroy(Project $project)
    {
        Storage::delete($project->image); //Eliminamos la imagen existente

        // Project::destroy($project); # Primera opcion 
        $project->delete();
        return redirect()->route('projects.index')->with('status', 'El proyecto se ha eliminado con éxito');
    }
}
