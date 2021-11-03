// DATA TABLE
// $("#tableRoles").DataTable();

// ABRIR MODAL
const d = document,
  $modalForm = d.getElementById("modalFormRol"),
  $btnModal = d.querySelector(".btn-modal"),
  $btnCerrarModal = d.querySelector(".btnCerrarModal"),
  $loading = d.getElementById("loading");
 


// FIN ABRIR MODAL
// $btnModal.addEventListener("click", (e) => {
//   openModal();
// });

function openModal() {
  d.getElementById("idRol").value = "";
  d.querySelector(".modal-header").classList.replace(
    "headerUpdate",
    "headerRegistro"
  );
  d.getElementById("btnActionForm").classList.replace(
    "btn-info",
    "btn-primary"
  );
  d.getElementById("btnText").innerHTML = "Guardar";
  d.getElementById("titleModal").innerHTML = "Nuevo Rol";
  d.getElementById("formRoles").reset();

  $("#modalFormRol").modal("show");
}

// MOSTRAR ROLES
var tableRoles;
d.addEventListener("DOMContentLoaded", (e) => {
  tableRoles = $("#tableRoles").dataTable({
    aProcessing: true,
    aServerSide: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
    },
    ajax: {
      url: " " + base_url + "/Roles/getRoles",
      dataSrc: "",
    },
    columns: [
      { data: "id_rol" },
      { data: "nombre_rol" },
      { data: "descripcion_rol" },
      { data: "status_rol" },
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
    iDisplayLength: 5,
    order: [[0, "asc"]],
  });
  // Fin MOSTRAR ROLES

  // CAPTURAR DATOS DEL FORMUALRIO

  var $formRoles = d.getElementById("formRoles");

  $formRoles.addEventListener("submit", (e) => {
    e.preventDefault();
    var $intIdRol = d.getElementById("idRol").value;
    var $strNombreRol = d.getElementById("txtNombre").value;
    //  console.log($strNombreRol);
    var $strDescripcionRol = d.getElementById("txtDescripcion").value;
    //  console.log($strDescripcionRol);

    var $intStatusRol = d.getElementById("listaEstados").value;
    //  console.log($intStatusRol);

    if (
      $strNombreRol == "" ||
      $strDescripcionRol == "" ||
      $intStatusRol == ""
    ) {
      swal("Atención", "Todos los campos son obligatorios.", "error");
      return false;
    }
        $loading.style.display = "flex";

    // PETICION AJAX
    var request = window.XMLHttpRequest
      ? new XMLHttpRequest()
      : new ActiveXObject("Microsoft.XMLHTTP");
    var ajaxUrl = base_url + "/Roles/setRol/";
    // OBJETO
    var formData = new FormData($formRoles);
    request.open("POST", ajaxUrl, true);
    request.send(formData);
    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        // console.log(request.responseText)
        var objData = JSON.parse(request.responseText);
        if (objData.status) {
          $("#modalFormRol").modal("hide");
          $formRoles.reset();
          swal("Roles de usuario", objData.msg, "success");
          tableRoles.api().ajax.reload();
        } else {
          swal("Error", objData.msg, "error");
        }
      }
      $loading.style.display = "none";
      return false;
    };
  });
});

// Fin CAPTURAR DATOS DEL FORMUALRIO

$("#tableRoles").DataTable();

// FUNCION PARA AGREGAR EVENTOS A EDITAR ROL

window.addEventListener(
  "load",
  (e) => {
    // fntEditRol();
    // fntDeleteRol();
    // fntPermisos();
  },
  false
);

function fntEditRol(id_rol) {
  
  d.getElementById("titleModal").innerHTML = "Actualizar Rol";
  d.querySelector(".modal-header").classList.replace(
    "headerRegistro",
    "headerUpdate"
  );
  d.getElementById("btnActionForm").classList.replace(
    "btn-primary",
    "btn-info"
  );
  d.getElementById("btnText").innerHTML = "Actualizar";

  //  Peticion ajax para obtener los datos de la BD
  var idRol = id_rol;
  var request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  var ajaxUser = base_url + "/Roles/getRol/"+idRol;
  request.open("GET", ajaxUser, true);
  request.send();
  //  obtener la respuesta
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var objData = JSON.parse(request.responseText);
      // Validacion de datos del objeto
      // Si el estado de la respuesta es verdadero:
      if (objData.status) {
        d.getElementById("idRol").value = objData.data.id_rol;
        d.getElementById("txtNombre").value = objData.data.nombre_rol;
        d.getElementById("txtDescripcion").value = objData.data.descripcion_rol;
        if (objData.data.status_rol == 1) {
          d.getElementById("listaEstados").value = 1;
        } else {
          d.getElementById("listaEstados").value = 2;
        }

        $("#listaEstados").selectpicker("render");
        $("#modalFormRol").modal("show");
      } else {
        swal("Error", objData.msg, "error");
      }
    }
  };
}

// Funcion para eliminar un rol
function fntDeleteRol(idrol) {
  var idrol = idrol;
  swal(
    {
      title: "Eliminar Rol",
      text: "¿Desea eliminar el rol?",
      type: "warning",
      showCancelButton: true,
      cancelButtonText: "Cancelar.",
      confirmButtonText: "Sí, eliminar.",
      closeOnConfirm: false,
      closeOnCancel: true,
    },
    function (isConfirm) {
      if (isConfirm) {
        var request = window.XMLHttpRequest
          ? new XMLHttpRequest()
          : new ActiveXObject("Microsoft.XMLHTTP");
        var ajaxUrl = base_url + "/Roles/deleteRol/";
        var strData = "idRol="+idrol;
        request.open("POST", ajaxUrl, true);
        request.setRequestHeader(
          "Content-type",
          "application/x-www-form-urlencoded"
        );
        request.send(strData);
        request.onreadystatechange = function () {
          if (request.readyState == 4 && request.status == 200) {
            // console.log(request.responseText)
            var objData = JSON.parse(request.responseText);
            if (objData.status) {
              swal("Eliminar Rol", objData.msg, "success");
              tableRoles.api().ajax.reload(function () {
                // fntEditRol();
                // fntDeleteRol();
                // fntPermisos();
              });
            } else {
              swal("Error", objData.msg, "error");
            }
          }
        };
      }
    }
  );
}
// Funcion para otorgar permisos
function fntPermisos(idrol) {
  // Peticion GET para obtener los modulos
  var idrol = idrol;
  var request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  var ajaxUrl = base_url + "/Permisos/getPermisosRol/"+idrol;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      // console.log(request.responseText);
      d.getElementById("contentAjax").innerHTML = request.responseText;
      $(".modalPermisos").modal("show");
      d.getElementById("formPermisos").addEventListener(
        "submit",
        fntSavePermisos,
        false
      );
    }
  };
}

function fntSavePermisos(e) {
  e.preventDefault();
  var request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  var ajaxUrl = base_url + "/Permisos/setPermisosRol";
  var $form = d.getElementById("formPermisos");
  var $formData = new FormData($form);
  request.open("POST", ajaxUrl, true);
  request.send($formData);
  // validacion de la respuesta del controlador Permisos.php
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      // console.log(request.responseText);
      var objData = JSON.parse(request.responseText);

      if (objData.status) {
        swal("Permisos de usuario.", objData.msg, "success");
      } else {
        swal("Error", objData.msg, "error");
      }
    }
  };
}

// FIN FUNCION PARA AGREGAR EVENTOS
