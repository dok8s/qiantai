<?php

include "./include/library.mem.php";
require ("./include/define_function_list.inc.php");
require ("./include/config.inc.php");

$uid=$_REQUEST['uid'];
$mtype=$_REQUEST['mtype'];
$langx=$_REQUEST['langx'];

require ("./include/traditional.$langx.inc.php");

switch($langx){
	case 'en-us':
		$css='_en';
		break;
	case 'zh-tw':
	case 'zh-cn':
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

if($mtype==""){
	$mtype=3;
}
?>
<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Description" content="Description: Welcome to hg0088.com. This is a premium service for registered members.">
<title>hg0088</title>
		<link href="http://66.133.87.20/style/member/reset.css" rel="stylesheet" type="text/css">
		<link href="http://66.133.87.20/style/member/order_en.css" rel="stylesheet" type="text/css">
</head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8 "><script>
var isHot_game = false;//是否為世足賽
var isFixed = true; //2016.0216 Leslie
var view_alldate = (top.select_showtype=="parlay")?true:true; //跨天過關看全部日期
var chgIor_TS = true;	//雙方球隊進球轉成雙盤
var scrollmax = 0;
var blurHash = new Object();
blurHash["pg_txt"] = "N";
//that body_browse be self
var showpage_ie11=false;
var page_sw=true;//ie11 edge 分頁 開關 20160711
var NotMasterDarw=true;//子盤和局要隱藏歐冠後
var getScrollsw=true;//收聯盟時top_back不重取高度

try{
	if(frame_broke) body_browse = this;
	else 			body_browse = body_browse;
}catch(e){
	//try{ console.log("error body_browse set from FT_mem_Function"); }catch(e){};
}


//--------------------------------public function ----------------------------

function setRefreshPos(){
		//var refresh_right= body_browse.document.getElementById('refresh_right');
		//refresh_right.style.left= body_browse.document.getElementById('myTable').clientWidth*1+20;
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
function OBTArray(gameHead,gameData,gameGid){
	var gameObj=new Object();
	for (var i=0;i<gameHead.length;i++){
		if (gameHead[i]!=""){
			gameObj[gameHead[i]]=gameData[i];	
		}
	}
	return gameObj;
}

function check_ioratio(rec,rtype,GameData,mod){
	if(mod==null) mod="";

	if (flash_ior_set =='Y'){
		//alert(oldObjDataFT[rec]);
		if (""+oldObjDataFT[mod+rec]=="undefined" || oldObjDataFT[mod+rec].gid != GameData.gid){
			var gameObj=new Object();
			gameObj.gid=GameData.gid; 
			oldObjDataFT[mod+rec]=gameObj;
		}

		var new_ioratio=GameData[rtype];
		var old_ioratio=oldObjDataFT[mod+rec][rtype];

		if (""+old_ioratio=="undefined"){
			oldObjDataFT[mod+rec][rtype]=GameData[rtype];
			old_ioratio=oldObjDataFT[mod+rec][rtype];
		}

		//alert("old_ioratio==>"+old_ioratio+",new_ioratio==>"+new_ioratio);
		if (""+new_ioratio=="undefined" || new_ioratio==""){
			oldObjDataFT[mod+rec][rtype]=GameData[rtype];
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

      //console.trace("change");
		if (old_ioratio!=new_ioratio && old_ioratio !="" && new_ioratio!="") {
			//console.log("new "+new_ioratio+" old "+ old_ioratio+" ,rtype=>"+rtype);
			
	    	oldObjDataFT[mod+rec][rtype]=GameData[rtype];
			//return "  style='background-color : yellow' ";
			return " class='bet_text_color' ";
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
	
	document.body.onscroll = function (){}
	setTimeout(function(){
				getback_top();
				setshowfixhead();	
			},50);
}
function showLegIcon(leg,state,gnumH,display){
	var  ary=body_browse.document.getElementsByName(leg);


	var tmp=gnumH.split(":");
	var gnumH=tmp[0];
	var isMaster=tmp[1];
	
	for (var j=0;j<ary.length;j++){
		ary[j].innerHTML="<span id='"+state+"'></span>";
	}
	//console.log("TR2_"+gnumH+"display  "+display);
	try{//聯盟前面加箭頭 william 2016-03-14
		body_browse.document.getElementById("LEG_"+gnumH).className=(display != "none")? "bet_game_league":"bet_game_league_down";
	}catch(E){}
	try{
		if(isMaster=="N" && NotMasterDarw){
			body_browse.document.getElementById("TR3_"+gnumH).style.display="";
		}else{
			body_browse.document.getElementById("TR3_"+gnumH).style.display=display;
		}
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
	try{
		body_browse.document.getElementById("BASE_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("OBT_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("GOAL_"+gnumH).style.display=display;
	}catch(E){}
	
}
//----------------------

//分頁
function show_page(){
	
	
	//alert(rtype)
	pg_str='';
	obj_pg = body_browse.document.getElementById('pg_txt');
	obj_pg.style.display="none";
	
	if(page_sw){
		obj_pg_new = body_browse.document.getElementById('show_page_txt');
		obj_pg_new.style.display="none";
	}
//	alert(t_page);
	if (t_page==0){
		t_page=1;
		//obj_pg.innerHTML = "";
		//return;
	}
	var tmp_lid="";
	if (rtype=="re"||rtype.match("^re")){
		//tmp_lid=eval("parent."+sel_gtype+"_lid_ary_RE");
		// 2017-04-06 3063.新、舊會員端-早餐、過關(包含特殊&精選)盤面-選擇聯盟改判斷為所有頁數，選擇後的頁數也會重新計算為目前所選的賽事統計頁數
		tmp_lid = top[sel_gtype+"_lid"][sel_gtype+"_"+(top.hot_game!=""?top.hot_game:"")+"lid_ary_RE"];
	}else{
		//tmp_lid=eval("parent."+sel_gtype+"_lid_ary");
		// 2017-04-06 3063.新、舊會員端-早餐、過關(包含特殊&精選)盤面-選擇聯盟改判斷為所有頁數，選擇後的頁數也會重新計算為目前所選的賽事統計頁數
		tmp_lid = top[sel_gtype+"_lid"][sel_gtype+"_"+(top.hot_game!=""?top.hot_game:"")+"lid_ary"];
	}
	
	if((tmp_lid=='ALL'&&!top.swShowLoveI&&g_date=="ALL"&&top.select_showtype!="today")||showpage_ie11||top.usepage){
			
			if(!top.usepage&& util.isIE11()){ //早餐過關  所有日期會進來
				obj_pg.style.display="none";
				if(page_sw) obj_pg_new.style.display="";
				body_browse.document.getElementById("show_pg_chk").style.display="";
				body_browse.document.getElementById("show_pg_chk_msg").style.display="";
				
			}else{
			
			obj_pg.style.display="";
			
			var page_str;
			var page_str_new;
			if(top.PAGE=="P"){
				page_str=top.PAGE+" "+(pg*1+1)+"/" +t_page;
			}else{
				page_str=(pg*1+1)+"/" +t_page+top.PAGE;
			}
			
			page_str_new=(pg*1+1)+"/" +t_page;//盤面下方 160517 joe
			
			var pghtml="<tt class='bet_normal_text'>"+page_str+"</tt>";
		 	pghtml+="	<div id='show_page' onmouseleave='hideDiv(this.id);' tabindex='100' class='bet_page_bg' style='display:none;'>"
  	  		pghtml+="<span class='bet_arrow'></span><span class='bet_arrow_text'>"+top.PAGE_NUM+"</span>";
			pghtml+="<ui>";
			for(var i=0;i<t_page;i++){
			 		pghtml+="<li id='page_"+i+"' class='bet_page_contant' style='list-style-type:none;' onclick='chg_pg("+i+");'>"+(i+1)+"</li>";
			}
			pghtml+="</ui></div>";
			obj_pg.value="1/3";
			obj_pg.innerHTML = pghtml;
			
			//	pg*1+1
			//	t_page
				var show=""
				if((pg*1+1) <= 1){
					show+="<span id='top_left'  class='bet_page_Lleft_out'></span>";
				}else{
					show+="<span id='top_left' onclick=\"clickpg('1')\" class='bet_page_Lleft'></span>";
				}	
				if((pg*1+1)>1){
					show+="<span id='pg_left' onclick=\"clickpg('del')\" class='bet_page_left'></span>";
				}else{
					show+="<span id='pg_left'  class='bet_page_left_out'></span>";
				}
				show+="<tt id='num' class='bet_page_text'>"+page_str_new+"</tt>"
				if((pg*1+1) == t_page){
					show+="<span id='pg_right'  class='bet_page_right_out'></span>";
				}else{
					show+="<span id='pg_right' onclick=\"clickpg('add')\" class='bet_page_right'></span>";
				}
				if(page_sw) 
				{
					if(util.isIE11()){
						
						
						body_browse.document.getElementById("show_pg_chk").style.display="";
						body_browse.document.getElementById("show_pg_chk_msg").style.display="";
					}
					obj_pg_new.innerHTML=show;
					obj_pg_new.style.display=""; 
				}
			
			
  	
				document.getElementById("pg_txt").onclick=function(){
				//divOnBlur(document.getElementById("show_page"),document.getElementById("pg_txt"));
				//console.log("click: "+blurHash["pg_txt"]);
				if(blurHash["pg_txt"]=="N"){
					document.getElementById("show_page").style.display='';
					document.getElementById("show_page").focus();
					set_class();
				}
			}
			initDivBlur_PFunction_new(document.getElementById("show_page"),document.getElementById("pg_txt"));
			}
	}else{
			obj_pg.style.display="none";
			if(page_sw) obj_pg_new.style.display="";
			
			if(util.isIE11()){
				body_browse.document.getElementById("show_pg_chk").style.display="";
				body_browse.document.getElementById("show_pg_chk_msg").style.display="";
			}
	}
}
//分頁 新按鈕
function clickChkbox(){
	
	var tmp = top.uid.match(/m\d*l\d*$/);
	tmp = tmp[0];
	tmp = tmp.substring(1,tmp.length).split("l")
	tmp = tmp[0];
	
	top.usepage=(document.getElementById("pg_chk").checked)?true:false;
	showpage_ie11=top.usepage;   //分頁按鈕
	pg =(top.usepage)? pg:0;		 //取消要回到第一頁

	top.pageType=(top.usepage)?"Y":"N";
	top.CM.set("pageType@"+tmp,top.pageType);
	try{
		if (rtype.indexOf("re")!=-1||!page_sw){//滾球不秀 page_sw過渡期開關
			showpage_ie11=false;
		}
	}catch(e){}
	reload_var("");
}
function clickpg(sel){
		//trace("chg_pg");
	if(sel=="1"){
		pg=0;
	}else if(sel ==="add"){
		pg++;
	}else if(sel ==="del"){
		pg--;
	}
	reload_var("");
}



function hideDiv(id_str){
		document.getElementById(id_str).style.display ="none";
}
//ie8分頁
function show_ie8(){
 util.trace("=======in showie8======");
  //window.onscroll = scroll;
}

/*function scroll()
{
		var ret = util.reachBottom(document);
		if(ret){
				trace("捲到底部了");
				//pg=1;
			//reload_var("");
		}
}*/
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

//if(top.swShowLoveI){
  //body_browse.document.getElementById("sel_league").style.display="none";
 //}else{
  body_browse.document.getElementById("sel_league").style.display="";
 //}
}
//足球 其他 棒球我的最愛盤面隱藏覽看主要盤口
function dis_Market(){
	// 2017-03-13 我的最愛盤面要加上選擇聯盟、看主盤、所有、賽局的按鈕需求(PJM-499)
	//if(top.swShowLoveI){
 		//body_browse.document.getElementById("sel_Market").style.display="none";
 	//}else{
 		body_browse.document.getElementById("sel_Market").style.display="";
	//}
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
//2017-0124-johnson-早餐足球-半場/全場,要帶出實際主客隊的隊名
function changeTitleStr2(s,at,gd){
	if (s.charAt(at)=="H"){
		return " "+gd.team_h;
	}else if(s.charAt(at)=="C"){
		return " "+gd.team_c;
	}else if(s.charAt(at)=="N"){
		return " "+top["team3"]+" ";
	}
	return "";
}


function loadingOK(){
	//alert("loadingOK")
	/*
	try{
		body_browse.document.getElementById("refresh_btn").className="refresh_btn";
	}catch(E){}
	try{
	body_browse.document.getElementById("refresh_right").className="refresh_M_btn";
	}catch(E){}
	try{
	body_browse.document.getElementById("refresh_down").className="refresh_M_btn";
	}catch(E){}
	*/
}


var gameCount="";
var recordHash=new Array();
function showHOT(countHOT){

if( (""+countHOT=="") || (""+countHOT=="undefined") ){

	 //body_browse.document.getElementById("euro_btn").style.display="none";
	 //body_browse.document.getElementById("euro_up").style.display="none";

}else{

	if(""+top.hot_game=="undefined"){
		top.hot_game="";
	}
	var gtypeHOT =new Array("FT","BK","TN","VB","BM","TT","OP");
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
		//body_browse.document.getElementById("euro_btn").style.display="none";
		//body_browse.document.getElementById("euro_up").style.display="none";
		//body_browse.document.getElementById("euro_close").style.display="";
		if(top.hot_game!=""){
			//top.hot_game="";
			//body_browse.reload_var();
		}
	}else{
		if(isHot_game){
			if(top.hot_game!=""){
				//body_browse.document.getElementById("euro_btn").style.display="none";
				//body_browse.document.getElementById("euro_up").style.display="";
			}else{
				//body_browse.document.getElementById("euro_btn").style.display="";
				//body_browse.document.getElementById("euro_up").style.display="none";
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

function showCleanData(gtype,rtype,show){
	body_browse.location.href="../showCleanData.php?uid="+uid+"&ltype="+ltype+"&gtype="+gtype+"&rtype="+rtype+"&show="+show+"&langx="+langx;
}


function TeamName(Name){
	return Name.replace(" [Mid]","").replace(" [中]","").replace("#FFFF99","").split(" - (")[0];
}
function TeamName_BS(Name){//BS OP
	return Name.replace(" [Mid]","").replace(" [中]","").replace("#FFFF99","");
}


function iornameMouseOver(idName)//滑鼠一上去就要有底色
{
	if(top.lastidName == idName)	return;//被選的不用改
	document.getElementById(idName).className = "bet_bg_color";
}

function iorMouseOver(obj){
		var org_class = util.getObjectClass(obj);
		obj.setAttribute("org" , org_class);
		util.setObjectClass(obj, "");

}

function iorMouseOut(obj){
		var org_class = obj.getAttribute("org");
		util.setObjectClass(obj, org_class);
}
function arrayMege(gm,g){
	var retary=[];
	for (var i=0;i<g.length;i++){
		var a=g[i].splice(0,1);
		tempG=[];
 		tempG=tempG.concat(a,gm[a[0]],g[i]);
 		retary.push(tempG);
	}
	return retary;
}
//after parse finish
function initfixhead(){

		try{
   			var scrollTop = document.documentElement.scrollTop || document.body.scrollTop || 0;
				var div_show = document.getElementById("showtable");
   			var tab_show = div_show.children[0];

   			tab_bak = tab_show.cloneNode(false);
   			tab_bak.setAttribute("id", "tab_bak");

				div_bak = document.createElement("div");
				with(div_bak){
		   			setAttribute("id", "div_bak");
						style["z-index"] = 1;
						//style.width = tab_bak.clientWidth+"px";
						style.height = tab_bak.clientHeight+"px";
						style.width = "100%";
						//style.height = "100%";
						style.position = "absolute";
		   			style.top = (scrollTop)+"px";
		   			style.left = "0px";
						appendChild(tab_bak);
				}
   			div_show.appendChild(div_bak);



				if(isFixed){ //2016.0216 Leslie
   					document.getElementById("fixhead_layer").style.position = "fixed";
   					//div_bak.style.position = "fixed";
   					//div_bak.style.top = "0px";
   					//div_bak.style.top = (scrollTop)+"px";
   					tab_bak.style.position = "fixed";
   			}else{
   					//div_bak.style.position = "absolute";
   					//div_bak.style.top = (scrollTop)+"px";
   					document.getElementById("fixhead_layer").style.top = scrollTop+"px";
   			}


   			var fixAry = document.getElementsByName("fixhead_copy");

				for(var i=0; i<fixAry.length; i++){

						var obj = fixAry[i];
						var org_w = obj.clientWidth;
						var org_h = obj.clientHeight;
						var _name = obj.id+"_bak";


						bak = obj.cloneNode(true);
						with(bak){
								setAttribute("id", _name);
								setAttribute("name", _name);
								style.width = org_w+"px";
								style.height = org_h+"px";
						}
						//if(isFixed) bak.style.position = "fixed"; //2016.0216 Leslie
						tab_bak.appendChild(bak);

						var last_line = false;
						for(var j=0; j<obj.children.length; j++){
								try{
										//console.info("["+_name+"]"+obj.children[j].clientWidth+","+obj.children[j].clientHeight);
										var w = obj.children[j].clientWidth;
										var h = obj.children[j].clientHeight;

										//td大小不含css,線的px不含在裡面
										if(bak.children[j].className=="bet_two_td_left"){ //線在左
												w+=1;
										}

										if(last_line){
												w+=1;
												last_line = false;
										}

										if(bak.children[j].className=="bet_title_oe"){ //線在右
												last_line = true;
										}



										bak.children[j].style.width = w+"px";
										bak.children[j].style.height = h+"px";

										//console.info(bak.children[j].getAttribute("style"));
								}catch(ee){
										systemMsg(ee.toString());
								}
						}

				}

  	}catch(e){
  			systemMsg(e.toString());
  	}


		scrollmax = getScrollMax();
}

function setshowfixhead(){

//on scroll
 document.body.onscroll = function (){
		//if(isFixed) return; //2016.0216 Leslie
	 
  	try{
   			var scrollTop = document.documentElement.scrollTop || document.body.scrollTop || 0;
   			if(!isFixed){
		   			document.getElementById("fixhead_layer").style.top= scrollTop+"px";
						document.getElementById("div_bak").style.top = (scrollTop)+"px";
				}
				//回到頂部======== joe 160122
				var bodyheight = document.documentElement.clientHeight || document.body.clientHeight ||0;
   			var tab_bak=document.getElementById("tab_bak").clientHeight;
   			var back_value="";
   			//back_value= scrollTop+bodyheight-tab_bak;
   			back_value = scrollTop+bodyheight-tab_bak+9;//多一行白色+9 160309 joe

   			if(back_value>scrollmax) back_value=scrollmax;

				if(scrollTop>0){
   				document.getElementById("backTOP").style.display="";
   				document.getElementById("backTOP").style.top= back_value+"px";
   				document.getElementById("backTOP").style["z-index"] = 1;
   				document.getElementById("show_page_txt").className="bet_page_bot_rt";
   			}else{
   				document.getElementById("backTOP").style.display="none";
   				document.getElementById("show_page_txt").className="bet_page_bot";

   			}
   			//===============
  	}catch(e){
  			systemMsg(e.toString());
  	}
}


}

function showfixhead(){

		//if(isFixed) return; //2016.0216 Leslie
	  
  	try{
   			var scrollTop = document.documentElement.scrollTop || document.body.scrollTop || 0;
   			if(!isFixed){
		   			document.getElementById("fixhead_layer").style.top= scrollTop+"px";
						document.getElementById("div_bak").style.top = (scrollTop)+"px";
				}
				//回到頂部======== joe 160122
				var bodyheight = document.documentElement.clientHeight || document.body.clientHeight ||0;
   			var tab_bak=document.getElementById("tab_bak").clientHeight;
   			var back_value="";
   			//back_value= scrollTop+bodyheight-tab_bak;
   			back_value = scrollTop+bodyheight-tab_bak+9;//多一行白色+9 160309 joe

   			if(back_value>scrollmax) back_value=scrollmax;

				if(scrollTop>0){
   				document.getElementById("backTOP").style.display="";
   				document.getElementById("backTOP").style.top= back_value+"px";
   				document.getElementById("backTOP").style["z-index"] = 1;
   				document.getElementById("show_page_txt").className="bet_page_bot_rt";
   			}else{
   				document.getElementById("backTOP").style.display="none";
   				document.getElementById("show_page_txt").className="bet_page_bot";
   			}
   			//===============
  	}catch(e){
  			systemMsg(e.toString());
  	}
}

function getback_top(){
	try{
				var scrollTop = document.documentElement.scrollTop || document.body.scrollTop || 0;
				var scrollmax=getScrollMax();
				//回到頂部======== joe 160122
				var bodyheight = document.documentElement.clientHeight || document.body.clientHeight ||0;
   			var tab_bak=document.getElementById("tab_bak").clientHeight;
   			var back_value="";
   			//back_value= scrollTop+bodyheight-tab_bak;
   			back_value = scrollTop+bodyheight-tab_bak+9;//多一行白色+9 160309 joe

				//console.log("back_value==> "+back_value+"scrollmax==> "+scrollmax );
   			if(back_value>scrollmax) back_value=scrollmax;

				if(scrollTop>0){
					 //console.log("backTOP display");
   				document.getElementById("backTOP").style.display="";
   				document.getElementById("backTOP").style.top= back_value+"px";
   				document.getElementById("backTOP").style["z-index"] = 1;
   				
   				document.getElementById("show_page_txt").className="bet_page_bot_rt";
   			}else{
   				document.getElementById("backTOP").style.display="none";
   				document.getElementById("show_page_txt").className="bet_page_bot";
   			}
   			//===============
  	}catch(e){
  			systemMsg(e.toString());
  	}
}

function getScrollMax(){
		var sh = document.getElementById("showtable").offsetHeight;
		return sh+44;
}

function backtop(){
		try{
				document.body.scrollTop="0";
				document.documentElement.scrollTop="0";
		}catch(e){}
}

function set_class(){
	var temp = odd_f_str.split(",");
	if(top.SortType=="" && top.rtype.indexOf("re")==-1)top.SortType="T";
	else if(top.SortType=="" && top.rtype.indexOf("re")!=-1) top.SortType="C";

if(top.SortType=="C"){
		document.getElementById("sort_time").className="bet_sort_time";
		document.getElementById("sort_leg").className="bet_sort_comp_choose";
	}else{
		document.getElementById("sort_time").className="bet_sort_time_choose";
		document.getElementById("sort_leg").className="bet_sort_comp";
	}
	//被選擇盤口亮色
	for(i=0;i<temp.length;i++){
		if(top.odd_f_type!=temp[i]){
			 document.getElementById("odd_"+temp[i]).className="bet_odds_contant";
		}else{
			 document.getElementById("odd_"+top.odd_f_type).className="bet_odds_contant_choose";
		}
	}
	//被選擇頁數亮色
	for(i=0;i<t_page;i++){
		if(pg!=i){
			 document.getElementById("page_"+i).className="bet_page_contant";
		}else{
			 document.getElementById("page_"+pg).className="bet_page_contant_choose";
		}
	}
}



function initDivBlur_PFunction_new(showdiv,selid){
	showdiv.tabIndex=100;
	showdiv.onblur=function(){
		blurHash[selid.id] = "Y";
		showdiv.style.display='none';
		setTimeout(function(){
				blurHash[selid.id] = "N";
		},300);
	};

}

function initDivBlur_PFunction(showdiv,selid){
	showdiv.tabIndex=100;
	showdiv.onblur=function(){
		showdiv.style.display='none';
		setTimeout(function(){
			selid.onclick=function(){
				//alert("onblur");
				divOnBlur(showdiv,selid);
				set_class();
				}
		},300);

	};

}
var selShowDivStatus = false;

function chgSelShowDivStatus(){
	selShowDivStatus = !selShowDivStatus; 	
	//console.log("selShowDivStatus ==>"+selShowDivStatus);
}

function initDivBlur_filter(showdiv,selid){
	showdiv.tabIndex=100;
	
	selid.onmousedown=function(){

	//	console.log("onmousedown==> "+selShowDivStatus);
		if(!selShowDivStatus && showdiv.style.display == "none"){
			
			init_mtype();
			showdiv.style.display='';
			chgSelShowDivStatus();
		}
	//set_class();
	}
	
	selid.onclick = function(){
		if(showdiv.style.display == ""){
			//console.log("aaaa1");
			showdiv.focus();
			//console.log("aaaa2");
			showdiv.onblur=function(){
			//setTimeout(function(){
				DivBlur_filter(showdiv,selid);
			//},100);
			}
			
			//console.log("aaaa3");
		}
	}
	
	showdiv.onmouseover = function(){
		
		//showdiv.onblur= null;
		showdiv.onblur = function(){
		//	console.log("onblur nul==>"+selset_filters);
		}
		showdiv.focus();
		//divOnBlur(showdiv,selid);
	}
	
	showdiv.onmouseout = function(){	
		
		showdiv.onblur=function(){
		//	console.log("selset_filters==>"+selset_filters);
			if(!selset_filters||selShowDivStatus){
			//setTimeout(function(){
				
				DivBlur_filter(showdiv,selid);
			}
			selset_filters=false;
			//},100);
		}
	
	}
	

}



function DivBlur_filter(showdiv,selid){
		//console.log("div onblur");
		showdiv.style.display='none';
		chgSelShowDivStatus();

}
function getKeepScroll(_top, keepscroll){
	var ret = 0;

	if(_top.select_gtype==_top.keep_gtype&&_top.sel_gd==_top.keep_gd){
			ret = keepscroll;
	}else{
			ret = 0;
			top.keep_gtype = top.select_gtype;
			top.keep_gd = top.sel_gd;
	}
	return ret;
}

//點了要有底色再點一次要取消注單 William 2016-03-15
function Bright(idName){
	top.lastidName = idName;
	document.getElementById(idName).className = "bet_bg_color_bet";

	try{
		showdata.document.getElementById(idName).className = "bet_bg_color_bet";
	}catch(e){}
	try{
		parent.show_tv.Live_mem.document.getElementById(idName).className = "bet_bg_color_bet";
	}catch(E){}
}

//ie11 edge 不允許重複id
function id_rename(chg_id,re_type){
	if(re_type=="bak"){
		try{
			chg_id.setAttribute("id",chg_id.id.split("_bak")[0]+"_bak");
		}catch(e){}
		//console.log(chg_id+" , "+chg_id.id);
	}else{
		try{
			chg_id.setAttribute("id",chg_id.id.split("_bak")[0]);
		}catch(e){}
	}
}
//多類別去掉 -
function replacePtype(ptype){
		var tmp_ptype = ptype;
		var base_ary = Array(" - "," -"," -","-");
		for(var i=0; i<base_ary.length; i++){
				var base = base_ary[i]
				var pos = tmp_ptype.indexOf(base);
				if(pos==0){
	    			        tmp_ptype = tmp_ptype.replace(base, "");
	    			        break;
	    	}
		}
		return tmp_ptype;
}


function init_page(){
	
	if(util.isIE11()){
		if(top.pageType!="def"){
			document.getElementById("pg_chk").checked=(top.pageType=="Y")?true:false;
			top.usepage=(top.pageType=="Y")?true:false;
		}else{
			document.getElementById("pg_chk").checked=true;
			top.usepage=true;
		}	
	}
	
	
	if(top.usepage==null){//init

	if(util.isIE11())	{
		document.getElementById("pg_chk").checked=true;
		top.usepage=true;
		top.pageType="Y";
		
	}else{
		top.usepage=false;
		top.pageType="N";
	}
	
	showpage_ie11=util.isIE11();   //分頁按鈕
	try{
		if (rtype.indexOf("re")!=-1){//滾球不秀

			showpage_ie11=false;
		}
	}catch(e){}
}	
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8 "><script>
var isHot_game = true;//是否為世足賽
top.select_showtype = "today";
top.select_gtype = "FT";
top.tv_allbet = false;
var gameData;
var showtypeAry = new Array("today","early","parlay");

var gtypeAry = gtypeAry || new Array("FT","BK","TN","VB","BM","TT","BS","OP","SK");
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
	if(menuType!="mybets"){
		loadData();
	}else{
		try{
			document.getElementById("rec_frame").contentWindow.loadData();
		}catch(e){}
	}
}

function loadData(){	
	trace("loadData");
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
	//bet_order_frame.location.replace(url);


	clearBetFrame();


	bet_src(url);

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
		"RWM","RDC","RWE","RWB","ARG","BRG","CRG","DRG","ERG","FRG","GRG","HRG","IRG","JRG","RCS","RWN","RHG","RMG","RSB","RT3G","RT1G"
		,"WM","HWM","HRWM","DC","BH","WE","WB","PG","CS","WN","F2G","F3G","HG","MG","SB","FG","T3G","T1G","TK","PA","RCD","ST","OS"
	);
	var doubleGame = new Array(
		"RTS","RTS2","TS","HTS","OG","OT","ROT","EOH","EOC","HEOH","HEOC"
	);

	var rouhc = new Array("ROUH","ROUC","HRUH","HRUC");
	var ouhc = new Array("OUH","OUC","HOUH","HOUC");
	var urlArray=new Array();
	var base_url = util.getNowDomain()+"/app/member/";
	if(gtype=="FT")
	{
		urlArray['R']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['HR']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['OU']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['HOU']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['M']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['HM']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['EO']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['REO']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['HEO']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['HREO']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['PD']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['RPD']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['HPD']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['HRPD']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['F']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['RF']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['T']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['PGF']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['HT']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['RT']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['HRT']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['SP']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['P']=new Array(base_url+gtype+"_order/"+gtype+"_order_p.php");
		urlArray['P3']=new Array(base_url+gtype+"_order/"+gtype+"_order_p3.php");
		urlArray['PR']=new Array(base_url+gtype+"_order/"+gtype+"_order_pr.php");
		urlArray['RE']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['HRE']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['ROU']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['HROU']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['RM']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['HRM']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['NFS']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");


		urlArray['RE15']=new Array(base_url+gtype+"_order/"+gtype+"_order_re15.php");
		urlArray['ROU15']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['RM15']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");

		urlArray['R15']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['OU15']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['M15']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");

		urlArray['SINGLE']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['DOUBLE']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['ROUHC']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['OUHC']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['W3']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");


		//網球新遊戲
		urlArray['PD3']=new Array(base_url+gtype+"_order/"+gtype+"_order_pd3.php");
		urlArray['PD5']=new Array(base_url+gtype+"_order/"+gtype+"_order_pd5.php");
		urlArray['RPD3']=new Array(base_url+gtype+"_order/"+gtype+"_order_rpd3.php");
		urlArray['RPD5']=new Array(base_url+gtype+"_order/"+gtype+"_order_rpd5.php");

		urlArray['PD7']=new Array(base_url+gtype+"_order/"+gtype+"_order_pd7.php");
		urlArray['RPD7']=new Array(base_url+gtype+"_order/"+gtype+"_order_rpd7.php");

		//足球新玩法
		//Next 只有下個角球有30個，其餘兩個只有15個(A~O)
		var wtypeAndOU = new Array("A","B","C","D");
		var wtypeNext = new Array("1","2","3","4","5","6","7","8","9","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U");
		urlArray['MQ']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['MW']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");

		for(var i = 0;i < wtypeAndOU.length;i++){
			urlArray['MOU'+wtypeAndOU[i]]=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
			urlArray['DU'+wtypeAndOU[i]]=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
			urlArray['OUT'+wtypeAndOU[i]]=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
			urlArray['OUE'+wtypeAndOU[i]]=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
			urlArray['OUP'+wtypeAndOU[i]]=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
			urlArray['RMU'+wtypeAndOU[i]]=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
			urlArray['RDU'+wtypeAndOU[i]]=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
			urlArray['RUT'+wtypeAndOU[i]]=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
			urlArray['RUE'+wtypeAndOU[i]]=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
			urlArray['RUP'+wtypeAndOU[i]]=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		}

		urlArray['MPG']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['MTS']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['DG']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['DS']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['RMPG']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['RMTS']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['RDG']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		urlArray['RDS']=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");

		for(var i = 0;i < wtypeNext.length;i++){
			urlArray['RSH'+wtypeNext[i]]=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
			urlArray['RSC'+wtypeNext[i]]=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
			urlArray['RNB'+wtypeNext[i]]=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
			urlArray['RNC'+wtypeNext[i]]=new Array(base_url+gtype+"_order/"+gtype+"_order_all.php");
		}
	}
	else
	{
		urlArray['R']=new Array(base_url+gtype+"_order/"+gtype+"_order_r.php");
		urlArray['HR']=new Array(base_url+gtype+"_order/"+gtype+"_order_hr.php");
		urlArray['OU']=new Array(base_url+gtype+"_order/"+gtype+"_order_ou.php");
		urlArray['HOU']=new Array(base_url+gtype+"_order/"+gtype+"_order_hou.php");
		urlArray['M']=new Array(base_url+gtype+"_order/"+gtype+"_order_m.php");
		urlArray['HM']=new Array(base_url+gtype+"_order/"+gtype+"_order_hm.php");
		urlArray['EO']=new Array(base_url+gtype+"_order/"+gtype+"_order_t.php");
		urlArray['REO']=new Array(base_url+gtype+"_order/"+gtype+"_order_rt.php");
		urlArray['HEO']=new Array(base_url+gtype+"_order/"+gtype+"_order_t.php");
		urlArray['HREO']=new Array(base_url+gtype+"_order/"+gtype+"_order_rt.php");
		urlArray['PD']=new Array(base_url+gtype+"_order/"+gtype+"_order_pd.php");
		urlArray['RPD']=new Array(base_url+gtype+"_order/"+gtype+"_order_rpd.php");
		urlArray['HPD']=new Array(base_url+gtype+"_order/"+gtype+"_order_hpd.php");
		urlArray['HRPD']=new Array(base_url+gtype+"_order/"+gtype+"_order_hrpd.php");
		urlArray['F']=new Array(base_url+gtype+"_order/"+gtype+"_order_f.php");
		urlArray['RF']=new Array(base_url+gtype+"_order/"+gtype+"_order_rf.php");
		urlArray['T']=new Array(base_url+gtype+"_order/"+gtype+"_order_t.php");
		urlArray['PGF']=new Array(base_url+gtype+"_order/"+gtype+"_order_sp.php");
		urlArray['HT']=new Array(base_url+gtype+"_order/"+gtype+"_order_t.php");
		urlArray['RT']=new Array(base_url+gtype+"_order/"+gtype+"_order_rt.php");
		urlArray['HRT']=new Array(base_url+gtype+"_order/"+gtype+"_order_rt.php");
		urlArray['SP']=new Array(base_url+gtype+"_order/"+gtype+"_order_sp.php");
		urlArray['P']=new Array(base_url+gtype+"_order/"+gtype+"_order_p.php");
		urlArray['P3']=new Array(base_url+gtype+"_order/"+gtype+"_order_p3.php");
		urlArray['PR']=new Array(base_url+gtype+"_order/"+gtype+"_order_pr.php");
		urlArray['RE']=new Array(base_url+gtype+"_order/"+gtype+"_order_re.php");
		urlArray['HRE']=new Array(base_url+gtype+"_order/"+gtype+"_order_hre.php");
		urlArray['ROU']=new Array(base_url+gtype+"_order/"+gtype+"_order_rou.php");
		urlArray['HROU']=new Array(base_url+gtype+"_order/"+gtype+"_order_hrou.php");
		urlArray['RM']=new Array(base_url+gtype+"_order/"+gtype+"_order_rm.php");
		urlArray['HRM']=new Array(base_url+gtype+"_order/"+gtype+"_order_hrm.php");
		urlArray['NFS']=new Array(base_url+gtype+"_order/"+gtype+"_order_nfs.php");


		urlArray['RE15']=new Array(base_url+gtype+"_order/"+gtype+"_order_re15.php");
		urlArray['ROU15']=new Array(base_url+gtype+"_order/"+gtype+"_order_rou15.php");
		urlArray['RM15']=new Array(base_url+gtype+"_order/"+gtype+"_order_rm15.php");

		urlArray['R15']=new Array(base_url+gtype+"_order/"+gtype+"_order_r15.php");
		urlArray['OU15']=new Array(base_url+gtype+"_order/"+gtype+"_order_ou15.php");
		urlArray['M15']=new Array(base_url+gtype+"_order/"+gtype+"_order_m15.php");

		urlArray['SINGLE']=new Array(base_url+gtype+"_order/"+gtype+"_order_single.php");
		urlArray['DOUBLE']=new Array(base_url+gtype+"_order/"+gtype+"_order_double.php");
		urlArray['ROUHC']=new Array(base_url+gtype+"_order/"+gtype+"_order_rouhc.php");
		urlArray['OUHC']=new Array(base_url+gtype+"_order/"+gtype+"_order_ouhc.php");
		urlArray['W3']=new Array(base_url+gtype+"_order/"+gtype+"_order_w3.php");


		//網球新遊戲
		urlArray['PD3']=new Array(base_url+gtype+"_order/"+gtype+"_order_pd3.php");
		urlArray['PD5']=new Array(base_url+gtype+"_order/"+gtype+"_order_pd5.php");
		urlArray['RPD3']=new Array(base_url+gtype+"_order/"+gtype+"_order_rpd3.php");
		urlArray['RPD5']=new Array(base_url+gtype+"_order/"+gtype+"_order_rpd5.php");

		urlArray['PD7']=new Array(base_url+gtype+"_order/"+gtype+"_order_pd7.php");
		urlArray['RPD7']=new Array(base_url+gtype+"_order/"+gtype+"_order_rpd7.php");

		//足球新玩法
		//Next 只有下個角球有30個，其餘兩個只有15個(A~O)
		var wtypeAndOU = new Array("A","B","C","D");
		var wtypeNext = new Array("1","2","3","4","5","6","7","8","9","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U");
		urlArray['MQ']=new Array(base_url+gtype+"_order/"+gtype+"_order_single.php");
		urlArray['MW']=new Array(base_url+gtype+"_order/"+gtype+"_order_single.php");

		for(var i = 0;i < wtypeAndOU.length;i++){
			urlArray['MOU'+wtypeAndOU[i]]=new Array(base_url+gtype+"_order/"+gtype+"_order_single.php");
			urlArray['DU'+wtypeAndOU[i]]=new Array(base_url+gtype+"_order/"+gtype+"_order_single.php");
			urlArray['OUT'+wtypeAndOU[i]]=new Array(base_url+gtype+"_order/"+gtype+"_order_single.php");
			urlArray['OUE'+wtypeAndOU[i]]=new Array(base_url+gtype+"_order/"+gtype+"_order_single.php");
			urlArray['OUP'+wtypeAndOU[i]]=new Array(base_url+gtype+"_order/"+gtype+"_order_single.php");
			urlArray['RMU'+wtypeAndOU[i]]=new Array(base_url+gtype+"_order/"+gtype+"_order_single.php");
			urlArray['RDU'+wtypeAndOU[i]]=new Array(base_url+gtype+"_order/"+gtype+"_order_single.php");
			urlArray['RUT'+wtypeAndOU[i]]=new Array(base_url+gtype+"_order/"+gtype+"_order_single.php");
			urlArray['RUE'+wtypeAndOU[i]]=new Array(base_url+gtype+"_order/"+gtype+"_order_single.php");
			urlArray['RUP'+wtypeAndOU[i]]=new Array(base_url+gtype+"_order/"+gtype+"_order_single.php");
		}

		urlArray['MPG']=new Array(base_url+gtype+"_order/"+gtype+"_order_single.php");
		urlArray['MTS']=new Array(base_url+gtype+"_order/"+gtype+"_order_single.php");
		urlArray['DG']=new Array(base_url+gtype+"_order/"+gtype+"_order_single.php");
		urlArray['DS']=new Array(base_url+gtype+"_order/"+gtype+"_order_single.php");
		urlArray['RMPG']=new Array(base_url+gtype+"_order/"+gtype+"_order_single.php");
		urlArray['RMTS']=new Array(base_url+gtype+"_order/"+gtype+"_order_single.php");
		urlArray['RDG']=new Array(base_url+gtype+"_order/"+gtype+"_order_single.php");
		urlArray['RDS']=new Array(base_url+gtype+"_order/"+gtype+"_order_single.php");

		for(var i = 0;i < wtypeNext.length;i++){
			urlArray['RSH'+wtypeNext[i]]=new Array(base_url+gtype+"_order/"+gtype+"_order_double.php");
			urlArray['RSC'+wtypeNext[i]]=new Array(base_url+gtype+"_order/"+gtype+"_order_double.php");
			urlArray['RNB'+wtypeNext[i]]=new Array(base_url+gtype+"_order/"+gtype+"_order_double.php");
			urlArray['RNC'+wtypeNext[i]]=new Array(base_url+gtype+"_order/"+gtype+"_order_double.php");
		}		
	}

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
	//TEST SK
	urlArray['SK_ALL']=new Array(base_url+"SK_order/SK_order_all.php");
	if(gtype=="SK"&&wtype!="P3"){
		//console.log("param====> "+param);
		wtype = "SK_ALL";
	}
	//TEST SK
	if(gtype=="BS"&& (wtype=="OT"||wtype=="ROT")){
		wtype = "SINGLE";
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
	if(doubleGame.indexOf(wtype) != -1){
		wtype = "DOUBLE";
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
function OpenLive(){
	trace("OpenLive");
	trace("top.liveid"+top.liveid);

	if (top.liveid == undefined) {
		parent.self.location = "";
		return;
	}
	top.select_type="betlist";
	//console.log("top.select_type"+top.select_type);
	var getLiveObj = window.open("./live/live.php?langx="+top.langx+"&uid="+top.uid+"&liveid="+top.liveid+"&autoOddCheck="+top.autoOddCheck,"Live","width=780,height=580,top=0,left=0,status=no,toolbar=no,scrollbars=yes,resizable=no,personalbar=no");
	getLiveObj.focus();
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
	parent.display_loading(true);
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
							document.getElementById(RB_countstr).innerHTML = g_count;
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

function Go_RB_page(RBgtype, loadFun){
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
		parent.display_loading(true);
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

		//parent.header.location.href=protocol+"//"+document.domain+"/app/member/"+RBgtype+"_header.php?uid="+top.uid+"&showtype=&langx="+top.langx+"&mtype="+top.mtype;
		var filename = protocol+"//"+document.domain+"/app/member/"+RBgtype+"_header.php";
		var param = "uid="+top.uid+"&showtype=&langx="+top.langx+"&mtype="+top.mtype;
		//parent.loadHead(filename, param);


		var bodyObj = parent.document.getElementById("body");
		//parent.document.getElementById("body").contentWindow.document.body.onload=function(){
		//bodyObj.location.href=util.getNowDomain()+"/app/member/"+RBgtype+"_browse/index.php?rtype=re&uid="+top.uid+"&langx="+top.langx+"&mtype="+top.mtype+"&showtype="+top.showtype+"&hot_game="+top.hot_game;
		if(loadFun){
				iframe_onload(bodyObj, loadFun);
				top.tv_allbet = true;
		}else{
				top.tv_allbet = false;
		}

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
		if(gtype=="BK"&&rtype=="r") rtype="r_main";
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
		{
			top.head_FU = "FU";
		}
		else
		{
			top.head_FU = "FT";
		}
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
			setMyBetCount(0);
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
		}
		else if(type == "menu"){
			if(document.all)	document.getElementById("count_parlay").innerText = top.count_parlay;
			else							document.getElementById("count_parlay").textContent = top.count_parlay;
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8 "><script>
top.isTestSite = false;
var gtypeAry = new Array("FT","BK","TN","VB","BS","OP","TT","BM","SK");
var notfind = new Object();
var JQ;
var load_jq_complet = false;
var fade_out_sec = 5000;  //賠率變色畫動秒數
var slide_sec = 100; //slide動畫秒數

try{
		if(console){
				//if(!top.isTestSite) setEmpty(console);
				/*
				console.log = emptyFun;
				console.trace = emptyFun;
				console.error = emptyFun;
				console.info = emptyFun;
				console.warn = emptyFun;
				console.table = emptyFun;*/
				//
		}


}catch(e){
		console = new Object();
		//setEmpty(console);

		console.log = emptyFun;
		console.trace = emptyFun;
		console.error = emptyFun;
		console.info = emptyFun;
		console.warn = emptyFun;
		console.table = emptyFun;
}

function emptyFun(){

}

function setEmpty(console){
		console.log = emptyFun;
		console.trace = emptyFun;
		console.error = emptyFun;
		console.info = emptyFun;
		console.warn = emptyFun;
		console.table = emptyFun;
}



var util = new Object();
util.classname = "[util.js]";
try{ util.HttpRequest = HttpRequest; }catch(e){}
try{ util.ParseHTML = ParseHTML; }catch(e){}
util.fail_count = new Object();
util.fail_limit = 10;
util.timeout_sec = 3000;
util.reload_sw = true;
var load_css = false;
var load_js = false;


//go to page
util.goToPage=function(filename, paramObj){
		util.trace(util.classname+"goToPage: "+filename);
		//if(!util.HttpRequest) util.systemMsg("HttpRequest does not load.");

		util.fail_count[filename] = 0;

		paramObj.targetWindow = paramObj.targetWindow || document.getElementsByTagName("body")[0];
		paramObj.targetHead = paramObj.targetHead || document.getElementsByTagName("head")[0];
		paramObj.loadComplete = paramObj.loadComplete || function(){};
		paramObj.param = paramObj.param||"";

		if(paramObj.filename.indexOf(".php")!=-1){
				paramObj.filepath = filename;
				paramObj.method = "POST";
		}else if(paramObj.filename.indexOf(".html")!=-1){
				paramObj.filepath = "/tpl/member/"+top.langx+"/"+filename+".html";
				paramObj.method = "GET";
		}else{
					util.systemMsg("[type error] "+filename);
		}

		var getHttp = new util.HttpRequest();
		getHttp.addEventListener("LoadComplete", function(html){
				util.loadHtmlFinish(html, paramObj);
		});

		getHttp.addEventListener("onError", function(html){
				if(util.reload_sw){
						util.fail_count[filename]++;

						if(util.fail_count[filename]<util.fail_limit){
								window.setTimeout(function(){
										getHttp.loadURL(paramObj.filepath, paramObj.method, paramObj.param);
								}, util.timeout_sec);
						}else{
								util.systemMsg("[load html fail] "+filename+".html");
						}
				}
		});

		getHttp.loadURL(paramObj.filepath, paramObj.method, paramObj.param);

}


//load html finish
util.loadHtmlFinish=function(html, paramObj){
		//util.trace(util.classname+"loadHtmlFinish");
		//if(!util.ParseHTML) util.systemMsg("ParseHTML does not load.");

		var tempHtml = new util.ParseHTML(html);

		//HTML
		dbody = tempHtml.getTag("div")[0];
		paramObj.targetWindow.innerHTML = "";
		if(dbody)paramObj.targetWindow.appendChild(dbody);




		//===== load JS =====
		var js_count = 0;
		jsAry = tempHtml.getTag("script");
		if(jsAry==0){
			
				//paramObj.loadComplete();
				
				
				//===== load CSS =====
				var css_count = 0;
				cssAry = tempHtml.getTag("link");
				if(cssAry.length==0){
					
						paramObj.loadComplete();
						
				}else{
						for(i=0;i<cssAry.length;i++) {
								var cssObj = cssAry[i];
								var _src = cssObj.href;
				
								//util.trace(_src);
				
								util.fail_count[_src] = 0;
				
				
								util.loadCSS(_src, paramObj, function(){
										css_count++;
				
										if(css_count>=cssAry.length){
												//util.trace("[load css finish]");
												//console.log("[load css finish]");
												paramObj.loadComplete();
		
										}
				
								});
				
						}
				}
				//===== load CSS =====
										
		}else{
				for(i=0;i<jsAry.length;i++) {
						var jsObj = jsAry[i];
						var _src = jsObj.src;

						util.fail_count[_src] = 0;
						//util.trace(_src);

						util.loadScript(_src, paramObj, function(){


								js_count++;
								//util.trace("load js: "+js_count);

								if(js_count>=jsAry.length){
										//console.log("[load js finish]");
										//paramObj.loadComplete();
										
										
										
										//===== load CSS =====
										var css_count = 0;
										cssAry = tempHtml.getTag("link");
										if(cssAry.length==0){
											
												paramObj.loadComplete();
												
										}else{
												for(i=0;i<cssAry.length;i++) {
														var cssObj = cssAry[i];
														var _src = cssObj.href;
										
														//util.trace(_src);
										
														util.fail_count[_src] = 0;
										
										
														util.loadCSS(_src, paramObj, function(){
																css_count++;
										
																if(css_count>=cssAry.length){
																		//util.trace("[load css finish]");
																		//console.log("[load css finish]");
																		paramObj.loadComplete();
								
																}
										
														});
										
												}
										}
										//===== load CSS =====
										
								}

						});
				}
		}
		//===== load JS =====



		

		
		

}

/*
function load_complete(_type, loadFun){
	
		//load_count++;
		
		switch(_type){
			case "css":
				load_css = true;
				break;
			case "js":
				load_js = true;
				break;
			default:
				break;
		}
		
		console.log("[load_complete]"+_type+",css="+load_css+",js="+load_js);
		
		if(load_css && load_js){
		//if(load_count>=2){
				console.log("[load_complete]");
				loadFun();
				load_css = false;
				load_js = false;
				//load_count = 0;
		}
}
*/

//load css
util.loadCSS=function(_src, paramObj, loadFun){
		//util.trace(util.classname+"loadCSS: "+_src);
		var css = document.createElement("link");
		css.setAttribute("rel", "stylesheet");
		css.setAttribute("type", "text/css");
		css.setAttribute("href", _src);

		css.onload=function(){
				//util.trace("load css finish: "+_src);
				//console.log("load css finish: "+_src);
				if(loadFun) loadFun();
		};

		//IE is not working
		css.onerror=function(){
				//util.trace("load css fail: "+_src);

				if(util.reload_sw){
						util.fail_count[_src]++;

						if(util.fail_count[_src]<util.fail_limit){

							window.setTimeout(function(){
									paramObj.targetHead.removeChild(css);
									util.loadCSS(_src, paramObj, loadFun);
							},util.timeout_sec);

						}else{
								var tmp_src = _src.split("/");
								util.systemMsg("[load css fail] "+tmp_src[tmp_src.length-1]);
						}
				}
		};

		paramObj.targetHead.appendChild(css);


}

//load script
util.loadScript=function(_src, paramObj, loadFun){
		//util.trace(util.classname+"loadScript: "+_src);
		//if(!util.HttpRequest) util.systemMsg("HttpRequest does not load.");

		var getHttp = new util.HttpRequest();
		getHttp.addEventListener("LoadComplete",function(html){

				var script = document.createElement("script");
				script.setAttribute("type","text/javascript");
				script.text = html;
				paramObj.targetHead.appendChild(script);

				if(loadFun) loadFun();

		});

		getHttp.addEventListener("onError", function(html){

				if(util.reload_sw){
						util.fail_count[_src]++;

						if(util.fail_count[_src]<util.fail_limit){
								window.setTimeout(function(){getHttp.loadURL(_src,"GET","");}, util.timeout_sec);
						}else{
								var tmp_src = _src.split("/");
								util.systemMsg("[load script fail] "+tmp_src[tmp_src.length-1]);
						}
				}
		});

		getHttp.loadURL(_src,"GET","");

}


//print stack trace
util.printStackTrace=function(code){
	/*
		var _this = arguments.callee.caller;
		var msg = "Stack trace:";
		var base = "\n";
		if(code) msg=code+base+msg;
		while(_this.caller){
				var param = util.getArguments(_this.caller.arguments);
				msg+=base+"function "+_this.caller.name+"("+param+")";
				//msg+=base+"function "+_this.caller.name;
				//msg+=base+"function "+_this.caller;
				_this = _this.caller;
		}

		console.log(msg);
	*/
	console.trace();
}

//get arguments
util.getArguments=function(obj){
		var ret = new Array();
		for(var _key in obj){
				var content = obj[_key];
				if(content!=null){
						if(content.length > 10) content=content.substr(0,10)+"...";
				}
				ret.push(typeof(obj[_key])+" ["+content+"]");


				//ret.push(typeof(obj[_key]));
		}
		return ret.join(",");
}

//print Hash
util.printHash=function(obj, _title){

		var count = 0;
		var str = "";

		if(_title!=null) str+="["+_title+"]\n";

		for(key in obj){
				str+=key+"======>"+obj[key]+"\n";
				count++;
		}
		str+="length======>"+count+"\n";
		util.trace(util.classname+str);
}


//http or https
util.getProtocal=function(){
		return document.location.protocol;
}


util.getWebDomain=function(){
		return document.domain;
}


util.getNowDomain=function(){
		return util.getProtocal()+"//"+util.getWebDomain();
}


//system msg
util.systemMsg=function(msg, isStack){
		console.warn(msg);
		if(isStack!=false) util.printStackTrace();
}

//trace
util.trace=function(msg, isStack){
		if(top.isTestSite){
				console.log(msg);
				//isStack = true;
				if(isStack) util.printStackTrace();
		}
}

util.showTxt=function(txt){
		if(txt+""=="undefined"||txt+""=="null"||txt+""=="NaN")  return "";
		return txt;
}

util.isIPad=function(){
		var agent = navigator.userAgent;
		if(agent.indexOf("iPad")!=-1){
				return true;
		}		
		return false;		
}

//含IE8以下
util.isIE8=function(){
		var ret = false;
		var agent = navigator.userAgent;
		var ie = "MSIE";
		var pos = agent.indexOf(ie);
		//Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET4.0C)

		if(pos!=-1){
				var tmp_agent = agent.substring(pos+ie.length,agent.length);
				var str = tmp_agent.indexOf(".");
				var version = tmp_agent.substring(0, str);
				if(version*1<=8) ret = true;
		}
		return ret;
}
util.checkBrowser=function (){
	var ret = false;
	var agent = navigator.userAgent;

	if(agent.indexOf("rv:11")!=-1||agent.indexOf("Firefox")!=-1||agent.indexOf("Edge")!=-1){
		//if(agent.indexOf("Firefox")!=-1){
		ret=true;
	}
	return ret;
}
util.isIE11=function(){//ie11 edge
var ret = true;
var agent = navigator.userAgent;
var ie = "MSIE";
var pos = agent.indexOf(ie);
var brows = new Array("Chrome","Safari","Firefox");
	if(agent.indexOf("Edge")== -1){
		for(var i=0;i<brows.length;i++){
				if(agent.indexOf(brows[i]) != -1){
					ret = false;
					break;
				}
		}
	}
	return ret;
}

//set obj class
util.setObjectClass=function(targetObj,classStr){
		if(targetObj.className!=undefined){
				targetObj.className = classStr;
		}else{
			try{
				targetObj.setAttribute("class", classStr);
			}catch(e){}
		}
}


//get obj class
util.getObjectClass=function(targetObj){
		if(targetObj.className!=undefined){
				return targetObj.className;
		}else{
				return targetObj.getAttribute("class");
		}
}

util.reachBottom=function(DOC){
    var scrollTop = 0;
    var clientHeight = 0;
    var scrollHeight = 0;
    if (DOC.documentElement && DOC.documentElement.scrollTop) {
        scrollTop = DOC.documentElement.scrollTop;
    } else if (DOC.body) {
        scrollTop = DOC.body.scrollTop;
    }
    if (DOC.body.clientHeight && DOC.documentElement.clientHeight) {
        clientHeight = (DOC.body.clientHeight < DOC.documentElement.clientHeight) ? DOC.body.clientHeight: DOC.documentElement.clientHeight;
    } else {
        clientHeight = (DOC.body.clientHeight > DOC.documentElement.clientHeight) ? DOC.body.clientHeight: DOC.documentElement.clientHeight;
    }
    scrollHeight = Math.max(DOC.body.scrollHeight, DOC.documentElement.scrollHeight);
    if (scrollTop + clientHeight == scrollHeight) {
        return true;
    } else {
        return false;
    }
}

util.getObjAbsolute_new=function(obj,stop_name){
		var abs = new Object();

		abs["left"] = obj.offsetLeft;
		abs["top"] = obj.offsetTop;

		while(obj = obj.offsetParent){
			////console.log(obj);
			////console.log(obj.offsetLeft+" >> "+obj.offsetTop);
				if(util.getStyle(obj,"position") == "relative"){
						////console.log(obj.id+"|"+obj.offsetParent.id+"|"+_self.getStyle(obj,"top")+"|"+_self.getStyle(obj,"margin-top")+"|"+obj.offsetTop);
						if((obj.id!="" && obj.offsetParent.id!="") && util.getStyle(obj,"top")!="auto" && util.getStyle(obj,"margin-top")!="auto" && util.getStyle(obj,"margin-top")!="0px"){
								abs["top"] += -obj.offsetTop;
								continue;
						}
				}

				if(stop_name!=undefined && obj.id==stop_name){
						break;
				}else if(util.getStyle(obj,"position") == "absolute"){
						break;
				}

				abs["left"] += obj.offsetLeft;
				abs["top"] += obj.offsetTop;
		}

	return abs;
}


util.getObjAbsolute=function(obj){
		var _abs = new Object();

		_abs["left"] = obj.offsetLeft;
		_abs["top"] = obj.offsetTop;

		while (obj = obj.offsetParent) {
			_abs["left"] += obj.offsetLeft;
			_abs["top"] += obj.offsetTop;
		}

		return _abs;
}


util.getStyle=function(oElm,strCssRule){
		var strValue = "";
		if(document.defaultView && document.defaultView.getComputedStyle){
				strValue = document.defaultView.getComputedStyle(oElm,"").getPropertyValue(strCssRule);
		}else if(oElm.currentStyle){
				strCssRule = strCssRule.replace(/\-(\w)/g, function (strMatch, p1){
						return p1.toUpperCase();
				});
				strValue = oElm.currentStyle[strCssRule];
		}else{
				return "error";
		}
		return strValue;
}


util.clearObject=function(obj){
		for(var key in obj){
				delete obj[key];
		}
		return obj;
}

util.clearArray=function(ary){
		ary.length = 0;
		return ary;
}


function getChildAry(objAry, _id, newAry){

		for(var i=0; i<objAry.length; i++){
				var obj = objAry[i];

				if(obj.getAttribute("id")==_id){
						newAry.push(obj);
				}

				if(obj.children.length > 0){
						getChildAry(obj.children, _id, newAry);
				}

		}
		return newAry;
}

function iframe_onError(iframe,errorfunc){
	try{
		check = iframe.contentWindow.document.body.onload;
	}catch(e){
		check = null;
	}
	if(check == null && iframe.loadsrc != undefined ){
		iframe.times = iframe.times || 0;
		errorfunc(iframe);
	}else{
		iframe.times = 0;
		try{
			iframe.loadsrc = ""+iframe.contentWindow.location;
		}catch(e){}
	}
}

function showerror(e){
	e.times+=1;
  if(e.times > 10)	return;
	setTimeout(function(){e.contentWindow.location=e.loadsrc;},5000);
}


function iframe_src(obj, url){

		if(obj!=null&&obj.tagName!=null&&url!=null){
     //2017.0112 johnson 斷線時記錄url
        obj.loadsrc = url;
        
				obj.contentWindow.location = url;
		}
}
function divOnBlur(showdiv,selid){
	//console.log("divOnBlur======>"+showdiv.id);
	selid.onclick=null;
	showdiv.style.display='';
	showdiv.focus();

}

function initDivBlur(showdiv,selid){
	showdiv.tabIndex=100;
	showdiv.onblur=function(){
		showdiv.style.display='none';
		setTimeout(function(){
			selid.onclick=function(){
				//alert("onblur");
				divOnBlur(showdiv,selid);
				document.body.scrollTop = "0";
				}
		},300);
	};

}

function iframe_src_new(obj, url){
	//console.log("util iframe_src_new"+obj+","+obj.tagName+","+url);
		if(obj!=null&&obj.tagName!=null&&url!=null){
				
				//console.log("util.checkBrowser()"+util.checkBrowser());
				if(util.checkBrowser()){
					iframe_src(obj, url);
				return;
				}

				var _id = obj.getAttribute("id");
				var bakObj = document.getElementById(_id+"_bak");

				if(bakObj==null||bakObj.tagName==null){
						trace("obj"+obj);
						bakObj = obj.cloneNode(false);
						bakObj.setAttribute("id", _id+"_bak");
						bakObj.style.display = "none";
						obj.parentNode.appendChild(bakObj);

				}
				bakObj.contentWindow.location = url;
				//console.error(bakObj.innerHTML);
		}
}

//when iframe loaded and parse screen finish
function iframe_rename(_id, Parent){
	if(util.checkBrowser()){

		var dom = (Parent)?Parent.document:document;
		var orgObj = dom.getElementById(_id);
		orgObj.style.display = "";
				return;
				}



		var dom = (Parent)?Parent.document:document;
		var orgObj = dom.getElementById(_id);
		var bakObj = dom.getElementById(_id+"_bak");


		if(orgObj==null||orgObj.tagName==null||bakObj==null||bakObj.tagName==null){
				return;
		}


		var orgName = _id;
		var bakName = _id+"_bak";

		orgObj.setAttribute("id", bakName);
		bakObj.setAttribute("id", orgName);


		dom.getElementById(_id).style.display = "";
		dom.getElementById(_id+"_bak").style.display = "none";

		//iframe_src(dom.getElementById(_id+"_bak"), "about:blank");
		dom.getElementById(_id+"_bak").parentNode.removeChild(dom.getElementById(_id+"_bak"));

}
function getKeyCode(e){
		return (window.event)?window.event.keyCode:e.which;
}
function iframe_onload(iframe, fun){
		//if(fun==null) return;

		//IE (before finish init)
		/*
		iframe.onreadystatechange = function(){
        if (iframe.readyState == "complete"){
            alert("Local iframe is now loaded.");
        }
    };
    */

    //IE (after finish init)
		if(iframe.attachEvent){
		    iframe.attachEvent("onload", function(){
		        //trace("attachEvent");
		        if(fun) fun();
		    });

		//other (after finish init)
		}else{
		    iframe.onload=function(){
		        //trace("onload");
		        if(fun) fun();
		    };
		}
}

function echo(msg){
		if(document.all){
				alert(msg);
		}else{
				console.log(msg);
		}
}
var elemtAll=null;
var aa = false;
var bb = this.name;
document.getElementById=function(_id){
	if(bb=="body"){
			if (elemtAll==null) elemtAll=document.getElementsByTagName("*");
			obj=elemtAll[_id];
	}else{
			obj=document.getElementsByTagName("*")[_id];
	}
	if(obj==null){
			if(notfind[_id]==null){
					obj = new Object();
					obj.style = new Object();
					obj.getAttribute = emptyFun;
					obj.setAttribute = emptyFun;
					obj.innerHTML = emptyFun;
					notfind[_id] = obj;
			}else{
				obj = notfind[_id];
			}
	}
	return obj;
}

function clearElementAll(){
		elemtAll=null;
}

/*
document.getElementById=function(_id){
 		var newAry = new Array();
 		var bodyObj = document.getElementsByTagName("body")[0];
 		var objAry = null;
 		var obj = null;

 		if(bodyObj!=null&&_id!=null){
 				objAry = bodyObj.children;
 				if(bodyObj.getAttribute("id")==_id){
 						obj = bodyObj;
 				}else{
 						obj = getChildAry(objAry, _id, newAry)[0];
 				}
		}

		if(obj==null){

				if(notfind[_id]==null){
						obj = new Object();

						obj.style = new Object();
						obj.getAttribute = emptyFun;
						obj.setAttribute = emptyFun;
						obj.innerHTML = emptyFun;
						notfind[_id] = obj;
				}

				obj = notfind[_id];
				//console.warn("Object \""+_id+"\" is not exist.");
				//if(top.isTestSite) console.trace();
				////util.systemMsg("Object \""+_id+"\" is not exist.");

		}

		return obj;
}
*/

function loadComplet(){
		load_jq_complet = true;
}
/*
try{
		var _src = "https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js";
		var paramObj = new Object();
		paramObj["targetHead"] = document.getElementsByTagName("head")[0];
		util.loadScript(_src, paramObj, loadComplet);
}catch(e){
		//console.error(e.toString());
}
*/
JQ = new JQAnimate();

function JQAnimate(){
  var _self = this;
  _self.init=function(){

  }

  //hide
  _self.hide=function(divname, speed, callback){
  		try{
	  			$(divname).hide(speed, callback);
	  	}catch(e){
	  			console.error(e.toString());
	  			throw new Error("error");
	  	}
  }

  //show
  _self.show=function(divname, speed, callback){
  		try{
	  			$(divname).show(speed, callback);
	  	}catch(e){
	  			console.error(e.toString());
	  			throw new Error("error");
	  	}
  }

  //hide/show
  _self.toggle=function(divname, speed, callback){
  		try{
	  			$(divname).toggle(speed, callback);
	  	}catch(e){
	  			console.error(e.toString());
	  			throw new Error("error");
	  	}
  }

	//slide up
  _self.slideUp=function(divname, speed, callback){
  		try{
	  			$(divname).slideUp(speed, callback);
	  	}catch(e){
	  			console.error(e.toString());
	  			throw new Error("error");
	  	}
  }

	//slide down
  _self.slideDown=function(divname, speed, callback){
  		try{
	  			$(divname).slideDown(speed, callback);
	  	}catch(e){
	  			console.error(e.toString());
	  			throw new Error("error");
	  	}
  }

	//slide up/down
  _self.slideToggle=function(divname, speed, callback){
  		try{
	  			$(divname).slideToggle(speed, callback);
	  	}catch(e){
	  			console.error(e.toString());
	  			throw new Error("error");
	  	}
  }

	//fade in
  _self.fadeIn=function(divname, speed, callback){
  		try{
	  			$(divname).fadeIn(speed, callback);
	  	}catch(e){
	  			console.error(e.toString());
	  			throw new Error("error");
	  	}
  }

	//fade out
  _self.fadeOut=function(divname, speed, callback){
  		try{
	  			$(divname).fadeOut(speed, callback);
	  	}catch(e){
	  			console.error(e.toString());
	  			throw new Error("error");
	  	}
  }

	//fade in/out
  _self.fadeToggle=function(divname, speed, callback){
  		try{
	  			$(divname).fadeToggle(speed, callback);
	  	}catch(e){
	  			console.error(e.toString());
	  			throw new Error("error");
	  	}
  }

	//fade to
  _self.fadeTo=function(divname, speed, opacity, callback){
  		try{
	  			$(divname).fadeTo(speed, opacity, callback);
	  	}catch(e){
	  			console.error(e.toString());
	  			throw new Error("error");
	  	}
  }

  //focus out
  _self.focusOut=function(divname, callback){
  		//console.log("set focus out=====>"+divname+","+callback);
  		try{
	  			$(divname).focusout(function(){
	  					return _self.transFun(callback);
	  			});

	  	}catch(e){
	  			console.error(e.toString());
	  			/*
	  			if(!load_jq_complet){
	  					setTimeout(function(){_self.focusOut(divname, callback)}, 1000);
	  			}
	  			*/
	  	}
  }

  _self.transFun=function(callback){

			//if(typeof callback=="function"){
			//		return callback();
			//}
			if(typeof callback=="string"){
					return new Function("return "+callback)();
			}
			return null;
	}

}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8 "><script>
function XmlNode(root){
		_self=this;
		if(root==null) return;
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
				//return retNode;
		}
		
		_self.Node=function(parentNode,node,auto){
				if (parentNode.length>1){
						//alert("DataNode error!!");
						return;
				}
				
				retNode=parentNode.getElementsByTagName(node);
				//if (auto==false) return retNode;
				//if (retNode.length==1) return retNode[0];
				//else return retNode;
		
		
				var newNode = new Object();
				newNode.length = retNode.length;
				
				for(var i=0;i<retNode.length;i++){
						newNode[i]=retNode[i];
						if (newNode[i].getAttribute("id")!=null){
								newNode[newNode[i].getAttribute("id")]=newNode[i];
						}
				}
  			

				if (auto==false) return newNode;
				if (newNode.length==1) return newNode[0];
				else return newNode;
				
				

		}
		
		_self.removeMC=function(){
			
		}
		
		_self.getNodeVal=function(Node){
			
				if(Node!=null){
					
						if(Node.childNodes!=null){ //tag not exist
							
								if(Node.childNodes[0]!=null){ //content of tag is empty
									
										if(Node.childNodes[0].nodeValue!=null){
												return Node.childNodes[0].nodeValue;
										}
										
								}else{
										return "";
								}
								
						}
				}
				return null;
		}
		
	
}	</script>
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
		        	self.eventhandler("onError",req.responseText);
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
/* Obj.e520 | Copyright 2014 ,Cvssp Inc. from this DBA Depts. | Gather you rosebuds while you may. | string
  bill TW_time:2014-11-11 17:06:39 file(113-300,301,302,303,304,224,212,321)
 */

top["str_submit"]="PLACE BET";
top["str_check_submit"]=" ACCEPT CHANGE <br>& PLACE BET";
top["str_Quit_MailSet"]="Cancel Registration?";
top["str_Quit_getPass"]="Cancel Password Recovery?";
top["str_RM_getPass"]="Delete Password Recovery?";

/* conf_lvar_00 (160) */
top["str_input_pwd"]="Please enter your password.";
top["str_input_repwd"]="Please confirm your password.";
top["str_err_pwd"]="Your passwords don't match. Please try again.";
top["str_pwd_limit"]="The password you entered does not meet the requirements:<br>1. Your password must be between 6 to 12 alphanumeric (A-Z & 0-9) characters.<br>2. Your new password cannot be the same as your current password.";
top["str_pwd_limit2"]="The password you entered does not meet the requirements:<br>1. Your password must be between 6 to 12 alphanumeric (A-Z & 0-9) characters.<br>2. Your new password cannot be the same as your current password.";
top["str_pwd_limit3"]="Your password must be between 6 to 12 alphanumeric (A-Z & 0-9) characters.";
top["str_err_mail"]="Please enter a valid email address.";
top["str_pwd_NoChg"]="Your new password cannot be the same as your current password. Please try again.";
top["str_pwd_NowErr"]="The password entered is incorrect. Please try again.";
top["str_pwd_OldErr"]="Please enter your current password.";
top["str_input_longin_id"]="Please enter your login ID.";
top["str_input_longin_id2"]="Please enter a User Code or Login ID.";
top["str_longin_limit1"]="The login ID you entered does not meet the requirements:<br>1. Your login ID must be between 6 to 12 alphanumeric characters with at least 2 capital (A-Z) or lowercase letters (a-z) and at least 1 numeric character (0-9).<br>2. Your login ID must not contain any spaces.";
top["str_longin_limit2"]="Login ID must involve numbers and letters!!";
top["str_refund"]="Push";
top["str_cancel"]="Cancel";
top["text_o"]="O";
top["text_e"]="E";
top["text_u"]="U";
top["str_o"]="O";
top["str_e"]="E";
top["str_checknum"]="Wrong check number, please enter again.";
top["str_irish_kiss"]="Draw";
top["str_draw"]="Push";
top["dPrivate"]="Private";
top["dPublic"]="Public";
top["grep"]="Group";
top["grepIP"]="GroupIP";
top["IP_list"]="IP list";
top["Group"]="Group";
top["choice"]="Choice";
top["account"]="Please enter your login ID.";
top["password"]="Please enter your password.";
top["S_EM"]="Earlier";
top["alldata"]="All";
top["date"]=" All Dates";
top["webset"]="Information";
top["str_renew"]="Refresh";
top["outright"]="Outright";
top["financial"]="Index";
top["str_FT"]="Soccer";
top["str_BK"]="B.K / NFL";
top["str_TN"]="Tennis";
top["str_VB"]="Volleyball";
top["str_BM"]="Badminton";
top["str_TT"]="Table Tennis";
top["str_BS"]="Baseball";
top["str_OP"]="Other sports";
top["str_score"]="Score";
top["str_order_FT"]="Soccer";
top["str_order_BK"]="Basketball & <br>American Football";
top["str_order_TN"]="Tennis";
top["str_order_VB"]="Volleyball";
top["str_order_BM"]="Badminton";
top["str_order_TT"]="Table Tennis";
top["str_order_BS"]="Baseball";
top["str_order_OP"]="Other Sports";
top["str_order_SK"]="Snooker";
top["str_fs_FT"]="Soccer : ";
top["str_fs_BK"]="B.K / NFL : ";
top["str_fs_TN"]="Tennis : ";
top["str_fs_VB"]="Volleyball : ";/* No.50 */
top["str_fs_BM"]="Badminton : ";
top["str_fs_TT"]="Volleyball : ";
top["str_fs_BS"]="Table Tennis : ";
top["str_fs_OP"]="Other Sports : ";
top["str_game_list"]="All Sports";
top["str_date_list"]="All";
top["str_second"]="sec";
top["str_demo"]="Demo";
top["str_alone"]="Stand alone player";
top["str_back"]="Back";
top["str_RB"]="Live";
top["str_msAll"]="(Full Time)";
top["str_ShowMyFavorite"]="Add to My Favourites";
top["str_ShowAllGame"]="Show All";
top["str_delShowLoveI"]="Remove from My Favourites";
top["str_SortType"]="Sort By Time";
top["str_SortTypeC"]="Sort By Compition";
top["str_SortTypeT"]="Sort By Time";
top["strOver"]="Over";
top["strUnder"]="Under";
top["yes"]="Yes";
top["no"]="No";
top["team1"]="Team 1";
top["team2"]="Team 2";
top["team3"]="Draw";
top["noGoal"]="No Goal";
top["strOdd"]="Odd";
top["strEven"]="Even";
top["message001"]=" Please enter your stake amount.";
top["message002"]=" only numbers acceptable!!";
top["message003"]=" The minimum bet amount is";
top["message004"]=" The maximum bet amount for this event is ";
top["message005"]="";
top["message006"]=" The maximum bet amount is ";
top["message007"]=" Exceeded maximum bet amount for this event.";
top["message008"]=" Total amount placed on this event is already ";
top["message009"]=".\n\n Current bet exceeds maximum limit for this event.";
top["message010"]=" You do not have sufficient credit to place this bet.";
top["message011"]=" Estimated Winnings: ";
top["message012"]=" confirm your wager?<br>";
top["message013"]=" <br> Proceed with bet placement?";
top["message014"]=" Please enter your stake amount.";
top["message015"]=" Please enter only numbers for stake amount.";
top["message016"]=" \n\n Proceed with bet placement?";
top["message017"]=" parlay 1";
top["message018"]=" team reverse";
top["message019"]=" You have to select at least ";
top["message020"]=" teams,otherwise the system cannot accept your wager!!";
top["message021"]=" You have added ";
top["message022"]=" selections in your Parlay.  The number of selections in your parlay bet is more than is accepted. Please remove some selections.";
top["message023"]=" selections in your Parlay.  The number of selections in your parlay bet is more than is accepted. Please remove some selections.";
top["message024"]=" The total of your parlay wager on this game has exceeded your parlay maximum wager limitation!!";
top["message025"]=" You do not have sufficient credit to place this bet.";
top["message026"]=" please select teams!!";
top["message027"]=" Single wager please goto Single Wage Page for betting!!";
top["message028"]=" please make sure you select at ";/* No.100 */
top["message029"]=" different matches!!";
top["message030"]="Proceed with bet placement?";
top["message031"]="Please enter some text to search";
top["message032"]="The following text was not found";
top["message033"]="Your browser does not support";
top["message034"]="ACCEPT CHANGE & PLACE BET";
top["message035"]="Max Payout per Bet: RMB ";
top["message036"]="";
top["message037"]="The minimum bet amount is ";
top["message038"]="The maximum bet amount is ";
top["message039"]="The market has closed.";
top["message040"]="The event is now In-Play.";
top["message041"]="Trading in this market is temporarily suspended.";
top["message042"]="The odds of one or more selections have changed.";
top["message043"]="One or more of the markets are closed.";
top["message044"]="Your bet is currently pending. Please refresh or check the ticket status in My Bets.";
top["page"]="Page";
top["refreshTime"]=" Refresh";
top["showyear"]="Year";
top["showmonth"]="Month";
top["showday"]="Day";
top["showtoday"]="Today";
top["showtomorrow"]="Tomorrow";
top["showfuture"]="Future Dates";
top["Half1st"]="1st Half";
top["Half2nd"]="2nd Half";
top["mem_logut"]="You have been logout.";
top["retime1H"]="1st Half";
top["retime2H"]="2nd Half";
top["str_otb_close"]="The event has closed.";
top["no_oly"]="There are currently no events available in this selection. Please check Outright bet type.";
top["conf_R"]="Handicap, Over/Under, Odd/Even";
top["conf_RE"]="R.B. Handicap, R.B. Over/Under, R.B. Odd/Even";
top["conf_RE_BK"]="R.B. Handicap, R.B. Over/Under, R.B. Odd/Even";
top["conf_M"]="1 X 2, R.B. 1 X 2";
top["conf_M_BK"]="Money Line, R.B. Money Line";
top["conf_DT"]="Other Bet Type";
top["conf_RDT"]="R.B. Other Bet Type";
top["conf_FS"]="Outright";
top["str_more"]="More";
top["str_all_bets"]="All Bets";
top["str_TV_RB"]="Live Streaming available";
top["str_TV_FT"]="Live Streaming available when In-Play";
top["addtoMyMarket"]='Add to "My Markets"';
top["deltoMyMarket"]="Remove from My Markets";
top["str_BK_OT"]="Over Time";
top["str_midfield"]="N";
top["str_BK_Market_Main"]="Main Markets Only";
top["str_BK_Market_All"]="All Markets";
top["str_BK_Period_View"]="View Periods";
top["str_BK_Period_Hide"]="Hide Periods";
top["str_TN_Market_Main"]="Main Markets Only";
top["str_TN_Market_All"]="All Markets";
top["str_TN_Period_View"]="View Sets";
top["str_TN_Period_Hide"]="Hide Sets";
top["str_BM_Market_Main"]="Main Markets Only";
top["str_BM_Market_All"]="All Markets";
top["str_BM_Period_View"]="View Games";
top["str_BM_Period_Hide"]="Hide Games";
top["str_TT_Market_Main"]="Main Markets Only";
top["str_TT_Market_All"]="All Markets";
top["str_TT_Period_View"]="View Games";
top["str_TT_Period_Hide"]="Hide Games";
top["str_VB_Market_Main"]="Main Markets Only";
top["str_VB_Market_All"]="All Markets";
top["str_VB_Period_View"]="View Sets";
top["str_VB_Period_Hide"]="Hide Sets";
top["TN_set_1"]="1st Set";
top["TN_set_2"]="2nd Set";
top["TN_set_3"]="3rd Set";
top["TN_set_4"]="4th Set";
top["TN_set_5"]="5th Set";
top["BM_set_1"]="1st Game";
top["BM_set_2"]="2nd Game";/* No.150 */
top["BM_set_3"]="3rd Game";
top["BM_set_4"]="4th Game";
top["BM_set_5"]="5th Game";
top["VB_set_1"]="1st Set";
top["VB_set_2"]="2nd Set";/* No.150 */
top["VB_set_3"]="3rd Set";
top["VB_set_4"]="4th Set";
top["VB_set_5"]="5th Set";
top["VB_set_6"]="6th Set";
top["VB_set_7"]="7th Set";
top["TT_set_1"]="1st Game";
top["TT_set_2"]="2nd Game";/* No.150 */
top["TT_set_3"]="3rd Game";
top["TT_set_4"]="4th Game";
top["TT_set_5"]="5th Game";
top["TT_set_6"]="6th Game";
top["TT_set_7"]="7th Game";

top["str_ARG"]="1st Goal";
top["str_BRG"]="2nd Goal";
top["str_CRG"]="3rd Goal";
top["str_DRG"]="4th Goal";
top["str_ERG"]="5th Goal";
top["str_FRG"]="6th Goal";
top["str_GRG"]="7th Goal";
top["str_HRG"]="7th Goal";
top["str_IRG"]="7th Goal";
top["str_JRG"]="7th Goal";


top["str_VB_Game"]="Total Sets : ";
top["str_VB_allPoint"]="Total Points : ";
top["str_VB_point"]="Points : ";
top["str_VB_more_r0"]="Set Handicap";
top["str_VB_more_r"]="Point Handicap";
top["str_VB_more_re0"]="Set Handicap";
top["str_VB_more_re"]="Point Handicap";/* No.160 */
top["point"]=".";//點

top["TN_Best3"]="Best of 3";//best of xx
top["TN_Best5"]="Best of 5";
top["TN_Best7"]="Best of 7";

top["SK_Best"]="Best of ";
top["PAGE"]="P";
top["PAGE_NUM"]="PAGE";
top["OVH"]="Any Other Score";
top["HK_Odds"]="Hong Kong Odds";
top["Euro_Odds"]="Euro Decimal Odds";

top["str_RSHA"]="1st Penalty";
top["str_RSHB"]="2nd Penalty";
top["str_RSHC"]="3rd Penalty";
top["str_RSHD"]="4th Penalty";
top["str_RSHE"]="5th Penalty";
top["str_RSHF"]="6th Penalty";
top["str_RSHG"]="7th Penalty";
top["str_RSHH"]="8th Penalty";
top["str_RSHI"]="9th Penalty";
top["str_RSHJ"]="10th Penalty";
top["str_RSHK"]="11th Penalty";
top["str_RSHL"]="12th Penalty";
top["str_RSHM"]="13th Penalty";
top["str_RSHN"]="14th Penalty";
top["str_RSHO"]="15th Penalty";
top["str_RNC1"]="1st Corner";
top["str_RNC2"]="2nd Corner";
top["str_RNC3"]="3rd Corner";
top["str_RNC4"]="4th Corner";
top["str_RNC5"]="5th Corner";
top["str_RNC6"]="6th Corner";
top["str_RNC7"]="7th Corner";
top["str_RNC8"]="8th Corner";
top["str_RNC9"]="9th Corner";
top["str_RNCA"]="10th Corner";
top["str_RNCB"]="11th Corner";
top["str_RNCC"]="12th Corner";
top["str_RNCD"]="13th Corner";
top["str_RNCE"]="14th Corner";
top["str_RNCF"]="15th Corner";
top["str_RNCG"]="16th Corner";
top["str_RNCH"]="17th Corner";
top["str_RNCI"]="18th Corner";
top["str_RNCJ"]="19th Corner";
top["str_RNCK"]="20th Corner";
top["str_RNCL"]="21th Corner";
top["str_RNCM"]="22th Corner";
top["str_RNCN"]="23th Corner";
top["str_RNCO"]="24th Corner";
top["str_RNCP"]="25th Corner";
top["str_RNCQ"]="26th Corner";
top["str_RNCR"]="27th Corner";
top["str_RNCS"]="28th Corner";
top["str_RNCT"]="29th Corner";
top["str_RNCU"]="30th Corner";
top["str_RNBA"]="1st Booking";
top["str_RNBB"]="2nd Booking";
top["str_RNBC"]="3rd Booking";
top["str_RNBD"]="4th Booking";
top["str_RNBE"]="5th Booking";
top["str_RNBF"]="6th Booking";
top["str_RNBG"]="7th Booking";
top["str_RNBH"]="8th Booking";
top["str_RNBI"]="9th Booking";
top["str_RNBJ"]="10th Booking";
top["str_RNBK"]="11th Booking";
top["str_RNBL"]="12th Booking";
top["str_RNBM"]="13th Booking";
top["str_RNBN"]="14th Booking";
top["str_RNBO"]="15th Booking";
top["str_AO"] = "Over 1.5";
top["str_BO"] = "Over 2.5";
top["str_CO"] = "Over 3.5";
top["str_DO"] = "Over 4.5";
top["str_AU"] = "Under 1.5";
top["str_BU"] = "Under 2.5";
top["str_CU"] = "Under 3.5";
top["str_DU"] = "Under 4.5";
top["goAllbets"]="Click 'OK' so All Bets Page become the active window.";
top["goodmybets"]="Click 'OK' so My Bets Will become the active window.";
top["ET_str"]="Extra Time starts at 0-0";
top["PK_istr"]="Over / Under market will be based on the first 10 penalties taken in the Penalty Shootout.";
top["PK_head"]="Next Penalty";

// 2017-05-05 PMO-51 危險球狀態字樣改變+十秒自動更新注單狀況
top["str_bet_sucess"] = "Bet placement confirmed!";
top["str_bet_reject"] = "Your bet is rejected.";
top["str_bet_pending"] = "Your bet is currently pending. Please check the status of this ticket in My bets.";

//RT Name
top.str_RT=["0 - 1","2 - 3","4 - 6","7 or More"];

/* conf_lvar_01  (3) */
top.str_HCN=["Home","Away","No"];

/* conf_lvar_02  (24) */
top.strRtypeSP={"PGF":"First Goal","OSF":"First Offside","STF":"Last Substitution","CNF":"First Corner","CDF":"First Booking","RCF":"First Free Kick","YCF":"First Throw In","GAF":"First Goal Kick","PGL":"Last Goal","OSL":"Last Offside","STL":"Last Substitution","CNL":"Last Corner","CDL":"Last Booking","RCL":"Last Free Kick","YCL":"Last Throw In","GAL":"Last Goal Kick","PG":"First Goal/Last Goal","OS":"First Offside/Last Offside","ST":"First Substitution/Last Substitution","CN":"First Corner/Last Corner","CD":"First Booking/Last Booking","RC":"First Free Kick/Last Free Kick","YC":"First Throw In/Last Throw In","GA":"First Goal Kick/Last Goal Kick"};

/* conf_lvar_03  (3) */
top.statu={"HT":"Half Time","1H":"1st Half","2H":"2nd Half"};

/* conf_lvar_04  (7) */
top.str_BK_MS=["","1st Half","2nd Half","1st Quarter","2nd Quarter","3rd Quarter","4th Quarter"];

/* conf_session  (41) */
top._session={"FTi0":"Full","FTi1":"1st Half","BKi0":"Full","BKi8":"1st Half","BKi9":"2nd Half","BKi3":"Q1","BKi4":"Q2","BKi5":"Q3","BKi6":"Q4","BSi0":"Full","FSi0":"Full","OPi0":"Full","TNi0":"Full","TNi1":"1st Set","TNi2":"2nd Set","TNi3":"3rd Set","TNi4":"4th Set ","TNi5":"5th Set","TNi6":"Game HDP","TNi7":"player A Game","TNi8":"player B Game","VBi0":"Full","VBi1":"Set HDP","VBi2":"Point HDP","VBi3":"1st Set","VBi4":"2nd Set","VBi5":"3rd Set","VBi6":"4th Set","VBi7":"5th Set","VBi8":"6th Set","VBi9":"7th Set","BMi0":"Full","BMi1":"Point HDP","BMi2":"1st Game","BMi3":"2nd Game","BMi4":"3rd Game","BMi5":"4th Game","BMi6":"5th Game","BMi7":"6th Game","BMi8":"7th Game","TTi0":"Full"};

/* conf_gtype  (9) */
top._gtype={"FT":"soccer","BK":"Basketball","BS":"Baseball","FS":"Outright","OP":"Other","TN":"Tennis","VB":"Volleyball","BM":"Badminton","TT":"table tennis"};

/* conf_lvar_21  (19) */
top.str_result={"No":"No","Y":"YES","N":"No","FG_S":"Shot","FG_H":"Header","FG_N":"No Goal","FG_P":"Penalty","FG_F":"Free Kick","FG_O":"Own Goal","T3G_1":"U26","T3G_2":"U27+","T3G_N":"No Goal","T1G_N":"No Goal","T1G_1":"0 - 14:59 Mins","T1G_2":"15 - 29:59 Mins","T1G_3":"30 Mins – Half Time","T1G_4":"Start of 2nd Half – 59:59 Mins","T1G_5":"60 – 74:59 Mins","T1G_6":"75 – Full Time End of 90 Mins","Both":"Both","MQ_H":" - U90","MQ_C":" - U90","MQ_HOT":" - Extra Time","MQ_COT":" - Extra Time","MQ_HPK":" - Penalty","MQ_CPK":" - Penalty","RNB_P":"No Booking","RNC_P":"No Corner","RS_Y":"Goal","RS_N":"No Goal","RS_P":"No Penalty"};

/* conf_date_21  (20) */
top._date={"m01":"Jan","m02":"Feb","m03":"Mar","m04":"Apr","m05":"May","m06":"Jun","m07":"Jul","m08":"Aug","m09":"Sep","m10":"Oct","m11":"Nov","m12":"Dec","Monday":"Mon","Tuesday":"Tue","Wednesday":"Wed","Thursday":"Thu","Friday":"Fri","Saturday":"Sat","Sunday":"Sun"};

/*conf_top._session_sk(6)*/
top._session_sk={"A":" - Frames 1-5","B":" - Frames 6-8","C":" - Frames 10-14","D":" - Frames 15-17","E":" - Frames 19-23","F":" - Frames 24-26"};

/*conf_top._session_sk_rf(35)*/
top._session_sk_rf={"01":" - 1st Frame","02":" - 2nd Frame","03":" - 3rd Frame","04":" - 4th Frame","05":" - 5th Frame","06":" - 6th Frame","07":" - 7th Frame","08":" - 8th Frame","09":" - 9th Frame","10":" - 10th Frame","11":" - 11th Frame","12":" - 12th Frame","13":" - 13th Frame","14":" - 14th Frame","15":" - 15th Frame","16":" - 16th Frame","17":" - 17th Frame","18":" - 18th Frame","19":" - 19th Frame","20":" - 20th Frame","21":" - 21st Frame","22":" - 22nd Frame","23":" - 23rd Frame","24":" - 24th Frame","25":" - 25th Frame","26":" - 26th Frame","27":" - 27th Frame","28":" - 28th Frame","29":" - 29th Frame","30":" - 30th Frame","31":" - 31st Frame","32":" - 32nd Frame","33":" - 33rd Frame","34":" - 34th Frame","35":" - 35th Frame"};</script>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<script>
gamedate = '2017-08-15';
var GameData = new Array();
GameData[0] = new Array('FT','06:00','日本J2聯賽','水戶霍利克','京都不死鳥','1766043');
GameData[1] = new Array('FT','06:00','日本J2聯賽','千葉市原','湘南比馬','1766048');
GameData[2] = new Array('FT','06:00','日本J2聯賽','松本山雅','山形蒙迪奧','1766053');
GameData[3] = new Array('FT','06:00','日本J2聯賽','町田澤維亞','名古屋鯨魚','1766058');
GameData[4] = new Array('FT','06:00','日本J2聯賽','澤維真金澤','德島沃堤','1766063');
GameData[5] = new Array('FT','06:00','日本J2聯賽','岡山雉雞','愛媛','1766068');
var GameHead = new Array('gtype','time','league','teamH','teamC','gidm');
var msg='';
var mtype='2';
var mem_enable='Y';
var countHOT= '' ;
var checkRoute='Y';
var imgurl='http://66.133.87.20';
var countMessage='';
</script>
<script>
top.uid = 'rgq1oe8e4m16617016l1234920';
top.langx = 'en-us';
top.liveid = ''
top.casino = 'SI2';
top.mtype = '2';
top.autoOddCheck = (''+top.autoOddCheck!='undefined')?top.autoOddCheck:true;
</script>

<body onLoad="bodyLoad();">
<div class="ord_main" id="div_ord_main">



		<div class="ord_memu">
    	<span id="title_menu" onClick="showMenu('menu')" class="ord_memuBTN_on">MENU</span>
    	<span id="title_betslip" onClick="showMenu('betslip')" class="ord_memuBTN">Bet Slip</span>
    	<span id="title_mybets" onClick="showMenu('mybets')" class="ord_memuBTN no_margin">my bets<span id="count_mybet" class="ord_msg">0</span></span>
    </div>



		<!--menu-->
   	<div id="div_menu" name="div_menu" class="ord_DIV">
     <!--過關下注數-->
    <div id="show_parlay" class="ord_parlyG noFloat" onClick="showMenu('betslip')" style="display:none">
     <ul><li>Parlay Bet Slip</li></ul>
     <span id="count_parlay" class="ord_parlyNUM">0</span>
    </div>

      <!--滾球區-->
      <div id="euro_open" style="display:none;" class="ord_sportMenu_InPlayG">
        <h1>In-Play Now</h1>
			<div id="div_rb" class="ord_sportMenu_InPlay">
        	<div id="FT_div_rb" style="display:none;" class="ord_sportFT_nor_off noFloat" onClick="Go_RB_page('FT');"><span class="ord_sportName">Soccer</span><span id="RB_FT_games" class="ord_sportDigit">0</span></div>
            <div id="BK_div_rb" style="display:none;" class="ord_sportBK_nor_off noFloat" onClick="Go_RB_page('BK');"><span class="ord_sportName">Basketball & <br>American Football</span><span id="RB_BK_games" class="ord_sportDigit">0</span></div>
            <div id="TN_div_rb" style="display:none;" class="ord_sportTN_nor_off noFloat" onClick="Go_RB_page('TN');"><span class="ord_sportName">Tennis</span><span id="RB_TN_games" class="ord_sportDigit">0</span></div>
            <div id="VB_div_rb" style="display:none;" class="ord_sportVB_nor_off noFloat" onClick="Go_RB_page('VB');"><span class="ord_sportName">Volleyball</span><span id="RB_VB_games" class="ord_sportDigit">0</span></div>
			<div id="BM_div_rb" style="display:none;" class="ord_sportBM_nor_off noFloat" onClick="Go_RB_page('BM');"><span class="ord_sportName">Badminton</span><span id="RB_BM_games" class="ord_sportDigit">0</span></div>
          	<div id="TT_div_rb" style="display:none;" class="ord_sportTT_nor_off noFloat" onClick="Go_RB_page('TT');"><span class="ord_sportName">Table Tennis</span><span id="RB_TT_games" class="ord_sportDigit">0</span></div>
          	<div id="BS_div_rb" style="display:none;" class="ord_sportBS_nor_off noFloat" onClick="Go_RB_page('BS');"><span class="ord_sportName">Baseball</span><span id="RB_BS_games" class="ord_sportDigit">0</span></div>
          	<div id="SK_div_rb" style="display:none;" class="ord_sportSK_nor_off noFloat" onClick="Go_RB_page('SK');"><span class="ord_sportName">Snooker</span><span id="RB_SK_games" class="ord_sportDigit">0</span></div>
          	<div id="OP_div_rb" style="display:none;" class="ord_sportOT_nor_off noFloat" onClick="Go_RB_page('OP');"><span class="ord_sportName">Other Sports</span><span id="RB_OP_games" class="ord_sportDigit">0</span></div>

        </div>
        <div id="RB_nodata" style="display:none;" class="ord_noInPlay">There are no In-Play events available at present</div><!--沒賽-->
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
		      <h1 id="hot_name">Highlights</h1>

		      <div id="hot_show" class="ord_sportMenu_high"></div>

		   		<div id="hot_model" style="display:none;">
				      <div *GTYPE_STYLE*  onclick="showHotDiv('*GTYPE*');"> <!-- class="ord_sportFT_high noFloat" -->
				      	<span class="ord_sportName"><span class="ordH3">*GTYPE_NAME*</span><span class="ordH4">*GAME_NAME*</span></span><span id="arrow_*GTYPE*" *ARROW_CLASS*></span>
				      </div>
				      <ul id="hot_div_*GTYPE*" *DIV_DISPLAY*>
				      	<li id="hot_game_RB_*GTYPE*" *RB_DISPLAY* onClick="goToHotGame('RB','*GTYPE*');"><h5>In-Play Matches</h5><h6>*RB_COUNT*</h6></li>
				        <li id="hot_game_FT_*GTYPE*" *FT_DISPLAY* onClick="goToHotGame('FT','*GTYPE*');"><h5>Today's Matches</h5><h6>*FT_COUNT*</h6></li>
				        <li id="hot_game_FU_*GTYPE*" *FU_DISPLAY* onClick="goToHotGame('FU','*GTYPE*');"><h5>Early Matches</h5><h6>*FU_COUNT*</h6></li>
				        <li id="hot_game_P3_*GTYPE*" *P3_DISPLAY* onClick="goToHotGame('P3','*GTYPE*');"><h5>Parlay</h5><h6>*P3_COUNT*</h6></li>
				        <li id="hot_game_FS_*GTYPE*" *FS_DISPLAY* onClick="goToHotGame('FS','*GTYPE*');"><h5>Outright Markets</h5><h6>*FS_COUNT*</h6></li>
				    	</ul>
		   		</div>

      </div>
      <!-- 精選賽事 End -->



      <!--球類有下拉區-->
      <div class="ord_sportMenu_TodayG">
        <h1>SPORTS</h1>
        <div class="ord_memu2">
        		<span id="title_today" onClick="chgShowType('today');" class="ord_memuBTN_on">TODAY</span>
        		<span id="title_early" onClick="chgShowType('early');" class="ord_memuBTN">Early</span>
        		<span id="title_parlay" onClick="chgShowType('parlay');" class="ord_memuBTN no_margin">Parlay</span></div>
        <div id="sportMenu_Today" class="ord_sportMenu_Today" >


        		<div id="title_FT" style="display:none;" onClick="chgTitle('FT');" class="ord_sportFT_on noFloat"><span class="ord_sportName">Soccer</span><span id="FT_games" class="ord_sportDigit">0</span></div>
						<ul id="wager_FT" select="wtype_FT_r" style="display:">
            		<li id="wtype_FT_r" class="On" onClick="chgWtype(this.id);chg_type(this.id,'');">1 X 2 & HDP & O/U</li>
                <li id="wtype_FT_pd" onClick="chgWtype(this.id);chg_type(this.id,parent.FT_lid_type);">Correct Score</li>
                <li id="wtype_FT_t" onClick="chgWtype(this.id);chg_type(this.id,parent.FT_lid_type);">Total Goals</li>
                <li id="wtype_FT_f" onClick="chgWtype(this.id);chg_type(this.id,parent.FT_lid_type);">HT / FT</li>
                <li id="wtype_FT_fs" onClick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin">Outright</li>
            </ul>

            <div id="title_BK" style="display:none;" onClick="chgTitle('BK');" class="ord_sportBK_off noFloat"><span class="ord_sportName">Basketball & <br>American Football</span><span id="BK_games" class="ord_sportDigit">0</span></div>
            <ul id="wager_BK" select="wtype_BK_r" style="display:none">
            		<li id="wtype_BK_r" class="On" onClick="chgWtype(this.id);chg_type(this.id,parent.BK_lid_type);">Matches</li>
                <li id="wtype_BK_fs" onClick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin">Outright</li>
            </ul>



            <div id="title_TN" style="display:none;" onClick="chgTitle('TN');" class="ord_sportTN_off noFloat"><span class="ord_sportName">Tennis</span><span id="TN_games" class="ord_sportDigit">0</span></div>
            <ul id="wager_TN" select="wtype_TN_r" style="display:none">
            		<li id="wtype_TN_r" class="On" onClick="chgWtype(this.id);chg_type(this.id,'');">Matches</li>
                <li id="wtype_TN_pd35" onClick="chgWtype(this.id);chg_type(this.id,parent.TN_lid_type);">Correct Score</li>
                <li id="wtype_TN_fs" onClick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin">Outright</li>
            </ul>



            <div id="title_VB" style="display:none;" onClick="chgTitle('VB');" class="ord_sportVB_off noFloat"><span class="ord_sportName">Volleyball</span><span id="VB_games" class="ord_sportDigit">0</span></div>
            <ul id="wager_VB" select="wtype_VB_r" style="display:none">
            		<li id="wtype_VB_r" class="On" onClick="chgWtype(this.id);chg_type(this.id,'');">Matches</li>
                <li id="wtype_VB_pd35" onClick="chgWtype(this.id);chg_type(this.id,parent.VB_lid_type);">Correct Score</li>
                <li id="wtype_VB_fs" onClick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin">Outright</li>
            </ul>


            <div id="title_BM" style="display:none;" onClick="chgTitle('BM');" class="ord_sportBM_off noFloat"><span class="ord_sportName">Badminton</span><span id="BM_games" class="ord_sportDigit">0</span></div>
            <ul id="wager_BM" select="wtype_BM_r" style="display:none">
            		<li id="wtype_BM_r" class="On" onClick="chgWtype(this.id);chg_type(this.id,'');">Matches</li>
                <li id="wtype_BM_pd35" onClick="chgWtype(this.id);chg_type(this.id,parent.BM_lid_type);">Correct Score</li>
                <li id="wtype_BM_fs" onClick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin">Outright</li>
            </ul>


            <div id="title_TT" style="display:none;" onClick="chgTitle('TT');" class="ord_sportTT_off noFloat"><span class="ord_sportName">Table Tennis</span><span id="TT_games" class="ord_sportDigit">0</span></div>
            <ul id="wager_TT" select="wtype_TT_r" style="display:none">
            		<li id="wtype_TT_r" class="On" onClick="chgWtype(this.id);chg_type(this.id,'');">Matches</li>
                <li id="wtype_TT_pd57" onClick="chgWtype(this.id);chg_type(this.id,parent.TT_lid_type);">Correct Score</li>
                <li id="wtype_TT_fs" onClick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin">Outright</li>
            </ul>


            <div id="title_BS" style="display:none;" onClick="chgTitle('BS');" class="ord_sportBS_off noFloat"><span class="ord_sportName">Baseball</span><span id="BS_games" class="ord_sportDigit">0</span></div>
            <ul id="wager_BS" select="wtype_BS_r" style="display:none">
            		<li id="wtype_BS_r" class="On" onClick="chgWtype(this.id);chg_type(this.id,parent.BS_lid_type);">Matches</li>
                <li id="wtype_BS_fs" onClick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin">Outright</li>
            </ul>
            
            <div id="title_SK" style="display:none;" onClick="chgTitle('SK');" class="ord_sportSK_off noFloat"><span class="ord_sportName">Snooker</span><span id="SK_games" class="ord_sportDigit">0</span></div>
   					<ul id="wager_SK" select="wtype_SK_r" style="display:none">
            		<li id="wtype_SK_r" class="On" onClick="chgWtype(this.id);chg_type(this.id,parent.SK_lid_type);">Matches</li>
                <li id="wtype_SK_fs" onClick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin">Outright</li>
            </ul>

            <div id="title_OP" style="display:none;" onClick="chgTitle('OP');" class="ord_sportOT_off noFloat"><span class="ord_sportName">Other Sports</span><span id="OP_games" class="ord_sportDigit">0</span></div>
   					<ul id="wager_OP" select="wtype_OP_r" style="display:none">
            		<li id="wtype_OP_r" class="On" onClick="chgWtype(this.id);chg_type(this.id,parent.OP_lid_type);">Matches</li>
                <li id="wtype_OP_fs" onClick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin">Outright</li>
            </ul>

        </div>

 
         
      
        
        <div id="FT_today_nodata" style="display:none;" class="ord_noInSports">There are no events available for Today.</div><!--沒賽-->
        <div id="FT_early_nodata" style="display:none;" class="ord_noInSports">There are no EARLY events available.</div><!--沒賽-->
        <div id="FT_parlay_nodata" style="display:none;" class="ord_noInSports">There are no PARLAY events available.</div><!--沒賽-->
        
        <!--小廣告-->
      <div id="hideAD" class="ord_adG">
      	<span><img src="/images/member/order_ad03_en.jpg"/></span>
      	<span><a href="https://www.live228.com/" target="_blank"><img src="/images/member/order_ad01_en.jpg"/></a></span>
        <!--span><a href="http://www.433.com/" target="_blank"><img src="/images/member/order_ad02_en.jpg"/></a></span-->
      </div>
      
      
      </div>


    </div>

    <!--bet slip-->
    <div id="div_betslip" name="div_bet" class="ord_DIV">
    		<!--沒單文字-->
            <h1 id="SIN_BET">SINGLE BET</h1>
            <h1 id="PAR_BET" style="display:none">Parlay</h1>
    		<div id="bet_nodata" class="ord_noOrder" style="display:none">Please add a selection to your Bet Slip.</div>

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
<iframe id="reloadPHP" name="reloadPHP"  width="0" height="0" style="display:none;"></iframe>
</body>
</html>
