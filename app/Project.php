<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    protected $fillable = ['title','url','description'];

    //Método para tener las rutas amigables donde va buscar por el campo que se le indique para la busqueda
    public function getRouteKeyName(){
       return 'url';
    }
}
