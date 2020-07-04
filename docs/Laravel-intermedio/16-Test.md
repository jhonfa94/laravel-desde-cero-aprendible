# Qué son los test y cómo ejecutarlos
En esta lección aprendemos qué son los tests automatizados, por qué deberíamos utilizarlos y cómo ejecutarlos en nuestras aplicaciones hechas con Laravel.

Los test nos ayudan a verficar automáticamente que nuestra aplicación este funcionando correctamente.
Se puede pensar en los test como pequeños robots que estan verificando que nuestra aplicación este funcionando correctamente, y en caso de que no este funcionando correctamente 
nos avisa el error presentado.

Laravel trae instalado PHPUnit que es el framework de test que se utiliza para probar nuestra aplicación
Los test se carga especialmente para el ambiente de desarrollo.
En la carpeta o directorio de test se tiene un ejemplo en el directorio de Feature llamado ExampleTest.php
Es recomendable asignar al final del archivo tengan este subfijo de Test, pues de esta forma, laravel interpreta que es un archivo para realizar los test a la aplicación, 
igualmente con el nombre de los métodos

Para ejecutar los test en laravel se realiza a través de la línea de comando
**vendor/bin/phpunit**

Para crear test se hace mediante el comando de: 
**php artisan make:test ListProjectsTest**

En el método de la clase de ListProjectsTest se debe asignar el nombre del método con el subfijo o fijo de test
~~~~
     public function test_can_see_all_projects()
        {
            $this->withExceptionHandling();
    
            $response = $this->get(route('projects.index'));
    
            $response->assertStatus(200);
        }
~~~~

Cuando trabajamos con los test se recomienda tener una base de datos a aparte.
En el archivo phpunit.xml se puede observar todas las variables que se ejecutan en los test 



