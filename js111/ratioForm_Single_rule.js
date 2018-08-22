/*
CRM-230 單盤（without spread）玩法賠率的四捨五入邏輯 (會員端)
*/

//轉換賠率格式

function addZero(code,b){
		code+="";
		var str = "";
		var index = code.indexOf(".");

		if(index==-1){
				code+=".";
				index=code.length-1;
		}

		var r = b*1 - (code.length-index-1);
		for(var i=0; i<r; i++){
				str += "0";
		}
		str = code + str;

		return str;
}

function formatNumber(num, b, add){
		var point = b;
		var t=1;
		for(;b>0;t*=10,b--);
		var n = (b==0)?0:(1/t); //極小數 處理溢位問題
		if(num*1 >= 0){
			if(add) return addZero(Math.round((num*t)+n)/t,point);
			else 	return Math.round((num*t)+n)/t;
		}else{
			if(add) return addZero(Math.round((num*t)-n)/t,point);
			else 	return Math.round((num*t)+n)/t;
		}
}

function chgForm_Single_ratio(odds,wtype){
	//return odds;
    odds = odds*1;
	var isM = chkIsM(wtype);
	var isFS = chkIsFS(wtype);
	var isEven = chkIsEven(wtype);
	//alert("isM->"+", isFS->"+isFS+", wtype->"+wtype+" , odds->"+odds);
	if(isEven)
	{
		return formatNumber(odds,2,2);
	}
	else
	{
		if(!(isM || isFS) && odds == 0){
			return formatNumber(odds,0);
		}else if((isM || isFS) && 10 <= odds && odds < 98.5){		//獨贏or冠軍賠率10~98.5 秀小數點後一位
			return formatNumber(odds,1,1);
		}else if(!(isM || isFS) && 5 <= odds && odds < 20){	//非獨贏賠率5~20 秀小數點後一位
			return formatNumber(odds,1,1);
		}else if(!(isM || isFS) && 20 <= odds ){							//非獨贏賠率大於等於20秀整數
			return formatNumber(odds,0);
		}else if((isM || isFS) && 101 <= odds ){						//獨贏or冠軍賠率大於等於101秀整數
			return formatNumber(odds,0);
		}
		return formatNumber(odds,2,2);
	}

}

function chkIsFS(wtype){
	var isFS = false;

	var ary = new Array();
	ary["FS"] = true;
	ary["SFS"] = true;

	if(ary[wtype] || wtype.indexOf("FS")!=-1){
		isFS = true;
	}

	return isFS;
}

function chkIsM(rtype){
	try{
		rtype = rtype.toUpperCase();
	}catch(e){}
	var isM = false;

	var M_wtype = new Array("A","B","C","D","E","F");
	var F_wtype = new Array("01","02");
	var RF_wtype = new Array("01","02","03","04","05","06","07","08","09","10",
											"11","12","13","14","15","16","17","18","19","20",
											"21","22","23","24","25","26","27","28","29","30",
											"31","32","33","34","35");

	var ary = new Array();
	ary["MH"] = true;
	ary["MC"] = true;
	ary["MN"] = true;
	ary["HMH"] = true;
	ary["HMC"] = true;
	ary["HMN"] = true;
	ary["RMH"] = true;
	ary["RMC"] = true;
	ary["RMN"] = true;
	ary["HRMH"] = true;
	ary["HRMC"] = true;
	ary["HRMN"] = true;

	for(var i = 0;i < M_wtype.length;i++){
		ary[M_wtype[i]+"MH"] = true;
		ary[M_wtype[i]+"MC"] = true;
		ary[M_wtype[i]+"MN"] = true;
	}
	for(var i = 0;i < F_wtype.length;i++){
		ary["F"+F_wtype[i]+"H"] = true;
		ary["F"+F_wtype[i]+"C"] = true;
	}
	for(var i = 0;i < RF_wtype.length;i++){
		ary["RF"+RF_wtype[i]+"H"] = true;
		ary["RF"+RF_wtype[i]+"C"] = true;
	}

	if(ary[rtype]){
		isM = true;
	}

	return isM;
}

function chkIsEven(wtype)
{
	var isEven = false;
	
	var OUHC = new Array("OUH","OUC","HOUH","HOUC");
	var DOUBLE = new Array(
				"EOH","EOC","HEOH","HEOC"
				,"RSH1","RSH2","RSH3","RSH4","RSH5","RSH6","RSH7","RSH8","RSH9","RSHA","RSHB","RSHC","RSHD","RSHE","RSHF","RSHG","RSHH","RSHI","RSHJ","RSHK"
				,"RSHL","RSHM","RSHN","RSHO","RSHP","RSHQ","RSHR","RSHS","RSHT","RSHU"
				,"RSC1","RSC2","RSC3","RSC4","RSC5","RSC6","RSC7","RSC8","RSC9","RSCA","RSCB","RSCC","RSCD","RSCE","RSCF","RSCG","RSCH","RSCI","RSCJ","RSCK"
				,"RSCL","RSCM","RSCN","RSCO","RSCP","RSCQ","RSCR","RSCS","RSCT","RSCU"
				,"RNB1","RNB2","RNB3","RNB4","RNB5","RNB6","RNB7","RNB8","RNB9","RNBA","RNBB","RNBC","RNBD","RNBE","RNBF","RNBG","RNBH","RNBI","RNBJ","RNBK"
				,"RNBL","RNBM","RNBN","RNBO","RNBP","RNBQ","RNBR","RNBS","RNBT","RNBU"
				,"RNC1H","RNC2","RNC3","RNC4","RNC5","RNC6","RNC7","RNC8","RNC9","RNCA","RNCB","RNCC","RNCD","RNCE","RNCF","RNCG","RNCH","RNCI","RNCJ","RNCK"
				,"RNCL","RNCM","RNCN","RNCO","RNCP","RNCQ","RNCR","RNCS","RNCT","RNCU"								
			);
	var OU15 = new Array("AOU","BOU","COU","DOU","EOU","FOU");
	var R15 = new Array("AR","BR","CR","DR","ER","FR");
	var ROU15 = new Array("AROU","BROU","CROU","DROU","EROU","FROU");
	var ROUHC = new Array("ROUH","ROUC","HRUH","HRUC");	
	
	
	var ary = new Array();
	ary["HR"] = true;
	ary["R"] = true;
	ary["HRE"] = true;
	ary["RE"] = true;
	ary["HOU"] = true;
	ary["OU"] = true;
	ary["HROU"] = true;
	ary["ROU"] = true;
	
	for(var i=0;i<OUHC.length;i++){
		ary[OUHC[i]] = true;
	}
	
	for(var i=0;i<DOUBLE.length;i++){
		ary[DOUBLE[i]] = true;
	}

	for(var i=0;i<OU15.length;i++){
		ary[OU15[i]] = true;
	}

	for(var i=0;i<R15.length;i++){
		ary[R15[i]] = true;
	}

	for(var i=0;i<ROU15.length;i++){
		ary[ROU15[i]] = true;
	}

	for(var i=0;i<ROUHC.length;i++){
		ary[ROUHC[i]] = true;
	}
	
	if(ary[wtype])
	{
		isEven = true;
	}

	return isEven;

}