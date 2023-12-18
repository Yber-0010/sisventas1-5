<?php
//////////////////////// ESTE ES UN MODELO DE LA TABLA CATERGORIA //////////
namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table='categoria';// hace regerencia a la tabla que lo indica
    protected $primaryKey='idcategoria';
    public $timestamps=false;

    protected $fillable=[
        'nombre',
        'descripcion',
        'condicion'
    ];
    protected $guarded=[

    ];
}
