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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link rel="stylesheet" href="/style/member/mem_body_ft.css" type="text/css">
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
var R_Regex = new RegExp('\^\RE\?$');
var OU_Regex = new RegExp('\^OU[HC]\?$');
var PD_Regex = new RegExp('\^R\?H\[0\-3\]C\[0\-3\]\?$');
var EO_Regex = new RegExp('\^R\?EO$');

var ObjDataFT = new Array();   //資料
var gid_ary = new Array();   
var gid_rtype_ior = new Array();
var obj_ary = new Array("myMarkets","mainMarkets");

var team_RegExp = new RegExp(' - \\(\[\^\\)\]+\\)');

var open_movie = {"myMarkets":false,"mainMarkets":true};
//var open_mod = {"ALL_Markets":true,"Pop_Markets":true,"HDP_OU":true,"first_Half":true,"Socore":true,"Corners":true,"Specials":true,"Others":true};

var retime_flag;
var retime_run;
var mod="ALL_Markets";
var show_more_sfs = false;    //特殊冠軍 more less
var show_gid;

var allwtype_ary = new Array();

top.more_bgYalloW ="";
var TV_eventid = "";


function sleep(millis)
 {
  var date = new Date();
  var curDate = null;
  do { curDate = new Date(); }
  while(curDate-date < millis);
}

function init(){
	document.getElementById("LoadLayer").style.display="";
	document.getElementById("LoadLayer").style.visibility = "visible";
	parent.document.getElementById('more_window').style.display = "";
//	sleep(1000);
	show_gid = _REQUEST['gid'];	
	open_movieF();
	reloadGameData();
	retime_run = retime;
	if(retime > 0){
		retime_flag='Y';
	}
	else{
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
  getHTML.loadURL("/app/member/get_game_allbets.php","POST", getUrlParam());
	//document.write("/app/member/get_game_allbets.php?"+getUrlParam());
}

function getUrlParam(){
		
		var param = "";
		param="uid="+_REQUEST['uid'];
		param+="&langx="+_REQUEST['langx'];
		param+="& gtype="+_REQUEST['gtype'];
		param+="&showtype="+_REQUEST['showtype'];
		//param+="&testMode="+"2";
		//param+="&gtype="+"FT";
		param+="&gid="+_REQUEST['gid'];
		param+="& ltype="+_REQUEST['ltype'];
		param+="&date="+_REQUEST['date'];

		return param;
		
}

function getNodeVal(Node){
		return Node.childNodes[0].nodeValue;	
}


function reloadGameDataComplete(xml){
		

		
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
		catch(e){;}
		var xmdObj = new Object();		
		xmlnode=new xmlNode(xml.getElementsByTagName("serverresponse"));
		xmlnodeRoot = xml.getElementsByTagName("serverresponse")[0];
		xmdObj["code"] = xmlnode.Node(xmlnodeRoot,"code");
		if(getNodeVal(xmdObj["code"])=="615"){

				ObjDataFT = XML2Array(xmlnode,xmlnodeRoot);
				if(ObjDataFT == ""){
					closeClickEvent();
					return;
				}
				show_close_info(ObjDataFT[show_gid]["gopen"]);
				show_gameInfo(show_gid,ObjDataFT);
				TV_title();
				var div_model = document.getElementById('div_model');
				//wtype
				for(var j=0; j<div_model.children.length; j++){ 
						var tab_model = div_model.children[j].cloneNode(true);
						if(tab_model.nodeName =="TABLE"&&tab_model.id.indexOf("model")!=-1){
								var wtype = tab_model.id.split("_")[1];
								//ms
								for(var ms_num=0;ms_num<=9;ms_num++){
									if(wtype.match("PD") && ms_num!=0)continue;
									document.getElementById('body_'+wtype+ms_num).innerHTML ="";
									var tmpDiv = document.createElement("div");
									tmpDiv.appendChild(tab_model);
									var tpl = new fastTemplate(); 
									tpl.init(tmpDiv);
									var tr_color = 0;
									tmpScreen ="";
									//gid
									tmp_gid=show_gid;

									for(var k=0; k<gid_ary.length; k++){
											var gid = gid_ary[k];
											var ior_arr = getIor(ObjDataFT[gid],wtype,ms_num);
											if(ior_arr=="nodata") continue;
											tmp_gid=gid;
											tpl.addBlock(wtype);
											tr_color++;
											
											tpl = alayer(tpl,ObjDataFT[gid],wtype,ior_arr,tr_color,ms_num);
										}
										var team_h = getTeamName(ObjDataFT[tmp_gid]["team_h"],ms_num);
										var team_c = getTeamName(ObjDataFT[tmp_gid]["team_c"],ms_num);
										var str_ary = get_ms_str(wtype,ms_num);
										tmpScreen = tpl.fastPrint();
										//tmpScreen = tmpScreen.replace(/\*MS_STR\*/g, (ms_num!=0)?" - "+top.str_VB_MS[ms_num]:"");
										tmpScreen = tmpScreen.replace(/\*MS\*/g, ms_num);
										tmpScreen = tmpScreen.replace(/\*TEAM_H\*/g,team_h);
										tmpScreen = tmpScreen.replace(/\*TEAM_C\*/g,team_c);
										tmpScreen = tmpScreen.replace(/\*TITLE_TEAM_H\*/g, "title='"+team_h+"'");//IE tag裡是<?=$strOver?>寫
										tmpScreen = tmpScreen.replace(/\*TITLE_TEAM_C\*/g, "title='"+team_c+"'");
										tmpScreen = tmpScreen.replace(/\*title_team_h\*/g, "title='"+team_h+"'");//chrome..tag<?=$strUnder?>寫
										tmpScreen = tmpScreen.replace(/\*title_team_c\*/g, "title='"+team_c+"'");
										
										for(keys in str_ary){
											//alog(keys+"|"+str_ary[keys]);
											tmpScreen = tmpScreen.replace(new RegExp('\\*'+keys.toUpperCase()+'\\*'),str_ary[keys]);
										}
										
										document.getElementById('body_'+wtype+ms_num).innerHTML += tmpScreen;
										document.getElementById('body_'+wtype+ms_num).style.display = "";
								}
						
						}
				}							
				document.getElementById("LoadLayer").style.display="none";
				document.getElementById("LoadLayer").style.visibility = "hidden";
				/*
				if(more_window_display_none){
						parent.document.getElementById('more_window').style.display='none';
						show_gid='';
				}
				*/
			//最愛				
				var tmp_arr = new (top.Array)();				
				tmp_arr = top.more_fave_wtype[show_gid];			
				top.more_fave_wtype[show_gid] = new (top.Array)();
				for(var i=0; i< tmp_arr.length ; i++){
					wtype = tmp_arr[i];
					addFavorites(wtype);
				}				
		}else{
			closeClickEvent();
		}
	fix_body_wtype();
	//模式處理
	//fixMoreWindow();
}



//liveTV
function liveTVClickEvent(){
	//var eventid = ObjDataFT[show_gid]["eventid"];
	if (TV_eventid != "" && TV_eventid != "null" && TV_eventid != "undefined") {	//判斷是否有轉播
			//parent.OpenLive(TV_eventid,"VB");			
			
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
		parent.parent.body_browse.document.getElementById('MVB').className="bodyset VBR";
		parent.parent.body_browse.document.getElementById('box').style.display="";

		parent.parent.body_browse.document.getElementById('refresh_right').style.display="";	
		parent.parent.body_browse.document.getElementById('refresh_down').style.display="";	
		
		parent.parent.body_browse.scrollTo(0,top.browse_ScrollY);
		retime_flag ="N";
		parent.parent.retime_flag = "Y";
}


//buttons
function btnClickEvent(eventName){
	//alert(eventName);
	if(eventName == "BackToTop" ){
		//parent.body_browse.scrollTo(0,0)
		document.getElementById("more_div").scrollTop = "0";
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
function show_gameInfo(gid,ObjData){

	var gameInfo = document.getElementById("gameInfo");
	
	var league_name = ObjData[gid]["league"];
	var gdatetime = ObjData[gid]["datetime"];
	var team_name_h = ObjData[gid]["team_h"];
	var team_name_c = ObjData[gid]["team_c"];
	var live = ObjData[gid]["Live"];
	var midfield = ObjData[gid]["midfield"];

	var dtime = gdatetime.split(" ");
	var date = dtime[0].split("-");
	var time = dtime[1].split(":");
	
	if(titleDiv == undefined){
		titleDiv = document.createElement("div");
		titleDiv.appendChild(gameInfo.cloneNode(true));
	}
	var tmpDiv = titleDiv.cloneNode(true);	
	var tmp_repl = tmpDiv.innerHTML;
	tmp_repl = tmp_repl.replace('*DATE*',date[2]+" / "+date[1]);
	tmp_repl = tmp_repl.replace('*TIME*',time[0]+":"+time[1]);
	tmp_repl = tmp_repl.replace('*TEAM_H*',team_name_h);
	tmp_repl = tmp_repl.replace('*TEAM_C*',team_name_c);
	tmp_repl = tmp_repl.replace('*MID_DISPLAY*',(midfield=="Y")?"":"style='display:none'");
	tmp_repl = tmp_repl.replace('*mid_display*',(midfield=="Y")?"":"style='display:none'");

	//tmp_repl = tmp_repl.replace('*MIDFIELD*',(midfield == 'Y')?top.str_midfield:"");
	tmpDiv.innerHTML = tmp_repl.replace('*LIVE*',(live == 'Y')?"<span class='more_ln'>LIVE</span>":"");
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
	var cont_myMarket = document.getElementById("count_myMarkets");
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
	cont_myMarket.innerHTML = fave_cont;
	if(fave_cont!=0){
		document.getElementById("movie_myMarkets_nodata").style.display="none";
		favorites_.style.display="";
	}
	body_.style.display="none";
	if(movie_myMarkets.style.display =="none" ) playCssEvent('myMarkets');
	//fixMoreWindow();
	fix_body_wtype();

}
function delFavorites(wtype_str){
	var tmp_arr = new (top.Array)();
	var tmp_wtype ;
	var fave_cont;
	var favorites_ = document.getElementById("favorites_"+wtype_str);
	var body_ = document.getElementById("body_"+wtype_str);
	var cont_myMarket = document.getElementById("count_myMarkets");
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
	cont_myMarket.innerHTML = fave_cont;
	if(fave_cont == 0)document.getElementById("movie_myMarkets_nodata").style.display="";
	favorites_.style.display="none";
	

	if(  mod== "ALL_Markets"||modeMap[wtype_str][mod]){
		body_.style.display ="";
	}
	
	fix_body_wtype();
	//fixMoreWindow();
}


function betEvent(gid,rtype,ratio,wtype){
	//alert(gid+rtype+ratio+wtype);

	if(ratio*1==0)return;
	if(wtype!='NFS'){
		parent.parent.parent.mem_order.betOrder('VB',wtype,getParam(gid,wtype,rtype,ratio));
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
	if( wtype=='M' ){
		var new_type = (type=='H')?'H':'C';
	}
	var param = 'gid='+gid+'&uid='+top.uid+'&odd_f_type='+top.odd_f_type+'&langx='+top.langx+'&rtype='+rtype;
	
	if(wtype=='R' ) {
		
		param += '&gnum='+GameFT['gnum_'+type.toLowerCase()]+'&strong='+strong+'&type='+type;
		
	}else if(wtype=='OU' ) {
		
		param += '&gnum='+GameFT['gnum_'+type.toLowerCase()]+'&type='+type;
		
	}else if(wtype=='M'  ){
		
		param += '&gnum='+GameFT['gnum_'+new_type.toLowerCase()]+'&type='+type;
		
	}else if(wtype.indexOf("PD") != -1 || wtype.indexOf("EO") != -1 ) {
		
		param +='';
		
	}else param += '&wtype='+wtype;
	
	return param;
}



function fixMoreWindow(){
	var tab_show = document.getElementById('tab_show');
	var MVB = parent.document.getElementById('MVB');
	parent.document.getElementById('showdata').width = MVB.offsetWidth;
	parent.document.getElementById('showdata').height = get_max(tab_show.offsetHeight,MVB.offsetHeight);
	
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
	if(ior_value*1 == 0 &&  PD_Regex.test(rtype)  )return "-";
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

function XML2Array(xmlnode,xmlnodeRoot){
	var tmp_Obj = new Array();
	var gameXML = xmlnode.Node(xmlnodeRoot,"game",false);
	gid_ary = new Array();
	for(var k=0; k<gameXML.length; k++){ 
		var tmp_game = gameXML[k];
		var gid = getNodeVal(xmlnode.Node(tmp_game,"gid"));
		var TagName = tmp_game.getElementsByTagName("*");
		
		gid_ary[gid_ary.length] = gid;
		tmp_Obj[gid] = new Array();
		for( var i=0;i<TagName.length;i++){
			try{
				tmp_Obj[gid][TagName[i].nodeName] =  getXML_TagValue(xmlnode,tmp_game,TagName[i].nodeName);
			}
			catch(e){
				//tmp_Obj[gid][TagName[i]] = "";
			}
		}
	}
	return tmp_Obj;
}

function getIor(gdata,wtype,ms_num){

	var gopen = gdata["gopen"];
	var sw = gdata["sw_"+wtype];
	if(gopen == "N") return "nodata" ;
	if(sw == "N") return "nodata" ;
	var ms = gdata["ms"].slice(-1)*1;
	if(ms!= ms_num)return "nodata";		
	
	var map = rtypeMap[wtype];
	var ior = new Object();
	var rtype,ratio_str,type;
	var ior_all_zero = true;
  var strong = gdata['strong'];	

	for(var i=0;i<map.length;i++){
		rtype =  map[i];
		if(!isNaN(gdata["ior_"+rtype]) && gdata["ior_"+rtype]*1 != 0) ior_all_zero= false;
		ior[rtype] = new Object();
		ior[rtype]["ior"] = gdata["ior_"+rtype];
		
		ratio_str = getRatioName(wtype,rtype);
	
		if(gdata[ratio_str]){
				ior[rtype]["ratio"] = gdata[ratio_str];
				
				type = rtype.substr(rtype.length-1,1);
				if(R_Regex.test(wtype) ){
						if(type != strong  || type=="N"){
							ior[rtype]["ratio"] = "";
						}
		  	}
	  }
	}
	if(ior_all_zero)return "nodata";
	if( R_Regex.test(wtype) || OU_Regex.test(wtype) || wtype == 'EO'){
			var arry = new Array();
			if(wtype == 'EO' ) {
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
				if(child_model.innerHTML !="" ) {
					if(wtype.match(/^(OU|R|M|EO)[HC]?[0-6]$/)){
						child_table = child_model.childNodes[0];
						cnt = cnt + child_table.rows.length -1;
					}
					else cnt++;
				}
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
	if (TV_eventid != "" && TV_eventid != "null" && typeof(TV_eventid) != "undefined") {	//判斷是否有轉播
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


function alayer(tpl,adata,wtype,ior_arr,tr_color,ms_num){
	var gid = adata["gid"];
	var sw =adata["sw_"+wtype];
	var strong =adata['strong'];
	for(var t=0; t<rtypeMap[wtype].length; t++){
		var rtype = rtypeMap[wtype][t];	
		var ior = ior_arr[rtype]["ior"];
		var ratio = ior_arr[rtype]["ratio"];
		//replace
		var IORATIO = "IORATIO_"+rtype;
		var RATIO = "RATIO_"+rtype;
		var td_class = "TD_CLASS_"+rtype;
		var RTYPE_GID = rtype+"_GID";
		//replace
		tpl.replace(new RegExp('\\*'+IORATIO+'\\*'), ior);
		tpl.replace(new RegExp('\\*'+IORATIO+'\\*'), parse_ior(gid,rtype,ior));
		tpl.replace(/\*GID\*/g, gid);
		tpl.replace("*TR_CLASS*",((t+tr_color)%2!=0)?"more_white":"more_color");
		tpl.replace(new RegExp('\\*'+RTYPE_GID+'\\*'), rtype+"_"+gid);
		tpl.replace(new RegExp('\\*'+RATIO+'\\*','g'), undefined2space(ratio));

		//背景黃色
		if(top.more_bgYalloW == rtype+"_"+gid ) tpl.replace(new RegExp('\\*'+td_class+'\\*'), "bg_yellow");
		else tpl.replace(new RegExp('\\*'+td_class+'\\*'), "bg_white");

	}
			
	team_h = getTeamName(adata["team_h"],ms_num);
	team_c = getTeamName(adata["team_c"],ms_num);
	tpl.replace(/\*TEAM_H\*/g, team_h);
	tpl.replace(/\*TEAM_C\*/g, team_c);
	tpl.replace(/\*TITLE_TEAM_H\*/g, "title='"+team_h+"'");//IE tag裡是<?=$strOver?>寫
	tpl.replace(/\*TITLE_TEAM_C\*/g, "title='"+team_c+"'");
	tpl.replace(/\*title_team_h\*/g, "title='"+team_h+"'");//chrome..tag<?=$strUnder?>寫
	tpl.replace(/\*title_team_c\*/g, "title='"+team_c+"'");
	return tpl;
}

function getTeamName(str,ms){
	if(ms==0)return str;
	var ans = str.replace(team_RegExp,"");
	return ans;
}


function get_ms_str(wtype,ms_num){
	
	
	var retArray = new Array();
	if(ms_num >= 1)retArray["ms_str"] = " - "+top._session["VBi"+ms_num];
	else retArray["ms_str"] ="";

	
	if(wtype=="OU"||wtype=="EO"){
		if(ms_num==0){
			retArray["head_str"] = top.str_VB_Game;
		}
		else if(ms_num==2){
			retArray["head_str"] = top.str_VB_allPoint;
		}
		else{
			retArray["head_str"] = top.str_VB_point;
		}
	}
	
	if(wtype=="R"){
		if(ms_num==0) retArray["wtype_str"] = top.str_VB_more_r0;
		else retArray["wtype_str"] = top.str_VB_more_r;
	}
	
	
	return retArray;
}

//var array = {aa:10,bb:20}


function alog(str){
	if(console)console.log(str);
}</script>

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
//????????O????(_)
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
//??ܪ??󤺮e
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
//???Jhtml???(??js)
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

	
//?ѪRxml
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


//?ѪRxml Class	
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

//?ѪRxml Class	
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
//?ѪRhtml Class
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
	   	//?ۤv??@?????C?@??div?U????????
	   	//??@????@???^?ӵ???
	   	divObj=null;
	   	
   	}
    _self.removeMC=function(){}
 }
 
 //???Jscript
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
//CSS?ʹ?class	
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
  			//???ocss keyframe size
  			_self.KeyFrameSize=function(){
  				csstag=_self.getCssTag(divObj.style["-webkit-animation-name"]);
  				return csstag.length;
  				}
  				
  			//?]?w??@??css keyframe
        _self.setKeyFrame=function(keyframe,value){
        	csstag=_self.getCssTag(divObj.style["-webkit-animation-name"]);
        	if (keyframe>csstag.length-1) alert("error=>keyframe>size");
        	csstag[keyframe].style.cssText=csstag[0].style[0]+":"+value;
        	}      
        //???ocss?Ҧ?keyframe????                                             
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
var rtypeMap = new Object();

//走地
rtypeMap["RE"] = ["REH","REC"];
rtypeMap["ROU"] = ["ROUH","ROUC"];
rtypeMap["RM"] = ["RMH","RMC"];
rtypeMap["RPD"] = ["RH3C0","RH3C1","RH3C2","RH0C3","RH1C3","RH2C3"];
rtypeMap["REO"] = ["REOO","REOE"];

//單式
rtypeMap["R"] = ["RH","RC"];
rtypeMap["OU"] = ["OUH","OUC"];
rtypeMap["M"] = ["MH","MC","MN"];
rtypeMap["PD"] = ["H3C0","H3C1","H3C2","H0C3","H1C3","H2C3"];
rtypeMap["EO"] = ["EOO","EOE"];</script>

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

<meta http-equiv="Content-Type" content="text/html; charset=utf-8 "><script>
(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5M4BG3');
</script>




</head>
<body id="MFT" class="BODYMORE" onLoad="init();">

<div id="div_show" class="more_b_bg">
<div id="LoadLayer" class="more_load" style="display:none;"><img src="/images/member/loading_pic.gif" width="38" height="38"></div>
<div class="more_three_btn">
	<!------------------------ right buttons ------------------------>
	<table class="more_right_btn">
			<tr><td><input type="button" class="more_btn_re_cn" value="" onClick="btnClickEvent('Refresh');"></td></tr>
			<tr><td><input type="button" class="more_btn_close_cn" value="" onClick="btnClickEvent('Close');"></td></tr>
			<tr><td><input type="button" class="more_btn_back_cn" value="" onClick="btnClickEvent('BackToTop');"></td></tr>
	</table>
	<!------------------------ right buttons ------------------------>
</div>

<div id="more_div" class="more_over">
<table id="tab_show" border="0" cellspacing="0" cellpadding="0" class="more_table">
 	<tr class="mo_bg_h"><td>
	<table id="" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td class="more_title">
				<span id="title_league" name="title_league" class="more_long">*LEAGUE_NAME*</span>
				<input type="button" class="more_x" value="" onClick="closeClickEvent();">
				<span  class="more_re" onClick="reFreshClickEvent();"><span id="refreshTime" class="more_re_t">refresh</span></span>
                <input id="live_tv" type="button" class="more_tv_on" value="" onClick="liveTVClickEvent();" >
			</td>
		</tr>
	</table>			
	<table id="gameInfo" width="100%" border="0" cellspacing="0" cellpadding="0" class="more_bg_table_vb">
		<tr class="more_bg1">
            <td id="title_showtype" name="title_showtype" class="more_live">*LIVE*<img src="/images/member/zh-tw/more_n.jpg" class="more_n" *MID_DISPLAY*/></td>
            <td></td>
			<td class="more_date"><span id="title_date" name="title_date">*DATE*</span>&nbsp;&nbsp;<span id="title_time" name="title_time">*TIME*</span></td>
		</tr>
		<tr class="more_bg2">	
			<td class="mo_bg_1_L"><span id="title_team_h" name="title_team_h">*TEAM_H*</span></td>
            <td class="mo_bg_2">&nbsp;V&nbsp;</td>
            <td class="mo_bg_3_R"><span id="title_team_c" name="title_team_c">*TEAM_C*</span></td>
		</tr>
		<tr class="more_bg3">
			<td id="title_showtype" name="title_showtype" colspan="3">&nbsp;</td>
		</tr>

	</table>
	
	<div id="gameOver" style="display:none;">
		<table border="0" cellpadding="0" cellspacing="0" class="">
			<tr class="more_no2"><td>
				<?=$saishijieshu?>
			</td></tr>
		</table>
	</div>


	<!------------------------ my markets ------------------------>
	<table id="head_myMarkets" width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr onClick="playCssEvent('myMarkets',this);" class="more_hand">
			<td class="more_title2">
					<span id="mark_myMarkets" class="more_up"></span>
					<span style="float: left;"><?=$wodepankou?></span>
					<span class="more_star"></span>
					<span class="more_black"><span id="count_myMarkets" class="more_num">0</span></span>
			</td>
		</tr>
	</table>	
	<div id="movie_myMarkets">
			<div id="movie_myMarkets_nodata">
				<table border="0" cellpadding="0" cellspacing="0" class="">
					<tr class="more_no"><td>
						<?=$tianjiasaishi?>
					</td></tr>
				</table>
			</div>
			<div id="favorites_M0"></div>
			<div id="favorites_R0"></div>
			<div id="favorites_OU0"></div>
			
			<div id="favorites_R2"></div>
			<div id="favorites_OU2"></div>
			
			<div id="favorites_PD0"></div>
			<div id="favorites_EO0"></div>

			<div id="favorites_EO2"></div>
			
			<div id="favorites_R1"></div>
			<div id="favorites_OU1"></div>
			<div id="favorites_M1"></div>
			<div id="favorites_EO1"></div>
			<div id="favorites_M2"></div>
			
			<div id="favorites_M3"></div>
			<div id="favorites_R3"></div>
			<div id="favorites_OU3"></div>
			<div id="favorites_EO3"></div>
			
			<div id="favorites_M4"></div>
			<div id="favorites_R4"></div>
			<div id="favorites_OU4"></div>
			<div id="favorites_EO4"></div>
			
			<div id="favorites_M5"></div>
			<div id="favorites_R5"></div>
			<div id="favorites_OU5"></div>
			<div id="favorites_EO5"></div>
			
			<div id="favorites_M6"></div>
			<div id="favorites_R6"></div>
			<div id="favorites_OU6"></div>
			<div id="favorites_EO6"></div>
			
			<div id="favorites_M7"></div>
			<div id="favorites_R7"></div>
			<div id="favorites_OU7"></div>
			<div id="favorites_EO7"></div>
			
			<div id="favorites_M8"></div>
			<div id="favorites_R8"></div>
			<div id="favorites_OU8"></div>
			<div id="favorites_EO8"></div>
			
			<div id="favorites_M9"></div>
			<div id="favorites_R9"></div>
			<div id="favorites_OU9"></div>
			<div id="favorites_EO9"></div>
	</div>
	<!------------------------ my markets ------------------------>
	
	
	
	
	

	<!------------------------ main markets ------------------------>
	<table id="head_mainMarkets" width="100%" border="0" cellspacing="0" cellpadding="0" class="more_ma">
		<tr onClick="playCssEvent('mainMarkets',this);" class="more_hand">
			<td class="more_title3">
					<span id="mark_mainMarkets" class="more_up"></span>
					<span style="float: left;"><?=$zhupankou?></span>
					<span class="more_black"><span id="count_mainMarkets" class="more_num">0</span></span>
			</td>
		</tr>
	</table>	
	
	
	<div id="movie_mainMarkets">
			<div id="body_M0"></div>
			<div id="body_R0"></div>
			<div id="body_OU0"></div>
			
			<div id="body_R2"></div>
			<div id="body_OU2"></div>
			
			<div id="body_PD0"></div>
			<div id="body_EO0"></div>

			<div id="body_EO2"></div>
			
			<div id="body_R1"></div>
			<div id="body_OU1"></div>
			<div id="body_M1"></div>
			<div id="body_EO1"></div>
			<div id="body_M2"></div>
			
			<div id="body_M3"></div>
			<div id="body_R3"></div>
			<div id="body_OU3"></div>
			<div id="body_EO3"></div>
			
			<div id="body_M4"></div>
			<div id="body_R4"></div>
			<div id="body_OU4"></div>
			<div id="body_EO4"></div>
			
			<div id="body_M5"></div>
			<div id="body_R5"></div>
			<div id="body_OU5"></div>
			<div id="body_EO5"></div>
			
			<div id="body_M6"></div>
			<div id="body_R6"></div>
			<div id="body_OU6"></div>
			<div id="body_EO6"></div>
			
			<div id="body_M7"></div>
			<div id="body_R7"></div>
			<div id="body_OU7"></div>
			<div id="body_EO7"></div>
			
			<div id="body_M8"></div>
			<div id="body_R8"></div>
			<div id="body_OU8"></div>
			<div id="body_EO8"></div>
			
			<div id="body_M9"></div>
			<div id="body_R9"></div>
			<div id="body_OU9"></div>
			<div id="body_EO9"></div>
	</div>

	<!------------------------ main markets ------------------------>
	
	
	</td></tr>
</table>
</div>


<div id="div_model" style="display:none;" >
	
			<!---------- R ---------->
		 	<table id="model_R" border="0" cellpadding="0" cellspacing="0" class="more_table2">
				<tr>
						<th colspan="2" class="more_title4">
							<span style="float: left;">*WTYPE_STR*&nbsp;</span>
							<span class="more_og2">*MS_STR*</span>
							<span class="more_star_bg"><span id="star_R*MS*" name="star_R*MS*" onClick="addFavorites('R*MS*');" class="star_down" title="加到“我的盘口”"></span></span>
						</th>
				</tr>
				
				<!-- START DYNAMIC BLOCK: R -->
				<tr class="*TR_CLASS*">
						<td id="*RH_GID*" onClick="betEvent('*GID*','RH','*IORATIO_RH*','R');" style="cursor:pointer"  class="*TD_CLASS_RH*" width="50%"><div class="more_font"><span class="m_team">*TEAM_H*</span><span class="m_middle">*RATIO_RH*</span><span class="m_red_bet" *TITLE_TEAM_H*>*IORATIO_RH*</span></div></td>
						<td id="*RC_GID*" onClick="betEvent('*GID*','RC','*IORATIO_RC*','R');" style="cursor:pointer"  class="*TD_CLASS_RC*" width="50%"><div class="more_font"><span class="m_team">*TEAM_C*</span><span class="m_middle">*RATIO_RC*</span><span class="m_red_bet" *TITLE_TEAM_C*>*IORATIO_RC*</span></div></td>
				</tr>
				<!-- END DYNAMIC BLOCK: R -->
	
			</table>
			<!---------- R ---------->

			<!---------- OU ---------->
			<table id="model_OU" border="0" cellpadding="0" cellspacing="0" class="more_table2">
				<tr>
						<th class="more_title4" colspan="2">
							<span style="float: left;">*HEAD_STR*</span>
							<span style="float: left;"><?=$ou?>&nbsp;</span>
							<span class="more_og2">*MS_STR*</span>
							<span class="more_star_bg"><span id="star_OU*MS*" name="star_OU*MS*" onClick="addFavorites('OU*MS*');" class="star_down" title="加到“我的盘口”"></span></span>
						</th>
				</tr>
				
				<!-- START DYNAMIC BLOCK: OU -->
				<tr class="*TR_CLASS*">
						<td id="*OUC_GID*" onClick="betEvent('*GID*','OUC','*IORATIO_OUC*','OU');" style="cursor:pointer"  class="*TD_CLASS_OUC*" width="50%"><div class="more_font"><span class="m_team"><?=$strOver?></span><span class="m_middle">*RATIO_OUC*</span><span class="m_red_bet" title="<?=$strOver?>">*IORATIO_OUC*</span></div></td>
						<td id="*OUH_GID*" onClick="betEvent('*GID*','OUH','*IORATIO_OUH*','OU');" style="cursor:pointer"  class="*TD_CLASS_OUH*" width="50%"><div class="more_font"><span class="m_team"><?=$strUnder?></span><span class="m_middle">*RATIO_OUH*</span><span class="m_red_bet" title="<?=$strUnder?>">*IORATIO_OUH*</span></div></td>
				</tr>
				<!-- END DYNAMIC BLOCK: OU -->
	
			</table>
			<!---------- OU ---------->
	
			<!---------- M ---------->
			<table id="model_M" border="0" cellpadding="0" cellspacing="0" class="more_table2">
				<tr>
						<th class="more_title4" colspan="3">
							<span style="float: left;"><?=$duying1?>&nbsp;</span>
							<span class="more_og2">*MS_STR*</span>
							<span class="more_star_bg"><span id="star_M*MS*" name="star_M*MS*" onClick="addFavorites('M*MS*');" class="star_down" title="加到“我的盘口”"></span></span>
						</th>
				</tr>
				
				<!-- START DYNAMIC BLOCK: M -->
				<tr class="*TR_CLASS*">
						<td id="*MH_GID*" onClick="betEvent('*GID*','MH','*IORATIO_MH*','M');" style="cursor:pointer"  class="*TD_CLASS_MH*" width="50%"><div class="more_font"><span class="m_team">*TEAM_H*</span><span class="m_red_bet" *TITLE_TEAM_H*>*IORATIO_MH*</span></div></td>
						<td id="*MC_GID*" onClick="betEvent('*GID*','MC','*IORATIO_MC*','M');" style="cursor:pointer"  class="*TD_CLASS_MC*" width="50%"><div class="more_font"><span class="m_team">*TEAM_C*</span><span class="m_red_bet" *TITLE_TEAM_C*>*IORATIO_MC*</span></div></td>
				</tr>
				<!-- END DYNAMIC BLOCK: M -->
	
			</table>
			<!---------- M ---------->
			<!---------- EO ---------->     
		 	<table id="model_EO" border="0" cellpadding="0" cellspacing="0" class="more_table2">
				<tr>
						<th class="more_title4" colspan="2">
							<span style="float: left;">*HEAD_STR*</span>
							<span style="float: left;"><?=$strOdd?>/<?=$strEven?>&nbsp;</span>
							<span class="more_og2">*MS_STR*</span>
							<span class="more_star_bg"><span id="star_EO*MS*" name="star_EO*MS*" onClick="addFavorites('EO*MS*');" class="star_down" title="加到“我的盘口”"></span></span>
						</th>
				</tr>
				
				<!-- START DYNAMIC BLOCK: EO -->
				<tr class="*TR_CLASS*">
						<td id="*EOO_GID*" onClick="betEvent('*GID*','ODD','*IORATIO_EOO*','EO');" style="cursor:pointer"  class="*TD_CLASS_EOO*" width="50%"><div class="more_font"><span class="m_team"><?=$strOdd?></span><span class="m_red_bet" title="<?=$strOdd?>">*IORATIO_EOO*</span></div></td>
						<td id="*EOE_GID*" onClick="betEvent('*GID*','EVEN','*IORATIO_EOE*','EO');" style="cursor:pointer"  class="*TD_CLASS_EOE*" width="50%"><div class="more_font"><span class="m_team"><?=$strEven?></span><span class="m_red_bet" title="<?=$strEven?>">*IORATIO_EOE*</span></div></td>
				</tr>
				<!-- END DYNAMIC BLOCK: EO -->
	
			</table>
			<!---------- EO ---------->

			<!---------- PD ---------->
		 	<table id="model_PD" border="0" cellpadding="0" cellspacing="0" class="more_table2">
				<tr>
						<th class="more_title4" colspan="6">
							<span style="float: left;"><?=$bodan?></span>
							<span class="more_star_bg"><span id="star_PD" name="star_PD" onClick="addFavorites('PD*MS*');" class="star_down" ></span></span>
						</th>
				</tr>
				
				<!-- START DYNAMIC BLOCK: PD -->
				<tr class="*TR_CLASS*">
						<td colspan="3" class="game_team" width="50%"><span>*TEAM_H*</span></td>
						<td colspan="3" class="game_team" width="50%"><span>*TEAM_C*</span></td>
				</tr>
				
				<tr class="more_white">
						<td id="*H3C0_GID*" onClick="betEvent('*GID*','H3C0','*IORATIO_H3C0*','PD');" style="cursor:pointer"  class="*TD_CLASS_H3C0*" width="16%"><span style="float: left;">3 - 0</span><span class="m_red2" title="3 - 0">*IORATIO_H3C0*</span></td>
						<td id="*H3C1_GID*" onClick="betEvent('*GID*','H3C1','*IORATIO_H3C1*','PD');" style="cursor:pointer"  class="*TD_CLASS_H3C1*" width="16%"><span style="float: left;">3 - 1</span><span class="m_red2" title="3 - 1">*IORATIO_H3C1*</span></td>
						<td id="*H3C2_GID*" onClick="betEvent('*GID*','H3C2','*IORATIO_H3C2*','PD');" style="cursor:pointer"  class="*TD_CLASS_H3C2*" width="16%"><span style="float: left;">3 - 2</span><span class="m_red2" title="3 - 2">*IORATIO_H3C2*</span></td>
						<td id="*H0C3_GID*" onClick="betEvent('*GID*','H0C3','*IORATIO_H0C3*','PD');" style="cursor:pointer"  class="*TD_CLASS_H0C3*" width="16%"><span style="float: left;">0 - 3</span><span class="m_red2" title="0 - 3">*IORATIO_H0C3*</span></td>
						<td id="*H1C3_GID*" onClick="betEvent('*GID*','H1C3','*IORATIO_H1C3*','PD');" style="cursor:pointer"  class="*TD_CLASS_H1C3*" width="16%"><span style="float: left;">1 - 3</span><span class="m_red2" title="1 - 3">*IORATIO_H1C3*</span></td>
						<td id="*H2C3_GID*" onClick="betEvent('*GID*','H2C3','*IORATIO_H2C3*','PD');" style="cursor:pointer"  class="*TD_CLASS_H2C3*" width="16%"><span style="float: left;">2 - 3</span><span class="m_red2" title="2 - 3">*IORATIO_H2C3*</span></td>
				</tr>                                                                                                       
				                                                                                                           				                                                                                                            
				<!-- END DYNAMIC BLOCK: PD -->
	
			</table>
			<!---------- PD ---------->
			

</div>


</body>
</html>