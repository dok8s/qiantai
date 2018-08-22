var gameAry = new Array("FT","BK","OP","FS");
var select_gtype = "FT";
function init(){
   chgGtype(select_gtype);
}

function chgGtype(gtype){
		if(","+gameAry.join(",")+",".indexOf(","+gtype+",")==-1) return;
		
		for(var i=0; i<gameAry.length; i++){
				var game = gameAry[i];
				document.getElementById("title_"+game).setAttribute("class","");
				document.getElementById("div_"+game).style.display = "none";
		}
		
		document.getElementById("title_"+gtype).setAttribute("class","on");
		
		select_gtype = gtype;
		ShowTable(gtype)
}

function ShowTable(gtype){
	var temp="";
	var txt_table_content="";
	var i,arr;
	var arry = new Object();
	arry["FT"]=new Array("R","RE","M","DT","RDT");
	arry["BK"]=new Array("R","RE","M","DT");
	arry["OP"]=new Array("R","RE","M","DT");
	arry["FS"]=new Array("FS");
	
	var body_T=document.getElementById("div_"+gtype);
	var txt_body_T= clearXmp(body_T.innerHTML);
	var model_tr = document.getElementById("model_tr");
	var tmp_txt_table_content = clearXmp(model_tr.innerHTML);

	for(i=0;i< arry[gtype].length;i++){
		var txt_table_content = tmp_txt_table_content;
		var str_tmp = dataAry[gtype][arry[gtype][i]];
		var TRarray=str_tmp.split('|'); 
		//alert(gtype+'---------'+arry[gtype][i])
		if((gtype =='BK' ||gtype =='OP')&& arry[gtype][i]=='RE')	txt_table_content = txt_table_content.replace("*TYPE*",top.conf_RE_BK);
		else if(gtype =='BK'&& arry[gtype][i]=='M')	txt_table_content = txt_table_content.replace("*TYPE*",top.conf_M_BK);
		else txt_table_content = txt_table_content.replace("*TYPE*",eval('top.conf_'+TRarray[0].toUpperCase()));
			
		txt_table_content = txt_table_content.replace("*S_MATCH*",TRarray[1]);
		txt_table_content = txt_table_content.replace("*S_BET*",TRarray[2]);
		//alert(txt_table_content);
		
		temp+=txt_table_content;
		
	}

	txt_body_T =txt_body_T.replace("*CONTENT*",temp);
  body_T.innerHTML=txt_body_T;
  body_T.style.display = "";
}
 
function clearXmp(innerStr){
	return innerStr.replace("<xmp>","").replace("</xmp>","").replace("<XMP>","").replace("</XMP>","");
} 

function systemMsg(msg){
		util.systemMsg("[mem_conf.js]"+msg);
}

function trace(msg){
		util.trace("[mem_conf.js]"+msg);
}
