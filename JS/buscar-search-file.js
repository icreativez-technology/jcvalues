$(obtener_registros());
function obtener_registros(productos) {
  let name = $("#name").val();
  let lang = $("#lang").val();
  $.ajax({
    url: "busqueda-search-file.php",
    type: "POST",
    dataType: "html",
    data: { productos: productos, name: name, lang: lang },
  }).done(function (resultado) {
    $("#search-result").html(resultado);
  });
}

$(document).on("keyup", "#search-files", function () {
  var valorBusqueda = $(this).val();
  if (valorBusqueda != "") {
    obtener_registros(valorBusqueda);
    $("#search-result").next().hide();
  } else {
    obtener_registros();
    $("#search-result").next().show();
  }
});
