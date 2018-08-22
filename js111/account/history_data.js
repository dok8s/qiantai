tmpObj = new Object();
tmpObj["gtype"] = "";
tmpObj["date_s"] = "";
tmpObj["date_e"] = "";

var calendar = null;
var setSearchDate="";
var minDate="";
var maxDate="";

function init(){

		var sel = document.getElementById("sel_gtype");
		var gtype = sel.getAttribute("value");
		var obj = document.getElementById("gtype_"+gtype);
		obj.className = (gtype == "BK")?"acc_selectBK On":"On";
		sel.innerHTML = obj.innerHTML;

		setClick("gtype");
		setClick("date_s");
		//setClick("date_e");
		document.body.onclick=function(evt){getTarget((evt) ? evt : window.event);}

		//月曆
		var langx = top.langx;
		var _set = {};
		if(langx == "zh-tw" ||langx == "zh-cn"){
			_set.monthName = ["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"]; // 月份語系;
			_set.weekName = ["日","一","二","三","四","五","六"]; // 星期語系;
		}
		if(langx == "en-us"){
			_set.monthName = ["January","February","March","April","May","June","July","August","September","October","November","December"]; // 月份語系;
			_set.weekName = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"]; // 星期語系;
		}
		_set.futureYear = 20; // 未來年份數;
		_set.cssShow = false;
		_set.minDate=minDate;
		_set.maxDate=maxDate;

		var tmpScreen = document.getElementById("div_state");
		calendar = new ClassFankCal(tmpScreen,_set);
		calendar.addEventListener("DATE_CHOOSE",function(evt,obj){
			if(document.all){
				document.getElementById(setSearchDate).innerText = obj.date;
			}
			else{
				document.getElementById(setSearchDate).textContent = obj.date;
			}
			document.getElementById(setSearchDate).setAttribute("value", obj.date);
			calendar.close();
			//location.href = "/app/member/account/result/result.php?game_type="+game_type+"&list_date="+obj.date+"&uid="+top.uid+"&langx="+top.langx;
		});
}

function getTarget(evt){
	var evt=(evt.target) ? evt.target :evt.srcElement;
	if(evt.id != "sel_gtype") document.getElementById("chose_gtype").style.display = "none";
	//document.getElementById(setSearchDate).className = "acc_selectMS_first";
}

function closeDate(){
	document.getElementById(setSearchDate).className = "acc_selectMS_first";
}

function setClick(type){
		var typeObj = document.getElementById("chose_"+type);
		typeObj.style.display = "none";

		if(type == "date_s"){
			minDate = typeObj.children[0].innerHTML;													//getAttribute("value") IE10只能取到年，故改成HTML
			maxDate = typeObj.children[typeObj.children.length-1].innerHTML;	//getAttribute("value") IE10只能取到年，故改成HTML
		}else{
			for(var i=0; i<typeObj.children.length; i++){
					var obj = typeObj.children[i];
					setClickEvent(obj,type);
			}
		}
}

function setClickEvent(obj,type){
		obj.onclick=function(){
				chgChose(obj,type);
		};
}

function chgChose(obj, type){
		var sel = document.getElementById("sel_"+type);
		var _value = obj.getAttribute("value");
		if(tmpObj[type]) tmpObj[type].className = "";
		else
		{
			if(type == "gtype")
				document.getElementById("gtype_"+sel.getAttribute("value")).className = "";
		}
		obj.className = "On";
		sel.innerHTML = obj.innerHTML;
		sel.setAttribute("value", _value);

		document.getElementById("chose_"+type).style.display="none";
		if(type == "gtype"){
			showDiv(type);
			searchEvent();
		}
		tmpObj[type] = obj;
}

function showDiv(divname){
		var obj = document.getElementById("chose_"+divname);
		obj.style.display = (obj.style.display)?"":"none";

}

function searchEvent(){
		if(on_Submit()){
				document.getElementById("gtype").value = document.getElementById("sel_gtype").getAttribute("value");
				document.getElementById("gdate").value = getselDate('sel_date_s');//抓起始日期
				document.getElementById("gdate1").value = getselDate('sel_date_e');//抓結束日期
				document.getElementById("myform").submit();
		}
}

function getselDate(showDate)//20160204_william_edge用getAttribute抓不到完整日期
{
	var abs = util.getObjAbsolute_new(document.getElementById(showDate));
	var date;
	if(document.all){
		date = document.getElementById(showDate).innerText;
	}
	else{
		date = document.getElementById(showDate).textContent;
	}
	return date;
}


function on_Submit(){
	var _dateS = getselDate('sel_date_s');
	var _dateE = getselDate('sel_date_e');


		if( (Date.parse(_dateS)).valueOf() > (Date.parse(_dateE)).valueOf()){
				alert("Search date Error!");
				return false;
		}
		return true;
}

function changeUrl(a){
		self.location=a;
}

function showDate(showDate){
	var abs = util.getObjAbsolute_new(document.getElementById(showDate));
	var date;
	if(document.all){
		date = document.getElementById(showDate).innerText;
	}
	else{
		date = document.getElementById(showDate).textContent;
	}
	var date = (document.getElementById(showDate).innerText || document.getElementById(showDate).textContent);
	if(showDate =="sel_date_e")  abs["left"] = abs["left"]-135;
	var _tmp=calendar.open(abs["left"],abs["top"]+document.getElementById(showDate).offsetHeight,date);
	if(!_tmp){
		setSearchDate = showDate;
		document.getElementById(showDate).className = "acc_selectMS_first RedWord";
	}
	top.showResultObj=new Object();
}
