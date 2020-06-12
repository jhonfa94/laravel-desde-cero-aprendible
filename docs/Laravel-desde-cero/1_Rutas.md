# CURSO DE LARAVEL DE APRENDIBLE

# RUTAS 
Son las url de entrada de nuestra aplicación, se configuran desde la siguiente ruta: 
routes/web.php
Podemos tener rutas de: 
get => obtener información
post => enviar información mediante formularios pos
put => para actualizar información
delete => para eliminar información.

Dentro de las rutas se puede pasar parametros tanto obligatorios como no obligatorios

Ejemplo 

* Esta ruta retorna una vista 
Route::get('/', function () {
    return view('welcome');
}); 

# Ruta get para el inicio
Route::get('/',function(){
    return 'Hola desde inicio';
});

# Ruta get con parametros obligatorios
Route::get('saludo/{nombre}',function($nombre){
    return "Saludos ". $nombre;
});

# Ruta get con parametros opcionales
Route::get('saludar/{nombre?}',function($nombre = "Invitado"){
    return "Saludos ". $nombre;
});


Podemos configurar las rutas como deseemos, ya que si en algun momento se quiere prestar un servicio, para vincular la ruta y esta a su 
vez tiende a tener modificaciones se puede tener varios dolores de cabeza. 
En el siguienete ejemplo se puede visualizar como se crea  un nombre de una ruta en laravel y se vincula a los demas links con el nombre de la ruta
mas no com el que se declara, ya que si en algun momento se quiere cmabiar el nombre contactenos por contacto solo se cambia el una vez y no debe ser
reemplazado en el o los archivos.

# RUTAS CON NOMBRE
Route::get('contactenos',function(){
    return "Sección de contacto";
})->name('contactos');

Route::get('/',function(){
    echo "<a href='" . route('contactos') . "'>Contactos 1</a><br>";
    echo "<a href='" . route('contactos') . "'>Contactos 2</a><br>";
    echo "<a href='" . route('contactos') . "'>Contactos 3</a><br>";
    echo "<a href='" . route('contactos') . "'>Contactos 4</a><br>";
    echo "<a href='" . route('contactos') . "'>Contactos 5</a><br>";
});


# PASAR VARIBLES A LAS VISTAS
Podemos pasarle variables a las vistas mediante:
* Metodo with ->with()

Route::get('/',function(){
    $nombre = "Jhon";

    return view('home')->with('nombre',$nombre);
});

El primer parametro es el nombre de la varible, el segundo valor es el nombre de la variable

Cuando debemos pasar varios datos lo hacemos mediante un array
Route::get('/',function(){
    $nombre = "Jhon";
    return view('home', ['nombre' => $nombre]);
});

La función compact nos devuelve el mismo valor, enlazando el nombre de la variable
Route::get('/',function(){
    $nombre = "Jhon";
    return view('home', compact('nombre'));
});

Si queremos ir directamente al home lo podemos hacer de la siguiente forma en la ruta
Route::view('/','home')->name('home');
Ya dentro de nuestra vista mediante el doble signo de ?? mostramos la alternativa si no se pasa la variable
Bievenido <?php echo  $nombre ?? "Invitado"  ?>