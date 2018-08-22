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

function init(){
    loadTodayWager();
    initDivBlur(document.getElementById("div_page"), document.getElementById("acc_pg"));
   	document.getElementById("acc_pg").onclick=function(){
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

function chgCW(){
		chk_cw = (chk_cw=="N")?"Y":"N";
		now_page=1;
		loadTodayWager();
}

function loadTodayWager(){
		if(cancel_count <= 0 && chk_cw =="Y")return;
		if(document.getElementById("cancel_str").className != "acc_backToOB"&& cancel_count>0) document.getElementById("cancel_str").className = "acc_backToOB";

		var par = "";
		par+="uid="+top.uid;
		par+="&langx="+top.langx;
		par+="&chk_cw="+chk_cw;
		par+="&page="+now_page;

		var getHTML = new HttpRequestXML();
		getHTML.addEventListener("LoadComplete", loadTodayWagerComplete);
		getHTML.loadURL(util.getNowDomain()+"/app/member/account/get_today_wagers.php","POST", par);

}


function loadTodayWagerComplete(xml){
		//trace("loadTodayWagerComplete: "+xml);
		//console.error(xml);

		var xmlObj = new Object();
		xmlnode = new XmlNode(xml.getElementsByTagName("serverresponse"));
		xmlnodeRoot = xml.getElementsByTagName("serverresponse")[0];
		xmlObj["code"] = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlnodeRoot,"code")));

		//if(xmlObj["code"]=="todaywagers"){
				xmlObj["page_gold"] = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlnodeRoot,"page_gold")));
				xmlObj["total_gold"] = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlnodeRoot,"total_gold")));
				xmlObj["now_page"] = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlnodeRoot,"now_page")));
				xmlObj["total_page"] = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlnodeRoot,"total_page")));
				xmlObj["cancel_str"] = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlnodeRoot,"cancel_str")));
				xmlObj["cancel_count"] = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlnodeRoot,"cancel_count")));
				xmlObj["onepage"] = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlnodeRoot,"onepage")));
				xmlObj["wagers"] = xmlnode.Node(xmlnodeRoot,"wagers",false);

				var tmp_screen = "";
				var totalLength = xmlObj["wagers"].length;
				var setNum = (xmlObj["now_page"]*1-1)*xmlObj["onepage"];
				var pendingAry = new Array();
				if(totalLength >= 1){


					for(var i=0; i<totalLength; i++){
						xmlObj["wagers_sub"] = xmlnode.Node(xmlObj["wagers"][i],"wagers_sub",false);

						w_id = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers"][i],"w_id")));
						addtime = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers"][i],"addtime")));
						oddf_type = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers"][i],"oddf_type")));
						gtype = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers"][i],"gtype")));
						w_ms = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers"][i],"w_ms")));
						wtype = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers"][i],"wtype")));
						// 2016-12-12 足球多type所有細單改位罝顯示
						// 2016-12-29 22.新會員端-交易狀況/帳戶歷史-(滾球)字眼要放在14個type前面
						wtype_title = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers"][i],"wtype_title")));
						gold = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers"][i],"gold")));
						win_gold = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers"][i],"win_gold")));
						result_data = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers"][i],"result_data")));
						ball_act_class = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers"][i],"ball_act_class")));
						ball_act_ret = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers"][i],"ball_act_ret")));

						// 2017-05-12 PMO-51 危險球狀態字樣改變+十秒自動更新注單狀況
						if(ball_act_ret!="" && ball_act_class.indexOf("OrangeWord")!=-1 &&  xmlObj["code"]=="todaywagers"){
							w_id = w_id.substr(2);
							pendingAry.push(w_id);
						}

						var div_model = "";
						if(xmlObj["wagers_sub"].length >= 1){//P
							var p_model = document.getElementById("p_model").innerHTML;
							p_model = p_model.replace("<XMP>","").replace("</XMP>","").replace("<xmp>","").replace("</xmp>","");

							var p_tmp_screen = "";
							for(var j=0; j<xmlObj["wagers_sub"].length; j++){
								league = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"league")));
								team_h_show = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"team_h_show")));
								team_c_show = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"team_c_show")));
								team_ratio = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"team_ratio")));
								ratio = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"ratio")));
								org_score = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"org_score")));
								score = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"score")));
								result = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"result")));
								pname = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"pname")));
								ioratio = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"ioratio")));
								date = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"date")));
								time = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"time")));
								wtype_sub = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"wtype_sub")));
								// 2016-12-12 足球多type所有細單改位罝顯示
								// 2016-12-29 22.新會員端-交易狀況/帳戶歷史-(滾球)字眼要放在14個type前面
								wtype_title_sub = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"wtype_title_sub")));
								ms_sub = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"ms_sub")));
								strong = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"strong")));
								title_data = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"title_data")));
								ball_sub_ret = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"ball_act_ret")));



								var p_details_model = document.getElementById("p_details_model").innerHTML;
								p_details_model = p_details_model.replace("<XMP>","").replace("</XMP>","").replace("<xmp>","").replace("</xmp>","");
								p_details_model = p_details_model.replace(/\*GTYPE\*/g,gtype);
								p_details_model = p_details_model.replace(/\*W_MS\*/g,ms_sub);
								p_details_model = p_details_model.replace(/\*WTYPE\*/g,wtype_sub);
								// 2016-12-12 足球多type所有細單改位罝顯示
								// 2016-12-29 22.新會員端-交易狀況/帳戶歷史-(滾球)字眼要放在14個type前面
								p_details_model = p_details_model.replace(/\*WTYPE_TITLE\*/g,wtype_title_sub);
								p_details_model = p_details_model.replace(/\*LEAGUE\*/g,league);
								p_details_model = p_details_model.replace(/\*ORDERDATE\*/g,title_data);
								p_details_model = p_details_model.replace(/\*TEAM_H_SHOW\*/g,team_h_show);
								p_details_model = p_details_model.replace(/\*TEAM_C_SHOW\*/g,team_c_show);
								if(strong == "H")p_details_model = p_details_model.replace(/\*TEAM_H_RATIO\*/g,team_ratio);
								if(strong == "C")p_details_model = p_details_model.replace(/\*TEAM_C_RATIO\*/g,team_ratio);
								p_details_model = p_details_model.replace(/\*TEAM_H_RATIO\*/g,"");
								p_details_model = p_details_model.replace(/\*TEAM_C_RATIO\*/g,"");
								if(team_h_show == "" && team_c_show == ""){
									p_details_model = p_details_model.replace(/\*TEAM_ACT\*/g,"display:none;");
								}else{
									p_details_model = p_details_model.replace(/\*TEAM_ACT\*/g,"display:;");
								}
								p_details_model = p_details_model.replace(/\*TEAM_RATIO\*/g,team_ratio);

        						//last one or only one
								if(j==xmlObj["wagers_sub"].length-1||xmlObj["wagers_sub"].length==1){
										line_class = "acc_betArea_wordTop_no_line";
								//first one and length > 1
								}else if(j==0){
										line_class = "acc_betArea_wordTop";
								}else{
										line_class = "acc_betArea_wordTop_three";
								}
								if (ball_sub_ret!="") line_class += " acc_ul_cancel";

								p_details_model = p_details_model.replace(/\*LINE_CLASS\*/g, "class='"+line_class+"'");
								//p_details_model = p_details_model.replace(/\*TILTEL_DATE\*/g, "title='"+title_data+"'");

								p_details_model = p_details_model.replace(/\*DIS_TEAM_N\*/g,"");
								p_details_model = p_details_model.replace(/\*ORG_SCORE\*/g,"");
								p_details_model = p_details_model.replace(/\*SCORE\*/g,score);


								tmp_result=result.split("^");
								if(tmp_result[1])result = tmp_result[0]+" <tt class='RedWord fatWord'>"+tmp_result[1]+"</tt>";
								p_details_model = p_details_model.replace(/\*RESULT\*/g,result);
								p_details_model = p_details_model.replace(/\*PNAME\*/g,pname);
								p_details_model = p_details_model.replace(/\*IORATIO\*/g,ioratio);
								p_tmp_screen += p_details_model;
							}

							p_model = p_model.replace(/\*SUB_CONTENT\*/g,p_tmp_screen);
							p_model = p_model.replace(/\*TID\*/g,w_id);
							p_model = p_model.replace(/\*W_ID\*/g,w_id);
							addtime = addtime.replace(",","<br>");
							p_model = p_model.replace(/\*ADDTIME\*/g,addtime);
							p_model = p_model.replace(/\*ODDF_TYPE\*/g,oddf_type);
							if(chk_cw=="Y"){
									dis_cw_n = "style='display:none'";
									dis_cw_y = "";
							}else{
									dis_cw_y = "style='display:none'";
									dis_cw_n = "";
							}

							p_model = p_model.replace(/\*DIS_CW_N\*/g,dis_cw_n);
							p_model = p_model.replace(/\*DIS_CW_Y\*/g,dis_cw_y);
							p_model = p_model.replace(/\*ID\*/g,(i+1)+setNum);
							p_model = p_model.replace(/\*GTYPE\*/g,gtype);
							p_model = p_model.replace(/\*W_MS\*/g,w_ms);
							p_model = p_model.replace(/\*WTYPE\*/g,wtype);
							// 2016-12-12 足球多type所有細單改位罝顯示
							// 2016-12-29 22.新會員端-交易狀況/帳戶歷史-(滾球)字眼要放在14個type前面
							p_model = p_model.replace(/\*WTYPE_TITLE\*/g,wtype_title);
							p_model = p_model.replace(/\*RESULT_DATA\*/g,result_data);
							if(ball_act_ret == ""){
								div_model = div_model.replace(/\*ANNOUCEMENT\*/g,"class='annoucement_1'");
								p_model = p_model.replace(/\*BALL_ACT\*/g,"display:none;");
								p_model = p_model.replace(/\*BALL_ACT_CLASS\*/g,"");
								p_model = p_model.replace(/\*BALL_ACT_RET\*/g,"");
							}else{
								//danAry.push(w_id);
								p_model = p_model.replace(/\*ANNOUCEMENT\*/g,"class='acc_openbetTB_cancel'");
								p_model = p_model.replace(/\*BALL_ACT\*/g,"display:;");
								p_model = p_model.replace(/\*BALL_ACT_CLASS\*/g,ball_act_class);
								p_model = p_model.replace(/\*BALL_ACT_RET\*/g,ball_act_ret);
							}
							//p_model = p_model.replace(/\*GOLD\*/g,formatThousand(util_formatNumber(gold)));
							//p_model = p_model.replace(/\*WIN_GOLD\*/g,formatThousand(util_formatNumber(win_gold)));
							if (!isNaN(win_gold*1)){
	     				  		p_model = p_model.replace(/\*WIN_GOLD\*/g,(win_gold == "-")?"0":util.showTxt(util_formatNumber(win_gold)));
	     				 	}else{
	      			  			p_model = p_model.replace(/\*WIN_GOLD\*/g,(win_gold == "-")?"0":util.showTxt(win_gold));
	     			  		}
	     			  		p_model = p_model.replace(/\*GOLD\*/g,(gold == "-")?"0":util.showTxt(gold));
							div_model = p_model;
						}else{
							league = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers"][i],"league")));
							team_h_show = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers"][i],"team_h_show")));
							team_c_show = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers"][i],"team_c_show")));
							team_ratio = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers"][i],"team_ratio")));
							ratio = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers"][i],"ratio")));
							org_score = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers"][i],"org_score")));
							score = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers"][i],"score")));
							result = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers"][i],"result")));
							pname = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers"][i],"pname")));
							ioratio = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers"][i],"ioratio")));
							strong = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers"][i],"strong")));
							title_data = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers"][i],"title_data")));

							div_model = document.getElementById("normal_model").innerHTML;
							div_model = div_model.replace("<XMP>","").replace("</XMP>","").replace("<xmp>","").replace("</xmp>","");
							div_model = div_model.replace(/\*ID\*/g,(i+1)+setNum);
							div_model = div_model.replace(/\*W_ID\*/g,w_id);
							addtime = addtime.replace(",","<br>");
							div_model = div_model.replace(/\*ADDTIME\*/g,addtime);
							div_model = div_model.replace(/\*ODDF_TYPE\*/g,oddf_type);
							div_model = div_model.replace(/\*GTYPE\*/g,gtype);
							div_model = div_model.replace(/\*W_MS\*/g,w_ms);
							div_model = div_model.replace(/\*WTYPE\*/g,wtype);
							// 2016-12-12 足球多type所有細單改位罝顯示
							// 2016-12-29 22.新會員端-交易狀況/帳戶歷史-(滾球)字眼要放在14個type前面
							div_model = div_model.replace(/\*WTYPE_TITLE\*/g,wtype_title);
							div_model = div_model.replace(/\*TILTEL_DATE\*/g,"title='"+title_data+"'");
							div_model = div_model.replace(/\*LEAGUE\*/g,league);
							div_model = div_model.replace(/\*TEAM_H_SHOW\*/g,team_h_show);
							div_model = div_model.replace(/\*TEAM_C_SHOW\*/g,team_c_show);
							if(strong == "H")div_model = div_model.replace(/\*TEAM_H_RATIO\*/g,team_ratio);
							if(strong == "C")div_model = div_model.replace(/\*TEAM_C_RATIO\*/g,team_ratio);
							div_model = div_model.replace(/\*TEAM_H_RATIO\*/g,"");
							div_model = div_model.replace(/\*TEAM_C_RATIO\*/g,"");
							div_model = div_model.replace(/\*TEAM_RATIO\*/g,team_ratio);
							div_model = div_model.replace(/\*ORG_SCORE\*/g,org_score);
							div_model = div_model.replace(/\*SCORE\*/g,score);
							div_model = div_model.replace(/\*PNAME\*/g,pname);
							div_model = div_model.replace(/\*IORATIO\*/g,ioratio<0?"<font class='ior_blue'>"+ioratio+"</font>":ioratio);
							if(ball_act_ret == "" ){
								div_model = div_model.replace(/\*ANNOUCEMENT\*/g,"");
								div_model = div_model.replace(/\*DISPLAY_BALL_ACT\*/g,"style=\"display:none;\"");
								div_model = div_model.replace(/\*BALL_ACT_CLASS\*/g,"");
								div_model = div_model.replace(/\*BALL_ACT_RET\*/g,"");
							}else if(ball_act_class.indexOf("Green")!=-1) {
								div_model = div_model.replace(/\*ANNOUCEMENT\*/g,"");
								div_model = div_model.replace(/\*DISPLAY_BALL_ACT\*/g,"");
								div_model = div_model.replace(/\*BALL_ACT_CLASS\*/g,"class='"+ball_act_class+"'");
								div_model = div_model.replace(/\*BALL_ACT_RET\*/g,ball_act_ret);
							}else{
								//danAry.push(w_id);
									//var ann_class = (ball_act_class.indexOf("RedWord fatWord")!=-1)?"acc_openbet_dangerTR":"acc_openbetTB_cancel";
									// 2017-05-23 PMO-21 危險球 - 三端畫面修改
									var ann_class = (ball_act_class.indexOf("RedWord fatWord")!=-1||ball_act_class.indexOf("OrangeWord fatWord")!=-1)?"acc_openbet_dangerTR":"acc_openbetTB_cancel";
									div_model = div_model.replace(/\*ANNOUCEMENT\*/g,"class='"+ann_class+"'");
									div_model = div_model.replace(/\*DISPLAY_BALL_ACT\*/g,"");
									// 2017-05-23 PMO-21 危險球 - 三端畫面修改
									var color = (ball_act_class.indexOf("RedWord")!=-1)?"class='RedWordSP fatWord'":"class='OrangeWord fatWord'";
									div_model = div_model.replace(/\*BALL_ACT_CLASS\*/g, color);
									div_model = div_model.replace(/\*BALL_ACT_RET\*/g,(ball_act_class.indexOf("RedWord")!=-1||ball_act_class.indexOf("OrangeWord")!=-1)?ball_act_ret:"");

							}
							if(chk_cw=="Y"){
									dis_cw_n = "style='display:none'";
									dis_cw_y = "";
							}else{
									dis_cw_y = "style='display:none'";
									dis_cw_n = "";
							}
							dis_team_n = "";
							if(!team_h_show && !team_c_show){
								dis_team_n = "style='display:none'";
							}
							div_model = div_model.replace(/\*DIS_CW_N\*/g,dis_cw_n);
							div_model = div_model.replace(/\*DIS_CW_Y\*/g,dis_cw_y);
							div_model = div_model.replace(/\*DIS_TEAM_N\*/g,dis_team_n);

							tmp_result=result.split("^");
							if(tmp_result[1])result = tmp_result[0]+" <tt class='RedWord fatWord'>"+tmp_result[1]+"</tt>";
							div_model = div_model.replace(/\*RESULT\*/g,result);
							div_model = div_model.replace(/\*RESULT_DATA\*/g,result_data);
							if (!isNaN(win_gold*1)){
	     				  		div_model = div_model.replace(/\*WIN_GOLD\*/g,(win_gold == "-")?"0":util.showTxt(util_formatNumber(win_gold)));
	     				 	}else{
	      			  			div_model = div_model.replace(/\*WIN_GOLD\*/g,(win_gold == "-")?"0":util.showTxt(win_gold));
	     			  		}
	     			 		div_model = div_model.replace(/\*GOLD\*/g,(gold == "-")?"0":util.showTxt(gold));
						}

						tmp_screen += div_model;
					}

					// 2017-05-12 PMO-51 危險球狀態字樣改變+十秒自動更新注單狀況
					var pending_tid = document.getElementById("pending_tid");
					var tmpStr = pendingAry.join(",");
					pending_tid.value = tmpStr;

					div_model = document.getElementById("div_model");
					div_show = document.getElementById("div_show");
					show_txt = div_model.innerHTML;
					show_txt = show_txt.replace("<XMP>","").replace("</XMP>","").replace("<xmp>","").replace("</xmp>","");
					show_txt = show_txt.replace(/\*CONTENT\*/g, tmp_screen);
					show_txt = show_txt.replace(/\*PAGE_GOLD\*/g, xmlObj["page_gold"]);
					show_txt = show_txt.replace(/\*TOTAL_GOLD\*/g, xmlObj["total_gold"]);
					div_show.innerHTML = show_txt;
					initPage(xmlObj["now_page"]*1, xmlObj["total_page"]*1);


					noData(false);
					/*
					if(div_show.scrollHeight >= _scrollHeightLimit){
						bottom_topObj.style.display = "";
					}else{
						bottom_topObj.style.display = "none";
					}

					var totalPage = Math.ceil(totalLength / _pageCount);
					if(_nowPage >= totalPage)	allsportsObj.style.display = "none";

					for(var k=0; k< danAry.length; k++){
						var divObj = document.getElementById("div_"+danAry[k]);
						_self.addEventListener("MouseEvent.CLICK",_self.reloadHandler,divObj);
					}
					*/
				}else{
						noData(true);
				}
				if(cancel_strObj["code"])cancel_strObj["obj"] = document.getElementById("cancel_str").innerHTML;
				if(xmlObj["code"] == "todaywagers"){
					document.getElementById("cancel_str").innerHTML = cancel_strObj["obj"];
					cObj = document.getElementById("cancel_strNUM");
					cObj.innerHTML = "("+xmlObj["cancel_count"]+")";
					cancel_count = xmlObj["cancel_count"];
					if(xmlObj["cancel_count"] > 0) {
						cObj.className = "WhiteWord";
						document.getElementById("cancel_str").className = "acc_CancelWord";
					}
					else document.getElementById("cancel_str").className = "acc_CancelWord no_pointer";
					document.getElementById("WAGERS").style.display = "";
					document.getElementById("WAGERS_CANCEL").style.display = "none";
				}else{
					document.getElementById("cancel_str").innerHTML = xmlObj["cancel_str"];
					document.getElementById("WAGERS").style.display = "none";
					document.getElementById("WAGERS_CANCEL").style.display = "";
				}
				cancel_strObj["code"] = false;

				if(pendingAry.length >0){
					onloadDanger();
				}


}

function initPage(now, total){
		document.getElementById("now_page").innerHTML = now;
		document.getElementById("total_page").innerHTML = total;
		now_page = now;
		total_page = total;

		var pageObj = document.getElementById("page");
		var page_0 = pageObj.children["page_0"].cloneNode(true);
		pageObj.innerHTML = "";
		pageObj.appendChild(page_0);
		for(var i=1; i<=total; i++){
				var obj = document.createElement("li");
				obj.setAttribute("id", "page_"+i);
				obj.setAttribute("value", i);
				obj.innerHTML = i;
				if(now_page == i)
				{
					obj.setAttribute("class","bet_page_contant_choose");
				}
				pageObj.appendChild(obj);
				setPageClick(obj);
		}
		setFlip(now,total);
}

function setFlip(now,total)//如果沒有上一頁或下一頁要不能點2016.0408 william
{
	var PPage = document.getElementById("P_Page");
	var NPage = document.getElementById("N_Page");
	var preBTN = document.getElementById("preBTN");
	var nextBTN = document.getElementById("nextBTN");
	if(now == total)
	{
		NPage.className = "";
		nextBTN.className = nextBTN.className+"off";
		nextBTN
		if(total == 1)
		{
			PPage.className = "";
			preBTN.className = preBTN.className+"off";
			return;
		}
	}
	if(now == 1)
	{
			PPage.className = "";
			preBTN.className = preBTN.className+"off";
	}
}

function setPageClick(obj){
		obj.onclick=function(){
				var page = obj.getAttribute("value");
				document.getElementById('div_page').style.display = "none";
				var now_pagenum=document.getElementById("now_page").innerHTML;

				if(now_pagenum == page)
				{
					return;
				}
				else
				{
					document.body.scrollTop = "0";
					chgPage(page);
				}
		};
}

function chgPage(page){
		now_page = chkPage(page);
		document.getElementById("now_page").innerHTML = now_page;
		loadTodayWager();
}

//previous or next
function chgPageEvent(v){
		var org = v*1;
		var obj = document.getElementById('div_page');
		obj.style.display = "none";
		if(org>0){
				if(now_page>=total_page) return;
		}else{
				if(now_page<=1) return;
		}
		document.body.scrollTop = "0";
		chgPage(now_page+org);

}

function chkPage(page){

		if(page > total_page) page=total_page;
		if(page < 1) page=1;
		return page;
}

function util_formatNumber(num){
		return formatNumber(num, 2, true);
}

function formatNumber(num, b, add){
		var point = b;
		var t=1;
		for(;b>0;t*=10,b--);

		if(num*1 >= 0){
				if(add) return addZero(Math.round((num*t)+(1/t))/t,point);
				else 		return Math.round((num*t)+(1/t))/t;
		}else{
				if(add) return addZero(Math.round((num*t)-(1/t))/t,point);
				else 		return Math.round((num*t)+(1/t))/t;
		}
}

function addZero(code,b){
		code+="";
		var str = "";
		var index = code.indexOf(".");

		if(index==-1){
				code+=".";
				index=code.length-1;
		}

		var r = b*1 - (code.length-index-1);
		for(i=0; i<r; i++){
				str += "0";
		}
		str = code + str;

		return str;
}

function noData(b){
		document.getElementById("div_show").style.display = (b)?"none":"";
		document.getElementById("div_nodata").style.display = (b)?"":"none";
}


function systemMsg(msg){
		util.systemMsg("[today_wagers.js]"+msg);
}

function trace(msg){
		util.trace("[today_wagers.js]"+msg);
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
	param+="&from=todaywagers";

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
    xmlnodeRoot = xml.getElementsByTagName("serverrequest")[0];
    xmdObj["tickets"] = xmlnode.Node(xmlnodeRoot,"tickets");

    ticketXML = xmlnode.Node(xmdObj["tickets"],"ticket",false);
    for(var i=0; i< ticketXML.length; i++){
      var tmp_ticket = ticketXML[i];
      var status = tmp_ticket.innerHTML;
      if(status=="N") pendingAry.push(tmp_ticket.getAttribute("id"));
    }
    var pendingLength = pendingAry.length;
    if(pendingLength==0){
      clearInterval(dgRedirect);
      reload_var();
    }
  }catch(err){
    clearInterval(dgRedirect);
  }
  
}
