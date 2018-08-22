<?php

include "../include/library.mem.php";
require ("../include/define_function_list.inc.php");
require ("../include/config.inc.php");

$uid=$_REQUEST['uid'];
$mtype=$_REQUEST['mtype'];
$langx=$_REQUEST['langx'];
$gtype=$_REQUEST['gtype'];

if($mtype=="")$mtype=3;
if($gtype=="")$gtype='FT';
$mm='str_fs_'.$gtype;

require ("../include/traditional.$langx.inc.php");

$cla = '';
switch($langx){
	case 'en-us':
		$cla='_en';
		$css='_en';
		break;
	case 'zh-tw':
		$css='_tw';
		break;
	case 'zh-cn':
		$css='_cn';
		break;
	default:
		$css='';
		break;
}

//$showtype = !empty($_REQUEST['showtype'])?$_REQUEST['showtype']:'';
//if ($showtype=="future"){
//	$header="future";
//	$body=BROWSER_IP."/app/member/FT_future/index.php?uid=$uid&langx=$langx&mtype=$mtype";
//}else{
//	$header="";
//	$body=BROWSER_IP."/app/member/FT_browse/index.php?uid=$uid&langx=$langx&mtype=$mtype";
//}

?>
<!doctype html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="Description" content="Description: Welcome to hg0088.com. This is a premium service for registered members.">
	<title>hg0088</title>
	<link href="/style/member/reset.css" rel="stylesheet" type="text/css">
	<link href="/style/member/order<?=$cla?>.css" rel="stylesheet" type="text/css">
</head>
<script src="/js/jquery-3.1.0.min.js"></script>
<script src="/js/conf/<?=$langx?>.js"></script>
<script src="/js/order/orderleg.js"></script>
<script src="/js/order/orderauto.js"></script>
<script>
	/**
	 * Created by LIYUQING on 2017-8-23.
	 */
	var isHot_game = true;//是否為世足賽
	top.select_showtype = "today";
	top.select_gtype = "FT";
	top.tv_allbet = false;
	var gameData;
	var showtypeAry = new Array("today","early","parlay");

	var gtypeAry = gtypeAry || new Array("FT","BK","TN","VB","BS","OP");
	//var gtypeAry = gtypeAry || new Array("FT","BK","BS","TN","VB,"OP","FS","BM","TT","SK");
	var menuType = "menu";
	var isChgType = false;
	var nowShowRB = false;//選的是否為滾球
	var nowShowHot = false;//選的是否為精選賽事
	var isFirst = true;
	var disHash = new Object();
	var maxHash="";
	//var top.ioradio="";
	var betGtype = "";
	var batWtype = "";
	var batParam = "";
	var _set = new Object();
	var lastSureidName="";//最後確認的注單

	var myBetTimer = null;
	var myBetSec = 90;

	function bodyLoad(){
		////trace("bodyLoad");
		/*
		 if (checkRoute == "Y"){
		 document.getElementById('switch_web').style.display="none";
		 }else{
		 document.getElementById('switch_web').style.display="";
		 }
		 */
		if(top.aspenbet=="Y"||top.showKR=="Y"){
			document.getElementById("hideAD").style.display = "none";
		}
		if(top.mem_status=="S"){
			util.setObjectClass(document.getElementById("title_menu"), "ord_memuBTN_off");
			util.setObjectClass(document.getElementById("title_betslip"), "ord_memuBTN_off");
			util.setObjectClass(document.getElementById("title_mybets"), "ord_memuBTN_off no_margin");
			util.setObjectClass(document.getElementById("div_menu"), "");
			util.setObjectClass(document.getElementById("div_betslip"), "");
			document.getElementById("title_menu").onclick = null;
			document.getElementById("title_betslip").onclick = null;
			document.getElementById("title_mybets").onclick = null;
			document.getElementById("div_menu").innerHTML = "";
			document.getElementById("div_betslip").innerHTML = "";
			document.getElementById("count_mybet").style.display = "none";
			parent.display_loadingMain("order");
			parent.display_loading(false);
			parent.reloadCrditFunction();
			return;
		}

		SetRB("FT",top.uid);
		close_bet();
		setMsg(msg);
		//set_messageCount(countMessage);
		//reload_messageCount();
		//reload_live_game(GameHead,GameData);
		//window.onscroll();
		//document.getElementById('main').onscroll=scroll;
		//var obj=document.getElementById('main');
		//scroll();
		try{
			//var gamecountHot=parent.body.getCountHOT();
			getCountHOT(countHOT);
			goRB();
			//document.getElementById('euro_open').style.zIndex=-1;
		}catch(e){
			//document.getElementById('euro_open').style.display='none';
		}
		setMyBetCount(0);
		checkShowRec(false);
		loadMyBet();
		createTimer();
	}

	function createTimer(){
		clearInterval(myBetTimer);
		myBetTimer = setInterval("loadMyBet()", myBetSec*1000);
	}

	function orderFinish(){
		trace("orderFinish");
		loadMyBet();
	}

	function loadMyBet(){
		try{
			document.getElementById("rec_frame").contentWindow.loadData();
		}catch(e){}
	}

	function loadData(){
		//trace("loadData");
		var par = "";
		par += "uid="+top.uid;
		par += "&langx="+top.langx;
		par += "&pgType=count";

		var getHTML = new HttpRequestXML();
		getHTML.addEventListener("LoadComplete",loadDataComplete);
		getHTML.loadURL(util.getNowDomain()+"/app/member/get_order_mybet.php","POST",par);
	}

	function loadDataComplete(xml){
		trace("loadDataComplete");
		var xmlObj = new Object();
		xmlnode = new XmlNode(xml.getElementsByTagName("serverresponse"));
		xmlnodeRoot = xml.getElementsByTagName("serverresponse")[0];
		xmlObj["mybets"] = xmlnode.Node(xmlnodeRoot,"mybets",false);
		var count = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["mybets"][0],"count")));

		setMyBetCount(count);

		//parent.document.getElementById("loadingL").style.display = "none";

		//menuType = type;

		/*var ary = new Array("div_menu","div_betslip","div_mybets");

		 for(var i=0; i<ary.length; i++){
		 var divname = ary[i];
		 var dis = "none";

		 if(divname=="div_"+menuType) dis="";
		 document.getElementById(divname).style.display = dis;
		 }*/
	}

	//window.onresize = scroll;
	function setMsg(msg){
		//document.getElementById('real_msg').innerHTML=msg;
	}

	function showOrder(){

		try{
			bet_order_frame.resetTimer();
		}catch(e){}
		//document.getElementById('rec_frame').height=0;
		//rec_frame.document.close();
		//document.getElementById('order_button').className="ord_on";
		//document.getElementById('record_button').className="record_btn";
		var betDiv=document.getElementById('div_betslip');
		var rec5Div=document.getElementById('div_mybets');
		betDiv.style.display="";
		rec5Div.style.display="none";
		//document.getElementById('pls_bet').style.display="none";
		//document.getElementById('info_div').style.display='';
		//if (checkRoute != "Y"){
		//	document.getElementById('switch_web').style.display="";
		//}
		//scroll();

		top.open_Rec="";
		try{
			//var gamecountHot=parent.body.getCountHOT();
			getCountHOT(countHOT);
		}catch(e){
			//document.getElementById('euro_open').style.display='none';
		}

	}

	function setMyBetCount(count){
		var obj = document.getElementById("count_mybet");
		obj.style.display = (count*1 > 0)?"":"none";
		obj.innerHTML = count;
	}

	function checkShowRec(isShow){
		/*
		 var dis_no = "";
		 var dis_yes = "none";

		 if(isShow){
		 dis_no = "none";
		 dis_yes = "";
		 }
		 document.getElementById("rec5_nodata").style.display = dis_no;
		 document.getElementById("rec_frame").style.display = dis_yes;
		 */
		//document.getElementById("rec5_nodata").style.display = "none";
		document.getElementById("rec_frame").style.display = "";
	}

	function showRec(){
		////trace("showRec");
		try{
			rec_frame.clearTimer();
			bet_order_frame.clearAllTimer();
			bet_order_frame_bak.clearAllTimer();
		}catch(e){}
		try{
			//close_bet();
		}catch(e){}

		rec_frame.location.replace("/app/member/order_mybet.php?uid="+top.uid+"&langx="+top.langx);

		try{
			if(tenrec_id ==""){
				top.open_Rec="";
			}else{
				top.open_Rec="Y";
			}
		}catch(e){}

		try{
			//getCountHOT(countHOT);
		}catch(e){
		}
		//parent.document.getElementById("loadingL").style.display = "none";
	}
	function onloadSet(w,h,frameName){
		trace("onloadSet===>"+w+","+h+","+frameName);

		/*
		 document.getElementById("bet_order_frame").style.display = "none";
		 document.getElementById("rec_frame").style.display = "none";
		 document.getElementById("div_menu").style.display = "none";
		 */

		//document.getElementById(frameName).width = "100%";
		//document.getElementById(frameName).height ="100%";

		document.getElementById(frameName).width =215+"px";
		document.getElementById(frameName).height=h+"px";

		try{
			document.getElementById(frameName+"_bak").width =215+"px";
			document.getElementById(frameName+"_bak").height=h+"px";
		}catch(e){}
		//document.getElementById(frameName).style.display = "";


		if (frameName=="rec_frame"){
			document.getElementById(frameName).width = w;
			try{
				if(tenrec_id!=""){
					top.open_Rec="Y";
					//document.getElementById('info_div').style.display='none';
					//document.getElementById('switch_web').style.display="none";
					//document.getElementById('euro_open').style.display='none';
				}else{
					top.open_Rec="";
				}
			}catch(e){}

			try{
				//var gamecountHot=parent.body.getCountHOT();
				getCountHOT(countHOT);
			}catch(e){
				//document.getElementById('euro_open').style.display='none';
			}
		}

		//scroll();
	}

	function betOrder(gtype,wtype,param,idName){

		top.errorMsg = "";
		if (wtype=="P3"||wtype=="PR"){
			//top.keepGold_PR="";
		}else{

			top.keepGold="";
			top.keepGold_PR="";
			//點了要有底色如果點同一個要取消
			try{
				if(top.lastidName != null)
				{
					if(idName == top.lastidName)
					{
						close_bet();
						return;
					}
				}

				clear_parlay();
				try{
					parent.body.Bright(idName);
				}catch(e){}
			}catch(e){}
		}
		top.ioradio="";
		var url=parseUrl(gtype,wtype,param);

		////trace(url);
		bet_order_frame.location.replace(url);
		//console.log(url);
		//clearBetFrame();


		//bet_src(url);

		betGtype = gtype;
		batWtype = wtype;
		batParam = param;
		top.betGtype = betGtype;
		top.open_bet="Y";
		top.open_Rec="";
		//2017-06-29 幫看新會員端-所有球類-另開tv-下注單-可贏金額更新秒數到了 會秀0
		top.betWtype = wtype;
		//bet_order_frame.onload=onloadSet;
		//alert("betorder")
		showMenu('betslip');
		document.getElementById('bet_nodata').style.display="none";
		document.getElementById('SIN_BET').style.display="none";
		document.getElementById('bet_order_frame').style.display="";
		document.getElementById('bet_order_frame').height ="100%";

	}

	function bet_src(url){
		if(url!=null&&url!=""){
			//console.error("iframe_src_new");
			iframe_src_new(document.getElementById("bet_order_frame"), url);

		}
	}

	function bet_parse_finish(){
		try{
			document.getElementById("bet_order_frame").contentWindow.clearAllTimer();
		}catch(e){}
		iframe_rename("bet_order_frame");
	}

	function backBet(){
		//trace("backBet");
		top.orderArray = top.lastOrderArray;
		top.ordergid = top.lastOrderGid;
		try{
			for(var i = 0;i < top.ordergid.length;i++){
				var tmpobj = top.orderArray["G"+top.ordergid[i]];
				parent.body.document.getElementById(tmpobj.wtype+"_"+tmpobj.gid).className="bet_bg_color_bet";
			}
		}catch(Ex){
			close_bet();
			return;
		}

		top.backLastBet = true;

		reBet();
	}

	function reBet(){
		if(betGtype != "" && batWtype != "" && batParam != ""){
			betOrder(betGtype,batWtype,batParam);
			top.lastidName = lastSureidName;//2016-0308  保留選項有勾賠率要再亮色
			//console.log("top.lastidname======="+top.lastidName);
			try{
				parent.body.document.getElementById(top.lastidName).className = "bet_bg_color_bet";
				try{
					parent.body.showdata.document.getElementById(top.lastidName).className = "bet_bg_color_bet";
				}
				catch(e){}
				try{
					parent.show_tv.Live_mem.document.getElementById(top.lastidName).className = "bet_bg_color_bet";
				}
				catch(e){}
			}
			catch(e){}

		}
	}
	function orderRemoveGid(removeGid){

		for(var i=0;i < top.ordergid.length;i++){
			var obj=top.orderArray["G"+top.ordergid[i]];
			if (obj.gid==removeGid || obj.hgid==removeGid){
				parent.body.orderRemoveGidBgcolor(top.ordergid[i]);
				top.orderArray["G"+top.ordergid[i]]="undefined";
				top.ordergid[i]=0;

			}
		}

		top.ordergid=resort(top.ordergid);
		top.orderArray = resortAry(top.ordergid);


	}
	function resort(ary){
		var tempary=new Array();
		for(var i=0;i<ary.length;i++){
			if (ary[i]!=0){
				tempary[tempary.length]=ary[i];
			}
		}
		return tempary;
	}
	function resortAry(ary){
		var tempary=new Array();
		for(var i=0;i<ary.length;i++){
			if (ary[i]!=0){
				tempary["G"+ary[i]]=top.orderArray["G"+ary[i]];
			}
		}
		return tempary;
	}

	function orderParlayParam(){
		var param="";
		for(var i=0;i<top.ordergid.length;i++){
			var obj=top.orderArray["G"+top.ordergid[i]];
			if (i!=0) param+="&";
			gameparam="game"+(i+1)+"="+obj.wtype+"&game_id"+(i+1)+"="+obj.gid+"&Hgame_id"+(i+1)+"="+obj.hgid+"&minlimit"+(i+1)+"="+obj.par_minlimit+"&maxlimit"+(i+1)+"="+obj.par_maxlimit;
			param+=gameparam;
		}

		var parlayType = (top.betGtype == "BS")?"PR":"P3";
		parent.paramData=new Array();
		if(top.ordergid.length>0){
			betOrder(top.betGtype,parlayType,"teamcount="+top.ordergid.length+"&uid="+top.uid+"&langx="+top.langx+"&"+param);
		}
	}
	function parseUrl(gtype,wtype,param){
		var rm15 = new Array("ARM","BRM","ERM","DRM");
		var re15 = new Array("ARE","BRE","ERE","DRE")
		var rou15 = new Array("AROU","BROU","EROU","DROU");
		var m15 = new Array("AM","BM","CM","DM","EM","FM");
		var r15 = new Array("AR","BR","CR","DR","ER","FR")
		var ou15 = new Array("AOU","BOU","COU","DOU","EOU","FOU");
		var singleGame = new Array(
			"RWM","RDC","RWE","RWB","ARG","BRG","CRG","DRG","ERG","FRG","GRG","HRG","IRG","JRG","RTS","RCS","RWN","RHG","RMG","RSB","RT3G","RT1G"
			,"WM","DC","BH","WE","WB","PG","TS","CS","WN","F2G","F3G","HG","MG","SB","FG","T3G","T1G","TK","PA","RCD","ST","OS"
		);
		var rouhc = new Array("ROUH","ROUC","HRUH","HRUC");
		var ouhc = new Array("OUH","OUC","HOUH","HOUC");
		var urlArray=new Array();
		urlArray['R']=new Array("../"+gtype+"_order/"+gtype+"_order_r.php");
		urlArray['HR']=new Array("../"+gtype+"_order/"+gtype+"_order_hr.php");
		urlArray['OU']=new Array("../"+gtype+"_order/"+gtype+"_order_ou.php");
		urlArray['HOU']=new Array("../"+gtype+"_order/"+gtype+"_order_hou.php");
		urlArray['M']=new Array("../"+gtype+"_order/"+gtype+"_order_m.php");
		urlArray['HM']=new Array("../"+gtype+"_order/"+gtype+"_order_hm.php");
		urlArray['EO']=new Array("../"+gtype+"_order/"+gtype+"_order_t.php");
		urlArray['REO']=new Array("../"+gtype+"_order/"+gtype+"_order_rt.php");
		urlArray['HEO']=new Array("../"+gtype+"_order/"+gtype+"_order_t.php");
		urlArray['HREO']=new Array("../"+gtype+"_order/"+gtype+"_order_rt.php");
		urlArray['PD']=new Array("../"+gtype+"_order/"+gtype+"_order_pd.php");
		urlArray['RPD']=new Array("../"+gtype+"_order/"+gtype+"_order_rpd.php");
		urlArray['HPD']=new Array("../"+gtype+"_order/"+gtype+"_order_hpd.php");
		urlArray['HRPD']=new Array("../"+gtype+"_order/"+gtype+"_order_hrpd.php");
		urlArray['F']=new Array("../"+gtype+"_order/"+gtype+"_order_f.php");
		urlArray['RF']=new Array("../"+gtype+"_order/"+gtype+"_order_rf.php");
		urlArray['T']=new Array("../"+gtype+"_order/"+gtype+"_order_t.php");
		urlArray['HT']=new Array("../"+gtype+"_order/"+gtype+"_order_ht.php");
		urlArray['RT']=new Array("../"+gtype+"_order/"+gtype+"_order_rt.php");
		urlArray['HRT']=new Array("../"+gtype+"_order/"+gtype+"_order_rt.php");
		urlArray['SP']=new Array("../"+gtype+"_order/"+gtype+"_order_sp.php");
		urlArray['P']=new Array("../"+gtype+"_order/"+gtype+"_order_p.php");
		urlArray['P3']=new Array("../"+gtype+"_order/"+gtype+"_order_p3.php");
		urlArray['PR']=new Array("../"+gtype+"_order/"+gtype+"_order_pr.php");
		urlArray['RE']=new Array("../"+gtype+"_order/"+gtype+"_order_re.php");
		urlArray['HRE']=new Array("../"+gtype+"_order/"+gtype+"_order_hre.php");
		urlArray['ROU']=new Array("../"+gtype+"_order/"+gtype+"_order_rou.php");
		urlArray['HROU']=new Array("../"+gtype+"_order/"+gtype+"_order_hrou.php");
		urlArray['RM']=new Array("../"+gtype+"_order/"+gtype+"_order_rm.php");
		urlArray['HRM']=new Array("../"+gtype+"_order/"+gtype+"_order_hrm.php");
		urlArray['NFS']=new Array("../"+gtype+"_order/"+gtype+"_order_nfs.php");


		urlArray['RE15']=new Array("../"+gtype+"_order/"+gtype+"_order_re15.php");
		urlArray['ROU15']=new Array("../"+gtype+"_order/"+gtype+"_order_rou15.php");
		urlArray['RM15']=new Array("../"+gtype+"_order/"+gtype+"_order_rm15.php");

		urlArray['R15']=new Array("../"+gtype+"_order/"+gtype+"_order_r15.php");
		urlArray['OU15']=new Array("../"+gtype+"_order/"+gtype+"_order_ou15.php");
		urlArray['M15']=new Array("../"+gtype+"_order/"+gtype+"_order_m15.php");

		urlArray['SINGLE']=new Array("../"+gtype+"_order/"+gtype+"_order_single.php");
		urlArray['ROUHC']=new Array("../"+gtype+"_order/"+gtype+"_order_rouhc.php");
		urlArray['OUHC']=new Array("../"+gtype+"_order/"+gtype+"_order_ouhc.php");
		urlArray['W3']=new Array("../"+gtype+"_order/"+gtype+"_order_w3.php");

		if(!Array.indexOf){
			Array.prototype.indexOf = function(obj){
				for(var i=0; i<this.length; i++){
					if(this[i]==obj){
						return i;
					}
				}
				return -1;
			}
		}
		if(ouhc.indexOf(wtype) != -1){
			wtype = "OUHC";
		}
		if(rouhc.indexOf(wtype) != -1){
			wtype = "ROUHC";
		}
		if(singleGame.indexOf(wtype) != -1){
			wtype = "SINGLE";
		}
		if(re15.indexOf(wtype) != -1){
			wtype = "RE15";
		}
		if(rou15.indexOf(wtype) != -1){
			wtype = "ROU15";
		}
		if(rm15.indexOf(wtype) != -1){
			wtype = "RM15";
		}
		if(r15.indexOf(wtype) != -1){
			wtype = "R15";
		}
		if(ou15.indexOf(wtype) != -1){
			wtype = "OU15";
		}
		if(m15.indexOf(wtype) != -1){
			wtype = "M15";
		}

		var url=urlArray[wtype]+"?"+param;
		//document.write(url);
		return url;

	}

	function clearBetFrame(){
		try{
			var ordObj = document.getElementById("bet_order_frame");
			//ordObj.style.display = "none";
			//ordObj.height =0;
			ordObj.contentWindow.clearAllTimer();
			//orgObj.contentDocument.write("<html><head></head><body></body></html>");
			//	orgObj.contentWindow.document.body.innerHTML = "";
			//iframe_src(ordObj, util.getNowDomain()+"/ok.html");
		}catch(e){
			//systemMsg(e.toString());
		}


		try{
			var bakObj = document.getElementById("bet_order_frame_bak");
			bakObj.style.display = "none";
			//bakObj.height =0;
			bakObj.contentWindow.clearAllTimer();
			//iframe_src(bakObj, "about:blank");
		}catch(e){
			//systemMsg(e.toString());
		}
	}
	function clear_parlay(){
		try{
			parent.body.document.getElementById(top.lastidName).className = "bet_bg_color";
			try{
				parent.body.showdata.document.getElementById(top.lastidName).className = "bet_all_bg_bet";
			}
			catch(e){}
			try{
				parent.show_tv.Live_mem.document.getElementById(top.lastidName).className = "bet_bg_color";
			}
			catch(e){}
			top.lastidName="";
		}
		catch(e){}
		//trace("clear_parlay");

		//top.orderArray = new Array();
		//top.ordergid = new Array();
		top.lastClass = "";
		top.lastChose = "";
		top.lastGidm = "";
		top.lastGid = "";
		top.lastWtype = "";
		top.count_parlay =0;
		top.lass_count=0;
		try{
			document.getElementById("bet_order_frame").contentWindow.delteamcount();
		}catch(e){}
	}
	function close_bet(){
		//trace("close_bet");
		//top.more_bgYalloW ="";

		showMenu("menu");
		document.getElementById("bet_order_frame").style.display = "none";
		document.getElementById("bet_nodata").style.display = "";
		bet_order_frame.document.close();
		clearBetFrame();


		top.scripts=new Array();
		top.keepGold="";
		top.keepGold_PR="";
		try{
			parent.body.orderRemoveALL();
			document.getElementById("show_parlay").style.display = "none";
		}catch (E) {}

		top.open_bet="";
		top.errorMsg = "";
		try{
			//var gamecountHot=parent.body.getCountHOT();
			getCountHOT(countHOT);
		}catch(e){
			//document.getElementById('euro_open').style.display='none';
		}
		clear_parlay();

	}
	function return_game(){
		showMenu("menu");

		/*try{
		 parent.body.body_browse.showdata.canclebet();
		 }catch(e){}*/
		//top.scripts=new Array();
		//top.keepGold="";
		//top.keepGold_PR="";
		/*try{
		 parent.body.orderRemoveALL();
		 }catch (E) {}*/

		//top.open_bet="";
		//window.location.href = "";
		try{
			getCountHOT(countHOT);
		}catch(e){
		}

	}
	function Show10List(){
		var objs=document.getElementById('reloadPHP');
		if (parent.refresh_var=='Y'||(""+parent.refresh_var=="undefined")){
			objs.src = "./today/show10rec.php?uid="+top.uid;
		}else{
			objs.src="../../../tpl/member/"+top.langx+"/show10rec_norefresh.html?uid="+top.uid;
		}
	}

	function show_record(){
		if (parent.show=='N'||(""+parent.show=="undefined")){
			parent.show='';
		}else{
			parent.show='N';
		}
		self.location = "./order.php?uid="+top.uid+"&langx="+top.langx+"&show="+parent.show;
	}
	function reload_var(){
		parent.refresh_var='Y';
		self.location.reload();
	}
	function Hot_click(a,b,c){
		parent.location=a+"&league_id=3";
	}
	function OpenLive(paramObj){
		parent.showLive(paramObj);
	}

	//2015-07-21 Peter 更正select取個人訊息筆數的error
	var getMessageCount="";
	function reload_messageCount(){
		clearTimeout(getMessageCount);
		var url = "getNewMessage.php";
		var params = "uid="+top.uid;

		loadHref(url+"?"+params);
		getMessageCount = setTimeout("reload_messageCount()",10000);
		//loadHref(url+"?"+params);
	}

	function loadHref(str){
		loadPHP.location.href=str;
	}

	function set_messageCount(countMessage){
		var mdata;
		var mtable = document.getElementById('messages');
		if(document.all){
			mdata = document.getElementById("messages").innerText;
		}else{
			mdata = document.getElementById("messages").textContent;
		}
		if(countMessage != 0){
			mtable.style.display="";
			mdata = countMessage;
		}
		else{
			mtable.style.display="none";
		}
		mtable.innerText = mdata;
	}

	function overInfo(){
		document.getElementById("personal_Info").style.display = "";
	}
	function outInf(){
		document.getElementById("personal_Info").style.display = "none";
	}

	var ObjDataLive=new Array();
	function reload_live_game(Game_Head,gamedata){
		for (var j=0;j < gamedata.length;j++){
			if (gamedata[j]!=null){
				ObjDataLive[j]=parseArray(Game_Head,gamedata[j]);
			}
		}
		var showtableData;
		var trdata;
		if(document.all){
			showtableData=document.getElementById('livetableData').innerText;
			trdata=document.getElementById('DataTR').innerText;
		} else{
			showtableData=document.getElementById('livetableData').textContent;
			trdata=document.getElementById('DataTR').textContent;
		}
		var showlayers="";
		if(ObjDataLive.length > 0){
			for ( i=0 ;i < ObjDataLive.length;i++){
				showlayers+=getLayer(trdata,i);
			}
		}else{
			var tmp_layer=trdata;
			tmp_layer=tmp_layer.replace("*TIME*","");
			tmp_layer=tmp_layer.replace("*TEAMS*","無直播資料");
			showlayers = tmp_layer;
		}
		var showtable=document.getElementById('showLive_table');
		showtableData=showtableData.replace("*showDataTR*",showlayers);
		showtable.innerHTML=showtableData;
	}
	//表格內容
	function getLayer(onelayer,gamerec){
		onelayer=onelayer.replace("*TIME*",ObjDataLive[gamerec].time+":");
		onelayer=onelayer.replace("*TEAMS*",ObjDataLive[gamerec].teamH+" VS "+ObjDataLive[gamerec].teamC);
		return onelayer;

	}


	//window.onscroll = scroll;

	function scroll(){
		//return;
		var refresh_right = document.getElementById('info_div');

		var msg_height=(refresh_right.style.height.replace("px","")*1);
		var recframe=document.getElementById('rec_frame');
		//alert(recframe.height+"---"+document.body.scrollHeight+"---"+msg_height);
		//if(recframe.height+msg_height < document.body.scrollHeight){
		//alert("1");
		refresh_right.style.top=document.body.scrollHeight - msg_height-15;
		//}else{
		//alert("2");
		//refresh_right.style.top=recframe.height*1+msg_height+250;
		//refresh_right.style.left=0;
		//}

	}
	function showMoreMsg(kind){
		//parent.body.location='./scroll_history.php?uid='+top.uid+'&langx='+top.langx;
		var MoreMsgObj = window.open('./scroll_history.php?uid='+top.uid+'&langx='+top.langx+"&t_important="+kind,"History","width=617,height=500,top=0,left=0,status=no,toolbar=no,scrollbars=yes,resizable=no,personalbar=no");
		MoreMsgObj.focus();
		//chgCountMessage(kind);
	}
	function chgCountMessage(kind,counts){
		countMessage = counts;
		if(kind == 2 && (counts == 0 || counts == "")){
			document.getElementById("messages").style.display="none";
			/*countMessage = 0;
			 if(countMessage != 0)
			 mdata = countMessage;
			 else
			 mdata = " ";
			 mtable.innerHTML = mdata;*/

		}
	}
	/*
	 function chg_URL(){
	 if(!confirm("請問是否切換至舊網址"){
	 return false;
	 }
	 chgURL.location.href='retimeset.php?gid='+gamegid+"&gtype="+gamegtype+"&se="+gamese+"&retime="+gameretime+"&"+get_pageparam();
	 }
	 */
	var xmlHttp;
	function createXHR(){
		if (window.XMLHttpRequest) {
			xmlHttp = new XMLHttpRequest();
		}else if (window.ActiveXObject) {
			xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		}

		if (!xmlHttp) {
			alert('您使用的瀏覽器不支援 XMLHTTP 物件');
			return false;
		}
	}
	function sendRequest(url){
//alert(url);
		createXHR();
		xmlHttp.open('GET',url,true);
		xmlHttp.onreadystatechange=catchResult;
		xmlHttp.send(null);
	}



	function catchResult(){
		if (xmlHttp.readyState==4){
			s=xmlHttp.responseText;
			if (xmlHttp.status == 200) {
				//alert("已成功加入~~"+s+":");
				// location.reload();
				document.getElementById('showURL').innerHTML=s;

				var obj = document.getElementById('newdomain');
				obj.submit();
				// document.getElementById(s).innerHTML='<img src="058/btn_cart.gif" width="129" height="32" align="absmiddle" />';
			}else{
				alert('執行錯誤,代碼:'+xmlHttp.status+'\('+xmlHttp.statusText+'\)');
			}
		}
	}
	function showHOT(){
		//trace("showHOT: "+top.open_bet+","+mem_enable+","+top.open_Rec);
		var countgtype =new Array("FT","BK","TN","VB","BM","TT","BS","OP");
		//alert(top.open_bet+"---"+mem_enable)
		//alert("top.open_bet:"+top.open_bet+",mem_enable="+mem_enable+",top.open_Rec="+top.open_Rec);
		if(top.open_bet =="Y" || mem_enable=="S" || top.open_Rec=="Y"){
			//document.getElementById('euro_open').style.display="none";
		}else{
			var today_RB=0;
			for( var i=0;i<countgtype.length;i++){
				today_RB +=recordHash[countgtype[i]+"_RB"];
				//塞場次進去div
				/*
				 var tmp_obj_RB=document.getElementById(countgtype[i]+"_RB");
				 if(tmp_obj_RB==null) continue;
				 //tmp_obj_RB.innerHTML=eval("top.str_order_"+countgtype[i]) + "("+recordHash[countgtype[i]+"_RB"]+")";
				 tmp_obj_RB.innerHTML=recordHash[countgtype[i]+"_RB"];

				 //該球類沒有滾球隱藏
				 var tmp_obj_div=document.getElementById(countgtype[i]+"_div_rb");
				 if(recordHash[countgtype[i]+"_RB"]*1==0){
				 tmp_obj_div.style.display="none";
				 }else{
				 tmp_obj_div.style.display="";
				 }
				 */
			}
			//alert("today_RB=="+today_RB);
			//今日沒有滾球賽程,整個MENU隱藏
			/*
			 if (today_RB > 0) {
			 document.getElementById('euro_open').style.display="";
			 }else{

			 document.getElementById('euro_open').style.display="none";
			 }
			 */

		}

	}

	function showRB(gtypeFT){
		var protocol = document.location.protocol;
		if(recordHash[gtypeFT+"_RB"]*1==0){
			//alert(top.no_oly);
			return;
		}
		top.hot_game="";
		top.select_showtype="FT";
		parent.header.location.href=protocol+"//"+document.domain+"/app/member/"+gtypeFT+"_header.php?uid="+top.uid+"&showtype=&langx="+top.langx+"&mtype="+top.mtype;
		parent.body.location.href=protocol+"//"+document.domain+"/app/member/"+gtypeFT+"_browse/index.php?rtype=re&uid="+top.uid+"&langx="+top.langx+"&mtype="+top.mtype+"&showtype="+top.showtype+"&hot_game="+top.hot_game;
		chg_button_bg(gtypeFT,"rb");
	}

	function showHotRB(gtypeFT){
		var protocol = document.location.protocol;
		if(recordHash[gtypeFT+"_HOT_RB"]*1==0){
			//alert(top.no_oly);
			return;
		}
		top.hot_game="HOT_";
		//top.select_showtype="FT";
		parent.header.location.href=protocol+"//"+document.domain+"/app/member/"+gtypeFT+"_header.php?uid="+top.uid+"&showtype=&langx="+top.langx+"&mtype="+top.mtype;
		parent.body.location.href=protocol+"//"+document.domain+"/app/member/"+gtypeFT+"_browse/index.php?rtype=re&uid="+top.uid+"&langx="+top.langx+"&mtype="+top.mtype+"&showtype="+top.showtype+"&hot_game="+top.hot_game;
		chg_button_bg(gtypeFT,"rb");
	}

	function showHotFT(gtypeFT){
		var protocol = document.location.protocol;
		if(recordHash[gtypeFT+"_HOT_FT"]*1==0){
			//alert(top.no_oly);
			return;
		}
		top.hot_game="HOT_";
		parent.header.location.href=protocol+"//"+document.domain+"/app/member/"+gtypeFT+"_header.php?uid="+top.uid+"&showtype=&langx="+top.langx+"&mtype="+top.mtype;
		parent.body.location.href=protocol+"//"+document.domain+"/app/member/"+gtypeFT+"_browse/index.php?rtype=r&uid="+top.uid+"&langx="+top.langx+"&mtype="+top.mtype+"&showtype="+top.showtype+"&hot_game="+top.hot_game;
		chg_button_bg(gtypeFT,"today");
	}

	function showHotFU(gtypeFU){
		var protocol = document.location.protocol;
		if(recordHash[gtypeFU+"_HOT_FU"]*1==0){
			//alert(top.no_oly);
			return;
		}
		top.hot_game="HOT_";
		parent.header.location.href=protocol+"//"+document.domain+"/app/member/"+gtypeFU+"_header.php?uid="+top.uid+"&showtype=future&langx="+top.langx+"&mtype="+top.mtype;
		parent.body.location.href=protocol+"//"+document.domain+"/app/member/"+gtypeFU+"_future/index.php?rtype=r&uid="+top.uid+"&langx="+top.langx+"&mtype="+top.mtype+"&showtype=future&hot_game="+top.hot_game+"&g_date=ALL";
		chg_button_bg(gtypeFU,"early");
	}

	function Eurover(act){
		if(act.className=="hot_btn"){
			act.className='hot_up';
		}else if(act.className=="early_btn"){
			act.className='early_up';
		}else if(act.className=="rb_btn"){
			act.className='rb_up';
		}
	}

	function Eurout(act){
		if(act.className=="hot_up"){
			act.className='hot_btn';
		}else if(act.className=="early_up"){
			act.className='early_btn';
		}else if(act.className=="rb_up"){
			act.className='rb_btn';
		}
	}

	var recordHash=new Array();
	function getCountHOT(countHOT){
		////trace("getCountHOT: "+countHOT);

		this.countHOT = countHOT;
		//alert("getCountHOT==>"+countHOT);
		var countgtype =new Array("FT","BK","TN","VB","BM","TT","BS","OP");
		var countgames=countHOT.split(",");
		for( var i=0;i<countgames.length;i++){
			var detailgame=countgames[i].split("|");
			recordHash[detailgame[0]+"_"+detailgame[1]]=detailgame[2]*1;
		}

		if(isHot_game){
			if((recordHash["FT_HOT_RB"]*1 + recordHash["FT_HOT_FT"]*1 + recordHash["FT_HOT_FU"]*1) >= 1){
				//document.getElementById("euro_menu_all").style.display = "";
				document.getElementById("HOT_rb").innerHTML = "("+recordHash["FT_HOT_RB"]+")";
				document.getElementById("HOT_today").innerHTML = "("+recordHash["FT_HOT_FT"]+")";
				document.getElementById("HOT_early").innerHTML = "("+recordHash["FT_HOT_FU"]+")";
			}else{
				//document.getElementById("euro_menu_all").style.display = "none";
			}
		}
		return showHOT();
	}

	function goRB(){
		document.getElementById('RB_btn').className="rb_over";
		//document.getElementById('today_btn').className="hot_btn";
		//document.getElementById('early_btn').className="early_btn";
		document.getElementById('RB_oly').style.display="";
		//document.getElementById('today_oly').style.display="none";
		//document.getElementById('early_oly').style.display="none";
	}

	function goHOT_FT(){
		document.getElementById('RB_btn').className="rb_btn";
		document.getElementById('today_btn').className="hot_over";
		document.getElementById('early_btn').className="early_btn";
		document.getElementById('RB_oly').style.display="none";
		document.getElementById('today_oly').style.display="";
		document.getElementById('early_oly').style.display="none";
	}

	function goHOT_FU(){
		document.getElementById('RB_btn').className="rb_btn";
		document.getElementById('today_btn').className="hot_btn";
		document.getElementById('early_btn').className="early_over";
		document.getElementById('RB_oly').style.display="none";
		document.getElementById('today_oly').style.display="none";
		document.getElementById('early_oly').style.display="";
	}
	//FT_today,FT_rb,FT_early
	function goEuro_HOT(types){

		var ary = types.split("_");
		var tmpGtype = ary[0];
		var tmpTypes = ary[1];
		var langx = "";


		switch(tmpTypes){
			case "rb":
				if(recordHash[tmpGtype+"_HOT_RB"]*1==0){
					//alert(top.no_oly);
					return;
				}
				showHotRB(tmpGtype);
				break;
			case "today":
				if(recordHash[tmpGtype+"_HOT_FT"]*1==0){
					//alert(top.no_oly);
					return;
				}
				showHotFT(tmpGtype);
				break;
			case "early":
				if(recordHash[tmpGtype+"_HOT_FU"]*1==0){
					//alert(top.no_oly);
					return;
				}
				showHotFU(tmpGtype);
				break;
			default:
				break;
		}
		goEuro_HOT_btn(types);
	}


	function goEuro_HOT_btn(types){


		var langx = "";

		switch(top.langx){
			case "zh-tw":
				langx = "tw";
				break;
			case "zh-cn":
				langx = "cn";
				break;
			case "en-us":
				langx = "en";
				break;
			default:
				langx = "en";
				break;
		}

		document.getElementById('HOT_rb_btn').className = "rb_left_"+langx+"_out";
		document.getElementById('HOT_today_btn').className = "hot_left_"+langx+"_out";
		document.getElementById('HOT_early_btn').className = "early_left_"+langx+"_out";
		///alert(top.hot_game);
		if(top.hot_game==""||types=="") return;

		var ary = types.split("_");
		var tmpGtype = ary[0];
		var tmpTypes = ary[1];

		switch(tmpTypes){
			case "rb":
				document.getElementById('HOT_rb_btn').className = "rb_left_"+langx+"_on";
				break;
			case "today":
				document.getElementById('HOT_today_btn').className = "hot_left_"+langx+"_on";
				break;
			case "early":
				document.getElementById('HOT_early_btn').className = "early_left_"+langx+"_on";
				break;
			default:
				break;
		}
	}

	/* 滾球提示--程式一開始值呼叫reloadRb,setInterval函式 多久會呼叫reloadRB函數預設 1分鐘 */
	function SetRB(gttype,uid){
		//alert("setRB=>"+top.uid);
		//parent.display_loading(true);
		reloadRB(gttype,top.uid,false);
		setInterval("reloadRB('"+gttype+"','"+top.uid+"',false)",60*1000);
	}

	/*滾球提示--將值帶進去去開啟getrecRB.php程式,去抓取伺服器是否有滾球賽程*/
	var record_RB = 0;
	function reloadRB(gtype,uid,types){
		isChgType = types;
		reloadPHP.location.href="/app/member/getrecRB.php?gtype="+gtype+"&uid="+top.uid+"&langx="+top.langx;
		//if(menuType != "mybets")	loadData();
	}

	function transShowType(type){
		var hash = new Object();
		hash["today"] = "FT";
		hash["early"] = "FU";
		hash["parlay"] = "P3";
		hash["inplay"] = "RB";
		hash["FT"] = "today";
		hash["FU"] = "early";
		hash["P3"] = "parlay";
		hash["RB"] = "inplay";
		return hash[type]||type;
	}

	function GameCount(games, hot_sp){

		info("GameCount====>"+games+","+hot_sp);
		gameData = games;
		var countgtype = gtypeAry;
		var countgames=games.split(",");
		var recordHash=new Array();
		recordHash["DATE"]=countgames[0];

		try{
			parent.setTimeStart(recordHash["DATE"]);
		}catch(e){
			top.init_date = recordHash["DATE"];
			top.load_order = true;
		}

		recordHash["RB"]=0;
		for( var i=1;i<countgames.length;i++){
			var detailgame=countgames[i].split("|");
			recordHash[detailgame[0]+"_"+detailgame[1]]=detailgame[2]*1;
		}

		//parse hot game and sp game
		parseHotSPGame(recordHash, hot_sp);

		//alert("nowShowRB=="+nowShowRB);
		try{
			var RB_idstr="";
			var RB_countstr="";
			var RB_count = 0;
			var FT_count = 0;
			for( var i=0;i<countgtype.length;i++){
				var gtype = countgtype[i];
				//console.log(gtype);
				RB_idstr="RB_"+countgtype[i];
				RB_countstr="RB_"+countgtype[i]+"_games";
				//滾球場次計算
				var g_count = recordHash[countgtype[i]+"_RB"]*1;
				RB_count+=g_count;
				var dis = (g_count>0)?"":"none";
				document.getElementById('RB_'+gtype+'_games').innerHTML = g_count;
				document.getElementById(gtype+'_div_rb').style.display = dis;


				//今日,早餐 場次計算
				g_count = recordHash[gtype+"_"+transShowType(top.select_showtype)]*1;
				if(top.select_showtype=="today" || top.select_showtype=="early"){
					g_count += recordHash["FS_"+gtype]*1;
				}
				FT_count+=g_count;
				//trace(top.select_showtype+","+transShowType(top.select_showtype)+","+gtype+"_"+transShowType(top.select_showtype)+","+g_count);
				dis = (g_count>0)?"":"none";
				document.getElementById(gtype+'_games').innerHTML = g_count;
				document.getElementById(gtype+'_games').style.display = "";
				document.getElementById("title_"+gtype).style.display = dis;

				if(top.select_showtype == "parlay"){
					document.getElementById("wager_"+gtype).style.display = "none";
				}else{
					dis = (g_count>0 && top.select_gtype==gtype && !nowShowRB && !nowShowHot)?"":"none";
					document.getElementById("wager_"+gtype).style.display = dis;
				}
			}

			//沒賽事少跑一次body_var() 多補上一次收loading joe 160104
			/*if(FT_count==0) {
			 parent.display_loading(false);
			 parent.display_loadingMain("body");
			 }*/
			//是否有滾球顯示
			document.getElementById("div_rb").style.display = (RB_count>0)?"":"none";
			document.getElementById("RB_nodata").style.display = (RB_count>0)?"none":"";

			//重整後精選賽事還是要亮色 2016-05-05	William
			if(nowShowHot){
				if(top.hot_game == "SP_"){
					util.setObjectClass(document.getElementById("sp_game_"+top.hot_gtype),"noFloat On");
				}else if(top.hot_game == "HOT_"){
					util.setObjectClass(document.getElementById("hot_game_"+top.hot_gtype),"On");
				}
			}
			//document.getElementById("FT_nodata").style.display = (FT_count>0)?"none":"";
			//今日,早餐沒場次顯示
			for(i=0;i<showtypeAry.length;i++){
				if(showtypeAry[i]==top.select_showtype && FT_count<=0){
					document.getElementById("FT_"+showtypeAry[i]+"_nodata").style.display = "";
					document.getElementById("sportMenu_Today").style.display = "none";
				}
				else{
					document.getElementById("FT_"+showtypeAry[i]+"_nodata").style.display = "none";
					document.getElementById("sportMenu_Today").style.display = "";
				}
			}

		}catch(e){
			systemMsg(e.toString());
		}
		trace("isFirst====>"+isFirst);
		if(isFirst){
			var def = chooseDefTOG(recordHash);

			top.select_showtype = def[0];
			top.select_gtype = def[1];
			trace("top.select_showtype===>")
			chgShowType(top.select_showtype);
			initGtypeClass();
			var titleObj = document.getElementById("title_"+top.select_gtype);
			if(titleObj != null){
				var org_sty = util.getObjectClass(titleObj);
				util.setObjectClass(titleObj,org_sty.replace(/_off/gi,"_on"));
			}

			if(def[2] == "fs"){
				chgWtype("wtype_"+top.select_gtype+"_fs");
				chg_type("wtype_"+top.select_gtype+"_fs","");
			}

			isFirst = false;
		}


		today_count=recordHash[top.head_gtype+"_FT"];
		early_count=recordHash[top.head_gtype+"_FU"];
		//rb_count = recordHash[top.head_gtype+"_RB"];

		var today_RB=0;
		for( var i=0;i<countgtype.length;i++){
			today_RB +=recordHash[countgtype[i]+"_RB"];
		}

		if(isChgType){
			var wagerObj = document.getElementById("wager_"+top.select_gtype);
			if(top.select_showtype != "parlay"){
				if(wagerObj != null){
					if(wagerObj.style.display == "")	chg_type(wagerObj.getAttribute("select"),"");
				}
			}else{
				wagerObj.style.display = "none";
				var rtype = (top.select_gtype == "BS")?"pr":"p3";
				chg_type("wtype_"+top.select_gtype+"_"+rtype);
			}
		}
		try{
			parent.display_loadingMain("order");
			parent.reloadCrditFunction();
		}catch(e){

		}
	}
	function Go_RB_page(gtypeFT){
		if(recordHash[gtypeFT+"_RB"]*1==0){
			//alert(top.no_oly);
			return;
		}
		top.hot_game="";
		top.head_FU="FT";
		parent.body.location.href="http://"+document.domain+"/app/member/"+gtypeFT+"_browse/index.php?rtype=re&uid="+top.uid+"&langx="+top.langx+"&mtype="+top.mtype;
	}
	function Go_RB_page1(RBgtype, loadFun){
		//trace("Go_RB_page=====>"+RBgtype);
		//清過關點賠率亮色 2016.0119 joe
		top.head_FU = "FT";
		top.hot_gtype=""; //精選及特別重置狀態
		close_bet();
		top.select_gtype=RBgtype;
		//====================
		var protocol = document.location.protocol;
		top.hot_game="";
		top.RB_id="RB_"+RBgtype;
		nowShowRB = true;
		nowShowHot = false;
		//parent.display_loading(true);
		//2015-07-20 Peter 重置選取聯盟
		//reload_leg();
		//判斷若不為原過關球類，則隱藏過關串數title
		document.getElementById("show_parlay").style.display = "none";
		initGtypeClass();

		util.setObjectClass(document.getElementById("title_today"),"ord_memuBTN");
		util.setObjectClass(document.getElementById("title_early"),"ord_memuBTN");
		util.setObjectClass(document.getElementById("title_parlay"),"ord_memuBTN no_margin");
		var obj = document.getElementById(RBgtype+"_div_rb");
		if(obj != null){
			var org_sty = util.getObjectClass(obj);
			util.setObjectClass(obj,org_sty.replace(/_off/gi,"_on"));
		}

		var bodyObj = parent.document.getElementById("body");
		//parent.document.getElementById("body").contentWindow.document.body.onload=function(){
		//bodyObj.location.href=util.getNowDomain()+"/app/member/"+RBgtype+"_browse/index.php?rtype=re&uid="+top.uid+"&langx="+top.langx+"&mtype="+top.mtype+"&showtype="+top.showtype+"&hot_game="+top.hot_game;
		if(loadFun){
			iframe_onload(bodyObj, loadFun);
			top.tv_allbet = true;
		}else{
			top.tv_allbet = false;
		}

		//console.log("/app/member/"+RBgtype+"_browse/index.php?rtype=re&uid="+top.uid+"&langx="+top.langx+"&mtype="+top.mtype+"&showtype="+top.showtype+"&hot_game="+top.hot_game);
		iframe_src(bodyObj, util.getNowDomain()+"/app/member/"+RBgtype+"_browse/index.php?rtype=re&uid="+top.uid+"&langx="+top.langx+"&mtype="+top.mtype+"&showtype="+top.showtype+"&hot_game="+top.hot_game);
	}

	function chgWtype(_id){
		if(!_id) return;
		parent.display_loading(true);

		var tmp = _id.split("_");
		var gtype = tmp[1];

		top.pastType = top.cgTypebtn;
		top.cgTypebtn =  tmp[2];
		//top.select_gtype = gtype;

		var wObj = document.getElementById("wager_"+gtype);
		if(wObj==null) return;

		var lastObj = document.getElementById(wObj.getAttribute("select"));
		if(lastObj!=null) util.setObjectClass(lastObj,"");
		if(wObj.getAttribute("select") == "wtype_"+gtype+"_fs"){
			if(lastObj!=null) util.setObjectClass(lastObj,"no_margin");
		}

		var tagetObj = document.getElementById(_id);
		if(tagetObj!=null) util.setObjectClass(tagetObj,"On");
		if(_id == "wtype_"+gtype+"_fs"){
			if(tagetObj!=null) util.setObjectClass(tagetObj,"On no_margin");
		}

		wObj.setAttribute("select", _id);

	}

	function chg_type(a,b){
		parent.display_loading(true);

		top.RB_id="";
		top.hot_game="";
		if(top.swShowLoveI)b=3;
		if(top.showtype=='hgft')b=3;
		var hot_str="";
		if(top.head_gtype=="FT"){
			try{
				parent.mem_order.goEuro_HOT_btn("");
			}catch(E){}
		}


		var url = getWagerUrl(a, top.select_showtype);
		//加入hot_game參數值
		url += "&hot_game="+top.hot_game;
		//lid check
		if(b!=undefined) url += "&league_id="+b;
		//parent.body.location=a+"&league_id="+b+hot_str;

		parent.body.location = url;
	}

	function getWagerUrl(_id, showtype){
		var tmp = _id.split("_");
		//showtype = top.select_showtype;
		gtype = tmp[1];
		rtype = tmp[2];

		// 2017-04-06 3063>>(1)精選&特殊盤面-一登入直接看這二個盤面的  會都沒有分頁，要去選過單式的早餐&過關後才會又正常
		top.select_showtype = showtype;

		var doc = (showtype=="early")?"future":"browse";
		if(gtype=="BK"&&rtype=="r") rtype="all";
		if(gtype=="BS"&&showtype=="parlay") rtype=rtype.replace("p3","pr");

		var base_url = util.getNowDomain()+"/app/member/";
		var url = base_url+gtype+"_"+doc+"/index.php?rtype="+rtype+"&uid="+top.uid+"&langx="+top.langx+"&mtype="+top.mtype+"&showtype="+top.showtype+"&hot_game="+top.hot_game;

		if(rtype=="fs"){
			url = base_url+"browse_FS/loadgame_R.php?uid="+top.uid+"&langx="+top.langx+"&FStype="+gtype+"&mtype="+top.mtype;
		}
		info("getWagerUrl=====>"+_id+","+showtype+","+url);


		return url;

	}

	function chgShowType(type){
		//trace("chgShowType =>"+type);
		top.hot_gtype=""; //精選及特別重置狀態
		if(type == "early")
			top.head_FU = "FU";
		else
			top.head_FU = "FT";
		var ary = ","+showtypeAry.join(",")+",";
		if(ary.indexOf(","+type+",")==-1) return;
		//清過關點賠率亮色 2016.0119 joe
		if(type!="parlay"){
			close_bet();
		}
		//====================
		//判斷若不為原過關球類，則隱藏過關串數title		p.s	若是在過關點"過關"，且剛好該球類沒賽事，會沒收掉
		if(top.count_parlay > 0 && type == "parlay" && top.betGtype == top.select_gtype){
			document.getElementById("show_parlay").style.display = "";
		}
		else{
			document.getElementById("show_parlay").style.display = "none";
		}

		if(nowShowRB){
			initGtypeClass();

			top.select_gtype = "FT";

			var titleObj = document.getElementById("title_"+top.select_gtype);
			if(titleObj != null){
				var org_sty = util.getObjectClass(titleObj);
				util.setObjectClass(titleObj,org_sty.replace(/_off/gi,"_on"));
			}
		}

		top.select_showtype = type;
		nowShowRB = false;
		nowShowHot = false;
		util.setObjectClass(document.getElementById("title_today"),"ord_memuBTN");
		util.setObjectClass(document.getElementById("title_early"),"ord_memuBTN");
		util.setObjectClass(document.getElementById("title_parlay"),"ord_memuBTN no_margin");

		var sty = util.getObjectClass(document.getElementById("title_"+type));
		var new_sty = sty.replace("ord_memuBTN","ord_memuBTN_on");
		util.setObjectClass(document.getElementById("title_"+type),new_sty);
		//GameCount(gameData);
		reloadRB(top.select_gtype, top.uid,true);
	}

	function chg_type_class(game_type){
		parent.display_loading(true);
//已選取：黃字 class="type_on"
//選取後離開：白字 class="type_out"
		try{

			var obj_laster= document.getElementById(top.cgTypebtn+"");
			//  alert("111>>>>>>>>"+obj.className);
			obj_laster.className="type_out";

			var obj= document.getElementById(game_type+"");
			obj.className="type_on";

			//2015-07-23 Peter 重置選取聯盟
			//console.log(top.cgTypebtn+"  "+game_type);
			/*if((top.cgTypebtn == "hp3_class" || top.cgTypebtn == "hpa_class"
			 || game_type == "hp3_class" || game_type == "hpa_class"
			 || (top.pastType != "fs_class" && game_type == "fs_class"))){
			 //console.log("enter");
			 reload_leg(game_type);
			 }*/
			top.pastType = top.cgTypebtn;
			top.cgTypebtn=game_type;
		}catch(E){}
	}

	function chg_index(a,b,c,d){
		top.RB_id="";
		top.hot_game="";
		top.swShowLoveI=false;
		top.cgTypebtn="re_class";

		var hot_str="";
		if(top.head_gtype=="FT"){
			try{
				parent.mem_order.goEuro_HOT_btn("");
			}catch(E){}
		}
		hot_str="&hot_game="+top.hot_game;

		//2015-07-23 Peter 重置選取聯盟
		//reload_leg();

		parent.body.location.href=b+"&league_id="+c+hot_str;
		//self.location.href=a;
	}
	var isViewMyBet = false;
	function showMenu(type,isTV){
		try{
			_set["bet_order_frame_window"]=document.getElementById("bet_order_frame").contentWindow;
			var orderObj=_set["bet_order_frame_window"];
			_set["rec_frame_window"]=document.getElementById("rec_frame").contentWindow;
			var recObj=_set["rec_frame_window"];
		}catch(err){
			//console.log(err);
		}

		// if(type!="betslip"&&top.count_parlay==0){
		if(type!="betslip"){
			try{
				orderObj.clearAlltimer();
				if(type=="mybets"){
					recObj.onloadDanger();
				}
			}catch(e){}
		}else{

			try{
				orderObj.resetTimer();
			}catch(e){
				//console.log(e);
			}



			// 2017-05-12 PMO-51 危險球狀態字樣改變+十秒自動更新注單狀況
			try{
				recObj.clearAlltimer();
			}catch(e){
				//console.log(e);
			}

			try{
				if(orderObj.dangerTimer){ // 代表在完成單
					orderObj.onloadDanger();
				}
			}catch(err){
				//console.log(err);
			}

		}


		//trace("showMenu: "+type);
		menuType = type;

		//parent.document.getElementById("loadingL").style.display = "";
		var ary = new Array("div_menu","div_betslip","div_mybets");

		for(var i=0; i<ary.length; i++){
			var divname = ary[i];
			var dis = "none";

			if(divname=="div_"+type) dis="";
			document.getElementById(divname).style.display = dis;

		}
		chgMenuStatus(type);
		//trace(type+" "+top.open_bet+" "+top.rtype);
		if(type == "mybets"){
			//setMyBetCount(0);
			showRec();
			isViewMyBet = true;
		}else{
			if(isViewMyBet){
				loadMyBet();
				isViewMyBet = false;
			}
			//loadData();
		}
		if(type == "betslip"){
			if(top.open_bet == ""){
				document.getElementById("SIN_BET").style.display = (top.rtype == "p3" || top.rtype == "pr")?"none":"";
				document.getElementById("PAR_BET").style.display = (top.rtype == "p3" || top.rtype == "pr")?"":"none";
			}
			else{
				document.getElementById("SIN_BET").style.display = "none";
				document.getElementById("PAR_BET").style.display = "none";
			}
		}else if(type == "menu"){
			if(document.all)
				document.getElementById("count_parlay").innerText = top.count_parlay;
			else
				document.getElementById("count_parlay").textContent = top.count_parlay;
			if(top.count_parlay > 0 && top.select_showtype == "parlay" && top.betGtype == top.select_gtype){
				document.getElementById("show_parlay").style.display = "";
			}
			else{
				document.getElementById("show_parlay").style.display = "none";
			}
		}
		if(isTV){
			window.focus();
			alert(top.goodmybets);
		}
	}

	function chgMenuStatus(type){
		////trace("chgMenuStatus: "+type);

		var hash = new Object();
		hash["title_menu"] = "ord_memuBTN";
		hash["title_betslip"] = "ord_memuBTN";
		hash["title_mybets"] = "ord_memuBTN no_margin";

		for(var divname in hash){
			var obj = document.getElementById(divname);
			var css = (divname=="title_"+type)?hash[divname].replace("ord_memuBTN","ord_memuBTN_on"):hash[divname];
			util.setObjectClass(obj,css);
		}

	}

	function chgTitle(gtype){
		top.hot_gtype=""; //精選及特別重置狀態
		//trace("chgTitle: "+gtype);
		/*
		 if(top.select_gtype==gtype){
		 if(top.select_showtype!="parlay"){
		 var obj = document.getElementById("wager_"+gtype);
		 obj.style.display = (obj.style.display=="")?"none":"";
		 }
		 return;
		 }
		 */
		////trace("=====>document.all.teamcount.value"+parent.document.all.teamcount.value);
		//判斷若不為原過關球類，則隱藏過關串數title
		if(top.count_parlay > 0 && top.select_showtype == "parlay" && top.betGtype == gtype ){
			document.getElementById("show_parlay").style.display = "";
		}
		else{
			document.getElementById("show_parlay").style.display = "none";
		}
		initGtypeClass();

		var sty = util.getObjectClass(document.getElementById("title_"+top.select_showtype));
		sty = sty.replace("ord_memuBTN_on","ord_memuBTN");
		var new_sty = sty.replace("ord_memuBTN","ord_memuBTN_on");
		util.setObjectClass(document.getElementById("title_"+top.select_showtype),new_sty);

		var titleObj = document.getElementById("title_"+gtype);
		if(titleObj != null){
			var org_sty = util.getObjectClass(titleObj);
			util.setObjectClass(titleObj,org_sty.replace(/_off/gi,"_on"));
		}

		if(top.select_showtype != "parlay"){
			var wagerObj = document.getElementById("wager_"+gtype);
			if(wagerObj != null){
				wagerObj.style.display = "";
				chg_type(wagerObj.getAttribute("select"),"");
			}
		}else{
			var rtype = (gtype == "BS")?"pr":"p3";
			chg_type("wtype_"+gtype+"_"+rtype);
		}

		top.select_gtype = gtype;
		nowShowRB = false;
		nowShowHot = false;
	}
	function linkToshowMenu(type){

		showMenu(type,true);
		//window.focus();
		//alert(top.goodmybets);

	}
	//TV link to allbets
	// 2017-02-21 283.info & UAT & 線上-右邊tv & 另彈tv-足球-點所有玩法，盤面會loading
	function linkToAllbets(gtype, gid ,isOpen, imp, ptype){
		//Go_RB_page會清掉top.lastidName所以保留起來
		if(isOpen)
		{
			if(gtype!=""&&gid!=""){
				Go_RB_page(gtype , function(){
					//goLinkAllbets(gid ,isOpen);
					goLinkAllbets(gid ,isOpen, imp, ptype);
				});
			}
		}
		else
		{
			if(top.lastidName != "")
			{
				var lastidName = top.lastidName;
			}
			if(gtype!=""&&gid!=""){
				Go_RB_page(gtype , function(){
					//goLinkAllbets(gid ,isOpen);
					goLinkAllbets(gid ,isOpen, imp, ptype);
				});
				top.lastidName = lastidName;
			}
		}
	}

	function goLinkAllbets(gid , isOpen, imp, ptype){
		//trace("goLinkAllbets===>"+gid);
		try{
			var bodyObj = parent.document.getElementById("body");
			iframe_onload(bodyObj, null);
			bodyObj.contentWindow.show_allbets(gid+"",'','','', imp, ptype);

		}catch(e){
			systemMsg(e.toString());
		}
		window.focus();
		if(isOpen)	alert(top.goAllbets);//只有另開視窗的需要提醒
	}


	function initGtypeClass(){
		//特別賽事
		var SPObj=document.getElementById("sp_game");
		if(SPObj.style.display != "none")
		{
			util.setObjectClass(document.getElementById("sp_game_RB"),"noFloat");
			util.setObjectClass(document.getElementById("sp_game_FT"),"noFloat");
			util.setObjectClass(document.getElementById("sp_game_FU"),"noFloat");
			util.setObjectClass(document.getElementById("sp_game_P3"),"noFloat");
			util.setObjectClass(document.getElementById("sp_game_FS"),"noFloat");
		}

		for(var i=0; i<gtypeAry.length; i++){
			var _gtype = gtypeAry[i];

			//精選賽事
			var HotObj=document.getElementById("hot_div_"+_gtype);
			if(HotObj != null)
			{
				util.setObjectClass(document.getElementById("hot_game_RB_"+_gtype),"");
				util.setObjectClass(document.getElementById("hot_game_FT_"+_gtype),"");
				util.setObjectClass(document.getElementById("hot_game_FU_"+_gtype),"");
				util.setObjectClass(document.getElementById("hot_game_P3_"+_gtype),"");
				util.setObjectClass(document.getElementById("hot_game_FS_"+_gtype),"");
			}

			//今日早盤過關
			var wObj = document.getElementById("wager_"+_gtype);

			if(wObj != null)	wObj.style.display="none";

			try{
				var tObj = document.getElementById("title_"+_gtype);
				var org_sty = util.getObjectClass(tObj);
				util.setObjectClass(tObj,org_sty.replace(/_on/gi,"_off"));
			}catch(e){}
			//滾球
			var obj = document.getElementById(_gtype+"_div_rb");
			if(obj != null){
				var org_sty = util.getObjectClass(obj);
				util.setObjectClass(obj,org_sty.replace(/_on/gi,"_off"));
			}
		}
	}

	function chooseDefTOG(recordHash){
		var types = new Array("today","early");
		var out = new Array("today","FT","r");
		var isDone = false;

		for(var i=0; i<gtypeAry.length; i++){
			var _gtype = gtypeAry[i];

			for(var j=0; j<types.length; j++){
				if(recordHash[_gtype+"_"+transShowType(types[j])]*1 != 0){
					isDone = true;
					out[0] = types[j];
					out[1] = _gtype;
					break;
				}

				if(recordHash["FS_"+_gtype]*1 != 0){
					isDone = true;
					out[0] = types[j];
					out[1] = _gtype;
					out[2] = "fs";
					break;
				}
			}

			if(isDone)	break;
		}

		return out;
	}



	//============= hot game and sp game =============
	function showHotDiv(gtype){
		info("showHotDiv===>"+gtype);

		var showObj = document.getElementById("hot_div_"+gtype);
		var arrowObj = document.getElementById("arrow_"+gtype);
		var org_sty = util.getObjectClass(arrowObj);
		var new_sty = org_sty;
		var dis = "";
		var on = "_on";
		var sw = false;
		new_sty = new_sty.replace(on,"");

		if(disHash["HOT_"+gtype]){ //off
			dis = "none";
			sw = false;
		}else{ //on
			new_sty+=on;
			dis = "";
			sw = true;
		}

		disHash["HOT_"+gtype] = sw;
		util.setObjectClass(arrowObj, new_sty);
		showObj.style.display = dis;
		//最後一筆有打開要換class 橘子要求 20160121 joe
		if(gtype==maxHash.gtype){
			document.getElementById("hot_show").className=(dis=="")? "ord_sportMenu_high2":"ord_sportMenu_high";
		}
	}

	function goToSPGame(_type, gtype){
		top.RB_id = "";
		nowShowHot = true;
		nowShowRB = false;
		parent.display_loading(true);
		info("goToSPGame===>"+_type+","+gtype);
		top.hot_game = "SP_";
		top.hot_gtype = _type;
		goToGame(_type, gtype);
		//選到要亮色
		util.setObjectClass(document.getElementById("sp_game_"+_type),"noFloat On");
	}

	function goToHotGame(_type, gtype){
		top.RB_id = "";
		nowShowHot = true;
		nowShowRB = false;
		parent.display_loading(true);
		info("goToHotGame===>"+_type+","+gtype);
		top.hot_game = "HOT_";
		top.hot_gtype = _type+"_"+gtype;
		goToGame(_type, gtype);
		//選到要亮色
		util.setObjectClass(document.getElementById("hot_game_"+_type+"_"+gtype),"On");
	}

	function goToGame(_type, gtype){
		info("goToGame===>"+_type+","+gtype);

		initGtypeClass();
		var hash = new Object();
		hash["RB"] = util.getNowDomain()+"/app/member/"+gtype+"_browse/index.php?rtype=re&uid="+top.uid+"&langx="+top.langx+"&mtype="+top.mtype+"&showtype="+top.showtype+"&hot_game="+top.hot_game;
		hash["FT"] = getWagerUrl("wtype_"+gtype+"_r", "today");
		hash["FU"] = getWagerUrl("wtype_"+gtype+"_r", "early");
		hash["P3"] = getWagerUrl("wtype_"+gtype+"_p3", "parlay");
		hash["FS"] = getWagerUrl("wtype_"+gtype+"_fs", "early");

		var url = hash[_type];
		info("url===>"+url);

		if(url!=null){
			var bodyObj = parent.document.getElementById("body");
			iframe_src(bodyObj, url);
		}
	}

	function parseHotSPGame(_hash, hot_sp){
		//info("parseHotSPGame===>"+hot_sp);
		//info(_hash);

		if(hot_sp==null) return;
		var code = hot_sp.split(",");
		//311,HOT球類1|HOT球類1主標題|HOT球類1副標題|HOT球類1排序@HOT球類2|HOT球類2主標題|HOT球類2副標題|HOT球類2排序@...,SP球類1|SP球類1主標題|SP球類1副標題|SP球類1排序,5,1
		//311,NODATA,NODATA

		var hot_limit = code[3]*1;
		var sp_limit = code[4]*1;
		var no_data = "NODATA";

		if(code[0]=="311"){
			var hot_game = document.getElementById("hot_game");
			var sp_game = document.getElementById("sp_game");
			var ary = new Array("RB","FT","FU","P3","FS");

			for(var j=0; j<gtypeAry.length; j++){ //util
				var g = gtypeAry[j];
				_hash[g+"_HOT_FS"] = _hash["FS_HOT_"+g];
				_hash[g+"_SP_FS"] = _hash["FS_SP_"+g];

				if(code[1].indexOf(g)==-1){
					disHash["HOT_"+g] = false;
				}
			}




			//hot game
			if(code[1].toUpperCase()!=no_data){
				var tmp_g = code[1].split("@");
				var hot_show = document.getElementById("hot_show");

				var shotHash = new Object();
				var tmpScreen = "";

				//sort data
				for(i=0; i<tmp_g.length; i++){
					var tmp = tmp_g[i].split("|");
					var _gtype = tmp[0];
					var _title = tmp[1];
					var _sub = tmp[2];
					var _sort = tmp[3];

					//info("sort==>"+_sort+",hot_limit==>"+hot_limit);
					if(_sort*1 < 1||_sort*1 > hot_limit){
						continue;
					}

					if(shotHash[_sort]==null){
						shotHash[_sort] = new Object();
					}

					shotHash[_sort].gtype = _gtype;
					shotHash[_sort]._title = _title;
					shotHash[_sort]._sub = _sub;
				}

				//info(shotHash);

				var hot_obj = document.getElementById("hot_model");


				//parse data
				for(var _sort in shotHash){
					if(_sort=="0") continue;
					maxHash=_sort;
					var gtype = shotHash[_sort].gtype;
					var _title = shotHash[_sort]._title;
					var _sub = shotHash[_sort]._sub;

					var hot_model="";
					//trace("hot_obj====>"+hot_obj);
					if(hot_obj.tagName==null) {
						return;
					}else{
						hot_model=hot_obj.innerHTML;
					}
					var total = 0;

					for(i=0; i<ary.length; i++){
						var type = ary[i];
						var n = _hash[gtype+"_HOT_"+type]*1;
						//info("_hash["+gtype+"_HOT_"+type+"]===>"+n);

						var cou = new RegExp("\\*"+type+"_COUNT\\*","gi");
						var dis = new RegExp("\\*"+type+"_DISPLAY\\*","gi");
						var arrow = (disHash["HOT_"+gtype])?"ord_sportArr_on":"ord_sportArr";
						var class_g = (gtype=="OP")?"OT":gtype;
						if(hot_model!=null){
							hot_model = hot_model.replace(/\*GTYPE\*/gi, gtype);
							hot_model = hot_model.replace(/\*GTYPE_STYLE\*/gi, "class='ord_sport"+class_g+"_high noFloat'");
							hot_model = hot_model.replace(/\*GTYPE_NAME\*/gi, (gtype=="OP"&&_title!="")?_title:top["str_order_"+gtype]);
							hot_model = hot_model.replace(/\*GAME_NAME\*/gi, _sub);
							hot_model = hot_model.replace(/\*ARROW_CLASS\*/gi, "class='"+arrow+"'");
							hot_model = hot_model.replace(/\*DIV_DISPLAY\*/gi, (disHash["HOT_"+gtype])?"":"style='display:none'");
							hot_model = hot_model.replace(cou, util.showTxt(n));
							hot_model = hot_model.replace(dis, (n==0)?"style='display:none'":"");
						}

						total+=n;

					}
					if(total>0) tmpScreen+=hot_model;
				}
				maxHash=shotHash[maxHash];//取最後一筆精選賽事
				if(tmpScreen!=""){
					hot_show.innerHTML = tmpScreen;
					hot_game.style.display = "";
				}
			}else{
				hot_game.style.display = "none";
			}





			//sp game
			if(code[2].toUpperCase()!=no_data){

				var tmp = code[2].split("|");
				var gtype = tmp[0];
				var _title = tmp[1];
				var _sub = tmp[2];
				//var _sort = tmp[3];
				var sp_show = document.getElementById("sp_show");
				var sp_name = document.getElementById("sp_name");
				var sp_model = document.getElementById("sp_model").innerHTML;
				var count = 0;

				for(i=0; i<ary.length; i++){
					var type = ary[i];
					var n = _hash[gtype+"_SP_"+type];
					//info("_hash["+gtype+"_SP_"+type+"]===>"+n);

					var cou = new RegExp("\\*"+type+"_COUNT\\*","gi");
					var dis = new RegExp("\\*"+type+"_DISPLAY\\*","gi");

					sp_model = sp_model.replace(/\*GTYPE\*/gi, gtype);
					sp_model = sp_model.replace(cou, util.showTxt(n));
					sp_model = sp_model.replace(dis, (n==0)?"style='display:none'":"");
					count+=n;
				}

				//info("count===>"+count);

				//no data
				if(count==0){
					sp_game.style.display = "none";
					return;
				}


				sp_show.innerHTML = sp_model;
				sp_name.innerHTML = util.showTxt(_sub);
				sp_game.style.display = "";

			}else{
				sp_game.style.display = "none";
			}

		}


	}
	var nowScrollTop = "";
	function udScrollTop()
	{

		nowScrollTop = document.getElementById("div_ord_main").scrollTop;
		//trace("order udScrollTop===>"+nowScrollTop);

	}

	function getscrollTop()
	{
		//trace("order getscrollTop===>"+nowScrollTop);
		//var sctop = document.getElementById("div_ord_main").scrollTop;
		return nowScrollTop;
	}
	//============= hot game and sp game =============
	function info(msg){
		//	console.info(msg);
	}

	function systemMsg(msg){
		util.systemMsg("[order.js]"+msg);
	}

	function trace(msg){
		util.trace("[order.js]"+msg);
	}

</script>

<!--	<script src="/js/XmlNode.js"></script>-->
<!--	<script src="/js/HttpRequestXML.js"></script>-->
<script>
	gamedate = '';
	var GameData = new Array();
	var msg='';
	var mtype='2';
	var mem_enable='Y';
	var countHOT= '' ;
	var checkRoute='Y';
	var countMessage='';
</script>
<script>
	top.uid = "<?=$uid?>";
	top.langx = "<?=$langx?>";
	top.liveid = ''
	top.casino = 'SI2';
	top.mtype = "<?=$mtype?>";
	top.autoOddCheck = (''+top.autoOddCheck!='undefined')?top.autoOddCheck:true;
</script>

<body onLoad="bodyLoad();">
<div class="ord_main" id="div_ord_main">
	<div class="ord_memu">
		<span id="title_menu" onClick="showMenu('menu')" class="ord_memuBTN_on"><?=$muluo?></span>
		<span id="title_betslip" onClick="showMenu('betslip')" class="ord_memuBTN"><?=$jiaoyidan?></span>
		<span id="title_mybets" onClick="showMenu('mybets')" class="ord_memuBTN no_margin"><?=$myzhudan?><span id="count_mybet" class="ord_msg">0</span></span>
	</div>

	<!--menu-->
	<div id="div_menu" name="div_menu" class="ord_DIV">
		<!--過關下注數-->
		<div id="show_parlay" class="ord_parlyG noFloat" onClick="showMenu('betslip')" style="display:none">
			<ul><li>Parlay Bet Slip</li></ul>
			<span id="count_parlay" class="ord_parlyNUM">0</span>
		</div>
		<!--滾球區-->
		<div id="euro_open" class="ord_sportMenu_InPlayG">
			<h1><?=$gunball?></h1>
			<div id="div_rb" class="ord_sportMenu_InPlay" style="display:none">
				<div id="FT_div_rb" style="display:none;" class="ord_sportFT_nor_off noFloat" onClick="Go_RB_page('FT');"><span class="ord_sportName"><?=$str_order_FT?></span><span id="RB_FT_games" class="ord_sportDigit">0</span></div>
				<div id="BK_div_rb" style="display:none;" class="ord_sportBK_nor_off noFloat" onClick="Go_RB_page('BK');"><span class="ord_sportName"><?=$str_order_BK?></span><span id="RB_BK_games" class="ord_sportDigit">0</span></div>
				<div id="TN_div_rb" style="display:none;" class="ord_sportTN_nor_off noFloat" onClick="Go_RB_page('TN');"><span class="ord_sportName"><?=$str_order_TN?></span><span id="RB_TN_games" class="ord_sportDigit">0</span></div>
				<div id="VB_div_rb" style="display:none;" class="ord_sportVB_nor_off noFloat" onClick="Go_RB_page('VB');"><span class="ord_sportName"><?=$str_order_VB?></span><span id="RB_VB_games" class="ord_sportDigit">0</span></div>
				<div id="BM_div_rb" style="display:none;" class="ord_sportBM_nor_off noFloat" onClick="Go_RB_page('BM');"><span class="ord_sportName"><?=$str_order_BM?></span><span id="RB_BM_games" class="ord_sportDigit">0</span></div>
				<div id="TT_div_rb" style="display:none;" class="ord_sportTT_nor_off noFloat" onClick="Go_RB_page('TT');"><span class="ord_sportName"><?=$str_order_TT?></span><span id="RB_TT_games" class="ord_sportDigit">0</span></div>
				<div id="BS_div_rb" style="display:none;" class="ord_sportBS_nor_off noFloat" onClick="Go_RB_page('BS');"><span class="ord_sportName"><?=$str_order_BS?></span><span id="RB_BS_games" class="ord_sportDigit">0</span></div>
				<div id="SK_div_rb" style="display:none;" class="ord_sportSK_nor_off noFloat" onClick="Go_RB_page('SK');"><span class="ord_sportName"><?=$str_order_SK?></span><span id="RB_SK_games" class="ord_sportDigit">0</span></div>
				<div id="OP_div_rb" style="display:none;" class="ord_sportOT_nor_off noFloat" onClick="Go_RB_page('OP');"><span class="ord_sportName"><?=$str_order_OP?></span><span id="RB_OP_games" class="ord_sportDigit">0</span></div>
			</div>
			<div id="RB_nodata" style="display:none;" class="ord_noInPlay"><?=$meiyousaishi?></div><!--沒賽-->
		</div>

		<!-- 特殊賽事 -->
		<div id="sp_game" style="display:none;" class="ord_sportMenu_WorldCupG">
			<h1 id="sp_name">world cup</h1>

			<div id="sp_show" class="ord_sportMenu_WorldCup"></div>

			<div id="sp_model" style="display:none;">
				<div id="sp_game_RB" *RB_DISPLAY* onClick="goToSPGame('RB','*GTYPE*');" class="noFloat"><span class="ord_sportName">In-Play Matches</span><span class="ord_sportDigitWC">*RB_COUNT*</span></div>
				<div id="sp_game_FT" *FT_DISPLAY* onClick="goToSPGame('FT','*GTYPE*');" class="noFloat"><span class="ord_sportName">Today's Matches</span><span class="ord_sportDigitWC">*FT_COUNT*</span></div>
				<div id="sp_game_FU" *FU_DISPLAY* onClick="goToSPGame('FU','*GTYPE*');" class="noFloat"><span class="ord_sportName">Early Matches</span><span class="ord_sportDigitWC">*FU_COUNT*</span></div>
				<div id="sp_game_P3" *P3_DISPLAY* onClick="goToSPGame('P3','*GTYPE*');" class="noFloat"><span class="ord_sportName">Parlay</span><span class="ord_sportDigitWC">*P3_COUNT*</span></div>
				<div id="sp_game_FS" *FS_DISPLAY* onClick="goToSPGame('FS','*GTYPE*');" class="noFloat"><span class="ord_sportName">Outright Markets</span><span class="ord_sportDigitWC">*FS_COUNT*</span></div>
			</div>

		</div>
		<!-- 特殊賽事 End -->


		<!-- 精選賽事 -->
		<div id="hot_game" style="display:none;" class="ord_sportMenu_highG">
			<h1 id="hot_name"><?=$jingxuan?></h1>

			<div id="hot_show" class="ord_sportMenu_high"></div>

			<div id="hot_model" style="display:none;">
				<div *GTYPE_STYLE*  onclick="showHotDiv('<?=$gtype?>');"> <!-- class="ord_sportFT_high noFloat" -->
					<span class="ord_sportName"><span class="ordH3"><?php echo $$mm?></span><span class="ordH4">Sự kiện hàng đầu</span></span><span id="arrow_*GTYPE*" *ARROW_CLASS*></span>
				</div>
				<ul id="hot_div_<?=$gtype?>" *DIV_DISPLAY*>
					<li id="hot_game_RB_<?=$gtype?>" *RB_DISPLAY* onClick="goToHotGame('RB','*GTYPE*');"><h5>In-Play Matches</h5><h6>*RB_COUNT*</h6></li>
					<li id="hot_game_FT_<?=$gtype?>" *FT_DISPLAY* onClick="goToHotGame('FT','*GTYPE*');"><h5>Today's Matches</h5><h6>*FT_COUNT*</h6></li>
					<li id="hot_game_FU_<?=$gtype?>" *FU_DISPLAY* onClick="goToHotGame('FU','*GTYPE*');"><h5>Early Matches</h5><h6>*FU_COUNT*</h6></li>
					<li id="hot_game_P3_<?=$gtype?>" *P3_DISPLAY* onClick="goToHotGame('P3','*GTYPE*');"><h5>Parlay</h5><h6>*P3_COUNT*</h6></li>
					<li id="hot_game_FS_<?=$gtype?>" *FS_DISPLAY* onClick="goToHotGame('FS','*GTYPE*');"><h5>Outright Markets</h5><h6>*FS_COUNT*</h6></li>
				</ul>
			</div>

		</div>
		<!-- 精選賽事 End -->

		<!--球類有下拉區-->
		<div class="ord_sportMenu_TodayG">
			<h1><?=$tiyu?></h1>
			<div class="ord_memu2">
				<span id="title_today" onClick="chgShowType('today');" class="ord_memuBTN_on"><?=$today?></span>
				<span id="title_early" onClick="chgShowType('early');" class="ord_memuBTN"><?=$early?></span>
				<span id="title_parlay" onClick="chgShowType('parlay');" class="ord_memuBTN no_margin"><?=$parlay2?></span></div>
			<div id="sportMenu_Today" class="ord_sportMenu_Today" >
				<div id="title_FT" style="display:none;" onClick="chgTitle('FT');" class="ord_sportFT_on noFloat"><span class="ord_sportName"><?=$str_order_FT?></span><span id="FT_games" class="ord_sportDigit">0</span></div>
				<ul id="wager_FT" select="wtype_FT_r" style="display:none">
					<li id="wtype_FT_r" class="On" onClick="chgWtype(this.id);chg_type(this.id,'');"><?=$rangf1?></li>
					<li id="wtype_FT_pd" onClick="chgWtype(this.id);chg_type(this.id,parent.FT_lid_type);"><?=$bodan?></li>
					<li id="wtype_FT_t" onClick="chgWtype(this.id);chg_type(this.id,parent.FT_lid_type);"><?=$dans?></li>
					<li id="wtype_FT_f" onClick="chgWtype(this.id);chg_type(this.id,parent.FT_lid_type);"><?=$banquan?></li>
					<li id="wtype_FT_fs" onClick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin"><?=$outright?></li>
				</ul>

				<div id="title_BK" style="display:none;" onClick="chgTitle('BK');" class="ord_sportBK_off noFloat"><span class="ord_sportName"><?=$str_order_BK?></span><span id="BK_games" class="ord_sportDigit">0</span></div>
				<ul id="wager_BK" select="wtype_BK_r" style="display:none">
					<li id="wtype_BK_r" class="On" onClick="chgWtype(this.id);chg_type(this.id,parent.BK_lid_type);"><?=$HomeTeam?></li>
					<li id="wtype_BK_fs" onClick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin"><?=$spmatch?></li>
				</ul>

				<div id="title_TN" style="display:none;" onClick="chgTitle('TN');" class="ord_sportTN_off noFloat"><span class="ord_sportName"><?=$str_order_TN?></span><span id="TN_games" class="ord_sportDigit">0</span></div>
				<ul id="wager_TN" select="wtype_TN_r" style="display:none">
					<li id="wtype_TN_r" class="On" onClick="chgWtype(this.id);chg_type(this.id,'');"><?=$HomeTeam?></li>
					<li id="wtype_TN_pd35" onClick="chgWtype(this.id);chg_type(this.id,parent.TN_lid_type);"><?=$bodan?></li>
					<li id="wtype_TN_fs" onClick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin"><?=$outright?></li>
				</ul>

				<div id="title_VB" style="display:none;" onClick="chgTitle('VB');" class="ord_sportVB_off noFloat"><span class="ord_sportName"><?=$str_order_VB?></span><span id="VB_games" class="ord_sportDigit">0</span></div>
				<ul id="wager_VB" select="wtype_VB_r" style="display:none">
					<li id="wtype_VB_r" class="On" onClick="chgWtype(this.id);chg_type(this.id,'');"><?=$HomeTeam?></li>
					<li id="wtype_VB_pd35" onClick="chgWtype(this.id);chg_type(this.id,parent.VB_lid_type);"><?=$bodan?></li>
					<li id="wtype_VB_fs" onClick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin"><?=$outright?></li>
				</ul>

				<div id="title_BM" style="display:none;" onClick="chgTitle('BM');" class="ord_sportBM_off noFloat"><span class="ord_sportName"><?=$str_order_BM?></span><span id="BM_games" class="ord_sportDigit">0</span></div>
				<ul id="wager_BM" select="wtype_BM_r" style="display:none">
					<li id="wtype_BM_r" class="On" onClick="chgWtype(this.id);chg_type(this.id,'');"><?=$HomeTeam?></li>
					<li id="wtype_BM_pd35" onClick="chgWtype(this.id);chg_type(this.id,parent.BM_lid_type);"><?=$bodan?></li>
					<li id="wtype_BM_fs" onClick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin"><?=$outright?></li>
				</ul>

				<div id="title_TT" style="display:none;" onClick="chgTitle('TT');" class="ord_sportTT_off noFloat"><span class="ord_sportName"><?=$str_order_TT?> Tennis</span><span id="TT_games" class="ord_sportDigit">0</span></div>
				<ul id="wager_TT" select="wtype_TT_r" style="display:none">
					<li id="wtype_TT_r" class="On" onClick="chgWtype(this.id);chg_type(this.id,'');"><?=$HomeTeam?></li>
					<li id="wtype_TT_pd57" onClick="chgWtype(this.id);chg_type(this.id,parent.TT_lid_type);"><?=$bodan?></li>
					<li id="wtype_TT_fs" onClick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin"><?=$outright?></li>
				</ul>

				<div id="title_BS" style="display:none;" onClick="chgTitle('BS');" class="ord_sportBS_off noFloat"><span class="ord_sportName"><?=$str_order_BS?></span><span id="BS_games" class="ord_sportDigit">0</span></div>
				<ul id="wager_BS" select="wtype_BS_r" style="display:none">
					<li id="wtype_BS_r" class="On" onClick="chgWtype(this.id);chg_type(this.id,parent.BS_lid_type);"><?=$HomeTeam?></li>
					<li id="wtype_BS_fs" onClick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin"><?=$outright?></li>
				</ul>

				<div id="title_SK" style="display:none;" onClick="chgTitle('SK');" class="ord_sportSK_off noFloat"><span class="ord_sportName"><?=$str_order_SK?></span><span id="SK_games" class="ord_sportDigit">0</span></div>
				<ul id="wager_SK" select="wtype_SK_r" style="display:none">
					<li id="wtype_SK_r" class="On" onClick="chgWtype(this.id);chg_type(this.id,parent.SK_lid_type);"><?=$HomeTeam?></li>
					<li id="wtype_SK_fs" onClick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin"><?=$outright?></li>
				</ul>

				<div id="title_OP" style="display:none;" onClick="chgTitle('OP');" class="ord_sportOT_off noFloat"><span class="ord_sportName"><?=$str_order_OP?></span><span id="OP_games" class="ord_sportDigit">0</span></div>
				<ul id="wager_OP" select="wtype_OP_r" style="display:none">
					<li id="wtype_OP_r" class="On" onClick="chgWtype(this.id);chg_type(this.id,parent.OP_lid_type);"><?=$HomeTeam?></li>
					<li id="wtype_OP_fs" onClick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin"><?=$outright?></li>
				</ul>

			</div>

			<div id="FT_today_nodata" style="display:none;" class="ord_noInSports"><?=$meiyousaishi?></div><!--沒賽-->
			<div id="FT_early_nodata" style="display:none;" class="ord_noInSports"><?=$meiyousaishi_early?></div><!--沒賽-->
			<div id="FT_parlay_nodata" style="display:none;" class="ord_noInSports"><?=$meiyousaishi_parlay?></div><!--沒賽-->

			<!--小廣告-->
			<div id="hideAD" class="ord_adG">
				<span><img src="/images/member/order_ad03<?=$css?>.jpg"/></span>
				<span><a href="https://www.live228.com/" target="_blank"><img src="/images/member/order_ad01<?=$css?>.jpg"/></a></span>
				<!--				<span><a href="http://www.433.com/" target="_blank"><img src="/images/member/order_ad02--><?//=$css?><!--.jpg"/></a></span>-->
			</div>

		</div>

	</div>

	<!--bet slip-->
	<div id="div_betslip" name="div_bet" class="ord_DIV">
		<!--沒單文字-->
		<h1 id="SIN_BET">Đặt cược đơn</h1>
		<h1 id="PAR_BET" style="display:none">Parlay</h1>
		<div id="bet_nodata" class="ord_noOrder" style="display:none">Vui lòng thêm lựa chọn vào đặt cược của bạn.</div>

		<iframe id="bet_order_frame" name="bet_order_frame" scrolling="NO" frameborder="NO" border="0" width="200" height="0" allowtransparency="true"></iframe>
	</div>

	<!--my bets-->
	<div id="div_mybets" name="div_mybets" class="ord_mainHight">
		<!--沒單-->
		<!--div id="rec5_nodata" class="ord_noMyBet">您沒有未結算注單</div-->

		<iframe id="rec_frame" name="rec_frame" scrolling='no' frameborder="NO" border="0" width="200" height="100%" allowtransparency="true"></iframe>
	</div>



</div>
<iframe id="loadPHP" name="loadPHP" width="0" height="0" style="display:none;"></iframe>
<iframe id="reloadPHP" name="reloadPHP" src="/app/member/getrecRB.php?gtype=<?=$gtype?>&uid=<?=$uid?>&langx=<?=$langx?>" width="0" height="0" style="display:none;"></iframe>
</body>
</html>
