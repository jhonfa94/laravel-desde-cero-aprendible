# BASES DE DATOS REALACIONALES EN LARAVEL 

Creamos un modelo junto con su migración 
~~~
    php artisan make:model Category -m 
~~~

Configuramos el archivo de la migración de la siguiente forma: 
~~~
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); //nombre de la categoría
            $table->string('url')->unique(); //url de la categoría, debe ser única
            $table->timestamps();
        });
    }
~~~

Ejecutamos la migración 
~~~
    php artisan migrate
~~~
Ingresamos una categoria por defecto en la cual queremos asociarla con más de un proyecto, lo que se prentende realizar 
es poder tener una relacion de uno a muchos, por lo que en la tabla de los proyectos de debe agregar un campo más para
poder realizar la relación.
En anteriores configuraciones se realizo por medio de una nueva migración para incluir el campo, en este caso por medio
de la migración que se va utilizar de las categorias podemos incluir el campo en dicha migración. 

El definir las realaciones en la base de datos nos garantiza la integridad
Nuestro método up de la migración de la tabla de categorias quedaría de la siguiente forma: 
~~~ 
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('url')->unique();
            $table->timestamps();
        });

        Schema::table('projects',function (Blueprint $table){
            $table->unsignedBigInteger('category_id')->nullable()->after('id');

            $table->foreign('category_id')->references('id')->on('categories');
        });
    }
~~~
Deshacemos la última migración que se realizo de las categorias para volver a crear nuevamente la migración con los 
cambios que se generaron
**php artisan migrate:rollback** 

Ejecutamos nuevamente la migración 
**php artisan migrate** 

Em el método que se tiene de down se procede a eliminar el la restrincción del forein key y luego se elimina el campo
de la categoía del id
~~~
    public function down()
    {
        Schema::table('projects',function (Blueprint $table){
            $table->dropForeign('projects_category_id_foreign');
            $table->dropColumn('category_id');
        });

        Schema::dropIfExists('categories');
    }
~~~
Con esto al ejecutar un rollback se elimina el campo de la tabla de proyectos de category_id

Se modifica el método de up 
~~~
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('url')->unique();
            $table->timestamps();
        });

        Schema::table('projects',function (Blueprint $table){
            $table->unsignedBigInteger('category_id')->nullable()->after('id');

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });

    }
~~~
Se restringe la realaciónes del foreign key donde: 
- se agrega el método de onUpdate con el valor de cascade, este va permitir que cuando una categoria se actualice, 
el reto de campos que se tiene en la tabla de projects se actualicen uno a uno. 
- se agrega el método onDelete con el valor de set null, lo que permite es que cuando una categoría se elimine, 
actualice los id en el campo de category_id a null 

Finalmente ejucutamos un rollback y luego la migración nuevamente
~~~
    php artisan migrate:rollback
    php artisan migrate
~~~









