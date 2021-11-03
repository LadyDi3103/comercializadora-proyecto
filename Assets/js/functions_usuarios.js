let tableUsuarios;

const d = document,
  $btnModal = d.querySelector(".btn-modal"),
  $loading = d.getElementById("loading");
let $rowTable = "";

// $btnModal.addEventListener("click", (e) => {
//   openModal();
// });

function openModal() {
  $rowTable = "";
  d.getElementById("idUsuario").value = "";
  d.querySelector(".modal-header").classList.replace(
    "headerUpdate",
    "headerRegistro"
  );
  d.getElementById("btnActionForm").classList.replace(
    "btn-info",
    "btn-primary"
  );
  d.getElementById("btnText").innerHTML = "Guardar";
  d.getElementById("titleModal").innerHTML = "Nuevo Usuario";
  d.getElementById("formUsuarios").reset();

  $("#modalFormUsuarios").modal("show");
}

// ejecutar funciones a la carga del DOM
d.addEventListener(
  "DOMContentLoaded",
  function () {
    // mostrar usuarios
    tableUsuarios = $("#tableUsuarios").dataTable({
      aProcessing: true,
      aServerSide: true,
      language: {
        url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
      },
      ajax: {
        url: " " + base_url + "/Usuarios/getUsuarios",
        dataSrc: "",
      },
      columns: [
        { data: "id_persona" },
        { data: "identificacion_persona" },
        { data: "nombres" },
        { data: "apellidos" },
        { data: "telefono_persona" },
        { data: "email_persona" },
        { data: "nombre_rol" },
        { data: "status_persona" },
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
            columns: [0, 1, 2, 3,4,5,6,7],
          },
        },
        {
          extend: "excelHtml5",
          text: "<i class ='far fa-file-excel separacion'></i>Excel",
          titleAttr: "Exportar a Excel",
          className: "btn btn-success",
          exportOptions: {
            columns: [0, 1, 2, 3,4,5,6,7],
          },
        },
        {
          extend: "pdfHtml5",
          text: "<i class ='far fa-file-pdf separacion'></i>PDF",
          titleAttr: "Exportar a PDF",
          className: "btn btn-danger",
          exportOptions: {
            columns: [0, 1, 2, 3,4,5,6,7],
          },
        },
        {
          extend: "csvHtml5",
          text: "<i class ='fas fa-file-csv separacion'></i>CSV",
          titleAttr: "Exportar a CSV",
          className: "btn btn-info",
          exportOptions: {
            columns: [0, 1, 2, 3,4,5,6,7],
          },
        },
      ],
      responsive: true,
      bDestroy: true,
      iDisplayLength: 10,
      order: [[0, "asc"]],
    });

    // funcion para crear usuarios

    if (d.getElementById("formUsuarios")) {
      let $formUsuarios = d.getElementById("formUsuarios");
      $formUsuarios.addEventListener("submit", function (e) {
        e.preventDefault();
        let $strIdentificacion = d.getElementById("txtIdentificacion").value;
        let $strNombres = d.getElementById("txtNombresUsuario").value;
        let $strApellidos = d.getElementById("txtApellidosUsuario").value;
        let $intTelefono = d.getElementById("strTelefonoUsuario").value;
        let $strEmail = d.getElementById("txtEmailUsuario").value;

        let $intRol = d.getElementById("listaRoles").value;
        let $intStatus = d.getElementById("listaEstados").value;
        let $strPassword = d.getElementById("txtPassUsuario").value;

        // Validar campos vacios

        if (
          $strIdentificacion == "" ||
          $strNombres == "" ||
          $strApellidos == "" ||
          $intTelefono == "" ||
          $strEmail == "" ||
          $intRol == "" ||
          $intStatus == ""
        ) {
          swal("Atención", "Todos los campos son obligatorios.", "error");
          return false;
        }
        let elementosValidos = d.getElementsByClassName("valid");
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
        let ajaxUrl = base_url + "/Usuarios/setUsuario";
        let formData = new FormData($formUsuarios);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function () {
          if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
              if ($rowTable == "") {
                tableUsuarios.api().ajax.reload();
              } else {
                $htmlStatus = $intStatus == 1 ?
                '<span class ="badge badge-success">Activo</span>' :
                '<span class ="badge badge-danger">Inactivo</span>' ;

                $rowTable.cells[2].textContent = $strNombres;
                $rowTable.cells[3].textContent = $strApellidos;
                $rowTable.cells[4].textContent = $intTelefono;
                $rowTable.cells[5].textContent = $strEmail;
                $rowTable.cells[6].textContent = d.getElementById("listaRoles").selectedOptions[0].text;
                $rowTable.cells[7].innerHTML =  $htmlStatus;
                rowTable = "";

              }
              $("#modalFormUsuarios").modal("hide");
              $formUsuarios.reset();
              swal("Usuarios", objData.msg, "success");
            } else {
              swal("Error", objData.msg, "error");
            }
          }
          $loading.style.display = "none";
          return false;
        };
      });
    }

    // funcion para actualizar perfil
    if (d.getElementById("formPerfilUsuario")) {
      let $formPerfil = d.getElementById("formPerfilUsuario");
      $formPerfil.addEventListener("submit", function (e) {
        e.preventDefault();

        let $strNombres = d.getElementById("txtNombresUsuario").value;
        let $strApellidos = d.getElementById("txtApellidosUsuario").value;
        let $intTelefono = d.getElementById("strTelefonoUsuario").value;
        let $strPassword = d.getElementById("txtPassUsuario").value;
        let $strPasswordConfirm = d.getElementById(
          "txtPassUsuarioConfirm"
        ).value;

        // Validar campos vacios

        if ($strNombres == "" || $strApellidos == "" || $intTelefono == "") {
          swal("Atención", "Todos los campos son obligatorios.", "error");
          return false;
        }
        // validar contraseñas del perfil
        if ($strPassword != "" || $strPasswordConfirm != "") {
          if ($strPassword != $strPasswordConfirm) {
            swal("Atención", "Las contraseñas no coinciden.", "error");
            return false;
          }
          if ($strPassword.length < 7) {
            swal(
              "Atención",
              "La contraseña debe tener mínimo 7 caracteres.",
              "info"
            );
            return false;
          }
        }

        // validar campos
        let elementosValidos = d.getElementsByClassName("valid");
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
        let ajaxUrl = base_url + "/Usuarios/updateUsuario";
        let formData = new FormData($formPerfil);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function () {
          if (request.readyState != 4) return;
          if (request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
              $("#modalFormPerfilUsuario").modal("hide");
              swal(
                {
                  title: "",
                  text: objData.msg,
                  type: "success",
                  confirmButtonText: "Aceptar",
                  closeOnConfirm: false,
                },
                function (isConfirm) {
                  if (isConfirm) {
                    location.reload();
                  }
                }
              );
            } else {
              swal("Error", objData.msg, "error");
            }
          }
          $loading.style.display = "none";
          return false;
        };
      });
    }

    // funcion para actualizar informacion fiscal
    if (d.getElementById("formDatosFiscales")) {
      let $formDatosFiscales = d.getElementById("formDatosFiscales");
      $formDatosFiscales.addEventListener("submit", function (e) {
        e.preventDefault();

        let $strRfc = d.getElementById("txtRfc").value;
        let $strDireccionFiscal = d.getElementById("txtDireccionFiscal").value;

        // Validar campos vacios

        if ($strRfc == "" || $strDireccionFiscal == "") {
          swal("Atención", "Todos los campos son obligatorios.", "error");
          return false;
        }
        $loading.style.display = "flex";

        let request = window.XMLHttpRequest
          ? new XMLHttpRequest()
          : new ActiveXObject("Microsoft.XMLHTTP");
        let ajaxUrl = base_url + "/Usuarios/setDatosFiscales";
        let formData = new FormData($formDatosFiscales);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function () {
          if (request.readyState != 4) return;
          if (request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
              swal(
                {
                  title: "",
                  text: objData.msg,
                  type: "success",
                  confirmButtonText: "Aceptar",
                  closeOnConfirm: false,
                },
                function (isConfirm) {
                  if (isConfirm) {
                    location.reload();
                  }
                }
              );
            } else {
              swal("Error", objData.msg, "error");
            }
          }
          $loading.style.display = "none";
          return false;
        };
      });
    }
  },
  false
);

window.addEventListener(
  "load",
  function () {
    fntRolesUsuario();
  },
  false
);

// Funcion para obetner los usuarios por medio de ajax

function fntRolesUsuario() {
  if (d.getElementById("listaRoles")) {
    let ajaxURl = base_url + "/Roles/getSelectRoles";
    let request = window.XMLHttpRequest
      ? new XMLHttpRequest()
      : new ActiveXObject("Microsoft.XMLHTTP");
    request.open("GET", ajaxURl, true);
    request.send();
    // Obtener los resultados del ajax

    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        d.getElementById("listaRoles").innerHTML = request.responseText;
        // d.getElementById("listaRoles").value = 21;
        $("#listaRoles").selectpicker("render");
      }
    };
  }
}

// Funcion para ver informacion del usuario
function fntViewUsuario(id_persona) {
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl = base_url + "/Usuarios/getUsuario/" + id_persona;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);

      if (objData.status) {
        let estadoUsuario =
          objData.data.status_persona == 1
            ? '<span class="badge badge-success">Activo</span>'
            : '<span class="badge badge-danger">inactivo</span>';

        d.getElementById("celIdentificacion").innerHTML =
          objData.data.identificacion_persona;
        d.getElementById("celNombres").innerHTML = objData.data.nombres;
        d.getElementById("celApellidos").innerHTML = objData.data.apellidos;
        d.getElementById("celTelefono").innerHTML =
          objData.data.telefono_persona;
        d.getElementById("celEmail").innerHTML = objData.data.email_persona;
        d.getElementById("celTipoUsuario").innerHTML = objData.data.nombre_rol;
        d.getElementById("celEstado").innerHTML = estadoUsuario;
        d.getElementById("celFechaRegistro").innerHTML =
          objData.data.fechaRegistro;
        $("#modalVerUsuario").modal("show");
      } else {
        swal("Error", objData, "error");
      }
    }
  };
}
// Funcion para editar un usuario

function fntEditUsuario(e, id_persona) {
  $rowTable = e.parentNode.parentNode.parentNode;
  // console.log($rowTable);
  d.getElementById("titleModal").innerHTML = "Actualizar Usuario";
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
  let ajaxUrl = base_url + "/Usuarios/getUsuario/"+id_persona;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);

      if (objData.status) {
        d.getElementById("idUsuario").value = objData.data.id_persona;
        d.getElementById("txtIdentificacion").value =
          objData.data.identificacion_persona;
        d.getElementById("txtNombresUsuario").value = objData.data.nombres;
        d.getElementById("txtApellidosUsuario").value = objData.data.apellidos;
        d.getElementById("strTelefonoUsuario").value =
          objData.data.telefono_persona;
        d.getElementById("txtEmailUsuario").value = objData.data.email_persona;

        d.getElementById("listaRoles").value = objData.data.id_rol;
        $("#listaRoles").selectpicker("render");

        if (objData.data.status_persona == 1) {
          d.getElementById("listaEstados").value = 1;
        } else {
          d.getElementById("listaEstados").value = 2;
        }

        $("#listaEstados").selectpicker("render");
      }
    }
    $("#modalFormUsuarios").modal("show");
  };
}

// Funcion para eliminar un usuario
function fntDeleteUsuario(id_persona) {
  swal(
    {
      title: "Eliminar Usuario",
      text: "¿Desea eliminar el usuario?",
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
        let ajaxUrl = base_url + "/Usuarios/delUsuario/";
        let strData = "idUsuario=" + id_persona;
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
              swal("Eliminar Usuario", objData.msg, "success");
              tableUsuarios.api().ajax.reload(function () {
                // fntRolesUsuario();
                // fntViewUsuario();
                // fntEditUsuario();
                // fntDeleteUsuario();
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

// Funciones para el perfil de usuario

function openModalPerfil() {
  $("#modalFormPerfilUsuario").modal("show");
}

