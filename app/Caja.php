<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table='caja';
    protected $primaryKey='idcaja';
    public $timestamps=false;

    protected $fillable=[
        'idcaja',
        'fecha_apertura',
        'fecha_cierre',
        'encargado',
        'inicio',
        'ingreso',
        'egreso',
        'otros_egresos',
        'cierre_optimo',
        'cierre_real',
        'estado',
        'detalles',
        'encargado_nombre'
    ];
    protected $guarded=[

    ];
}
