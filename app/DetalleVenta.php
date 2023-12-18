<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table='detalle_venta';// hace regerencia a la tabla que lo indica
    protected $primaryKey='iddetalle_venta';
    public $timestamps=false;

    protected $fillable=[
        'idventa',
        'idarticulo',
        'cantidad',
        'precio_venta',
        'descuento'
    ];
    protected $guarded=[

    ];
}
