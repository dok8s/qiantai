<?

include "../include/library.mem.php";
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../include/config.inc.php");
$uid=$_REQUEST['uid'];
$mtype=$_REQUEST['mtype'];
$rtype='fs';
$langx=$_REQUEST['langx'];

require ("../include/traditional.$langx.inc.php");

$sql = "select id,memname,language from web_member where Oid='$uid' and Oid<>'' and Status<>0";

$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}
$row = mysql_fetch_array($result);
$username=$row['memname'];
$mid=$row['id'];
$mdate=date('m-d');
$FStype=$_REQUEST['FStype'];
$mm = 'str_fs_'.$FStype;
$Gname = $$mm;
?>
<html>
<head>
	<meta name="Robots" contect="none">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title></title>
	<link href="/style/member/reset.css" rel="stylesheet" type="text/css">
	<link href="/style/member/bet_maincortol.css" rel="stylesheet" type="text/css">
	<script>
		top["str_input_pwd"]="请输入密码。";
		top["str_input_repwd"]="请输入确认密码。";
		top["str_err_pwd"]="密码确认错误, 请重新输入。";
		top["str_pwd_limit"]="您输入的密码不符合要求：<br>1. 您的新密码必须由 6-12个字母和数字 (A-Z 或 0-9)组成. <br>2. 您的新密码不能和现用密码相同。";
		top["str_pwd_limit2"]="您输入的密码不符合要求：<br>1. 您的新密码必须由 6-12个字母和数字 (A-Z 或 0-9)组成. <br>2. 您的新密码不能和现用密码相同。";
		top["str_pwd_NoChg"]="您的新密码必须和现用密码不一样。";
		top["str_pwd_NowErr"]="您输入的密码不正确，请重试。";
		top["str_pwd_OldErr"]="请输入现用密码。";
		top["str_input_longin_id"]="请输入登录帐号。";
		top["str_longin_limit1"]="您输入的登录帐号不符合要求：<br>1. 您的登入帐号必须由2个英文大小写字母(A-Z或a-z)和数字(0-9)组合, 输入限制6-12字元.<br>2. 您的登入帐号不准许有空格.";
		top["str_longin_limit2"]="您的登录帐号需使用字母加上数字!!";
		top["str_o"]="单";
		top["str_e"]="双";
		top["str_checknum"]="验证码错误,请重新输入";
		top["str_irish_kiss"]="和";
		top["dPrivate"]="私域";
		top["dPublic"]="公有";
		top["grep"]="群组";
		top["grepIP"]="群组IP";
		top["IP_list"]="IP列表";
		top["Group"]="组别";
		top["choice"]="请选择";
		top["account"]="请输入登录帐号。";
		top["password"]="请输入密码。";
		top["S_EM"]="特早";
		top["alldata"]="a全部";
		top["date"]="所有日期";
		top["webset"]="资讯网";
		top["str_renew"]="更新";
		top["outright"]="冠军";
		top["financial"]="金融";
		top["str_FT"]="足球";
		top["str_BK"]="篮球";
		top["str_TN"]="网球";
		top["str_VB"]="排球";
		top["str_BM"]="羽毛球";
		top["str_TT"]="兵乓球";
		top["str_BS"]="棒球";
		top["str_OP"]="其他";
		top["str_score"]="比分";
		top["str_order_FT"]="足球";
		top["str_order_BK"]="篮球 / 美式足球";
		top["str_order_TN"]="网球";
		top["str_order_VB"]="排球";
		top["str_order_BM"]="羽毛球";
		top["str_order_TT"]="兵乓球";
		top["str_order_BS"]="棒球";
		top["str_order_OP"]="其他";
		top["str_fs_FT"]="足球 : ";
		top["str_fs_BK"]="篮球 / 美式足球 : ";
		top["str_fs_TN"]="网球 : ";
		top["str_fs_VB"]="排球 : ";/* No.50 */
		top["str_fs_BM"]="羽毛球 : ";
		top["str_fs_TT"]="兵乓球 : ";
		top["str_fs_BS"]="棒球 : ";
		top["str_fs_OP"]="其他体育 : ";
		top["str_game_list"]="所有球类";
		top["str_date_list"]="所有日期";
		top["str_second"]="秒";
		top["str_demo"]="样本播放";
		top["str_alone"]="独立";
		top["str_back"]="返回";
		top["str_RB"]="滚球";
		top["str_msAll"]="(全场)";
		top["str_ShowMyFavorite"]="我的最爱";
		top["str_ShowAllGame"]="全部赛事";
		top["str_delShowLoveI"]="移出";
		top["str_SortType"]="按时间排序";
		top["str_SortTypeC"]="按联盟排序";
		top["str_SortTypeT"]="按时间排序";
		top["strOver"]="大";
		top["strUnder"]="小";
		top["strOdd"]="单";
		top["strEven"]="双";
		top["message001"]="请输入下注金额。";
		top["message002"]="只能输入数字!!";
		top["message003"]="最低投注额是 ";
		top["message004"]="本场有下注金額最高是 ";
		top["message005"]=" 元限制!!";
		top["message006"]="最高投注额设在";
		top["message007"]="总下注金额已超过单场限额。";
		top["message008"]="本场累积下注共: ";
		top["message009"]="。\n\n总下注金额已超过单场限额。";
		top["message010"]="下注金额不可大于信用额度。";
		top["message011"]="可赢金额：";
		top["message012"]="<br>确定进行下注吗?";
		top["message013"]="确定进行下注吗?<br>";
		top["message014"]="未输入下注金额!!!";
		top["message015"]="下注金额只能输入数字。";
		top["message016"]="\n\n确定进行下注吗?";
		top["message017"]="串1";
		top["message018"]="队联碰";
		top["message019"]="您必须选择至少";
		top["message020"]="个队伍,否则不能下注!!";
		top["message021"]="不接受";
		top["message022"]="串过关投注。";
		top["message023"]="请输入欲下注金额!!";
		top["message024"]="已超过某场次之过关注单限额!!";
		top["message025"]="下注金额不可大于信用额度。";
		top["message026"]="请选择下注队伍!!";
		top["message027"]="单式投注请至单式下注页面下注!!";
		top["message028"]="仅接受";/* No.100 */
		top["message029"]="串投注!!";
		top["message030"]="确定要进行交易吗？";
		top["message031"]="请输入要搜寻的文字";
		top["message032"]="找不到相符项目";
		top["message033"]="你的浏览器不支援";
		top["page"]="页";
		top["refreshTime"]="刷新";
		top["showmonth"]="月";
		top["showday"]="日";
		top["showtoday"]="今日";
		top["showfuture"]="未来";
		top["Half1st"]="上半滚球";
		top["Half2nd"]="下半滚球";
		top["mem_logut"]="您的帐号已登出";
		top["retime1H"]="上半场";
		top["retime2H"]="下半场";
		top["str_otb_close"]="赛事已关闭。";
		top["no_oly"]="您选择的项目暂时没有赛事。请查看冠军玩法。";
		top["conf_R"]="让球,大小,单双";
		top["conf_RE"]="滚球让球,滚球大小,滚球单双";
		top["conf_RE_BK"]="滚球让球,滚球大小,滚球单双";
		top["conf_M"]="独赢,滚球独赢";
		top["conf_M_BK"]="独赢,滚球独赢";
		top["conf_DT"]="其他";
		top["conf_RDT"]="滚球其他";
		top["conf_FS"]="冠军";
		top["str_more"]="更多玩法";
		top["str_all_bets"]="所有玩法";
		top["str_TV_RB"]="视频转播可使用";
		top["str_TV_FT"]="视频转播将在滚球时提供";
		top["addtoMyMarket"]="加到\"我的盘口\"";
		top["str_BK_OT"]="加时";
		top["str_midfield"]="中";
		top["str_BK_Market_Main"]="览看主要盘口";
		top["str_BK_Market_All"]="览看所有盘口 ";
		top["str_BK_Period_View"]="览看赛节投注";
		top["str_BK_Period_Hide"]="隐藏赛节投注 ";
		top["str_TN_Market_Main"]="览看主要盘口";
		top["str_TN_Market_All"]="览看所有盘口";
		top["str_TN_Period_View"]="览看赛盘投注";
		top["str_TN_Period_Hide"]="隐藏赛盘投注";
		top["str_BM_Market_Main"]="览看主要盘口";
		top["str_BM_Market_All"]="览看所有盘口";
		top["str_BM_Period_View"]="览看赛局投注";
		top["str_BM_Period_Hide"]="隐藏赛局投注";
		top["str_TT_Market_Main"]="览看主要盘口";
		top["str_TT_Market_All"]="览看所有盘口";
		top["str_TT_Period_View"]="览看赛局投注";
		top["str_TT_Period_Hide"]="隐藏赛局投注";
		top["str_VB_Market_Main"]="览看主要盘口";
		top["str_VB_Market_All"]="览看所有盘口";
		top["str_VB_Period_View"]="览看赛局投注";
		top["str_VB_Period_Hide"]="隐藏赛局投注";
		top["TN_set_1"]="第一盘";
		top["TN_set_2"]="第二盘";
		top["TN_set_3"]="第三盘";
		top["TN_set_4"]="第四盘";
		top["TN_set_5"]="第五盘";
		top["BM_set_1"]="第一局";
		top["BM_set_2"]="第二局";/* No.150 */
		top["BM_set_3"]="第三局";
		top["BM_set_4"]="第四局";
		top["BM_set_5"]="第五局";
		top["VB_set_1"]="第一局";
		top["VB_set_2"]="第二局";/* No.150 */
		top["VB_set_3"]="第三局";
		top["VB_set_4"]="第四局";
		top["VB_set_5"]="第五局";
		top["VB_set_6"]="第六局";
		top["VB_set_7"]="第七局";
		top["TT_set_1"]="第一局";
		top["TT_set_2"]="第二局";/* No.150 */
		top["TT_set_3"]="第三局";
		top["TT_set_4"]="第四局";
		top["TT_set_5"]="第五局";
		top["TT_set_6"]="第六局";
		top["TT_set_7"]="第七局";
		top["str_VB_Game"]="总局数 : ";
		top["str_VB_allPoint"]="球员总分 : ";
		top["str_VB_point"]="分数 : ";
		top["str_VB_more_r0"]="让局";
		top["str_VB_more_r"]="让分";
		top["str_VB_more_re0"]="让局";
		top["str_VB_more_re"]="让分";/* No.160 */
		top["point"]=".";//點

		/* conf_lvar_01  (3) */
		top.str_HCN=["主","客","无"];

		/* conf_lvar_02  (24) */
		top.strRtypeSP={"PGF":"最先进球","OSF":"最先越位","STF":"最先替补","CNF":"最先角球","CDF":"第一张罚牌","RCF":"最先任意球","YCF":"最先界外球","GAF":"最先球门球","PGL":"最后进球","OSL":"最后越位","STL":"最后替补","CNL":"最后角球","CDL":"最后一张罚牌","RCL":"最后任意球","YCL":"最后界外球","GAL":"最后球门球","PG":"最先/最后进球球队","OS":"最先/最后越位球队","ST":"最先/最后替补球员球队","CN":"最先/最后角球","CD":"第一张/最后一张罚牌","RC":"最先/最后任意球","YC":"最先界外球/最后界外球","GA":"最先/最后球门球"};

		/* conf_lvar_03  (3) */
		top.statu={"HT":"半场","1H":"上半场","2H":"下半场"};

		/* conf_lvar_04  (7) */
		top.str_BK_MS=["","上半场","下半场","第一节","第二节","第三节","第四节"];

		/* conf_session  (41) */
		top._session={"FTi0":"全场","FTi1":"上半","BKi0":"全场","BKi1":"上半","BKi2":"下半","BKi3":"第1节","BKi4":"第2节","BKi5":"第3节","BKi6":"第4节","BSi0":"全场","FSi0":"全场","OPi0":"全场","TNi0":"全场","TNi1":"第一盘","TNi2":"第二盘","TNi3":"第三盘","TNi4":"第四盘","TNi5":"第五盘","TNi6":"让局","TNi7":"主队局数","TNi8":"客队局数","VBi0":"全场","VBi1":"局数","VBi2":"分数","VBi3":"第一局","VBi4":"第二局","VBi5":"第三局","VBi6":"第四局","VBi7":"第五局","VBi8":"第六局","VBi9":"第七局","BMi0":"全场","BMi1":"分数","BMi2":"第一局","BMi3":"第二局","BMi4":"第三局","BMi5":"第四局","BMi6":"第五局","BMi7":"第六局","BMi8":"第七局","TTi0":"全场"};

		/* conf_gtype  (9) */
		top._gtype={"FT":"足球","BK":"篮球","BS":"棒球","FS":"冠军","OP":"其他","TN":"网球","VB":"排球","BM":"羽毛球","TT":"乒乓球"};

		/* conf_lvar_21  (19) */
		top.str_result={"No":"无","Y":"是","N":"否","FG_S":"射门","FG_H":"头球","FG_N":"无进球","FG_P":"点球","FG_F":"任意球","FG_O":"乌龙球","T3G_1":"26分钟以下","T3G_2":"27分钟+","T3G_N":"无进球","T1G_N":"无进球","T1G_1":"0 - 14:59","T1G_2":"15 - 29:59","T1G_3":"30 – 半场","T1G_4":"45 – 59:59","T1G_5":"60 – 74:59","T1G_6":"75 – 全场"};

		var Showtypes="R";
		var ordersR=new Array();
		var ordersOU=new Array();
		var keep_rs_windows="";
		var se="90";
		var sessions="2";
		var keep_action1="";
		var keep_leg="";
		var Ratio=new Array();
		var defaultOpen = true;			// 預設盤面顯示全縮 或是 全打開
		var NoshowLeg=new Array();
		function showgame_table(){
			init();
			//obj_msg = document.getElementById('real_msg');

			start_time=get_timer();
			var AllLayer="";
			var layers="";
			//var shows=showlayers.innerHTML;
			var tr_data="";
			if(document.all){
				var shows=showlayers.innerText;
				tr_data=document.getElementById('glist').innerText;
				//notrdata=document.getElementById('NoDataTR').innerText;
			} else{
				var shows=showlayers.textContent;
				tr_data=document.getElementById('glist').textContent;
				//notrdata=document.getElementById('NoDataTR').textContent;
			}
			notrdata=document.getElementById('NoDataTR').innerText;

			doings="";
			keep_leg="";
			for (i=0;i<gamount;i++){
				gid=GameFT[i][0];
				AllLayer+=layer_screen(gid,tr_data);

			}
			if(AllLayer=="")AllLayer=notrdata;
			var GtypeStr = eval("top.str_order_"+FStype);
			shows = shows.replace("*GTYPE*",GtypeStr);
			shows = shows.replace("*Outright*",top.outright);
			shows = shows.replace("*ShowGame*",AllLayer);
			showgames.innerHTML=shows;



			if (defaultOpen){
				for (i=0;i<gamount;i++){
					gid=GameFT[i][0];
					leg=GameFT[i][2];
					//alert(NoshowLeg[gid])
					if (NoshowLeg[gid+"_"+leg]*1==-1){
						document.getElementById('TR'+gid).style.display="none";
						document.getElementById('TR_1_'+gid).style.display="none";

					}else{
						if (document.getElementById('TR'+gid)!=null){
							document.getElementById('TR'+gid).style.display="";
							document.getElementById('TR_1_'+gid).style.display="";
						}
					}
				}
			}

			var conscroll= document.getElementById('controlscroll');
			conscroll.style.display="none";

			showHOT(gameCount);
			parent.mem_order.getCountHOT(gameCount);
			parent.display_loading(false);

		}
		function layer_screen(gid,layers){
			//檢查賠率是否有變動
			changeRatio=check_ratio(gid).split(",");
			param=getpararm('2');
			gno=gidx[gid];
			layers=layers.replace(/\*GID\*/g,GameFT[gno][0]);/*gid*/
			layers=layers.replace("*TIME*",(GameFT[gno][1]));/*時間*/
			layers=layers.replace(/\*LEG\*/g,GameFT[gno][2]);/*聯盟*/


			if (keep_leg==GameFT[gno][2]) layers=layers.replace("*ST*","style='display: none'");
			else layers=layers.replace("*ST*","");

			//--------------判斷聯盟底下的賽事顯示或隱藏----------------

			if (NoshowLeg[GameFT[gno][0]+"_"+GameFT[gno][2]]==-1){
				//layers=layers.replace(/\*CLASS\*/g,"style='display: none;'");
				layers=layers.replace("*LegMark*","<span id='LegClose'></span>"); //聯盟的小圖
			}else{
				//layers=layers.replace(/\*CLASS\*/g,"style='display: ;'");
				layers=layers.replace("*LegMark*","<span id='LegOpen'></span>");  //聯盟的小圖
			}
			keep_leg=GameFT[gno][2];
			layers=layers.replace("*ITEM*",GameFT[gno][3]); /*場次*/
			if (parent.LegGame.indexOf((GameFT[gno][2]+"_").replace("<br>"," ").replace(" _","_"),0)<0 && parent.LegGame!="ALL" ) return ""; //select game
			if (GameFT[gno][4]=="N"){
				return "";
			}else{
				layers=layers.replace("*CLASS*",'bgcolor=#ffffff');
			}
			var teamdata='';
			var countRec=0;
			result="";
			var style_ = '';
			if (GameFT[gno][5]*1>0){
				for (k=0;k<GameFT[gno][5];k++){
					if (GameFT[gno][6+k*4]=="N") {
						if (GameFT[gno][9+k*4]*1==0) {
							GameFT[gno][9+k*4]="";
						}else{
							GameFT[gno][9+k*4]=printf(GameFT[gno][9+k*4],2);
							param="gametype="+GameFT[i][(GameFT[i].length-1)]+"&gid="+GameFT[i][0]+"&uid="+parent.uid+"&rtype="+GameFT[gno][7+k*4]+"&wtype="+parent.rtype.toUpperCase()+"&langx="+top.langx;
							style_ = " style=\"cursor: pointer;\" onmouseover=\"mouseover_pointer(this);\" onmouseout=\"mouseout_pointer(this);\" onclick=\"parent.mem_order.betOrder('FT','NFS','"+param+"');\""
							if(countRec%2 == 0){
								teamdata += '<tr class="bet_game_small_top" id="TR'+GameFT[i][0]+'">';
							}
								teamdata += '<td class="bet_date_small_left" id="TR_'+GameFT[i][0]+'_2"'+style_+'>';
								teamdata += '<div class="bet_small_table">';
								teamdata += '<span class="bet_small_left">'+GameFT[gno][8+k*4]+'</span>';
								teamdata += '<span class="bet_small_right">';
								teamdata += '<span class="bet_bg_color">';
								teamdata += '<font title="'+GameFT[gno][8+k*4]+'">'+GameFT[gno][9+k*4]+'</font>';
								teamdata += '</span></span></div></td>';
							if(countRec%2 == 1){
								teamdata += '</tr>';
							}
							countRec++;
						}
					}
				}
				if(countRec%2 == 0){
					teamdata += '</tr>';
				}
			}

			orders="";
			layers=layers.replace("*ORDER*",orders);
			layers=layers.replace("*TEAM*",teamdata);


			return layers;
		}

		function getcolor(changeRatio,Rpos){
			if (changeRatio[Rpos]=="1"){
				backgrounds=" style='background-color:yellow' ";
			}else{
				backgrounds="";
			}
			return backgrounds;
		}
		//檢查賠率
		function check_ratio(gid){
			gnos=gidx[gid];
			var changes="";
			if (""+Ratio[gid]=="undefined"){
				Ratio[gid]=new Array();
			}
			for (u=0;u<(GameFT[gnos][5]+1);u++){
				if (""+Ratio[gid][u]!="undefined"){
					if (Ratio[gid][u]!=GameFT[gnos][9+u*4]){
						changes+="1,";
					}else changes+="0,";
				}else changes+="0,";
				eval("Ratio[gid]["+u+"]=GameFT[gnos]["+(9+u*4)+"];");
			}
			return changes;
		}


		function showLEG(gid){
			tmp_leg=GameFT[gidx[gid]][2];
			for (x=0;x < GameFT.length;x++){
				if (tmp_leg==GameFT[x][2]){//&&gid==GameFT[x][0]){
					gid=GameFT[x][0];
					if ((""+NoshowLeg[gid+"_"+tmp_leg])=="undefined"){
						NoshowLeg[gid+"_"+tmp_leg]=-1;
					}else{
						NoshowLeg[gid+"_"+tmp_leg]=NoshowLeg[gid+"_"+tmp_leg]*-1;
					}
					if(document.getElementById('TR'+gid).style.display=="none"){
						document.getElementById('TR'+gid).style.display="";
						document.getElementById('TR_1_'+gid).style.display="";
						document.getElementById(gid+"_"+tmp_leg).innerHTML="<span id='LegOpen'></span>";
					}else{
						document.getElementById(gid+"_"+tmp_leg).innerHTML="<span id='LegClose'></span>";
						document.getElementById('TR'+gid).style.display="none";
						document.getElementById('TR_1_'+gid).style.display="none";
					}
				}
			}





		}

		//===選擇區域===
		function chg_area(){
			var obj_area = document.getElementById('sel_aid');
			sel_area=obj_area.value;
			parent.sel_area=sel_area;
			homepage="reloadgame_"+Showtypes+".php?"+get_pageparam();
			//alert(homepage);
			reloadPHP.location.href=homepage;

		}

		function ShowArea(aid){
			//if ((""+aid=="undefined")) aid="";
			area_data = "";
			var temp = "";
			var temparray = new Array();
			var area = document.getElementById("area");
			var bodyA = document.getElementById("bodyA");
			var show_a = document.getElementById("show_a");
//	var temparea = area.innerText;
			var temparea;
			if(document.all){
				temparea= area.innerText;
			} else{
				temparea = area.textContent ;
			}


			txt_bodyA = bodyA.innerHTML;
			if(areasarray != '') {
				area_data = areasarray.split(",");
				for(i=1; i<area_data.length; i++) {
					temparray = area_data[i].split("*");
					txt_area = temparea.replace("*AREA_ID*",temparray[0]);
					if(aid == temparray[0]) txt_area = txt_area.replace("*SELECT_AREA*","SELECTED");
					else txt_area = txt_area.replace("*SELECT_AREA*","");
					txt_area = txt_area.replace("*AREA_NAME*",temparray[1]);
					temp += txt_area;
				}
				txt_bodyA = txt_bodyA.replace("*SHOW_A*",temp);
			} else {
				txt_bodyA =txt_bodyA.replace("*SHOW_A*","");
			}
			sel_areas.innerHTML=txt_bodyA;
		}

		//===選擇類別===
		function chg_item(){
			var obj_item = document.getElementById('sel_itemid');
			sel_item=obj_item.value;
			parent.sel_item=sel_item;
			homepage="reloadgame_"+Showtypes+".php?"+get_pageparam();
			//alert(homepage);
			reloadPHP.location.href=homepage;

		}

		function ShowItem(FS_items){
			item_data = "";
			var temp = "";
			var temparray = new Array();
			var item = document.getElementById("item");;
			var bodyI = document.getElementById("bodyI");
			var show_i = document.getElementById("show_i");
//	var tempitem = item.innerText;
			var tempitem;
			if(document.all){
				tempitem= item.innerText;
			} else{
				tempitem = item.textContent ;
			}
			txt_bodyI = bodyI.innerHTML;
			if(itemsarray != '') {
				item_data = itemsarray.split(",");
				for(i=1; i<item_data.length; i++) {
					temparray = item_data[i].split("*");
					txt_item = tempitem.replace("*ITEM_ID*",temparray[0]);
					if(FS_items == temparray[0]) txt_item = txt_item.replace("*SELECT_ITEM*","SELECTED");
					else txt_item = txt_item.replace("*SELECT_ITEM*","");
					txt_item = txt_item.replace("*ITEM_NAME*",temparray[1]);
					temp += txt_item;
				}
				txt_bodyI = txt_bodyI.replace("*SHOW_I*",temp);
			} else {
				txt_bodyI =txt_bodyI.replace("*SHOW_I*","");
			}
			sel_items.innerHTML=txt_bodyI;
		}

		//===選擇聯盟===


		function ShowLeague(lid){
			league_data = "";
			var temp = "";
			var temparray = new Array();
			var league = document.getElementById("league");
			var bodyI = document.getElementById("bodyL");
			var templeague;
			if(document.all){
				templeague= league.innerText;
			} else{
				templeague = league.textContent ;
			}

			//var templeague = league.innerText;
			txt_bodyI = bodyI.innerHTML;
			if(leaguearray != '') {
				league_data = leaguearray.split(",");
				for(i=1; i<league_data.length; i++) {
					temparray = league_data[i].split("*");
					txt_league = templeague.replace("*LEAGUE_ID*",temparray[0]);
					if(lid == temparray[0]) txt_league = txt_league.replace("*SELECT_LEAGUE*","SELECTED");
					else txt_league = txt_league.replace("*SELECT_LEAGUE*","");
					txt_league = txt_league.replace("*LEAGUE_NAME*",temparray[1]);
					temp += txt_league;
				}
				txt_bodyI = txt_bodyI.replace("*SHOW_I*",temp);
			} else {
				txt_bodyI =txt_bodyI.replace("*SHOW_I*","");
			}
//			sel_leagues.innerHTML=txt_bodyI;
		}

		function loadingOK(){
			//alert("loadingOK")
			//try{
//			document.getElementById("rsu_refresh").className="rsu_refresh";
			//}catch(E){}

		}
	</script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8 "><script>
		//-------------------onmouse over out變色---------------------------------
		//if(top.uid=="" || self==top || top.document.domain!=document.domain){ top.location="http:/"+"/"+document.domain;}
		var bgclass="";
		var futrue="";
		var GameFT=new Array();
		var gidx=new Array();
		parent.records=40;
		var Npages=1;
		var rang=0;
		var choice="";

		function hasClass(elem, cls) {
			cls = cls || '';
			if (cls.replace(/\s/g, '').length == 0) return false; //当cls没有参数时，返回false
			return new RegExp(' ' + cls + ' ').test(' ' + elem.className + ' ');
		}

		function mouseover_pointer(obj){
			var cls = 'bet_game_bg';
			if (!hasClass(obj, cls)) {
				obj.className = obj.className == '' ? cls : obj.className + ' ' + cls;
			}
		}

		function mouseout_pointer(obj){
			var cls = 'bet_game_bg';
			if (hasClass(obj,cls)) {
				var newClass = ' ' + obj.className.replace(/[\t\r\n]/g, '') + ' ';
				while (newClass.indexOf(' ' + cls + ' ') >= 0) {
					newClass = newClass.replace(' ' + cls + ' ', ' ');
				}
				obj.className = newClass.replace(/^\s+|\s+$/g, '');
			}
		}
		/*
		 ---------------reload time------------------
		 */
		var ReloadTimeID="";
		var showtime=0;
		var LeagueAry=new Array();
		function set_reloadtime(){
			parent.retime = 180;
			parent.loading_var = 'N';
			document.getElementById("MNFS").className="FS"+FStype;
			count_down();
			parent.sel_league=lidURL(eval("top.FS"+FStype+"_lid['FS"+FStype+"_lid_ary']"));
			if(parent.sel_league=="ALL")parent.sel_league="";
			coun_Leagues();
			//alert('reloadgame_'+Showtypes+".php?mid="+parent.mid+"&"+get_pageparam());

			document.getElementById("reloadPHP").onload=iframe_onError;
			reloadPHP.location.href='reloadgame_R.php?uid='+parent.uid+'&mid='+parent.mid+"&"+get_pageparam();
		}

		function iframe_onError(){
			var iframe = document.getElementById("reloadPHP");

			try{
				check = iframe.contentWindow.document.body.onload;
			}catch(e){
				check = null;
			}

			if(check == null){
				iframe.times = iframe.times || 0;
				showerror(iframe);
			}else{
				iframe.times = 0;
			}
		}

		function showerror(e){
			e.times+=1;
			if(e.times > 10)	return;
//			setTimeout('set_reloadtime()',5000);
		}

		function lidURL(str){
			var showstr="";
			var strray=str.split('-');
			for(var i =0;i<strray.length;i++){
				if(strray[i]=="")continue;
				if(showstr!=""){
					showstr+="-";
				}
				showstr+=strray[i];
			}
			return showstr;
		}
		function coun_Leagues(){
			var coun=0;
			var str_tmp ="-"+eval("top.FS"+FStype+"_lid['FS"+FStype+"_lid_ary']");
			if(str_tmp=='-ALL'){
				document.getElementById("str_num").innerHTML =top.alldata;
			}else{
				var larray=str_tmp.split('-');

				for(var i =0;i<larray.length;i++){
					if(larray[i]!=""){coun++}
				}
				document.getElementById("str_num").innerHTML =coun;
			}
		}
		function reloadtime(){

			//reloadPHP.location.href='reloadgame_'+Showtypes+".php?uid="+top.uid+"&langx="+top.langx+"&mid="+top.mid;
			parent.sel_item="";
			reloadPHP.location.href='reloadgame_'+Showtypes+".php?mid="+parent.mid+"&"+get_pageparam();
			setrefesh();

		}
		function setrefesh(){
			//alert("reladtime-------"+top.retime);
			clearInterval(ReloadTimeID);
			if ((""+parent.retime=="undefined") || parent.retime=="") parent.retime="X";
			if (parent.retime != 'X' ){ReloadTimeID = setInterval("reload_var()",parent.retime*1000);}
		}
		function refreshReload(level,fake){
			set_reloadtime();
		}
		function reload_var(Level){
			parent.retime = 180;
			parent.sel_league=lidURL(eval("top.FS"+FStype+"_lid['FS"+FStype+"_lid_ary']"));
			if(parent.sel_league=="ALL")parent.sel_league="";
			coun_Leagues();
			reloadPHP.location.href='reloadgame_'+Showtypes+".php?mid="+parent.mid+"&"+get_pageparam();
		}
		/*
		 ----------------功能menu--------------
		 */
		//function change_game(gtype,vals,gid)
		//{
		//if ((gtype=="gopen" || gtype=="strong") && (vals!="all"))
		//	a=confirm(eval("str_"+gtype+vals));
		//else a=true;
		//if (a==true){
		//	alert('FT_Game_change.php?gid='+gid+"&"+gtype+"="+vals+"&ShowType="+Showtypes+"&"+get_pageparam());
		//	self.location.href='FT_Game_change.php?gid='+gid+"&"+gtype+"="+vals+"&ShowType="+Showtypes+"&"+get_pageparam();
		//	}
		//}
		/*
		 公用 FUNC
		 */

		function printf(vals,points){ //小數點位數
			vals=""+vals;
			var cmd=new Array();
			cmd=vals.split(".");
			if (cmd.length>1){
				for (ii=0;ii<(points-cmd[1].length);ii++)vals=vals+"0";
			}else{
				vals=vals+".";
				for (ii=0;ii<points;ii++)vals=vals+"0";
			}
			return vals;
		}

		function get_timer(){return (new Date()).getTime();} // 計數器
		/*
		 鍵盤
		 */
		document.onkeypress=checkfunc;
		function checkfunc(e) {
			switch(event.keyCode){
			}
		}

		function CheckKey(){
			if(event.keyCode == 13) return true;
			if (event.keyCode!=46){
				if((event.keyCode < 48 || event.keyCode > 57))
				{
					alert(top.str_only_keyin_num);	/*僅能接受數字!!*/
					return false;
				}
			}
		}
		/*
		 parser 球頭
		 */
		function get_cr_str(cr){
			var crs=new Array();
			var word ="";
			if (cr.indexOf("+")>0) {
				crs=cr.split("+");
				if(crs[0]=="0"){
					if(crs[1]=="0") word = crs[1].replace('0',top.str_ratio[0]);
				}else{
					switch(crs[1]){
						case '100':
							//alert(cr);
							if(crs[0]*1==1){
								word =top.str_ratio[1];
							}else{

								word =""+(crs[0]*1 - 0.5);

								word = word.replace('.5',top.str_ratio[2]);
							}
							break;
						case '50':
							if(crs[0]*1==1){
								word =top.str_ratio[1]+"&nbsp;/&nbsp;"+crs[0]+top.str_ratio[3];
							}else{
								word =(crs[0]*1 - 0.5)+"&nbsp;/&nbsp;"+crs[0]+top.str_ratio[3];
								word = word.replace('.5',top.str_ratio[2]);
							}
							break;
						case '0':
							word = crs[0]+top.str_ratio[3];
							break;
					}
				}
			}

			if (cr.indexOf("-")>0) {
				crs=cr.split("-");
				crs[1]="-"+crs[1];
				if(crs[0]=="0")	word = top.str_ratio[0]+"&nbsp;/&nbsp;"+top.str_ratio[1];
				else{
					word =crs[0]+top.str_ratio[3]+"&nbsp;/&nbsp;"+(1+crs[0]*1 - 0.5);
					word = word.replace('.5',top.str_ratio[2]);
				}

			}
			if(word=="") return cr;
			return word;
		}

		function get_ou_str(cr){

			var crs=new Array();
			var word ="";
			if (cr.indexOf("+")>0) {
				crs=cr.split("+");
				if(crs[0]=="0"){
					if(crs[1]=="0") word = crs[1];
					if(crs[1]=="50") word = crs[0]+" / "+(crs[0]*1+1 - 0.5);
				}else{
					switch(crs[1]){
						case '100':
							word =crs[0]*1 - 0.5;
							break;
						case '50':
							word =(crs[0]*1 - 0.5)+"&nbsp;/&nbsp;"+crs[0];
							break;
						case '0':
							word =crs[0];
							break;
					}
				}
			}

			if (cr.indexOf("-")>0) {
				crs=cr.split("-");
				crs[1]="-"+crs[1];
				word =crs[0]+"&nbsp;/&nbsp;"+(1+crs[0]*1 - 0.5);
			}


			if(word=="")return cr;
			return word;
		}
		function  change_time(get_time){
			var dates=get_time.split(" ");
			if (dates.length>1) get_time=dates[1];
			gtime=get_time.split(":");
			if (gtime[0]>12){
				return dates[0].substring(5,10) + "<br>" +(gtime[0]*1-12)+":"+gtime[1]+"p";
			}else if(gtime[0] == 12){
				return dates[0].substring(5,10) + "<br>" +gtime[0]+":"+gtime[1]+"p";
			}

			return dates[0].substring(5,10) + "<br>" +gtime[0]+":"+gtime[1]+"a";
		}
		/*
		 設定分頁
		 */
		function setpage(){

			//document.getElementById('times').innerHTML=nowtime;

			var pagehtml="";

			if (""+top.pages=="undefined") top.pages=1;
			if (top.pages<=1) top.pages=1;

			if (gamount<=(top.records*(top.pages-1))) top.pages=1;

			for (cc=1;cc<=(Math.floor(gamount/top.records)+1);cc++){
				if (top.pages==cc)
					pagehtml+=" <font color=red>"+cc+"</font>";
				else
					pagehtml+=" <font style='cursor:hand' onclick=change_page('"+cc+"')>"+cc+"</font> ";
			}

			document.getElementById('pages').innerHTML=pagehtml;
		}
		function change_page(pages){
			top.pages=pages;

			homepage="reloadgame_"+Showtypes+".php?"+get_pageparam();
			//alert(homepage);
			reloadPHP.location.href=homepage;
		}
		function show_xy(){
			try{
				if (rs_window.style.visibility=="visible"){
					top_y=document.body.scrollTop;
					rs_window.style.top=top_y+200;
				}
			}catch(E){}
		}
		function show_layer(showlayer,scrollY){

			try{
				if (eval(showlayer+".style.visibility=='visible'")){
					top_y=document.body.scrollTop;
					eval(showlayer+".style.top=top_y+"+scrollY);
				}
			}catch(E){}
		}


		function change_showtype(){
			top.pages=1;
			ptypes=document.getElementById('ptype').options[document.getElementById('ptype').selectedIndex].value;
			homepage="loadgame_"+ptypes+".php?"+get_pageparam();
			//alert(homepage);
			window.location.href=homepage;
		}
		function show_showRecord()
		{
			if (""+top.records=="undefined") top.records=-1;
			j=0;
			for(i=0;i<document.getElementById('showRecord').length;i++){
				if(document.getElementById('showRecord').options[i].value==top.records) document.getElementById('showRecord').selectedIndex=j;
				j++;
			}


		}
		function set_showRecord()
		{
			top.pages=1;
			top.records=document.getElementById('showRecord').options[document.getElementById('showRecord').selectedIndex].value;
			homepage="loadgame_"+Showtypes+".php?"+get_pageparam();
			window.location.href=homepage;
		}

		var keepsec="";
		function init(){
			if ((parent.LegGame=="") || (""+parent.LegGame=='undefined')) parent.LegGame="ALL";
		}

		function get_pageparam(){
			if (choice=="") choice="ALL";
			if (!parent.LegGame) parent.LegGame="";
			if (!parent.pages) parent.pages=1;
			if (!parent.records) parent.records=-1;
			if ((parent.sel_league=="") || (""+parent.sel_league=="undefined"))parent.sel_league="";
			if ((parent.sel_item=="") || (""+parent.sel_item=="undefined"))parent.sel_item="";
			if ((parent.sel_area=="") || (""+parent.sel_area=="undefined"))parent.sel_area="";
			return parent.base_url+"&choice="+choice+"&LegGame="+parent.LegGame+"&pages="+parent.pages+"&records="+parent.records+"&FStype="+FStype+"&area_id="+parent.sel_area+"&league_id="+parent.sel_league+"&rtype="+parent.rtype+"&hot_game="+top.hot_game; //+"&item_id="+parent.sel_item
		}

		function getpararm(se){
			gtype="FS";
			param=parent.uid+","+gtype+","+se;
			return param;
		}
		function getpararmP(){
			gtype="FS";
			param=parent.uid+","+gtype;
			return param;
		}
		function lostFocus(thisButton){
			thisButton.blur();
		}

		var keep_drop_layers;
		var dragapproved=false;
		var iex;
		var iey;
		var tempx;
		var tempy;
		if (document.all){
			document.onmouseup=new Function("dragapproved=false;");
		}
		function initializedragie(drop_layers){
			keep_drop_layers=drop_layers;
			iex=event.clientX
			iey=event.clientY
			eval("tempx="+drop_layers+".style.pixelLeft")
			eval("tempy="+drop_layers+".style.pixelTop")
			dragapproved=true;
			document.onmousemove=drag_dropie;
		}
		function drag_dropie(){
			if (dragapproved==true){
				eval("document.all."+keep_drop_layers+".style.pixelLeft=tempx+event.clientX-iex");
				eval("document.all."+keep_drop_layers+".style.pixelTop=tempy+event.clientY-iey");
				return false
			}
		}

		function Euro(){
			if(top.hot_game!=""){
				top.hot_game="";
				top.swShowLoveI=false;
				document.getElementById("euro_btn").style.display='';
				document.getElementById("euro_up").style.display='none';
			}else{
				top.hot_game="HOT_";
				document.getElementById("euro_btn").style.display='none';
				document.getElementById("euro_up").style.display='';

			}
			reload_var();

		}

		function Eurover(act){
			if(act.className=="euro_btn"){
				act.className='euro_over';
			}else if(act.className=="euro_up"){
				act.className='euro_up_over';
			}
		}

		function Eurout(act){
			if(act.className=="euro_over"){
				act.className='euro_btn';
			}else if(act.className=="euro_up_over"){
				act.className='euro_up';
			}
		}

		var gameCount="";
		var recordHash=new Array();
		function showHOT(countHOT){

			if( (""+countHOT=="") || (""+countHOT=="undefined") ){

				//document.getElementById("euro_btn").style.display="none";
				//document.getElementById("euro_up").style.display="none";

			}else{

				if(""+top.hot_game=="undefined"){
					top.hot_game="";
				}

				var countgames=countHOT.split(",");

				for( var i=1;i<countgames.length;i++){
					var detailgame=countgames[i].split("|");
					recordHash[detailgame[0]+"_"+detailgame[1]]=detailgame[2]*1;
				}

				if(recordHash["FS_HOT_"+FStype]*1==0){
					//document.getElementById("euro_btn").style.display="none";
					//document.getElementById("euro_up").style.display="none";

					if(top.hot_game!=""){
						top.hot_game="";
						reload_var();
					}

				}else{
					/*if(top.hot_game!=""){
					 document.getElementById("euro_btn").style.display="none";
					 document.getElementById("euro_up").style.display="";
					 }else{
					 document.getElementById("euro_btn").style.display="";
					 document.getElementById("euro_up").style.display="none";
					 }*/

				}

			}

		}
	</script>
	<script>
		var FStype='<?=$FStype?>';
		parent.uid='<?=$uid?>';
		parent.username='<?=$username?>';
		parent.langx='<?=$langx?>';
		parent.base_url='uid=<?=$uid?>&langx=<?=$langx?>';
		parent.sel_gtype='FS<?=$FStype?>';
		parent.rtype='<?=$rtype?>';
		parent.retime=180;
	</script>
	<script src="/js/jquery-3.1.0.min.js"></script>
	<script src="/js/body/common.js"></script>
</head>

<body id="MNFS" onLoad="set_reloadtime();" class="bet_rmax_FS">
<div  id="max_leg">
	<div id=fixhead_layer class="fixhead_layer">
		<div class="bet_head">
			<!--左侧按钮-->
			<div class="bet_left">
				<span id="sel_league" onClick="chg_league();" class="bet_league_btn"><tt class="bet_normal_text">选择联赛&nbsp;<tt id="str_num" class="bet_yellow">(全部)</tt></tt></span>
				<span id="show_pg_chk" style="display:none;" class="bet_paging"><label><input id="pg_chk" onClick="clickChkbox();" type="checkbox"  class="bet_selsect_box" value="C" id="box_C"><span></span><span class="bet_more_chk">分頁</span></label></span>
				<div id="show_pg_chk_msg" style="display:none;" class="bet_game_head_i"><div class="bet_head_i_bg"><span class="bet_head_iarrow_text">如您觉得网页运行缓慢,请选分页，<br>这会限制每页显示的比赛场数。</span></div></div>
			</div>
			<!--右侧按钮-->
			<div class="bet_right">
				<span class="bet_time_btn" onClick="javascript:refreshReload('',true)"><tt id="refreshTime" class="bet_time_text">刷新</tt></span>
			</div>
		</div>
	</div>
</div>
<!--奥运-->
<div id="LoadLayer"></div>
<div id="showlayers" style="display:none;">
	<xmp>
		<table cellpadding="0" cellspacing="0" border="0" class="bet_game_table">
			<tr id="title_tr" name="fixhead_copy" class="bet_game_title">
				<td colspan="2" class="bet_game_name">*GTYPE*<br><tt class="bet_game">*Outright*</tt></td>
			</tr>
			*ShowGame*
		</table>
		<div id="show_page_txt" style="display:none;" class="bet_page_bot">
		</div>
	</xmp>
</div>
<div id="glist" style="display: none"-->
	<xmp>
		<tr *ST* class="bet_game_league">
			<td id="*GID*_*LEG*" onClick="showLEG('*GID*')" colspan="2">*LEG*<span class="bet_corr_number">*TIME*</span></td>
		</tr>
		<tr class="bet_date_small_title" id="TR_1_*GID*">
			<td colspan="2">
				<span>*ITEM*</span>
			</td>
		</tr>
		*TEAM*
	</xmp>
</div>
<div id="NoDataTR" style="display:none;">
	<xmp>
		<tr>
			<td colspan="20" class="bet_no_game">您选择的项目暂时没有赛事。</td>
		</tr>
	</xmp>
</div>




<div id="showgames" class="showtable_normal"></div>
<div id="showtable" class="showtable_normal"></div>

<div id=NoDataTR style="display:none;">
	<td colspan="20" class="no_game"><span class="no_game_fox"><?=$meisai?></span></td>
</div>

<!----------------------更改下拉视窗---------------------------->
<!--区域 START-->
<span id="area" style="position:absolute; display: none">
	<xmp>
		<option value="*AREA_ID*" *SELECT_AREA*>*AREA_NAME*</option>
	</xmp>
</span> <span id="bodyA" style="position:absolute; display: none">
<select id="sel_aid" name="sel_aid" onChange="chg_area();" class="za_select">
	<option value=""><?=$alldata?></option>

	*SHOW_A*

</select>
</span>
<!--区域 END-->
<!--类别 START-->
<span id="item" style="position:absolute; display: none">
	<xmp>
		<option value="*ITEM_ID*" *SELECT_ITEM*>*ITEM_NAME*</option>
	</xmp>
</span> 
<span id="bodyI" style="position:absolute; display: none">
<select id="sel_itemid" name="sel_itemid" onChange="chg_item();" class="za_select">
	<option value=""><?=$alldata?></option>
	*SHOW_I*
</select>
</span>
<!--类别 END-->
<!--联盟 START-->
<span id="league" style="position:absolute; display: none">
	<xmp>
		<option value="*LEAGUE_ID*" *SELECT_LEAGUE*>*LEAGUE_NAME*</option>
	</xmp>
</span> 
<span id="bodyL" style="position:absolute; display: none">
<select id="sel_leagueid" name="sel_leagueid" onChange="chg_league();"  class="za_select">
	<option value=""><?=$alldata?></option>

	*SHOW_I*

</select>
</span>
<!--联盟 END-->
<!--选择联赛-->
<div id="legView" style="display:none;" class="legView">
	<div class="leg_head" onMousedown="initializedragie('legView')"></div>
	<div><iframe id="legFrame" frameborder="no" border="0" allowtransparency="true" height="100%" width="830px"></iframe></div>
	<div class="leg_foot"></div>
</div>
<iframe id=reloadPHP name=reloadPHP  style=display:none ></iframe>
<div id="controlscroll"  style="position:absolute;"><table border="0" cellspacing="0" cellpadding="0" class="loadBox"><tr><td><!--loading--></td></tr></table></div>
</body>
</html>


