<?
include "../include/library.mem.php";
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";

require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/http.class.php");
$gid   = $_REQUEST['gid'];
$uid   = $_REQUEST['uid'];
$ltype = $_REQUEST['ltype'];

$sql = "select language,opentype,Memname from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}else{
	$langx=$_REQUEST['langx'];
	require ("../include/traditional.$langx.inc.php");
	$memname=$row['Memname'];
	//userlog($memname);
	$mysql = "select MID,MB_Win,TG_Win,M_Flat,MB_MID,TG_MID,MB1TG0,MB2TG0,MB2TG1,MB3TG0,MB3TG1,MB3TG2,MB4TG0,MB4TG1,MB4TG2,MB4TG3,MB0TG0,MB1TG1,MB2TG2,MB3TG3,MB4TG4,OVMB,MB0TG1,MB0TG2,MB1TG2,MB0TG3,MB1TG3,MB2TG3,MB0TG4,MB1TG4,MB2TG4,MB3TG4,S_0_1,S_2_3,S_4_6,S_7UP,MBMB,MBFT,MBTG,FTMB,FTFT,FTTG,TGMB,TGFT,TGTG from foot_match  where mid=$gid+1";
	$result1 = mysql_db_query($dbname, $mysql);
	$row1=mysql_fetch_array($result1);

	$mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MB_Win,TG_Win,M_Flat,MB_MID,TG_MID,MB1TG0,MB2TG0,MB2TG1,MB3TG0,MB3TG1,MB3TG2,MB4TG0,MB4TG1,MB4TG2,MB4TG3,MB0TG0,MB1TG1,MB2TG2,MB3TG3,MB4TG4,OVMB,MB0TG1,MB0TG2,MB1TG2,MB0TG3,MB1TG3,MB2TG3,MB0TG4,MB1TG4,MB2TG4,MB3TG4,S_0_1,S_2_3,S_4_6,S_7UP,MBMB,MBFT,MBTG,FTMB,FTFT,FTTG,TGMB,TGFT,TGTG from foot_match  where mid=$gid";
	$result = mysql_db_query($dbname, $mysql);
	$row=mysql_fetch_array($result);
	$m_date=$row[M_Date].'<br>'.$row[M_Time];

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link rel="stylesheet" href="/style/member/mem_body_ft.css" type="text/css">
<script> 
var ObjDataFT=new Array();
function onLoad(){
	show_detail(GameHead,GameHead_SP,GameOther,SPdata);
	parent.document.getElementById('more_window').style.display="block";
	var dd=document.getElementById('showALL_DATA');
	parent.document.getElementById('showdata').width=dd.clientWidth;
	parent.document.getElementById('showdata').height=dd.clientHeight;
}
function show_detail(Game_Head,Game_Head_SP,GameData,SPdata){
	ObjDataFT=new Object();
	var ObjDataSP=new Object();
	
	if (GameData!=null){
		ObjDataFT=parseArray(Game_Head,GameData);
	}
	if (SPdata!=null){
		ObjDataSP=parseArray(Game_Head_SP,SPdata);
		ObjDataSP.gid=ObjDataFT.gid;
	}
	var tableData;
	if(document.all){
     	tableData=document.getElementById('showtableData').innerText;
	}else{
     	tableData=document.getElementById('showtableData').textContent;
	}
	tableData=tableData.replace("*SHOW_TEAM_H*",ObjDataFT.team_h).replace("[Mid]","[N]");
	tableData=tableData.replace("*SHOW_TEAM_C*",ObjDataFT.team_c);
	tableData=tableData.replace("*SHOW_TEAM_FS_H*",ObjDataFT.team_h);
	tableData=tableData.replace("*SHOW_TEAM_FS_C*",ObjDataFT.team_c);
	
   	var Head_PD  =new Array('ior_H1C0','ior_H2C0','ior_H2C1','ior_H3C0','ior_H3C1','ior_H3C2','ior_H4C0','ior_H4C1','ior_H4C2','ior_H4C3','ior_H0C0','ior_H1C1','ior_H2C2','ior_H3C3','ior_H4C4','ior_OVH','ior_H0C1','ior_H0C2','ior_H1C2','ior_H0C3','ior_H1C3','ior_H2C3','ior_H0C4','ior_H1C4','ior_H2C4','ior_H3C4','ior_OVC');
	var Head_HPD =new Array('ior_HH1C0','ior_HH2C0','ior_HH2C1','ior_HH3C0','ior_HH3C1','ior_HH3C2','ior_HH4C0','ior_HH4C1','ior_HH4C2','ior_HH4C3','ior_HH0C0','ior_HH1C1','ior_HH2C2','ior_HH3C3','ior_HH4C4','ior_HOVH','ior_HH0C1','ior_HH0C2','ior_HH1C2','ior_HH0C3','ior_HH1C3','ior_HH2C3','ior_HH0C4','ior_HH1C4','ior_HH2C4','ior_HH3C4','ior_HOVC');
	var Head_F   =new Array('ior_FHH','ior_FHN','ior_FHC','ior_FNH','ior_FNN','ior_FNC','ior_FCH','ior_FCN','ior_FCC');
	var Head_T   =new Array('ior_ODD','ior_EVEN','ior_T01','ior_T23','ior_T46','ior_OVER');
    var Head_SP_PG =new Array('ior_PGFH','ior_PGFC','ior_PGFN','ior_PGFN','ior_PGLH','ior_PGLC','ior_PGLN');
    var Head_SP1 =new Array('ior_OSFH','ior_OSFC','ior_OSFN','ior_OSLH','ior_OSLC','ior_OSLN','ior_OSLN','ior_STFH','ior_STFC','ior_STFN','ior_STFN','ior_STLH','ior_STLC','ior_STLN','ior_GAFH','ior_GAFC','ior_GAFN','ior_GALH','ior_GALC','ior_GALN');
    var Head_SP2 =new Array('ior_CNFH','ior_CNFC','ior_CNFN','ior_CNLH','ior_CNLC','ior_CNLN','ior_CDFH','ior_CDFC','ior_CDFN','ior_CDLH','ior_CDLC','ior_CDLN','ior_YCFH','ior_YCFC','ior_YCFN','ior_YCLH','ior_YCLC','ior_YCLN','ior_RCFH','ior_RCFC','ior_RCFN','ior_RCLH','ior_RCLC','ior_RCLN');
 
    tableData=parseM(tableData,ObjDataFT,Head_PD,"PD");
   	tableData=parseM(tableData,ObjDataFT,Head_HPD,"HPD");
   	tableData=parseM(tableData,ObjDataFT,Head_T,"T");
   	tableData=parseM(tableData,ObjDataFT,Head_F,"F");
   	tableData=parseM(tableData,ObjDataSP,Head_SP1,"SP0");
   	tableData=parseM(tableData,ObjDataSP,Head_SP_PG,"SP_PG");
   	tableData=parseM(tableData,ObjDataSP,Head_SP2,"SP1");
	tableData=parseFS(tableData,Stype,FS_teams,"FS");   
	var showtable=document.getElementById('showtable');
	showtable.innerHTML=tableData;	
 
}
function parseM(layout,gamedata,tag,wtype){
	var hasUrl=false;
	var tmp_wtype=wtype;
	if (wtype=="SP0"||wtype=="SP1"||wtype=="SP_PG"){
		tmp_wtype="SP";
	}
	for (i=0;i < tag.length;i++){
		var rtype=tag[i].split("_")[1];
		var ratio_url=parseUrl(uid,top.odd_f_type,gamedata,tmp_wtype,rtype);
		if (ratio_url!=""){
			hasUrl=true;
		}
		layout=layout.replace("*"+tag[i].toUpperCase()+"*",ratio_url);
	}
	if (hasUrl){
		layout=layout.replace("*DISPLAY_"+wtype+"*","");
	}else{
		layout=layout.replace("*DISPLAY_"+wtype+"*","style='display: none'");
	}
	return layout;
}
 
//取注url
function parseUrl(uid,odd_f_type,GameData,wtype,rtype){
	var urlArray=new Array();
	urlArray['PD']=new Array("../FT_order/FT_order_pd.php");
	urlArray['HPD']=new Array("../FT_order/FT_order_hpd.php");
	urlArray['F']=new Array("../FT_order/FT_order_f.php");
	urlArray['T']=new Array("../FT_order/FT_order_t.php");
	urlArray['SP']=new Array("../FT_order/FT_order_sp.php");
	urlArray['NFS']=new Array("../FT_order/FT_order_nfs.php");
	
	var paramRtype = new Array();
	paramRtype['ODD'] = "ODD";
	paramRtype['EVEN'] = "EVEN";
	paramRtype['T01'] = "0~1";
	paramRtype['T23'] = "2~3";
	paramRtype['T46'] = "4~6";
	paramRtype['OVER'] = "OVER";
	
	var param=getParam(uid,odd_f_type,GameData,wtype,rtype);
	var order=urlArray[wtype][0];
	
	var ioratio=eval("GameData.ior_"+rtype);
	var ret="";
	
	var team="";
	if (wtype=="SP"){
		tmp_rtype=rtype.substring(3,4);
		//alert(tmp_rtype);
		if (tmp_rtype=="H"){
			team=ObjDataFT.team_h;
		}else if (tmp_rtype=="C"){
			team=ObjDataFT.team_c;
		}else{
			team=str_rtype_SP[rtype];
		}
	}else if(wtype=="PD"||wtype=="HPD"){
		if (rtype=="OVH"||rtype=="HOVH"){
			team="Other Score";
		}else{
			team=rtype.replace("H","").replace("H","").replace("C",":");
		}
	}else if (wtype=="F"){
		team=changeTitleStr(rtype,1)+"/"+changeTitleStr(rtype,2);	
	}else{
		if (rtype=="OVER"){
			team="7up";
		}else if (rtype=="ODD"){
			team=top.strOdd;
		}else if (rtype=="EVEN"){
			team=top.strEven;
		}else{	
			team=paramRtype[rtype];
		}
	}
	
	if (ioratio*1 > 0){
	 	//ret="<a href='"+order+"?"+param+"' target='mem_order'>"+ioratio+"</a>";
	 	if(wtype=="SP"){
			ret="<a href='javascript://'  title='"+team+"'>"+ioratio+"</a>";
		}else{
	 		ret="<a href='javascript://' onclick=\"parent.parent.parent.mem_order.betOrder('FT','"+wtype+"','"+param+"');\" title='"+team+"'>"+ioratio+"</a>";
		}
	}
	return ret;
	
}
 
//--------------------------public function --------------------------------
 
//取注
function getParam(uid,odd_f_type,GameData,wtype,rtype){
	var paramArray=new Array();
	//paramArray['R']=new Array("gid","uid","odd_f_type","type","gnum","strong");
	paramArray['PD']=new Array("gid","uid","odd_f_type","rtype");
	paramArray['HPD']=new Array("gid","uid","odd_f_type","rtype");
	paramArray['F']=new Array("gid","uid","odd_f_type","rtype");
	paramArray['T']=new Array("gid","uid","odd_f_type","rtype");
	paramArray['SP']=new Array("gid","uid","odd_f_type","rtype");
	var param="";
	var gid=((wtype=="HPD") ? GameData.hgid : GameData.gid);
	if (wtype=="HPD"){
		rtype=rtype.substring(1,5);	
	}
	if (wtype=="T"){
		if (rtype!="OVER"&&rtype!="ODD"&&rtype!="EVEN"){
			rtype=rtype.substring(1,2)+"~"+	rtype.substring(2,3);
		}
	}
	for (var i=0;i<paramArray[wtype].length;i++){
		if (i>0)  param+="&";
		param+=paramArray[wtype][i]+"="+eval(paramArray[wtype][i]);
	}
	param+="&langx="+top.langx;
	return param;
}
function parseFS(layout,stype,teams,wtype){
	var h,c,tcount,stype_h1,stype_h2,stype_c1,stype_c2;
	if(teams["H"] == null || teams["C"] == null){
		layout=layout.replace("*DISPLAY_"+wtype+"*","style='display: none'");
		return layout;
	}else{
		layout=layout.replace("*DISPLAY_"+wtype+"*","");
	}
	
	try{
		stype_h1 = stype['H1'][0];
		stype_h2 = stype['H2'][0];
		stype_c1 = stype['C1'][0];
		stype_c2 = stype['C2'][0];
		h = teams["H"];
		c = teams["C"];
	}catch(e){
		return layout;
	}
	tcount = h.length;
	if(c.length > h.length) tcount = c.length;
	var trdata=document.getElementById('DataTR_FS').innerHTML;
	var showlayers="";
	for(n=1;n < tcount;n++){
		showlayers+=parseFS_TR(trdata,h,c,stype_h1,stype_h2,stype_c1,stype_c2,n);
	}
	layout=layout.replace("*showDataTR_FS*",showlayers);
	return layout;
}
function parseFS_TR(onelayer,h,c,stype_h1,stype_h2,stype_c1,stype_c2,n){
	
	if (h[n]!=null){
		onelayer=onelayer.replace("*TEAM_H*",h[n]['tname']);//TQ
		onelayer=onelayer.replace("*IOR_FH*",getFSHref(h[n]['gtype'],h[n]['gid'+stype_h1],h[n]['rtype'+stype_h1],"FS",h[n]['ioratio'+stype_h1]));//Mr
		onelayer=onelayer.replace("*IOR_LH*",getFSHref(h[n]['gtype'],h[n]['gid'+stype_h2],h[n]['rtype'+stype_h2],"FS",h[n]['ioratio'+stype_h2]));//r
	}else{
		onelayer=onelayer.replace("*TEAM_H*","");//TQ
		onelayer=onelayer.replace("*IOR_FH*","");//Mr
		onelayer=onelayer.replace("*IOR_LH*","");//r
	}
	if (c[n]!=null){
		onelayer=onelayer.replace("*TEAM_C*",c[n]['tname']);//TQ
		onelayer=onelayer.replace("*IOR_FC*",getFSHref(c[n]['gtype'],c[n]['gid'+stype_c1],c[n]['rtype'+stype_c1],"FS",c[n]['ioratio'+stype_c1]));//Mr
		onelayer=onelayer.replace("*IOR_LC*",getFSHref(c[n]['gtype'],c[n]['gid'+stype_c2],c[n]['rtype'+stype_c2],"FS",c[n]['ioratio'+stype_c2]));//r
	}else{
		onelayer=onelayer.replace("*TEAM_C*","");//TQ
		onelayer=onelayer.replace("*IOR_FC*","");//Mr
		onelayer=onelayer.replace("*IOR_LC*","");//r
	}
	return onelayer;
}
 
 
function getFSHref(gametype,gid,rtype,wtype,ratio){
	var str = "";
	if(ratio != undefined){
		//str = '<a href=\"../FT_order/FT_order_nfs.php?gametype='+gametype+'&gid='+gid+'&uid='+uid+'&rtype='+rtype+'&wtype='+wtype+'\" target=\"mem_order\">'+ratio+'</A>';
		var param="gametype="+gametype+"&gid="+gid+"&uid="+uid+"&rtype="+rtype+"&wtype="+wtype+"&langx="+top.langx;
		str = "<a class=\"r_bold\" onclick=\"parent.parent.parent.mem_order.betOrder('FT','NFS','"+param+"');\" style=\"cursor:hand\">"+ratio+"</a>";
		
	}
	return str;
}
 
 
 
</script>
 
<script>
 
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
//--------------袛聯@示[----------------
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
 
//
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
 
//rg D 24小r//04:00p
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
 
//[业x聯賽
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
var uid='<?=$uid?>'; 
<?
$mysql = "select * from web_system";
	$result = mysql_db_query($dbname,$mysql);
	$row = mysql_fetch_array($result);
	
	switch($langx){
	case "en-us":
		$suid=$row['uid_en'];
		$site=$row['datasite_en'];
		break;
	case "zh-tw":
		$suid=$row['uid_tw'];
		$site=$row['datasite_tw'];
		break;
	default:
		$suid=$row['uid_cn'];
		$site=$row['datasite'];
		break;
	}

	$base_url = "".$site."/app/member/FT_browse/index.php?rtype=$rtype&uid=$suid&langx=$langx1&mtype=$mtype";
	$thisHttp = new cHTTP();
	$thisHttp->setReferer($base_url);
	
   $filename="".$site."/app/member/FT_browse/body_var_r_more.php?uid=$suid&langx=$langx1&ltype=$ltype&gid=$gid";
	$thisHttp->getPage($filename);

$msg  = $thisHttp->getContent();
 $GameOther=explode('GameOther = ',$msg);
 $GameOther=explode(';',$GameOther[1]);
 $GameOther=$GameOther[0];
 
 $SPdata=explode('SPdata = ',$msg);
 $SPdata=explode(';',$SPdata[1]);
 $SPdata=$SPdata[0];

?>
GameOther = <?=$GameOther?>;


SPdata = <?=$SPdata?>;
SPrtype = new Array('PGFH','PGFC','PGFN','PGLH','PGLC','PGLN','OSFH','OSFC','OSFN','OSLH','OSLC','OSLN','STFH','STFC','STFN','STLH','STLC','STLN','GAFH','GAFC','GAFN','GALH','GALC','GALN','CNFH','CNFC','CNFN','CNLH','CNLC','CNLN','CDFH','CDFC','CDFN','CDLH','CDLC','CDLN','YCFH','YCFC','YCFN','YCLH','YCLC','YCLN','RCFH','RCFC','RCFN','RCLH','RCLC','RCLN');
str_rtype_SP = new Array();
str_rtype_SP['PGF'] = '<?=$strRtypeSP1?>';
str_rtype_SP['OSF'] = '<?=$strRtypeSP2?>';
str_rtype_SP['STF'] = '<?=$strRtypeSP3?>';
str_rtype_SP['CNF'] = '<?=$strRtypeSP4?>';
str_rtype_SP['CDF'] = '<?=$strRtypeSP5?>';
str_rtype_SP['RCF'] = '<?=$strRtypeSP6?>';
str_rtype_SP['YCF'] = '<?=$strRtypeSP7?>';
str_rtype_SP['GAF'] = '<?=$strRtypeSP8?>';
str_rtype_SP['PGL'] = '<?=$strRtypeSP9?>';
str_rtype_SP['OSL'] = '<?=$strRtypeSP10?>';
str_rtype_SP['STL'] = '<?=$strRtypeSP11?>';
str_rtype_SP['CNL'] = '<?=$strRtypeSP12?>';
str_rtype_SP['CDL'] = '<?=$strRtypeSP13?>';
str_rtype_SP['RCL'] = '<?=$strRtypeSP14?>';
str_rtype_SP['YCL'] = '<?=$strRtypeSP15?>';
str_rtype_SP['GAL'] = '<?=$strRtypeSP16?>';
str_rtype_SP['PG'] = '<?=$strRtypeSP17?>';
str_rtype_SP['OS'] = '<?=$strRtypeSP18?>';
str_rtype_SP['ST'] = '<?=$strRtypeSP19?>';
str_rtype_SP['CN'] = '<?=$strRtypeSP20?>';
str_rtype_SP['CD'] = '<?=$strRtypeSP21?>';
str_rtype_SP['RC'] = '<?=$strRtypeSP22?>';
str_rtype_SP['YC'] = '<?=$strRtypeSP23?>';
str_rtype_SP['GA'] = '<?=$strRtypeSP24?>';
str_rtype_SP['PGFN'] = '<?=$strRtypeSP25?>';
str_rtype_SP['OSFN'] = '<?=$strRtypeSP26?>';
str_rtype_SP['STFN'] = '<?=$strRtypeSP27?>';
str_rtype_SP['CNFN'] = '<?=$strRtypeSP28?>';
str_rtype_SP['CDFN'] = '<?=$strRtypeSP29?>';
str_rtype_SP['RCFN'] = '<?=$strRtypeSP30?>';
str_rtype_SP['YCFN'] = '<?=$strRtypeSP31?>';
str_rtype_SP['PGLN'] = '<?=$strRtypeSP32?>';
str_rtype_SP['OSLN'] = '<?=$strRtypeSP33?>';
str_rtype_SP['STLN'] = '<?=$strRtypeSP34?>';
str_rtype_SP['CNLN'] = '<?=$strRtypeSP35?>';
str_rtype_SP['CDLN'] = '<?=$strRtypeSP36?>';
str_rtype_SP['RCLN'] = '<?=$strRtypeSP37?>';
str_rtype_SP['YCLN'] = '<?=$strRtypeSP38?>';
FS_teams = new Array();
Stype = new Array();
var GameHead =new Array('hgid','datetime','league','gnum_h','gnum_c','team_h','team_c','strong','ior_MH','ior_MC','ior_MN','','','','','ior_HMH','ior_HMC','ior_HMN','gid','ior_H1C0','ior_H2C0','ior_H2C1','ior_H3C0','ior_H3C1','ior_H3C2','ior_H4C0','ior_H4C1','ior_H4C2','ior_H4C3','ior_H0C0','ior_H1C1','ior_H2C2','ior_H3C3','ior_H4C4','ior_OVH','ior_H0C1','ior_H0C2','ior_H1C2','ior_H0C3','ior_H1C3','ior_H2C3','ior_H0C4','ior_H1C4','ior_H2C4','ior_H3C4','ior_OVC','ior_ODD','ior_EVEN','ior_T01','ior_T23','ior_T46','ior_OVER','ior_FHH','ior_FHN','ior_FHC','ior_FNH','ior_FNN','ior_FNC','ior_FCH','ior_FCN','ior_FCC','ior_HH1C0','ior_HH2C0','ior_HH2C1','ior_HH3C0','ior_HH3C1','ior_HH3C2','ior_HH4C0','ior_HH4C1','ior_HH4C2','ior_HH4C3','ior_HH0C0','ior_HH1C1','ior_HH2C2','ior_HH3C3','ior_HH4C4','ior_HOVH','ior_HH0C1','ior_HH0C2','ior_HH1C2','ior_HH0C3','ior_HH1C3','ior_HH2C3','ior_HH0C4','ior_HH1C4','ior_HH2C4','ior_HH3C4','ior_HOVC');
var GameHead_SP =new Array('ior_PGFH','ior_PGFC','ior_PGFN','ior_PGLH','ior_PGLC','ior_PGLN','ior_OSFH','ior_OSFC','ior_OSFN','ior_OSLH','ior_OSLC','ior_OSLN','ior_STFH','ior_STFC','ior_STFN','ior_STLH','ior_STLC','ior_STLN','ior_GAFH','ior_GAFC','ior_GAFN','ior_GALH','ior_GALC','ior_GALN','ior_CNFH','ior_CNFC','ior_CNFN','ior_CNLH','ior_CNLC','ior_CNLN','ior_CDFH','ior_CDFC','ior_CDFN','ior_CDLH','ior_CDLC','ior_CDLN','ior_YCFH','ior_YCFC','ior_YCFN','ior_YCLH','ior_YCLC','ior_YCLN','ior_RCFH','ior_RCFC','ior_RCFN','ior_RCLH','ior_RCLC','ior_RCLN');
</script>
 
</head>
<body id="MFT" class="BODYMORE" onLoad="onLoad();">
 
<div id=showtableData style="display:none;">
<xmp>
	<table border="0" cellpadding="0" cellspacing="0" id="showALL_DATA">
	<tr>
	<td>	
	<table id="table_team" width="100%" border="0" cellspacing="1" cellpadding="0" class="game">
		<tr>
			<td class="game_team">
				<tt>
					*SHOW_TEAM_H*
				</tt>&nbsp;&nbsp;
				<span class="vs">vs.</span>&nbsp;&nbsp;
				<tt>
					*SHOW_TEAM_C*
				</tt>
				<input type="button" class="close" value="" onClick="parent.document.getElementById('more_window').style.display='none';">
	
			</td>
		</tr>
	</table>		
	<table id="table_pd" *DISPLAY_PD* border="0" class="game">
	    <tr>
	    	<td class="game_title" colspan="16"><?=$Correctscore?></td>
	    </tr>
		<tr>
			<th>1:0</th>
			<th>2:0</th>
			<th>2:1</th>
			<th>3:0</th>
			<th>3:1</th>
			<th>3:2</th>
			<th>4:0</th>
			<th>4:1</th>
			<th>4:2</th>
			<th>4:3</th>
			<th>0:0</th>
			<th>1:1</th>
			<th>2:2</th>
			<th>3:3</th>
			<th>4:4</th>
			<th><?=$qita?></th>
		</tr>
		<tr class="b_cen">
			<td>*IOR_H1C0*</td>
			<td>*IOR_H2C0*</td>
			<td>*IOR_H2C1*</td>
			<td>*IOR_H3C0*</td>
			<td>*IOR_H3C1*</td>
			<td>*IOR_H3C2*</td>
			<td>*IOR_H4C0*</td>
			<td>*IOR_H4C1*</td>
			<td>*IOR_H4C2*</td>
			<td>*IOR_H4C3*</td>
			
			<td rowspan="2">*IOR_H0C0*</td>
			<td rowspan="2">*IOR_H1C1*</td>
			<td rowspan="2">*IOR_H2C2*</td>
			<td rowspan="2">*IOR_H3C3*</td>
			<td rowspan="2">*IOR_H4C4*</td>
			<td rowspan="2">*IOR_OVH*</td>
		</tr>	
		<tr class="b_cen">
			<td>*IOR_H0C1*</td>
			<td>*IOR_H0C2*</td>
			<td>*IOR_H1C2*</td>
			<td>*IOR_H0C3*</td>
			<td>*IOR_H1C3*</td>
			<td>*IOR_H2C3*</td>
			<td>*IOR_H0C4*</td>
			<td>*IOR_H1C4*</td>
			<td>*IOR_H2C4*</td>
			<td>*IOR_H3C4*</td>
		</tr>
    </table>
	<table id="table_hpd" *DISPLAY_HPD* border="0" class="game">
		<tr>
			<td class="game_title" colspan="16"><?=$bodan?></td>
		</tr>
		<tr>
			<th>1:0</th>
			<th>2:0</th>
			<th>2:1</th>
			<th>3:0</th>
			<th>3:1</th>
			<th>3:2</th>
			<th>4:0</th>
			<th>4:1</th>
			<th>4:2</th>
			<th>4:3</th>
			<th>0:0</th>
			<th>1:1</th>
			<th>2:2</th>
			<th>3:3</th>
			<th>4:4</th>
			<th><?=$qita?></th>
		</tr>
		<tr class="b_cen">
			<td>*IOR_HH1C0*</td>
			<td>*IOR_HH2C0*</td>
			<td>*IOR_HH2C1*</td>
			<td>*IOR_HH3C0*</td>
			<td>*IOR_HH3C1*</td>
			<td>*IOR_HH3C2*</td>
			<td>*IOR_HH4C0*</td>
			<td>*IOR_HH4C1*</td>
			<td>*IOR_HH4C2*</td>
			<td>*IOR_HH4C3*</td>
			
			<td rowspan="2">*IOR_HH0C0*</td>
			<td rowspan="2">*IOR_HH1C1*</td>
			<td rowspan="2">*IOR_HH2C2*</td>
			<td rowspan="2">*IOR_HH3C3*</td>
			<td rowspan="2">*IOR_HH4C4*</td>
			<td rowspan="2">*IOR_HOVH*</td>
		</tr>	
		<tr class="b_cen">
			<td>*IOR_HH0C1*</td>
			<td>*IOR_HH0C2*</td>
			<td>*IOR_HH1C2*</td>
			<td>*IOR_HH0C3*</td>
			<td>*IOR_HH1C3*</td>
			<td>*IOR_HH2C3*</td>
			<td>*IOR_HH0C4*</td>
			<td>*IOR_HH1C4*</td>
			<td>*IOR_HH2C4*</td>
			<td>*IOR_HH3C4*</td>
		</tr>
    </table>
    <table id="table_t" *DISPLAY_T* border="0"  class="game">
		<tr>
			<td class="game_title" colspan="6"><?=$rqs?></td>
		</tr>
		<tr>
			<!--th></th>
			<th>双</th--> 
			<th width="25%">0 - 1</th>
			<th width="25%">2 - 3</th>
			<th width="25%">4 - 6</th>
			<th width="25%"><?=$qi?></th>
		</tr>
		<tr class="b_cen">
			<!--td>*IOR_ODD*</td>
			<td>*IOR_EVEN*</td-->
			<td>*IOR_T01*</td>
		    <td>*IOR_T23*</td>
		    <td>*IOR_T46*</td>
		    <td>*IOR_OVER*</td>
		</tr>	
	</table>
    <table id="table_f" *DISPLAY_F* border="0"  class="game">
      <tr><td class="game_title" colspan="9"><?=$banquan?></td></tr>
      <tr>
        <th><?=$HH?></th>
		<th><?=$HD?></th>
        <th><?=$HA?></th>
        <th><?=$DH?></th>
        <th><?=$DD?></th>
        <th><?=$DA?></th>
        <th><?=$AH?></th>
        <th><?=$HD?></th>
        <th><?=$AA?></th>
      </tr>
      <tr>
		<td class="b_cen">*IOR_FHH*</td>
		<td class="b_cen">*IOR_FHN*</td>
		<td class="b_cen">*IOR_FHC*</td>
		<td class="b_cen">*IOR_FNH*</td>

		<td class="b_cen">*IOR_FNN*</td>
		<td class="b_cen">*IOR_FNC*</td>
		<td class="b_cen">*IOR_FCH*</td>
		<td class="b_cen">*IOR_FCN*</td>
		<td class="b_cen">*IOR_FCC*</td>
 
      </tr>
      
      
  </table>
  <table border="0" class="game" id="table_sp_PG" *DISPLAY_SP_PG*>
      <tr class="game_title">
        <td colspan="3"><?=$strRtypeSP1?></td>
        <td colspan="3"><?=$strRtypeSP9?></td>
        </tr>
      <tr>
        <th width="133"><?=$Home?></th>
        <th width="133"><?=$Away?></th>
        <th width="96"><?=$str_HCN3?></th>
        <th width="133"><?=$Home?></th>
        <th width="133"><?=$Away?></th>
        <th width="96"><?=$str_HCN3?></th>
      </tr>
      <tr>
        <td class="b_cen">*IOR_PGFH*</td>
        <td class="b_cen">*IOR_PGFC*</td>
        <td class="b_cen">*IOR_PGFN*</td>
        <td class="b_cen">*IOR_PGLH*</td>
        <td class="b_cen">*IOR_PGLC*</td>
        <td class="b_cen">*IOR_PGFN*</td>
      </tr>
    </table>
  <!--<table id="table_sp_PG" *DISPLAY_SP_PG* border="0" class="game">
  	<tr class="game_title">
	    <td nowrap></td>
	  	<td>冉</td>
	    <td></td>
	  </tr>
	  <tr class="b_cen">
        <td nowrap></td>
        <td>*IOR_PGFH*</td>
        <td>*IOR_PGLH*</td>
    </tr>
    <tr class="b_cen">
        <td nowrap>投</td>
        <td>*IOR_PGFC*</td>
        <td>*IOR_PGLC*</td>
    </tr>
    <tr class="b_cen">
        <td></td>
        <td>*IOR_PGFN*</td>
        <td>*IOR_PGFN*</td>
    </tr>
  </table> -->       
	<table border="0" class="game" id="table_sp0" *DISPLAY_SP0*>
      <tr class="game_title">
        <td nowrap width="74"><?=$guanlea?></td>
        <td width="106"><?=$strRtypeSP3?></td>
        <td width="106"><?=$strRtypeSP11?></td>
        <td width="106"><?=$strRtypeSP2?></td>
        <td width="106"><?=$strRtypeSP10?></td>
        <td width="106"><?=$strRtypeSP8?></td>
        <td width="106"><?=$strRtypeSP16?></td>
      </tr>
      <tr class="b_cen">
        <td nowrap><?=$Home?></td>
        <td>*IOR_STFH*</td>
        <td>*IOR_STLH*</td>
        
        <td>*IOR_OSFH*</td>
        <td>*IOR_OSLH*</td>
        <td>*IOR_GAFH*</td>
        <td>*IOR_GALH*</td>
      </tr>
      <tr class="b_cen">
        <td nowrap><?=$Away?></td>
        <td>*IOR_STFC*</td>
        <td>*IOR_STLC*</td>
        
        <td>*IOR_OSFC*</td>
        <td>*IOR_OSLC*</td>
        <td>*IOR_GAFC*</td>
        <td>*IOR_GALC*</td>
      </tr>
      <tr class="b_cen">
        <td><?=$str_HCN3?></td>
        <td>*IOR_STFN*</td>
        <td>*IOR_STFN*</td>
        <td>*IOR_OSLN*</td>
        <td>*IOR_OSLN*</td>
        <td class="b_cen">&nbsp;</td>
        <td class="b_cen">&nbsp;</td>
      </tr>
    </table>
	<table id="table_sp1" *DISPLAY_SP1* border="0" class="game">
      <tr class="game_title">
       <td nowrap><?=$guanlea?></td>
        <td width="12%"><?=$strRtypeSP4?></td>
        <td width="12%"><?=$strRtypeSP12?></td>
        <td width="12%"><?=$strRtypeSP5?></td>
        <td width="12%"><?=$strRtypeSP13?></td>
        <td width="12%"><?=$strRtypeSP7?></td>
        <td width="12%"><?=$strRtypeSP15?></td>
        <td width="12%"><?=$strRtypeSP6?></td>
        <td width="12%"><?=$strRtypeSP14?></td>
      </tr>
      <tr class="b_cen">
        <td><?=$str_HCN1?></td>
        <td>*IOR_CNFH*</td>
        <td>*IOR_CNLH*</td>
        <td>*IOR_CDFH*</td>
        <td>*IOR_CDLH*</td>
        <td>*IOR_YCFH*</td>
        <td>*IOR_YCLH*</td>
        <td>*IOR_RCFH*</td>
        <td>*IOR_RCLH*</td>
      </tr>
      <tr class="b_cen">
        <td><?=$str_HCN2?></td>
        <td>*IOR_CNFC*</td>
        <td>*IOR_CNLC*</td>
        <td>*IOR_CDFC*</td>
        <td>*IOR_CDLC*</td>
        <td>*IOR_YCFC*</td>
        <td>*IOR_YCLC*</td>
        <td>*IOR_RCFC*</td>
        <td>*IOR_RCLC*</td>
      </tr>
      <tr class="b_cen">
        <td align="center"><?=$str_HCN3?></td>
        <td colspan="2">*IOR_CNFN*</td>
        <td colspan="2">*IOR_CDLN*</td>
        <td colspan="2">*IOR_YCFN*</td>
        <td colspan="2"></td>
      </tr>
    </table>
	<table id="table_fs" *DISPLAY_FS* border="0" class="game">
    <tr>
    	<td class="game_title" colspan="6"><?=$strEtypeSP39?></td>
    </tr>
	<tr>
		<th colspan=3><tt>*SHOW_TEAM_FS_H*</tt></th>
		<th colspan=3>*SHOW_TEAM_FS_C*</span></th>
	</tr>
	<tr>
		<th><?=$strEtypeSP40?></th>
		<th id="pname_h1"><?=$strEtypeSP41?></th>
		<th id="pname_h2"><?=$strEtypeSP42?></th>
		<th><?=$strEtypeSP40?></th>
		<th id="pname_c1"><?=$strEtypeSP41?></th>
		<th id="pname_c2"><?=$strEtypeSP42?></th>
	</tr>
	*showDataTR_FS*
    </table>
</td>
</tr>
</table>
</xmp>
 
</div>
<!--        -->
<table id=DataTR_FS style="display:none;">
	<tr class="b_cen">
	    <td>*TEAM_H*</td>
	    <td>*IOR_FH*</td>
	    <td>*IOR_LH*</td>
	    <td>*TEAM_C*</td>
	    <td>*IOR_FC*</td>
	    <td>*IOR_LC*</td>
   	</tr>
</table>
 
 
 
<div id=showtable></div>
</body>
</html>
 

<?
}
mysql_close();
?>