

<style>
@page { margin:0px; }	
.headerLetters{font-size: 12px;}
.letter1{font-size: :8px;}
</style>

<style>
    
    #footer { position: fixed; left: 30px; bottom: 10px; right: 0px; height: 200px; border-style: none; border-color: gray;}
    tbody:before, tbody:after { display: none; }
    
  </style>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<title>Amonestacion Laboral</title>
</head>
<body>
	<div class="container">

		<div class="row">
			<div class="col-md-12">
				<br>
				<div class="table-responsive">
					<table class="table table-hover" id="tabla">
						<thead>
							<tr>
								
							</tr>
						</thead>

						<tbody style="border-style: none; margin-top: 150px;">
							<tr>
								<td class="w-25"><img src="{{ public_path()."/img/innlogo.jpg" }}" style="height: 120px; width: 200px;" alt=""></td>
								
								<td class="text-center" colspan="2">
									<br>

									<h3 class="font-weight-bold">Amonestacion Laboral</h3>
								</td>
								<td colspan="2">
									<br>
										<br>
										<br><br>

										<span class="text-muted headerLetters">{{ 'Mexicali ,B.C. '.date('Y-d-M') }}</span>
								</td>
							</tr>


							

							<tr>
								<td colspan="4"  style="padding-top: 1cm; padding-bottom: 0; border-style: none;">
									
									<span class="font-weight-bold">Se dirige el siguiente documento a :</span> {{$empleado->nombre.' '.$empleado->apellido1.' '.$empleado->apellido2}}
								</td>	
							</tr>


							

							<tr class="mt-10">
								<td colspan="4" style="padding-top: 0; padding-bottom: 0; border-style: none;">
									
									<span class="font-weight-bold">Motivo de amonestacion :</span> {{$amonestacion->motivo}}
									
								</td>
								
							</tr>

							<tr class="mt-0">
								<td colspan="4" style="padding-top: 0; padding-bottom: 0; border-style: none;">
									
									<span class="font-weight-bold">Tipo de Falta :</span> {{$amonestacion->tipo}}

								</td>
							</tr>
							<tr class="mt-0">
								<td colspan="4" style="padding-top: 0; padding-bottom: 0; border-style: none;">
									
									<span class="font-weight-bold">Fecha de la amonestacion :</span> {{$amonestacion->created_at->format('d/m/Y') }}

								</td>
							</tr>
							
							<tr class="mt-0">
								<td colspan="4" style="padding-top: 1cm; padding-bottom: 0; border-style: none;">
									
									Por el presente le comunicamos que dicha falta quedará anotada en su expediente y que al acumular 3 amonestaciones tendrá consecuencia 1 dia que no se le dará acceso a desempeñar sus laboera (se le descansará) y no tendrá derecho a recibir bono.

								</td>
							</tr>

							<tr class="mt-0">
								<td colspan="4" style="padding-top: 1cm; padding-bottom: 0; border-style: none;">
									
									<span class="font-weight-bold">La sanción a aplicarse será :</span> {{$amonestacion->sancion}}

								</td>
							</tr>
							



						</tbody>
					</table>
				</div>
			</div>
		</div>


		
	</div>
	<div id="footer" class="container">
		
			
			<table>
				<thead>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</thead>

				<tbody>
					<tr>
						<td>
							<span class="text-muted headerLetters">
								
							</span>
							
							
						</td>
						
						<td>
							
						</td>

						<td></td>
						<td></td>
						
					</tr>

					<tr>
						<td>
							<span class="headerLetters">
								
							<span class="font-weight-bold">
							
							</span>

						</td>
						
						<td>
							<span class="headerLetters align-bottom">
								
							</span>
						</td>

						<td class="text-center">
							

						</td>
						<td class="text-center">
							

						</td>
						
					</tr>

					<tr>
						<td>
							<span class="headerLetters">

								<span class="font-weight-bold">
							
							</span>
						</td>
						
						<td>
							<span class="headerLetters align-bottom">
								
							</span>
						</td>

						<td><span class="font-weight-bold"></span></td>
						
					</tr>

					<tr>
						<td>
							<span class="headerLetters">
								<span class="font-weight-bold">
							
							</span>
						</td>
						
						<td> 
							<span class="headerLetters align-bottom">
							
							</span>
							
						</td>

						<td><span class="font-weight-bold"></span></td>
						<td></td>
						
					</tr>


					<tr>
						<td class="text-center">
							______________________ <br><span class="font-weight-bold">EDUARDO MENDOZA ARRIAGA</span>

						</td>
						
						<td class="text-center" style="padding-top: 80px;">
							______________________ <br><span class="font-weight-bold">LUIS E. VAZQUEZ RODRIGUEZ</span>

						</td>
						<td class="text-center">
							______________________ <br><span class="font-weight-bold">{{$empleado->nombre.' '.$empleado->apellido1.' '.$empleado->apellido2}}</span>

						</td>
						<td></td>
						
					</tr>

					
				</tbody>
			</table>

	</div>

</body>
</html>
