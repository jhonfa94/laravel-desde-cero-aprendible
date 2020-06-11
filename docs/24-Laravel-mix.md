# Laravel Mix

Proporciona uan API fluida para definir lso pasos de compilación de webpack de nuestra aplicacion de Laravel utilizando varios preprocesaradores de CSS y Javascript

Dentro de los archivos de de laravel se tiene un uno llamado **webpack.mix.js** el contiene la configuración para realizar la compilación.

Para esto se debe tener instalado nodejs para ejecutar las herramientas de npm
En el archivo de package.json se tiene todas las dependencias que se necesita para funcionar los archivos del frontend de css y javascritp
en nuestra consola se debe ejecutar el comando de **npm install** para instalar todas las dependencias, donde se nos crea una carpeta llamada node_modules la cual es ignorada en el archivo del gitignore para los sistemas de control de versiones, por lo que solo se necesita para desarrollo. 

Para ejecutar la compilación lo hacemos el comando de **npm run dev**
Con esto genera una compilación de los arhivos css y javascript que se tienen en el directorio de resources.
Las modificaciones o adiciones al css se agregan en el preprocesador de sass en el archivo app.scss y el de javascript en app.js

Cada modificación que se genere a nivel de css y javascript se debe volver a compilar por lo que se vuelve muy molesto estar ejecutando de forma manual las compilaciones, para esto
tenemos el comando **npm run watch** el cual de forma automatica genera las compilaciones que se de en la modificación de los archivos y estos sean guardados. 

Cada cambio compilado que se realiza se debe ejecutar manualmente la recarga de a página por lo que se puede instalar un paquete que genere la recarga de la pagina automaticamente cada vez que se hace una modificación y el npm run watch haya realizado todo.
Para esto lo configuramos desde el mismo archivo webpack.mix.js al final

Se debe especificar el parametro que es la url
~~~
    mix.browserSync('http://127.0.0.1:8000')
~~~
Despues de esto se debe volver a ejecutar todo del nodejs

Cuando trabajamos en modo desarrollo los archivos que son generados muy extensos, esto cuando se da en el css y el javascript ya en produccion puede tardar un poco cuando el navegador intente cargar todo, para ello debemos compilar los archivos a modo producción donde los archivos de css y javascript quedan minificados en lo máximo posible.
Para  compilar los archivos a producción lo hacemos con el comando
**npm run production**

Cada cambio que se realiza en el proyecto a nivel de frontend el navegador al cargar los archivos siempre lee la cache, lo cual es bueno y malo, bueno en el sentido que carga mas rápido y malo porque para un usuario que no tenga conocimientos tiene que hacer un hard reset del navegador borrando la cache en windows se hace con las teclas de CTRL + SHIFT + R
o yendose a las configuración y borrando la cache de las páginas o sitio actual.

Para solucionar este inconveniente dentro del archivo de laravel.mix.js
hacemos una validación donde preguntamos si estamos en producción esto con el fin de generar nuevos archivos cada vez que se compila el proyecto crear un nuevo css y javascript para que se cargue por completo 
~~~~
    if(mix.inProduction()){
        mix.version();
    }
~~~~
Con esto al momento de generar una nueva compilación se crea o se sobreescribe en la carpeta public  el archivo de mix-manifest.json el cual genera las rutas de los nuevos archivos compilados
~~~
    {
        "/js/app.js": "/js/app.js?id=95871bc0857b0f71dccc",
        "/css/app.css": "/css/app.css?id=dbaf0b65c6439ebd052b"
    }
~~~
Cada vez que se ejecute una compilación a nivel de producción se cambia el valor del id, por lo que obliga al navegador generar una carga completa del sitio web

Ya en el frontend en las etiquetas que hacen referencia a los archivos de css y javascript se utiliza la función de mix el va y busca en el archivo de **mix-manifest.json** las rutas de css y javascript

* Antes
~~~
    <link rel="stylesheet" href="/css/app.css">

    <script src="/js/app.js" defer></script>
~~~

* Después con laravel mix
~~~
    <link rel="stylesheet" href="{{ mix('css/app.css')}}">

    <script src="{{ mix('js/app.js')}}" defer></script>
~~~
Si vemos el código fuente en el navegador se notara como cambia la referencia. 


