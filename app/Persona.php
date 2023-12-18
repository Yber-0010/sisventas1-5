<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table='persona';// hace regerencia a la tabla que lo indica
    protected $primaryKey='idpersona';
    public $timestamps=false;

    protected $fillable=[
        'tipo_persona',
        'nombre',
        'tipo_documento',
        'num_documento',
        'direccion',
        'telefono',
        'email',
        'tiene_cambio',
        'detalles'
    ];
    protected $guarded=[

    ];
}
