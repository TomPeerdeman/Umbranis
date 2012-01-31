window.onload = function(){
	var form1 = document.forms[0];
	form1.elements[0].focus();

	var normal_price = form1.elements['normal_price'];
	normal_price.onblur = function(){
		var reg = new RegExp('^[0-9]{1,}[.]?[0-9]{0,2}$');
		if(!normal_price.value.match(reg)){
			normal_price.className = 'wrong';
		}else{
			normal_price.className = 'correct';
		}
	};
	
	var product_name = form1.elements['product_name'];
	product_name.onblur = function(){
		var reg = new RegExp('(?=.{0,}).+');
		if(!product_name.value.match(reg)){
			product_name.className = 'wrong';
		}else{
			product_name.className = 'correct';
		}
	};
	
	var ean_code = form1.elements['ean_code'];
	ean_code.onblur = function(){
		var reg = new RegExp('^[0-9]{13}$');
		if(!ean_code.value.match(reg)){
			ean_code.className = 'wrong';
		}else{
			ean_code.className = 'correct';
		}
	};
	
	var price = form1.elements['price'];
	price.onblur = function(){
		var reg = new RegExp('^[0-9]{1,}[.]?[0-9]{0,2}$');
		if((!price.value.match(reg) && price.value != '')){
			price.className = 'wrong';
		}else{
			price.className = 'correct';
		}
	};
	var stock
	= form1.elements['stock'];
	stock.onblur = function(){
		var reg = new RegExp('^[0-9]{0,}$');
		if((!stock.value.match(reg) && stock.value != '')){
			stock.className = 'wrong';
		}else{
			stock.className = 'correct';
		}
	};
	
	var delivery_time = form1.elements['delivery_time'];
	delivery_time.onblur = function(){
		var reg = new RegExp('^[0-9]{0,}$');
		if((!delivery_time.value.match(reg) && delivery_time.value != '')){
			delivery_time.className = 'wrong';
		}else{
			delivery_time.className = 'correct';
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