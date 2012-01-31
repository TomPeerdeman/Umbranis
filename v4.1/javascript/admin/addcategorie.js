window.onload = function(){
	var form1 = document.forms[0];
	form1.elements[0].focus();

	var cat_name = form1.elements['cat_name'];
	cat_name.onblur = function(){
		var reg = new RegExp('^[A-Za-z0-9-]{1,}$');
		if((!cat_name.value.match(reg) && cat_name.value != '')){
			cat_name.className = 'wrong';
		}else{
			cat_name.className = 'correct';
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