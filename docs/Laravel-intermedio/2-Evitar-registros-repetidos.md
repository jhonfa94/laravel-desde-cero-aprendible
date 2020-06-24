# Evitar registros repetidos

En el modelo se especifico acerca del campo de la url fuese unico a nivel de base de datos, por lo que al ingresar un nuevo proyecto con un url ya repetida dentro de sistema se puede notar el error que nos muestra Laravel acerca de que se tiene un registro ya existene en la url, por lo que se le debe informar al usuario acerca del error que se genera.

Dentro de la carpeta de App/Http/Request tenemos un archivo el archivo llamado SaveProjectRequest el cual se utiliza para el registro y actualización de los proyectos. 
En el método de **rules** donde se tiene la validación se configura nuevamente la url, donde en un array se asigna las nuevas validaciones, como el ser requerido el campo y que sera unico, por lo que se tiene que especificar en que tabla estan los registros para realizarlo de forma interna, y como parametro opcional podemos pasarle el nombre del campo en donde relizara la verificación.
Nuestro método quedaría de la siguiente forma:
~~~
    public function rules()
    {
        return [
            'title' => 'required',
            'url' => ['required', 'unique:projects'],
            'description' => 'required'
        ];
    }
~~~
Al ser ejecutado ya nos validara el campo url en la tabla de projects en de la base de datos.

A través del request podemos acceder a los parámetros que necesitamos, utilizaremos el **dd()** para hacer como un var_dump en php para verificar que esta haciendo el request. 

Vamos a utilizar el método route para verificar el parametro que se tiene en la ruta, y poder detallar lo que se esta ejecutando en el parametro project que tenemos establecido al enviar el request

**dd($this->route('project'));**

Reemplazamos la anterior validación para verificar la ruta por:
~~~
    public function rules()
    {

        // dd($this->route('project'));

        return [
            'title' => 'required',
            'url' => [
                'required', 
                // 'unique:projects',
                Rule::unique('projects')->ignore( $this->route('project') )
                
            ],
            'description' => 'required'
        ];
    }
~~~
Cuando se utiliza el namespace de Rule se debe tener en cuenta la importación de la validación. 
**use Illuminate\Validation\Rule;**

Con esto si actualizamos un proyecto existente donde solo se cambie el contenido ignorara la url en la actaulización y podra modificar los otros campos, cuando se cree un núevo proyecto si validara la url y verificara que no exista dentro de la tabla. 


