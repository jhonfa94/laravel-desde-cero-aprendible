# Como validar imagenes

La primera forma es declarando que la imagen sea un campo obligatorio por que el archivo de **SaveProjectRequest.php** en el metodo de rules agregamos la validación
~~~
    public function rules()
    {
        return [
            'title' => 'required',
            'url' => [
                'required', 
                // 'unique:projects',
                Rule::unique('projects')->ignore( $this->route('project') )
                
            ],
            'image' => 'required',
            'description' => 'required'
        ];
    }
~~~

Se puede notar que el campo del fórmulario que permite adjuntar la imagen puede aceptar otro tipos de archivos como pdf, xlsx y demás. Para ello se debe agregar la validación que solo pueda recibir imagenes de tipo jpg o png. 
Para agregar esta configuración se debe especificar dentro del método de rules en el campo de image, que a parte que sea requerido acepte solo imagenes
**'image' => ['required','image'],** al agregar la validación de image lo que realiza internamente laravel es verificar mediante el MIME Type del archivo para verificar que sea una imgen de tipo jpeg, png, bmp, gif, svg o webp
En caso de querer aceptar ciertos tipos de formato de imagen se debe especificar mediante el **mimes:png,jpeg**

Una vez tenemos la validación de que el archivo es una imagen, nos resta agregar la validación de las resoluciones y de los tamaños, ya que si no se implementa el almacenimento del servidor no estaria muy optimizado.

Tenemos para las dimensiones el especificar un tamaño en especifico o también el establecer un minimo de ancho y alto para que la imagen pueda ser validada dentro de la regla
**'dimensions:min_width=400,min_height:400',**

Par validar el tamaño de la imagen se puede realizar mediante el **size:tamaño kb** o por medio el **max:tamaño kb**, la diferencia es que el size exige que la imagen este en 
el tamaño especificado mientras que el max permite obtener el máximo de  peso para subir la imagen sin importar si es igual o inferior. El peso se debe especificar en tamaño de kilobytes, es decir que si queremos dejar subir imagenes con un peso máximo de 2 mb se debe asignar el valor de 2048, el cual equivale a 2 mb.

Nuestro método de rules quedaría de la siguiente forma: 
~~~
    public function rules()
    {

        return [
            'title' => 'required',
            'url' => [
                'required', 
                Rule::unique('projects')->ignore( $this->route('project') )                
            ],
            'image' => [
                'required',
                'mimes:png,jpeg',
                'dimensions:min_width=400,min_height:400',
                'max:2048'
            ],//imagnes de tipo => jpeg, png, bmp, gif, svg o webp
            'description' => 'required'
        ];
    }
~~~



