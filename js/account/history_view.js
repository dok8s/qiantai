var now_page = 1;
var total_page = 1;
function init(){
    loadData();
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


function loadData(){

		var par = "";
		par+=base_url;
		par+="&page="+now_page;

		var getHTML = new HttpRequestXML();
		getHTML.addEventListener("LoadComplete", loadDataComplete);
		getHTML.loadURL(util.getNowDomain()+"/app/member/account/get_history_view.php","POST", par);
}


function loadDataComplete(xml){
		//trace("loadDataComplete: "+xml);

		var xmlObj = new Object();
		xmlnode = new XmlNode(xml.getElementsByTagName("serverresponse"));
		xmlnodeRoot = xml.getElementsByTagName("serverresponse")[0];
		xmlObj["code"] = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlnodeRoot,"code")));


		if(xmlObj["code"]=="history_view"){
				xmlObj["page_gold"] = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlnodeRoot,"page_gold")));
				xmlObj["total_gold"] = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlnodeRoot,"total_gold")));
				xmlObj["page_wingold"] = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlnodeRoot,"page_wingold")));
				xmlObj["total_wingold"] = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlnodeRoot,"total_wingold")));

				xmlObj["now_page"] = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlnodeRoot,"now_page")));
				xmlObj["total_page"] = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlnodeRoot,"total_page")));
				xmlObj["cancel_str"] = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlnodeRoot,"cancel_str")));
				xmlObj["cancel_count"] = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlnodeRoot,"cancel_count")));
				xmlObj["onepage"] = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlnodeRoot,"onepage")));
				xmlObj["wagers"] = xmlnode.Node(xmlnodeRoot,"wagers",false);

				var tmp_screen = "";
				var totalLength = xmlObj["wagers"].length;
				var setNum = (xmlObj["now_page"]*1-1)*xmlObj["onepage"];
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
						gpush = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers"][i],"push")));
						ball_act_class = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers"][i],"ball_act_class")));
						ball_act_ret = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers"][i],"ball_act_ret")));
						result_WL = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers"][i],"result_WL")));
						result_WL_class = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers"][i],"result_WL_class")));


						var div_model = "";
						if(xmlObj["wagers_sub"].length >= 1){//P
							subMax = xmlObj["wagers_sub"].length;
							var p_tmp_screen = "";
							var p_result_screen = "";
							var tmpSub_ret = false;
							for(var j=0; j<xmlObj["wagers_sub"].length; j++){
								league = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"league")));
								team_h_show = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"team_h_show")));
								team_c_show = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"team_c_show")));
								team_ratio = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"team_ratio")));
								ratio = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"ratio")));
								org_score = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"org_score")));
								score = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"score")));
								result = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"result")));
								result_data = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"result_data")));
								pname = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"pname")));
								ioratio = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"ioratio")));
								ball_sub_class = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"ball_sub_class")));
								ball_sub_ret = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"ball_sub_ret")));
								date = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"date")));
								time = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"time")));
								wtype_sub = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"wtype_sub")));
								// 2016-12-12 足球多type所有細單改位罝顯示
								// 2016-12-29 22.新會員端-交易狀況/帳戶歷史-(滾球)字眼要放在14個type前面
								wtype_title_sub = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"wtype_title_sub")));
								ms_sub = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"ms_sub")));
								strong = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"strong")));
								title_data = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"title_data")));
								result_sub = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"result_sub")));
								result_sub_class = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers_sub"][j],"result_sub_class")));

								var p_model = document.getElementById("p_model").innerHTML;
								p_model = p_model.replace("<XMP>","").replace("</XMP>","").replace("<xmp>","").replace("</xmp>","");

								if(j==0)p_model = p_model.replace(/\*TD_SHOW\*/g,"rowspan='"+subMax+"'");
								else p_model = p_model.replace(/\*TD_SHOW\*/g,"style='display:none'");

								p_model = p_model.replace(/\*TID\*/g,w_id);
								p_model = p_model.replace(/\*W_ID\*/g,w_id);
								addtime = addtime.replace(",","<br>");
								p_model = p_model.replace(/\*ADDTIME\*/g,addtime);
								p_model = p_model.replace(/\*ODDF_TYPE\*/g,oddf_type);
								p_model = p_model.replace(/\*ID\*/g,(i+1)+setNum);
								p_model = p_model.replace(/\*GTYPE\*/g,gtype);
								p_model = p_model.replace(/\*W_MS\*/g,ms_sub);
								p_model = p_model.replace(/\*WTYPE\*/g,wtype_sub);
								// 2016-12-12 足球多type所有細單改位罝顯示
								// 2016-12-29 22.新會員端-交易狀況/帳戶歷史-(滾球)字眼要放在14個type前面
								p_model = p_model.replace(/\*WTYPE_TITLE\*/g,wtype_title_sub);
								p_model = p_model.replace(/\*LEAGUE\*/g,league);


								p_model = p_model.replace(/\*ORDERDATE\*/g,title_data);
								p_model = p_model.replace(/\*TEAM_H_SHOW\*/g,team_h_show);
								p_model = p_model.replace(/\*TEAM_C_SHOW\*/g,team_c_show);
								if(strong == "H")p_model = p_model.replace(/\*TEAM_H_RATIO\*/g,team_ratio);
								if(strong == "C")p_model = p_model.replace(/\*TEAM_C_RATIO\*/g,team_ratio);
								p_model = p_model.replace(/\*TEAM_H_RATIO\*/g,"");
								p_model = p_model.replace(/\*TEAM_C_RATIO\*/g,"");
								p_model = p_model.replace(/\*TEAM_RATIO\*/g,team_ratio);
								line_class = "";
								if(ball_sub_ret != "")line_class += " acc_ul_cancel";
								p_model = p_model.replace(/\*LINE_CLASS\*/g, "class='"+line_class+"'");


								if(ball_act_ret == ""){
									if(j!=0)p_model = p_model.replace(/\*TR_CLASS\*/g,"class='acc_TRdashed'");
									p_model = p_model.replace(/\*WIN_GOLD_CLASS\*/g,(win_gold.replace(",","")*1 < 0 )?"RedWord":"");
              
									if (!isNaN(win_gold*1)){
										//console.log('w0');
										if(win_gold*1==0)
										{
											p_model = p_model.replace(/\*WIN_GOLD\*/g,(win_gold != "-")?result_WL:win_gold);
											}else{
									    	p_model = p_model.replace(/\*WIN_GOLD\*/g,(win_gold != "-")?util.showTxt(util_formatNumber(win_gold)):win_gold);
									    }
									  //cosole.log(util.showTxt(util_formatNumber(win_gold)));
									  
									}else{
										p_model = p_model.replace(/\*WIN_GOLD\*/g,(win_gold != "-")?util.showTxt(win_gold):win_gold);
		     			  	}
								}else{
									//danAry.push(w_id);
									p_model = p_model.replace(/\*TR_CLASS\*/g,"class='acc_openbetTB_cancel'");
									p_model = p_model.replace(/\*WIN_GOLD_CLASS\*/g,"RedWordSP");
									p_model = p_model.replace(/\*WIN_GOLD\*/g,ball_act_ret);
								}
								tmp_result=result.split("^");
								if(tmp_result[1])result = tmp_result[0]+" <tt class='RedWord fatWord'>"+tmp_result[1]+"</tt>";
								p_model = p_model.replace(/\*RESULT\*/g,result);
								//p_model = p_model.replace(/\*PNAME\*/g,pname);
								p_model = p_model.replace(/\*IORATIO\*/g,ioratio);

		     			 	p_model = p_model.replace(/\*GOLD\*/g,(gold == "-")?"0":util.showTxt(gold));

								if(ball_sub_ret == ""){
									p_model = p_model.replace(/\*RESULT_CONTENT\*/g,result_sub+"<br>"+result_data);
									p_model = p_model.replace(/\*RESULT_CONTENT_CLASS\*/g,result_sub_class);
		     			  	tmpSub_ret = true;
								}else{
									p_model = p_model.replace(/\*RESULT_CONTENT\*/g,result_data);
									p_model = p_model.replace(/\*RESULT_CONTENT_CLASS\*/g,ball_sub_class);
								}
								p_model = p_model.replace(/\*RESULT_ALL\*/g,result_WL);
								p_model = p_model.replace(/\*RESULT_CLASS\*/g,result_WL_class);

								if(j == subMax-1 && ball_act_ret == "" && tmpSub_ret)p_model = p_model.replace(/\*RESULT_SHOW\*/g,"");
								else p_model = p_model.replace(/\*RESULT_SHOW\*/g,"style='display:none'");

							div_model += p_model;
							}

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
							result_data = util.showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlObj["wagers"][i],"result_data")));
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
							div_model = div_model.replace(/\*LEAGUE\*/g,league);
							div_model = div_model.replace(/\*TILTEL_DATE\*/g,"title='"+title_data+"'");
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
							var result_data_class = "";
							if(ball_act_ret == "" ){
								div_model = div_model.replace(/\*TR_CLASS\*/g,"");
								div_model = div_model.replace(/\*DISPLAY_BALL_ACT\*/g,"style=\"display:none;\"");
								div_model = div_model.replace(/\*BALL_ACT_CLASS\*/g,"");
								div_model = div_model.replace(/\*BALL_ACT_RET\*/g,"");
								if(result_WL)result_data = result_WL+"<br>"+result_data;
								result_data_class = "class='"+result_WL_class+"'";;
							}else if(ball_act_class.indexOf("Green")!=-1) {
								div_model = div_model.replace(/\*TR_CLASS\*/g,"");
								div_model = div_model.replace(/\*DISPLAY_BALL_ACT\*/g,"");
								div_model = div_model.replace(/\*BALL_ACT_CLASS\*/g,"class='"+ball_act_class+"'");
								div_model = div_model.replace(/\*BALL_ACT_RET\*/g,ball_act_ret);
								if(result_WL)result_data = result_WL+"<br>"+result_data;
								result_data_class = "class='"+result_WL_class+"'";;
							}else{
								//danAry.push(w_id);
								div_model = div_model.replace(/\*TR_CLASS\*/g,"class='acc_openbetTB_cancel'");
								var ann_class = (ball_act_class.indexOf("RedWord")!=-1)?"RedWordSP fatWord":"";
								div_model = div_model.replace(/\*DISPLAY_BALL_ACT\*/g,"");
								div_model = div_model.replace(/\*BALL_ACT_CLASS\*/g, "class='"+ann_class+"'");
								div_model = div_model.replace(/\*BALL_ACT_RET\*/g,(ball_act_class.indexOf("RedWord")!=-1)?ball_act_ret:"");
	     			  	result_data_class = "class='RedWord'";
							}

							dis_team_n = "";
							if(!team_h_show && !team_c_show){
								dis_team_n = "style='display:none'";
							}
							div_model = div_model.replace(/\*DIS_TEAM_N\*/g,dis_team_n);

							tmp_result=result.split("^");
							if(tmp_result[1])result = tmp_result[0]+" <tt class='RedWord fatWord'>"+tmp_result[1]+"</tt>";
							div_model = div_model.replace(/\*RESULT\*/g,result);
							if (!isNaN(win_gold*1)){
								if(win_gold*1==0){
									div_model = div_model.replace(/\*WINGOLD\*/g,(win_gold != "-")?result_WL:win_gold);
									}else{
	     				   div_model = div_model.replace(/\*WINGOLD\*/g,(win_gold != "-")?util.showTxt(util_formatNumber(win_gold)):win_gold);
	     				      }
	     				 }else{
	      			  div_model = div_model.replace(/\*WINGOLD\*/g,(win_gold != "-")?util.showTxt(win_gold):win_gold);
	     			  }

	     			  div_model = div_model.replace(/\*WINGOLD_CLASS\*/g, (win_gold.replace(",","")*1 < 0 )?"RedWord":"");
	     			  div_model = div_model.replace(/\*RESULT_DATA\*/g, result_data);
	     			  div_model = div_model.replace(/\*RESULT_DATA_CLASS\*/g, result_data_class);

	     			  div_model = div_model.replace(/\*GOLD\*/g,(gold == "-")?"0":util.showTxt(gold));
						}

						tmp_screen += div_model;
					}

					div_model = document.getElementById("div_model");
					div_show = document.getElementById("div_show");
					show_txt = div_model.innerHTML;
					show_txt = show_txt.replace("<XMP>","").replace("</XMP>","").replace("<xmp>","").replace("</xmp>","");
					show_txt = show_txt.replace(/\*CONTENT\*/g, tmp_screen);
					show_txt = show_txt.replace(/\*PAGE_GOLD\*/g, xmlObj["page_gold"]);
					show_txt = show_txt.replace(/\*TOTAL_GOLD\*/g, xmlObj["total_gold"]);
					show_txt = show_txt.replace(/\*PAGE_WINGOLD\*/g, xmlObj["page_wingold"]);
					show_txt = show_txt.replace(/\*TOTAL_WINGOLD\*/g, xmlObj["total_wingold"]);
					div_show.innerHTML = show_txt;
					initPage(xmlObj["now_page"]*1, xmlObj["total_page"]*1);


					cObj = document.getElementById("cancel_str");
					cObj.innerHTML = xmlObj["cancel_str"];
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
		loadData();
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
		//document.getElementById("div_nodata").style.display = (b)?"":"none";
}


function systemMsg(msg){
		util.systemMsg("[history_view.js]"+msg);
}

function trace(msg){
		util.trace("[history_view.js]"+msg);
}