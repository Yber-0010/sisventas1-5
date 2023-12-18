<style>
  .table {
      width: 100%;
      border: 2px solid rgb(226, 226, 226);
      /* text-align: center;         */
  }
</style>
<div class="row">
  <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
      <div class="table-responsive">
          <table class="table">
              <tr>
                  <td>
                      <label for="nombre">Proveedor</label>
                      <p>{{$ingreso->nombre}}</p>
                  </td>
                  <td>
                      <label for="detalles">Detalles</label>
                      <p style="color: blue;">{{$ingreso->detalles}}</p>
                  </td>
                  <td>
                      <label for="idventa">Nro</label>
                      <p>{{$idshow}}</p>
                  </td>
                  <td>
                    <label for="nombre">Fecha</label>
                    <p>{{$ingreso->fecha_hora}}</p>
                  </td>
              </tr>
              <tr>
                  <td>
                    <label for="">Tipo Comprobante</label>
                    <p>{{$ingreso->tipo_comprobante}}</p>
                  </td>
                  <td>
                    <label for="serie_comprobante">Serie Comprobante</label>
                    <p>{{$ingreso->serie_comprobante}}</p>
                  </td>
                  <td>
                    <label for="num_comprobante">Numero Comprobante</label>
                    <p>{{$ingreso->num_comprobante}}</p>
                  </td>
              </tr>
          </table>
      </div>
  </div>
</div>
<div class="row">
  <div class="panel panel-primary">
    <div class="table-responsive">
      <div class="panel-body">
        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
          <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                <thead style="background-color:#A9D0F5">
                    <tr>
                      <th>Idarticulo</th>
                      <th>Articulo</th>
                      <th>Cantidad</th>
                      <th>Precio_compra</th>
                      <th>Precio_venta</th>
                      <th>Habia_stock</th>
                      <th>total_stock</th>
                      <th>fecha_vencimiento</th>
                      <th>subtotal</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($detalles as $det)
                  <tr>
                    <td>{{$det->idarticulo}}</td>
                    <td>{{$det->articulo}} {{$det->peso}}</td>
                    <td>{{$det->cantidad}}</td>
                    <td>{{$det->precio_compra}}</td>
                    <td>{{$det->precio_venta}}</td>
                    <td>{{$det->habia_stock}}</td>
                    <td>{{$det->total_stock}}</td>
                    <td>{{$det->fecha_vencimiento}}</td>
                    <td>{{$det->cantidad*$det->precio_compra}}</td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th><h4>Total</h4></th>
                    <th><h4 id="total">{{$ingreso->total_venta}}</h4></th>
                  </tr>
              </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>  
</div>
             
