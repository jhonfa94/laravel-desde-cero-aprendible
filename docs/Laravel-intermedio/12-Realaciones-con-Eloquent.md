# Relaciones de modelos en Eloquent

Para este ejemplo se relacionara los proyectos con las categorías. 
Dentro de la carpeta de **App** se tiene los dos modelos a relacionar, que consta de Category.php y Project.php

Para este caso un proyecto esta asociado a una categoria, por lo que se crea un método para definir la relación, 
por lo que se utiliza un método de la clase de Model llamado **belongsTo** el cual permite hacer la relación de uno a uno. 

~~~
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
~~~

En el archivo de las categorías se crea el método de projects, el cual se asigna el nombre en prural por lo que una 
categoría esta asociada a varios proyectos. 
Para este caso utilizamos el método de la clase Modelo llamado **hasMany()** que interpreta tiene muchos
~~~
    public function projects()
        {
            return $this->hasMany(Category::class);
            
        }
    }
~~~

Como segundo parametro se puede pasar el nombre de la llave foranea, pero como se esta realizando la convención por 
defecto, Laravel automáticamente dectecta la relación a nivel de DB

Para realizar las pruebas de las relaciones se realiza a través de línea de comandos por medio de 
** php artisan tinker**, esta es una consola de php para realizar las pruebas

**php artisan tinker** nos permite hacer las pruebas de ejecución de las relaciones que se han definido, para ello se consulta de la siguiente manera:
~~~
    $project = App\Projet::find(1);
~~~
En la variable de **$project** se almacenara el resultado de la consulta en el modelo de Project, se utiliza en **find()** 
pues este es el que realiza la busqueda y se le pasa como parametro el id a consultar, en este caso estamos consultando el registro con el id uno de la tabla projects del DB

Si queremos traer el primer registro de la db sin necesidad de pasar el id como parametro utilizamos el **first()**
~~~
    $project = App\Projet::first();
    $category = App\Category::first();
~~~

Si queremos actualizar una categoría de un proyecto que no tiene asignado se realiza se puede utilizar la última instancia del proyecto 
y por medio de ella acceder al método de update, en donde se le debe pasar el nombre de la columana de la tabla y el valor
~~~
    $project->update(['category_id' => $category->id]);  
~~~
Al ejecutar la línea se puede evidenciar que retorna un valor de **true** indicando que se realizo correctamente la actaulización
si se revisa la instancia de **$project** el valor de category_id que estaba en null ahora esta con el valor de la categoria que se establecio.

Para consultar el proyecto que se tienen en memoria que categoria se tiene asignada se realiza de la siguiente manera
~~~
    $project->category;
~~~
Con esto nos muestra el resultado del método asignado en el modelo de Project

Si queremos tener en una consulta el proyecto y la categoría asignada lo podemos realizar mediante el método with
~~~
    $project = App\Project::with('category')->find(1);
~~~
El parametro que se l pasa por el método with es el nombre del método que se creo en la relación del modelo

Si queremos que categorias estan asociadas a los proyectos
~~~
    $categoria = App\Category::with('projects')->find(1);
~~~

























