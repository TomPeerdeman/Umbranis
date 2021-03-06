window.onload = init;
function init(){
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
function checkStrength(pwd){
	var text = document.getElementById('text');
	var id = document.getElementById('id');
	var progress = document.getElementById('progress');
 
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