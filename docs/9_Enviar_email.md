# Enviar email en laravel

Para enviar un email en laravel utilizamos el Mail, seguidamente invocamoes el métdo to
que quiere decir para
*  Mail::to('soporte.coytex@gmail.com');
Luego asignamos el método send
Mailable => Es una clase de php para representar todo tipo de email enviado por nuestra aplicación

Debemos crear la clase para enviar los mensajes al email.
Dentro de la consola podemos ver con el comando php artisan en la lista el make:mail
Creamos la clase del mail 
* php artisan make:mail nombreMail
=>  php artisan make:mail MessageRecieved

Dentro de la carpeta de app se nos crea una subcarpeta llamada Mail, luego el archivo con el que se se le fue asignado el nombre, para este caso el de MessageReceived
En el método build del presente archivo configuramos una vista la cual contendra el mensaje de para el envio del email, para ello en el directorio de resources, dentro de views creamosel directorio o carpeta de emails, posteriormente el archivo de message-received.blade.php donde se colocara el mensaje a enviar.
~~~
    public function build()
    {
        return $this->view('emails.message-recived');
    }
~~~

* Mail::to('soporte.coytex@gmail.com')->send(new MessageReceived);
Se debe importar en el archivo la clase de MessageReceived
use App\Mail\MessageReceived;

Para hacer las pruebas del mail, podemos ir al archiv ode mail.php que esta en la carpeta config, donde se puede observar los protocolos disponibles para el envio de los emails
Para el trabajo de forma local vamos a utilizar el log, pero este lo configuraremos en el archivo .env que esta a raiz del proyecto.
MAIL_DRIVER=log

Es recomendable utilizar para enviar el mensaje el metodo que en vez de send se utilice el **queue**, ya que este se ejecuta en segundo plano y el usuario no debe esperar 

Si queremos ver en el navegador el email que se ha generado es retornando la nueva instancia que se ha generado para el envio del correo electronico. 

Otra opción para ver el email cuando trabajamos en local es Mailtrap
Mailtrap utiliza el protocolo smtp, el cual debemos configurarlo en el archivo de .env 

En caso de presentar problemas para el envio de los emails vaciamos la cache
~~~
    php artisan config:cache
~~~
Posterirormente es bueno detener el servicio y luego inicialo nuevamnete.

# Mailtrap
En https://mailtrap.io/ podemos registrarnos para hacer la prueba del email, creamos una bandeja de entrada
Las credeciales que nos genera mailtrap se los configuramos en el smtp del env


# Sendgrid es una plataforma que nos ofrece servicio de email gratuitos hasta cierto numero que sea permitido durante su plan

https://sendgrid.com/

Para instalar sendgrid en laravel lo hacemos  a través del siguiente link que nos dal el acceso al repositorio
https://github.com/s-ichikawa/laravel-sendgrid-driver

Instalamos via composer
~~~
    $ composer require s-ichikawa/laravel-sendgrid-driver
~~~
Despues de la instalación realizamos la configuración en el archivo .env que seria agregar los siguientes parametros: 
~~~
    MAIL_DRIVER=sendgrid
    SENDGRID_API_KEY='YOUR_SENDGRID_API_KEY'
~~~
Esto se debe configurar para los servidores de producción en desarrollo no seria necesario que estuviese enviando correos de verdad






