let tableTallas,
  $rowTable = "";

const d = document,
  $loading = d.getElementById("loading");

function openModal() {
  $rowTable = "";
  d.getElementById("idTalla").value = "";
  d.querySelector(".modal-header").classList.replace(
    "headerUpdate",
    "headerRegistro"
  );
  d.getElementById("btnActionForm").classList.replace(
    "btn-info",
    "btn-primary"
  );
  d.getElementById("btnText").innerHTML = "Guardar";
  d.getElementById("titleModal").innerHTML = "Nueva Talla";
  d.getElementById("formTallas").reset();
  $("#modalFormTallas").modal("show");

}

d.addEventListener(
  "DOMContentLoaded",
  function () {
    tableTallas = $("#tableTallas").dataTable({
      aProcessing: true,
      aServerSide: true,
      language: {
        url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
      },
      ajax: {
        url: " " + base_url + "/Tallas/getTallas",
        dataSrc: "",
      },
      columns: [
        { data: "id_numeroTalla" },
        { data: "numero" },
        { data: "status_talla" },
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

    //   envio de datos por medio de ajax, nueva talla
    let $formTallas = d.getElementById("formTallas");

    $formTallas.addEventListener("submit", (e) => {
      e.preventDefault();

      let $intTalla = d.getElementById("intTalla").value;

      let $intStatusColor = d.getElementById("listaEstados").value;

      if ($intTalla == "" || $intStatusColor == "") {
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

      // PETICION AJAX
      let request = window.XMLHttpRequest
        ? new XMLHttpRequest()
        : new ActiveXObject("Microsoft.XMLHTTP");
      let ajaxUrl = base_url + "/Tallas/setTalla/";
      // OBJETO
      let formData = new FormData($formTallas);
      request.open("POST", ajaxUrl, true);
      request.send(formData);
      request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
          // console.log(request.responseText)
          let objData = JSON.parse(request.responseText);
          if (objData.status) {
            if ($rowTable == "") {
              tableTallas.api().ajax.reload();
            } else {
              $htmlStatus =
                $intStatusColor == 1
                  ? '<span class ="badge badge-success">Activo</span>'
                  : '<span class ="badge badge-danger">Inactivo</span>';
              $rowTable.cells[1].textContent = $intTalla;
              $rowTable.cells[2].innerHTML = $htmlStatus;
              $rowTable = "";
            }
            $("#modalFormTallas").modal("hide");
            $formTallas.reset();
            swal("Tallas", objData.msg, "success");
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


// Funcion para ver informacion de la talla
function fntViewTalla(id_numeroTalla) {
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl = base_url + "/Tallas/getTalla/" + id_numeroTalla;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);

      if (objData.status) {
 let estadoTalla =
          objData.data.status_talla == 1
            ? '<span class="badge badge-success">Activo</span>'
            : '<span class="badge badge-danger">inactivo</span>';
            d.getElementById("celId").innerHTML = objData.data.id_numeroTalla;
        d.getElementById("celTalla").innerHTML = objData.data.numero;
        d.getElementById("celStatus").innerHTML = estadoTalla;
        $("#modalVerTallas").modal("show");
      } else {
        swal("Error", objData, "error");
      }
    }
  };
}

function fntEditTalla(e, id_numeroTalla) {
  $rowTable = e.parentNode.parentNode.parentNode;
  // console.log($rowTable);

  d.getElementById("titleModal").innerHTML = "Actualizar Talla";
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
  let ajaxUrl = base_url + "/Tallas/getTalla/" + id_numeroTalla;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);

      if (objData.status) {
        d.getElementById("idTalla").value = objData.data.id_numeroTalla;

        d.getElementById("intTalla").value = objData.data.numero;

        if (objData.data.status_talla == 1) {
          d.getElementById("listaEstados").value = 1;
        } else {
          d.getElementById("listaEstados").value = 2;
        }

        $("#listaEstados").selectpicker("render");
      }
    }
    $("#modalFormTallas").modal("show");
  };
}

function fntDeleteTalla(id_numeroTalla) {
  swal(
    {
      title: "Eliminar Talla",
      text: "¿Desea eliminar la talla?",
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
        let ajaxUrl = base_url + "/Tallas/delTalla/";
        let strData = "idTalla=" + id_numeroTalla;
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
              swal("Eliminar Talla", objData.msg, "success");
              tableTallas.api().ajax.reload(function () {});
            } else {
              swal("Error", objData.msg, "error");
            }
          }
        };
      }
    }
  );
}

