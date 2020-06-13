# Como subir imagenes en Laravel

Modificamos el archivo que se tiene en las vistas de projects llamado **_form.blade.php** el cual  es reutilizado para la creación y la actualización.
Agregamos el campo de tipo file y le asignamos el nombre de **image**

Para poder subir imagenes o archivos a nuestro servidor, debemos agregar el atributo en el fórmulario de **enctype="multipart/form-data"** el cual habilita en el navegador para poder hacer uso de los envios de las imagenes. 

Dentro de nuestro controlador de projects en el método de store, depuramos lo que nos esta llegado por medio del request, a su vez inspeccionamos el name para ver como nos esta colocando la imagen en una ruta temporal. 
Por medio del método de store después del nombre del archivo estamos guardando el arhivo en la carpeta de store/app 
~~~
    // dd( $request->file('image')); Nos depura lo que llega en el name de image
    $request->file('image')->store('images'); //guardamos la imagen en la carpeta de images dentro de store
~~~

El método store tiene un parametro el cual se llaman los discos, que determinan donde se guardan los archivos por defecto.
Para visulizar la configuración de todos los discos podemos irnos a **config/filesystems.php** 
Por defecto cuando hacemos uso del método **store**, este se guarda en local, donde no se puede acceder de forma publica. 
Si queremos que se guarde nuestro archivo y pueda ser accedido desde cualquier parte del proyecto lo hacemos utilizando el disco de public
**$request->file('image')->store('images','public');**
Si no queremos estar pasando el parametro de public le podemos indicar en el archivo de **.env** que por defecto se guarde en el disco de public
**FILESYSTEM_DRIVER=public**

Una vez se nos guarda la imagen nos retorna un patch donde queda almacenada junto con su nombre. 
En la tabla de projects no tenemos un campo que haga referenia al patch por lo que se creara en las migraciones. 
Debido a que ya tenemos registros en la base de datos vamos a implementar el nuevo campo sin alterar lo que se tiene.
En la términal creamos la migración 

~~~
    php artisan make:migration add_image_field_to_projects_table
~~~
Al utilizar la palabra add o alter laravel interpreta que se debe añadir o modificar un campo en la tabla de projects en este caso.

En el método de up agregamos el nuevo campo de tipo null 
~~~
   $table->string('image')->after('id')->nullable();
~~~

En el método down, configuramos para la eliminación de la columna
~~~
    $table->dropColumn('image');
~~~

Luego de configurar esto ejecutamos la migración. 
~~~
    php artisan migrarte
~~~
Automaticamente se nos agrega nuestro campo a la tabla de projects seguido del campo del id de tipo null. 

Ya implementado el campo en la tabla de projects procedemos a configurar del método store para el guardar la información junto la ruta o el patch de la imagen
~~~
    public function store(SaveProjectRequest $request)
    {

        $project = new Project( $request->validated());

        $project->image = $request->file('image')->store('images');

        $project->save();


        return redirect()->route('projects.index')->with('status', 'El proyecto fue creado con éxito');
    }
~~~
El anterior método de **store** para guardar la información realiza lo siguiente:
- Recibe por parametro el FormRequest que es el hace las validaciones. 
- Se crea una nueva instancia del modelo Project, dodne se asigna por parametro el request y el validated del formRequest
- Se accede al campo de file de image que se establecio en el input y se inidca que guarde la imagen directamente en el disco .
- Elproject teniendo todos los campos se procede a ser guardado por medio el método de save
- finalemtne hacemos una redirección a la ruta de projects.index, conde se le pasa una variable de sesión llamada status con su respectivo valor. 


