
$(obtener_registros());
function obtener_registros(productos)
{
	$.ajax({
		url : 'busqueda-suppliers.php',
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
		$('#kt_suppliers_table, .pagination').hide();
	}
	else
	{
		obtener_registros();
		$('#kt_suppliers_table, .pagination').show();
	}
});