# Filtrar proyecto por categorías
En esta lección permitimos filtrar proyectos por su categoría asociada y reutilizamos la vista index para evitar duplicar código.

Creamos un controlador para la categoria
**php artisan make:controller CategoryController**

Creamos la ruta de categorías en el archivo web.php
**Route::get('categorias/{category}', 'CategoryController@show')->name('categories.show');**


Configuramos el método store en el controlador
~~~
    public function show(Category $category)
    {        
        return view('projects.index', [
            'category' => $category, 
            'projects' => $category->projects()->with('category')->latest()->paginate()
        ]);
    }
~~~
Mediante el **with()** se llama la realación que se creo

Sobreescribimos el método de **getRouteKeyName()** para retonar la url y no el id en el archivo del modelo de la categoría
~~~
    public function getRouteKeyName()
    {
        return 'url';
    }
~~~


