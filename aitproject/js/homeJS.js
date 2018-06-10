var counter = 0;
function aboutFunction() {
	if(counter==0) {
		document.getElementsByClassName('back')[0].style.opacity = "0.5";
		document.getElementById('about').style.display = "block";
		counter++;
	}
	else if(counter==1) {
		document.getElementsByClassName('back')[0].style.opacity = "1";
		document.getElementById('about').style.display = "none";
		counter--;
	}
}