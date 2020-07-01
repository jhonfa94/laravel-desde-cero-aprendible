# Cómo utilizar Eventos y Listeners

Debido a que en el momento se esta haciedo uso en dos métodos la misma lógica para el procesar la imagen y optimizarla 
se creara un método dentro del controlador y la clase llamado:
**optimizeImage()** donde recibira como parametro el proyecto
Nuestro método quedaria de la siguiente forma: 
~~~
    protected function optimizeImage($project)
    {
        $image = Image::make(Storage::get($project->image))
            ->widen(600)
            ->limitColors(255)
            ->encode();

        Storage::put($project->image, (string) $image);
    }
~~~

Y para ser llamado o ejecutado desde otro método interno 
**$this->optimizeImage($project);**

Un evento es como un anuncio donde se informa de algo ocurrido en la aplicación, para que luego otra parte de la 
aplicación escuche ese evento y pueda actuar en consecuencia.
Para este caso vamos a informar de que el proyecto fue creado despues de que fue creado **$project->save()** 
El evento siempre anunca alg que ya ocurrio.

Para la creación de los eventos lo hacemos a través de la terminal o también directemente desde las estructruas del proyecto 
Nos ubicamos en: 
app/Provides/EventServiceProvider.php
En la propiedad de **$listen** definimos los eventos que queremos configurar, por defecto laravel ya tiene un envento 
configurado para la notificación de los emails, 
creamos nuestro listener
~~~
    ProjectSaved::class =>[
        OptimizeProjectImage::class,
    ],
~~~
Finalemnte nuestro listener quedaría de la siguiente forma: 
~~~
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ProjectSaved::class =>[
            OptimizeProjectImage::class,
        ],
    ];
~~~
Una vez es creado, se necesita crear un namespace del listener que se agrego
~~~
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        \App\Events\ProjectSaved::class =>[
            \App\Listeners\OptimizeProjectImage::class,
        ],
    ];
~~~
Seguidamente desde la terminal **php artisan event:generate**
Al ejecutar el comando se crea dentro del directorio de **App** las subcarpetas de Events y Listeners con sus respectivos 
archivos que fueron definidos.

Se debe tener presente que el evento no realiza la acción sino que solamente contiene la información necesaria para que 
el listener pueda operar.
Por lo cual el evento ProjectSave solamente va a contener el evento project y el listener va recibir la información para 
poder optimizar la imagen del proyecto

Posteriormente se debe definir cuando se va disparar el evento, para nuestro poyecto se va disparar cuando se guarde 
una imagen o se actualice, en los métodos de store y update.
Se envia de la siguiente forma: **ProjectSaved::dispatch();** 
Como se envia se recibe en el archivo de **ProjectSave.php** que se encuentra en el directorio o carpeta de Events de App
Dentro del archivo de ProjectSave se crea el atributo **$project** de tipo público, seguidamente se configura el constructor
para que reciba la instancia del proyecto

~~~
    #Importar antes de la clase
    use App\Project;
    
    # Dentro de la clase 
    public $project;   
    public function __construct(Project $project)
    {
        $this->project = $project;
    }
~~~

En el archivo del directorio de Listeners llamado OptimizeProjectImage.php configuramos el método handle para definir
la logica del listener












