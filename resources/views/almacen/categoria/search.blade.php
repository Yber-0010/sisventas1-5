{!! Form::open(array('url'=>'almacen/categoria','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!}
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