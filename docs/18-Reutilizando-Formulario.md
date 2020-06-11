# Reutilizando el Fórmulario

Hasta el momento se tiene dos fórmularios uno para crear y otro para actualizar, pero a menudo que va creciendo nuestro aplicativo se vuelve complejo estar agregando campos en la creación y en la actualización por lo cual, Laravel nos facilita el desarrollo logrando reutilizando el mismo fórmulario, tanto para crear como para actualizar. 

En nuestro controlador de ProjectController en el método de create debemos pasarle a la vista una instancia de project, la cual esta vacia sin valores, donde este valor que llega null si depuramos la variable es para que se muestre en el segundo parametro de la función de **old** en el fórmulario, por lo que de esta forma tendra unos valores por defectos de ser vacios. 
~~~
    public function create()
    {
        return view('projects.create',[
            'project' => new Project
        ]);
    }
~~~

Dentro de views en projects creamos un nuevo archivo el cual va contener los campos iguales en el formulario del proyecto tanto para la creación como pera la edición.
Para este caso se creará un archivo nuevo llamado **_form.blade.php**

~~~
    @csrf

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

    <button type="submit">{{__($btnText)}}</button>

~~~

Esto es lo mas cómun entre ambas funciones, por lo que se repite en ambos en @csfr, los campos, y el botón pero este solo cambia el texto para indicar sis de guardar o es de actualiazar.

En el formulario o archivo de create proyectos nos queda de al siguiente forma: 
~~~
    <form action="{{route('projects.store')}}" method="post">        
        @include('projects._form', ['btnText' => 'Save']) 
    </form>
~~~

En el formulario o archivo de edit proyectos nos queda de al siguiente forma: 
~~~
    <form action="{{route('projects.update',$project)}}" method="post">
        @method('PUT')
        @include('projects._form',['btnText' => 'Update'])    
    </form>
~~~

En ambos fórmularios se pasa por medio del array el texto que tendra el bóton. 

