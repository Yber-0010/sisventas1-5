<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table='pedido';
    protected $primarykey='id';
    public $timestamps=false;

    protected $fillable=[
        'idcliente',
        'tipo_comprobante',
        'serie_comprobante',
        'num_comprobante',
        'fecha_hora_inicio',
        'impuesto',
        'total_venta',
        'fecha_hora_entrega',
        'detalles',
        'estado',
        'a_cuenta',
        'saldo',
        'recogio',
        'hora',
        'fecha_hora_finalizado',
        'nombre_cliente',
        'celular_cliente'
    ];
    protected $guarded=[

    ];
    public function detallePedido()
    {
        return $this->belongsToMany(Detalle_pedido::class, 'detalle_pedido',"id","idpedido");
    }
}
