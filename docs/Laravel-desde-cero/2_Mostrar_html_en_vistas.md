# Mostrar HTML  en las vistas con blade
Blade es el motor de plantillas que maneja laravel donde nos previene de ataques de xss de inyección js
Lo cual nos proteje este hace que todo corra como en texto plano

Cuando trabajamos con blade la impresion se hace mediante dos llaves {{}}, esto se interpreta como el famoso echo de php

Crearemos un nuevo archivos dentro de views llamado layout o plantilla como se quiere esto con fin de luego hacer un include en cada archivo
Una vez se configura todo lo de la plantilla se procede a incluir en cada archivo que se necesita con el @extends('layout')
Si la plantilla fue guarda en una ruta de una carpeta o diretorio se accede mediante el nombre de la carpeta y un punto para el archivo eje
carpeta.layout, con esto nos estamos refiriendo a que en la carpeta esta el layout el cual se va incluir en la vista.
El @extends solo funciona dentro de la directiva de la ruta de las vistas views

Para que nuestro contenido se tenga dinamicamente se utiliza la directiva el @yield el cual se le asigna el nombre como parametro para ser
diferenciado, ya que el yield puede ser utilizado en varias secciones del layout o plantilla

Ya  para asingar el contenidos desde el archivo home u otro se hace por medio de la directiva @section() el cual lleva como parametro el nombre del yield que se configuro en el layout
@section('content')
    Se agrega el contenido unico que va en la sección del yield
@endsection
Se debe indicar tanto el inicio como el final 

Podemos configurar para que el yield en caso de que no  se inclyua se muestre un valor por defecto, esto como ejemplo para el titulo 
@yield('title','Aprendible')

Para ser llamado desde el balde el titulo lo hacemos con el section de la siguiente forma: 
~~~
    @section('title')
        Portfolio
    @endsection
~~~


Tambien se puede utilizar la siguiente opción: 
~~~
    @section('title','Portfolio')
    
~~~
En esta opción no se debe tener el @endsection ya que dentro de la instancia del inicio del @section se esta indiciando el nombre a reemplazar, además Laravel interpreta todo esto internamente.
