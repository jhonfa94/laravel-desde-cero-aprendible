# Qúe son y como utilizar Factories

Los factories nos ayudan a crear registros automaticamente en la base de datos 
La palabra Fábrica es Factory en inglés, por lo que en este caso se configura una bodega de datos personalizada para los proyectos
Se conoce como fabricas de modelos. 

Los factories se encuentran en la ruta de la carpeta o directorio de Database/Factories, por defecto Laravel nos 
trae un ejemplo llamado UserFactory. 

Para hacer un llamado al factory, se hace mediante la función de factory, donde lleva como parámetro el nombre del modelo, 
seguidamente se le indica que cree el factory.
**$user = factory('App\User')->create();**

Para crear un factory lo hacemos desde la términal 
**php artisan make:factory ProjectFactory -m Project**
Por convención y buenas prácticas utilizar el nombre del modelo

Laravel tiene una libreria integrada para crear los Factories llamada Faker la cual nos permite crear registros aleatorios para 
no tener que digitar los datos 
**https://github.com/fzaninotto/Faker**
