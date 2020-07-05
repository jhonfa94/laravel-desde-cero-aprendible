# Qúe son Gates y cómo utilizarlos
También conocidos como puertas de acceso.
Laravel nos prove de una manera simple para autorizar acciones de los usuarios.
La difrencia entre autenticación y autorización se puede entender de la siguiente forma: 
- Autenticación: La aplicación reconoce quienes somos, como usuario, email, etc...
- Autorización: La aplicación ya conoce quieres somos, y sabe que acciones puede realizar al usuario que ya reconocío, 
pero además administra las acciones que podemos realizar como usuario en la aplicación

En el momento la aplicación permite crear proyectos sin ninguna restrinción, por lo que cualquier usuario logueado puede
realizar dicha acción 

Una forma de realizarlo es por medio del archivo **AuthServiceProvider.php** que se encuentra en la ruta ruta de
App\Providers\AuthServiceProvider.php
Nos ubicamos en el método de boot, luego de las **//** podemos agregar nuestro Facade de Gate
Se debe importar el Gate en el proyecto 
**use Illuminate\Support\Facades\Gate;**
Nuestro Gate o puerta de acceso quedaría de la siguiente forma: 
~~~
    Gate::define('create-projects', function ($user){
        return $user->email === 'test@test.com';
    });
~~~
Done se hace el llamado al método estático de define que define el Gate, posteriormetne recibe como parámetros el nombre 
del Gate, y luego la función para hacer la validación, donde retorna la valiación  del usuario que sea igual al valor 
del email que se le esta especificando, por lo tanto si el usuario que este logueado en la aplicación al momento de hacer 
la validación y su email no sea igual al que se estableció en el Gate retornara falso y lo no dejara seguir con las 
actividades. 
En el controlador se debe implementar dicha acción para que pueda hacer el llamado al Gate definido. 
En este caso la validación del formulario se tiene por medio de un Request (SaveProjectRequest) donde se esta especificando 
que el usuario debe estar logueado para crear el proyecto de lo contrario no se le permite ejecutar dicha acción.

 En el método de autorize del archivo de SaveProjectRequest.php se tiene true para que el usuario pueda acceder a la validación, 
 en el retorno se cambia el valor true que se tiene establecido por el Gate, este se debe importar para poder hacer uso de el 
 **use Illuminate\Support\Facades\Gate;**
 La configuración que se establece en el Gate se llama el método estático llamado allows() que nos dice permite donde le
 pasamos el nombre de la puerta que deseamos validar, en este caso es **create->projects**
 ~~~
    public function authorize()
    {
        // return false;
        # return true; # De momento se deja en true para que cualquier usuario pueda utilizar el formulario
        return Gate::allows('create-projects');
    }
 ~~~
En caso de que la validación no este disponible para el usuario, se retorna una respuesta de un 403, inidicandonos
que la acción no esta autorizada. 
Este mensaje se puede modificar en la carpeta de views de las vistas de blade en la carpeta o directorio de errors,
como se hizo con el de 404.

En el controlador podemos aplicar la validación en en el método del create, que es que muestra el formualario para
ingresar los datos del proyecto.

~~~
    public function create()
    {
        # En caso de no pasar la validación aborta y muestra el error 403 de acceso prohibido
        abort_unless(Gate::allows('create-projects'),403);
        
        return view('projects.create', [
            'project' => new Project,
            'categories' => Category::pluck('name','id'),
        ]);
    }
~~~
Otra opción de utilizar la validación del Gates es por medio del método de authorize, donde no hay necesidad de 
llamar la función de abort, internamente Laravel hace la validación
 ~~~
    Gate::authorize('create-projects');
 ~~~
La otra opción de utilizar la autorización es por medio del this
~~~
    $this->authorize('create-projects');
~~~
Aplicamos tanto para create como para el update para que se haga la puerta de la validación 

A nivel de frontend se debe hacer la validación para mostrar el botón de crear proyecto, donde en el momento 
solo valida que el usuario este autenticado, para esto cambiamos la validación de **auth** por **can** el cual 
valida el Gate que se ha establecido

Inicialmente con el auth
~~~
    @auth
        <a class="btn btn-primary "
            href="{{route('projects.create')}}">
            Crear proyecto
        </a>
    @endauth
~~~

Implementando el can
~~~
    @can('create-projects')
        <a class="btn btn-primary "
            href="{{route('projects.create')}}">
            Crear proyecto
        </a>
    @endcan
~~~
 










