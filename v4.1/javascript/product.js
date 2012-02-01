var res;
// laad de eerste tab in tabcontent bij pageload
function init()
  {
   res=document.getElementById("tabContent");
   res.innerHTML=document.getElementById("tab1Content").innerHTML;
   }
 window.onload = init;
 
function tabs(x)
  {
	//verzamel alle li elementen van productTabs
    var list=document.getElementById("productTabs").childNodes;
 
	//maak alle li klassen leeg, dit is zodat wanneer je op een tab
	//drukt de vorige tab niet meer de klasse selected heeft
    for(i=0;i<list.length;i++)
    {
      list[i].className="";
    }
	//geeft de li element waar je op hebt geklikt de klasse selected
    x.className="selected";
    var tab=x.id;
	//vervang inhoud van tabcontent met de tab waar je op hebt geklikt
    switch(tab)
    {
      case "tab1":
        res.innerHTML=document.getElementById("tab1Content").innerHTML;
        break;
 
      case "tab2":
        res.innerHTML=document.getElementById("tab2Content").innerHTML;
        break;

      default:
        res.innerHTML=document.getElementById("tab1Content").innerHTML;
        break;
 
    }
  }

  
  