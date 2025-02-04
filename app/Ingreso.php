<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $table='ingreso';// hace regerencia a la tabla que lo indica
    protected $primaryKey='idingreso';
    public $timestamps=false;

    protected $fillable=[
        'idproveedor',
        'tipo_comprobante',
        'serie_comprobante',
        'num_comprobante'.
        'fecha_hora',
        'impuesto',
        'total_venta',
        'obserbacion',
        'estado',
        'detalles',
        'idusuario',
        'anuladopor'
    ];
    protected $guarded=[

    ];
}
