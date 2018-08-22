function init(){
		if(top.mem_status=="S"){
				document.getElementById("result").style.display = "none";
				document.getElementById("result").onclick=null;
		}
		
		if(top.showKR=="Y"){
				document.getElementById("troubleshooting").style.display = "none";
				document.getElementById("troubleshooting").onclick=null;
		}
   	chgClickStatus(type);
}

function chgClickStatus(_type){
		//故障及疑難排解新開視窗	2016-05-16 William
		if(_type=="troubleshooting"){
			return;
		}
		var ary = new Array("history_data","today_wagers","mem_conf","set_email","chg_passwd","scroll_history","sport_rules","terms","result","tutorials","new_features","odds","contact_us","troubleshooting");
		for(var i=0; i<ary.length; i++){
				var obj = document.getElementById(ary[i]);
				util.setObjectClass(obj,"");
		}
		util.setObjectClass(document.getElementById(_type),"on");
}

function linkEvent(_id){
		if(parent.mail_forbid){
			if(confirm(top["str_Quit_MailSet"])==false){
				return false;
			}else{
				var reg = new parent.HttpRequest();
				reg.addEventListener("LoadComplete");
				reg.loadURL("./set_email.php","POST",'uid='+parent.opener.top.uid+'&action=clean_verify');
			}
		}
		parent.mail_forbid = false;
		chgClickStatus(_id);
		parent.goLink(_id);
}