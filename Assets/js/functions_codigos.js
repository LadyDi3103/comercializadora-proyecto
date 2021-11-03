let tableCodigos,
  $rowTable = "";

const d = document,
  $loading = d.getElementById("loading");

function openModal() {
 
  $("#modalFormCodigos").modal("show");
}




var qrcode = new QRCode(document.getElementById("qrcode"), {
  width: 100,
  height: 100,
});
// Funcion para crear el codigo
function makeCode() {
  var elText = document.getElementById("text");

  qrcode.makeCode(elText.value);
}
// Al cargar crear el qr inicial
makeCode();
// Al pulsar teclar Enter, genera en QR
$("#text")
  .on("blur", function () {
    makeCode();
  })
  .on("keyup", function (e) {
    makeCode();
  });




d.addEventListener(
  "DOMContentLoaded",
  function () {
    tableCodigos = $("#tableCodigos").dataTable({
      aProcessing: true,
      aServerSide: true,
      language: {
        url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
      },
      ajax: {
        url: " " + base_url + "/Codigos/getCodigos",
        dataSrc: "",
      },
      columns: [
        { data: "id_codigo" },
        { data: "nombre_producto" },
        { data: "url" },
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
    let $formCodigo = d.getElementById("formCodigos");

    $formCodigo.addEventListener("submit", (e) => {
      e.preventDefault();

      let $url = d.getElementById("text").value;

      let $producto = d.getElementById("listaProductos").value;

      if ($url == "" || $producto== "") {
        swal("Atención", "Todos los campos son obligatorios.", "error");
        return false;
      }
      $loading.style.display = "flex";

      // PETICION AJAX
      let request = window.XMLHttpRequest
        ? new XMLHttpRequest()
        : new ActiveXObject("Microsoft.XMLHTTP");
      let ajaxUrl = base_url + "/Codigos/setCodigo/";
      // OBJETO
      let formData = new FormData($formCodigo);
      request.open("POST", ajaxUrl, true);
      request.send(formData);
      request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
          // console.log(request.responseText)
          let objData = JSON.parse(request.responseText);
          if (objData.status) {
           
             if ($rowTable == "") {
              tableCodigos.api().ajax.reload();
            } else {
             
              $rowTable.cells[1].textContent = $producto;
              $rowTable.cells[2].innerHTML = $url;
              $rowTable = "";
            }
            $("#modalFormCodigos").modal("hide");
            $formCodigo.reset();
            swal("Codigo", objData.msg, "success");
          } else {
            swal("Error", objData.msg, "error");
          }
        }
        $loading.style.display = "none";
        return false;
      };
    });

    fntCodigos();
  },
  false
);


// Funcion para obtener los codigos
function fntCodigos() {
  if (d.getElementById("listaProductos")) {
    let ajaxUrl = base_url + "/Productos/getSelectProductos";
    let request = window.XMLHttpRequest
      ? new XMLHttpRequest()
      : new ActiveXObject("Microsoft.XMLHTTP");

    request.open("GET", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
          
        d.getElementById("listaProductos").innerHTML = request.responseText;
        $("#listaProductos").selectpicker("render");
      }
    };
  }
}

// Funcion para ver elcodigo


function fntViewCodigo(id_codigo) { 
let request = window.XMLHttpRequest
  ? new XMLHttpRequest()
  : new ActiveXObject("Microsoft.XMLHTTP");
let ajaxUrl = base_url + "/Codigos/getCodigo/" + id_codigo;
request.open("GET", ajaxUrl, true);
request.send();
request.onreadystatechange = function () {
  if (request.readyState == 4 && request.status == 200) {
    let objData = JSON.parse(request.responseText);

    if (objData.status) {
      
    //   d.getElementById("celId").innerHTML = objData.data.id_codigo;
      d.getElementById("nombreProducto").value = objData.data.nombre_producto;
      d.getElementById("textv").value = objData.data.url;


      $("#modalVerCodigo").modal("show");
    } else {
      swal("Error", objData, "error");
    }
  }
};





 }


 
var qrcodev = new QRCode(document.getElementById("qrcodev"), {
  width: 100,
  height: 100,
});
// Funcion para crear el codigo
function makeCodev() {
  var elText = document.getElementById("textv");

  qrcodev.makeCode(elText.value);
}
// Al cargar crear el qr inicial
makeCodev();
// Al pulsar teclar Enter, genera en QR
$("#textv")
  .on("blur", function () {
    makeCodev();
  })
  .on("keyup", function (e) {
    makeCodev();
  });

  