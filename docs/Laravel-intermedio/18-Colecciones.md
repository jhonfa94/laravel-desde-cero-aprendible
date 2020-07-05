# Qúe son y cómo utilizar Colecciones en Laravel 

Las colecciones sirven para trabajar con arrays de una forma más sencilla y más elegante

Para probar las colecciones lo podemos hacer a través de la consola de tinker 
**php artisan tinker**
Creamos un array con la diferencia que se hace una instancia de la clase colletion
~~~
    $number = new Illuminate\Support\Collection([1,2,3,4,5])
    $number = Illuminate\Support\Collection::make([1,2,3,4,5])
    $number = collect([1,2,3,4,5])
~~~
Con lo anterior se puede ver que se tiene 3 formas de crear las colecciones en laravel, al ejecutar cualquiera se puede
notar en la consola que se llama la clase Collection **Illuminate\Support\Collection**

De acuerdo a la instancia de valores que se dio, se puede obtener el primer y últmo valor del array sin ninguna 
dificultad
~~~
    $nubmer->first();
    $nubmer->last();
~~~

También se puede ordenar con el método **sort()**
~~~
    $number->sort();
~~~

Tenmos el método all() el cual devuelve el array

También se puede verificar si se tiene un elemento en el array o la colección  por medio del método **contains()**
~~~
    $number->contains(7);
~~~
En la anterior línea se puede notar que se hace busqueda del valor 7 en la colección pero como no esta incluido 
retorna un valor falso

Calcular el promedio
~~~
    $number->average();
    $number->avg();
~~~
Se puede utilizar cualquiera de los dos, siempre dara el promedio de los valores númericos de la colección

Suma de las colecciones
~~~
    $nubmer->sum()
~~~

Mezclar las colecciones
~~~
    $number->shuffle();
~~~

Aparte de ejectuar los métodos que se han mencionado, se puede encadear con otros, por ejemplo si queremos mezclar y
obtener el primer valor que se genero se puede llamar de la siguiente forma
~~~
   $number->shuffle()->first();
~~~

El método random genera los valores aletorio de  la colección existente

El método split() permite dividir el array en las partes que deseemos, por ejemplo en dos partes
~~~
    $number->split(2);
~~~

# Trabajando colecciones  con arrays multidimencionales 
~~~
    $products = collect([
            [
                "name" => "Product 1",
                "price" => 2000,
            ],
            [
                "name" => "Product 2",
                "price" => 1500,
            ],
            [
                "name" => "Product 3",
                "price" => 3000,
            ],    
        ])
~~~

El método pluck nos devuelve un nuevo array a partir de los valores que le demos, en este caso si pasamos que nos 
que genere de los nombres  un nuevo array se realizaria de la siguente forma. 
~~~
     $products->pluck('name')
~~~
Podemos jugar con el método de pluck donde se le puede pasar el primer parámetro como la llave y el segundo como el valor, 
de esta forma quedaria nuevamente como un un array asociativo
~~~
    $products->pluck('price', 'name');
~~~

Para sumar los valores, se puede utilizar de la siguiente forma: 
~~~
    $products->pluck('price', 'name')->sum();
~~~

Podemos realizar la suma de una forma más sencilla donde en el método se sum se especifica el campo para ser sumado
en el array asociativo
~~~
    $products->sum('sum');
~~~

## Obtener los nombres y separarlos por comas
~~~
    $products->pluck('name')->implode(', ');
~~~
Para conocer mas acerca de las colecciones  que se tienen en laravel en la documentación oficial nos ofrece todo 
lo que se tiene disponible

# Colecciones en Eloquent
Tiene una instancia, por lo que nos permite hacer uso de los meétdos de :
- find() => Ejecuta una busqueda a nivel de id de la tabla, 
- first() => Nos retorna el primer registro de la DB de la tabla
- last()  => Nos regorna el último registro de la DB de la tabla
~~~
    $projects instanceOf Illuminate\Support\Collation
    $projects->find();
    $projects->first();
    $projects->last();
~~~ 
Tambien podemos hacer uso de los anteriores meétodos que se hicieron como: 
- pluck('campoTabla0);
- implode('| ');
~~~
    $projects->pluck('title');
    $projects->pluck('title')->implode('| ');
~~~

El método **modelKeys()** nos trae un array plano con los id
~~~
    $projects->modelKeys();
~~~

El método **load()** nos carga una relación
~~~
    $projects->load('category');
~~~

El método de map nos permite ejecutar una función y retornar la nueva colección con los valores que se le establezca
~~~
    $projects->map(function($project){return $project->title;});
~~~

En caso de solo retornar solo un campo se puede pasar solo el nombre del campo, esto se conoce como **Higher Order Messages**
que en español traduce **Mensajes de Orden Superior**











