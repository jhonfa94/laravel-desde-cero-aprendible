# Implementando Login y Registro

Para implementar el login y registro se debe instalar un paquete de laravel a través de composer donde se debe especificar que paquete utilizar
1. composer require laravel/ui
2. php artisan ui vue --auth
3. npm install
4. npm run dev

Laravel maneja un paquete de autenticación llamado Laravel UI (User Interface)
Para utilizar este paquete se debe instalar la dependencia a través de composer el cual se llama: 
~~~~
    composer require laravel/ui
    
    composer require laravel/ui
~~~~
Una vez se instale este paquete se agrega a la lista de comando de php artisan, dentro del grupo ui

Por medio del comando  **php artisan ui --help** nos va mostrar las diferentes argumentos como: 
type => Este nos permite especificar si queremos trabajar el frontend con bootstrap, vue o react
--auth => instala todo el proceso de autenticación

Preparando la instalación
~~~
    php artisan ui bootstrap --auth
~~~
Al realizar la instalación se generan nuevas estructuras dentro del proyecto, y se debe ejercuar las migraciones de nuevo. 
Recordar que se hace por medio del siguiente comando: 
~~~
    php artisan migrate:fresh --seed
~~~

En el archivo de web.php de las rutas se puede encontrar como se implementa el 
**Auth::routes()** la cual es la que se encarga de registrar todas las rutas relacionadas con el login, logaout, recuperacion de la contraseña, validaciones. 

Con esta nueva implementación aparece un nuevo helper en las vitas el cual se llama **asset()**, lo que nos hace es generar una url a la carpeta donde esta el css o js

Al realizarce esta instalación se puede notar en el desarrollo del proyecto que se implementan nuevos controladres en la carpeta para la utenticación, de igual forma genera nuevas vistas en el blade, para el login, registro y restablecimiento de password. 

Luego de finalizarse la compilación se puede notar que en las vistas de views creo una carpeta llamada layouts con un archivo llamdo app.blade.php, donde nos genera una baase para la definición del html del proyecto. 

Debemos modifcar los controladores de registro y de login en el atributo de redirect para indicarle a donde se quiere enviar despues del registro o login
Una vez nos encontramos logueados podemos acceder a los atributos de la sesion del logueo  a traves de **{{auth()->user()}}** seguidametne elegimos que atributos queremos acceder
Al no estar autenticados no podremos acceder a los valores de la sesión y laravel nos mostrara el error
Para esto Laravel tienen su directiva dentro de blade llamado **auth** donde valida si existe si un usuario esta autenticado si no lo esta, no generara el error
~~~
    @auth
        {{auth()->user()}}
    @endauth
~~~

En el archivo de las rutas de web.php se adiciona la siguiente ruta para hacer el login 
**<li class="{{ setActive('login')}}"><a href="{{route('login')}}">Login</a></li>**
Al hacer clic nos llevara al home por defecto, para esto nos vamos a la carpeta de los Middleware y buscar el archivo **RedirectIfAuthenticated** donde nos redirecciona si estamos autenticado, para esto lo modificamos a nuestro gusto 

Implementamosa nivel de la navegación una directiva llamada Guest
Esta directiva lo que nos valida es que si no estamos logueados nos mostrara la opcion para loguearnos al sistema
~~~
    @guest
        <li class="{{ setActive('login')}}"><a href="{{route('login')}}">Login</a></li>            
    @endguest
~~~

Para cerrar sesión podemos ir al archivo app que nos dejo laraven en las vistas para guiarnos implementado a nuestra app queda asi: 
~~~
    @guest
        <li class="{{ setActive('login')}}"><a href="{{route('login')}}">Login</a></li>           
    @else
        <li>
            <a class="dropdown-item" href="#"
                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>
        </li>
    @endguest

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
~~~

Si queremos excluir la ruta de registro, dentro del archivo web.php le decimos en el auth:routes que no muestre el formulario mediante un arreglo
~~~
    Auth::routes(['register' => false]);
~~~
