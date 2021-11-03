let tableCategorias,
  $rowTable = "";

const d = document,
  $loading = d.getElementById("loading");

function openModal() {
  $rowTable = "";
  d.getElementById("idCategoria").value = "";
  d.querySelector(".modal-header").classList.replace(
    "headerUpdate",
    "headerRegistro"
  );
  d.getElementById("btnActionForm").classList.replace(
    "btn-info",
    "btn-primary"
  );
  d.getElementById("btnText").innerHTML = "Guardar";
  d.getElementById("titleModal").innerHTML = "Nueva Categoría";
  d.getElementById("formCategorias").reset();
  $("#modalFormCategoria").modal("show");
  removePhoto();
}

d.addEventListener(
  "DOMContentLoaded",
  function () {
    tableCategorias = $("#tableCategorias").dataTable({
      aProcessing: true,
      aServerSide: true,
      language: {
        url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
      },
      ajax: {
        url: " " + base_url + "/Categorias/getCategorias",
        dataSrc: "",
      },
      columns: [
        { data: "id_categoria" },
        { data: "nombre_categoria" },
        { data: "descripcion_categoria" },
        { data: "status_categoria" },
        { data: "opciones" },
      ],
      dom: "lBfrtip",
      buttons: [
        {
          extend: "copyHtml5",
          text: "<i class ='fas fa-copy separacion'></i>Copiar",
          titleAttr: "Copiar",
          className: "btn btn-secondary",
          exportOptions: {
            columns: [0, 1, 2, 3],
          },
        },
        {
          extend: "excelHtml5",
          text: "<i class ='far fa-file-excel separacion'></i>Excel",
          titleAttr: "Exportar a Excel",
          className: "btn btn-success",
          exportOptions: {
            columns: [0, 1, 2, 3],
          },
        },
        {
          extend: "pdfHtml5",
          text: "<i class ='far fa-file-pdf separacion'></i>PDF",
          titleAttr: "Exportar a PDF",
          className: "btn btn-danger",
          exportOptions: {
            columns: [0, 1, 2, 3],
          },
        },
        {
          extend: "csvHtml5",
          text: "<i class ='fas fa-file-csv separacion'></i>CSV",
          titleAttr: "Exportar a CSV",
          className: "btn btn-info",
          exportOptions: {
            columns: [0, 1, 2, 3],
          },
        },
      ],
      responsive: true,
      bDestroy: true,
      iDisplayLength: 10,
      order: [[0, "desc"]],
    });
    // funcion para cargar la imagen de categorias
    if (d.getElementById("foto")) {
      let foto = d.getElementById("foto");
      foto.onchange = function (e) {
        let uploadFoto = d.getElementById("foto").value;
        let fileimg = d.getElementById("foto").files;
        let nav = window.URL || window.webkitURL;
        let contactAlert = d.getElementById("form_alert");
        if (uploadFoto != "") {
          let type = fileimg[0].type;
          let name = fileimg[0].name;
          if (
            type != "image/jpeg" &&
            type != "image/jpg" &&
            type != "image/png"
          ) {
            contactAlert.innerHTML =
              '<p class="errorArchivo">El archivo no es válido.</p>';
            if (d.getElementById("img")) {
              d.getElementById("img").remove();
            }
            d.querySelector(".delPhoto").classList.add("notBlock");
            foto.value = "";
            return false;
          } else {
            contactAlert.innerHTML = "";
            if (d.getElementById("img")) {
              d.getElementById("img").remove();
            }
            d.querySelector(".delPhoto").classList.remove("notBlock");
            let objeto_url = nav.createObjectURL(this.files[0]);
            d.querySelector(".prevPhoto div").innerHTML =
              "<img id='img' src=" + objeto_url + ">";
          }
        } else {
          alert("No selecciono foto");
          if (d.getElementById("img")) {
            d.getElementById("img").remove();
          }
        }
      };
    }

    //   funcion para elimiminar foto de categoria
    if (d.querySelector(".delPhoto")) {
      let delPhoto = d.querySelector(".delPhoto");
      delPhoto.onclick = function (e) {
        d.getElementById("fotoDesactualizada").value = 1;
        removePhoto();
      };
    }

    //   envio de datos por medio de ajax, nueva categoria
    let $formCategorias = d.getElementById("formCategorias");

    $formCategorias.addEventListener("submit", (e) => {
      e.preventDefault();

      let $strNombreCategoria = d.getElementById("txtNombre").value;
      //  console.log($strNombreRol);
      let $strDescripcionCategoria = d.getElementById("txtDescripcion").value;
      //  console.log($strDescripcionRol);

      let $intStatusCategoria = d.getElementById("listaEstados").value;
      //  console.log($intStatusRol);

      if (
        $strNombreCategoria == "" ||
        $strDescripcionCategoria == "" ||
        $intStatusCategoria == ""
      ) {
        swal("Atención", "Todos los campos son obligatorios.", "error");
        return false;
      }
      $loading.style.display = "flex";

      // PETICION AJAX
      let request = window.XMLHttpRequest
        ? new XMLHttpRequest()
        : new ActiveXObject("Microsoft.XMLHTTP");
      let ajaxUrl = base_url + "/Categorias/setCategoria/";
      // OBJETO
      let formData = new FormData($formCategorias);
      request.open("POST", ajaxUrl, true);
      request.send(formData);
      request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
          // console.log(request.responseText)
          let objData = JSON.parse(request.responseText);
          if (objData.status) {

            if ($rowTable == "") {
            tableCategorias.api().ajax.reload();
            }else{
              $htmlStatus =
                $intStatusCategoria == 1
                  ? '<span class ="badge badge-success">Activo</span>'
                  : '<span class ="badge badge-danger">Inactivo</span>';
              $rowTable.cells[1].textContent = $strNombreCategoria;
              $rowTable.cells[2].textContent = $strNombreCategoria;
              $rowTable.cells[3].innerHTML = $htmlStatus;
              $rowTable = "";
            }
            $("#modalFormCategoria").modal("hide");
            $formCategorias.reset();
            swal("Categorías", objData.msg, "success");
            removePhoto();
          } else {
            swal("Error", objData.msg, "error");
          }
        }
        $loading.style.display = "none";
        return false;
      };
    });
  },
  false
);

// Funcion para ver informacion de la categoria
function fntViewCategoria(id_categoria) {
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl = base_url + "/Categorias/getCategoria/" + id_categoria;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);

      if (objData.status) {
        let status =
          objData.data.status_categoria == 1
            ? '<span class="badge badge-success">Activo</span>'
            : '<span class="badge badge-danger">Inactivo</span>';

        d.getElementById("celId").innerHTML = objData.data.id_categoria;
        d.getElementById("celNombre").innerHTML = objData.data.nombre_categoria;
        d.getElementById("celDescripcion").innerHTML =
          objData.data.descripcion_categoria;
        d.getElementById("celStatus").innerHTML = status;
        d.getElementById("celFoto").innerHTML =
          '<img src="' + objData.data.url_img + '"></img>';
        $("#modalVerCategorias").modal("show");
      } else {
        swal("Error", objData, "error");
      }
    }
  };
}
// Funcion para editar informacion de la categoria
function fntEditCategoria(e, id_categoria) {
  $rowTable = e.parentNode.parentNode.parentNode;
 
  d.getElementById("titleModal").innerHTML = "Actualizar Categoria";
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
  let ajaxUrl = base_url + "/Categorias/getCategoria/" + id_categoria;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);

      if (objData.status) {
        d.getElementById("idCategoria").value = objData.data.id_categoria;
        d.getElementById("txtNombre").value = objData.data.nombre_categoria;
        d.getElementById("txtDescripcion").value =
          objData.data.descripcion_categoria;
        d.getElementById("listaEstados").value =
          objData.data.descripcion_categoria;
        d.getElementById("fotoActualizada").value =
          objData.data.imagen_categoria;
        d.getElementById("fotoDesactualizada").value = 0;

        if (d.getElementById("img")) {
          d.getElementById("img").src = objData.data.url_img;
        } else {
          d.querySelector(".prevPhoto div").innerHTML =
            "<img id = 'img' src=" + objData.data.url_img + ">";
        }
        if (objData.data.imagen_categoria == "portada_categoria.png") {
          d.querySelector(".delPhoto").classList.add("notBlock");
        } else {
          d.querySelector(".delPhoto").classList.remove("notBlock");
        }
        if (objData.data.status_categoria == 1) {
          d.getElementById("listaEstados").value = 1;
        } else {
          d.getElementById("listaEstados").value = 2;
        }

        $("#listaEstados").selectpicker("render");
        $("#modalFormCategoria").modal("show");
      } else {
        swal("Error", objData, "error");
      }
    }
  };
}
// Funcion para eliminar informacion de la categoria

function fntDeleteCategoria(id_categoria) {
  swal(
    {
      title: "Eliminar Categoria",
      text: "¿Desea eliminar la cetegoria?",
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
        let ajaxUrl = base_url + "/Categorias/delCategoria/";
        let strData = "idCategoria=" + id_categoria;
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
              swal("Eliminar Categoria", objData.msg, "success");
              tableCategorias.api().ajax.reload(function () {});
            } else {
              swal("Error", objData.msg, "error");
            }
          }
        };
      }
    }
  );
}

// funcion para eliminar foto de la categoria
function removePhoto() {
  document.getElementById("foto").value = "";
  document.querySelector(".delPhoto").classList.add("notBlock");
  if (d.getElementById("img")) {
    document.getElementById("img").remove();
  }
}
