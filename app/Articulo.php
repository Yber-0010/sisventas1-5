<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $table='articulo';// hace regerencia a la tabla que lo indica
    protected $primaryKey='idarticulo';
    public $timestamps=false;

    protected $fillable=[
        'idcategoria',
        'codigo',
        'nombre',
        'stock',
        'descripcion',
        'imagen',
        'estado',
        'precio_venta',
        'precio_compra',
        'peso',
        'empresa',
        'created_at',
        'updated_at',
        'stock_min',
        'stock_max',
        'alerta_dias'
    ];
    protected $guarded=[

    ];
}
