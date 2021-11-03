let tablePedidos, $rowTable;

const d = document;

tablePedidos = $("#tablePedidos").dataTable({
  aProcessing: true,
  aServerSide: true,
  language: {
    url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
  },
  ajax: {
    url: " " + base_url + "/Pedidos/getPedidos",
    dataSrc: "",
  },
  columns: [
    { data: "id_pedido" },
    { data: "transaccion" },
    { data: "fecha" },
    { data: "nombre" },
    { data: "monto" },
    { data: "status_pedido" },
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
        columns: [0, 1, 2, 3, 4, 5],
      },
    },
    {
      extend: "excelHtml5",
      text: "<i class ='far fa-file-excel separacion'></i>Excel",
      titleAttr: "Exportar a Excel",
      className: "btn btn-success",
      exportOptions: {
        columns: [0, 1, 2, 3, 4, 5],
      },
    },
    {
      extend: "pdfHtml5",
      text: "<i class ='far fa-file-pdf separacion'></i>PDF",
      titleAttr: "Exportar a PDF",
      className: "btn btn-danger",
      exportOptions: {
        columns: [0, 1, 2, 3, 4, 5],
      },
    },
    {
      extend: "csvHtml5",
      text: "<i class ='fas fa-file-csv separacion'></i>CSV",
      titleAttr: "Exportar a CSV",
      className: "btn btn-info",
      exportOptions: {
        columns: [0, 1, 2, 3, 4, 5],
      },
    },
  ],
  responsive: true,
  bDestroy: true,
  iDisplayLength: 10,
  order: [[0, "desc"]],
});

var $loading = d.getElementById("loading");

// funcion para abrir modal del reembolso
function fntReembolso(transaccion) {
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");

  let ajaxUrl = base_url + "/Pedidos/getTp/" + transaccion;
  $loading.style.display = "flex";
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);
      if (objData.status) {
        d.getElementById("modalReembolso").innerHTML = objData.modalR;
        $("#modalFormReembolso").modal("show");
      } else {
        swal("Error", objData.msg, "error");
      }
      $loading.style.display = "none";
      return false;
    }
  };
}

// funcion para hacer el reembolso
function fntReembolsar() {
  let numTransaccion = d.getElementById("numTransaccion").value;
  let observaciones = d.getElementById("txtObservaciones").value;
  if (numTransaccion == "" || observaciones == "") {
    swal("", "Complete los datos para reembolsar.", "error");
    return false;
  }

  swal(
    {
      title: "Reembolso",
      text: "¿Realizar el reembolso?",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: "Si",
      cancelButtonText: "No",
      closeOnConfirm: true,
      closeOnCancel: true,
    },
    function (isConfirm) {
      if (isConfirm) {
        $("#modalFormReembolso").modal("hide");
        $loading.style.display = "flex";
        let request = window.XMLHttpRequest
          ? new XMLHttpRequest()
          : new ActiveXObject("Microsoft.XMLHTTP");
        let ajaxUrl = base_url + "/Pedidos/setReembolso";
        let formData = new FormData();
        formData.append("idTransaccion", numTransaccion);
        formData.append("observaciones", observaciones);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function () {
          if (request.readyState != 4) return;
          if (request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
              window.location.reload();
            } else {
              swal("Error", objData.msg, "error");
            }
            divLoading.style.display = "none";
            return false;
          }
        };
      }
    }
  );
}

// funcion para editar producto

function fntEditPedido(e, idPedido) {
  $rowTable = e.parentNode.parentNode.parentNode;
  console.log($rowTable);
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl = base_url + "/Pedidos/getPedido/" + idPedido;
  $loading.style.display = "flex";

  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState != 4) return;
    if (request.status == 200) {
      let objData = JSON.parse(request.responseText);
      if (objData.status) {
        d.getElementById("modalPedido").innerHTML = objData.modalPedido;
        $("#modalFormPedido").modal("show");
        $("select").selectpicker();
        fntActualizar();
      } else {
        swal("Error", objData.msg, "error");
      }
      $loading.style.display = "none";
      return false;
    }
  };
}

function fntActualizar() {
  let formularioPedido = d.getElementById("formPedido");
  formularioPedido.addEventListener("submit", (e) => {
    e.preventDefault();
    let numTransaccion;
    if (d.getElementById("txtTransaccionP")) {
      numTransaccion = d.getElementById("txtTransaccionP").value;
      if (numTransaccion == "") {
        swal("", "Los datos deben estar completos.", "error");
        return false;
      }
    }
    $loading.style.display = "flex";
    let request = window.XMLHttpRequest
      ? new XMLHttpRequest()
      : new ActiveXObject("Microsoft.XMLHTTP");
    let ajaxUrl = base_url + "/Pedidos/setPedido/";
    let formData = new FormData(formularioPedido);

    request.open("POST", ajaxUrl, true);
    request.send(formData);
    request.onreadystatechange = function () {
      if (request.readyState != 4) return;
      if (request.status == 200) {
        let objData = JSON.parse(request.responseText);
        if (objData.status) {
          swal("", objData.msg, "success");

          $("#modalFormPedido").modal("hide");
           if (d.getElementById("txtTransaccionP")) {
          $rowTable.cells[1].textContent = d.getElementById("txtTransaccionP").value;
          $rowTable.cells[3].textContent = d.getElementById("listaPagos").selectedOptions[0].innerText;
          $rowTable.cells[5].textContent = d.getElementById("listaEstado").value;
           }else{
          $rowTable.cells[5].textContent = d.getElementById("listaEstado").value;

           }
        } else {
          swal("Error", objData.msg, "error");
        }
        $loading.style.display = "none";
        return false;
      }
    };
  });
}
