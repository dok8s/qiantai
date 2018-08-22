var oldpassword_placeholder="";
var password_placeholder="";
var REpassword_placeholder="";

function onLoads(){
	oldpassword_placeholder=document.getElementById("oldpassword").placeholder;
	password_placeholder=document.getElementById("password").placeholder;
	REpassword_placeholder=document.getElementById("REpassword").placeholder;
}

function inputFocus(obj,side){
	obj.placeholder = "";
}

function inputBlur(obj,side){
	var placehold="";
	
	if(side=="oldpassword"){
		placehold=oldpassword_placeholder;
	}else if(side=="password"){
		placehold=password_placeholder;
	}else{
		placehold=REpassword_placeholder;
	}
		
	obj.placeholder = placehold;
}

function SubChk(){
	var Numflag = 0;
	var Letterflag = 0;
	var pwd = document.all.password.value;
	var oldpwd = document.all.oldpassword.value;
	//alert(opener.top.uid);
	if(oldpwd == "")
	{
		//alert(top.str_pwd_NowErr);
		document.getElementById("hr_info").innerHTML=top.str_pwd_OldErr;
		document.getElementById("err_info").style.display = "";
		clear_pwd();
		return false;
	}
	if(oldpwd != pass){
		//alert(top.str_pwd_NowErr);
		document.getElementById("hr_info").innerHTML=top.str_pwd_NowErr;
		document.getElementById("err_info").style.display = "";
		clear_pwd();
		return false;
	}
	if (pwd == pass) {
		//alert(top.str_pwd_NoChg);
		document.getElementById("hr_info").innerHTML=top.str_pwd_NoChg;
		document.getElementById("err_info").style.display = "";
		clear_pwd();
		return false;
	}
	if (document.all.password.value==''){
		document.all.password.focus();
		//alert(top.str_input_pwd);
		document.getElementById("hr_info").innerHTML=top.str_input_pwd;
		document.getElementById("err_info").style.display = "";
		clear_pwd();
		return false;
	}
	if (document.all.REpassword.value==''){
		document.all.REpassword.focus();
		//alert(top.str_input_repwd);
		document.getElementById("hr_info").innerHTML=top.str_input_repwd;
		document.getElementById("err_info").style.display = "";
		clear_pwd();
		return false;
	}
	if (pwd.length < 6 || pwd.length > 12) {
		//alert(top.str_pwd_limit);
		document.getElementById("hr_info").innerHTML=top.str_pwd_limit;
		document.getElementById("err_info").style.display = "";
		clear_pwd();
		return false;
	}
	if(document.all.password.value != document.all.REpassword.value){
		document.all.password.focus();
		//alert(top.str_err_pwd);
		document.getElementById("hr_info").innerHTML=top.str_err_pwd;
		document.getElementById("err_info").style.display = "";
		clear_pwd();
		return false;
	}
	for (idx = 0; idx < pwd.length; idx++) {
		//====== 密碼只可使用字母(不分大小寫)與數字
		if(!((pwd.charAt(idx)>= "a" && pwd.charAt(idx) <= "z") || (pwd.charAt(idx)>= 'A' && pwd.charAt(idx) <= 'Z') || (pwd.charAt(idx)>= '0' && pwd.charAt(idx) <= '9'))){
			//alert(top.str_pwd_limit);
			document.getElementById("hr_info").innerHTML=top.str_pwd_limit;
			document.getElementById("err_info").style.display = "";
			clear_pwd();
			return false;
		}
		if ((pwd.charAt(idx)>= "a" && pwd.charAt(idx) <= "z") || (pwd.charAt(idx)>= 'A' && pwd.charAt(idx) <= 'Z')){
			Letterflag++;
		}
		if ((pwd.charAt(idx)>= "0" && pwd.charAt(idx) <= "9")){
			Numflag++;
		}
	}
	//====== 密碼需使用字母加上數字
		var msg = "";
	if (Numflag == 0 || Letterflag == 0) {
		//alert(top.str_pwd_limit2);
		document.getElementById("hr_info").innerHTML=top.str_pwd_limit2;
		document.getElementById("err_info").style.display = "";
		clear_pwd();
		return false;
	} else if (Letterflag >= 1 && Letterflag <= 3) {
		msg = "1";
	} else if (Letterflag >= 4 && Letterflag <= 8) {
		msg = "2";
	} else if (Letterflag >= 9 && Letterflag <= 11) {
		msg = "3";
	} else {
		clear_pwd();
		return false;
	}
	try{
		document.all.uid.value=opener.top.uid;
	}catch(E){
		try{
			if (""+top.uid!="undefined"){
				document.all.uid.value=top.uid;
			}else{
				alert(top.mem_logut);
				window.close();
				return false;
			}
		}catch(E){
			alert(top.mem_logut);
			window.close();
			return false;	
		}
		
	}
	//alert(msg);

	document.all.msg.value=msg;
	//window.showModalDialog("/app/member/chg_pass_msg.php?msg="+msg+"_"+LS+"&str_meta="+str_meta+"&langx="+top.langx, "", "dialogHeight=130px;dialogWidth=280px;center=yes;status=no;help=no;statusbar=no;scroll=no;");
	
	return true;
}

function do_cancel(flag){
	if(flag == "3"){
		window.location="/app/member/index.php";
	}else{
		parent.window.close();
	}
}

function do_submit(){
		//document.getElementById("myform").submit();
		document.getElementById("OK").click();
}

function clear_pwd(){
		document.getElementById("oldpassword").value="";
		document.getElementById("password").value="";
		document.getElementById("REpassword").value="";
		document.getElementById("oldpassword").focus();
}

function changeDiv(divID){
	
	var allDiv = ["chg_pwd_main","SetMyEmail"];
	for(var i=0; i<allDiv.length; i++){
		document.getElementById(allDiv[i]).style.display="none";
	}
	if(divID!="") try{document.getElementById(divID).style.display="";}catch(e){}	
	if(divID=="SetMyEmail"){
		document.body.onkeydown = function (e) {
					var evt = e || window.event; //IE does not pass the event object
			    var code = evt.keyCode ? evt.keyCode : evt.which;
			    if (code === 13 ) { //up key
			        document.getElementById("go_setEmail").click();
			    }
			};
		is_set = false;
	}else{
		document.body.onkeydown = function (e){};
	}
}