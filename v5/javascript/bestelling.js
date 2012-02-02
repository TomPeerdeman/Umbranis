function init(){
	var form1 = document.forms[0];
	form1.elements[0].focus();
	
	var zip1 = document.getElementById('zip1');
	zip1.onblur = function(){
		var reg = new RegExp('[0-9]{4}');
		if(!zip1.value.match(reg)){
			zip1.className = 'wrong';
		}else{
			zip1.className = 'correct';
		}
	};

	var zip2 = document.getElementById('zip2');
	zip2.onblur = function(){
		var reg = new RegExp('[a-zA-Z]{2}');
		if(!zip2.value.match(reg)){
			zip2.className = 'wrong';
		}else{
			zip2.className = 'correct';
			zip2.value = zip2.value.toUpperCase();
		}
	};

	var housenr = form1.elements['housenr'];
	housenr.onblur = function(){
		var reg = new RegExp('^[0-9]{1,}[a-zA-Z]{0,}$');
		if(!housenr.value.match(reg)){
			housenr.className = 'wrong';
		}else{
			housenr.className = 'correct';
		}
	};
	
	var email = form1.elements['email'];
	email.onblur = function(){
		var reg = new RegExp('^.+@.+\..+$');
		if(!email.value.match(reg)){
			email.className = 'wrong';
		}else{
			email.className = 'correct';
		}
	};
	
	isset(form1.elements['name']);
	isset(form1.elements['lastname']);
	isset(form1.elements['city']);
	isset(form1.elements['street']);
};

window.onload = init;

function isset(obj){	
	obj.onblur = function(){
		if(obj.value != ''){
			obj.className = 'correct';
		}else{
			obj.className = 'wrong';
		}
	}
}