// Menu

((d)=>{

 const $btnMenu = d.querySelector(".menu-boton"),
   $menu = d.querySelector(".menu-principal");

 $btnMenu.addEventListener("click", e =>{
   $btnMenu.firstElementChild.classList.toggle("none");
   $btnMenu.lastElementChild.classList.toggle("none");
   
$menu.classList.toggle("is-active");


 });

 d.addEventListener("click", e=>{

if (!e.target.matches(".menu-principal a")) {
  return false;
}
 $btnMenu.firstElementChild.classList.remove("none");
 $btnMenu.lastElementChild.classList.add("none");

 $menu.classList.remove("is-active");



 })

})(document);

// iconos menu

((d)=>{


var pushbar = new Pushbar ({

blur: true,
overlay: true

})

})(document)





// function galeria(itemSmal){
//   let itemFull = document.getElementById("imagenBox");

//   itemFull.src=itemSmal.src;
// }



