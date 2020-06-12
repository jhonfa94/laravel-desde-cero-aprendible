# Route Resource 

En el archivo web.php se muestra lo siguiente con refrente a las rutas de tipo REST para la aplicación 
~~~
    Route::get('/portafolio', 'ProjectController@index')->name('projects.index');
    Route::get('/portafolio/crear', 'ProjectController@create')->name('projects.create');
    Route::get('/portafolio/{project}/editar', 'ProjectController@edit')->name('projects.edit');
    Route::put('/portafolio/{project}', 'ProjectController@update')->name('projects.update');
    Route::post('/portafolio', 'ProjectController@store')->name('projects.store');
    Route::get('/portafolio/{project}', 'ProjectController@show')->name('projects.show');
    Route::delete('/portafolio/{project}', 'ProjectController@destroy')->name('projects.destroy');
~~~

Laravel nos permite crear rutas recursivas,la cual neceista el nombre de la ruta y posteriormente el nombre del controlador por lo que intenamente asigna los nombres y los metodos a ejecutarsen en los servicios de REST 

Se debe configurar los nombres y los parametros que se habian asignado anterirormente, por lo que se debe especificar para no tener problemas dentro de la ejecución del programa y todo funcione correctamente.
**Route::resource('/portafolio', 'ProjectController')->names('projects')->parameters(['portafolio' => 'project']);**
Los names y los parametros se configuran porque trabajamos en lenguaje español, por lo se  puede adaptar todo al termino ingles y no colocar estos parametros. 
