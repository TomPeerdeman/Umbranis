window.onload = function(){
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

	var phone1 = form1.elements['phone1'];
	phone1.onblur = function(){
		var reg = new RegExp('^[0-9]{2,4}-?[0-9]{6,8}$');
		if(!phone1.value.match(reg)){
			phone1.className = 'wrong';
		}else{
			phone1.className = 'correct';
		}
	};

	var phone2 = form1.elements['phone2'];
	phone2.onblur = function(){
		var reg = new RegExp('^[0-9]{2,4}-?[0-9]{6,8}$');
		if((!phone2.value.match(reg) && phone2.value != '') || phone2.value == phone1.value){
			phone2.className = 'wrong';
		}else{
			phone2.className = 'correct';
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
	isset(form1.elements['pass1']);
	isset(form1.elements['captcha']);
	
	var pass2 = form1.elements['pass2'];
	pass2.onblur = function(){
		if(pass2.value == '' || pass2.value != form1.elements['pass1'].value){
			pass2.className = 'wrong';
		}else{
			pass2.className = 'correct';
		}
	};
};

function isset(obj){	
	obj.onblur = function(){
		if(obj.value != ''){
			obj.className = 'correct';
		}else{
			obj.className = 'wrong';
		}
	}
}

function checkStrength(pwd){
	var text = document.getElementById('text');
	var id = document.getElementById('id');
	var bar = document.getElementById('progress');
 
	var strong = new RegExp('^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$', 'g');
	var medium = new RegExp('^(?=.{6,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$', 'g');
	var lengte = new RegExp('(?=.{6,}).*', 'g');
 
	if (text == null)
	{
		return;
	}
 
	id.value = 0;
 
	var width = pwd.length * 10;
 
	if (pwd.length == 0)
	{
		text.innerHTML = 'Geen';
		width = 0;
		progress.style.backgroundColor = 'white';
		id.value = 0;
	}
	else if (false == lengte.test(pwd))
	{
		width = 33;
		text.innerHTML = 'Te Kort';
		progress.style.backgroundColor = 'red';
	}
	else if (strong.test(pwd))
	{
		text.innerHTML = 'Sterk';
		width = 100;
		progress.style.backgroundColor = 'Green';
		id.value = 3;
	}
	else if (medium.test(pwd))
	{
		text.innerHTML = 'Redelijk';
		width = 65;
		progress.style.backgroundColor = 'Orange';
		id.value = 2;
	}
	else
	{
		width = 33;
		text.innerHTML = 'Zwak';
		progress.style.backgroundColor = 'red';
		id.value = 1;
	}
 
	progress.style.width = width + '%';
 
	document.getElementById('strength').style.display = (pwd.length == 0)?'visible':'';
}