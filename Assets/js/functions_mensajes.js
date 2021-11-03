let tableMensajes;
 

const d = document;


    tableMensajes = $("#tableMensajes").dataTable({
      aProcessing: true,
      aServerSide: true,
      language: {
        url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
      },
      ajax: {
        url: " " + base_url + "/Mensajes/getMensajes",
        dataSrc: "",
      },
      columns: [
        { data: "id_contacto" },
        { data: "nombre_contacto" },
        { data: "email_contacto" },
        { data: "fecha" },
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
function fntViewMensaje(id_contacto) {
  

  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl = base_url + "/Mensajes/getMensaje/" + id_contacto;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);
      if (objData.status) {   
        let objMensaje = objData.data
        d.getElementById("celId").innerHTML = objMensaje.id_contacto;
        d.getElementById("celNombre").innerHTML = objMensaje.nombre_contacto;
        d.getElementById("celEmail").innerHTML = objMensaje.email_contacto;
        d.getElementById("celMensaje").innerHTML = objMensaje.mensaje_contacto;
        d.getElementById("celFecha").innerHTML = objMensaje.fecha;
        $("#modalVerMensaje").modal("show");
      } else {
        swal("Error", objData.msg, "error");
      }
    }
  };
}