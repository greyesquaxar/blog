@extends('layouts.appAdmin')

@section('content')

<div style="margin-top: 150px; margin-bottom: 180px;" class="container"> 
	<button type="button" class="btn btn-info"><a href="{{ route('articulos.create') }}">Añadir Nuevo Artículo</a></button>
    <div style="margin-top: 20px">
       {{--  <form class="form-inline" action="{{url('admin/buscador/articulos')}}" method="GET">
            @csrf
            <div class="form-group">
            <input type="text" class="form-control" id="exampleInputEmail2" name="busqueda" placeholder="Buscar">
            </div>
            <button style="margin-top: 8px" type="submit" class="btn btn-warning btn-sm">Buscar</button>
        </form> --}}
        <button id="eliminar" style="margin-top: 8px" type="submit" class="btn btn-danger btn-sm">Eliminar Todo</button>
    </div>
    @if(session('notificacion'))   
        <div class="alert alert-success" role="alert">
            {{session('notificacion')}}
        </div>
    @endif
    @if(session('notificacion2'))   
        <div class="alert alert-success" role="alert">
            {{session('notificacion2')}}
        </div>
    @endif
    <div class="row">
        <strong>{{ $todosArticulos }} articulos</strong>
    </div>
	<table id="articulos" class="table table-hover">
		<thead class="thead-dark">
			<tr>
			  <th scope="col">#</th>
			  <th scope="col">Título</th>
			  <th scope="col">Autor</th> 
              <th scope="col">Tema</th> 
			  <th scope="col">Fecha de creación</th>
			  <th scope="col">Activado</th>
              <th width="70px" scope="col">&nbsp;</th>
			  {{-- <th scope="col">Ver contenido</th>
			  <th scope="col">Editar</th>
			  <th scope="col">Eliminar</th> --}}
			</tr>
		</thead>
        
        {{-- <tbody>
		    @foreach($articulos as $articulo)
				<tr>
                    <th scope="row">{{ $articulo->id }}</th>
                    <td>{{ $articulo->titulo }}</td>
                    <td>{{ $articulo->user->name }}</td>
                    <td>{{ $articulo->theme->nombre }}</td>
                    <td>{{ $articulo->created_at->toDayDateTimeString() }}</td>
                    <td>{{ $articulo->EstaActivado}}</td>
				    <td>
                        <a href="{{ route('articulos.show',$articulo->id) }}">
                            <img width="25px" src="{{ asset('imagenes/admin/ver.png') }}" alt="title 1" title="title 1">
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('articulos.edit',$articulo->id) }}">
                            <img width="25px" src="{{ asset('imagenes/admin/editar.png') }}" alt="title 1" title="title 1">
                        </a>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('articulos.destroy',$articulo->id) }}">
                            @csrf
                            {{ method_field('DELETE') }}
                            <button class="eliminar" style = "background-color:white ;border:0" type="submit">
                                <img width="25px" src="{{ asset('imagenes/admin/eliminar.png') }}" alt="title 1" title="title 1">
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody> --}}
        
  </table>
{{--   <div class="row">
      <div class="col-xs-12 col-lg-10 col-lg-offset-1">
          {{ $articulos->links() }}
      </div>
  </div> --}}
</div>

@endsection

@section('articulos-css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap.min.css">
@endsection

@section('articulos-js')
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script>

    $(document).ready(function() {
        $('#articulos').DataTable({
            "serverSide": true,
        "ajax": "{{ url('/admin/articulos-datatable') }}",
        "columns":[
        	{data:'id'},
        	{data:'titulo'},
        	{data:'user.name'},
        	{data:'theme.nombre'},
        	{data:'created_at.date',
                render: function ( data, type, row ) {
                    let current_datetime = new Date(data);
                    let formatted_date = current_datetime.getDate() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getFullYear() + " " + current_datetime.getHours() + ":" + current_datetime.getMinutes() + ":" + current_datetime.getSeconds(); 
                    return formatted_date;        
                }
            },
            {data:'activo',
                render: function ( data, type, row ) {
                    if(data==1) return "Si";
                    else        return "No";                    
                }
            },
            {data:'id',
                render: function ( data, type, row ) {
                    return "<a href='/admin/articulos/"+data+"'><img width='25px' src='{{ asset('imagenes/admin/ver.png') }}'' alt='title 1' title='title 1'></a><a href='/admin/articulos/"+data+"/edit'><img width='25px' src='{{ asset('imagenes/admin/editar.png') }}' alt='title 1' title='title 1'></a><button class='eliminar' onclick='eliminar("+data+")' id='"+data+"' style='background-color:white ;border:0'><img width='25px' src='{{ asset('imagenes/admin/eliminar.png') }}'></button>"; 
                }
            }
        ],
            
            /*"scrollY":        "1000px",*/
            /*"paging":         false,*/
            "lengthMenu": [[10,25,50,100,200,-1], [10,25,50,100,200, "Todos"]],
            "language": {
                "lengthMenu": " _MENU_ artículos por página",
                /*"lengthMenu": 'Mostrar <select>'+
                                '<option value="10">10</option>'+
                                '<option value="25">25</option>'+
                                '<option value="50">50</option>'+
                                '<option value="100">100</option>'+
                                '<option value="-1">Todos</option>'+
                                '</select> Registros',*/
                "zeroRecords": "No he encontrado nada, lo siento",
                "info": "Mostrando _TOTAL_ Entradas",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado de _MAX_ total archivos)",
                "search":"Buscar",
                "paginate":{
                    "next":"Siguiente",
                    "previous":"Anterior"
                }
            }
        });

        $('#eliminar').click(function(){
            if(!confirm("¿Estás seguro?")){
                return false;
            }
            var url='/admin/eliminar-todos-articulos';
            toastr.info('Espere mientras se eliminan todos los artículos', {
                "progressBar": true,
                "positionClass": "toast-bottom-right",
            });
            axios.delete(url).then(response =>{ //eliminamos
                toastr.success('Todos los artículos han sido eliminados','¡Bien!', {
                    "progressBar": true,
                    "positionClass": "toast-bottom-right",
                }); 
                $('#articulos').DataTable().ajax.reload(); 
            }).catch(error => {
                alert(error);
            });
        });
        
    });

    function eliminar(id){
        var url='/admin/articulos/'+ id;
        axios.delete(url).then(response =>{ //eliminamos
            toastr.success('El artículo ha sido eliminado','¡Bien!', {
                "progressBar": true,
                "positionClass": "toast-bottom-right",
            });
            $('#articulos').DataTable().ajax.reload();   
        }).catch(error => {
            alert(error);
        });
    }

</script>
@endsection

