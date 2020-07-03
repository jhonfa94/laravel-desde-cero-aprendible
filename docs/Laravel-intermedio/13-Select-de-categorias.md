# Select de categorías.

Desde el controlador se hace el llamado a los modelos para extraer los datos, para este caso se requeire extraer los datos de las categorías, para ser
incluidas en el select del formulario

Mediante el método de get de Eloquent nos trae todas las categorías de la base de datos. 
~~~
    Category::get();
~~~
Los datos nos lo retorna en un array o json

Tenemos el método de **pluck()** el cual recibe como parametros los campos que deseamos extraer. 
~~~
    Category::pluck('name','id');
~~~
Con lo anterior nos crea un array asociativo, donde por medio de un foreach se recorre los valores para ser impreso en nuestro select
del archivo de _form.blade.php
~~~
    <div class="form-group">
    <label for="category_id">Categoría del proyecto</label>
    <select name="category_id" 
            id="category_id"
            class="form-control border-o bg-light- shadow-sm">
        <option value="" >Seleccione</option>
        @foreach ($categories as $id => $name)
            <option value="{{$id}}"
                {{$id === $project->category_id ? 'selected' : ''}}
            >
            {{$name}}
            </option>
        @endforeach
    </select>
</div>
~~~
Dentro del foreach se pregunta si el id es igual a que se tiene en el campo de category_id de la tabla, para ser asginado, esto aplica para cuando se hace una edición.

En el archivo de validación del formulario se debe agregar el nuevo campo de category_id, y asi al momento de realizar la validación pueda incluir el valor para ser creado o actualizado. 
~~~
    'category_id' => ['required'],
~~~

Finalmente el archivo del modelo de **Project.php**  en la variable de **$fillable** se debe agregarel campo de category_id para que pueda ejecutarse cuando se relice la validación y se proceda a realizar el crud
~~~
    protected $fillable = ['category_id','title', 'url', 'description'];
~~~

En caso de que un usuario modifique las opciones que se tienen a nivel de formulario html y le agregue otro y lo envie, Laravel le mostrara un error informandole que esta 
violando la integridad de al base de datos, y esto se da gracias a las llaves foraneas que fueron definidas. Este error se muestra si estamos en desarrollo, pues en producción se visualiza un error llamado **500 | Server Error**

Para solucionar este error se debe agregar en el archivo SaveProjectRequest la validación en la categoría, dode se indica que debe existir en la tabla de la DB
~~~
    'category_id' => [
        'required',
        'exists:categories,id'
    ],
~~~
