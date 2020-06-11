# Variables de entorno
Son variables con diferente valor dendiendo el entorno en el que este nuestra aplicación, ejemplo produccion y desarrollo.

Las variables de entorno en laravel se guardan en  un archivo llamado .env, el cual esta en la raiz del proyecto 

Por cada entono se debe tener un archivo diferente.

Dentro del archivo de .env se tiene el APP_ENV el cual nos determina si estamos en un entorno de desarrollo o de producción
APP_ENV=local
APP_ENV=production

Igualmente en APP_DEBUG en entorno de desarrollo local tenemos true, pero en producción se debe tener false
APP_DEBUG=false
