var ajax_obj;
var ie;
var head;
var maindiv;
var js;
var css;
var finished = true;

window.onload = function(){
	if(typeof init == 'function'){
		init();
	}
	ie = navigator.userAgent.indexOf("MSIE") != -1;
	var heads = document.getElementsByTagName('head');
	head = heads[0];
	maindiv = document.getElementById('maincontent');
}

function ajax_init(){
	try{
		ajax_obj = new XMLHttpRequest();
	}catch (e){
		try{
			ajax_obj = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e){
			try{
				ajax_obj = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
				ajax_obj = false;
			}
		}
	}
}

function ajax_inited(){
	if(ajax_obj){
		return true;
	}
	return false;
}

function ajax_test(){
	var obj = document.getElementById('testdiv');
	obj.innerHTML = 'Init: ' + ajax_inited();
}

function ajax_get(url, onfinish, onfail){
	if(!ajax_inited()){
		ajax_init();
	}
	var request_complete = false;
	
	ajax_obj.onreadystatechange = function(){
		if (ajax_obj.readyState == 4 && ajax_obj.status == 200){
			if(!request_complete){
				request_complete = true;
				if(onfinish){
					onfinish(ajax_obj.responseText);
				}
			}
		}else if(ajax_obj.readyState == 4){
			if(onfail){
				onfail(ajax_obj.status);
			}
		}
	};
	
	if(url.indexOf('?') == -1){
		ajax_obj.open('GET', url + '?rnd=' + Math.random(), true);
	}else{
		ajax_obj.open('GET', url + '&rnd=' + Math.random(), true);
	}
	ajax_obj.send();
}

function page_load(page, param){
	if(!finished){
		return false;
	}
	finished = false;
	opacity(maindiv, 0);
	removePageHeaders();
	var url;
	if(!param){
		url = 'index.php?p=' + page + '&type=body';
	}else{
		url = 'index.php?p=' + page + '&type=body&' + param;
	}
	ajax_get(url, function(result){
		maindiv.innerHTML = result;
		//opvragen welke files in de head moeten komen
		ajax_get('getHead.php?p=' + page, function(result){
			var heads = result.split(",");
			if(heads[0] && heads[0] == 'true'){
				//Css file in head zetten
				css = document.createElement('link');
				css.setAttribute("type","text/css");
				css.setAttribute("rel","stylesheet");
				css.setAttribute("href", 'style/' + page + '.css');
				head.appendChild(css);
			}else{
				css = null;
			}
			
			if(heads[1] && heads[1] == 'true'){
				//Js file in head zetten
				js = document.createElement('script');
				js.setAttribute("type","text/javascript");
				js.setAttribute("src", 'javascript/' + page + '.js');
				js.onload = function(){
					init();
				};
				head.appendChild(js);
			}else{
				js = null;
			}
			
			//Fade in
			fadeIn(0, maindiv, 3, function(){
				finished = true;
			});
		}, function(errorcode){
			alert('fail: ' + errorcode);
		});
		
	}, function(errorcode){
		alert('fail: ' + errorcode);
	});
	return false;
}

function removePageHeaders(){
	if(css){
		head.removeChild(css);
	}
	
	if(js){
		head.removeChild(js);
	}
}

function opacity(elem, percent){
	if(ie){
		elem.style.filter = 'alpha(opacity = ' + percent + ')';
	}else{
		elem.style.opacity = (percent / 100);
	}
}

function fadeIn(tick, elem, tickAmount, onfinish){
	tick += tickAmount;
	
	if(tick >= 100){
		opacity(elem, 100);
		if(onfinish)onfinish();
		return;
	}
	
	opacity(elem, tick);
	
	setTimeout(function(){
		fadeIn(tick, elem, tickAmount, onfinish);
	}, 15);
}