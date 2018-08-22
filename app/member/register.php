<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>用户注册</title>    
    <link href="/style/Reg.css" rel="stylesheet" type="text/css">
<script language="JAVAScript"> 
<!--
//去掉空格
function check_null(string){ 
var i=string.length;
var j = 0; 
var k = 0; 
var flag = true;
while (k<i){ 
if (string.charAt(k)!= " ") 
j = j+1; 
k = k+1; 
} 
if (j==0){ 
flag = false;
} 
return flag; 
}
function isNum(N){   
//var   Ns=/^\d{8}/;   
var Ns=/^[A-Za-z0-9]{4,10}$/;   
if (!Ns.test(N)){   
    return   false;
}else{   
    return   true;   
}   
}
function fourNum(N){   
//var   Ns=/^\d{8}/;   
var Ns=/^[0-9]{4,4}$/;   
if (!Ns.test(N)){   
    return   false;
}else{   
    return   true;   
}   
}
function isMobel(value){   
if(/^1[0-9]{10,12}$/.test(value)){    
          return true;   
}else{   
           return false;   
}   
}

function isNoChinese(v){
	var reg=/[\u4E00-\u9FA5]|[\uFE30-\uFFA0]/gi;
	if (reg.test(v)) return true;
	else return false;
}
function isEmail(obj) {

	strEmail = obj.value ;

	if(strEmail==''){

		return;

	}

	if (strEmail.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) != -1)

		return true;

	else

		alert("郵箱不正確!");

		obj.value='';

		obj.focus();

}
function VerifyData(){
	if (document.main.username.value == "") {
		alert("所需帐号不能为空")
		document.main.username.focus();
		return false;
	}
	if (!isNum(document.main.username.value)){   
		alert("请输入正确的账号！格式：以英文+数字,长度6-10"); 
		document.main.username.focus();
		return   false;   
	}
	if (document.main.username.value.length<6 || document.main.username.value.length>10) {
		alert("账号需在6-10位之间");
		document.main.username.focus();
		return   false; 
	}
	/*if (!fourNum(document.main.address.value)){   
		alert("取款密码必须为4位数字。"); 
		document.main.address.focus();
		return   false;   
	}*/
	if (document.main.password.value == "") {
		alert("所需密码不能为空")
		document.main.password.focus();
		return false;
	}
	if (document.main.Confirm_Password.value.length<6 || document.main.Confirm_Password.value.length>10) {
		alert("确认密码不正确");
		document.main.Confirm_Password.focus();
		return   false; 
	}
	if (document.main.password.value != document.main.Confirm_Password.value) {
		alert("确认密码不正确!");
		document.main.Confirm_Password.focus();
		return false;
	}
	if (!check_null(document.main.alias.value)) {
		window.alert("阁下姓名不能为空")
		document.main.alias.focus();
		return false;
	}
	if (!isNoChinese(document.main.alias.value)) 
		{
			window.alert("阁下姓名只能为中文！")
			document.main.alias.focus();
			return false;
		}
	/*if (document.main.address.value== "") {
        alert("提款密码必须填写")
        document.main.address.focus();
        return false;
    }*/
	if (document.main.phone.value == "") {
		alert("手机号码不能为空!");
		document.main.phone.focus();
		return false;
	}
	if (!isMobel(document.main.phone.value)){
		alert("手机号码格式不正确!");
		document.main.phone.focus();
		return false;
	}
	var reg=/^\d+$/g; 
    if (reg.test(document.main.phone.value)==false){
		alert("手机号码必须是数字！")
		document.main.phone.focus();
		return false;
	}
	//document.main.submit();
}
-->
</script>
    <style type="text/css">
        .style1
        {
            padding-top: 5px;
            width: 209px;
        }
        .style2
        {
            width: 209px;
        }
        .style3
        {
            padding:0 0 2px 0;
			margin:0;
			text-align:left;
            width: 250px;
        }
        .style4
        {
            width: 250px;
        }
    </style>
   <script type="text/javascript">
       function clickIE4() {
           if (event.button == 2) {
               return false;
           }
       }

       function clickNS4(e) {
           if (document.layers || document.getElementById && !document.all) {
               if (e.which == 2 || e.which == 3) {
                   return false;
               }
           }
       }

       function OnDeny() {
           if (event.ctrlKey || event.keyCode == 78 && event.ctrlKey || event.altKey || event.altKey && event.keyCode == 115) {
               return false;
           }
       }

       if (document.layers) {
           document.captureEvents(Event.MOUSEDOWN);
           document.onmousedown = clickNS4;
           document.onkeydown = OnDeny();
       } else if (document.all && !document.getElementById) {
           document.onmousedown = clickIE4;
           document.onkeydown = OnDeny();
       }

       document.oncontextmenu = new Function("return false");

    </script>

</head>
<body ondragstart="window.event.returnValue=false" onselectstart="event.returnValue=false" oncontextmenu="window.event.returnValue=false">
    <center>
        <div id="Login">
            <h1 align="left">
                新用户注册开户：</h1>
                <div>提交注册开户后，该帐号将作为您的交易帐号，请牢记并妥善保管您的用户名和密码，防止帐户信息泄露或被盗！ 
                    <br>
                    <br>
</div>
            <table width="980" class="lineJL" border="0" cellspacing="0" cellpadding="0">
                <tbody>
				<form action="add_reg_mem.php?keys=add" method="post" name="main" id="main">
				<!--<INPUT  type="hidden" class="input3" maxLength="10" name="agents" readonly value="">-->
				<tr>
                    <td align="right" class="style1" valign="top">
                        会员账号：                    </td>
                    <td class="style3" valign="top" width="700">
                        <input name="username" type="text" id="username" maxlength="10"><span class="Reginput" id="span_CheckUsername"></span>                    </td>
                    <td width="425" align="left" class="sty04" valign="top">
                        登录的会员账号（字母开头,字母和数字组合）！<br>                    </td>
                </tr>
                <tr>
                    <td align="right" class="style1" valign="top">
                        真实姓名：                    </td>
                    <td class="style3" valign="top">
                  <input name="alias" type="text"  id="alias" maxlength="10"><span class="Reginput" id="span1"></span>                    </td>
                    <td width="425" align="left" class="sty04" valign="top">
                        该姓名必须与您的提款银行帐户的户名相同，以便提款！<br>                    </td>
                </tr>
                <tr>
                    <td align="right" class="style1" valign="top">
                        取款密码：                    </td>
                    <td class="style3" valign="top">
                        <!--<input name="address" type="password"  id="address" maxlength="10">-->
						<select name="address1" id="address"  pd="yes">
                  <option value="0">0</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                </select>
                <select name="address2" id="address"  pd="yes">
                  <option value="0">0</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                </select>
                <select name="address3" id="address"  pd="yes">
                  <option value="0">0</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                </select>
                <select name="address4" id="address"  pd="yes">
                  <option value="0">0</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                </select>
				
						<span class="Reginput" id="span2"></span>                    </td>
                    <td width="425" align="left" class="sty04" valign="top">
                        取款密码必须设置为&nbsp;<span style="color:#FF0000;font-weight:bold;">4</span>&nbsp位数字;，为了您方便出款，请牢记。<br>                    </td>
                </tr>
                <tr>
                    <td align="right" class="style1" valign="top">
                        联络电话(手机)：
                    </td>
                    <td class="style3" valign="top">
                        <input name="phone" type="text" class="input3" value=""  id="phone" maxlength="11"><span class="Reginput" id="span3"></span>
                    </td>
                    <td width="425" align="left" class="sty04" valign="top">
                        您本人的电话或手机，以便能通过电话或手机与您取得联系！<br>
                    </td>
                </tr>

                <tr>
                    <td align="right" class="style1" valign="top">
                        账号登录密码：                    </td>
                    <td class="style3" valign="top">
                        <input name="password" type="password" class="input3" id="password" maxlength="10"><span class="Reginput" id="CheckRePassWord"></span>                    </td>
                    <td align="left" class="sty03 sty04" valign="top">
                        密码请设置为&nbsp;<span style="color:#FF0000;font-weight:bold;">6-16</span>&nbsp;位字母或数字！                    </td>
                </tr>
                <tr>
                    <td align="right" class="style1" valign="top">
                        确认登录密码：                    </td>
                    <td class="style3" valign="top">
                        <input name="Confirm_Password" type="password" class="input3" id="Confirm_Password" maxlength="10"><span class="Reginput" id="ReCheckRePassWord"></span>                    </td>
                    <td align="left" class="sty03 sty04" valign="top">请再一次输入确认密码
                    ！</td>
                </tr>
<Script>
var chgURL_domain='';
var mtype='3';
function urlss(r){
    window.open(r,"newopen");  
}
</script>
                
                <tr>
                    <td class="style2">                    </td>
					<td align="center" class="style4">
                       
                      <a href="#" target="_blank"><img alt="联系客服" src="/images/reg_lxkf.gif"></a>&nbsp;&nbsp;&nbsp;
						<input style="border: 0px ; width: 82px; height: 27px; margin-top:inherit" onClick="return VerifyData()" type="image" alt="提交注册" src="/images/btn_wczc.gif">                  </td>
                </tr>
				</form>
            </tbody></table>
			
			<div style="margin:0 auto 30px; width:670px; line-height:25px; text-align:left;"><font color="#FF0000">温馨提示：</font>应广大用户要求，公司在原有 <strong>www.v3322.com</strong> 信用平台的基础上，于2010年隆重推出 <strong>www.v3322.com</strong> 现金平台，可以自助开户、在线存款、实时提款、让广大用户在体育娱乐的同时享受新宝公司带来更加方便快捷的服务。</div>

        </div>
    </center>
</body></html>