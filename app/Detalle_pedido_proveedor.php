<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle_pedido_proveedor extends Model
{
    protected $table = 'detalle_pedido_proveedor';
    protected $primarykey = 'id_detalle';
    public $timestamps = false;

    protected $fillable = [
        'id_pedido',
        'id_articulo',
        'cantidad',
        /* 'precio_venta', */
        'precio_compra',
        'otro',
        'descuento',
        'stock'
    ];
}
