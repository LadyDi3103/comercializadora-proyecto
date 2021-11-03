// FUNCIONES GENERALES

// Funcion para bloquear teclas

function controlTag(e) {
  tecla = document.all ? e.keyCode : e.which;
  //   keyCode 8 = borrar
  if (tecla == 8) return true;
  // keyCode 9 tabulador
  else if (tecla == 0 || tecla == 9) return true;

  //   exp: permite numeros del 0-9
  patron = /[0-9\s]/;
  //   verificar el patron
  n = String.fromCharCode(tecla);
  return patron.test(n);
}

// Funcion para validar nombres y apellidos
function testText(txtString) {
  var stringText = new RegExp(/^[a-zA-zÑñÁáÉéÍíÓóÚúÜü\s]+$/);
  if (stringText.test(txtString)) {
    return true;
  } else {
    return false;
  }
}

function testEntero(intCant) {
  var intCantidad = new RegExp(/^([0-9])*$/);

  if (intCantidad.test(intCant)) {
    return true;
  } else {
    return false;
  }
}

function fntEmailValidate(email) {
  var stringEmail = new RegExp(
    /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})$/
  );
  if (stringEmail.test(email) == false) {
    return false;
  } else {
    return true;
  }
}

// asignacion de eventos

function fntValidText() {
  let validText = document.querySelectorAll(".validTexto");
  validText.forEach(function (validText) {
    validText.addEventListener("keyup", function () {
      let inputValue = this.value;
      // console.log(inputValue);
      if (!testText(inputValue)) {
        this.classList.add("is-invalid");
      } else {
        this.classList.remove("is-invalid");
      }
    });
  });
}
function fntValidNumber() {
  let validNumber = document.querySelectorAll(".validNumero");
  validNumber.forEach(function (validNumber) {
    validNumber.addEventListener("keyup", function () {
      let inputValue = this.value;
      // console.log(inputValue);

      if (!testEntero(inputValue)) {
        this.classList.add("is-invalid");
      } else {
        this.classList.remove("is-invalid");
      }
    });
  });
}
function fntValidEmail() {
  let validEmail = document.querySelectorAll(".validEmail");
  validEmail.forEach(function (validEmail) {
    validEmail.addEventListener("keyup", function () {
      let inputValue = this.value;
      // console.log(inputValue);

      if (!fntEmailValidate(inputValue)) {
        this.classList.add("is-invalid");
      } else {
        this.classList.remove("is-invalid");
      }
    });
  });
}

window.addEventListener(
  "load",
  function () {
    fntValidText();
    fntValidNumber();
    fntValidEmail();
  },
  false
);
