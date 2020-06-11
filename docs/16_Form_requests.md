# Form requests
Estan pensado para validar formularios en escenarios mas complejos.
Son clases dedicadas para encapsuplar la lógica de validación y autorización de uno o varios formularios

## Crear form request
Para crear un form request se hace desde la términal o línea de comandos 
**php artisan make:request CreateProjectRequest**

Por defecto los form request se crean en la carpeta de 
app\Http\Requests\CreateProjectRequest.php

Todo form request consta de dos métodos 
- authorize => se ejecuta para validar si el usuario tiene acceso o esta autorizado para hacer en envio o la diligencia del formulario
Si la autorización no retorna en valor verdadero se mostrar el error
HTTTP Response 403 
Forbidden(Prohibido)
Es decir que el usuario no esta autorizado para continuar

Si devuelve verdadero procede al metodo rules para verificar las reglas de validación que se tienen

- rules => Validación que se realiza en el los rules, con esto no hay necesidad de especificar la validación en el controlador solo seria llamar la clase para que quede de forma automaticamente
return [
    'title' => 'required',
    'url' => 'required',
    'description' => 'required',
];

Ya en con controlador procedemos a llamar el form request, y el metodo del modelo create del Project el parametro que se pasa se le asigana el validated 

~~~
    public function store(CreateProjectRequest $request)
    {       
        Project::create($request->validated());    
        return redirect()->route('projects.index');
    }
~~~

Para agregar mensajes personalizados se debe hacer, creando el método después de rules donde se especifica los mensajes que queremos mostrar sobre los campos del fórmulario.
~~~
    public function messages()
    {
        return [
            'title.required' => 'El proyecto necesita un título'
        ];
    }
~~~

