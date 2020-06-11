# Mostrar Mensajes de Sesión.

La sesión es un tipo de almacenamiento temporal que se utiliza para visualizar información al usuario, como mensajes personalizados.

En el momento que registramos algo o mandamos datos, se visualiza un mensaje, en donde nosotros lo hemos programado, por lo que todo esto lo podemos implementar en un mesaje dentro de una sesión la cual se visualizara por medio de una sola petición si se recarga la página la sesión ya no esta en funcionamiento con el mensaje o datos que se le muestran al usuario.

Laravel nos permite almacenar las sesiones de distintas formas, donde se puede detallar en la ruta de config/session.php, alli se tiene toda la cofiguración
Por defecto utiliza archivos aunque se puede manejar configurar para otros métodos.
Se recomienta utilizar en producción el memcached o redis que son mucho más rápidas 

De momento como estamos en desarrollo las sesiones se almacenan dentro de la carpeta de **storage/framework/sesions**
Podemos eliminar los archivos que se encuentran en esta ruta, menos el de .gitignore, y si recargamos el navegador vemos como se crea por defecto en laravel una nueva sesión.

Para crear una sesión se debe hacerlo desde el controlador donde se le envia los datos a visualizar en la vista de blade por medio del método de with el cual se aplica en las redirecciones o llamados de las rutas

**return redirect()->route('contact')->with('status','Recibimos tu mensaje, te responderemos en menos de 24 horas.');**
De la anterior linea el método esta redireccionando a la ruta de contacto, y por medio del with se pasa el valoriable de la sesión junto con su valor.
Con esto se guardara el mensaje que durara una sola petición. 

Mediante el siguiente código que se tiene se especifica si existe una session con el atributo de status visualizarlo 
~~~
    @if (session('status'))
        {{session('status')}}        
    @endif
~~~

El mensaje se da solo por un instante al recargar la página se quita

Tambien esto es conocido como mensajes flash ya que solo estan en un instante hasta que se cambie o se recargue la página actual. 
