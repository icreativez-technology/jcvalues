
$(obtener_registros());
function obtener_registros(productos)
{
	$.ajax({
		url : 'busqueda-quality-risk-source.php',
		type : 'POST',
		dataType : 'html',
		data : { productos: productos },
	})
	.done(function(resultado){
		$("#result-busqueda").html(resultado);
	})
}

$(document).on('keyup', '#termino', function()
{
	var valorBusqueda=$(this).val();
	
	if (valorBusqueda!="")
	{
		obtener_registros(valorBusqueda);
		$('#admin_quality_risk_table, .pagination').hide();
	}
	else
	{
		obtener_registros();
		$('#admin_quality_risk_table, .pagination').show();
	}
});