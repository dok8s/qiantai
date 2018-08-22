var _mc;
var _set;
var ReloadTimeID = null;
var dangerTimer = "10000"; // 10秒reolad危險單
var dgRedirect = 0;
var pendingTid = "";
function init(){
	trace("init");

	_mc = new Object();
	_set = new Object();

	//_set["ReloadTimeID"] = null;
	//_set["run_retime"] = parent.myBetSec || 90;
	_set["ticket"] = new Object();
	_set["unsettled_count"] = 0;
	_set["settled_count"] = 0;
	_set["nowShow"] = document.getElementById("unord_setTitle").getAttribute("id");
	_set["win"] = "dark_GreenWord";
	_set["loss"] = "RedWord";
	_set["draw"] = "dark_grayWord";
	_set["icon_W"] = "ord_winIcon";
	_set["icon_L"] = "ord_lossIcon";
	_set["icon_P"] = "ord_darwIcon";
	_set["icon_D"] = "ord_cancelIcon";
	_set["icon_LL"] = "ord_loss_halfIcon";
	_set["icon_LW"] = "ord_win_halfIcon";
	_set["show_off"] = "ord_setTitle_off noFloat";
	_set["div_ord_main"]=parent.document.getElementById("div_ord_main");
  	_set["unsettled"]=null;
  	_set["settled"]=null;

	_set["unsettled_model"]=document.getElementById("unsettled_detail_model").innerHTML;
	_set["settled_model"]=document.getElementById("settled_detail_model").innerHTML;
	document.getElementById("unord_setTitle").onclick = function(){ showBets(this,"ord_setTitle"); }
	document.getElementById("ord_setTitle").onclick = function(){ showBets(this,"unord_setTitle"); }

	loadData();

	/*
	if(_set["ReloadTimeID"])	clearInterval(_set["ReloadTimeID"]);
	_set["ReloadTimeID"] = setInterval("loadData()",_set["run_retime"]*1000);
	*/
}

function showBets(targetObj,lastType){
	if(targetObj.getAttribute("id") == _set["nowShow"]){
		_set["nowShow"] = "";

		var nowUn = "un";
		if(targetObj.getAttribute("id") == "ord_setTitle")	nowUn = "";

		var noMyBet = "none";
		var setTxT = "none";
		var oldcss = "ord_setTitle";
		var newcss = "ord_setTitle_off";

		if(targetObj.className.indexOf("ord_setTitle_off") != -1){
			oldcss = "ord_setTitle_off";
			newcss = "ord_setTitle";
			noMyBet = "";

			if(_set[nowUn+"settled_count"] > 0){
				noMyBet = "none";
				setTxT = "";
			}
		}

		targetObj.className = targetObj.className.replace(oldcss,newcss);

		document.getElementById(nowUn+"ord_noMyBet").style.display = noMyBet;
		document.getElementById(nowUn+"ord_setTxT").style.display = setTxT;
		document.getElementById(nowUn+"ord_viewG").style.display = setTxT;
	}else{
		_set["nowShow"] = targetObj.getAttribute("id");

		var lastobj = document.getElementById(lastType);
		lastobj.className = lastobj.className.replace("ord_setTitle_off","tmp");
		lastobj.className = lastobj.className.replace("ord_setTitle","ord_setTitle_off");
		lastobj.className = lastobj.className.replace("tmp","ord_setTitle_off");
		targetObj.className = targetObj.className.replace("ord_setTitle_off","ord_setTitle");

		var lastUn = "";
		var nowUn = "un";
		if(_set["nowShow"] == "ord_setTitle"){
			lastUn = "un";
			nowUn = "";
		}

		var noMyBet = "";
		var setTxT = "none";
		if(_set[nowUn+"settled_count"] > 0){
			noMyBet = "none";
			setTxT = "";
		}

		document.getElementById(lastUn+"ord_noMyBet").style.display = "none";
		document.getElementById(lastUn+"ord_setTxT").style.display = "none";
		document.getElementById(lastUn+"ord_viewG").style.display = "none";
		document.getElementById(nowUn+"ord_noMyBet").style.display = noMyBet;
		document.getElementById(nowUn+"ord_setTxT").style.display = setTxT;
		document.getElementById(nowUn+"ord_viewG").style.display = setTxT;
	}
	// joe 160202======

	if(targetObj.className==_set["show_off"] &&document.getElementById("unord_setTitle").className==document.getElementById("ord_setTitle").className){
		resethei("off");
	}else{
		resethei("open");
	}
	//================================
}


function loadData(){	
	var par = "";
	par += "uid="+top.uid;
	par += "&langx="+top.langx;
	par += "&pgType=10rec";

	var getHTML = new HttpRequestXML();
	getHTML.addEventListener("LoadComplete",loadDataComplete);
	getHTML.loadURL(util.getNowDomain()+"/app/member/get_order_mybet.php","POST",par);
}

function loadDataComplete(xml){
	//trace("loadDataComplete: "+xml);

	var xmlObj = new Object();
	var pendingAry = new Array();
	xmlnode = new XmlNode(xml.getElementsByTagName("serverresponse"));
	xmlnodeRoot = xml.getElementsByTagName("serverresponse")[0];
	xmlObj["mybets"] = xmlnode.Node(xmlnodeRoot,"mybets",false);
	xmlObj["types"] = xmlnode.Node(xmlObj["mybets"][0],"types",false);

	var typesLength = xmlObj["types"].length;

	for(var i=0; i<typesLength; i++){
		var thisTypes = xmlObj["types"][i].getAttribute("id");

		var nowUn = "un";
		if(thisTypes == "settled")	nowUn = "";

		xmlObj["ticket"] = xmlnode.Node(xmlObj["types"][i],"ticket",false);

		var tmp_screen = "";
		var ticketLength = xmlObj["ticket"].length;

		for(var j=0; j<ticketLength; j++){
			var tmp_model = document.getElementById(thisTypes+"_model").innerHTML;
			var isSp = "";

			var betid = xmlObj["ticket"][j].getAttribute("id");
			_set["ticket"][betid] = xmlObj["ticket"][j];

			xmlObj["ticket_detail"] = xmlnode.Node(xmlObj["ticket"][j],"ticket_detail",false);

			var tmp_screen_detail = "";
			var ticket_detailLength = xmlObj["ticket_detail"].length
			var ms = "";

			for(var k=0; k<ticket_detailLength; k++){
				var tmp_betcontent_model = document.getElementById("betcontent_model").innerHTML;

				var ratio_H = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket_detail"][k],"ratio_H")));
				var ratio_A = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket_detail"][k],"ratio_A")));
				var choose = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket_detail"][k],"choose")));
				var betratio = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket_detail"][k],"betratio")));
				var ioratio = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket_detail"][k],"ioratio")));
				var resultdetail = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket_detail"][k],"resultdetail")));
				ms = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket_detail"][k],"ms")));
				var betdetail = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket_detail"][k],"betdetail")));

				var wlcolor = getWL_inside(resultdetail,betdetail);
				var ulc = "";
				if(nowUn=="" && wlcolor[0]=="D" && resultdetail!=""){
					isSp = "SP";
					ulc = "ord_ul_cancel";
				}
				if(nowUn=="un" && resultdetail=="-"){
					isSp = "SS";
					ulc = "ord_ul_cancel";
				}
       			// console.log(wlcolor[0]);
				var icon = _set["icon_"+wlcolor[0]];
				var iconclass = "ord_parLI";
				//console.log(nowUn);
				//console.log(ticket_detailLength);
				if(nowUn=="un" || ticket_detailLength==1)	icon = "";
				if(icon == "")	iconclass = "";
				//console.log(_set["icon_"+wlcolor[0]]);
				//console.log(icon);
				tmp_betcontent_model = tmp_betcontent_model.replace(/\*ULCANCEL\*/g,ulc);
				tmp_betcontent_model = tmp_betcontent_model.replace(/\*BETICON\*/g,icon);
				tmp_betcontent_model = tmp_betcontent_model.replace(/\*ICONCLASS\*/g,iconclass);
				tmp_betcontent_model = tmp_betcontent_model.replace(/\*CHOOSE\*/g,choose);
				tmp_betcontent_model = tmp_betcontent_model.replace(/\*BETRATIO\*/g,betratio);
				tmp_betcontent_model = tmp_betcontent_model.replace(/\*IORCLASS\*/g,(ioratio * 1 < 0)?"ior_blue fatWord":"RedWord fatWord");
				tmp_betcontent_model = tmp_betcontent_model.replace(/\*IORATIO\*/g,ioratio);

				tmp_screen_detail += tmp_betcontent_model;
			}

			var betstate = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket"][j],"betstate")));
			var wtype = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket"][j],"wtype")));
			var vs = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket"][j],"vs")));
			var _home = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket"][j],"home")));
			var _away = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket"][j],"away")));
			var org_score = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket"][j],"org_score")));
			var score = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket"][j],"score")));
			var stake = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket"][j],"stake")));
			var gold = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket"][j],"gold")));
			var betinfo = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket"][j],"betinfo")));
			var result = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket"][j],"result")));

			var wlcolor = getWLcolor(result,gold,betstate);
			var sb = "_S";
			var cr = "";
			var showbetinfo = "";
			var showresult = "";
			// 2017-05-15 PMO-51 危險球狀態字樣改變+十秒自動更新注單狀況
			var showLoading = "none";
			if(betstate == "dangerN"){
				cr = betid;
				showLoading = "";
				pendingAry.push(betid);
			}	
			if(ticket_detailLength > 1)	ms = "";
			if(ms == "")	sb = "_B";
			if(betinfo == "")	showbetinfo = "None";
			if(result == "")	showresult = "None";

			tmp_model = tmp_model.replace(/\*BETSTATE\*/g,betstate);
			tmp_model = tmp_model.replace(/\*CR\*/g,cr);
			tmp_model = tmp_model.replace(/\*TYPES\*/g,thisTypes);
			tmp_model = tmp_model.replace(/\*BETID\*/g,betid);
			tmp_model = tmp_model.replace(/\*SP\*/g,isSp);

			// 2017-05-15 PMO-51 危險球狀態字樣改變+十秒自動更新注單狀況
			tmp_model = tmp_model.replace(/\*DG_ICON\*/g,showLoading);

			tmp_model = tmp_model.replace(/\*WTYPE\*/g,wtype);
			tmp_model = tmp_model.replace(/\*SHOWVS\*/g,vs);
			tmp_model = tmp_model.replace(/\*HOME\*/g,_home);
			tmp_model = tmp_model.replace(/\*AWAY\*/g,_away);
			tmp_model = tmp_model.replace(/\*RATIO_H\*/g,ratio_H);
			tmp_model = tmp_model.replace(/\*RATIO_A\*/g,ratio_A);
			tmp_model = tmp_model.replace(/\*ORGSCORE\*/g,org_score);
			tmp_model = tmp_model.replace(/\*SCORE\*/g,score);
			tmp_model = tmp_model.replace(/\*BETCONTENT\*/g,tmp_screen_detail);
			tmp_model = tmp_model.replace(/\*STAKE\*/g,stake);
			if(gold=="-" || gold==0)
			{ 
				if(betstate=="cancel")
				 {tmp_model = tmp_model.replace(/\*GOLD\*/g,"-");}
				 else
				{tmp_model = tmp_model.replace(/\*GOLD\*/g,result.split(" ",1));}
			}
			else{
				
				tmp_model = tmp_model.replace(/\*GOLD\*/g,gold);
				}
			
			tmp_model = tmp_model.replace(/\*BETINFO\*/g,betinfo);
			tmp_model = tmp_model.replace(/\*SHOWBETINFO\*/g,showbetinfo);
			tmp_model = tmp_model.replace(/\*MS\*/g,ms);
			tmp_model = tmp_model.replace(/\*SB\*/g,sb);
			tmp_model = tmp_model.replace(/\*WLCOLOR\*/g,wlcolor["WLC"]);
			tmp_model = tmp_model.replace(/\*WLCOLORGOLD\*/g,wlcolor["WLCG"]);
			//console.log(result.split(" ").length);
			//var resize=result.split(" ").length;
		  	//var trueResult=result.split(" ")[0]+result.split(" ")[resize-3]+result.split(" ")[resize-2]+result.split(" ")[resize-1];
		  	tmp_model = tmp_model.replace(/\*RESULT\*/g,result); 
			tmp_model = tmp_model.replace(/\*SHOWRESULT\*/g,showresult);

			tmp_screen += tmp_model;
		}
		document.getElementById(nowUn+"ord_setTxT").innerHTML = tmp_screen;

		_set[thisTypes+"_count"] = ticketLength;
	}
	// 2017-05-12 PMO-51 危險球狀態字樣改變+十秒自動更新注單狀況
	var pending_tid = document.getElementById("pending_tid");
	var tmpStr = pendingAry.join(",");
	pending_tid.value = tmpStr;

	showBets_reload();
	// 
	//document.getElementById("unord_setNUM").innerHTML = _set["unsettled_count"];
	//document.getElementById("ord_setNUM").innerHTML = _set["settled_count"];

	parent.onloadSet(document.body.scrollWidth,document.body.scrollHeight,"rec_frame");
	document.getElementById("ord_DIV_Mask").style.height = document.getElementById("ord_main").scrollHeight+"px";
	onloadDanger();
}

function clearAlltimer(){
	clearInterval(dgRedirect);
}

function onloadDanger(){
  	clearInterval(dgRedirect);
	pendingTid = document.getElementById('pending_tid').value;
	// if(pendingTid!="") dgRedirect = setInterval("reload()", dangerTimer);
	// 2017-08-22 防止 pendingTid==null pendingTid=="" pendingTid=='undefined'
	if(pendingTid) dgRedirect = setInterval("reload()", dangerTimer);
}
function reload(){
	try{
		var getHTML = new HttpRequestXML();
		var param = "";
		param+="uid="+top.uid;
		param+="&langx="+top.langx;
		param+="&tid="+pendingTid;
		param+="&type=xml";
		param+="&from=mybets";

		getHTML.addEventListener("LoadComplete", reloadDangerDataComplete);
		getHTML.loadURL("/app/member/get_dangerous.php","POST", param);
	}catch(err){
		clearInterval(dgRedirect);
	}
}

function reloadDangerDataComplete(xml){
  try{
    var xmdObj = new Object();
    var pendingAry = new Array();
    var xmlnode=new XmlNode(xml.getElementsByTagName("serverrequest"));
	var dg_icon = document.getElementById('dg_icon');
    xmlnodeRoot = xml.getElementsByTagName("serverrequest")[0];
    xmdObj["tickets"] = xmlnode.Node(xmlnodeRoot,"tickets");

    ticketXML = xmlnode.Node(xmdObj["tickets"],"ticket",false);
    for(var i=0; i< ticketXML.length; i++){
      var tmp_ticket = ticketXML[i];
      var status = tmp_ticket.innerHTML;
      if(status=="N") pendingAry.push(tmp_ticket.getAttribute("id"));
    }
    var pendingLength = pendingAry.length;
    if(pendingLength!=0){
	  dg_icon.style.display = "";
    }else{
	  dg_icon.style.display = "none";
      clearInterval(dgRedirect);
      loadData();
    }
  }catch(err){
    clearInterval(dgRedirect);
  }
  
}

function resethei(show_type){
	var sheight=(show_type=="off")?document.getElementById("ord_main").scrollHeight:document.body.scrollHeight;
	try{
			parent.document.getElementById("div_ord_main").scrollTop="0";
		}catch(e){
  }
  parent.onloadSet(document.body.scrollWidth,0,"rec_frame");
	parent.onloadSet(document.body.scrollWidth,sheight,"rec_frame");
	document.getElementById("ord_DIV_Mask").style.height = document.getElementById("ord_main").scrollHeight+"px";
}
function showBets_reload(){
	if(_set["nowShow"] != ""){
		var lastUn = "";
		var nowUn = "un";
		if(_set["nowShow"] == "ord_setTitle"){
			lastUn = "un";
			nowUn = "";
		}

		var noMyBet = "";
		var setTxT = "none";
		if(_set[nowUn+"settled_count"] > 0){
			noMyBet = "none";
			setTxT = "";
		}

		document.getElementById(lastUn+"ord_noMyBet").style.display = "none";
		document.getElementById(lastUn+"ord_setTxT").style.display = "none";
		document.getElementById(lastUn+"ord_viewG").style.display = "none";
		document.getElementById(nowUn+"ord_noMyBet").style.display = noMyBet;
		document.getElementById(nowUn+"ord_setTxT").style.display = setTxT;
		document.getElementById(nowUn+"ord_viewG").style.display = setTxT;
	}
}

function util_formatNumber(num){
	return formatNumber(num,2,true);
}

function formatNumber(num,b,add){
	var point = b;
	var t = 1;
	for(; b>0; t*=10,b--);

	if(num*1 >= 0){
		if(add)	return addZero(Math.round((num*t)+(1/t))/t,point);
		else		return Math.round((num*t)+(1/t))/t;
	}else{
		if(add)	return addZero(Math.round((num*t)-(1/t))/t,point);
		else		return Math.round((num*t)+(1/t))/t;
	}
}

function addZero(code,b){
	code += "";

	var str = "";
	var index = code.indexOf(".");

	if(index == -1){
		code += ".";
		index = code.length-1;
	}

	var r = b*1 - (code.length-index-1);
	for(i=0; i<r; i++){
		str += "0";
	}
	str = code + str;

	return str;
}

function noData(b){
	parent.checkShowRec(b);
}

function showMore(types,betid){
	//trace("showMore");
	//var tmp_screen = document.getElementById(types+"_detail_model").innerHTML;
	var tmp_screen=_set[types+"_model"];
	var obj = _set["ticket"][betid];
	var xmlObj = new Object();
	xmlObj["ticket_detail"] = xmlnode.Node(obj,"ticket_detail",false);

	var tmp_screen_detail = "";
	var ticket_detailLength = xmlObj["ticket_detail"].length

	var bettime = "";
	var gametime = "";
	var nomalshow = (ticket_detailLength == 1)?"":"None";
	var pshow = (ticket_detailLength == 1)?"":"_p";
	var ms = "";

	for(var k=0; k<ticket_detailLength; k++){
		var tmp_betdetail_model = document.getElementById("betdetail_model"+pshow).innerHTML;

		var game_time = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket_detail"][k],"game_time")));
		var wtype_detail = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket_detail"][k],"wtype_detail")));
		var vs_detail = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket_detail"][k],"vs_detail")));
		var league = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket_detail"][k],"league")));
		var vs = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket_detail"][k],"vs")));
		var _home = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket_detail"][k],"home")));
		var away = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket_detail"][k],"away")));
		var ratio_H = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket_detail"][k],"ratio_H")));
		var ratio_A = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket_detail"][k],"ratio_A")));
		var org_score = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket_detail"][k],"org_score")));
		var score = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket_detail"][k],"score")));
		var choose = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket_detail"][k],"choose")));
		var betratio = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket_detail"][k],"betratio")));
		var ioratio = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket_detail"][k],"ioratio")));
		var resultdetail = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket_detail"][k],"resultdetail")));
		ms = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket_detail"][k],"ms")));

		var betdetail = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket_detail"][k],"betdetail")));

		if(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket_detail"][k],"wtype_detail")) === null){
			wtype_detail = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(obj,"wtype")));
		}

		if(ticket_detailLength>1 && k==0){
			var wtype = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(obj,"wtype")));
			wtype_detail = wtype+"<br>"+wtype_detail;
		}

		if(xmlnode.getNodeVal(xmlnode.Node(xmlObj["ticket_detail"][k],"vs_detail")) === null){
			vs_detail = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(obj,"vs")));
		}

		var game_timeAry = game_time.split(" ");
		var dateAry = game_timeAry[0].split("-");
		var timeAry = game_timeAry[1].split(":");

		if(top.langx == "zh-tw"){
			gametime = dateAry[1]+"/"+dateAry[2]+" "+timeAry[0]+":"+timeAry[1];
		}else{
			gametime = dateAry[2]+"/"+dateAry[1]+" "+timeAry[0]+":"+timeAry[1];
		}

		var sb = "_S";
		var it = "";
		var iscancel = "";
		var wl = getWL_inside(resultdetail,betdetail);
		if(ticket_detailLength>1 && (betdetail==top.str_cancel || resultdetail=="-"))	iscancel = "ord_CanBG";
		if(ms=="" && betdetail=="")	it = "None";
		if(ms == "")	sb = "_B";
        
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*ISCANCEL\*/g,iscancel);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*WTYPE\*/g,wtype_detail);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*LEAGUE\*/g,league);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*SHOWVS\*/g,vs_detail);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*HOME\*/g,_home);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*AWAY\*/g,away);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*RATIO_H\*/g,ratio_H);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*RATIO_A\*/g,ratio_A);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*ORGSCORE\*/g,org_score);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*SCORE\*/g,score);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*CHOOSE\*/g,choose);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*BETRATIO\*/g,betratio);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*IORCLASS\*/g,(ioratio * 1 < 0)?"ior_blue fatWord":"RedWord fatWord");
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*IORATIO\*/g,ioratio);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*COLOR\*/g,_set[wl[1]]);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*BETDETAIL\*/g,betdetail);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*MS\*/g,ms);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*SB\*/g,sb);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*IT\*/g,it);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*GAMETIME\*/g,gametime);

		tmp_screen_detail += tmp_betdetail_model;
	}

	var stake = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(obj,"stake")));
	var gold = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(obj,"gold")));
	var result = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(obj,"result")));
	var bet_time = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(obj,"bet_time")));
	var betstate = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(obj,"betstate")));

	var wlcolor = getWLcolor(result,gold,betstate);
	var bet_timeAry = bet_time.split(" ");
	var dateAry = bet_timeAry[0].split("-");
	var timeAry = bet_timeAry[1].split(":");
	if(top.langx == "zh-tw"){
		bettime = dateAry[1]+"/"+dateAry[2]+" "+timeAry[0]+":"+timeAry[1];
	}else{
		bettime = dateAry[2]+"/"+dateAry[1]+" "+timeAry[0]+":"+timeAry[1];
	}

	var sb = "_S";
	var showresult = "";
	var showcancel = "";
	if(ticket_detailLength > 1)	ms = "";
	if(ms == "")	sb = "_B";
	if(result == "")	showresult = "None";
	if(betstate == "cancel")	showcancel = "ord_CanBG";


	tmp_screen = tmp_screen.replace(/\*ALLDETAIL\*/g,tmp_screen_detail);
	tmp_screen = tmp_screen.replace(/\*SHOWCANCEL\*/g,showcancel);
	tmp_screen = tmp_screen.replace(/\*MODEL\*/g,"id_"+types);
	tmp_screen = tmp_screen.replace(/\*STAKE\*/g,stake);
	
		if(gold=="-" || gold==0 )
			{ 
				if(betstate=="cancel") 
				{tmp_screen = tmp_screen.replace(/\*GOLD\*/g,"-");}
				else
				{tmp_screen = tmp_screen.replace(/\*GOLD\*/g,result.split(" ",1));}
			}
			else{
				
				tmp_screen = tmp_screen.replace(/\*GOLD\*/g,gold);
				}
	tmp_screen = tmp_screen.replace(/\*WLCOLOR\*/g,wlcolor["WLC"]);
	tmp_screen = tmp_screen.replace(/\*WLCOLORGOLD\*/g,wlcolor["WLCG"]);
	//var resize=result.split(" ").length;
	//var trueResult=result.split(" ")[0]+result.split(" ")[resize-3]+result.split(" ")[resize-2]+result.split(" ")[resize-1];
	
	tmp_screen = tmp_screen.replace(/\*BETINFO\*/g,result);
	tmp_screen = tmp_screen.replace(/\*SHOWBETINFO\*/g,showresult);
	tmp_screen = tmp_screen.replace(/\*MS\*/g,ms);
	tmp_screen = tmp_screen.replace(/\*SB\*/g,sb);
	tmp_screen = tmp_screen.replace(/\*BETTIME\*/g,bettime);
	tmp_screen = tmp_screen.replace(/\*GAMETIME\*/g,gametime);
	tmp_screen = tmp_screen.replace(/\*BETID\*/g,betid);
	tmp_screen = tmp_screen.replace(/\*NOMALSHOW\*/g,nomalshow);

	divScroll = document.getElementById("ord_main");
	//divScroll.style.overflowY="hidden";
	document.getElementById("ord_DIV_Mask").innerHTML = tmp_screen;
	document.getElementById("ord_DIV_Mask").style.display = "";
	//==== joe 160128 
		_set["ord_Mask_set"]=document.getElementById("id_"+types+"_detail_model");
		//trace(document.getElementById("id_"+types+"_detail_model").outerHTML);
		//trace(types);
		//trace(document.getElementById("ord_DIV_Mask").children[0].outerHTML);
		trace("scrollHeight===>"+_set["div_ord_main"].scrollHeight);
		trace("clientHeight===>"+_set["div_ord_main"].clientHeight);
		trace("offsetHeight===>"+_set["div_ord_main"].offsetHeight);
		trace("_set['div_ord_main'].scrollTop===>"+_set["div_ord_main"].scrollTop);
		trace("document.body.scrollTop===>"+document.body.scrollTop);
		var ord_main=((40-_set["div_ord_main"].scrollTop)>0)?_set["div_ord_main"].scrollTop:40;//(  )40
		var top_value=_set["div_ord_main"].clientHeight/2+_set["div_ord_main"].scrollTop-_set["ord_Mask_set"].scrollHeight/2-ord_main;
			_set["ord_Mask_set"].style.top=(top_value<0)?0+"px":top_value+"px";
	//=====================
	//document.getElementById(types+"_detail_model").style.top = (parent.document.getElementById("div_ord_main").scrollTop+200)+"px";

	//var maxhei="";
	//maxhei(document.getElementById(types+"DIV").scrollHeight>document.body.scrollHeight)?document.getElementById(types+"DIV").scrollHeight:document.body.scrollHeight;
	parent.onloadSet(document.body.scrollWidth,document.body.scrollHeight,"rec_frame");
	document.getElementById("ord_DIV_Mask").style.height = divScroll.scrollHeight+"px";

}

function closeMore(){
	document.getElementById("ord_DIV_Mask").style.display = "none";
	document.getElementById("ord_DIV_Mask").innerHTML = "";

	//sdocument.getElementById("ord_main").style.overflowY="";
}

function Refresh(cr){
	if(cr == "")	return;
	loadData();
}

function getWL(result){
	var out = new Array("","");
	out[0] = result;

	if(result == "-"){
		out[0] = "D";
		out[1] = "loss";
	}else if(result=="W"){
		out[0] = "W";
		out[1] = "win";
	}else if(result=="L"){
		out[0] = "L";
		out[1] = "loss";
	}else if(result=="LW"){
		out[0] = "LW";
		out[1] = "win";
	}else if(result=="LL"){
		out[0] = "LL";
		out[1] = "loss";
	}else if(result == "P"){
		out[1] = "draw";
	}else{
		if(result == "LM"){
			out[0] = "P";
			out[1] = "draw";
		}else{
			out[0] = "D";
			out[1] = "loss";
		}
	}

	return out;
}


function getWL_inside(result,betdetail){
	var out = new Array("","");
	out[0] = result;
	//console.log(result);
	//console.log(betdetail.split(" ")[0]);
	//console.log(top.str_draw);
	if(result == "-"){
		out[0] = "D";
		out[1] = "loss";
	}else if(result=="W"){
		out[0] = "W";
		out[1] = "win";
	}else if(result=="L"){
		out[0] = "L";
		out[1] = "loss";
	}else if(result=="LW"){
		out[0] = (betdetail.split(" ")[0] == top.str_draw)?"P":"LW";
		out[1] = (betdetail.split(" ")[0] == top.str_draw)?"draw":"win";
	}else if(result=="LL"){
		out[0] = (betdetail.split(" ")[0] == top.str_draw)?"P":"LL";
		out[1] = (betdetail.split(" ")[0] == top.str_draw)?"draw":"loss";
	}else if(result == "P"){
		out[1] = "draw";
	}else{
		if(result == "LM"){
			out[0] = "P";
			out[1] = "draw";
		}else{
			out[0] = "D";
			out[1] = "loss";
		}
	}

	return out;
}

function getWLcolor(result,gold,betstate){
	var wlcolor = {"WLC":"","WLCG":""};
	gold = gold.replace(/,/g,"");

	if(gold == "-"){
		wlcolor["WLC"] = _set["draw"];
		wlcolor["WLCG"] = _set["draw"];
		
		// 2016-12-22 新會員端-最新十筆交易-已結算-過關單的退還秀成-   ，單式的和局秀成退還
		if(result.indexOf(top.str_refund)!=-1 || result.indexOf(top.str_irish_kiss)!=-1)	wlcolor["WLC"] = _set["draw"];
	}else{
		if(gold*1 < 0){
			wlcolor["WLC"] = _set["loss"] = "RedWord";
			wlcolor["WLCG"] = _set["loss"] = "RedWord";
		}else if(gold*1 > 0){
			wlcolor["WLC"] = _set["win"];
			wlcolor["WLCG"] = _set["win"];
		}else{
			wlcolor["WLC"] = _set["draw"];
			wlcolor["WLCG"] = _set["draw"];
		}
	}
  if(betstate=="cancel") wlcolor["WLC"] = _set["loss"] = "RedWord";	

	return wlcolor;
}

function clearTimer(){
	if(_set["ReloadTimeID"])	clearInterval(_set["ReloadTimeID"]);
}

function showPage(types){
	parent.parent.showMyAccount(types);
}

function systemMsg(msg){
	util.systemMsg("[order_mybet.js]"+msg);
}

function trace(msg){
	util.trace("[order_mybet.js]"+msg);
}
