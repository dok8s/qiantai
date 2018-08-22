var AutoRenewID;
var ChkUserTimerID;
var ChkGameDataTimer;
var ChkUserTime = 10;
var ReloadTime = 60;
var TimerID = 0;
var T_color_h = "";
var T_color_c = "";
var Livegtype ="";
var Livegidm ="";
var pages='TVbut';
var gtype ="";//檢查tv是否結束用
var gidm ="";//檢查tv是否結束用
var is_box_none =1;//檢查tv是否結束用

top.mcurrency=parent.top.mcurrency;
top.hasLogin=parent.top.hasLogin;
var unasURL="";
function onloads() {
	onloadGame();
	reloadioratio();
}

function reloadioratio(){
	try{
		Live_mem.self.location="./game_ioratio_view.php?uid="+uid+"&langx="+parent.top.langx+"&gtype="+Livegtype+"&gidm="+Livegidm+"&gdate=All";
	}catch(e){
		Live_mem.src="./game_ioratio_view.php?uid="+uid+"&langx="+parent.top.langx+"&gtype="+Livegtype+"&gidm="+Livegidm+"&gdate=All";
	}
}
function onloadGame(){
	var tmp_opt = "";
	//====== 處理球類選單

	//====== 處理日期選單

	//====== 讀取賽程
	//document.getElementById("gameOpt").value = "All";
	Livegtype ="All";

	reloadGame();

	if (videoData != "") {
		var tmpAry=videoData.split(",");
		eventid=tmpAry[0];
	}
}

function divOnBlur(showdiv){
	document.getElementById(showdiv).style.display='';
}
function hideDiv(obj){
	obj.style.display ="none";
}

function chggype(obj){
	Livegtype =$(obj).attr('value');
	reloadGame();
	reloadioratio();
	var html = $(obj).html();
	$("#select_gtype").html(html);
	setTimeout("document.getElementById('show_gtype').style.display = 'none'",10);
	reload_game();
}

//function chggdate(){
//	reloadGame();
//	reloadioratio();
//}
function reloadGame() {
	try{
		reloadgame.self.location="./game_list.php?uid="+uid+"&langx="+parent.top.langx+"&gtype="+Livegtype+"&gdate=All";
	}catch(e){
		reloadgame.src="./game_list.php?uid="+uid+"&langx="+parent.top.langx+"&gtype="+Livegtype+"&gdate=All";
	}
}

function ResetTimer() {
	clearInterval(AutoRenewID);
	TimerID++;
	var tmp = (ReloadTime - TimerID);
	if(tmp <= 1){
		TimerID=0;
		reloadGame();
		//reloadscore();
	}
	AutoRenewID = setInterval("ResetTimer()",1000);
}

function independent() {
	var browser = check_browser();
	if (document.getElementById("time_list").style.display == "none") {	//取消獨立顯示
		document.getElementById("alone_btn").alt = top.str_alone;
		window.resizeTo(791,655);
	} else {	//獨立顯示
		document.getElementById("alone_btn").alt = top.str_back;
		if(browser == "safari"){
			window.resizeTo(516,600);
		}else if(browser == "chrome"){
			window.resizeTo(510,625);
		}else if(browser == "firefox"){
			window.resizeTo(516,635);
		}else{
			window.resizeTo(521,645);
		}

	}
}

//====== 啟動 game_data 定時檢查計時器
function ChkGameDataTimerFun() {
	return;
	clearInterval(ChkGameDataTimer);
	ChkGameDataTimer = setInterval("ChkGameData('"+gtype+"','"+gidm+"')", 60*1000);
}

//=== 檢查 user id
function ChkGameData(g,gid_m) {
	//alert("ChkGameData==>"+g+","+gid_m);
	if(g=="") {
		//alert("ChkGameData==clearVideo")
		clearVideo();
		return;
	}
	try{
		reloadPHP.self.location="./chk_game_data.php?uid="+uid+"&langx="+parent.top.langx+"&gtype="+g+"&gidm="+gid_m;
	} catch (E) {
		self.location="http://"+document.domain;
	}
}

function retGameData(b){
	//alert(b);
	if(b*1==0){
		//alert("retGameData b===>"+b);
		clearVideo();
	}
}


//====== 啟動 user 定時檢查計時器
function StartChkTimer() {
	return;//2013.08.26 這個 timer 是 定時回去檢查 tv 的 regedit 先拿掉
	clearInterval(ChkUserTimerID);
	ChkUserTimerID = setInterval("ChkUid('"+mtvid+"','"+eventid+"')",ChkUserTime * 60 *1000);
}

//=== 檢查 user id
function ChkUid(id, gid) {
	try{
		reloadPHP.self.location="./chk_registid.php?uid="+uid+"&langx="+parent.top.langx+"&regist_id="+id+"&liveid="+window.opener.top.liveid+"&gid="+gid;
	} catch (E) {
		self.location="http://"+document.domain;
	}
}

function send_result(datas) {
	var tmp = datas.split(",");
	if (tmp.length <= 1) {
		tmp[0] = datas;
	}
	if (tmp[0] == "false") {
		self.location.reload();
	}
	if (tmp.length > 1) {
		SetClothesColor(tmp[1], tmp[2]);
	}
}

//=== QA
function GoToQAPage() {
	window.open("/tpl/member/"+langx+"/QA.html","LiveQA","width=780,height=600,top=0,left=0,status=no,toolbar=no,scrollbars=yes,resizable=yes,personalbar=no");
}

function ShowVideo() {
	var swf_name = "liveTV_"+langx.substring(3)+".swf";
	var swf_str = "<object id=\"liveTV\" classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\""+
		"width=\"480\" height=\"410\" codebase='http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab#version=9,0,124,0'>"+
		"<param name=\"movie\" value=\""+swf_name+"\" />"+
		"<param name=\"quality\" value=\"high\" />"+
		"<param name=\"bgcolor\" value=\"#FFFFFF\" />"+
		"<param name=\"allowScriptAccess\" value=\"sameDomain\" />"+
		"<embed name=\"liveTV\" id=\"liveTV\" src=\""+swf_name+"\" quality=\"high\" bgcolor=\"#1C0D00\""+
		"width=\"480\" height=\"410\" align=\"middle\""+
		"play=\"true\""+
		"loop=\"false\""+
		"quality=\"high\""+
		"bgcolor=\"#FFFFFF\""+
		"allowScriptAccess=\"sameDomain\""+
		"type=\"application/x-shockwave-flash\""+
		"pluginspage='http://www.adobe.com/go/getflashplayer'>"+
		"</embed>"+
		"</object>";
	videoFrame.innerHTML = swf_str;
	videoFrame.style.display = "";
	document.getElementById("FlahLayer").style.display = "";
	document.getElementById("div_info").style.display = "";
	document.getElementById("DemoImgLayer").style.display = "none";
	//document.getElementById("demo_msg").style.display = "";
	//document.getElementById("demo_msg").innerHTML = "<font class='mag_info'>"+top.str_demo+"</font>";
	document.getElementById("team").innerHTML = "<font class='mag_info'>"+top.str_demo+"</font>";
}

//=== 傳遞參數
function appInit() {
	liveTV.FLashFunction(langx);
}

//window.onbeforeunload = unload_swf;
function unload_swf() {
	var obj=document.getElementById("liveTV");
	try {
		obj.unloadSWF();
	} catch (e) {}
	for (var x in obj){
		try{
			obj[x]=null;
		}catch(e){}
	}
}

function unLoad() {
	clearInterval(AutoRenewID);
	clearInterval(ChkUserTimerID);
	clearInterval(ChkGameDataTimer);
}
/**
 * 賽程列表
 */
function reload_game() {
	if(!GameData){
		document.getElementById("even_none").style.display ="";
		document.getElementById("even_list").style.display ="none";
	}else{
		document.getElementById("even_none").style.display ="none";
	}
	//var shows = document.getElementById("tb_layer").innerHTML;

	GameData=mySort(GameData,2);

	var shows = '';
	var shows_all = '';
	var tr_data = "";
	var tem_data = "";
	var tr_date = '';
	for (var i = 0; i < GameData.length; i++) {
		var game_date = GameData[i][2].split(" ");
		//tr_data+= showlayer(document.getElementById("tr_layer").innerHTML,i)+"\n";
		if(document.all){
			tem_data = showlayer(document.getElementById("tr_layer").innerText,i)+"\n";
		} else{
			tem_data = showlayer(document.getElementById("tr_layer").textContent,i)+"\n";
		}
		if(tr_date == '')tr_date = game_date[0];
		if(tr_date != game_date[0]){
			if(tr_date){
				if(document.all){
					shows=document.getElementById("tb_layer").innerText; //ie支援
				} else{
					shows=document.getElementById("tb_layer").textContent; //firefox支援
				}
				shows = shows.replace("*GAME_DATE*",tr_date);
				shows = shows.replace("*GAME_LIST*",tr_data);
				shows_all += shows;
				tr_data = tem_data;
			}
			tr_date = game_date[0];
		}else{
			tr_data += tem_data;
		}

	}
	keep_date="";
	$("#showlayers").html(shows_all);
	ResetTimer();

	if(eventlive=="Y"){
		//alert(eventlive);
		eventlive="";
		OpenTVbet(eventid);
	}

}
var keep_date="";
function showlayer(layers,i){
	var gtype_class = '';
	var game_date = GameData[i][2].split(" ");
	layers = layers.replace("*ID*",i);
	layers = layers.replace("*ID*",i);
	layers = layers.replace("*ID*",i);
	layers = layers.replace("*ID*",i);
	layers = layers.replace("*TEAMH*",GameData[i][3]);
	layers = layers.replace("*TEAMC*",GameData[i][4]);
	$c = 'sc';
	switch (GameData[i][0]){
		case 'BK': $c = 'bk';break;
		case 'TN': $c = 'tn';break;
		case 'VB': $c = 'vb';break;
		case 'BM': $c = 'bm';break;
		case 'TT': $c = 'tt';break;
		case 'BS': $c = 'bs';break;
		case 'OT': $c = 'ot';break;
		case 'SK': $c = 'sk';break;
		case 'FT': $c = 'sc';break;
	}
	if (GameData[i][6] == "Y") {	//判斷是否開賽
		gtype_class = 'class = "live_'+$c+'_nomal"';
		layers = layers.replace("*TIME*","");
		layers = layers.replace("*LIVE_TV_CLASS*",'class="live_tv_nomal"');
		layers = layers.replace("*LIVE_TXT_CLASS*",'class="live_txt_nomal"');
		layers = layers.replace("*onclick*",'onClick="OpenTV('+i+');"');
		layers = layers.replace("*LIVE_GTYPE_CLASS*",gtype_class);
	} else {
		gtype_class = 'class="live_'+$c+'_off"';
		layers = layers.replace("*TIME*",game_date[1]);
		layers = layers.replace("*LIVE_TV_CLASS*",'class="live_tv_off"');
		layers = layers.replace("*LIVE_TXT_CLASS*",'class="live_txt_off"');
		layers = layers.replace("*onclick*",'');
		layers = layers.replace("*LIVE_GTYPE_CLASS*",gtype_class);
	}

	return layers;
}

function OpenTV(i) {
	eventid = GameData[i][1];

	videoData = GameData[i][1]+","+GameData[i][3]+","+GameData[i][4]+","+GameData[i][9]+","+GameData[i][7]+","+GameData[i][8]+","+GameData[i][11]+","+GameData[i][12]+","+GameData[i][0];
	document.getElementById("FlahLayer").style.display = "";
	document.getElementById("DemoImgLayer").style.display = "none";
	var videoVersion = GameData[i][13];
	if(videoVersion =="perform"){
		document.getElementById("DefLive").style.display = "";
		document.getElementById("div_fake").style.display = "none";
		//StartChkTimer();
		try{
			DefLive.self.location="./getVideoFMS.php?uid="+uid+"&langx="+langx+"&gameary="+GameData[i][1]+"&liveid="+GameData[i][2];
		}catch(e){
			DefLive.src="./getVideoFMS.php?uid="+uid+"&langx="+langx+"&gameary="+GameData[i][1]+"&liveid="+GameData[i][2];
		}
	}else if(videoVersion == "unas"){
		reloadgame.self.location = "./unasVideo.php?uid="+uid+"&langx="+langx+"&gameary="+GameData[i][1];
	}else if(videoVersion == "img"){
		reloadgame.self.location = "./imgVideo.php?uid="+uid+"&langx="+langx+"&gameary="+GameData[i][1];
	}else{
		document.getElementById("DefLive").style.display = "none";
		document.getElementById("div_fake").style.display = "";
	}
	gtype=GameData[i][0];
	gidm=GameData[i][10];
	Livegtype= GameData[i][0];
	Livegidm = GameData[i][10];
	reloadioratio();
	hide_bet_ps();
}

function OpenTVbet(eventid) {
	document.getElementById("DemoLink").style.display = "none";
	if (eventid == "") { return false; }
	for (var i = 0; i < GameData.length; i++){
		//alert(GameData[i].length-1);
		if(GameData[i][1]==eventid){
			videoData = GameData[i][1]+","+GameData[i][3]+","+GameData[i][4]+","+GameData[i][9]+","+GameData[i][7]+","+GameData[i][8]+","+GameData[i][11]+","+GameData[i][12]+","+GameData[i][0]+","+GameData[i][13];
			Livegtype= GameData[i][0];
			Livegidm = GameData[i][10];
			gtype=GameData[i][0];
			gidm=GameData[i][10];
		}
	}
	StartChkTimer();

	var tmpAry=videoData.split(",");
	//registLive.self.location="./RegistLive.php?uid="+uid+"&langx="+langx+"&gameary="+eventid+"&liveid="+mtvid;
	if(tmpAry[9]=="perform"){
		try{
			reloadgame.self.location="./RegistLive.php?uid="+uid+"&langx="+langx+"&gameary="+eventid+"&liveid="+mtvid;
		}catch(e){
			reloadgame.src="./RegistLive.php?uid="+uid+"&langx="+langx+"&gameary="+eventid+"&liveid="+mtvid;
		}
	}else{
		document.getElementById("DefLive").style.display = "none";
		document.getElementById("div_fake").style.display = "";
	}
	reloadioratio();
	//go_betpage();
	show_bet_ps();
	close_bet();
}
function close_bet(){
	//bet_order_frame.location.replace("");
	document.getElementById('bet_order_frame').height =0;
	document.getElementById("bet_order_frame").style.display = "none";
	parent.document.getElementById("bet_div").style.display = "none";
	//bet_order_frame.document.close();
}


// --------------------------------------------------
// function getFlashMovie
// this function gets the correct flash object
// --------------------------------------------------
function getFlashMovie(movieName){
	if(document.all){
		return document.getElementById("myFlashPlayer");
	}else{
		return document.getElementById("myFlashPlayer_em");
	}
	//var isIE = navigator.appName.indexOf("Microsoft") != -1;
	//return (isIE) ? window[movieName] : document[movieName];
}
// --------------------------------------------------
// function RefreshStream(streamId)
// this function sends the streaming url to our
// flashplayer
// --------------------------------------------------
function RefreshStream(streamId) {

	var movie = getFlashMovie("myFlashPlayer");
	//alert("RefreshStream="+movie);
	// --------------------------------------------------
	// IMPORTANT
	// --------------------------------------------------
	// the stream url is only avaible for 30 seconds
	// so you have to implement an ajax call to generate
	// a valide stream url
	//
	// in this example this procedure is simmulated with
	// the static function getNewStreamUrl(streamid)
	// --------------------------------------------------
	movieUrl = getNewStreamUrl(streamId);
	// --------------------------------------------------

	movie.SetNewStream(movieUrl);
}
// --------------------------------------------------
// function getNewStreamUrl(streamId)
// this function is a placeholder for an example
// call in the RefreshStream() function
// --------------------------------------------------
function getNewStreamUrl(streamId){
	//alert(unasURL);
	var url = unasURL;
	//alert("getNewStreamUrl==>"+url)
	return(url);
}
function SetClothesColor(color_h, color_c) {
	if (color_h == "") {
		T_color_h = color_h;
		document.getElementById("all_serve_h").style.display = "none";
	}
	if (color_c == "") {
		T_color_c = color_c;
		document.getElementById("all_serve_c").style.display = "none";
	}
	if (T_color_h != color_h && color_h != "") {
		T_color_h = color_h;
		document.getElementById("all_serve_h").className = 'live_Icon_'+T_color_h;
		document.getElementById("all_serve_h").style.display = "";
	}
	if (T_color_c != color_c && color_c != "") {
		T_color_c = color_c;
		document.getElementById("all_serve_c").className = 'live_Icon_'+T_color_c;
		document.getElementById("all_serve_c").style.display = "";
	}
}

function chg_page(tmppage){
	//chg_page_images(tmppage);
	chg_page_height();
}
function chg_page_images(tmppage){
	if(tmppage =='TVbut'){
		document.getElementById("BEbut").src ="/images/member/"+langx+"/live_BEbut3.gif";
		document.getElementById("TVbut").src ="/images/member/"+langx+"/live_TVbut.gif";
	}else if(tmppage =='BEbut'){
		document.getElementById("BEbut").src ="/images/member/"+langx+"/live_BEbut.gif";
		document.getElementById("TVbut").src ="/images/member/"+langx+"/live_TVbut3.gif";
	}else{
		document.getElementById("BEbut").src ="/images/member/"+langx+"/live_BEbut3.gif";
		document.getElementById("TVbut").src ="/images/member/"+langx+"/live_TVbut.gif";
	}
}
function chg_page_height(){
	live_game_heigth();
}
function mouseEnter_pointer(tmp){
	try{
		//document.getElementById(tmp).src ="";
	}catch(E){}
}

function mouseOut_pointer(tmp){
	try{
		//document.getElementById(tmp).src ="none";
	}catch(E){}
}


function live_order_height(tmppage){
	document.all("bet_order_frame").height = tmppage * 1+5;
}

function live_game_heigth(){
	tmpEnd =window.frames["Live_mem"].document.body.scrollHeight+5;
	document.getElementById("Live_mem").height=tmpEnd;
}

function go_betpage(){
	eventlive ="";
	is_box_none = 0;
	hide_bet_ps();
	chg_page_height();
	try{
		close_bet();
	}catch(E){}
}

function go_livepage(){
	eventlive ="";
	show_bet_ps();
}

function close_bet_finish(){
	bet_order_frame.location.replace("");
	document.getElementById('bet_order_frame').height =0;
	//bet_order_frame.document.close();
	//document.getElementById("bet_ps").style.display = "none";
}

function onloadSet(w,h,frameName){
	//document.getElementById(frameName).width  =245;
	document.getElementById(frameName).height =h;
	//document.getElementById(frameName).height =311;
	//document.getElementById('pls_bet').style.display="none";

}

function check_browser(){
	var browser = "";
	var b_name = navigator.userAgent.toLowerCase();
	if(b_name.match(/msie/i) == "msie"){
		browser=b_name.match(/msie/i);
	}else if(b_name.match(/firefox/i) == "firefox"){
		browser=b_name.match(/firefox/i);
	}else if(b_name.match(/chrome/i) == "chrome"){
		browser=b_name.match(/chrome/i);
	}else if(b_name.match(/safari/i) == "safari"){
		browser=b_name.match(/safari/i);
	}
	return browser;
}

function reloadscore(){
	if(eventid !=""){
		for (var i = 0; i < parent.GameData.length; i++){
			if(parent.GameData[i][1]==eventid){
				if(parent.GameData[i][0] == "FT"){
					document.getElementById("team").innerHTML = parent.GameData[i][3]+"&nbsp;"+parent.GameData[i][11]+"&nbsp; - &nbsp;"+parent.GameData[i][12]+"&nbsp;"+parent.GameData[i][4];
					SetClothesColor(GameData[i][7],GameData[i][8]);
				}
			}
		}
	}
}

function mySort(ary,keyNo){
	ary.sort(function(a,b){return sortMethod(a,b,keyNo)});
	return ary;
}

function sortMethod(a,b,keyNo){
	return a[keyNo].localeCompare(b[keyNo]);
}
function showGameList(){
	$("#time_list").toggle();
}
function showOpenLive(){
	parent.showLive();
}
function tv_open(){
	$("#div_body").toggle();
	if($("#div_body").is(":hidden"))
		$("#ctl_tv").attr("class","off");
	else
		$("#ctl_tv").attr("class","on");
}

function GetVideo(vurl) {
	clearVideo();
	if (vurl != "") {
		document.getElementById("DefLive").src = vurl;
		document.getElementById("DefLive").style.display = "";
		document.getElementById("FlahLayer").style.display = "";
		document.getElementById("DemoImgLayer").style.display = "none";

		// 视频标题
		get_tmp();
	}else{
		document.getElementById("div_fake").style.display = "";
	}
}

//img
function GetVideoImg(url){
	clearVideo();
	if (url != "") {
		document.getElementById("DefLive").src = url;
		document.getElementById("DefLive").style.display = "";
		var width = '100%';
		var height = '270px';
		if(isonload_TV != "Y"){
			height = '270px';
		}
		document.getElementById("DefLive").style.width = width;
		document.getElementById("DefLive").style.height = height;
		document.getElementById("FlahLayer").style.display = "";
		document.getElementById("div_fake").style.display = "none";
		document.getElementById("DemoImgLayer").style.display = "none";

		// 视频标题
		get_tmp();
	}else{
		document.getElementById("div_fake").style.display = "";
	}
}

//unas
function GetVideoUnas(url){
	clearVideo();
	if (url != "") {
		objstr='<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" id = "myFlashPlayer" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="480" height="408">';
		objstr+='<param name = movie      value="unasplayer.swf?src='+url+'">';
		objstr+='<param name = quality    value="high">';
		objstr+='<param name = bgcolor    value="black">';
		objstr+='<param name = loop       value="false">';
		objstr+='<param name = wmode      value="transparent">';
		objstr+='<param name = FlashVars  value="secretdebug=false">';
		objstr+='<EMBED	';
		objstr+='src         = "unasplayer.swf?src='+url+'"';
		objstr+='id          = "myFlashPlayer_em"';
		// 2017-02-21 第二張圖會一下就又變正常
		var width = '480';
		var height = '408';
		if(isonload_TV != "Y"){
			width = '300';height = '300';
		}
		objstr+="width = "+width;
		objstr+="height = "+height;
		objstr+='allowscale  = "true"';
		objstr+='quality     = "high" ';
		objstr+='bgcolor     = "black" ';
		objstr+='loop        = "false"';
		objstr+='wmode      = "transparent"';
		objstr+='FlashVars   = "secretdebug=false"';
		objstr+='type        = "application/x-shockwave-flash"';
		objstr+='pluginspage = "http://www.macromedia.com/go/getflashplayer">';
		objstr+='</EMBED>';
		objstr+='</OBJECT>';

		document.getElementById("videoFrame").innerHTML = objstr;
		document.getElementById("videoFrame").style.display = "";
		document.getElementById("FlahLayer").style.display = "";
		document.getElementById("div_fake").style.display = "none";
		document.getElementById("DemoImgLayer").style.display = "none";

		// 视频标题
		get_tmp();
	}else{
		document.getElementById("div_fake").style.display = "";
	}

}

/**
 * 视频标题
 */
function get_tmp(){
	var tmp = videoData.split(",");
	document.getElementById("div_info").style.display = "";
	document.getElementById("info_all").style.display = "";
	//=== 隊名
	SetClothesColor(tmp[4], tmp[5]);
	document.getElementById("all_point_h").innerHTML = tmp[6];
	document.getElementById("all_point_c").innerHTML = tmp[7];
	document.getElementById("all_team_h").innerHTML = tmp[1];
	document.getElementById("all_team_c").innerHTML = tmp[2];
}
function clearVideo(){
	clearInterval(ChkGameDataTimer);

	document.getElementById("div_fake").style.display = "none";
	document.getElementById("videoFrame").innerHTML = "";
	document.getElementById("videoFrame").style.display = "none";
	document.getElementById("div_info").style.display = "none";
	document.getElementById("FlahLayer").style.display = "none";
	document.getElementById("DemoImgLayer").style.display = "";

	document.getElementById("DefLive").style.display = "none";
	document.getElementById("DefLive").src = "about:blank";
}

function show_bet_ps(){
	document.getElementById("time_list").style.display = "";
	document.getElementById("bet_box").style.display = "none";
	if(isonload_TV == "Y")document.getElementById("no_bet_head").style.display = "none";
}

function hide_bet_ps(){
	document.getElementById("time_list").style.display = "none";
	document.getElementById("bet_box").style.display = "";
	if(isonload_TV == "Y")document.getElementById("no_bet_head").style.display = "";
}
