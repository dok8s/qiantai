var DataFT = new Array();
//取消原因 result_type
//輸贏結果 result_open
var GameHead = new Array("gid","date","time","league","team_h","team_c","num_h","num_c","game_over",
"result_h1st","result_c1st","result_type1st","result_open1st",
"result_hfull","result_cfull","result_typefull","result_openfull",
"result_ha","result_ca","result_typea","result_opena","result_hb","result_cb","result_typeb","result_openb",
"result_hc","result_cc","result_typec","result_openc","result_hd","result_cd","result_typed","result_opend",
"result_he","result_ce","result_typee","result_opene","result_hf","result_cf","result_typef","result_openf",
"result_BH","BH",
"result_ARG","ARG","result_BRG","BRG","result_CRG","CRG","result_DRG","DRG","result_ERG","ERG",
"result_FRG","FRG","result_GRG","GRG","result_HRG","HRG","result_IRG","IRG","result_JRG","JRG",
"result_FG","FG","result_F2G","F2G","result_F3G","F3G","result_T1G","T1G","result_T3G","T3G","result_TK","TK","result_PA","PA",
"result_RCD","RCD","result_PGF","PGF","result_PGL","PGL","result_OSF","OSF","result_OSL","OSL","result_STF","STF","result_STL","STL",
"result_CNF","CNF","result_CNL","CNL","result_CDF","CDF","result_CDL","CDL","result_YCF","YCF","result_YCL","YCL","result_GAF","GAF",
"result_GAL","GAL","result_RCF","RCF","result_RCL","RCL");

var objAry = new Object();
objAry["Minute"] = new Array("1st","full","a","b","c","d","e","f");
objAry["Manual"] = new Array("BH","ARG","BRG","CRG","DRG","ERG","FRG","GRG","HRG","IRG","JRG","FG","F2G","F3G","T1G","T3G","TK","PA","RCD");
objAry["SP"] = new Array("PGF","PGL","OSF","OSL","STF","STL","CNF","CNL","CDF","CDL","RCF","RCL","YCF","YCL","GAF","GAL");

function Loaded(){
	
	DataFT = lib_parseArray(GameHead,gdata);
	
	document.getElementById("tean_name").innerHTML = DataFT["team_h"]+" VS "+DataFT["team_c"];
	document.getElementById("leagues_name").innerHTML = DataFT["league"];
	document.getElementById("game_time").innerHTML = DataFT["date"].substring(5)+" "+DataFT["time"];
	
	initMinuteObj(objAry["Minute"]);
	initManualObj(objAry["Manual"]);
	initSPObj(objAry["SP"]);
	
	fix_window();
}

//============================= init start =============================
function initMinuteObj(dataArr){
	for(var i=0; i<dataArr.length; i++){
		var thisTRObj = document.getElementById("tr_"+dataArr[i]);
		thisTRObj.style.display = "";
		
		var showResult = DataFT["result_type"+dataArr[i]];
		var openResult = DataFT["result_open"+dataArr[i]];
		var showScoreH = DataFT["result_h"+dataArr[i]];
		var showScoreC = DataFT["result_c"+dataArr[i]];
		
		if(i>=2 && (WtypeOpen["AR"]=="Y" || WtypeOpen["ARE"]=="Y")){
			thisTRObj.style.display = "none";
		}else{
			if(openResult == "DN"){
				//DN 賽事腰斬 顯示取消原因和比分
			}else{
				if((openResult == "DL") || (showScoreH*1 == -11 || showScoreC*1 == -11)){
					thisTRObj.style.display = "none";
				}else{
					if(showResult != ""){
						showScoreH = "";
						showScoreC = "";
					}
				}
			}
			
			document.getElementById("result_"+dataArr[i]+"h").innerHTML = showResult;
			document.getElementById("score_"+dataArr[i]+"h").innerHTML = showScoreH;
			document.getElementById("score_"+dataArr[i]+"c").innerHTML = showScoreC;
		}
	}
}

function initManualObj(dataArr){
	for(var i=0; i<dataArr.length; i++){
		var thisTRObj = document.getElementById("tr_"+dataArr[i]);
		thisTRObj.style.display = "";
		
		var showResult = DataFT["result_"+dataArr[i]];
		var openResult = DataFT[dataArr[i]];
		var finalResult = openResult;
		
		var nowSubWtype = dataArr[i];
		var chkRKey = "N";
		
		//T1G T3G 多判斷 滾球開關
		if(nowSubWtype=="T1G" || nowSubWtype=="T3G"){
			chkRKey = WtypeOpen["R"+nowSubWtype];
		}
		
		if(WtypeOpen[nowSubWtype]=="Y" || chkRKey=="Y"){
			thisTRObj.style.display = "none";
		}else{
			if(openResult == "DL"){
				thisTRObj.style.display = "none";
			}else{
				if(showResult != ""){
					document.getElementById("result_type"+dataArr[i]).innerHTML = showResult;
				}else{
					var newOpenResult = openResult;
					if(dataArr[i] == "FG" || dataArr[i] == "T3G" || dataArr[i] == "T1G"){
						newOpenResult = top.str_result[dataArr[i]+"_"+newOpenResult];
					}else if(dataArr[i]=="PA" || dataArr[i]=="RCD"){
						newOpenResult = top.str_result[newOpenResult];
					}else{
						if(newOpenResult=="H" || newOpenResult=="Home"){
							newOpenResult = DataFT["team_h"];
						}else if(newOpenResult=="C" || newOpenResult=="Away"){
							newOpenResult = DataFT["team_c"];
						}else if(newOpenResult=="N" || newOpenResult=="No"){
							newOpenResult = top.str_result["N"];
						}
					}
					document.getElementById("result_type"+dataArr[i]).innerHTML = newOpenResult;
				}
			}
		}
	}
}

function initSPObj(dataArr){
	for(var i=0; i<dataArr.length; i++){
		var thisTRObj = document.getElementById("tr_"+dataArr[i]);
		thisTRObj.style.display = "";
		
		var showResult = DataFT["result_"+dataArr[i]];
		var openResult = DataFT[dataArr[i]];
		var finalResult = openResult;
		
		var nowSubWtype = dataArr[i].substr(0,2);
		if(WtypeOpen[nowSubWtype] == "Y"){
			thisTRObj.style.display = "none";
		}else{
			if(openResult == "DL"){
				thisTRObj.style.display = "none";
			}else{
				if(showResult != ""){
					document.getElementById("result_type"+dataArr[i]).innerHTML = showResult;
				}else{
					var newOpenResult = openResult;
					if(dataArr[i] == "FG"){
						newOpenResult = top.str_result[dataArr[i]+"_"+newOpenResult];
					}else if(dataArr[i]=="PA" || dataArr[i]=="RCD"){
						newOpenResult = top.str_result[newOpenResult];
					}else{
						if(newOpenResult=="H" || newOpenResult=="Home"){
							newOpenResult = DataFT["team_h"];
						}else if(newOpenResult=="C" || newOpenResult=="Away"){
							newOpenResult = DataFT["team_c"];
						}else if(newOpenResult=="N" || newOpenResult=="No"){
							newOpenResult = top.str_result["N"];
						}
					}
					document.getElementById("result_type"+dataArr[i]).innerHTML = newOpenResult;
				}
			}
		}
	}
}

//============================= init end =============================

function closeIframe(){
	parent.document.getElementById('result_new_Data').style.display = "none";
}

//將資料轉成物件
function lib_parseArray(gameHead,gameData){
	var gameObj = new Array();
	for (var i=0; i<gameHead.length; i++){
		gameObj[gameHead[i]] = gameData[i];
	}
	return gameObj;
}


function fix_window(){
	var iframe = parent.document.getElementById('result_new_Data');
	
	var child = document.body.children;
	var Width=0,Height=0;
	for(i=0;i<child.length;i++){
		
		if(child[i].nodeName =="TABLE"){
			Width += child[i].offsetWidth;
			Height += child[i].offsetHeight;
		}
	}
	
	iframe.width = Width;
	iframe.height = Height;
}