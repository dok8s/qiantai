var emailRule = /[\x00-\xff]+@[\x00-\xff]+\.com(?:\.[\x00-\xff]+|)$/;
var time = "";

function onLoads(){
	changeDiv('div_set_email');
}

function do_submit(action){
	var myVerify =document.getElementById('myVerify').value;
	var username =document.getElementById('username').value;
	var passwd =document.getElementById('passwd').value;
	var pwd_chk =document.getElementById('pwd_chk').value;
	var setEmail = document.getElementById('setEmail').value;
	
	if(username==""){
		document.getElementById("msg_err").innerHTML = top.str_input_longin_id2;
		document.getElementById("err_info").style.display = "";
		return false;
	}
	if((!setEmail.match(emailRule))||setEmail.match(/\s/)||setEmail.length<=0){
		document.getElementById("msg_err").innerHTML = top.str_err_mail;
		document.getElementById("err_info").style.display = "";
		return false;
	}
	
	if(action == "setPwd"){
		var Numflag = 0;
		var Letterflag = 0;
		
		if (passwd==''){
			document.getElementById('passwd').focus();
			document.getElementById("pwd_info").innerHTML=top.str_input_pwd;
			document.getElementById("pwd_show_info").style.display = "";
			clear_pwd();
			return false;
		}
		if (pwd_chk==''){
			document.getElementById('pwd_chk').focus();
			document.getElementById("pwd_info").innerHTML=top.str_input_repwd;
			document.getElementById("pwd_show_info").style.display = "";
			clear_pwd();
			return false;
		}
		if (passwd.length < 6 || passwd.length > 12) {
			document.getElementById("pwd_info").innerHTML=top.str_pwd_limit3;
			document.getElementById("pwd_show_info").style.display = "";
			clear_pwd();
			return false;
		}
		if(passwd != pwd_chk){
			document.getElementById('passwd').focus();
			document.getElementById("pwd_info").innerHTML=top.str_err_pwd;
			document.getElementById("pwd_show_info").style.display = "";
			clear_pwd();
			return false;
		}
		for (idx = 0; idx < passwd.length; idx++) {
			//====== 密碼只可使用字母(不分大小寫)與數字
			if(!((passwd.charAt(idx)>= "a" && passwd.charAt(idx) <= "z") || (passwd.charAt(idx)>= 'A' && passwd.charAt(idx) <= 'Z') || (passwd.charAt(idx)>= '0' && passwd.charAt(idx) <= '9'))){
				document.getElementById("pwd_info").innerHTML=top.str_pwd_limit3;
				document.getElementById("pwd_show_info").style.display = "";
				clear_pwd();
				return false;
			}
			if ((passwd.charAt(idx)>= "a" && passwd.charAt(idx) <= "z") || (passwd.charAt(idx)>= 'A' && passwd.charAt(idx) <= 'Z')){
				Letterflag++;
			}
			if ((passwd.charAt(idx)>= "0" && passwd.charAt(idx) <= "9")){
				Numflag++;
			}
		}
		//====== 密碼需使用字母加上數字
			var msg = "";
		if (Numflag == 0 || Letterflag == 0) {
			document.getElementById("pwd_info").innerHTML=top.str_pwd_limit3;
			document.getElementById("pwd_show_info").style.display = "";
			clear_pwd();
			return false;
		}
	}//if setPwd
	
	var reg = new HttpRequest();
	reg.addEventListener("LoadComplete",view_);
	reg.loadURL("./forgot_pwd.php","POST",'setEmail='+setEmail+'&username='+username+'&action='+action+'&myVerify='+myVerify+'&langx='+langx+'&passwd='+passwd+'&pwd_chk='+pwd_chk+'&time='+time);
}

function view_(data){
	var JsonObj = (new Function("return "+data+";"))();
	changeDiv(JsonObj.view);
	
	time = JsonObj.time;
	if(JsonObj.alert_msg!=""){
		setTimeout(function(){alert(JsonObj.alert_msg);},50);
	}
	
	if(JsonObj.done_msg!=""){
		alert(JsonObj.done_msg);
	}
	if(JsonObj.view == "div_set_verify") document.getElementById('myVerify').value = "";
	if(JsonObj.err_msg!=""){
		if(JsonObj.view == "div_set_email"){
			document.getElementById("msg_err").innerHTML = JsonObj.err_msg;
			document.getElementById("err_info").style.display = "";
		}else if(JsonObj.view == "div_set_verify"){
			document.getElementById("verify_info").innerHTML = JsonObj.err_msg;
			document.getElementById("verify_show_info").style.display = "";
		}else if(JsonObj.view == "div_set_pwd"){
			document.getElementById("pwd_info").innerHTML = JsonObj.err_msg;
			document.getElementById("pwd_show_info").style.display = "";
		}
		return false;
	}
	
}

function clear_pwd(){
	document.getElementById('passwd').value = "";
	document.getElementById('pwd_chk').value = "";
}

function do_cancel(flag){
	if(flag != "2"&&confirm(top["str_Quit_getPass"])==false)return false;
	go_domain();
	/*
	var username =document.getElementById('username').value;
	var setEmail = document.getElementById('setEmail').value;
	var reg = new HttpRequest();
	reg.addEventListener("LoadComplete",go_domain);
	reg.loadURL("./forgot_pwd.php","POST",'setEmail='+setEmail+'&username='+username+'&action=clean_verify');
	*/
}

function go_domain(){
	var protocol = document.location.protocol;
	window.location.href= protocol+"//"+document.domain+"/app/member/";
}

function changeDiv(divID){
	
	document.getElementById("verify_show_info").style.display = "none";
	document.getElementById("pwd_show_info").style.display = "none";
	document.getElementById("err_info").style.display = "none";
	document.body.focus();
	
	var allDiv = ["div_set_email","div_set_verify","div_set_pwd","div_set_done"];
	for(var i=0; i<allDiv.length; i++){
		document.getElementById(allDiv[i]).style.display="none";
	}
	if(divID!="") try{document.getElementById(divID).style.display="";}catch(e){}
	if(divID=="div_set_done"){
		document.body.onkeydown = function (e) {
					var evt = e || window.event; //IE does not pass the event object
			    var code = evt.keyCode ? evt.keyCode : evt.which;
			    if (code === 13 ) { //up key
			        document.getElementById("to_login").click();
			    }
			};
		is_set = false;
	}else{
		document.body.onkeydown = function (e){};
	}
}

function key_value(e,_action){
	if(window.event){//IE
			keynum = window.event.keyCode;
		}else if(e.which){//Netscape/Firefox/OEera
			keynum = e.which;
		}
		
		if(keynum == "13"){
			do_submit(_action);
		}
}