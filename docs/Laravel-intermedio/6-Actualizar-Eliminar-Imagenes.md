# Como actualizar y eliminar imagenes

Teniendo en cuenta que las imagenes del proyecto unas pueden ser modificadas como otras pueden conservarse al editar el proyecto nos exige el importar la imagen para el proyecto al actualizar, en el controlador se hace el llamado al form request para la reutilización de las reglas.

Se debe modificar el metodo de rules  del archivo  de SaveProjectRequest.php donde se valida internamente si es un nuevo archivo o una edición.

**$this->route('project') ? 'nullable' :  'required',** esto nos valida si es un proyecto nuevo o ya existente, donde nos retorna un valor null cuando es nuevo, pero al 
ejecutar la actualización se nos actualiza el campo en la tabla más no se borra del servidor o directorio
La solción se da implementeando en el controlador en el método de update un array filter, 
**$project->update(array_filter($request->validated()));**

Dentro del método update se debe validar si existe un archivo al momento de ejecutar la actualización.
Seguidamente se elimina la imagen que se tiene actualmente y se reemplaza por la nueva, ya en caso de presentarse alguna actualización se aplicaria el filter para determinar que no se tengan campos vacios o nulos y afecten a la tabla 
Cuando hacemos la eliminación de la imagen actual hacemos uso de un **Facades** en laravel que nos permite acceder a la ruta de Storage donde se especifica que se realiza una eliminación y se pasa por parametro la ruta
**Storage::delete($project->image);**
Este se debe importar en el archivo del controlador para su correcto funcionamiento.
**use Illuminate\Support\Facades\Storage;**

Nuestro método quedaría de la siguiente forma: 
~~~
    public function update(Project $project, SaveProjectRequest $request)
    {
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
~~~
