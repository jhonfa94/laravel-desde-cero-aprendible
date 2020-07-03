<?php

namespace App;

use App\Project;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    # Sobreescribimos el método para que la url no se muestre el id, sino el campo url de la tabla
    public function getRouteKeyName()
    {
        return 'url';
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
