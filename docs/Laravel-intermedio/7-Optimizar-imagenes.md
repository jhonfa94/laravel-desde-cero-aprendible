# Como optimizar imagenes para la web

Cuando se sube una imagen al servidor esta queda del tamaño original el cual se sube, por lo que a largo plazo puede ser un inconveniente por los temas del almacenamiento.
En laravel podemos utilizar la herramienta de **image.intervention.io**, el cual nos permite optimizar las imagenes que se suban al servidor.
Para utilizar este paquete se debe hacer a través de composer el cual se agregara a nuestro proyecto. 
**composer require intervention/image**

Una vez esta instala la herramienta en nuestro proyecto podemos hacer uso de ella, donde se utilizara los métodos que se tienen en la documentación dentro de los cuales tenemos el **resize()**, este metodo lleva como parametros el ancho y alto, mientras que el método **widen()** solamente se especifica el ancho, donde el alto se lo da proporcionalmente.

Para hacer uso de la herramienta, se debe crear primero la instancia

Se debe importar el facade de la herramienta al inicio de nuestro controlador 
**use Intervention\Image\Facades\Image;**

Nuestro código en los métodos quedaría de la siguiente forma:
~~~
    //Optimización  de la imagen
        $image = Image::make(Storage::get($project->image))
            ->widen(600)
            ->limitColors(255)
            ->encode();

    Storage::put($project->image, (string) $image);
~~~
Donde: 
- Primiero se debe importar el facades de image de intervention
- Se crea la instancia de para realizar la modificación, para ello se debe pasar la ruta de la imagen, por lo que hacemos uso de la imagen ya guardada, se utiliza el Facades del Storage, donde llama directamente a la carpeta storage que se tiene por defecto que en este caso es la de public, y se pasa el patch de la ruta de al imagen. 
- Se asigna el método de widen el cual recibe como parametro el ancho
- Para optimizar al maximo la imagen, se realiza por medio del método de limitColors(255) el cual recibe como pametro la cantidad de colores a utilizar para la imagen.
- Mediante el encode se realiza se aplica la configuración. 
- Finalmente, mediante el facade del storage realiza la actualización de la imagen que se tiene por la nueva que es la optimizada, donde se indica la imagen actual  y por cual se va actualizar. 

