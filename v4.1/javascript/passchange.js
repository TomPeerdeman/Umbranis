window.onload = function(){
	var form1 = document.forms[0];
	form1.elements[0].focus();
	
	var pass2 = form1.elements['newpass2'];
	pass2.onblur = function(){
		if(pass2.value == '' || pass2.value != form1.elements['newpass1'].value){
			pass2.className = 'wrong';
		}else{
			pass2.className = 'correct';
		}
	};
	
	isset(form1.elements['oldpass']);
	isset(form1.elements['newpass1']);
}

function isset(obj){	
	obj.onblur = function(){
		if(obj.value != ''){
			obj.className = 'correct';
		}else{
			obj.className = 'wrong';
		}
	}
}