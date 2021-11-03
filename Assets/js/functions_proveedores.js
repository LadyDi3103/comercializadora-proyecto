let tableProveedores,
  $rowTable = "";

const d = document,
  $loading = d.getElementById("loading");

function openModal() {
  $rowTable = "";
  d.getElementById("idProveedor").value = "";
  d.querySelector(".modal-header").classList.replace(
    "headerUpdate",
    "headerRegistro"
  );
  d.getElementById("btnActionForm").classList.replace(
    "btn-info",
    "btn-primary"
  );
  d.getElementById("btnText").innerHTML = "Guardar";
  d.getElementById("titleModal").innerHTML = "Nuevo Proveedor";
  d.getElementById("formProveedores").reset();

  $("#modalFormProveedor").modal("show");
}

d.addEventListener(
  "DOMContentLoaded",
  function () {
   tableProveedores = $("#tableProveedores").dataTable({
     aProcessing: true,
     aServerSide: true,
     language: {
       url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
     },
     ajax: {
       url: " " + base_url + "/Proveedores/getProveedores",
       dataSrc: "",
     },
     columns: [
       { data: "id_proveedor" },
       { data: "nombre_proveedor" },  
       { data: "telefono_proveedor" },
       { data: "email_proveedor" },
       { data: "status_proveedor" },
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

    // Funcion para crear un cliente
    if (d.getElementById("formProveedores")) {
      let $formProveedores = d.getElementById("formProveedores");
      $formProveedores.addEventListener("submit", function (e) {
        e.preventDefault();

        let $strNombre = d.getElementById("txtNombreProveedor").value;
        let $intTelefono = d.getElementById("strTelefonoProveedor").value;
        let $strEmail = d.getElementById("txtEmailProveedor").value;
    var $intStatusProveedor = d.getElementById("listaEstados").value;

       

        // Validar campos vacios

        if (
          $strNombre == "" ||
          $intTelefono == "" ||
          $strEmail == "" ||
          $intStatusProveedor == ""
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
        let ajaxUrl = base_url + "/Proveedores/setProveedor";
        let formData = new FormData($formProveedores);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function () {
          if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
              if ($rowTable == "") {
                tableProveedores.api().ajax.reload();
              } else {
                $htmlStatus =
                  $intStatusProveedor == 1
                    ? '<span class ="badge badge-success">Activo</span>'
                    : '<span class ="badge badge-danger">Inactivo</span>';
                $rowTable.cells[1].textContent = $strNombre;
                $rowTable.cells[2].textContent = $intTelefono;
                $rowTable.cells[3].textContent = $strEmail;
                $rowTable.cells[4].innerHTML = $htmlStatus;
                 

                $rowTable = "";
              }
              $("#modalFormProveedor").modal("hide");
              $formProveedores.reset();
              swal("Proveedores", objData.msg, "success");
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


// Funcion para ver informacion del proveedor
function fntViewProveedor(id_proveedor) {
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl = base_url + "/Proveedores/getProveedor/" + id_proveedor;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);

      if (objData.status) {
 let estadoProveedor =
          objData.data.status_proveedor == 1
            ? '<span class="badge badge-success">Activo</span>'
            : '<span class="badge badge-danger">inactivo</span>';
        d.getElementById("celNombre").innerHTML = objData.data.nombre_proveedor;
    
        d.getElementById("celTelefono").innerHTML =
          objData.data.telefono_proveedor;
        d.getElementById("celEmail").innerHTML = objData.data.email_proveedor;
        d.getElementById("celStatus").innerHTML = estadoProveedor;
    
        d.getElementById("celFechaRegistro").innerHTML =
          objData.data.fechaRegistro;
        $("#modalVerProveedores").modal("show");
      } else {
        swal("Error", objData, "error");
      }
    }
  };
}

// Funcion para editar un proveedor

function fntEditProveedor(e, id_proveedor) {
  $rowTable = e.parentNode.parentNode.parentNode;
  // console.log($rowTable);
  
  d.getElementById("titleModal").innerHTML = "Actualizar Proveedor";
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
  let ajaxUrl = base_url + "/Proveedores/getProveedor/"+id_proveedor;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);

      if (objData.status) {
        d.getElementById("idProveedor").value = objData.data.id_proveedor;
       
        d.getElementById("txtNombreProveedor").value = objData.data.nombre_proveedor;
       
        d.getElementById("strTelefonoProveedor").value = objData.data.telefono_proveedor;
        d.getElementById("txtEmailProveedor").value = objData.data.email_proveedor;
        
        if (objData.data.status_proveedor == 1) {
          d.getElementById("listaEstados").value = 1;
        } else {
          d.getElementById("listaEstados").value = 2;
        }

        $("#listaEstados").selectpicker("render");
      }
    }
    $("#modalFormProveedor").modal("show");
  };
}

// Funcion para eliminar un proveedor
function fntDeleteProveedor(id_proveedor) {
  swal(
    {
      title: "Eliminar Proveedor",
      text: "¿Desea eliminar el proveedor?",
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
        let ajaxUrl = base_url + "/Proveedores/delProveedor/";
        let strData = "idProveedor=" + id_proveedor;
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
              swal("Eliminar Proveedor", objData.msg, "success");
              tableProveedores.api().ajax.reload(function () {
               
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