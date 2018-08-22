function ShowTable(gtype){
	changeGtype(gtype);
	var temp="";
	var txt_table_content="";
	var i,arr;
	var arry = new Object();
	arry["FT"]=new Array("R","RE","M","DT","RDT");
	arry["BK"]=new Array("R","RE","M","DT");
	arry["OP"]=new Array("R","RE","M","DT");
	arry["FS"]=new Array("R");
	var table_content = document.getElementById("table_content");
	var body_T=document.getElementById("body_T");
	var show_T=document.getElementById("show_T");
	var temp_table_content = clearXmp(table_content.innerHTML);



	var txt_body_T= clearXmp(body_T.innerHTML);
	for(i=0;i< arry[gtype].length;i++){
		var str_tmp = dataAry[gtype][arry[gtype][i]];
		var TRarray=str_tmp.split('|'); 
		txt_table_content = temp_table_content.replace("*TR_CLASS*",'color_bg'+(i%2+1));
		//alert(gtype+'---------'+arry[gtype][i])
		if((gtype =='BK' ||gtype =='OP')&& arry[gtype][i]=='RE')	txt_table_content = txt_table_content.replace("*TYPE*",top.conf_RE_BK);
		else if(gtype =='BK'&& arry[gtype][i]=='M')	txt_table_content = txt_table_content.replace("*TYPE*",top.conf_M_BK);
		else txt_table_content = txt_table_content.replace("*TYPE*",eval('top.conf_'+TRarray[0].toUpperCase()));
			
		txt_table_content = txt_table_content.replace("*S_MATCH*",TRarray[1]);
		txt_table_content = txt_table_content.replace("*S_BET*",TRarray[2]);
		//alert(txt_table_content);
		temp+=txt_table_content;
		
		if(i == 0){
			if(TRarray[3] == "Y"){
				txt_body_T = txt_body_T.replace(/\*LEGSTR\*/g,legStr);
			}else{
				txt_body_T = txt_body_T.replace(/\*LEGSTR\*/g,"");
			}
		}
	}
	
	txt_body_T =txt_body_T.replace("*t_replace*",temp);
  show_T.innerHTML=txt_body_T;
 }
function changeGtype(gtype){
	var arry = new Array("FT","BK","OP","FS");
	for(var i=0;i<arry.length ;i++){
		document.getElementById(arry[i]+"_td").className="btn_out";
	}
	document.getElementById(gtype+"_td").className="btn_on";
}
function clearXmp(innerStr){
	return innerStr.replace("<xmp>","").replace("</xmp>","").replace("<XMP>","").replace("</XMP>","");
}