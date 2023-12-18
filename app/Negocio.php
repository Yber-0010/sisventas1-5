<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Negocio extends Model
{
    protected $table='negocio';// hace regerencia a la tabla que lo indica
    protected $primaryKey='idnegocio';
    public $timestamps=false;
    /* SUCURSALES 1.0.0*/
    // la razon de crear es para personalizar pero nos referimos tambien a si tiene mas de una sucursal 
    // esta es la primera actualizacion para tener mas de una sucursal por ahora solo permanece en N = 1
    /*******************/
    protected $fillable=[
        'nombre_negocio',
        'direccion_negocio',
        'telefono_negocio',
        'imagen_negocio'
    ];
    protected $guarded=[

    ];
}
