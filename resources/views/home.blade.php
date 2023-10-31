@extends('layouts.app')

@section('content')
<div style="margin-top: 150px; margin-bottom: 180px; class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2"></div>
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <form method="POST" action="{{ url('/usuario-actualizar') }}">
                @csrf
                {{ method_field('PUT') }}
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach
                        </ul>
                    </div>    
                @endif
                @if(session('notificacion'))   
                    <div class="alert alert-success" role="alert">
                      {{session('notificacion')}}
                    </div>
                @endif
                <div class="form-group">
                    <label for="exampleInputPassword1">Nombre</label>
                    <input type="text" class="form-control" name="nombre" value="{{ old('nombre') ?? auth()->user()->name }}">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Introduce tu vieja contraseña o una nueva contraseña">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Alias</label>
                    <input type="text" class="form-control" name="alias" value="{{ old('alias') ?? auth()->user()->alias }}">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Web</label>
                    <input type="text" class="form-control" name="web" value="{{ old('web') ?? auth()->user()->web}}">
                </div>
                <button type="submit" class="btn btn-info btn-sm">Actualizar</button>
            </form>
        </div>
    </div>
</div>
@endsection
