$(obtener_registros());

function obtener_registros(productos) {
  $.ajax({
    url: "busqueda-file.php",
    type: "POST",
    dataType: "html",
    data: { productos: productos },
  }).done(function (resultado) {
    $("#docu_resultados").html(resultado);
  });
}

$(document).on("keyup", "#termino", function () {
  var valorBusqueda = $(this).val();
  if (valorBusqueda != "") {
    obtener_registros(valorBusqueda);
    $("#docu_resultados").next().hide();
  } else {
    obtener_registros();
    $("#docu_resultados").next().show();
  }
});
