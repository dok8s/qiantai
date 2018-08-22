var today_count=0;
var early_count=0;
var chgSite_sw = true; //switch old site or new site
var urlHash = new Object();
//var changebtn="rb";
//var headerClass = new Object();


//try{
//parent = window;
/*
 if (""+top.cgTypebtn=="undefined"){
 top.cgTypebtn="re";
 }

 if (""+top.head_gtype=="undefined"){
 top.head_gtype="FT";
 }
 if (""+top.head_FU=="undefined"){
 top.head_FU="FT";
 }
 if (""+top.head_btn=="undefined"){
 top.head_btn="today";
 }
 */
//showGtype = top.gtypeShowLoveI;
//var xx=showGtype.length;
//initDate();
//showGtype = top.gtypeShowLoveI;
//}catch(e){

//}


function initHeader(){
	if(top.load_order){
		setTimeStart(top.init_date);
		reloadCrditFunction();
	}

	initDivBlur_header(document.getElementById('div_langx'),document.getElementById('sel_div_langx'));
	initDivBlur_header(document.getElementById('div_help'),document.getElementById('sel_div_help'));
	initDivBlur_header(document.getElementById('div_acc'),document.getElementById('sel_div_acc'));
	document.getElementById('sel_div_langx').onclick=function(){
		//console.log("sel_div_langx is onClick");
		hideDiv('annou');
		divOnBlur(document.getElementById('div_langx'),document.getElementById('sel_div_langx'));
	}
	document.getElementById('sel_div_help').onclick=function(){
		hideDiv('annou');
		divOnBlur(document.getElementById('div_help'),document.getElementById('sel_div_help'));
	}
	document.getElementById('sel_div_acc').onclick=function(){
		hideDiv('annou');
		divOnBlur(document.getElementById('div_acc'),document.getElementById('sel_div_acc'));
	}
	/*
	 document.getElementById('head_annBTN').onclick=function(){

	 //document.getElementById('annou_div').style.display='';
	 divOnBlur(document.getElementById('annou_div'));
	 showAnnou();
	 }
	 */
	// 2017-02-24 褰堣烦锛达级鐩墠涓嶉爯瑷枊绗竴鍫�
	//top.select_type = "betlist";

	if(top.mem_status=="S"||top.showKR=="Y"){
		document.getElementById("head_live").style.display = "none";
		document.getElementById("head_live").onclick = null;
	}

	if(top.mem_status == "S"){
		document.getElementById("btn_result").style.display = "none";
		document.getElementById("btn_result").onclick = null;
		//2065.娓│姗�&uat&绶氫笂-鏂版渻鍝＄-鍙兘鐪嬪赋鏈冨摗鐧诲叆鑻辨枃瑾炵郴,鍙充笂瑙掔殑瑾炵郴鍦栨璁婇煋鏂囩殑(BGM-311)
		//document.getElementById("head_MINI").className = "head_OUTmenuS noFloat KR";
	}else{
		document.getElementById("btn_result").onclick=function(){
			showMyAccount('Results');
		}
	}


	document.getElementById("btn_openbets").onclick=function(){
		showMyAccount('OpenBets');
	}
	document.getElementById("btn_history").onclick=function(){
		showMyAccount('Statement');
	}


	display_loadingMain("head");

	setMemOnlineTimer();
	getAnnouCount();

	getChgUrlSW();
	if (top.casino != "SI2") {
		try{
			document.getElementById("live").style.display = "none";
			document.getElementById("QA_row").style.display = "none";
		}catch(E){}
	}

	if(top.head_btn=="rb"){
		try{
			document.getElementById("nav_re").style.display = "";
			document.getElementById("type_re").style.display = "";
			document.getElementById("nav").style.display = "none";
			document.getElementById("type").style.display = "none";
		}catch(E){}
	}else{
		try{
			document.getElementById("nav_re").style.display = "none";
			document.getElementById("type_re").style.display = "none";
			document.getElementById("nav").style.display = "";
			document.getElementById("type").style.display = "";
		}catch(E){}
	}


	try{
		var obj = document.getElementById(top.cgTypebtn+"");
		obj.className="type_on";
	}catch(E){}

	try{
		if((navigator.appVersion).indexOf("MSIE 6")==-1){
			document.getElementById("download").style.visibility="visible";
		}
	}catch(E){}
	try{
		document.getElementById("today_btn").className="today";
	}catch(E){}
	try{
		document.getElementById("early_btn").className="early";
	}catch(E){}
	try{
		document.getElementById("rb_btn").className="rb";
	}catch(E){}
	try{
		document.getElementById(top.head_btn+"_btn").className=top.head_btn+"_on";
		document.getElementById(top.RB_id).className="rb_menu_on";
	}catch(E){}
	try{
		document.getElementById("rb_btn").className="rb";
	}catch(E){}

	//鏇存柊淇＄敤椤嶅害   max---
	//reloadCrditFunction();
	//showTable();
	//GameType();

}
function initDivBlur_header(showdiv,selid){
	showdiv.tabIndex=100;
	showdiv.onblur=function(){
		showdiv.style.display='none';
		setTimeout(function(){
			selid.onclick=function(){
				//alert("onblur");
				hideDiv('annou');
				divOnBlur(showdiv,selid);
			}
		},300);
	};

}

function setChgSiteVisible(isShow){
	var dis = "none";
	/*
	 if(top.aspenbet=="Y"||util.isIPad()||top.showKR=="Y"){
	 dis = "none";
	 }else{
	 dis = (isShow)?"":"none";
	 }
	 */

	document.getElementById("chg_site").onclick = null;

	if(isShow){
		if(!(top.aspenbet=="Y"||util.isIPad()||top.showKR=="Y")){
			dis = "";
			document.getElementById("chg_site").onclick = chgSiteEvent;
		}
	}

	document.getElementById("chg_site").style.display = dis;

}

function getChgUrlSW(){

	var param = "";
	param+="uid="+top.uid;
	param+="&langx="+top.langx;
	param+="&code=getSW";

	var getHttp = new util.HttpRequest();
	getHttp.addEventListener("LoadComplete", function(html){

		if(html){
			var tmp = html.split(",");
			urlHash["sw"] = tmp[1];
			urlHash["domain"] = tmp[2];

			try{
				if(urlHash["sw"]=="Y"){
					setChgSiteVisible(true);
					//document.getElementById("chg_site").onclick = chgSiteEvent;
				}else{
					setChgSiteVisible(false);
					//document.getElementById("chg_site").onclick = null;
				}
			}catch(e){
				systemMsg(e.toString());
			}

		}else{
			setChgSiteVisible(false);
			//document.getElementById("chg_site").onclick = null;
		}

	});

	getHttp.loadURL(util.getNowDomain()+"/app/member/chgurl.php", "GET", param);
}

//switch old site or new site
function chgSiteEvent(){

	var param = "";
	param+="mtype="+top.mtype;
	param+="&uid="+top.uid;
	param+="&langx="+top.langx;
	param+="&chgURL_domain="+urlHash["domain"];
	param+="&ts="+new Date().getTime();
	param+="&code=goToDomain";

	if(!urlHash["domain"]) return;

	var getHttp = new util.HttpRequest();
	getHttp.addEventListener("LoadComplete", function(html){
		try{
			document.getElementById('showURL').innerHTML = html;
			var obj = document.getElementById('newdomain').submit();
		}catch(e){
			systemMsg(e.toString());
		}
	});

	getHttp.loadURL(util.getNowDomain()+"/app/member/chgurl.php", "GET", param);

}

function showOn(obj){
	obj.className += " On";
}

function showOut(obj){
	obj.className = obj.className.replace(" On","");
}

function chg_head(a,b,c){
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
	//鍔犲叆hot_game鍙冩暩鍊�
	hot_str="&hot_game="+top.hot_game;

	parent.body.location=a+"&league_id="+b+hot_str;

	//2015-07-23 Peter 閲嶇疆閬稿彇鑱洘
	//reload_leg();
}

function chg_index_head(a,b,c,d){
	top.RB_id="";
	top.hot_game="";
	top.swShowLoveI=false;
	top.cgTypebtn="re_class";
	var hot_str="";
	hot_str="&hot_game="+top.hot_game;
	if(top.head_gtype=="FT"){
		try{
			parent.mem_order.goEuro_HOT_btn("");
		}catch(E){}
	}
	parent.body.location.href=b+"&league_id="+c+hot_str;
	self.location.href=a;

	//2015-07-20 Peter 閲嶇疆閬稿彇鑱洘
	//reload_leg();
}

function chg_rb_index_head(a,b,c,d){
	top.RB_id="";
	top.head_FU="FT";
	top.hot_game="";
	top.swShowLoveI=false;
	top.cgTypebtn="re_class";
	var hot_str="";
	hot_str="&hot_game="+top.hot_game;
	if(top.head_gtype=="FT"){
		try{
			parent.mem_order.goEuro_HOT_btn("");
		}catch(E){}
	}
	parent.body.location.href=b+"&league_id="+c+hot_str;
	self.location.href=a;

}

//2015-07-20 Peter function 閲嶇疆閬稿彇鑱洘
function reload_leg(game_type){
	tmp_gtype = "";
	tmp_fs = "";
	switch(top.head_gtype){
		case "FT":
			tmp_gtype = (top.head_btn == "today" || top.head_btn == "rb")?"FT":"FU";
			break;
		case "BK":
			tmp_gtype = (top.head_btn == "today" || top.head_btn == "rb")?"BK":"BU";
			break;
		case "BS":
			tmp_gtype = (top.head_btn == "today" || top.head_btn == "rb")?"BS":"BSFU";
			break;
		case "TN":
			tmp_gtype = (top.head_btn == "today" || top.head_btn == "rb")?"TN":"TU";
			break;
		case "VB":
			tmp_gtype = (top.head_btn == "today" || top.head_btn == "rb")?"VB":"VU";
			break;
		case "BM":
			tmp_gtype = (top.head_btn == "today" || top.head_btn == "rb")?"BM":"BMFU";
			break;
		case "TT":
			tmp_gtype = (top.head_btn == "today" || top.head_btn == "rb")?"TT":"TTFU";
			break;
		case "OP":
			tmp_gtype = (top.head_btn == "today" || top.head_btn == "rb")?"OP":"OM";
			break;
		default:
			tmp_gtype = (top.head_btn == "today" || top.head_btn == "rb")?"FT":"FU";
			break;
	}
	try{
		if(top.head_gtype == "FT" && top.head_btn == "early" && top.cgTypebtn == "hp3_class"){
			tmp_gtype = "FT";
			parent[tmp_gtype+"_lid_type"] = '';
			parent[tmp_gtype+"_lid_ary"] = 'ALL';
			parent[tmp_gtype+"_lname_ary"] = 'ALL';
		}
		else{
			parent[tmp_gtype+"_lid_type"] = '';
			parent[tmp_gtype+"_lid_ary"] = 'ALL';
			parent[tmp_gtype+"_lname_ary"] = 'ALL';
			if(top.head_btn == "rb"){
				parent[tmp_gtype+"_lid_ary_RE"] = 'ALL';
				parent[tmp_gtype+"_lname_ary_RE"] = 'ALL';
			}
		}

		if(game_type == "fs_class"){
			top["FS"+top.head_gtype+"_lid"]["FS"+top.head_gtype+"_lname_ary"] = 'ALL';
			top["FS"+top.head_gtype+"_lid"]["FS"+top.head_gtype+"_lid_ary"] = 'ALL';
			parent["FS"+top.head_gtype+"_lid_ary"] = 'ALL';
			parent["FS"+top.head_gtype+"_lname_ary"] = 'ALL';
			parent.body.reload_var();
		}
	}catch(e){}
}





function changeLangx(setlangx){

	clearAllOpenWindow();
	//console.log("==>"+top.ShowLoveIarray["FTRE"]);
	if (top.langx!=setlangx){
		//initDate();鎻涜獮绯讳笉鐢ㄥ垵濮嬪寲鎴戠殑鏈€鎰�
		top.cgTypebtn="re_class";
		top.langx=setlangx;
		top.head_gtype="FT";
		top.head_FU="FT";
		top.head_btn="today";
		// 2017-08-02 3101.鏂版渻鍝＄-閬庨棞 鍒囨彌瑾炵郴鏅傜洡闈㈠簳鑹茶娓呮帀
		top.orderArray = new Array();
		top.ordergid = new Array();
		top.FT_lid = new Array();
		top.FU_lid = new Array();
		top.FSFT_lid = new Array();
		top.FT_lid['FT_lid_ary']= FT_lid_ary='ALL';
		top.FT_lid['FT_lid_type']= FT_lid_type='';
		top.FT_lid['FT_lname_ary']= FT_lname_ary='ALL';
		top.FT_lid['FT_lid_ary_RE']= FT_lid_ary_RE='ALL';
		top.FT_lid['FT_lname_ary_RE']= FT_lname_ary_RE='ALL';
		top.FU_lid['FU_lid_ary']= FU_lid_ary='ALL';
		top.FU_lid['FU_lid_type']= FU_lid_type='';
		top.FU_lid['FU_lname_ary']= FU_lname_ary='ALL';
		top.FSFT_lid['FSFT_lid_ary']= FSFT_lid_ary='ALL';
		top.FSFT_lid['FSFT_lname_ary']= FSFT_lname_ary='ALL';

		top.BK_lid = new Array();
		top.BU_lid = new Array();
		top.FSBK_lid = new Array();
		top.BK_lid['BK_lid_ary']= BK_lid_ary='ALL';
		top.BK_lid['BK_lid_type']= BK_lid_type='';
		top.BK_lid['BK_lname_ary']= BK_lname_ary='ALL';
		top.BK_lid['BK_lid_ary_RE']= BK_lid_ary_RE='ALL';
		top.BK_lid['BK_lname_ary_RE']= BK_lname_ary_RE='ALL';
		top.BU_lid['BU_lid_ary']= BU_lid_ary='ALL';
		top.BU_lid['BU_lid_type']= BU_lid_type='';
		top.BU_lid['BU_lname_ary']= BU_lname_ary='ALL';
		top.FSBK_lid['FSBK_lid_ary']= FSBK_lid_ary='ALL';
		top.FSBK_lid['FSBK_lname_ary']= FSBK_lname_ary='ALL';

		top.BS_lid = new Array();
		top.BSFU_lid = new Array();
		top.FSBS_lid = new Array();
		top.BS_lid['BS_lid_ary']= BS_lid_ary='ALL';
		top.BS_lid['BS_lid_type']= BS_lid_type='';
		top.BS_lid['BS_lname_ary']= BS_lname_ary='ALL';
		top.BS_lid['BS_lid_ary_RE']= BS_lid_ary_RE='ALL';
		top.BS_lid['BS_lname_ary_RE']= BS_lname_ary_RE='ALL';
		top.BSFU_lid['BSFU_lid_ary']= BSFU_lid_ary='ALL';
		top.BSFU_lid['BSFU_lid_type']= BSFU_lid_type='';
		top.BSFU_lid['BSFU_lname_ary']= BSFU_lname_ary='ALL';
		top.FSBS_lid['FSBS_lid_ary']= FSBS_lid_ary='ALL';
		top.FSBS_lid['FSBS_lname_ary']= FSBS_lname_ary='ALL';

		top.TN_lid = new Array();
		top.TU_lid = new Array();
		top.FSTN_lid = new Array();
		top.TN_lid['TN_lid_ary']= TN_lid_ary='ALL';
		top.TN_lid['TN_lid_type']= TN_lid_type='';
		top.TN_lid['TN_lname_ary']= TN_lname_ary='ALL';
		top.TN_lid['TN_lid_ary_RE']= TN_lid_ary_RE='ALL';
		top.TN_lid['TN_lname_ary_RE']= TN_lname_ary_RE='ALL';
		top.TU_lid['TU_lid_ary']= TU_lid_ary='ALL';
		top.TU_lid['TU_lid_type']= TU_lid_type='';
		top.TU_lid['TU_lname_ary']= TU_lname_ary='ALL';
		top.FSTN_lid['FSTN_lid_ary']= FSTN_lid_ary='ALL';
		top.FSTN_lid['FSTN_lname_ary']= FSTN_lname_ary='ALL';

		top.VB_lid = new Array();
		top.VU_lid = new Array();
		top.FSVB_lid = new Array();
		top.VB_lid['VB_lid_ary']= VB_lid_ary='ALL';
		top.VB_lid['VB_lid_type']= VB_lid_type='';
		top.VB_lid['VB_lname_ary']= VB_lname_ary='ALL';
		top.VB_lid['VB_lid_ary_RE']= VB_lid_ary_RE='ALL';
		top.VB_lid['VB_lname_ary_RE']= VB_lname_ary_RE='ALL';
		top.VU_lid['VU_lid_ary']= VU_lid_ary='ALL';
		top.VU_lid['VU_lid_type']= VU_lid_type='';
		top.VU_lid['VU_lname_ary']= VU_lname_ary='ALL';
		top.FSVB_lid['FSVB_lid_ary']= FSVB_lid_ary='ALL';
		top.FSVB_lid['FSVB_lname_ary']= FSVB_lname_ary='ALL';

		top.BM_lid = new Array();
		top.BMFU_lid = new Array();
		top.FSBM_lid = new Array();
		top.BM_lid['BM_lid_ary']= BM_lid_ary='ALL';
		top.BM_lid['BM_lid_type']= BM_lid_type='';
		top.BM_lid['BM_lname_ary']= BM_lname_ary='ALL';
		top.BM_lid['BM_lid_ary_RE']= BM_lid_ary_RE='ALL';
		top.BM_lid['BM_lname_ary_RE']= BM_lname_ary_RE='ALL';
		top.BMFU_lid['BMFU_lid_ary']= BMFU_lid_ary='ALL';
		top.BMFU_lid['BMFU_lid_type']= BMFU_lid_type='';
		top.BMFU_lid['BMFU_lname_ary']= BMFU_lname_ary='ALL';
		top.FSBM_lid['FSBM_lid_ary']= FSBM_lid_ary='ALL';
		top.FSBM_lid['FSBM_lname_ary']= FSBM_lname_ary='ALL';

		top.TT_lid = new Array();
		top.TTFU_lid = new Array();
		top.FSTT_lid = new Array();
		top.TT_lid['TT_lid_ary']= TT_lid_ary='ALL';
		top.TT_lid['TT_lid_type']= TT_lid_type='';
		top.TT_lid['TT_lname_ary']= TT_lname_ary='ALL';
		top.TT_lid['TT_lid_ary_RE']= TT_lid_ary_RE='ALL';
		top.TT_lid['TT_lname_ary_RE']= TT_lname_ary_RE='ALL';
		top.TTFU_lid['TTFU_lid_ary']= TTFU_lid_ary='ALL';
		top.TTFU_lid['TTFU_lid_type']= TTFU_lid_type='';
		top.TTFU_lid['TTFU_lname_ary']= TTFU_lname_ary='ALL';
		top.FSTT_lid['FSTT_lid_ary']= FSTT_lid_ary='ALL';
		top.FSTT_lid['FSTT_lname_ary']= FSTT_lname_ary='ALL';

		top.OP_lid = new Array();
		top.OM_lid = new Array();
		top.FSOP_lid = new Array();
		top.OP_lid['OP_lid_ary']= OP_lid_ary='ALL';
		top.OP_lid['OP_lid_type']= OP_lid_type='';
		top.OP_lid['OP_lname_ary']= OP_lname_ary='ALL';
		top.OP_lid['OP_lid_ary_RE']= OP_lid_ary_RE='ALL';
		top.OP_lid['OP_lname_ary_RE']= OP_lname_ary_RE='ALL';
		top.OM_lid['OM_lid_ary']= OM_lid_ary='ALL';
		top.OM_lid['OM_lid_type']= OM_lid_type='';
		top.OM_lid['OM_lname_ary']= OM_lname_ary='ALL';
		top.FSOP_lid['FSOP_lid_ary']= FSOP_lid_ary='ALL';
		top.FSOP_lid['FSOP_lname_ary']= FSOP_lname_ary='ALL';
		top.head_btn="today";

		top.SK_lid = new Array();
		top.SKFU_lid = new Array();
		top.FSSK_lid = new Array();
		top.SK_lid['SK_lid_ary']= OP_lid_ary='ALL';
		top.SK_lid['SK_lid_type']= OP_lid_type='';
		top.SK_lid['SK_lname_ary']= OP_lname_ary='ALL';
		top.SK_lid['SK_lid_ary_RE']= OP_lid_ary_RE='ALL';
		top.SK_lid['SK_lname_ary_RE']= OP_lname_ary_RE='ALL';
		top.SKFU_lid['SKFU_lid_ary']= OM_lid_ary='ALL';
		top.SKFU_lid['SKFU_lid_type']= OM_lid_type='';
		top.SKFU_lid['SKFU_lname_ary']= OM_lname_ary='ALL';
		top.FSSK_lid['FSSK_lid_ary']= FSOP_lid_ary='ALL';
		top.FSSK_lid['FSSK_lname_ary']= FSOP_lname_ary='ALL';
		top.mail_forbid = false;



		//console.log(((""+self.location).replace("zh-tw",setlangx).replace("zh-cn",setlangx).replace("en-us",setlangx).replace("ko-kr",setlangx)));
		self.location.href=((""+self.location).replace("zh-tw",setlangx).replace("zh-cn",setlangx).replace("en-us",setlangx).replace("ko-kr",setlangx));

	}

}

function setMemOnlineTimer(){
	setInterval("chkMemOnline()",60*1000);
	setInterval("getAnnouCount()",60*1000*5);
}


function chkMemOnline(){
	memOnline.location.href="./mem_online.php?uid="+top.uid;
}

function getAnnouCount(){

	var getHTML = new HttpRequestXML();
	getHTML.addEventListener("LoadComplete", loadAnnouCount);
	getHTML.loadURL(util.getNowDomain()+"/app/member/account/scroll_history.php","POST", "uid="+top.uid+"&langx="+top.langx+"&type=scroll_count");
	//annouCount.location.href="./;
}

function loadAnnouCount(xml){
	//trace("loadAnnouCount: "+xml);
	var xmlObj = new Object();
	xmlnode = new XmlNode(xml.getElementsByTagName("serverresponse"));
	xmlnodeRoot = xml.getElementsByTagName("serverresponse")[0];
	xmlObj["count"] = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlnodeRoot,"count")));
	trace("loadAnnouCount==>count: "+xmlObj["count"] );
	document.getElementById('count_ann').style.display='none';
	document.getElementById('head_annBTN').className = "head_annBTN";
	if(xmlObj["count"] > 0 ){
		document.getElementById('count_ann').style.display='';
		document.getElementById('count_ann').innerHTML=xmlObj["count"];
		document.getElementById('head_annBTN').className = "head_annGIF";
	}


}
/*婊剧悆鎻愮ず--灏噂etrecRB.php鐨勭祼鏋滃付閫插幓,鍘诲垽鏂锋槸鍚ecord_RB鏄惁澶ф柤0,濡傛灉鏈夋渻椤ず婊剧悆鍦栫ず*/

function showLayer(record_RB){

	document.getElementById('RB_games').innerHTML=record_RB;
	document.getElementById('FT_games').innerHTML=0;
	document.getElementById('BK_games').innerHTML=0;
	document.getElementById('TN_games').innerHTML=0;
	document.getElementById('BS_games').innerHTML=0;
	document.getElementById('VB_games').innerHTML=0;
	document.getElementById('BM_games').innerHTML=0;
	document.getElementById('OP_games').innerHTML=0;


	reloadCrditFunction();

}

//-----------------鏅傞嵕------------------姣忕椤ず
var nowTimer=0;
var stimer=0;
function autoZero(val){
	if (val<10){
		return "0"+val;
	}
	return val;
}

var monthAry=new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
function showTimer(){
	//alert(nowTimer);
	nowTimer+=1000;
	var now=new Date(nowTimer);
	//document.getElementById('head_date').innerHTML=now.toString();
	try{

		if (top.langx=="en-us"){
			tmp_year = now.getFullYear();
			tmp_month = monthAry[now.getMonth()];
			tmp_day = now.getDate();
		}else{
			tmp_year = now.getFullYear()+top["showyear"];
			tmp_month = (now.getMonth()+1)+top["showmonth"];
			tmp_day = now.getDate()+top["showday"];
		}

		document.getElementById('head_year').innerHTML=tmp_year;
		document.getElementById('head_month').innerHTML=tmp_month;
		document.getElementById('head_day').innerHTML=tmp_day;
		document.getElementById('head_hour').innerHTML=autoZero(now.getHours());
		document.getElementById('head_min').innerHTML=autoZero(now.getMinutes());
		//document.getElementById('head_sec').innerHTML=autoZero(now.getSeconds());
		document.getElementById('head_date').style.display='';
	}catch(E){}
}
function setTimeStart(now){
	clearInterval(stimer);
	var today=now.split(" ");
	//top.today_gmt=today[0];
	//top.now_gmt=today[1];
	var today_date=today[0].split("-");
	var today_time=today[1].split(":");

	//alert(new Date(today_date[0],today_date[1]-1,today_date[2],today_time[0],today_time[1],today_time[2],0));
	nowTimer=(new Date(today_date[0],today_date[1]-1,today_date[2],today_time[0],today_time[1],today_time[2],0)).getTime();
	showTimer();
	stimer=setInterval("showTimer()",1000);
}
//-----------------------------------------------------------



function  getdomain(){
	var a = new Array();
	a[0]= document.domain;
	ESTime.setdomain(a);
	return a;
}
function OnMouseOverEvent() {
	//document.getElementById("informaction").style.display = "block";
}
function OnMouseOutEvent() {
	//document.getElementById("informaction").style.display = "none";
}

function chgPass(){
	Real_Win=window.open("../../../app/member/account/chg_passwd.php?uid="+top.uid+"&langx="+top.langx,"Chg_pass","width=530,height=688,status=no,location=no");
	Real_Win.focus();
}


function mouseEnter_pointer(tmp){
	try{
		var tmp1 = tmp.split("_")[1];
		var txtnum = top.ShowLoveIarray[tmp1].length;
		if(txtnum !=0)
			document.getElementById(tmp).style.display ="block";
	}catch(E){}
}

function mouseOut_pointer(tmp){
	try{
		document.getElementById(tmp).style.display ="none";
	}catch(E){}
}

//top.swShowLoveI=false;
//window.onscroll =chkscrollShowLoveI;

function hrefs(){
	window.open("./getVworld.php?langx="+top.langx+"&uid="+top.uid,"Vworld","width=780,height=580,top=0,left=0,status=no,toolbar=no,scrollbars=yes,resizable=no,personalbar=no");
}

//鏇存柊淇＄敤椤嶅害max
function reloadCrditFunction(){
	reloadPHP1.location.href='reloadCredit.php?uid='+top.uid+'&langx='+top.langx;
}
function reloadCredit(cash){
	var tmp=cash.split(" ");
	top.mcurrency=tmp[0];
	document.getElementById("credit").innerHTML=cash;
}

function openOther(url){
	//memOnline.location.replace(url);
	window.open(URL);
}

function Go_RB_page(RBgtype){
	var protocol = document.location.protocol;
	top.hot_game="";
	top.RB_id="RB_"+RBgtype;

	//2015-07-20 Peter 閲嶇疆閬稿彇鑱洘
	//reload_leg();
	self.header.location.href=protocol+"//"+document.domain+"/app/member/"+RBgtype+"_header.php?uid="+top.uid+"&showtype=&langx="+top.langx+"&mtype="+top.mtype;
	self.body.location.href=protocol+"//"+document.domain+"/app/member/"+RBgtype+"_browse/index.php?rtype=re&uid="+top.uid+"&langx="+top.langx+"&mtype="+top.mtype+"&showtype="+top.showtype+"&hot_game="+top.hot_game;
}

function Go_FU_RB_page(RBgtype){
	var protocol = document.location.protocol;
	top.head_FU="FT";
	top.hot_game="";
	top.RB_id="RB_"+RBgtype;

	self.header.location.href=protocol+"//"+document.domain+"/app/member/"+RBgtype+"_header.php?uid="+top.uid+"&showtype=&langx="+top.langx+"&mtype="+top.mtype;
	self.body.location.href=protocol+"//"+document.domain+"/app/member/"+RBgtype+"_browse/index.php?rtype=re&uid="+top.uid+"&langx="+top.langx+"&mtype="+top.mtype+"&showtype="+top.showtype+"&hot_game="+top.hot_game;
}

function change_group(gtype,grp,lid_type){
	var protocol = document.location.protocol;
	top.RB_id="";
	top.hot_game="";
	if(top.swShowLoveI) lid_type=3;
	if(top.showtype=='hgft') lid_type=3;
	var hot_str="";

	//鍔犲叆hot_game鍙冩暩鍊�
	hot_str="&hot_game="+top.hot_game;
	var url=protocol+"//"+document.domain+"/app/member/"+gtype+"_browse/index.php?rtype="+grp+"&uid="+top.uid+"&langx="+top.langx+"&mtype="+top.mtype+"&showtype="+top.showtype;

	trace(url+"&league_id="+lid_type+hot_str);
	self.body.location=url+"&league_id="+lid_type+hot_str;
}

function hideDiv(divname){
	document.getElementById(divname).style.display = "none";
	if(divname == "annou"){
		getAnnouCount();
		document.getElementById("head_ann_arr").style.display="none";
	}

}

//show div
function showDiv(divname){
	trace("showDiv: "+divname);

	var ary = new Array("div_acc","div_langx","div_help","annou");
	for(var i=0; i<ary.length; i++){
		var _name = ary[i];

		var div = document.getElementById(_name);
		if(div != null){
			if(_name == divname){
				var _status = div.style.display;
				if(_name == "annou"){
					showAnnou();
				}else{
					div.style.display = (_status=="")?"none":"";
				}
				if(_name == "annou" && div.style.display=="none")	{
					getAnnouCount();
					document.getElementById("head_ann_arr").style.display = "none";
				}
			}else{
				div.style.display = "none";
				if(_name == "annou")	{
					getAnnouCount();
					document.getElementById("head_ann_arr").style.display = "none";
				}
			}
		}
	}
}

function showAnnou(){
	var div = document.getElementById("annou");

	var div_ann = document.getElementById("head_ann_arr");
	if(div!=null){
		var _status = div.style.display;
		div.style.display = (_status=="")?"none":"";
		div_ann.style.display = (_status=="")?"none":"";
	}

	if(div.style.display == "") annou.location.href="./account/scroll_history.php?uid="+top.uid+"&langx="+top.langx+"&type=scroll_header&t_important=1";

}

//show/hide balance
function setBalanceVisible(isShow){
	trace("setBalanceVisible: "+isShow);


	var showObj = document.getElementById("show_balance");
	var hideObj = document.getElementById("hide_balance");
	var credit = document.getElementById("credit");
	var head_cre = document.getElementById("head_cre");

	var showDis = (isShow)?"none":"";
	var hideDis = (isShow)?"":"none";
	var setClass = (isShow)?"":"head_hideCre";

	if(showObj!=null) showObj.style.display=showDis;
	if(hideObj!=null) hideObj.style.display=hideDis;
	if(credit!=null) credit.style.display=hideDis;

	if(head_cre!=null) head_cre.className=setClass;
}

//log out
function logOut(_url){
	trace("logOut: "+_url);
	top.location.href = _url
}

//my account
function showMyAccount(type){
	try{
		if(top.newWinObj["account"]!=undefined && top.newWinObj["account"].mail_forbid){
			if(confirm(top["str_Quit_MailSet"])==false){
				return false;
			}
		}
	}catch(e){}
	trace("showMyAccount: "+type);

	var hash = new Object();
	hash["setEmail"]	= "set_email";
	hash["ChgPass"]	= "chg_passwd";
	hash["OpenBets"]	= "today_wagers";
	hash["Statement"]	= "history_data";
	hash["Account"]	= "mem_conf";
	hash["Announcements"]	= "scroll_history";
	hash["Terms"]	= "terms";
	hash["Results"]	= "result";
	hash["Tutorials"]	= "tutorials";
	hash["NewFeatures"]	= "new_features";
	hash["OddsConversion"]	= "odds";
	hash["Contactus"]	= "contact_us";
	hash["Rules"]	= "sport_rules";

	_type = hash[type];
	if(_type==null){
		systemMsg("[type not find]"+type);
		return;
	}

	top.account_type = _type;


	var _url = util.getNowDomain()+"/app/member/account/index.php";
	var par = "width=900,height=650,status=no,location=no";
	try{
		if(!top.newWinObj["account"]){
			top.newWinObj["account"] = window.open(_url, "account", par);
		}else{
			top.newWinObj["account"].linkEvent(_type);
		}
	}catch(e){
		top.newWinObj["account"] = window.open(_url, "account", par);
	}
	top.newWinObj["account"].focus();
}



function checkOpenLiveExist(){
	var ret = false;
	if(top.newWinObj["Live"]){
		if(!top.newWinObj["Live"].closed){
			ret = true;
		}
	}
	return ret;
}

function clearAllOpenWindow(){
	for(var i in top.newWinObj){
		try{
			if(!top.newWinObj[i].closed){
				top.newWinObj[i].window.close();
			}
		}catch(e){}
	}
}

function systemMsg(msg){
	util.systemMsg("[header]"+msg);
}

function trace(msg){
	//util.trace("[header]"+msg);
}