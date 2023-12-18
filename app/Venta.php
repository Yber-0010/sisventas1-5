<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table='venta';// hace regerencia a la tabla que lo indica
    protected $primaryKey='idventa';
    public $timestamps=false;

    protected $fillable=[
        'idcliente',
        'tipo_comprobante',
        'serie_comprobante',
        'num_comprobante',
        'fecha_hora',
        'impuesto',
        'total_venta',
        'estado'
    ];
    protected $guarded=[

    ];
}
