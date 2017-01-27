document.addEventListener('DOMContentLoaded', function() {
    setCorrectBodyClass();
}, false);

window.onresize = function(event) {
    setCorrectBodyClass();
};
function isDesk(){
	return window.innerWidth>window.innerHeight;
}
function setCorrectBodyClass(){
	if(isDesk()){
		document.body.className='desk';
	}else{
		document.body.className='phone';
	}
}