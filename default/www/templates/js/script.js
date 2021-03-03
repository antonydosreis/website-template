// ENCOLHER MENUS
window.onscroll = function() {scrollFunction()};
function scrollFunction(){
	if(document.body.scrollTop > 30 || document.documentElement.scrollTop > 30){
		document.getElementsByClassName("menu_principal")[0].classList.add("encolhido");
		document.getElementsByClassName("menu_whatsapp")[0].classList.add("encolhido");
	}else{
		document.getElementsByClassName("menu_principal")[0].classList.remove("encolhido");
		document.getElementsByClassName("menu_whatsapp")[0].classList.remove("encolhido");
	}
}
// ABRIR E FECHAR DIVS
	function open_div(id){
		document.getElementById(id).style.display = "block";
		document.getElementById(id).classList.add("show");
		document.getElementById(id).classList.remove("hide");
		scrollPosition = window.pageYOffset;
		document.body.style.position = "fixed";
	}
	function close_div(id){
		document.getElementById(id).classList.remove("show");
		document.getElementById(id).classList.add("hide");
		setTimeout(function(){ document.getElementById(id).style.display = "none"; }, 450);
		document.body.style.position = "relative";
		window.scrollTo(0, scrollPosition);
	}
	