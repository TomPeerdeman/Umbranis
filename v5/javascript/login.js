window.onload = init;

function init(){
	if(document.forms.length > 0){
		var form1 = document.forms[0];
		form1.elements[0].focus();
	}
}