<?
include "../include/library.mem.php";
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";

require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/http.class.php");
$gid   = $_REQUEST['gid'];
$uid   = $_REQUEST['uid'];
$ltype = $_REQUEST['ltype'];
$langx = $_REQUEST['langx'];
$gtype = $_REQUEST['gtype'];
require ("../include/traditional.$langx.inc.php");
$sql = "select language,opentype,Memname from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title></title>
	<link href="/style/member/reset.css" rel="stylesheet" type="text/css">
	<link href="/style/member/bet_maincortol.css" rel="stylesheet" type="text/css">
	<script>
		var _REQUEST = new Array();
		_REQUEST['gid']='<?=$gid?>';
		_REQUEST['uid']='<?=$uid?>';
		_REQUEST['ltype']='<?=$ltype?>';
		_REQUEST['langx']='<?=$langx?>';
		_REQUEST['gtype']='<?=$gtype?>';
		_REQUEST['showtype']='FT';
		_REQUEST['date']='<?=date('Y-m-d')?>';
	</script>
	<script>
		var retime=90;
	</script>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8 "><script>
		﻿var R_Regex = new RegExp('\^\[A-FH\]\?R$');
		var OU_Regex = new RegExp('\^\[A-FH\]\?OU[HC]\?$');
		var AR_Regex = new RegExp('\[A-F\]R');
		var AOU_Regex = new RegExp('\[A-F\]OU');
		var AM_Regex = new RegExp('\[A-F\]M');
		var PD_Regex = new RegExp('\^H\?R\?H\[0-9\]C\[0-9\]$');
		var SFS_Regex = new RegExp('\^FS\[0\-9A\-F\]\[0\-9A\-F\]$');
		var EO_Regex = new RegExp('\^H\?R\?EO$');


		var ObjDataFT=new Array();   //資料
		var old_ObjDataFT = new Array();
		var gid_ary = new Array();

		var more_window_display_none = false;
		var gid_rtype_ior = new Array();
		var obj_ary = new Array("myMarkets","mainMarkets","goalMarkets","specials","corners","otherMarkets");
		var mod_ary = new Array("ALL_Markets","Pop_Markets","HDP_OU","first_Half","Socore","Corners","Specials","Others");

		var open_movie = {"myMarkets":false,"mainMarkets":true,"goalMarkets":true,"specials":false,"corners":false,"otherMarkets":false};
		var open_mod = {"ALL_Markets":true,"Pop_Markets":true,"HDP_OU":true,"first_Half":true,"Socore":true,"Corners":true,"Specials":true,"Others":true};

		var retime_flag;
		var retime_run;
		var mod="ALL_Markets";
		var show_more_sfs = false;    //特殊冠軍 more less
		var show_gid;

		var allwtype_ary = new Array();

		top.more_bgYalloW ="";
		var TV_eventid = "";

		function init(){

			show_gid = _REQUEST['gid'];

			allwtype_ary = create_map_array(mod_ary[0],obj_ary[0]);

			open_movieF();
			reloadGameData();
			retime_run = retime;
			if(retime > 0){
				retime_flag='Y';
			}else{
				retime_flag='N';
			}
			if (retime_flag == 'Y'){
				count_down();
			}else{
				var rt=document.getElementById('refreshTime');
				rt.innerHTML=top.refreshTime;
			}
			btnClickEvent("BackToTop");
		}


		//reload game data
		function reloadGameData(){
			retime_run = retime;
			var getHTML = new HttpRequestXML();
			getHTML.addEventListener("LoadComplete", reloadGameDataComplete);
			//document.write("/app/member/get_game_allbets.php?"+getUrlParam());

			getHTML.loadURL("/app/member/get_game_allbets.php","POST", getUrlParam());
			iorPHP.location.href="/app/member/FT_browse/aaa.php?"+getUrlParam();
			//document.write("/app/member/FT_browse/aaa.php?"+getUrlParam());
		}

		function getUrlParam(){

			var param = "";
			param="uid="+_REQUEST['uid'];
			param+="&langx="+_REQUEST['langx'];
			param+="&gtype="+_REQUEST['gtype'];
			param+="&showtype="+_REQUEST['showtype'];
			param+="&gid="+_REQUEST['gid'];
			param+="&ltype="+_REQUEST['ltype'];
			param+="&date="+_REQUEST['date'];

			return param;

		}

		function getNodeVal(Node){
			return Node.childNodes[0].nodeValue;
		}


		function reloadGameDataComplete(xml){
console.log(xml);
			if(xml == null){ //server no exit
				closeClickEvent();
				return;
			}
			try{// server error
				var tmp = xml.getElementsByTagName("server")[0];
				if(getNodeVal(tmp).indexOf("error") != -1){
					closeClickEvent();
					return;
				}
			}
			catch(e){}
			var xmdObj = new Object();
			xmlnode=new xmlNode(xml.getElementsByTagName("serverresponse"));
			xmlnodeRoot = xml.getElementsByTagName("serverresponse")[0];
			xmdObj["code"] = xmlnode.Node(xmlnodeRoot,"code");
			if(getNodeVal(xmdObj["code"])=="615"){
				//alert("final");
				//return;
				ObjDataFT = XML2Array(xmlnode,xmlnodeRoot);
				if(ObjDataFT == ""){
					if(old_ObjDataFT==""){
						closeClickEvent();
						parent.refreshReload();
						return;
					}
					ObjDataFT = old_ObjDataFT;
					//closeClickEvent();
					//show_close_info();
					//return;
				}else{
					old_ObjDataFT = ObjDataFT;
				}
				//alert(ObjDataFT[show_gid]['gid']);
				show_close_info(ObjDataFT[show_gid]["gopen"]);
				show_gameInfo(gid_ary[0],ObjDataFT);
				TV_title();


				var tpl = new fastTemplate();
				var tmpScreen = "";
				var div_model = document.getElementById('div_model');
				for(var j=0; j<div_model.children.length; j++){
					//alert( div_model.children[j]);
					var tab_model = div_model.children[j].cloneNode(true);
					if(tab_model.nodeName =="TABLE"&&tab_model.id.indexOf("model")!=-1){
						var wtype = tab_model.id.split("_")[1];
						document.getElementById('body_'+wtype).innerHTML ="";
						var tmpDiv = document.createElement("div");
						tmpDiv.appendChild(tab_model);
						tpl.init(tmpDiv);
						var tr_color = 0;
						tmpScreen ="";
						for(var k=0; k<gid_ary.length; k++){
							var gid = gid_ary[k];
							var hgid = ObjDataFT[gid]["hgid"];
							if(wtype!="SFS"){
								//alert("for head");

								var ior_arr = getIor(ObjDataFT[gid],wtype);
								if(ior_arr=="nodata") continue;
								tpl.addBlock(wtype);
								tr_color++;
								var sw =ObjDataFT[gid]["sw_"+wtype];

								var strong =ObjDataFT[gid]['strong'];
								for(var t=0; t<rtypeMap[wtype].length; t++){
									var rtype = rtypeMap[wtype][t];
									var ior = ior_arr[rtype]["ior"];
									//alert(ior);alert(rtype);
									var ratio = ior_arr[rtype]["ratio"];
									var IORATIO = "IORATIO_"+rtype;
									var RATIO = "RATIO_"+rtype;
									var td_class = "TD_CLASS_"+rtype;
									var RTYPE_GID = rtype+"_GID";
									var RTYPE_HGID = rtype+"_HGID";
									//var ratio = xmlnode.Node(tmp_game,getRatioName(wtype,rtype));
									tpl.replace(new RegExp('\\*'+IORATIO+'\\*'), ior);
									tpl.replace(new RegExp('\\*'+IORATIO+'\\*'), parse_ior(gid,rtype,ior));
									tpl.replace(/\*GID\*/g, gid);
									tpl.replace(/\*HGID\*/g, hgid);
									tpl.replace("*TR_CLASS*",((t+tr_color)%2!=0)?"more_white":"more_color");
									tpl.replace(new RegExp('\\*'+RTYPE_GID+'\\*'), rtype+"_"+gid);
									tpl.replace(new RegExp('\\*'+RTYPE_HGID+'\\*'), rtype+"_"+hgid);
									if(top.more_bgYalloW == rtype+"_"+gid || top.more_bgYalloW == rtype+"_"+hgid){
										tpl.replace(new RegExp('\\*'+td_class+'\\*'), "bg_yellow");
									}
									else{
										tpl.replace(new RegExp('\\*'+td_class+'\\*'), "bg_white");
									}
									//alert(ratio);
									tpl.replace(new RegExp('\\*'+RATIO+'\\*','g'), undefined2space(ratio));

								}
							}
							else{
								max_FS = ObjDataFT[gid]["MAXSFS"];
								SFSGAME= ObjDataFT[gid]["SFS"];
								S_LIST = ObjDataFT[gid]["STYPE_LIST"];
								H_LIST = ObjDataFT[gid]["H_LIST"];
								C_LIST = ObjDataFT[gid]["C_LIST"];

								//alert(gid+"||||||"+max_FS);
								for(var p=0;p<max_FS;p++){
									if( !show_more_sfs && p>4) continue;
									tpl.addBlock(wtype);
									tpl.replace("*TR_CLASS*",((p+1)%2!=0)?"more_white":"more_color");
									for(var key in S_LIST){
										var stype = S_LIST[key];
										var td_class = "TD_CLASS_"+key;
										var FS_str = (stype.indexOf("H") < 0)? C_LIST[p]:H_LIST[p];

										//alert(stype+"===>"+FS_str);

										var ior_val = undefined2space(SFSGAME[stype]["SFS_IOR_"+FS_str]);
										var sgid = SFSGAME[stype]["SFS_GID"]

										var RTYPE_SGID = "RTYPE_SGID"+key;

										tpl.replace("*SFS_GID_"+key+"*",sgid);
										tpl.replace("*SFS_IOR_"+key+"*",ior_val);
										tpl.replace("*SFS_IOR_"+key+"*",parse_ior(sgid,FS_str,ior_val));
										tpl.replace("*SFS_NAME_"+key+"*",undefined2space(SFSGAME[stype]["SFS_NAME_"+FS_str]));
										tpl.replace("*SFS_RTYPE_"+key+"*",FS_str);
										tpl.replace(new RegExp('\\*'+RTYPE_SGID+'\\*'), FS_str+"_"+sgid);
										if(top.more_bgYalloW == FS_str+"_"+sgid ){
											tpl.replace(new RegExp('\\*'+td_class+'\\*'), "bg_yellow");
										}
										else{
											tpl.replace(new RegExp('\\*'+td_class+'\\*'), "bg_white");
										}
									}
								}
								if(max_FS >0 ){
									tmpScreen = tpl.fastPrint();
									if(max_FS>5){
										if(show_more_sfs){
											tmpScreen = tmpScreen.replace("*dis_play_more_sfs*","style=\"display:none\"");
											tmpScreen = tmpScreen.replace("*dis_play_less_sfs*","style=\"display:\"");
										}else{
											tmpScreen = tmpScreen.replace("*dis_play_more_sfs*","style=\"display:\"");
											tmpScreen = tmpScreen.replace("*dis_play_less_sfs*","style=\"display:none\"");
										}
									}else{
										tmpScreen = tmpScreen.replace("*dis_play_more_sfs*","style=\"display:none\"");
										tmpScreen = tmpScreen.replace("*dis_play_less_sfs*","style=\"display:none\"");
									}

									for(var key in S_LIST){
										var stype = S_LIST[key];
										var name = SFSGAME[stype]["SFS_TITLE"];
										var tmpName = name.replace(/-/gi,"");
										//tmpScreen = tmpScreen.replace("*TITLE_"+key+"*",name.substr(1,name.length-1));
										tmpScreen = tmpScreen.replace("*TITLE_"+key+"*",tmpName);
									}
								}
							}
						}
						if(wtype!="SFS" ){
							tmpScreen = tpl.fastPrint();
						}
						tmpScreen = tmpScreen.replace(/\*TEAM_H\*/g, ObjDataFT[gid]["team_h"]);
						tmpScreen = tmpScreen.replace(/\*TEAM_C\*/g, ObjDataFT[gid]["team_c"]);
						document.getElementById('body_'+wtype).innerHTML += tmpScreen;
						document.getElementById('body_'+wtype).style.display = "";
					}


				}
				parent.document.getElementById('more_window').style.display = "";
				/*
				 if(more_window_display_none){
				 parent.document.getElementById('more_window').style.display='none';
				 show_gid='';
				 }
				 */
				//最愛
				var tmp_arr = new Array();
				tmp_arr = top.more_fave_wtype[show_gid];
				top.more_fave_wtype[show_gid] = new Array();
				for(var i=0; i< tmp_arr.length ; i++){
					wtype = tmp_arr[i];
					addFavorites(wtype);
				}

				//mod_sel(mod);

			}else{
				closeClickEvent();
			}
			fix_body_wtype();
			//模式處理
			mod_class_close();
			mod_sel(mod);
			fixMoreWindow();
		}



		//liveTV
		function liveTVClickEvent(){
			var eventid = ObjDataFT[show_gid]["eventid"];
			if (eventid != "" && eventid != "null" && eventid != "undefined") {	//判斷是否有轉播
				//parent.parent.OpenLive(eventid,"FT");

			}
		}

		//refresh
		function reFreshClickEvent(){
			//alert("refresh");
			reloadGameData();
		}
		//倒數自動更新時間
		function count_down(){
			var rt=document.getElementById('refreshTime');
			setTimeout('count_down()',1000);
			if (retime_flag == 'Y'){
				if(retime_run <= 0){
					btnClickEvent("Refresh")
					return;
				}
				retime_run--;
				rt.innerHTML=retime_run;
			}
		}


		//close

		function closeClickEvent(){
			//alert("close");
			parent.parent.show_more_gid='';

			parent.document.getElementById('more_window').style.display='none';
			parent.parent.body_browse.document.getElementById('max_leg').style.display='';

			parent.parent.body_browse.scrollTo(0,top.browse_ScrollY);
			retime_flag ="N";
			parent.parent.retime_flag = "Y";
		}


		//buttons
		function btnClickEvent(eventName){
			//alert(eventName);
			if(eventName == "BackToTop" ){
				//parent.parent.body_browse.scrollTo(0,0)
				document.getElementById("tab_show").scrollTop = "0";
			}
			if(eventName == "Close" ) closeClickEvent();
			if(eventName == "Refresh" ) reloadGameData();
		}


		//playCssEvent
		function playCssEvent(objName){
			//alert(objName);

			var obj = document.getElementById('movie_'+objName);
			if(obj.style.display==""){
				obj.style.display="none";
				open_movie[objName]=false;
			}
			else{
				obj.style.display="";
				open_movie[objName]=true;
			}


			setMark(objName);
		}

		//set mark
		function setMark(_name){

			var obj = document.getElementById('movie_'+_name);
			var showObj = document.getElementById('mark_'+_name);
			//fixMoreWindow()
			if(obj.style.display==""){
				showObj.className = "more_up"; //open
			}else{
				showObj.className = "more_out"; //open
			}
		}


		//set all mark
		function setAllMark(){
			for(var i=0; i<obj_ary.length; i++){
				setMark(obj_ary[i]);
			}
		}
		var titleDiv;
		function show_gameInfo(gid,ObjDataFT){

			//var gameInfo = document.getElementById("gameInfo");

			var league_name = ObjDataFT[gid]["league"];
			var gdatetime = ObjDataFT[gid]["datetime"];
			var team_name_h = ObjDataFT[gid]["team_h"];
			var team_name_c = ObjDataFT[gid]["team_c"];
			var live = ObjDataFT[gid]["Live"];

			var dtime = gdatetime.split(" ");
			var date = dtime[0].split("-");
			var time = dtime[1].split(":");

			if(titleDiv == undefined){
				titleDiv = document.createElement("div");
				titleDiv.appendChild(gameInfo.cloneNode(true));
			}
			var tmpDiv = titleDiv.cloneNode(true);
			var tmp_repl = tmpDiv.innerHTML;
			tmp_repl = tmp_repl.replace('*DATE*',date[1]+"/"+date[2]);
			tmp_repl = tmp_repl.replace('*TIME*',time[0]+":"+time[1]);
			tmp_repl = tmp_repl.replace('*TEAM_H*',team_name_h);
			tmp_repl = tmp_repl.replace('*TEAM_C*',team_name_c);
			tmpDiv.innerHTML = tmp_repl.replace('*LIVE*',(live == 'Y')?"LIVE":"");
			document.getElementById("title_league").innerHTML = league_name;



			gameInfo.parentNode.replaceChild(tmpDiv.children[0],gameInfo);
		}

		function setRefreshPos(){
			var refresh_right= body_browse.document.getElementById('refresh_right');
			refresh_right.style.left= body_browse.document.getElementById('myTable').clientWidth*1+20;
			//refresh_right.style.top= 39;
		}

		function addFavorites(wtype_str){
			//top.more
			var fave_cont;
			var favorites_ = document.getElementById("favorites_"+wtype_str);
			var body_ = document.getElementById("body_"+wtype_str);
//			var cont_myMarket = document.getElementById("count_myMarkets");
			var movie_myMarkets = document.getElementById("movie_myMarkets");
			var tmp_repl = body_.innerHTML;
			tmp_repl = tmp_repl.replace("model_","f_table_");
			tmp_repl = tmp_repl.replace("addFavorites","delFavorites");
			tmp_repl = tmp_repl.replace("star_down","star_up");
			//tmp_repl = tmp_repl.replace(new RegExp(top.addtoMyMarket),"");

			favorites_.innerHTML = tmp_repl;
			body_.innerHTML = "";
			top.more_fave_wtype[show_gid].push(wtype_str);
			fave_cont = count_wtype("myMarkets","ALL_Markets");
//			cont_myMarket.innerHTML = fave_cont;
			if(fave_cont!=0){
				document.getElementById("movie_myMarkets_nodata").style.display="none";
				favorites_.style.display="";
			}
			body_.style.display="none";
			if(movie_myMarkets.style.display =="none" ) playCssEvent('myMarkets');
			//fixMoreWindow();
			fix_body_wtype();
			mod_sel(mod);

		}
		function delFavorites(wtype_str){
			var tmp_arr = new Array();
			var tmp_wtype ;
			var fave_cont;
			var favorites_ = document.getElementById("favorites_"+wtype_str);
			var body_ = document.getElementById("body_"+wtype_str);
//			var cont_myMarket = document.getElementById("count_myMarkets");
			var tmp_repl = favorites_.innerHTML;
			tmp_repl = tmp_repl.replace("f_table_","model_");
			tmp_repl = tmp_repl.replace("delFavorites","addFavorites");
			tmp_repl = tmp_repl.replace("star_up","star_down");
			body_.innerHTML = tmp_repl ;
			favorites_.innerHTML = "";
			for(var i=0, a=0;i < top.more_fave_wtype[show_gid].length ; i++){
				tmp_wtype = top.more_fave_wtype[show_gid][i]
				if(wtype_str != tmp_wtype) tmp_arr[a++] = tmp_wtype ;
			}
			top.more_fave_wtype[show_gid] = tmp_arr;
			fave_cont = count_wtype("myMarkets","ALL_Markets");
//			cont_myMarket.innerHTML = fave_cont;
			if(fave_cont == 0)document.getElementById("movie_myMarkets_nodata").style.display="";
			favorites_.style.display="none";

			if( modeMap[wtype_str][mod] || mod== "ALL_Markets"){
				body_.style.display ="";
			}
			else{
				body_.style.display ="none";
			}

			fix_body_wtype();
			mod_sel(mod);
			//fixMoreWindow();
		}


		function betEvent(gid,rtype,ratio,wtype){
			//alert(gid+rtype+ratio+wtype);

			if(ratio*1==0)return;
			if(wtype!='NFS'){
				parent.parent.parent.mem_order.betOrder('FT',wtype,getParam(gid,wtype,rtype,ratio));
			}
			else{
				var param = 'gametype=FT&gid='+gid+'&uid='+top.uid+'&rtype='+rtype+'&wtype=FS'+'&langx='+top.langx;
				parent.parent.parent.mem_order.betOrder('FT',wtype,param);
			}
			if(rtype == "0~1" || rtype == "2~3" || rtype == "4~6" ){
				var index = rtype.substr(0,1) *1 /2 ;
				rtype = rtypeMap[wtype][index];
			}
			if(EO_Regex.test(wtype)){
				if(rtype.indexOf('ODD') != -1){
					rtype = wtype+"O";
				}else{
					rtype = wtype+"E";
				}
			}

			if(top.more_bgYalloW != ""){
				try{
					tar = document.getElementById(top.more_bgYalloW);
					setObjectClass(tar,"bg_white");
				}catch(e){}
			}
			top.more_bgYalloW = rtype+"_"+gid;
			tar = document.getElementById(top.more_bgYalloW);
			setObjectClass(tar,"bg_yellow");

		}
		function canclebet(){
			//alert("canclebet=="+top.more_bgYalloW);
			if(top.more_bgYalloW != ""){
				try{
					tar = document.getElementById(top.more_bgYalloW);
					setObjectClass(tar,"bg_white");
				}catch(e){}
			}
			top.more_bgYalloW="";
		}

		var setObjectClass = function(targetObj,classStr){
			var browserVar = navigator.userAgent.toLowerCase();
			//alert("browser:"+navigator.userAgent.toLowerCase());

			if(browserVar.indexOf("msie") > -1){
				targetObj.className = classStr;
				//targetObj.setAttribute("className", classStr);
			}else{
				targetObj.setAttribute("class", classStr);
			}
			return;
		}

		function getParam(gid,wtype,rtype,ratio){

			var GameFT = ObjDataFT[gid];

			var strong = GameFT["strong"];


			var type = rtype.substr(rtype.length-1,1).toUpperCase();
			if(wtype.indexOf('OU') != -1 ){
				if(type=='O')type='C';
				if(type=='U')type='H'
			}
			if( wtype=='M' || wtype=='HM' || AM_Regex.test(wtype) ||wtype =='W3' ){
				var new_type = (type=='H')?'H':'C';
			}
			if(wtype == "HPD" || wtype == "HRPD"){
				rtype = rtype.substr(1,rtype.length);
			}
			var param = 'gid='+gid+'&uid='+top.uid+'&odd_f_type='+top.odd_f_type+'&langx='+top.langx+'&rtype='+rtype;

			if(wtype=='R' ||wtype=='HR') {

				param += '&gnum='+GameFT['gnum_'+type.toLowerCase()]+'&strong='+strong+'&type='+type;

			}else if(wtype=='OU' || wtype =='HOU') {

				param += '&gnum='+GameFT['gnum_'+type.toLowerCase()]+'&type='+type;

			}else if(wtype=='M'  || wtype =='HM' ){

				param += '&gnum='+GameFT['gnum_'+new_type.toLowerCase()]+'&type='+type;

			}else if(wtype=='OUH'|| wtype =='HOUH' || wtype=='OUC' || wtype =='HOUC'){

				param += '&gnum='+GameFT['gnum_'+type.toLowerCase()]+'&type='+(type =='H'?'U':'O')+'&wtype='+wtype;

			}else if(AR_Regex.test(wtype)) {

				param += '&gnum='+GameFT['gnum_'+type.toLowerCase()]+'&strong='+strong+'&type='+type+'&wtype='+wtype;

			}else if(AOU_Regex.test(wtype)) {

				param += '&gnum='+GameFT['gnum_'+type.toLowerCase()]+'&type='+(type =='H'?'U':'O')+'&wtype='+wtype;

			}else if(AM_Regex.test(wtype)){

				param += '&gnum='+GameFT['gnum_'+new_type.toLowerCase()]+'&type='+type+'&wtype='+wtype;

			}else if(wtype.indexOf("PD") != -1 || wtype == 'T' || wtype == 'HT' || wtype == 'F' || wtype.indexOf("EO") != -1 || wtype == "SP") {

				param +='';

			}else if(wtype=='W3') {

				param += '&gnum='+GameFT['gnum_'+new_type.toLowerCase()]+'&strong='+strong+'&type='+type+'&wtype='+wtype;

			}else param += '&wtype='+wtype;


			/*
			 var thisRegex = new RegExp('\[ABDE\]RE');
			 if(thisRegex.test(wtype)){
			 }
			 */
			//preg_match("/([A-F]RE)/",$rtype)


			return param;
		}



		function fixMoreWindow(){
			var tab_show = document.getElementById('tab_show');
			var MFT = parent.document.getElementById('MFT');
			//parent.document.getElementById('more_window').width = MFT.offsetWidth;
			//parent.document.getElementById('more_window').height = get_max(tab_show.offsetHeight,MFT.offsetHeight);
			//alert(MFT.offsetWidth);
			parent.document.getElementById('showdata').width = MFT.offsetWidth-5;
			parent.document.getElementById('showdata').height = MFT.offsetHeight-5;

		}
		function get_max(a,b){
			if(a>b)return a;
			else return b;
		}

		function open_movieF(){
			var market;
			for(var i=0;i<obj_ary.length ;i++){
				market = obj_ary[i];
				if(open_movie[market] == false) playCssEvent(market);
			}

		}
		function mod_sel(mod_Name){
			if(mod_Name != "ALL_Markets"){

				var ret = true
				for(var i=1; i<obj_ary.length; i++){
					var cnt = count_wtype(obj_ary[i],mod_Name);
					if(cnt != 0)ret = false;
				}
				if(ret)return ;

			}
			mod = mod_Name;

			//模式 up down
			for(var i=0 ;i<mod_ary.length;i++){
				if(open_mod[mod_ary[i]]){
					if(mod == mod_ary[i])document.getElementById(mod_ary[i]).className="bet_all_mark_on";
					else document.getElementById(mod_ary[i]).className="bet_all_mark_out";
				}

			}

			for(var i=1; i<obj_ary.length; i++){
				var head_display = false;
				var _name = obj_ary[i];
				var div_model = document.getElementById('movie_'+_name);
				for(var j=0; j<div_model.children.length; j++){
					var child_model = div_model.children[j];

					if(child_model.nodeName =="DIV"&& child_model.id.indexOf("body")!=-1 ){
						var wtype = child_model.id.split("body_")[1];
						if(mod_Name == "ALL_Markets" || modeMap[wtype][mod_Name] ){
							if(document.getElementById('body_'+wtype).innerHTML != "") {
								document.getElementById('body_'+wtype).style.display = "";
								setStarTitle(wtype,top.addtoMyMarket);
								head_display = true;
							}
							else document.getElementById('body_'+wtype).style.display = "none";
						}
						else{
							document.getElementById('body_'+wtype).style.display ="none";
						}
						//把家到我的最愛的star title清掉
						if(document.getElementById('favorites_'+wtype).innerHTML != "") {
							setStarTitle(wtype,"");
						}
					}


				}
				document.getElementById("head_"+_name).style.display = (head_display)?"":"none";
			}
		}
		//球頭字串
		function getRatioName(wtype,rtype){
			var ratio_str= "ratio";
			switch(wtype){
				case 'R':
					break;
				case 'HR':
					ratio_str = 'h'+ratio_str;
					break;
				case 'OU':
					ratio_str+= (rtype.substr(rtype.length-1,1) =='H')?'_o':'_u';
					break;
				case 'HOU':
					ratio_str+= (rtype.substr(rtype.length-1,1) =='H')?'_ho':'_hu';
					break;
				//case 'W3':
				case 'AR':
				case 'BR':
				case 'CR':
				case 'DR':
				case 'ER':
				case 'FR':
					ratio_str+= "_"+wtype;
					break;
				default:
					ratio_str+= "_"+rtype;
					break;
			}
			return ratio_str.toLowerCase();
		}


		function getXML_TagValue(xmlnode,xmlnodeRoot,TagName){
			var ret_value="";
			if(xmlnode.Node(xmlnodeRoot,TagName).childNodes[0] != null && xmlnode.Node(xmlnodeRoot,TagName) != null) {
				ret_value = getNodeVal(xmlnode.Node(xmlnodeRoot,TagName));
			}
			return ret_value;
		}


		// 顯示賠率處理
		function parse_ior(gid,rtype,ior_value){
			var red_word = true;
			var bgcolor = false

			if(ior_value *1 < 0 )red_word = false;
			if(typeof(gid_rtype_ior[gid+rtype]) != "undefined" && gid_rtype_ior[gid+rtype] != ior_value ){
				bgcolor = true;
			}
			gid_rtype_ior[gid+rtype] = ior_value;
			if(ior_value!=""){
				ior_value=parent.parent.Mathfloor(ior_value);
				ior_value=parent.parent.printf(ior_value,2);
			}
			if(ior_value*1 == 0 && ( PD_Regex.test(rtype) || SFS_Regex.test(rtype)  || rtype =="OVH" || rtype =="HOVH" ) )return "-";
			if(ior_value*1 == 0)return "";

			if(red_word) {
				ior_value = '<font color=\'#cc0000\'>'+ior_value+'</font>';
			}
			else{
				ior_value = '<font color=\'#1f497d\'>'+ior_value+'</font>';
			}


			if(bgcolor)ior_value = '<font style=\'background-color : yellow\'>'+ior_value+'</font>';
			return ior_value;

		}
		function undefined2space(val){
			if(val == 'undefined' || typeof(val) == 'undefined')return "";
			else return val;
		}
		function SFS_show(show_str){
			if(show_more_sfs){
				show_more_sfs=false;
			}
			else {
				show_more_sfs=true;
			}
			reloadGameData();
		}



		function XML2Array(xmlnode,xmlnodeRoot){
			var tmp_Obj = new Array();
			var gameXML = xmlnode.Node(xmlnodeRoot,"game",false);
			gid_ary = new Array();
			for(var k=0; k<gameXML.length; k++){
				var tmp_game = gameXML[k];
				var gid = getNodeVal(xmlnode.Node(tmp_game,"gid"));
				var hgid = getNodeVal(xmlnode.Node(tmp_game,"hgid"));
				var TagName = tmp_game.getElementsByTagName("*");

				gid_ary[gid_ary.length] = gid;
				//gid_ary[gid_ary.length] = hgid;
				tmp_Obj[gid] = new Array();
				tmp_Obj[hgid] = new Array();
				for( var i=0;i<TagName.length;i++){
					try{
						tmp_Obj[gid][TagName[i].nodeName] =  getXML_TagValue(xmlnode,tmp_game,TagName[i].nodeName);
						tmp_Obj[hgid][TagName[i].nodeName] =  getXML_TagValue(xmlnode,tmp_game,TagName[i].nodeName);
					}
					catch(e){
						//tmp_Obj[gid][TagName[i]] = "";
						//tmp_Obj[hgid][TagName[i]] = "";
					}
				}


				try{
					var max_FS=0;
					var SFSGAMEXML = xmlnode.Node(tmp_game,"SFSGAME",false);
					var SFSXML = xmlnode.Node(tmp_game,"SFS",false);
					var LS = top.langx!="zh-tw"?(top.langx!="zh-cn"?"E":"G"):"C";
					var SFSGAME = new Array();
					var S_LIST = new Array();
					var cnt_H = new Array();
					var cnt_C = new Array();
					var RTYPE_H = new Array();
					var RTYPE_C = new Array();

					//alert(gid+"|"+SFSXML.length);
					for(var m=0;m<SFSXML.length;m++){
						var tmp_sfs = SFSXML[m];
						SFStype = getNodeVal(xmlnode.Node(tmp_sfs,"SFS_ID"));
						S_LIST[S_LIST.length] = SFStype;

						SFSGAME[SFStype] = new Array();
						SFSGAME[SFStype]["SFS_GID"] = getNodeVal(xmlnode.Node(tmp_sfs,"SFS_GID"));
						SFSGAME[SFStype]["SFS_TITLE"] = getNodeVal(xmlnode.Node(tmp_sfs,"SFS_PICTHER_"+LS));

						var RTYPES = xmlnode.Node(SFSXML[m],"RTYPES",false);
						for(var n=0;n<RTYPES.length;n++){
							var tmp_rtype = RTYPES[n];
							var FSrtype = getNodeVal(xmlnode.Node(tmp_rtype,"SFS_RTYPE"));
							SFSGAME[SFStype]["SFS_IOR_"+FSrtype] = getNodeVal(xmlnode.Node(tmp_rtype,"SFS_IOR"));
							SFSGAME[SFStype]["SFS_NAME_"+FSrtype] = getNodeVal(xmlnode.Node(tmp_rtype,"SFS_NAME_"+LS));

							if(SFStype.indexOf("H")!=-1){
								if(cnt_H[FSrtype]==undefined) cnt_H[FSrtype] = 0;
								//alert(n+"==>"+cnt_H[FSrtype]);
								cnt_H[FSrtype] += getNodeVal(xmlnode.Node(tmp_rtype,"SFS_IOR"))*1;
							}
							if(SFStype.indexOf("C")!=-1){
								if(cnt_C[FSrtype]==undefined) cnt_C[FSrtype] = 0;
								cnt_C[FSrtype] += getNodeVal(xmlnode.Node(tmp_rtype,"SFS_IOR"))*1;
							}
						}
					}
					var r_key;
					for(r_key in cnt_H){
						//alert(r_key+" ===>"+cnt_H[r_key]);
						if(cnt_H[r_key] > 0) RTYPE_H[RTYPE_H.length] = r_key;
					}

					for(r_key in cnt_C){
						//alert(r_key+" ===>"+cnt_C[r_key]);
						if(cnt_C[r_key] > 0) RTYPE_C[RTYPE_C.length] = r_key;
					}

					max_FS = (RTYPE_C.length > RTYPE_H.length)?RTYPE_C.length:RTYPE_H.length;

					//alert(RTYPE_H.toString());
					//alert(RTYPE_C.toString());

					tmp_Obj[gid]["STYPE_LIST"] = sortStype(S_LIST);
					tmp_Obj[gid]["H_LIST"] = RTYPE_H.sort();
					tmp_Obj[gid]["C_LIST"] = RTYPE_C.sort();
					tmp_Obj[gid]["MAXSFS"] = max_FS
					tmp_Obj[gid]["SFS"] = SFSGAME;

					// ObjDataFT[show_gid]["SFS_TITLE"];
				}catch(e){
					//alert(e.toString());
					//tmp_Obj[gid]["STYPE_LIST"] = "";
					//tmp_Obj[gid]["MAXSFS"] = "";
					//tmp_Obj[gid]["SFS"] = "";
				}
			}
			return tmp_Obj;
		}

		function sortStype(S_LIST){
			S_LIST.sort();
			var outObj = new Object();
			var match = {"H":"A","C":"B"};
			var cnt = {"H":0,"C":0};
			var tmp;

			for(var i=0 ;i<S_LIST.length;i++){
				tmp = S_LIST[i].substr(0,1);

				outObj[match[tmp]+(cnt[tmp]++)] = S_LIST[i];
			}

			return outObj;
		}

		function getIor(gdata,wtype){
//	var wtype_chk_ary = [];
			var map = rtypeMap[wtype];
			var ior = new Object();
			var rtype,ratio_str,type;
			var sw = gdata["sw_"+wtype];
			var gopen = gdata["gopen"];
			var ior_all_zero = true;
			var strong;
			(wtype=="HR")?
				strong = gdata['hstrong']:
				strong = gdata['strong'];
			if(gopen == "N") return "nodata" ;
			if(sw == "N") return "nodata" ;
			for(var i=0;i<map.length;i++){
				rtype =  map[i];
				//	if( wtype_chk_ary.indexOf(wtype)  && gdata["ior_"+rtype]==0 ) return "nodata" ;
				if(!isNaN(gdata["ior_"+rtype]) && gdata["ior_"+rtype]*1 != 0) ior_all_zero= false;
				ior[rtype] = new Object();
				ior[rtype]["ior"] = gdata["ior_"+rtype];

				ratio_str = getRatioName(wtype,rtype);

				if(gdata[ratio_str]){
					ior[rtype]["ratio"] = gdata[ratio_str];

					type = rtype.substr(rtype.length-1,1);
					//if(R_Regex.test(wtype) || wtype=="W3" ){
					if(R_Regex.test(wtype) ){
						if(type != strong  || type=="N"){
							ior[rtype]["ratio"] = "";
						}
					}
					if(wtype=="W3"){
						ior[rtype]["ratio"] = ior[rtype]["ratio"]*1
						if(ior[rtype]["ratio"] > 0) ior[rtype]["ratio"] = "+ "+ior[rtype]["ratio"];
						if(ior[rtype]["ratio"] < 0) ior[rtype]["ratio"] = "- "+ior[rtype]["ratio"]*-1;
					}
				}
			}
			if(ior_all_zero)return "nodata";
			if( R_Regex.test(wtype) || OU_Regex.test(wtype) || wtype == 'EO' || wtype == 'HEO'){
				var arry = new Array();
				if(wtype == 'EO' || wtype=='HEO') {
					arry[0] = (ior[map[0]]["ior"]*1000 - 1000) / 1000;
					arry[1] = (ior[map[1]]["ior"]*1000 - 1000) / 1000;
					arry = parent.parent.get_other_ioratio("H",arry[0],arry[1],parent.parent.show_ior);
					arry[0] =(arry[0]*1000 + 1000) / 1000;
					arry[1] =(arry[1]*1000 + 1000) / 1000;
				}else{
					arry[0] = ior[map[0]]["ior"]*1;
					arry[1] = ior[map[1]]["ior"]*1;
					arry = parent.parent.get_other_ioratio(top.odd_f_type,arry[0],arry[1],parent.parent.show_ior);
				}

				ior[map[0]]["ior"] = arry[0];
				ior[map[1]]["ior"] = arry[1];
			}

			return ior;
		}

		function mod_OnOver(this_mod){
			if(open_mod[this_mod]){
				document.getElementById(this_mod).className="bet_all_mark_on";
			}
		}
		function mod_OnOut(this_mod){
			if(open_mod[this_mod]){
				if(mod == this_mod)document.getElementById(this_mod).className="bet_all_mark_on";
				else document.getElementById(this_mod).className="bet_all_mark_out";
			}
		}

		// i=0 MyMarket 以外 cnt 等於0收head
		function fix_body_wtype(){

			var cnt;
			for(var i=0;i<obj_ary.length;i++){
				var _name = obj_ary[i];
				cnt = count_wtype(_name,"ALL_Markets");
				document.getElementById("count_"+_name).innerHTML = cnt;
				if(i>0){
					if(cnt == 0){
						document.getElementById("head_"+_name).style.display = "none";
					}else{
						document.getElementById("head_"+_name).style.display = "";
					}
				}
			}
		}
		//
		function count_wtype(_name,modName){
			var div_model = document.getElementById('movie_'+_name);
			var cnt = 0
			for(var j=0; j<div_model.children.length; j++){
				var child_model = div_model.children[j];
				if(child_model.nodeName =="DIV"&&( child_model.id.indexOf("body")!=-1 || child_model.id.indexOf("favorites")!=-1)){
					var wtype = child_model.id.split("body_")[1] || child_model.id.split("favorites_")[1] ;
					if(modName == "ALL_Markets" || modeMap[wtype][modName] ){
						if(child_model.innerHTML !="" ) cnt++;
						else child_model.style.display="none";
					}
				}
			}
			return cnt;
		}



		function TV_title(){
			var tv_bton = document.getElementById("live_tv");
			try{
				TV_eventid = undefined2space( ObjDataFT[show_gid]["eventid"] ) ;
			}catch(e){
				tv_bton.style.display="none";
				return;
			}
			if (TV_eventid != "" && TV_eventid != "null" && TV_eventid != undefined) {	//判斷是否有轉播
				tv_bton.title = top.str_TV_FT;
			}
			else {
				tv_bton.style.display="none";
			}

			tv_bton.className = "more_tv_out";
		}

		function setStarTitle(wtype,TitleText){
			document.getElementById("star_"+wtype).title = TitleText;
		}

		function show_close_info(gopen){
			var dis_str = "";
			if(gopen=='N')dis_str = "none";
			document.getElementById("gameOver").style.display = (dis_str=="none")?"":"none" ;
			document.getElementById("mod_table").style.display = dis_str;
			for(i=0;i<obj_ary.length;i++){
				var objName = obj_ary[i];
				var mark = document.getElementById("mark_"+objName);
				document.getElementById("head_"+objName).style.display = dis_str;
				if( gopen == 'Y') {
					document.getElementById("movie_"+objName).style.display = (mark.className == "more_up")?"":"none";
				}else{
					document.getElementById("movie_"+objName).style.display =  "none";
				}
			}
		}

		//
		function create_map_array(modName,objName){
			var ret_arry = new Array();
			var div_model = document.getElementById('movie_'+objName);
			for(var j=0; j<div_model.children.length; j++){
				var child_model = div_model.children[j];
				if(child_model.nodeName =="DIV"&& ( child_model.id.indexOf("body")!=-1 || child_model.id.indexOf("favorites")!=-1 ) ){
					var wtype = child_model.id.split("body_")[1] || child_model.id.split("favorites_")[1] ;
					if(modName == "ALL_Markets" || modeMap[wtype][modName] ){
						ret_arry.push(wtype);
					}
				}
			}
			return ret_arry;
		}

		//var obj_ary = new Array("myMarkets","mainMarkets","goalMarkets","specials","corners","otherMarkets");
		//var mod_ary = new Array("ALL_Markets","Pop_Markets","HDP_OU","first_Half","Socore","Corners","Specials","Others");

		//模式反灰 產生 open_mod
		function mod_class_close(){
			for(k=1;k<mod_ary.length;k++){
				modName = mod_ary[k];
				var open_it = false
				for(var i=1; i<obj_ary.length; i++){
					var cnt = count_wtype(obj_ary[i],modName);
					if(cnt != 0)open_it = true;
				}
				open_mod[modName] = open_it;
				//alert(open_it)
				if(open_it == false){
					document.getElementById(modName).className = "mod_none";
				}else if(mod == modName){
					document.getElementById(modName).className = "bet_all_mark_on";
				}
				else{
					document.getElementById(modName).className = "bet_all_mark_out";
				}
			}
		}
	</script>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8 "><script>
		function HttpRequestXML(){
			var self=this;
			var req;
			var eventHandler=new Array();
			var parentClass;
			self.init=function(){
				self.addEventListener("LoadComplete",self.cmd_proc);
				//self.removeEventListener("LoadComplete");
				//alert("onload");
			}
			self.help=function(){
				var str="";
				str+="EventName:LoadComplete Method:function(html)\n";
				str+="Method:loadURL(url,post/get,pamam)\n";
				return str;
			}

			self.setParentclass=function(parentclass){
				parentClass=parentclass;
				//util=parentClass.util;
			}

			self.getThis=function(varible){
				return eval(varible);
			}



			self.loadURL=function(url,method,params) {
				req = false;
				// branch for native XMLHttpRequest object

				if(window.XMLHttpRequest && !(window.ActiveXObject)) {
					try{
						req = new XMLHttpRequest();
					}catch(e){
						req = false;
					}
					// branch for IE/Windows ActiveX version
				}else if(window.ActiveXObject){
					try{
						req = new ActiveXObject("Msxml2.XMLHTTP");
					}catch(e){
						try{
							req = new ActiveXObject("Microsoft.XMLHTTP");
						}catch(e){
							req = false;
						}
					}
				}


				if(req){

					req.onreadystatechange = self.processReqChange;
					if(method==undefined) method="POST";

					if(method.toUpperCase()=="POST"){
						req.open("POST", url, true);
						//req.setRequestHeader("Content-Type","text/xml;charset=utf8");
						// xmlHttp.setRequestHeader("Content-Type","text/xml;charset="+charset);
						// params = "lorem=ipsum&name=binny";
						req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						//php:·í½s½X¤£¬°utf-8®É­n¥[¦bphp  header('Content-Type:text/html;charset=big5');
						//	req.setRequestHeader("Content-length", params.length);
						//	if (params!="" && params!=undefined)
						req.send(params);

					}else{
						req.open("GET", url+"?"+params, true);
						req.send("");
					}
				}
			}

			self.processReqChange=function() {
				// only if req shows "loaded"
				//   alert(req.status);
				if(req.readyState == 4){
					// only if "OK"
					//alert("req.status="+req.status);
					if(req.status == 200){
						// ...processing statements go here...
						//self.cmd_proc(req.responseText);
						//	self.eventhandler("LoadComplete",req.responseText);
						self.eventhandler("LoadComplete",req.responseXML);
					}else{
						//alert("There was a problem retrieving the XML data:\n" +req.statusText);
					}
				}
			}

			self.addEventListener=function(eventname,eventFunction){
				eventHandler[eventname]=eventFunction;
			}

			self.removeEventListener=function(eventname){
				EventHandler[eventname]=undefined;
			}

			self.eventhandler=function(eventname,param){
				if(eventHandler[eventname]!=undefined){
					eventHandler[eventname](param);
				}
			}

			self.cmd_proc=function(html){
				alert(html);
				//return html;
			}
			//self.addEventLisition("LoadComplete",self.cmd_proc);
			self.init();
		}
	</script>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8 "><script>
		var _=new Object();
		var dataClass=new Object();
		var debug=true;
		function maxlog(obj,message){

			if (!debug) return;
			if (document.getElementById(obj)==null){
				document.body.innerHTML=document.body.innerHTML+"<div id="+obj+"></div>";
			}
			if (message==""){
				document.getElementById(obj).innerHTML="";
			}else{
				document.getElementById(obj).innerHTML=document.getElementById(obj).innerHTML+message;
			}
		}
		//��������O����(_)
		function removeMem(obj){


			for(var variable in obj){
				try{

					//alert(variable+"===>"+typeof obj[variable]);
					if (typeof obj[variable]=="object"){
						maxlog("removeMC_log","NEXT->"+variable);
						//document.getElementById("rm").innerHTML=document.getElementById("rm").innerHTML+"NEXT->"+variable+"<br>";
						obj[variable].removeMC();
						removeMem(obj[variable]);
						maxlog("removeMC_log","[Next Remove]"+variable);
						obj[variable]=null;
					}else{
						//document.getElementById("rm").innerHTML=document.getElementById("rm").innerHTML+"[Remove]"+variable+"<br>";
						maxlog("removeMC_log","[Remove]"+variable);
						obj[variable]=null;
					}

				}catch(e){
					maxlog("removeMC_log","[Try Remove]"+variable);
					obj[variable]=null;
				}
			}
		}
		//��ܪ��󤺮e
		function showObj(Obj){
			//alert(obj)
			maxlog("showobj_log","");

			for(var variable in Obj){
				try{
					maxlog("showobj_log","name:"+variable+"==== value:"+Obj[variable]);
				}catch(e){
					//alert(e);
				}
			}

		}
		//���Jhtml���(��js)
		function loadHtml(Url,autoClearBody,loadComplete){
			urls=Url.split("/");
			filename=urls[urls.length-1].split(".")[0];
			urlpath=Url.replace(urls[urls.length-1],"");

			url=Url;
			//jsurl=urlpath+"js/"+filename+".js";
			jsurl="/js/"+filename+".js";
			if (autoClearBody!=false) try{ removeMem(_);}catch(e){}
			loaderProc(url,jsurl,autoClearBody,loadComplete);

		}

		function loaderProc(url,jsurl,autoClearBody,loadComplete){
			var getHTML=new HttpRequest();
			getHTML.addEventListener("LoadComplete",function(html){
				//alert(html);
				if (autoClearBody!=false) document.body.innerHTML="";
				var tempHtml=new parseHTML(html);
				dbody=tempHtml.getTag("div")[0];
				//dbody=tempHtml.getTag("body")[0];
				//dhead=tempHtml.getTag("head")[0];
				//document.body.innerHTML="";

				//CSS
				alink=tempHtml.getTag("link");

				for(i=0;i<alink.length;i++) {
					document.body.appendChild(alink[i]);

					//document.getElementsByTagName("head")[0].appendChild(alink[i]);
				}

				document.body.appendChild(dbody);
				//alert("header=>"+dhead.innterHTML);


				/*
				 var s=tempHtml.getTag("script")[0];
				 if (s!=null){
				 //document.getElementsByTagName("head")[0].appendChild(s);
				 alert(s.tagName+"==>"+s.innerHTML);
				 (document.getElementsByTagName("head")[0] || document.body).appendChild(s.cloneNode(true));
				 }
				 */

				//document.body.replaceChild(document.body,dbody);
				tempHtml.remove();
				//script
				//alert(jsurl);
				loadscript(jsurl,loadComplete);
			})

			getHTML.loadURL(url,"GET","");

		}


		//�ѪRxml
		function parseXml(xml){
			var tempHtml=new parseHTML(xml);
			var xml=tempHtml.getChildren();
			alert("-==>"+xml[0].tagName);
			var firstNode=xml[0].tagName;

			//game=xml["server"].node["group"].children["game"].children;
			root=tempHtml.getTag(firstNode);


			xmlnode=new xmlNode(root);
			tempHtml.remove();
			return xmlnode;

		}


		//�ѪRxml Class
		function xmlNodeMax(root){
			_self=this;
			_self.Root=root;
			parentNode=_self.Root[0];
			_self.getParentNode=function(){
				return parentNode;
			}
			_self.getNode=function(node,auto){
				retNode=parentNode.getElementsByTagName(node);
				parentNode=retNode[0];
				if (auto==false) return retNode[0].childNode;
				if (retNode.length==1) return retNode[0].childNodes[0];
				else return retNode[0].childNodes;
				//	return retNode;
			}
			_self.Node=function(parentNode,node,auto){
				if (parentNode.length>1){
					alert("DataNode error!!");
					return;
				}
				retNode=parentNode.getElementsByTagName(node);
				if (auto==false) return retNode;
				if (retNode.length==1) return retNode[0];
				else return retNode;
				//return retNode;
			}
			_self.removeMC=function(){}
		}

		//�ѪRxml Class
		function xmlNode(root){
			_self=this;
			_self.Root=root;
			parentNode=_self.Root[0];
			_self.getParentNode=function(){
				return parentNode;
			}
			_self.getNode=function(node,auto){
				retNode=parentNode.getElementsByTagName(node);
				parentNode=retNode[0];
				if (auto==false) return retNode;
				if (retNode.length==1) return retNode[0];
				else return retNode;
				//	return retNode;
			}
			_self.Node=function(parentNode,node,auto){
				if (parentNode.length>1){
					alert("DataNode error!!");
					return;
				}
				retNode=parentNode.getElementsByTagName(node);
				if (auto==false) return retNode;
				if (retNode.length==1) return retNode[0];
				else return retNode;
				//return retNode;
			}
			_self.removeMC=function(){}
		}
		//�ѪRhtml Class
		function parseHTML(html){
			//alert("parseHTML==>"+html);
			var _self=this;
			var divObj=document.createElement("div");
			//var divObj=document.createDocumentFragment();
			//	var divObj=document.createDocumentFragment();
			//document.body.appendChild(divObj);

			//document.appendChild(divObj);

			alert("parseHTML==>"+html);

			divObj.innerHTML=html;
			//divObj.innerHTML="<xmp>"+html+"</xmp>"
			//divObj.innerHTML = divObj.innerHTML.replace("<xmp>","").replace("</xmp>","").replace("<XMP>","").replace("</XMP>","");

			//divObj.appendChild(divObj1);
			//divObj1=null;
			alert(divObj.innerHTML);

			document.getElementById("test_look").innerHTML ="<xmp>"+divObj.innerHTML+"</xmp>";
			//alert(divObj.parentNode);
			_self.getTag=function(tagID,divobj){

				if (divobj==undefined) divobj=divObj;
				var retobj=new Array();
				for(var i=0;i<divobj.children.length;i++){
					//	alert(divobj.children[i].tagName+"==>"+ divobj.children[i].id);
					if (divobj.children[i].tagName.toUpperCase()==tagID.toUpperCase()){
						retobj.push(divobj.children[i]);
					}
				}
				return retobj;

			}
			_self.getChildren=function(){
				return divObj.children;
			}
			//document.body.appChild(divObj);
			_self.getObj=function(tagID,divobj){
				if (divobj==undefined) divobj=divObj;
				var obj=null;
				try{
					obj=divobj.children[tagID];
				}catch(e){
					obj=null;
				}

				return obj;
			}
			//return _self;
			_self.remove=function(){
				//�ۤv��@�����C�@��div�U��������
				//��@����@���^�ӵ���
				divObj=null;

			}
			_self.removeMC=function(){}
		}

		//���Jscript
		function loadscript(url,loadComplete){

			scriptAry=document.getElementsByTagName("script");
			for(i=scriptAry.length-1;i>=0;i--){
				//if (scriptAry[i].src==url) return;
				scriptAry[i].parentNode.removeChild(scriptAry[i]);
			}

			var src=document.createElement("script");
			(document.getElementsByTagName("head")[0] || document.body).appendChild(src);
			src.id=url;
			src.src=url;
			if(loadComplete!=null) src.onload=loadComplete;

		}




		function removeScript(url){
			//alert(url+"==>"+document.getElementById(url));
			var obj=document.getElementById(url);
			if (obj!=null)
				document.getElementById(url).parentNode.removeChild(document.getElementById(url));
		}
		function runJS(js){
			return new Function("return "+js)();
		}
		//CSS�ʹ�class
		function cssAni(divObj){
			var _self=this;
			_self.play=function(ms,times){
				playtime=ms/1000;
				divObj.style["-webkit-animation-duration"]=playtime+"s";
				divObj.style["-webkit-animation-iteration-count"]=1;
				_self.finishTimer=setTimeout(_self.finishAni,ms,divObj);
			}
			_self.showXY=function(x,y){
				divObj.style.top=y;
				divObj.style.left=x;
			}
			_self.finishAni=function(divObj){
				divObj.style["-webkit-animation-iteration-count"]=0;
				csstag=_self.getCssTag(divObj.style["-webkit-animation-name"]);
				lastPos=csstag[csstag.length-1].style.cssText.replace(";","").split(":");
				divObj.style[lastPos[0]]=lastPos[1];
				_self.finish(divObj);
			}
			_self.finish=function(divObj){
				alert("override finish(divObj)");

			}
			//���ocss keyframe size
			_self.KeyFrameSize=function(){
				csstag=_self.getCssTag(divObj.style["-webkit-animation-name"]);
				return csstag.length;
			}

			//�]�w��@��css keyframe
			_self.setKeyFrame=function(keyframe,value){
				csstag=_self.getCssTag(divObj.style["-webkit-animation-name"]);
				if (keyframe>csstag.length-1) alert("error=>keyframe>size");
				csstag[keyframe].style.cssText=csstag[0].style[0]+":"+value;
			}
			//���ocss�Ҧ�keyframe����
			_self.getCssTag=function(findTagName){
				for (var i=0;i<document.styleSheets[0].rules.length;i++){
					//alert(document.styleSheets[0].rules[i].name);
					if (document.styleSheets[0].rules[i].name==findTagName){
						return document.styleSheets[0].rules[i].cssRules;
						//alert(i)
					}
				}

			}
		}</script>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8 "><script>
		﻿var rtypeMap = new Object();

		//走地
		rtypeMap["RE"] = ["REH","REC"];
		rtypeMap["HRE"] = ["HREH","HREC"];
		rtypeMap["ROU"] = ["ROUH","ROUC"];
		rtypeMap["HROU"] = ["HROUH","HROUC"];
		rtypeMap["RM"] = ["RMH","RMC","RMN"];
		rtypeMap["HRM"] = ["HRMH","HRMC","HRMN"];
		rtypeMap["ARE"] = ["AREH","AREC"];
		rtypeMap["AROU"] = ["AROUU","AROUO"];
		rtypeMap["ARM"] = ["ARMH","ARMC","ARMN"];
		rtypeMap["BRE"] = ["BREH","BREC"];
		rtypeMap["BROU"] = ["BROUU","BROUO"];
		rtypeMap["BRM"] = ["BRMH","BRMC","BRMN"];
		rtypeMap["DRE"] = ["DREH","DREC"];
		rtypeMap["DROU"] = ["DROUU","DROUO"];
		rtypeMap["DRM"] = ["DRMH","DRMC","DRMN"];
		rtypeMap["ERE"] = ["EREH","EREC"];
		rtypeMap["EROU"] = ["EROUU","EROUO"];
		rtypeMap["ERM"] = ["ERMH","ERMC","ERMN"];
		rtypeMap["RPD"] = ["RH1C0","RH2C0","RH2C1","RH3C0","RH3C1","RH3C2","RH4C0","RH4C1","RH4C2","RH4C3","RH0C0","RH1C1","RH2C2","RH3C3","RH4C4","ROVH","RH0C1","RH0C2","RH1C2","RH0C3","RH1C3","RH2C3","RH0C4","RH1C4","RH2C4","RH3C4","ROVC"];
		rtypeMap["HRPD"] = ["HRH1C0","HRH2C0","HRH2C1","HRH3C0","HRH3C1","HRH3C2","HRH4C0","HRH4C1","HRH4C2","HRH4C3","HRH0C0","HRH1C1","HRH2C2","HRH3C3","HRH4C4","HROVH","HRH0C1","HRH0C2","HRH1C2","HRH0C3","HRH1C3","HRH2C3","HRH0C4","HRH1C4","HRH2C4","HRH3C4","HROVC"];
		rtypeMap["RT"] = ["RT01","RT23","RT46","ROVER"];
		rtypeMap["HRT"] = ["HRT0","HRT1","HRT2","HRTOV"];
		rtypeMap["RF"] = ["RFHH","RFHN","RFHC","RFNH","RFNN","RFNC","RFCH","RFCN","RFCC"];
		rtypeMap["RWM"] = ["RWMH1","RWMH2","RWMH3","RWMHOV","RWMC1","RWMC2","RWMC3","RWMCOV","RWM0","RWMN"];
		rtypeMap["RDC"] = ["RDCHN","RDCCN","RDCHC"];
		rtypeMap["RWE"] = ["RWEH","RWEC"];
		rtypeMap["RWB"] = ["RWBH","RWBC"];
		rtypeMap["ARG"] = ["ARGH","ARGC","ARGN"];
		rtypeMap["BRG"] = ["BRGH","BRGC","BRGN"];
		rtypeMap["CRG"] = ["CRGH","CRGC","CRGN"];
		rtypeMap["DRG"] = ["DRGH","DRGC","DRGN"];
		rtypeMap["ERG"] = ["ERGH","ERGC","ERGN"];
		rtypeMap["FRG"] = ["FRGH","FRGC","FRGN"];
		rtypeMap["GRG"] = ["GRGH","GRGC","GRGN"];
		rtypeMap["HRG"] = ["HRGH","HRGC","HRGN"];
		rtypeMap["IRG"] = ["IRGH","IRGC","IRGN"];
		rtypeMap["JRG"] = ["JRGH","JRGC","JRGN"];
		rtypeMap["RTS"] = ["RTSY","RTSN"];
		rtypeMap["ROUH"] = ["ROUHO","ROUHU"];
		rtypeMap["ROUC"] = ["ROUCO","ROUCU"];
		rtypeMap["HRUH"] = ["HRUHO","HRUHU"];
		rtypeMap["HRUC"] = ["HRUCO","HRUCU"];
		rtypeMap["REO"] = ["REOO","REOE"];
		rtypeMap["HREO"] = ["HREOO","HREOE"];
		rtypeMap["RCS"] = ["RCSH","RCSC"];
		rtypeMap["RWN"] = ["RWNH","RWNC"];
		rtypeMap["RHG"] = ["RHGH","RHGC"];
		rtypeMap["RMG"] = ["RMGH","RMGC","RMGN"];
		rtypeMap["RSB"] = ["RSBH","RSBC"];
		rtypeMap["RT3G"] = ["RT3G1","RT3G2","RT3GN"];
		rtypeMap["RT1G"] = ["RT1G1","RT1G2","RT1G3","RT1G4","RT1G5","RT1G6","RT1GN"];


		//單式

		rtypeMap["R"] = ["RH","RC"];
		rtypeMap["HR"] = ["HRH","HRC"];
		rtypeMap["OU"] = ["OUH","OUC"];
		rtypeMap["HOU"] = ["HOUH","HOUC"];
		rtypeMap["M"] = ["MH","MC","MN"];
		rtypeMap["HM"] = ["HMH","HMC","HMN"];
		rtypeMap["AR"] = ["ARH","ARC"];
		rtypeMap["AOU"] = ["AOUO","AOUU"];
		rtypeMap["AM"] = ["AMH","AMC","AMN"];
		rtypeMap["BR"] = ["BRH","BRC"];
		rtypeMap["BOU"] = ["BOUO","BOUU"];
		rtypeMap["BM"] = ["BMH","BMC","BMN"];
		rtypeMap["CR"] = ["CRH","CRC"];
		rtypeMap["COU"] = ["COUO","COUU"];
		rtypeMap["CM"] = ["CMH","CMC","CMN"];
		rtypeMap["DR"] = ["DRH","DRC"];
		rtypeMap["DOU"] = ["DOUO","DOUU"];
		rtypeMap["DM"] = ["DMH","DMC","DMN"];
		rtypeMap["ER"] = ["ERH","ERC"];
		rtypeMap["EOU"] = ["EOUO","EOUU"];
		rtypeMap["EM"] = ["EMH","EMC","EMN"];
		rtypeMap["FR"] = ["FRH","FRC"];
		rtypeMap["FOU"] = ["FOUO","FOUU"];
		rtypeMap["FM"] = ["FMH","FMC","FMN"];
		rtypeMap["PD"] = ["H1C0","H2C0","H2C1","H3C0","H3C1","H3C2","H4C0","H4C1","H4C2","H4C3","H0C0","H1C1","H2C2","H3C3","H4C4","OVH","H0C1","H0C2","H1C2","H0C3","H1C3","H2C3","H0C4","H1C4","H2C4","H3C4","OVC"];
		rtypeMap["HPD"] = ["HH1C0","HH2C0","HH2C1","HH3C0","HH3C1","HH3C2","HH4C0","HH4C1","HH4C2","HH4C3","HH0C0","HH1C1","HH2C2","HH3C3","HH4C4","HOVH","HH0C1","HH0C2","HH1C2","HH0C3","HH1C3","HH2C3","HH0C4","HH1C4","HH2C4","HH3C4","HOVC"];
		rtypeMap["T"] = ["T01","T23","T46","OVER"];
		rtypeMap["HT"] = ["HT0","HT1","HT2","HTOV"];
		rtypeMap["F"] = ["FHH","FHN","FHC","FNH","FNN","FNC","FCH","FCN","FCC"];
		rtypeMap["WM"] = ["WMH1","WMH2","WMH3","WMHOV","WMC1","WMC2","WMC3","WMCOV","WM0","WMN"];
		rtypeMap["DC"] = ["DCHN","DCCN","DCHC"];
		rtypeMap["W3"] = ["W3H","W3C","W3N"];
		rtypeMap["BH"] = ["BHH","BHC"];
		rtypeMap["WE"] = ["WEH","WEC"];
		rtypeMap["WB"] = ["WBH","WBC"];
		rtypeMap["PG"] = ["PGFH","PGLH","PGFN","PGFC","PGLC"];
		rtypeMap["RC"] = ["RCFH","RCLH","RCFC","RCLC"];
		rtypeMap["TS"] = ["TSY","TSN"];
		rtypeMap["OUH"] = ["OUHO","OUHU"];
		rtypeMap["OUC"] = ["OUCO","OUCU"];
		rtypeMap["HOUH"] = ["HOUHO","HOUHU"];
		rtypeMap["HOUC"] = ["HOUCO","HOUCU"];
		rtypeMap["EO"] = ["EOO","EOE"];
		rtypeMap["HEO"] = ["HEOO","HEOE"];
		rtypeMap["SFS"] = ["H19","C19","H20","C20","H21","C21"];
		rtypeMap["CS"] = ["CSH","CSC"];
		rtypeMap["WN"] = ["WNH","WNC"];
		rtypeMap["F2G"] = ["F2GH","F2GC","F2GN"];
		rtypeMap["F3G"] = ["F3GH","F3GC","F3GN"];
		rtypeMap["HG"] = ["HGH","HGC"];
		rtypeMap["MG"] = ["MGH","MGC","MGN"];
		rtypeMap["SB"] = ["SBH","SBC"];
		rtypeMap["FG"] = ["FGS","FGH","FGN","FGP","FGF","FGO"];
		rtypeMap["T3G"] = ["T3G1","T3G2","T3GN"];
		rtypeMap["T1G"] = ["T1G1","T1G2","T1G3","T1G4","T1G5","T1G6","T1GN"];
		rtypeMap["TK"] = ["TKH","TKC"];
		rtypeMap["PA"] = ["PAH","PAC"];
		rtypeMap["RCD"] = ["RCDH","RCDC"];
		rtypeMap["CN"] = ["CNFH","CNLH","CNFN","CNFC","CNLC"];
		rtypeMap["CD"] = ["CDFH","CDLH","CDFN","CDFC","CDLC"];
		rtypeMap["YC"] = ["YCFH","YCLH","YCFN","YCFC","YCLC"];
		rtypeMap["ST"] = ["STFH","STLH","STFN","STFC","STLC"];
		rtypeMap["OS"] = ["OSFH","OSLH","OSFN","OSFC","OSLC"];



		//if(modeMap[wtype][sel_type] != false)



		//{"type1"=>,"type2"=>false,""};
		//new Array("myMarkets","mainMarkets","goalMarkets","corners","otherMarkArray;
		modeMap = new Array()
		modeMap["R"] = {"Pop_Markets":true,"HDP_OU":true,"first_Half":false,"Socore":false,"Corners":false,"Specials":false,"Others":false};
		modeMap["HR"] = {"Pop_Markets":true,"HDP_OU":true,"first_Half":true,"Socore":false,"Corners":false,"Specials":false,"Others":false};
		modeMap["OU"] = {"Pop_Markets":true,"HDP_OU":true,"first_Half":false,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["HOU"] = {"Pop_Markets":true,"HDP_OU":true,"first_Half":true,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["M"] = {"Pop_Markets":true,"HDP_OU":false,"first_Half":false,"Socore":false,"Corners":false,"Specials":false,"Others":false};
		modeMap["HM"] = {"Pop_Markets":true,"HDP_OU":false,"first_Half":true,"Socore":false,"Corners":false,"Specials":false,"Others":false};
		modeMap["AR"] = {"Pop_Markets":true,"HDP_OU":true,"first_Half":true,"Socore":false,"Corners":false,"Specials":false,"Others":false};
		modeMap["AOU"] = {"Pop_Markets":true,"HDP_OU":true,"first_Half":true,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["AM"] = {"Pop_Markets":true,"HDP_OU":false,"first_Half":true,"Socore":false,"Corners":false,"Specials":false,"Others":false};
		modeMap["BR"] = {"Pop_Markets":true,"HDP_OU":true,"first_Half":true,"Socore":false,"Corners":false,"Specials":false,"Others":false};
		modeMap["BOU"] = {"Pop_Markets":true,"HDP_OU":true,"first_Half":true,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["BM"] = {"Pop_Markets":true,"HDP_OU":false,"first_Half":true,"Socore":false,"Corners":false,"Specials":false,"Others":false};
		modeMap["CR"] = {"Pop_Markets":true,"HDP_OU":true,"first_Half":true,"Socore":false,"Corners":false,"Specials":false,"Others":false};
		modeMap["COU"] = {"Pop_Markets":true,"HDP_OU":true,"first_Half":true,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["CM"] = {"Pop_Markets":true,"HDP_OU":false,"first_Half":true,"Socore":false,"Corners":false,"Specials":false,"Others":false};
		modeMap["DR"] = {"Pop_Markets":true,"HDP_OU":true,"first_Half":false,"Socore":false,"Corners":false,"Specials":false,"Others":false};
		modeMap["DOU"] = {"Pop_Markets":true,"HDP_OU":true,"first_Half":false,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["DM"] = {"Pop_Markets":true,"HDP_OU":false,"first_Half":false,"Socore":false,"Corners":false,"Specials":false,"Others":false};
		modeMap["ER"] = {"Pop_Markets":true,"HDP_OU":true,"first_Half":false,"Socore":false,"Corners":false,"Specials":false,"Others":false};
		modeMap["EOU"] = {"Pop_Markets":true,"HDP_OU":true,"first_Half":false,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["EM"] = {"Pop_Markets":true,"HDP_OU":false,"first_Half":false,"Socore":false,"Corners":false,"Specials":false,"Others":false};
		modeMap["FR"] = {"Pop_Markets":true,"HDP_OU":true,"first_Half":false,"Socore":false,"Corners":false,"Specials":false,"Others":false};
		modeMap["FOU"] = {"Pop_Markets":true,"HDP_OU":true,"first_Half":false,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["FM"] = {"Pop_Markets":true,"HDP_OU":false,"first_Half":false,"Socore":false,"Corners":false,"Specials":false,"Others":false};

		modeMap["PD"] = {"Pop_Markets":true,"HDP_OU":false,"first_Half":false,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["HPD"] = {"Pop_Markets":true,"HDP_OU":false,"first_Half":true,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["T"] = {"Pop_Markets":true,"HDP_OU":false,"first_Half":false,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["HT"] = {"Pop_Markets":true,"HDP_OU":false,"first_Half":true,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["F"] = {"Pop_Markets":true,"HDP_OU":false,"first_Half":true,"Socore":false,"Corners":false,"Specials":false,"Others":false};

		modeMap["WM"] = {"Pop_Markets":true,"HDP_OU":false,"first_Half":false,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["DC"] = {"Pop_Markets":true,"HDP_OU":false,"first_Half":false,"Socore":false,"Corners":false,"Specials":false,"Others":false};
		modeMap["W3"] = {"Pop_Markets":false,"HDP_OU":true,"first_Half":false,"Socore":false,"Corners":false,"Specials":false,"Others":false};
		modeMap["BH"] = {"Pop_Markets":false,"HDP_OU":false,"first_Half":false,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["WE"] = {"Pop_Markets":false,"HDP_OU":false,"first_Half":false,"Socore":false,"Corners":false,"Specials":false,"Others":false};
		modeMap["WB"] = {"Pop_Markets":false,"HDP_OU":false,"first_Half":false,"Socore":false,"Corners":false,"Specials":false,"Others":false};
		modeMap["PG"] = {"Pop_Markets":true,"HDP_OU":false,"first_Half":false,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["RC"] = {"Pop_Markets":false,"HDP_OU":false,"first_Half":false,"Socore":false,"Corners":false,"Specials":false,"Others":false};
		modeMap["TS"] = {"Pop_Markets":true,"HDP_OU":false,"first_Half":false,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["OUH"] = {"Pop_Markets":true,"HDP_OU":true,"first_Half":false,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["OUC"] = {"Pop_Markets":true,"HDP_OU":true,"first_Half":false,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["HOUH"] = {"Pop_Markets":true,"HDP_OU":true,"first_Half":true,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["HOUC"] = {"Pop_Markets":true,"HDP_OU":true,"first_Half":true,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["EO"] = {"Pop_Markets":false,"HDP_OU":false,"first_Half":false,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["HEO"] = {"Pop_Markets":false,"HDP_OU":false,"first_Half":true,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["SFS"] = {"Pop_Markets":true,"HDP_OU":false,"first_Half":false,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["CS"] = {"Pop_Markets":true,"HDP_OU":false,"first_Half":false,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["WN"] = {"Pop_Markets":true,"HDP_OU":false,"first_Half":false,"Socore":true,"Corners":false,"Specials":false,"Others":false};

		modeMap["F2G"] = {"Pop_Markets":false,"HDP_OU":false,"first_Half":false,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["F3G"] = {"Pop_Markets":false,"HDP_OU":false,"first_Half":false,"Socore":true,"Corners":false,"Specials":false,"Others":false};

		modeMap["HG"] = {"Pop_Markets":false,"HDP_OU":false,"first_Half":false,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["MG"] = {"Pop_Markets":false,"HDP_OU":false,"first_Half":false,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["SB"] = {"Pop_Markets":false,"HDP_OU":false,"first_Half":false,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["FG"] = {"Pop_Markets":false,"HDP_OU":false,"first_Half":false,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["T3G"] = {"Pop_Markets":false,"HDP_OU":false,"first_Half":false,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["T1G"] = {"Pop_Markets":false,"HDP_OU":false,"first_Half":false,"Socore":true,"Corners":false,"Specials":false,"Others":false};
		modeMap["TK"] = {"Pop_Markets":false,"HDP_OU":false,"first_Half":false,"Socore":false,"Corners":false,"Specials":true,"Others":false};
		modeMap["PA"] = {"Pop_Markets":false,"HDP_OU":false,"first_Half":false,"Socore":false,"Corners":false,"Specials":true,"Others":false};
		modeMap["RCD"] = {"Pop_Markets":false,"HDP_OU":false,"first_Half":false,"Socore":false,"Corners":false,"Specials":true,"Others":true};
		modeMap["CN"] = {"Pop_Markets":false,"HDP_OU":false,"first_Half":false,"Socore":false,"Corners":true,"Specials":true,"Others":false};
		modeMap["CD"] = {"Pop_Markets":false,"HDP_OU":false,"first_Half":false,"Socore":false,"Corners":false,"Specials":true,"Others":true};
		modeMap["YC"] = {"Pop_Markets":false,"HDP_OU":false,"first_Half":false,"Socore":false,"Corners":false,"Specials":true,"Others":true};
		modeMap["ST"] = {"Pop_Markets":false,"HDP_OU":false,"first_Half":false,"Socore":false,"Corners":false,"Specials":true,"Others":true};
		modeMap["OS"] = {"Pop_Markets":false,"HDP_OU":false,"first_Half":false,"Socore":false,"Corners":false,"Specials":true,"Others":true};
	</script>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8 "><script>
		function fastTemplate(){
			var _self=this;
			var parentClass;
			var Hashtabl=new Array();
			var dataHash=new Array();
			var keyHash=new Array();
			var SampleTable;
			var samplelayer;
			var tempTag;
			_self.init=function(obj){
				SampleTable=obj.innerHTML;
				samplelayer="";
			}

			_self.setParentclass=function(parentclass){
				parentClass=parentclass;
			}

			_self.getThis=function(varible){
				return eval(varible);
			}
			_self.setPrivate=function(varible,val){
				eval(varible+"='"+val+"'");
			}
			_self.addBlock=function(tag){
				var s_srt="<!-- START DYNAMIC BLOCK: "+tag+" -->";
				var e_srt="<!-- END DYNAMIC BLOCK: "+tag+" -->";
				var n_start =SampleTable.indexOf(s_srt,0);
				var n_end   =SampleTable.lastIndexOf(e_srt,SampleTable.length);
				var sampleTag =SampleTable.substring(n_start,n_end);

				sampleTag =sampleTag.replace(s_srt,"");
				samplelayer=SampleTable.replace(s_srt+sampleTag+e_srt,"*TAG_"+tag+"*");

				if (dataHash[tag]==undefined){
					dataHash[tag]=new Array();
					keyHash[keyHash.length]=tag;
				}
				tempTag=tag;
				dataHash[tag][dataHash[tag].length]=sampleTag;
			}

			_self.replace=function(oldTag,newTag){
				dataHash[tempTag][dataHash[tempTag].length-1]=dataHash[tempTag][dataHash[tempTag].length-1].replace(oldTag,newTag);
			}

			_self.fastPrint=function(){
				var output=samplelayer;
				for (var i=0;i<keyHash.length;i++){
					allLayer="";
					for (var j=0;j<dataHash[keyHash[i]].length;j++){
						allLayer+=dataHash[keyHash[i]][j];
					}
					output=output.replace("*TAG_"+keyHash[i]+"*",allLayer);
				}
				return output;
			}
		}</script>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8 "><script>

		if (onloadQue==null){
			var browse="";
			//注意:此js必須放在最後一個js
			if (document.all){//IE getElementsByName只能用在form改為用document上
				browse="IE";
				document.getElementsByName=function(objName){
					var children=new Array();
					var obj=document.getElementsByTagName("*");
					for (var i=0;i<obj.length;i++){
						if (obj[i].name==objName){
							children[obj[i].id]=obj[i];
							children.push(obj[i]);
						}
					}
					return children;
				}
			}

			if (!document.all){
				document.all=function(){
					return document.getElementsByTagName("*");}();
			}
			function autoAddID(){ //自動把沒有加到id而有name的tag補上id同名為name

				var all=document.getElementsByTagName("*");
				for (var i=0;i<all.length;i++){
					try{
						if (all[i].attributes["name"]!=null && all[i].id=="") all[i].id=all[i].attributes["name"].value;
					}catch(e){}
					//新增textContent
					//try{
					//alert(all[i].innerText);
					//if (all[i].innerText!=null && all[i].innerText!="") all[i].textContent=all[i].innerText;
					// if (all[i].textContent==null && all[i].innerText!="" && all[i].innerText!=null) all[i].textContent=all[i].innerText;
					//}catch(e){}
					//新增innertext
					try{
						if (all[i].innerText==null && all[i].textContent!="" && all[i].textContent!=null) all[i].innerText=all[i].textContent;
					}catch(e){}
					try{
						if(all[i].tagName.toUpperCase()=="IFRAME"){
							all[i].location=all[i].contentWindow.location;
						}
					}catch(e){}
				}
				/*
				 var xmp=document.getElementsByTagName("xmp");
				 var tmpDoc=document.createElement("div");
				 var len=xmp.length;
				 for (j=0;j<len;j++){
				 tmpDoc.innerHTML=xmp[j].innerHTML;
				 //alert(xmp[i].innerHTML);
				 var tall=tmpDoc.getElementsByTagName("*");
				 for (var i=0;i<tall.length;i++){
				 //alert(tall[i].id);
				 try{
				 if (tall[i].attributes["name"]!=null && tall[i].id=="") tall[i].id=tall[i].attributes["name"].value;
				 }catch(e){}

				 }
				 tmpDoc.innerHTML="<xmp>"+tmpDoc.innerHTML+"</xmp>";
				 xmp[j].parentNode.replaceChild(tmpDoc.children[0],xmp[j]);

				 }
				 */

			}

			var onloadQue=new Array();
			function addonloadQue(func){
				onloadQue[onloadQue.length]=func;
			}
			function autoStartLoad(){
				for(var i=0;i<onloadQue.length;i++){
					onloadQue[i]();
				}
				onloadQue=new Array();
			}



			document.onreadystatechange = function (e) {
				//alert(document.readyState+"\n"+e.target.body.innerHTML+'ready')
				if (document.readyState=="complete"){
					//alert("-->"+document.body.attributes["ONLOAD"]);
					//alert(document.body.onload.toString());
					//showObj(document.body);
					try{
						if (document.body.onload!=null && document.body.onload!="") addonloadQue(document.body.onload);
						//document.body.removeAttribute("onload",0);
						document.body.onload=function(){};
						if(window.onload!=null) addonloadQue(window.onload);
						window.onload=autoStartLoad;
					}catch(e){alert(e)}
				}
				//alert(document.readyState+" ready");
			}


			addonloadQue(autoAddID);
			//if(window.onload!=null) addonloadQue(window.onload);
			//window.onload=autoStartLoad;

			function GetEvent(caller){
				var obj=new Object;
				caller=GetEvent.caller;
				if(browse=="IE"){
					//event.keycode=event.keyCode;
					var eventobj= window.event; //For IE.
					for(var variable in eventobj){
						try{
							obj[variable]=eventobj[variable];
						}catch(e){}
					}
					obj.clientX=window.event.x;
					obj.clientY=window.event.y;
					obj.returnValue=function (){window.event.returnValue = false;}
					obj.keyCode=window.event.keyCode;
					obj.keycode=window.event.keyCode;
					return obj;

				}
				if(caller == null || typeof(caller) != "function")
					return null;
				while(caller.caller != null){
					caller = caller.caller;
				}
				var event=caller.arguments[0];

				//	if (event.keyCode==0){
				//		event.keycode=event.which;
				//		}

				for(var variable in event){
					try{
						obj[variable]=event[variable];
					}catch(e){}
				}
				if (event.keyCode==0){
					obj.keyCode=event.which;
				}
				obj.keycode=obj.keyCode;
				obj.returnValue=function (){event.preventDefault();}
				obj.x=event.clientX;
				obj.y=event.clientY;
				//alert(event.x+":"+event.y);
				return obj;

				return obj;
			}
			function GetEventTarget(event){
				if(browse=="IE") return event.srcElement;
				return event.target;
			}
		}
	</script>




</head>
<body id="MFT" class="BODYMORE" onLoad="init();">

<div id="div_show" class="bet_select_bg"><!--最外层-->
	<!--right buttons-->
	<div id="right_div" class="bet_right_btn">
		<ul class="bet_right_ul">
			<li class="bet_right_refresh" onClick="btnClickEvent('Refresh');">刷新</li>
			<li class="bet_right_close" onClick="btnClickEvent('Close');">关闭</li>
			<li class="bet_right_top" onClick="btnClickEvent('BackToTop');">返回顶部</li>
		</ul>
	</div>
	<!--right buttons-->

	<div id="more_div" class="bet_more_div">
		<div id="tab_show" class="bet_select_content"><!--白底层-->

			<!--title层-->
			<div class="bet_all_title_w">

				<div class="bet_all_select_title">
					<div id="title_league" class="bet_select_left">*LEAGUE_NAME*</div>
					<div class="bet_select_right">
						<span id="live_tv" onClick="liveTVClickEvent();" class="bet_select_TV_close"></span><!-- bet_select_TV -->
						<span id="sel_more_odd" class="bet_all_odds_btn">
							<tt id="chose_odd" class="bet_normal_text">香港盘</tt>
							<div id="show_odd" class="bet_all_odds_bg" style="display:none;">
								<span class="bet_arrow"></span>
								<span class="bet_arrow_text">盘口类型</span>
								<ul id="myoddType">
									<!--li class="bet_odds_contant">Hong Kong Odds</li>
                                    <li class="bet_odds_contant">Malay Odds</li>
                                    <li class="bet_odds_contant">Euro Decimal Odds</li>
                                    <li class="bet_odds_contant">Indo Odds</li-->
								</ul>
							</div>

						</span>

						<span class="bet_all_time_btn" onClick="reFreshClickEvent();">
							<tt id="refreshTime">refresh</tt></span>
						<span class="bet_select_close" onClick="closeClickEvent();"></span>
					</div>
				</div>
				<!-- game info -->
				<table id="gameInfo" cellpadding="0" cellspacing="0" border="0" class="bet_all_table">
					<tr class="bet_all_tr_title">
						<td id="title_showtype" class="bet_all_live"></td>
						<td></td>
						<td class="bet_all_date">*DATE*  *TIME*</td>
					</tr>
					<tr class="bet_all_tr_point">
						<td class="bet_all_point_1">*TEAM_H*</td>
						<td class="bet_all_point_v">V</td>
						<td class="bet_all_point_2">*TEAM_C*</td>
					</tr>
				</table>
				<div id="mod_table" class="bet_all_title_btn">
					<span id="ALL_Markets" onClick="mod_sel('ALL_Markets',this);" onMouseOver="mod_OnOver('ALL_Markets');" onMouseOut="mod_OnOut('ALL_Markets');" class="bet_all_mark_out"><?=$quanbupankou?></span>
					<span id="Pop_Markets" onClick="mod_sel('Pop_Markets',this);" onMouseOver="mod_OnOver('Pop_Markets');" onMouseOut="mod_OnOut('Pop_Markets');" class="bet_all_mark_out"><?=$remenpankou?></span>
					<span id="HDP_OU" onClick="mod_sel('HDP_OU',this);" onMouseOver="mod_OnOver('HDP_OU');" onMouseOut="mod_OnOut('HDP_OU');" class="bet_all_hdp_out"><?=$rangqiudaxiao?></span>
					<span id="first_Half" onClick="mod_sel('first_Half',this);" onMouseOver="mod_OnOver('first_Half');" onMouseOut="mod_OnOut('first_Half');" class="bet_all_1st_out"><?=$shangbanchang?></span>
					<span id="Socore" onClick="mod_sel('Socore',this);" onMouseOver="mod_OnOver('Socore');" onMouseOut="mod_OnOut('Socore');" class="bet_all_score_out"><?=$bifenpankou?></span>
					<span id="Specials" onClick="mod_sel('Specials',this);" onMouseOver="mod_OnOver('Specials');" onMouseOut="mod_OnOut('Specials');" class="bet_all_special_out"><?=$tebiewanfa?></span>
					<span id="Corners" style="display:none;" onClick="mod_sel('Corners',this);" onMouseOver="mod_OnOver('Corners');" onMouseOut="mod_OnOut('Corners');" class="bet_all_special_out"><?=$jiaoqiu?></span>
					<span id="Others" style="display:none;" onClick="mod_sel('Others',this);" onMouseOver="mod_OnOver('Others');" onMouseOut="mod_OnOut('Others');" class="bet_all_special_out"><?=$qitawanfa?></span>
				</div>
				<!-- markets -->
				<div class="bet_all_markets">
					<!------------------------ my markets ------------------------>
					<div id="head_myMarkets" onClick="playCssEvent('myMarkets',this);" class="bet_all_title_bg">
						<span id="mark_myMarkets" class="bet_all_arrow_up"></span>
						<span><?=$wodepankou?></span>
					</div>
					<div id="movie_myMarkets">
						<div id="movie_myMarkets_nodata" class="bet_all_click">点击 <span class="bet_all_click_star"></span> <?=$tianjiasaishi?></div>
						<div id="favorites_R"></div>
						<div id="favorites_HR"></div>
						<div id="favorites_OU"></div>
						<div id="favorites_HOU"></div>
						<div id="favorites_M"></div>
						<div id="favorites_HM"></div>
						<div id="favorites_AR"></div>
						<div id="favorites_AOU"></div>
						<div id="favorites_AM"></div>
						<div id="favorites_BR"></div>
						<div id="favorites_BOU"></div>
						<div id="favorites_BM"></div>
						<div id="favorites_CR"></div>
						<div id="favorites_COU"></div>
						<div id="favorites_CM"></div>
						<div id="favorites_DR"></div>
						<div id="favorites_DOU"></div>
						<div id="favorites_DM"></div>
						<div id="favorites_ER"></div>
						<div id="favorites_EOU"></div>
						<div id="favorites_EM"></div>
						<div id="favorites_FR"></div>
						<div id="favorites_FOU"></div>
						<div id="favorites_FM"></div>
						<div id="favorites_PD"></div>
						<div id="favorites_HPD"></div>
						<div id="favorites_T"></div>
						<div id="favorites_HT"></div>
						<div id="favorites_F"></div>

						<div id="favorites_WM"></div>
						<div id="favorites_DC"></div>
						<div id="favorites_W3"></div>
						<div id="favorites_BH"></div>
						<div id="favorites_WE"></div>
						<div id="favorites_WB"></div>
						<div id="favorites_PG"></div>
						<div id="favorites_RC"></div>
						<div id="favorites_TS"></div>
						<div id="favorites_OUH"></div>
						<div id="favorites_OUC"></div>
						<div id="favorites_HOUH"></div>
						<div id="favorites_HOUC"></div>
						<div id="favorites_EO"></div>
						<div id="favorites_HEO"></div>
						<div id="favorites_SFS"></div>
						<div id="favorites_CS"></div>
						<div id="favorites_WN"></div>
						<div id="favorites_F2G"></div>
						<div id="favorites_F3G"></div>
						<div id="favorites_HG"></div>
						<div id="favorites_MG"></div>
						<div id="favorites_SB"></div>
						<div id="favorites_FG"></div>
						<div id="favorites_T3G"></div>
						<div id="favorites_T1G"></div>
						<div id="favorites_TK"></div>
						<div id="favorites_PA"></div>
						<div id="favorites_RCD"></div>
						<div id="favorites_CN"></div>
						<div id="favorites_CD"></div>
						<div id="favorites_YC"></div>
						<div id="favorites_ST"></div>
						<div id="favorites_OS"></div>
					</div>
					<!------------------------ my markets ------------------------>
					<!------------------------ main markets ------------------------>
					<div id="head_mainMarkets" onClick="playCssEvent('mainMarkets',this);" class="bet_all_title_bg">
						<span id="mark_mainMarkets" class="bet_all_arrow_up"></span>
						<span><?=$zhupankou?></span>
					</div>
					<div id="movie_mainMarkets">
						<div id="body_R"></div>
						<div id="body_HR"></div>
						<div id="body_OU"></div>
						<div id="body_HOU"></div>
						<div id="body_M"></div>
						<div id="body_HM"></div>
						<div id="body_AR"></div>
						<div id="body_AOU"></div>
						<div id="body_AM"></div>
						<div id="body_BR"></div>
						<div id="body_BOU"></div>
						<div id="body_BM"></div>
						<div id="body_CR"></div>
						<div id="body_COU"></div>
						<div id="body_CM"></div>
						<div id="body_DR"></div>
						<div id="body_DOU"></div>
						<div id="body_DM"></div>
						<div id="body_ER"></div>
						<div id="body_EOU"></div>
						<div id="body_EM"></div>
						<div id="body_FR"></div>
						<div id="body_FOU"></div>
						<div id="body_FM"></div>
						<div id="body_PD"></div>
						<div id="body_HPD"></div>
						<div id="body_T"></div>
						<div id="body_HT"></div>
						<div id="body_F"></div>
						<div id="body_WM"></div>
						<div id="body_DC"></div>
						<div id="body_W3"></div>
						<div id="body_BH"></div>
						<div id="body_WE"></div>
						<div id="body_WB"></div>
					</div>
					<!------------------------ main markets ------------------------>
					<!------------------------ corners ------------------------>
					<div id="head_corners" onClick="playCssEvent('corners',this);" class="bet_all_title_bg">
						<span id="mark_corners" class="bet_all_arrow_up"></span>
						<span><?=$jiaoqiu?></span>
					</div>
					<div id="movie_corners" >
						<div id="body_CN"></div>
					</div>
					<!------------------------ corners ------------------------>
					<!------------------------ bookings ------------------------>
					<div id="head_bookings" onClick="playCssEvent('bookings',this);" class="bet_all_title_bg">
						<span id="mark_bookings" class="bet_all_arrow_up"></span>
						<span>罚牌</span>
					</div>
					<div id="movie_bookings">
						<div id="body_CD"></div>
						<div id="body_RCD"></div>
					</div>
					<!------------------------ bookings ------------------------>
					<!------------------------ goal markets ------------------------>
					<div id="head_goalMarkets" onClick="playCssEvent('goalMarkets',this);" class="bet_all_title_bg">
						<span id="mark_goalMarkets" class="bet_all_arrow_up"></span>
						<span><?=$jinqiupankou?></span>
					</div>
					<div id="movie_goalMarkets">
						<div id="body_PG"></div>
						<div id="body_RC"></div>
						<div id="body_TS"></div>
						<div id="body_OUH"></div>
						<div id="body_OUC"></div>
						<div id="body_HOUH"></div>
						<div id="body_HOUC"></div>
						<div id="body_EO"></div>
						<div id="body_HEO"></div>
						<div id="body_SFS"></div>
						<div id="body_CS"></div>
						<div id="body_WN"></div>
						<div id="body_F2G"></div>
						<div id="body_F3G"></div>
						<div id="body_HG"></div>
						<div id="body_MG"></div>
						<div id="body_SB"></div>
						<div id="body_FG"></div>
						<div id="body_T3G"></div>
						<div id="body_T1G"></div>
					</div>
					<!------------------------ goal markets ------------------------>
					<!------------------------ specials ------------------------>
					<div id="head_specials" onClick="playCssEvent('specials',this);" class="bet_all_title_bg">
						<span id="mark_specials" class="bet_all_arrow_up"></span>
						<span><?=$tebiewanfa?></span>
					</div>
					<div id="movie_specials" >
						<div id="body_TK"></div>
						<div id="body_PA"></div>
						<div id="body_RCD"></div>
					</div>
					<!------------------------ specials ------------------------>
					<!------------------------ other markets ------------------------>
					<div id="head_otherMarkets" onClick="playCssEvent('otherMarkets',this);" class="bet_all_title_bg">
						<span id="mark_otherMarkets" class="bet_all_arrow_up"></span>
						<span><?=$qitawanfa?></span>
					</div>
					<div id="movie_otherMarkets" >
						<div id="body_CD"></div>
						<div id="body_YC"></div>
						<div id="body_ST"></div>
						<div id="body_OS"></div>
					</div>
					<!------------------------ other markets ------------------------>
				</div>
			</div>
			<!--赛程已关闭-->
			<div id="gameOver" style="display:none;">
				<table border="0" cellpadding="0" cellspacing="0" class="bet_all_no_table">
					<tr class="bet_all_no_text"><td>
							<?=$saishijieshu?>
						</td></tr>
				</table>
			</div>
			<div id="div_model" style="display:none;" class="bet_all_game"><!--玩法层-->
				<!---------- R ---------->
				<table id="model_R" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2">
							<span class="bet_all_name"><?=$rangqiu?></span>
							<span id="star_R" name="star_R" onClick="addFavorites('R');" class="bet_all_game_star_out"></span>
						</td>
					</tr>
					<!-- START DYNAMIC BLOCK: R -->
					<tr class="bet_all_game_h">
						<td id="*RH_GID*" onClick="betEvent('*GID*','RH','*IORATIO_RH*','R');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_middle">*RATIO_RH*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_RH*</span></span></div></td>

						<td id="*RC_GID*" onClick="betEvent('*GID*','RC','*IORATIO_RC*','R');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_middle">*RATIO_RC*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_RC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: R -->
				</table>
				<!---------- R ---------->
				<!---------- HR ---------->
				<table id="model_HR" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2">
							<span class="bet_all_name"><?=$rangqiu?><tt class="bet_name_color">&nbsp;- <?=$shangbanchang?></tt></span>
							<span id="star_HR" name="star_HR" onClick="addFavorites('HR');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: HR -->
					<tr class="bet_all_game_h">
						<td id="*HRH_HGID*" onClick="betEvent('*HGID*','HRH','*IORATIO_HRH*','HR');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_middle">*RATIO_HRH*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_HRH*</span></span></div></td>
						<td id="*HRC_HGID*" onClick="betEvent('*HGID*','HRC','*IORATIO_HRC*','HR');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_middle">*RATIO_HRC*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_HRC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: HR -->
				</table>
				<!---------- HR ---------->
				<!---------- OU ---------->
				<table id="model_OU" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name"><?=$daxiao?></span><span id="star_OU" name="star_OU" onClick="addFavorites('OU');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: OU -->
					<tr class="bet_all_game_h">
						<td id="*OUC_GID*" onClick="betEvent('*GID*','OUC','*IORATIO_OUC*','OU');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">大</span><span class="bet_all_middle">*RATIO_OUC*</span><span class="bet_all_bet"><span class="bet_all_bg" title="大">*IORATIO_OUC*</span></span></div></td>
						<td id="*OUH_GID*" onClick="betEvent('*GID*','OUH','*IORATIO_OUH*','OU');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">小</span><span class="bet_all_middle">*RATIO_OUH*</span><span class="bet_all_bet"><span class="bet_all_bg" title="小">*IORATIO_OUH*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: OU -->
				</table>
				<!---------- OU ---------->
				<!---------- HOU ---------->
				<table id="model_HOU" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name"><?=$daxiao?><tt class="bet_name_color">&nbsp;- <?=$shangbanchang?></tt></span><span id="star_HOU" name="star_HOU" onClick="addFavorites('HOU');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: HOU -->
					<tr class="bet_all_game_h">
						<td id="*HOUC_HGID*" onClick="betEvent('*HGID*','HOUC','*IORATIO_HOUC*','HOU');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">大</span><span class="bet_all_middle">*RATIO_HOUC*</span><span class="bet_all_bet"><span class="bet_all_bg" title="大">*IORATIO_HOUC*</span></span></div></td>
						<td id="*HOUH_HGID*" onClick="betEvent('*HGID*','HOUH','*IORATIO_HOUH*','HOU');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">小</span><span class="bet_all_middle">*RATIO_HOUH*</span><span class="bet_all_bet"><span class="bet_all_bg" title="小">*IORATIO_HOUH*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: HOU -->
				</table>
				<!---------- HOU ---------->
				<!---------- M ---------->
				<table id="model_M" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name"><?=$duying1?></span><span id="star_M" name="star_M" onClick="addFavorites('M');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: M -->
					<tr class="bet_all_game_h">
						<td id="*MH_GID*" onClick="betEvent('*GID*','MH','*IORATIO_MH*','M');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_MH*</span></span></div></td>
						<td id="*MN_GID*" onClick="betEvent('*GID*','MN','*IORATIO_MN*','M');" class="bet_all_three_middle"><div class="bet_all_div"><span class="bet_all_team"><?=$Draw?></span><span class="bet_all_bet"><span class="bet_all_bg" title="<?=$Draw?>">*IORATIO_MN*</span></span></div></td>
						<td id="*MC_GID*" onClick="betEvent('*GID*','MC','*IORATIO_MC*','M');" class="bet_all_three"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_MC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: M -->
				</table>
				<!---------- M ---------->
				<!---------- HM ---------->
				<table id="model_HM" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name"><?=$duying1?><tt class="bet_name_color"> - <?=$shangbanchang?></tt></span><span id="star_HM" name="star_HM" onClick="addFavorites('HM');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: HM -->
					<tr class="bet_all_game_h">
						<td id="*HMH_HGID*" onClick="betEvent('*HGID*','HMH','*IORATIO_HMH*','HM');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_HMH*</span></span></div></td>
						<td id="*HMN_HGID*" onClick="betEvent('*HGID*','HMN','*IORATIO_HMN*','HM');" class="bet_all_three_middle"><div class="bet_all_div"><span class="bet_all_team"><?=$Draw?></span><span class="bet_all_bet"><span class="bet_all_bg" title="<?=$Draw?>">*IORATIO_HMN*</span></span></div></td>
						<td id="*HMC_HGID*" onClick="betEvent('*HGID*','HMC','*IORATIO_HMC*','HM');" class="bet_all_three"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_HMC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: HM -->
				</table>
				<!---------- HM ---------->
				<!---------- AR ---------->
				<table id="model_AR" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">15 <?=$fenzhong?>盘口: <?=$kaichang?>&nbsp;- 14:59 <?=$fenzhong?> - <?=$rangqiu?></span><span id="star_AR" name="star_AR" onClick="addFavorites('AR');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: AR -->
					<tr class="bet_all_game_h">
						<td id="*ARH_HGID*" onClick="betEvent('*GID*','ARH','*IORATIO_ARH*','AR');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_middle">*RATIO_ARH*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_ARH*</span></span></div></td>
						<td id="*ARC_HGID*" onClick="betEvent('*GID*','ARC','*IORATIO_ARC*','AR');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_middle">*RATIO_ARC*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_ARC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: AR -->

				</table>
				<!---------- AR ---------->
				<!---------- BR ---------->
				<table id="model_BR" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">15 <?=$fenzhong?>盘口: 15:00 - 29:59 <?=$fenzhong?> - <?=$rangqiu?></span><span id="star_BR" name="star_BR" onClick="addFavorites('BR');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: BR -->
					<tr class="bet_all_game_h">
						<td id="*BRH_HGID*" onClick="betEvent('*GID*','BRH','*IORATIO_BRH*','BR');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_middle">*RATIO_BRH*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_BRH*</span></span></div></td>
						<td id="*BRC_HGID*" onClick="betEvent('*GID*','BRC','*IORATIO_BRC*','BR');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_middle">*RATIO_BRC*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_BRC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: BR -->
				</table>
				<!---------- BR ---------->
				<!---------- AOU ---------->
				<table id="model_AOU" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">15 分钟盘口: 开场&nbsp;- 14:59 分钟 - 大 / 小</span><span id="star_AOU" name="star_AOU" onClick="addFavorites('AOU');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: AOU -->
					<tr class="bet_all_game_h">
						<td id="*AOUO_GID*" onClick="betEvent('*GID*','AOUO','*IORATIO_AOUO*','AOU');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">大</span><span class="bet_all_middle">*RATIO_AOUO*</span><span class="bet_all_bet"><span class="bet_all_bg" title="大">*IORATIO_AOUO*</span></span></div></td>
						<td id="*AOUU_GID*" onClick="betEvent('*GID*','AOUU','*IORATIO_AOUU*','AOU');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">小</span><span class="bet_all_middle">*RATIO_AOUU*</span><span class="bet_all_bet"><span class="bet_all_bg" title="小">*IORATIO_AOUU*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: AOU -->
				</table>
				<!---------- AOU ---------->
				<!---------- AM ---------->
				<table id="model_AM" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">15 分钟盘口: 开场&nbsp;- 14:59 分钟 - 独赢</span><span id="star_AM" name="star_AM" onClick="addFavorites('AM');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: AM -->
					<tr class="bet_all_game_h">
						<td id="*AMH_GID*" onClick="betEvent('*GID*','AMH','*IORATIO_AMH*','AM');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_AMH*</span></span></div></td>
						<td id="*AMN_GID*" onClick="betEvent('*GID*','AMN','*IORATIO_AMN*','AM');" class="bet_all_three_middle"><div class="bet_all_div"><span class="bet_all_team">和局</span><span class="bet_all_bet"><span class="bet_all_bg" title="和局">*IORATIO_AMN*</span></span></div></td>
						<td id="*AMC_GID*" onClick="betEvent('*GID*','AMC','*IORATIO_AMC*','AM');" class="bet_all_three"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_AMC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: AM -->
				</table>
				<!---------- AM ---------->
				<!---------- BOU ---------->
				<table id="model_BOU" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">15 分钟盘口: 15:00 - 29:59 分钟 - 大 / 小</span><span id="star_BOU" name="star_BOU" onClick="addFavorites('BOU');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: BOU -->
					<tr class="bet_all_game_h">
						<td id="*BOUO_GID*" onClick="betEvent('*GID*','BOUO','*IORATIO_BOUO*','BOU');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">大</span><span class="bet_all_middle">*RATIO_BOUO*</span><span class="bet_all_bet"><span class="bet_all_bg" title="大">*IORATIO_BOUO*</span></span></div></td>
						<td id="*BOUU_GID*" onClick="betEvent('*GID*','BOUU','*IORATIO_BOUU*','BOU');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">小</span><span class="bet_all_middle">*RATIO_BOUU*</span><span class="bet_all_bet"><span class="bet_all_bg" title="小">*IORATIO_BOUU*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: BOU -->

				</table>
				<!---------- BOU ---------->
				<!---------- BM ---------->
				<table id="model_BM" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">15 分钟盘口: 15:00 - 29:59 分钟 - 独赢</span><span id="star_BM" name="star_BM" onClick="addFavorites('BM');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: BM -->
					<tr class="bet_all_game_h">
						<td id="*BMH_GID*" onClick="betEvent('*GID*','BMH','*IORATIO_BMH*','BM');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_BMH*</span></span></div></td>

						<td id="*BMN_GID*" onClick="betEvent('*GID*','BMN','*IORATIO_BMN*','BM');" class="bet_all_three_middle"><div class="bet_all_div"><span class="bet_all_team">和局</span><span class="bet_all_bet"><span class="bet_all_bg" title="和局">*IORATIO_BMN*</span></span></div></td>

						<td id="*BMC_GID*" onClick="betEvent('*GID*','BMC','*IORATIO_BMC*','BM');" class="bet_all_three"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_BMC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: BM -->
				</table>
				<!---------- BM ---------->
				<!---------- CR ---------->
				<table id="model_CR" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">15 分钟盘口: 30:00 分钟 - 半场 - 让球</span><span id="star_CR" name="star_CR" onClick="addFavorites('CR');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: CR -->
					<tr class="bet_all_game_h">
						<td id="*CRH_HGID*" onClick="betEvent('*GID*','CRH','*IORATIO_CRH*','CR');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_middle">*RATIO_CRH*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_CRH*</span></span></div></td>
						<td id="*CRC_HGID*" onClick="betEvent('*GID*','CRC','*IORATIO_CRC*','CR');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_middle">*RATIO_CRC*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_CRC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: CR -->
				</table>
				<!---------- CR ---------->
				<!---------- COU ---------->
				<table id="model_COU" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">15 分钟盘口: 30:00 分钟 - 半场 - 大 / 小</span><span id="star_COU" name="star_COU" onClick="addFavorites('COU');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: COU -->
					<tr class="bet_all_game_h">
						<td id="*COUO_GID*" onClick="betEvent('*GID*','COUO','*IORATIO_COUO*','COU');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">大</span><span class="bet_all_middle">*RATIO_COUO*</span><span class="bet_all_bet"><span class="bet_all_bg" title="大">*IORATIO_COUO*</span></span></div></td>
						<td id="*COUU_GID*" onClick="betEvent('*GID*','COUU','*IORATIO_COUU*','COU');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">小</span><span class="bet_all_middle">*RATIO_COUU*</span><span class="bet_all_bet"><span class="bet_all_bg" title="小">*IORATIO_COUU*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: COU -->
				</table>
				<!---------- COU ---------->
				<!---------- CM ---------->
				<table id="model_CM" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">15 分钟盘口: 30:00 分钟 - 半场 - 独赢</span><span id="star_CM" name="star_CM" onClick="addFavorites('CM');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: CM -->
					<tr class="bet_all_game_h">
						<td id="*CMH_GID*" onClick="betEvent('*GID*','CMH','*IORATIO_CMH*','CM');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_CMH*</span></span></div></td>
						<td id="*CMN_GID*" onClick="betEvent('*GID*','CMN','*IORATIO_CMN*','CM');" class="bet_all_three_middle"><div class="bet_all_div"><span class="bet_all_team"><?=$Draw?></span><span class="bet_all_bet"><span class="bet_all_bg" title="<?=$Draw?>">*IORATIO_CMN*</span></span></div></td>
						<td id="*CMC_GID*" onClick="betEvent('*GID*','CMC','*IORATIO_CMC*','CM');" class="bet_all_three"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_CMC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: CM -->
				</table>
				<!---------- CM ---------->
				<!---------- DM ---------->
				<table id="model_DM" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">15 分钟盘口: 下半场开始&nbsp;- 59:59 分钟 - 独赢</span><span id="star_DM" name="star_DM" onClick="addFavorites('DM');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: DM -->
					<tr class="bet_all_game_h">
						<td id="*DMH_GID*" onClick="betEvent('*GID*','DMH','*IORATIO_DMH*','DM');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_DMH*</span></span></div></td>
						<td id="*DMN_GID*" onClick="betEvent('*GID*','DMN','*IORATIO_DMN*','DM');" class="bet_all_three_middle"><div class="bet_all_div"><span class="bet_all_team">和局</span><span class="bet_all_bet"><span class="bet_all_bg" title="和局">*IORATIO_DMN*</span></span></div></td>
						<td id="*DMC_GID*" onClick="betEvent('*GID*','DMC','*IORATIO_DMC*','DM');" class="bet_all_three"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_DMC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: DM -->
				</table>
				<!---------- DM ---------->
				<!---------- DOU ---------->
				<table id="model_DOU" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">15 分钟盘口: 下半场开始&nbsp;- 59:59 分钟 - 大 / 小</span><span id="star_DOU" name="star_DOU" onClick="addFavorites('DOU');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: DOU -->
					<tr class="bet_all_game_h">
						<td id="*DOUO_GID*" onClick="betEvent('*GID*','DOUO','*IORATIO_DOUO*','DOU');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">大</span><span class="bet_all_middle">*RATIO_DOUO*</span><span class="bet_all_bet"><span class="bet_all_bg" title="大">*IORATIO_DOUO*</span></span></div></td>
						<td id="*DOUU_GID*" onClick="betEvent('*GID*','DOUU','*IORATIO_DOUU*','DOU');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">小</span><span class="bet_all_middle">*RATIO_DOUU*</span><span class="bet_all_bet"><span class="bet_all_bg" title="小">*IORATIO_DOUU*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: DOU -->
				</table>
				<!---------- DOU ---------->
				<!---------- DM ---------->
				<table id="model_DM" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">15 分钟盘口: 下半场开始&nbsp;- 59:59 分钟 - 独赢</span><span id="star_DM" name="star_DM" onClick="addFavorites('DM');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: DM -->
					<tr class="bet_all_game_h">
						<td id="*DMH_GID*" onClick="betEvent('*GID*','DMH','*IORATIO_DMH*','DM');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_DMH*</span></span></div></td>
						<td id="*DMN_GID*" onClick="betEvent('*GID*','DMN','*IORATIO_DMN*','DM');" class="bet_all_three_middle"><div class="bet_all_div"><span class="bet_all_team"><?=$Draw?></span><span class="bet_all_bet"><span class="bet_all_bg" title="<?=$Draw?>">*IORATIO_DMN*</span></span></div></td>
						<td id="*DMC_GID*" onClick="betEvent('*GID*','DMC','*IORATIO_DMC*','DM');" class="bet_all_three"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_DMC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: DM -->
				</table>
				<!---------- DM ---------->
				<!---------- ER ---------->
				<table id="model_ER" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">15 分钟盘口: 60:00 - 74:59 分钟 - 让球</span><span id="star_ER" name="star_ER" onClick="addFavorites('ER');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: ER -->
					<tr class="bet_all_game_h">
						<td id="*ERH_HGID*" onClick="betEvent('*GID*','ERH','*IORATIO_ERH*','ER');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_middle">*RATIO_ERH*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_ERH*</span></span></div></td>
						<td id="*ERC_HGID*" onClick="betEvent('*GID*','ERC','*IORATIO_ERC*','ER');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_middle">*RATIO_ERC*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_ERC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: ER -->
				</table>
				<!---------- ER ---------->
				<!---------- EOU ---------->
				<table id="model_EOU" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">15 分钟盘口: 60:00 - 74:59 分钟 - 大 / 小</span><span id="star_EOU" name="star_EOU" onClick="addFavorites('EOU');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: EOU -->
					<tr class="bet_all_game_h">
						<td id="*EOUO_GID*" onClick="betEvent('*GID*','EOUO','*IORATIO_EOUO*','EOU');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">大</span><span class="bet_all_middle">*RATIO_EOUO*</span><span class="bet_all_bet"><span class="bet_all_bg" title="大">*IORATIO_EOUO*</span></span></div></td>
						<td id="*EOUU_GID*" onClick="betEvent('*GID*','EOUU','*IORATIO_EOUU*','EOU');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">小</span><span class="bet_all_middle">*RATIO_EOUU*</span><span class="bet_all_bet"><span class="bet_all_bg" title="小">*IORATIO_EOUU*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: EOU -->
				</table>
				<!---------- EOU ---------->
				<!---------- EM ---------->
				<table id="model_EM" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">15 分钟盘口: 60:00 - 74:59 分钟 - 独赢</span><span id="star_EM" name="star_EM" onClick="addFavorites('EM');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: EM -->
					<tr class="bet_all_game_h">
						<td id="*EMH_GID*" onClick="betEvent('*GID*','EMH','*IORATIO_EMH*','EM');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_EMH*</span></span></div></td>
						<td id="*EMN_GID*" onClick="betEvent('*GID*','EMN','*IORATIO_EMN*','EM');" class="bet_all_three_middle"><div class="bet_all_div"><span class="bet_all_team"><?=$Draw?></span><span class="bet_all_bet"><span class="bet_all_bg" title="<?=$Draw?>">*IORATIO_EMN*</span></span></div></td>
						<td id="*EMC_GID*" onClick="betEvent('*GID*','EMC','*IORATIO_EMC*','EM');" class="bet_all_three"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_EMC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: EM -->
				</table>
				<!---------- EM ---------->
				<!---------- FR ---------->
				<table id="model_FR" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">15 分钟盘口: 75:00 分钟 - 全场 - 让球</span><span id="star_FR" name="star_FR" onClick="addFavorites('FR');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: FR -->
					<tr class="bet_all_game_h">
						<td id="*FRH_HGID*" onClick="betEvent('*GID*','FRH','*IORATIO_FRH*','FR');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_middle">*RATIO_FRH*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_FRH*</span></span></div></td>
						<td id="*FRC_HGID*" onClick="betEvent('*GID*','FRC','*IORATIO_FRC*','FR');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_middle">*RATIO_FRC*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_FRC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: FR -->
				</table>
				<!---------- FR ---------->
				<!---------- FOU ---------->
				<table id="model_FOU" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">15 分钟盘口: 75:00 分钟 - 全场 - 大 / 小</span><span id="star_FOU" name="star_FOU" onClick="addFavorites('FOU');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: FOU -->
					<tr class="bet_all_game_h">
						<td id="*FOUO_GID*" onClick="betEvent('*GID*','FOUO','*IORATIO_FOUO*','FOU');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">大</span><span class="bet_all_middle">*RATIO_FOUO*</span><span class="bet_all_bet"><span class="bet_all_bg" title="大">*IORATIO_FOUO*</span></span></div></td>
						<td id="*FOUU_GID*" onClick="betEvent('*GID*','FOUU','*IORATIO_FOUU*','FOU');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">小</span><span class="bet_all_middle">*RATIO_FOUU*</span><span class="bet_all_bet"><span class="bet_all_bg" title="小">*IORATIO_FOUU*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: FOU -->
				</table>
				<!---------- FOU ---------->
				<!---------- FM ---------->
				<table id="model_FM" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">15 分钟盘口: 75:00 分钟 - 全场 - 独赢</span><span id="star_FM" name="star_FM" onClick="addFavorites('FM');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: FM -->
					<tr class="bet_all_game_h">
						<td id="*FMH_GID*" onClick="betEvent('*GID*','FMH','*IORATIO_FMH*','FM');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_FMH*</span></span></div></td>
						<td id="*FMN_GID*" onClick="betEvent('*GID*','FMN','*IORATIO_FMN*','FM');" class="bet_all_three_middle"><div class="bet_all_div"><span class="bet_all_team">和局</span><span class="bet_all_bet"><span class="bet_all_bg" title="和局">*IORATIO_FMN*</span></span></div></td>
						<td id="*FMC_GID*" onClick="betEvent('*GID*','FMC','*IORATIO_FMC*','FM');" class="bet_all_three"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_FMC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: FM -->
				</table>
				<!---------- FM ---------->
				<!---------- PD ---------->
				<table id="model_PD" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="5"><span class="bet_all_name"><?=$bodan?></span><span id="star_PD" name="star_PD" onClick="addFavorites('PD');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: PD -->
					<tr class="bet_all_team_title">
						<td colspan="2" class="bet_all_col5_w">*TEAM_H*</td>
						<td class="bet_all_coldraw_w"><?=$Draw?></td>
						<td colspan="2" class="bet_all_col5_w">*TEAM_C*</td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*H1C0_GID*" onClick="betEvent('*GID*','H1C0','*IORATIO_H1C0*','PD');" class="bet_all_five_left"><span class="bet_all_any_text">1 - 0</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_H1C0*</span></span></td>
						<td id="*H2C0_GID*" onClick="betEvent('*GID*','H2C0','*IORATIO_H2C0*','PD');" class="bet_all_five_left"><span class="bet_all_any_text">2 - 0</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_H2C0*</span></span></td>
						<td id="*H0C0_GID*" onClick="betEvent('*GID*','H0C0','*IORATIO_H0C0*','PD');" class="bet_all_five_left"><span class="bet_all_any_text">0 - 0</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_H0C0*</span></span></td>
						<td id="*H0C1_GID*" onClick="betEvent('*GID*','H0C1','*IORATIO_H0C1*','PD');" class="bet_all_five_left"><span class="bet_all_any_text">0 - 1</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_H0C1*</span></span></td>
						<td id="*H0C2_GID*" onClick="betEvent('*GID*','H0C2','*IORATIO_H0C2*','PD');" class="bet_all_five"><span class="bet_all_any_text">0 - 2</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_H0C2*</span></span></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*H2C1_GID*" onClick="betEvent('*GID*','H2C1','*IORATIO_H2C1*','PD');" class="bet_all_five_left"><span class="bet_all_any_text">2 - 1</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_H2C1*</span></span></td>
						<td id="*H3C0_GID*" onClick="betEvent('*GID*','H3C0','*IORATIO_H3C0*','PD');" class="bet_all_five_left"><span class="bet_all_any_text">3 - 0</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_H3C0*</span></span></td>
						<td id="*H1C1_GID*" onClick="betEvent('*GID*','H1C1','*IORATIO_H1C1*','PD');" class="bet_all_five_left"><span class="bet_all_any_text">1 - 1</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_H1C1*</span></span></td>
						<td id="*H1C2_GID*" onClick="betEvent('*GID*','H1C2','*IORATIO_H1C2*','PD');" class="bet_all_five_left"><span class="bet_all_any_text">1 - 2</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_H1C2*</span></span></td>
						<td id="*H0C3_GID*" onClick="betEvent('*GID*','H0C3','*IORATIO_H0C3*','PD');" class="bet_all_five"><span class="bet_all_any_text">0 - 3</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_H0C3*</span></span></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*H3C1_GID*" onClick="betEvent('*GID*','H3C1','*IORATIO_H3C1*','PD');" class="bet_all_five_left"><span class="bet_all_any_text">3 - 1</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_H3C1*</span></span></td>
						<td id="*H3C2_GID*" onClick="betEvent('*GID*','H3C2','*IORATIO_H3C2*','PD');" class="bet_all_five_left"><span class="bet_all_any_text">3 - 2</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_H3C2*</span></span></td>
						<td id="*H2C2_GID*" onClick="betEvent('*GID*','H2C2','*IORATIO_H2C2*','PD');" class="bet_all_five_left"><span class="bet_all_any_text">2 - 2</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_H2C2*</span></span></td>
						<td id="*H1C3_GID*" onClick="betEvent('*GID*','H1C3','*IORATIO_H1C3*','PD');" class="bet_all_five_left"><span class="bet_all_any_text">1 - 3</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_H1C3*</span></span></td>
						<td id="*H2C3_GID*" onClick="betEvent('*GID*','H2C3','*IORATIO_H2C3*','PD');" class="bet_all_five"><span class="bet_all_any_text">2 - 3</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_H2C3*</span></span></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*H4C0_GID*" onClick="betEvent('*GID*','H4C0','*IORATIO_H4C0*','PD');" class="bet_all_five_left"><span class="bet_all_any_text">4 - 0</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_H4C0*</span></span></td>
						<td id="*H4C1_GID*" onClick="betEvent('*GID*','H4C1','*IORATIO_H4C1*','PD');" class="bet_all_five_left"><span class="bet_all_any_text">4 - 1</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_H4C1*</span></span></td>
						<td id="*H3C3_GID*" onClick="betEvent('*GID*','H3C3','*IORATIO_H3C3*','PD');" class="bet_all_five_left"><span class="bet_all_any_text">3 - 3</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_H3C3*</span></span></td>
						<td id="*H0C4_GID*" onClick="betEvent('*GID*','H0C4','*IORATIO_H0C4*','PD');" class="bet_all_five_left"><span class="bet_all_any_text">0 - 4</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_H0C4*</span></span></td>
						<td id="*H1C4_GID*" onClick="betEvent('*GID*','H1C4','*IORATIO_H1C4*','PD');" class="bet_all_five"><span class="bet_all_any_text">1 - 4</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_H1C4*</span></span></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*H4C2_GID*" onClick="betEvent('*GID*','H4C2','*IORATIO_H4C2*','PD');" class="bet_all_five_left"><span class="bet_all_any_text">4 - 2</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_H4C2*</span></span></td>
						<td id="*H4C3_GID*" onClick="betEvent('*GID*','H4C3','*IORATIO_H4C3*','PD');" class="bet_all_five_left"><span class="bet_all_any_text">4 - 3</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_H4C3*</span></span></td>
						<td id="*H4C4_GID*" onClick="betEvent('*GID*','H4C4','*IORATIO_H4C4*','PD');" class="bet_all_five_left"><span class="bet_all_any_text">4 - 4</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_H4C4*</span></span></td>
						<td id="*H2C4_GID*" onClick="betEvent('*GID*','H2C4','*IORATIO_H2C4*','PD');" class="bet_all_five_left"><span class="bet_all_any_text">2 - 4</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_H2C4*</span></span></td>
						<td id="*H3C4_GID*" onClick="betEvent('*GID*','H3C4','*IORATIO_H3C4*','PD');" class="bet_all_five"><span class="bet_all_any_text">3 - 4</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_H3C4*</span></span></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*OVH_GID*" onClick="betEvent('*GID*','OVH','*IORATIO_OVH*','PD');" colspan="5" class="bet_all_five_last"><span class="bet_all_five_other">其他比分</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_OVH*</span></span></td>
					</tr>
					<!-- END DYNAMIC BLOCK: PD -->
				</table>
				<!---------- PD ---------->
				<!---------- HPD ---------->
				<table id="model_HPD" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="5"><span class="bet_all_name"><?=$bodan?><tt class="bet_name_color">&nbsp;- <?=$shangbanchang?></tt></span><span id="star_HPD" name="star_HPD" onClick="addFavorites('HPD');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: HPD -->
					<tr class="bet_all_team_title">
						<td colspan="2" class="bet_all_col5_w">*TEAM_H*</td>
						<td class="bet_all_coldraw_w"><?=$Draw?></td>
						<td colspan="2" class="bet_all_col5_w">*TEAM_C*</td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*HH1C0_HGID*" onClick="betEvent('*HGID*','HH1C0','*IORATIO_HH1C0*','HPD');" class="bet_all_five_left"><span class="bet_all_any_text">1 - 0</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HH1C0*</span></span></td>
						<td id="*HH2C0_HGID*" onClick="betEvent('*HGID*','HH2C0','*IORATIO_HH2C0*','HPD');" class="bet_all_five_left"><span class="bet_all_any_text">2 - 0</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HH2C0*</span></span></td>
						<td id="*HH0C0_HGID*" onClick="betEvent('*HGID*','HH0C0','*IORATIO_HH0C0*','HPD');" class="bet_all_five_left"><span class="bet_all_any_text">0 - 0</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HH0C0*</span></span></td>
						<td id="*HH0C1_HGID*" onClick="betEvent('*HGID*','HH0C1','*IORATIO_HH0C1*','HPD');" class="bet_all_five_left"><span class="bet_all_any_text">0 - 1</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HH0C1*</span></span></td>
						<td id="*HH0C2_HGID*" onClick="betEvent('*HGID*','HH0C2','*IORATIO_HH0C2*','HPD');" class="bet_all_five"><span class="bet_all_any_text">0 - 2</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HH0C2*</span></span></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*HH2C1_HGID*" onClick="betEvent('*HGID*','HH2C1','*IORATIO_HH2C1*','HPD');" class="bet_all_five_left"><span class="bet_all_any_text">2 - 1</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HH2C1*</span></span></td>
						<td id="*HH3C0_HGID*" onClick="betEvent('*HGID*','HH3C0','*IORATIO_HH3C0*','HPD');" class="bet_all_five_left"><span class="bet_all_any_text">3 - 0</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HH3C0*</span></span></td>
						<td id="*HH1C1_HGID*" onClick="betEvent('*HGID*','HH1C1','*IORATIO_HH1C1*','HPD');" class="bet_all_five_left"><span class="bet_all_any_text">1 - 1</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HH1C1*</span></span></td>
						<td id="*HH1C2_HGID*" onClick="betEvent('*HGID*','HH1C2','*IORATIO_HH1C2*','HPD');" class="bet_all_five_left"><span class="bet_all_any_text">1 - 2</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HH1C2*</span></span></td>
						<td id="*HH0C3_HGID*" onClick="betEvent('*HGID*','HH0C3','*IORATIO_HH0C3*','HPD');" class="bet_all_five"><span class="bet_all_any_text">0 - 3</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HH0C3*</span></span></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*HH3C1_HGID*" onClick="betEvent('*HGID*','HH3C1','*IORATIO_HH3C1*','HPD');" class="bet_all_five_left"><span class="bet_all_any_text">3 - 1</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HH3C1*</span></span></td>
						<td id="*HH3C2_HGID*" onClick="betEvent('*HGID*','HH3C2','*IORATIO_HH3C2*','HPD');" class="bet_all_five_left"><span class="bet_all_any_text">3 - 2</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HH3C2*</span></span></td>
						<td id="*HH2C2_HGID*" onClick="betEvent('*HGID*','HH2C2','*IORATIO_HH2C2*','HPD');" class="bet_all_five_left"><span class="bet_all_any_text">2 - 2</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HH2C2*</span></span></td>
						<td id="*HH1C3_HGID*" onClick="betEvent('*HGID*','HH1C3','*IORATIO_HH1C3*','HPD');" class="bet_all_five_left"><span class="bet_all_any_text">1 - 3</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HH1C3*</span></span></td>
						<td id="*HH2C3_HGID*" onClick="betEvent('*HGID*','HH2C3','*IORATIO_HH2C3*','HPD');" class="bet_all_five"><span class="bet_all_any_text">2 - 3</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HH2C3*</span></span></td>
					</tr>
					<tr class="bet_all_game_h">
						<td class="bet_all_five_left"></td>
						<td class="bet_all_five_left"></td>
						<td id="*HH3C3_HGID*" onClick="betEvent('*HGID*','HH3C3','*IORATIO_HH3C3*','HPD');" class="bet_all_five_left"><span class="bet_all_any_text">3 - 3</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HH3C3*</span></span></td>
						<td class="bet_all_five_left"></td>
						<td class="bet_all_five"></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*HOVH_HGID*" onClick="betEvent('*HGID*','HOVH','*IORATIO_HOVH*','HPD');" colspan="5" class="bet_all_five_last"><span class="bet_all_five_other">其他比分</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HOVH*</span></span></td>
					</tr>
					<!-- END DYNAMIC BLOCK: HPD -->
				</table>
				<!---------- HPD ---------->
				<!---------- T ---------->
				<table id="model_T" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="5"><span class="bet_all_name"><?=$dans?></span><span id="star_T" name="star_T" onClick="addFavorites('T');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: T -->
					<tr class="bet_all_game_h">
						<td id="*T01_GID*" onClick="betEvent('*GID*','0~1','*IORATIO_T01*','T');" class="bet_all_four_left"><span class="bet_all_any_text">0 - 1</span><span class="bet_all_any_bold"><span class="bet_all_bg" title="0 - 1">*IORATIO_T01*</span></span></td>
						<td id="*T23_GID*" onClick="betEvent('*GID*','2~3','*IORATIO_T23*','T');" class="bet_all_four_left"><span class="bet_all_any_text">2 - 3</span><span class="bet_all_any_bold"><span class="bet_all_bg" title="2 - 3">*IORATIO_T23*</span></span></td>
						<td id="*T46_GID*" onClick="betEvent('*GID*','4~6','*IORATIO_T46*','T');" class="bet_all_four_left"><span class="bet_all_any_text">4 - 6</span><span class="bet_all_any_bold"><span class="bet_all_bg" title="4 - 6">*IORATIO_T46*</span></span></td>
						<td id="*OVER_GID*" onClick="betEvent('*GID*','OVER','*IORATIO_OVER*','T');" class="bet_all_four"><span class="bet_all_any_text_long"><?=$qi?></span><span class="bet_all_any_bold"><span class="bet_all_bg" title="<?=$qi?>">*IORATIO_OVER*</span></span></td>
					</tr>
					<!-- END DYNAMIC BLOCK: T -->
				</table>
				<!---------- T ---------->
				<!---------- HT ---------->
				<table id="model_HT" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="5"><span class="bet_all_name"><?=$dans?><tt class="bet_name_color">&nbsp;- <?=$shangbanchang?></tt></span><span id="star_HT" name="star_HT" onClick="addFavorites('HT');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: HT -->
					<tr class="bet_all_game_h">
						<td id="*HT0_HGID*" onClick="betEvent('*HGID*','HT0','*IORATIO_HT0*','HT');" class="bet_all_four_left"><span class="bet_all_any_text">0</span><span class="bet_all_any_bold"><span class="bet_all_bg" title="0">*IORATIO_HT0*</span></span></td>
						<td id="*HT1_HGID*" onClick="betEvent('*HGID*','HT1','*IORATIO_HT1*','HT');" class="bet_all_four_left"><span class="bet_all_any_text">1</span><span class="bet_all_any_bold"><span class="bet_all_bg" title="1">*IORATIO_HT1*</span></span></td>
						<td id="*HT2_HGID*" onClick="betEvent('*HGID*','HT2','*IORATIO_HT2*','HT');" class="bet_all_four_left"><span class="bet_all_any_text">2</span><span class="bet_all_any_bold"><span class="bet_all_bg" title="2">*IORATIO_HT2*</span></span></td>
						<td id="*HTOV_HGID*" onClick="betEvent('*HGID*','HTOV','*IORATIO_HTOV*','HT');" class="bet_all_four"><span class="bet_all_any_text_long">3<tt class="bet_all_text_small">或以上</tt></span><span class="bet_all_any_bold"><span class="bet_all_bg" title="3或以上">*IORATIO_HTOV*</span></span></td>
					</tr>
					<!-- END DYNAMIC BLOCK: HT -->
				</table>
				<!---------- HT ---------->
				<!---------- F ---------->
				<table id="model_F" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">半场 / 全场</span><span id="star_F" name="star_F" onClick="addFavorites('F');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: F -->
					<tr class="bet_all_game_h">
						<td id="*FHH_GID*" onClick="betEvent('*GID*','FHH','*IORATIO_FHH*','F');" class="bet_all_three_left_2"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H* / *TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg" title="*TEAM_H* / *TEAM_H*">*IORATIO_FHH*</span></span></div></td>
						<td id="*FNH_GID*" onClick="betEvent('*GID*','FNH','*IORATIO_FNH*','F');" class="bet_all_three_left_2"><div class="bet_all_div"><span class="bet_all_team">和局 / *TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg" title="和局 / *TEAM_H*">*IORATIO_FNH*</span></span></div></td>
						<td id="*FCH_GID*" onClick="betEvent('*GID*','FCH','*IORATIO_FCH*','F');" class="bet_all_three_2"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C* / *TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg" title="*TEAM_C* / *TEAM_H*">*IORATIO_FCH*</span></span></div></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*FHN_GID*" onClick="betEvent('*GID*','FHN','*IORATIO_FHN*','F');" class="bet_all_three_left_2"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H* / 和局</span><span class="bet_all_bet"><span class="bet_all_bg" title="*TEAM_H* / 和局">*IORATIO_FHN*</span></span></div></td>
						<td id="*FNN_GID*" onClick="betEvent('*GID*','FNN','*IORATIO_FNN*','F');" class="bet_all_three_left_2"><div class="bet_all_div"><span class="bet_all_team">和局 / 和局</span><span class="bet_all_bet"><span class="bet_all_bg" title="和局 / 和局">*IORATIO_FNN*</span></span></div></td>
						<td id="*FCN_GID*" onClick="betEvent('*GID*','FCN','*IORATIO_FCN*','F');" class="bet_all_three_2"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C* / 和局</span><span class="bet_all_bet"><span class="bet_all_bg" title="*TEAM_C* / 和局">*IORATIO_FCN*</span></span></div></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*FHC_GID*" onClick="betEvent('*GID*','FHC','*IORATIO_FHC*','F');"  class="bet_all_three_left_2"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H* / *TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg" title="*TEAM_H* / *TEAM_C*">*IORATIO_FHC*</span></span></div></td>
						<td id="*FNC_GID*" onClick="betEvent('*GID*','FNC','*IORATIO_FNC*','F');"  class="bet_all_three_left_2"><div class="bet_all_div"><span class="bet_all_team">和局 / *TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg" title="和局 / *TEAM_C*">*IORATIO_FNC*</span></span></div></td>
						<td id="*FCC_GID*" onClick="betEvent('*GID*','FCC','*IORATIO_FCC*','F');"  class="bet_all_three_2"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C* / *TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg" title="*TEAM_C* / *TEAM_C*">*IORATIO_FCC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: F -->
				</table>
				<!---------- F ---------->
				<!---------- WM ---------->
				<table id="model_WM" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">净胜球数</span><span id="star_WM" name="star_WM" onClick="addFavorites('WM');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: WM -->
					<tr class="bet_all_team_title">
						<td class="bet_all_col5_w">*TEAM_H*</td>
						<td class="bet_all_coldraw_w">和局</td>
						<td class="bet_all_col5_w">*TEAM_C*</td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*WMH1_GID*" onClick="betEvent('*GID*','WMH1','*IORATIO_WMH1*','WM');" class="bet_all_three_left_2"><div class="bet_all_div"><span class="bet_all_team">净胜1球</span><span class="bet_all_bet"><span class="bet_all_bg" title="净胜1球">*IORATIO_WMH1*</span></span></div></td>
						<td id="*WM0_GID*" onClick="betEvent('*GID*','WM0','*IORATIO_WM0*','WM');" class="bet_all_three_left_2"><div class="bet_all_div"><span class="bet_all_team">0 - 0 和局</span><span class="bet_all_bet"><span class="bet_all_bg" title="0 - 0 和局">*IORATIO_WM0*</span></span></div></td>
						<td id="*WMC1_GID*" onClick="betEvent('*GID*','WMC1','*IORATIO_WMC1*','WM');" class="bet_all_three_2"><div class="bet_all_div"><span class="bet_all_team">净胜1球</span><span class="bet_all_bet"><span class="bet_all_bg" title="净胜1球">*IORATIO_WMC1*</span></span></div></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*WMH2_GID*" onClick="betEvent('*GID*','WMH2','*IORATIO_WMH2*','WM');"class="bet_all_three_left_2"><div class="bet_all_div"><span class="bet_all_team">净胜2球</span><span class="bet_all_bet"><span class="bet_all_bg" title="净胜2球">*IORATIO_WMH2*</span></span></div></td>
						<td id="*WMN_GID*" onClick="betEvent('*GID*','WMN','*IORATIO_WMN*','WM');"class="bet_all_three_left_2"><div class="bet_all_div"><span class="bet_all_team">任何进球和局</span><span class="bet_all_bet"><span class="bet_all_bg" title="任何进球和局">*IORATIO_WMN*</span></span></div></td>
						<td id="*WMC2_GID*" onClick="betEvent('*GID*','WMC2','*IORATIO_WMC2*','WM');"class="bet_all_three_2"><div class="bet_all_div"><span class="bet_all_team">净胜2球</span><span class="bet_all_bet"><span class="bet_all_bg" title="净胜2球">*IORATIO_WMC2*</span></span></div></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*WMH3_GID*" onClick="betEvent('*GID*','WMH3','*IORATIO_WMH3*','WM');" class="bet_all_three_left_2"><div class="bet_all_div"><span class="bet_all_team">净胜3球</span><span class="bet_all_bet"><span class="bet_all_bg" title="净胜3球">*IORATIO_WMH3*</span></span></div></td>
						<td class="bet_all_three_left_2"></td>
						<td id="*WMC3_GID*" onClick="betEvent('*GID*','WMC3','*IORATIO_WMC3*','WM');" class="bet_all_three_2"><div class="bet_all_div"><span class="bet_all_team">净胜3球</span><span class="bet_all_bet"><span class="bet_all_bg" title="净胜3球">*IORATIO_WMC3*</span></span></div></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*WMHOV_GID*" onClick="betEvent('*GID*','WMHOV','*IORATIO_WMHOV*','WM');" class="bet_all_three_left_2"><div class="bet_all_div"><span class="bet_all_team">净胜4球或更多</span><span class="bet_all_bet"><span class="bet_all_bg" title="净胜4球或更多">*IORATIO_WMHOV*</span></span></div></td>
						<td class="bet_all_three_left_2"></td>
						<td id="*WMCOV_GID*" onClick="betEvent('*GID*','WMCOV','*IORATIO_WMCOV*','WM');" class="bet_all_three_2"><div class="bet_all_div"><span class="bet_all_team">净胜4球或更多</span><span class="bet_all_bet"><span class="bet_all_bg" title="净胜4球或更多">*IORATIO_WMCOV*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: WM -->
				</table>
				<!---------- WM ---------->
				<!---------- DC ---------->
				<table id="model_DC" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">双重机会</span><span id="star_DC" name="star_DC" onClick="addFavorites('DC');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: DC -->
					<tr class="bet_all_game_h">
						<td id="*DCHN_GID*" onClick="betEvent('*GID*','DCHN','*IORATIO_DCHN*','DC');" class="bet_all_one"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H* / 和局</span><span class="bet_all_bet"><span class="bet_all_bg" title="*TEAM_H* / 和局">*IORATIO_DCHN*</span></span></div></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*DCCN_GID*" onClick="betEvent('*GID*','DCCN','*IORATIO_DCCN*','DC');" class="bet_all_one"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C* / 和局</span><span class="bet_all_bet"><span class="bet_all_bg" title="*TEAM_C* / 和局">*IORATIO_DCCN*</span></span></div></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*DCHC_GID*" onClick="betEvent('*GID*','DCHC','*IORATIO_DCHC*','DC');" class="bet_all_one"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H* / *TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg" title="*TEAM_H* / *TEAM_C*">*IORATIO_DCHC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: DC -->
				</table>
				<!---------- DC ---------->
				<!---------- W3 ---------->
				<table id="model_W3" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name"><?=$xiang3rangqiutouzhu?></span><span id="star_W3" name="star_W3" onClick="addFavorites('W3');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: W3 -->
					<tr class="bet_all_game_h">
						<td id="*W3H_GID*" onClick="betEvent('*GID*','W3H','*IORATIO_W3H*','W3');" class="bet_all_one"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*<span class="bet_all_3way">*RATIO_W3H*</span></span><span class="bet_all_bet"><span class="bet_all_bg" title="*TEAM_H*">*IORATIO_W3H*</span></span></div></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*W3C_GID*" onClick="betEvent('*GID*','W3C','*IORATIO_W3C*','W3');" class="bet_all_one"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*<span class="bet_all_3way">*RATIO_W3C*</span></span><span class="bet_all_bet"><span class="bet_all_bg" title="*TEAM_C*">*IORATIO_W3C*</span></span></div></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*W3N_GID*" onClick="betEvent('*GID*','W3N','*IORATIO_W3N*','W3');" class="bet_all_one"><div class="bet_all_div"><span class="bet_all_team">让球和局<span class="bet_all_3way">*RATIO_W3N*</span></span><span class="bet_all_bet"><span class="bet_all_bg" title="让球和局">*IORATIO_W3N*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: W3 -->
				</table>
				<!---------- W3 ---------->
				<!---------- BH ---------->
				<table id="model_BH" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name"><?=$louhoufanchao?></span><span id="star_BH" name="star_BH" onClick="addFavorites('BH');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: BH -->
					<tr class="bet_all_game_h">
						<td id="*BHH_GID*" onClick="betEvent('*GID*','BHH','*IORATIO_BHH*','BH');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_BHH*</span></span></div></td>
						<td id="*BHC_GID*" onClick="betEvent('*GID*','BHC','*IORATIO_BHC*','BH');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_BHC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: BH -->
				</table>
				<!---------- BH ---------->
				<!---------- WE ---------->
				<table id="model_WE" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name"><?=$yingderenyibanqiu?></span><span id="star_WE" name="star_WE" onClick="addFavorites('WE');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: WE -->
					<tr class="bet_all_game_h">
						<td id="*WEH_GID*" onClick="betEvent('*GID*','WEH','*IORATIO_WEH*','WE');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_WEH*</span></span></div></td>
						<td id="*WEC_GID*" onClick="betEvent('*GID*','WEC','*IORATIO_WEC*','WE');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_WEC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: WE -->
				</table>
				<!---------- WE ---------->
				<!---------- WB ---------->
				<table id="model_WB" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name"><?=$yingdesuoyoubanchang?></span><span id="star_WB" name="star_WB" onClick="addFavorites('WB');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: WB -->
					<tr class="bet_all_game_h">
						<td id="*WBH_GID*" onClick="betEvent('*GID*','WBH','*IORATIO_WBH*','WB');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_WBH*</span></span></div></td>

						<td id="*WBC_GID*" onClick="betEvent('*GID*','WBC','*IORATIO_WBC*','WB');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_WBC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: WB -->
				</table>
				<!---------- WB ---------->
				<!---------- PG ---------->
				<table id="model_PG" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name"><?=$zuixianzuihoujinqiu?></span><span id="star_PG" name="star_PG" onClick="addFavorites('PG');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: PG -->
					<tr class="bet_all_team_title">
						<td><?=$zuixianjinqiu?></td>
						<td><?=$zuihoujinqiu?></td>
						<td><?=$wujinqiu?></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*PGFH_GID*" onClick="betEvent('*GID*','PGFH','*IORATIO_PGFH*','SP');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_PGFH*</span></span></div></td>
						<td id="*PGLH_GID*" onClick="betEvent('*GID*','PGLH','*IORATIO_PGLH*','SP');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_PGLH*</span></span></div></td>
						<td rowspan="2" id="*PGFN_GID*" onClick="betEvent('*GID*','PGFN','*IORATIO_PGFN*','SP');" class="bet_all_three"><div class="bet_all_div"><span class="bet_all_team">无进球</span><span class="bet_all_bet"><span class="bet_all_bg" title="无进球">*IORATIO_PGFN*</span></span></div></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*PGFC_GID*" onClick="betEvent('*GID*','PGFC','*IORATIO_PGFC*','SP');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_PGFC*</span></span></div></td>
						<td id="*PGLC_GID*" onClick="betEvent('*GID*','PGLC','*IORATIO_PGLC*','SP');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_PGLC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: PG -->
				</table>
				<!---------- PG ---------->
				<!---------- RC ---------->
				<table id="model_RC" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name"><?=$huibuhuijinqiu?></span><span id="star_RC" name="star_RC" onClick="addFavorites('RC');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: RC -->
					<tr class="bet_all_team_title">
						<td><?=$huijinqiu?></td>
						<td><?=$buhuijinqiu?></td>
					</tr>

					<tr class="bet_all_game_h">
						<td id="*RCFH_GID*" onClick="betEvent('*GID*','RCFH','*IORATIO_RCFH*','SP');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_RCFH*</span></span></div></td>
						<td id="*RCLH_GID*" onClick="betEvent('*GID*','RCLH','*IORATIO_RCLH*','SP');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_RCLH*</span></span></div></td>
					</tr>

					<tr class="bet_all_game_h">
						<td id="*RCFC_GID*" onClick="betEvent('*GID*','RCFC','*IORATIO_RCFC*','SP');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_RCFC*</span></span></div></td>
						<td id="*RCLC_GID*" onClick="betEvent('*GID*','RCLC','*IORATIO_RCLC*','SP');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_RCLC*</span></span></div></td>
					</tr>

					<!-- END DYNAMIC BLOCK: RC -->

				</table>
				<!---------- RC ---------->
				<!---------- TS ---------->
				<table id="model_TS" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name"><?=$shaungfangqiudui?></span><span id="star_TS" name="star_TS" onClick="addFavorites('TS');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: TS -->
					<tr class="bet_all_game_h">
						<td id="*TSY_GID*" onClick="betEvent('*GID*','TSY','*IORATIO_TSY*','TS');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">是</span><span class="bet_all_bet"><span class="bet_all_bg" title="是">*IORATIO_TSY*</span></span></div></td>
						<td id="*TSN_GID*" onClick="betEvent('*GID*','TSN','*IORATIO_TSN*','TS');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">不是</span><span class="bet_all_bet"><span class="bet_all_bg" title="不是">*IORATIO_TSN*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: TS -->
				</table>
				<!---------- TS ---------->
				<!---------- OUH ---------->
				<table id="model_OUH" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name"><?=$qiuduiruqiushu?>: <tt class="bet_name_color">*TEAM_H*</tt> -  <?=$ou?></span><span id="star_OUH" name="star_OUH" onClick="addFavorites('OUH');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: OUH -->
					<tr class="bet_all_game_h">
						<td id="*OUHO_GID*" onClick="betEvent('*GID*','OUHO','*IORATIO_OUHO*','OUH');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">大</span><span class="bet_all_middle">*RATIO_OUHO*</span><span class="bet_all_bet"><span class="bet_all_bg" title="大">*IORATIO_OUHO*</span></span></div></td>
						<td id="*OUHU_GID*" onClick="betEvent('*GID*','OUHU','*IORATIO_OUHU*','OUH');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">小</span><span class="bet_all_middle">*RATIO_OUHU*</span><span class="bet_all_bet"><span class="bet_all_bg" title="小">*IORATIO_OUHU*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: OUH -->
				</table>
				<!---------- OUH ---------->
				<!---------- OUC ---------->
				<table id="model_OUC" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name"><?=$qiuduiruqiushu?>: <tt class="bet_name_color">*TEAM_C*</tt> - <?=$ou?></span><span id="star_OUC" name="star_OUC" onClick="addFavorites('OUC');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: OUC -->
					<tr class="bet_all_game_h">
						<td id="*OUCO_GID*" onClick="betEvent('*GID*','OUCO','*IORATIO_OUCO*','OUC');" class="bet_all_two_left">
							<div class="bet_all_div">
								<span class="bet_all_team">大</span>
								<span class="bet_all_middle">*RATIO_OUCO*</span>
								<span class="bet_all_bet"><span class="bet_all_bg" title="大">*IORATIO_OUCO*</span></span>
							</div>
						</td>
						<td id="*OUCU_GID*" onClick="betEvent('*GID*','OUCU','*IORATIO_OUCU*','OUC');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">小</span><span class="bet_all_middle">*RATIO_OUCO*</span><span class="bet_all_bet"><span class="bet_all_bg" title="小">*IORATIO_OUCU*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: OUC -->
				</table>
				<!---------- OUC ---------->
				<!---------- HOUH ---------->
				<table id="model_HOUH" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name"><?=$qiuduiruqiushu?>: <tt class="bet_name_color">*TEAM_H*</tt> -  <?=$ou?><tt class="bet_name_color">&nbsp;- <?=$shangbanchang?></tt></span><span id="star_HOUH" name="star_HOUH" onClick="addFavorites('HOUH');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: HOUH -->
					<tr class="bet_all_game_h">
						<td id="*HOUHO_HGID*" onClick="betEvent('*HGID*','HOUHO','*IORATIO_HOUHO*','HOUH');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">大</span><span class="bet_all_middle">*RATIO_HOUHO*</span><span class="bet_all_bet"><span class="bet_all_bg" title="大">*IORATIO_HOUHO*</span></span></div></td>
						<td id="*HOUHU_HGID*" onClick="betEvent('*HGID*','HOUHU','*IORATIO_HOUHU*','HOUH');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">小</span><span class="bet_all_middle">*RATIO_HOUHU*</span><span class="bet_all_bet"><span class="bet_all_bg" title="小">*IORATIO_HOUHU*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: HOUH -->
				</table>
				<!---------- HOUH ---------->
				<!---------- HOUC ---------->
				<table id="model_HOUC" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">球队进球数: <tt class="bet_name_color">*TEAM_C*</tt> -  大 / 小<tt class="bet_name_color">&nbsp;- 上半场</tt></span><span id="star_HOUC" name="star_HOUC" onClick="addFavorites('HOUC');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: HOUC -->
					<tr class="bet_all_game_h">
						<td id="*HOUCO_HGID*" onClick="betEvent('*HGID*','HOUCO','*IORATIO_HOUCO*','HOUC');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">大</span><span class="bet_all_middle">*RATIO_HOUCO*</span><span class="bet_all_bet"><span class="bet_all_bg" title="大">*IORATIO_HOUCO*</span></span></div></td>
						<td id="*HOUCU_HGID*" onClick="betEvent('*HGID*','HOUCU','*IORATIO_HOUCU*','HOUC');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">小</span><span class="bet_all_middle">*RATIO_HOUCO*</span><span class="bet_all_bet"><span class="bet_all_bg" title="小">*IORATIO_HOUCU*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: HOUC -->
				</table>
				<!---------- HOUC ---------->
				<!---------- EO ---------->
				<table id="model_EO" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">单 / 双</span><span id="star_EO" name="star_EO" onClick="addFavorites('EO');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: EO -->
					<tr class="bet_all_game_h">
						<td id="*EOO_GID*" onClick="betEvent('*GID*','ODD','*IORATIO_EOO*','EO');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">单</span><span class="bet_all_bet"><span class="bet_all_bg" title="单">*IORATIO_EOO*</span></span></div></td>
						<td id="*EOE_GID*" onClick="betEvent('*GID*','EVEN','*IORATIO_EOE*','EO');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">双</span><span class="bet_all_bet"><span class="bet_all_bg" title="双">*IORATIO_EOE*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: EO -->
				</table>
				<!---------- EO ---------->
				<!---------- HEO ---------->
				<table id="model_HEO" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">单 / 双<tt class="bet_name_color"> - 上半场</tt></span><span id="star_HEO" name="star_HEO" onClick="addFavorites('HEO');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: HEO -->
					<tr class="bet_all_game_h">
						<td id="*HEOO_HGID*" onClick="betEvent('*HGID*','HODD','*IORATIO_HEOO*','HEO');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">单</span><span class="bet_all_bet"><span class="bet_all_bg" title="单">*IORATIO_HEOO*</span></span></div></td>
						<td id="*HEOE_HGID*" onClick="betEvent('*HGID*','HEVEN','*IORATIO_HEOE*','HEO');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">双</span><span class="bet_all_bet"><span class="bet_all_bg" title="双">*IORATIO_HEOE*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: HEO -->
				</table>
				<!---------- HEO ---------->
				<!---------- SFS ---------->
				<table id="model_SFS" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">进球球员</span><span id="star_SFS" name="star_SFS" onClick="addFavorites('SFS');" class="bet_all_game_star_out"></span></td>
					</tr>
					<tr class="bet_all_team_title">
						<td class="bet_all_col2_w">*TEAM_H*</td>
						<td class="bet_all_col2_w">*TEAM_C*</td>
					</tr>
					<tr class="bet_all_player">
						<td class="bet_all_player_title"><span>球员</span><tt class="bet_all_player_First">*TITLE_A0*</tt><tt class="bet_all_player_Last">*TITLE_A1*</tt><tt class="bet_all_player_right">*TITLE_A2*</tt></td>
						<td class="bet_all_player_title"><span>球员</span><tt class="bet_all_player_First">*TITLE_B0*</tt><tt class="bet_all_player_Last">*TITLE_B1*</tt><tt class="bet_all_player_right">*TITLE_B2*</tt></td>
					</tr>
					<!-- START DYNAMIC BLOCK: SFS -->
					<tr class="bet_all_game_h">
						<td class="bet_all_two_left"><div class="bet_all_div">
								<span class="bet_all_team_sf">*SFS_NAME_A0*</span>
                    <span class="bet_all_bet_player">
                       <span class="bet_all_sfs_w"><span id="*RTYPE_SGIDA0*" onClick="betEvent('*SFS_GID_A0*','*SFS_RTYPE_A0*','*SFS_IOR_A0*','NFS');" class="bet_all_bg" *TITLE_SFS_NAME_A0*>*SFS_IOR_A0*</span></span>
                       <span class="bet_all_sfs_w"><span id="*RTYPE_SGIDA1*" onClick="betEvent('*SFS_GID_A1*','*SFS_RTYPE_A1*','*SFS_IOR_A1*','NFS');" class="bet_all_bg" *TITLE_SFS_NAME_A0*>*SFS_IOR_A1*</span></span>
                       <span class="bet_all_sfs_w"><span id="*RTYPE_SGIDA2*" onClick="betEvent('*SFS_GID_A2*','*SFS_RTYPE_A2*','*SFS_IOR_A2*','NFS');" class="bet_all_bg" *TITLE_SFS_NAME_A0*>*SFS_IOR_A2*</span></span>
                    </span>
							</div></td>
						<td class="bet_all_two"><div class="bet_all_div">
								<span class="bet_all_team_sf">*SFS_NAME_B0*</span>
                    <span class="bet_all_bet_player">
                       <span class="bet_all_sfs_w"><span id="*RTYPE_SGIDB0*" onClick="betEvent('*SFS_GID_B0*','*SFS_RTYPE_B0*','*SFS_IOR_B0*','NFS');" class="bet_all_bg" *TITLE_SFS_NAME_B0*>*SFS_IOR_B0*</span></span>
                       <span class="bet_all_sfs_w"><span id="*RTYPE_SGIDB1*" onClick="betEvent('*SFS_GID_B1*','*SFS_RTYPE_B1*','*SFS_IOR_B1*','NFS');" class="bet_all_bg" *TITLE_SFS_NAME_B0*>*SFS_IOR_B1*</span></span>
                       <span class="bet_all_sfs_w"><span id="*RTYPE_SGIDB2*" onClick="betEvent('*SFS_GID_B2*','*SFS_RTYPE_B2*','*SFS_IOR_B2*','NFS');" class="bet_all_bg" *TITLE_SFS_NAME_B0*>*SFS_IOR_B2*</span></span>
                    </span>
							</div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: SFS -->
					<tr class="bet_all_player_btn *DIS_PLAY_MORE_SFS*" >
						<td id="show_more_SFS" colspan="2"><div onClick="SFS_show('more')" >显示更多</div></td>
					</tr>
					<tr class="bet_all_player_btn *DIS_PLAY_LESS_SFS*" >
						<td id="show_more_SFS" colspan="2"><div onClick="SFS_show('less')" >显示精简</div></td>
					</tr>
				</table>
				<!---------- SFS ---------->
				<!---------- CS ---------->
				<table id="model_CS" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">零失球</span><span id="star_CS" name="star_CS" onClick="addFavorites('CS');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: CS -->
					<tr class="bet_all_game_h">
						<td id="*CSH_GID*" onClick="betEvent('*GID*','CSH','*IORATIO_CSH*','CS');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_CSH*</span></span></div></td>
						<td id="*CSC_GID*" onClick="betEvent('*GID*','CSC','*IORATIO_CSC*','CS');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_CSC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: CS -->
				</table>
				<!---------- CS ---------->
				<!---------- WN ---------->
				<table id="model_WN" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">零失球获胜</span><span id="star_WN" name="star_WN" onClick="addFavorites('WN');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: WN -->
					<tr class="bet_all_game_h">
						<td id="*WNH_GID*" onClick="betEvent('*GID*','WNH','*IORATIO_WNH*','WN');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_WNH*</span></span></div></td>
						<td id="*WNC_GID*" onClick="betEvent('*GID*','WNC','*IORATIO_WNC*','WN');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_WNC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: WN -->
				</table>
				<!---------- WN ---------->
				<!---------- F2G ---------->
				<table id="model_F2G" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">先进2球的一方</span><span id="star_F2G" name="star_F2G" onClick="addFavorites('F2G');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: F2G -->
					<tr class="bet_all_game_h">
						<td id="*F2GH_GID*" onClick="betEvent('*GID*','F2GH','*IORATIO_F2GH*','F2G');" class="bet_all_one"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_F2GH*</span></span></div></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*F2GC_GID*" onClick="betEvent('*GID*','F2GC','*IORATIO_F2GC*','F2G');" class="bet_all_one"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_F2GC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: F2G -->
				</table>
				<!---------- F2G ---------->
				<!---------- F3G ---------->
				<table id="model_F3G" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">先进3球的一方</span><span id="star_F3G" name="star_F3G" onClick="addFavorites('F3G');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: F3G -->
					<tr class="bet_all_game_h">
						<td id="*F3GH_GID*" onClick="betEvent('*GID*','F3GH','*IORATIO_F3GH*','F3G');" class="bet_all_one"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_F3GH*</span></span></div></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*F3GC_GID*" onClick="betEvent('*GID*','F3GC','*IORATIO_F3GC*','F3G');" class="bet_all_one"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_F3GC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: F3G -->
				</table>
				<!---------- F3G ---------->
				<!---------- HG ---------->
				<table id="model_HG" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">最多进球的半场</span><span id="star_HG" name="star_HG" onClick="addFavorites('HG');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: HG -->
					<tr class="bet_all_game_h">
						<td id="*HGH_GID*" onClick="betEvent('*GID*','HGH','*IORATIO_HGH*','HG');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">上半场</span><span class="bet_all_bet"><span class="bet_all_bg" title="上半场">*IORATIO_HGH*</span></span></div></td>
						<td id="*HGC_GID*" onClick="betEvent('*GID*','HGC','*IORATIO_HGC*','HG');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">下半场</span><span class="bet_all_bet"><span class="bet_all_bg" title="下半场">*IORATIO_HGC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: HG -->
				</table>
				<!---------- HG ---------->
				<!---------- MG ---------->
				<table id="model_MG" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">最多进球的半场 - 独赢</span><span id="star_MG" name="star_MG" onClick="addFavorites('MG');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: MG -->
					<tr class="bet_all_game_h">
						<td id="*MGH_GID*" onClick="betEvent('*GID*','MGH','*IORATIO_MGH*','MG');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">上半场</span><span class="bet_all_bet"><span class="bet_all_bg" title="上半场">*IORATIO_MGH*</span></span></div></td>
						<td id="*MGC_GID*" onClick="betEvent('*GID*','MGC','*IORATIO_MGC*','MG');" class="bet_all_three_middle"><div class="bet_all_div"><span class="bet_all_team">下半场</span><span class="bet_all_bet"><span class="bet_all_bg" title="下半场">*IORATIO_MGC*</span></span></div></td>
						<td id="*MGN_GID*" onClick="betEvent('*GID*','MGN','*IORATIO_MGN*','MG');" class="bet_all_three"><div class="bet_all_div"><span class="bet_all_team">和局</span><span class="bet_all_bet"><span class="bet_all_bg" title="和局">*IORATIO_MGN*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: MG -->
				</table>
				<!---------- MG ---------->
				<!---------- SB ---------->
				<table id="model_SB" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">双半场进球</span><span id="star_SB" name="star_SB" onClick="addFavorites('SB');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: SB -->
					<tr class="bet_all_game_h">
						<td id="*SBH_GID*" onClick="betEvent('*GID*','SBH','*IORATIO_SBH*','SB');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_SBH*</span></span></div></td>
						<td id="*SBC_GID*" onClick="betEvent('*GID*','SBC','*IORATIO_SBC*','SB');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_SBC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: SB -->
				</table>
				<!---------- SB ---------->
				<!---------- FG ---------->
				<table id="model_FG" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">首个进球方式</span><span id="star_FG" name="star_FG" onClick="addFavorites('FG');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: FG -->
					<tr class="bet_all_game_h">
						<td id="*FGS_GID*" onClick="betEvent('*GID*','FGS','*IORATIO_FGS*','FG');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">射门</span><span class="bet_all_bet"><span class="bet_all_bg" title="射门">*IORATIO_FGS*</span></span></div></td>
						<td id="*FGH_GID*" onClick="betEvent('*GID*','FGH','*IORATIO_FGH*','FG');" class="bet_all_three_middle"><div class="bet_all_div"><span class="bet_all_team">头球</span><span class="bet_all_bet"><span class="bet_all_bg" title="头球">*IORATIO_FGH*</span></span></div></td>
						<td id="*FGN_GID*" onClick="betEvent('*GID*','FGN','*IORATIO_FGN*','FG');" class="bet_all_three"><div class="bet_all_div"><span class="bet_all_team">无进球</span><span class="bet_all_bet"><span class="bet_all_bg" title="无进球">*IORATIO_FGN*</span></span></div></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*FGP_GID*" onClick="betEvent('*GID*','FGP','*IORATIO_FGP*','FG');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">点球大战</span><span class="bet_all_bet"><span class="bet_all_bg" title="点球大战">*IORATIO_FGP*</span></span></div></td>
						<td id="*FGF_GID*" onClick="betEvent('*GID*','FGF','*IORATIO_FGF*','FG');" class="bet_all_three_middle"><div class="bet_all_div"><span class="bet_all_team">任意球</span><span class="bet_all_bet"><span class="bet_all_bg" title="任意球">*IORATIO_FGF*</span></span></div></td>
						<td id="*FGO_GID*" onClick="betEvent('*GID*','FGO','*IORATIO_FGO*','FG');" class="bet_all_three"><div class="bet_all_div"><span class="bet_all_team">乌龙球</span><span class="bet_all_bet"><span class="bet_all_bg" title="乌龙球">*IORATIO_FGO*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: FG -->
				</table>
				<!---------- FG ---------->
				<!---------- T3G ---------->
				<table id="model_T3G" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">首个进球时间-3项</span><span id="star_T3G" name="star_T3G" onClick="addFavorites('T3G');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: T3G -->
					<tr class="bet_all_game_h">
						<td id="*T3G1_GID*" onClick="betEvent('*GID*','T3G1','*IORATIO_T3G1*','T3G');" class="bet_all_one"><div class="bet_all_div"><span class="bet_all_team">第26分钟或之前</span><span class="bet_all_bet"><span class="bet_all_bg" title="第26分钟或之前">*IORATIO_T3G1*</span></span></div></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*T3G2_GID*" onClick="betEvent('*GID*','T3G2','*IORATIO_T3G2*','T3G');" class="bet_all_one"><div class="bet_all_div"><span class="bet_all_team">第27分钟或之后</span><span class="bet_all_bet"><span class="bet_all_bg" title="第27分钟或之后">*IORATIO_T3G2*</span></span></div></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*T3GN_GID*" onClick="betEvent('*GID*','T3GN','*IORATIO_T3GN*','T3G');" class="bet_all_one"><div class="bet_all_div"><span class="bet_all_team">无进球</span><span class="bet_all_bet"><span class="bet_all_bg" title="无进球">*IORATIO_T3GN*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: T3G -->
				</table>
				<!---------- T3G ---------->
				<!---------- T1G ---------->
				<table id="model_T1G" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">首个进球时间</span><span id="star_T1G" name="star_T1G" onClick="addFavorites('T1G');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: T1G -->
					<tr class="bet_all_game_h">
						<td id="*T1G1_GID*" onClick="betEvent('*GID*','T1G1','*IORATIO_T1G1*','T1G');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">上半场开场 - 14:59分钟</span><span class="bet_all_bet"><span class="bet_all_bg" title="上半场开场 - 14:59分钟">*IORATIO_T1G1*</span></span></div></td>
						<td id="*T1G2_GID*" onClick="betEvent('*GID*','T1G2','*IORATIO_T1G2*','T1G');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">15:00分钟 - 29:59分钟</span><span class="bet_all_bet"><span class="bet_all_bg" title="15:00分钟 - 29:59分钟">*IORATIO_T1G2*</span></span></div></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*T1G3_GID*" onClick="betEvent('*GID*','T1G3','*IORATIO_T1G3*','T1G');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">30:00分钟 - 半场</span><span class="bet_all_bet"><span class="bet_all_bg" title="30:00分钟 - 半场">*IORATIO_T1G3*</span></span></div></td>
						<td id="*T1G4_GID*" onClick="betEvent('*GID*','T1G4','*IORATIO_T1G4*','T1G');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">下半场开场 - 59:59分钟</span><span class="bet_all_bet"><span class="bet_all_bg" title="下半场开场 - 59:59分钟">*IORATIO_T1G4*</span></span></div></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*T1G5_GID*" onClick="betEvent('*GID*','T1G5','*IORATIO_T1G5*','T1G');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">60:00分钟 - 74:59分钟</span><span class="bet_all_bet"><span class="bet_all_bg" title="60:00分钟 - 74:59分钟">*IORATIO_T1G5*</span></span></div></td>
						<td id="*T1G6_GID*" onClick="betEvent('*GID*','T1G6','*IORATIO_T1G6*','T1G');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">75:00分钟 - 全场完场</span><span class="bet_all_bet"><span class="bet_all_bg" title="75:00分钟 - 全场完场">*IORATIO_T1G6*</span></span></div></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*T1GN_GID*" onClick="betEvent('*GID*','T1GN','*IORATIO_T1GN*','T1G');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">无进球</span><span class="bet_all_bet"><span class="bet_all_bg" title="无进球">*IORATIO_T1GN*</span></span></div></td>
						<td></td>
					</tr>
					<!-- END DYNAMIC BLOCK: T1G -->
				</table>
				<!---------- T1G ---------->
				<!---------- TK ---------->
				<table id="model_TK" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">开球球队</span><span id="star_TK" name="star_TK" onClick="addFavorites('TK');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: TK -->
					<tr class="bet_all_game_h">
						<td id="*TKH_GID*" onClick="betEvent('*GID*','TKH','*IORATIO_TKH*','TK');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_TKH*</span></span></div></td>
						<td id="*TKC_GID*" onClick="betEvent('*GID*','TKC','*IORATIO_TKC*','TK');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_TKC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: TK -->
				</table>
				<!---------- TK ---------->
				<!---------- PA ---------->
				<table id="model_PA" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">点球荣获（除开点球大战）</span><span id="star_PA" name="star_PA" onClick="addFavorites('PA');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: PA -->
					<tr class="bet_all_game_h">
						<td id="*PAH_GID*" onClick="betEvent('*GID*','PAH','*IORATIO_PAH*','PA');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">是</span><span class="bet_all_bet"><span class="bet_all_bg" title="是">*IORATIO_PAH*</span></span></div></td>
						<td id="*PAC_GID*" onClick="betEvent('*GID*','PAC','*IORATIO_PAC*','PA');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">不是</span><span class="bet_all_bet"><span class="bet_all_bg" title="不是">*IORATIO_PAC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: PA -->
				</table>
				<!---------- PA ---------->
				<!---------- RCD ---------->
				<table id="model_RCD" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">红卡（球员）</span><span id="star_RCD" name="star_RCD" onClick="addFavorites('RCD');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: RCD -->
					<tr class="bet_all_game_h">
						<td id="*RCDH_GID*" onClick="betEvent('*GID*','RCDH','*IORATIO_RCDH*','RCD');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">是</span><span class="bet_all_bet"><span class="bet_all_bg" title="是">*IORATIO_RCDH*</span></span></div></td>
						<td id="*RCDC_GID*" onClick="betEvent('*GID*','RCDC','*IORATIO_RCDC*','RCD');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">不是</span><span class="bet_all_bet"><span class="bet_all_bg" title="不是">*IORATIO_RCDC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: RCD -->
				</table>
				<!---------- RCD ---------->
				<!---------- CN ---------->
				<table id="model_CN" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">最先 / 最后角球</span><span id="star_CN" name="star_CN" onClick="addFavorites('CN');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: CN -->
					<tr class="bet_all_team_title">
						<td>最先角球</td>
						<td>最后角球</td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*CNFH_GID*" onClick="betEvent('*GID*','CNFH','*IORATIO_CNFH*','SP');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_CNFH*</span></span></div></td>
						<td id="*CNLH_GID*" onClick="betEvent('*GID*','CNLH','*IORATIO_CNLH*','SP');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_CNLH*</span></span></div></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*CNFC_GID*" onClick="betEvent('*GID*','CNFC','*IORATIO_CNFC*','SP');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_CNFC*</span></span></div></td>
						<td id="*CNLC_GID*" onClick="betEvent('*GID*','CNLC','*IORATIO_CNLC*','SP');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_CNLC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: CN -->
				</table>
				<!---------- CN ---------->
				<!---------- CD ---------->
				<table id="model_CD" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">第一张 / 最后一张罚牌</span><span id="star_CD" name="star_CD" onClick="addFavorites('CD');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: CD -->
					<tr class="bet_all_team_title">
						<td>第一张罚牌</td>
						<td>最后一张罚牌</td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*CDFH_GID*" onClick="betEvent('*GID*','CDFH','*IORATIO_CDFH*','SP');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_CDFH*</span></span></div></td>
						<td id="*CDLH_GID*" onClick="betEvent('*GID*','CDLH','*IORATIO_CDLH*','SP');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_CDLH*</span></span></div></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*CDFC_GID*" onClick="betEvent('*GID*','CDFC','*IORATIO_CDFC*','SP');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_CDFC*</span></span></div></td>
						<td id="*CDLC_GID*" onClick="betEvent('*GID*','CDLC','*IORATIO_CDLC*','SP');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_CDLC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: CD -->
				</table>
				<!---------- CD ---------->
				<!---------- YC ---------->
				<table id="model_YC" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">最先 / 最后界外球</span><span id="star_YC" name="star_YC" onClick="addFavorites('YC');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: YC -->
					<tr class="bet_all_team_title">
						<td>最先界外球</td>
						<td>最后界外球</td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*YCFH_GID*" onClick="betEvent('*GID*','YCFH','*IORATIO_YCFH*','SP');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_YCFH*</span></span></div></td>
						<td id="*YCLH_GID*" onClick="betEvent('*GID*','YCLH','*IORATIO_YCLH*','SP');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_YCLH*</span></span></div></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*YCFC_GID*" onClick="betEvent('*GID*','YCFC','*IORATIO_YCFC*','SP');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_YCFC*</span></span></div></td>
						<td id="*YCLC_GID*" onClick="betEvent('*GID*','YCLC','*IORATIO_YCLC*','SP');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_YCLC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: YC -->
				</table>
				<!---------- YC ---------->
				<!---------- ST ---------->
				<table id="model_ST" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">最先 / 最后替补</span><span id="star_ST" name="star_ST" onClick="addFavorites('ST');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: ST -->
					<tr class="bet_all_team_title">
						<td>最先替补</td>
						<td>最后替补</td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*STFH_GID*" onClick="betEvent('*GID*','STFH','*IORATIO_STFH*','SP');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_STFH*</span></span></div></td>
						<td id="*STLH_GID*" onClick="betEvent('*GID*','STLH','*IORATIO_STLH*','SP');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_STLH*</span></span></div></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*STFC_GID*" onClick="betEvent('*GID*','STFC','*IORATIO_STFC*','SP');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_STFC*</span></span></div></td>
						<td id="*STLC_GID*" onClick="betEvent('*GID*','STLC','*IORATIO_STLC*','SP');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_STLC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: ST -->
				</table>
				<!---------- ST ---------->
				<!---------- OS ---------->
				<table id="model_OS" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">最先 / 最后越位</span><span id="star_OS" name="star_OS" onClick="addFavorites('OS');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: OS -->
					<tr class="bet_all_team_title">
						<td>最先越位</td>
						<td>最后越位</td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*OSFH_GID*" onClick="betEvent('*GID*','OSFH','*IORATIO_OSFH*','SP');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_OSFH*</span></span></div></td>
						<td id="*OSLH_GID*" onClick="betEvent('*GID*','OSLH','*IORATIO_OSLH*','SP');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_OSLH*</span></span></div></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*OSFC_GID*" onClick="betEvent('*GID*','OSFC','*IORATIO_OSFC*','SP');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_OSFC*</span></span></div></td>
						<td id="*OSLC_GID*" onClick="betEvent('*GID*','OSLC','*IORATIO_OSLC*','SP');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg">*IORATIO_OSLC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: OS -->
				</table>
				<!---------- OS ---------->
			</div><!--玩法层-->
		</div><!--白底层-->
	</div>
</div><!--最外层-->
</body>
</html>

