@extends("pdf.facturas.TemplateFacturas")

@section("content")

<div class="content">
	<div class="row">
		<div class="col">
			1
		</div>
		<div class="col">
			2
		</div>
		<div class="col">
			3
		</div>
	</div>
</div>
{!! nl2br($proyecto->descripcion_trabajo) !!}    
@endsection