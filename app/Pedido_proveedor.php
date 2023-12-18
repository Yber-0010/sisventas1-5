<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido_proveedor extends Model
{
    protected $table='pedido_proveedor';
    protected $primaykey='id';
    public $timestamps=false;

    protected $fillable=[
        'id_proveedor',
        'id_usuario',
        'fecha_inicio',
        'fecha_fin',
        'detalles',
        'estado',
        'recibido'
    ];

}
