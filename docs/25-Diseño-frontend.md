# Diseño de la aplicación en el frontend con Boostrap

Dentro del archivo de package.json tenemos la versión de bootstrap 4.0, donde en la actualidad a  la fecha esta en la 4.5 
~~~
     "bootstrap": "^4.0.0"
~~~
Para actualziar este paquete lo hacemos de la siguiente forma: 
1. Removemos bootstrap  con el comando **npm remove bootstrap**
Con esto eliminamos el paquete de bootstrap que se tiene actualmente.

2. La agregamos nuevamente con el comando  **npm add bootstrap --dev**
Con esto hemos actualizado el paquete de bootstra para nuestro frontend, en el archivo package.json se crea una nueva configuración de las dependencias, con el paquete actualizado de la versión 4.5 de bootstrap
~~~
    "dependencies": {
        "bootstrap": "^4.5.0"
    }
~~~

Es recomendable ejecutar el comando **npm run watch** para que vigile los archivos que tengan cambios y posteriormente nos los actualice en las compilaciones
