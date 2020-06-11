# Activar los links de navegación
Para activar los links de navegación debemos irnos al archivos de plantilla o layout 
creamos un estilo temporalmente para el ejemplo 
~~~
    <style>
        .active a{
            color: red;
            text-decoration: none;
        }
    </style>
~~~

Para poder asignar la clase  a la lista del menu para visualizar el item activo primero mostramos en una etiqueta de pre el request 
que se esta dando en la pagina
<pre>
{{ request()  }}
</pre>
Esto nos detalla la petición de la pagina actual
Podemos hacer un dump antes del request el cual nos permite ver todo en formato json
<pre>
{{ dump(request())  }}
</pre>

Accedemos a la url 
<pre>
{{ dump(request()->url())  }}
</pre>

Con esto nos damos cuenta en que url estamos actualmente
si queremos ver la url interna acedemos con el metodo path
<pre>
    {{ dump(request()->path()) }}
</pre>

Disponemos de un metodo que nos pemrite comparar la ruta el cual se llaam routeIS('nombreDeLaRuta') el cual nos retorna un valor boleano
Nuestro menu quedaria de la siguiente forma:
<ul>
    <li class="{{ request()->routeIs('home') ? 'active' : ''}}"><a href="/">home</a></li>
    <li class="{{ request()->routeIs('about') ? 'active' : ''}}"><a href="/about">about</a></li>
    <li class="{{ request()->routeIs('portafolio') ? 'active' : ''}}"><a href="/portfolio">portfolio</a></li>
    <li class="{{ request()->routeIs('contact') ? 'active' : ''}}"><a href="/contact">contact</a></li>
</ul>

Trabajar toda esta logica en la vista de la plantilla es un poco tedioso, por lo que se crea un archivo llamado helpers.php en la carpeta app.
Dentro de este archivo se creea una función la cual va ser reutilizable
La función quedaria de la siguiente forma: 
function setActive($routeName)
{
    return request()->routeIs($routeName) ? 'active' : '';
}

<ul>
    <li class="{{ setActive('home') }}"><a href="/">home</a></li>
    <li class="{{ setActive('about') }}"><a href="/about">about</a></li>
    <li class="{{ setActive('portafolio') }}"><a href="/portfolio">portfolio</a></li>
    <li class="{{ setActive('contact')}}"><a href="/contact">contact</a></li>
</ul>

Si accedemos a la url de nuestro proyecto nos presentan un error ya que este dectecta error de un nuevo paquete el cual no ha sido 
vinculado, paa ello nos vamos al archivo composer.json para agregar esta nueva ruta.

Para agregar el archivo de nuestro helpers a comporser.json buscamos la sección de autoload en composer.json
Alli se definen las clases que se van a cargar automaticamente
Se puede evidenciar que las clases se cargan dentro de la ruta de app pero no los archivos.
Para especificar que se cargue los archivos debemos adicionar a la ruta de autoload los files y dentro de un array definir que archivos se van a cargar por defecto, se debe colocar la ruta de donde se este almacenando el archivo
"files":["app/helpers.php"],
Estos se debe agregar despues de  "psr-4"
Nuestro autoload en el composer.json debe quedar de la siguiente forma:
~~~ 
    "autoload": {
        "psr-4": {
            "App\\": "app/"
        },
        "files": ["app/helpers.php"],
        "classmap": [
            "database/seeds",
            "database/factories"
        ]
    },
~~~ 

Una vez es configurada la ruta se debe volver a compilar el composer.json desde la terminal con el siguieente comando y asi poder hacer uso del archivo
El comando es el siguiente: 
* composer dumpautoload

Una vez compilado se puede hacer uso del aplicativo

Dado que nuesto menu de navegación tiende a ser modificado de la plantilla procedmos a crear una carpeta en  views la cual se llamara partials, esta almacenara todo lo del menu, y para ser incluida en el archivo layout o plantilla se utiliza la directiva de @includes('ruta.archivo')




