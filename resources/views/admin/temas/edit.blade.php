@extends('layouts.appAdmin')

@section('content')

<form method="POST" action="{{ route('tema.update', $tema) }}" class="temaFormuEdit">
	@csrf
	{{ method_field('PUT') }}	
	<div style="margin-top: 150px; margin-bottom: 180px;" class="container">
		@if(session('notificacion2'))   
	        <div class="alert alert-danger" role="alert">
	          {{session('notificacion2')}}
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
	            <div class="form-group">
	                <label for="exampleInputPassword1">Nombre</label>
	                <input type="text" class="form-control" name="nombre" value="{{ old('nombre',$tema->nombre) }}">
	            </div>
	            <hr>
	            <p><b>Destacado</b></p>
	            <div class="radio">
				  <label>
				    <input type="radio" name="destacado" value="1" @if((old('destacado',$tema->destacado))) checked @endif>
				    	Si
				  </label>
				</div>
				<div class="radio">
				  <label>
				    <input type="radio" name="destacado" value="0" @if(!(old('destacado',$tema->destacado))) checked @endif>
				    	No
				  </label>
				</div>
				<hr>
				<p><b>Suscripción</b></p>
				<div class="radio">
				  <label>
				    <input type="radio" name="suscripcion" value="1" @if((old('suscripcion',$tema->suscripcion))) checked @endif>
				    	Si
				  </label>
				</div>
				<div class="radio">
				  <label>
				    <input type="radio" name="suscripcion" value="0" @if(!(old('suscripcion',$tema->suscripcion))) checked @endif>
				    	No
				  </label>
				</div>
	            <button type="submit" class="btn btn-info btn-sm">Actualizar</button>
	        </div>
	    </div>
	</div>
</form>

@endsection