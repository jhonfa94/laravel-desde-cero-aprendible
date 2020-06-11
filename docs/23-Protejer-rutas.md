# Cómo proteger rutas con usuario y contraseña. 

Dentro del desarrollo que se realiza en las aplicaciones es muy común implementar un sistema de login y registro, aparte de esto debemos proteger el acceso a nuestra aplicación en las rutas del create, update, delete y todo lo que un  usario sin autenticación no pueda acceder libremente. 

Para proteger estas rutas y opciones se utilizan los **Middlewares** 
Estos son un mecanismo que filtran las peticiones http.
Para este ejemplo se necesita un **middleware** para que intercepte la peticion http del usuario y que verifique si esta autenticado o no, en caso de estarlo lo dejara continuar de lo contrario lo llevara a la ruta de inicio de sesión o login.

Laravel por defecto trae varios  middleware donde se tienen uno por defecto para la autenticación

Los middleware se encuentran dentro de la carpeta de app\Http\Middleware
Dentro de esta carpeta se tiene un middleware llamado Autenticate el cual verifica si el usuario esta autenticado y si no lo esta realizarle una redirección.
Tambien tenemos el middleware RedirectIfAutenticated el cual verifica que si el usuario esta logueado o tiene una sesión activa lo redirecciona a la ruta que se tenga por defecto cuando el usuario quiera acceder como a la ruta para el inicio de sesión.

Dentro del archivo del kernel.php se guardan las configuraciones y llamados a los middleware 

Para utilizar los middleware lo podemos hacer dentro de nuestras rutas del archivo web.php donde se pasa el metodo middleware y posteriormente pasarle en su parametro el nombre del middleware

En la siguiente ruta se configura el middleware a las rutas del portafolio o proyectos, donde se le especifica la autenticación para que el usuario este logueado y pueda acceder a las rutas si dificultad
~~~
    Route::resource('/portafolio', 'ProjectController')
        ->names('projects')
        ->parameters(['portafolio' => 'project'])
        ->middleware('auth');
~~~

Otra forma de aplicar los middleware a nuestro proyecto es ir al controlador y especificar que métodos pueden tener acceso libremente y cuales requieren una autenticación.
Para este caso vamos a utilizar el ProjectController, donde por medio del constructor llamamos al middlware, el constructor quedaria de al siguiente forma: 
~~~
    public function __construct()
    {
        $this->middleware('auth');   
    }
~~~
Este constructor estaria aplicando la autenticación para todos los métodos de REST que se tienen en el controlador.

Una de las vetajas de trabajar con los middleware en el constructor desde el controlador es que nos brinda la posibildad de aplicar por medio del only a que métodos se aplicar la autenticación en este caso. 
En el siguiente middleware se especifica a que método se aplicara la autentciación, para este caso el usuario sin tener un login o sesión no podra acceder a crear projectos, pero podría ver,editar, actualizar, eliminar sin tener una sesión iniciada, por lo que se especificaria en el array a que métodos aplicar. 
~~~
    public function __construct()
    {
        $this->middleware('auth')->only(['create']);      
    }
~~~

Si queremos que se aplique a todos los métodos exceptuando uno o varios utilizamos en vez vez de only el except

Para el siguiente ejemplo se aplicara la autenticación a todos los métodos exceptuando el index que es el que visualiza el listado, pero no se tendria acceso a crear, editar y eliminar.
~~~
    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);    
    }
~~~
