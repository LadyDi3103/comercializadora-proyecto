let tableProductos,
  $rowTable = "";

const d = document,
  $loading = d.getElementById("loading");

d.write(
  `<script src="${base_url}/Assets/js/plugins/JsBarcode.all.min.js"></script>`
);
$(document).on("focusin", function (e) {
  if ($(e.target).closest(".tox-dialog").length) {
    e.stopImmediatePropagation();
  }
});

tableProductos = $("#tableProductos").dataTable({
  aProcessing: true,
  aServerSide: true,
  language: {
    url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
  },
  ajax: {
    url: " " + base_url + "/Productos/getProductos",
    dataSrc: "",
  },
  columns: [
    { data: "id_producto" },

    { data: "nombre_producto" },

    { data: "precio_producto" },
    { data: "stockTotal" },
    { data: "status" },
    { data: "opciones" },
  ],
  columnDefs: [
    { className: "textright", targets: [3] },
    { className: "textcenter", targets: [4] },
    { className: "textcenter", targets: [5] },
  ],
  dom: "lBfrtip",
  buttons: [
    {
      extend: "copyHtml5",
      text: "<i class ='fas fa-copy separacion'></i>Copiar",
      titleAttr: "Copiar",
      className: "btn btn-secondary",
      exportOptions: {
        columns: [0, 1, 2, 3, 4],
      },
    },
    {
      extend: "excelHtml5",
      text: "<i class ='far fa-file-excel separacion'></i>Excel",
      titleAttr: "Exportar a Excel",
      className: "btn btn-success",
      exportOptions: {
        columns: [0, 1, 2, 3, 4],
      },
    },
    {
      extend: "pdfHtml5",
      text: "<i class ='far fa-file-pdf separacion'></i>PDF",
      titleAttr: "Exportar a PDF",
      className: "btn btn-danger",
      exportOptions: {
        columns: [0, 1, 2, 3, 4],
      },
    },
    {
      extend: "csvHtml5",
      text: "<i class ='fas fa-file-csv separacion'></i>CSV",
      titleAttr: "Exportar a CSV",
      className: "btn btn-info",
      exportOptions: {
        columns: [0, 1, 2, 3, 4],
      },
    },
  ],
  responsive: true,
  bDestroy: true,
  iDisplayLength: 10,
  order: [[0, "desc"]],
});
window.addEventListener(
  "load",
  function () {
    if (d.getElementById("formProductos")) {
      let $formProductos = d.getElementById("formProductos");
      $formProductos.addEventListener("submit", function (e) {
        e.preventDefault();
        let strNombre = d.getElementById("txtNombre").value;
        let intCodigo = d.getElementById("txtCodigo").value;
        let strPrecio = d.getElementById("txtPrecio").value;
        let intStock = d.getElementById("txtStock").value;
        let $intStatus = d.getElementById("listaEstados").value;

        if (
          strNombre == "" ||
          intCodigo == "" ||
          strPrecio == "" ||
          intStock == ""
        ) {
          swal("Atención.", "Todos los campos son obligatorios.", "error");
          return false;
        }
        if (intCodigo.length < 5) {
          swal("Atención.", "El código debe ser mayor a 5 dígitos", "error");
          return false;
        }
        $loading.style.display = "flex";
        tinyMCE.triggerSave();
        let request = window.XMLHttpRequest
          ? new XMLHttpRequest()
          : new ActiveXObject("Microsoft.XMLHTTP");
        let ajaxUrl = base_url + "/Productos/setProducto";
        let formData = new FormData($formProductos);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function () {
          if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
              swal("", objData.msg, "success");
              d.getElementById("idProducto").value = objData.id_producto;
              d.getElementById("containerGallery").classList.remove("notBlock");

              if ($rowTable == "") {
                tableProductos.api().ajax.reload();
              } else {
                $htmlStatus =
                  $intStatus == 1
                    ? '<span class ="badge badge-success">Activo</span>'
                    : '<span class ="badge badge-danger">Inactivo</span>';

                $rowTable.cells[1].textContent = strNombre;
                $rowTable.cells[2].textContent = simboloMoney + strPrecio;
                $rowTable.cells[3].textContent = intStock;

                $rowTable.cells[4].innerHTML = $htmlStatus;
                rowTable = "";
              }
            } else {
              swal("Error", objData.msg, "error");
            }
          }
          $loading.style.display = "none";
          return false;
        };
      });
    }

    // funcion para las imagenes de los productos
    if (d.querySelector(".btnAddImage")) {
      let agregarImagen = d.querySelector(".btnAddImage");
      agregarImagen.addEventListener("click", function (e) {
        let timeId = Date.now();
        // alert(timeId);
        let $div = d.createElement("div");
        $div.id = "div" + timeId;
        $div.innerHTML = `
        <div class="prevImage">
          
        </div>
        <input type="file" name="foto" id="img${timeId}" class="inputUploadFile">
        <label for="img${timeId}" class="btnUploadFile"><i class="fas fa-upload"></i></label>
        <button class="btnDeleteImage notBlock" type="button" onclick="fntDelItem('#div${timeId}')"><i class="fas fa-trash-alt"></i></button>`;
        d.getElementById("containerImages").appendChild($div);
        d.querySelector("#div" + timeId + " .btnUploadFile").click();
        fntInputFile();
      });
    }
    fntInputFile();
    fntCategorias();
    fntColores();
    fntProveedores();
  },
  false
);

// Funcion para el codigo de barras

if (d.getElementById("txtCodigo")) {
  let $codigo = d.getElementById("txtCodigo");
  $codigo.onkeyup = function () {
    if ($codigo.value.length >= 5) {
      d.getElementById("divBarCode").classList.remove("notBlock");
      fntBarCode();
    } else {
      d.getElementById("divBarCode").classList.add("notBlock");
    }
  };
}

// funcion para el editor
tinymce.init({
  selector: "#txtDescripcion",
  width: "100%",
  height: 400,
  statubar: true,
  plugins: [
    "advlist autolink link image lists charmap print preview hr anchor pagebreak",
    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
    "save table contextmenu directionality emoticons template paste textcolor",
  ],
  toolbar:
    "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
});

// funcion para cargar las imagenes del producto
function fntInputFile() {
  let inputUploadFile = d.querySelectorAll(".inputUploadFile");
  inputUploadFile.forEach(function (inputUploadFile) {
    inputUploadFile.addEventListener("change", function () {
      let $idProducto = d.getElementById("idProducto").value;
      let $idParent = this.parentNode.getAttribute("id");
      let $idFile = this.getAttribute("id");
      let $fotoUpload = d.querySelector("#" + $idFile).value;
      let $imgFile = d.querySelector("#" + $idFile).files;
      let $prevImg = d.querySelector("#" + $idParent + " .prevImage");
      let $nav = window.URL || window.webkitURL;

      if ($fotoUpload != "") {
        let type = $imgFile[0].type;
        let name = $imgFile[0].name;
        if (
          type != "image/jpeg" &&
          type != "image/jpg" &&
          type != "image/png"
        ) {
          $prevImg.innerHTML = "El archivo no es válido.";
          $fotoUpload.value = "";
          return false;
        } else {
          let $imgObj = $nav.createObjectURL(this.files[0]);
          $prevImg.innerHTML = `<img class="loading" src="${base_url}/Assets/images/loading.svg">`;

          let request = window.XMLHttpRequest
            ? new XMLHttpRequest()
            : new ActiveXObject("Microsoft.XMLHTTP");

          let ajaxUrl = base_url + "/Productos/setImagen";
          let formData = new FormData();
          formData.append("idproducto", $idProducto);
          formData.append("foto", this.files[0]);
          request.open("POST", ajaxUrl, true);
          request.send(formData);
          request.onreadystatechange = function () {
            if (request.readyState != 4) return;
            if (request.status == 200) {
              let objData = JSON.parse(request.responseText);
              if (objData.status) {
                $prevImg.innerHTML = `<img src="${$imgObj}">`;
                d.querySelector(
                  "#" + $idParent + " .btnDeleteImage"
                ).setAttribute("imgnombre", objData.imgnombre);
                d.querySelector(
                  "#" + $idParent + " .btnUploadFile"
                ).classList.add("notBlock");
                d.querySelector(
                  "#" + $idParent + " .btnDeleteImage"
                ).classList.remove("notBlock");
              } else {
                swal("Error", objData.msg, "error");
              }
            }
          };
        }
      }
    });
  });
}

// Funcion para elminar foto del producto

function fntDelItem(element) {
  let nombreImagen = d
    .querySelector(element + " .btnDeleteImage")
    .getAttribute("imgnombre");
  let idProducto = d.getElementById("idProducto").value;

  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl = base_url + "/Productos/deleteFile";

  let formData = new FormData();
  formData.append("idProducto", idProducto);
  formData.append("foto", nombreImagen);
  request.open("POST", ajaxUrl, true);
  request.send(formData);
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);
      if (objData.status) {
        let removerItem = d.querySelector(element);
        removerItem.parentNode.removeChild(removerItem);
      } else {
        swal("Error", objData.msg, "error");
      }
    }
  };
}

// Funcion para ver informacion del prodcuto

function fntViewProducto(id_producto) {
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl = base_url + "/Productos/getProducto/" + id_producto;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);
      if (objData.status) {
        let objProducto = objData.data;
        let estadoProducto =
          objData.data.status == 1
            ? '<span class="badge badge-success">Activo</span>'
            : '<span class="badge badge-danger">inactivo</span>';
        let $htmlImagen = "";
        d.getElementById("celId").innerHTML = objProducto.id_producto;
        d.getElementById("celCodigo").innerHTML = objProducto.codigo_producto;
        d.getElementById("celNombre").innerHTML = objProducto.nombre_producto;
        d.getElementById("celCategoria").innerHTML =
          objProducto.nombre_categoria;
        d.getElementById("celColor").innerHTML = objProducto.nombre_color;
        d.getElementById("celProveedor").innerHTML =
          objProducto.nombre_proveedor;
        d.getElementById("celDescripcion").innerHTML =
          objProducto.descripcion_producto;
        d.getElementById("celPrecio").innerHTML = objProducto.precio_producto;
        d.getElementById("celStock").innerHTML = objProducto.stockTotal;
        d.getElementById("celStatus").innerHTML = estadoProducto;

        if (objProducto.imagenes.length > 0) {
          let objImgsProducto = objProducto.imagenes;
          for (let index = 0; index < objImgsProducto.length; index++) {
            $htmlImagen += `<img src="${objImgsProducto[index].url_imagen}"></img>`;
          }
        }
        d.getElementById("celFotos").innerHTML = $htmlImagen;
        $("#modalVerProducto").modal("show");
      } else {
        swal("Error", objData.msg, "error");
      }
    }
  };
}

// Funcion para editar la informacion del prodcuto
function fntEditProducto(e, id_producto) {
  $rowTable = e.parentNode.parentNode.parentNode;

  d.getElementById("titleModal").innerHTML = "Actualizar Producto";
  d.querySelector(".modal-header").classList.replace(
    "headerRegistro",
    "headerUpdate"
  );
  d.getElementById("btnActionForm").classList.replace(
    "btn-primary",
    "btn-info"
  );
  d.getElementById("btnText").innerHTML = "Actualizar";

  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl = base_url + "/Productos/getProducto/" + id_producto;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);
      if (objData.status) {
        let $htmlImagen = "";
        let objProductos = objData.data;
        // console.log(objData.data);
        d.getElementById("idProducto").value = objProductos.id_producto;
        d.getElementById("txtNombre").value = objProductos.nombre_producto;
        d.getElementById("txtDescripcion").value =
          objData.data.descripcion_producto;
        d.getElementById("txtCodigo").value = objProductos.codigo_producto;
        d.getElementById("txtPrecio").value = objProductos.precio_producto;
        d.getElementById("txtStock").value = objProductos.stockTotal;
        d.getElementById("listaCategorias").value = objData.data.categoria_id;
        d.getElementById("listaColores").value = objProductos.color_id;
        d.getElementById("listaEstados").value = objProductos.status;
        d.getElementById("listaProveedores").value = objProductos.proveedor_id;

        tinymce.activeEditor.setContent(objProductos.descripcion_producto);
        $("#listaCategorias").selectpicker("render");

        $("#listaEstados").selectpicker("render");
        $("#listaColores").selectpicker("render");
        $("#listaProveedores").selectpicker("render");

        fntBarCode();

        if (objProductos.imagenes.length > 0) {
          let imagenesProductos = objProductos.imagenes;
          for (let index = 0; index < imagenesProductos.length; index++) {
            let timeId = Date.now() + index;
            $htmlImagen += `<div id="div${timeId}">
            <div class="prevImage">
            <img src="${imagenesProductos[index].url_imagen}"></img>
            </div>
            <button type ="button" class="btnDeleteImage" onclick = "fntDelItem('#div${timeId}')" imgnombre="${imagenesProductos[index].imagen}">
<i class=" fas fa-trash-alt"></i></button>
            </div>`;
          }
        }
        d.getElementById("containerImages").innerHTML = $htmlImagen;
        d.getElementById("divBarCode").classList.remove("notBlock");
        d.getElementById("containerGallery").classList.remove("notBlock");
        $("#modalFormProducto").modal("show");
      } else {
        swal("Error", objData.msg, "error");
      }
    }
  };
}

function fntDeleteProducto(idProducto) {
  swal(
    {
      title: "Eliminar Producto",
      text: "¿Desea eliminar el producto?",
      type: "warning",
      showCancelButton: true,
      cancelButtonText: "Cancelar.",
      confirmButtonText: "Sí, eliminar.",
      closeOnConfirm: false,
      closeOnCancel: true,
    },
    function (isConfirm) {
      if (isConfirm) {
        let request = window.XMLHttpRequest
          ? new XMLHttpRequest()
          : new ActiveXObject("Microsoft.XMLHTTP");
        let ajaxUrl = base_url + "/Productos/delProducto";
        let strData = "idProducto=" + idProducto;
        request.open("POST", ajaxUrl, true);
        request.setRequestHeader(
          "Content-type",
          "application/x-www-form-urlencoded"
        );
        request.send(strData);
        request.onreadystatechange = function () {
          if (request.readyState == 4 && request.status == 200) {
            // console.log(request.responseText)
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
              swal("Eliminar Producto", objData.msg, "success");
              tableProductos.api().ajax.reload(function () {});
            } else {
              swal("Error", objData.msg, "error");
            }
          }
        };
      }
    }
  );
}

// Funcion para obtener las categorias
function fntCategorias() {
  if (d.getElementById("listaCategorias")) {
    let ajaxUrl = base_url + "/Categorias/getSelectCategorias";
    let request = window.XMLHttpRequest
      ? new XMLHttpRequest()
      : new ActiveXObject("Microsoft.XMLHTTP");

    request.open("GET", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        d.getElementById("listaCategorias").innerHTML = request.responseText;
        $("#listaCategorias").selectpicker("render");
      }
    };
  }
}

// Funcion para obtener los colores
function fntColores() {
  if (d.getElementById("listaColores")) {
    let ajaxUrl = base_url + "/Colores/getSelectColores";
    let request = window.XMLHttpRequest
      ? new XMLHttpRequest()
      : new ActiveXObject("Microsoft.XMLHTTP");

    request.open("GET", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        d.getElementById("listaColores").innerHTML = request.responseText;
        $("#listaColores").selectpicker("render");
      }
    };
  }
}

// Funcion para obtener los proveedores
function fntProveedores() {
  if (d.getElementById("listaProveedores")) {
    let ajaxUrl = base_url + "/Proveedores/getSelectProveedores";
    let request = window.XMLHttpRequest
      ? new XMLHttpRequest()
      : new ActiveXObject("Microsoft.XMLHTTP");

    request.open("GET", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        d.getElementById("listaProveedores").innerHTML = request.responseText;
        $("#listaProveedores").selectpicker("render");
      }
    };
  }
}

// Funcion para generar el codigo de barras
function fntBarCode() {
  let codigo = d.getElementById("txtCodigo").value;
  JsBarcode("#barcode", codigo);
}

// Funcion para imprimir el codigo de barras
function fntPrintBarCode(tamanio) {
  let $area = d.querySelector(tamanio);
  let cPrint = window.open(" ", "popimpr", "height=600, width=800");
  cPrint.document.write($area.innerHTML);
  cPrint.document.close();
  cPrint.print();
  cPrint.close();
}

//  funcion para abir el modal
function openModal() {
  $rowTable = "";
  d.getElementById("idProducto").value = "";
  d.querySelector(".modal-header").classList.replace(
    "headerUpdate",
    "headerRegistro"
  );
  d.getElementById("btnActionForm").classList.replace(
    "btn-info",
    "btn-primary"
  );
  d.getElementById("btnText").innerHTML = "Guardar";
  d.getElementById("titleModal").innerHTML = "Nuevo Producto";
  d.getElementById("formProductos").reset();
  d.getElementById("divBarCode").classList.add("notBlock");
  d.getElementById("containerGallery").classList.add("notBlock");
  d.getElementById("containerImages").innerHTML = "";
  $("#modalFormProducto").modal("show");
   

}




