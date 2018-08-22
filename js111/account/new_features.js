var _top = 624;

function init(){
	document.getElementById("topDiv").style.top = _top+"px";
	window.onscroll = scrollHeight;

	initDivBlur(document.getElementById("NF_options"),document.getElementById("first"))
	document.getElementById("first").onclick =function() {
		divOnBlur(document.getElementById("NF_options"),document.getElementById("first"));
		showOption();
	}
}

function divOnBlur(showdiv,selid){// util 
	//console.log("divOnBlur======>"+showdiv.id);
	selid.onclick=null;
	showdiv.style.display='';
	showdiv.focus();

}

function initDivBlur(showdiv,selid){
	showdiv.tabIndex=100;
	showdiv.onblur=function(){
		showdiv.style.display='none';
		setTimeout(function(){
			selid.onclick=function(){
				//alert("onblur");
				divOnBlur(showdiv,selid);
				showOption();
				}
		},300);
	};

}

function scrollHeight(){
	var scrollObj = getScrollObj();
	var scrollTop = document.documentElement.scrollTop || document.body.scrollTop || 0;
	document.getElementById("topDiv").style.top = (_top+scrollTop)+"px";

}

function getScrollObj(){
	var scrollObj = null;

	if(document.all){
		scrollObj = document.documentElement;
	}else{
		scrollObj = document.body;
	}

	return scrollObj;
}

function showOption(){
	//var _status = document.getElementById("soptions").style.display;
	//document.getElementById("soptions").style.display = (_status=="")?"none":"";

	var sel = document.getElementById("first").innerHTML;
	var _options = document.getElementById("NF_options").children;
	var h = document.getElementById("NF_options").clientHeight;

	for(var i=0; i<_options.length; i++){
		var _option = _options[i];

		if(_option.innerHTML == sel){
			document.getElementById("NF_options").scrollTop = (_option.offsetTop - (h-_option.clientHeight));
		}
	}

}

function moveDiv(move){
	move="#"+move;
	window.location.href=move;
}