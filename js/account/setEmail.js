var emailRule = /[\x00-\xff]+@[\x00-\xff]+\.com(?:\.[\x00-\xff]+|)$/;
var setEmail = "";
var is_set = false;

function onLoads(){
	changeDiv('');
	do_submit('init');
}

function do_submit(action,_id){
	var val = 0;
	if(action == "remove"){
		if(confirm(top["str_RM_getPass"])==false)
		return false
	}

	var myVerify =$('#myVerify').val();
	if(action == "getVerify"){
		var eid = '#'+_id;
		if(_id=="setEmail") {
			setEmail = $(eid).val();
			$('#myEmail').html(setEmail);
		}else{
			setEmail = $(eid).html();
			val = 1;
		}
		if((!setEmail.match(emailRule))||setEmail.match(/\s/)||setEmail.length<=0){
			$('#mail_info_msg').html(top.str_err_mail);
			$('#mail_info').css('display','block');
			return false;
		}
	}
	$.post('/app/member/account/get_set_email.php',
		{
			'uid':myform.uid.value,
			'langx':myform.langx.value,
			'myVerify':myVerify,
			'setEmail':setEmail,
			'getEmail':val,
			'action':action
		},
		function (data) {
			var info = data.info;
			if(data.state == 1){
				var action = info.action;
				//console.log(action);
				$('#div_set_email').css('display','none');
				$('#div_set_verify').css('display','none');
				$('#div_set_done').css('display','none');
				$('#div_rm_done').css('display','none');
				switch (action){
					case 'init':
						$('#div_set_email').css('display','block');
						break;
					case 'getVerify':
						$('#div_set_verify').css('display','block');
						break;
					case 'chkVerify':
						$('#div_set_done').css('display','block');
						break;
					case 'remove':
						$('#div_rm_done').css('display','block');
						break;
				}
			}else{
				alert(data.msg);
				if(data.do_cancel){
					do_cancel(1);
				}
			}

		},
		'json');
}

function do_cancel(flag){
	parent.mail_forbid = false;
	if(flag == "2"){
		if(confirm(top["str_Quit_MailSet"])==true){
			if(is_set) onLoads();
			else parent.window.close();
			//var reg = new HttpRequest();
			//reg.addEventListener("LoadComplete",function(xml){parent.window.close();});
			//reg.loadURL("./set_email.php","POST",'uid='+myform.uid.value+'&action=clean_verify');
		}
	}else{
		if(is_set) onLoads();
		else parent.window.close();
	}
}


function changeDiv(divID){
	
	document.getElementById("setEmail").value = "";
	document.getElementById('myVerify').value = "";
	document.getElementById("err_info").style.display = "none";
	document.getElementById("mail_info").style.display = "none";
	document.body.focus();
	
	var allDiv = ["div_set_email","div_set_verify","div_set_done","div_rm_done"];
	for(var i=0; i<allDiv.length; i++){
		document.getElementById(allDiv[i]).style.display="none";
	}
	if(divID!="") try{document.getElementById(divID).style.display="";}catch(e){}
	parent.mail_forbid =(divID=="div_set_verify")?true:false;
	if(divID=="div_set_done") is_set = true;	
	if(divID=="div_rm_done"){
		document.body.onkeydown = function (e) {
					var evt = e || window.event; //IE does not pass the event object
			    var code = evt.keyCode ? evt.keyCode : evt.which;
			    if (code === 13 ) { //up key
			        document.getElementById("new_mail").click();
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
			if(_action == "getVerify"){
				do_submit(_action,"setEmail");
			}else{
				do_submit(_action);
			}
		}
}
