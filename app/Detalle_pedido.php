<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle_pedido extends Model
{
    protected $table='detalle_pedido';// hace regerencia a la tabla que lo indica
    protected $primaryKey='iddetale_pedido';
    public $timestamps=false;

    protected $fillable=[
        'idpedido',
        'idarticulo',
        'cantidad',
        'precio_venta',
        'descuento',
        'otro'
    ];
    protected $guarded=[

    ];
}
