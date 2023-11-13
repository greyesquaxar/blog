@extends('layouts.appAdmin')

@section('content')
<script src="//cdn.ckeditor.com/4.11.2/full/ckeditor.js"></script>
<form method="POST" action="{{ route('articulos.update', $articulo->id) }}" enctype="multipart/form-data" class="temaFormuEdit">
	@csrf
    {{ method_field('PUT') }}	
	<div style="margin-top: 150px; margin-bottom: 180px;" class="container">
		@if (session('notificacion'))
			<div class="alert alert-success" role="alert">
				{{session('notificacion')}}
			</div>
		@endif
		@if($errors->any())
	        <div class="alert alert-danger">
	            <ul>
	                @foreach($errors->all() as $error)

	                    <li>{{ $error }}</li>

	                @endforeach
	            </ul>
	        </div>    
	    @endif
	    <div class="row">
	        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2"></div>
	        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
	        	<p><b>Activar</b></p>
	            <div class="radio">
				  <label>
				    <input type="radio" name="activo" value="1" @if((old('activar',$articulo->activo))) checked @endif>
				    	Si
				  </label>
				</div>
				<div class="radio">
				  <label>
				    <input type="radio" name="activo" value="0" @if(!(old('activar',$articulo->activo))) checked @endif>
				    	No
				  </label>
				</div>
				<hr>
	            <div class="form-group">
	                <label for="exampleInputPassword1">Titulo</label>
	                <input type="text" class="form-control" name="titulo" value="{{ old('titulo',$articulo->titulo) }}">
	            </div>
	            <hr>
	            <div class="form-group">
	                <label for="exampleInputPassword1">Categoria</label>
		            <select class="form-control" name="theme_id">
						
						@foreach($temasTodos as $tema)
							<option value="{{ $tema->id }}" {{ old('theme_id', $articulo->theme_id) == $tema->id ? 'selected' : '' }}>
							{{ $tema->nombre }}
							</option>
					  	@endforeach

					</select>
				</div>
				<hr>
				<div class="form-group">
	                <label for="exampleInputPassword1">Contenido</label>
					<textarea class="form-control" rows="5" name="contenido">{{ old('contenido',$articulo->contenido) }}</textarea>
					<script>
						CKEDITOR.replace('contenido');
					</script>	
				</div>
				<hr>
                @foreach($articulo->images as $imagen)
					<div class="padre" id="{{ $imagen->id }}" style="float:left">
						<img width="190px" src="{{ Storage::url('imagenesArticulos/'.$imagen->nombre) }}">
						{{-- <a href="{{ route('imagen.delete',$imagen) }}"> --}}
						<img class="hijo" style="cursor: pointer; margin-left: -20px; margin-top: -170px" width="20px" src="{{asset('imagenes/admin/eliminar.png')}}">
						{{-- </a> --}}
					</div>
				@endforeach
				<div style="clear:both"></div>
				<div id="contenido" articulo="{{ $articulo->id }}"></div>
                {{-- @if($articulo->images->count()<3)
				    <p><h3>Añadir imágenes (máximo 3 imágenes por artículo)</h3></p>
				@endif
				  <div class="container">
				     @for($i=3;$i>$articulo->images->count();$i--)
				        <div style="margin-top: 20px" class="row">  
				          <div style="margin-top: 20px" class="col-1">
				            <input type="file" name="foto{{$i}}"></input>
				          </div>
				        </div>
				     @endfor
				  </div> --}}
                <hr>
	            <button type="submit" class="btn btn-info btn-sm">Actualizar</button>
	        </div>
	    </div>
	</div>
</form>
@endsection


@section('eliminar-img-js')
	<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script>
		var contenido = document.getElementById("contenido");
		var articulo = $('#contenido').attr("articulo");
		function showInputsFile(articulo,contenido){
			axios.get('/admin/inputs-file/' + articulo,{responseType:'text'}).then(response => {
	        contenido.innerHTML=response.data;
		    }).catch(error => {
		        console.log(error);
		    });
		}
		$(document).ready(function() {
			showInputsFile(articulo,contenido);
			$('.hijo').click(function(){
				var id = $(this).parent().attr('id'); 
				var url='/admin/imagenes/'+ id;
	            axios.delete(url).then(response =>{ //eliminamos
	            	$(this).parent().addClass("hinge"); // Eliminar con efecto
	            	$(this).parent().fadeOut(2000);	   // Eliminar con efecto
	            }).catch(error => {
	            	alert(error);
	            });
	            showInputsFile(articulo,contenido); 
			});
		});
	</script>
@endsection