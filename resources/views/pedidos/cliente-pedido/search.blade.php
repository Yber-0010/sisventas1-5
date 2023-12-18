<!-- otro buscador -->
{!! Form::open(array('url'=>'pedidos/cliente-pedido','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!}
     
<div class="form group">
      <div class="input group">
            <table class="responsive" style="margin-bottom: 10px">
                  <tr>
                        <input id="hoy" type="hidden" name="searchText">
                        <td>
                              <samp class="input-group-btn">
                                    <button style="margin-left: 5px" type="submit" class="btn btn-info">Hoy</button>
                              </samp>
                        </td>
                  </tr>
      </table>
      </div>
</div>
{{Form::close()}}
<!----------------->

<!--buscador real-->
{!! Form::open(array('url'=>'pedidos/cliente-pedido','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!}

      <div class="form group">
            <div class="input group">
                  <table class="responsive" style="margin-bottom: 10px">
                        <tr>
                              <td style="width: 800px; border:#bbbbbb solid 2px"><input type="text" class="form-control" name="searchText" placeholder="Buscar..." value="{{$searchText}}"></td>
                              <td>
                                    <samp class="input-group-btn">
                                          <button style="margin-left: 5px" type="submit" class="btn btn-primary">Buscar</button>
                                    </samp>
                              </td>
                        </tr>
            </table>
            </div>
      </div>      
{{Form::close()}}
<!---------------->
@push ('scripts')
<script>
      $(document).ready(function(){
      hoyFecha();
       });
      function hoyFecha(){
        val=1;
        var d = new Date();
        var dia = d.getDate();
        var dia1 = dia;
        var mes = d.getMonth();
        var mes1 = mes;

        mes=mes+1;
        mes=mes.toString();
        mes=mes.length;
        mes = parseInt(mes);

        dia=dia.toString();
        dia=dia.length;
        dia = parseInt(dia);
        if(dia==1){
              if(mes==1){
                  $("#hoy").val((d.getFullYear())+"-0"+(mes1 + 1)+"-0"+dia1);
              }
              else{
                  $("#hoy").val((d.getFullYear())+"-"+(d.getMonth()+1)+"-0"+dia1);
              }
        }
        else{
              if(mes==1){
                  $("#hoy").val((d.getFullYear())+"-0"+(mes1 + 1)+"-"+dia1);
              }
              else{
                  $("#hoy").val((d.getFullYear())+"-"+(d.getMonth()+1)+"-"+dia1);
              }
        }
      }
</script>
@endpush
