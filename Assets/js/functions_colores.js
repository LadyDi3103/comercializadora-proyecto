let tableColores,
  $rowTable = "";

const d = document,
  $loading = d.getElementById("loading");

function openModal() {
  $rowTable = "";
  d.getElementById("idColor").value = "";
  d.querySelector(".modal-header").classList.replace(
    "headerUpdate",
    "headerRegistro"
  );
  d.getElementById("btnActionForm").classList.replace(
    "btn-info",
    "btn-primary"
  );
  d.getElementById("btnText").innerHTML = "Guardar";
  d.getElementById("titleModal").innerHTML = "Nuevo Color";
  d.getElementById("formColores").reset();
  $("#modalFormColores").modal("show");
}
d.addEventListener(
  "DOMContentLoaded",
  function () {
    tableColores = $("#tableColores").dataTable({
      aProcessing: true,
      aServerSide: true,
      language: {
        url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
      },
      ajax: {
        url: " " + base_url + "/Colores/getColores",
        dataSrc: "",
      },
      columns: [
        { data: "id_color" },
        { data: "nombre_color" },
        { data: "status_color" },
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
            columns: [0, 1, 2],
          },
        },
        {
          extend: "excelHtml5",
          text: "<i class ='far fa-file-excel separacion'></i>Excel",
          titleAttr: "Exportar a Excel",
          className: "btn btn-success",
          exportOptions: {
            columns: [0, 1, 2],
          },
        },
        {
          extend: "pdfHtml5",
          text: "<i class ='far fa-file-pdf separacion'></i>PDF",
          titleAttr: "Exportar a PDF",
          className: "btn btn-danger",
          exportOptions: {
            columns: [0, 1, 2],
          },
        },
        {
          extend: "csvHtml5",
          text: "<i class ='fas fa-file-csv separacion'></i>CSV",
          titleAttr: "Exportar a CSV",
          className: "btn btn-info",
          exportOptions: {
            columns: [0, 1, 2],
          },
        },
      ],
      responsive: true,
      bDestroy: true,
      iDisplayLength: 10,
      order: [[0, "desc"]],
    });

    //   envio de datos por medio de ajax, nueva categoria
    let $formColores = d.getElementById("formColores");

    $formColores.addEventListener("submit", (e) => {
      e.preventDefault();

      let $strNombreColor = d.getElementById("txtNombre").value;

      let $intStatusColor = d.getElementById("listaEstados").value;

      if ($strNombreColor == "" || $intStatusColor == "") {
        swal("Atención", "Todos los campos son obligatorios.", "error");
        return false;
      }
      $loading.style.display = "flex";

      // PETICION AJAX
      let request = window.XMLHttpRequest
        ? new XMLHttpRequest()
        : new ActiveXObject("Microsoft.XMLHTTP");
      let ajaxUrl = base_url + "/Colores/setColor/";
      // OBJETO
      let formData = new FormData($formColores);
      request.open("POST", ajaxUrl, true);
      request.send(formData);
      request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
          // console.log(request.responseText)
          let objData = JSON.parse(request.responseText);
          if (objData.status) {
            if ($rowTable == "") {
              tableColores.api().ajax.reload();
            } else {
              $htmlStatus =
                $intStatusColor == 1
                  ? '<span class ="badge badge-success">Activo</span>'
                  : '<span class ="badge badge-danger">Inactivo</span>';
              $rowTable.cells[1].textContent = $strNombreColor;
              $rowTable.cells[2].innerHTML = $htmlStatus;
              $rowTable = "";
            }
            $("#modalFormColores").modal("hide");
            $formColores.reset();
            swal("Colores", objData.msg, "success");
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

// Funcion para ver informacion del color
function fntViewColor(id_color) {
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl = base_url + "/Colores/getColor/" + id_color;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);

      if (objData.status) {
        let estadoColor =
          objData.data.status_color == 1
            ? '<span class="badge badge-success">Activo</span>'
            : '<span class="badge badge-danger">inactivo</span>';
        d.getElementById("celId").innerHTML = objData.data.id_color;
        d.getElementById("celNombre").innerHTML = objData.data.nombre_color;
        d.getElementById("celStatus").innerHTML = estadoColor;
        $("#modalVerColores").modal("show");
      } else {
        swal("Error", objData, "error");
      }
    }
  };
}

function fntEditColor(e, id_color) {
  $rowTable = e.parentNode.parentNode.parentNode;
  // console.log($rowTable);

  d.getElementById("titleModal").innerHTML = "Actualizar Color";
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
  let ajaxUrl = base_url + "/Colores/getColor/" + id_color;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);

      if (objData.status) {
        d.getElementById("idColor").value = objData.data.id_color;

        d.getElementById("txtNombre").value = objData.data.nombre_color;

        if (objData.data.status_color == 1) {
          d.getElementById("listaEstados").value = 1;
        } else {
          d.getElementById("listaEstados").value = 2;
        }

        $("#listaEstados").selectpicker("render");
      }
    }
    $("#modalFormColores").modal("show");
  };
}

function fntDeleteColor(id_color) {
  swal(
    {
      title: "Eliminar Color",
      text: "¿Desea eliminar el color?",
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
        let ajaxUrl = base_url + "/Colores/delColor/";
        let strData = "idColor=" + id_color;
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
              swal("Eliminar Color", objData.msg, "success");
              tableColores.api().ajax.reload(function () {});
            } else {
              swal("Error", objData.msg, "error");
            }
          }
        };
      }
    }
  );
}
