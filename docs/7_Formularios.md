# Formularios
Creamos un formulario en el archivo de contact.blade.php
~~~
<form method="post" action="{{ route('contact') }}">
        <input type="text" name="name" placeholder="Nombre..."><br>
        <input type="email" name="email" placeholder="Email..."><br>
        <input type="text" name="subject" placeholder="Asunto..."><br>
        <textarea name="content" placeholder="Mensaje..." ></textarea><br>
        <input type="submit" value="Enviar">
</form>
~~~

Por defecto el formulario se envia en el metodo post por lo que se asigna el post, luego en la accion especificamos que se vaya a la ruta del 
mismo archivo, pero como el archivo no esta recibiendo o no tiene una ruta para el tipo post nos muestra un error. Para ello especificamos 
una ruta tipo post en el archivo web.php, pero al ser enviado necesita un controlador el cual debe recibir la informción dle formulario para 
luego ser procesada. 
Creamos un contorlador para procesar la información del formulario 
* php artisan make:controller MessagesController

* Route::post('/contact','MessagesController@store');
Dentro del controlador se agrega el metodo store manualmente

- Por el momento se tiene la funcion asi para mostrar algo mientras se continua desarrollando la lógica
public function store(){    
    return "Procesar el formulario";
}

Cuando le damos enviar al formulario nos mostrar un error el cual se da porque no se ha pasado el token, esto es porque laravel, nos proteje de ataques xss y suplantación.
Para solucionar esto se debe pasar la directiva de blade @csrf antes del primer input
~~~
    <form method="post" action="{{ route('contact') }}">
        @csrf
        <input type="text" name="name" placeholder="Nombre..."><br>
        <input type="email" name="email" placeholder="Email..."><br>
        <input type="text" name="subject" placeholder="Asunto..."><br>
        <textarea name="content" placeholder="Mensaje..." ></textarea><br>
        <input type="submit" value="Enviar">
    </form>
~~~

Con esto laravel le genera al formulario un token de forma seguro para poder enviarlo al controlador

# Acceder a la información del formulario.
Para poder acceder a la información del formulario se hace por medio del metodo request, ese se importa automaticamente cuando se crea el formulario.
- use Illuminate\Http\Request;

Para hacer uso de Request se tiene varios metodos.
Uno es pasando el nombre de la clase como parametro dentro de la función y guardarla en la variable

~~~
    public function store(Request $request){
        return $request;
    }
~~~

Cuando enviamos el formulario este se visualizara en la misma página en formato json
si queremos acceder a una variable en especifico despues dle retorno lo hacemos con el metodo get

public function store(Request $request){
    return $request->get('name');
}

La segunda forma es la simplicidad, solamentte en el retono se llama el request y el campo a tomar 
~~~
    public function store(){          
        return request('email');
    }
~~~


## Validar Formularios
Primero es recomendable añadir el atributo requiered a cada input que se tenga en el formulario en la validación al lado del cliente.

En el lado del backend en laravel contamos con una función llamada validate, la cual nos valida los datos que llegan del input
Como parametro recibe un array con las opciones que queremos aplicarle a los campos 
~~~
    public function store(){ 
        request()->validate([
            'name' => 'required'
        ]);

        return "Datos validados";
    }
~~~

En laravel tenemos acceso en todas vistas a la variable $errors
Podemos acceder al metodo any para preguntar si tenemos algun error este valor nos lo retorna en un valor boleano
**($errors->any())**
Con el all() mostramos todos los errores que se tengan en el formualrio
**($errors->all())**

Por medio de un foreach mostramos los errores que se tengan en formulario por medio del metodo all
~~~
    @if ($errors->all())
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    @endif
~~~


Podemos acceder al error de cada campo pormedio del first y luego especificando el nombre del campo.
Dado esto podemos mostrar el mensaje en cada validación que se de en el formulario

Resulta que cuando hacemos una valicación del formulario nos borra todos los valores, para ello podemos mostrar el valor que se tenia al momento de retornar la validación y presentar errores
En cada input se deberia mostrar en el value el old('nobmreDelCampo')
value="{{old('email')}}"
value="{{old('name')}}"

En el controlador podemos especificar el minimo de caracteres 

## Al final nuestro formulario en blade quedaria de la siguiente forma:

~~~

    @extends('layout')

    @section('title')
        Contacto
    @endsection

    @section('content')
        <h1>Contacto</h1>
        @if ($errors->all())
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <form method="post" action="{{ route('contact') }}">
            @csrf
            <input type="text" name="name" placeholder="Nombre..." value="{{old('name')}}" ><br>
            {!! $errors->first('name','<small>:message</small><br>') !!}

            <input type="text" name="email" placeholder="Email..." value="{{old('email')}}" ><br>
            {!! $errors->first('email','<small>:message</small><br>') !!}

            <input type="text" name="subject" placeholder="Asunto..." value="{{old('subject')}}" ><br>
            {!! $errors->first('subject','<small>:message</small><br>') !!}

            <textarea name="content" placeholder="Mensaje..." >
                {{old('content')}}
            </textarea><br>
            {!! $errors->first('content','<small>:message</small><br>') !!}

            <input type="submit" value="Enviar">
        </form>

    @endsection
~~~


## La validación enel lado del servidor en el controlador quedaria así: 
public function store(){ 
    request()->validate([
        'name' => 'required',
        'email' => 'required|email',
        'subject' => 'required',
        'content' => 'required|min:3',
    ]);
    
    return "Datos validados";
    
}

