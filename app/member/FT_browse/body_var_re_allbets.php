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
		_REQUEST['showtype']='RB';
		_REQUEST['date']='<?=$date?>';
	</script>
	<script>
		var retime=60;
	</script>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8 "><script>
		﻿var ObjDataFT = new Array();
		var gid_ary = new Array();
		var more_window_display_none = false;   //
		var gid_rtype_ior = new Array();
		var gidXmlObj = new Object();
		var obj_ary = new Array("myMarkets","mainMarkets","goalMarkets","corners","otherMarkets");
		var open_movie = {"myMarkets":false,"mainMarkets":true,"goalMarkets":true,"corners":false,"otherMarkets":false};
		var favorites_ary = new Array();  //favorites
		var retime_flag;
		var retime_run;
		var show_gid;
		var RE_Regex = new RegExp('\^\[A-FH\]\?RE$');
		var ROU_Regex = new RegExp('\(\^\[A-FH\]\?ROU[HC]\?$\|\^HRU\[HC\]$\)');
		var ARE_Regex = new RegExp('\[ABDE\]RE');
		var AROU_Regex = new RegExp('\[ABDE\]ROU');
		var ARM_Regex = new RegExp('\[ABDE\]RM');
		var PD_Regex = new RegExp('\^H\?R\?H\[0-9\]C\[0-9\]$');
		top.more_bgYalloW ="";
		var TV_eventid = "";

		function init(){
			show_gid = _REQUEST['gid'];
			open_movieF();
			reloadGameData();
			retime_run = retime;
			setAllMark();
			if(retime > 0){
				retime_flag='Y';
			}else{
				retime_flag='N';
			}
			if (retime_flag == 'Y'){
				//ReloadTimeID = setInterval("reload_var()",parent.retime*1000);
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
			getHTML.loadURL("/app/member/get_game_allbets.php","POST", getUrlParam());
			iorPHP.location.href="/app/member/FT_browse/re.php?"+getUrlParam();
		}

		function getUrlParam(){
			var param = "";
			param="uid="+_REQUEST['uid'];
			param+="&langx="+_REQUEST['langx'];
			param+="&gtype="+_REQUEST['gtype'];
			param+="&showtype="+_REQUEST['showtype'];
			//param+="&testMode="+"1";
			param+="&gid="+_REQUEST['gid'];
			param+="&ltype="+_REQUEST['ltype'];
			param+="&date="+_REQUEST['date'];

			return param;
		}

		function getNodeVal(Node){
			return Node.childNodes[0].nodeValue;
		}

		function reloadGameDataComplete(xml){

			if(xml == null){
				closeClickEvent();
				return;
			}
			try{
				var tmp = xml.getElementsByTagName("server")[0];
				if(getNodeVal(tmp).indexOf("error") != -1){
					closeClickEvent();
					return;
				}
			}
			catch(e){;}
			var xmdObj = new Object();
			xmlnode=new xmlNode(xml.getElementsByTagName("serverresponse"));
			xmlnodeRoot = xml.getElementsByTagName("serverresponse")[0];

			xmdObj["code"] = xmlnode.Node(xmlnodeRoot,"code");
			//alert(xmdObj["code"].childNodes[0].nodeValue);
			if(getNodeVal(xmdObj["code"])=="615"){
				//alert("final");
				//return;


				ObjDataFT = XML2Array(xmlnode,xmlnodeRoot);
				if(ObjDataFT == ""){
					closeClickEvent();
					return;
				}
				TV_title();
				show_close_info(ObjDataFT[show_gid]["gopen"]);
				show_gameInfo(show_gid,ObjDataFT);

				var tpl = new fastTemplate();
				var tmpScreen = "";
				var div_model = document.getElementById('div_model');
				for(var j=0; j<div_model.children.length; j++){
					var tab_model = div_model.children[j].cloneNode(true);
					//alert(tab_model.id+"=="+tab_model.nodeName);
					if(tab_model.nodeName =="TABLE"&&tab_model.id.indexOf("model")!=-1){
						var wtype = tab_model.id.split("_")[1];
						document.getElementById('body_'+wtype).innerHTML ="";
						var tmpDiv = document.createElement("div");
						tmpDiv.appendChild(tab_model);

						tpl.init(tmpDiv);
						var tr_color = 0;
						for(var k=0; k<gid_ary.length; k++){
							var gid = gid_ary[k];
							var hgid = ObjDataFT[gid]["hgid"];
							//var chkArray();
							var ior_arr = getIor(ObjDataFT[gid],wtype);
							//alert(ior_arr);
							if(ior_arr=="nodata") continue;
							tr_color++;
							var tr_class="";
							tpl.addBlock(wtype);
							var sw = ObjDataFT[gid]["sw_"+wtype];
							var strong = ObjDataFT[gid]["strong"];

							for(var t=0; t<rtypeMap[wtype].length; t++){
								var rtype = rtypeMap[wtype][t];
								//var ior = ObjDataFT[gid]["ior_"+rtype];

								var IORATIO = "IORATIO_"+rtype;
								var RATIO = "RATIO_"+rtype;
								var td_class = "TD_CLASS_"+rtype;
								var RTYPE_GID = rtype+"_GID";
								var RTYPE_HGID = rtype+"_HGID";
								/*if(rtype=='BROUO'){
								 alert(ior_arr["BROUO"]["ior"]);
								 }*/
								try{
									tpl.replace(new RegExp('\\*'+IORATIO+'\\*'), ior_arr[rtype]["ior"]);
									tpl.replace(new RegExp('\\*'+IORATIO+'\\*','g'), parse_ior(gid,rtype,ior_arr[rtype]["ior"]));
									tpl.replace(/\*TEAM_H\*/g, ObjDataFT[gid]["team_h"]);
									tpl.replace(/\*TEAM_C\*/g, ObjDataFT[gid]["team_c"]);
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
									tpl.replace(new RegExp('\\*'+RATIO+'\\*','g'), undefined2space(ior_arr[rtype]["ratio"]));
								}catch(e){
									//alert(wtype+"-"+rtype+" is undefined");
								}
							}


						}
						tmpScreen = tpl.fastPrint();
						if( ARE_Regex.test(wtype) || AROU_Regex.test(wtype) || ARM_Regex.test(wtype) ){
							var type15 = wtype.substr(0,1);
							tmpScreen = tmpScreen.replace("*SCORE_H"+type15+"*",ObjDataFT[gid]["score_h_"+type15]);
							tmpScreen = tmpScreen.replace("*SCORE_C"+type15+"*",ObjDataFT[gid]["score_c_"+type15]);
						}
						tmpScreen = tmpScreen.replace(/\*TEAM_H\*/g, ObjDataFT[gid]["team_h"]);
						tmpScreen = tmpScreen.replace(/\*TEAM_C\*/g, ObjDataFT[gid]["team_c"]);
						document.getElementById('body_'+wtype).innerHTML += tmpScreen;
						document.getElementById('body_'+wtype).style.display = "";

					}
				}
				parent.document.getElementById('more_window').style.display = "";


				var tmp_arr = new Array();
				tmp_arr = top.more_fave_wtype[show_gid];
				top.more_fave_wtype[show_gid] = new Array();
				if(tmp_arr.length > 0){
					for(var i=0; i< tmp_arr.length ; i++){
						wtype = tmp_arr[i];
						addFavorites(wtype);
					}
				}

			}else{
				closeClickEvent();
			}
			fix_body_wtype();
			fixMoreWindow();
		}



		//liveTV
		function liveTVClickEvent(){
			//alert("TV click");
			if (TV_eventid != "" && TV_eventid != "null" && TV_eventid != undefined) {	//判斷<?=$shi?><?=$fou?>有轉播
				parent.parent.OpenLive(TV_eventid,"FT");
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
		function playCssEvent(eventName){
			//alert(eventName);

			var obj = document.getElementById('movie_'+eventName);
			obj.style.display=(obj.style.display=="")?"none":"";

			setMark(eventName);
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

			var league_name = ObjDataFT[gid]["league"];
			var team_h = ObjDataFT[gid]["team_h"];
			var team_c = ObjDataFT[gid]["team_c"];
			//var session = ObjDataFT[gid]["session"];
			if(ObjDataFT[gid]['gopen']=='Y'){
				var score_h = ObjDataFT[gid]["score_h"];
				var score_c = ObjDataFT[gid]["score_c"];
				var redcard_h = ObjDataFT[gid]["redcard_h"]*1;
				var redcard_c = ObjDataFT[gid]["redcard_c"]*1;
				var re_time = ObjDataFT[gid]["re_time"];
				var tmpset=re_time.split("^");
				var showretime=tmpset[1];
				var status = "";
				switch (tmpset[0]){
					case "HT":
						status = top.statu["HT"];
						break;
					case "1H":
						status = top.statu["1H"];
						break;
					case "2H":
						status = top.statu["2H"];
						break;
					default:
						status = tmpset[0];
				}
				if(titleDiv == undefined){
					titleDiv = document.createElement("div");
					titleDiv.appendChild(gameInfo.cloneNode(true));
				}

				var tmpDiv = titleDiv.cloneNode(true);
				var tmp_repl =  tmpDiv.innerHTML;
				tmp_repl = tmp_repl.replace('*TEAM_H*',team_h);
				tmp_repl = tmp_repl.replace('*TEAM_C*',team_c);
				tmp_repl = tmp_repl.replace('*STATUS*',status);

				tmp_repl = tmp_repl.replace('*SCORE_H*',(score_h!="")?score_h:0);
				tmp_repl = tmp_repl.replace('*SCORE_C*',(score_c!="")?score_c:0);
				tmp_repl = tmp_repl.replace('*RED_H*',(redcard_h!='0')?"<font class=\"more_card\">&nbsp;"+redcard_h+"&nbsp;</font>":"");
				tmp_repl = tmp_repl.replace('*RED_C*',(redcard_c!='0')?"<font class=\"more_card\">&nbsp;"+redcard_c+"&nbsp;</font>":"");
				tmpDiv.innerHTML = tmp_repl.replace('*RB_TIME*',showretime);

				document.getElementById("title_league").innerHTML = league_name;
				gameInfo.parentNode.replaceChild(tmpDiv.children[0],gameInfo);

			}
			else{
				if(titleDiv == undefined){
					titleDiv = document.createElement("div");
					titleDiv.appendChild(gameInfo.cloneNode(true));
				}

				var tmpDiv = titleDiv.cloneNode(true);
				var tmp_repl =  tmpDiv.innerHTML;
				tmp_repl = tmp_repl.replace('*TEAM_H*',team_h);
				tmp_repl = tmp_repl.replace('*TEAM_C*',team_c);
				tmp_repl = tmp_repl.replace('*STATUS*',"");
				tmp_repl = tmp_repl.replace('*SCORE_H*',"");
				tmp_repl = tmp_repl.replace('*SCORE_C*',"");
				tmp_repl = tmp_repl.replace('*RED_H*',"");
				tmp_repl = tmp_repl.replace('*RED_C*',"");
				tmpDiv.innerHTML = tmp_repl.replace('*RB_TIME*',"");


				document.getElementById("title_league").innerHTML = league_name;
				gameInfo.parentNode.replaceChild(tmpDiv.children[0],gameInfo);
			}



		}

		function setRefreshPos(){
			var refresh_right= body_browse.document.getElementById('refresh_right');
			refresh_right.style.left= body_browse.document.getElementById('myTable').clientWidth*1+20;
			//refresh_right.style.top= 39;
		}

		function addFavorites(wtype_Name){
			//top.more
			var fave_cont;
			var favorites_ = document.getElementById("favorites_"+wtype_Name);
			var body_ = document.getElementById("body_"+wtype_Name);
//			var cont_myMarket = document.getElementById("count_myMarkets");
			var movie_myMarkets = document.getElementById("movie_myMarkets");
			var tmp_repl = body_.innerHTML;
			tmp_repl = tmp_repl.replace("model_","f_table_");
			tmp_repl = tmp_repl.replace("addFavorites","delFavorites");
			tmp_repl = tmp_repl.replace("star_down","star_up");
			favorites_.innerHTML = tmp_repl;
			body_.innerHTML = "";
			top.more_fave_wtype[show_gid].push(wtype_Name);
			fave_cont = count_wtype("myMarkets");
//			cont_myMarket.innerHTML = fave_cont;
			if(fave_cont!=0){
				document.getElementById("movie_myMarkets_nodata").style.display="none";
				favorites_.style.display="";
			}
			body_.style.display="none";
			if(movie_myMarkets.style.display =="none" ) playCssEvent('myMarkets');
			fix_body_wtype();
			fixMoreWindow();
		}
		function delFavorites(wtype_Name){
			var tmp_arr = new Array();
			var tmp_wtype ;
			var favorites_ = document.getElementById("favorites_"+wtype_Name);
			var body_ = document.getElementById("body_"+wtype_Name);
//			var cont_myMarket = document.getElementById("count_myMarkets");
			var tmp_repl = favorites_.innerHTML;
			tmp_repl = tmp_repl.replace("f_table_","model_");
			tmp_repl = tmp_repl.replace("delFavorites","addFavorites");
			tmp_repl = tmp_repl.replace("star_up","star_down");
			body_.innerHTML = tmp_repl ;
			favorites_.innerHTML = "";
			for(var i=0, a=0;i < top.more_fave_wtype[show_gid].length ; i++){
				tmp_wtype = top.more_fave_wtype[show_gid][i]
				if(wtype_Name != tmp_wtype) tmp_arr[a++] = tmp_wtype ;
			}
			top.more_fave_wtype[show_gid] = tmp_arr;
			fave_cont = count_wtype("myMarkets");
//			cont_myMarket.innerHTML = fave_cont;
			if(fave_cont == 0)document.getElementById("movie_myMarkets_nodata").style.display="";
			favorites_.style.display="none";
			body_.style.display="";
			fix_body_wtype();
			fixMoreWindow();

		}


		function betEvent(gid,rtype,ratio,wtype){
			var tar ;
			if(ratio==0)return;
			parent.parent.parent.mem_order.betOrder('FT',wtype,getParam(gid,wtype,rtype,ratio));



			if(rtype == "R0~1" || rtype == "R2~3" || rtype == "R4~6" ){
				var indexs = rtype.substr(1,1) *1 /2 ;
				rtype = rtypeMap[wtype][indexs];
			}
			if(wtype.indexOf('EO') != -1){
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
			tmp_game = gidXmlObj[gid];
			var strong = ObjDataFT[gid]["strong"];


			var type = rtype.substr(rtype.length-1,1).toUpperCase();
			if(wtype.indexOf('OU') != -1 || wtype == 'HRUH' || wtype == 'HRUC' ){
				if(type=='O')type='C';
				if(type=='U')type='H'
			}
			if( wtype=='M' || wtype.indexOf('RM') != -1 ){
				var new_type = (type=='H')?'H':'C';
			}
			if(wtype == "HPD" || wtype == "HRPD"){
				rtype = rtype.substr(1,rtype.length);
			}
			var param = 'gid='+gid+'&uid='+top.uid+'&odd_f_type='+top.odd_f_type+'&langx='+top.langx+'&rtype='+rtype;
			if(wtype=='RE' ||wtype=='HRE')param += '&gnum='+ObjDataFT[gid]['gnum_'+type.toLowerCase()]+'&strong='+strong+'&type='+type;
			else if(wtype=='ROU' || wtype =='HROU')param += '&gnum='+ObjDataFT[gid]['gnum_'+type.toLowerCase()]+'&type='+type;
			else if(wtype=='RM' || wtype =='HRM')param += '&gnum='+ObjDataFT[gid]['gnum_'+new_type.toLowerCase()]+'&type='+type;
			else if(wtype=='ROUH' || wtype =='HRUH' || wtype=='ROUC' || wtype =='HRUC')param += '&gnum='+ObjDataFT[gid]['gnum_'+type.toLowerCase()]+'&type='+(type =='H'?'U':'O')+'&wtype='+wtype;
			else if(ARE_Regex.test(wtype)) param += '&gnum='+ObjDataFT[gid]['gnum_'+type.toLowerCase()]+'&strong='+strong+'&type='+type+'&wtype='+wtype;
			else if(AROU_Regex.test(wtype)) param += '&gnum='+ObjDataFT[gid]['gnum_'+type.toLowerCase()]+'&type='+(type =='H'?'U':'O')+'&wtype='+wtype;
			else if(ARM_Regex.test(wtype)) param += '&gnum='+ObjDataFT[gid]['gnum_'+new_type.toLowerCase()]+'&type='+type+'&wtype='+wtype;
			else if(wtype.indexOf("PD") != -1 || wtype == 'RT' || wtype == 'HRT' || wtype == 'RF' || wtype.indexOf("EO") != -1) param +='';
			else param += '&wtype='+wtype;


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

		function getXML_TagValue(xmlnode,xmlnodeRoot,TagName){
			var ret_value="";
			if(xmlnode.Node(xmlnodeRoot,TagName).childNodes[0] != null && xmlnode.Node(xmlnodeRoot,TagName) != null) {
				ret_value = getNodeVal(xmlnode.Node(xmlnodeRoot,TagName));
			}
			return ret_value;
		}

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
			if(ior_value*1 == 0 &&  (PD_Regex.test(rtype) || rtype == "HROVH" || rtype == "ROVH" ) )return "-";
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
			}
			return tmp_Obj;
		}

		function getIor(gdata,wtype){

			var map = rtypeMap[wtype];
			var ior = new Object();
			var rtype,ratio_str,type;
			var gopen = gdata["gopen"];
			var sw = gdata["sw_"+wtype];
			var ior_all_zero = true;
			var strong;
			(wtype=="HRE")?
				strong = gdata['hstrong']:
				strong = gdata['strong'];
			if(gopen == "N") return "nodata" ;
			if(sw == "N") return "nodata" ;
			for(var i=0;i<map.length;i++){
				rtype =  map[i];
				//if( wtype_chk_ary.indexOf(wtype)  && gdata["ior_"+rtype]==0 ) return "nodata" ;
				if( !isNaN(gdata["ior_"+rtype]) && gdata["ior_"+rtype]*1 != 0) ior_all_zero= false;
				ior[rtype] = new Object();
				/*if(rtype='BROUO'){
				 alert(gdata["ior_"+rtype]);
				 }*/
				ior[rtype]["ior"] = gdata["ior_"+rtype];

				ratio_str = getRatioName(wtype,rtype);

				if(gdata[ratio_str]){
					ior[rtype]["ratio"] = gdata[ratio_str];

					type = rtype.substr(rtype.length-1,1);
					if(wtype.indexOf('RE') != -1){
						if(type != strong && type!="N"){
							ior[rtype]["ratio"] = "";
						}
					}
				}
			}
			if(ior_all_zero)return "nodata";
			if( RE_Regex.test(wtype) || ROU_Regex.test(wtype) || wtype == 'REO' || wtype == 'HREO'){
				var arry = new Array();
				if(wtype == 'REO' || wtype=='HREO') {
					arry[0] = (ior[map[0]]["ior"]*1000 - 1000) / 1000;
					arry[1] = (ior[map[1]]["ior"]*1000 - 1000) / 1000;
					arry = parent.parent.get_other_ioratio("H",arry[0],arry[1],parent.parent.show_ior);
					arry[0] =(arry[0]*1000 + 1000) / 1000;
					arry[1] =(arry[1]*1000 + 1000) / 1000;
				}else{
					arry[0] = ior[map[0]]["ior"]*1;
					arry[1] = ior[map[1]]["ior"]*1;
					/* if(rtype=='AROUO'){
					 alert(top.odd_f_type);
					 }	*/
					arry = parent.parent.get_other_ioratio(top.odd_f_type,arry[0],arry[1],parent.parent.show_ior);
				}
				/*if(rtype=='DROUO'){
				 alert(arry[1]);
				 }*/
				ior[map[0]]["ior"] = arry[0];
				ior[map[1]]["ior"] = arry[1];
			}

			return ior;
		}

		function getRatioName(wtype,rtype){
			var ratio= "ratio";
			if(wtype.indexOf('RE') != -1) {
				ratio = "ratio_"+wtype;
			}else if(wtype=='HROU' || wtype=='ROU'){
				ratio = "ratio_"+wtype+(rtype.substr(rtype.length-1,1)=='C'?'o':'u');
			}else{
				ratio = "ratio_"+rtype;
			}
			return ratio.toLowerCase();
		}

		function undefined2space(val){
			if(val == 'undefined' || typeof(val) == 'undefined')return "";
			else return val;
		}

		function fix_body_wtype(){
			var cnt;
			for(var i=0;i<obj_ary.length;i++){
				var _name = obj_ary[i];
				cnt = count_wtype(_name);
//				document.getElementById("count_"+_name).innerHTML = cnt;
				if(i>0){
					if(cnt == 0){
						document.getElementById("head_"+_name).style.display = "none";
					}else{
						document.getElementById("head_"+_name).style.display = "";
					}
				}
			}
		}

		function count_wtype(_name){
			var div_model = document.getElementById('movie_'+_name);
			var cnt = 0
			for(var j=0; j<div_model.children.length; j++){
				var child_model = div_model.children[j];
				var div_id = child_model.id;
				if(child_model.nodeName =="DIV"&&( div_id.indexOf("body")!=-1 || div_id.indexOf("favorites")!=-1)){

					var wtype = div_id.split("body_")[1] || div_id.split("favorites_")[1] ;

					if(child_model.innerHTML !="" ) {
						if(div_id.indexOf("body")!=-1){
							setStarTitle(wtype,top.addtoMyMarket);
						}
						else{
							setStarTitle(wtype,"");
						}
						cnt++;
					}
					else child_model.style.display="none";
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
			if (TV_eventid != "" && TV_eventid != "null" && TV_eventid != undefined) {	//判斷<?=$shi?><?=$fou?>有轉播
				tv_bton.title = top.str_TV_RB;
				tv_bton.className = "more_tv_on";
			}
			else {
				tv_bton.style.display="none";
			}
		}

		function show_close_info(gopen){
			var dis_str = "";
			if(gopen=='N')dis_str = "none";
			document.getElementById("gameOver").style.display = (dis_str=="none")?"":"none" ;
			//document.getElementById("mod_table").style.display = dis_str;
			for(i=0;i<obj_ary.length;i++){
				var _name = obj_ary[i];
				var mark = document.getElementById("mark_"+_name);
				document.getElementById("head_"+_name).style.display = dis_str;
				if( gopen == 'Y') {
					document.getElementById("movie_"+_name).style.display = (mark.className == "more_up")?"":"none";
				}
				else{
					document.getElementById("movie_"+_name).style.display = "none";
				}
			}
		}



		//setStarTitle(wtype,top.addtoMyMarket);

		function setStarTitle(wtype,TitleText){

			document.getElementById("star_"+wtype).title = TitleText;

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
		}
	</script>

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

<iframe id="iorPHP" name="iorPHP" src="" width="0" height="0"></iframe>
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
						<td class="bet_all_date">*RB_TIME*</td>
					</tr>
					<tr class="bet_all_tr_point">
						<td class="bet_all_point_1">*TEAM_H*</td>
						<td class="bet_all_point_v">V</td>
						<td class="bet_all_point_2">*TEAM_C*</td>
					</tr>
				</table>
				<!-- markets -->
				<div class="bet_all_markets">
					<!------------------------ my markets ------------------------>
					<div id="head_myMarkets" onClick="playCssEvent('myMarkets',this);" class="bet_all_title_bg">
						<span id="mark_myMarkets" class="more_up"></span>
						<span><?=$wodepankou?></span>
					</div>
					<div id="movie_myMarkets">
						<div id="movie_myMarkets_nodata" class="bet_all_click">点击 <span class="bet_all_click_star"></span> <?=$tianjiasaishi?></div>
						<div id="favorites_RE"></div>
						<div id="favorites_HRE"></div>
						<div id="favorites_ROU"></div>
						<div id="favorites_HROU"></div>
						<div id="favorites_RM"></div>
						<div id="favorites_HRM"></div>
						<div id="favorites_ARE"></div>
						<div id="favorites_AROU"></div>
						<div id="favorites_ARM"></div>
						<div id="favorites_BRE"></div>
						<div id="favorites_BROU"></div>
						<div id="favorites_BRM"></div>
						<div id="favorites_DRE"></div>
						<div id="favorites_DROU"></div>
						<div id="favorites_DRM"></div>
						<div id="favorites_ERE"></div>
						<div id="favorites_EROU"></div>
						<div id="favorites_ERM"></div>
						<div id="favorites_RPD"></div>
						<div id="favorites_HRPD"></div>
						<div id="favorites_RT"></div>
						<div id="favorites_HRT"></div>
						<div id="favorites_RF"></div>
						<div id="favorites_RWM"></div>
						<div id="favorites_RDC"></div>
						<div id="favorites_RWE"></div>
						<div id="favorites_RWB"></div>
						<div id="favorites_ARG"></div>
						<div id="favorites_BRG"></div>
						<div id="favorites_CRG"></div>
						<div id="favorites_DRG"></div>
						<div id="favorites_ERG"></div>
						<div id="favorites_FRG"></div>
						<div id="favorites_GRG"></div>
						<div id="favorites_HRG"></div>
						<div id="favorites_IRG"></div>
						<div id="favorites_JRG"></div>
						<div id="favorites_RTS"></div>
						<div id="favorites_ROUH"></div>
						<div id="favorites_ROUC"></div>
						<div id="favorites_HRUH"></div>
						<div id="favorites_HRUC"></div>
						<div id="favorites_REO"></div>
						<div id="favorites_HREO"></div>
						<div id="favorites_RCS"></div>
						<div id="favorites_RWN"></div>
						<div id="favorites_RHG"></div>
						<div id="favorites_RMG"></div>
						<div id="favorites_RSB"></div>
						<div id="favorites_RT3G"></div>
						<div id="favorites_RT1G"></div>
					</div>
					<!------------------------ my markets ------------------------>
					<!------------------------ main markets ------------------------>
					<div id="head_mainMarkets" onClick="playCssEvent('mainMarkets',this);" class="bet_all_title_bg">
						<span id="mark_mainMarkets" class="more_up"></span>
						<span><?=$zhupankou?></span>
					</div>
					<div id="movie_mainMarkets">
						<div id="body_RE"></div>
						<div id="body_HRE"></div>
						<div id="body_ROU"></div>
						<div id="body_HROU"></div>
						<div id="body_RM"></div>
						<div id="body_HRM"></div>
						<div id="body_ARE"></div>
						<div id="body_AROU"></div>
						<div id="body_ARM"></div>
						<div id="body_BRE"></div>
						<div id="body_BROU"></div>
						<div id="body_BRM"></div>
						<div id="body_DRE"></div>
						<div id="body_DROU"></div>
						<div id="body_DRM"></div>
						<div id="body_ERE"></div>
						<div id="body_EROU"></div>
						<div id="body_ERM"></div>
						<div id="body_RPD"></div>
						<div id="body_HRPD"></div>
						<div id="body_RT"></div>
						<div id="body_HRT"></div>
						<div id="body_RF"></div>
						<div id="body_RWM"></div>
						<div id="body_RDC"></div>
						<div id="body_RWE"></div>
						<div id="body_RWB"></div>
					</div>
					<!------------------------ main markets ------------------------>
					<!------------------------ corners ------------------------>
					<div id="head_corners" onClick="playCssEvent('corners',this);" class="bet_all_title_bg">
						<span id="mark_corners" class="more_up"></span>
						<span><?=$jiaoqiu?></span>
					</div>
					<div id="movie_corners" >
					</div>
					<!------------------------ corners ------------------------>
					<!------------------------ goal markets ------------------------>
					<div id="head_goalMarkets" onClick="playCssEvent('goalMarkets',this);" class="bet_all_title_bg">
						<span id="mark_goalMarkets" class="more_up"></span>
						<span><?=$jinqiupankou?></span>
					</div>
					<div id="movie_goalMarkets">
						<div id="body_ARG"></div>
						<div id="body_BRG"></div>
						<div id="body_CRG"></div>
						<div id="body_DRG"></div>
						<div id="body_ERG"></div>
						<div id="body_FRG"></div>
						<div id="body_GRG"></div>
						<div id="body_HRG"></div>
						<div id="body_IRG"></div>
						<div id="body_JRG"></div>
						<div id="body_RTS"></div>
						<div id="body_ROUH"></div>
						<div id="body_ROUC"></div>
						<div id="body_HRUH"></div>
						<div id="body_HRUC"></div>
						<div id="body_REO"></div>
						<div id="body_HREO"></div>
						<div id="body_RCS"></div>
						<div id="body_RWN"></div>
						<div id="body_RHG"></div>
						<div id="body_RMG"></div>
						<div id="body_RSB"></div>
						<div id="body_RT3G"></div>
						<div id="body_RT1G"></div>
					</div>
					<!------------------------ goal markets ------------------------>
					<!------------------------ other markets ------------------------>
					<div id="head_otherMarkets" onClick="playCssEvent('otherMarkets',this);" class="bet_all_title_bg">
						<span id="mark_otherMarkets" class="more_up"></span>
						<span><?=$qitawanfa?></span>
					</div>
					<div id="movie_otherMarkets" >
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


				<!---------- RE ---------->
				<table id="model_RE" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">让球</span><span id="star_RE" name="star_RE" onClick="addFavorites('RE');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: RE -->
					<tr class="bet_all_game_h">
						<td id="*REH_GID*" onClick="betEvent('*GID*','REH','*IORATIO_REH*','RE');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_middle">*RATIO_REH*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_H*>*IORATIO_REH*</span></span></div></td>

						<td id="*REC_GID*" onClick="betEvent('*GID*','REC','*IORATIO_REC*','RE');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_middle">*RATIO_REC*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_C*>*IORATIO_REC*</span></span></div></td>
					</tr>


					<!-- END DYNAMIC BLOCK: RE -->

				</table>
				<!---------- RE ---------->
				<!---------- HRE ---------->
				<table id="model_HRE" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">让球<tt class="bet_name_color">&nbsp;- 上半场</tt></span><span id="star_HRE" name="star_HRE" onClick="addFavorites('HRE');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: HRE -->
					<tr class="bet_all_game_h">
						<td id="*HREH_HGID*" onClick="betEvent('*HGID*','HREH','*IORATIO_HREH*','HRE');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_middle">*RATIO_HREH*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_H*>*IORATIO_HREH*</span></span></div></td>
						<td id="*HREC_HGID*" onClick="betEvent('*HGID*','HREC','*IORATIO_HREC*','HRE');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_middle">*RATIO_HREC*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_C*>*IORATIO_HREC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: HRE -->

				</table>
				<!---------- HRE ---------->
				<!---------- ROU ---------->
				<table id="model_ROU" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">大 / 小</span><span id="star_ROU" name="star_ROU" onClick="addFavorites('ROU');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: ROU -->
					<tr class="bet_all_game_h">
						<td id="*ROUC_GID*" onClick="betEvent('*GID*','ROUC','*IORATIO_ROUC*','ROU');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">大</span><span class="bet_all_middle">*RATIO_ROUC*</span><span class="bet_all_bet"><span class="bet_all_bg" title="大">*IORATIO_ROUC*</span></span></div></td>

						<td id="*ROUH_GID*" onClick="betEvent('*GID*','ROUH','*IORATIO_ROUH*','ROU');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">小</span><span class="bet_all_middle">*RATIO_ROUH*</span><span class="bet_all_bet"><span class="bet_all_bg" title="小">*IORATIO_ROUH*</span></span></div></td>


					</tr>


					<!-- END DYNAMIC BLOCK: ROU -->

				</table>
				<!---------- ROU ---------->
				<!---------- HROU ---------->
				<table id="model_HROU" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">大 / 小<tt class="bet_name_color">&nbsp;- 上半场</tt></span><span id="star_HROU" name="star_HROU" onClick="addFavorites('HROU');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: HROU -->
					<tr class="bet_all_game_h">
						<td id="*HROUC_HGID*" onClick="betEvent('*HGID*','HROUC','*IORATIO_HROUC*','HROU');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">大</span><span class="bet_all_middle">*RATIO_HROUC*</span><span class="bet_all_bet"><span class="bet_all_bg" title="大">*IORATIO_HROUC*</span></span></div></td>

						<td id="*HROUH_HGID*" onClick="betEvent('*HGID*','HROUH','*IORATIO_HROUH*','HROU');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">小</span><span class="bet_all_middle">*RATIO_HROUH*</span><span class="bet_all_bet"><span class="bet_all_bg" title="小">*IORATIO_HROUH*</span></span></div></td>


					</tr>


					<!-- END DYNAMIC BLOCK: HROU -->

				</table>
				<!---------- HROU ---------->
				<!---------- RM ---------->
				<table id="model_RM" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">独赢</span><span id="star_RM" name="star_RM" onClick="addFavorites('RM');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: RM -->
					<tr class="bet_all_game_h">
						<td id="*RMH_GID*" onClick="betEvent('*GID*','RMH','*IORATIO_RMH*','RM');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_H*>*IORATIO_RMH*</span></span></div></td>

						<td id="*RMN_GID*" onClick="betEvent('*GID*','RMN','*IORATIO_RMN*','RM');" class="bet_all_three_middle"><div class="bet_all_div"><span class="bet_all_team">和局</span><span class="bet_all_bet"><span class="bet_all_bg" title="和局">*IORATIO_RMN*</span></span></div></td>

						<td id="*RMC_GID*" onClick="betEvent('*GID*','RMC','*IORATIO_RMC*','RM');" class="bet_all_three"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_C*>*IORATIO_RMC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: RM -->


				</table>
				<!---------- RM ---------->
				<!---------- HRM ---------->
				<table id="model_HRM" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">独赢<tt class="bet_name_color"> - 上半场</tt></span><span id="star_HRM" name="star_HRM" onClick="addFavorites('HRM');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: HRM -->
					<tr class="bet_all_game_h">
						<td id="*HRMH_HGID*" onClick="betEvent('*HGID*','HRMH','*IORATIO_HRMH*','HRM');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_H*>*IORATIO_HRMH*</span></span></div></td>

						<td id="*HRMN_HGID*" onClick="betEvent('*HGID*','HRMN','*IORATIO_HRMN*','HRM');" class="bet_all_three_middle"><div class="bet_all_div"><span class="bet_all_team">和局</span><span class="bet_all_bet"><span class="bet_all_bg" title="和局">*IORATIO_HRMN*</span></span></div></td>

						<td id="*HRMC_HGID*" onClick="betEvent('*HGID*','HRMC','*IORATIO_HRMC*','HRM');" class="bet_all_three"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_C*>*IORATIO_HRMC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: HRM -->


				</table>
				<!---------- HRM ---------->
				<!---------- ARE ---------->
				<table id="model_ARE" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name"><span class="bet_all_15left">15 分钟盘口: 开场&nbsp;- 14:59 分钟 - 让球</span><span class="bet_all_15right">15分钟 比分: *SCORE_HA* - *SCORE_CA*</span></span><span id="star_ARE" name="star_ARE" onClick="addFavorites('ARE');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: ARE -->
					<tr class="bet_all_game_h">
						<td id="*AREH_HGID*" onClick="betEvent('*HGID*','AREH','*IORATIO_AREH*','ARE');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_middle">*RATIO_AREH*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_H*>*IORATIO_AREH*</span></span></div></td>
						<td id="*AREC_HGID*" onClick="betEvent('*HGID*','AREC','*IORATIO_AREC*','ARE');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_middle">*RATIO_AREC*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_C*>*IORATIO_AREC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: ARE -->

				</table>
				<!---------- ARE ---------->
				<!---------- BRE ---------->
				<table id="model_BRE" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name"><span class="bet_all_15left">15 分钟盘口: 15:00 - 29:59 分钟 - 让球</span><span class="bet_all_15right">15分钟 比分: *SCORE_HB* - *SCORE_CB*</span></span><span id="star_BRE" name="star_BRE" onClick="addFavorites('BRE');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: BRE -->
					<tr class="bet_all_game_h">
						<td id="*BREH_HGID*" onClick="betEvent('*HGID*','BREH','*IORATIO_BREH*','BRE');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_middle">*RATIO_BREH*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_H*>*IORATIO_BREH*</span></span></div></td>
						<td id="*BREC_HGID*" onClick="betEvent('*HGID*','BREC','*IORATIO_BREC*','BRE');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_middle">*RATIO_BREC*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_C*>*IORATIO_BREC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: BRE -->

				</table>
				<!---------- BRE ---------->
				<!---------- DRE ---------->
				<table id="model_DRE" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name"><span class="bet_all_15left">15 分钟盘口: 下半场开始&nbsp;- 59:59 分钟 - 让球</span><span class="bet_all_15right">15分钟 比分: *SCORE_HD* - *SCORE_CD*</span></span><span id="star_DRE" name="star_DRE" onClick="addFavorites('DRE');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: DRE -->
					<tr class="bet_all_game_h">
						<td id="*DREH_HGID*" onClick="betEvent('*HGID*','DREH','*IORATIO_DREH*','DRE');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_middle">*RATIO_DREH*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_H*>*IORATIO_DREH*</span></span></div></td>
						<td id="*DREC_HGID*" onClick="betEvent('*HGID*','DREC','*IORATIO_DREC*','DRE');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_middle">*RATIO_DREC*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_C*>*IORATIO_DREC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: DRE -->

				</table>
				<!---------- DRE ---------->
				<!---------- ERE ---------->
				<table id="model_ERE" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name"><span class="bet_all_15left">15 分钟盘口: 60:00 - 74:59 分钟 - 让球</span><span class="bet_all_15right">15分钟 比分: *SCORE_HE* - *SCORE_CE*</span></span><span id="star_ERE" name="star_ERE" onClick="addFavorites('ERE');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: ERE -->
					<tr class="bet_all_game_h">
						<td id="*EREH_HGID*" onClick="betEvent('*HGID*','EREH','*IORATIO_EREH*','ERE');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_middle">*RATIO_EREH*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_H*>*IORATIO_EREH*</span></span></div></td>
						<td id="*EREC_HGID*" onClick="betEvent('*HGID*','EREC','*IORATIO_EREC*','ERE');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_middle">*RATIO_EREC*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_C*>*IORATIO_EREC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: ERE -->

				</table>
				<!---------- ERE ---------->
				<!---------- AROU ---------->
				<table id="model_AROU" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name"><span class="bet_all_15left">15 分钟盘口: 开场&nbsp;- 14:59 分钟 - 大 / 小</span><span class="bet_all_15right">15分钟 比分: *SCORE_HA* - *SCORE_CA*</span></span><span id="star_AROU" name="star_AROU" onClick="addFavorites('AROU');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: AROU -->
					<tr class="bet_all_game_h">
						<td id="*AROUO_GID*" onClick="betEvent('*GID*','AROUO','*IORATIO_AROUO*','AROU');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">大</span><span class="bet_all_middle">*RATIO_AROUO*</span><span class="bet_all_bet"><span class="bet_all_bg" title="大">*IORATIO_AROUO*</span></span></div></td>
						<td id="*AROUU_GID*" onClick="betEvent('*GID*','AROUU','*IORATIO_AROUU*','AROU');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">小</span><span class="bet_all_middle">*RATIO_AROUU*</span><span class="bet_all_bet"><span class="bet_all_bg" title="小">*IORATIO_AROUU*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: AROU -->

				</table>
				<!---------- AROU ---------->
				<!---------- BROU ---------->
				<table id="model_BROU" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name"><span class="bet_all_15left">15 分钟盘口: 15:00 - 29:59 分钟 - 大 / 小</span><span class="bet_all_15right">15分钟 比分: *SCORE_HB* - *SCORE_CB*</span></span><span id="star_BROU" name="star_BROU" onClick="addFavorites('BROU');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: BROU -->
					<tr class="bet_all_game_h">
						<td id="*BROUO_GID*" onClick="betEvent('*GID*','BROUO','*IORATIO_BROUO*','BROU');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">大</span><span class="bet_all_middle">*RATIO_BROUO*</span><span class="bet_all_bet"><span class="bet_all_bg" title="大">*IORATIO_BROUO*</span></span></div></td>
						<td id="*BROUU_GID*" onClick="betEvent('*GID*','BROUU','*IORATIO_BROUU*','BROU');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">小</span><span class="bet_all_middle">*RATIO_BROUU*</span><span class="bet_all_bet"><span class="bet_all_bg" title="小">*IORATIO_BROUU*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: BROU -->

				</table>
				<!---------- BROU ---------->
				<!---------- DROU ---------->
				<table id="model_DROU" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name"><span class="bet_all_15left">15 分钟盘口: 下半场开始&nbsp;- 59:59 分钟 - 大 / 小</span><span class="bet_all_15right">15分钟 比分: *SCORE_HD* - *SCORE_CD*</span></span><span id="star_DROU" name="star_DROU" onClick="addFavorites('DROU');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: DROU -->
					<tr class="bet_all_game_h">
						<td id="*DROUO_GID*" onClick="betEvent('*GID*','DROUO','*IORATIO_DROUO*','DROU');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">大</span><span class="bet_all_middle">*RATIO_DROUO*</span><span class="bet_all_bet"><span class="bet_all_bg" title="大">*IORATIO_DROUO*</span></span></div></td>
						<td id="*DROUU_GID*" onClick="betEvent('*GID*','DROUU','*IORATIO_DROUU*','DROU');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">小</span><span class="bet_all_middle">*RATIO_DROUU*</span><span class="bet_all_bet"><span class="bet_all_bg" title="小">*IORATIO_DROUU*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: DROU -->

				</table>
				<!---------- DROU ---------->
				<!---------- EROU ---------->
				<table id="model_EROU" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name"><span class="bet_all_15left">15 分钟盘口: 60:00 - 74:59 分钟 - 大 / 小</span><span class="bet_all_15right">15分钟 比分: *SCORE_HE* - *SCORE_CE*</span></span><span id="star_EROU" name="star_EROU" onClick="addFavorites('EROU');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: EROU -->
					<tr class="bet_all_game_h">
						<td id="*EROUO_GID*" onClick="betEvent('*GID*','EROUO','*IORATIO_EROUO*','EROU');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">大</span><span class="bet_all_middle">*RATIO_EROUO*</span><span class="bet_all_bet"><span class="bet_all_bg" title="大">*IORATIO_EROUO*</span></span></div></td>
						<td id="*EROUU_GID*" onClick="betEvent('*GID*','EROUU','*IORATIO_EROUU*','EROU');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">小</span><span class="bet_all_middle">*RATIO_EROUU*</span><span class="bet_all_bet"><span class="bet_all_bg" title="小">*IORATIO_EROUU*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: EROU -->

				</table>
				<!---------- EROU ---------->
				<!---------- ARM ---------->
				<table id="model_ARM" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">15 分钟盘口: 开场&nbsp;- 14:59 分钟 - 独赢</span><span id="star_ARM" name="star_ARM" onClick="addFavorites('ARM');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: ARM -->
					<tr class="bet_all_game_h">
						<td id="*ARMH_GID*" onClick="betEvent('*GID*','ARMH','*IORATIO_ARMH*','ARM');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_H*>*IORATIO_ARMH*</span></span></div></td>

						<td id="*ARMN_GID*" onClick="betEvent('*GID*','ARMN','*IORATIO_ARMN*','ARM');" class="bet_all_three_middle"><div class="bet_all_div"><span class="bet_all_team">和局</span><span class="bet_all_bet"><span class="bet_all_bg" title="和局">*IORATIO_ARMN*</span></span></div></td>

						<td id="*ARMC_GID*" onClick="betEvent('*GID*','ARMC','*IORATIO_ARMC*','ARM');" class="bet_all_three"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_C*>*IORATIO_ARMC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: ARM -->


				</table>
				<!---------- ARM ---------->
				<!---------- BRM ---------->
				<table id="model_BRM" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">15 分钟盘口: 15:00 - 29:59 分钟 - 独赢</span><span id="star_BRM" name="star_BRM" onClick="addFavorites('BRM');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: BRM -->
					<tr class="bet_all_game_h">
						<td id="*BRMH_GID*" onClick="betEvent('*GID*','BRMH','*IORATIO_BRMH*','BRM');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_H*>*IORATIO_BRMH*</span></span></div></td>

						<td id="*BRMN_GID*" onClick="betEvent('*GID*','BRMN','*IORATIO_BRMN*','BRM');" class="bet_all_three_middle"><div class="bet_all_div"><span class="bet_all_team">和局</span><span class="bet_all_bet"><span class="bet_all_bg" title="和局">*IORATIO_BRMN*</span></span></div></td>

						<td id="*BRMC_GID*" onClick="betEvent('*GID*','BRMC','*IORATIO_BRMC*','BRM');" class="bet_all_three"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_C*>*IORATIO_BRMC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: BRM -->


				</table>
				<!---------- BRM ---------->
				<!---------- DRM ---------->
				<table id="model_DRM" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">15 分钟盘口: 下半场开始&nbsp;- 59:59 分钟 - 独赢</span><span id="star_DRM" name="star_DRM" onClick="addFavorites('DRM');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: DRM -->
					<tr class="bet_all_game_h">
						<td id="*DRMH_GID*" onClick="betEvent('*GID*','DRMH','*IORATIO_DRMH*','DRM');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_H*>*IORATIO_DRMH*</span></span></div></td>

						<td id="*DRMN_GID*" onClick="betEvent('*GID*','DRMN','*IORATIO_DRMN*','DRM');" class="bet_all_three_middle"><div class="bet_all_div"><span class="bet_all_team">和局</span><span class="bet_all_bet"><span class="bet_all_bg" title="和局">*IORATIO_DRMN*</span></span></div></td>

						<td id="*DRMC_GID*" onClick="betEvent('*GID*','DRMC','*IORATIO_DRMC*','DRM');" class="bet_all_three"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_C*>*IORATIO_DRMC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: DRM -->
				</table>
				<!---------- DRM ---------->
				<!---------- ERM ---------->
				<table id="model_ERM" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">15 分钟盘口: 60:00 - 74:59 分钟 - 独赢</span><span id="star_ERM" name="star_ERM" onClick="addFavorites('ERM');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: ERM -->
					<tr class="bet_all_game_h">
						<td id="*ERMH_GID*" onClick="betEvent('*GID*','ERMH','*IORATIO_ERMH*','ERM');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_H*>*IORATIO_ERMH*</span></span></div></td>

						<td id="*ERMN_GID*" onClick="betEvent('*GID*','ERMN','*IORATIO_ERMN*','ERM');" class="bet_all_three_middle"><div class="bet_all_div"><span class="bet_all_team">和局</span><span class="bet_all_bet"><span class="bet_all_bg" title="和局">*IORATIO_ERMN*</span></span></div></td>

						<td id="*ERMC_GID*" onClick="betEvent('*GID*','ERMC','*IORATIO_ERMC*','ERM');" class="bet_all_three"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_C*>*IORATIO_ERMC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: ERM -->


				</table>
				<!---------- ERM ---------->
				<!---------- RPD ---------->
				<table id="model_RPD" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="5"><span class="bet_all_name">波胆</span><span id="star_RPD" name="star_RPD" onClick="addFavorites('RPD');" class="bet_all_game_star_out"></span></td>
					</tr>


					<!-- START DYNAMIC BLOCK: RPD -->
					<tr class="bet_all_team_title">
						<td colspan="2" class="bet_all_col5_w">*TEAM_H*</td>
						<td class="bet_all_coldraw_w">和局</td>
						<td colspan="2" class="bet_all_col5_w">*TEAM_C*</td>
					</tr>


					<tr class="bet_all_game_h">
						<td id="*RH1C0_GID*" onClick="betEvent('*GID*','RH1C0','*IORATIO_RH1C0*','RPD');" class="bet_all_five_left"><span class="bet_all_any_text">1 - 0</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_RH1C0*</span></span></td>
						<td id="*RH2C0_GID*" onClick="betEvent('*GID*','RH2C0','*IORATIO_RH2C0*','RPD');" class="bet_all_five_left"><span class="bet_all_any_text">2 - 0</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_RH2C0*</span></span></td>
						<td id="*RH0C0_GID*" onClick="betEvent('*GID*','RH0C0','*IORATIO_RH0C0*','RPD');" class="bet_all_five_left"><span class="bet_all_any_text">0 - 0</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_RH0C0*</span></span></td>
						<td id="*RH0C1_GID*" onClick="betEvent('*GID*','RH0C1','*IORATIO_RH0C1*','RPD');" class="bet_all_five_left"><span class="bet_all_any_text">0 - 1</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_RH0C1*</span></span></td>
						<td id="*RH0C2_GID*" onClick="betEvent('*GID*','RH0C2','*IORATIO_RH0C2*','RPD');" class="bet_all_five"><span class="bet_all_any_text">0 - 2</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_RH0C2*</span></span></td>
					</tr>




					<tr class="bet_all_game_h">
						<td id="*RH2C1_GID*" onClick="betEvent('*GID*','RH2C1','*IORATIO_RH2C1*','RPD');" class="bet_all_five_left"><span class="bet_all_any_text">2 - 1</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_RH2C1*</span></span></td>
						<td id="*RH3C0_GID*" onClick="betEvent('*GID*','RH3C0','*IORATIO_RH3C0*','RPD');" class="bet_all_five_left"><span class="bet_all_any_text">3 - 0</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_RH3C0*</span></span></td>
						<td id="*RH1C1_GID*" onClick="betEvent('*GID*','RH1C1','*IORATIO_RH1C1*','RPD');" class="bet_all_five_left"><span class="bet_all_any_text">1 - 1</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_RH1C1*</span></span></td>
						<td id="*RH1C2_GID*" onClick="betEvent('*GID*','RH1C2','*IORATIO_RH1C2*','RPD');" class="bet_all_five_left"><span class="bet_all_any_text">1 - 2</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_RH1C2*</span></span></td>
						<td id="*RH0C3_GID*" onClick="betEvent('*GID*','RH0C3','*IORATIO_RH0C3*','RPD');" class="bet_all_five"><span class="bet_all_any_text">0 - 3</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_RH0C3*</span></span></td>
					</tr>






					<tr class="bet_all_game_h">
						<td id="*RH3C1_GID*" onClick="betEvent('*GID*','RH3C1','*IORATIO_RH3C1*','RPD');" class="bet_all_five_left"><span class="bet_all_any_text">3 - 1</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_RH3C1*</span></span></td>
						<td id="*RH3C2_GID*" onClick="betEvent('*GID*','RH3C2','*IORATIO_RH3C2*','RPD');" class="bet_all_five_left"><span class="bet_all_any_text">3 - 2</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_RH3C2*</span></span></td>
						<td id="*RH2C2_GID*" onClick="betEvent('*GID*','RH2C2','*IORATIO_RH2C2*','RPD');" class="bet_all_five_left"><span class="bet_all_any_text">2 - 2</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_RH2C2*</span></span></td>
						<td id="*RH1C3_GID*" onClick="betEvent('*GID*','RH1C3','*IORATIO_RH1C3*','RPD');" class="bet_all_five_left"><span class="bet_all_any_text">1 - 3</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_RH1C3*</span></span></td>
						<td id="*RH2C3_GID*" onClick="betEvent('*GID*','RH2C3','*IORATIO_RH2C3*','RPD');" class="bet_all_five"><span class="bet_all_any_text">2 - 3</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_RH2C3*</span></span></td>
					</tr>




					<tr class="bet_all_game_h">
						<td id="*RH4C0_GID*" onClick="betEvent('*GID*','RH4C0','*IORATIO_RH4C0*','RPD');" class="bet_all_five_left"><span class="bet_all_any_text">4 - 0</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_RH4C0*</span></span></td>
						<td id="*RH4C1_GID*" onClick="betEvent('*GID*','RH4C1','*IORATIO_RH4C1*','RPD');" class="bet_all_five_left"><span class="bet_all_any_text">4 - 1</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_RH4C1*</span></span></td>
						<td id="*RH3C3_GID*" onClick="betEvent('*GID*','RH3C3','*IORATIO_RH3C3*','RPD');" class="bet_all_five_left"><span class="bet_all_any_text">3 - 3</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_RH3C3*</span></span></td>
						<td id="*RH0C4_GID*" onClick="betEvent('*GID*','RH0C4','*IORATIO_RH0C4*','RPD');" class="bet_all_five_left"><span class="bet_all_any_text">0 - 4</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_RH0C4*</span></span></td>
						<td id="*RH1C4_GID*" onClick="betEvent('*GID*','RH1C4','*IORATIO_RH1C4*','RPD');" class="bet_all_five"><span class="bet_all_any_text">1 - 4</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_RH1C4*</span></span></td>
					</tr>




					<tr class="bet_all_game_h">
						<td id="*RH4C2_GID*" onClick="betEvent('*GID*','RH4C2','*IORATIO_RH4C2*','RPD');" class="bet_all_five_left"><span class="bet_all_any_text">4 - 2</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_RH4C2*</span></span></td>
						<td id="*RH4C3_GID*" onClick="betEvent('*GID*','RH4C3','*IORATIO_RH4C3*','RPD');" class="bet_all_five_left"><span class="bet_all_any_text">4 - 3</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_RH4C3*</span></span></td>
						<td id="*RH4C4_GID*" onClick="betEvent('*GID*','RH4C4','*IORATIO_RH4C4*','RPD');" class="bet_all_five_left"><span class="bet_all_any_text">4 - 4</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_RH4C4*</span></span></td>
						<td id="*RH2C4_GID*" onClick="betEvent('*GID*','RH2C4','*IORATIO_RH2C4*','RPD');" class="bet_all_five_left"><span class="bet_all_any_text">2 - 4</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_RH2C4*</span></span></td>
						<td id="*RH3C4_GID*" onClick="betEvent('*GID*','RH3C4','*IORATIO_RH3C4*','RPD');" class="bet_all_five"><span class="bet_all_any_text">3 - 4</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_RH3C4*</span></span></td>
					</tr>



					<tr class="bet_all_game_h">
						<td id="*ROVH_GID*" onClick="betEvent('*GID*','ROVH','*IORATIO_ROVH*','RPD');" colspan="5" class="bet_all_five_last"><span class="bet_all_five_other">其他比分</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_ROVH*</span></span></td>
					</tr>
					<!-- END DYNAMIC BLOCK: RPD -->


				</table>
				<!---------- RPD ---------->
				<!---------- HRPD ---------->
				<table id="model_HRPD" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="5"><span class="bet_all_name">波胆<tt class="bet_name_color">&nbsp;- 上半场</tt></span><span id="star_HRPD" name="star_HRPD" onClick="addFavorites('HRPD');" class="bet_all_game_star_out"></span></td>
					</tr>


					<!-- START DYNAMIC BLOCK: HRPD -->
					<tr class="bet_all_team_title">
						<td colspan="2" class="bet_all_col5_w">*TEAM_H*</td>
						<td class="bet_all_coldraw_w">和局</td>
						<td colspan="2" class="bet_all_col5_w">*TEAM_C*</td>
					</tr>


					<tr class="bet_all_game_h">
						<td id="*HRH1C0_HGID*" onClick="betEvent('*HGID*','HRH1C0','*IORATIO_HRH1C0*','HRPD');" class="bet_all_five_left"><span class="bet_all_any_text">1 - 0</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HRH1C0*</span></span></td>
						<td id="*HRH2C0_HGID*" onClick="betEvent('*HGID*','HRH2C0','*IORATIO_HRH2C0*','HRPD');" class="bet_all_five_left"><span class="bet_all_any_text">2 - 0</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HRH2C0*</span></span></td>
						<td id="*HRH0C0_HGID*" onClick="betEvent('*HGID*','HRH0C0','*IORATIO_HRH0C0*','HRPD');" class="bet_all_five_left"><span class="bet_all_any_text">0 - 0</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HRH0C0*</span></span></td>
						<td id="*HRH0C1_HGID*" onClick="betEvent('*HGID*','HRH0C1','*IORATIO_HRH0C1*','HRPD');" class="bet_all_five_left"><span class="bet_all_any_text">0 - 1</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HRH0C1*</span></span></td>
						<td id="*HRH0C2_HGID*" onClick="betEvent('*HGID*','HRH0C2','*IORATIO_HRH0C2*','HRPD');" class="bet_all_five"><span class="bet_all_any_text">0 - 2</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HRH0C2*</span></span></td>
					</tr>




					<tr class="bet_all_game_h">
						<td id="*HRH2C1_HGID*" onClick="betEvent('*HGID*','HRH2C1','*IORATIO_HRH2C1*','HRPD');" class="bet_all_five_left"><span class="bet_all_any_text">2 - 1</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HRH2C1*</span></span></td>
						<td id="*HRH3C0_HGID*" onClick="betEvent('*HGID*','HRH3C0','*IORATIO_HRH3C0*','HRPD');" class="bet_all_five_left"><span class="bet_all_any_text">3 - 0</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HRH3C0*</span></span></td>
						<td id="*HRH1C1_HGID*" onClick="betEvent('*HGID*','HRH1C1','*IORATIO_HRH1C1*','HRPD');" class="bet_all_five_left"><span class="bet_all_any_text">1 - 1</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HRH1C1*</span></span></td>
						<td id="*HRH1C2_HGID*" onClick="betEvent('*HGID*','HRH1C2','*IORATIO_HRH1C2*','HRPD');" class="bet_all_five_left"><span class="bet_all_any_text">1 - 2</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HRH1C2*</span></span></td>
						<td id="*HRH0C3_HGID*" onClick="betEvent('*HGID*','HRH0C3','*IORATIO_HRH0C3*','HRPD');" class="bet_all_five"><span class="bet_all_any_text">0 - 3</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HRH0C3*</span></span></td>
					</tr>






					<tr class="bet_all_game_h">
						<td id="*HRH3C1_HGID*" onClick="betEvent('*HGID*','HRH3C1','*IORATIO_HRH3C1*','HRPD');" class="bet_all_five_left"><span class="bet_all_any_text">3 - 1</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HRH3C1*</span></span></td>
						<td id="*HRH3C2_HGID*" onClick="betEvent('*HGID*','HRH3C2','*IORATIO_HRH3C2*','HRPD');" class="bet_all_five_left"><span class="bet_all_any_text">3 - 2</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HRH3C2*</span></span></td>
						<td id="*HRH2C2_HGID*" onClick="betEvent('*HGID*','HRH2C2','*IORATIO_HRH2C2*','HRPD');" class="bet_all_five_left"><span class="bet_all_any_text">2 - 2</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HRH2C2*</span></span></td>
						<td id="*HRH1C3_HGID*" onClick="betEvent('*HGID*','HRH1C3','*IORATIO_HRH1C3*','HRPD');" class="bet_all_five_left"><span class="bet_all_any_text">1 - 3</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HRH1C3*</span></span></td>
						<td id="*HRH2C3_HGID*" onClick="betEvent('*HGID*','HRH2C3','*IORATIO_HRH2C3*','HRPD');" class="bet_all_five"><span class="bet_all_any_text">2 - 3</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HRH2C3*</span></span></td>
					</tr>




					<tr class="bet_all_game_h">
						<td class="bet_all_five_left"></td>
						<td class="bet_all_five_left"></td>
						<td id="*HRH3C3_HGID*" onClick="betEvent('*HGID*','HRH3C3','*IORATIO_HRH3C3*','HRPD');" class="bet_all_five_left"><span class="bet_all_any_text">3 - 3</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HRH3C3*</span></span></td>
						<td class="bet_all_five_left"></td>
						<td class="bet_all_five"></td>
					</tr>



					<tr class="bet_all_game_h">
						<td id="*HROVH_HGID*" onClick="betEvent('*HGID*','HROVH','*IORATIO_HROVH*','HRPD');" colspan="5" class="bet_all_five_last"><span class="bet_all_five_other">其他比分</span><span class="bet_all_any_bold"><span class="bet_all_bg">*IORATIO_HROVH*</span></span></td>
					</tr>
					<!-- END DYNAMIC BLOCK: HRPD -->


				</table>
				<!---------- HRPD ---------->
				<!---------- RT ---------->
				<table id="model_RT" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="5"><span class="bet_all_name">总进球数</span><span id="star_RT" name="star_RT" onClick="addFavorites('RT');" class="bet_all_game_star_out"></span></td>
					</tr>
					<!-- START DYNAMIC BLOCK: RT -->
					<tr class="bet_all_game_h">
						<td id="*RT01_GID*" onClick="betEvent('*GID*','R0~1','*IORATIO_RT01*','RT');" class="bet_all_four_left"><span class="bet_all_any_text">0 - 1</span><span class="bet_all_any_bold"><span class="bet_all_bg" title="0 - 1">*IORATIO_RT01*</span></span></td>
						<td id="*RT23_GID*" onClick="betEvent('*GID*','R2~3','*IORATIO_RT23*','RT');" class="bet_all_four_left"><span class="bet_all_any_text">2 - 3</span><span class="bet_all_any_bold"><span class="bet_all_bg" title="2 - 3">*IORATIO_RT23*</span></span></td>
						<td id="*RT46_GID*" onClick="betEvent('*GID*','R4~6','*IORATIO_RT46*','RT');" class="bet_all_four_left"><span class="bet_all_any_text">4 - 6</span><span class="bet_all_any_bold"><span class="bet_all_bg" title="4 - 6">*IORATIO_RT46*</span></span></td>
						<td id="*ROVER_GID*" onClick="betEvent('*GID*','ROVER','*IORATIO_ROVER*','RT');" class="bet_all_four"><span class="bet_all_any_text_long">7<tt class="bet_all_text_small">或以上</tt></span><span class="bet_all_any_bold"><span class="bet_all_bg" title="7或以上">*IORATIO_ROVER*</span></span></td>
					</tr>
					<!-- END DYNAMIC BLOCK: RT -->
				</table>
				<!---------- RT ---------->
				<!---------- HRT ---------->
				<table id="model_HRT" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="5"><span class="bet_all_name">总进球数<tt class="bet_name_color">&nbsp;- 上半场</tt></span><span id="star_HRT" name="star_HRT" onClick="addFavorites('HRT');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: HRT -->
					<tr class="bet_all_game_h">
						<td id="*HRT0_HGID*" onClick="betEvent('*HGID*','HRT0','*IORATIO_HRT0*','HRT');" class="bet_all_four_left"><span class="bet_all_any_text">0</span><span class="bet_all_any_bold"><span class="bet_all_bg" title="0">*IORATIO_HRT0*</span></span></td>
						<td id="*HRT1_HGID*" onClick="betEvent('*HGID*','HRT1','*IORATIO_HRT1*','HRT');" class="bet_all_four_left"><span class="bet_all_any_text">1</span><span class="bet_all_any_bold"><span class="bet_all_bg" title="1">*IORATIO_HRT1*</span></span></td>
						<td id="*HRT2_HGID*" onClick="betEvent('*HGID*','HRT2','*IORATIO_HRT2*','HRT');" class="bet_all_four_left"><span class="bet_all_any_text">2</span><span class="bet_all_any_bold"><span class="bet_all_bg" title="2">*IORATIO_HRT2*</span></span></td>
						<td id="*HRTOV_HGID*" onClick="betEvent('*HGID*','HRTOV','*IORATIO_HRTOV*','HRT');" class="bet_all_four"><span class="bet_all_any_text_long">3<tt class="bet_all_text_small">或以上</tt></span><span class="bet_all_any_bold"><span class="bet_all_bg" title="3或以上">*IORATIO_HRTOV*</span></span></td>
					</tr>
					<!-- END DYNAMIC BLOCK: HRT -->

				</table>
				<!---------- HRT ---------->
				<!---------- RF ---------->
				<table id="model_RF" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">半场 / 全场</span><span id="star_RF" name="star_RF" onClick="addFavorites('RF');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: RF -->

					<tr class="bet_all_game_h">
						<td id="*RFHH_GID*" onClick="betEvent('*GID*','RFHH','*IORATIO_RFHH*','RF');" class="bet_all_three_left_2"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H* / *TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg" title="*TEAM_H* / *TEAM_H*">*IORATIO_RFHH*</span></span></div></td>
						<td id="*RFNH_GID*" onClick="betEvent('*GID*','RFNH','*IORATIO_RFNH*','RF');" class="bet_all_three_left_2"><div class="bet_all_div"><span class="bet_all_team">和局 / *TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg" title="和局 / *TEAM_H*">*IORATIO_RFNH*</span></span></div></td>
						<td id="*RFCH_GID*" onClick="betEvent('*GID*','RFCH','*IORATIO_RFCH*','RF');" class="bet_all_three_2"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C* / *TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg" title="*TEAM_C* / *TEAM_H*">*IORATIO_RFCH*</span></span></div></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*RFHN_GID*" onClick="betEvent('*GID*','RFHN','*IORATIO_RFHN*','RF');" class="bet_all_three_left_2"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H* / 和局</span><span class="bet_all_bet"><span class="bet_all_bg" title="*TEAM_H* / 和局">*IORATIO_RFHN*</span></span></div></td>
						<td id="*RFNN_GID*" onClick="betEvent('*GID*','RFNN','*IORATIO_RFNN*','RF');" class="bet_all_three_left_2"><div class="bet_all_div"><span class="bet_all_team">和局 / 和局</span><span class="bet_all_bet"><span class="bet_all_bg" title="和局 / 和局">*IORATIO_RFNN*</span></span></div></td>
						<td id="*RFCN_GID*" onClick="betEvent('*GID*','RFCN','*IORATIO_RFCN*','RF');" class="bet_all_three_2"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C* / 和局</span><span class="bet_all_bet"><span class="bet_all_bg" title="*TEAM_C* / 和局">*IORATIO_RFCN*</span></span></div></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*RFHC_GID*" onClick="betEvent('*GID*','RFHC','*IORATIO_RFHC*','RF');"  class="bet_all_three_left_2"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H* / *TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg" title="*TEAM_H* / *TEAM_C*">*IORATIO_RFHC*</span></span></div></td>
						<td id="*RFNC_GID*" onClick="betEvent('*GID*','RFNC','*IORATIO_RFNC*','RF');"  class="bet_all_three_left_2"><div class="bet_all_div"><span class="bet_all_team">和局 / *TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg" title="和局 / *TEAM_C*">*IORATIO_RFNC*</span></span></div></td>
						<td id="*RFCC_GID*" onClick="betEvent('*GID*','RFCC','*IORATIO_RFCC*','RF');"  class="bet_all_three_2"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C* / *TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg" title="*TEAM_C* / *TEAM_C*">*IORATIO_RFCC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: RF -->

				</table>
				<!---------- RF ---------->
				<!---------- RWM ---------->
				<table id="model_RWM" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">净胜球数</span><span id="star_RWM" name="star_RWM" onClick="addFavorites('RWM');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: RWM -->
					<tr class="bet_all_team_title">
						<td class="bet_all_col5_w">*TEAM_H*</td>
						<td class="bet_all_coldraw_w">和局</td>
						<td class="bet_all_col5_w">*TEAM_C*</td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*RWMH1_GID*" onClick="betEvent('*GID*','RWMH1','*IORATIO_RWMH1*','RWM');" class="bet_all_three_left_2"><div class="bet_all_div"><span class="bet_all_team">净胜1球</span><span class="bet_all_bet"><span class="bet_all_bg" title="净胜1球">*IORATIO_RWMH1*</span></span></div></td>
						<td id="*RWM0_GID*" onClick="betEvent('*GID*','RWM0','*IORATIO_RWM0*','RWM');" class="bet_all_three_left_2"><div class="bet_all_div"><span class="bet_all_team">0 - 0 和局</span><span class="bet_all_bet"><span class="bet_all_bg" title="0 - 0 和局">*IORATIO_RWM0*</span></span></div></td>
						<td id="*RWMC1_GID*" onClick="betEvent('*GID*','RWMC1','*IORATIO_RWMC1*','RWM');" class="bet_all_three_2"><div class="bet_all_div"><span class="bet_all_team">净胜1球</span><span class="bet_all_bet"><span class="bet_all_bg" title="净胜1球">*IORATIO_RWMC1*</span></span></div></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*RWMH2_GID*" onClick="betEvent('*GID*','RWMH2','*IORATIO_RWMH2*','RWM');"class="bet_all_three_left_2"><div class="bet_all_div"><span class="bet_all_team">净胜2球</span><span class="bet_all_bet"><span class="bet_all_bg" title="净胜2球">*IORATIO_RWMH2*</span></span></div></td>
						<td id="*RWMN_GID*" onClick="betEvent('*GID*','RWMN','*IORATIO_RWMN*','RWM');"class="bet_all_three_left_2"><div class="bet_all_div"><span class="bet_all_team">任何进球和局</span><span class="bet_all_bet"><span class="bet_all_bg" title="任何进球和局">*IORATIO_RWMN*</span></span></div></td>
						<td id="*RWMC2_GID*" onClick="betEvent('*GID*','RWMC2','*IORATIO_RWMC2*','RWM');"class="bet_all_three_2"><div class="bet_all_div"><span class="bet_all_team">净胜2球</span><span class="bet_all_bet"><span class="bet_all_bg" title="净胜2球">*IORATIO_RWMC2*</span></span></div></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*RWMH3_GID*" onClick="betEvent('*GID*','RWMH3','*IORATIO_RWMH3*','RWM');" class="bet_all_three_left_2"><div class="bet_all_div"><span class="bet_all_team">净胜3球</span><span class="bet_all_bet"><span class="bet_all_bg" title="净胜3球">*IORATIO_RWMH3*</span></span></div></td>
						<td class="bet_all_three_left_2"></td>
						<td id="*RWMC3_GID*" onClick="betEvent('*GID*','RWMC3','*IORATIO_RWMC3*','RWM');" class="bet_all_three_2"><div class="bet_all_div"><span class="bet_all_team">净胜3球</span><span class="bet_all_bet"><span class="bet_all_bg" title="净胜3球">*IORATIO_RWMC3*</span></span></div></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*RWMHOV_GID*" onClick="betEvent('*GID*','RWMHOV','*IORATIO_RWMHOV*','RWM');" class="bet_all_three_left_2"><div class="bet_all_div"><span class="bet_all_team">净胜4球或更多</span><span class="bet_all_bet"><span class="bet_all_bg" title="净胜4球或更多">*IORATIO_RWMHOV*</span></span></div></td>
						<td class="bet_all_three_left_2"></td>
						<td id="*RWMCOV_GID*" onClick="betEvent('*GID*','RWMCOV','*IORATIO_RWMCOV*','RWM');" class="bet_all_three_2"><div class="bet_all_div"><span class="bet_all_team">净胜4球或更多</span><span class="bet_all_bet"><span class="bet_all_bg" title="净胜4球或更多">*IORATIO_RWMCOV*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: RWM -->
				</table>
				<!---------- RWM ---------->
				<!---------- RDC ---------->
				<table id="model_RDC" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">双重机会</span><span id="star_RDC" name="star_RDC" onClick="addFavorites('RDC');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: RDC -->
					<tr class="bet_all_game_h">
						<td id="*RDCHN_GID*" onClick="betEvent('*GID*','RDCHN','*IORATIO_RDCHN*','RDC');" class="bet_all_one"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H* / 和局</span><span class="bet_all_bet"><span class="bet_all_bg" title="*TEAM_H* / 和局">*IORATIO_RDCHN*</span></span></div></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*RDCCN_GID*" onClick="betEvent('*GID*','RDCCN','*IORATIO_RDCCN*','RDC');" class="bet_all_one"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C* / 和局</span><span class="bet_all_bet"><span class="bet_all_bg" title="*TEAM_C* / 和局">*IORATIO_RDCCN*</span></span></div></td>
					</tr>
					<tr class="bet_all_game_h">
						<td id="*RDCHC_GID*" onClick="betEvent('*GID*','RDCHC','*IORATIO_RDCHC*','RDC');" class="bet_all_one"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H* / *TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg" title="*TEAM_H* / *TEAM_C*">*IORATIO_RDCHC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: RDC -->


				</table>
				<!---------- RDC ---------->
				<!---------- RWE ---------->
				<table id="model_RWE" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">赢得任一半场</span><span id="star_RWE" name="star_RWE" onClick="addFavorites('RWE');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: RWE -->
					<tr class="bet_all_game_h">
						<td id="*RWEH_GID*" onClick="betEvent('*GID*','RWEH','*IORATIO_RWEH*','RWE');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_H*>*IORATIO_RWEH*</span></span></div></td>

						<td id="*RWEC_GID*" onClick="betEvent('*GID*','RWEC','*IORATIO_RWEC*','RWE');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_C*>*IORATIO_RWEC*</span></span></div></td>
					</tr>


					<!-- END DYNAMIC BLOCK: RWE -->

				</table>
				<!---------- RWE ---------->
				<!---------- RWB ---------->
				<table id="model_RWB" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">赢得所有半场</span><span id="star_RWB" name="star_RWB" onClick="addFavorites('RWB');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: RWB -->
					<tr class="bet_all_game_h">
						<td id="*RWBH_GID*" onClick="betEvent('*GID*','RWBH','*IORATIO_RWBH*','RWB');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_H*>*IORATIO_RWBH*</span></span></div></td>

						<td id="*RWBC_GID*" onClick="betEvent('*GID*','RWBC','*IORATIO_RWBC*','RWB');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_C*>*IORATIO_RWBC*</span></span></div></td>
					</tr>


					<!-- END DYNAMIC BLOCK: RWB -->

				</table>
				<!---------- RWB ---------->
				<!---------- ARG ---------->
				<table id="model_ARG" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">第一个进球</span><span id="star_ARG" name="star_ARG" onClick="addFavorites('ARG');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: ARG -->
					<tr class="bet_all_game_h">
						<td id="*ARGH_GID*" onClick="betEvent('*GID*','ARGH','*IORATIO_ARGH*','ARG');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_H*>*IORATIO_ARGH*</span></span></div></td>
						<td id="*ARGN_GID*" onClick="betEvent('*GID*','ARGN','*IORATIO_ARGN*','ARG');" class="bet_all_three_middle"><div class="bet_all_div"><span class="bet_all_team">无进球</span><span class="bet_all_bet"><span class="bet_all_bg" title="无进球">*IORATIO_ARGN*</span></span></div></td>
						<td id="*ARGC_GID*" onClick="betEvent('*GID*','ARGC','*IORATIO_ARGC*','ARG');" class="bet_all_three"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_C*>*IORATIO_ARGC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: ARG -->


				</table>
				<!---------- ARG ---------->
				<!---------- BRG ---------->
				<table id="model_BRG" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">第二个进球</span><span id="star_BRG" name="star_BRG" onClick="addFavorites('BRG');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: BRG -->
					<tr class="bet_all_game_h">
						<td id="*BRGH_GID*" onClick="betEvent('*GID*','BRGH','*IORATIO_BRGH*','BRG');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_H*>*IORATIO_BRGH*</span></span></div></td>
						<td id="*BRGN_GID*" onClick="betEvent('*GID*','BRGN','*IORATIO_BRGN*','BRG');" class="bet_all_three_middle"><div class="bet_all_div"><span class="bet_all_team">无进球</span><span class="bet_all_bet"><span class="bet_all_bg" title="无进球">*IORATIO_BRGN*</span></span></div></td>
						<td id="*BRGC_GID*" onClick="betEvent('*GID*','BRGC','*IORATIO_BRGC*','BRG');" class="bet_all_three"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_C*>*IORATIO_BRGC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: BRG -->


				</table>
				<!---------- BRG ---------->
				<!---------- CRG ---------->
				<table id="model_CRG" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">第三个进球</span><span id="star_CRG" name="star_CRG" onClick="addFavorites('CRG');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: CRG -->
					<tr class="bet_all_game_h">
						<td id="*CRGH_GID*" onClick="betEvent('*GID*','CRGH','*IORATIO_CRGH*','CRG');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_H*>*IORATIO_CRGH*</span></span></div></td>
						<td id="*CRGN_GID*" onClick="betEvent('*GID*','CRGN','*IORATIO_CRGN*','CRG');" class="bet_all_three_middle"><div class="bet_all_div"><span class="bet_all_team">无进球</span><span class="bet_all_bet"><span class="bet_all_bg" title="无进球">*IORATIO_CRGN*</span></span></div></td>
						<td id="*CRGC_GID*" onClick="betEvent('*GID*','CRGC','*IORATIO_CRGC*','CRG');" class="bet_all_three"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_C*>*IORATIO_CRGC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: CRG -->


				</table>
				<!---------- CRG ---------->
				<!---------- DRG ---------->
				<table id="model_DRG" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">第四个进球</span><span id="star_DRG" name="star_DRG" onClick="addFavorites('DRG');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: DRG -->
					<tr class="bet_all_game_h">
						<td id="*DRGH_GID*" onClick="betEvent('*GID*','DRGH','*IORATIO_DRGH*','DRG');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_H*>*IORATIO_DRGH*</span></span></div></td>
						<td id="*DRGN_GID*" onClick="betEvent('*GID*','DRGN','*IORATIO_DRGN*','DRG');" class="bet_all_three_middle"><div class="bet_all_div"><span class="bet_all_team">无进球</span><span class="bet_all_bet"><span class="bet_all_bg" title="无进球">*IORATIO_DRGN*</span></span></div></td>
						<td id="*DRGC_GID*" onClick="betEvent('*GID*','DRGC','*IORATIO_DRGC*','DRG');" class="bet_all_three"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_C*>*IORATIO_DRGC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: DRG -->


				</table>
				<!---------- DRG ---------->
				<!---------- ERG ---------->
				<table id="model_ERG" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">第五个进球</span><span id="star_ERG" name="star_ERG" onClick="addFavorites('ERG');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: ERG -->
					<tr class="bet_all_game_h">
						<td id="*ERGH_GID*" onClick="betEvent('*GID*','ERGH','*IORATIO_ERGH*','ERG');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_H*>*IORATIO_ERGH*</span></span></div></td>
						<td id="*ERGN_GID*" onClick="betEvent('*GID*','ERGN','*IORATIO_ERGN*','ERG');" class="bet_all_three_middle"><div class="bet_all_div"><span class="bet_all_team">无进球</span><span class="bet_all_bet"><span class="bet_all_bg" title="无进球">*IORATIO_ERGN*</span></span></div></td>
						<td id="*ERGC_GID*" onClick="betEvent('*GID*','ERGC','*IORATIO_ERGC*','ERG');" class="bet_all_three"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_C*>*IORATIO_ERGC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: ERG -->


				</table>
				<!---------- ERG ---------->
				<!---------- FRG ---------->
				<table id="model_FRG" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">第六个进球</span><span id="star_FRG" name="star_FRG" onClick="addFavorites('FRG');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: FRG -->
					<tr class="bet_all_game_h">
						<td id="*FRGH_GID*" onClick="betEvent('*GID*','FRGH','*IORATIO_FRGH*','FRG');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_H*>*IORATIO_FRGH*</span></span></div></td>
						<td id="*FRGN_GID*" onClick="betEvent('*GID*','FRGN','*IORATIO_FRGN*','FRG');" class="bet_all_three_middle"><div class="bet_all_div"><span class="bet_all_team">无进球</span><span class="bet_all_bet"><span class="bet_all_bg" title="无进球">*IORATIO_FRGN*</span></span></div></td>
						<td id="*FRGC_GID*" onClick="betEvent('*GID*','FRGC','*IORATIO_FRGC*','FRG');" class="bet_all_three"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_C*>*IORATIO_FRGC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: FRG -->


				</table>
				<!---------- FRG ---------->
				<!---------- GRG ---------->
				<table id="model_GRG" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">第七个进球</span><span id="star_GRG" name="star_GRG" onClick="addFavorites('GRG');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: GRG -->
					<tr class="bet_all_game_h">
						<td id="*GRGH_GID*" onClick="betEvent('*GID*','GRGH','*IORATIO_GRGH*','GRG');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_H*>*IORATIO_GRGH*</span></span></div></td>
						<td id="*GRGN_GID*" onClick="betEvent('*GID*','GRGN','*IORATIO_GRGN*','GRG');" class="bet_all_three_middle"><div class="bet_all_div"><span class="bet_all_team">无进球</span><span class="bet_all_bet"><span class="bet_all_bg" title="无进球">*IORATIO_GRGN*</span></span></div></td>
						<td id="*GRGC_GID*" onClick="betEvent('*GID*','GRGC','*IORATIO_GRGC*','GRG');" class="bet_all_three"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_C*>*IORATIO_GRGC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: GRG -->


				</table>
				<!---------- GRG ---------->
				<!---------- HRG ---------->
				<table id="model_HRG" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">第八个进球</span><span id="star_HRG" name="star_HRG" onClick="addFavorites('HRG');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: HRG -->
					<tr class="bet_all_game_h">
						<td id="*HRGH_GID*" onClick="betEvent('*GID*','HRGH','*IORATIO_HRGH*','HRG');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_H*>*IORATIO_HRGH*</span></span></div></td>
						<td id="*HRGN_GID*" onClick="betEvent('*GID*','HRGN','*IORATIO_HRGN*','HRG');" class="bet_all_three_middle"><div class="bet_all_div"><span class="bet_all_team">无进球</span><span class="bet_all_bet"><span class="bet_all_bg" title="无进球">*IORATIO_HRGN*</span></span></div></td>
						<td id="*HRGC_GID*" onClick="betEvent('*GID*','HRGC','*IORATIO_HRGC*','HRG');" class="bet_all_three"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_C*>*IORATIO_HRGC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: HRG -->


				</table>
				<!---------- HRG ---------->
				<!---------- IRG ---------->
				<table id="model_IRG" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">第九个进球</span><span id="star_IRG" name="star_IRG" onClick="addFavorites('IRG');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: IRG -->
					<tr class="bet_all_game_h">
						<td id="*IRGH_GID*" onClick="betEvent('*GID*','IRGH','*IORATIO_IRGH*','IRG');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_H*>*IORATIO_IRGH*</span></span></div></td>
						<td id="*IRGN_GID*" onClick="betEvent('*GID*','IRGN','*IORATIO_IRGN*','IRG');" class="bet_all_three_middle"><div class="bet_all_div"><span class="bet_all_team">无进球</span><span class="bet_all_bet"><span class="bet_all_bg" title="无进球">*IORATIO_IRGN*</span></span></div></td>
						<td id="*IRGC_GID*" onClick="betEvent('*GID*','IRGC','*IORATIO_IRGC*','IRG');" class="bet_all_three"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_C*>*IORATIO_IRGC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: IRG -->


				</table>
				<!---------- IRG ---------->
				<!---------- JRG ---------->
				<table id="model_JRG" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">第十个进球</span><span id="star_JRG" name="star_JRG" onClick="addFavorites('JRG');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: JRG -->
					<tr class="bet_all_game_h">
						<td id="*JRGH_GID*" onClick="betEvent('*GID*','JRGH','*IORATIO_JRGH*','JRG');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_H*>*IORATIO_JRGH*</span></span></div></td>
						<td id="*JRGN_GID*" onClick="betEvent('*GID*','JRGN','*IORATIO_JRGN*','JRG');" class="bet_all_three_middle"><div class="bet_all_div"><span class="bet_all_team">无进球</span><span class="bet_all_bet"><span class="bet_all_bg" title="无进球">*IORATIO_JRGN*</span></span></div></td>
						<td id="*JRGC_GID*" onClick="betEvent('*GID*','JRGC','*IORATIO_JRGC*','JRG');" class="bet_all_three"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_C*>*IORATIO_JRGC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: JRG -->


				</table>
				<!---------- JRG ---------->
				<!---------- RTS ---------->
				<table id="model_RTS" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">双方球队进球</span><span id="star_RTS" name="star_RTS" onClick="addFavorites('RTS');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: RTS -->

					<tr class="bet_all_game_h">
						<td id="*RTSY_GID*" onClick="betEvent('*GID*','RTSY','*IORATIO_RTSY*','RTS');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">是</span><span class="bet_all_bet"><span class="bet_all_bg" title="是">*IORATIO_RTSY*</span></span></div></td>
						<td id="*RTSN_GID*" onClick="betEvent('*GID*','RTSN','*IORATIO_RTSN*','RTS');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">不是</span><span class="bet_all_bet"><span class="bet_all_bg" title="不是">*IORATIO_RTSN*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: RTS -->

				</table>
				<!---------- RTS ---------->
				<!---------- ROUH ---------->
				<table id="model_ROUH" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">球队进球数: <tt class="bet_name_color">*TEAM_H*</tt> -  大 / 小</span><span id="star_ROUH" name="star_ROUH" onClick="addFavorites('ROUH');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: ROUH -->

					<tr class="bet_all_game_h">
						<td id="*ROUHO_GID*" onClick="betEvent('*GID*','ROUHO','*IORATIO_ROUHO*','ROUH');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">大</span><span class="bet_all_middle">*RATIO_ROUHO*</span><span class="bet_all_bet"><span class="bet_all_bg" title="大">*IORATIO_ROUHO*</span></span></div></td>
						<td id="*ROUHU_GID*" onClick="betEvent('*GID*','ROUHU','*IORATIO_ROUHU*','ROUH');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">小</span><span class="bet_all_middle">*RATIO_ROUHU*</span><span class="bet_all_bet"><span class="bet_all_bg" title="小">*IORATIO_ROUHU*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: ROUH -->

				</table>
				<!---------- ROUH ---------->
				<!---------- ROUC ---------->
				<table id="model_ROUC" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">球队进球数: <tt class="bet_name_color">*TEAM_C*</tt> -  大 / 小</span><span id="star_ROUC" name="star_ROUC" onClick="addFavorites('ROUC');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: ROUC -->

					<tr class="bet_all_game_h">
						<td id="*ROUCO_GID*" onClick="betEvent('*GID*','ROUCO','*IORATIO_ROUCO*','ROUC');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">大</span><span class="bet_all_middle">*RATIO_ROUCO*</span><span class="bet_all_bet"><span class="bet_all_bg" title="大">*IORATIO_ROUCO*</span></span></div></td>
						<td id="*ROUCU_GID*" onClick="betEvent('*GID*','ROUCU','*IORATIO_ROUCU*','ROUC');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">小</span><span class="bet_all_middle">*RATIO_ROUCO*</span><span class="bet_all_bet"><span class="bet_all_bg" title="小">*IORATIO_ROUCU*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: ROUC -->

				</table>
				<!---------- ROUC ---------->
				<!---------- HRUH ---------->
				<table id="model_HRUH" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">球队进球数: <tt class="bet_name_color">*TEAM_H*</tt> -  大 / 小<tt class="bet_name_color">&nbsp;- 上半场</tt></span><span id="star_HRUH" name="star_HRUH" onClick="addFavorites('HRUH');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: HRUH -->

					<tr class="bet_all_game_h">
						<td id="*HRUHO_HGID*" onClick="betEvent('*HGID*','HRUHO','*IORATIO_HRUHO*','HRUH');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">大</span><span class="bet_all_middle">*RATIO_HRUHO*</span><span class="bet_all_bet"><span class="bet_all_bg" title="大">*IORATIO_HRUHO*</span></span></div></td>
						<td id="*HRUHU_HGID*" onClick="betEvent('*HGID*','HRUHU','*IORATIO_HRUHU*','HRUH');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">小</span><span class="bet_all_middle">*RATIO_HRUHU*</span><span class="bet_all_bet"><span class="bet_all_bg" title="小">*IORATIO_HRUHU*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: HRUH -->

				</table>
				<!---------- HRUH ---------->
				<!---------- HRUC ---------->
				<table id="model_HRUC" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">球队进球数: <tt class="bet_name_color">*TEAM_C*</tt> -  大 / 小<tt class="bet_name_color">&nbsp;- 上半场</tt></span><span id="star_HRUC" name="star_HRUC" onClick="addFavorites('HRUC');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: HRUC -->

					<tr class="bet_all_game_h">
						<td id="*HRUCO_HGID*" onClick="betEvent('*HGID*','HRUCO','*IORATIO_HRUCO*','HRUC');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">大</span><span class="bet_all_middle">*RATIO_HRUCO*</span><span class="bet_all_bet"><span class="bet_all_bg" title="大">*IORATIO_HRUCO*</span></span></div></td>
						<td id="*HRUCU_HGID*" onClick="betEvent('*HGID*','HRUCU','*IORATIO_HRUCU*','HRUC');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">小</span><span class="bet_all_middle">*RATIO_HRUCO*</span><span class="bet_all_bet"><span class="bet_all_bg" title="小">*IORATIO_HRUCU*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: HRUC -->

				</table>
				<!---------- HRUC ---------->
				<!---------- REO ---------->
				<table id="model_REO" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">单 / 双</span><span id="star_REO" name="star_REO" onClick="addFavorites('REO');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: REO -->

					<tr class="bet_all_game_h">
						<td id="*REOO_GID*" onClick="betEvent('*GID*','RODD','*IORATIO_REOO*','REO');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">单</span><span class="bet_all_bet"><span class="bet_all_bg" title="单">*IORATIO_REOO*</span></span></div></td>
						<td id="*REOE_GID*" onClick="betEvent('*GID*','REVEN','*IORATIO_REOE*','REO');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">双</span><span class="bet_all_bet"><span class="bet_all_bg" title="双">*IORATIO_REOE*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: REO -->

				</table>
				<!---------- REO ---------->
				<!---------- HREO ---------->
				<table id="model_HREO" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">单 / 双<tt class="bet_name_color"> - 上半场</tt></span><span id="star_HREO" name="star_HREO" onClick="addFavorites('HREO');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: HREO -->

					<tr class="bet_all_game_h">
						<td id="*HREOO_HGID*" onClick="betEvent('*HGID*','HRODD','*IORATIO_HREOO*','HREO');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">单</span><span class="bet_all_bet"><span class="bet_all_bg" title="单">*IORATIO_HREOO*</span></span></div></td>
						<td id="*HREOE_HGID*" onClick="betEvent('*HGID*','HREVEN','*IORATIO_HREOE*','HREO');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">双</span><span class="bet_all_bet"><span class="bet_all_bg" title="双">*IORATIO_HREOE*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: HREO -->

				</table>
				<!---------- HREO ---------->
				<!---------- RCS ---------->
				<table id="model_RCS" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">零失球</span><span id="star_RCS" name="star_RCS" onClick="addFavorites('RCS');"class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: RCS -->

					<tr class="bet_all_game_h">
						<td id="*RCSH_GID*" onClick="betEvent('*GID*','RCSH','*IORATIO_RCSH*','RCS');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_H*>*IORATIO_RCSH*</span></span></div></td>
						<td id="*RCSC_GID*" onClick="betEvent('*GID*','RCSC','*IORATIO_RCSC*','RCS');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_C*>*IORATIO_RCSC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: RCS -->

				</table>
				<!---------- RCS ---------->
				<!---------- RWN ---------->
				<table id="model_RWN" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">零失球获胜</span><span id="star_RWN" name="star_RWN" onClick="addFavorites('RWN');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: RWN -->

					<tr class="bet_all_game_h">
						<td id="*RWNH_GID*" onClick="betEvent('*GID*','RWNH','*IORATIO_RWNH*','RWN');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_H*>*IORATIO_RWNH*</span></span></div></td>
						<td id="*RWNC_GID*" onClick="betEvent('*GID*','RWNC','*IORATIO_RWNC*','RWN');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_C*>*IORATIO_RWNC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: RWN -->

				</table>
				<!---------- RWN ---------->
				<!---------- - RHG--------->
				<table id="model_RHG" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">最多进球的半场</span><span id="star_RHG" name="star_RHG" onClick="addFavorites('RHG');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: RHG -->
					<tr class="bet_all_game_h">
						<td id="*RHGH_GID*" onClick="betEvent('*GID*','RHGH','*IORATIO_RHGH*','RHG');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">上半场</span><span class="bet_all_bet"><span class="bet_all_bg" title="上半场">*IORATIO_RHGH*</span></span></div></td>

						<td id="*RHGC_GID*" onClick="betEvent('*GID*','RHGC','*IORATIO_RHGC*','RHG');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">下半场</span><span class="bet_all_bet"><span class="bet_all_bg" title="下半场">*IORATIO_RHGC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: RHG -->

				</table>
				<!---------- RHG ---------->
				<!---------- RMG ---------->
				<table id="model_RMG" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">最多进球的半场 - 独赢</span><span id="star_RMG" name="star_RMG" onClick="addFavorites('RMG');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: RMG -->
					<tr class="bet_all_game_h">
						<td id="*RMGH_GID*" onClick="betEvent('*GID*','RMGH','*IORATIO_RMGH*','RMG');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">上半场</span><span class="bet_all_bet"><span class="bet_all_bg" title="上半场">*IORATIO_RMGH*</span></span></div></td>

						<td id="*RMGC_GID*" onClick="betEvent('*GID*','RMGC','*IORATIO_RMGC*','RMG');" class="bet_all_three_middle"><div class="bet_all_div"><span class="bet_all_team">下半场</span><span class="bet_all_bet"><span class="bet_all_bg" title="下半场">*IORATIO_RMGC*</span></span></div></td>

						<td id="*RMGN_GID*" onClick="betEvent('*GID*','RMGN','*IORATIO_RMGN*','RMG');" class="bet_all_three"><div class="bet_all_div"><span class="bet_all_team">和局</span><span class="bet_all_bet"><span class="bet_all_bg" title="和局">*IORATIO_RMGN*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: RMG -->


				</table>
				<!---------- RMG ---------->
				<!---------- RSB ---------->
				<table id="model_RSB" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">双半场进球</span><span id="star_RSB" name="star_RSB" onClick="addFavorites('RSB');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: RSB -->
					<tr class="bet_all_game_h">
						<td id="*RSBH_GID*" onClick="betEvent('*GID*','RSBH','*IORATIO_RSBH*','RSB');" class="bet_all_two_left"><div class="bet_all_div"><span class="bet_all_team">*TEAM_H*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_H*>*IORATIO_RSBH*</span></span></div></td>

						<td id="*RSBC_GID*" onClick="betEvent('*GID*','RSBC','*IORATIO_RSBC*','RSB');" class="bet_all_two"><div class="bet_all_div"><span class="bet_all_team">*TEAM_C*</span><span class="bet_all_bet"><span class="bet_all_bg" *TITLE_TEAM_C*>*IORATIO_RSBC*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: RSB -->

				</table>
				<!---------- RSB ---------->
				<!---------- RT3G ---------->
				<table id="model_RT3G" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="3"><span class="bet_all_name">首个进球时间-3项</span><span id="star_RT3G" name="star_RT3G" onClick="addFavorites('RT3G');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: RT3G -->
					<tr class="bet_all_game_h">
						<td id="*RT3G1_GID*" onClick="betEvent('*GID*','RT3G1','*IORATIO_RT3G1*','RT3G');" class="bet_all_one"><div class="bet_all_div"><span class="bet_all_team">第26分钟或之前</span><span class="bet_all_bet"><span class="bet_all_bg" title="第26分钟或之前">*IORATIO_RT3G1*</span></span></div></td>
					</tr>

					<tr class="bet_all_game_h">
						<td id="*RT3G2_GID*" onClick="betEvent('*GID*','RT3G2','*IORATIO_RT3G2*','RT3G');" class="bet_all_one"><div class="bet_all_div"><span class="bet_all_team">第27分钟或之后</span><span class="bet_all_bet"><span class="bet_all_bg" title="第27分钟或之后">*IORATIO_RT3G2*</span></span></div></td>
					</tr>

					<tr class="bet_all_game_h">
						<td id="*RT3GN_GID*" onClick="betEvent('*GID*','RT3GN','*IORATIO_RT3GN*','RT3G');" class="bet_all_one"><div class="bet_all_div"><span class="bet_all_team">无进球</span><span class="bet_all_bet"><span class="bet_all_bg" title="无进球">*IORATIO_RT3GN*</span></span></div></td>
					</tr>
					<!-- END DYNAMIC BLOCK: RT3G -->


				</table>
				<!---------- RT3G ---------->
				<!---------- RT1G ---------->
				<table id="model_RT1G" cellpadding="0" cellspacing="0" border="0" class="bet_all_game_table">
					<tr class="bet_all_game_tr">
						<td colspan="2"><span class="bet_all_name">首个进球时间</span><span id="star_RT1G" name="star_RT1G" onClick="addFavorites('RT1G');" class="bet_all_game_star_out"></span></td>
					</tr>

					<!-- START DYNAMIC BLOCK: RT1G -->
					<tr class="bet_all_game_h">
						<td id="*RT1G1_GID*" onClick="betEvent('*GID*','RT1G1','*IORATIO_RT1G1*','RT1G');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">上半场开场 - 14:59分钟</span><span class="bet_all_bet"><span class="bet_all_bg" title="上半场开场 - 14:59分钟">*IORATIO_RT1G1*</span></span></div></td>
						<td id="*RT1G2_GID*" onClick="betEvent('*GID*','RT1G2','*IORATIO_RT1G2*','RT1G');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">15:00分钟 - 29:59分钟</span><span class="bet_all_bet"><span class="bet_all_bg" title="15:00分钟 - 29:59分钟">*IORATIO_RT1G2*</span></span></div></td>
					</tr>

					<tr class="bet_all_game_h">
						<td id="*RT1G3_GID*" onClick="betEvent('*GID*','RT1G3','*IORATIO_RT1G3*','RT1G');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">30:00分钟 - 半场</span><span class="bet_all_bet"><span class="bet_all_bg" title="30:00分钟 - 半场">*IORATIO_RT1G3*</span></span></div></td>
						<td id="*RT1G4_GID*" onClick="betEvent('*GID*','RT1G4','*IORATIO_RT1G4*','RT1G');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">下半场开场 - 59:59分钟</span><span class="bet_all_bet"><span class="bet_all_bg" title="下半场开场 - 59:59分钟">*IORATIO_RT1G4*</span></span></div></td>
					</tr>

					<tr class="bet_all_game_h">
						<td id="*RT1G5_GID*" onClick="betEvent('*GID*','RT1G5','*IORATIO_RT1G5*','RT1G');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">60:00分钟 - 74:59分钟</span><span class="bet_all_bet"><span class="bet_all_bg" title="60:00分钟 - 74:59分钟">*IORATIO_RT1G5*</span></span></div></td>
						<td id="*RT1G6_GID*" onClick="betEvent('*GID*','RT1G6','*IORATIO_RT1G6*','RT1G');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">75:00分钟 - 全场完场</span><span class="bet_all_bet"><span class="bet_all_bg" title="75:00分钟 - 全场完场">*IORATIO_RT1G6*</span></span></div></td>
					</tr>

					<tr class="bet_all_game_h">
						<td id="*RT1GN_GID*" onClick="betEvent('*GID*','RT1GN','*IORATIO_RT1GN*','RT1G');" class="bet_all_three_left"><div class="bet_all_div"><span class="bet_all_team">无进球</span><span class="bet_all_bet"><span class="bet_all_bg" title="无进球">*IORATIO_RT1GN*</span></span></div></td>
						<td ></td>
					</tr>
					<!-- END DYNAMIC BLOCK: RT1G -->


				</table>
				<!---------- RT1G ---------->
			</div><!--玩法层-->
		</div><!--白底层-->
	</div>
</div><!--最外层-->
</body>
</html>

