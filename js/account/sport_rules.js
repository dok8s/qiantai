var _top = 624;

function init(){
	$('#topDiv').css('top',_top+"px");
	window.onscroll = scrollHeight;
	var filenameId = "#"+filename;
	var str = $(filenameId).html();
	document.getElementById('first').innerHTML = str;

	initDivBlur(document.getElementById("soptions"),document.getElementById("first"))
	document.getElementById("first").onclick =function() {
		divOnBlur(document.getElementById("soptions"),document.getElementById("first"));
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
	var _options = document.getElementById("soptions").children;
	var h = document.getElementById("soptions").clientHeight;

	for(var i=0; i<_options.length; i++){
		var _option = _options[i];

		if(_option.innerHTML == sel){
			document.getElementById("soptions").scrollTop = (_option.offsetTop - (h-_option.clientHeight));
		}
	}

}

function chgPage(filename){
	self.location.href="sport_rules.php?uid="+top.uid+"&langx="+langx+"&filename="+filename;
}