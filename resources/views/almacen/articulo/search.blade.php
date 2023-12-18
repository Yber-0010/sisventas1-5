{!! Form::open(array('url'=>'almacen/articulo','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!}

      <div class="form group">
            <div class="input group">
              <table class="responsive" style="margin-bottom: 10px">
                    <tr>
                          <td  style="width: 800px;"><input style="border:#bbbbbb solid 2px" id="ptext" type="text" class="form-control" name="searchText" placeholder="Buscar..." value="{{$searchText}}"></td>
                          <td>
                              <samp class="input-group-btn">
                                    <button style="margin-left: 5px" id="psearch" type="submit" class="btn btn-primary">Buscar</button>
                              </samp>
                          </td>
                          <td>
                              <div style="border: cornflowerblue 2px solid; width: 100px; padding:7px; margin-left:4px;" class="radio">
                                    <label for="activos">
                                          @if ($estado == '1')
                                                <input  type="radio" id="estado" name="estado" value="1" checked>          
                                          @else
                                                <input  type="radio" id="estado" name="estado" value="1">
                                          @endif
                                    Activos</label>
                                    <label for="inactivos">
                                          @if ($estado == '2')
                                                <input  type="radio" id="estado2" name="estado" value="2" checked>          
                                          @else
                                                <input  type="radio" id="estado2" name="estado" value="2">
                                          @endif
                                    inactivos </label>
                              </div>
                          </td>
                    </tr>
              </table>
            </div>
      </div>

      {{-- selec activos inactivos --}}
      {{-- <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            
      </div> --}}
      {{-- fin select activos inactivos --}}
{{Form::close()}}
