let tableClientes, $rowTable ="";

const d = document,
  $loading = d.getElementById("loading");

function openModal() {
  $rowTable = "";
  d.getElementById("idCliente").value = "";
  d.querySelector(".modal-header").classList.replace(
    "headerUpdate",
    "headerRegistro"
  );
  d.getElementById("btnActionForm").classList.replace(
    "btn-info",
    "btn-primary"
  );
  d.getElementById("btnText").innerHTML = "Guardar";
  d.getElementById("titleModal").innerHTML = "Nuevo Cliente";
  d.getElementById("formClientes").reset();

  $("#modalFormCliente").modal("show");
}

// ejecutar funciones a la carga del DOM
d.addEventListener(
  "DOMContentLoaded",
  function () {
    tableClientes = $("#tableClientes").dataTable({
      aProcessing: true,
      aServerSide: true,
      language: {
        url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
      },
      ajax: {
        url: " " + base_url + "/Clientes/getClientes",
        dataSrc: "",
      },
      columns: [
        { data: "id_persona" },
        { data: "identificacion_persona" },
        { data: "nombres" },
        { data: "apellidos" },
        { data: "telefono_persona" },
        { data: "email_persona" },
        { data: "rfc_persona" },
        { data: "direccion_fiscal" },
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
      order: [[0, "desc"]],
    });

    // Funcion para crear un cliente

    if (d.getElementById("formClientes")) {
      let $formClientes = d.getElementById("formClientes");
      $formClientes.addEventListener("submit", function (e) {
        e.preventDefault();
        let $strIdentificacion = d.getElementById("txtIdentificacion").value;
        let $strNombres = d.getElementById("txtNombresCliente").value;
        let $strApellidos = d.getElementById("txtApellidosCliente").value;
        let $intTelefono = d.getElementById("strTelefonoCliente").value;
        let $strEmail = d.getElementById("txtEmailCliente").value;
        let $strPassword = d.getElementById("txtPassCliente").value;
        let $strRfc = d.getElementById("txtRfc").value;
        let $strDireccionFiscal = d.getElementById("txtDireccionFiscal").value;

        // Validar campos vacios

        if (
          $strIdentificacion == "" ||
          $strNombres == "" ||
          $strApellidos == "" ||
          $intTelefono == "" ||
          $strEmail == "" ||
          $strRfc == "" ||
          $strDireccionFiscal == ""
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
        let ajaxUrl = base_url + "/Clientes/setCliente";
        let formData = new FormData($formClientes);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function () {
          if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
              if ($rowTable == "") {
                tableClientes.api().ajax.reload();
              } else {
                $rowTable.cells[1].textContent = $strIdentificacion;
                $rowTable.cells[2].textContent = $strNombres;
                $rowTable.cells[3].textContent = $strApellidos;
                $rowTable.cells[4].textContent = $intTelefono;
                $rowTable.cells[5].textContent = $strEmail;
                $rowTable.cells[6].textContent = $strRfc;
                $rowTable.cells[7].textContent = $strDireccionFiscal;
                $rowTable = "";
              }
              $("#modalFormCliente").modal("hide");
              $formClientes.reset();
              swal("Clientes", objData.msg, "success");
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

// Funcion para ver informacion del cliente
function fntViewCliente(id_persona) {
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl = base_url + "/Clientes/getCliente/" + id_persona;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);

      if (objData.status) {
        d.getElementById("celIdentificacion").innerHTML =
          objData.data.identificacion_persona;
        d.getElementById("celNombres").innerHTML = objData.data.nombres;
        d.getElementById("celApellidos").innerHTML = objData.data.apellidos;
        d.getElementById("celTelefono").innerHTML =
          objData.data.telefono_persona;
        d.getElementById("celEmail").innerHTML = objData.data.email_persona;
        d.getElementById("celRfc").innerHTML = objData.data.rfc_persona;
        d.getElementById("celDireccionFiscal").innerHTML =
          objData.data.direccion_fiscal;
        d.getElementById("celFechaRegistro").innerHTML =
          objData.data.fechaRegistro;
        $("#modalVerClientes").modal("show");
      } else {
        swal("Error", objData, "error");
      }
    }
  };
}

// Funcion para editar un cliente

function fntEditCliente(e, id_persona) {
  $rowTable = e.parentNode.parentNode.parentNode;
  // console.log($rowTable);
  
  d.getElementById("titleModal").innerHTML = "Actualizar Cliente";
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
  let ajaxUrl = base_url + "/Clientes/getCliente/"+id_persona;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);

      if (objData.status) {
        d.getElementById("idCliente").value = objData.data.id_persona;
        d.getElementById("txtIdentificacion").value = objData.data.identificacion_persona;
        d.getElementById("txtNombresCliente").value = objData.data.nombres;
        d.getElementById("txtApellidosCliente").value = objData.data.apellidos;
        d.getElementById("strTelefonoCliente").value = objData.data.telefono_persona;
        d.getElementById("txtEmailCliente").value = objData.data.email_persona;
        d.getElementById("txtRfc").value = objData.data.rfc_persona;
        d.getElementById("txtDireccionFiscal").value = objData.data.direccion_fiscal;

      }
    }
    $("#modalFormCliente").modal("show");
  };
}


// Funcion para eliminar un cliente
function fntDeleteCliente(id_persona) {
  swal(
    {
      title: "Eliminar Cliente",
      text: "¿Desea eliminar el cliente?",
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
        let ajaxUrl = base_url + "/Clientes/delCliente/";
        let strData = "idCliente=" + id_persona;
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
              swal("Eliminar Cliente", objData.msg, "success");
              tableClientes.api().ajax.reload(function () {
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


