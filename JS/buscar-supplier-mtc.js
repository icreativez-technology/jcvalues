$(obtener_registros());
function obtener_registros(productos) {
  $.ajax({
    url: "busqueda-supplier-mtc.php",
    type: "POST",
    dataType: "html",
    data: { productos: productos },
  }).done(function (resultado) {
    $("#result-busqueda").html(resultado);
    // $("#po_search").val(localStorage.getItem('po_text'));
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

$(document).on("keyup", "#po_search", function () {
  var valorBusqueda = $(this).val();
  if (valorBusqueda != "") {
    obtener_registros(valorBusqueda);
    $("#result-busqueda").next().hide();
  } else {
    obtener_registros();
    $("#result-busqueda").next().show();
  }
});

$(document).on("keyup", "#mtc_search", function () {
  var valorBusqueda = $(this).val();
  if (valorBusqueda != "") {
    obtener_registros(valorBusqueda);
    $("#result-busqueda").next().hide();
  } else {
    obtener_registros();
    $("#result-busqueda").next().show();
  }
});

$(document).on("keyup", "#item_search", function () {
  var valorBusqueda = $(this).val();
  if (valorBusqueda != "") {
    obtener_registros(valorBusqueda);
    $("#result-busqueda").next().hide();
  } else {
    obtener_registros();
    $("#result-busqueda").next().show();
  }
});

$(document).on("keyup", "#mat_search", function () {
  var valorBusqueda = $(this).val();
  if (valorBusqueda != "") {
    obtener_registros(valorBusqueda);
    $("#result-busqueda").next().hide();
  } else {
    obtener_registros();
    $("#result-busqueda").next().show();
  }
});

$(document).on("keyup", "#heat_search", function () {
  var valorBusqueda = $(this).val();
  if (valorBusqueda != "") {
    obtener_registros(valorBusqueda);
    $("#result-busqueda").next().hide();
  } else {
    obtener_registros();
    $("#result-busqueda").next().show();
  }
});

$(document).on("keyup", "#class_search", function () {
  var valorBusqueda = $(this).val();
  if (valorBusqueda != "") {
    obtener_registros(valorBusqueda);
    $("#result-busqueda").next().hide();
  } else {
    obtener_registros();
    $("#result-busqueda").next().show();
  }
});
