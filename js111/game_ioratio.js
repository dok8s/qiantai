
var AutoRenewID;
var ChkUserTimerID;
var ChkUserTime = 10;
var ReloadTime = 60;
var TimerID = 0;
var gtype =parent.Livegtype;
function onloads(){
	reloadioratio();
}

function unLoad() {
	clearInterval(AutoRenewID);
}

function ResetTimer() {
	try{
		document.getElementById("live_refresh").innerHTML = ReloadTime+"&nbsp;";
	}catch(E){}
	AutoRenewID = setInterval("RenewTimerStr()",1000);
}
function RenewTimerStr() {
	try{
		document.getElementById("live_refresh").innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	}catch(E){}
	if ((ReloadTime - TimerID) <= 1) {
		TimerID = 0;
		reloadioratio();
	} else {
		TimerID++;
		var tmp = (ReloadTime - TimerID);
		if (tmp < 10) { tmp = "&nbsp;&nbsp;"+tmp; }

		try{
			document.getElementById("live_refresh").innerHTML = tmp+"&nbsp;";
		}catch(E){}

	}
}
function reloadioratio(){
	clearInterval(AutoRenewID);
	TimerID = 0;
	try{
		reloadPHP.self.location=o_path;
	}catch(e){
		reloadPHP.src=o_path;
	}

}
function loadioratio(){
	if(gtype && gtype != "All"){
		table_loadioratio();
	}else{
		show_none_div();
	}
	//ResetTimer();
	parent.live_game_heigth();
}


function table_loadioratio(){
	var gdata="";
	var hgdata="";
	var MH,MC,MN,RADIO_REH,REH,RADIO_ROUH,ROUH,RADIO_REC,REC,RADIO_ROUC,ROUC ='';

	var R_ior =Array();
	var OU_ior =Array();
	var HR_ior =Array();
	var HOU_ior =Array();
	var gamenum =0;
	show_none_div();

	var table_str = "table_"+gtype;
	var tmp_table = document.getElementById("table_FT").textContent;
	if(gtype =="TN"||gtype =="VB"||gtype =="BK"||gtype =="BS") {
		var tmp_tr = document.getElementById("tr_ioratio_TN").textContent;
	}else{
		var tmp_tr = document.getElementById("tr_ioratio_FT").textContent;
	}

	for (var i = 0; i < GameData.length; i++) {
		if(GameData[i][50] != parent.gidm)
			continue;
		gamenum ++;
		gdata += tmp_tr;
		hgdata += tmp_tr;
		R_ior  = get_other_ioratio(odd_f_type, GameData[i][9], GameData[i][10] , show_ior);
		OU_ior = get_other_ioratio(odd_f_type, GameData[i][13], GameData[i][14] , show_ior);
		HR_ior = get_other_ioratio(odd_f_type, GameData[i][23], GameData[i][24] , show_ior);
		HOU_ior= get_other_ioratio(odd_f_type, GameData[i][27], GameData[i][28] , show_ior);
		if ((GameData[i][33]*1) <= 0 || (GameData[i][34]*1) <= 0) {
			GameData[i][33]='';
			GameData[i][34]='';
			GameData[i][35]='';
		}
		if ((GameData[i][36]*1) <= 0 || (GameData[i][37]*1) <= 0) {
			GameData[i][36]='';
			GameData[i][37]='';
			GameData[i][38]='';
		}
		//MH = ((GameData[i][33]*1) > 0)? '<a href="javascript:void(0);"  onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_rm.php?gid='+GameData[i][0]+'&uid='+uid+'&langx='+langx+'&type=H&gnum='+GameData[i][3]+'&odd_f_type='+odd_f_type+'\")\' title=\"'+GameData[i][5]+'\"><font '+checkRatio_font(i,33)+' class="bet_bg_color">'+GameData[i][33]+'</font></A>&nbsp;':'&nbsp;' ;
		MH = ((GameData[i][33]*1) > 0)? '<a href="javascript:void(0);"  onClick="parent.parent.mem_order.betOrder(\''+gtype+'\',\'RM\',\'gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&type=H&gnum='+GameData[i][3]+'&langx='+langx+'\');"><font '+checkRatio_font(i,33)+' class="bet_bg_color">'+GameData[i][33]+'</font></A>&nbsp;':'&nbsp;' ;
		

		//MC = ((GameData[i][34]*1) > 0)? '<a href="javascript:void(0);"  onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_rm.php?gid='+GameData[i][0]+'&uid='+uid+'&langx='+langx+'&type=C&gnum='+GameData[i][4]+'&odd_f_type='+odd_f_type+'\")\' title=\"'+GameData[i][6]+'\"><font '+checkRatio_font(i,34)+' class="bet_bg_color">'+GameData[i][34]+'</font></A>&nbsp;' :'&nbsp;';
		MC = ((GameData[i][34]*1) > 0)? '<a href="javascript:void(0);"  onClick="parent.parent.mem_order.betOrder(\''+gtype+'\',\'RM\',\'gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&type=C&gnum='+GameData[i][4]+'&langx='+langx+'\');" title=\"'+GameData[i][6]+'\"><font '+checkRatio_font(i,34)+' class="bet_bg_color">'+GameData[i][34]+'</font></A>&nbsp;' :'&nbsp;';
		
		//MN = ((GameData[i][33]*1) > 0&&(GameData[i][34]*1) > 0&&(GameData[i][35]*1) > 0)? '<A href="javascript:void(0);"  onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_rm.php?gid='+GameData[i][0]+'&uid='+uid+'&langx='+langx+'&type=N&gnum='+GameData[i][4]+'&odd_f_type='+odd_f_type+'\")\' title=\"'+str_even+'\"><font '+checkRatio_font(i,35)+' class="bet_bg_color">'+GameData[i][35]+'</font></A>&nbsp;':'&nbsp;';
		MN = ((GameData[i][33]*1) > 0&&(GameData[i][34]*1) > 0&&(GameData[i][35]*1) > 0)? '<A href="javascript:void(0);"  onClick="parent.parent.mem_order.betOrder(\''+gtype+'\',\'RM\',\'gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&type=N&gnum='+GameData[i][4]+'&langx='+langx+'\');" title=\"'+str_even+'\"><font '+checkRatio_font(i,35)+' class="bet_bg_color">'+GameData[i][35]+'</font></A>&nbsp;':'&nbsp;';
		
		
		RADIO_REH = (GameData[i][7] == 'H')? '<font '+checkRatio_font(i,8)+'>'+GameData[i][8]+'</font>':'&nbsp;';
		
		//REH = '<a href="javascript:void(0);" onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_re.php?gid='+GameData[i][0]+'&uid='+uid+'&langx='+langx+'&type=H&gnum='+GameData[i][3]+'&strong='+GameData[i][7]+'&odd_f_type='+odd_f_type+'\")\' title=\"'+GameData[i][5]+'\"><font '+checkRatio_font(i,9)+' class="bet_bg_color">'+R_ior[0]+'</font></a>';
		REH = '<a href="javascript:void(0);" onClick="parent.parent.mem_order.betOrder(\''+gtype+'\',\'RE\',\'gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&type=H&gnum='+GameData[i][3]+'&strong='+GameData[i][7]+'&langx='+langx+'\');" title=\"'+GameData[i][5]+'\"><font '+checkRatio_font(i,9)+' class="bet_bg_color">'+R_ior[0]+'</font></a>';
		
		RADIO_ROUH = '<font '+checkRatio_font(i,11)+'>'+GameData[i][11]+'</font>';
		
		//ROUH = '<a href="javascript:void(0);" onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_rou.php?gid='+GameData[i][0]+'&uid='+uid+'&langx='+langx+'&type=C&gnum='+GameData[i][4]+'&odd_f_type='+odd_f_type+'\")\' title=\"'+title_strbig+'\"><font '+checkRatio_font(i,14)+' class="bet_bg_color">'+OU_ior[1]+'</font></A>&nbsp;';
		ROUH = '<a href="javascript:void(0);" onClick="parent.parent.mem_order.betOrder(\''+gtype+'\',\'ROU\',\'gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&type=C&gnum='+GameData[i][4]+'&langx='+langx+'\');" title=\"'+title_strbig+'\"><font '+checkRatio_font(i,14)+' class="bet_bg_color">'+OU_ior[1]+'</font></A>&nbsp;';
		
		RADIO_REC = (GameData[i][7] == 'C')? '<font '+checkRatio_font(i,8)+'>'+GameData[i][8]+'</font>':'&nbsp;';
		
		//REC = '<a href="javascript:void(0);" onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_re.php?gid='+GameData[i][0]+'&uid='+uid+'&langx='+langx+'&type=C&gnum='+GameData[i][4]+'&strong='+GameData[i][7]+'&odd_f_type='+odd_f_type+'\")\' title=\"'+GameData[i][6]+'\"><font '+checkRatio_font(i,10)+' class="bet_bg_color">'+R_ior[1]+'</font></a>';
		REC = '<a href="javascript:void(0);" onClick="parent.parent.mem_order.betOrder(\''+gtype+'\',\'RE\',\'gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&type=C&strong='+GameData[i][7]+'&gnum='+GameData[i][4]+'&langx='+langx+'\');" title=\"'+GameData[i][6]+'\"><font '+checkRatio_font(i,10)+' class="bet_bg_color">'+R_ior[1]+'</font></a>';
		
		RADIO_ROUC = '<font '+checkRatio_font(i,12)+'>'+GameData[i][12]+'</font>';
		
		//ROUC = '<a href="javascript:void(0);" onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_rou.php?gid='+GameData[i][0]+'&uid='+uid+'&langx='+langx+'&type=H&gnum='+GameData[i][3]+'&odd_f_type='+odd_f_type+'\")\'title=\"'+title_strsmall+'\"><font '+checkRatio_font(i,13)+' class="bet_bg_color">'+OU_ior[0]+'</font></A>&nbsp;';
		ROUC = '<a href="javascript:void(0);" onClick="parent.parent.mem_order.betOrder(\''+gtype+'\',\'ROU\',\'gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&type=H&gnum='+GameData[i][3]+'&langx='+langx+'\');" title=\"'+title_strsmall+'\"><font '+checkRatio_font(i,13)+' class="bet_bg_color">'+OU_ior[0]+'</font></A>&nbsp;';

		gdata =gdata.replace("*MH*",MH);
		gdata =gdata.replace("*MC*",MC);
		gdata =gdata.replace("*MN*",MN);

		gdata =gdata.replace("*RADIO_REH*",RADIO_REH);
		gdata =gdata.replace("*REH*",REH);
		gdata =gdata.replace("*RADIO_ROUH*",RADIO_ROUH);
		gdata =gdata.replace("*ROUH*",ROUH);

		gdata =gdata.replace("*RADIO_REC*",RADIO_REC);
		gdata =gdata.replace("*REC*",REC);
		gdata =gdata.replace("*RADIO_ROUC*",RADIO_ROUC);
		gdata =gdata.replace("*ROUC*",ROUC);

		MH = ((GameData[i][36]*1) > 0)?'<a href="javascript:void(0);" onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_hrm.php?gid='+GameData[i][20]+'&uid='+uid+'&langx='+langx+'&type=H&gnum='+GameData[i][3]+'&odd_f_type='+odd_f_type+'\")\' title=\"'+GameData[i][5]+'\"><font '+checkRatio_font(i,36)+' class="bet_bg_color">'+GameData[i][36]+'</A></font>&nbsp;':'&nbsp;';
		MC = ((GameData[i][37]*1) > 0)?'<a href="javascript:void(0);" onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_hrm.php?gid='+GameData[i][20]+'&uid='+uid+'&langx='+langx+'&type=C&gnum='+GameData[i][4]+'&odd_f_type='+odd_f_type+'\")\' title=\"'+GameData[i][6]+'\"><font '+checkRatio_font(i,37)+' class="bet_bg_color">'+GameData[i][37]+'</A></font>&nbsp;':'&nbsp;';
		MN = ((GameData[i][36]*1) > 0&&(GameData[i][37]*1) > 0&&(GameData[i][38]*1) > 0)?'<A href="javascript:void(0);" onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_hrm.php?gid='+GameData[i][20]+'&uid='+uid+'&langx='+langx+'&type=N&gnum='+GameData[i][4]+'&odd_f_type='+odd_f_type+'\")\' title=\"'+str_even+'\"><font '+checkRatio_font(i,38)+' class="bet_bg_color">'+GameData[i][38]+'</A></font>&nbsp;':'&nbsp;';
		RADIO_REH = (GameData[i][21] == 'H')?'<font '+checkRatio_font(i,22)+'>'+GameData[i][22]+'</font>':'&nbsp;';
		REH = '<a href="javascript:void(0);"  onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_hre.php?gid='+GameData[i][20]+'&uid='+uid+'&langx='+langx+'&type=H&gnum='+GameData[i][3]+'&strong='+GameData[i][7]+'&odd_f_type='+odd_f_type+'\")\'   title=\"'+GameData[i][5]+'\"><font '+checkRatio_font(i,23)+' class="bet_bg_color">'+HR_ior[0]+'</a>';
		RADIO_ROUH = GameData[i][25];
		ROUH = '<a href="javascript:void(0);" onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_hrou.php?gid='+GameData[i][20]+'&uid='+uid+'&langx='+langx+'&type=C&gnum='+GameData[i][4]+'&odd_f_type='+odd_f_type+'\")\' title=\"'+title_strbig+'\"><font '+checkRatio_font(i,28)+' class="bet_bg_color">'+HOU_ior[1]+'</font></A>&nbsp;';
		RADIO_REC = (GameData[i][21] == 'C')?'<font '+checkRatio_font(i,22)+'>'+GameData[i][22]+'</font>':'&nbsp;';
		REC = '<a href="javascript:void(0);"  onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_hre.php?gid='+GameData[i][20]+'&uid='+uid+'&langx='+langx+'&type=C&gnum='+GameData[i][4]+'&strong='+GameData[i][7]+'&odd_f_type='+odd_f_type+'\")\'   title=\"'+GameData[i][6]+'\"><font '+checkRatio_font(i,24)+' class="bet_bg_color">'+HR_ior[1]+'</a>';
		RADIO_ROUC = GameData[i][26];
		ROUC = '<a href="javascript:void(0);" onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_hrou.php?gid='+GameData[i][20]+'&uid='+uid+'&langx='+langx+'&type=H&gnum='+GameData[i][3]+'&odd_f_type='+odd_f_type+'\")\' title=\"'+title_strsmall+'\"><font '+checkRatio_font(i,27)+' class="bet_bg_color">'+HOU_ior[0]+'</font></A>&nbsp;';

		hgdata =hgdata.replace("*MH*",MH);
		hgdata =hgdata.replace("*MC*",MC);
		hgdata =hgdata.replace("*MN*",MN);

		hgdata =hgdata.replace("*RADIO_REH*",RADIO_REH);
		hgdata =hgdata.replace("*REH*",REH);
		hgdata =hgdata.replace("*RADIO_ROUH*",RADIO_ROUH);
		hgdata =hgdata.replace("*ROUH*",ROUH);

		hgdata =hgdata.replace("*RADIO_REC*",RADIO_REC);
		hgdata =hgdata.replace("*REC*",REC);
		hgdata =hgdata.replace("*RADIO_ROUC*",RADIO_ROUC);
		hgdata =hgdata.replace("*ROUC*",ROUC);

	}

	if(gamenum <= 0){
		console.log(1);
		hide_right_div();
		return;
	}
	tmp_table = tmp_table.replace("*GAMEDATA*",gdata);
	tmp_table = tmp_table.replace("*HGAMEDATA*",hgdata);
	document.getElementById('right_div').innerHTML=tmp_table;

	ResetTimer();
	show_right_div();

}

function gethref(tmlURL){
	parent.document.getElementById("bet_div").style.display = "";
	parent.document.getElementById("bet_order_frame").style.display = "";
	//parent.bet_order_frame.location =tmlURL+"&live=Live";
	parent.bet_order_frame.location.replace(tmlURL+"&live=Live");
}


function getoddf(){
	var tmp_opt="";
	var seloddf="";
	for (i = 0; i < Format.length; i++) {
		//沒盤口選擇時，預設為H(香港變盤)
		if((odd_f_str.indexOf(Format[i][0])!=(-1))&&Format[i][2]=="Y"){
			seloddf =(Format[i][0]==odd_f_type)?"selected":"";
			tmp_opt+= "<option value='"+Format[i][0]+"' "+seloddf+">"+Format[i][1]+"</option>\n";
		}
	}
	tmp_opt = "<select id=\"gameoddf\" name=\"gameoddf\" onChange=\"reloadoddf()\" class=\"select\">\n"+tmp_opt+"</select>";
	return tmp_opt;
}



function reloadoddf(){
	odd_f_type =document.getElementById("gameoddf").value ;
	reloadioratio();
}

function show_right_div(){
	console.log(top.openlive);
	document.getElementById("bet_none").style.display = "none";
	document.getElementById("right_div").style.display = "";
	document.getElementById("live_refresh").style.display = "";
	if(top.openlive!="Y")parent.document.getElementById("bet_box").style.display = "";

}

function hide_right_div(){
	document.getElementById("bet_none").style.display = "";
	document.getElementById("right_div").style.display = "none";
	document.getElementById("live_refresh").style.display = "none";
	if(top.openlive!="Y")parent.document.getElementById("bet_box").style.display = "none";
}

function show_none_div(){
	document.getElementById("none_div").style.display = "";
	document.getElementById("right_div").style.display = "none";
	document.getElementById("live_refresh").style.display = "none";
	if(top.openlive!="Y")parent.document.getElementById("bet_box").style.display = "none";
}
