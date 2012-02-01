window.onload = init;

function init(){
	var form1 = document.forms[0];
	form1.elements[0].focus();

	var housenr = form1.elements['huisnr'];
	housenr.onblur = function(){
		var reg = new RegExp('^[0-9]{1,}[a-zA-Z]{0,}$');
		if(!housenr.value.match(reg)){
			housenr.className = 'wrong';
		}else{
			housenr.className = 'correct';
		}
	};
	
	var zip = form1.elements['pstc'];
	zip.onblur = function(){
		var reg = new RegExp('^[0-9]{4}[a-zA-Z]{2}$');
		if(!zip.value.match(reg)){
			zip.className = 'wrong';
		}else{
			zip.className = 'correct';
			zip.value = zip.value.toUpperCase();
		}
	};
	
	var email = form1.elements['mail'];
	email.onblur = function(){
		var reg = new RegExp('^.+@.+\..+$');
		if(!email.value.match(reg)){
			email.className = 'wrong';
		}else{
			email.className = 'correct';
		}
	};
	
	var phone1 = form1.elements['tel1'];
	phone1.onblur = function(){
		var reg = new RegExp('^[0-9]{2,4}-?[0-9]{6,8}$');
		if(!phone1.value.match(reg)){
			phone1.className = 'wrong';
		}else{
			phone1.className = 'correct';
		}
	};

	var phone2 = form1.elements['tel2'];
	phone2.onblur = function(){
		var reg = new RegExp('^[0-9]{2,4}-?[0-9]{6,8}$');
		if((!phone2.value.match(reg) && phone2.value != '') || phone2.value == phone1.value){
			phone2.className = 'wrong';
		}else{
			phone2.className = 'correct';
		}
	};

	isset(form1.elements['vnaam']);
	isset(form1.elements['anaam']);
	isset(form1.elements['plaats']);
	isset(form1.elements['straat']);
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