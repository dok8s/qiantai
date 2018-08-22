var selScrollType = "";
function reload_var(){
//	location.reload();
	var str = document.getElementById ("findField").value;
	self.location.href="scroll_history.php?uid="+uid+"&langx="+langx+"&select_date="+select_date+"&fField="+str+"&t_important="+t_important+"&type="+selScrollType;
}

function showImportant(val,scrollType){
	top.t_important = val;
	document.getElementById("General").className="acc_ann_msgBTN";
	document.getElementById("Important").className="acc_ann_msgBTN";
	document.getElementById("Personal").className="acc_ann_msgBTN";
	classType = "acc_ann_msgBTN_on";
	if(val==0){
		document.getElementById("General").className=classType;
	}else if(val==1){
		document.getElementById("Important").className=classType;
	}else if(val==2){
		document.getElementById("Personal").className=classType;
	}else{
		document.getElementById("General").className=classType;
	}
	selScrollType = scrollType;
}
//chg_date
function chg_date(tmp_date){
	var str = document.getElementById ("findField").value;
	top.tmp_date = tmp_date;
	//var myOddtype=document.getElementById("select2");
	//var tmp_date=myOddtype.options[myOddtype.selectedIndex].value;
	//self.location.href="scroll_history.php?uid="+top.uid+"&langx="+top.langx+"&select_date="+tmp_date;
	try{
		uid=top.uid;
	}catch(E){
		alert("chg_dates="+top.mem_logut);
		window.close();
	}

	self.location.href="scroll_history.php?uid="+uid+"&langx="+langx+"&select_date="+tmp_date+"&fField="+str+"&t_important="+t_important+"&type="+selScrollType;
}

function chg_pge(){
	var myOddtype=document.getElementById("select");
	var page_no=myOddtype.value;
	//self.location.href="scroll_history.php?uid="+top.uid+"&langx="+top.langx+"&select_date="+select_date+"&page_no="+page_no;
	try{
		uid=top.uid;
	}catch(E){
		alert(top.mem_logut);
		window.close();
	}
	self.location.href="scroll_history.php?uid="+uid+"&langx="+langx+"&select_date="+select_date+"&page_no="+page_no+"&t_important="+t_important+"&type="+selScrollType;

}
function overbars(obj,color){
	obj.className=color;
}
function outbars(obj,color){
	obj.className=color;
}

//�j�M��r
function FindNext () {
	try{
		uid=top.uid;
	}catch(E){
		alert("FindNext="+top.mem_logut);
		window.close();
	}
	var str = document.getElementById ("findField").value;
	if (str == "") {
		// alert ("Please enter some text to search!");
		//alert(top.message031);
		//return;
		self.location.href="scroll_history.php?uid="+uid+"&langx="+langx+"&select_date="+select_date+"&t_important="+t_important+"&type="+selScrollType;
		return;
	}
	self.location.href="scroll_history.php?uid="+uid+"&langx="+langx+"&fField="+str+"&find=true"+"&select_date="+select_date+"&t_important="+t_important+"&type="+selScrollType;

}
var setCookie = new Object();
setCookie[0] = "Gen_cookie";
setCookie[1] = "Imp_cookie";
setCookie[2] = "Per_cookie";
var DateObj = new Object();
DateObj[-4] = "all";
DateObj[-3] = "today";
DateObj[-1] = "yesterday";
DateObj[-2] = "before";
function init(){
	try{
		uid=top.uid;
	}catch(E){
		alert("init="+top.mem_logut);
		window.close();
	}
	if (""+select_date=="undefined") select_date="";
	if(""+t_important == "undefined")t_important="";
	showImportant(t_important,annouType);
	try{
		document.getElementById ("findField").value=fField;
		x=document.getElementById ("findField");
		x.focus();
		if(x.setSelectionRange){
			x.setSelectionRange(x.value.length, x.value.length);
		}else{
			o=x.createTextRange();
			o.moveStart('character',x.value.length);
			o.collapse(true);
			o.select();
		}
		setClick("type");
		var sel_type = document.getElementById("sel_type");
		var obj_type = document.getElementById(DateObj[select_date]);
		obj_type.className = "On";
		sel_type.innerHTML = obj_type.innerHTML;
		if(document.getElementById ("findField").value != "")document.getElementById("acc_ann_delBTN").style.display="";
		setTextClick("acc_ann_delBTN");
		setText("findField");
	}catch(e){}

	var cookieValue = "";
	var cookmid="";
	var tmp_cookie="";

	var cookieAry = document.cookie.split(";");
	for(var i=0; i<cookieAry.length; i++){
		var thisCookie = cookieAry[i].split("=");
		if(thisCookie[0].indexOf(setCookie[t_important]) != -1){
			tmp_cookie = thisCookie[1];
		}
	}
	var tmp_cookieAry =tmp_cookie.split("&");
	for(var i=0; i<tmp_cookieAry.length;i++){
		var splCookie = tmp_cookieAry[i].split("@");
		if(splCookie[1]==mid){
			cookieValue = splCookie[0];
		}
	}

	//console.log(select_date);
	set_ImportantCount(Imp_count);
	//reload_messageCount();
	if(document.getElementById ("findField").value == ""){

		if(scroll_id > cookieValue){
			// 2017-08-02 3100.新會員端-公告也幫加上cookie的時效
			var now = new Date();
			var time = now.getTime();
			var expireTime = time + 365*24*60*60*1000;
			now.setTime(expireTime);
			if(tmp_cookie){
				//document.cookie = setCookie[t_important]+"="+tmp_cookie+"&"+scroll_id+"@"+mid+";";
				// 2017-08-02 3100.新會員端-公告也幫加上cookie的時效
				document.cookie = setCookie[t_important]+"="+tmp_cookie+"&"+scroll_id+"@"+mid+";expires="+now.toGMTString()+";";
			}else{
				//document.cookie = setCookie[t_important]+"="+scroll_id+"@"+mid+";";
				// 2017-08-02 3100.新會員端-公告也幫加上cookie的時效
				document.cookie = setCookie[t_important]+"="+scroll_id+"@"+mid+";expires="+now.toGMTString()+";";
			}
			//document.cookie = setCookie[t_important]+"="+scroll_id+";";
		}
	}
	//console.log(counts);
}

function setClick(type){
	var typeObj = document.getElementById("chose_"+type);
	for(var i=0; i<typeObj.children.length; i++){
		var obj = typeObj.children[i];
		setClickEvent(obj,type);
	}
}

function setClickEvent(obj,type){
	obj.onclick=function(){
		chgChose(obj,type);
	}
}

function chgChose(obj, type){
	var _value = obj.getAttribute("value");
	chg_date(_value);

}

function showOption(){
	var _status = document.getElementById("chose_type").style.display;
	document.getElementById("chose_type").style.display = (_status=="")?"none":"";
}

function checkKey(e){
	var findbutton = document.getElementById('findbutton');
	if(e ==13){  //�� Enter
		findbutton.focus();
	}
}

function chg_important(val,scrollType){

	self.location.href=util.getNowDomain()+"/app/member/account/scroll_history.php?uid="+top.uid+"&langx="+langx+"&select_date="+select_date+"&t_important="+val+"&type="+scrollType;
	showImportant(val,scrollType);
	try{
		parent.getAnnouCount();
	}catch(e){}
	try{
		parent.setAnnouCount();
	}catch(e){}
}

//2015-07-21 Peter selecterror
var getMessageCount="";
function reload_messageCount(){
	clearTimeout(getMessageCount);
	var url = "scroll_history.php";
	var params = "uid="+top.uid;
	loadHref(url+"?"+params);

	//2015-07-28	peter	
	//getMessageCount = setTimeout("reload_messageCount()",10000);
}

function loadHref(str){
	loadPHP.location.href=str;
}

function set_messageCount(countMessage){
	//2015-07-27	peter (select)
	//window.opener.chgCountMessage(t_important,countMessage);
	if(countMessage != 0 && countMessage != ""){
		document.getElementById("PersonalMessage").style.display="";
		document.getElementById("PersonalMessage").innerHTML = countMessage;
	}
	else{
		document.getElementById("PersonalMessage").innerHTML = "";
		document.getElementById("PersonalMessage").style.display="none";
	}
}

function set_ImportantCount(countMessage){
	//2015-07-27	peter (select)
	//window.opener.chgCountMessage(t_important,countMessage);
	if(countMessage != 0 && countMessage != ""){
		document.getElementById("ImportantMessage").style.display="";
		document.getElementById("ImportantMessage").innerHTML = countMessage;
	}
	else{
		document.getElementById("ImportantMessage").innerHTML = "";
		document.getElementById("ImportantMessage").style.display="none";
	}
}


function goAnnou(){
	closeIframe();
	parent.showMyAccount("Announcements");
}

function closeIframe(){
	try{
		parent.getAnnouCount();
	}catch(e){}
	try{
		parent.setAnnouCount();
	}catch(e){}
	parent.document.getElementById("annou").style.display="none";
	parent.document.getElementById("head_ann_arr").style.display="none";
}

function setText(type){
	obj = document.getElementById(type);
	obj.onkeyup = function(){
		document.getElementById("acc_ann_delBTN").style.display="";
	}
}

function setTextClick(type){
	obj = document.getElementById(type);
	obj.onclick = function(){
		document.getElementById("findField").value = "";
		document.getElementById("acc_ann_delBTN").style.display="none";
	}
}