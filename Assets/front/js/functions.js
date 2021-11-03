// Funcion para agregar productos al carrito

$(".js-addcart-detail").each(function () {
  var nameProduct = $(this)
    .parent()
    .parent()
    .parent()
    .parent()
    .parent()
    .find(".js-name-detail")
    .html();
  $(this).on("click", function () {
    let id = this.getAttribute("id");
    let cantidad = document.getElementById("cantidad-producto").value;
    let talla = document.getElementById("talla-producto").value;
    let color = document.getElementById("color-producto").value;

    if (isNaN(cantidad) || cantidad < 1 || cantidad > 3) {
      swal("", "La cantidad de productos debe ser mínimo 1 máximo 3", "error");
      return;
    } else if (talla == "" || color == "") {
      swal("Atención", "Todos los campos son obligatorios.", "error");
      return;
    }

    let $request = window.XMLHttpRequest
        ? new XMLHttpRequest()
        : new ActiveXObject("Microsoft.XMLHTTP"),
      $ajaxUrl = base_url + "/VshoesProductos/agregarCarrito";
    let $formData = new FormData();

    $formData.append("id", id);
    $formData.append("cantidad", cantidad);
    $formData.append("talla", talla);
    $formData.append("color", color);

    $request.open("POST", $ajaxUrl, true);
    $request.send($formData);
    $request.onreadystatechange = function () {
      if ($request.readyState != 4) return;
      if ($request.status == 200) {
        // console.log($request.responseText);
        let objData = JSON.parse($request.responseText);
        if (objData.status) {
          document.querySelector("#cantidadCarrito").innerHTML =
            objData.cantidadCarrito;
          document.querySelector("#productoCarrito").innerHTML =
            objData.htmlCarrito;
          swal(nameProduct, "Se ha agregado al carrito", "success");
        } else {
          swal("", objData.msg, "error");
        }
      }
      return false;
    };
  });
});

// Fin Funcion para agregar productos al carrito

// Conteador para cantidad de productos

$(".btn-num-product-down").on("click", function () {
  let numProduct = Number($(this).next().val());
  let idProducto = this.getAttribute("idProducto");
  if (numProduct > 1)
    $(this)
      .next()
      .val(numProduct - 1);
  let cantidad = $(this).next().val();
  if (idProducto != null) {
    fntUpdateCantidad(idProducto, cantidad);
  }
});

$(".btn-num-product-up").on("click", function () {
  let numProduct = Number($(this).prev().val());
  let idProducto = this.getAttribute("idProducto");
  $(this)
    .prev()
    .val(numProduct + 1);
  if (numProduct >= 3) {
    swal("", "La cantidad de productos debe ser mínimo 1 máximo 3", "error");
    return;
  } else {
    let cantidad = $(this).prev().val();
    if (idProducto != null) {
      fntUpdateCantidad(idProducto, cantidad);
    }
  }
});

if (document.querySelector(".num-product")) {
  let inputCantidad = document.querySelectorAll(".num-product");
  inputCantidad.forEach(function (inputCantidad) {
    inputCantidad.addEventListener("keyup", function () {
      let idProducto = this.getAttribute("idProducto");
      let cantidad = this.value;

      if (cantidad > 3) {
        swal(
          "",
          "La cantidad de productos debe ser mínimo 1 máximo 3",
          "error"
        );
        return;
      } else {
        if (idProducto != null) {
          fntUpdateCantidad(idProducto, cantidad);
        }
      }
    });
  });
}

// Fin Conteador para cantidad de productos

// Funcion para eliminar productos del carrito

function fntDelProducto(e) {
  // console.log(e);
  let $opcion = e.getAttribute("opcion");
  let $idProducto = e.getAttribute("idproducto");
  if ($opcion == 1 || $opcion == 2) {
    let $request = window.XMLHttpRequest
        ? new XMLHttpRequest()
        : new ActiveXObject("Microsoft.XMLHTTP"),
      $ajaxUrl = base_url + "/VshoesProductos/eliminarCarrito";
    let $formData = new FormData();

    $formData.append("id", $idProducto);
    $formData.append("opcion", $opcion);

    $request.open("POST", $ajaxUrl, true);
    $request.send($formData);
    $request.onreadystatechange = function () {
      if ($request.readyState != 4) return;
      if ($request.status == 200) {
        //  console.log($request.responseText);
        let objData = JSON.parse($request.responseText);

        //  console.log(objData);
        if (objData.status) {
          if ($opcion == 1) {
            document.querySelector("#cantidadCarrito").innerHTML =
              objData.cantidadCarrito;
            document.querySelector("#productoCarrito").innerHTML =
              objData.htmlCarrito;
          } else {
            e.parentNode.parentNode.parentNode.remove();
            document.getElementById("subtotal").innerHTML = objData.subTotal;
            document.getElementById("total").innerHTML = objData.total;
            if (document.querySelectorAll("tablaCarrito tr").length == 1) {
              window.location.href = base_url;
            }
          }
        } else {
          swal("", objData.msg, "error");
        }
      }
      return false;
    };
  }
}

// Fin Funcion para eliminar productos del carrito

// Funcion para actualizar cantidad de productos del carrito
function fntUpdateCantidad(producto, cantidad) {
  if (cantidad <= 0) {
    document.getElementById("pagar").classList.add("notBlock");
  } else {
    document.getElementById("pagar").classList.remove("notBlock");
    let request = window.XMLHttpRequest
      ? new XMLHttpRequest()
      : new ActiveXObject("Mixrosoft.XMLHTTP");
    let ajaxUrl = base_url + "/VshoesProductos/actualizarCarrito";
    let formData = new FormData();

    formData.append("idProducto", producto);
    formData.append("cantidad", cantidad);
    request.open("POST", ajaxUrl, true);
    request.send(formData);

    request.onreadystatechange = function () {
      if (request.readyState != 4) return;
      if ((request.status = 200)) {
        let objData = JSON.parse(request.responseText);
        if (objData.status) {
          if (cantidad <= 3) {
            let columnaSubT = document.getElementsByClassName(producto)[0];

            columnaSubT.cells[3].textContent = objData.precioProductos;

            document.getElementById("subtotal").innerHTML = objData.subTotal;
            document.getElementById("total").innerHTML = objData.total;
          }
        } else {
          swal("", objData.msg, "error");
        }
      }
    };
  }
  return false;
}

// Fin Funcion para actualizar cantidad de productos del carrito

// Funcion para registro de cuenta
if (document.getElementById("formRegistro")) {
  let $formRegistro = document.getElementById("formRegistro");
  $formRegistro.addEventListener("submit", function (e) {
    e.preventDefault();

    let $strNombres = document.getElementById("txtNombres").value;
    let $strApellidos = document.getElementById("txtApellidos").value;
    let $intTelefono = document.getElementById("txtTelefono").value;
    let $strEmail = document.getElementById("txtEmailCliente").value;

    // Validar campos vacios

    if (
      $strNombres == "" ||
      $strApellidos == "" ||
      $intTelefono == "" ||
      $strEmail == ""
    ) {
      swal("Atención", "Todos los campos son obligatorios.", "error");
      return false;
    }
    let elementosValidos = document.getElementsByClassName("valid");
    for (let index = 0; index < elementosValidos.length; index++) {
      if (elementosValidos[index].classList.contains("is-invalid")) {
        swal("Atención.", "Verifique los campos en rojo.", "error");
        return false;
      }
    }
    $loading.style.display = "flex";

    let request = window.XMLHttpRequest
      ? new XMLHttpRequest()
      : new ActiveXObject("Microsoft.XMLHTTP");
    let ajaxUrl = base_url + "/VshoesProductos/registroCliente";
    let formData = new FormData($formRegistro);
    request.open("POST", ajaxUrl, true);
    request.send(formData);
    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        let objData = JSON.parse(request.responseText);
        if (objData.status) {
          window.location.reload(false);
        } else {
          swal("Error", objData.msg, "error");
        }
      }
      $loading.style.display = "none";
      return false;
    };
  });
}
// Fin Funcion para registro de cuenta

// Funcion para seleccionar metodo de pago
if (document.querySelector(".metodoPago")) {
  let opcionPago = document.querySelectorAll(".metodoPago");
  opcionPago.forEach(function (opcionPago) {
    opcionPago.addEventListener("click", function () {
      if (this.value == "Paypal") {
        document.getElementById("pagoPaypal").classList.remove("notBlock");
        document.getElementById("tipoPago").classList.add("notBlock");
      } else {
        document.getElementById("pagoPaypal").classList.add("notBlock");
        document.getElementById("tipoPago").classList.remove("notBlock");
      }
    });
  });
}

// Fin Funcion para seleccionar metodo de pago
if (document.getElementById("txtDireccion")) {
  let inputDireccion = document.getElementById("txtDireccion");

  inputDireccion.addEventListener("keyup", function () {
    let direccion = this.value;

    fntVerTipoPago();
  });
}
if (document.getElementById("intCodigoPostal")) {
  let inputCodigoPostal = document.getElementById("intCodigoPostal");

  inputCodigoPostal.addEventListener("keyup", function () {
    let codigoPostal = this.value;

    fntVerTipoPago();
  });
}
if (document.getElementById("txtEstado")) {
  let inputEstado = document.getElementById("txtEstado");

  inputEstado.addEventListener("keyup", function () {
    let estado = this.value;

    fntVerTipoPago();
  });
}
if (document.getElementById("txtCiudad")) {
  let inputCiudad = document.getElementById("txtCiudad");

  inputCiudad.addEventListener("keyup", function () {
    let ciudad = this.value;

    fntVerTipoPago();
  });
}
if (document.getElementById("txtColonia")) {
  let inputColonia = document.getElementById("txtColonia");

  inputColonia.addEventListener("keyup", function () {
    let colonia = this.value;

    fntVerTipoPago();
  });
}

function fntVerTipoPago() {
  let inputDireccion = document.getElementById("txtDireccion").value;
  let inputCodigoPostal = document.getElementById("intCodigoPostal").value;
  let inputEstado = document.getElementById("txtEstado").value;
  let inputCiudad = document.getElementById("txtCiudad").value;
  let inputColonia = document.getElementById("txtColonia").value;

  if (
    inputDireccion == "" ||
    inputCodigoPostal == "" ||
    inputEstado == "" ||
    inputCiudad == "" ||
    inputColonia == ""
  ) {
    document.getElementById("tiposPago").classList.add("notBlock");
  } else {
    document.getElementById("tiposPago").classList.remove("notBlock");
  }
}

if (document.getElementById("pagar")) {
  let bntPagar = document.getElementById("pagar");

  bntPagar.addEventListener(
    "click",
    function () {
      let direccion = document.getElementById("txtDireccion").value;
      let codigoPostal = document.getElementById("intCodigoPostal").value;
      let estado = document.getElementById("txtEstado").value;
      let ciudad = document.getElementById("txtCiudad").value;
      let colonia = document.getElementById("txtColonia").value;
      let tipoPago = document.getElementById("listaTipoPago").value;
      if (
        direccion == "" ||
        codigoPostal == "" ||
        estado == "" ||
        ciudad == "" ||
        colonia == "" ||
        tipoPago == ""
      ) {
        swal("Atención", "Todos los campos son obligatorios.", "error");
        return false;
      } else {
        $loading.style.display = "flex";

        let request = window.XMLHttpRequest
          ? new XMLHttpRequest()
          : new ActiveXObject("Microsoft.XMLHTTP");

        let ajaxUrl = base_url + "/VshoesProductos/venta";
        let formData = new FormData();
        formData.append("direccion", direccion);
        formData.append("codigoPostal", codigoPostal);
        formData.append("estado", estado);
        formData.append("ciudad", ciudad);
        formData.append("colonia", colonia);
        formData.append("tipoPago", tipoPago);

        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function () {
          if (request.readyState != 4) return;
          if (request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
              window.location =
                base_url + "/VshoesProductos/confirmacionPedido";
            } else {
              swal("", objData.msg, "error");
            }
          }
          $loading.style.display = "none";
        };
      }
    },
    false
  );
}

if (document.getElementById("formContacto")) {
  let formContacto = document.getElementById("formContacto");

  formContacto.addEventListener(
    "submit",
    function (e) {
      e.preventDefault();

      let nombreContacto = document.getElementById("nombreContacto").value;
      let emailContacto = document.getElementById("emailContacto").value;
      let mensajeContacto = document.getElementById("mensajeContacto").value;

      if (
        nombreContacto == "" ||
        emailContacto == "" ||
        mensajeContacto == ""
      ) {
        swal("Atención", "Todos los campos son obligatorios.", "error");
        return false;
      }
      let elementosValidos = document.getElementsByClassName("valid");
      for (let index = 0; index < elementosValidos.length; index++) {
        if (elementosValidos[index].classList.contains("is-invalid")) {
          swal("Atención.", "Verifique los campos en rojo.", "error");
          return false;
        }
      }

      
      $loading.style.display = "flex";

      let request = window.XMLHttpRequest
        ? new XMLHttpRequest()
        : new ActiveXObject("Microsoft.XMLHTTP");

      let ajaxUrl = base_url + "/VshoesProductos/contacto";
      let formData = new FormData(formContacto);

      request.open("POST", ajaxUrl, true);
      request.send(formData);
      request.onreadystatechange = function () {
        if (request.readyState != 4) return;
        if (request.status == 200) {
          // console.log(request.responseText);
          let objData = JSON.parse(request.responseText);
          if (objData.status) {
           swal("", objData.msg, "success");
          document.getElementById("formContacto").reset();
          } else {
            swal("", objData.msg, "error");
          }
        }
        $loading.style.display = "none";
        return false;
      };
    },
    false
  );
}
