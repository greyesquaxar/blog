@extends('layouts.appAdmin')

@section('content')
	<div style="margin-top: 150px; margin-bottom: 180px;" class="container">
		<h3>Resolución recomendada: 1920x1080 (HD)</h3>
		<form action="{{ url('admin/slider') }}" class="dropzone" id="my-awesome-dropzone">
		      @csrf
		</form>
		<hr>
		<div id="imagenesv" class="row">
			{{-- Aquí mostramos las imágenes --}}
		</div>
	</div>
@endsection

@section('slider-drop-zone-css')
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/dragula.css') }}">
@endsection

@section('slider-drop-zone-js')
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.min.js'></script>
	<script>
	function mostrarImagenes()
	{
		var imagenesMostrar = document.getElementById('imagenesv');
        axios.get('/admin/imagenes-slider',{responseType:'text'}).then(response => {
        	imagenesMostrar.innerHTML=response.data;
	    }).catch(error => {
	        console.log(error);
	    });
	}

	function eliminarImagen(id)
	{
		var url='/admin/slider/'+id;
        axios.delete(url).then(response =>{ //eliminamos
        	mostrarImagenes(); 
        }).catch(error => {
        	alert(error);
        }); 
	}

	$(document).ready(function() {
		mostrarImagenes();
		Dropzone.options.myAwesomeDropzone = {
		    paramName: "file", // Las imágenes se van a usar bajo este nombre de parámetro
		    maxFilesize: 2, // Tamaño máximo en MB
		    success: function (file, response) {
		        mostrarImagenes();
		    }
		};

		dragula([document.getElementById('imagenesv')])
		  .on('drop', function (el) {
		  	var ultimo=false;
		  	var posicionInicial=el.id;
		  	var posicionFinal=$('#'+el.id).next().attr('id');
		  	if(posicionFinal==undefined){
		  		posicionFinal=false;
		  		ultimo=true; // Cuando idSecundario=0, tomará la última posición.
		  	}
		  	axios.get('/admin/imagenes-ordenar/'+ posicionInicial +'/'+ posicionFinal +'/'+ ultimo,{responseType:'text'}).then(response => {
		  		mostrarImagenes();
		  		toastr.info('La imagen se ha cambiado','¡Bien!', {
                    "progressBar": true,
                    "positionClass": "toast-top-center",
                });
		    }).catch(error => {
		        console.log(error);
		    });
		  });
	});
	</script>
@endsection
