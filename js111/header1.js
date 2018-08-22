<!--
function chg_type(a,b,c){
	eval("top."+c+"_mem_index").body.location=a+"&league_id="+b;
}
function chg_index(a,b,c){
	eval("top."+c+"_mem_index").location=a+"&league_id="+b;
}

/* 流程 SetRB ---> reloadRB --->  showLayer */

/*滾球提示--將值帶進去去開啟getrecRB.php程式,去抓取伺服器是否有滾球賽程*/

var record_RB = 0;
function reloadRB(gtype,uid){
	reloadPHP.location.href="./getrecRB.php?gtype="+gtype+"&uid="+uid;
}


/*滾球提示--將getrecRB.php的結果帶進去,去判斷是否record_RB是否大於0,如果有會顯示滾球圖示*/

function showLayer(record_RB){
	if (record_RB > 0) {                                  
		                   
		document.getElementById('extra1').style.display='block'; 
	}else{			                                       
		                  
		document.getElementById('extra1').style.display='none';          
	}                                                                   
}


/* 滾球提示--程式一開始值呼叫reloadRb,setInterval函式 多久會呼叫reloadRB函數預設 5分鐘 */
 
function SetRB(gttype,uid){
	reloadRB(gttype,top.uid);
	setInterval("reloadRB('"+gttype+"','"+top.uid+"')",5*60*1000);
}
function  getdomain(){
	var a = new Array();
	a[0]= document.domain;
	ESTime.setdomain(a);
	return a;
}
function OnMouseOverEvent() {
	document.getElementById("informaction").style.display = "block";
}
function OnMouseOutEvent() {
	document.getElementById("informaction").style.display = "none";
}

function Go_Chg_pass(){
	Real_Win=window.open("./account g_passwd.php?uid="+top.uid,"Chg_pass","width=360,height=166,status=no");
}

function OpenLive(){
	/*alert("top.liveid:"+top.liveid);
	if (top.liveid == undefined) {
		parent.self.location = "";
		return;
	}*/
	window.open("./live/live.php?langx="+top.langx+"&uid="+top.uid+"&liveid="+top.liveid,"Live","width=750,height=495,top=0,left=0,status=no,toolbar=no,scrollbars=no,resizable=no,personalbar=no");
}
--> 