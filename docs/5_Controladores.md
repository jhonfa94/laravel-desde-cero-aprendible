# Controladores en Laravel 

Para crear un controlador se debe hacer desde la terminal por recomendación.

Dentro de la terminal podemos: 
ver el listado de controladores.
ver el listado de las rutas. 
php artisan route:list

## Comando para crear un controlador desde la terminal
* php artisan make:controller NombreControlador
Cuando especificamos -h al final del controlador la consola nos muestra que opciones podemos asignarle directamente para la creación del controlador

## Ubicación de los controladores
Por defecto del framework los controladores se guardan en la carpeta app/Http/Controllers

Cuando creamos el controlador de PortfolioController -i nos crea un metodo mágico 

## Atajo para ver la lista de rutas
* php artisan r:l


## Controladores Resoruce y API
* php artisan make:controller PortfolioController -r
El -r significa resource
Cuando creamos un controlador de tipo resource se crean los metodos de: 
- index  => Lista los recursos
- create => Mostramos el formulario para crear un nuevo recurso
- store => Se utiliza para guardar el recurso en la base de datos
- show => Muestra un recurso en especifico 
- edit => Mostramos un formulario para editar un recurso que ya exista 
- update => Guardamos los cambios que se pasan en el formulario editar
- delete/destroy => Elimina un recuso por medio del identificador
Cada metodo tiene un proposito en especifico 

Cuando se pasa la ruta desde el archivo web.php, especificamos que metodo se va utilizar por medio del @
Para este ejemplo se va utilizar el index
Route::get('/portfolio','PortfolioController@index')->name('portafolio');

## Ruta resource
Cuando creamos una ruta resource automaticamente nos genera las rutas para el index, edit, updated etc
* Route::resource('/projects','PortfolioController');

Las ruta de tipo resource nos permiten personalizar que metodos van a a estar disponibles, mediante el metodo only
* Route::resource('/projects','PortfolioController')->only(['index','show']);
Con lo anterior estamos especificando que solo se pueden utilizar los metodos de index y de show

* Route::resource('/projects','PortfolioController')->except(['index','show']);
El metodo except hace lo contrario a only especifica que estas opciones que se le asignan por el array no se pueden utilizar


## Creando controlador API
* php artisan make:controller PortfolioController --api
Cuando creamos un controlador de tipo api, este nos excluye los metodos de create y edit, ya que estos son los que muestran la vista de los formularios
Los cuales no se necesitan en una api

Ya en la seccion del archivo web.php para la ruta se debe configurar de la siguiente forma:
* Route::apiResource('/projects','PortfolioController');
Podemos verificar las rutas en la consola con  el comando php artisan r:l
Tambien tenemos a disposición los metodos only y except

Cuando visualizamos  a traves de consola las rutas que tenemos disponibles estas se muestran al final con nombre de ingles, ya que asi viene por defecto con el framework

## Renombrar los verbos de las rutas
En la carpeta de app encontramos una subcarpeta llamada providers y un archivo AppServiceProvider.php
Dentro del archivo tenemos un metodo de boot, el cual podemos redeclarar el nombre de las funciones como:
Route::resourceVerbs([
    'create' => 'crear',
    'edit' => 'editar',
    'edit' => 'editar',
]);
Se debe importar la clase de resorceVerbs para  que esto funcione
* use Illuminate\Support\Facades\Route;




