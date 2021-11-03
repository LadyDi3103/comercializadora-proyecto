const inputs = document.querySelectorAll(".input"),
  d = document;

function agregarFocus() {
  let parent = this.parentNode.parentNode;
  parent.classList.add("focus");
}

function removerFocus() {
  let parent = this.parentNode.parentNode;
  if (this.value == "") {
    parent.classList.remove("focus");
  }
}

inputs.forEach((input) => {
  input.addEventListener("focus", agregarFocus);
  input.addEventListener("blur", removerFocus);
});

// capturar datos del formulario
var $loading = d.getElementById("loading");
d.addEventListener(
  "DOMContentLoaded",
  (e) => {
    if (d.getElementById("formLogin")) {
      let formLogin = d.getElementById("formLogin");

      formLogin.addEventListener("submit", (e) => {
        e.preventDefault();

        let strEmail = d.getElementById("txtEmail").value;
        let strPassword = d.getElementById("txtPassword").value;

        if (strEmail == "" || strPassword == "") {
          swal("Atención", "Todos los campos son obligatorios.", "error");
          return false;
        } else {
          $loading.style.display = "flex";
          // Proceso para enviar los datos al controlador
          var request = window.XMLHttpRequest
            ? new XMLHttpRequest()
            : new ActiveXObject("Microsoft.XMLHTTP");
          var ajaxUrl = base_url + "/Login/loginUsuario";
          var formData = new FormData(formLogin);
          request.open("POST", ajaxUrl, true);
          request.send(formData);
          request.onreadystatechange = function () {
            if (request.readyState != 4) return;
            if (request.status == 200) {
              var objData = JSON.parse(request.responseText);
              // validacion si el estado es true(login corecto)
              if (objData.status) {
                // window.location = base_url + "/dashboard";
                window.location.reload(false);
              } else {
                swal("Atención", objData.msg, "error");
                d.getElementById("txtPassword").value = "";
              }
            } else {
              swal("Atención", "Error en la petición", "error");
            }
            $loading.style.display = "none";

            return false;
            // console.log(request);
          };
        }
      });
    }
    if (d.getElementById("formResetPass")) {
      let formResetPass = d.getElementById("formResetPass");
      formResetPass.addEventListener("submit", (e) => {
        e.preventDefault();
        let strEmail = d.getElementById("txtEmailReset").value;
        // console.log(strEmail);
        if (strEmail == "") {
          swal("Por favor.", "Ingresa tu correo electrónico", "error");
          return false;
        } else {
          $loading.style.display = "flex";

          var request = window.XMLHttpRequest
            ? new XMLHttpRequest()
            : new ActiveXObject("Microsoft.XMLHTTP");
          var ajaxUrl = base_url + "/Login/resetPassword";
          var formData = new FormData(formResetPass);
          request.open("POST", ajaxUrl, true);
          request.send(formData);
          request.onreadystatechange = function () {
            if (request.readyState != 4) return;
            if (request.status == 200) {
              var objData = JSON.parse(request.responseText);
              if (objData.status) {
                swal(
                  {
                    title: "",
                    text: objData.msg,
                    type: "success",
                    confirmButtonText: "Aceptar.",
                    closeOnConfirm: false,
                  },
                  function (isConfirm) {
                    if (isConfirm) {
                      // redireccionar cuando muestre la alerta(puede redireccionar al login)
                      window.location = base_url;
                    }
                  }
                );
              } else {
                swal("Atención", objData.msg, "error");
              }
            } else {
              swal("Atención", "Error en el proceso", "error");
            }
            $loading.style.display = "none";

            return false;
          };
        }
      });
    }
    if (d.getElementById("formCambiarPass")) {
      let formCambiarPass = d.getElementById("formCambiarPass");
      formCambiarPass.addEventListener("submit", (e) => {
        e.preventDefault();
        let strPassword = d.getElementById("txtPassword").value;
        let strPasswordConfirmar = d.getElementById(
          "txtPasswordConfirmar"
        ).value;
        let idUsuario = d.getElementById("idUsuario").value;
        if (strPassword == "" || strPasswordConfirmar == "") {
          swal("Por favor", "Ingresa la nueva contraseña", "error");
          return false;
        } else {
          if (strPassword.length < 7) {
            swal(
              "Atención",
              "La contraseña debe tener mínimo 7 caracteres.",
              "info"
            );
            return false;
          }
          if (strPassword != strPasswordConfirmar) {
            swal("Atención", "Las contraseñas no coinciden.", "error");
            return false;
          }
          $loading.style.display = "flex";

          var request = window.XMLHttpRequest
            ? new XMLHttpRequest()
            : new ActiveXObject("Microsoft.XMLHTTP");
          var ajaxUrl = base_url + "/Login/setPassword";
          var formData = new FormData(formCambiarPass);
          request.open("POST", ajaxUrl, true);
          request.send(formData);
          request.onreadystatechange = function () {
            if (request.readyState != 4) return;
            if (request.status == 200) {
              // console.log(request.responseText);
              var objData = JSON.parse(request.responseText);
              if (objData.status) {
                swal(
                  {
                    title: "",
                    text: objData.msg,
                    type: "success",
                    confirmButtonText: "Iniciar Sesión",
                    closeOnConfirm: false,
                  },
                  function (isConfirm) {
                    if (isConfirm) {
                      window.location = base_url + "/Login";
                    }
                  }
                );
              } else {
                swal("Atención", objData.msg, "error");
              }
            } else {
              swal("Atención", "Error en el proceso", "error");
            }
            $loading.style.display = "none";

          };
        }
      });
    }
  },
  false
);
