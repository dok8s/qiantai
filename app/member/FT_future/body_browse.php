<?
include "../include/library.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$mtype=$_REQUEST['mtype'];
$rtype=trim($_REQUEST['rtype']);
$langx=$_REQUEST['langx'];
$g_date=$_REQUEST['g_date'];
$hot_game=$_REQUEST['hot_game'];
$sql = "select * from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
$memname=$row['Memname'];
//userlog($memname);
require ("../include/traditional.$langx.inc.php");
if ($langx=='en-us'){
	$css='_en';
}
$tab_id="id=game_table";
// table
$zao = $zaopan;
require ("../body/body_table_FT.php");
switch ($rtype){
	case "r":
		$caption=$zuqiuzp;
		$upd_msg=$udpsecond;
		$table=$table0;
		break;
	case "hr":
		$caption=$hsthalf;
		$upd_msg=$ManualUpdate;
		$table=$table1;
		break;
	case "re":
		$caption=$RunningBall;
		$upd_msg=$udpsecond;
		$table=$table2;
		break;
	case "hre":
		$caption=substr($hsthalf,0,4).$RunningBall;
		$upd_msg=$udpsecond;
		$table=$table2;
		break;
	case "t":
		$caption=$zuqiuzp.":".$dans;
		$upd_msg=$RqPaicai;
		$table=$table3;
		break;
	case "f":
		$caption=$zuqiuzp.":".$banquan;
		$upd_msg=$Paicai;
		$table=$table4;
		break;
	case "pd":
		$caption=$zuqiuzp.":".$Correctscore;
		$upd_msg=$BdPaicai;
		$table=$table9;
		break;
	case "hpd":
		$caption=$zuqiuzp.":".$bodan;
		$upd_msg=$BdPaicai;
		$table=$table5;
		break;
	case "pr":
		$caption=$HandicapParlay;
		$tab_id="";
		$upd_msg=$Paicai;
		$table=$table6;
		break;
	case "p":
		$caption=$Parlay;
		$tab_id="";
		$upd_msg=$Paicai;
		$table=$table7;
		break;
	case "p3":
		$caption=$zuqiuzp.":".$zhgg;
		$tab_id='id="p3"';
		$upd_msg=$Paicai;
		$table=$table8;
		$id='P3';
		break;
}
?>
<? if($rtype<>"r"){?>
	<html>
	<head>
		<title></title>
		<link href="/style/member/reset.css" rel="stylesheet" type="text/css">
		<link href="/style/member/bet_maincortol.css" rel="stylesheet" type="text/css">
		<script>
			var DateAry = new Array('<?=date('Y-m-d',strtotime('1 day'))?>','<?=date('Y-m-d',strtotime('2 day'))?>','<?=date('Y-m-d',strtotime('3 day'))?>','<?=date('Y-m-d',strtotime('4 day'))?>','<?=date('Y-m-d',strtotime('5 day'))?>','<?=date('Y-m-d',strtotime('6 day'))?>','<?=date('Y-m-d',strtotime('7 day'))?>','<?=date('Y-m-d',strtotime('8 day'))?>','<?=date('Y-m-d',strtotime('9 day'))?>','<?=date('Y-m-d',strtotime('10 day'))?>','<?=date('Y-m-d',strtotime('11 day'))?>');
			top.today_gmt = '<?=date('Y-m-d')?>';
			top.sel_gd = '<?=$g_date?>';
			g_date = '<?=$g_date?>';
			var rtype = '<?=$rtype?>';
			var odd_f_str = 'H,M,I,E';
			var Format=new Array();
			Format[0]=new Array( 'H','<?=$ODDS[HH];?>','Y');
			Format[1]=new Array( 'M','<?=$ODDS[MM];?>','Y');
			Format[2]=new Array( 'I','<?=$ODDS[II];?>','Y');
			Format[3]=new Array( 'E','<?=$ODDS[EE];?>','Y');
		</script>

		<script>
			var ReloadTimeID;
			var sel_gtype=parent.sel_gtype;

			//網頁載入
			function onLoad(){
				top.swShowLoveI=false;
				if((""+eval("parent."+sel_gtype+"_lname_ary"))=="undefined") eval("parent."+sel_gtype+"_lname_ary='ALL'");
				if((""+eval("parent."+sel_gtype+"_lid_ary"))=="undefined") eval("parent."+sel_gtype+"_lid_ary='ALL'");
				if(parent.ShowType==""||rtype=="r") parent.ShowType = 'OU';
				if(rtype=="hr") parent.ShowType = 'OU';
				if(rtype=="re") parent.ShowType = 'RE';
				if(rtype=="pd") parent.ShowType = 'PD';
				if(rtype=="hpd") parent.ShowType = 'HPD';
				if(rtype=="t") parent.ShowType = 'EO';
				if(rtype=="f") parent.ShowType = 'F';
				if(parent.parent.leg_flag=="Y"){
					parent.parent.leg_flag="N";
					parent.pg=0;
					reload_var("");
				}else{
					showPicLove();
				}
				parent.loading = 'N';
				if(parent.loading_var == 'N'){
					parent.ShowGameList();
					obj_layer = document.getElementById('LoadLayer');
					obj_layer.style.display = 'none';
				}
				if (parent.retime_flag == 'Y'){
					//ReloadTimeID = setInterval("reload_var()",parent.retime*1000);
					count_down();
				}else{
					var rt=document.getElementById('refreshTime');
					rt.innerHTML=top.refreshTime;
				}
				document.getElementById("odd_f_window").style.display = "none";
				if(sel_gtype=="FU"){
					if (rtype!="r"){
						if(top.showtype!='hgft'){
							selgdate(rtype);
						}
					}
				}

				gameSort();

			}

			window.onscroll = scroll;


			function saveSortType(){
				if(top.SortType == document.getElementById("SortSel").value ) {
					refreshReload();
					return;
				}else{
					top.SortType = document.getElementById("SortSel").value;
					reload_var("");
				}
			}
			function gameSort(){
				if(top.SortType=="") top.SortType="T";
				document.getElementById("SortSel").value = top.SortType;
			}

			function scroll(){}

			function reload_var(Level){
				showPicLove();
				parent.loading_var = 'Y';
				if(Level=="up"){
					var tmp = "./"+parent.sel_gtype+"_browse/body_var.php";
					if (parent.sel_gtype=="FU"){
						tmp = "./FT_future/body_var.php";
					}
				}else{
					var tmp = "./body_var.php";
				}

				var l_id =eval("parent.parent."+sel_gtype+"_lid_type");
				if(top.showtype=='hgft'&&parent.sel_gtype=="FU"){
					l_id=3;
				}
				if(parent.rtype == "p3") top.hot_game="";
				var homepage = tmp+"?uid=<?=$uid?>&rtype=<?=$rtype?>&langx=<?=$langx?>&mtype=4&page_no="+parent.pg+"&league_id="+l_id+"&hot_game="+top.hot_game;
				//alert("parent.g_date==>"+parent.g_date)
				if (parent.sel_gtype=="FU"){
					homepage+="&g_date="+parent.g_date;
				}

				parent.body_var.location = homepage;
				if(rtype=="r") document.getElementById('more_window').style.display='none';


			}






			//倒數自動更新時間
			function count_down(){
				var rt=document.getElementById('refreshTime');
				if(parent.retime=="" || parent.retime==0){
					rt.innerHTML="<?=$shuxin?>";}
				setTimeout('count_down()',1000);
				if (parent.retime_flag == 'Y'){
					if(parent.retime <= 0){
						if(parent.loading_var == 'N')
							reload_var("");
						return;
					}
					parent.retime--;
					rt.innerHTML=parent.retime;
					//alert(parent.retime);
					//obj_cd = document.getElementById('cd');
					//obj_cd.innerHTML = parent.retime;
				}
			}



			//賽事換頁
			function chg_pg(pg){
				if (pg==parent.pg) {return;}
				parent.pg=pg;
				reload_var("");
			}

			function chg_wtype(wtype){
				var l_id =eval("parent.parent."+sel_gtype+"_lid_type");
				if(top.swShowLoveI) l_id=3;
				if(top.showtype=='hgft'&&parent.sel_gtype=="FU"){
					l_id=3;
				}
				parent.location.href="index.php?uid=<?=$uid?>&langx=<?=$langx?>&mtype="+parent.ltype+"&rtype="+wtype+"&showtype=&league_id="+l_id;

				//<frame name="body_var" scrolling="NO" noresize src="body_var.php?uid=<?echo $uid?>&rtype=<?echo $rtype?>&langx=<?echo $langx?>&mtype=<?echo $mtype;?>&delay=<?echo $delay;?>&league_id=<?echo $league_id?>">
				//<frame name="body_browse" src="body_browse.php?uid=<?echo $uid?>&rtype=<?echo $rtype?>&langx=<?echo $langx?>&mtype=<?echo $mtype;?>&delay=<?echo $delay;?>&showtype=<?echo $showtype?>">


			}

			//選擇聯盟=================start


			//選擇聯盟=================end
			function unload(){
				clearInterval(ReloadTimeID);
			}
			window.onunload=unload;

			//-----------------------------future------------------------

			function arraySort1(array ,data){
				var outarray =new Array();
				var newarray =new Array();
				for(var i=0;i < array.length ;i++){
					if(array[i]<= data){
						outarray.push(array[i]);
					}else{
						newarray.push(array[i]);
					}
				}
				outarray.push(data);
				for(var i=0;i < newarray.length ;i++){
					outarray.push(newarray[i]);
				}
				return  outarray;
			}

			//切換日期
			function chg_gdate(){

				var obj_gdate = document.getElementById("g_date");

				parent.g_date=obj_gdate.value;
				parent.pg=0;
				reload_var("");
			}

			//====== 取表格 TD 的x軸
			function GetTD_X(TD_lay,GetTableID){
				alert(GetTableID);
				alert(document.getElementById(GetTableID))
				var TBar = document.getElementById(GetTableID);
				var td_x = TD_lay;
				for(var i=0; i < TBar.rows[0].children.length; i++){
					if (i == TD_lay) { break; }
					td_x += TBar.rows[0].children[i].clientWidth;
				}
				return td_x;
			}
			//====== 取表格 TD 的y軸
			function GetTD_Y(AryIndex,GetTableID){
				var TBar = document.getElementById(GetTableID);
				var td_y = parseInt(AryIndex)+2;

				for(var i=0; i <= parseInt(AryIndex)+1; i++){
					try{
						td_y += TBar.rows[i].clientHeight;
					} catch (E){
						td_y += TBar.rows[i-1].clientHeight;
					}
				}
				return td_y;
			}




			//----------------------------我的最愛  start----------------------------------
			function showPicLove(){
				var gtypeNum= StatisticsGty(top.today_gmt,top.now_gmt,getGtypeShowLoveI());
				try{
					document.getElementById("fav_num").style.display = "none";
					document.getElementById("showNull").style.display = "none";
					document.getElementById("showAll").style.display = "none";
					document.getElementById("showMy").style.display = "none";
					if(gtypeNum!=0){
						document.getElementById("live_num").innerHTML =gtypeNum;
						document.getElementById("fav_num").style.display = "block";
						if(top.swShowLoveI){
							document.getElementById("showAll").style.display = "block";
						}else{
							document.getElementById("showMy").style.display = "block";
						}
					}else{
						document.getElementById("showNull").style.display = "block";
						top.swShowLoveI=false;
					}
				}catch(E){}
			}
			//我的最愛中的顯示全部
			function showAllGame(gtype){
				top.swShowLoveI=false;

				//eval("parent.parent."+parent.sel_gtype+"_lid_type=''");
				eval("parent.parent."+parent.sel_gtype+"_lid_type=top."+parent.sel_gtype+"_lid['"+parent.sel_gtype+"_lid_type']");
				reload_var("");
			}

			//單式盤面點下我的最愛
			function showMyLove(gtype){
				top.swShowLoveI =true;

				parent.pg =0;
				eval("parent.parent."+parent.sel_gtype+"_lid_type='3'");
				reload_var("");
			}


			function StatisticsGty(today,now_gmt,gtype){
				var out=0;
				var array =new Array(0,0,0);
				var tmp =today.split("-");
				var newtoday =tmp[1]+"-"+tmp[2];
				var Months =tmp[1]*1;
				tmp =now_gmt.split(":");
				var newgmt=tmp[0]+":"+tmp[1];
				var tmpgday = new Array(0,0);
				var bf = false;
				for (var i=0 ; i < top.ShowLoveIarray[gtype].length ; i++){
					//alert(top.ShowLoveIarray[gtype][i][1]+","+top.ShowLoveIarray[gtype][i][2]+","+top.ShowLoveIarray[gtype][i][3]+","+top.ShowLoveIarray[gtype][i][4]+","+top.ShowLoveIarray[gtype][i][4]);
					tmpday = top.ShowLoveIarray[gtype][i][1].split("<br>")[0];
					tmpgday = tmpday.split("-");
					tmpgmt =top.ShowLoveIarray[gtype][i][1].split("<br>")[1];
					tmpgmt=time_12_24(tmpgmt);
					if(++tmpgday[0] < Months){
						bf = true;
					}else{
						bf = false;
					}
					if(bf){
						array[2]++;
					}else{
						if(newtoday >= tmpday ){
							if((newtoday+" "+newgmt) >= (tmpday+" "+tmpgmt)){
								array[0]++;	//走地
							}else{
								array[1]++;	//單式
							}
						}else if(newtoday < tmpday){
							array[2]++;	//早餐
						}
					}
				}
				if(parent.sel_gtype=="FT"||parent.sel_gtype=="OP"||parent.sel_gtype=="BK"||parent.sel_gtype=="BS"||parent.sel_gtype=="VB"||parent.sel_gtype=="TN"){
					if(parent.rtype=="re"){
						out=array[0];
					}else{
						out=array[1];
					}
				}else if(parent.sel_gtype=="FU"||parent.sel_gtype=="OM"||parent.sel_gtype=="BU"||parent.sel_gtype=="BSFU"||parent.sel_gtype=="VU"||parent.sel_gtype=="TU"){
					out=array[2];
				}

				return out;
			}

			function time_12_24(stTime){
				var out="";
				var shour =stTime.split(":")[0]*1;
				var smin=stTime.split(":")[1];
				var aop =smin.substr(smin.length-1,1);
				if(aop =="p"){
					if((shour*1)>0)
						shour += 12;
				}
				out=((shour < 10)?"0":"")+shour+":"+smin;
				return out;
			}
			// new array{球類 , new array {gid ,data time ,聯盟,H,C,sw}}
			function addShowLoveI(gid,getDateTime,getLid,team_h,team_c){
				var getGtype =getGtypeShowLoveI();
				var getnum =top.ShowLoveIarray[getGtype].length;
				var sw =true;
				for (var i=0 ; i < top.ShowLoveIarray[getGtype].length ; i++){
					if(top.ShowLoveIarray[getGtype][i][0]==gid)
						sw = false;
				}
				if(sw){
					top.ShowLoveIarray[getGtype] = arraySort(top.ShowLoveIarray[getGtype] ,new Array(gid,getDateTime,getLid,team_h,team_c));
					chkOKshowLoveI();
				}

				document.getElementById("sp_"+MM_imgId(getDateTime,gid)).innerHTML = "<div class=\"bet_game_star_on\" style=\"cursor:hand\" title=\""+top.str_delShowLoveI+"\" onClick=\"chkDelshowLoveI('"+getDateTime+"','"+gid+"');\"></div>";
			}
			function arraySort(array ,data){
				var outarray =new Array();
				var newarray =new Array();
				for(var i=0;i < array.length ;i++){
					if(array[i][1]<= data[1]){
						outarray.push(array[i]);
					}else{
						newarray.push(array[i]);
					}
				}
				outarray.push(data);
				for(var i=0;i < newarray.length ;i++){
					outarray.push(newarray[i]);
				}
				return  outarray;
			}


			function getGtypeShowLoveI(){
				var Gtype;
				var getGtype =parent.sel_gtype;
				var getRtype =parent.rtype;
				Gtype =getGtype;
				if(getRtype=="re"){
					Gtype +="RE";
				}
				return Gtype;
			}
			function chkOKshowLoveI(){
				var getGtype = getGtypeShowLoveI();
				var getnum =top.ShowLoveIOKarray[getGtype].length ;
				var ibj="" ;
				top.ShowLoveIOKarray[getGtype]="";
				for (var i=0 ; i < top.ShowLoveIarray[getGtype].length ; i++){
					tmp = top.ShowLoveIarray[getGtype][i][1].split("<br>")[0];
					top.ShowLoveIOKarray[getGtype]+=tmp+top.ShowLoveIarray[getGtype][i][0]+",";
				}
				showPicLove();
			}


			function chkDelshowLoveI(data2,data){
				var getGtype = getGtypeShowLoveI();
				var tmpdata = data2.split("<br>")[0]+data;
				var tmpdata1 ="";
				var ary = new Array();
				var tmp = new Array();
				tmp = top.ShowLoveIarray[getGtype];
				top.ShowLoveIarray[getGtype] = new Array();
				for (var i=0 ; i < tmp.length ; i++){
					tmpdata1 =tmp[i][1].split("<br>")[0]+tmp[i][0];
					if(tmpdata1 == tmpdata){
						ary = tmp[i];
						continue;
					}
					top.ShowLoveIarray[getGtype].push(tmp[i]);
				}
				chkOKshowLoveI();
				var gtypeNum= StatisticsGty(top.today_gmt,top.now_gmt,getGtypeShowLoveI());
				if(top.swShowLoveI){

					var sw=false;
					if(gtypeNum==0){
						top.swShowLoveI=false;
						eval("parent.parent."+parent.sel_gtype+"_lid_type=top."+parent.sel_gtype+"_lid['"+parent.sel_gtype+"_lid_type']");
						reload_var("");
					}else{
						parent.ShowGameList();
					}
				}else{
					if(gtypeNum==0){
						reload_var("");
					}else{
						document.getElementById("sp_"+MM_imgId(ary[1],ary[0])).innerHTML ="<div id='"+MM_imgId(ary[1],ary[0])+"' class=\"bet_game_star_out\" style=\"cursor:hand;display:none;\" title=\""+top.str_ShowMyFavorite+"\" onClick=\"addShowLoveI('"+ary[0]+"','"+ary[1]+"','"+ary[2]+"','"+ary[3]+"','"+ary[4]+"'); \"></div>";
					}
				}
			}

			function chkDelAllShowLoveI(){
				var getGtype=getGtypeShowLoveI();
				top.ShowLoveIarray[getGtype]= new Array();
				top.ShowLoveIOKarray[getGtype]="";
				if(top.swShowLoveI){
					top.swShowLoveI=false;
					eval("parent.parent."+parent.sel_gtype+"_lid_type=top."+parent.sel_gtype+"_lid['"+parent.sel_gtype+"_lid_type']");
					parent.pg =0;
					reload_var("");
				}else{
					parent.ShowGameList();
				}
			}
			//檢查所選的最愛賽事是否已經進入滾球或是結束
			function checkLoveCount(GameArray){

				var getGtype = getGtypeShowLoveI();
				var tmpdata = "";
				var tmpdata1 ="";
				var ary = new Array();
				var tmp = new Array();
				tmp = top.ShowLoveIarray[getGtype];
				top.ShowLoveIarray[getGtype] = new Array();
				for (s=0;s < GameArray.length;s++){
					tmpdata=GameArray[s].datetime.split("<br>")[0]+GameArray[s].gnum_h;
					for (var i=0;i < tmp.length; i++){
						tmpdata1 =tmp[i][1].split("<br>")[0]+tmp[i][0];
						if(tmpdata1 == tmpdata){
							top.ShowLoveIarray[getGtype].push(tmp[i]);
						}
					}
				}
				chkOKshowLoveI();
			}

			function mouseEnter_pointer(tmp){
				//alert("==="+tmp.split("_")[1])
				try{
					document.getElementById(tmp.split("_")[1]).style.display ="block";
				}catch(E){}
			}

			function mouseOut_pointer(tmp){
				try{
					document.getElementById(tmp.split("_")[1]).style.display ="none";
				}catch(E){}
			}

			function chkLookShowLoveI(){
				top.swShowLoveI =true;
				eval("parent.parent."+parent.sel_gtype+"_lid_type='3'");
				parent.pg =0;
				reload_var("");
			}




			function MM_imgId(time,gid){
				var tmp = time.split("<br>")[0];
				//alert(tmp+gid);
				return tmp+gid;
			}


			//----------------------------我的最愛  end----------------------------------




			//--------------------------odd_f 	start--------------------
			//盤口onclick事件

			function ChkOddfDiv(){

				// alert(top.odd_f_type);
				var odd_show="<select id=myoddType onchange=chg_odd_type()>";
				var tmp_check="";
				for (i = 0; i < Format.length; i++) {
					//沒盤口選擇時，預設為H(香港變盤)
					if((odd_f_str.indexOf(Format[i][0])!=(-1))&&Format[i][2]=="Y"){

						if(top.odd_f_type==Format[i][0]){
							odd_show+="<option value="+Format[i][0]+tmp_check+" selected>"+Format[i][1]+"</option>";
						}else{
							odd_show+="<option value="+Format[i][0]+tmp_check+">"+Format[i][1]+"</option>";
						}
					}
					//else{
					//	odd_show+="<option value="+Format[i][0]+tmp_check+">"+Format[i][1]+"</option>";
					//	}
					//}
				}
				odd_show+"</select>";
				document.getElementById("Ordertype").innerHTML=odd_show;

			}

			//切換盤口
			function chg_odd_type(){

				var myOddtype=document.getElementById("myoddType");
				top.odd_f_type=myOddtype.options[myOddtype.selectedIndex].value;
				reload_var("");
			}

			function show_oddf(){
				for (i = 0; i < Format.length; i++) {
					if(Format[i][0]==top.odd_f_type){
						document.getElementById("oddftext").innerHTML=Format[i][1];
					}
				}

			}
			//--------------------------odd_f 	end--------------------
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
				return;
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

			function refreshReload(){
				reload_var("");
			}

			function get_timer(){return (new Date()).getTime();} // 計數器;
		</script>

	<body id="MFU" class="bodyset FUR" onLoad="onLoad();">

	<!--     资料显示的layer     -->
	<?php require ("../body/body_top.php");?>
	<div id="showtableData" style="display:none;">
		<xmp>
			<table <?=$tab_id?> cellpadding="0" cellspacing="0" border="0" class="bet_game_table">
				<tr id="title_tr" name="fixhead_copy" class="bet_game_title">
					<?=$table?>
				</tr>
				*showDataTR*
			</table>
			<div id="show_page_txt" style="display:none;" class="bet_page_bot">
			</div>
		</xmp>
	</div>
	<!--   表格资料     -->
	<div id='DataTR' style="display:none;" >
		<xmp>
			<!--SHOW LEGUAGE START-->
			<? if($rtype=="r"){ ?>
				<!--SHOW LEGUAGE START-->
				<tr *ST* class="bet_game_league">
					<td colspan="9" onClick="parent.showLeg('*LEG*')">*LEG*</td>
				</tr>
				<!--SHOW LEGUAGE END-->
				<tr id="TR_*ID_STR*" *TR_EVENT* class="bet_game_tr_top">
					<td rowspan="3" class="bet_game_time">*DATETIME*</td>
					<td rowspan="2" class="bet_team">*TEAM_H*<br>*TEAM_C*</td>
					<td class="bet_text">*RATIO_MH*</td>
					<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">*CON_RH*</tt></span><span class="bet_text_tdr">*RATIO_RH*</span></div></td>
					<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*CON_OUH*</tt></span><span class="bet_text_tdr">*RATIO_OUH*</span></div></td>
					<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdr"><tt class="bet_text_oue">*RATIO_EOO*</tt></span></div></td>
					<td id="TR_*ID_STR*_text_1" class="bet_text_left_bg">*RATIO_HMH*</td>
					<td id="TR_*ID_STR*_text_2" class="bet_text_bg"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg">*CON_HRH*</tt></span><span class="bet_text_tdr">*RATIO_HRH*</span></div></td>
					<td id="TR_*ID_STR*_text_3" class="bet_text_right_bg"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg">*CON_HOUH*</tt></span><span class="bet_text_tdr">*RATIO_HOUH*</span></div></td>
				</tr>

				<tr id="TR1_*ID_STR*" *TR_EVENT* class="bet_game_tr_other">
					<td class="bet_text">*RATIO_MC*</td>
					<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">*CON_RC*</tt></span><span class="bet_text_tdr">*RATIO_RC*</span></div></td>
					<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*CON_OUC*</tt></span><span class="bet_text_tdr">*RATIO_OUC*</span></div></td>
					<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdr"><tt class="bet_text_oue">*RATIO_EOE*</tt></span></div></td>
					<td id="TR1_*ID_STR*_text_1" class="bet_text_left_bg">*RATIO_HMC*</td>
					<td id="TR1_*ID_STR*_text_2" class="bet_text_bg"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg">*CON_HRC*</tt></span><span class="bet_text_tdr">*RATIO_HRC*</span></div></td>
					<td id="TR1_*ID_STR*_text_3" class="bet_text_right_bg"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg">*CON_HOUC*</tt></span><span class="bet_text_tdr">*RATIO_HOUC*</span></div></td>
				</tr>
				<tr id="TR2_*ID_STR*" *TR_EVENT* class="bet_game_tr_other">
					<td class="bet_team" style="background-color:#FFFFFF;">*MYLOVE*<!--星星符号--><!--div class="bet_game_star_on"></div--><!--星星符号-灰色--><!--div class="bet_game_star_out"></div--></td>
					<td class="bet_text">*RATIO_MN*</td>
					<td colspan="3" valign="top" class="b_cen"><span>*MORE*</span></td>
					<td id="TR1_*ID_STR*_text_1" class="bet_text_left_bg" >*RATIO_HMN*</td>
					<td id="TR2_*ID_STR*_text_2" class="bet_td_bg"></td>
					<td id="TR2_*ID_STR*_text_3" class="bet_text_right_bg"><span title="可以观看滚球在线直播" *TV_CLASS* *TV*</span></td>
				</tr>
			<? }
			if($rtype=="pd"){
				?>
				<!--SHOW LEGUAGE START-->
				<tr *ST*  class="bet_game_league">
					<td colspan="18" onClick="parent.showLeg('*LEG*')">*LEG*</td>
				</tr>
				<!--SHOW LEGUAGE END-->
				<tr id="TR_*ID_STR*" *CLASS* class="bet_game_correct_top">
					<td rowspan="2" class="bet_game_time"><div>*DATETIME*</div></td>
					<td class="bet_team"><div>*TEAM_H*</div></td>
					<td class="bet_text">*RATIO_H1C0*</td>
					<td class="bet_text">*RATIO_H2C0*</td>
					<td class="bet_text">*RATIO_H2C1*</td>
					<td class="bet_text">*RATIO_H3C0*</td>
					<td class="bet_text">*RATIO_H3C1*</td>
					<td class="bet_text">*RATIO_H3C2*</td>
					<td class="bet_text">*RATIO_H4C0*</td>
					<td class="bet_text">*RATIO_H4C1*</td>
					<td class="bet_text">*RATIO_H4C2*</td>
					<td class="bet_text">*RATIO_H4C3*</td>
					<td rowspan="2" class="bet_correct_bg">*RATIO_H0C0*</td>
					<td rowspan="2" class="bet_correct_bg">*RATIO_H1C1*</td>
					<td rowspan="2" class="bet_correct_bg">*RATIO_H2C2*</td>
					<td rowspan="2" class="bet_correct_bg">*RATIO_H3C3*</td>
					<td rowspan="2" class="bet_correct_bg">*RATIO_H4C4*</td>
					<td rowspan="2" class="bet_correct_bg">*RATIO_OVH*</td>
				</tr>

				<tr id="TR1_*ID_STR*" *CLASS* class="bet_game_correct_other">
					<td class="bet_team">*TEAM_C*</td>
					<td class="bet_text">*RATIO_H0C1*</td>
					<td class="bet_text">*RATIO_H0C2*</td>
					<td class="bet_text">*RATIO_H1C2*</td>
					<td class="bet_text">*RATIO_H0C3*</td>
					<td class="bet_text">*RATIO_H1C3*</td>
					<td class="bet_text">*RATIO_H2C3*</td>
					<td class="bet_text">*RATIO_H0C4*</td>
					<td class="bet_text">*RATIO_H1C4*</td>
					<td class="bet_text">*RATIO_H2C4*</td>
					<td class="bet_text">*RATIO_H3C4*</td>
				</tr>
			<? }
			if($rtype=="hpd"){
				?>
				<tr *ST* >
					<td colspan="13" class="b_hline">
						<table border="0" cellpadding="0" cellspacing="0"><tr><td class="legicon" onClick="parent.showLeg('*LEG*')">
      <span id="*LEG*" name="*LEG*" class="showleg">
      	*LegMark*
       <!--展开联盟-符号--><!--span id="LegOpen"></span-->
       <!--收合联盟-符号--><!--div id="LegClose"></div-->
      </span>
								</td><td onClick="parent.showLeg('*LEG*')" class="leg_bar">*LEG*</td></tr></table>
					</td>
				</tr>
				<!--SHOW LEGUAGE END-->
				<tr id="TR_*ID_STR*" *TR_EVENT* *CLASS*>
					<td rowspan="2" class="b_cen">*DATETIME*</td>
					<td rowspan="2" class="team_name">*TEAM_H*<br>
						*TEAM_C*</td>
					<td class="b_cen">*RATIO_H1C0*</td>
					<td class="b_cen">*RATIO_H2C0*</td>
					<td class="b_cen">*RATIO_H2C1*</td>
					<td class="b_cen">*RATIO_H3C0*</td>
					<td class="b_cen">*RATIO_H3C1*</td>
					<td class="b_cen">*RATIO_H3C2*</td>
					<td class="b_cen" rowspan="2">*RATIO_H0C0*</td>
					<td class="b_cen" rowspan="2">*RATIO_H1C1*</td>
					<td class="b_cen" rowspan="2">*RATIO_H2C2*</td>
					<td class="b_cen" rowspan="2">*RATIO_H3C3*</td>
					<td class="b_cen" rowspan="2">*RATIO_OVH*</td>
				</tr>
				<tr id="TR1_*ID_STR*" *TR_EVENT* *CLASS*>
					<td class="b_cen">*RATIO_H0C1*</td>
					<td class="b_cen">*RATIO_H0C2*</td>
					<td class="b_cen">*RATIO_H1C2*</td>
					<td class="b_cen">*RATIO_H0C3*</td>
					<td class="b_cen">*RATIO_H1C3*</td>
					<td class="b_cen">*RATIO_H2C3*</td>
				</tr>
			<? }
			if($rtype=="t"){
				?>
				<!--SHOW LEGUAGE START-->
				<tr *ST* class="bet_game_league">
					<td colspan="8" onClick="parent.showLeg('*LEG*')">*LEG*</td>
				</tr>
				<!--SHOW LEGUAGE END-->
				<tr id="TR_*ID_STR*" class="bet_game_correct_top">
					<td rowspan="2" class="bet_game_time"><div>*DATETIME*</div></td>
					<td class="bet_team"><div>*TEAM_H*</div></td>
					<td rowspan="2"></td>
					<td rowspan="2" class="bet_text">*RATIO_T01*</td>
					<td rowspan="2" class="bet_text">*RATIO_T23*</td>
					<td rowspan="2" class="bet_text">*RATIO_T46*</td>
					<td rowspan="2" class="bet_text">*RATIO_OVER*</td>
					<td rowspan="2"></td>
				</tr>
				<tr id="TR1_*ID_STR*" class="bet_game_correct_other">
					<td class="bet_team">*TEAM_C*</td>
				</tr>

			<? }
			if($rtype=="f"){
				?>
				<!--SHOW LEGUAGE START-->
				<tr class="bet_game_league" *ST*>
					<td colspan="11" onClick="parent.showLeg('*LEG*')">*LEG*</td>
				</tr>
				<!--SHOW LEGUAGE END-->

				<tr id="TR_*ID_STR*" class="bet_game_correct_top">
					<td rowspan="2" class="bet_game_time"><div>*DATETIME*</div></td>
					<td class="bet_team"><div>*TEAM_H*</div></td>
					<td rowspan="2" class="bet_text">*RATIO_FHH*</td>
					<td rowspan="2" class="bet_text">*RATIO_FHN*</td>
					<td rowspan="2" class="bet_text">*RATIO_FHC*</td>
					<td rowspan="2" class="bet_text">*RATIO_FNH*</td>
					<td rowspan="2" class="bet_text">*RATIO_FNN*</td>
					<td rowspan="2" class="bet_text">*RATIO_FNC*</td>
					<td rowspan="2" class="bet_text">*RATIO_FCH*</td>
					<td rowspan="2" class="bet_text">*RATIO_FCN*</td>
					<td rowspan="2" class="bet_text">*RATIO_FCC*</td>
				</tr>

				<tr id="TR1_*ID_STR*" class="bet_game_correct_other">
					<td class="bet_team">*TEAM_C*</td>
				</tr>

			<? }
			if($rtype=="p3"){?>
				<tr *ST* >
					<td colspan="9" class="b_hline">
						<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td class="legicon" onClick="parent.showLeg('*LEG*')">
      <span id="*LEG*" name="*LEG*" class="showleg">
      	*LegMark*
       <!--展开联盟-符号--><!--span id="LegOpen"></span-->
       <!--收合联盟-符号--><!--div id="LegClose"></div-->
      </span>
								</td><td onClick="parent.showLeg('*LEG*')" class="leg_bar">*LEG*</td><td class="IN">
									<table class="show_p3" border="0" cellpadding="0" cellspacing="0" title="指出从该联赛投注过关&#13;最少所需选择的赛事数&#13;量。">
										<tr>
											<td class="p3_num1">*PORDER*</td>
											<td class="em"></td>
											<td class="p3_num2">1</td>
										</tr>
									</table>
								</td>
							</tr></table>
					</td>
				</tr>
				<!--SHOW LEGUAGE END-->
				<tr id="TR_*ID_STR*" *TR_EVENT* *CLASS*>
					<td rowspan="3" class="b_cen"><table><tr><td class="b_cen">*DATETIME*</td></tr></table></td>
					<td rowspan="2" class="team_name none">*TEAM_H*<br>
						*TEAM_C*</td>
					<td class="b_cen" id="*GID_MH*">*RATIO_MH*</td>
					<td class="b_rig"  id="*GID_RH*"><span class="con">*CON_RH*</span> <span class="ratio">*RATIO_RH*</span></td>
					<td class="b_rig"  id="*GID_OUC*"><span class="con">*CON_OUC*</span> <span class="ratio">*RATIO_OUC*</span></td>
					<td class="b_cen" id="*GID_EOO*">*RATIO_EOO*</td>

					<td class="b_1st"  id="*GID_HMH*">*RATIO_HMH*</td>
					<td class="b_1stR"  id="*GID_HRH*"><span class="con">*CON_HRH*</span> <span class="ratio">*RATIO_HRH*</span></td>
					<td class="b_1stR"  id="*GID_HOUC*"><span class="con">*CON_HOUC*</span> <span class="ratio">*RATIO_HOUC*</span></td>
				</tr>
				<tr id="TR1_*ID_STR*" *TR_EVENT* *CLASS*>
					<td class="b_cen"  id="*GID_MC*">*RATIO_MC*</td>
					<td class="b_rig"  id="*GID_RC*"><span class="con">*CON_RC*</span> <span class="ratio">*RATIO_RC*</span></td>
					<td class="b_rig"  id="*GID_OUH*"><span class="con">*CON_OUH*</span> <span class="ratio">*RATIO_OUH*</span></td>
					<td class="b_cen" id="*GID_EOE*">*RATIO_EOE*</td>

					<td class="b_1st"  id="*GID_HMC*">*RATIO_HMC*</td>
					<td class="b_1stR"  id="*GID_HRC*"><span class="con">*CON_HRC*</span> <span class="ratio">*RATIO_HRC*</span></td>
					<td class="b_1stR"  id="*GID_HOUH*"><span class="con">*CON_HOUH*</span> <span class="ratio">*RATIO_HOUH*</span></td>
				</tr>
				<tr id="TR2_*ID_STR*" *TR_EVENT* *CLASS*>
					<td class="drawn_td" style="background-color:#FFFFFF;">*MYLOVE*<!--星星符号--><!--div class="bet_game_star_on"></div--><!--星星符号-灰色--><!--div class="bet_game_star_out"></div--></td>
					<td class="b_cen"  id="*GID_MN*">*RATIO_MN*</td>
					<td colspan="3" valign="top" class="b_cen"><span class="more_txt">*MORE*</span></td>
					<td class="b_1st"  id="*GID_HMN*">*RATIO_HMN*</td>
					<td colspan="2" valign="top" class="b_1st">&nbsp;</td>
				</tr>
			<? }
			?>
		</xmp>
	</div>
	<div id='NoDataTR' style="display:none;">
		<xmp>
			<td colspan="20" class="bet_no_game"><?=$meisai?></td>
		</xmp>
	</div>


	<!--选择联赛-->
	<div id="controlscroll"  style="position:absolute;"><table border="0" cellspacing="0" cellpadding="0" class="loadBox"><tr><td><!--loading--></td></tr></table></div>
	</body>
	</html>
	<!--<div id="copyright">
        版权所有 皇冠 建议您以 IE 5.0 800 X 600 以上高彩模式浏览本站&nbsp;&nbsp;<a id=download title="下载" href="http://www.microsoft.com/taiwan/products/ie/" target="_blank">立刻下载IE</a>
    </div>-->
	<!--div id="copyright">
        版权所有 建议您以 IE 5.0 800 X 600 以上高彩模式浏览本站&nbsp;&nbsp;<a id=download title="下载" href="http://www.microsoft.com/taiwan/products/ie/" target="_blank">立刻下载IE</a>
    </div-->
	<!-- ------------------------------ 盘口选择 ------------------------------ -->

	<div  id=odd_f_window style="display: none;position:absolute">
		<table id="odd_group" width="100" border="0" cellspacing="1" cellpadding="1">
			<tr>
				<td class="b_hline" >盘口</td>
			</tr>
			<tr >
				<td class="b_cen" width="100">
					<span id="show_odd_f" ></span></td>
			</tr>
		</table>
	</div>

	<!-- ------------------------------ 盘口选择 ------------------------------ -->
<? }else{
	if($langx=="zh-cn"){
		$css="_cn";
	}

	if($langx=="en-us"){
		$css="_en";
	}
	?>
	<html>
	<head>
		<meta name="Robots" contect="none">
		<meta http-equiv="Content-Type" content="text/html; charset=<?=$charset?>">
		<title></title>
		<link href="/style/member/reset.css" rel="stylesheet" type="text/css">
		<link href="/style/member/bet_maincortol.css" rel="stylesheet" type="text/css">
		<script>

			var DateAry = new Array('<?=date('Y-m-d',strtotime('1 day'))?>','<?=date('Y-m-d',strtotime('2 day'))?>','<?=date('Y-m-d',strtotime('3 day'))?>','<?=date('Y-m-d',strtotime('4 day'))?>','<?=date('Y-m-d',strtotime('5 day'))?>','<?=date('Y-m-d',strtotime('6 day'))?>','<?=date('Y-m-d',strtotime('7 day'))?>','<?=date('Y-m-d',strtotime('8 day'))?>','<?=date('Y-m-d',strtotime('9 day'))?>','<?=date('Y-m-d',strtotime('10 day'))?>','<?=date('Y-m-d',strtotime('11 day'))?>');
			top.today_gmt = '<?=date('Y-m-d')?>';
			top.sel_gd = '<?=$g_date?>';
			g_date = '<?=$g_date?>';
			var rtype = '<?=$rtype?>';
			var odd_f_str = 'H,M,I,E';
			var Format=new Array();
			Format[0]=new Array( 'H','<?=$ODDS[HH];?>','Y');
			Format[1]=new Array( 'M','<?=$ODDS[MM];?>','Y');
			Format[2]=new Array( 'I','<?=$ODDS[II];?>','Y');
			Format[3]=new Array( 'E','<?=$ODDS[EE];?>','Y');
		</script>

		<script>
			//在body_browse載入


			var ReloadTimeID;
			var sel_gtype=parent.sel_gtype;

			//網頁載入
			function onLoad(){
				obj_layer = document.getElementById('LoadLayer');
				obj_layer.style.display = 'none';
				obj_layer = document.getElementById('controlscroll');
				obj_layer.style.display = 'none';
				top.swShowLoveI=false;
				if((""+eval("parent."+sel_gtype+"_lname_ary"))=="undefined") eval("parent."+sel_gtype+"_lname_ary='ALL'");
				if((""+eval("parent."+sel_gtype+"_lid_ary"))=="undefined") eval("parent."+sel_gtype+"_lid_ary='ALL'");
				if(parent.ShowType==""||rtype=="r") parent.ShowType = 'OU';
				if(rtype=="hr") parent.ShowType = 'OU';
				if(rtype=="re") parent.ShowType = 'RE';
				if(rtype=="pd") parent.ShowType = 'PD';
				if(rtype=="hpd") parent.ShowType = 'HPD';
				if(rtype=="t") parent.ShowType = 'EO';
				if(rtype=="f") parent.ShowType = 'F';
				if(parent.parent.leg_flag=="Y"){
					parent.parent.leg_flag="N";
					parent.pg=0;
					reload_var("");
				}else{
					showPicLove();
				}
				parent.loading = 'N';
				if(parent.loading_var == 'N'){
					parent.ShowGameList();
					//obj_layer = document.getElementById('LoadLayer');
					//obj_layer.style.display = 'none';
				}
				if (parent.retime_flag == 'Y'){
					//ReloadTimeID = setInterval("reload_var()",parent.retime*1000);
					count_down();
				}else{
					var rt=document.getElementById('refreshTime');
					rt.innerHTML=top.refreshTime;
				}

				document.getElementById("odd_f_window").style.display = "none";
				selgdate(rtype);
				gameSort();

			}

			window.onscroll = scroll;
			function saveSortType(){
				//trace("saveSortType");
				var SortSel=document.getElementById("SortSel");
				if(top.SortType == SortSel.getAttribute("selValue")) {
					refreshReload();
					return;
				}
				top.SortType = SortSel.getAttribute("selValue");
				var tmp = top.uid.match(/m\d*l\d*$/);
				tmp = tmp[0];
				tmp =	tmp.substring(1,tmp.length).split("l");
				tmp = tmp[0];
				top.CM.set("SortType@"+tmp,top.SortType);
				refreshReload();
			}
			function gameSort(){
				//trace("[gameSort] SortType"+top.SortType);
				if(top.SortType=="" && top.rtype.indexOf("re")==-1)top.SortType="T";
				else if(top.SortType=="" && top.rtype.indexOf("re")!=-1) top.SortType="C";

				document.getElementById("SortSel").setAttribute("selValue", top.SortType);
				document.getElementById("sel_sort").setAttribute("class",(top.SortType=="T")?"bet_sort_time_btn":"bet_sort_btn");

			}

			function overInfo(){
				document.getElementById("info").style.display = "";
			}

			function outInf(){
				document.getElementById("info").style.display = "none";
			}


			function showDIv(divname){
				var temp = odd_f_str.split(",");
				if(temp.length == 1 && divname=="odd"){
					return;
				}
				//被選擇排序亮色

				if(top.SortType=="C"){
					document.getElementById("sort_time").className="bet_sort_time";
					document.getElementById("sort_leg").className="bet_sort_comp_choose";
				}else{
					document.getElementById("sort_time").className="bet_sort_time_choose";
					document.getElementById("sort_leg").className="bet_sort_comp";
				}
				//被選擇盤口亮色
				for(i=0;i<temp.length;i++){
					if(top.odd_f_type!=temp[i]){
						document.getElementById("odd_"+temp[i]).className="bet_odds_contant";
					}else{
						document.getElementById("odd_"+top.odd_f_type).className="bet_odds_contant_choose";
					}
				}
				//被選擇頁數亮色
				for(i=0;i<t_page;i++){
					if(pg!=i){
						document.getElementById("page_"+i).className="bet_page_contant";
					}else{
						document.getElementById("page_"+pg).className="bet_page_contant_choose";
					}
				}
				var obj = document.getElementById("show_"+divname);
				//trace("show_"+divname);
				if(obj!=null){
					obj.style.display = (obj.style.display=="")?"none":"";
				}
				var div_id= Array("page","sort","odd");
				for(i=0;i<div_id.length;i++){
					if(div_id[i]!=divname&& obj!=null){
						document.getElementById("show_"+div_id[i]).style.display ="none";
					}
				}

			}
			//覽看所有盤口
			function setMarketPeriod(aRtype){
				if(aRtype=="r_main" || aRtype=="re_main"){Market="Main";}
				else if(aRtype=="r" || aRtype=="re"){Market="All";}
				else if(aRtype=="p3" ){Market="Main";}
			}
			function chgMarket(event){//Main,All
				trace("chgMarket");
				if(Market=="Main")Market="All";
				else Market="Main";
				MarketPeriod();
				rtype = getRtype(rtype);
				var tmp = top.uid.match(/m\d*l\d*$/);
				tmp = tmp[0];
				tmp = tmp.substring(1,tmp.length).split("l")
				tmp = tmp[0];
				top.CM.set("FTRtype@"+tmp,(rtype.split("_")[1])? rtype.split("_")[1]:"r");
				//日期特早 切換帶回全部
				//if(g_date==1 && rtype != "r_no")g_date="ALL"
				//g_date = "ALL";
				if(top.rtype.indexOf("re")!=-1) chk_heisw=true;//是否檢查高度
				refreshReload();

			}
			function MarketPeriod(){
				try{
					var spanM=document.getElementById("SpanMarket");
					var Market_str=(Market=="Main")?"All":"Main";
					var selM=document.getElementById("sel_Market");
					selM.className=(Market_str=="Main")?"bet_view_btn":"bet_view_small_btn";
					spanM.innerHTML = top["str_BK_Market_"+Market_str];
				}catch(e){
					try{trace("NaN Market");}catch(e){};
				}
			}
			function getRtype(aRtype){
				var tmp_str="r";
				if(aRtype.match("re")){
					tmp_str="re"
				}
				if(aRtype.match("p3")){
					tmp_str="p3"
				}
				if(Market=="All" ){
					tmp_str= tmp_str;
				}
				else if(Market=="Main" ){
					tmp_str= tmp_str+"_main";

				}
				return tmp_str
			}

			function scroll(){}

			function reload_var(Level){
				showPicLove();
				parent.loading_var = 'Y';
				if(Level=="up"){
					var tmp = "./"+parent.sel_gtype+"_browse/body_var.php";
					if (parent.sel_gtype=="FU"){
						tmp = "./FT_future/body_var.php";
					}
				}else{
					var tmp = "./body_var.php";
				}

				var l_id =eval("parent.parent."+sel_gtype+"_lid_type");
				if(top.showtype=='hgft'&&parent.sel_gtype=="FU"){
					l_id=3;
				}
				if(parent.rtype == "p3") top.hot_game="";
				var homepage = tmp+"?uid="+parent.uid+"&rtype="+parent.rtype+"&langx="+parent.langx+"&mtype="+parent.ltype+"&page_no="+parent.pg+"&league_id="+l_id+"&hot_game="+top.hot_game;
				//alert("parent.g_date==>"+parent.g_date)
				homepage+="&g_date="+parent.g_date;
				console.log(homepage);
				parent.body_var.location = homepage;
				if(rtype=="r") document.getElementById('more_window').style.display='none';
			}

			//倒數自動更新時間
			function count_down(){
				var rt=document.getElementById('refreshTime');
				setTimeout('count_down()',1000);
				if (parent.retime_flag == 'Y'){
					if(parent.retime <= 0){
						if(parent.loading_var == 'N')
							reload_var("");
						return;
					}
					parent.retime--;
					rt.innerHTML=parent.retime;
					//alert(parent.retime);
					//obj_cd = document.getElementById('cd');
					//obj_cd.innerHTML = parent.retime;
				}
			}

			//賽事換頁
			function chg_pg(pg){
				if (pg==parent.pg) {return;}
				parent.pg=pg;
				reload_var("");
			}

			function chg_wtype(wtype){
				var l_id =eval("parent.parent."+sel_gtype+"_lid_type");
				if(top.swShowLoveI) l_id=3;
				if(top.showtype=='hgft'&&parent.sel_gtype=="FU"){
					l_id=3;
				}
				parent.location.href="index.php?uid="+top.uid+"&langx="+top.langx+"&mtype="+parent.ltype+"&rtype="+wtype+"&showtype=&league_id="+l_id;

				//<frame name="body_var" scrolling="NO" noresize src="body_var.php?uid=<?echo $uid?>&rtype=<?echo $rtype?>&langx=<?echo $langx?>&mtype=<?echo $mtype;?>&delay=<?echo $delay;?>&league_id=<?echo $league_id?>">
				//<frame name="body_browse" src="body_browse.php?uid=<?echo $uid?>&rtype=<?echo $rtype?>&langx=<?echo $langx?>&mtype=<?echo $mtype;?>&delay=<?echo $delay;?>&showtype=<?echo $showtype?>">


			}
			//選擇聯盟=================start


			//選擇聯盟=================end
			function unload(){
				clearInterval(ReloadTimeID);
			}
			window.onunload=unload;

			//-----------------------------future------------------------

			function arraySort1(array ,data){
				var outarray =new Array();
				var newarray =new Array();
				for(var i=0;i < array.length ;i++){
					if(array[i]<= data){
						outarray.push(array[i]);
					}else{
						newarray.push(array[i]);
					}
				}
				outarray.push(data);
				for(var i=0;i < newarray.length ;i++){
					outarray.push(newarray[i]);
				}
				return  outarray;
			}

			//切換日期
			function chg_gdate(){

				var obj_gdate = document.getElementById("g_date");

				parent.g_date=obj_gdate.value;
				parent.pg=0;
				reload_var("");
			}

			//====== 取表格 TD 的x軸
			function GetTD_X(TD_lay,GetTableID){
				var TBar = document.getElementById(GetTableID);
				var td_x = TD_lay;
				for(var i=0; i < TBar.rows[0].children.length; i++){
					if (i == TD_lay) { break; }
					td_x += TBar.rows[0].children[i].clientWidth;
				}
				return td_x;
			}
			//====== 取表格 TD 的y軸
			function GetTD_Y(AryIndex,GetTableID){
				var TBar = document.getElementById(GetTableID);
				var td_y = parseInt(AryIndex)+2;

				for(var i=0; i <= parseInt(AryIndex)+1; i++){
					try{
						td_y += TBar.rows[i].clientHeight;
					} catch (E){
						td_y += TBar.rows[i-1].clientHeight;
					}
				}
				return td_y;
			}




			//----------------------------我的最愛  start----------------------------------
			function showPicLove(){
				var gtypeNum= StatisticsGty(top.today_gmt,top.now_gmt,getGtypeShowLoveI());
				try{
					document.getElementById("fav_num").style.display = "none";
					document.getElementById("showNull").style.display = "none";
					document.getElementById("showAll").style.display = "none";
					document.getElementById("showMy").style.display = "none";
					if(gtypeNum!=0){
						document.getElementById("live_num").innerHTML =gtypeNum;
						document.getElementById("fav_num").style.display = "block";
						if(top.hot_game!=""){
							document.getElementById("showMy").style.display = "block";
						}else{
							if(top.swShowLoveI){
								document.getElementById("showAll").style.display = "block";
							}else{
								document.getElementById("showMy").style.display = "block";
							}
						}
					}else{
						document.getElementById("showNull").style.display = "block";
						top.swShowLoveI=false;
					}
				}catch(E){}
			}
			//我的最愛中的顯示全部
			function showAllGame(gtype){
				top.swShowLoveI=false;
				//eval("parent.parent."+parent.sel_gtype+"_lid_type=''");
				eval("parent.parent."+parent.sel_gtype+"_lid_type=top."+parent.sel_gtype+"_lid['"+parent.sel_gtype+"_lid_type']");
				reload_var("");
			}

			//單式盤面點下我的最愛
			function showMyLove(gtype){
				top.swShowLoveI =true;
				//精選賽事導回
				if(top.hot_game!=""){
					top.hot_game="";
//					document.getElementById("euro_btn").style.display='';
//					document.getElementById("euro_up").style.display='none';
				}
				//
				parent.pg =0;
				eval("parent.parent."+parent.sel_gtype+"_lid_type='3'");
				reload_var("");
			}


			function StatisticsGty(today,now_gmt,gtype){
				var out=0;
				var array =new Array(0,0,0);
				var tmp =today.split("-");
				var newtoday =tmp[1]+"-"+tmp[2];
				var Months =tmp[1]*1;
				tmp =now_gmt.split(":");
				var newgmt=tmp[0]+":"+tmp[1];
				var tmpgday = new Array(0,0);
				var bf = false;
				for (var i=0 ; i < top.ShowLoveIarray[gtype].length ; i++){
					//alert(top.ShowLoveIarray[gtype][i][1]+","+top.ShowLoveIarray[gtype][i][2]+","+top.ShowLoveIarray[gtype][i][3]+","+top.ShowLoveIarray[gtype][i][4]+","+top.ShowLoveIarray[gtype][i][4]);
					tmpday = top.ShowLoveIarray[gtype][i][1].split("<br>")[0];
					tmpgday = tmpday.split("-");
					tmpgmt =top.ShowLoveIarray[gtype][i][1].split("<br>")[1];
					tmpgmt=time_12_24(tmpgmt);
					if(++tmpgday[0] < Months){
						bf = true;
					}else{
						bf = false;
					}
					if(bf){
						array[2]++;
					}else{
						if(newtoday >= tmpday ){
							if((newtoday+" "+newgmt) >= (tmpday+" "+tmpgmt)){
								array[0]++;	//走地
							}else{
								array[1]++;	//單式
							}
						}else if(newtoday < tmpday){
							array[2]++;	//早餐
						}
					}
				}
				if(parent.sel_gtype=="FT"||parent.sel_gtype=="OP"||parent.sel_gtype=="BK"||parent.sel_gtype=="BS"||parent.sel_gtype=="VB"||parent.sel_gtype=="TN"){
					if(parent.rtype=="re"){
						out=array[0];
					}else{
						out=array[1];
					}
				}else if(parent.sel_gtype=="FU"||parent.sel_gtype=="OM"||parent.sel_gtype=="BU"||parent.sel_gtype=="BSFU"||parent.sel_gtype=="VU"||parent.sel_gtype=="TU"){
					out=array[2];
				}

				return out;
			}

			function time_12_24(stTime){
				var out="";
				var shour =stTime.split(":")[0]*1;
				var smin=stTime.split(":")[1];
				var aop =smin.substr(smin.length-1,1);
				if(aop =="p"){
					if((shour*1)>0 && (shour*1) < 12)
						shour += 12;
				}
				out=((shour < 10)?"0":"")+shour+":"+smin;
				return out;
			}
			// new array{球類 , new array {gid ,data time ,聯盟,H,C,sw}}
			function addShowLoveI(gid,getDateTime,getLid,team_h,team_c){
				var getGtype =getGtypeShowLoveI();
				var getnum =top.ShowLoveIarray[getGtype].length;
				var sw =true;
				for (var i=0 ; i < top.ShowLoveIarray[getGtype].length ; i++){
					if(top.ShowLoveIarray[getGtype][i][0]==gid && top.ShowLoveIarray[getGtype][i][1] == getDateTime)
						sw = false;
				}
				if(sw){
					top.ShowLoveIarray[getGtype] = arraySort(top.ShowLoveIarray[getGtype] ,new Array(gid,getDateTime,getLid,team_h,team_c));
					chkOKshowLoveI();
				}

				document.getElementById("sp_"+MM_imgId(getDateTime,gid)).innerHTML = "<div class=\"bet_game_star_on\" style=\"cursor:hand\" title=\""+top.str_delShowLoveI+"\" onClick=\"chkDelshowLoveI('"+getDateTime+"','"+gid+"');\"></div>";
			}
			function arraySort(array ,data){
				var outarray =new Array();
				var newarray =new Array();
				for(var i=0;i < array.length ;i++){
					if(array[i][1]<= data[1]){
						outarray.push(array[i]);
					}else{
						newarray.push(array[i]);
					}
				}
				outarray.push(data);
				for(var i=0;i < newarray.length ;i++){
					outarray.push(newarray[i]);
				}
				return  outarray;
			}


			function getGtypeShowLoveI(){
				var Gtype;
				var getGtype =parent.sel_gtype;
				var getRtype =parent.rtype;
				Gtype =getGtype;
				if(getRtype=="re"){
					Gtype +="RE";
				}
				/*
				 if(getGtype =="FU"||getGtype=="FT"){
				 Gtype ="FT";
				 }else if(getGtype =="OM"||getGtype=="OP"){
				 Gtype ="OP";
				 }else if(getGtype =="BU"||getGtype=="BK"){
				 Gtype ="BK";
				 }else if(getGtype =="BSFU"||getGtype=="BS"){
				 Gtype ="BS";
				 }else if(getGtype =="VU"||getGtype=="VB"){
				 Gtype ="VB";
				 }else if(getGtype =="TU"||getGtype=="TN"){
				 Gtype ="TN";
				 }else {
				 Gtype ="FT";
				 }
				 */

				//alert("in==>"+parent.sel_gtype+",out==>"+Gtype);
				return Gtype;
			}
			function chkOKshowLoveI(){
				var getGtype = getGtypeShowLoveI();
				var getnum =top.ShowLoveIOKarray[getGtype].length ;
				var ibj="" ;
				top.ShowLoveIOKarray[getGtype]="";
				for (var i=0 ; i < top.ShowLoveIarray[getGtype].length ; i++){
					tmp = top.ShowLoveIarray[getGtype][i][1].split("<br>")[0];
					top.ShowLoveIOKarray[getGtype]+=tmp+top.ShowLoveIarray[getGtype][i][0]+",";
				}
				showPicLove();
			}


			function chkDelshowLoveI(getDateTime,gid){
				var getGtype = getGtypeShowLoveI();
				var tmpdata = getDateTime.split("<br>")[0]+gid;
				var tmpdata1 ="";
				var ary = new Array();
				var tmp = new Array();
				tmp = top.ShowLoveIarray[getGtype];
				top.ShowLoveIarray[getGtype] = new Array();
				for (var i=0 ; i < tmp.length ; i++){
					tmpdata1 =tmp[i][1].split("<br>")[0]+tmp[i][0];
					if(tmpdata1 == tmpdata){
						ary = tmp[i];
						continue;
					}
					top.ShowLoveIarray[getGtype].push(tmp[i]);
				}
				chkOKshowLoveI();
				var gtypeNum= StatisticsGty(top.today_gmt,top.now_gmt,getGtypeShowLoveI());
				if(top.swShowLoveI){

					var sw=false;
					if(gtypeNum==0){
						top.swShowLoveI=false;
						eval("parent.parent."+parent.sel_gtype+"_lid_type=top."+parent.sel_gtype+"_lid['"+parent.sel_gtype+"_lid_type']");
						reload_var("");
					}else{
						parent.ShowGameList();
					}
				}else{
					if(gtypeNum==0){
						reload_var("");
					}else{
						document.getElementById("sp_"+MM_imgId(ary[1],ary[0])).innerHTML ="<div id='"+MM_imgId(ary[1],ary[0])+"' class=\"bet_game_star_out\" style=\"cursor:hand;display:none;\" title=\""+top.str_ShowMyFavorite+"\" onClick=\"addShowLoveI('"+ary[0]+"','"+ary[1]+"','"+ary[2]+"','"+ary[3]+"','"+ary[4]+"'); \"></div>";
					}
				}
			}

			function chkDelAllShowLoveI(){
				var getGtype=getGtypeShowLoveI();
				top.ShowLoveIarray[getGtype]= new Array();
				top.ShowLoveIOKarray[getGtype]="";
				if(top.swShowLoveI){
					top.swShowLoveI=false;
					eval("parent.parent."+parent.sel_gtype+"_lid_type=top."+parent.sel_gtype+"_lid['"+parent.sel_gtype+"_lid_type']");
					parent.pg =0;
					reload_var("");
				}else{
					parent.ShowGameList();
				}
			}
			//檢查所選的最愛賽事是否已經進入滾球或是結束
			function checkLoveCount(GameArray){

				var getGtype = getGtypeShowLoveI();
				var tmpdata = "";
				var tmpdata1 ="";
				var ary = new Array();
				var tmp = new Array();
				tmp = top.ShowLoveIarray[getGtype];
				top.ShowLoveIarray[getGtype] = new Array();
				for (s=0;s < GameArray.length;s++){
					tmpdata=GameArray[s].datetime.split("<br>")[0]+GameArray[s].gnum_h;
					for (var i=0;i < tmp.length; i++){
						tmpdata1 =tmp[i][1].split("<br>")[0]+tmp[i][0];
						if(tmpdata1 == tmpdata){
							top.ShowLoveIarray[getGtype].push(tmp[i]);
						}
					}
				}
				chkOKshowLoveI();
			}

			function mouseEnter_pointer(tmp){
				//alert("==="+tmp.split("_")[1])
				try{
					document.getElementById(tmp.split("_")[1]).style.display ="block";
				}catch(E){}
			}

			function mouseOut_pointer(tmp){
				try{
					document.getElementById(tmp.split("_")[1]).style.display ="none";
				}catch(E){}
			}

			function chkLookShowLoveI(){
				top.swShowLoveI =true;
				eval("parent.parent."+parent.sel_gtype+"_lid_type='3'");
				parent.pg =0;
				reload_var("");
			}




			function MM_imgId(time,gid){
				var tmp = time.split("<br>")[0];
				//alert(tmp+gid);
				return tmp+gid;
			}


			//----------------------------我的最愛  end----------------------------------




			//--------------------------odd_f 	start--------------------
			//盤口onclick事件

			function ChkOddfDiv(){

				// alert(top.odd_f_type);
				var odd_show="<select id=myoddType onchange=chg_odd_type()>";
				var tmp_check="";
				for (i = 0; i < Format.length; i++) {
					//沒盤口選擇時，預設為H(香港變盤)
					if((odd_f_str.indexOf(Format[i][0])!=(-1))&&Format[i][2]=="Y"){

						if(top.odd_f_type==Format[i][0]){
							odd_show+="<option value="+Format[i][0]+tmp_check+" selected>"+Format[i][1]+"</option>";
						}else{
							odd_show+="<option value="+Format[i][0]+tmp_check+">"+Format[i][1]+"</option>";
						}
					}
					//else{
					//	odd_show+="<option value="+Format[i][0]+tmp_check+">"+Format[i][1]+"</option>";
					//	}
					//}
				}
				odd_show+"</select>";
//				document.getElementById("Ordertype").innerHTML=odd_show;

			}

			//切換盤口
			function chg_odd_type(){
				var myOddtype=document.getElementById("myoddType");
				top.odd_f_type=myOddtype.options[myOddtype.selectedIndex].value;
				reload_var("");
			}

			function show_oddf(){
				for (i = 0; i < Format.length; i++) {
					if(Format[i][0]==top.odd_f_type){
						document.getElementById("oddftext").innerHTML=Format[i][1];
					}
				}

			}
			//--------------------------odd_f 	end--------------------
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
				return;
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

			function refreshReload(){
//				document.getElementById("refresh_btn").className='refresh_on';
				reload_var("");
			}

			function get_timer(){return (new Date()).getTime();} // 計數器



			function Euro(){

				if(top.hot_game!=""){
					top.hot_game="";
					top.swShowLoveI=false;
//					document.getElementById("euro_btn").style.display='';
//					document.getElementById("euro_up").style.display='none';
				}else{
					top.hot_game="HOT_";
//					document.getElementById("euro_btn").style.display='none';
//					document.getElementById("euro_up").style.display='';

				}
				parent.pg =0;
				parent.show_page();
				reload_var("");

			}

			function Eurover(act){
				//alert(act.className)
//				if(act.className=="euro_btn"){
//					act.className='euro_over';
//				}else if(act.className=="euro_up"){
//					act.className='euro_up_over';
//				}
			}

			function Eurout(act){
				//alert(act.className)
//				if(act.className=="euro_over"){
//					act.className='euro_btn';
//				}else if(act.className=="euro_up_over"){
//					act.className='euro_up';
//				}
			}
		</script>

	</head>

	<body id="MFU" onLoad="onLoad();" onScroll="showfixhead();" class="bet_r_FTF">

	<!--     资料显示的layer     -->
	<?php require ("../body/body_top.php");?>
	<!--   表格资料     -->
	<div id=DataTR style="display:none;" >
		<xmp>
			<!--SHOW LEGUAGE START-->
			<tr *ST* class="bet_game_league">
				<td colspan="9" onClick="parent.showLeg('*LEG*')">*LEG*</td>
			</tr>
			<!--SHOW LEGUAGE END-->
			<tr id="TR_*ID_STR*" *TR_EVENT* class="bet_game_tr_top">
				<td rowspan="3" class="bet_game_time">*DATETIME*</td>
				<td rowspan="2" class="bet_team">*TEAM_H*<br>*TEAM_C*</td>
				<td class="bet_text">*RATIO_MH*</td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">*CON_RH*</tt></span><span class="bet_text_tdr">*RATIO_RH*</span></div></td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*CON_OUH*</tt></span><span class="bet_text_tdr">*RATIO_OUH*</span></div></td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdr"><tt class="bet_text_oue">*RATIO_EOO*</tt></span></div></td>
				<td id="TR_*ID_STR*_text_1" class="bet_text_left_bg">*RATIO_HMH*</td>
				<td id="TR_*ID_STR*_text_2" class="bet_text_bg"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg">*CON_HRH*</tt></span><span class="bet_text_tdr">*RATIO_HRH*</span></div></td>
				<td id="TR_*ID_STR*_text_3" class="bet_text_right_bg"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg">*CON_HOUH*</tt></span><span class="bet_text_tdr">*RATIO_HOUH*</span></div></td>
			</tr>

			<tr id="TR1_*ID_STR*" *TR_EVENT* class="bet_game_tr_other">
				<td class="bet_text">*RATIO_MC*</td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">*CON_RC*</tt></span><span class="bet_text_tdr">*RATIO_RC*</span></div></td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*CON_OUC*</tt></span><span class="bet_text_tdr">*RATIO_OUC*</span></div></td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdr"><tt class="bet_text_oue">*RATIO_EOE*</tt></span></div></td>
				<td id="TR1_*ID_STR*_text_1" class="bet_text_left_bg">*RATIO_HMC*</td>
				<td id="TR1_*ID_STR*_text_2" class="bet_text_bg"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg">*CON_HRC*</tt></span><span class="bet_text_tdr">*RATIO_HRC*</span></div></td>
				<td id="TR1_*ID_STR*_text_3" class="bet_text_right_bg"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg">*CON_HOUC*</tt></span><span class="bet_text_tdr">*RATIO_HOUC*</span></div></td>
			</tr>
			<tr id="TR2_*ID_STR*" *TR_EVENT* class="bet_game_tr_other">
				<td class="bet_team" style="background-color:#FFFFFF;">*MYLOVE*<!--星星符号--><!--div class="bet_game_star_on"></div--><!--星星符号-灰色--><!--div class="bet_game_star_out"></div--></td>
				<td class="bet_text">*RATIO_MN*</td>
				<td colspan="3" valign="top" class="b_cen"><span>*MORE*</span></td>
				<td id="TR1_*ID_STR*_text_1" class="bet_text_left_bg" >*RATIO_HMN*</td>
				<td id="TR2_*ID_STR*_text_2" class="bet_td_bg"></td>
				<td id="TR2_*ID_STR*_text_3" class="bet_text_right_bg"><span title="可以观看滚球在线直播" *TV_CLASS* *TV*</span></td>
			</tr>

		</xmp>
	</div>
	<div id=NoDataTR style="display:none;">
		<xmp>
			<td colspan="20" class="bet_no_game"><?=$meisai?></td>
		</xmp>
	</div>
	<div id="showtableData" style="display:none;">
		<xmp>
			<table <?=$tab_id?> border="0" cellspacing="1" cellpadding="0" class="bet_game_table">
				<tr id="title_tr" name="fixhead_copy" class="bet_game_title">
					<?=$table?>
				</tr>
				*showDataTR*
			</table>
		</xmp>
	</div>


	<!--选择联赛-->
	<div id="controlscroll"  style="position:absolute;"><table border="0" cellspacing="0" cellpadding="0" class="loadBox"><tr><td><!--loading--></td></tr></table></div>
	</body>
	</html>
	<!--<div id="copyright">
        版权所有 皇冠 建议您以 IE 5.0 800 X 600 以上高彩模式浏览本站&nbsp;&nbsp;<a id=download title="下载" href="http://www.microsoft.com/taiwan/products/ie/" target="_blank">立刻下载IE</a>
    </div>-->
	<!--div id="copyright">
        版权所有 建议您以 IE 5.0 800 X 600 以上高彩模式浏览本站&nbsp;&nbsp;<a id=download title="下载" href="http://www.microsoft.com/taiwan/products/ie/" target="_blank">立刻下载IE</a>
    </div-->
	<!-- ------------------------------ 盘口选择 ------------------------------ -->

	<div  id=odd_f_window style="display: none;position:absolute">
		<table id="odd_group" width="100" border="0" cellspacing="1" cellpadding="1">
			<tr>
				<td class="b_hline">盘口</td>
			</tr>
			<tr >
				<td class="b_cen" width="100">
					<span id="show_odd_f" ></span></td>
			</tr>
		</table>
	</div>


<? }?>