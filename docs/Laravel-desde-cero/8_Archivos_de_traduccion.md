# Archivos de traducción.

Los archivos de traducción se encuentran en: 
**resources\lang**
Dentro de esta ruta vamos a cambiar las traducciones que se tienen en el archivo validation
Cambiaremos la siguiente traducción: 
- 'required' => 'The :attribute field is required.',
- 'required' => 'El campo :attribute es obligatorio.',

Estos cambios no son buenos realizarlos en la carpeta del idioma en que se encuentran, para ello es mejor crear nuestras traducciones en un nuevo archivo o directorio.

Dentro de la carpeta **config** se tiene toda la configuración global de nuestro proyecto de laravel 
Accedemos al app.php
En el archivo app.php encontramos una linea la cual nos muestra la configuración del idioma que se tiene, dicha línea
es 'locale' => 'en'
Nos informa que esta en ingles por defecto, lo cual hara que debe ir a la carpeta resources y buscara una carpeta lang y finalmente una subcarpeta con el nombre de en.

Para crear nuestras traducciones en español debemos crear una carpeta llamada es dentro de lang, para especificar que **es** en español.
Luego procedemos a traducir todos los errores a nuestro gusto.
No olvidar que dentro del archivo app.php en el locale debemos cambiar el nombre a es para que pueda encontrar nuestra traducción personlizada.

En el archivo de configuración app.php debajo del locale encontramos una configuracion llamada 'fallback_locale' = 'en',
esta configuración lo que nos permite es que una vez no pueda encontrar la traducción en la configuración por defecto que se tiene **es** es buscara en la ruta de **en**.

Afortunadamente la comunidad de laravel ha creado las traducciones por lo que se nos facilita el no traducir toda esta lista que es tan grande
* https://github.com/caouecs/Laravel-lang/tree/master/src/es

# Traducciones especialmente para el formulario actual y no para todos
Se hacen directamente en el controlador de la siguiente forma:
public function store(){ 
    request()->validate([
        'name' => 'required',
        'email' => 'required|email',
        'subject' => 'required',
        'content' => 'required|min:3',
    ],[
        'name.required' => 'Necesito tu nombre',
        'email.required' => 'Necesito tu email',
        'subject.required' => 'Por favor agregue un asunto.',
        'content.required' => 'El contenido debe tener por lo menos 3 caracteres.',

    ]
    );

    return "Datos validados";
}

# Traducir texto fuera del formulario.
Laravel nos permite hacer traducciones en varios idiomas.
Por ejemplo vamos a traducir la palabra contacto del formulario que se ha trabajado. 
Para hacer la traducción se debe convertir la palabra en ingles
 <h1>{{ __('Contact') }}</h1>
El __ indicara en el motor de blade que se va realizar una traducción.
Se debe crear un archivo de traducción en la carpeta resources, con el nombre de la entrada que le especificamos en el locale,
en este caso se llamaria es.json
resources\lang\es.json

Tambien podemos utilizar la directiva de blade llamada  @lang('palabra_a_traducir')
Podemos agregar las traducciones que ofrece la comunidad 
https://raw.githubusercontent.com/caouecs/Laravel-lang/master/json/es.json 
para nuestras palabras estaticas.







