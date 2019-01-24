
function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {  
    window.onload = function() {
      oldonload();
      func();
    }
  }
}
function createTag() {
	var dl=document.getElementById("new_address_con").getElementsByTagName("dl");
	var dd=dl[5].getElementsByTagName("dd");
	var label=dd[0].getElementsByTagName("label");
	var bTag=document.createElement("b");
	dd[0].insertBefore(bTag,label[0]);	
	}
function checklist() {
	var dl=document.getElementById("new_address_con").getElementsByTagName("dl");
	var dd=dl[5].getElementsByTagName("dd")[0];
	dd.onclick=function() {
		if(this.className=="botton-select"){
			this.className=" ";
			$("input[name=is_default]").attr("value","0");
			}
			else{
				this.className="botton-select";
			$("input[name=is_default]").attr("value","1");
			

				}
		}
	}
	
addLoadEvent(createTag);
addLoadEvent(checklist);