<!--
function chg_type(a,b,c){
	eval("top."+c+"_mem_index").body.location=a+"&league_id="+b;
}
function chg_index(a,b,c){
	eval("top."+c+"_mem_index").location=a+"&league_id="+b;
}

/* �y�{ SetRB ---> reloadRB --->  showLayer */

/*�u�y����--�N�ȱa�i�h�h�}��getrecRB.php�{��,�h������A���O�_���u�y�ɵ{*/

var record_RB = 0;
function reloadRB(gtype,uid){
	reloadPHP.location.href="./getrecRB.php?gtype="+gtype+"&uid="+uid;
}


/*�u�y����--�NgetrecRB.php�����G�a�i�h,�h�P�_�O�_record_RB�O�_�j��0,�p�G���|��ܺu�y�ϥ�*/

function showLayer(record_RB){
	if (record_RB > 0) {                                  
		                   
		document.getElementById('extra1').style.display='block'; 
	}else{			                                       
		                  
		document.getElementById('extra1').style.display='none';          
	}                                                                   
}


/* �u�y����--�{���@�}�l�ȩI�sreloadRb,setInterval�禡 �h�[�|�I�sreloadRB��ƹw�] 5���� */
 
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