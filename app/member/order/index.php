<?
include "../include/library.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/http.class.php");
$uid=$_REQUEST['uid'];
$hot_game=$_REQUEST['hot_game'];
$langx=$_REQUEST['langx'];
$mtype=$_REQUEST['mtype'];
include("../include/msg.inc.php");
$rtype=ltrim(strtolower($_REQUEST['rtype']));
$league_id=$_REQUEST['league_id'];

$sql = "select status,Memname from web_member where Oid='$uid' and Status>0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
	$memname=$row['Memname'];
////userlog($memname);
$status=$row['status'];
if($status==2)
{
	echo "此帐号以被暂停，请联系你的上级!";
	exit;
}


require ("../include/traditional.$langx.inc.php");
$leg_id	=	$_REQUEST['league_id'];
if(!in_array($rtype,array('hr','re','pd','hpd','t','f','p3','rpd','hrpd','rt','rf'))){$rtype='r';}
?>
<html>
<head>
<title>下注分割页面</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script> 
var show_ior = '100';
</script>

<script> 
var keepGameData=new Array();
var gidData=new Array();
parent.gamecount=0;
//判斷賠率是否變動
//包td
 
function checkRatio(rec,index){
 //alert(flash_ior_set);
	//return true;
	if (flash_ior_set =='Y'){
 
		if (""+keepGameData[rec]=="undefined"||keepGameData[rec]==""){
			keepGameData[rec]=new Array();
			keepGameData[rec][index]=GameFT[rec][index];
		}
		//判斷gid是否相同
		if (gidData[rec]!=GameFT[rec][0]||""+GameFT[rec][0]=="undefined"){
			keepGameData[rec]=new Array();
			gidData[rec]=new Array();
			keepGameData[rec][index]=GameFT[rec][index];
			gidData[rec][0]=GameFT[rec][0];
		}
 
		if (""+keepGameData[rec][index]=="undefined" ||keepGameData[rec][index]==""){
			keepGameData[rec][index]=GameFT[rec][index];
		}
		//alert("aaa==>"+keepGameData[rec][index]+"bbb==>"+GameFT[rec][index]);
		if (keepGameData[rec][index]!=GameFT[rec][index]&& keepGameData[rec][index] !=""&&GameFT[rec][index]!=""){
	    	//keepGameData[rec][index]=GameFT[rec][index];
	    	keepGameData[rec][index] = "";
	    	//keepGameData[rec]="";
			return " bgcolor=yellow ";
		}
		return true;
	}
}
//包font
function checkRatio_font(rec,index){
//alert(flash_ior_set);
	//return true;
	//alert(GameFT.length+"----"+keepGameData.length)
 
	if (flash_ior_set =='Y'){
		if (""+keepGameData[rec]=="undefined"||keepGameData[rec]==""){
			keepGameData[rec]=new Array();
			keepGameData[rec][index]=GameFT[rec][index];
		}
		//判斷gid是否相同
		if (gidData[rec]!=GameFT[rec][0]||""+GameFT[rec][0]=="undefined"){
			keepGameData[rec]=new Array();
			gidData[rec]=new Array();
			keepGameData[rec][index]=GameFT[rec][index];
			gidData[rec][0]=GameFT[rec][0];
		}
		if (""+keepGameData[rec][index]=="undefined"||keepGameData[rec][index] ==""){
			keepGameData[rec][index]=GameFT[rec][index];
		}
 
		//alert("ccc==>"+keepGameData[rec][index]+"ddd==>"+GameFT[rec][index]);
		if (keepGameData[rec][index]!=GameFT[rec][index] && keepGameData[rec][index] !=""&&GameFT[rec][index]!="") {
	    	//keepGameData[rec][index]=GameFT[rec][index];
	    	keepGameData[rec][index] = "";
	    	//keepGameData[rec]="";
			return '  style=\"background-color : yellow\" ';
		}
		return true;
	}
}
function gethighlight(){
	return " style=\"color:red\" style=\"font-weight:bolder\" ";
}
//滑鼠移動帶出索引
//function showMsg(msg, type) {
//	var showHelpMsg = body_browse.document.getElementById("showHelpMsg");
////	var showHelpMsg = parent.body_browse.document.getElementById('showHelpMsg');
//	var helpMsg = body_browse.document.getElementById('helpMsg').innerHTML;
//	var tmpHTML = "";
//	if(type == 1) {
//		tmpHTML = helpMsg;
//		tmpHTML = tmpHTML.replace("*SHOWMSG*", msg);
//		showHelpMsg.innerHTML = tmpHTML;
//		showHelpMsg.style.display = "block";
//		showHelpMsg.style.top = body_browse.document.body.scrollTop+body_browse.event.clientY-10;
//		showHelpMsg.style.left = body_browse.document.body.scrollLeft+body_browse.event.clientX+10;
//	} else showHelpMsg.style.display = "none";
//}
 
//====== 加入現場轉播功能 2009-04-09
// 開啟轉播
function OpenLive(eventid, gtype){
	if (top.liveid == undefined) {
		parent.self.location = "";
		return;
	}
	var eventlive="Y";
	//關閉主視窗 連子視窗一起關閉
	 var newWinObj2=new Array();
	 for(var i=0;i<top.newWinObj.length;i++){
	  if(!top.newWinObj[i].closed) newWinObj2[newWinObj2.length]=top.newWinObj[i];
	 }
	 top.newWinObj=newWinObj2;
 
	 var DWinObj= window.open("../live/live.php?langx="+top.langx+"&uid="+top.uid+"&liveid="+top.liveid+"&eventid="+eventid+"&eventlive="+eventlive+"&gtype="+gtype,"Live","width=780,height=585,top=0,left=0,status=no,toolbar=no,scrollbars=no,resizable=no,personalbar=no");
	 top.newWinObj[top.newWinObj.length]=DWinObj;
}
 
function VideoFun(eventid, hot, play, gtype) {
	var tmpStr = "";
	//play="Y";
	if (play == "Y") {
		//tmpStr+= "<img lowsrc=\"/images/member/video_1.gif\" onClick=\"parent.OpenLive('"+eventid+"','"+gtype+"')\" style=\"cursor:hand\">";
		tmpStr= "<span ><div style=\"cursor:hand\" class=\"tv_icon_on\" onClick=\"parent.OpenLive('"+eventid+"','"+gtype+"')\"></div></span>";
	} else {
		//tmpStr+= "<img lowsrc=\"/images/member/video_2.gif\">";
		tmpStr= "<span ><div  class=\"tv_icon_out\"></div></span>";
	}
	return tmpStr;
}
 
function MM_ShowLoveI(gid,getDateTime,getLid,team_h,team_c){
	var txtout="";
	//if(!top.swShowLoveI){
		//alert(chkRepeat(gid));
		if(!chkRepeat(gid,getDateTime)){	
			//txtout = "<span id='sp_"+MM_imgId(getDateTime,gid)+"'><img id='"+MM_imgId(getDateTime,gid)+"' lowsrc=\"/images/member/icon_X2.gif\" vspace=\"0\" style=\"cursor:hand;display:none;\" title=\""+top.str_ShowMyFavorite+"\" onClick=\"addShowLoveI('"+gid+"','"+getDateTime+"','"+getLid+"','"+team_h+"','"+team_c+"'); \"></span>";
			txtout = "<span id='sp_"+MM_imgId(getDateTime,gid)+"'><div id='"+MM_imgId(getDateTime,gid)+"' class=\"fov_icon_out\" style=\"cursor:hand;display:none;\" title=\""+top.str_ShowMyFavorite+"\" onClick=\"addShowLoveI('"+gid+"','"+getDateTime+"','"+getLid+"','"+team_h+"','"+team_c+"'); \"></div></span>";
		}else{
			//txtout = "<span id='sp_"+MM_imgId(getDateTime,gid)+"'><img lowsrc=\"/images/member/love_small.gif\" style=\"cursor:hand\" title=\""+top.str_delShowLoveI+"\" onClick=\"chkDelshowLoveI('"+getDateTime+"','"+gid+"'); \"></span>";
			txtout = "<span id='sp_"+MM_imgId(getDateTime,gid)+"'><div class=\"fov_icon_on\" style=\"cursor:hand\" title=\""+top.str_delShowLoveI+"\" onClick=\"chkDelshowLoveI('"+getDateTime+"','"+gid+"'); \"></div></span>";
		}
	//}else{
		//txtout = "<img lowsrc=\"/images/member/love_small.gif\" style=\"cursor:hand\" title=\""+top.str_delShowLoveI+"\" onClick=\"chkDelshowLoveI('"+getDateTime+"','"+gid+"'); \">";
		//txtout = "<div class=\"fov_icon_on\" style=\"cursor:hand\" title=\""+top.str_delShowLoveI+"\" onClick=\"chkDelshowLoveI('"+getDateTime+"','"+gid+"'); \"></div>";
	//}
	return txtout;
}
 
function chkRepeat(gid,getDateTime){
	var getGtype =getGtypeShowLoveI();
	var sw =false;
	for (var i=0 ; i < top.ShowLoveIarray[getGtype].length ; i++){
		if(top.ShowLoveIarray[getGtype][i][0]==gid && top.ShowLoveIarray[getGtype][i][1] == getDateTime)
			sw =true;
	}
	return sw;
}
 
function MM_IdentificationDisplay(time,gid){
	var getGtype = getGtypeShowLoveI();
	var txt_array = top.ShowLoveIOKarray[getGtype];
	if(top.swShowLoveI){
		var tmp = time.split("<br>")[0];
		if(txt_array.length==0)return true;
		if(txt_array.indexOf(tmp+gid +",",0)== -1)
			return true;
	}
}
function getGtypeShowLoveI(){
	var Gtype;
	var getGtype =sel_gtype;
	var getRtype =rtype;
	Gtype =getGtype;
	if(getRtype=="re"){
		Gtype +="RE";
	}
	/*
	if(getGtype =="FU"||getGtype=="FT"){
		Gtype ="FT";
	}else if(getGtype =="OM"||getGtype=="OP"){
		Gtype ="OP";
	}else if(getGtype =="BU"||getGtype=="BK"){
		Gtype ="BK";
	}else if(getGtype =="BSFU"||getGtype=="BS"){
		Gtype ="BS";
	}else if(getGtype =="VU"||getGtype=="VB"){
		Gtype ="VB";
	}else if(getGtype =="TU"||getGtype=="TN"){
		Gtype ="TN";
	}else {
		Gtype ="FT";
	}
	*/
	
	//alert("in==>"+parent.sel_gtype+",out==>"+Gtype);
	return Gtype;
}
function MM_imgId(time,gid){	
	var tmp = time.split("<br>")[0];
	//alert("tmp===>"+tmp+"==="+"gid===>"+gid+"===");
	return tmp+gid;
}
 
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8 "><script>
 
/**
 * 選擇多盤口時 轉換成該選擇賠率
 * @param odd_type 	選擇盤口
 * @param iorH		主賠率
 * @param iorC		客賠率
 * @param show		顯示位數
 * @return		回傳陣列 0-->H  ,1-->C
 */
function  get_other_ioratio(odd_type, iorH, iorC , showior){
	var out=new Array();
	if(iorH!="" ||iorC!=""){
		out =chg_ior(odd_type,iorH,iorC,showior);
	}else{
		out[0]=iorH;
		out[1]=iorC;
	}
	return out;
}
/**
 * 轉換賠率
 * @param odd_f
 * @param H_ratio
 * @param C_ratio
 * @param showior
 * @return
 */
function chg_ior(odd_f,iorH,iorC,showior){
	//console.log("1. "+odd_f+"<>"+iorH+"<>"+iorC+"<>"+showior);
	iorH = Math.floor((iorH*1000)+0.001) / 1000;
	iorC = Math.floor((iorC*1000)+0.001) / 1000;
	
	var ior=new Array();
	if(iorH < 11) iorH *=1000;
	if(iorC < 11) iorC *=1000;
	iorH=parseFloat(iorH);
	iorC=parseFloat(iorC);
	switch(odd_f){
	case "H":	//香港變盤(輸水盤)
		ior = get_HK_ior(iorH,iorC);
		break;
	case "M":	//馬來盤
		ior = get_MA_ior(iorH,iorC);
		break;
	case "I" :	//印尼盤
		ior = get_IND_ior(iorH,iorC);
		break;
	case "E":	//歐洲盤
		ior = get_EU_ior(iorH,iorC);
		break;
	default:	//香港盤
		ior[0]=iorH ;
		ior[1]=iorC ;
	}
	ior[0]/=1000;
	ior[1]/=1000;
//	alert(ior[0]+'---'+ior[1]);
	ior[0]=printf(Decimal_point(ior[0],showior),iorpoints);
	ior[1]=printf(Decimal_point(ior[1],showior),iorpoints);
	//alert("odd_f="+odd_f+",iorH="+iorH+",iorC="+iorC+",ouH="+ior[0]+",ouC="+ior[1]);
	return ior;
}
 
/**
 * 換算成輸水盤賠率
 * @param H_ratio
 * @param C_ratio
 * @return
 */
function get_HK_ior( H_ratio, C_ratio){
	var out_ior=new Array();
	var line,lowRatio,nowRatio,highRatio;
	var nowType="";
	if (H_ratio <= 1000 && C_ratio <= 1000){
		out_ior[0]=H_ratio;
		out_ior[1]=C_ratio;
		return out_ior;
	}
	line=2000 - ( H_ratio + C_ratio );
	
	if (H_ratio > C_ratio){ 
		lowRatio=C_ratio;
		nowType = "C";
	}else{
		lowRatio = H_ratio;
		nowType = "H";
	}
	if (((2000 - line) - lowRatio) > 1000){
		//對盤馬來盤
		nowRatio = (lowRatio + line) * (-1);
	}else{
		//對盤香港盤
		nowRatio=(2000 - line) - lowRatio;	
	}
	
	if (nowRatio < 0){
		highRatio = Math.floor(Math.abs(1000 / nowRatio) * 1000) ;
	}else{
		highRatio = (2000 - line - nowRatio) ;
	}
	if (nowType == "H"){
		out_ior[0]=lowRatio;
		out_ior[1]=highRatio;
	}else{
		out_ior[0]=highRatio;
		out_ior[1]=lowRatio;
	}
	return out_ior;
}
/**
 * 換算成馬來盤賠率
 * @param H_ratio
 * @param C_ratio
 * @return
 */
function get_MA_ior( H_ratio, C_ratio){
	var out_ior=new Array();
	var line,lowRatio,highRatio;
	var nowType="";
	if ((H_ratio <= 1000 && C_ratio <= 1000)){
		out_ior[0]=H_ratio;
		out_ior[1]=C_ratio;
		return out_ior;
	}
	line=2000 - ( H_ratio + C_ratio );
	if (H_ratio > C_ratio){ 
		lowRatio = C_ratio;
		nowType = "C";
	}else{
		lowRatio = H_ratio;
		nowType = "H";
	}
	highRatio = (lowRatio + line) * (-1);
	if (nowType == "H"){
		out_ior[0]=lowRatio;
		out_ior[1]=highRatio;
	}else{
		out_ior[0]=highRatio;
		out_ior[1]=lowRatio;
	}
	return out_ior;
}
/**
 * 換算成印尼盤賠率
 * @param H_ratio
 * @param C_ratio
 * @return
 */
function get_IND_ior( H_ratio, C_ratio){
	var out_ior=new Array();
	out_ior = get_HK_ior(H_ratio,C_ratio);
	H_ratio=out_ior[0];
	C_ratio=out_ior[1];
	H_ratio /= 1000;
	C_ratio /= 1000;
	if(H_ratio < 1){
		H_ratio=(-1) / H_ratio;
	}
	if(C_ratio < 1){
		C_ratio=(-1) / C_ratio;
	}
	out_ior[0]=H_ratio*1000;
	out_ior[1]=C_ratio*1000;
	return out_ior;
}
/**
 * 換算成歐洲盤賠率
 * @param H_ratio
 * @param C_ratio
 * @return
 */
function get_EU_ior(H_ratio, C_ratio){
	var out_ior=new Array();
	out_ior = get_HK_ior(H_ratio,C_ratio);
	H_ratio=out_ior[0];
	C_ratio=out_ior[1];       
	out_ior[0]=H_ratio+1000;
	out_ior[1]=C_ratio+1000;
	return out_ior;
}
/*
去正負號做小數第幾位捨去
進來的值是小數值
*/
function Decimal_point(tmpior,show){
	var sign="";
	sign =((tmpior < 0)?"Y":"N");
	tmpior = (Math.floor(Math.abs(tmpior) * show + 1 / show )) / show;
	return (tmpior * ((sign =="Y")? -1:1)) ;
}
 
 
/*
 公用 FUNC
*/
function printf(vals,points){ //小數點位數
	vals=""+vals;
	var cmd=new Array();
	cmd=vals.split(".");
	if (cmd.length>1){
		for (ii=0;ii<(points-cmd[1].length);ii++)vals=vals+"0";
	}else{
		vals=vals+".";
		for (ii=0;ii<points;ii++)vals=vals+"0";
	}
	return vals;
}</script>
<script>
<?
switch($rtype){
case 'r':
?>

var ObjDataFT=new Array();
var oldObjDataFT=new Array();
//var GameHead=new Array("gid","datetime","league","gnum_h","gnum_c","team_h","team_c","strong","ratio","ior_RH","ior_RC","ratio_o","ratio_u","ior_OUH","ior_OUC","ior_MH","ior_MC","ior_MN","str_odd","str_even","ior_EOO","ior_EOE","hgid","hstrong","hratio","ior_HRH","ior_HRC","hratio_o","hratio_u","ior_HOUH","ior_HOUC","ior_HMH","ior_HMC","ior_HMN","more","eventid","hot","play");
var keepleg="";
var legnum=0;
var NoshowLeg=new Array();
var myLeg=new Array();
var LeagueAry=new Array();
var keepscroll=0;
var step=1;
function ShowGameList(){
	reTimeNow = retime;
	
	if(""+top.hot_game=="undefined"){
		top.hot_game="";
	}	
	try{
	start_time=body_browse.get_timer();
	}catch(E){}	
	if(loading == 'Y') return;
	if (parent.gamecount!=gamount){
		oldObjDataFT=new Array();
	}
	if(top.odd_f_type==""||""+top.odd_f_type=="undefined") top.odd_f_type="H";
	
	
		
	keepscroll=body_browse.document.body.scrollTop;
	
 
	var conscroll= body_browse.document.getElementById('controlscroll');
	/*
	if (conscroll.style.display!=""){
		conscroll.style.display="";
		step=step*-1;
		//alert(conscroll.style.top);
		
		conscroll.style.top = keepscroll+step;
		//conscroll.style.width=800;
		//conscroll.style.Height=600;
		conscroll.focus();
}
*/
		//conscroll.blur();
		//conscroll.style.top=parseInt(conscroll.style.top)-1;
	dis_ShowLoveI();
	
	//秀盤面
	showtables(GameFT,GameHead,gamount,top.odd_f_type);
  //conscroll.style.top=top.keepscroll;
	//conscroll.focus();
	
	body_browse.scroll(0,keepscroll);
	
	//設定右方重新整理位置
	setRefreshPos();
 
	//顯示盤口
	body_browse.ChkOddfDiv();
	//跑馬燈
//	obj_msg = body_browse.document.getElementById('real_msg');
//	obj_msg.innerHTML = '<marquee scrolldelay=\"300\">'+msg+'</marquee>';
	
	//更新秒數
	//只有 讓分/走地 才有更新時間
	//hr_info = body_browse.document.getElementById('hr_info');
	//if(retime){
	//	hr_info.innerHTML = retime+str_renew;
	//}else{
	//	hr_info.innerHTML = str_renew;
	//}
	
	parent.gamecount=gamount;
	//日期下拉霸
	
	if (sel_gtype=="FU"){
		if (""+body_browse.document.getElementById('g_date')!="undefined"){
			body_browse.selgdate("r",g_date);
			body_browse.document.getElementById('g_date').value=g_date;
		}
	}
	
	if (top.hot_game!=""){
		body_browse.document.getElementById('sel_league').style.display='none';
		show_page();
 	}else{	
 			
		if(top.showtype=='hgft'||top.showtype=='hgfu'){
			obj_sel = body_browse.document.getElementById('sel_league');
			obj_sel.style.display='none';
			try{
				var obj_date='';
				obj_date=body_browse.document.getElementById("g_date").value;
				body_browse.selgdate("",obj_date);
			}catch(E){}
		}else{
			show_page();
	  }
	}
 
	conscroll.style.display="none";
	coun_Leagues();
	body_browse.showPicLove();
	loadingOK();
	showHOT(gameCount);
	try{
		body_browse.document.getElementById('show_run_time').innerHTML="time:"+((body_browse.get_timer()-start_time)/1000)+"s";
	}catch(E){}
	keep_show_more(show_more_gid,ObjDataFT,gamount);
}
var hotgdateArr =new Array();
function hot_gdate(gdate){
	if((""+hotgdateArr).indexOf(gdate)==-1){
		hotgdateArr.push(gdate);
	}
}
function coun_Leagues(){
	var coun=0;
	var str_tmp ="|"+eval('parent.'+sel_gtype+'_lname_ary');
	if(str_tmp=='|ALL'){
		body_browse.document.getElementById("str_num").innerHTML =top.alldata;
	}else{
		var larray=str_tmp.split('|');
		for(var i =0;i<larray.length;i++){
			if(larray[i]!=""){coun++}
		}
		//alert(coun+"---"+LeagueAry.length);
		coun =LeagueAry.length;
		
		body_browse.document.getElementById("str_num").innerHTML =coun;
	}
	
	
}
//------單式顯示------
//function ShowData_OU(obj_table,GameData,data_amount,odd_f_type){
	//showtables();
//}
 
//var GameFT=new Array();
 
 
//表格函數
function showtables(GameData,Game_Head,data_amount,odd_f_type){
//	var conscroll= body_browse.document.getElementById('controlscroll');
 
	//var conscroll= document.getElementById('controlscroll');
//	conscroll.style.display="block";
//	conscroll.top=keepscroll;

	//alert("kkkk");
	
	
	
	ObjDataFT=new Array();
	myLeg=new Array();
	for (var j=0;j < data_amount;j++){
		if (GameData[j]!=null){
			ObjDataFT[j]=parseArray(Game_Head,GameData[j]);
		}
	}
	//alert("ObjDataFT===>"+ObjDataFT.length);
	var trdata;//=body_browse.document.getElementById('DataTR').innerHTML;
	var showtableData;
	if(body_browse.document.all){
	     	showtableData=body_browse.document.getElementById('showtableData').innerText ;
	     	trdata=body_browse.document.getElementById('DataTR').innerText;
	     	notrdata=body_browse.document.getElementById('NoDataTR').innerText;
	} else{
     		showtableData=body_browse.document.getElementById('showtableData').textContent ;
     	 	trdata=body_browse.document.getElementById('DataTR').textContent;
			notrdata=body_browse.document.getElementById('NoDataTR').textContent;
	}
	//alert(trdata);
	var showtable=body_browse.document.getElementById('showtable');
	var showlayers="";
	keepleg="";
	legnum=0;
	LeagueAry =new Array();
	var chk_Love_I=new Array();
	if(ObjDataFT.length > 0){
	  	for ( i=0 ;i < ObjDataFT.length;i++){
	  		tmp_Str=getLayer(trdata,i,odd_f_type);
	  		showlayers+=tmp_Str;
	  		if (top.swShowLoveI&&tmp_Str!=""){
	  			chk_Love_I.push(ObjDataFT[i]);	
	  		}
	  	}
	  
	  	if(showlayers=="")showlayers=notrdata;
	  	showtableData=showtableData.replace("*showDataTR*",showlayers);
	}else{
	    showtableData=showtableData.replace("*showDataTR*",notrdata);
	  
	}
 
	if (top.head_FU=="FT"){ 	
	  	if (top.hot_game==""){
	  		  if(top.swShowLoveI){
	  					body_browse.checkLoveCount(chk_Love_I);	
	  			}		
	  	}
	}
	
	showtable.innerHTML=showtableData;
	
	//----------leg圖--------
 
}
 
//表格內容
function getLayer(onelayer,gamerec,odd_f_type){
	var open_hot = false;
	if (top.hot_game==""){
		if(MM_IdentificationDisplay(ObjDataFT[gamerec].datetime,ObjDataFT[gamerec].gnum_h)) return "";
	}
	//如果有選我的最愛,選擇聯盟不判斷
	//alert(top.swShowLoveI)
	if (!top.swShowLoveI){
		if (top.hot_game==""){
			if(("|"+eval('parent.'+sel_gtype+'_lname_ary')).indexOf(("|"+ObjDataFT[gamerec].league+"|"),0)==-1&&eval('parent.'+sel_gtype+'_lname_ary')!='ALL') return "";
			if((""+LeagueAry).indexOf(ObjDataFT[gamerec].league)== -1)LeagueAry.push(ObjDataFT[gamerec].league);
		}
	}
	var tmp_date = ObjDataFT[gamerec].datetime.split("<br>")[0];
	onelayer=onelayer.replace(/\*ID_STR\*/g,tmp_date+ObjDataFT[gamerec].gnum_h);
	onelayer=onelayer.replace(/\*TR_EVENT\*/g,"onMouseOver='mouseEnter_pointer(this.id);' onMouseOut='mouseOut_pointer(this.id);'");
	//alert(ObjDataFT[gamerec].league+"==="+keepleg+"["+(ObjDataFT[gamerec].league==keepleg)+"]")
	
	if (""+myLeg[ObjDataFT[gamerec].league]=="undefined"){
		myLeg[ObjDataFT[gamerec].league]=ObjDataFT[gamerec].league;
		myLeg[ObjDataFT[gamerec].league]=new Array();
		myLeg[ObjDataFT[gamerec].league][0]=tmp_date+ObjDataFT[gamerec].gnum_h;
	}else{
		myLeg[ObjDataFT[gamerec].league][myLeg[ObjDataFT[gamerec].league].length]=tmp_date+ObjDataFT[gamerec].gnum_h;
	}
 
	//--------------判斷聯盟名稱列顯示或隱藏----------------
	if (ObjDataFT[gamerec].league==keepleg){
			onelayer=onelayer.replace("*ST*"," style='display: none;'");
	}else{
			onelayer=onelayer.replace("*ST*"," style='display: ;'");
	}
	//---------------------------------------------------------------------
	//--------------判斷聯盟底下的賽事顯示或隱藏----------------
	if (NoshowLeg[ObjDataFT[gamerec].league]==-1){
		onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: none;'");
		onelayer=onelayer.replace("*LegMark*","<span id='LegClose'></span>"); //聯盟的小圖
	}else{
		onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: ;'");
		onelayer=onelayer.replace("*LegMark*","<span id='LegOpen'></span>");  //聯盟的小圖
	}
	//---------------------------------------------------------------------
	
	var R_ior =Array();
	var OU_ior =Array();
	var HR_ior =Array();
	var HOU_ior =Array();
	var EO_ior =Array();
	R_ior  = get_other_ioratio(odd_f_type, ObjDataFT[gamerec].ior_RH   , ObjDataFT[gamerec].ior_RC   , show_ior);
	OU_ior = get_other_ioratio(odd_f_type, ObjDataFT[gamerec].ior_OUH  , ObjDataFT[gamerec].ior_OUC  , show_ior);
	HR_ior = get_other_ioratio(odd_f_type, ObjDataFT[gamerec].ior_HRH  , ObjDataFT[gamerec].ior_HRC  , show_ior);
	HOU_ior= get_other_ioratio(odd_f_type, ObjDataFT[gamerec].ior_HOUH , ObjDataFT[gamerec].ior_HOUC , show_ior);
	
	if((ObjDataFT[gamerec].ior_EOO != 0) && (ObjDataFT[gamerec].ior_EOE != 0)){
		EO_ior= get_other_ioratio("H", ObjDataFT[gamerec].ior_EOO*1-1 , ObjDataFT[gamerec].ior_EOE*1-1 , show_ior);
		ObjDataFT[gamerec].ior_EOO=EO_ior[0]*1+1;
		ObjDataFT[gamerec].ior_EOE=EO_ior[1]*1+1;
	}
	
	ObjDataFT[gamerec].ior_RH=R_ior[0];
	ObjDataFT[gamerec].ior_RC=R_ior[1];
	ObjDataFT[gamerec].ior_OUH=OU_ior[0];
	ObjDataFT[gamerec].ior_OUC=OU_ior[1];
	ObjDataFT[gamerec].ior_HRH=HR_ior[0];
	ObjDataFT[gamerec].ior_HRC=HR_ior[1];
	ObjDataFT[gamerec].ior_HOUH=HOU_ior[0];
	ObjDataFT[gamerec].ior_HOUC=HOU_ior[1];
 
	//滾球字眼
	ObjDataFT[gamerec].datetime=ObjDataFT[gamerec].datetime.replace("Running Ball",top.str_RB);
	keepleg=ObjDataFT[gamerec].league;
	onelayer=onelayer.replace(/\*LEG\*/gi,ObjDataFT[gamerec].league);
	
		//onelayer=onelayer.replace(/\*LEGM\*/gi,(ObjDataFT[gamerec].league+myLeg[ObjDataFT[gamerec].league].length));
//	onelayer=onelayer.replace(/\*LegID\*/g,"LEG_"+legnum);
	var tmp_date=ObjDataFT[gamerec].datetime.split("<br>");
	if (sel_gtype=="FU"){
		tmp_date_str=tmp_date[0]+"<br>"+change_time(tmp_date[1]);
	}else{
		tmp_date_str=change_time(tmp_date[1]);
	}
	if (tmp_date.length==3){
		tmp_date_str+="<br>"+tmp_date[2];
	}
	
	//ObjDataFT[gamerec].team_h=ObjDataFT[gamerec].team_h.replace("[Mid]","<font color=\"#005aff\">N</font>");
	onelayer=onelayer.replace("*DATETIME*",tmp_date_str);
	onelayer=onelayer.replace("*TEAM_H*",ObjDataFT[gamerec].team_h.replace("[Mid]","<font color=\"#005aff\">[N]</font>").replace("[中]","<font color=\"#005aff\">[中]</font>").replace("#FFFF99",""));
	onelayer=onelayer.replace("*TEAM_C*",ObjDataFT[gamerec].team_c.replace("#FFFF99",""));
	//全場
	//獨贏
	if ((ObjDataFT[gamerec].ior_MH*1 > 0) && (ObjDataFT[gamerec].ior_MC*1 > 0)){
		onelayer=onelayer.replace("*RATIO_MH*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"M"));
		onelayer=onelayer.replace("*RATIO_MC*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"M"));
		if ((ObjDataFT[gamerec].ior_MN*1) > 0){
			onelayer=onelayer.replace("*RATIO_MN*",parseUrl(uid,odd_f_type,"N",ObjDataFT[gamerec],gamerec,"M"));
		}else{
			onelayer=onelayer.replace("*RATIO_MN*","&nbsp;");
		}
	}else{
		onelayer=onelayer.replace("*RATIO_MH*","&nbsp;");
		onelayer=onelayer.replace("*RATIO_MC*","&nbsp;");
		onelayer=onelayer.replace("*RATIO_MN*","&nbsp;");
	}
	//讓球
	if (ObjDataFT[gamerec].strong=="H"){
		onelayer=onelayer.replace("*CON_RH*",ObjDataFT[gamerec].ratio);	/*讓球球頭*/
		onelayer=onelayer.replace("*CON_RC*","");
	}else{
		onelayer=onelayer.replace("*CON_RH*","");
		onelayer=onelayer.replace("*CON_RC*",ObjDataFT[gamerec].ratio);
	}
	
	
	//onelayer=onelayer.replace("*TD_RH_CLASS*",check_ioratio(gamerec,"ior_RH",ObjDataFT[gamerec]));/*讓球sytle*/
	//onelayer=onelayer.replace("*TD_RH_CLASS*","class='b_rig'");/*讓球sytle*/
	
	onelayer=onelayer.replace("*RATIO_RH*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"R"));/*讓球賠率*/
	onelayer=onelayer.replace("*RATIO_RC*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"R"));
	//大小
	if (top.langx=="en-us"){
		onelayer=onelayer.replace("*CON_OUH*",ObjDataFT[gamerec].ratio_o.replace("O","o") );	/*大小球頭*/
		onelayer=onelayer.replace("*CON_OUC*",ObjDataFT[gamerec].ratio_u.replace("U","u") );
	}else{
		onelayer=onelayer.replace("*CON_OUH*",ObjDataFT[gamerec].ratio_o.replace("O",top.strOver));	/*大小球頭*/
		onelayer=onelayer.replace("*CON_OUC*",ObjDataFT[gamerec].ratio_u.replace("U",top.strUnder));
	}
	onelayer=onelayer.replace("*RATIO_OUH*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"OU"));/*大小賠率*/
	onelayer=onelayer.replace("*RATIO_OUC*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"OU"));
	//單雙
	if (top.langx=="en-us"){

	onelayer=onelayer.replace("*RATIO_EOO*",ObjDataFT[gamerec].str_odd+parseUrl(uid,odd_f_type,"O",ObjDataFT[gamerec],gamerec,"EO"));
  	onelayer=onelayer.replace("*RATIO_EOE*",ObjDataFT[gamerec].str_even+parseUrl(uid,odd_f_type,"E",ObjDataFT[gamerec],gamerec,"EO"));
	}else{
	onelayer=onelayer.replace("*RATIO_EOO*",ObjDataFT[gamerec].str_odd+parseUrl(uid,odd_f_type,"O",ObjDataFT[gamerec],gamerec,"EO"));
  	onelayer=onelayer.replace("*RATIO_EOE*",ObjDataFT[gamerec].str_even+parseUrl(uid,odd_f_type,"E",ObjDataFT[gamerec],gamerec,"EO"));	
		}
	//上半場
	//獨贏
	if ((ObjDataFT[gamerec].ior_HMH*1 > 0) && (ObjDataFT[gamerec].ior_HMC*1 > 0)){
		onelayer=onelayer.replace("*RATIO_HMH*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"HM"));
		onelayer=onelayer.replace("*RATIO_HMC*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"HM"));
		if ((ObjDataFT[gamerec].ior_HMN*1) > 0){
			onelayer=onelayer.replace("*RATIO_HMN*",parseUrl(uid,odd_f_type,"N",ObjDataFT[gamerec],gamerec,"HM"));
		}else{
			onelayer=onelayer.replace("*RATIO_HMN*","&nbsp;");
		}
	}else{
		onelayer=onelayer.replace("*RATIO_HMH*","&nbsp;");
		onelayer=onelayer.replace("*RATIO_HMC*","&nbsp;");
		onelayer=onelayer.replace("*RATIO_HMN*","&nbsp;");
		}
		
 
	//讓球
	if (ObjDataFT[gamerec].hstrong=="H"){
		onelayer=onelayer.replace("*CON_HRH*",ObjDataFT[gamerec].hratio);	/*讓球球頭*/
		onelayer=onelayer.replace("*CON_HRC*","");
	}else{
		onelayer=onelayer.replace("*CON_HRH*","");
		onelayer=onelayer.replace("*CON_HRC*",ObjDataFT[gamerec].hratio);
	}
	onelayer=onelayer.replace("*RATIO_HRH*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"HR"));/*讓球賠率*/
	onelayer=onelayer.replace("*RATIO_HRC*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"HR"));
	//大小
	if (top.langx=="en-us"){
		onelayer=onelayer.replace("*CON_HOUH*",ObjDataFT[gamerec].hratio_o.replace("O","o") );	/*大小球頭*/
		onelayer=onelayer.replace("*CON_HOUC*",ObjDataFT[gamerec].hratio_u.replace("U","u") );
	}else{
		onelayer=onelayer.replace("*CON_HOUH*",ObjDataFT[gamerec].hratio_o.replace("O",top.strOver));	/*大小球頭*/
		onelayer=onelayer.replace("*CON_HOUC*",ObjDataFT[gamerec].hratio_u.replace("U",top.strUnder));
	}
	onelayer=onelayer.replace("*RATIO_HOUH*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"HOU"));/*大小賠率*/
	onelayer=onelayer.replace("*RATIO_HOUC*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"HOU"));
	//onelayer=onelayer.replace("*MORE*",parsemore(ObjDataFT[gamerec],game_more));
	onelayer=onelayer.replace("*MORE*",parseAllBets(ObjDataFT[gamerec],game_more));  //2014.03足球多玩法 by Leslie
	//我的最愛
	onelayer=onelayer.replace("*MYLOVE*",parseMyLove(ObjDataFT[gamerec]));
/*
	if (ObjDataFT[gamerec].play=="Y"){
			onelayer=onelayer.replace("*TV_ST*","style='display:block;'");
		
		}else{
				onelayer=onelayer.replace("*TV_ST*","style='display:none;'");
			}
 
*/
		if (ObjDataFT[gamerec].eventid != "" && ObjDataFT[gamerec].eventid != "null" && ObjDataFT[gamerec].eventid != undefined) {	//判斷是否有轉播
			tmpStr= VideoFun(ObjDataFT[gamerec].eventid, ObjDataFT[gamerec].hot, ObjDataFT[gamerec].play, "FT");
			//alert(tmpStr);
			onelayer=onelayer.replace("*TV*",tmpStr);
		}
		onelayer=onelayer.replace("*TV*","");
	
	//alert(onelayer);
	return onelayer;
}
 
//----------------------
//取得下注的url
function parseUrl(uid,odd_f_type,betTeam,GameData,gamerec,wtype){
	var urlArray=new Array();
	urlArray['R']=new Array("../FT_order/FT_order_r.php",eval("GameData.team_"+betTeam.toLowerCase()));
	urlArray['HR']=new Array("../FT_order/FT_order_hr.php",eval("GameData.team_"+betTeam.toLowerCase()));
	urlArray['OU']=new Array("../FT_order/FT_order_ou.php",(betTeam=="C" ? top.strOver : top.strUnder));
	urlArray['HOU']=new Array("../FT_order/FT_order_hou.php",(betTeam=="C" ? top.strOver : top.strUnder));
	urlArray['M']=new Array("../FT_order/FT_order_m.php",(betTeam=="N" ? top.str_irish_kiss : eval("GameData.team_"+betTeam.toLowerCase())));
	urlArray['HM']=new Array("../FT_order/FT_order_hm.php",(betTeam=="N" ? top.str_irish_kiss : eval("GameData.team_"+betTeam.toLowerCase())));
	urlArray['EO']=new Array("../FT_order/FT_order_t.php", (betTeam=="O"  ? top.str_o : top.str_e));
 
	var param=getParam(uid,odd_f_type,betTeam,wtype,GameData);
	var order=urlArray[wtype][0];
	
	var team=urlArray[wtype][1].replace("[Mid]","[N]").replace("<font style=background-color:#FFFF99>","").replace("</font>","");
	
	var tmp_rtype="ior_"+wtype+betTeam;
	var ioratio_str="GameData."+tmp_rtype;
	
	var ioratio=eval(ioratio_str);
	
 
	if(eval(ioratio_str)!=""){
	ioratio=Mathfloor(ioratio);
	ioratio=printf(ioratio,2);
}
 
 
//20121023 max新增 輸水盤 負值顯示藍色
	if (odd_f_type=="M" || odd_f_type=="I"){
		if (ioratio<0) ioratio="<font color=#1f497d>"+ioratio+"</font>";
	
		}
	
 
 
 	//var ret="<a href='"+order+"?"+param+"' target='mem_order' title='"+team+"'><font "+check_ioratio(gamerec,tmp_rtype,GameData)+">"+ioratio+"</font></a>";
	//alert(parent.name)
	var ret="<a href='javascript://' onclick=\"parent.parent.mem_order.betOrder('FT','"+wtype+"','"+param+"');\" title='"+team+"'><font "+check_ioratio(gamerec,tmp_rtype,GameData)+">"+ioratio+"</font></a>";
	
	return ret;
	
}
	function Mathfloor(z){
	 var tmp_z;
	 tmp_z=(Math.floor(z*100+0.01))/100;
 	return tmp_z;
}
 
//--------------------------public function --------------------------------
 
//取得下注參數
function getParam(uid,odd_f_type,betTeam,wtype,GameData){
	var paramArray=new Array();
	paramArray['R']=new Array("gid","uid","odd_f_type","type","gnum","strong","langx");
	paramArray['HR']=new Array("gid","uid","odd_f_type","type","gnum","strong","langx");
	paramArray['OU']=new Array("gid","uid","odd_f_type","type","gnum","langx");
	paramArray['HOU']=new Array("gid","uid","odd_f_type","type","gnum","langx");
	paramArray['M']=new Array("gid","uid","odd_f_type","type","gnum","langx");
	paramArray['HM']=new Array("gid","uid","odd_f_type","type","gnum","langx");
	paramArray['EO']=new Array("gid","uid","odd_f_type","rtype","langx");
 
	var param="";
	var gid=((wtype=="R"||wtype=="OU"||wtype=="M"||wtype=="EO") ? GameData.gid : GameData.hgid);
	var gnum=eval("GameData.gnum_"+(betTeam=="N"? "c":betTeam.toLowerCase()));
	var strong=(wtype=="R" ? GameData.strong : GameData.hstrong);
	var rtype=(betTeam=="O" ? "ODD" : "EVEN");
	var type=betTeam;
	
	for (var i=0;i<paramArray[wtype].length;i++){
		if (i>0)  param+="&";
		param+=paramArray[wtype][i]+"="+eval(paramArray[wtype][i]);
	}
	return param;
}
 
function parsemore(GameData,g_more){
	var ret="";
	if(g_more=='0'||GameData.more=='0'){
		ret="&nbsp;";
	}else{
	 	ret="<A href=javascript: onClick=parent.show_more('"+GameData.gid+"',event);>"+"<font class='total_color'>+"+GameData.more+"&nbsp;</font>"+str_more+"</A>";
	}			
	return ret;	
}
function show_more(gid,evt){
	evt = evt ? evt : (window.event ? window.event : null);
	var mY = evt.pageY ? evt.pageY : evt.y;
	body_browse.document.getElementById('more_window').style.position='absolute';
	body_browse.document.getElementById('more_window').style.top=mY+30;
	body_browse.document.getElementById('more_window').style.left=body_browse.document.body.scrollLeft+10;
	show_more_gid = gid;
	var  url="body_var_r_more.php?gid="+gid+"&uid="+uid+"&ltype="+ltype+"&langx="+top.langx;
	body_browse.showdata.location.href = url;
}
function parseAllBets(GameData,g_more){
	var ret="";
	if(g_more=='0'||GameData.more=='0'){
		ret="&nbsp;";
	}else{
	 	ret="<A href=javascript: onClick=parent.show_allbets('"+GameData.gid+"',event);><font class='total_color'>"+str_more+" ("+GameData.more+")</font></A>";
	}			
	return ret;	
}
 
 
function show_allbets(gid,evt){
	evt = evt ? evt : (window.event ? window.event : null);
	var mY = evt.pageY ? evt.pageY : evt.y;
	
	top.browse_ScrollY = getScroll(body_browse);//body_browse.scrollY;
	body_browse.document.getElementById('box').style.display="none";	
	body_browse.document.getElementById('refresh_right').style.display="none";
	body_browse.document.getElementById('refresh_down').style.display="none";
	if(typeof(g_date) == "undefined"){
		body_browse.document.getElementById('MFT').className="more_bar";
	}
	else {
	  body_browse.document.getElementById('MFU').className="more_bar";
	}
	
	//body_browse.document.getElementById('more_window').style.display="block";
	body_browse.document.getElementById('more_window').style.position='absolute';
	body_browse.document.getElementById('more_window').style.top="0px";
	body_browse.document.getElementById('more_window').style.left="0px";
	show_more_gid = gid;
	retime_flag = "N"; 
	if(typeof(top.more_fave_wtype) == "undefined" ) top.more_fave_wtype = new Array();
	if(typeof(top.more_fave_wtype[show_more_gid]) == "undefined" ) top.more_fave_wtype[show_more_gid] = new Array();
	var  url="body_var_r_allbets.php?gid="+gid+"&uid="+uid+"&ltype="+ltype+"&langx="+top.langx+"&gtype=FT";
 
	body_browse.showdata.location.href = url;

	// alert(url);
}
 
function getScroll(frameObj){
		return body_browse.scrollY || body_browse.document.body.scrollTop ; 
}
 
 
 
 
function parseMyLove(GameData){
 
	var tmpStr="";
	//====== 加入現場轉播功能 2009-04-09, VideoFun 放在 flash_ior_mem.js
	tmpStr = "<table width='99%'   border='0' cellpadding='0' cellspacing='0'><tr><td align='left'>"+str_even+"</td>";				
	tmpStr+= "<td class='hot_td'>";
//	tmpStr+= "<table><tr align='right'><td>";
	tmpStr+=MM_ShowLoveI(GameData.gnum_h,GameData.datetime,GameData.league,GameData.team_h,GameData.team_c);
	tmpStr+= "</td>";
	tmpStr+= "<td class='hot_tv'>";
//	if (top.casino == "SI2") {
		if (GameData.eventid != "" && GameData.eventid != "null" && GameData.eventid != undefined) {	//判斷是否有轉播
		tmpStr+= VideoFun(GameData.eventid, GameData.hot, GameData.play, "FT");
		}
//	}
	tmpStr+= "</td>";
	tmpStr+= "</tr></table>";
 
	return  tmpStr;
}
 
 
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8 "><script>
var isHot_game = false;//是否為世足賽
//--------------------------------public function ----------------------------
 
function setRefreshPos(){
		var refresh_right= body_browse.document.getElementById('refresh_right');
		refresh_right.style.left= body_browse.document.getElementById('myTable').clientWidth*1+20;
		//refresh_right.style.top= 39;
	}
 
function parseArray(gameHead,gameData){
	var gameObj=new Object();
	for (var i=0;i<gameHead.length;i++){
		if (gameHead[i]!=""){	
			eval("gameObj."+gameHead[i]+"='"+gameData[i]+"'");
		}
	}
	return gameObj;
}
 
 
function check_ioratio(rec,rtype,GameData){
//alert(flash_ior_set);
	//return true;
	//alert(GameFT.length+"----"+keepGameData.length)
 
	if (flash_ior_set =='Y'){
		//alert(oldObjDataFT[rec]);
		if (""+oldObjDataFT[rec]=="undefined" || oldObjDataFT[rec].gid != GameData.gid){
			var gameObj=new Object();
			gameObj.gid=GameData.gid;
			oldObjDataFT[rec]=gameObj;
		}
		
		var new_ioratio=eval("GameData."+rtype);
		var old_ioratio=eval("oldObjDataFT[rec]."+rtype);
		
		
		if (""+old_ioratio=="undefined"){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			old_ioratio=eval("oldObjDataFT[rec]."+rtype);
		}
		
		//alert("old_ioratio==>"+old_ioratio+",new_ioratio==>"+new_ioratio);
		if (""+new_ioratio=="undefined" || new_ioratio==""){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return;
		}
		
		/*
		if (parseFloat(old_ioratio)>parseFloat(new_ioratio) ){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='border: 1px solid #FF0000;' ";
		}
		if (parseFloat(old_ioratio)<parseFloat(new_ioratio) ){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='border: 1px solid #00FF00;' ";
		}
		*/
		
		if (old_ioratio!=new_ioratio && old_ioratio !="" && new_ioratio!="") {
	    	eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='background-color : yellow' ";
		}
		
		return true;
	}
 
}
//--------------判斷聯盟顯示或隱藏----------------
function showLeg(leg){
	for (var i=0;i<myLeg[leg].length;i++){
	if ( body_browse.document.getElementById("TR_"+myLeg[leg][i]).style.display!="none"){
				showLegIcon(leg,"LegClose",myLeg[leg][i],"none");
				
		}else{
			showLegIcon(leg,"LegOpen",myLeg[leg][i],"");
		}
	}
	if ((""+NoshowLeg[leg])=="undefined"){
		NoshowLeg[leg]=-1;
	}else{
		NoshowLeg[leg]=NoshowLeg[leg]*-1;
	}
 
}
function showLegIcon(leg,state,gnumH,display){
	var  ary=body_browse.document.getElementsByName(leg);
			
	for (var j=0;j<ary.length;j++){
		ary[j].innerHTML="<span id='"+state+"'></span>";
	}
	try{
		body_browse.document.getElementById("TR3_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR2_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR1_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR_"+gnumH).style.display=display;
	}catch(E){}
}
//----------------------
 
//分頁
function show_page(){
	//alert(rtype)
	pg_str='';
	obj_pg = body_browse.document.getElementById('pg_txt');
//	alert(t_page);
	if (t_page==0){
		t_page=1;
		//obj_pg.innerHTML = "";
		//return;
	}
	var tmp_lid="";
	if (rtype=="re"){
		tmp_lid=eval("parent."+sel_gtype+"_lid_ary_RE");
	}else{
		tmp_lid=eval("parent."+sel_gtype+"_lid_ary");
	}
	//alert(tmp_lid+"--"+top.swShowLoveI+"--"+t_page)
	if(tmp_lid=='ALL'&&!top.swShowLoveI){
		var disabled="";
		if (t_page==1){
			disabled="disabled";
			}
		var pghtml=(pg*1+1)+" / " +t_page+" "+top.page+"&nbsp;&nbsp; <select  onchange='chg_pg(this.options[this.selectedIndex].value)' "+disabled+">";
		for(var i=0;i<t_page;i++){
			if (pg==i){
		 		pghtml+="<option value='"+i+"' selected>"+(i+1)+"</option>";
		 	}else{
		  		pghtml+="<option value='"+i+"' >"+(i+1)+"</option>";
		  	}
		}
		pghtml+="</select>";
		obj_pg.innerHTML = pghtml;
	}else{
		obj_pg.innerHTML = "";
	}
}
 
//將時間 轉回 24小時//04:00p
function  change_time(get_time){
	
	if (get_time.indexOf("font") > 0 ) return get_time;
	if (get_time.indexOf("p")>0 || get_time.indexOf("a")>0){
		gtime=get_time.split(":");
		if (gtime[1].indexOf("p")>0){
			
			if (gtime[0]!="12"){
				gtime[0]=gtime[0]*1+12;
			}	
		}
		gtime[1]=gtime[1].replace("a","").replace("p","");
		
	}else{
		return get_time;
	}
	return gtime[0]+":"+gtime[1];
	
}
 
//隱藏我的最愛選擇聯賽
function dis_ShowLoveI(){
 
if(top.swShowLoveI){
  body_browse.document.getElementById("sel_league").style.display="none";
 }else{
  body_browse.document.getElementById("sel_league").style.display="";
 }
 
}
 
 
function changeTitleStr(s,at){
	if (s.charAt(at)=="H"){
		return "H";
	}else if(s.charAt(at)=="C"){
		return "A";
	}else if(s.charAt(at)=="N"){
		return "D";
	}
	return "";
}
 
 
function loadingOK(){
	//alert("loadingOK")
	try{
		body_browse.document.getElementById("refresh_btn").className="refresh_btn";
	}catch(E){}
	try{
	body_browse.document.getElementById("refresh_right").className="refresh_M_btn";
	}catch(E){}
	try{	
	body_browse.document.getElementById("refresh_down").className="refresh_M_btn";
	}catch(E){}
}
 
 
var gameCount="";
var recordHash=new Array();
function showHOT(countHOT){
	
if( (""+countHOT=="") || (""+countHOT=="undefined") ){
	
	 body_browse.document.getElementById("euro_btn").style.display="none";
	 body_browse.document.getElementById("euro_up").style.display="none";
			
}else{	
		
	if(""+top.hot_game=="undefined"){
		top.hot_game="";
	}	
	var gtypeHOT =new Array("FT","BK","TN","VB","OP");
	var countgames=countHOT.split(",");
	recordHash=new Array();
	var head_str="";
	
	if(rtype == "re"){
		head_str="RB";
	}else{
		head_str=top.head_FU;
	}
	//alert(head_str);
	
	for( var i=0;i<countgames.length;i++){
		var detailgame=countgames[i].split("|");
		recordHash[detailgame[0]+"_"+detailgame[1]]=detailgame[2]*1;
	}
	if(recordHash[top.head_gtype+"_HOT_"+head_str]*1==0){
		body_browse.document.getElementById("euro_btn").style.display="none";
		body_browse.document.getElementById("euro_up").style.display="none";
		//body_browse.document.getElementById("euro_close").style.display="";
		if(top.hot_game!=""){
			top.hot_game="";
			body_browse.reload_var();
		}
	}else{
		if(isHot_game){
			if(top.hot_game!=""){
				body_browse.document.getElementById("euro_btn").style.display="none";
				body_browse.document.getElementById("euro_up").style.display="";
			}else{
				body_browse.document.getElementById("euro_btn").style.display="";
				body_browse.document.getElementById("euro_up").style.display="none";
			}
		}
		//body_browse.document.getElementById("euro_close").style.display="none";	
	}
	//alert(recordHash[top.head_gtype+"_HOT_RB"]);
	//alert(recordHash[top.head_gtype+"_HOT_FT"]);
	//alert(recordHash[top.head_gtype+"_HOT_FU"]);
	//parent.mem_order.showHOT(recordHash[top.head_gtype+"_HOT_FT"],recordHash[top.head_gtype+"_HOT_FU"]);
	//parent.mem_order.showHOT(recordHash["FT_HOT_FT"],recordHash["FT_HOT_FU"]);
	/*
	var today_hot=0;
	var early_hot=0;
	for( var i=0;i<gtypeHOT.length;i++){
		try{
		parent.mem_order.document.getElementById(gtypeHOT[i]+"_FT").innerHTML=eval("top.str_"+gtypeHOT[i]) + "("+recordHash[gtypeHOT[i]+"_HOT_FT"]+")";
		parent.mem_order.document.getElementById(gtypeHOT[i]+"_FU").innerHTML=eval("top.str_"+gtypeHOT[i]) + "("+recordHash[gtypeHOT[i]+"_HOT_FU"]+")";
		}catch(E){}
			
		today_hot +=recordHash[gtypeHOT[i]+"_HOT_FT"];
		early_hot +=recordHash[gtypeHOT[i]+"_HOT_FU"];
	}	
	
		parent.mem_order.showHOT(today_hot,early_hot);
	*/	
	try{
		parent.mem_order.getCountHOT(countHOT);
	}catch(e){}
		
 }		
 	
}
 
//function getCountHOT(){
//	return recordHash[top.head_gtype+"_HOT_FT"];
//}
function keep_show_more(gid,GameFT,gamount){
	if(gid!=''){
		show_more_gid = '';
		for (var j=0;j < gamount;j++){
			if(gid == GameFT[j].gid  && GameFT[j].more != 0){
				//body_browse.showdata.location.reload();
				show_more_gid = gid;
				return;
			}
		}
	}
	body_browse.document.getElementById('more_window').style.display='none';
}

<?	
break;
case 're':
?>
var ObjDataFT=new Array();
var oldObjDataFT=new Array();
//var GameHead=new Array("gid","datetime","league","gnum_h","gnum_c","team_h","team_c","strong","ratio","ior_RH","ior_RC","ratio_o","ratio_u","ior_OUH","ior_OUC","ior_MH","ior_MC","ior_MN","str_odd","str_even","ior_EOO","ior_EOE","hgid","hstrong","hratio","ior_HRH","ior_HRC","hratio_o","hratio_u","ior_HOUH","ior_HOUC","ior_HMH","ior_HMC","ior_HMN","more","eventid","hot","play");
var keepleg="";
var legnum=0;
var NoshowLeg=new Array();
var myLeg=new Array();
var LeagueAry=new Array();
//var keepscroll=0;
function ShowGameList(){
	reTimeNow = retime;
	
	parent.header.chg_button_bg('FT','rb');	
	
	if(loading == 'Y') return;
	if (parent.gamecount!=gamount){
		oldObjDataFT=new Array();
	}
	if(top.odd_f_type==""||""+top.odd_f_type=="undefined") top.odd_f_type="H";
	keepscroll=body_browse.document.body.scrollTop;
 
	var conscroll= body_browse.document.getElementById('controlscroll');
	//conscroll.style.display="";
	//conscroll.style.top=keepscroll+1;
	//	conscroll.style.width=800;
	//	conscroll.style.Height=600;
	//conscroll.focus();
		//conscroll.blur();
 
	dis_ShowLoveI();
	
	body_browse.auto_re_addShowLoveI(GameFT);//自動加入單式最愛
	//秀盤面
	showtables(GameFT,GameHead,gamount,top.odd_f_type);
//conscroll.style.top=top.keepscroll;
	//conscroll.focus();
 
	body_browse.scroll(0,keepscroll);
	
	//設定右方重新整理位置
	setRefreshPos();
	
	//顯示盤口
	body_browse.ChkOddfDiv();
	//跑馬燈
//	obj_msg = body_browse.document.getElementById('real_msg');
//	obj_msg.innerHTML = '<marquee scrolldelay=\"300\">'+msg+'</marquee>';
 
	//更新秒數
	//只有 讓分/走地 才有更新時間
	//hr_info = body_browse.document.getElementById('hr_info');
	//if(retime){
	//	hr_info.innerHTML = retime+str_renew;
	//}else{
	//	hr_info.innerHTML = str_renew;
	//}
 
	parent.gamecount=gamount;
	//alert("top.showtype="+top.showtype+",top.showtype="+top.showtype);
	//日期下拉霸
 
	if (sel_gtype=="FU"){
		if (""+body_browse.document.getElementById('g_date')!="undefined"){
			body_browse.selgdate("re",g_date);
			body_browse.document.getElementById('g_date').value=g_date;
		}
	}
	if (top.hot_game!=""){
		body_browse.document.getElementById('sel_league').style.display='none';
		show_page();
 	}else{	
 		
	if(top.showtype=='hgft'||top.showtype=='hgfu'){
		obj_sel = body_browse.document.getElementById('sel_league');
		obj_sel.style.display='none';
		try{
			var obj_date='';
			obj_date=body_browse.document.getElementById("g_date").value;
			body_browse.selgdate("",obj_date);
		}catch(E){}
	}else{
		show_page();
	}
	
 }
 
	//var conscroll= body_browse.document.getElementById('controlscroll');
	conscroll.style.display="none";
	//conscroll.width=1;
	//	conscroll.Height=1;
	coun_Leagues();
	body_browse.showPicLove();
	loadingOK();
	showHOT(gameCount);	
	
	keep_show_more(show_more_gid,ObjDataFT,gamount);
}
var hotgdateArr =new Array();
function hot_gdate(gdate){
	if((""+hotgdateArr).indexOf(gdate)==-1){
		hotgdateArr.push(gdate);
	}
}
function coun_Leagues(){
	var coun=0;
	var str_tmp ="|"+eval('parent.'+sel_gtype+'_lname_ary_RE');
	if(str_tmp=='|ALL'){
		body_browse.document.getElementById("str_num").innerHTML =top.alldata;
	}else{
		var larray=str_tmp.split('|');
		for(var i =0;i<larray.length;i++){
			if(larray[i]!=""){coun++}
		}
		coun =LeagueAry.length;
		body_browse.document.getElementById("str_num").innerHTML =coun;
	}
	
	
}
/*
function show_page(){
	pg_str='';
	obj_pg = body_browse.document.getElementById('pg_txt');
	if (t_page==0){
		obj_pg.innerHTML = "";
		return;
	}
	//alert(pg+"/"+t_page)
 
	if(eval("parent."+sel_gtype+"_lid_ary_RE")=='ALL'&&!top.swShowLoveI){
		var pghtml="頁次:" +(pg*1+1)+"/" +t_page+"&nbsp;&nbsp; <select  onchange='chg_pg(this.options[this.selectedIndex].value)'>";
		for(var i=0;i<t_page;i++){
		 // 	if (pg!=i)
		 		if  (pg==i){
		 			pghtml+="<option value='"+i+"' selected>"+(i+1)+"</option>";
		 		}else{
		  			pghtml+="<option value='"+i+"' >"+(i+1)+"</option>";
		  		}
		  	//	pg_str=pg_str+"<a href=# onclick='chg_pg("+i+");'>"+(i+1)+"</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		  //	else
		  //		pg_str=pg_str+(i+1)+"&nbsp;&nbsp;&nbsp;&nbsp;";
			}
		pghtml+="</select>";
			obj_pg.innerHTML = pghtml;
	}else{
		obj_pg.innerHTML = "";
	}
 
 
}
*/
//------單式顯示------
//function ShowData_OU(obj_table,GameData,data_amount,odd_f_type){
	//showtables();
//}
 
//var GameFT=new Array();
 
 
//表格函數
function showtables(GameData,Game_Head,data_amount,odd_f_type){
//	var conscroll= body_browse.document.getElementById('controlscroll');
 
	//var conscroll= document.getElementById('controlscroll');
//	conscroll.style.display="block";
//	conscroll.top=keepscroll;
	//alert("kkkk");
 
 
 
	ObjDataFT=new Array();
	myLeg=new Array();
	for (var j=0;j < data_amount;j++){
		if (GameData[j]!=null){
			ObjDataFT[j]=parseArray(Game_Head,GameData[j]);
		}
	}
	//alert("ObjDataFT===>"+ObjDataFT.length);
	var trdata;//=body_browse.document.getElementById('DataTR').innerHTML;
	var showtableData;
	if(body_browse.document.all){
	     	showtableData=body_browse.document.getElementById('showtableData').innerText ;
	     	trdata=body_browse.document.getElementById('DataTR').innerText;
	     	notrdata=body_browse.document.getElementById('NoDataTR').innerText;
	} else{
	     	showtableData=body_browse.document.getElementById('showtableData').textContent ;
	     	trdata=body_browse.document.getElementById('DataTR').textContent;
	     	notrdata=body_browse.document.getElementById('NoDataTR').textContent;
	}
	//alert(trdata);
	var showtable=body_browse.document.getElementById('showtable');
	var showlayers="";
	keepleg="";
	legnum=0;
	LeagueAry =new Array();
	var chk_Love_I=new Array();
	if(ObjDataFT.length > 0){
	  	for ( i=0 ;i < ObjDataFT.length;i++){
	  		tmp_Str=getLayer(trdata,i,odd_f_type);
	  		showlayers+=tmp_Str;
	  		if (top.swShowLoveI&&tmp_Str!=""){
	  			chk_Love_I.push(ObjDataFT[i]);	
	  		}
	  	}
	  	//alert("top.hot_game="+top.hot_game+",top.swShowLoveI="+top.swShowLoveI+",chk_Love_I="+chk_Love_I);
	  if (top.hot_game==""){	
	  	if (top.swShowLoveI){
	  		body_browse.checkLoveCount(chk_Love_I);	
	  	}
	  }	
	  	if(showlayers=="")showlayers=notrdata;
  		showtableData=showtableData.replace("*showDataTR*",showlayers);
	}else{
	 	showtableData=showtableData.replace("*showDataTR*",notrdata);
	}
	
	showtable.innerHTML=showtableData;
	//oldObjDataFT=ObjDataFT;
 
//	conscroll.style.display="none";
}
 
 
//表格內容
function getLayer(onelayer,gamerec,odd_f_type){
	var open_hot = false;
	if (top.hot_game==""){
		if(MM_IdentificationDisplay(ObjDataFT[gamerec].datetime,ObjDataFT[gamerec].gnum_h)) return "";
	}
	if (!top.swShowLoveI){
		if (top.hot_game==""){
			if(("|"+eval('parent.'+sel_gtype+'_lname_ary_RE')).indexOf(("|"+ObjDataFT[gamerec].league+"|"),0)==-1&&eval('parent.'+sel_gtype+'_lname_ary_RE')!='ALL') return "";
			if((""+LeagueAry).indexOf(ObjDataFT[gamerec].league)== -1)LeagueAry.push(ObjDataFT[gamerec].league);
		}
	}
	var tmp_date = ObjDataFT[gamerec].datetime.split("<br>")[0];
	onelayer=onelayer.replace(/\*ID_STR\*/g,tmp_date+ObjDataFT[gamerec].gnum_h);
	onelayer=onelayer.replace(/\*TR_EVENT\*/g,"onMouseOver='mouseEnter_pointer(this.id);' onMouseOut='mouseOut_pointer(this.id);'");
	//alert(ObjDataFT[gamerec].league+"==="+keepleg+"["+(ObjDataFT[gamerec].league==keepleg)+"]")
 
 
 
	if (""+myLeg[ObjDataFT[gamerec].league]=="undefined"){
			myLeg[ObjDataFT[gamerec].league]=ObjDataFT[gamerec].league;
			myLeg[ObjDataFT[gamerec].league]=new Array();
			myLeg[ObjDataFT[gamerec].league][0]=tmp_date+ObjDataFT[gamerec].gnum_h;
		}else{
			myLeg[ObjDataFT[gamerec].league][myLeg[ObjDataFT[gamerec].league].length]=tmp_date+ObjDataFT[gamerec].gnum_h;
			}
 
	//--------------判斷聯盟名稱列顯示或隱藏----------------
	if (ObjDataFT[gamerec].league==keepleg){
			onelayer=onelayer.replace("*ST*"," style='display: none;'");
	}else{
			onelayer=onelayer.replace("*ST*"," style='display: ;'");
	}
	//---------------------------------------------------------------------
	//--------------判斷聯盟底下的賽事顯示或隱藏----------------
	if (NoshowLeg[ObjDataFT[gamerec].league]==-1){
		onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: none;'");
		onelayer=onelayer.replace("*LegMark*","<span id='LegClose'></span>"); //聯盟的小圖
	}else{
		onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: ;'");
		onelayer=onelayer.replace("*LegMark*","<span id='LegOpen'></span>");  //聯盟的小圖
	}
	//---------------------------------------------------------------------
 
 
	//滾球字眼
	ObjDataFT[gamerec].datetime=ObjDataFT[gamerec].datetime.replace("Running Ball","");
	ObjDataFT[gamerec].timer=ObjDataFT[gamerec].timer.replace("<font style=background-color=red>","").replace("</font>","");
	keepleg=ObjDataFT[gamerec].league;
	onelayer=onelayer.replace(/\*LEG\*/gi,ObjDataFT[gamerec].league);
 
 
//	onelayer=onelayer.replace(/\*LegID\*/g,"LEG_"+legnum);
 
	var R_ior =Array();
	var OU_ior =Array();
	var HR_ior =Array();
	var HOU_ior =Array();
	var EO_ior =Array();
	
	R_ior  = get_other_ioratio(odd_f_type, ObjDataFT[gamerec].ior_RH   , ObjDataFT[gamerec].ior_RC   , show_ior);
	OU_ior = get_other_ioratio(odd_f_type, ObjDataFT[gamerec].ior_OUH  , ObjDataFT[gamerec].ior_OUC  , show_ior);
	HR_ior = get_other_ioratio(odd_f_type, ObjDataFT[gamerec].ior_HRH  , ObjDataFT[gamerec].ior_HRC  , show_ior);
	HOU_ior= get_other_ioratio(odd_f_type, ObjDataFT[gamerec].ior_HOUH , ObjDataFT[gamerec].ior_HOUC , show_ior);
	
	if((ObjDataFT[gamerec].ior_EOO != 0) && (ObjDataFT[gamerec].ior_EOE != 0)){
		EO_ior= get_other_ioratio("H", ObjDataFT[gamerec].ior_EOO*1-1 , ObjDataFT[gamerec].ior_EOE*1-1 , show_ior);
		ObjDataFT[gamerec].ior_EOO=EO_ior[0]*1+1;
		ObjDataFT[gamerec].ior_EOE=EO_ior[1]*1+1;
	}
	
	ObjDataFT[gamerec].ior_RH=R_ior[0];
	ObjDataFT[gamerec].ior_RC=R_ior[1];
	ObjDataFT[gamerec].ior_OUH=OU_ior[0];
	ObjDataFT[gamerec].ior_OUC=OU_ior[1];
	ObjDataFT[gamerec].ior_HRH=HR_ior[0];
	ObjDataFT[gamerec].ior_HRC=HR_ior[1];
	ObjDataFT[gamerec].ior_HOUH=HOU_ior[0];
	ObjDataFT[gamerec].ior_HOUC=HOU_ior[1];	
 
	var tmpset=ObjDataFT[gamerec].retimeset.split("^");
	tmpset[1]=tmpset[1].replace("<font style=background-color=red>","").replace("</font>","");
	var showretime="";
	if(tmpset[0]=="Start"){
		//showretime=tmpset[1];
			showretime="-";
	}else if(tmpset[0]=="MTIME"){
		showretime=tmpset[1];
	}else{
		var tmpHtime=tmpset[0];
		if(top.langx=="zh-tw"||top.langx=="zh-cn"){
			var showstr=tmpset[0].split("H");
			if(showstr[0]=="1")tmpHtime=top.retime1H;
			if(showstr[0]=="2")tmpHtime=top.retime2H;
		}
		showretime=tmpHtime+" "+tmpset[1]+"\'";
	}
	onelayer=onelayer.replace("*DATETIME*",showretime);
	//onelayer=onelayer.replace("*DATETIME*",change_time(ObjDataFT[gamerec].timer));
	
	
	if(ObjDataFT[gamerec].lastestscore_h != ''){
		onelayer=onelayer.replace("*SCORE*","<font color=\"red\" >"+ObjDataFT[gamerec].score_h+"</font>&nbsp;-&nbsp;"+ObjDataFT[gamerec].score_c);
	}else if(ObjDataFT[gamerec].lastestscore_c != ''){
		onelayer=onelayer.replace("*SCORE*",ObjDataFT[gamerec].score_h+"&nbsp;-&nbsp;<font color=\"red\" >"+ObjDataFT[gamerec].score_c+"</font>");
	}else{
		onelayer=onelayer.replace("*SCORE*",ObjDataFT[gamerec].score_h+"&nbsp;-&nbsp;"+ObjDataFT[gamerec].score_c);
	}
	
	
	if (ObjDataFT[gamerec].redcard_h*1 > 0){
		onelayer=onelayer.replace("*REDCARD_H*",ObjDataFT[gamerec].redcard_h);
		onelayer=onelayer.replace("*REDCARD_H_STYLE*","");
	}else{
		onelayer=onelayer.replace("*REDCARD_H_STYLE*","style='display:none;'");
	}
	if (ObjDataFT[gamerec].redcard_c*1 > 0){
		onelayer=onelayer.replace("*REDCARD_C*",ObjDataFT[gamerec].redcard_c);
		onelayer=onelayer.replace("*REDCARD_C_STYLE*","");
	}else{
		onelayer=onelayer.replace("*REDCARD_C_STYLE*","style='display:none;'");
	}
	onelayer=onelayer.replace("*TEAM_H*",ObjDataFT[gamerec].team_h.replace("[Mid]","<font color=\"#005aff\">[N]</font>").replace("[中]","<font color=\"#005aff\">[中]</font>"));
	onelayer=onelayer.replace("*TEAM_C*",ObjDataFT[gamerec].team_c);
	//全場
	//獨贏
	onelayer=onelayer.replace("*RATIO_MH*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"M"));
	onelayer=onelayer.replace("*RATIO_MC*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"M"));
	onelayer=onelayer.replace("*RATIO_MN*",parseUrl(uid,odd_f_type,"N",ObjDataFT[gamerec],gamerec,"M"));
	//讓球
	if (ObjDataFT[gamerec].strong=="H"){
		onelayer=onelayer.replace("*CON_RH*",ObjDataFT[gamerec].ratio);	/*讓球球頭*/
		onelayer=onelayer.replace("*CON_RC*","");
	}else{
		onelayer=onelayer.replace("*CON_RH*","");
		onelayer=onelayer.replace("*CON_RC*",ObjDataFT[gamerec].ratio);
	}
 
 
	//onelayer=onelayer.replace("*TD_RH_CLASS*",check_ioratio(gamerec,"ior_RH",ObjDataFT[gamerec]));/*讓球sytle*/
	//onelayer=onelayer.replace("*TD_RH_CLASS*","class='b_rig'");/*讓球sytle*/
 
	onelayer=onelayer.replace("*RATIO_RH*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"R"));/*讓球賠率*/
	onelayer=onelayer.replace("*RATIO_RC*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"R"));
	//大小
	if (top.langx=="en-us"){
		onelayer=onelayer.replace("*CON_OUH*",ObjDataFT[gamerec].ratio_o.replace("O","o") );	/*大小球頭*/
		onelayer=onelayer.replace("*CON_OUC*",ObjDataFT[gamerec].ratio_u.replace("U","u") );
	}else{
		onelayer=onelayer.replace("*CON_OUH*",ObjDataFT[gamerec].ratio_o.replace("O",top.strOver));	/*大小球頭*/
		onelayer=onelayer.replace("*CON_OUC*",ObjDataFT[gamerec].ratio_u.replace("U",top.strUnder));
	}
	onelayer=onelayer.replace("*RATIO_OUH*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"OU"));/*大小賠率*/
	onelayer=onelayer.replace("*RATIO_OUC*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"OU"));
	//單雙
	if (top.langx=="en-us"){
	onelayer=onelayer.replace("*RATIO_RODD*",ObjDataFT[gamerec].str_odd+parseUrl(uid,odd_f_type,"O",ObjDataFT[gamerec],gamerec,"EO"));
  	onelayer=onelayer.replace("*RATIO_REVEN*",ObjDataFT[gamerec].str_even+parseUrl(uid,odd_f_type,"E",ObjDataFT[gamerec],gamerec,"EO"));
	}else{
	onelayer=onelayer.replace("*RATIO_RODD*",ObjDataFT[gamerec].str_odd+parseUrl(uid,odd_f_type,"O",ObjDataFT[gamerec],gamerec,"EO"));
  	onelayer=onelayer.replace("*RATIO_REVEN*",ObjDataFT[gamerec].str_even+parseUrl(uid,odd_f_type,"E",ObjDataFT[gamerec],gamerec,"EO"));	
		}	
	//上半場
	//獨贏
	onelayer=onelayer.replace("*RATIO_HMH*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"HM"));
	onelayer=onelayer.replace("*RATIO_HMC*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"HM"));
	onelayer=onelayer.replace("*RATIO_HMN*",parseUrl(uid,odd_f_type,"N",ObjDataFT[gamerec],gamerec,"HM"));
	//讓球
	if (ObjDataFT[gamerec].hstrong=="H"){
		onelayer=onelayer.replace("*CON_HRH*",ObjDataFT[gamerec].hratio);	/*讓球球頭*/
		onelayer=onelayer.replace("*CON_HRC*","");
	}else{
		onelayer=onelayer.replace("*CON_HRH*","");
		onelayer=onelayer.replace("*CON_HRC*",ObjDataFT[gamerec].hratio);
	}
	onelayer=onelayer.replace("*RATIO_HRH*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"HR"));/*讓球賠率*/
	onelayer=onelayer.replace("*RATIO_HRC*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"HR"));
	//大小
	if (top.langx=="en-us"){
		onelayer=onelayer.replace("*CON_HOUH*",ObjDataFT[gamerec].hratio_o.replace("O","o") );	/*大小球頭*/
		onelayer=onelayer.replace("*CON_HOUC*",ObjDataFT[gamerec].hratio_u.replace("U","u") );
	}else{
		onelayer=onelayer.replace("*CON_HOUH*",ObjDataFT[gamerec].hratio_o.replace("O",top.strOver));	/*大小球頭*/
		onelayer=onelayer.replace("*CON_HOUC*",ObjDataFT[gamerec].hratio_u.replace("U",top.strUnder));
	}
	onelayer=onelayer.replace("*RATIO_HOUH*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"HOU"));/*大小賠率*/
	onelayer=onelayer.replace("*RATIO_HOUC*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"HOU"));
	//onelayer=onelayer.replace("*MORE*",parsemore(ObjDataFT[gamerec],game_more));
	onelayer=onelayer.replace("*MORE*",parseAllBets(ObjDataFT[gamerec],game_more));  //2014.03足球多玩法 by Leslie
	
	
	//我的最愛
	onelayer=onelayer.replace("*MYLOVE*",parseMyLove(ObjDataFT[gamerec]));
/*
	if (ObjDataFT[gamerec].play=="Y"){
			onelayer=onelayer.replace("*TV_ST*","style='display:block;'");
 
		}else{
				onelayer=onelayer.replace("*TV_ST*","style='display:none;'");
			}
 
*/
		if (ObjDataFT[gamerec].eventid != "" && ObjDataFT[gamerec].eventid != "null" && ObjDataFT[gamerec].eventid != undefined) {	//判斷是否有轉播
			tmpStr= VideoFun(ObjDataFT[gamerec].eventid, ObjDataFT[gamerec].hot, ObjDataFT[gamerec].play, "FT");
			//alert(tmpStr);
			onelayer=onelayer.replace("*TV*",tmpStr);
		}
		onelayer=onelayer.replace("*TV*","");
 
	//alert(onelayer);
	return onelayer;
}
 
 
//取得下注的url
function parseUrl(uid,odd_f_type,betTeam,GameData,gamerec,wtype){
	var urlArray=new Array();
	urlArray['R']=new Array("../FT_order/FT_order_re.php",eval("GameData.team_"+betTeam.toLowerCase()));
	urlArray['HR']=new Array("../FT_order/FT_order_hre.php",eval("GameData.team_"+betTeam.toLowerCase()));
	urlArray['OU']=new Array("../FT_order/FT_order_rou.php",(betTeam=="C" ? top.strOver : top.strUnder));
	urlArray['HOU']=new Array("../FT_order/FT_order_hrou.php",(betTeam=="C" ? top.strOver : top.strUnder));
	urlArray['M']=new Array("../FT_order/FT_order_rm.php",(betTeam=="N" ? top.str_irish_kiss : eval("GameData.team_"+betTeam.toLowerCase())));
	urlArray['HM']=new Array("../FT_order/FT_order_hrm.php",(betTeam=="N" ? top.str_irish_kiss : eval("GameData.team_"+betTeam.toLowerCase())));
	urlArray['EO']=new Array("../FT_order/FT_order_rt.php", (betTeam=="O"  ? top.str_o : top.str_e));
	var rewtype = new Array();
	rewtype['R'] = "RE";
	rewtype['HR'] = "HRE";
	rewtype['OU'] = "ROU";
	rewtype['HOU'] = "HROU";
	rewtype['M'] = "RM";
	rewtype['HM'] = "HRM";
	rewtype['EO'] = "REO";
 
	var param=getParam(uid,odd_f_type,betTeam,wtype,GameData);
	var order=urlArray[wtype][0];
	var team=urlArray[wtype][1].replace("[Mid]","[N]");
	var tmp_rtype="ior_"+wtype+betTeam;
	var ioratio_str="GameData."+tmp_rtype;
 
	var ioratio=eval(ioratio_str);
	
	if(eval(ioratio_str)!=""){
		ioratio=Mathfloor(ioratio);
		ioratio=printf(ioratio,2);
	}
 
	//20121023 max新增 輸水盤 負值顯示藍色
	if (odd_f_type=="M" || odd_f_type=="I"){
		if (ioratio<0) ioratio="<font color=#1f497d>"+ioratio+"</font>";
	
		}
 	//var ret="<a href='"+order+"?"+param+"' target='mem_order' title='"+team+"'><font "+check_ioratio(gamerec,tmp_rtype,GameData)+">"+ioratio+"</font></a>";
	//alert(parent.name)
	var ret="<a href='javascript://' onclick=\"parent.parent.mem_order.betOrder('FT','"+rewtype[wtype]+"','"+param+"');\" title='"+team+"'><font "+check_ioratio(gamerec,tmp_rtype,GameData)+">"+ioratio+"</font></a>";
 
	return ret;
 
}
 
	function Mathfloor(z){
	 var tmp_z;
	 tmp_z=(Math.floor(z*100+0.01))/100;
 	return tmp_z;
}
 
//--------------------------public function --------------------------------
 
//取得下注參數
function getParam(uid,odd_f_type,betTeam,wtype,GameData){
	var paramArray=new Array();
	paramArray['R']=new Array("gid","uid","odd_f_type","type","gnum","strong","langx");
	paramArray['HR']=new Array("gid","uid","odd_f_type","type","gnum","strong","langx");
	paramArray['OU']=new Array("gid","uid","odd_f_type","type","gnum","langx");
	paramArray['HOU']=new Array("gid","uid","odd_f_type","type","gnum","langx");
	paramArray['M']=new Array("gid","uid","odd_f_type","type","gnum","langx");
	paramArray['HM']=new Array("gid","uid","odd_f_type","type","gnum","langx");
	paramArray['EO']=new Array("gid","uid","odd_f_type","rtype","langx");
 
	var param="";
	var gid=((wtype=="R"||wtype=="OU"||wtype=="M"||wtype=="EO") ? GameData.gid : GameData.hgid);
	var gnum=eval("GameData.gnum_"+(betTeam=="N"? "c":betTeam.toLowerCase()));
	var strong=(wtype=="R" ? GameData.strong : GameData.hstrong);
	var rtype=(betTeam=="O" ? "RODD" : "REVEN");
	var type=betTeam;
 
	for (var i=0;i<paramArray[wtype].length;i++){
		if (i>0)  param+="&";
		param+=paramArray[wtype][i]+"="+eval(paramArray[wtype][i]);
	}
	return param;
}
 
function parsemore(GameData,g_more){
	var ret="";
	if(g_more=='0'||GameData.more=='0'){
		ret="&nbsp;";
	}else{
	 	ret="<A href=javascript: onClick=parent.show_more('"+GameData.gid+"',event);>"+"<font class='total_color'>+"+GameData.more+"&nbsp;</font>"+str_more+"</A>";
	}			
	return ret;	
}
 
function show_more(gid,evt){
	evt = evt ? evt : (window.event ? window.event : null);
	var mY = evt.pageY ? evt.pageY : evt.y;
	body_browse.document.getElementById('more_window').style.position='absolute';
	body_browse.document.getElementById('more_window').style.top=mY+30;
	body_browse.document.getElementById('more_window').style.left=body_browse.document.body.scrollLeft+10;
	show_more_gid = gid;
	var  url="body_var_re_more.php?gid="+gid+"&uid="+uid+"&ltype="+ltype+"&langx="+top.langx;
	body_browse.showdata.location.href = url;
}
 
 
//2014.03足球多玩法 by Leslie
function parseAllBets(GameData,g_more){
	var ret="";
	if(g_more=='0'||GameData.more=='0'){
		ret="&nbsp;";
	}else{
		var datetime = GameData.datetime.split("<br>");
	 	ret="<A href=javascript: onClick=parent.show_allbets('"+GameData.gid+"',event,'"+datetime[0]+"');><font class='total_color'>"+str_more+" ("+GameData.more+")</font></A>";
	}			
	return ret;	
}
 
 
 
//2014.03足球多玩法 by Leslie
function show_allbets(gid,evt,datetime){
	evt = evt ? evt : (window.event ? window.event : null);
	var mY = evt.pageY ? evt.pageY : evt.y;
	
	
	top.browse_ScrollY = getScroll(body_browse);//body_browse.scrollY;
	body_browse.document.getElementById('box').style.display="none";
	
	body_browse.document.getElementById('refresh_right').style.display="none";
	body_browse.document.getElementById('refresh_down').style.display="none";
	body_browse.document.getElementById('MFT').className="more_bar";
	
	//body_browse.document.getElementById('more_window').style.display="block";
	body_browse.document.getElementById('more_window').style.position='absolute';
	body_browse.document.getElementById('more_window').style.top="0px";
	body_browse.document.getElementById('more_window').style.left="0px";
	show_more_gid = gid;
	retime_flag = "N"; 
	
	
	
	if(typeof(top.more_fave_wtype) == "undefined" ) top.more_fave_wtype = new Array();
	if(typeof(top.more_fave_wtype[show_more_gid]) == "undefined" ) top.more_fave_wtype[show_more_gid] = new Array();
	var gate = new Date();
	datetime = (gate.getYear()+1900)+"-"+datetime
	var  url="body_var_re_allbets.php?gid="+gid+"&uid="+uid+"&ltype="+ltype+"&langx="+top.langx+"&gtype=FT&showtype=RB&date="+datetime;
	body_browse.showdata.location.href = url;
	
}
 
function getScroll(frameObj){
		return body_browse.scrollY || body_browse.document.body.scrollTop ; 
}
 
 
function parseMyLove(GameData){
 
	var tmpStr="";
	//====== 加入現場轉播功能 2009-04-09, VideoFun 放在 flash_ior_mem.js
	tmpStr = "<table width='99%'   border='0' cellpadding='0' cellspacing='0'><tr><td align='left'>"+str_even+"</td>";				
	tmpStr+= "<td class='hot_td'>";
//	tmpStr+= "<table><tr align='right'><td>";
	tmpStr+=MM_ShowLoveI(GameData.gnum_h,GameData.datetime,GameData.league,GameData.team_h,GameData.team_c);
	tmpStr+= "</td>";
	tmpStr+= "<td class='hot_tv'>";
//	if (top.casino == "SI2") {
		if (GameData.eventid != "" && GameData.eventid != "null" && GameData.eventid != undefined) {	//判斷是否有轉播
		tmpStr+= VideoFun(GameData.eventid, GameData.hot, GameData.play, "FT");
		}
//	}
	tmpStr+= "</td>";
	tmpStr+= "</tr></table>";
 
	return  tmpStr;
}
 
 
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8 "><script>
var isHot_game = false;//是否為世足賽
//--------------------------------public function ----------------------------
 
function setRefreshPos(){
		var refresh_right= body_browse.document.getElementById('refresh_right');
		refresh_right.style.left= body_browse.document.getElementById('myTable').clientWidth*1+20;
		//refresh_right.style.top= 39;
	}
 
function parseArray(gameHead,gameData){
	var gameObj=new Object();
	for (var i=0;i<gameHead.length;i++){
		if (gameHead[i]!=""){	
			eval("gameObj."+gameHead[i]+"='"+gameData[i]+"'");
		}
	}
	return gameObj;
}
 
 
function check_ioratio(rec,rtype,GameData){
//alert(flash_ior_set);
	//return true;
	//alert(GameFT.length+"----"+keepGameData.length)
 
	if (flash_ior_set =='Y'){
		//alert(oldObjDataFT[rec]);
		if (""+oldObjDataFT[rec]=="undefined" || oldObjDataFT[rec].gid != GameData.gid){
			var gameObj=new Object();
			gameObj.gid=GameData.gid;
			oldObjDataFT[rec]=gameObj;
		}
		
		var new_ioratio=eval("GameData."+rtype);
		var old_ioratio=eval("oldObjDataFT[rec]."+rtype);
		
		
		if (""+old_ioratio=="undefined"){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			old_ioratio=eval("oldObjDataFT[rec]."+rtype);
		}
		
		//alert("old_ioratio==>"+old_ioratio+",new_ioratio==>"+new_ioratio);
		if (""+new_ioratio=="undefined" || new_ioratio==""){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return;
		}
		
		/*
		if (parseFloat(old_ioratio)>parseFloat(new_ioratio) ){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='border: 1px solid #FF0000;' ";
		}
		if (parseFloat(old_ioratio)<parseFloat(new_ioratio) ){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='border: 1px solid #00FF00;' ";
		}
		*/
		
		if (old_ioratio!=new_ioratio && old_ioratio !="" && new_ioratio!="") {
	    	eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='background-color : yellow' ";
		}
		
		return true;
	}
 
}
//--------------判斷聯盟顯示或隱藏----------------
function showLeg(leg){
	for (var i=0;i<myLeg[leg].length;i++){
	if ( body_browse.document.getElementById("TR_"+myLeg[leg][i]).style.display!="none"){
				showLegIcon(leg,"LegClose",myLeg[leg][i],"none");
				
		}else{
			showLegIcon(leg,"LegOpen",myLeg[leg][i],"");
		}
	}
	if ((""+NoshowLeg[leg])=="undefined"){
		NoshowLeg[leg]=-1;
	}else{
		NoshowLeg[leg]=NoshowLeg[leg]*-1;
	}
 
}
function showLegIcon(leg,state,gnumH,display){
	var  ary=body_browse.document.getElementsByName(leg);
			
	for (var j=0;j<ary.length;j++){
		ary[j].innerHTML="<span id='"+state+"'></span>";
	}
	try{
		body_browse.document.getElementById("TR3_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR2_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR1_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR_"+gnumH).style.display=display;
	}catch(E){}
}
//----------------------
 
//分頁
function show_page(){
	//alert(rtype)
	pg_str='';
	obj_pg = body_browse.document.getElementById('pg_txt');
//	alert(t_page);
	if (t_page==0){
		t_page=1;
		//obj_pg.innerHTML = "";
		//return;
	}
	var tmp_lid="";
	if (rtype=="re"){
		tmp_lid=eval("parent."+sel_gtype+"_lid_ary_RE");
	}else{
		tmp_lid=eval("parent."+sel_gtype+"_lid_ary");
	}
	//alert(tmp_lid+"--"+top.swShowLoveI+"--"+t_page)
	if(tmp_lid=='ALL'&&!top.swShowLoveI){
		var disabled="";
		if (t_page==1){
			disabled="disabled";
			}
		var pghtml=(pg*1+1)+" / " +t_page+" "+top.page+"&nbsp;&nbsp; <select  onchange='chg_pg(this.options[this.selectedIndex].value)' "+disabled+">";
		for(var i=0;i<t_page;i++){
			if (pg==i){
		 		pghtml+="<option value='"+i+"' selected>"+(i+1)+"</option>";
		 	}else{
		  		pghtml+="<option value='"+i+"' >"+(i+1)+"</option>";
		  	}
		}
		pghtml+="</select>";
		obj_pg.innerHTML = pghtml;
	}else{
		obj_pg.innerHTML = "";
	}
}
 
//將時間 轉回 24小時//04:00p
function  change_time(get_time){
	
	if (get_time.indexOf("font") > 0 ) return get_time;
	if (get_time.indexOf("p")>0 || get_time.indexOf("a")>0){
		gtime=get_time.split(":");
		if (gtime[1].indexOf("p")>0){
			
			if (gtime[0]!="12"){
				gtime[0]=gtime[0]*1+12;
			}	
		}
		gtime[1]=gtime[1].replace("a","").replace("p","");
		
	}else{
		return get_time;
	}
	return gtime[0]+":"+gtime[1];
	
}
 
//隱藏我的最愛選擇聯賽
function dis_ShowLoveI(){
 
if(top.swShowLoveI){
  body_browse.document.getElementById("sel_league").style.display="none";
 }else{
  body_browse.document.getElementById("sel_league").style.display="";
 }
 
}
 
 
function changeTitleStr(s,at){
	if (s.charAt(at)=="H"){
		return "H";
	}else if(s.charAt(at)=="C"){
		return "A";
	}else if(s.charAt(at)=="N"){
		return "D";
	}
	return "";
}
 
 
function loadingOK(){
	//alert("loadingOK")
	try{
		body_browse.document.getElementById("refresh_btn").className="refresh_btn";
	}catch(E){}
	try{
	body_browse.document.getElementById("refresh_right").className="refresh_M_btn";
	}catch(E){}
	try{	
	body_browse.document.getElementById("refresh_down").className="refresh_M_btn";
	}catch(E){}
}
 
 
var gameCount="";
var recordHash=new Array();
function showHOT(countHOT){
	
if( (""+countHOT=="") || (""+countHOT=="undefined") ){
	
	 body_browse.document.getElementById("euro_btn").style.display="none";
	 body_browse.document.getElementById("euro_up").style.display="none";
			
}else{	
		
	if(""+top.hot_game=="undefined"){
		top.hot_game="";
	}	
	var gtypeHOT =new Array("FT","BK","TN","VB","OP");
	var countgames=countHOT.split(",");
	recordHash=new Array();
	var head_str="";
	
	if(rtype == "re"){
		head_str="RB";
	}else{
		head_str=top.head_FU;
	}
	//alert(head_str);
	
	for( var i=0;i<countgames.length;i++){
		var detailgame=countgames[i].split("|");
		recordHash[detailgame[0]+"_"+detailgame[1]]=detailgame[2]*1;
	}
	if(recordHash[top.head_gtype+"_HOT_"+head_str]*1==0){
		body_browse.document.getElementById("euro_btn").style.display="none";
		body_browse.document.getElementById("euro_up").style.display="none";
		//body_browse.document.getElementById("euro_close").style.display="";
		if(top.hot_game!=""){
			top.hot_game="";
			body_browse.reload_var();
		}
	}else{
		if(isHot_game){
			if(top.hot_game!=""){
				body_browse.document.getElementById("euro_btn").style.display="none";
				body_browse.document.getElementById("euro_up").style.display="";
			}else{
				body_browse.document.getElementById("euro_btn").style.display="";
				body_browse.document.getElementById("euro_up").style.display="none";
			}
		}
		//body_browse.document.getElementById("euro_close").style.display="none";	
	}
	//alert(recordHash[top.head_gtype+"_HOT_RB"]);
	//alert(recordHash[top.head_gtype+"_HOT_FT"]);
	//alert(recordHash[top.head_gtype+"_HOT_FU"]);
	//parent.mem_order.showHOT(recordHash[top.head_gtype+"_HOT_FT"],recordHash[top.head_gtype+"_HOT_FU"]);
	//parent.mem_order.showHOT(recordHash["FT_HOT_FT"],recordHash["FT_HOT_FU"]);
	/*
	var today_hot=0;
	var early_hot=0;
	for( var i=0;i<gtypeHOT.length;i++){
		try{
		parent.mem_order.document.getElementById(gtypeHOT[i]+"_FT").innerHTML=eval("top.str_"+gtypeHOT[i]) + "("+recordHash[gtypeHOT[i]+"_HOT_FT"]+")";
		parent.mem_order.document.getElementById(gtypeHOT[i]+"_FU").innerHTML=eval("top.str_"+gtypeHOT[i]) + "("+recordHash[gtypeHOT[i]+"_HOT_FU"]+")";
		}catch(E){}
			
		today_hot +=recordHash[gtypeHOT[i]+"_HOT_FT"];
		early_hot +=recordHash[gtypeHOT[i]+"_HOT_FU"];
	}	
	
		parent.mem_order.showHOT(today_hot,early_hot);
	*/	
	try{
		parent.mem_order.getCountHOT(countHOT);
	}catch(e){}
		
 }		
 	
}
 
//function getCountHOT(){
//	return recordHash[top.head_gtype+"_HOT_FT"];
//}
function keep_show_more(gid,GameFT,gamount){
	if(gid!=''){
		show_more_gid = '';
		for (var j=0;j < gamount;j++){
			if(gid == GameFT[j].gid  && GameFT[j].more != 0){
				//body_browse.showdata.location.reload();
				show_more_gid = gid;
				return;
			}
		}
	}
	body_browse.document.getElementById('more_window').style.display='none';
}



<?	
break;
case 'hpd':
?>
var ObjDataFT=new Array();
var oldObjDataFT=new Array();
//var GameHead=new Array("gid","datetime","league","gnum_h","gnum_c","team_h","team_c","strong","ior_H1C0","ior_H2C0","ior_H2C1","ior_H3C0","ior_H3C1","ior_H3C2","ior_H4C0","ior_H4C1","ior_H4C2","ior_H4C3","ior_H0C0","ior_H1C1","ior_H2C2","ior_H3C3","ior_H4C4","ior_OVH","ior_H0C1","ior_H0C2","ior_H1C2","ior_H0C3","ior_H1C3","ior_H2C3","ior_H0C4","ior_H1C4","ior_H2C4","ior_H3C4","ior_OVC");
var keepleg="";
var legnum=0;
var NoshowLeg=new Array();
var myLeg=new Array();
var LeagueAry=new Array();

function ShowGameList(){
	if(loading == 'Y') return;
	if (parent.gamecount!=gamount){
		oldObjDataFT=new Array();
	}
	if(top.odd_f_type==""||""+top.odd_f_type=="undefined") top.odd_f_type="H";
	keepscroll=body_browse.document.body.scrollTop;
	var conscroll= body_browse.document.getElementById('controlscroll');
	dis_ShowLoveI();

	//秀盤面
	showtables(GameFT,GameHead,gamount,top.odd_f_type);

	body_browse.scroll(0,keepscroll);

	//設定右方重新整理位置
	setRefreshPos();

	parent.gamecount=gamount;
	//日期下拉霸

	if (sel_gtype=="FU"){
		if (""+body_browse.document.getElementById('g_date')!="undefined"){
			body_browse.selgdate("r",g_date);
			body_browse.document.getElementById('g_date').value=g_date;
		}
	}

	if(top.showtype=='hgft'||top.showtype=='hgfu'){
		obj_sel = body_browse.document.getElementById('sel_league');
		obj_sel.style.display='none';
		try{
			var obj_date='';
			obj_date=body_browse.document.getElementById("g_date").value;
			body_browse.selgdate("",obj_date);
		}catch(E){}
	}else{
		
	}
	show_page();
	conscroll.style.display="none";
	coun_Leagues();
	body_browse.showPicLove();
	loadingOK();
}
var hotgdateArr =new Array();
function hot_gdate(gdate){
	if((""+hotgdateArr).indexOf(gdate)==-1){
		hotgdateArr.push(gdate);
	}
}
function coun_Leagues(){
	var coun=0;
	var str_tmp ="|"+eval('parent.'+sel_gtype+'_lname_ary');
	if(str_tmp=='|ALL'){
		body_browse.document.getElementById("str_num").innerHTML =top.alldata;
	}else{
		var larray=str_tmp.split('|');
		for(var i =0;i<larray.length;i++){
			if(larray[i]!=""){coun++}
		}
		coun =LeagueAry.length;
		body_browse.document.getElementById("str_num").innerHTML =coun;
	}
	
	
}
//表格函數
function showtables(GameData,Game_Head,data_amount,odd_f_type){
	ObjDataFT=new Array();
	myLeg=new Array();
	for (var j=0;j < data_amount;j++){
		if (GameData[j]!=null){
			ObjDataFT[j]=parseArray(Game_Head,GameData[j]);
		}
	}
	var trdata;
	var showtableData;
	if(body_browse.document.all){
	     	showtableData=body_browse.document.getElementById('showtableData').innerText ;
	     	trdata=body_browse.document.getElementById('DataTR').innerText;
	     	notrdata=body_browse.document.getElementById('NoDataTR').innerText;
	} else{
	     	showtableData=body_browse.document.getElementById('showtableData').textContent ;
	     	trdata=body_browse.document.getElementById('DataTR').textContent;
		notrdata=body_browse.document.getElementById('NoDataTR').textContent;
	}
	var showtable=body_browse.document.getElementById('showtable');
	var showlayers="";
	keepleg="";
	legnum=0;
	LeagueAry =new Array();
	if(ObjDataFT.length > 0){
	  	for ( i=0 ;i < ObjDataFT.length;i++){
	  			showlayers+=getLayer(trdata,i,odd_f_type);
	  	}
	  	if(showlayers=="")showlayers=notrdata;
	  	showtableData=showtableData.replace("*showDataTR*",showlayers);
	}else{
		showtableData=showtableData.replace("*showDataTR*",notrdata);
	}
	showtable.innerHTML=showtableData;
}


//表格內容
function getLayer(onelayer,gamerec,odd_f_type){
	var open_hot = false;
	if(MM_IdentificationDisplay(ObjDataFT[gamerec].datetime,ObjDataFT[gamerec].gnum_h)) return "";
	if(("|"+eval('parent.'+sel_gtype+'_lname_ary')).indexOf(("|"+ObjDataFT[gamerec].league+"|"),0)==-1&&eval('parent.'+sel_gtype+'_lname_ary')!='ALL') return "";
	if((""+LeagueAry).indexOf(ObjDataFT[gamerec].league)== -1)LeagueAry.push(ObjDataFT[gamerec].league);
	var tmp_date = ObjDataFT[gamerec].datetime.split("<br>")[0];
	onelayer=onelayer.replace(/\*ID_STR\*/g,tmp_date+ObjDataFT[gamerec].gnum_h);
	onelayer=onelayer.replace(/\*TR_EVENT\*/g,"onMouseOver='mouseEnter_pointer(this.id);' onMouseOut='mouseOut_pointer(this.id);'");

	if (""+myLeg[ObjDataFT[gamerec].league]=="undefined"){
			myLeg[ObjDataFT[gamerec].league]=ObjDataFT[gamerec].league;
			myLeg[ObjDataFT[gamerec].league]=new Array();
			myLeg[ObjDataFT[gamerec].league][0]=tmp_date+ObjDataFT[gamerec].gnum_h;
	}else{
			myLeg[ObjDataFT[gamerec].league][myLeg[ObjDataFT[gamerec].league].length]=tmp_date+ObjDataFT[gamerec].gnum_h;
	}

	//--------------判斷聯盟名稱列顯示或隱藏----------------
	if (ObjDataFT[gamerec].league==keepleg){
			onelayer=onelayer.replace("*ST*"," style='display: none;'");
	}else{
			onelayer=onelayer.replace("*ST*"," style='display: ;'");
	}
	//---------------------------------------------------------------------
	//--------------判斷聯盟底下的賽事顯示或隱藏----------------
	if (NoshowLeg[ObjDataFT[gamerec].league]==-1){
		onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: none;'");
		onelayer=onelayer.replace("*LegMark*","<span id='LegClose'></span>"); //聯盟的小圖
	}else{
		onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: ;'");
		onelayer=onelayer.replace("*LegMark*","<span id='LegOpen'></span>");  //聯盟的小圖
	}
	//---------------------------------------------------------------------

	//滾球字眼
	ObjDataFT[gamerec].datetime=ObjDataFT[gamerec].datetime.replace("Running Ball","");
	keepleg=ObjDataFT[gamerec].league;
	onelayer=onelayer.replace(/\*LEG\*/gi,ObjDataFT[gamerec].league);

	var tmp_date=ObjDataFT[gamerec].datetime.split("<br>");
	if (sel_gtype=="FU"){
		tmp_date_str=tmp_date[0]+"<br>"+change_time(tmp_date[1]);
	}else{
		tmp_date_str=change_time(tmp_date[1]);
	}
	if (tmp_date.length==3){
		tmp_date_str+="<br>"+tmp_date[2];
	}	
	onelayer=onelayer.replace("*DATETIME*",tmp_date_str);
	onelayer=onelayer.replace("*TEAM_H*",ObjDataFT[gamerec].team_h.replace("[Mid]","<font color=\"#005aff\">[N]</font>").replace("[中]","<font color=\"#005aff\">[中]</font>"));
	onelayer=onelayer.replace("*TEAM_C*",ObjDataFT[gamerec].team_c);
	//全場
	//波膽
	onelayer=onelayer.replace("*RATIO_H1C0*",parseUrl(uid,odd_f_type,"H1C0",ObjDataFT[gamerec],gamerec,"HPD"));
	onelayer=onelayer.replace("*RATIO_H2C0*",parseUrl(uid,odd_f_type,"H2C0",ObjDataFT[gamerec],gamerec,"HPD"));
	onelayer=onelayer.replace("*RATIO_H2C1*",parseUrl(uid,odd_f_type,"H2C1",ObjDataFT[gamerec],gamerec,"HPD"));
	onelayer=onelayer.replace("*RATIO_H3C0*",parseUrl(uid,odd_f_type,"H3C0",ObjDataFT[gamerec],gamerec,"HPD"));
	onelayer=onelayer.replace("*RATIO_H3C1*",parseUrl(uid,odd_f_type,"H3C1",ObjDataFT[gamerec],gamerec,"HPD"));
	onelayer=onelayer.replace("*RATIO_H3C2*",parseUrl(uid,odd_f_type,"H3C2",ObjDataFT[gamerec],gamerec,"HPD"));
	onelayer=onelayer.replace("*RATIO_H0C0*",parseUrl(uid,odd_f_type,"H0C0",ObjDataFT[gamerec],gamerec,"HPD"));
	onelayer=onelayer.replace("*RATIO_H1C1*",parseUrl(uid,odd_f_type,"H1C1",ObjDataFT[gamerec],gamerec,"HPD"));
	onelayer=onelayer.replace("*RATIO_H2C2*",parseUrl(uid,odd_f_type,"H2C2",ObjDataFT[gamerec],gamerec,"HPD"));
	onelayer=onelayer.replace("*RATIO_H3C3*",parseUrl(uid,odd_f_type,"H3C3",ObjDataFT[gamerec],gamerec,"HPD"));
	onelayer=onelayer.replace("*RATIO_OVH*",parseUrl(uid,odd_f_type,"OVH",ObjDataFT[gamerec],gamerec,"HPD"));
	onelayer=onelayer.replace("*RATIO_H0C1*",parseUrl(uid,odd_f_type,"H0C1",ObjDataFT[gamerec],gamerec,"HPD"));
	onelayer=onelayer.replace("*RATIO_H0C2*",parseUrl(uid,odd_f_type,"H0C2",ObjDataFT[gamerec],gamerec,"HPD"));
	onelayer=onelayer.replace("*RATIO_H1C2*",parseUrl(uid,odd_f_type,"H1C2",ObjDataFT[gamerec],gamerec,"HPD"));
	onelayer=onelayer.replace("*RATIO_H0C3*",parseUrl(uid,odd_f_type,"H0C3",ObjDataFT[gamerec],gamerec,"HPD"));
	onelayer=onelayer.replace("*RATIO_H1C3*",parseUrl(uid,odd_f_type,"H1C3",ObjDataFT[gamerec],gamerec,"HPD"));
	onelayer=onelayer.replace("*RATIO_H2C3*",parseUrl(uid,odd_f_type,"H2C3",ObjDataFT[gamerec],gamerec,"HPD"));

	return onelayer;
}


//取得下注的url
function parseUrl(uid,odd_f_type,rtype,GameData,gamerec,wtype){
	var urlArray=new Array();
	urlArray['PD']=new Array("../FT_order/FT_order_pd.php");
	urlArray['HPD']=new Array("../FT_order/FT_order_hpd.php");

	var param=getParam(uid,odd_f_type,rtype,wtype,GameData);
	var order=urlArray[wtype][0];
	var tmp_rtype="ior_"+rtype;
	var ioratio_str="GameData."+tmp_rtype;
	var team="";
	if (rtype=="OVH"){
		team="Other Score";
	}else{
		team=rtype.replace("H","").replace("C",":");
	}
	var ioratio=eval(ioratio_str);
 	//var ret="<a href='"+order+"?"+param+"' target='mem_order' title='"+team+"'><font "+check_ioratio(gamerec,tmp_rtype,GameData)+">"+ioratio+"</font></a>";
	//alert(parent.name)
	var ret="<a href='javascript://' onclick=\"parent.parent.mem_order.betOrder('FT','"+wtype+"','"+param+"');\" title='"+team+"'><font "+check_ioratio(gamerec,tmp_rtype,GameData)+">"+ioratio+"</font></a>";

	return ret;

}

//--------------------------public function --------------------------------

//取得下注參數
function getParam(uid,odd_f_type,rtype,wtype,GameData){
	var paramArray=new Array();
	paramArray['PD']=new Array("gid","uid","odd_f_type","rtype","langx");
	paramArray['HPD']=new Array("gid","uid","odd_f_type","rtype","langx");

	var param="";
	var gid=GameData.gid;

	for (var i=0;i<paramArray[wtype].length;i++){
		if (i>0)  param+="&";
		param+=paramArray[wtype][i]+"="+eval(paramArray[wtype][i]);
	}
	return param;
}

//--------------------------------public function ----------------------------

function setRefreshPos(){
		var refresh_right= body_browse.document.getElementById('refresh_right');
		refresh_right.style.left= body_browse.document.getElementById('myTable').clientWidth*1+20;
		//refresh_right.style.top= 39;
	}

function parseArray(gameHead,gameData){
	var gameObj=new Object();
	for (var i=0;i<gameHead.length;i++){
		if (gameHead[i]!=""){	
			eval("gameObj."+gameHead[i]+"='"+gameData[i]+"'");
		}
	}
	return gameObj;
}


function check_ioratio(rec,rtype,GameData){
//alert(flash_ior_set);
	//return true;
	//alert(GameFT.length+"----"+keepGameData.length)

	if (flash_ior_set =='Y'){
		//alert(oldObjDataFT[rec]);
		if (""+oldObjDataFT[rec]=="undefined" || oldObjDataFT[rec].gid != GameData.gid){
			var gameObj=new Object();
			gameObj.gid=GameData.gid;
			oldObjDataFT[rec]=gameObj;
		}
		
		var new_ioratio=eval("GameData."+rtype);
		var old_ioratio=eval("oldObjDataFT[rec]."+rtype);
		
		
		if (""+old_ioratio=="undefined"){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			old_ioratio=eval("oldObjDataFT[rec]."+rtype);
		}
		
		//alert("old_ioratio==>"+old_ioratio+",new_ioratio==>"+new_ioratio);
		if (""+new_ioratio=="undefined" || new_ioratio==""){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return;
		}
		
		/*
		if (parseFloat(old_ioratio)>parseFloat(new_ioratio) ){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='border: 1px solid #FF0000;' ";
		}
		if (parseFloat(old_ioratio)<parseFloat(new_ioratio) ){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='border: 1px solid #00FF00;' ";
		}
		*/
		
		if (old_ioratio!=new_ioratio && old_ioratio !="" && new_ioratio!="") {
	    	eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='background-color : yellow' ";
		}
		
		return true;
	}

}
//--------------判斷聯盟顯示或隱藏----------------
function showLeg(leg){
	for (var i=0;i<myLeg[leg].length;i++){
	if ( body_browse.document.getElementById("TR_"+myLeg[leg][i]).style.display!="none"){
				showLegIcon(leg,"LegClose",myLeg[leg][i],"none");
				
		}else{
			showLegIcon(leg,"LegOpen",myLeg[leg][i],"");
		}
	}
	if ((""+NoshowLeg[leg])=="undefined"){
		NoshowLeg[leg]=-1;
	}else{
		NoshowLeg[leg]=NoshowLeg[leg]*-1;
	}

}
function showLegIcon(leg,state,gnumH,display){
	var  ary=body_browse.document.getElementsByName(leg);
			
	for (var j=0;j<ary.length;j++){
		ary[j].innerHTML="<span id='"+state+"'></span>";
	}
	try{
		body_browse.document.getElementById("TR3_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR2_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR1_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR_"+gnumH).style.display=display;
	}catch(E){}
}
//----------------------

//分頁
function show_page(){
	//alert(rtype)
	pg_str='';
	obj_pg = body_browse.document.getElementById('pg_txt');
//	alert(t_page);
	if (t_page==0){
		t_page=1;
		//obj_pg.innerHTML = "";
		//return;
	}
	var tmp_lid="";
	if (rtype=="re"){
		tmp_lid=eval("parent."+sel_gtype+"_lid_ary_RE");
	}else{
		tmp_lid=eval("parent."+sel_gtype+"_lid_ary");
	}
	//alert(tmp_lid+"--"+top.swShowLoveI+"--"+t_page)
	if(tmp_lid=='ALL'&&!top.swShowLoveI){
		var disabled="";
		if (t_page==1){
			disabled="disabled";
			}
		var pghtml=(pg*1+1)+" / " +t_page+" "+top.page+"&nbsp;&nbsp; <select  onchange='chg_pg(this.options[this.selectedIndex].value)' "+disabled+">";
		for(var i=0;i<t_page;i++){
			if (pg==i){
		 		pghtml+="<option value='"+i+"' selected>"+(i+1)+"</option>";
		 	}else{
		  		pghtml+="<option value='"+i+"' >"+(i+1)+"</option>";
		  	}
		}
		pghtml+="</select>";
		obj_pg.innerHTML = pghtml;
	}else{
		obj_pg.innerHTML = "";
	}
}

//將時間 轉回 24小時//04:00p
function  change_time(get_time){
	
	if (get_time.indexOf("font") > 0 ) return get_time;
	if (get_time.indexOf("p")>0 || get_time.indexOf("a")>0){
		gtime=get_time.split(":");
		if (gtime[1].indexOf("p")>0){
			
			if (gtime[0]!="12"){
				gtime[0]=gtime[0]*1+12;
			}	
		}
		gtime[1]=gtime[1].replace("a","").replace("p","");
		
	}else{
		return get_time;
	}
	return gtime[0]+":"+gtime[1];
	
}

//隱藏我的最愛選擇聯賽
function dis_ShowLoveI(){

if(top.swShowLoveI){
  body_browse.document.getElementById("sel_league").style.display="none";
 }else{
  body_browse.document.getElementById("sel_league").style.display="";
 }
 
}


function changeTitleStr(s,at){
	if (s.charAt(at)=="H"){
		return "H";
	}else if(s.charAt(at)=="C"){
		return "A";
	}else if(s.charAt(at)=="N"){
		return "D";
	}
	return "";
}
function loadingOK(){
	//alert("loadingOK")
	try{
		body_browse.document.getElementById("refresh_btn").className="refresh_btn";
	}catch(E){}
	try{
	body_browse.document.getElementById("refresh_right").className="refresh_M_btn";
	}catch(E){}
	try{	
	body_browse.document.getElementById("refresh_down").className="refresh_M_btn";
	}catch(E){}
}
<?	
break;
case 'pd':
?>
var ObjDataFT=new Array();
var oldObjDataFT=new Array();
var keepleg="";
var legnum=0;
var NoshowLeg=new Array();
var myLeg=new Array();
var LeagueAry=new Array();

function ShowGameList(){
	if(loading == 'Y') return;
	if (parent.gamecount!=gamount){
		oldObjDataFT=new Array();
	}
	if(top.odd_f_type==""||""+top.odd_f_type=="undefined") top.odd_f_type="H";
	keepscroll=body_browse.document.body.scrollTop;
	var conscroll= body_browse.document.getElementById('controlscroll');
	dis_ShowLoveI();

	//秀盤面
	showtables(GameFT,GameHead,gamount,top.odd_f_type);

	body_browse.scroll(0,keepscroll);

	//設定右方重新整理位置
	setRefreshPos();

	parent.gamecount=gamount;
	//日期下拉霸

	if (sel_gtype=="FU"){
		if (""+body_browse.document.getElementById('g_date')!="undefined"){
			body_browse.selgdate("r",g_date);
			body_browse.document.getElementById('g_date').value=g_date;
		}
	}

	if(top.showtype=='hgft'||top.showtype=='hgfu'){
		obj_sel = body_browse.document.getElementById('sel_league');
		obj_sel.style.display='none';
		try{
			var obj_date='';
			obj_date=body_browse.document.getElementById("g_date").value;
			body_browse.selgdate("",obj_date);
		}catch(E){}
	}else{
		
	}
	show_page();
	conscroll.style.display="none";
	coun_Leagues();
	body_browse.showPicLove();
	loadingOK();
}
var hotgdateArr =new Array();
function hot_gdate(gdate){
	if((""+hotgdateArr).indexOf(gdate)==-1){
		hotgdateArr.push(gdate);
	}
}
function coun_Leagues(){
	var coun=0;
	var str_tmp ="|"+eval('parent.'+sel_gtype+'_lname_ary');
	if(str_tmp=='|ALL'){
		body_browse.document.getElementById("str_num").innerHTML =top.alldata;
	}else{
		var larray=str_tmp.split('|');
		for(var i =0;i<larray.length;i++){
			if(larray[i]!=""){coun++}
		}
		coun =LeagueAry.length;
		body_browse.document.getElementById("str_num").innerHTML =coun;
	}
	
	
}
//表格函數
function showtables(GameData,Game_Head,data_amount,odd_f_type){
	ObjDataFT=new Array();
	myLeg=new Array();
	for (var j=0;j < data_amount;j++){
		if (GameData[j]!=null){
			ObjDataFT[j]=parseArray(Game_Head,GameData[j]);
		}
	}
	var trdata;
	var showtableData;
	if(body_browse.document.all){
	     	showtableData=body_browse.document.getElementById('showtableData').innerText ;
	     	trdata=body_browse.document.getElementById('DataTR').innerText;
		notrdata=body_browse.document.getElementById('NoDataTR').innerText;
	} else{
		showtableData=body_browse.document.getElementById('showtableData').textContent ;
		trdata=body_browse.document.getElementById('DataTR').textContent;
		notrdata=body_browse.document.getElementById('NoDataTR').textContent;
	}
	var showtable=body_browse.document.getElementById('showtable');
	var showlayers="";
	keepleg="";
	legnum=0;
	LeagueAry =new Array();
	if(ObjDataFT.length > 0){
	  	for ( i=0 ;i < ObjDataFT.length;i++){
	  		showlayers+=getLayer(trdata,i,odd_f_type);
	  	}
	  	if(showlayers=="")showlayers=notrdata;
  		showtableData=showtableData.replace("*showDataTR*",showlayers);
	}else{
		showtableData=showtableData.replace("*showDataTR*",notrdata);
	}
	showtable.innerHTML=showtableData;
}


//表格內容
function getLayer(onelayer,gamerec,odd_f_type){
	var open_hot = false;
	if(MM_IdentificationDisplay(ObjDataFT[gamerec].datetime,ObjDataFT[gamerec].gnum_h)) return "";
	if(("|"+eval('parent.'+sel_gtype+'_lname_ary')).indexOf(("|"+ObjDataFT[gamerec].league+"|"),0)==-1&&eval('parent.'+sel_gtype+'_lname_ary')!='ALL') return "";
	if((""+LeagueAry).indexOf(ObjDataFT[gamerec].league)== -1)LeagueAry.push(ObjDataFT[gamerec].league);
	var tmp_date = ObjDataFT[gamerec].datetime.split("<br>")[0];
	onelayer=onelayer.replace(/\*ID_STR\*/g,tmp_date+ObjDataFT[gamerec].gnum_h);
	onelayer=onelayer.replace(/\*TR_EVENT\*/g,"onMouseOver='mouseEnter_pointer(this.id);' onMouseOut='mouseOut_pointer(this.id);'");

	if (""+myLeg[ObjDataFT[gamerec].league]=="undefined"){
			myLeg[ObjDataFT[gamerec].league]=ObjDataFT[gamerec].league;
			myLeg[ObjDataFT[gamerec].league]=new Array();
			myLeg[ObjDataFT[gamerec].league][0]=tmp_date+ObjDataFT[gamerec].gnum_h;
	}else{
			myLeg[ObjDataFT[gamerec].league][myLeg[ObjDataFT[gamerec].league].length]=tmp_date+ObjDataFT[gamerec].gnum_h;
	}

	//--------------判斷聯盟名稱列顯示或隱藏----------------
	if (ObjDataFT[gamerec].league==keepleg){
			onelayer=onelayer.replace("*ST*"," style='display: none;'");
	}else{
			onelayer=onelayer.replace("*ST*"," style='display: ;'");
	}
	//---------------------------------------------------------------------
	//--------------判斷聯盟底下的賽事顯示或隱藏----------------
	if (NoshowLeg[ObjDataFT[gamerec].league]==-1){
		onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: none;'");
		onelayer=onelayer.replace("*LegMark*","<span id='LegClose'></span>"); //聯盟的小圖
	}else{
		onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: ;'");
		onelayer=onelayer.replace("*LegMark*","<span id='LegOpen'></span>");  //聯盟的小圖
	}
	//---------------------------------------------------------------------

	//滾球字眼
	ObjDataFT[gamerec].datetime=ObjDataFT[gamerec].datetime.replace("Running Ball","");
	keepleg=ObjDataFT[gamerec].league;
	onelayer=onelayer.replace(/\*LEG\*/gi,ObjDataFT[gamerec].league);

	var tmp_date=ObjDataFT[gamerec].datetime.split("<br>");
	if (sel_gtype=="FU"){
		tmp_date_str=tmp_date[0]+"<br>"+change_time(tmp_date[1]);
	}else{
		tmp_date_str=change_time(tmp_date[1]);
	}
	if (tmp_date.length==3){
		tmp_date_str+="<br>"+tmp_date[2];
	}
	onelayer=onelayer.replace("*DATETIME*",tmp_date_str);
	onelayer=onelayer.replace("*TEAM_H*",ObjDataFT[gamerec].team_h.replace("[Mid]","<font color=\"#005aff\">[N]</font>").replace("[中]","<font color=\"#005aff\">[中]</font>"));
	onelayer=onelayer.replace("*TEAM_C*",ObjDataFT[gamerec].team_c);
	//全場
	//波膽
	onelayer=onelayer.replace("*RATIO_H1C0*",parseUrl(uid,odd_f_type,"H1C0",ObjDataFT[gamerec],gamerec,"PD"));
	onelayer=onelayer.replace("*RATIO_H2C0*",parseUrl(uid,odd_f_type,"H2C0",ObjDataFT[gamerec],gamerec,"PD"));
	onelayer=onelayer.replace("*RATIO_H2C1*",parseUrl(uid,odd_f_type,"H2C1",ObjDataFT[gamerec],gamerec,"PD"));
	onelayer=onelayer.replace("*RATIO_H3C0*",parseUrl(uid,odd_f_type,"H3C0",ObjDataFT[gamerec],gamerec,"PD"));
	onelayer=onelayer.replace("*RATIO_H3C1*",parseUrl(uid,odd_f_type,"H3C1",ObjDataFT[gamerec],gamerec,"PD"));
	onelayer=onelayer.replace("*RATIO_H3C2*",parseUrl(uid,odd_f_type,"H3C2",ObjDataFT[gamerec],gamerec,"PD"));
	onelayer=onelayer.replace("*RATIO_H4C0*",parseUrl(uid,odd_f_type,"H4C0",ObjDataFT[gamerec],gamerec,"PD"));
	onelayer=onelayer.replace("*RATIO_H4C1*",parseUrl(uid,odd_f_type,"H4C1",ObjDataFT[gamerec],gamerec,"PD"));
	onelayer=onelayer.replace("*RATIO_H4C2*",parseUrl(uid,odd_f_type,"H4C2",ObjDataFT[gamerec],gamerec,"PD"));
	onelayer=onelayer.replace("*RATIO_H4C3*",parseUrl(uid,odd_f_type,"H4C3",ObjDataFT[gamerec],gamerec,"PD"));
	onelayer=onelayer.replace("*RATIO_H0C0*",parseUrl(uid,odd_f_type,"H0C0",ObjDataFT[gamerec],gamerec,"PD"));
	onelayer=onelayer.replace("*RATIO_H1C1*",parseUrl(uid,odd_f_type,"H1C1",ObjDataFT[gamerec],gamerec,"PD"));
	onelayer=onelayer.replace("*RATIO_H2C2*",parseUrl(uid,odd_f_type,"H2C2",ObjDataFT[gamerec],gamerec,"PD"));
	onelayer=onelayer.replace("*RATIO_H3C3*",parseUrl(uid,odd_f_type,"H3C3",ObjDataFT[gamerec],gamerec,"PD"));
	onelayer=onelayer.replace("*RATIO_H4C4*",parseUrl(uid,odd_f_type,"H4C4",ObjDataFT[gamerec],gamerec,"PD"));
	onelayer=onelayer.replace("*RATIO_OVH*",parseUrl(uid,odd_f_type,"OVH",ObjDataFT[gamerec],gamerec,"PD"));
	onelayer=onelayer.replace("*RATIO_H0C1*",parseUrl(uid,odd_f_type,"H0C1",ObjDataFT[gamerec],gamerec,"PD"));
	onelayer=onelayer.replace("*RATIO_H0C2*",parseUrl(uid,odd_f_type,"H0C2",ObjDataFT[gamerec],gamerec,"PD"));
	onelayer=onelayer.replace("*RATIO_H1C2*",parseUrl(uid,odd_f_type,"H1C2",ObjDataFT[gamerec],gamerec,"PD"));
	onelayer=onelayer.replace("*RATIO_H0C3*",parseUrl(uid,odd_f_type,"H0C3",ObjDataFT[gamerec],gamerec,"PD"));
	onelayer=onelayer.replace("*RATIO_H1C3*",parseUrl(uid,odd_f_type,"H1C3",ObjDataFT[gamerec],gamerec,"PD"));
	onelayer=onelayer.replace("*RATIO_H2C3*",parseUrl(uid,odd_f_type,"H2C3",ObjDataFT[gamerec],gamerec,"PD"));
	onelayer=onelayer.replace("*RATIO_H0C4*",parseUrl(uid,odd_f_type,"H0C4",ObjDataFT[gamerec],gamerec,"PD"));
	onelayer=onelayer.replace("*RATIO_H1C4*",parseUrl(uid,odd_f_type,"H1C4",ObjDataFT[gamerec],gamerec,"PD"));
	onelayer=onelayer.replace("*RATIO_H2C4*",parseUrl(uid,odd_f_type,"H2C4",ObjDataFT[gamerec],gamerec,"PD"));
	onelayer=onelayer.replace("*RATIO_H3C4*",parseUrl(uid,odd_f_type,"H3C4",ObjDataFT[gamerec],gamerec,"PD"));
	
	return onelayer;
}


//取得下注的url
function parseUrl(uid,odd_f_type,rtype,GameData,gamerec,wtype){
	var urlArray=new Array();
	urlArray['PD']=new Array("../FT_order/FT_order_pd.php");
	urlArray['HPD']=new Array("../FT_order/FT_order_hpd.php");

	var param=getParam(uid,odd_f_type,rtype,wtype,GameData);
	var order=urlArray[wtype][0];
	var tmp_rtype="ior_"+rtype;
	var ioratio_str="GameData."+tmp_rtype;
	var team="";
	if (rtype=="OVH"){
		team="Other Score";
	}else{
		team=rtype.replace("H","").replace("C",":");
	}
	
	
	
	var ioratio=eval(ioratio_str);
 	//var ret="<a href='"+order+"?"+param+"' target='mem_order' title='"+team+"'><font "+check_ioratio(gamerec,tmp_rtype,GameData)+">"+ioratio+"</font></a>";
	//alert(parent.name)
	var ret="<a href='javascript://' onclick=\"parent.parent.mem_order.betOrder('FT','"+wtype+"','"+param+"');\" title='"+team+"'><font "+check_ioratio(gamerec,tmp_rtype,GameData)+">"+ioratio+"</font></a>";

	return ret;

}

//--------------------------public function --------------------------------

//取得下注參數
function getParam(uid,odd_f_type,rtype,wtype,GameData){
	var paramArray=new Array();
	paramArray['PD']=new Array("gid","uid","odd_f_type","rtype","langx");
	paramArray['HPD']=new Array("gid","uid","odd_f_type","rtype","langx");

	var param="";
	var gid=GameData.gid;

	for (var i=0;i<paramArray[wtype].length;i++){
		if (i>0)  param+="&";
		param+=paramArray[wtype][i]+"="+eval(paramArray[wtype][i]);
	}
	return param;
}


//--------------------------------public function ----------------------------

function setRefreshPos(){
		var refresh_right= body_browse.document.getElementById('refresh_right');
		refresh_right.style.left= body_browse.document.getElementById('myTable').clientWidth*1+20;
		//refresh_right.style.top= 39;
	}

function parseArray(gameHead,gameData){
	var gameObj=new Object();
	for (var i=0;i<gameHead.length;i++){
		if (gameHead[i]!=""){	
			eval("gameObj."+gameHead[i]+"='"+gameData[i]+"'");
		}
	}
	return gameObj;
}


function check_ioratio(rec,rtype,GameData){
//alert(flash_ior_set);
	//return true;
	//alert(GameFT.length+"----"+keepGameData.length)

	if (flash_ior_set =='Y'){
		//alert(oldObjDataFT[rec]);
		if (""+oldObjDataFT[rec]=="undefined" || oldObjDataFT[rec].gid != GameData.gid){
			var gameObj=new Object();
			gameObj.gid=GameData.gid;
			oldObjDataFT[rec]=gameObj;
		}
		
		var new_ioratio=eval("GameData."+rtype);
		var old_ioratio=eval("oldObjDataFT[rec]."+rtype);
		
		
		if (""+old_ioratio=="undefined"){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			old_ioratio=eval("oldObjDataFT[rec]."+rtype);
		}
		
		//alert("old_ioratio==>"+old_ioratio+",new_ioratio==>"+new_ioratio);
		if (""+new_ioratio=="undefined" || new_ioratio==""){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return;
		}
		
		/*
		if (parseFloat(old_ioratio)>parseFloat(new_ioratio) ){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='border: 1px solid #FF0000;' ";
		}
		if (parseFloat(old_ioratio)<parseFloat(new_ioratio) ){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='border: 1px solid #00FF00;' ";
		}
		*/
		
		if (old_ioratio!=new_ioratio && old_ioratio !="" && new_ioratio!="") {
	    	eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='background-color : yellow' ";
		}
		
		return true;
	}

}
//--------------判斷聯盟顯示或隱藏----------------
function showLeg(leg){
	for (var i=0;i<myLeg[leg].length;i++){
	if ( body_browse.document.getElementById("TR_"+myLeg[leg][i]).style.display!="none"){
				showLegIcon(leg,"LegClose",myLeg[leg][i],"none");
				
		}else{
			showLegIcon(leg,"LegOpen",myLeg[leg][i],"");
		}
	}
	if ((""+NoshowLeg[leg])=="undefined"){
		NoshowLeg[leg]=-1;
	}else{
		NoshowLeg[leg]=NoshowLeg[leg]*-1;
	}

}
function showLegIcon(leg,state,gnumH,display){
	var  ary=body_browse.document.getElementsByName(leg);
			
	for (var j=0;j<ary.length;j++){
		ary[j].innerHTML="<span id='"+state+"'></span>";
	}
	try{
		body_browse.document.getElementById("TR3_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR2_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR1_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR_"+gnumH).style.display=display;
	}catch(E){}
}
//----------------------

//分頁
function show_page(){
	//alert(rtype)
	pg_str='';
	obj_pg = body_browse.document.getElementById('pg_txt');
//	alert(t_page);
	if (t_page==0){
		t_page=1;
		//obj_pg.innerHTML = "";
		//return;
	}
	var tmp_lid="";
	if (rtype=="re"){
		tmp_lid=eval("parent."+sel_gtype+"_lid_ary_RE");
	}else{
		tmp_lid=eval("parent."+sel_gtype+"_lid_ary");
	}
	//alert(tmp_lid+"--"+top.swShowLoveI+"--"+t_page)
	if(tmp_lid=='ALL'&&!top.swShowLoveI){
		var disabled="";
		if (t_page==1){
			disabled="disabled";
			}
		var pghtml=(pg*1+1)+" / " +t_page+" "+top.page+"&nbsp;&nbsp; <select  onchange='chg_pg(this.options[this.selectedIndex].value)' "+disabled+">";
		for(var i=0;i<t_page;i++){
			if (pg==i){
		 		pghtml+="<option value='"+i+"' selected>"+(i+1)+"</option>";
		 	}else{
		  		pghtml+="<option value='"+i+"' >"+(i+1)+"</option>";
		  	}
		}
		pghtml+="</select>";
		obj_pg.innerHTML = pghtml;
	}else{
		obj_pg.innerHTML = "";
	}
}

//將時間 轉回 24小時//04:00p
function  change_time(get_time){
	
	if (get_time.indexOf("font") > 0 ) return get_time;
	if (get_time.indexOf("p")>0 || get_time.indexOf("a")>0){
		gtime=get_time.split(":");
		if (gtime[1].indexOf("p")>0){
			
			if (gtime[0]!="12"){
				gtime[0]=gtime[0]*1+12;
			}	
		}
		gtime[1]=gtime[1].replace("a","").replace("p","");
		
	}else{
		return get_time;
	}
	return gtime[0]+":"+gtime[1];
	
}

//隱藏我的最愛選擇聯賽
function dis_ShowLoveI(){

if(top.swShowLoveI){
  body_browse.document.getElementById("sel_league").style.display="none";
 }else{
  body_browse.document.getElementById("sel_league").style.display="";
 }
 
}


function changeTitleStr(s,at){
	if (s.charAt(at)=="H"){
		return "H";
	}else if(s.charAt(at)=="C"){
		return "A";
	}else if(s.charAt(at)=="N"){
		return "D";
	}
	return "";
}
function loadingOK(){
	//alert("loadingOK")
	try{
		body_browse.document.getElementById("refresh_btn").className="refresh_btn";
	}catch(E){}
	try{
	body_browse.document.getElementById("refresh_right").className="refresh_M_btn";
	}catch(E){}
	try{	
	body_browse.document.getElementById("refresh_down").className="refresh_M_btn";
	}catch(E){}
}
<?	
break;
case 't':
?>
var ObjDataFT=new Array();
var oldObjDataFT=new Array();
//var GameHead=new Array("gid","datetime","league","gnum_h","gnum_c","team_h","team_c","strong","ior_H1C0","ior_H2C0","ior_H2C1","ior_H3C0","ior_H3C1","ior_H3C2","ior_H4C0","ior_H4C1","ior_H4C2","ior_H4C3","ior_H0C0","ior_H1C1","ior_H2C2","ior_H3C3","ior_H4C4","ior_OVH","ior_H0C1","ior_H0C2","ior_H1C2","ior_H0C3","ior_H1C3","ior_H2C3","ior_H0C4","ior_H1C4","ior_H2C4","ior_H3C4","ior_OVC");
var keepleg="";
var legnum=0;
var NoshowLeg=new Array();
var myLeg=new Array();
var LeagueAry=new Array();

function ShowGameList(){
	if(loading == 'Y') return;
	if (parent.gamecount!=gamount){
		oldObjDataFT=new Array();
	}
	if(top.odd_f_type==""||""+top.odd_f_type=="undefined") top.odd_f_type="H";
	keepscroll=body_browse.document.body.scrollTop;
	var conscroll= body_browse.document.getElementById('controlscroll');

	dis_ShowLoveI();

	//秀盤面
	showtables(GameFT,GameHead,gamount,top.odd_f_type);

	body_browse.scroll(0,keepscroll);

	//設定右方重新整理位置
	setRefreshPos();

	parent.gamecount=gamount;
	//日期下拉霸

	if (sel_gtype=="FU"){
		if (""+body_browse.document.getElementById('g_date')!="undefined"){
			body_browse.selgdate("t",g_date);
			body_browse.document.getElementById('g_date').value=g_date;
		}
	}
	if (top.hot_game!=""){
		body_browse.document.getElementById('sel_league').style.display='none';
		show_page();
 	}else{
 			
	if(top.showtype=='hgft'||top.showtype=='hgfu'){
		obj_sel = body_browse.document.getElementById('sel_league');
		obj_sel.style.display='none';
		try{
			var obj_date='';
			obj_date=body_browse.document.getElementById("g_date").value;
			body_browse.selgdate("",obj_date);
		}catch(E){}
	}else{
		show_page();
	}
	
 }	
	conscroll.style.display="none";
	coun_Leagues();
	body_browse.showPicLove();
	loadingOK();
	
		try{
		parent.mem_order.document.getElementById('today_btn').className="today_btn";
		parent.mem_order.document.getElementById('early_btn').className="early_btn";
		}catch(E){}		
			
	parent.mem_order.getCountHOT(gameCount);
	//showHOT(gameCount);
}
var hotgdateArr =new Array();
function hot_gdate(gdate){
	if((""+hotgdateArr).indexOf(gdate)==-1){
		hotgdateArr.push(gdate);
	}
}
function coun_Leagues(){
	var coun=0;
	var str_tmp ="|"+eval('parent.'+sel_gtype+'_lname_ary');
	if(str_tmp=='|ALL'){
		body_browse.document.getElementById("str_num").innerHTML =top.alldata;
	}else{
		var larray=str_tmp.split('|');
		for(var i =0;i<larray.length;i++){
			if(larray[i]!=""){coun++}
		}
		coun =LeagueAry.length;
		body_browse.document.getElementById("str_num").innerHTML =coun;
	}
	
	
}
//表格函數
function showtables(GameData,Game_Head,data_amount,odd_f_type){
	ObjDataFT=new Array();
	myLeg=new Array();
	for (var j=0;j < data_amount;j++){
		if (GameData[j]!=null){
			ObjDataFT[j]=parseArray(Game_Head,GameData[j]);
		}
	}
	var trdata;
	var showtableData;
	if(body_browse.document.all){
	     	showtableData=body_browse.document.getElementById('showtableData').innerText ;
	     	trdata=body_browse.document.getElementById('DataTR').innerText;
	     	notrdata=body_browse.document.getElementById('NoDataTR').innerText;
	} else{
	     	showtableData=body_browse.document.getElementById('showtableData').textContent ;
	     	trdata=body_browse.document.getElementById('DataTR').textContent;
	     	notrdata=body_browse.document.getElementById('NoDataTR').textContent;
	}
	var showtable=body_browse.document.getElementById('showtable');
	var showlayers="";
	keepleg="";
	legnum=0;
	LeagueAry =new Array();
	if(ObjDataFT.length > 0){
	  	for ( i=0 ;i < ObjDataFT.length;i++){
	  			showlayers+=getLayer(trdata,i,odd_f_type);
	  	}
	  	if(showlayers=="")showlayers=notrdata;
		showtableData=showtableData.replace("*showDataTR*",showlayers);
	}else{
		showtableData=showtableData.replace("*showDataTR*",notrdata);
	}
	showtable.innerHTML=showtableData;
}


//表格內容
function getLayer(onelayer,gamerec,odd_f_type){
	var open_hot = false;
	if(MM_IdentificationDisplay(ObjDataFT[gamerec].datetime,ObjDataFT[gamerec].gnum_h)) return "";
	if (top.hot_game==""){
		if(("|"+eval('parent.'+sel_gtype+'_lname_ary')).indexOf(("|"+ObjDataFT[gamerec].league+"|"),0)==-1&&eval('parent.'+sel_gtype+'_lname_ary')!='ALL') return "";
		if((""+LeagueAry).indexOf(ObjDataFT[gamerec].league)== -1)LeagueAry.push(ObjDataFT[gamerec].league);
	}
	var tmp_date = ObjDataFT[gamerec].datetime.split("<br>")[0];
	onelayer=onelayer.replace(/\*ID_STR\*/g,tmp_date+ObjDataFT[gamerec].gnum_h);
	onelayer=onelayer.replace(/\*TR_EVENT\*/g,"onMouseOver='mouseEnter_pointer(this.id);' onMouseOut='mouseOut_pointer(this.id);'");

	if (""+myLeg[ObjDataFT[gamerec].league]=="undefined"){
			myLeg[ObjDataFT[gamerec].league]=ObjDataFT[gamerec].league;
			myLeg[ObjDataFT[gamerec].league]=new Array();
			myLeg[ObjDataFT[gamerec].league][0]=tmp_date+ObjDataFT[gamerec].gnum_h;
	}else{
			myLeg[ObjDataFT[gamerec].league][myLeg[ObjDataFT[gamerec].league].length]=tmp_date+ObjDataFT[gamerec].gnum_h;
	}

	//--------------判斷聯盟名稱列顯示或隱藏----------------
	if (ObjDataFT[gamerec].league==keepleg){
			onelayer=onelayer.replace("*ST*"," style='display: none;'");
	}else{
			onelayer=onelayer.replace("*ST*"," style='display: ;'");
	}
	//---------------------------------------------------------------------
	//--------------判斷聯盟底下的賽事顯示或隱藏----------------
	if (NoshowLeg[ObjDataFT[gamerec].league]==-1){
		onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: none;'");
		onelayer=onelayer.replace("*LegMark*","<span id='LegClose'></span>"); //聯盟的小圖
	}else{
		onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: ;'");
		onelayer=onelayer.replace("*LegMark*","<span id='LegOpen'></span>");  //聯盟的小圖
	}
	//---------------------------------------------------------------------

	//滾球字眼
	ObjDataFT[gamerec].datetime=ObjDataFT[gamerec].datetime.replace("Running Ball","");
	keepleg=ObjDataFT[gamerec].league;
	onelayer=onelayer.replace(/\*LEG\*/gi,ObjDataFT[gamerec].league);

	var tmp_date=ObjDataFT[gamerec].datetime.split("<br>");
	if (sel_gtype=="FU"){
		tmp_date_str=tmp_date[0]+"<br>"+change_time(tmp_date[1]);
	}else{
		tmp_date_str=change_time(tmp_date[1]);
	}
	if (tmp_date.length==3){
		tmp_date_str+="<br>"+tmp_date[2];
	}	
	onelayer=onelayer.replace("*DATETIME*",tmp_date_str);
	onelayer=onelayer.replace("*TEAM_H*",ObjDataFT[gamerec].team_h.replace("[Mid]","<font color=\"#005aff\">[N]</font>").replace("[中]","<font color=\"#005aff\">[中]</font>"));
	onelayer=onelayer.replace("*TEAM_C*",ObjDataFT[gamerec].team_c);
	//全場
	//單雙
	onelayer=onelayer.replace("*RATIO_ODD*",parseUrl(uid,odd_f_type,"ODD",ObjDataFT[gamerec],gamerec,"T"));
	onelayer=onelayer.replace("*RATIO_EVEN*",parseUrl(uid,odd_f_type,"EVEN",ObjDataFT[gamerec],gamerec,"T"));
	//入球數
	onelayer=onelayer.replace("*RATIO_T01*",parseUrl(uid,odd_f_type,"T01",ObjDataFT[gamerec],gamerec,"T"));
	onelayer=onelayer.replace("*RATIO_T23*",parseUrl(uid,odd_f_type,"T23",ObjDataFT[gamerec],gamerec,"T"));
	onelayer=onelayer.replace("*RATIO_T46*",parseUrl(uid,odd_f_type,"T46",ObjDataFT[gamerec],gamerec,"T"));
	onelayer=onelayer.replace("*RATIO_OVER*",parseUrl(uid,odd_f_type,"OVER",ObjDataFT[gamerec],gamerec,"T"));

	return onelayer;
}


//取得下注的url
function parseUrl(uid,odd_f_type,rtype,GameData,gamerec,wtype){
	var urlArray=new Array();
	urlArray['T']=new Array("../FT_order/FT_order_t.php");

	var paramRtype = new Array();
	paramRtype['ODD'] = "ODD";
	paramRtype['EVEN'] = "EVEN";
	paramRtype['T01'] = "0~1";
	paramRtype['T23'] = "2~3";
	paramRtype['T46'] = "4~6";
	paramRtype['OVER'] = "OVER";
	
	var param=getParam(uid,odd_f_type,paramRtype[rtype],wtype,GameData);
	var order=urlArray[wtype][0];
	var tmp_rtype="ior_"+rtype;
	var ioratio_str="GameData."+tmp_rtype;
	
	var team="";
	if (rtype=="OVER"){
		team="7up";
	}else if (rtype=="ODD"){
		team=top.strOdd;
	}else if (rtype=="EVEN"){
		team=top.strEven;
	}else{	
		team=paramRtype[rtype];
	}
	
	
	
	var ioratio=eval(ioratio_str);
 	//var ret="<a href='"+order+"?"+param+"' target='mem_order' title='"+team+"'><font "+check_ioratio(gamerec,tmp_rtype,GameData)+">"+ioratio+"</font></a>";
	//alert(parent.name)
	var ret="<a href='javascript://' onclick=\"parent.parent.mem_order.betOrder('FT','"+wtype+"','"+param+"');\" title='"+team+"'><font "+check_ioratio(gamerec,tmp_rtype,GameData)+">"+ioratio+"</font></a>";

	return ret;

}

//--------------------------public function --------------------------------

//取得下注參數
function getParam(uid,odd_f_type,rtype,wtype,GameData){
	var paramArray=new Array();
	paramArray['T']=new Array("gid","uid","odd_f_type","rtype","langx");

	var param="";
	var gid=GameData.gid;

	for (var i=0;i<paramArray[wtype].length;i++){
		if (i>0)  param+="&";
		param+=paramArray[wtype][i]+"="+eval(paramArray[wtype][i]);
	}
	return param;
}

//--------------------------------public function ----------------------------

function setRefreshPos(){
		var refresh_right= body_browse.document.getElementById('refresh_right');
		refresh_right.style.left= body_browse.document.getElementById('myTable').clientWidth*1+20;
		//refresh_right.style.top= 39;
	}

function parseArray(gameHead,gameData){
	var gameObj=new Object();
	for (var i=0;i<gameHead.length;i++){
		if (gameHead[i]!=""){	
			eval("gameObj."+gameHead[i]+"='"+gameData[i]+"'");
		}
	}
	return gameObj;
}


function check_ioratio(rec,rtype,GameData){
//alert(flash_ior_set);
	//return true;
	//alert(GameFT.length+"----"+keepGameData.length)

	if (flash_ior_set =='Y'){
		//alert(oldObjDataFT[rec]);
		if (""+oldObjDataFT[rec]=="undefined" || oldObjDataFT[rec].gid != GameData.gid){
			var gameObj=new Object();
			gameObj.gid=GameData.gid;
			oldObjDataFT[rec]=gameObj;
		}
		
		var new_ioratio=eval("GameData."+rtype);
		var old_ioratio=eval("oldObjDataFT[rec]."+rtype);
		
		
		if (""+old_ioratio=="undefined"){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			old_ioratio=eval("oldObjDataFT[rec]."+rtype);
		}
		
		//alert("old_ioratio==>"+old_ioratio+",new_ioratio==>"+new_ioratio);
		if (""+new_ioratio=="undefined" || new_ioratio==""){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return;
		}
		
		/*
		if (parseFloat(old_ioratio)>parseFloat(new_ioratio) ){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='border: 1px solid #FF0000;' ";
		}
		if (parseFloat(old_ioratio)<parseFloat(new_ioratio) ){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='border: 1px solid #00FF00;' ";
		}
		*/
		
		if (old_ioratio!=new_ioratio && old_ioratio !="" && new_ioratio!="") {
	    	eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='background-color : yellow' ";
		}
		
		return true;
	}

}
//--------------判斷聯盟顯示或隱藏----------------
function showLeg(leg){
	for (var i=0;i<myLeg[leg].length;i++){
	if ( body_browse.document.getElementById("TR_"+myLeg[leg][i]).style.display!="none"){
				showLegIcon(leg,"LegClose",myLeg[leg][i],"none");
				
		}else{
			showLegIcon(leg,"LegOpen",myLeg[leg][i],"");
		}
	}
	if ((""+NoshowLeg[leg])=="undefined"){
		NoshowLeg[leg]=-1;
	}else{
		NoshowLeg[leg]=NoshowLeg[leg]*-1;
	}

}
function showLegIcon(leg,state,gnumH,display){
	var  ary=body_browse.document.getElementsByName(leg);
			
	for (var j=0;j<ary.length;j++){
		ary[j].innerHTML="<span id='"+state+"'></span>";
	}
	try{
		body_browse.document.getElementById("TR3_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR2_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR1_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR_"+gnumH).style.display=display;
	}catch(E){}
}
//----------------------

//分頁
function show_page(){
	//alert(rtype)
	pg_str='';
	obj_pg = body_browse.document.getElementById('pg_txt');
//	alert(t_page);
	if (t_page==0){
		t_page=1;
		//obj_pg.innerHTML = "";
		//return;
	}
	var tmp_lid="";
	if (rtype=="re"){
		tmp_lid=eval("parent."+sel_gtype+"_lid_ary_RE");
	}else{
		tmp_lid=eval("parent."+sel_gtype+"_lid_ary");
	}
	//alert(tmp_lid+"--"+top.swShowLoveI+"--"+t_page)
	if(tmp_lid=='ALL'&&!top.swShowLoveI){
		var disabled="";
		if (t_page==1){
			disabled="disabled";
			}
		var pghtml=(pg*1+1)+" / " +t_page+" "+top.page+"&nbsp;&nbsp; <select  onchange='chg_pg(this.options[this.selectedIndex].value)' "+disabled+">";
		for(var i=0;i<t_page;i++){
			if (pg==i){
		 		pghtml+="<option value='"+i+"' selected>"+(i+1)+"</option>";
		 	}else{
		  		pghtml+="<option value='"+i+"' >"+(i+1)+"</option>";
		  	}
		}
		pghtml+="</select>";
		obj_pg.innerHTML = pghtml;
	}else{
		obj_pg.innerHTML = "";
	}
}

//將時間 轉回 24小時//04:00p
function  change_time(get_time){
	
	if (get_time.indexOf("font") > 0 ) return get_time;
	if (get_time.indexOf("p")>0 || get_time.indexOf("a")>0){
		gtime=get_time.split(":");
		if (gtime[1].indexOf("p")>0){
			
			if (gtime[0]!="12"){
				gtime[0]=gtime[0]*1+12;
			}	
		}
		gtime[1]=gtime[1].replace("a","").replace("p","");
		
	}else{
		return get_time;
	}
	return gtime[0]+":"+gtime[1];
	
}

//隱藏我的最愛選擇聯賽
function dis_ShowLoveI(){

if(top.swShowLoveI){
  body_browse.document.getElementById("sel_league").style.display="none";
 }else{
  body_browse.document.getElementById("sel_league").style.display="";
 }
 
}


function changeTitleStr(s,at){
	if (s.charAt(at)=="H"){
		return "H";
	}else if(s.charAt(at)=="C"){
		return "A";
	}else if(s.charAt(at)=="N"){
		return "D";
	}
	return "";
}


function loadingOK(){
	//alert("loadingOK")
	try{
		body_browse.document.getElementById("refresh_btn").className="refresh_btn";
	}catch(E){}
	try{
	body_browse.document.getElementById("refresh_right").className="refresh_M_btn";
	}catch(E){}
	try{	
	body_browse.document.getElementById("refresh_down").className="refresh_M_btn";
	}catch(E){}
}


var gameCount="";
var recordHash=new Array();
function showHOT(countHOT){
	if(""+top.hot_game=="undefined"){
		top.hot_game="";
	}	
	var gtypeHOT =new Array("FT","BK","TN","VB","OP");
	var countgames=countHOT.split(",");
	recordHash=new Array();
	var head_str="";
	
	if(rtype == "re"){
		head_str="RB";
	}else{
		head_str=top.head_FU;
	}
	//alert(head_str);
	
	for( var i=0;i<countgames.length;i++){
		var detailgame=countgames[i].split("|");
		recordHash[detailgame[0]+"_"+detailgame[1]]=detailgame[2]*1;
	}
	if(recordHash[top.head_gtype+"_HOT_"+head_str]*1==0){
		body_browse.document.getElementById("euro_btn").style.display="none";
		body_browse.document.getElementById("euro_up").style.display="none";
		//body_browse.document.getElementById("euro_close").style.display="";
		if(top.hot_game!=""){
			top.hot_game="";
			body_browse.reload_var();
		}
	}else{	
		if(top.hot_game!=""){
			body_browse.document.getElementById("euro_btn").style.display="none";
			body_browse.document.getElementById("euro_up").style.display="";
		}else{
			body_browse.document.getElementById("euro_btn").style.display="";
			body_browse.document.getElementById("euro_up").style.display="none";
		}
		//body_browse.document.getElementById("euro_close").style.display="none";	
	}
	//alert(recordHash[top.head_gtype+"_HOT_RB"]);
	//alert(recordHash[top.head_gtype+"_HOT_FT"]);
	//alert(recordHash[top.head_gtype+"_HOT_FU"]);
	//parent.mem_order.showHOT(recordHash[top.head_gtype+"_HOT_FT"],recordHash[top.head_gtype+"_HOT_FU"]);
	//parent.mem_order.showHOT(recordHash["FT_HOT_FT"],recordHash["FT_HOT_FU"]);
	/*
	var today_hot=0;
	var early_hot=0;
	for( var i=0;i<gtypeHOT.length;i++){
		try{
		parent.mem_order.document.getElementById(gtypeHOT[i]+"_FT").innerHTML=eval("top.str_"+gtypeHOT[i]) + "("+recordHash[gtypeHOT[i]+"_HOT_FT"]+")";
		parent.mem_order.document.getElementById(gtypeHOT[i]+"_FU").innerHTML=eval("top.str_"+gtypeHOT[i]) + "("+recordHash[gtypeHOT[i]+"_HOT_FU"]+")";
		}catch(E){}
			
		today_hot +=recordHash[gtypeHOT[i]+"_HOT_FT"];
		early_hot +=recordHash[gtypeHOT[i]+"_HOT_FU"];
	}	
	
		parent.mem_order.showHOT(today_hot,early_hot);
	*/	
	try{
		parent.mem_order.getCountHOT(countHOT);
	}catch(e){}
			
}

 

<?	
break;
case 'f':
?>
var ObjDataFT=new Array();
var oldObjDataFT=new Array();
var keepleg="";
var legnum=0;
var NoshowLeg=new Array();
var myLeg=new Array();
var LeagueAry=new Array();

function ShowGameList(){
	if(loading == 'Y') return;
	if (parent.gamecount!=gamount){
		oldObjDataFT=new Array();
	}
	if(top.odd_f_type==""||""+top.odd_f_type=="undefined") top.odd_f_type="H";
	keepscroll=body_browse.document.body.scrollTop;
	var conscroll= body_browse.document.getElementById('controlscroll');

	dis_ShowLoveI();

	//秀盤面
	showtables(GameFT,GameHead,gamount,top.odd_f_type);

	body_browse.scroll(0,keepscroll);

	//設定右方重新整理位置
	setRefreshPos();

	parent.gamecount=gamount;
	//日期下拉霸

	if (sel_gtype=="FU"){
		if (""+body_browse.document.getElementById('g_date')!="undefined"){
			body_browse.selgdate("r",g_date);
			body_browse.document.getElementById('g_date').value=g_date;
		}
	}

	if(top.showtype=='hgft'||top.showtype=='hgfu'){
		obj_sel = body_browse.document.getElementById('sel_league');
		obj_sel.style.display='none';
		try{
			var obj_date='';
			obj_date=body_browse.document.getElementById("g_date").value;
			body_browse.selgdate("",obj_date);
		}catch(E){}
	}else{
		show_page();
	}
	conscroll.style.display="none";
	coun_Leagues();
	body_browse.showPicLove();
	loadingOK();
}
var hotgdateArr =new Array();
function hot_gdate(gdate){
	if((""+hotgdateArr).indexOf(gdate)==-1){
		hotgdateArr.push(gdate);
	}
}
function coun_Leagues(){
	var coun=0;
	var str_tmp ="|"+eval('parent.'+sel_gtype+'_lname_ary');
	if(str_tmp=='|ALL'){
		body_browse.document.getElementById("str_num").innerHTML =top.alldata;
	}else{
		var larray=str_tmp.split('|');
		for(var i =0;i<larray.length;i++){
			if(larray[i]!=""){coun++}
		}
		coun =LeagueAry.length;
		body_browse.document.getElementById("str_num").innerHTML =coun;
	}
	
	
}

//表格函數
function showtables(GameData,Game_Head,data_amount,odd_f_type){
	ObjDataFT=new Array();
	myLeg=new Array();
	for (var j=0;j < data_amount;j++){
		if (GameData[j]!=null){
			ObjDataFT[j]=parseArray(Game_Head,GameData[j]);
		}
	}
	var trdata;
	var showtableData;
	if(body_browse.document.all){
	     	showtableData=body_browse.document.getElementById('showtableData').innerText ;
	     	trdata=body_browse.document.getElementById('DataTR').innerText;
     		notrdata=body_browse.document.getElementById('NoDataTR').innerText;
	} else{
	     	showtableData=body_browse.document.getElementById('showtableData').textContent ;
	     	trdata=body_browse.document.getElementById('DataTR').textContent;
     		notrdata=body_browse.document.getElementById('NoDataTR').textContent;
	}
	var showtable=body_browse.document.getElementById('showtable');
	var showlayers="";
	keepleg="";
	legnum=0;
	LeagueAry =new Array();
	if(ObjDataFT.length > 0){
	  	for ( i=0 ;i < ObjDataFT.length;i++){
	  			showlayers+=getLayer(trdata,i,odd_f_type);
	  	}
	  	if(showlayers=="")showlayers=notrdata;
		showtableData=showtableData.replace("*showDataTR*",showlayers);
	}else{
		showtableData=showtableData.replace("*showDataTR*",notrdata);
	}
	showtable.innerHTML=showtableData;
}


//表格內容
function getLayer(onelayer,gamerec,odd_f_type){
	var open_hot = false;
	if(MM_IdentificationDisplay(ObjDataFT[gamerec].datetime,ObjDataFT[gamerec].gnum_h)) return "";
	if(("|"+eval('parent.'+sel_gtype+'_lname_ary')).indexOf(("|"+ObjDataFT[gamerec].league+"|"),0)==-1&&eval('parent.'+sel_gtype+'_lname_ary')!='ALL') return "";
	if((""+LeagueAry).indexOf(ObjDataFT[gamerec].league)== -1)LeagueAry.push(ObjDataFT[gamerec].league);
	var tmp_date = ObjDataFT[gamerec].datetime.split("<br>")[0];
	onelayer=onelayer.replace(/\*ID_STR\*/g,tmp_date+ObjDataFT[gamerec].gnum_h);
	onelayer=onelayer.replace(/\*TR_EVENT\*/g,"onMouseOver='mouseEnter_pointer(this.id);' onMouseOut='mouseOut_pointer(this.id);'");

	if (""+myLeg[ObjDataFT[gamerec].league]=="undefined"){
			myLeg[ObjDataFT[gamerec].league]=ObjDataFT[gamerec].league;
			myLeg[ObjDataFT[gamerec].league]=new Array();
			myLeg[ObjDataFT[gamerec].league][0]=tmp_date+ObjDataFT[gamerec].gnum_h;
	}else{
			myLeg[ObjDataFT[gamerec].league][myLeg[ObjDataFT[gamerec].league].length]=tmp_date+ObjDataFT[gamerec].gnum_h;
	}

	//--------------判斷聯盟名稱列顯示或隱藏----------------
	if (ObjDataFT[gamerec].league==keepleg){
			onelayer=onelayer.replace("*ST*"," style='display: none;'");
	}else{
			onelayer=onelayer.replace("*ST*"," style='display: ;'");
	}
	//---------------------------------------------------------------------
	//--------------判斷聯盟底下的賽事顯示或隱藏----------------
	if (NoshowLeg[ObjDataFT[gamerec].league]==-1){
		onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: none;'");
		onelayer=onelayer.replace("*LegMark*","<span id='LegClose'></span>"); //聯盟的小圖
	}else{
		onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: ;'");
		onelayer=onelayer.replace("*LegMark*","<span id='LegOpen'></span>");  //聯盟的小圖
	}
	//---------------------------------------------------------------------


	//滾球字眼
	ObjDataFT[gamerec].datetime=ObjDataFT[gamerec].datetime.replace("Running Ball","");
	keepleg=ObjDataFT[gamerec].league;
	onelayer=onelayer.replace(/\*LEG\*/gi,ObjDataFT[gamerec].league);

	var tmp_date=ObjDataFT[gamerec].datetime.split("<br>");
	if (sel_gtype=="FU"){
		tmp_date_str=tmp_date[0]+"<br>"+change_time(tmp_date[1]);
	}else{
		tmp_date_str=change_time(tmp_date[1]);
	}
	if (tmp_date.length==3){
		tmp_date_str+="<br>"+tmp_date[2];
	}	
	onelayer=onelayer.replace("*DATETIME*",tmp_date_str);
	onelayer=onelayer.replace("*TEAM_H*",ObjDataFT[gamerec].team_h.replace("[Mid]","<font color=\"#005aff\">[N]</font>").replace("[中]","<font color=\"#005aff\">[中]</font>"));
	onelayer=onelayer.replace("*TEAM_C*",ObjDataFT[gamerec].team_c);
	//全場
	//半全場
	onelayer=onelayer.replace("*RATIO_FHH*",parseUrl(uid,odd_f_type,"FHH",ObjDataFT[gamerec],gamerec,"F"));
	onelayer=onelayer.replace("*RATIO_FHN*",parseUrl(uid,odd_f_type,"FHN",ObjDataFT[gamerec],gamerec,"F"));
	onelayer=onelayer.replace("*RATIO_FHC*",parseUrl(uid,odd_f_type,"FHC",ObjDataFT[gamerec],gamerec,"F"));
	onelayer=onelayer.replace("*RATIO_FNH*",parseUrl(uid,odd_f_type,"FNH",ObjDataFT[gamerec],gamerec,"F"));
	onelayer=onelayer.replace("*RATIO_FNN*",parseUrl(uid,odd_f_type,"FNN",ObjDataFT[gamerec],gamerec,"F"));
	onelayer=onelayer.replace("*RATIO_FNC*",parseUrl(uid,odd_f_type,"FNC",ObjDataFT[gamerec],gamerec,"F"));
	onelayer=onelayer.replace("*RATIO_FCH*",parseUrl(uid,odd_f_type,"FCH",ObjDataFT[gamerec],gamerec,"F"));
	onelayer=onelayer.replace("*RATIO_FCN*",parseUrl(uid,odd_f_type,"FCN",ObjDataFT[gamerec],gamerec,"F"));
	onelayer=onelayer.replace("*RATIO_FCC*",parseUrl(uid,odd_f_type,"FCC",ObjDataFT[gamerec],gamerec,"F"));

	return onelayer;
}

//取得下注的url
function parseUrl(uid,odd_f_type,rtype,GameData,gamerec,wtype){
	var urlArray=new Array();
	urlArray['F']=new Array("../FT_order/FT_order_f.php");

	var param=getParam(uid,odd_f_type,rtype,wtype,GameData);
	var order=urlArray[wtype][0];
	var tmp_rtype="ior_"+rtype;
	var ioratio_str="GameData."+tmp_rtype;

	var team="";
	team=changeTitleStr(rtype,1)+"/"+changeTitleStr(rtype,2);
	
	

	var ioratio=eval(ioratio_str);
 	//var ret="<a href='"+order+"?"+param+"' target='mem_order' title='"+team+"'><font "+check_ioratio(gamerec,tmp_rtype,GameData)+">"+ioratio+"</font></a>";
	//alert(parent.name)
	var ret="<a href='javascript://' onclick=\"parent.parent.mem_order.betOrder('FT','"+wtype+"','"+param+"');\" title='"+team+"'><font "+check_ioratio(gamerec,tmp_rtype,GameData)+">"+ioratio+"</font></a>";

	return ret;

}


//--------------------------public function --------------------------------

//取得下注參數
function getParam(uid,odd_f_type,rtype,wtype,GameData){
	var paramArray=new Array();
	paramArray['F']=new Array("gid","uid","odd_f_type","rtype","langx");

	var param="";
	var gid=GameData.gid;

	for (var i=0;i<paramArray[wtype].length;i++){
		if (i>0)  param+="&";
		param+=paramArray[wtype][i]+"="+eval(paramArray[wtype][i]);
	}
	return param;
}


//--------------------------------public function ----------------------------

function setRefreshPos(){
		var refresh_right= body_browse.document.getElementById('refresh_right');
		refresh_right.style.left= body_browse.document.getElementById('myTable').clientWidth*1+20;
		//refresh_right.style.top= 39;
	}

function parseArray(gameHead,gameData){
	var gameObj=new Object();
	for (var i=0;i<gameHead.length;i++){
		if (gameHead[i]!=""){	
			eval("gameObj."+gameHead[i]+"='"+gameData[i]+"'");
		}
	}
	return gameObj;
}


function check_ioratio(rec,rtype,GameData){
//alert(flash_ior_set);
	//return true;
	//alert(GameFT.length+"----"+keepGameData.length)

	if (flash_ior_set =='Y'){
		//alert(oldObjDataFT[rec]);
		if (""+oldObjDataFT[rec]=="undefined" || oldObjDataFT[rec].gid != GameData.gid){
			var gameObj=new Object();
			gameObj.gid=GameData.gid;
			oldObjDataFT[rec]=gameObj;
		}
		
		var new_ioratio=eval("GameData."+rtype);
		var old_ioratio=eval("oldObjDataFT[rec]."+rtype);
		
		
		if (""+old_ioratio=="undefined"){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			old_ioratio=eval("oldObjDataFT[rec]."+rtype);
		}
		
		//alert("old_ioratio==>"+old_ioratio+",new_ioratio==>"+new_ioratio);
		if (""+new_ioratio=="undefined" || new_ioratio==""){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return;
		}
		
		/*
		if (parseFloat(old_ioratio)>parseFloat(new_ioratio) ){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='border: 1px solid #FF0000;' ";
		}
		if (parseFloat(old_ioratio)<parseFloat(new_ioratio) ){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='border: 1px solid #00FF00;' ";
		}
		*/
		
		if (old_ioratio!=new_ioratio && old_ioratio !="" && new_ioratio!="") {
	    	eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='background-color : yellow' ";
		}
		
		return true;
	}

}
//--------------判斷聯盟顯示或隱藏----------------
function showLeg(leg){
	for (var i=0;i<myLeg[leg].length;i++){
	if ( body_browse.document.getElementById("TR_"+myLeg[leg][i]).style.display!="none"){
				showLegIcon(leg,"LegClose",myLeg[leg][i],"none");
				
		}else{
			showLegIcon(leg,"LegOpen",myLeg[leg][i],"");
		}
	}
	if ((""+NoshowLeg[leg])=="undefined"){
		NoshowLeg[leg]=-1;
	}else{
		NoshowLeg[leg]=NoshowLeg[leg]*-1;
	}

}
function showLegIcon(leg,state,gnumH,display){
	var  ary=body_browse.document.getElementsByName(leg);
			
	for (var j=0;j<ary.length;j++){
		ary[j].innerHTML="<span id='"+state+"'></span>";
	}
	try{
		body_browse.document.getElementById("TR3_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR2_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR1_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR_"+gnumH).style.display=display;
	}catch(E){}
}
//----------------------

//分頁
function show_page(){
	//alert(rtype)
	pg_str='';
	obj_pg = body_browse.document.getElementById('pg_txt');
//	alert(t_page);
	if (t_page==0){
		t_page=1;
		//obj_pg.innerHTML = "";
		//return;
	}
	var tmp_lid="";
	if (rtype=="re"){
		tmp_lid=eval("parent."+sel_gtype+"_lid_ary_RE");
	}else{
		tmp_lid=eval("parent."+sel_gtype+"_lid_ary");
	}
	//alert(tmp_lid+"--"+top.swShowLoveI+"--"+t_page)
	if(tmp_lid=='ALL'&&!top.swShowLoveI){
		var disabled="";
		if (t_page==1){
			disabled="disabled";
			}
		var pghtml=(pg*1+1)+" / " +t_page+" "+top.page+"&nbsp;&nbsp; <select  onchange='chg_pg(this.options[this.selectedIndex].value)' "+disabled+">";
		for(var i=0;i<t_page;i++){
			if (pg==i){
		 		pghtml+="<option value='"+i+"' selected>"+(i+1)+"</option>";
		 	}else{
		  		pghtml+="<option value='"+i+"' >"+(i+1)+"</option>";
		  	}
		}
		pghtml+="</select>";
		obj_pg.innerHTML = pghtml;
	}else{
		obj_pg.innerHTML = "";
	}
}

//將時間 轉回 24小時//04:00p
function  change_time(get_time){
	
	if (get_time.indexOf("font") > 0 ) return get_time;
	if (get_time.indexOf("p")>0 || get_time.indexOf("a")>0){
		gtime=get_time.split(":");
		if (gtime[1].indexOf("p")>0){
			
			if (gtime[0]!="12"){
				gtime[0]=gtime[0]*1+12;
			}	
		}
		gtime[1]=gtime[1].replace("a","").replace("p","");
		
	}else{
		return get_time;
	}
	return gtime[0]+":"+gtime[1];
	
}

//隱藏我的最愛選擇聯賽
function dis_ShowLoveI(){

if(top.swShowLoveI){
  body_browse.document.getElementById("sel_league").style.display="none";
 }else{
  body_browse.document.getElementById("sel_league").style.display="";
 }
 
}


function changeTitleStr(s,at){
	if (s.charAt(at)=="H"){
		return "H";
	}else if(s.charAt(at)=="C"){
		return "A";
	}else if(s.charAt(at)=="N"){
		return "D";
	}
	return "";
}
function loadingOK(){
	//alert("loadingOK")
	try{
		body_browse.document.getElementById("refresh_btn").className="refresh_btn";
	}catch(E){}
	try{
	body_browse.document.getElementById("refresh_right").className="refresh_M_btn";
	}catch(E){}
	try{	
	body_browse.document.getElementById("refresh_down").className="refresh_M_btn";
	}catch(E){}
}
<?	
break;
case 'p3':
?>
var ObjDataFT=new Array();
var oldObjDataFT=new Array();
//var GameHead=new Array("gid","datetime","league","gnum_h","gnum_c","team_h","team_c","strong","ratio","ior_RH","ior_RC","ratio_o","ratio_u","ior_OUH","ior_OUC","ior_MH","ior_MC","ior_MN","str_odd","str_even","ior_EOO","ior_EOE","hgid","hstrong","hratio","ior_HRH","ior_HRC","hratio_o","hratio_u","ior_HOUH","ior_HOUC","ior_HMH","ior_HMC","ior_HMN","more","eventid","hot","play");
var keepleg="";
var legnum=0;
var NoshowLeg=new Array();
var myLeg=new Array();
var LeagueAry=new Array();
//var keepscroll=0;
function ShowGameList(){
	
	if(loading == 'Y') return;
	if (parent.gamecount!=gamount){
		oldObjDataFT=new Array();
	}
	if(top.odd_f_type==""||""+top.odd_f_type=="undefined") top.odd_f_type="H";
	keepscroll=body_browse.document.body.scrollTop;
	
	var conscroll= body_browse.document.getElementById('controlscroll');
	conscroll.style.display='';
	conscroll.style.top=keepscroll+1;
	//conscroll.focus();
	
	dis_ShowLoveI();
	
	//秀盤面
	showtables(GameFT,GameHead,gamount,top.odd_f_type);
 
	//重新將選過的單子秀出來
	orderShowSelALL();
	
	body_browse.scroll(0,keepscroll);
	
	//設定右方重新整理位置
	setRefreshPos();
 
	//顯示盤口
	//body_browse.ChkOddfDiv();
 
	
	parent.gamecount=gamount;
	//日期下拉霸
	
	if (sel_gtype=="FU"){
		if (""+body_browse.document.getElementById('g_date')!="undefined"){
			body_browse.selgdate("p3",g_date);
			body_browse.document.getElementById('g_date').value=g_date;
		}
	}
 
	if(top.showtype=='hgft'||top.showtype=='hgfu'){
		obj_sel = body_browse.document.getElementById('sel_league');
		obj_sel.style.display='none';
		try{
			var obj_date='';
			obj_date=body_browse.document.getElementById("g_date").value;
			body_browse.selgdate("",obj_date);
		}catch(E){}
	}else{
		show_page();
	}
 
 
	conscroll.style.display="none";
 
	coun_Leagues();
	body_browse.showPicLove();
	loadingOK();
			
	parent.mem_order.getCountHOT(gameCount);
}
var hotgdateArr =new Array();
function hot_gdate(gdate){
	if((""+hotgdateArr).indexOf(gdate)==-1){
		hotgdateArr.push(gdate);
	}
}
function coun_Leagues(){
	var coun=0;
	var str_tmp ="|"+eval('parent.'+sel_gtype+'_lname_ary');
	if(str_tmp=='|ALL'){
		body_browse.document.getElementById("str_num").innerHTML =top.alldata;
	}else{
		var larray=str_tmp.split('|');
		for(var i =0;i<larray.length;i++){
			if(larray[i]!=""){coun++}
		}
		coun =LeagueAry.length;
		body_browse.document.getElementById("str_num").innerHTML =coun;
	}
	
	
}
 
//表格函數
function showtables(GameData,Game_Head,data_amount,odd_f_type){
//	var conscroll= body_browse.document.getElementById('controlscroll');
 
	//var conscroll= document.getElementById('controlscroll');
//	conscroll.style.display='';
//	conscroll.top=keepscroll;
	//alert("kkkk");
	
	
	
	ObjDataFT=new Array();
	myLeg=new Array();
	for (var j=0;j < data_amount;j++){
		if (GameData[j]!=null){
			ObjDataFT[j]=parseArray(Game_Head,GameData[j]);
		}	
	}
	//alert("ObjDataFT===>"+ObjDataFT.length);
	var trdata;//=body_browse.document.getElementById('DataTR').innerHTML;
	var showtableData;
	if(body_browse.document.all){
	     	showtableData=body_browse.document.getElementById('showtableData').innerText ;
	     	trdata=body_browse.document.getElementById('DataTR').innerText;
	     	notrdata=body_browse.document.getElementById('NoDataTR').innerText;
	} else{
	     	showtableData=body_browse.document.getElementById('showtableData').textContent ;
	     	trdata=body_browse.document.getElementById('DataTR').textContent;
		notrdata=body_browse.document.getElementById('NoDataTR').textContent;
	}
	//alert(trdata);
	var showtable=body_browse.document.getElementById('showtable');
	var showlayers="";
	keepleg="";
	legnum=0;
	LeagueAry =new Array();
	if(ObjDataFT.length > 0){
	  	for ( i=0 ;i < ObjDataFT.length;i++){
	  			showlayers+=getLayer(trdata,i,odd_f_type);
	  			
	  	}
	  	if(showlayers=="")showlayers=notrdata;
	  	showtableData=showtableData.replace("*showDataTR*",showlayers);
	}else{
	        showtableData=showtableData.replace("*showDataTR*",notrdata);
	  
	}
	showtable.innerHTML=showtableData;
	//oldObjDataFT=ObjDataFT;
	
//	conscroll.style.display="none";
}
 
 
//表格內容
function getLayer(onelayer,gamerec,odd_f_type){
	var open_hot = false;
	if(MM_IdentificationDisplay(ObjDataFT[gamerec].datetime,ObjDataFT[gamerec].gnum_h)) return "";
	if(("|"+eval('parent.'+sel_gtype+'_lname_ary')).indexOf(("|"+ObjDataFT[gamerec].league+"|"),0)==-1&&eval('parent.'+sel_gtype+'_lname_ary')!='ALL') return "";
	if((""+LeagueAry).indexOf(ObjDataFT[gamerec].league)== -1)LeagueAry.push(ObjDataFT[gamerec].league);
	var tmp_date = ObjDataFT[gamerec].datetime.split("<br>")[0];
	onelayer=onelayer.replace(/\*ID_STR\*/g,tmp_date+ObjDataFT[gamerec].gnum_h);
	onelayer=onelayer.replace(/\*TR_EVENT\*/g,"onMouseOver='mouseEnter_pointer(this.id);' onMouseOut='mouseOut_pointer(this.id);'");
	//alert(ObjDataFT[gamerec].league+"==="+keepleg+"["+(ObjDataFT[gamerec].league==keepleg)+"]")
	
	if (""+myLeg[ObjDataFT[gamerec].league]=="undefined"){
			myLeg[ObjDataFT[gamerec].league]=ObjDataFT[gamerec].league;
			myLeg[ObjDataFT[gamerec].league]=new Array();
			myLeg[ObjDataFT[gamerec].league][0]=tmp_date+ObjDataFT[gamerec].gnum_h;
		}else{
			myLeg[ObjDataFT[gamerec].league][myLeg[ObjDataFT[gamerec].league].length]=tmp_date+ObjDataFT[gamerec].gnum_h;
			}
	onelayer=onelayer.replace("*PORDER*",ObjDataFT[gamerec].par_minlimit); 	
		
	if (ObjDataFT[gamerec].league==keepleg){
			//alert(ObjDataFT[gamerec].league+"==="+keepleg+"["+(ObjDataFT[gamerec].league==keepleg)+"]")
			onelayer=onelayer.replace("*ST*"," style='display: none;'");
			//--------------判斷聯盟顯示或隱藏----------------
			if (NoshowLeg[ObjDataFT[gamerec].league]==-1){
				//return "";
				onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: none;'"); 
				//聯盟的小圖
				onelayer=onelayer.replace("*LegMark*","<span id='LegClose'></span>");
			}else{
				onelayer=onelayer.replace("*LegMark*","<span id='LegOpen'></span>");
				}
			//---------------------------------------------------------------------
		}else{	
				onelayer=onelayer.replace("*ST*","style='display:;'");
			
			//--------------判斷聯盟顯示或隱藏----------------
		if (NoshowLeg[ObjDataFT[gamerec].league]==-1){
				onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: none;'"); 
				onelayer=onelayer.replace("*LegMark*","<span id='LegClose'></span>");
			}else{
				//聯盟的小圖
				onelayer=onelayer.replace("*LegMark*","<span id='LegOpen'></span>");
				}
			//---------------------------------------------------------------------
		
	}
	var PR_ior =Array();
	var POU_ior =Array();
	var HPR_ior =Array();
	var HPOU_ior =Array();
	
	PR_ior  = get_other_ioratio("", ObjDataFT[gamerec].ior_PRH   , ObjDataFT[gamerec].ior_PRC   , show_ior);
	POU_ior = get_other_ioratio("", ObjDataFT[gamerec].ior_POUH  , ObjDataFT[gamerec].ior_POUC  , show_ior);
	HPR_ior = get_other_ioratio("", ObjDataFT[gamerec].ior_HPRH  , ObjDataFT[gamerec].ior_HPRC  , show_ior);
	HPOU_ior= get_other_ioratio("", ObjDataFT[gamerec].ior_HPOUH , ObjDataFT[gamerec].ior_HPOUC , show_ior);
	
	ObjDataFT[gamerec].ior_PRH=PR_ior[0];
	ObjDataFT[gamerec].ior_PRC=PR_ior[1];
	ObjDataFT[gamerec].ior_POUH=POU_ior[0];
	ObjDataFT[gamerec].ior_POUC=POU_ior[1];
	ObjDataFT[gamerec].ior_HPRH=HPR_ior[0];
	ObjDataFT[gamerec].ior_HPRC=HPR_ior[1];
	ObjDataFT[gamerec].ior_HPOUH=HPOU_ior[0];
	ObjDataFT[gamerec].ior_HPOUC=HPOU_ior[1];
	
 
 
	//滾球字眼
	ObjDataFT[gamerec].datetime=ObjDataFT[gamerec].datetime.replace("Running Ball",top.str_RB);
	keepleg=ObjDataFT[gamerec].league;
	onelayer=onelayer.replace(/\*LEG\*/gi,ObjDataFT[gamerec].league);
	
	
//	onelayer=onelayer.replace(/\*LegID\*/g,"LEG_"+legnum);
 
	
	var tmp_date=ObjDataFT[gamerec].datetime.split("<br>");
	if (sel_gtype=="FU"){
		tmp_date_str=tmp_date[0]+"<br>"+change_time(tmp_date[1]);
	}else{
		tmp_date_str=change_time(tmp_date[1]);
	}
	if (tmp_date.length==3){
		tmp_date_str+="<br>"+tmp_date[2];
	}	
	onelayer=onelayer.replace("*DATETIME*",tmp_date_str);
	onelayer=onelayer.replace("*TEAM_H*",ObjDataFT[gamerec].team_h.replace("[Mid]","<font color=\"#005aff\">[N]</font>").replace("[中]","<font color=\"#005aff\">[中]</font>"));
	onelayer=onelayer.replace("*TEAM_C*",ObjDataFT[gamerec].team_c);
	//全場
	
		onelayer=onelayer.replace("*GID_MH*",ObjDataFT[gamerec].gid+"_MH");
		onelayer=onelayer.replace("*GID_MC*",ObjDataFT[gamerec].gid+"_MC");
		onelayer=onelayer.replace("*GID_MN*",ObjDataFT[gamerec].gid+"_MN");
		onelayer=onelayer.replace("*GID_HMH*",ObjDataFT[gamerec].gid+"_HPMH");
		onelayer=onelayer.replace("*GID_HMC*",ObjDataFT[gamerec].gid+"_HPMC");
		onelayer=onelayer.replace("*GID_HMN*",ObjDataFT[gamerec].gid+"_HPMN");
		onelayer=onelayer.replace("*GID_RH*",ObjDataFT[gamerec].gid+"_PRH");
		onelayer=onelayer.replace("*GID_RC*",ObjDataFT[gamerec].gid+"_PRC");
		onelayer=onelayer.replace("*GID_HRH*",ObjDataFT[gamerec].gid+"_HPRH");
		onelayer=onelayer.replace("*GID_HRC*",ObjDataFT[gamerec].gid+"_HPRC");
		onelayer=onelayer.replace("*GID_OUH*",ObjDataFT[gamerec].gid+"_POUH");
		onelayer=onelayer.replace("*GID_OUC*",ObjDataFT[gamerec].gid+"_POUC");
		onelayer=onelayer.replace("*GID_HOUH*",ObjDataFT[gamerec].gid+"_HPOUH");
		onelayer=onelayer.replace("*GID_HOUC*",ObjDataFT[gamerec].gid+"_HPOUC");
		onelayer=onelayer.replace("*GID_EOO*",ObjDataFT[gamerec].gid+"_PO");
		onelayer=onelayer.replace("*GID_EOE*",ObjDataFT[gamerec].gid+"_PE");
	
	//獨贏
	if ((ObjDataFT[gamerec].ior_MH*1 > 0) && (ObjDataFT[gamerec].ior_MC*1 > 0)&&(ObjDataFT[gamerec].ior_MN*1 > 0)){
		onelayer=onelayer.replace("*RATIO_MH*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"M"));
		onelayer=onelayer.replace("*RATIO_MC*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"M"));
		onelayer=onelayer.replace("*RATIO_MN*",parseUrl(uid,odd_f_type,"N",ObjDataFT[gamerec],gamerec,"M"));
	}else{
		onelayer=onelayer.replace("*RATIO_MH*","&nbsp;");
		onelayer=onelayer.replace("*RATIO_MC*","&nbsp;");
		onelayer=onelayer.replace("*RATIO_MN*","&nbsp;");
	}
	//讓球
	if (ObjDataFT[gamerec].strong=="H"){
		onelayer=onelayer.replace("*CON_RH*",ObjDataFT[gamerec].ratio);	/*讓球球頭*/
		onelayer=onelayer.replace("*CON_RC*","");
	}else{
		onelayer=onelayer.replace("*CON_RH*","");
		onelayer=onelayer.replace("*CON_RC*",ObjDataFT[gamerec].ratio);
	}
	
	
	//onelayer=onelayer.replace("*TD_RH_CLASS*",check_ioratio(gamerec,"ior_RH",ObjDataFT[gamerec]));/*讓球sytle*/
	//onelayer=onelayer.replace("*TD_RH_CLASS*","class='b_rig'");/*讓球sytle*/
	
 
	onelayer=onelayer.replace("*RATIO_RH*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"PR"));/*讓球賠率*/
	onelayer=onelayer.replace("*RATIO_RC*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"PR"));
	//大小
	if (top.langx=="en-us"){
		onelayer=onelayer.replace("*CON_OUC*",ObjDataFT[gamerec].ratio_o.replace("O","o"));	/*大小球頭*/
		onelayer=onelayer.replace("*CON_OUH*",ObjDataFT[gamerec].ratio_u.replace("U","u"));
	}else{
		onelayer=onelayer.replace("*CON_OUC*",ObjDataFT[gamerec].ratio_o.replace("O",top.strOver));	/*大小球頭*/
		onelayer=onelayer.replace("*CON_OUH*",ObjDataFT[gamerec].ratio_u.replace("U",top.strUnder));
	}
	
	onelayer=onelayer.replace("*RATIO_OUC*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"POU"));/*大小賠率*/
	onelayer=onelayer.replace("*RATIO_OUH*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"POU"));
	//上半場
	//獨贏
 
	if ((ObjDataFT[gamerec].ior_HPMH*1 > 0) && (ObjDataFT[gamerec].ior_HPMC*1 > 0) && (ObjDataFT[gamerec].ior_HPMN*1 > 0)){
			                                            //ior_HPMH,ior_HPMC,ior_HPMN
			                                            //var tmp_rtype="ior_"+wtype+betTeam;
		onelayer=onelayer.replace("*RATIO_HMH*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"HPM"));
		onelayer=onelayer.replace("*RATIO_HMC*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"HPM"));
		onelayer=onelayer.replace("*RATIO_HMN*",parseUrl(uid,odd_f_type,"N",ObjDataFT[gamerec],gamerec,"HPM"));
		
	}else{
		onelayer=onelayer.replace("*RATIO_HMH*","&nbsp;");
		onelayer=onelayer.replace("*RATIO_HMC*","&nbsp;");
		onelayer=onelayer.replace("*RATIO_HMN*","&nbsp;");
		}
	//讓球
	if (ObjDataFT[gamerec].hstrong=="H"){
		onelayer=onelayer.replace("*CON_HRH*",ObjDataFT[gamerec].hratio);	/*讓球球頭*/
		onelayer=onelayer.replace("*CON_HRC*","");
	}else{
		onelayer=onelayer.replace("*CON_HRH*","");
		onelayer=onelayer.replace("*CON_HRC*",ObjDataFT[gamerec].hratio);
	}
	onelayer=onelayer.replace("*RATIO_HRH*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"HPR"));/*讓球賠率*/
	onelayer=onelayer.replace("*RATIO_HRC*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"HPR"));
	//大小
	if (top.langx=="en-us"){
		onelayer=onelayer.replace("*CON_HOUC*",ObjDataFT[gamerec].hratio_o.replace("O","o"));	/*大小球頭*/
		onelayer=onelayer.replace("*CON_HOUH*",ObjDataFT[gamerec].hratio_u.replace("U","u"));
	}else{
		onelayer=onelayer.replace("*CON_HOUC*",ObjDataFT[gamerec].hratio_o.replace("O",top.strOver));	/*大小球頭*/
		onelayer=onelayer.replace("*CON_HOUH*",ObjDataFT[gamerec].hratio_u.replace("U",top.strUnder));
	
	}	
	
	onelayer=onelayer.replace("*RATIO_HOUC*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"HPOU"));/*大小賠率*/
	onelayer=onelayer.replace("*RATIO_HOUH*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"HPOU"));
	var tmp_ior_po=eval("ObjDataFT[gamerec].ior_PO");
	var tmp_ior_pe=eval("ObjDataFT[gamerec].ior_PE");
	
	var rario_eoo="";
	var ratio_eoe="";
	if (tmp_ior_po*1 >0 && tmp_ior_pe*1 > 0){
		
		if (top.langx=="en-us"){
				var rario_eoo="o "+parseUrl(uid,top.odd_f_type,"O",ObjDataFT[gamerec],gamerec,"P");
				var ratio_eoe="e "+parseUrl(uid,top.odd_f_type,"E",ObjDataFT[gamerec],gamerec,"P");
			}else{
				var rario_eoo=top.strOdd+" "+parseUrl(uid,top.odd_f_type,"O",ObjDataFT[gamerec],gamerec,"P");
				var ratio_eoe=top.strEven+" "+parseUrl(uid,top.odd_f_type,"E",ObjDataFT[gamerec],gamerec,"P");
			}
	onelayer=onelayer.replace("*RATIO_EOO*",rario_eoo);
  	onelayer=onelayer.replace("*RATIO_EOE*",ratio_eoe);
	}else{
	onelayer=onelayer.replace("*RATIO_EOO*","&nbsp;");
  	onelayer=onelayer.replace("*RATIO_EOE*","&nbsp;");
	}
	
	//onelayer=onelayer.replace("*MORE*",parsemore(ObjDataFT[gamerec],game_more));
	gcount=0;
	if(ObjDataFT[gamerec].more=="0"){
		onelayer=onelayer.replace("*MORE*","");
	}else{
		onelayer=onelayer.replace("*MORE*",'<A href=\"javascript:\" onClick=\"parent.show_more(\''+gamerec+'\',event);\">'+'+'+ObjDataFT[gamerec].more+'&nbsp;'+str_more+'</A>');
		                              
		
	}
	//我的最愛
	onelayer=onelayer.replace("*MYLOVE*",parseMyLove(ObjDataFT[gamerec]));
/*
	if (ObjDataFT[gamerec].play=="Y"){
			onelayer=onelayer.replace("*TV_ST*","style='display:'';'");
		
		}else{
				onelayer=onelayer.replace("*TV_ST*","style='display:none;'");
			}
 
*/
		if (ObjDataFT[gamerec].eventid != "" && ObjDataFT[gamerec].eventid != "null" && ObjDataFT[gamerec].eventid != undefined) {	//判斷是否有轉播
			tmpStr= VideoFun(ObjDataFT[gamerec].eventid, ObjDataFT[gamerec].hot, ObjDataFT[gamerec].play, "FT");
			//alert(tmpStr);
			onelayer=onelayer.replace("*TV*",tmpStr);
		}
		onelayer=onelayer.replace("*TV*","");
	
	//alert(onelayer);
	return onelayer;
}
 
 
//取得下注的url
function parseUrl(uid,odd_f_type,betTeam,GameData,gamerec,wtype){
//	alert(wtype);
	
	var urlArray=new Array();
	urlArray['M']=new Array((betTeam=="N" ? top.str_irish_kiss : eval("GameData.team_"+betTeam.toLowerCase())));
	urlArray['PR']=new Array(eval("GameData.team_"+betTeam.toLowerCase()));
	urlArray['POU']=new Array((betTeam=="C" ? top.strOver : top.strUnder));
	//urlArray['HR']=new Array(eval("GameData.team_"+betTeam.toLowerCase()));
	urlArray['HPR']=new Array(eval("GameData.team_"+betTeam.toLowerCase()));
	urlArray['HPOU']=new Array((betTeam=="C" ? top.strOver : top.strUnder));
	urlArray['HPM']=new Array((betTeam=="N" ? top.str_irish_kiss : eval("GameData.team_"+betTeam.toLowerCase())));
	urlArray['P']=new Array((betTeam=="O" ? top.str_o : top.str_e));
	
	urlArray['T01'] = new Array("0~1");
	urlArray['T23'] = new Array("2~3");
	urlArray['T46'] = new Array("4~6");
	urlArray['OVER'] = new Array("7up");
	
//	var param=getParam(uid,odd_f_type,betTeam,wtype,GameData);
//	var order=urlArray[wtype][0];
	
	var team="";
	var title_str="";
	if (urlArray[wtype]!=null){
		team=urlArray[wtype][0];
		title_str="title='"+team+"'";
	}else{
		var HPD=new Array('HH1C0','HH2C0','HH2C1','HH3C0','HH3C1','HH3C2','HH4C0','HH4C1','HH4C2','HH4C3','HH0C0','HH1C1','HH2C2','HH3C3','HH4C4','HOVH','HH0C1','HH0C2','HH1C2','HH0C3','HH1C3','HH2C3','HH0C4','HH1C4','HH2C4','HH3C4');
		var PD=new Array('H1C0','H2C0','H2C1','H3C0','H3C1','H3C2','H4C0','H4C1','H4C2','H4C3','H0C0','H1C1','H2C2','H3C3','H4C4','OVH','H0C1','H0C2','H1C2','H0C3','H1C3','H2C3','H0C4','H1C4','H2C4','H3C4');
		if (indexof(HPD,wtype) > -1||indexof(PD,wtype) > -1){
			if (wtype=="OVH"||wtype=="HOVH"){
				title_str="title='Other Score'";
			}else{
				title_str="title='"+(wtype.replace("H","").replace("H","").replace("C",":"))+"'";
			}
		}
		var RM_F=new Array('FHH','FHN','FHC','FNH','FNN','FNC','FCH','FCN','FCC');
		
		if (indexof(RM_F,wtype) > -1){
			title_str="title='"+changeTitleStr(wtype,1)+"/"+changeTitleStr(wtype,2)+"'";	
		}
		
		
		
		
		
	}
	
	var tmp_rtype="ior_"+wtype+betTeam;
	var ioratio_str="GameData."+tmp_rtype;
 
	var bet_rtype=wtype+betTeam;
	
	if (wtype.indexOf("T") > -1){
		bet_rtype=wtype.substr(1,1)+"~"+wtype.substr(2,1);
	}
	
	
	
	var ioratio=eval(ioratio_str);
	//alert("1====>"+ioratio+":"+ioratio_str);
	//ioratio=printf(Decimal_point(ioratio,2),2);
	//alert("2====>"+ioratio);
 //	var ret="<a href='"+order+"?"+param+"' target='mem_order' title='"+team+"'><font "+check_ioratio(gamerec,tmp_rtype,GameData)+">"+ioratio+"</font></a>";
 	var ret="<a href='javascript:void(0)'  onclick='parent.orderParlay(\""+GameData.gidm+"\",\""+GameData.gid+"\",\""+GameData.hgid+"\",\""+(bet_rtype)+"\",\""+GameData.par_minlimit+"\",\""+GameData.par_maxlimit+"\")' "+title_str+"><font "+check_ioratio(gamerec,tmp_rtype,GameData)+">"+ioratio+"</font></a>";
	//alert(parent.name)
	//var ret="<a href='javascript://' onclick=\"parent.parent.mem_order.betOrder('FT','"+wtype+"','"+param+"');\" title='"+team+"'><font "+check_ioratio(gamerec,tmp_rtype,GameData)+">"+ioratio+"</font></a>";
	
	return ret;
	
}
function indexof(ary,key){
	
	for (i=0;i < ary.length;i++){
		if (ary[i]==key) return i;	
	}
	return -1;
}
//------------------------新過關變色直接新增功能-------------------max 2010/10
top.orderArray=new Array();
top.ordergid=new Array();
function resort(ary){
	var tempary=new Array();
	for(var i=0;i<ary.length;i++){
		if (ary[i]!=0){
			tempary[tempary.length]=ary[i];
			}
		}
	return tempary;
	}
 
 
function orderRemoveALL(){
	//alert("orderRemoveALL===>"+top.ordergid.length);
	for(var i=0;i < top.ordergid.length;i++){
		orderRemoveGidBgcolor(top.ordergid[i]);		
	}
	top.orderArray=new Array();
	top.ordergid=new Array();
}
 
function orderShowSelALL(){
	for(var i=0;i < top.ordergid.length;i++){
		var obj=top.orderArray["G"+top.ordergid[i]];
		try{
			var classary=(body_browse.document.getElementById(obj.gid+"_"+obj.wtype).className).split("_");
			body_browse.document.getElementById(obj.gid+"_"+obj.wtype).className="pr_"+classary[1];
		}catch(E){}	
	}
}
 
 
function orderRemoveGid(removeGid){
 
		
		for(var i=0;i < top.ordergid.length;i++){
		//alert("gid==>"+top.ordergid[i]);
			var obj=top.orderArray["G"+top.ordergid[i]];
			if (obj.gid==removeGid || obj.hgid==removeGid){
				orderRemoveGidBgcolor(top.ordergid[i]);
				top.orderArray["G"+top.ordergid[i]]="undefined";
				top.ordergid[i]=0;
			
				} 
		}
	
		top.ordergid=resort(top.ordergid);
 
	
	}
function orderRemoveGidBgcolor(gidm){
		var tmpobj=top.orderArray["G"+gidm];
		try{
			var classary=( body_browse.document.getElementById(tmpobj.gid+"_"+tmpobj.wtype).className).split("_");
			body_browse.document.getElementById(tmpobj.gid+"_"+tmpobj.wtype).className="b_"+classary[1];
		}catch(E){}
	}
 
 
function orderParlay(gidm,gid,hgid,wtype,par_minlimit,par_maxlimit){
	//alert(gid+"_"+wtype);
 
	// body_browse.document.getElementById(gid+"_"+wtype).bgColor="gold";
	if (""+top.orderArray["G"+gidm]=="undefined"){
		top.ordergid[top.ordergid.length]=gidm;
	}else{
		orderRemoveGidBgcolor(gidm);
		
		var tmp_obj=top.orderArray["G"+gidm];
		if (tmp_obj.wtype==wtype&&tmp_obj.gid==gid){
			orderRemoveGid(gid);
			if (top.ordergid.length > 0){
				orderParlayParam();
			}else{
				
					try{
						parent.mem_order.close_bet();	
					}catch(E){}
			}
			return;
		}	
	}
			
	try{
		//alert(gid+"_"+wtype+","+body_browse.document.getElementById(gid+"_"+wtype).className);
		var classary=(body_browse.document.getElementById(gid+"_"+wtype).className).split("_");
		//alert(classary.length);
		body_browse.document.getElementById(gid+"_"+wtype).className="pr_"+classary[1];
	}catch(E){
		//alert("找不到標籤")	
	}
	//var gameparam="game1="+wtype+"&game_id1="+gid+"&Hgame_id1="+hgid;
	var orderobj=new Object();
	orderobj.wtype=wtype;
	orderobj.gid=gid;
	orderobj.hgid=hgid;
	orderobj.par_minlimit=par_minlimit;
	orderobj.par_maxlimit=par_maxlimit;
	//orderobj.gameparam=gameparam;
	top.orderArray["G"+gidm]=orderobj;
	//alert(ordergid.length);
	orderParlayParam();
	
	}
//------------------------------------------------------------------------------------
function orderParlayParam(){
	var param="";
		for(var i=0;i < top.ordergid.length;i++){
			var obj=top.orderArray["G"+top.ordergid[i]];
			if (i!=0) param+="&";
			gameparam="game"+(i+1)+"="+obj.wtype+"&game_id"+(i+1)+"="+obj.gid+"&Hgame_id"+(i+1)+"="+obj.hgid+"&minlimit"+(i+1)+"="+obj.par_minlimit+"&maxlimit"+(i+1)+"="+obj.par_maxlimit;
			param+=gameparam;
		}
	parent.paramData=new Array();
	parent.mem_order.betOrder('FT','P3',"teamcount="+top.ordergid.length+"&uid="+top.uid+"&langx="+top.langx+"&"+param);
}
//--------------------------public function --------------------------------
 
//取得下注參數
function getParam(uid,odd_f_type,betTeam,wtype,GameData){
	var paramArray=new Array();
	paramArray['R']=new Array("gid","uid","odd_f_type","type","gnum","strong");
	paramArray['HR']=new Array("gid","uid","odd_f_type","type","gnum","strong");
	paramArray['OU']=new Array("gid","uid","odd_f_type","type","gnum");
	paramArray['HOU']=new Array("gid","uid","odd_f_type","type","gnum");
	paramArray['M']=new Array("gid","uid","odd_f_type","type","gnum");
	paramArray['HM']=new Array("gid","uid","odd_f_type","type","gnum");
	paramArray['EO']=new Array("gid","uid","odd_f_type","rtype");
 
	var param="";
	var gid=((wtype=="R"||wtype=="OU"||wtype=="M"||wtype=="EO") ? GameData.gid : GameData.hgid);
	var gnum=eval("GameData.gnum_"+(betTeam=="N"? "c":betTeam.toLowerCase()));
	var strong=(wtype=="R" ? GameData.strong : GameData.hstrong);
	var rtype=(betTeam=="O" ? "ODD" : "EVEN");
	var type=betTeam;
	
	for (var i=0;i<paramArray[wtype].length;i++){
		if (i>0)  param+="&";
		param+=paramArray[wtype][i]+"="+eval(paramArray[wtype][i]);
	}
	return param;
}
/*
function parsemore(GameData,g_more){
	var ret="";
	if(g_more=='0'||GameData.more=='0'){
		ret="&nbsp;";
	}else{
	 	ret="<A href=javascript: onClick=parent.show_more('"+GameData.gid+"',event);>"+"<font class='total_color'>+"+GameData.more+"&nbsp;</font>"+str_more+"</A>";
	}			
	return ret;	
}
function show_more(gid,evt){
	evt = evt ? evt : (window.event ? window.event : null);
	var mY = evt.pageY ? evt.pageY : evt.y;
	body_browse.document.getElementById('more_window').style.position='absolute';
	body_browse.document.getElementById('more_window').style.top=mY+30;
	body_browse.document.getElementById('more_window').style.left=body_browse.document.body.scrollLeft+7;
	var  url="body_var_r_more.php?gid="+gid+"&uid="+uid+"&ltype="+ltype;
	body_browse.showdata.location.href = url;
}
*/
 
function parseMyLove(GameData){
 
	var tmpStr="";
	//====== 加入現場轉播功能 2009-04-09, VideoFun 放在 flash_ior_mem.js
	tmpStr = "<table width='99%'   border='0' cellpadding='0' cellspacing='0'><tr><td align='left'>"+str_even+"</td>";				
	tmpStr+= "<td class='hot_td' >";
//	tmpStr+= "<table><tr align='right'><td>";
	//tmpStr+=MM_ShowLoveI(GameData.gnum_h,GameData.datetime,GameData.league,GameData.team_h,GameData.team_c);
//	tmpStr+= "</td></tr></table>";
	tmpStr+= "</td>";
	tmpStr+= "</tr></table>";
 
	return  tmpStr;
}
 
function layer_screen(layers,gamerec){
	//alert("layer_screen>"+gamerec)
	show_team = body_browse.document.getElementById('table_team');
	show_hpd = body_browse.document.getElementById('table_hpd');
	show_pd = body_browse.document.getElementById("table_pd");
	show_t = body_browse.document.getElementById("table_t");
	show_f = body_browse.document.getElementById("table_f");
	var tmp_stype="style=\"display:none;\"";
	gid=ObjDataFT[gamerec].gid;
	Hgid=ObjDataFT[gamerec].hgid;
	//layers=layers.replace("*GID*",GameFT[index][0]);
	
	//主客隊伍
	
	var tmp_team="";
	tmp_team=ObjDataFT[gamerec].team_h.replace("[Mid]","[N]")+'&nbsp;&nbsp;<font class="vs">vs.</font>&nbsp;&nbsp;'+ObjDataFT[gamerec].team_c;
	layers=layers.replace("*TEAM*",tmp_team);
	layers=layers.replace("*MORDER*",ObjDataFT[gamerec].par_minlimit);
	//if (ObjDataFT[gamerec].more=='0') layers=layers.replace("*table_team_sty*",tmp_stype);
	
	
	//上半波膽
	
	var RM=new Array('HH1C0','HH2C0','HH2C1','HH3C0','HH3C1','HH3C2','HH4C0','HH4C1','HH4C2','HH4C3','HH0C0','HH1C1','HH2C2','HH3C3','HH4C4','HOVH','HH0C1','HH0C2','HH1C2','HH0C3','HH1C3','HH2C3','HH0C4','HH1C4','HH2C4','HH3C4');
	var vals=0;
	var tmp_ior=0;
	for (jj=0;jj< RM.length;jj++){
		tmp_ior=eval("ObjDataFT[gamerec].ior_"+RM[jj]);
		//alert("key="+RM[jj]+",ior="+tmp_ior);
		if (tmp_ior*1>0){
			//parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"HPOU")
			//layers=layers.replace("*"+RM[jj]+"*",("<font class=r_bold>"+(tmp_ior*1)+"</font>"));
			layers=layers.replace("*"+RM[jj]+"*",parseUrl(uid,top.odd_f_type,"",ObjDataFT[gamerec],gamerec,RM[jj]));
			layers=layers.replace("*GID_"+RM[jj]+"*",ObjDataFT[gamerec].gid+"_"+RM[jj]);
		}else{
			vals++;
			layers=layers.replace("*"+RM[jj]+"*", "&nbsp;");
			layers=layers.replace("*GID_"+RM[jj]+"*","");
		}
	}
	if (vals==26)layers=layers.replace("*table_hpd_sty*",tmp_stype);
	
	
	//波膽
	
	var RM=new Array('H1C0','H2C0','H2C1','H3C0','H3C1','H3C2','H4C0','H4C1','H4C2','H4C3','H0C0','H1C1','H2C2','H3C3','H4C4','OVH','H0C1','H0C2','H1C2','H0C3','H1C3','H2C3','H0C4','H1C4','H2C4','H3C4');
	var vals=0;
	for (jj=0;jj< RM.length;jj++){
		tmp_ior=eval("ObjDataFT[gamerec].ior_"+RM[jj]);
		if (tmp_ior*1>0){
			layers=layers.replace("*"+RM[jj]+"*",parseUrl(uid,top.odd_f_type,"",ObjDataFT[gamerec],gamerec,RM[jj]));
			layers=layers.replace("*GID_"+RM[jj]+"*",ObjDataFT[gamerec].gid+"_"+RM[jj]);
		}else{
			vals++;
			layers=layers.replace("*"+RM[jj]+"*", "&nbsp;");
			layers=layers.replace("*GID_"+RM[jj]+"*","");
		}
	}
	if (vals==26)layers=layers.replace("*table_pd_sty*",tmp_stype);
	
	
	//總入球
	
	var RM=new Array('T01','T23','T46','OVER');
	var betRtype=new Array('0~1','2~3','4~6','OVER');
	var vals=0;
	for (jj=0;jj< RM.length;jj++){
		tmp_ior=eval("ObjDataFT[gamerec].ior_"+RM[jj]);
		if (tmp_ior*1>0){
			layers=layers.replace("*"+RM[jj]+"*",parseUrl(uid,top.odd_f_type,"",ObjDataFT[gamerec],gamerec,RM[jj]));
			//alert(ObjDataFT[gamerec].gid+"_"+betRtype[jj])
			layers=layers.replace("*GID_"+RM[jj]+"*",ObjDataFT[gamerec].gid+"_"+betRtype[jj]);
		}else{
			vals++;
			layers=layers.replace("*"+RM[jj]+"*", "&nbsp;");
			layers=layers.replace("*GID_"+RM[jj]+"*","");
		}
	}
	//單雙
	/*
	var tmp_ior_po=eval("ObjDataFT[gamerec].ior_PO");
	var tmp_ior_pe=eval("ObjDataFT[gamerec].ior_PE");
	if (tmp_ior_po*1 >0 && tmp_ior_pe*1 > 0){
		layers=layers.replace("*RATIO_EOO*",parseUrl(uid,top.odd_f_type,"O",ObjDataFT[gamerec],gamerec,"P"));
  		layers=layers.replace("*RATIO_EOE*",parseUrl(uid,top.odd_f_type,"E",ObjDataFT[gamerec],gamerec,"P"));
	}else{
		vals++;
		layers=layers.replace("*RATIO_EOO*","&nbsp;");
  		layers=layers.replace("*RATIO_EOE*","&nbsp;");
	}
	*/
	if (vals==4) layers=layers.replace("*table_t_sty*",tmp_stype);
	
	
	//半全場
	
	var RM=new Array('FHH','FHN','FHC','FNH','FNN','FNC','FCH','FCN','FCC');
	var vals=0;
	for (jj=0;jj< RM.length;jj++){
		
		tmp_ior=eval("ObjDataFT[gamerec].ior_"+RM[jj]);
		if (tmp_ior*1 > 0){
			layers=layers.replace("*"+RM[jj]+"*",parseUrl(uid,top.odd_f_type,"",ObjDataFT[gamerec],gamerec,RM[jj]));
			layers=layers.replace("*GID_"+RM[jj]+"*",ObjDataFT[gamerec].gid+"_"+RM[jj]);
		}else{
			vals++;
			layers=layers.replace("*"+RM[jj]+"*", "&nbsp;");
			layers=layers.replace("*GID_"+RM[jj]+"*","");
		}
	}
	if (vals==9)layers=layers.replace("*table_f_sty*",tmp_stype);
	
	
	layers=layers.replace("*CLS*","onclick=\"document.getElementById('showtable_more').style.display='none'\"");
	return layers;
}
var show_more_str="";
function show_more(gamerec,evt){
	
	//var layers_str="";
	//try{
		//if(show_more_str.indexOf(","+idx+",",0)==-1){
			//if (show_more_str==''){
			//	show_more_str=','+idx+',';
			//}else{
			//	show_more_str+=idx+',';
			//}
			//alert("show_more .....");
			//var more_DIV  = body_browse.document.getElementById('show_play').innerText;
			
	if(document.all){
     	var more_DIV  = body_browse.document.getElementById('show_play').innerText;
	}else{
        var more_DIV  = body_browse.document.getElementById('show_play').textContent;
	}			
			
			var more_span = body_browse.document.getElementById('showtable_more');
			//layers_str =more_span.innerHTML;
			//alert(more_DIV);
			var layers_str = layer_screen(more_DIV,gamerec);
			//alert(layers_str);
			more_span.innerHTML=layers_str;
		//}
		//try{
			//var tmp_div_obj=eval("body_browse.document.all.Play"+parent.showgid);
			//tmp_div_obj.style.display='none';
		//}catch(E){}
		//parent.showgid=gid;
		//var div_obj=eval("body_browse.document.all.Play"+gid);
		//alert(body_browse.document.body.scrollTop+body_browse.event.clientY+"==="+body_browse.document.body.scrollLeft)
		
		evt = evt ? evt : (window.event ? window.event : null);
		var mY = evt.pageY ? evt.pageY : evt.y;
		more_span.style.top=mY+30;
		more_span.style.left=body_browse.document.body.scrollLeft+7;
		more_span.style.display='';
		more_span.focus();
		
	//}catch(E){}
}
//下注取得gidm
function get_gidm(gid,ms){
	for ( i=0 ;i < ObjDataFT.length;i++){
		tmp_gid=ObjDataFT[i].gid;
		if (ms!=""){
			tmp_gid=ObjDataFT[i].hgid;
		}		
		if (tmp_gid==gid){
			return 	ObjDataFT[i].gidm;
		}
		
	}
	return "";
}
function killgid(gids){
	//alert(gids);
	var gidary=gids.split("|");
	for (var i=0;i<gidary.length;i++){
		orderRemoveGid(gidary[i]);	
	}
	alert(top.str_otb_close);
}
 
//--------------------------------public function ----------------------------
 
function setRefreshPos(){
		var refresh_right= body_browse.document.getElementById('refresh_right');
		refresh_right.style.left= body_browse.document.getElementById('myTable').clientWidth*1+20;
		//refresh_right.style.top= 39;
	}
 
function parseArray(gameHead,gameData){
	var gameObj=new Object();
	for (var i=0;i<gameHead.length;i++){
		if (gameHead[i]!=""){	
			eval("gameObj."+gameHead[i]+"='"+gameData[i]+"'");
		}
	}
	return gameObj;
}
 
 
function check_ioratio(rec,rtype,GameData){
//alert(flash_ior_set);
	//return true;
	//alert(GameFT.length+"----"+keepGameData.length)
 
	if (flash_ior_set =='Y'){
		//alert(oldObjDataFT[rec]);
		if (""+oldObjDataFT[rec]=="undefined" || oldObjDataFT[rec].gid != GameData.gid){
			var gameObj=new Object();
			gameObj.gid=GameData.gid;
			oldObjDataFT[rec]=gameObj;
		}
		
		var new_ioratio=eval("GameData."+rtype);
		var old_ioratio=eval("oldObjDataFT[rec]."+rtype);
		
		
		if (""+old_ioratio=="undefined"){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			old_ioratio=eval("oldObjDataFT[rec]."+rtype);
		}
		
		//alert("old_ioratio==>"+old_ioratio+",new_ioratio==>"+new_ioratio);
		if (""+new_ioratio=="undefined" || new_ioratio==""){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return;
		}
		
		/*
		if (parseFloat(old_ioratio)>parseFloat(new_ioratio) ){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='border: 1px solid #FF0000;' ";
		}
		if (parseFloat(old_ioratio)<parseFloat(new_ioratio) ){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='border: 1px solid #00FF00;' ";
		}
		*/
		
		if (old_ioratio!=new_ioratio && old_ioratio !="" && new_ioratio!="") {
	    	eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='background-color : yellow' ";
		}
		
		return true;
	}
 
}
//--------------判斷聯盟顯示或隱藏----------------
function showLeg(leg){
	for (var i=0;i<myLeg[leg].length;i++){
	if ( body_browse.document.getElementById("TR_"+myLeg[leg][i]).style.display!="none"){
				showLegIcon(leg,"LegClose",myLeg[leg][i],"none");
				
		}else{
			showLegIcon(leg,"LegOpen",myLeg[leg][i],"");
		}
	}
	if ((""+NoshowLeg[leg])=="undefined"){
		NoshowLeg[leg]=-1;
	}else{
		NoshowLeg[leg]=NoshowLeg[leg]*-1;
	}
 
}
function showLegIcon(leg,state,gnumH,display){
	var  ary=body_browse.document.getElementsByName(leg);
			
	for (var j=0;j<ary.length;j++){
		ary[j].innerHTML="<span id='"+state+"'></span>";
	}
	try{
		body_browse.document.getElementById("TR3_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR2_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR1_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR_"+gnumH).style.display=display;
	}catch(E){}
}
//----------------------
 
//分頁
function show_page(){
	//alert(rtype)
	pg_str='';
	obj_pg = body_browse.document.getElementById('pg_txt');
//	alert(t_page);
	if (t_page==0){
		t_page=1;
		//obj_pg.innerHTML = "";
		//return;
	}
	var tmp_lid="";
	if (rtype=="re"){
		tmp_lid=eval("parent."+sel_gtype+"_lid_ary_RE");
	}else{
		tmp_lid=eval("parent."+sel_gtype+"_lid_ary");
	}
	//alert(tmp_lid+"--"+top.swShowLoveI+"--"+t_page)
	if(tmp_lid=='ALL'&&!top.swShowLoveI){
		var disabled="";
		if (t_page==1){
			disabled="disabled";
			}
		var pghtml=(pg*1+1)+" / " +t_page+" "+top.page+"&nbsp;&nbsp; <select  onchange='chg_pg(this.options[this.selectedIndex].value)' "+disabled+">";
		for(var i=0;i<t_page;i++){
			if (pg==i){
		 		pghtml+="<option value='"+i+"' selected>"+(i+1)+"</option>";
		 	}else{
		  		pghtml+="<option value='"+i+"' >"+(i+1)+"</option>";
		  	}
		}
		pghtml+="</select>";
		obj_pg.innerHTML = pghtml;
	}else{
		obj_pg.innerHTML = "";
	}
}
 
//將時間 轉回 24小時//04:00p
function  change_time(get_time){
	
	if (get_time.indexOf("font") > 0 ) return get_time;
	if (get_time.indexOf("p")>0 || get_time.indexOf("a")>0){
		gtime=get_time.split(":");
		if (gtime[1].indexOf("p")>0){
			
			if (gtime[0]!="12"){
				gtime[0]=gtime[0]*1+12;
			}	
		}
		gtime[1]=gtime[1].replace("a","").replace("p","");
		
	}else{
		return get_time;
	}
	return gtime[0]+":"+gtime[1];
	
}
 
//隱藏我的最愛選擇聯賽
function dis_ShowLoveI(){
 
if(top.swShowLoveI){
  body_browse.document.getElementById("sel_league").style.display="none";
 }else{
  body_browse.document.getElementById("sel_league").style.display="";
 }
 
}
 
 
function changeTitleStr(s,at){
	if (s.charAt(at)=="H"){
		return "H";
	}else if(s.charAt(at)=="C"){
		return "A";
	}else if(s.charAt(at)=="N"){
		return "D";
	}
	return "";
}
 
 
function loadingOK(){
	//alert("loadingOK")
	try{
		body_browse.document.getElementById("refresh_btn").className="refresh_btn";
	}catch(E){}
	try{
	body_browse.document.getElementById("refresh_right").className="refresh_M_btn";
	}catch(E){}
	try{	
	body_browse.document.getElementById("refresh_down").className="refresh_M_btn";
	}catch(E){}
}
 
 
var gameCount="";
var recordHash=new Array();
function showHOT(countHOT){
	
if( (""+countHOT=="") || (""+countHOT=="undefined") ){
	
	 body_browse.document.getElementById("euro_btn").style.display="none";
	 body_browse.document.getElementById("euro_up").style.display="none";
			
}else{	
		
	if(""+top.hot_game=="undefined"){
		top.hot_game="";
	}	
	var gtypeHOT =new Array("FT","BK","TN","VB","OP");
	var countgames=countHOT.split(",");
	recordHash=new Array();
	var head_str="";
	
	if(rtype == "re"){
		head_str="RB";
	}else{
		head_str=top.head_FU;
	}
	//alert(head_str);
	
	for( var i=0;i<countgames.length;i++){
		var detailgame=countgames[i].split("|");
		recordHash[detailgame[0]+"_"+detailgame[1]]=detailgame[2]*1;
	}
	if(recordHash[top.head_gtype+"_HOT_"+head_str]*1==0){
		body_browse.document.getElementById("euro_btn").style.display="none";
		body_browse.document.getElementById("euro_up").style.display="none";
		//body_browse.document.getElementById("euro_close").style.display="";
		if(top.hot_game!=""){
			top.hot_game="";
			body_browse.reload_var();
		}
	}else{	
		if(top.hot_game!=""){
			body_browse.document.getElementById("euro_btn").style.display="none";
			body_browse.document.getElementById("euro_up").style.display="";
		}else{
			body_browse.document.getElementById("euro_btn").style.display="";
			body_browse.document.getElementById("euro_up").style.display="none";
		}
		//body_browse.document.getElementById("euro_close").style.display="none";	
	}
	//alert(recordHash[top.head_gtype+"_HOT_RB"]);
	//alert(recordHash[top.head_gtype+"_HOT_FT"]);
	//alert(recordHash[top.head_gtype+"_HOT_FU"]);
	//parent.mem_order.showHOT(recordHash[top.head_gtype+"_HOT_FT"],recordHash[top.head_gtype+"_HOT_FU"]);
	//parent.mem_order.showHOT(recordHash["FT_HOT_FT"],recordHash["FT_HOT_FU"]);
	/*
	var today_hot=0;
	var early_hot=0;
	for( var i=0;i<gtypeHOT.length;i++){
		try{
		parent.mem_order.document.getElementById(gtypeHOT[i]+"_FT").innerHTML=eval("top.str_"+gtypeHOT[i]) + "("+recordHash[gtypeHOT[i]+"_HOT_FT"]+")";
		parent.mem_order.document.getElementById(gtypeHOT[i]+"_FU").innerHTML=eval("top.str_"+gtypeHOT[i]) + "("+recordHash[gtypeHOT[i]+"_HOT_FU"]+")";
		}catch(E){}
			
		today_hot +=recordHash[gtypeHOT[i]+"_HOT_FT"];
		early_hot +=recordHash[gtypeHOT[i]+"_HOT_FU"];
	}	
	
		parent.mem_order.showHOT(today_hot,early_hot);
	*/	
	try{
		parent.mem_order.getCountHOT(countHOT);
	}catch(e){}
		
 }		
 	
}
<?	
break;
case 'hrpd':
?>
var ObjDataFT=new Array();
var oldObjDataFT=new Array();
//var GameHead=new Array("gid","datetime","league","gnum_h","gnum_c","team_h","team_c","strong","ior_H1C0","ior_H2C0","ior_H2C1","ior_H3C0","ior_H3C1","ior_H3C2","ior_H4C0","ior_H4C1","ior_H4C2","ior_H4C3","ior_H0C0","ior_H1C1","ior_H2C2","ior_H3C3","ior_H4C4","ior_OVH","ior_H0C1","ior_H0C2","ior_H1C2","ior_H0C3","ior_H1C3","ior_H2C3","ior_H0C4","ior_H1C4","ior_H2C4","ior_H3C4","ior_OVC");
var keepleg="";
var legnum=0;
var NoshowLeg=new Array();
var myLeg=new Array();
var LeagueAry=new Array();
 
function ShowGameList(){
	if(loading == 'Y') return;
	if (parent.gamecount!=gamount){
		oldObjDataFT=new Array();
	}
	if(top.odd_f_type==""||""+top.odd_f_type=="undefined") top.odd_f_type="H";
	keepscroll=body_browse.document.body.scrollTop;
	var conscroll= body_browse.document.getElementById('controlscroll');
	dis_ShowLoveI();
 
	//秀盤面
	showtables(GameFT,GameHead,gamount,top.odd_f_type);
 
	body_browse.scroll(0,keepscroll);
 
	//設定右方重新整理位置
	setRefreshPos();
 
	parent.gamecount=gamount;
	//日期下拉霸
 
	if (sel_gtype=="FU"){
		if (""+body_browse.document.getElementById('g_date')!="undefined"){
			body_browse.selgdate("hpd",g_date);
			body_browse.document.getElementById('g_date').value=g_date;
		}
	}
	if (top.hot_game!=""){
		body_browse.document.getElementById('sel_league').style.display='none';
		show_page();
 	}else{	
 		
	if(top.showtype=='hgft'||top.showtype=='hgfu'){
		obj_sel = body_browse.document.getElementById('sel_league');
		obj_sel.style.display='none';
		try{
			var obj_date='';
			obj_date=body_browse.document.getElementById("g_date").value;
			body_browse.selgdate("",obj_date);
		}catch(E){}
	}else{
	}
	show_page();
	
 }
	conscroll.style.display="none";
	coun_Leagues();
	body_browse.showPicLove();
	loadingOK();
	
	parent.mem_order.getCountHOT(gameCount);
	showHOT(gameCount);
}
var hotgdateArr =new Array();
function hot_gdate(gdate){
	if((""+hotgdateArr).indexOf(gdate)==-1){
		hotgdateArr.push(gdate);
	}
}
function coun_Leagues(){
	var coun=0;
	var str_tmp ="|"+eval('parent.'+sel_gtype+'_lname_ary_RE');
	if(str_tmp=='|ALL'){
		body_browse.document.getElementById("str_num").innerHTML =top.alldata;
	}else{
		var larray=str_tmp.split('|');
		for(var i =0;i<larray.length;i++){
			if(larray[i]!=""){coun++}
		}
		coun =LeagueAry.length;
		body_browse.document.getElementById("str_num").innerHTML =coun;
	}
	
	
}
//表格函數
function showtables(GameData,Game_Head,data_amount,odd_f_type){
	ObjDataFT=new Array();
	myLeg=new Array();
	for (var j=0;j < data_amount;j++){
		if (GameData[j]!=null){
			ObjDataFT[j]=parseArray(Game_Head,GameData[j]);
		}
	}
	var trdata;
	var showtableData;
	if(body_browse.document.all){
	     	showtableData=body_browse.document.getElementById('showtableData').innerText ;
	     	trdata=body_browse.document.getElementById('DataTR').innerText;
	     	notrdata=body_browse.document.getElementById('NoDataTR').innerText;
	} else{
	     	showtableData=body_browse.document.getElementById('showtableData').textContent ;
	     	trdata=body_browse.document.getElementById('DataTR').textContent;
		notrdata=body_browse.document.getElementById('NoDataTR').textContent;
	}
	var showtable=body_browse.document.getElementById('showtable');
	var showlayers="";
	keepleg="";
	legnum=0;
	LeagueAry =new Array();
	if(ObjDataFT.length > 0){
	  	for ( i=0 ;i < ObjDataFT.length;i++){
	  			showlayers+=getLayer(trdata,i,odd_f_type);
	  	}
	  	if(showlayers=="")showlayers=notrdata;
	  	showtableData=showtableData.replace("*showDataTR*",showlayers);
	}else{
		showtableData=showtableData.replace("*showDataTR*",notrdata);
	}
	showtable.innerHTML=showtableData;
}
 
 
//表格內容
function getLayer(onelayer,gamerec,odd_f_type){
	var open_hot = false;
	if(MM_IdentificationDisplay(ObjDataFT[gamerec].datetime,ObjDataFT[gamerec].gnum_h)) return "";
	if (top.hot_game==""){
		if(("|"+eval('parent.'+sel_gtype+'_lname_ary_RE')).indexOf(("|"+ObjDataFT[gamerec].league+"|"),0)==-1&&eval('parent.'+sel_gtype+'_lname_ary_RE')!='ALL') return "";
		if((""+LeagueAry).indexOf(ObjDataFT[gamerec].league)== -1)LeagueAry.push(ObjDataFT[gamerec].league);
	}
	var tmp_date = ObjDataFT[gamerec].datetime.split("<br>")[0];
	onelayer=onelayer.replace(/\*ID_STR\*/g,tmp_date+ObjDataFT[gamerec].gnum_h);
	onelayer=onelayer.replace(/\*TR_EVENT\*/g,"onMouseOver='mouseEnter_pointer(this.id);' onMouseOut='mouseOut_pointer(this.id);'");
 
	if (""+myLeg[ObjDataFT[gamerec].league]=="undefined"){
			myLeg[ObjDataFT[gamerec].league]=ObjDataFT[gamerec].league;
			myLeg[ObjDataFT[gamerec].league]=new Array();
			myLeg[ObjDataFT[gamerec].league][0]=tmp_date+ObjDataFT[gamerec].gnum_h;
	}else{
			myLeg[ObjDataFT[gamerec].league][myLeg[ObjDataFT[gamerec].league].length]=tmp_date+ObjDataFT[gamerec].gnum_h;
	}
 
	//--------------判斷聯盟名稱列顯示或隱藏----------------
	if (ObjDataFT[gamerec].league==keepleg){
			onelayer=onelayer.replace("*ST*"," style='display: none;'");
	}else{
			onelayer=onelayer.replace("*ST*"," style='display: ;'");
	}
	//---------------------------------------------------------------------
	//--------------判斷聯盟底下的賽事顯示或隱藏----------------
	if (NoshowLeg[ObjDataFT[gamerec].league]==-1){
		onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: none;'");
		onelayer=onelayer.replace("*LegMark*","<span id='LegClose'></span>"); //聯盟的小圖
	}else{
		onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: ;'");
		onelayer=onelayer.replace("*LegMark*","<span id='LegOpen'></span>");  //聯盟的小圖
	}
	//---------------------------------------------------------------------
 
	//滾球字眼
	ObjDataFT[gamerec].datetime=ObjDataFT[gamerec].datetime.replace("Running Ball","");
	keepleg=ObjDataFT[gamerec].league;
	onelayer=onelayer.replace(/\*LEG\*/gi,ObjDataFT[gamerec].league);
 
	var tmp_date=ObjDataFT[gamerec].datetime.split("<br>");
	if (sel_gtype=="FU"){
		tmp_date_str=tmp_date[0]+"<br>"+change_time(tmp_date[1]);
	}else{
		tmp_date_str=change_time(tmp_date[1]);
	}
	if (tmp_date.length==3){
		tmp_date_str+="<br>"+tmp_date[2];
	}	
	onelayer=onelayer.replace("*DATETIME*",tmp_date_str);
	onelayer=onelayer.replace("*TEAM_H*",ObjDataFT[gamerec].team_h.replace("[Mid]","<font color=\"#005aff\">[N]</font>").replace("[中]","<font color=\"#005aff\">[中]</font>"));
	onelayer=onelayer.replace("*TEAM_C*",ObjDataFT[gamerec].team_c);
	//全場
	//波膽
	onelayer=onelayer.replace("*RATIO_H1C0*",parseUrl(uid,odd_f_type,"RH1C0",ObjDataFT[gamerec],gamerec,"HRPD"));
	onelayer=onelayer.replace("*RATIO_H2C0*",parseUrl(uid,odd_f_type,"RH2C0",ObjDataFT[gamerec],gamerec,"HRPD"));
	onelayer=onelayer.replace("*RATIO_H2C1*",parseUrl(uid,odd_f_type,"RH2C1",ObjDataFT[gamerec],gamerec,"HRPD"));
	onelayer=onelayer.replace("*RATIO_H3C0*",parseUrl(uid,odd_f_type,"RH3C0",ObjDataFT[gamerec],gamerec,"HRPD"));
	onelayer=onelayer.replace("*RATIO_H3C1*",parseUrl(uid,odd_f_type,"RH3C1",ObjDataFT[gamerec],gamerec,"HRPD"));
	onelayer=onelayer.replace("*RATIO_H3C2*",parseUrl(uid,odd_f_type,"RH3C2",ObjDataFT[gamerec],gamerec,"HRPD"));
	/*
	onelayer=onelayer.replace("*RATIO_H4C0*",parseUrl(uid,odd_f_type,"H4C0",ObjDataFT[gamerec],gamerec,"HPD"));
	onelayer=onelayer.replace("*RATIO_H4C1*",parseUrl(uid,odd_f_type,"H4C1",ObjDataFT[gamerec],gamerec,"HPD"));
	onelayer=onelayer.replace("*RATIO_H4C2*",parseUrl(uid,odd_f_type,"H4C2",ObjDataFT[gamerec],gamerec,"HPD"));
	onelayer=onelayer.replace("*RATIO_H4C3*",parseUrl(uid,odd_f_type,"H4C3",ObjDataFT[gamerec],gamerec,"HPD"));
	*/
	onelayer=onelayer.replace("*RATIO_H0C0*",parseUrl(uid,odd_f_type,"RH0C0",ObjDataFT[gamerec],gamerec,"HRPD"));
	onelayer=onelayer.replace("*RATIO_H1C1*",parseUrl(uid,odd_f_type,"RH1C1",ObjDataFT[gamerec],gamerec,"HRPD"));
	onelayer=onelayer.replace("*RATIO_H2C2*",parseUrl(uid,odd_f_type,"RH2C2",ObjDataFT[gamerec],gamerec,"HRPD"));
	onelayer=onelayer.replace("*RATIO_H3C3*",parseUrl(uid,odd_f_type,"RH3C3",ObjDataFT[gamerec],gamerec,"HRPD"));
	//onelayer=onelayer.replace("*RATIO_H4C4*",parseUrl(uid,odd_f_type,"H4C4",ObjDataFT[gamerec],gamerec,"HPD"));
	onelayer=onelayer.replace("*RATIO_OVH*",parseUrl(uid,odd_f_type,"ROVH",ObjDataFT[gamerec],gamerec,"HRPD"));
	onelayer=onelayer.replace("*RATIO_H0C1*",parseUrl(uid,odd_f_type,"RH0C1",ObjDataFT[gamerec],gamerec,"HRPD"));
	onelayer=onelayer.replace("*RATIO_H0C2*",parseUrl(uid,odd_f_type,"RH0C2",ObjDataFT[gamerec],gamerec,"HRPD"));
	onelayer=onelayer.replace("*RATIO_H1C2*",parseUrl(uid,odd_f_type,"RH1C2",ObjDataFT[gamerec],gamerec,"HRPD"));
	onelayer=onelayer.replace("*RATIO_H0C3*",parseUrl(uid,odd_f_type,"RH0C3",ObjDataFT[gamerec],gamerec,"HRPD"));
	onelayer=onelayer.replace("*RATIO_H1C3*",parseUrl(uid,odd_f_type,"RH1C3",ObjDataFT[gamerec],gamerec,"HRPD"));
	onelayer=onelayer.replace("*RATIO_H2C3*",parseUrl(uid,odd_f_type,"RH2C3",ObjDataFT[gamerec],gamerec,"HRPD"));
	/*
	onelayer=onelayer.replace("*RATIO_H0C4*",parseUrl(uid,odd_f_type,"H0C4",ObjDataFT[gamerec],gamerec,"HPD"));
	onelayer=onelayer.replace("*RATIO_H1C4*",parseUrl(uid,odd_f_type,"H1C4",ObjDataFT[gamerec],gamerec,"HPD"));
	onelayer=onelayer.replace("*RATIO_H2C4*",parseUrl(uid,odd_f_type,"H2C4",ObjDataFT[gamerec],gamerec,"HPD"));
	onelayer=onelayer.replace("*RATIO_H3C4*",parseUrl(uid,odd_f_type,"H3C4",ObjDataFT[gamerec],gamerec,"HPD"));
	*/
	return onelayer;
}
 
 
//取得下注的url
function parseUrl(uid,odd_f_type,rtype,GameData,gamerec,wtype){
	var urlArray=new Array();
	urlArray['RPD']=new Array("../FT_order/FT_order_rpd.php");
	urlArray['HRPD']=new Array("../FT_order/FT_order_hrpd.php");
 
	var param=getParam(uid,odd_f_type,rtype,wtype,GameData);
	var order=urlArray[wtype][0];
	var tmp_rtype="ior_"+rtype;
	var ioratio_str="GameData."+tmp_rtype;
	var team="";
	if (rtype=="OVH"){
		team="Other Score";
	}else{
		team=rtype.replace("H","").replace("C",":");
	}
	var ioratio=eval(ioratio_str);
 	//var ret="<a href='"+order+"?"+param+"' target='mem_order' title='"+team+"'><font "+check_ioratio(gamerec,tmp_rtype,GameData)+">"+ioratio+"</font></a>";
	//alert(parent.name)
	var ret="<a href='javascript://' onclick=\"parent.parent.mem_order.betOrder('FT','"+wtype+"','"+param+"');\" title='"+team+"'><font "+check_ioratio(gamerec,tmp_rtype,GameData)+">"+ioratio+"</font></a>";
 
	return ret;
 
}
 
//--------------------------public function --------------------------------
 
//取得下注參數
function getParam(uid,odd_f_type,rtype,wtype,GameData){
	var paramArray=new Array();
	paramArray['RPD']=new Array("gid","uid","odd_f_type","rtype","langx");
	paramArray['HRPD']=new Array("gid","uid","odd_f_type","rtype","langx");
 
	var param="";
	var gid=GameData.gid;
 
	for (var i=0;i<paramArray[wtype].length;i++){
		if (i>0)  param+="&";
		param+=paramArray[wtype][i]+"="+eval(paramArray[wtype][i]);
	}
	return param;
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8 "><script>
var isHot_game = false;//是否為世足賽
//--------------------------------public function ----------------------------
 
function setRefreshPos(){
		var refresh_right= body_browse.document.getElementById('refresh_right');
		refresh_right.style.left= body_browse.document.getElementById('myTable').clientWidth*1+20;
		//refresh_right.style.top= 39;
	}
 
function parseArray(gameHead,gameData){
	var gameObj=new Object();
	for (var i=0;i<gameHead.length;i++){
		if (gameHead[i]!=""){	
			eval("gameObj."+gameHead[i]+"='"+gameData[i]+"'");
		}
	}
	return gameObj;
}
 
 
function check_ioratio(rec,rtype,GameData){
//alert(flash_ior_set);
	//return true;
	//alert(GameFT.length+"----"+keepGameData.length)
 
	if (flash_ior_set =='Y'){
		//alert(oldObjDataFT[rec]);
		if (""+oldObjDataFT[rec]=="undefined" || oldObjDataFT[rec].gid != GameData.gid){
			var gameObj=new Object();
			gameObj.gid=GameData.gid;
			oldObjDataFT[rec]=gameObj;
		}
		
		var new_ioratio=eval("GameData."+rtype);
		var old_ioratio=eval("oldObjDataFT[rec]."+rtype);
		
		
		if (""+old_ioratio=="undefined"){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			old_ioratio=eval("oldObjDataFT[rec]."+rtype);
		}
		
		//alert("old_ioratio==>"+old_ioratio+",new_ioratio==>"+new_ioratio);
		if (""+new_ioratio=="undefined" || new_ioratio==""){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return;
		}
		
		/*
		if (parseFloat(old_ioratio)>parseFloat(new_ioratio) ){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='border: 1px solid #FF0000;' ";
		}
		if (parseFloat(old_ioratio)<parseFloat(new_ioratio) ){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='border: 1px solid #00FF00;' ";
		}
		*/
		
		if (old_ioratio!=new_ioratio && old_ioratio !="" && new_ioratio!="") {
	    	eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='background-color : yellow' ";
		}
		
		return true;
	}
 
}
//--------------判斷聯盟顯示或隱藏----------------
function showLeg(leg){
	for (var i=0;i<myLeg[leg].length;i++){
	if ( body_browse.document.getElementById("TR_"+myLeg[leg][i]).style.display!="none"){
				showLegIcon(leg,"LegClose",myLeg[leg][i],"none");
				
		}else{
			showLegIcon(leg,"LegOpen",myLeg[leg][i],"");
		}
	}
	if ((""+NoshowLeg[leg])=="undefined"){
		NoshowLeg[leg]=-1;
	}else{
		NoshowLeg[leg]=NoshowLeg[leg]*-1;
	}
 
}
function showLegIcon(leg,state,gnumH,display){
	var  ary=body_browse.document.getElementsByName(leg);
			
	for (var j=0;j<ary.length;j++){
		ary[j].innerHTML="<span id='"+state+"'></span>";
	}
	try{
		body_browse.document.getElementById("TR3_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR2_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR1_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR_"+gnumH).style.display=display;
	}catch(E){}
}
//----------------------
 
//分頁
function show_page(){
	//alert(rtype)
	pg_str='';
	obj_pg = body_browse.document.getElementById('pg_txt');
//	alert(t_page);
	if (t_page==0){
		t_page=1;
		//obj_pg.innerHTML = "";
		//return;
	}
	var tmp_lid="";
	if (rtype=="re"){
		tmp_lid=eval("parent."+sel_gtype+"_lid_ary_RE");
	}else{
		tmp_lid=eval("parent."+sel_gtype+"_lid_ary");
	}
	//alert(tmp_lid+"--"+top.swShowLoveI+"--"+t_page)
	if(tmp_lid=='ALL'&&!top.swShowLoveI){
		var disabled="";
		if (t_page==1){
			disabled="disabled";
			}
		var pghtml=(pg*1+1)+" / " +t_page+" "+top.page+"&nbsp;&nbsp; <select  onchange='chg_pg(this.options[this.selectedIndex].value)' "+disabled+">";
		for(var i=0;i<t_page;i++){
			if (pg==i){
		 		pghtml+="<option value='"+i+"' selected>"+(i+1)+"</option>";
		 	}else{
		  		pghtml+="<option value='"+i+"' >"+(i+1)+"</option>";
		  	}
		}
		pghtml+="</select>";
		obj_pg.innerHTML = pghtml;
	}else{
		obj_pg.innerHTML = "";
	}
}
 
//將時間 轉回 24小時//04:00p
function  change_time(get_time){
	
	if (get_time.indexOf("font") > 0 ) return get_time;
	if (get_time.indexOf("p")>0 || get_time.indexOf("a")>0){
		gtime=get_time.split(":");
		if (gtime[1].indexOf("p")>0){
			
			if (gtime[0]!="12"){
				gtime[0]=gtime[0]*1+12;
			}	
		}
		gtime[1]=gtime[1].replace("a","").replace("p","");
		
	}else{
		return get_time;
	}
	return gtime[0]+":"+gtime[1];
	
}
 
//隱藏我的最愛選擇聯賽
function dis_ShowLoveI(){
 
if(top.swShowLoveI){
  body_browse.document.getElementById("sel_league").style.display="none";
 }else{
  body_browse.document.getElementById("sel_league").style.display="";
 }
 
}
 
 
function changeTitleStr(s,at){
	if (s.charAt(at)=="H"){
		return "H";
	}else if(s.charAt(at)=="C"){
		return "A";
	}else if(s.charAt(at)=="N"){
		return "D";
	}
	return "";
}
 
 
function loadingOK(){
	//alert("loadingOK")
	try{
		body_browse.document.getElementById("refresh_btn").className="refresh_btn";
	}catch(E){}
	try{
	body_browse.document.getElementById("refresh_right").className="refresh_M_btn";
	}catch(E){}
	try{	
	body_browse.document.getElementById("refresh_down").className="refresh_M_btn";
	}catch(E){}
}
 
 
var gameCount="";
var recordHash=new Array();
function showHOT(countHOT){
	
if( (""+countHOT=="") || (""+countHOT=="undefined") ){
	
	 body_browse.document.getElementById("euro_btn").style.display="none";
	 body_browse.document.getElementById("euro_up").style.display="none";
			
}else{	
		
	if(""+top.hot_game=="undefined"){
		top.hot_game="";
	}	
	var gtypeHOT =new Array("FT","BK","TN","VB","OP");
	var countgames=countHOT.split(",");
	recordHash=new Array();
	var head_str="";
	
	if(rtype == "re"){
		head_str="RB";
	}else{
		head_str=top.head_FU;
	}
	//alert(head_str);
	
	for( var i=0;i<countgames.length;i++){
		var detailgame=countgames[i].split("|");
		recordHash[detailgame[0]+"_"+detailgame[1]]=detailgame[2]*1;
	}
	if(recordHash[top.head_gtype+"_HOT_"+head_str]*1==0){
		body_browse.document.getElementById("euro_btn").style.display="none";
		body_browse.document.getElementById("euro_up").style.display="none";
		//body_browse.document.getElementById("euro_close").style.display="";
		if(top.hot_game!=""){
			top.hot_game="";
			body_browse.reload_var();
		}
	}else{
		if(isHot_game){
			if(top.hot_game!=""){
				body_browse.document.getElementById("euro_btn").style.display="none";
				body_browse.document.getElementById("euro_up").style.display="";
			}else{
				body_browse.document.getElementById("euro_btn").style.display="";
				body_browse.document.getElementById("euro_up").style.display="none";
			}
		}
		//body_browse.document.getElementById("euro_close").style.display="none";	
	}
	//alert(recordHash[top.head_gtype+"_HOT_RB"]);
	//alert(recordHash[top.head_gtype+"_HOT_FT"]);
	//alert(recordHash[top.head_gtype+"_HOT_FU"]);
	//parent.mem_order.showHOT(recordHash[top.head_gtype+"_HOT_FT"],recordHash[top.head_gtype+"_HOT_FU"]);
	//parent.mem_order.showHOT(recordHash["FT_HOT_FT"],recordHash["FT_HOT_FU"]);
	/*
	var today_hot=0;
	var early_hot=0;
	for( var i=0;i<gtypeHOT.length;i++){
		try{
		parent.mem_order.document.getElementById(gtypeHOT[i]+"_FT").innerHTML=eval("top.str_"+gtypeHOT[i]) + "("+recordHash[gtypeHOT[i]+"_HOT_FT"]+")";
		parent.mem_order.document.getElementById(gtypeHOT[i]+"_FU").innerHTML=eval("top.str_"+gtypeHOT[i]) + "("+recordHash[gtypeHOT[i]+"_HOT_FU"]+")";
		}catch(E){}
			
		today_hot +=recordHash[gtypeHOT[i]+"_HOT_FT"];
		early_hot +=recordHash[gtypeHOT[i]+"_HOT_FU"];
	}	
	
		parent.mem_order.showHOT(today_hot,early_hot);
	*/	
	try{
		parent.mem_order.getCountHOT(countHOT);
	}catch(e){}
		
 }		
 	
}
 
//function getCountHOT(){
//	return recordHash[top.head_gtype+"_HOT_FT"];
//}
function keep_show_more(gid,GameFT,gamount){
	if(gid!=''){
		show_more_gid = '';
		for (var j=0;j < gamount;j++){
			if(gid == GameFT[j].gid  && GameFT[j].more != 0){
				//body_browse.showdata.location.reload();
				show_more_gid = gid;
				return;
			}
		}
	}
	body_browse.document.getElementById('more_window').style.display='none';
}
<?	
break;
case 'rpd':
?>
var ObjDataFT=new Array();
var oldObjDataFT=new Array();
//var GameHead=new Array("gid","datetime","league","gnum_h","gnum_c","team_h","team_c","strong","ior_H1C0","ior_H2C0","ior_H2C1","ior_H3C0","ior_H3C1","ior_H3C2","ior_H4C0","ior_H4C1","ior_H4C2","ior_H4C3","ior_H0C0","ior_H1C1","ior_H2C2","ior_H3C3","ior_H4C4","ior_OVH","ior_H0C1","ior_H0C2","ior_H1C2","ior_H0C3","ior_H1C3","ior_H2C3","ior_H0C4","ior_H1C4","ior_H2C4","ior_H3C4","ior_OVC");
var keepleg="";
var legnum=0;
var NoshowLeg=new Array();
var myLeg=new Array();
var LeagueAry=new Array();
 
function ShowGameList(){
	reTimeNow = retime;
	
	if(loading == 'Y') return;
	if (parent.gamecount!=gamount){
		oldObjDataFT=new Array();
	}
	if(top.odd_f_type==""||""+top.odd_f_type=="undefined") top.odd_f_type="H";
	keepscroll=body_browse.document.body.scrollTop;
	var conscroll= body_browse.document.getElementById('controlscroll');
	dis_ShowLoveI();
 
	//秀盤面
	showtables(GameFT,GameHead,gamount,top.odd_f_type);
 
	body_browse.scroll(0,keepscroll);
 
	//設定右方重新整理位置
	setRefreshPos();
 
	parent.gamecount=gamount;
	//日期下拉霸
 
	if (sel_gtype=="FU"){
		if (""+body_browse.document.getElementById('g_date')!="undefined"){
			body_browse.selgdate("pd",g_date);
			body_browse.document.getElementById('g_date').value=g_date;
		}
	}
	if (top.hot_game!=""){
		body_browse.document.getElementById('sel_league').style.display='none';
		
 	}else{
 			
	if(top.showtype=='hgft'||top.showtype=='hgfu'){
		obj_sel = body_browse.document.getElementById('sel_league');
		obj_sel.style.display='none';
		try{
			var obj_date='';
			obj_date=body_browse.document.getElementById("g_date").value;
			body_browse.selgdate("",obj_date);
		}catch(E){}
	}else{
		
	}
	show_page();
 }	
	conscroll.style.display="none";
	coun_Leagues();
	body_browse.showPicLove();
	loadingOK();
	
	parent.mem_order.getCountHOT(gameCount);
	showHOT(gameCount);
}
var hotgdateArr =new Array();
function hot_gdate(gdate){
	if((""+hotgdateArr).indexOf(gdate)==-1){
		hotgdateArr.push(gdate);
	}
}
function coun_Leagues(){
	var coun=0;
	var str_tmp ="|"+eval('parent.'+sel_gtype+'_lname_ary_RE');
	if(str_tmp=='|ALL'){
		body_browse.document.getElementById("str_num").innerHTML =top.alldata;
	}else{
		var larray=str_tmp.split('|');
		for(var i =0;i<larray.length;i++){
			if(larray[i]!=""){coun++}
		}
		coun =LeagueAry.length;
		body_browse.document.getElementById("str_num").innerHTML =coun;
	}
	
	
}
//表格函數
function showtables(GameData,Game_Head,data_amount,odd_f_type){
	ObjDataFT=new Array();
	myLeg=new Array();
	for (var j=0;j < data_amount;j++){
		if (GameData[j]!=null){
			ObjDataFT[j]=parseArray(Game_Head,GameData[j]);
		}
	}
	var trdata;
	var showtableData;
	if(body_browse.document.all){
	     	showtableData=body_browse.document.getElementById('showtableData').innerText ;
	     	trdata=body_browse.document.getElementById('DataTR').innerText;
		notrdata=body_browse.document.getElementById('NoDataTR').innerText;
	} else{
		showtableData=body_browse.document.getElementById('showtableData').textContent ;
		trdata=body_browse.document.getElementById('DataTR').textContent;
		notrdata=body_browse.document.getElementById('NoDataTR').textContent;
	}
	var showtable=body_browse.document.getElementById('showtable');
	var showlayers="";
	keepleg="";
	legnum=0;
	LeagueAry =new Array();
	if(ObjDataFT.length > 0){
	  	for ( i=0 ;i < ObjDataFT.length;i++){
	  		showlayers+=getLayer(trdata,i,odd_f_type);
	  	}
	  	if(showlayers=="")showlayers=notrdata;
  		showtableData=showtableData.replace("*showDataTR*",showlayers);
	}else{
		showtableData=showtableData.replace("*showDataTR*",notrdata);
	}
	showtable.innerHTML=showtableData;
}
 
 
//表格內容
function getLayer(onelayer,gamerec,odd_f_type){
	var open_hot = false;
	if(MM_IdentificationDisplay(ObjDataFT[gamerec].datetime,ObjDataFT[gamerec].gnum_h)) return "";
	if (top.hot_game==""){
	if(("|"+eval('parent.'+sel_gtype+'_lname_ary_RE')).indexOf(("|"+ObjDataFT[gamerec].league+"|"),0)==-1&&eval('parent.'+sel_gtype+'_lname_ary_RE')!='ALL') return "";
	if((""+LeagueAry).indexOf(ObjDataFT[gamerec].league)== -1)LeagueAry.push(ObjDataFT[gamerec].league);
	}
	var tmp_date = ObjDataFT[gamerec].datetime.split("<br>")[0];
	onelayer=onelayer.replace(/\*ID_STR\*/g,tmp_date+ObjDataFT[gamerec].gnum_h);
	onelayer=onelayer.replace(/\*TR_EVENT\*/g,"onMouseOver='mouseEnter_pointer(this.id);' onMouseOut='mouseOut_pointer(this.id);'");
 
	if (""+myLeg[ObjDataFT[gamerec].league]=="undefined"){
			myLeg[ObjDataFT[gamerec].league]=ObjDataFT[gamerec].league;
			myLeg[ObjDataFT[gamerec].league]=new Array();
			myLeg[ObjDataFT[gamerec].league][0]=tmp_date+ObjDataFT[gamerec].gnum_h;
	}else{
			myLeg[ObjDataFT[gamerec].league][myLeg[ObjDataFT[gamerec].league].length]=tmp_date+ObjDataFT[gamerec].gnum_h;
	}
 
	//--------------判斷聯盟名稱列顯示或隱藏----------------
	if (ObjDataFT[gamerec].league==keepleg){
			onelayer=onelayer.replace("*ST*"," style='display: none;'");
	}else{
			onelayer=onelayer.replace("*ST*"," style='display: ;'");
	}
	//---------------------------------------------------------------------
	//--------------判斷聯盟底下的賽事顯示或隱藏----------------
	if (NoshowLeg[ObjDataFT[gamerec].league]==-1){
		onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: none;'");
		onelayer=onelayer.replace("*LegMark*","<span id='LegClose'></span>"); //聯盟的小圖
	}else{
		onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: ;'");
		onelayer=onelayer.replace("*LegMark*","<span id='LegOpen'></span>");  //聯盟的小圖
	}
	//---------------------------------------------------------------------
 
	//滾球字眼
	ObjDataFT[gamerec].datetime=ObjDataFT[gamerec].datetime.replace("Running Ball","");
	keepleg=ObjDataFT[gamerec].league;
	onelayer=onelayer.replace(/\*LEG\*/gi,ObjDataFT[gamerec].league);
 
	var tmp_date=ObjDataFT[gamerec].datetime.split("<br>");
	if (sel_gtype=="FU"){
		tmp_date_str=tmp_date[0]+"<br>"+change_time(tmp_date[1]);
	}else{
		tmp_date_str=change_time(tmp_date[1]);
	}
	if (tmp_date.length==3){
		tmp_date_str+="<br>"+tmp_date[2];
	}
	onelayer=onelayer.replace("*DATETIME*",tmp_date_str);
	onelayer=onelayer.replace("*TEAM_H*",ObjDataFT[gamerec].team_h.replace("[Mid]","<font color=\"#005aff\">[N]</font>").replace("[中]","<font color=\"#005aff\">[中]</font>"));
	onelayer=onelayer.replace("*TEAM_C*",ObjDataFT[gamerec].team_c);
	//全場
	//波膽
	onelayer=onelayer.replace("*RATIO_H1C0*",parseUrl(uid,odd_f_type,"RH1C0",ObjDataFT[gamerec],gamerec,"RPD"));
	onelayer=onelayer.replace("*RATIO_H2C0*",parseUrl(uid,odd_f_type,"RH2C0",ObjDataFT[gamerec],gamerec,"RPD"));
	onelayer=onelayer.replace("*RATIO_H2C1*",parseUrl(uid,odd_f_type,"RH2C1",ObjDataFT[gamerec],gamerec,"RPD"));
	onelayer=onelayer.replace("*RATIO_H3C0*",parseUrl(uid,odd_f_type,"RH3C0",ObjDataFT[gamerec],gamerec,"RPD"));
	onelayer=onelayer.replace("*RATIO_H3C1*",parseUrl(uid,odd_f_type,"RH3C1",ObjDataFT[gamerec],gamerec,"RPD"));
	onelayer=onelayer.replace("*RATIO_H3C2*",parseUrl(uid,odd_f_type,"RH3C2",ObjDataFT[gamerec],gamerec,"RPD"));
	onelayer=onelayer.replace("*RATIO_H4C0*",parseUrl(uid,odd_f_type,"RH4C0",ObjDataFT[gamerec],gamerec,"RPD"));
	onelayer=onelayer.replace("*RATIO_H4C1*",parseUrl(uid,odd_f_type,"RH4C1",ObjDataFT[gamerec],gamerec,"RPD"));
	onelayer=onelayer.replace("*RATIO_H4C2*",parseUrl(uid,odd_f_type,"RH4C2",ObjDataFT[gamerec],gamerec,"RPD"));
	onelayer=onelayer.replace("*RATIO_H4C3*",parseUrl(uid,odd_f_type,"RH4C3",ObjDataFT[gamerec],gamerec,"RPD"));
	onelayer=onelayer.replace("*RATIO_H0C0*",parseUrl(uid,odd_f_type,"RH0C0",ObjDataFT[gamerec],gamerec,"RPD"));
	onelayer=onelayer.replace("*RATIO_H1C1*",parseUrl(uid,odd_f_type,"RH1C1",ObjDataFT[gamerec],gamerec,"RPD"));
	onelayer=onelayer.replace("*RATIO_H2C2*",parseUrl(uid,odd_f_type,"RH2C2",ObjDataFT[gamerec],gamerec,"RPD"));
	onelayer=onelayer.replace("*RATIO_H3C3*",parseUrl(uid,odd_f_type,"RH3C3",ObjDataFT[gamerec],gamerec,"RPD"));
	onelayer=onelayer.replace("*RATIO_H4C4*",parseUrl(uid,odd_f_type,"RH4C4",ObjDataFT[gamerec],gamerec,"RPD"));
	onelayer=onelayer.replace("*RATIO_OVH*",parseUrl(uid,odd_f_type,"ROVH",ObjDataFT[gamerec],gamerec,"RPD"));
	onelayer=onelayer.replace("*RATIO_H0C1*",parseUrl(uid,odd_f_type,"RH0C1",ObjDataFT[gamerec],gamerec,"RPD"));
	onelayer=onelayer.replace("*RATIO_H0C2*",parseUrl(uid,odd_f_type,"RH0C2",ObjDataFT[gamerec],gamerec,"RPD"));
	onelayer=onelayer.replace("*RATIO_H1C2*",parseUrl(uid,odd_f_type,"RH1C2",ObjDataFT[gamerec],gamerec,"RPD"));
	onelayer=onelayer.replace("*RATIO_H0C3*",parseUrl(uid,odd_f_type,"RH0C3",ObjDataFT[gamerec],gamerec,"RPD"));
	onelayer=onelayer.replace("*RATIO_H1C3*",parseUrl(uid,odd_f_type,"RH1C3",ObjDataFT[gamerec],gamerec,"RPD"));
	onelayer=onelayer.replace("*RATIO_H2C3*",parseUrl(uid,odd_f_type,"RH2C3",ObjDataFT[gamerec],gamerec,"RPD"));
	onelayer=onelayer.replace("*RATIO_H0C4*",parseUrl(uid,odd_f_type,"RH0C4",ObjDataFT[gamerec],gamerec,"RPD"));
	onelayer=onelayer.replace("*RATIO_H1C4*",parseUrl(uid,odd_f_type,"RH1C4",ObjDataFT[gamerec],gamerec,"RPD"));
	onelayer=onelayer.replace("*RATIO_H2C4*",parseUrl(uid,odd_f_type,"RH2C4",ObjDataFT[gamerec],gamerec,"RPD"));
	onelayer=onelayer.replace("*RATIO_H3C4*",parseUrl(uid,odd_f_type,"RH3C4",ObjDataFT[gamerec],gamerec,"RPD"));
	
	return onelayer;
}
 
 
//取得下注的url
function parseUrl(uid,odd_f_type,rtype,GameData,gamerec,wtype){
	var urlArray=new Array();
	urlArray['RPD']=new Array("../FT_order/FT_order_rpd.php");
	urlArray['HRPD']=new Array("../FT_order/FT_order_hrpd.php");
 
	var param=getParam(uid,odd_f_type,rtype,wtype,GameData);
	var order=urlArray[wtype][0];
	var tmp_rtype="ior_"+rtype;
	var ioratio_str="GameData."+tmp_rtype;
	var team="";
	if (rtype=="ROVH"){
		team="Other Score";
	}else{
		team=rtype.replace("H","").replace("C",":");
	}
	
	
	
	var ioratio=eval(ioratio_str);
 	//var ret="<a href='"+order+"?"+param+"' target='mem_order' title='"+team+"'><font "+check_ioratio(gamerec,tmp_rtype,GameData)+">"+ioratio+"</font></a>";
	//alert(parent.name)
	var ret="<a href='javascript://' onclick=\"parent.parent.mem_order.betOrder('FT','"+wtype+"','"+param+"');\" title='"+team+"'><font "+check_ioratio(gamerec,tmp_rtype,GameData)+">"+ioratio+"</font></a>";
 
	return ret;
 
}
 
//--------------------------public function --------------------------------
 
//取得下注參數
function getParam(uid,odd_f_type,rtype,wtype,GameData){
	var paramArray=new Array();
	paramArray['RPD']=new Array("gid","uid","odd_f_type","rtype","langx");
	paramArray['HRPD']=new Array("gid","uid","odd_f_type","rtype","langx");
 
	var param="";
	var gid=GameData.gid;
 
	for (var i=0;i<paramArray[wtype].length;i++){
		if (i>0)  param+="&";
		param+=paramArray[wtype][i]+"="+eval(paramArray[wtype][i]);
	}
	return param;
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8 "><script>
var isHot_game = false;//是否為世足賽
//--------------------------------public function ----------------------------
 
function setRefreshPos(){
		var refresh_right= body_browse.document.getElementById('refresh_right');
		refresh_right.style.left= body_browse.document.getElementById('myTable').clientWidth*1+20;
		//refresh_right.style.top= 39;
	}
 
function parseArray(gameHead,gameData){
	var gameObj=new Object();
	for (var i=0;i<gameHead.length;i++){
		if (gameHead[i]!=""){	
			eval("gameObj."+gameHead[i]+"='"+gameData[i]+"'");
		}
	}
	return gameObj;
}
 
 
function check_ioratio(rec,rtype,GameData){
//alert(flash_ior_set);
	//return true;
	//alert(GameFT.length+"----"+keepGameData.length)
 
	if (flash_ior_set =='Y'){
		//alert(oldObjDataFT[rec]);
		if (""+oldObjDataFT[rec]=="undefined" || oldObjDataFT[rec].gid != GameData.gid){
			var gameObj=new Object();
			gameObj.gid=GameData.gid;
			oldObjDataFT[rec]=gameObj;
		}
		
		var new_ioratio=eval("GameData."+rtype);
		var old_ioratio=eval("oldObjDataFT[rec]."+rtype);
		
		
		if (""+old_ioratio=="undefined"){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			old_ioratio=eval("oldObjDataFT[rec]."+rtype);
		}
		
		//alert("old_ioratio==>"+old_ioratio+",new_ioratio==>"+new_ioratio);
		if (""+new_ioratio=="undefined" || new_ioratio==""){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return;
		}
		
		/*
		if (parseFloat(old_ioratio)>parseFloat(new_ioratio) ){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='border: 1px solid #FF0000;' ";
		}
		if (parseFloat(old_ioratio)<parseFloat(new_ioratio) ){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='border: 1px solid #00FF00;' ";
		}
		*/
		
		if (old_ioratio!=new_ioratio && old_ioratio !="" && new_ioratio!="") {
	    	eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='background-color : yellow' ";
		}
		
		return true;
	}
 
}
//--------------判斷聯盟顯示或隱藏----------------
function showLeg(leg){
	for (var i=0;i<myLeg[leg].length;i++){
	if ( body_browse.document.getElementById("TR_"+myLeg[leg][i]).style.display!="none"){
				showLegIcon(leg,"LegClose",myLeg[leg][i],"none");
				
		}else{
			showLegIcon(leg,"LegOpen",myLeg[leg][i],"");
		}
	}
	if ((""+NoshowLeg[leg])=="undefined"){
		NoshowLeg[leg]=-1;
	}else{
		NoshowLeg[leg]=NoshowLeg[leg]*-1;
	}
 
}
function showLegIcon(leg,state,gnumH,display){
	var  ary=body_browse.document.getElementsByName(leg);
			
	for (var j=0;j<ary.length;j++){
		ary[j].innerHTML="<span id='"+state+"'></span>";
	}
	try{
		body_browse.document.getElementById("TR3_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR2_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR1_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR_"+gnumH).style.display=display;
	}catch(E){}
}
//----------------------
 
//分頁
function show_page(){
	//alert(rtype)
	pg_str='';
	obj_pg = body_browse.document.getElementById('pg_txt');
//	alert(t_page);
	if (t_page==0){
		t_page=1;
		//obj_pg.innerHTML = "";
		//return;
	}
	var tmp_lid="";
	if (rtype=="re"){
		tmp_lid=eval("parent."+sel_gtype+"_lid_ary_RE");
	}else{
		tmp_lid=eval("parent."+sel_gtype+"_lid_ary");
	}
	//alert(tmp_lid+"--"+top.swShowLoveI+"--"+t_page)
	if(tmp_lid=='ALL'&&!top.swShowLoveI){
		var disabled="";
		if (t_page==1){
			disabled="disabled";
			}
		var pghtml=(pg*1+1)+" / " +t_page+" "+top.page+"&nbsp;&nbsp; <select  onchange='chg_pg(this.options[this.selectedIndex].value)' "+disabled+">";
		for(var i=0;i<t_page;i++){
			if (pg==i){
		 		pghtml+="<option value='"+i+"' selected>"+(i+1)+"</option>";
		 	}else{
		  		pghtml+="<option value='"+i+"' >"+(i+1)+"</option>";
		  	}
		}
		pghtml+="</select>";
		obj_pg.innerHTML = pghtml;
	}else{
		obj_pg.innerHTML = "";
	}
}
 
//將時間 轉回 24小時//04:00p
function  change_time(get_time){
	
	if (get_time.indexOf("font") > 0 ) return get_time;
	if (get_time.indexOf("p")>0 || get_time.indexOf("a")>0){
		gtime=get_time.split(":");
		if (gtime[1].indexOf("p")>0){
			
			if (gtime[0]!="12"){
				gtime[0]=gtime[0]*1+12;
			}	
		}
		gtime[1]=gtime[1].replace("a","").replace("p","");
		
	}else{
		return get_time;
	}
	return gtime[0]+":"+gtime[1];
	
}
 
//隱藏我的最愛選擇聯賽
function dis_ShowLoveI(){
 
if(top.swShowLoveI){
  body_browse.document.getElementById("sel_league").style.display="none";
 }else{
  body_browse.document.getElementById("sel_league").style.display="";
 }
 
}
 
 
function changeTitleStr(s,at){
	if (s.charAt(at)=="H"){
		return "H";
	}else if(s.charAt(at)=="C"){
		return "A";
	}else if(s.charAt(at)=="N"){
		return "D";
	}
	return "";
}
 
 
function loadingOK(){
	//alert("loadingOK")
	try{
		body_browse.document.getElementById("refresh_btn").className="refresh_btn";
	}catch(E){}
	try{
	body_browse.document.getElementById("refresh_right").className="refresh_M_btn";
	}catch(E){}
	try{	
	body_browse.document.getElementById("refresh_down").className="refresh_M_btn";
	}catch(E){}
}
 
 
var gameCount="";
var recordHash=new Array();
function showHOT(countHOT){
	
if( (""+countHOT=="") || (""+countHOT=="undefined") ){
	
	 body_browse.document.getElementById("euro_btn").style.display="none";
	 body_browse.document.getElementById("euro_up").style.display="none";
			
}else{	
		
	if(""+top.hot_game=="undefined"){
		top.hot_game="";
	}	
	var gtypeHOT =new Array("FT","BK","TN","VB","OP");
	var countgames=countHOT.split(",");
	recordHash=new Array();
	var head_str="";
	
	if(rtype == "re"){
		head_str="RB";
	}else{
		head_str=top.head_FU;
	}
	//alert(head_str);
	
	for( var i=0;i<countgames.length;i++){
		var detailgame=countgames[i].split("|");
		recordHash[detailgame[0]+"_"+detailgame[1]]=detailgame[2]*1;
	}
	if(recordHash[top.head_gtype+"_HOT_"+head_str]*1==0){
		body_browse.document.getElementById("euro_btn").style.display="none";
		body_browse.document.getElementById("euro_up").style.display="none";
		//body_browse.document.getElementById("euro_close").style.display="";
		if(top.hot_game!=""){
			top.hot_game="";
			body_browse.reload_var();
		}
	}else{
		if(isHot_game){
			if(top.hot_game!=""){
				body_browse.document.getElementById("euro_btn").style.display="none";
				body_browse.document.getElementById("euro_up").style.display="";
			}else{
				body_browse.document.getElementById("euro_btn").style.display="";
				body_browse.document.getElementById("euro_up").style.display="none";
			}
		}
		//body_browse.document.getElementById("euro_close").style.display="none";	
	}
	//alert(recordHash[top.head_gtype+"_HOT_RB"]);
	//alert(recordHash[top.head_gtype+"_HOT_FT"]);
	//alert(recordHash[top.head_gtype+"_HOT_FU"]);
	//parent.mem_order.showHOT(recordHash[top.head_gtype+"_HOT_FT"],recordHash[top.head_gtype+"_HOT_FU"]);
	//parent.mem_order.showHOT(recordHash["FT_HOT_FT"],recordHash["FT_HOT_FU"]);
	/*
	var today_hot=0;
	var early_hot=0;
	for( var i=0;i<gtypeHOT.length;i++){
		try{
		parent.mem_order.document.getElementById(gtypeHOT[i]+"_FT").innerHTML=eval("top.str_"+gtypeHOT[i]) + "("+recordHash[gtypeHOT[i]+"_HOT_FT"]+")";
		parent.mem_order.document.getElementById(gtypeHOT[i]+"_FU").innerHTML=eval("top.str_"+gtypeHOT[i]) + "("+recordHash[gtypeHOT[i]+"_HOT_FU"]+")";
		}catch(E){}
			
		today_hot +=recordHash[gtypeHOT[i]+"_HOT_FT"];
		early_hot +=recordHash[gtypeHOT[i]+"_HOT_FU"];
	}	
	
		parent.mem_order.showHOT(today_hot,early_hot);
	*/	
	try{
		parent.mem_order.getCountHOT(countHOT);
	}catch(e){}
		
 }		
 	
}
 
//function getCountHOT(){
//	return recordHash[top.head_gtype+"_HOT_FT"];
//}
function keep_show_more(gid,GameFT,gamount){
	if(gid!=''){
		show_more_gid = '';
		for (var j=0;j < gamount;j++){
			if(gid == GameFT[j].gid  && GameFT[j].more != 0){
				//body_browse.showdata.location.reload();
				show_more_gid = gid;
				return;
			}
		}
	}
	body_browse.document.getElementById('more_window').style.display='none';
}
<? break;
	case "rt":
	
?>
var ObjDataFT=new Array();
var oldObjDataFT=new Array();
//var GameHead=new Array("gid","datetime","league","gnum_h","gnum_c","team_h","team_c","strong","ior_H1C0","ior_H2C0","ior_H2C1","ior_H3C0","ior_H3C1","ior_H3C2","ior_H4C0","ior_H4C1","ior_H4C2","ior_H4C3","ior_H0C0","ior_H1C1","ior_H2C2","ior_H3C3","ior_H4C4","ior_OVH","ior_H0C1","ior_H0C2","ior_H1C2","ior_H0C3","ior_H1C3","ior_H2C3","ior_H0C4","ior_H1C4","ior_H2C4","ior_H3C4","ior_OVC");
var keepleg="";
var legnum=0;
var NoshowLeg=new Array();
var myLeg=new Array();
var LeagueAry=new Array();
 
function ShowGameList(){
	reTimeNow = retime;
	
	if(loading == 'Y') return;
	if (parent.gamecount!=gamount){
		oldObjDataFT=new Array();
	}
	if(top.odd_f_type==""||""+top.odd_f_type=="undefined") top.odd_f_type="H";
	keepscroll=body_browse.document.body.scrollTop;
	var conscroll= body_browse.document.getElementById('controlscroll');
 
	dis_ShowLoveI();
 
	//秀盤面
	showtables(GameFT,GameHead,gamount,top.odd_f_type);
 
	body_browse.scroll(0,keepscroll);
 
	//設定右方重新整理位置
	setRefreshPos();
 
	parent.gamecount=gamount;
	//日期下拉霸
 
	if (sel_gtype=="FU"){
		if (""+body_browse.document.getElementById('g_date')!="undefined"){
			body_browse.selgdate("t",g_date);
			body_browse.document.getElementById('g_date').value=g_date;
		}
	}
	if (top.hot_game!=""){
		body_browse.document.getElementById('sel_league').style.display='none';
		show_page();
 	}else{
 			
	if(top.showtype=='hgft'||top.showtype=='hgfu'){
		obj_sel = body_browse.document.getElementById('sel_league');
		obj_sel.style.display='none';
		try{
			var obj_date='';
			obj_date=body_browse.document.getElementById("g_date").value;
			body_browse.selgdate("",obj_date);
		}catch(E){}
	}else{
		show_page();
	}
	
 }	
	conscroll.style.display="none";
	coun_Leagues();
	body_browse.showPicLove();
	loadingOK();
	
	parent.mem_order.getCountHOT(gameCount);
	showHOT(gameCount);
}
var hotgdateArr =new Array();
function hot_gdate(gdate){
	if((""+hotgdateArr).indexOf(gdate)==-1){
		hotgdateArr.push(gdate);
	}
}
function coun_Leagues(){
	var coun=0;
	var str_tmp ="|"+eval('parent.'+sel_gtype+'_lname_ary_RE');
	if(str_tmp=='|ALL'){
		body_browse.document.getElementById("str_num").innerHTML =top.alldata;
	}else{
		var larray=str_tmp.split('|');
		for(var i =0;i<larray.length;i++){
			if(larray[i]!=""){coun++}
		}
		coun =LeagueAry.length;
		body_browse.document.getElementById("str_num").innerHTML =coun;
	}
	
	
}
//表格函數
function showtables(GameData,Game_Head,data_amount,odd_f_type){
	ObjDataFT=new Array();
	myLeg=new Array();
	for (var j=0;j < data_amount;j++){
		if (GameData[j]!=null){
			ObjDataFT[j]=parseArray(Game_Head,GameData[j]);
		}
	}
	var trdata;
	var showtableData;
	if(body_browse.document.all){
	     	showtableData=body_browse.document.getElementById('showtableData').innerText ;
	     	trdata=body_browse.document.getElementById('DataTR').innerText;
	     	notrdata=body_browse.document.getElementById('NoDataTR').innerText;
	} else{
	     	showtableData=body_browse.document.getElementById('showtableData').textContent ;
	     	trdata=body_browse.document.getElementById('DataTR').textContent;
	     	notrdata=body_browse.document.getElementById('NoDataTR').textContent;
	}
	var showtable=body_browse.document.getElementById('showtable');
	var showlayers="";
	keepleg="";
	legnum=0;
	LeagueAry =new Array();
	if(ObjDataFT.length > 0){
	  	for ( i=0 ;i < ObjDataFT.length;i++){
	  			showlayers+=getLayer(trdata,i,odd_f_type);
	  	}
	  	if(showlayers=="")showlayers=notrdata;
		showtableData=showtableData.replace("*showDataTR*",showlayers);
	}else{
		showtableData=showtableData.replace("*showDataTR*",notrdata);
	}
	showtable.innerHTML=showtableData;
}
 
 
//表格內容
function getLayer(onelayer,gamerec,odd_f_type){
	var open_hot = false;
	if(MM_IdentificationDisplay(ObjDataFT[gamerec].datetime,ObjDataFT[gamerec].gnum_h)) return "";
	if (top.hot_game==""){
		if(("|"+eval('parent.'+sel_gtype+'_lname_ary_RE')).indexOf(("|"+ObjDataFT[gamerec].league+"|"),0)==-1&&eval('parent.'+sel_gtype+'_lname_ary_RE')!='ALL') return "";
		if((""+LeagueAry).indexOf(ObjDataFT[gamerec].league)== -1)LeagueAry.push(ObjDataFT[gamerec].league);
	}
	var tmp_date = ObjDataFT[gamerec].datetime.split("<br>")[0];
	onelayer=onelayer.replace(/\*ID_STR\*/g,tmp_date+ObjDataFT[gamerec].gnum_h);
	onelayer=onelayer.replace(/\*TR_EVENT\*/g,"onMouseOver='mouseEnter_pointer(this.id);' onMouseOut='mouseOut_pointer(this.id);'");
 
	if (""+myLeg[ObjDataFT[gamerec].league]=="undefined"){
			myLeg[ObjDataFT[gamerec].league]=ObjDataFT[gamerec].league;
			myLeg[ObjDataFT[gamerec].league]=new Array();
			myLeg[ObjDataFT[gamerec].league][0]=tmp_date+ObjDataFT[gamerec].gnum_h;
	}else{
			myLeg[ObjDataFT[gamerec].league][myLeg[ObjDataFT[gamerec].league].length]=tmp_date+ObjDataFT[gamerec].gnum_h;
	}
 
	//--------------判斷聯盟名稱列顯示或隱藏----------------
	if (ObjDataFT[gamerec].league==keepleg){
			onelayer=onelayer.replace("*ST*"," style='display: none;'");
	}else{
			onelayer=onelayer.replace("*ST*"," style='display: ;'");
	}
	//---------------------------------------------------------------------
	//--------------判斷聯盟底下的賽事顯示或隱藏----------------
	if (NoshowLeg[ObjDataFT[gamerec].league]==-1){
		onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: none;'");
		onelayer=onelayer.replace("*LegMark*","<span id='LegClose'></span>"); //聯盟的小圖
	}else{
		onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: ;'");
		onelayer=onelayer.replace("*LegMark*","<span id='LegOpen'></span>");  //聯盟的小圖
	}
	//---------------------------------------------------------------------
 
	//滾球字眼
	ObjDataFT[gamerec].datetime=ObjDataFT[gamerec].datetime.replace("Running Ball","");
	keepleg=ObjDataFT[gamerec].league;
	onelayer=onelayer.replace(/\*LEG\*/gi,ObjDataFT[gamerec].league);
	var tmp_date=ObjDataFT[gamerec].datetime.split("<br>");
	if (sel_gtype=="FU"){
		tmp_date_str=tmp_date[0]+"<br>"+change_time(tmp_date[1]);
	}else{
		tmp_date_str=change_time(tmp_date[1]);
	}
	if (tmp_date.length==3){
		tmp_date_str+="<br>"+tmp_date[2];
	}	
	onelayer=onelayer.replace("*DATETIME*",tmp_date_str);
	onelayer=onelayer.replace("*TEAM_H*",ObjDataFT[gamerec].team_h.replace("[Mid]","<font color=\"#005aff\">[N]</font>").replace("[中]","<font color=\"#005aff\">[中]</font>"));
	onelayer=onelayer.replace("*TEAM_C*",ObjDataFT[gamerec].team_c);
	//全場
	//單雙
	onelayer=onelayer.replace("*RATIO_ODD*",parseUrl(uid,odd_f_type,"RODD",ObjDataFT[gamerec],gamerec,"RT"));
	onelayer=onelayer.replace("*RATIO_EVEN*",parseUrl(uid,odd_f_type,"REVEN",ObjDataFT[gamerec],gamerec,"RT"));
	//入球數
	onelayer=onelayer.replace("*RATIO_T01*",parseUrl(uid,odd_f_type,"RT01",ObjDataFT[gamerec],gamerec,"RT"));
	onelayer=onelayer.replace("*RATIO_T23*",parseUrl(uid,odd_f_type,"RT23",ObjDataFT[gamerec],gamerec,"RT"));
	onelayer=onelayer.replace("*RATIO_T46*",parseUrl(uid,odd_f_type,"RT46",ObjDataFT[gamerec],gamerec,"RT"));
	onelayer=onelayer.replace("*RATIO_OVER*",parseUrl(uid,odd_f_type,"ROVER",ObjDataFT[gamerec],gamerec,"RT"));
 
	return onelayer;
}
 
 
//取得下注的url
function parseUrl(uid,odd_f_type,rtype,GameData,gamerec,wtype){
	var urlArray=new Array();
	urlArray['RT']=new Array("../FT_order/FT_order_rt.php");
 
	var paramRtype = new Array();
	//paramRtype['RODD'] = "RODD";
	//paramRtype['REVEN'] = "REVEN";
	paramRtype['RT01'] = "R0~1";
	paramRtype['RT23'] = "R2~3";
	paramRtype['RT46'] = "R4~6";
	paramRtype['ROVER'] = "ROVER";
	
	var param=getParam(uid,odd_f_type,paramRtype[rtype],wtype,GameData);
	var order=urlArray[wtype][0];
	var tmp_rtype="ior_"+rtype;
	var ioratio_str="GameData."+tmp_rtype;
	
	var team="";
	if (rtype=="ROVER"){
		team="7up";
	}else if (rtype=="RODD"){
		team=top.strOdd;
	}else if (rtype=="REVEN"){
		team=top.strEven;
	}else{	
		team=paramRtype[rtype];
	}
	
	
	
	var ioratio=eval(ioratio_str);
 	//var ret="<a href='"+order+"?"+param+"' target='mem_order' title='"+team+"'><font "+check_ioratio(gamerec,tmp_rtype,GameData)+">"+ioratio+"</font></a>";
	//alert(parent.name)
	var ret="<a href='javascript://' onclick=\"parent.parent.mem_order.betOrder('FT','"+wtype+"','"+param+"');\" title='"+team+"'><font "+check_ioratio(gamerec,tmp_rtype,GameData)+">"+ioratio+"</font></a>";
 
	return ret;
 
}
 
//--------------------------public function --------------------------------
 
//取得下注參數
function getParam(uid,odd_f_type,rtype,wtype,GameData){
	var paramArray=new Array();
	paramArray['RT']=new Array("gid","uid","odd_f_type","rtype","langx");
 
	var param="";
	var gid=GameData.gid;
 
	for (var i=0;i<paramArray[wtype].length;i++){
		if (i>0)  param+="&";
		param+=paramArray[wtype][i]+"="+eval(paramArray[wtype][i]);
	}
	return param;
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8 "><script>
var isHot_game = false;//是否為世足賽
//--------------------------------public function ----------------------------
 
function setRefreshPos(){
		var refresh_right= body_browse.document.getElementById('refresh_right');
		refresh_right.style.left= body_browse.document.getElementById('myTable').clientWidth*1+20;
		//refresh_right.style.top= 39;
	}
 
function parseArray(gameHead,gameData){
	var gameObj=new Object();
	for (var i=0;i<gameHead.length;i++){
		if (gameHead[i]!=""){	
			eval("gameObj."+gameHead[i]+"='"+gameData[i]+"'");
		}
	}
	return gameObj;
}
 
 
function check_ioratio(rec,rtype,GameData){
//alert(flash_ior_set);
	//return true;
	//alert(GameFT.length+"----"+keepGameData.length)
 
	if (flash_ior_set =='Y'){
		//alert(oldObjDataFT[rec]);
		if (""+oldObjDataFT[rec]=="undefined" || oldObjDataFT[rec].gid != GameData.gid){
			var gameObj=new Object();
			gameObj.gid=GameData.gid;
			oldObjDataFT[rec]=gameObj;
		}
		
		var new_ioratio=eval("GameData."+rtype);
		var old_ioratio=eval("oldObjDataFT[rec]."+rtype);
		
		
		if (""+old_ioratio=="undefined"){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			old_ioratio=eval("oldObjDataFT[rec]."+rtype);
		}
		
		//alert("old_ioratio==>"+old_ioratio+",new_ioratio==>"+new_ioratio);
		if (""+new_ioratio=="undefined" || new_ioratio==""){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return;
		}
		
		/*
		if (parseFloat(old_ioratio)>parseFloat(new_ioratio) ){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='border: 1px solid #FF0000;' ";
		}
		if (parseFloat(old_ioratio)<parseFloat(new_ioratio) ){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='border: 1px solid #00FF00;' ";
		}
		*/
		
		if (old_ioratio!=new_ioratio && old_ioratio !="" && new_ioratio!="") {
	    	eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='background-color : yellow' ";
		}
		
		return true;
	}
 
}
//--------------判斷聯盟顯示或隱藏----------------
function showLeg(leg){
	for (var i=0;i<myLeg[leg].length;i++){
	if ( body_browse.document.getElementById("TR_"+myLeg[leg][i]).style.display!="none"){
				showLegIcon(leg,"LegClose",myLeg[leg][i],"none");
				
		}else{
			showLegIcon(leg,"LegOpen",myLeg[leg][i],"");
		}
	}
	if ((""+NoshowLeg[leg])=="undefined"){
		NoshowLeg[leg]=-1;
	}else{
		NoshowLeg[leg]=NoshowLeg[leg]*-1;
	}
 
}
function showLegIcon(leg,state,gnumH,display){
	var  ary=body_browse.document.getElementsByName(leg);
			
	for (var j=0;j<ary.length;j++){
		ary[j].innerHTML="<span id='"+state+"'></span>";
	}
	try{
		body_browse.document.getElementById("TR3_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR2_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR1_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR_"+gnumH).style.display=display;
	}catch(E){}
}
//----------------------
 
//分頁
function show_page(){
	//alert(rtype)
	pg_str='';
	obj_pg = body_browse.document.getElementById('pg_txt');
//	alert(t_page);
	if (t_page==0){
		t_page=1;
		//obj_pg.innerHTML = "";
		//return;
	}
	var tmp_lid="";
	if (rtype=="re"){
		tmp_lid=eval("parent."+sel_gtype+"_lid_ary_RE");
	}else{
		tmp_lid=eval("parent."+sel_gtype+"_lid_ary");
	}
	//alert(tmp_lid+"--"+top.swShowLoveI+"--"+t_page)
	if(tmp_lid=='ALL'&&!top.swShowLoveI){
		var disabled="";
		if (t_page==1){
			disabled="disabled";
			}
		var pghtml=(pg*1+1)+" / " +t_page+" "+top.page+"&nbsp;&nbsp; <select  onchange='chg_pg(this.options[this.selectedIndex].value)' "+disabled+">";
		for(var i=0;i<t_page;i++){
			if (pg==i){
		 		pghtml+="<option value='"+i+"' selected>"+(i+1)+"</option>";
		 	}else{
		  		pghtml+="<option value='"+i+"' >"+(i+1)+"</option>";
		  	}
		}
		pghtml+="</select>";
		obj_pg.innerHTML = pghtml;
	}else{
		obj_pg.innerHTML = "";
	}
}
 
//將時間 轉回 24小時//04:00p
function  change_time(get_time){
	
	if (get_time.indexOf("font") > 0 ) return get_time;
	if (get_time.indexOf("p")>0 || get_time.indexOf("a")>0){
		gtime=get_time.split(":");
		if (gtime[1].indexOf("p")>0){
			
			if (gtime[0]!="12"){
				gtime[0]=gtime[0]*1+12;
			}	
		}
		gtime[1]=gtime[1].replace("a","").replace("p","");
		
	}else{
		return get_time;
	}
	return gtime[0]+":"+gtime[1];
	
}
 
//隱藏我的最愛選擇聯賽
function dis_ShowLoveI(){
 
if(top.swShowLoveI){
  body_browse.document.getElementById("sel_league").style.display="none";
 }else{
  body_browse.document.getElementById("sel_league").style.display="";
 }
 
}
 
 
function changeTitleStr(s,at){
	if (s.charAt(at)=="H"){
		return "H";
	}else if(s.charAt(at)=="C"){
		return "A";
	}else if(s.charAt(at)=="N"){
		return "D";
	}
	return "";
}
 
 
function loadingOK(){
	//alert("loadingOK")
	try{
		body_browse.document.getElementById("refresh_btn").className="refresh_btn";
	}catch(E){}
	try{
	body_browse.document.getElementById("refresh_right").className="refresh_M_btn";
	}catch(E){}
	try{	
	body_browse.document.getElementById("refresh_down").className="refresh_M_btn";
	}catch(E){}
}
 
 
var gameCount="";
var recordHash=new Array();
function showHOT(countHOT){
	
if( (""+countHOT=="") || (""+countHOT=="undefined") ){
	
	 body_browse.document.getElementById("euro_btn").style.display="none";
	 body_browse.document.getElementById("euro_up").style.display="none";
			
}else{	
		
	if(""+top.hot_game=="undefined"){
		top.hot_game="";
	}	
	var gtypeHOT =new Array("FT","BK","TN","VB","OP");
	var countgames=countHOT.split(",");
	recordHash=new Array();
	var head_str="";
	
	if(rtype == "re"){
		head_str="RB";
	}else{
		head_str=top.head_FU;
	}
	//alert(head_str);
	
	for( var i=0;i<countgames.length;i++){
		var detailgame=countgames[i].split("|");
		recordHash[detailgame[0]+"_"+detailgame[1]]=detailgame[2]*1;
	}
	if(recordHash[top.head_gtype+"_HOT_"+head_str]*1==0){
		body_browse.document.getElementById("euro_btn").style.display="none";
		body_browse.document.getElementById("euro_up").style.display="none";
		//body_browse.document.getElementById("euro_close").style.display="";
		if(top.hot_game!=""){
			top.hot_game="";
			body_browse.reload_var();
		}
	}else{
		if(isHot_game){
			if(top.hot_game!=""){
				body_browse.document.getElementById("euro_btn").style.display="none";
				body_browse.document.getElementById("euro_up").style.display="";
			}else{
				body_browse.document.getElementById("euro_btn").style.display="";
				body_browse.document.getElementById("euro_up").style.display="none";
			}
		}
		//body_browse.document.getElementById("euro_close").style.display="none";	
	}
	//alert(recordHash[top.head_gtype+"_HOT_RB"]);
	//alert(recordHash[top.head_gtype+"_HOT_FT"]);
	//alert(recordHash[top.head_gtype+"_HOT_FU"]);
	//parent.mem_order.showHOT(recordHash[top.head_gtype+"_HOT_FT"],recordHash[top.head_gtype+"_HOT_FU"]);
	//parent.mem_order.showHOT(recordHash["FT_HOT_FT"],recordHash["FT_HOT_FU"]);
	/*
	var today_hot=0;
	var early_hot=0;
	for( var i=0;i<gtypeHOT.length;i++){
		try{
		parent.mem_order.document.getElementById(gtypeHOT[i]+"_FT").innerHTML=eval("top.str_"+gtypeHOT[i]) + "("+recordHash[gtypeHOT[i]+"_HOT_FT"]+")";
		parent.mem_order.document.getElementById(gtypeHOT[i]+"_FU").innerHTML=eval("top.str_"+gtypeHOT[i]) + "("+recordHash[gtypeHOT[i]+"_HOT_FU"]+")";
		}catch(E){}
			
		today_hot +=recordHash[gtypeHOT[i]+"_HOT_FT"];
		early_hot +=recordHash[gtypeHOT[i]+"_HOT_FU"];
	}	
	
		parent.mem_order.showHOT(today_hot,early_hot);
	*/	
	try{
		parent.mem_order.getCountHOT(countHOT);
	}catch(e){}
		
 }		
 	
}
 
//function getCountHOT(){
//	return recordHash[top.head_gtype+"_HOT_FT"];
//}
function keep_show_more(gid,GameFT,gamount){
	if(gid!=''){
		show_more_gid = '';
		for (var j=0;j < gamount;j++){
			if(gid == GameFT[j].gid  && GameFT[j].more != 0){
				//body_browse.showdata.location.reload();
				show_more_gid = gid;
				return;
			}
		}
	}
	body_browse.document.getElementById('more_window').style.display='none';
}
<?
break;
case "rf":
?>
var ObjDataFT=new Array();
var oldObjDataFT=new Array();
//var GameHead=new Array("gid","datetime","league","gnum_h","gnum_c","team_h","team_c","strong","ior_H1C0","ior_H2C0","ior_H2C1","ior_H3C0","ior_H3C1","ior_H3C2","ior_H4C0","ior_H4C1","ior_H4C2","ior_H4C3","ior_H0C0","ior_H1C1","ior_H2C2","ior_H3C3","ior_H4C4","ior_OVH","ior_H0C1","ior_H0C2","ior_H1C2","ior_H0C3","ior_H1C3","ior_H2C3","ior_H0C4","ior_H1C4","ior_H2C4","ior_H3C4","ior_OVC");
var keepleg="";
var legnum=0;
var NoshowLeg=new Array();
var myLeg=new Array();
var LeagueAry=new Array();
 
function ShowGameList(){
	reTimeNow = retime;
	
	if(loading == 'Y') return;
	if (parent.gamecount!=gamount){
		oldObjDataFT=new Array();
	}
	if(top.odd_f_type==""||""+top.odd_f_type=="undefined") top.odd_f_type="H";
	keepscroll=body_browse.document.body.scrollTop;
	var conscroll= body_browse.document.getElementById('controlscroll');
 
	dis_ShowLoveI();
 
	//秀盤面
	showtables(GameFT,GameHead,gamount,top.odd_f_type);
 
	body_browse.scroll(0,keepscroll);
 
	//設定右方重新整理位置
	setRefreshPos();
 
	parent.gamecount=gamount;
	//日期下拉霸
 
	if (sel_gtype=="FU"){
		if (""+body_browse.document.getElementById('g_date')!="undefined"){
			body_browse.selgdate("f",g_date);
			body_browse.document.getElementById('g_date').value=g_date;
		}
	}
	if (top.hot_game!=""){
		body_browse.document.getElementById('sel_league').style.display='none';
		show_page();
 	}else{
 			
	if(top.showtype=='hgft'||top.showtype=='hgfu'){
		obj_sel = body_browse.document.getElementById('sel_league');
		obj_sel.style.display='none';
		try{
			var obj_date='';
			obj_date=body_browse.document.getElementById("g_date").value;
			body_browse.selgdate("",obj_date);
		}catch(E){}
	}else{
		show_page();
	}
	
 }	
	conscroll.style.display="none";
	coun_Leagues();
	body_browse.showPicLove();
	loadingOK();
	
	parent.mem_order.getCountHOT(gameCount);
	showHOT(gameCount);
}
var hotgdateArr =new Array();
function hot_gdate(gdate){
	if((""+hotgdateArr).indexOf(gdate)==-1){
		hotgdateArr.push(gdate);
	}
}
function coun_Leagues(){
	var coun=0;
	var str_tmp ="|"+eval('parent.'+sel_gtype+'_lname_ary_RE');
	if(str_tmp=='|ALL'){
		body_browse.document.getElementById("str_num").innerHTML =top.alldata;
	}else{
		var larray=str_tmp.split('|');
		for(var i =0;i<larray.length;i++){
			if(larray[i]!=""){coun++}
		}
		coun =LeagueAry.length;
		body_browse.document.getElementById("str_num").innerHTML =coun;
	}
	
	
}
 
//表格函數
function showtables(GameData,Game_Head,data_amount,odd_f_type){
	ObjDataFT=new Array();
	myLeg=new Array();
	for (var j=0;j < data_amount;j++){
		if (GameData[j]!=null){
			ObjDataFT[j]=parseArray(Game_Head,GameData[j]);
		}
	}
	var trdata;
	var showtableData;
	if(body_browse.document.all){
	     	showtableData=body_browse.document.getElementById('showtableData').innerText ;
	     	trdata=body_browse.document.getElementById('DataTR').innerText;
     		notrdata=body_browse.document.getElementById('NoDataTR').innerText;
	} else{
	     	showtableData=body_browse.document.getElementById('showtableData').textContent ;
	     	trdata=body_browse.document.getElementById('DataTR').textContent;
     		notrdata=body_browse.document.getElementById('NoDataTR').textContent;
	}
	var showtable=body_browse.document.getElementById('showtable');
	var showlayers="";
	keepleg="";
	legnum=0;
	LeagueAry =new Array();
	if(ObjDataFT.length > 0){
	  	for ( i=0 ;i < ObjDataFT.length;i++){
	  			showlayers+=getLayer(trdata,i,odd_f_type);
	  	}
	  	if(showlayers=="")showlayers=notrdata;
		showtableData=showtableData.replace("*showDataTR*",showlayers);
	}else{
		showtableData=showtableData.replace("*showDataTR*",notrdata);
	}
	showtable.innerHTML=showtableData;
}
 
 
//表格內容
function getLayer(onelayer,gamerec,odd_f_type){
	var open_hot = false;
	if(MM_IdentificationDisplay(ObjDataFT[gamerec].datetime,ObjDataFT[gamerec].gnum_h)) return "";
	if (top.hot_game==""){
		if(("|"+eval('parent.'+sel_gtype+'_lname_ary_RE')).indexOf(("|"+ObjDataFT[gamerec].league+"|"),0)==-1&&eval('parent.'+sel_gtype+'_lname_ary_RE')!='ALL') return "";
		if((""+LeagueAry).indexOf(ObjDataFT[gamerec].league)== -1)LeagueAry.push(ObjDataFT[gamerec].league);
	}
	var tmp_date = ObjDataFT[gamerec].datetime.split("<br>")[0];
	onelayer=onelayer.replace(/\*ID_STR\*/g,tmp_date+ObjDataFT[gamerec].gnum_h);
	onelayer=onelayer.replace(/\*TR_EVENT\*/g,"onMouseOver='mouseEnter_pointer(this.id);' onMouseOut='mouseOut_pointer(this.id);'");
 
	if (""+myLeg[ObjDataFT[gamerec].league]=="undefined"){
			myLeg[ObjDataFT[gamerec].league]=ObjDataFT[gamerec].league;
			myLeg[ObjDataFT[gamerec].league]=new Array();
			myLeg[ObjDataFT[gamerec].league][0]=tmp_date+ObjDataFT[gamerec].gnum_h;
	}else{
			myLeg[ObjDataFT[gamerec].league][myLeg[ObjDataFT[gamerec].league].length]=tmp_date+ObjDataFT[gamerec].gnum_h;
	}
 
	//--------------判斷聯盟名稱列顯示或隱藏----------------
	if (ObjDataFT[gamerec].league==keepleg){
			onelayer=onelayer.replace("*ST*"," style='display: none;'");
	}else{
			onelayer=onelayer.replace("*ST*"," style='display: ;'");
	}
	//---------------------------------------------------------------------
	//--------------判斷聯盟底下的賽事顯示或隱藏----------------
	if (NoshowLeg[ObjDataFT[gamerec].league]==-1){
		onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: none;'");
		onelayer=onelayer.replace("*LegMark*","<span id='LegClose'></span>"); //聯盟的小圖
	}else{
		onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: ;'");
		onelayer=onelayer.replace("*LegMark*","<span id='LegOpen'></span>");  //聯盟的小圖
	}
	//---------------------------------------------------------------------
 
 
	//滾球字眼
	ObjDataFT[gamerec].datetime=ObjDataFT[gamerec].datetime.replace("Running Ball","");
	keepleg=ObjDataFT[gamerec].league;
	onelayer=onelayer.replace(/\*LEG\*/gi,ObjDataFT[gamerec].league);
 
	var tmp_date=ObjDataFT[gamerec].datetime.split("<br>");
	if (sel_gtype=="FU"){
		tmp_date_str=tmp_date[0]+"<br>"+change_time(tmp_date[1]);
	}else{
		tmp_date_str=change_time(tmp_date[1]);
	}
	if (tmp_date.length==3){
		tmp_date_str+="<br>"+tmp_date[2];
	}	
	onelayer=onelayer.replace("*DATETIME*",tmp_date_str);
	onelayer=onelayer.replace("*TEAM_H*",ObjDataFT[gamerec].team_h.replace("[Mid]","<font color=\"#005aff\">[N]</font>").replace("[中]","<font color=\"#005aff\">[中]</font>"));
	onelayer=onelayer.replace("*TEAM_C*",ObjDataFT[gamerec].team_c);
	//全場
	//半全場
	onelayer=onelayer.replace("*RATIO_FHH*",parseUrl(uid,odd_f_type,"RFHH",ObjDataFT[gamerec],gamerec,"RF"));
	onelayer=onelayer.replace("*RATIO_FHN*",parseUrl(uid,odd_f_type,"RFHN",ObjDataFT[gamerec],gamerec,"RF"));
	onelayer=onelayer.replace("*RATIO_FHC*",parseUrl(uid,odd_f_type,"RFHC",ObjDataFT[gamerec],gamerec,"RF"));
	onelayer=onelayer.replace("*RATIO_FNH*",parseUrl(uid,odd_f_type,"RFNH",ObjDataFT[gamerec],gamerec,"RF"));
	onelayer=onelayer.replace("*RATIO_FNN*",parseUrl(uid,odd_f_type,"RFNN",ObjDataFT[gamerec],gamerec,"RF"));
	onelayer=onelayer.replace("*RATIO_FNC*",parseUrl(uid,odd_f_type,"RFNC",ObjDataFT[gamerec],gamerec,"RF"));
	onelayer=onelayer.replace("*RATIO_FCH*",parseUrl(uid,odd_f_type,"RFCH",ObjDataFT[gamerec],gamerec,"RF"));
	onelayer=onelayer.replace("*RATIO_FCN*",parseUrl(uid,odd_f_type,"RFCN",ObjDataFT[gamerec],gamerec,"RF"));
	onelayer=onelayer.replace("*RATIO_FCC*",parseUrl(uid,odd_f_type,"RFCC",ObjDataFT[gamerec],gamerec,"RF"));
 
	return onelayer;
}
 
//取得下注的url
function parseUrl(uid,odd_f_type,rtype,GameData,gamerec,wtype){
	var urlArray=new Array();
	urlArray['RF']=new Array("../FT_order/FT_order_rf.php");
 
	var param=getParam(uid,odd_f_type,rtype,wtype,GameData);
	var order=urlArray[wtype][0];
	var tmp_rtype="ior_"+rtype;
	var ioratio_str="GameData."+tmp_rtype;
 
	var team="";
	team=changeTitleStr(rtype,1)+"/"+changeTitleStr(rtype,2);
	
	
 
	var ioratio=eval(ioratio_str);
 	//var ret="<a href='"+order+"?"+param+"' target='mem_order' title='"+team+"'><font "+check_ioratio(gamerec,tmp_rtype,GameData)+">"+ioratio+"</font></a>";
	//alert(parent.name)
	var ret="<a href='javascript://' onclick=\"parent.parent.mem_order.betOrder('FT','"+wtype+"','"+param+"');\" title='"+team+"'><font "+check_ioratio(gamerec,tmp_rtype,GameData)+">"+ioratio+"</font></a>";
 
	return ret;
 
}
 
 
//--------------------------public function --------------------------------
 
//取得下注參數
function getParam(uid,odd_f_type,rtype,wtype,GameData){
	var paramArray=new Array();
	paramArray['RF']=new Array("gid","uid","odd_f_type","rtype","langx");
 
	var param="";
	var gid=GameData.gid;
 
	for (var i=0;i<paramArray[wtype].length;i++){
		if (i>0)  param+="&";
		param+=paramArray[wtype][i]+"="+eval(paramArray[wtype][i]);
	}
	return param;
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8 "><script>
var isHot_game = false;//是否為世足賽
//--------------------------------public function ----------------------------
 
function setRefreshPos(){
		var refresh_right= body_browse.document.getElementById('refresh_right');
		refresh_right.style.left= body_browse.document.getElementById('myTable').clientWidth*1+20;
		//refresh_right.style.top= 39;
	}
 
function parseArray(gameHead,gameData){
	var gameObj=new Object();
	for (var i=0;i<gameHead.length;i++){
		if (gameHead[i]!=""){	
			eval("gameObj."+gameHead[i]+"='"+gameData[i]+"'");
		}
	}
	return gameObj;
}
 
 
function check_ioratio(rec,rtype,GameData){
//alert(flash_ior_set);
	//return true;
	//alert(GameFT.length+"----"+keepGameData.length)
 
	if (flash_ior_set =='Y'){
		//alert(oldObjDataFT[rec]);
		if (""+oldObjDataFT[rec]=="undefined" || oldObjDataFT[rec].gid != GameData.gid){
			var gameObj=new Object();
			gameObj.gid=GameData.gid;
			oldObjDataFT[rec]=gameObj;
		}
		
		var new_ioratio=eval("GameData."+rtype);
		var old_ioratio=eval("oldObjDataFT[rec]."+rtype);
		
		
		if (""+old_ioratio=="undefined"){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			old_ioratio=eval("oldObjDataFT[rec]."+rtype);
		}
		
		//alert("old_ioratio==>"+old_ioratio+",new_ioratio==>"+new_ioratio);
		if (""+new_ioratio=="undefined" || new_ioratio==""){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return;
		}
		
		/*
		if (parseFloat(old_ioratio)>parseFloat(new_ioratio) ){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='border: 1px solid #FF0000;' ";
		}
		if (parseFloat(old_ioratio)<parseFloat(new_ioratio) ){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='border: 1px solid #00FF00;' ";
		}
		*/
		
		if (old_ioratio!=new_ioratio && old_ioratio !="" && new_ioratio!="") {
	    	eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='background-color : yellow' ";
		}
		
		return true;
	}
 
}
//--------------判斷聯盟顯示或隱藏----------------
function showLeg(leg){
	for (var i=0;i<myLeg[leg].length;i++){
	if ( body_browse.document.getElementById("TR_"+myLeg[leg][i]).style.display!="none"){
				showLegIcon(leg,"LegClose",myLeg[leg][i],"none");
				
		}else{
			showLegIcon(leg,"LegOpen",myLeg[leg][i],"");
		}
	}
	if ((""+NoshowLeg[leg])=="undefined"){
		NoshowLeg[leg]=-1;
	}else{
		NoshowLeg[leg]=NoshowLeg[leg]*-1;
	}
 
}
function showLegIcon(leg,state,gnumH,display){
	var  ary=body_browse.document.getElementsByName(leg);
			
	for (var j=0;j<ary.length;j++){
		ary[j].innerHTML="<span id='"+state+"'></span>";
	}
	try{
		body_browse.document.getElementById("TR3_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR2_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR1_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR_"+gnumH).style.display=display;
	}catch(E){}
}
//----------------------
 
//分頁
function show_page(){
	//alert(rtype)
	pg_str='';
	obj_pg = body_browse.document.getElementById('pg_txt');
//	alert(t_page);
	if (t_page==0){
		t_page=1;
		//obj_pg.innerHTML = "";
		//return;
	}
	var tmp_lid="";
	if (rtype=="re"){
		tmp_lid=eval("parent."+sel_gtype+"_lid_ary_RE");
	}else{
		tmp_lid=eval("parent."+sel_gtype+"_lid_ary");
	}
	//alert(tmp_lid+"--"+top.swShowLoveI+"--"+t_page)
	if(tmp_lid=='ALL'&&!top.swShowLoveI){
		var disabled="";
		if (t_page==1){
			disabled="disabled";
			}
		var pghtml=(pg*1+1)+" / " +t_page+" "+top.page+"&nbsp;&nbsp; <select  onchange='chg_pg(this.options[this.selectedIndex].value)' "+disabled+">";
		for(var i=0;i<t_page;i++){
			if (pg==i){
		 		pghtml+="<option value='"+i+"' selected>"+(i+1)+"</option>";
		 	}else{
		  		pghtml+="<option value='"+i+"' >"+(i+1)+"</option>";
		  	}
		}
		pghtml+="</select>";
		obj_pg.innerHTML = pghtml;
	}else{
		obj_pg.innerHTML = "";
	}
}
 
//將時間 轉回 24小時//04:00p
function  change_time(get_time){
	
	if (get_time.indexOf("font") > 0 ) return get_time;
	if (get_time.indexOf("p")>0 || get_time.indexOf("a")>0){
		gtime=get_time.split(":");
		if (gtime[1].indexOf("p")>0){
			
			if (gtime[0]!="12"){
				gtime[0]=gtime[0]*1+12;
			}	
		}
		gtime[1]=gtime[1].replace("a","").replace("p","");
		
	}else{
		return get_time;
	}
	return gtime[0]+":"+gtime[1];
	
}
 
//隱藏我的最愛選擇聯賽
function dis_ShowLoveI(){
 
if(top.swShowLoveI){
  body_browse.document.getElementById("sel_league").style.display="none";
 }else{
  body_browse.document.getElementById("sel_league").style.display="";
 }
 
}
 
 
function changeTitleStr(s,at){
	if (s.charAt(at)=="H"){
		return "H";
	}else if(s.charAt(at)=="C"){
		return "A";
	}else if(s.charAt(at)=="N"){
		return "D";
	}
	return "";
}
 
 
function loadingOK(){
	//alert("loadingOK")
	try{
		body_browse.document.getElementById("refresh_btn").className="refresh_btn";
	}catch(E){}
	try{
	body_browse.document.getElementById("refresh_right").className="refresh_M_btn";
	}catch(E){}
	try{	
	body_browse.document.getElementById("refresh_down").className="refresh_M_btn";
	}catch(E){}
}
 
 
var gameCount="";
var recordHash=new Array();
function showHOT(countHOT){
	
if( (""+countHOT=="") || (""+countHOT=="undefined") ){
	
	 body_browse.document.getElementById("euro_btn").style.display="none";
	 body_browse.document.getElementById("euro_up").style.display="none";
			
}else{	
		
	if(""+top.hot_game=="undefined"){
		top.hot_game="";
	}	
	var gtypeHOT =new Array("FT","BK","TN","VB","OP");
	var countgames=countHOT.split(",");
	recordHash=new Array();
	var head_str="";
	
	if(rtype == "re"){
		head_str="RB";
	}else{
		head_str=top.head_FU;
	}
	//alert(head_str);
	
	for( var i=0;i<countgames.length;i++){
		var detailgame=countgames[i].split("|");
		recordHash[detailgame[0]+"_"+detailgame[1]]=detailgame[2]*1;
	}
	if(recordHash[top.head_gtype+"_HOT_"+head_str]*1==0){
		body_browse.document.getElementById("euro_btn").style.display="none";
		body_browse.document.getElementById("euro_up").style.display="none";
		//body_browse.document.getElementById("euro_close").style.display="";
		if(top.hot_game!=""){
			top.hot_game="";
			body_browse.reload_var();
		}
	}else{
		if(isHot_game){
			if(top.hot_game!=""){
				body_browse.document.getElementById("euro_btn").style.display="none";
				body_browse.document.getElementById("euro_up").style.display="";
			}else{
				body_browse.document.getElementById("euro_btn").style.display="";
				body_browse.document.getElementById("euro_up").style.display="none";
			}
		}
		//body_browse.document.getElementById("euro_close").style.display="none";	
	}
	//alert(recordHash[top.head_gtype+"_HOT_RB"]);
	//alert(recordHash[top.head_gtype+"_HOT_FT"]);
	//alert(recordHash[top.head_gtype+"_HOT_FU"]);
	//parent.mem_order.showHOT(recordHash[top.head_gtype+"_HOT_FT"],recordHash[top.head_gtype+"_HOT_FU"]);
	//parent.mem_order.showHOT(recordHash["FT_HOT_FT"],recordHash["FT_HOT_FU"]);
	/*
	var today_hot=0;
	var early_hot=0;
	for( var i=0;i<gtypeHOT.length;i++){
		try{
		parent.mem_order.document.getElementById(gtypeHOT[i]+"_FT").innerHTML=eval("top.str_"+gtypeHOT[i]) + "("+recordHash[gtypeHOT[i]+"_HOT_FT"]+")";
		parent.mem_order.document.getElementById(gtypeHOT[i]+"_FU").innerHTML=eval("top.str_"+gtypeHOT[i]) + "("+recordHash[gtypeHOT[i]+"_HOT_FU"]+")";
		}catch(E){}
			
		today_hot +=recordHash[gtypeHOT[i]+"_HOT_FT"];
		early_hot +=recordHash[gtypeHOT[i]+"_HOT_FU"];
	}	
	
		parent.mem_order.showHOT(today_hot,early_hot);
	*/	
	try{
		parent.mem_order.getCountHOT(countHOT);
	}catch(e){}
		
 }		
 	
}
 
//function getCountHOT(){
//	return recordHash[top.head_gtype+"_HOT_FT"];
//}
function keep_show_more(gid,GameFT,gamount){
	if(gid!=''){
		show_more_gid = '';
		for (var j=0;j < gamount;j++){
			if(gid == GameFT[j].gid  && GameFT[j].more != 0){
				//body_browse.showdata.location.reload();
				show_more_gid = gid;
				return;
			}
		}
	}
	body_browse.document.getElementById('more_window').style.display='none';
}
<?	
break;
}
?>
</script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8 "><script> 
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-43753661-1']);
  _gaq.push(['_trackPageview']);
 
 // (function() {
  //  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
   // ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
   // var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  //})();
</script>

<SCRIPT LANGUAGE="JAVASCRIPT">
<!--
 if(self == top) location='<?=BROWSER_IP?>/app/member/';
var username='';
var maxcredit='';
var code='';
var pg=0;
var sel_league='';	//選擇顯示聯盟
var uid='<?=$uid?>';		//user's session ID
var loading = 'Y';	//是否正在讀取瀏覽頁面
var loading_var = 'Y';	//是否正在讀取變數值頁面
var ShowType = '';	//目前顯示頁面
var ltype = 1;		//目前顯示line
var retime_flag = 'Y';	//自動更新旗標
var retime = 0;		//自動更新時間

var str_even = '和';
var str_renew = '秒自動更新';
var str_submit = '確認';
var str_reset = '重設';
var num_page = 20;	//設定20筆賽程一頁
var now_page = 1;	//目前顯示頁面
var pages = 1;		//總頁數
var msg = '';		//即時資訊
var gamount = 0;	//目前顯示一般賽程數
var GameFT = new Array(512); //最多設定顯示512筆開放賽程
var sel_gtype='FT';
var iorpoints=2;
var GameHead=new Array();


var show_more_gid = '';

// -->
</SCRIPT>
<frameset rows="0,*" frameborder="NO" border="0" framespacing="0">
  <frame name="body_var" scrolling="NO" noresize src="body_var.php?uid=<?=$uid?>&rtype=<?=$rtype?>&langx=<?=$langx?>&mtype=<?=$mtype?>&delay=<?=$delay?>&league_id=<?=$league_id?>&hot_game=<?=$hot_game?>">
  <frame name="body_browse" src="body_browse.php?uid=<?=$uid?>&rtype=<?=$rtype?>&langx=<?=$langx?>&mtype=<?=$mtype?>&delay=<?=$delay?>&showtype=<?=$showtype?>">
</frameset>
<noframes><body bgcolor="#000000">

</body></noframes>
</html>



