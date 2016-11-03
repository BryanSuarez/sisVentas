@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h3>Editar Artículo: {{ $articulo->nombre }}</h3>


            {!!Form::model($articulo,['method'=>'PATCH','route'=>['almacen.articulo.update',$articulo->idarticulo], 'files'=>'true'])!!}
            {{Form::token()}}

            <div class="row">
                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="{{$articulo->nombre}}">
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="">Categoría</label>
                        <select name="idcategoria"  class="form-control">
                            @foreach($categorias as $cat)
                                @if($cat->idcategoria == $articulo->idcategoria)
                                <option value="{{ $cat->idcategoria }}" selected>{{ $cat->nombre }}  </option>
                                    @else
                                      <option value="{{ $cat->idcategoria }}">{{ $cat->nombre }}  </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="codigo">Código</label>
                        <input type="text" name="codigo" class="form-control" value="{{$articulo->codigo }}">
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="stock">Stock</label>
                        <input type="text" name="stock" class="form-control" value="{{$articulo->stock }}" >
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <input type="text" name="descripcion" class="form-control"
                               value="{{$articulo->descripcion }}">
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="imagen">Imagen</label>
                        <input type="file" name="imagen" class="form-control">
                        @if(($articulo->imagen) != "")
                            <img src="{{asset('imagenes/articulos/'.$articulo->imagen)}}" alt="" height="200px" width="200px" class="img-thumbnail">
                        @endif
                    </div>
                </div>

                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Editar</button>
                        <button class="btn btn-danger" type="reset">Cancelar</button>
                    </div>
                </div>
            </div>

            {!!Form::close()!!}

        </div>
    </div>
@endsection