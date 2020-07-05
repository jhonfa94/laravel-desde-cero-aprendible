<?php

namespace App;

use App\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = ['category_id','title', 'url', 'description'];

    //Método para tener las rutas amigables donde va buscar por el campo que se le indique para la busqueda
    public function getRouteKeyName()
    {
        return 'url';
    }

    // CADA PROYECTO PERTENECE A UNA CATEGORIA
    public function category()
    {
        return $this->belongsTo(Category::class);
    }


}
