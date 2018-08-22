var now_page = 1;
var total_page = 1;
var chk_cw = "N";
var cancel_strObj = new Object();
cancel_strObj["obj"]="";
cancel_strObj["code"]=true;
var cancel_count = -1;
var dangerTimer = "10000"; // 10秒reolad危險單
var dgRedirect = 0;
var pendingTid = "";

function init() {
	loadTodayWager();
	initDivBlur(document.getElementById("div_page"), document.getElementById("acc_pg"));
	document.getElementById("acc_pg").onclick = function () {
		divOnBlur(document.getElementById("div_page"), document.getElementById("acc_pg"));
		document.body.scrollTop = "0";
	}
}


function showPage(){
		var obj = document.getElementById('div_page');
		if(obj==null) return;
		obj.style.display = (obj.style.display=="")?"none":"";
}

function reload_var(){
	
		loadTodayWager();
}

function chgCW() {
	if(chk_cw=='' || chk_cw=='N')
		chk_cw='Y';
	else
		chk_cw='N';
	now_page = 1;
	loadTodayWager();
}

function loadTodayWager() {
	$.post('/app/member/account/get_today_wagers.php',
		{
			'uid':top.uid,
			'langx':top.langx,
			'chk_cw':chk_cw,
			'page':now_page
		},
		function (data) {
			var info = data.info;
			if(data.state == 1){
				var cancel = info.cancel;
				var list = info.list;
				console.log(cancel);
				now_page = cancel.now_page;
				cancel_count = cancel.cancel_count;
				total_page = cancel.total_page;
				$('#cancel_str').html(cancel.cancel_str);
				$('#page_gold').html(cancel.page_gold);
				$('#total_gold').html(cancel.total_gold);
				$('#present_page_gold').html(info.present_page_gold);
				$('#present_total_gold').html(info.present_total_gold);
				initPage(cancel.now_page, cancel.total_page);
				if(cancel_count <= 0){
					noData(true);
				}else{
					noData(false);
					setListNormal(list);
				}
			}else{
				alert(data.msg);
				do_cancel(1);
			}

		},
		'json');

}
function do_cancel(flag){
	parent.mail_forbid = false;
	if(flag == "2"){
		if(confirm(top["str_Quit_MailSet"])==true){
			if(is_set) onLoads();
			else parent.window.close();
			//var reg = new HttpRequest();
			//reg.addEventListener("LoadComplete",function(xml){parent.window.close();});
			//reg.loadURL("./set_email.php","POST",'uid='+myform.uid.value+'&action=clean_verify');
		}
	}else{
		if(is_set) onLoads();
		else parent.window.close();
	}
}


function initPage(now, total) {
	document.getElementById("now_page").innerHTML = now;
	document.getElementById("total_page").innerHTML = total;
	now_page = now;
	total_page = total;

	var pageObj = document.getElementById("page");
	var page_0 = pageObj.children["page_0"].cloneNode(true);
	pageObj.innerHTML = "";
	pageObj.appendChild(page_0);
	for (var i = 1; i <= total; i++) {
		var obj = document.createElement("li");
		obj.setAttribute("id", "page_" + i);
		obj.setAttribute("value", i);
		obj.innerHTML = i;
		if (now_page == i) {
			obj.setAttribute("class", "bet_page_contant_choose");
		}
		pageObj.appendChild(obj);
		setPageClick(obj);
	}
	setFlip(now, total);
}
//如果沒有上一頁或下一頁要不能點2016.0408 william
function setFlip(now,total) {
	var PPage = document.getElementById("P_Page");
	var NPage = document.getElementById("N_Page");
	var preBTN = document.getElementById("preBTN");
	var nextBTN = document.getElementById("nextBTN");
	if (now == total) {
		NPage.className = "";
		nextBTN.className = nextBTN.className + "off";
		if (total == 1) {
			PPage.className = "";
			preBTN.className = preBTN.className + "off";
			return;
		}
	}
	if (now == 1) {
		PPage.className = "";
		preBTN.className = preBTN.className + "off";
	}
}

function setPageClick(obj) {
	obj.onclick = function () {
		var page = obj.getAttribute("value");
		document.getElementById('div_page').style.display = "none";
		var now_pagenum = document.getElementById("now_page").innerHTML;

		if (now_pagenum == page) {
			return;
		}
		else {
			document.body.scrollTop = "0";
			chgPage(page);
		}
	};
}

function chgPage(page) {
	now_page = chkPage(page);
	document.getElementById("now_page").innerHTML = now_page;
	loadTodayWager();
}

//previous or next
function chgPageEvent(v) {
	var org = v * 1;
	var obj = document.getElementById('div_page');
	obj.style.display = "none";
	if (org > 0) {
		if (now_page >= total_page) return;
	} else {
		if (now_page <= 1) return;
	}
	document.body.scrollTop = "0";
	chgPage(now_page + org);

}

function chkPage(page) {

	if (page > total_page) page = total_page;
	if (page < 1) page = 1;
	return page;
}

function util_formatNumber(num) {
	return formatNumber(num, 2, true);
}

function formatNumber(num, b, add) {
	var point = b;
	var t = 1;
	for (; b > 0; t *= 10, b--);

	if (num * 1 >= 0) {
		if (add) return addZero(Math.round((num * t) + (1 / t)) / t, point);
		else        return Math.round((num * t) + (1 / t)) / t;
	} else {
		if (add) return addZero(Math.round((num * t) - (1 / t)) / t, point);
		else        return Math.round((num * t) + (1 / t)) / t;
	}
}

function addZero(code,b) {
	code += "";
	var str = "";
	var index = code.indexOf(".");

	if (index == -1) {
		code += ".";
		index = code.length - 1;
	}

	var r = b * 1 - (code.length - index - 1);
	for (i = 0; i < r; i++) {
		str += "0";
	}
	str = code + str;

	return str;
}

function noData(bool) {
	if(bool){
		$('.div_none').css('display','block');
		$('.div_show').css('display','none');
	}else{
		$('.div_none').css('display','none');
		$('.div_show').css('display','block');
	}
}


function systemMsg(msg) {
	util.systemMsg("[today_wagers.js]" + msg);
}

function trace(msg) {
	util.trace("[today_wagers.js]" + msg);
}

function onloadDanger() {
	clearInterval(dgRedirect);
	pendingTid = document.getElementById('pending_tid').value;
	if (pendingTid != "") dgRedirect = setInterval("reload()", dangerTimer);
}
function reload() {
	try {
		var getHTML = new HttpRequestXML();
		var param = "";
		param += "uid=" + top.uid;
		param += "&langx=" + top.langx;
		param += "&tid=" + pendingTid;
		param += "&type=xml";
		param += "&from=todaywagers";

		getHTML.addEventListener("LoadComplete", reloadDangerDataComplete);
		getHTML.loadURL("/app/member/get_dangerous.php", "POST", param);
	} catch (err) {
		clearInterval(dgRedirect);
	}
}

function reloadDangerDataComplete(xml) {
	try {
		var xmdObj = new Object();
		var pendingAry = new Array();
		var xmlnode = new XmlNode(xml.getElementsByTagName("serverrequest"));
		xmlnodeRoot = xml.getElementsByTagName("serverrequest")[0];
		xmdObj["tickets"] = xmlnode.Node(xmlnodeRoot, "tickets");

		ticketXML = xmlnode.Node(xmdObj["tickets"], "ticket", false);
		for (var i = 0; i < ticketXML.length; i++) {
			var tmp_ticket = ticketXML[i];
			var status = tmp_ticket.innerHTML;
			if (status == "N") pendingAry.push(tmp_ticket.getAttribute("id"));
		}
		var pendingLength = pendingAry.length;
		if (pendingLength == 0) {
			clearInterval(dgRedirect);
			reload_var();
		}
	} catch (err) {
		clearInterval(dgRedirect);
	}

}

function setListNormal(list){
	var str = '';
	$("#normal_show").html("");
	$.each( list, function( key, val ) {
		str += '<tr>';
		str += '<td>'+val.ID+'</td>';
		str += '<td>'+val.W_ID+'<br/>'+val.addtime+'<br/>('+val.ODDF_TYPE+')</td>';
		str += '<td>'+val.BetType+'</td>';
		str += '<td class="acc_oddDetailTD" style="color:'+val.weixian_color+';">'+val.middle+'</td>';
		str += '<td class="fatWord">'+val.BetScore+'</td>';
		str += '<td class="fatWord">'+val.Gwin+'</td>';
		str += '<td><tt>'+val.status_j+'</tt><br/><tt class="RedWord">'+val.Gwin+'</tt></td>';
		str += '</tr>'
	} );
	$("#normal_show").prepend(str);

}