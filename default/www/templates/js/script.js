// GO TO LINK WITH SPACE AND ANIMATION
$(document).on('click', 'a[href^="#"]', function (event) {
	event.preventDefault();

	$('html, body').animate({
		scrollTop: $($.attr(this, 'href')).offset().top - 50
	}, 500);
})
// SHRINK MENUS
window.onscroll = function() {scrollFunction()};
function scrollFunction(){
	if(document.body.scrollTop > 30 || document.documentElement.scrollTop > 30){
		document.getElementsByClassName("main_menu")[0].classList.add("shrunken");
	}else{
		document.getElementsByClassName("main_menu")[0].classList.remove("shrunken");
	}
}
// OPEN AND CLOSE DIVS
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
	