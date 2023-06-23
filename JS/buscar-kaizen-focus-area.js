$(obtener_registros());
function obtener_registros(productos) {
  $.ajax({
    url: "busqueda-kaizen-focus-area.php",
    type: "POST",
    dataType: "html",
    data: { productos: productos },
  }).done(function (resultado) {
    $("#result-busqueda").html(resultado);
  });
}

$(document).on("keyup", "#termino", function () {
  var valorBusqueda = $(this).val();
  if (valorBusqueda != "") {
    obtener_registros(valorBusqueda);
    $("#result-busqueda").next().hide();
  } else {
    obtener_registros();
    $("#result-busqueda").next().show();
  }
});
