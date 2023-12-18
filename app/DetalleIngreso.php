<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleIngreso extends Model
{
    protected $table='detalle_ingreso';// hace referencia a la tabla que lo indica
    protected $primaryKey='iddetalle_ingreso';
    public $timestamps=false;

    protected $fillable=[
        'idingreso',
        'idarticulo',
        'cantidad',
        'precio_compra',
        'precio_venta',
        'fecha_vencimiento',
        'peso',
        'proveedor',
        'habia_stock',
        'total_stock'
    ];
    protected $guarded=[

    ];
}
