<?
include "../include/library.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$mtype=$_REQUEST['mtype'];
$rtype=trim($_REQUEST['rtype']);
$langx=$_REQUEST['langx'];
$hot_game=$_REQUEST['hot_game'];
$date=date("Y-m-d");
$date1=date("H:i:s");
$league_id=$_REQUEST['league_id'];
$sql = "select * from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
$memname=$row['Memname'];

require ("../include/traditional.$langx.inc.php");
if ($langx=='en-us'){
	$css='_en';
}

$tab_id="id=game_table";

// table
$zao = $jinri;
require ("../body/body_table_FT.php");
switch ($rtype){
	case "r":
		$caption=$caption_bo;
		$upd_msg=$udpsecond;
		$table=$table0;
		$tatype='FTR';
		break;
	case "hr":
		$caption=$hsthalf;
		$upd_msg=$ManualUpdate;
		$table=$table1;
		break;
	case "re":
		$caption=$Soccer.':'.$RunningBall;
		$upd_msg=$udpsecond;
		$table=$table2;
		$tatype='FTRE';
		break;
	case "hre":
		$caption=substr($hsthalf,0,4).$RunningBall;
		$upd_msg=$udpsecond;
		$table=$table2;
		break;
	case "t":
		$caption=$caption_bo.':'.$dans;
		$upd_msg=$RqPaicai;
		$table=$table3;
		$tatype="FTT";
		break;
	case "rt":
		$caption=$Soccer.$RunningBall.':'.$dans;
		$upd_msg=$RqPaicai;
		$table=$table3;
		$tatype="FTT";
		break;
	case "f":
		$caption=$caption_bo.':'.$banquan;
		$upd_msg=$Paicai;
		$table=$table4;
		$tatype="FTF";

		break;
	case "rf":
		$caption=$Soccer.$RunningBall.':'.$banquan;
		$upd_msg=$Paicai;
		$table=$table4;
		$tatype="FTF";

		break;
	case "pd":
		$caption=$caption_bo.':'.$Correctscore;
		$upd_msg=$BdPaicai;
		$table=$table9;
		$tatype='FTPD';
		break;
	case "rpd":
		$caption=$Soccer.$RunningBall.':'.$Correctscore;
		$upd_msg=$BdPaicai;
		$table=$table9;
		$tatype='FTPD';
		break;
	case "hpd":
		$caption=$caption_bo.':'.$bodan;
		$upd_msg=$BdPaicai;
		$table=$table5;
		$tatype='FTPD';
		break;
	case "hrpd":
		$caption=$Soccer.$RunningBall.':'.$bodan;
		$upd_msg=$BdPaicai;
		$table=$table5;
		$tatype='FTPD';
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
		$caption=$caption_bo.':'.$zhgg;
		$tab_id='id="p3"';
		$upd_msg=$Paicai;
		$table=$table8;
		$tatype="FTP3";
		$id='P3';
		break;
}
?>
<html>
<head>
	<title></title>
	<meta name="Robots" contect="none">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link href="/style/member/reset.css" rel="stylesheet" type="text/css">
	<link href="/style/member/bet_maincortol.css" rel="stylesheet" type="text/css">
	<script>
		var rtype = '<?=$rtype?>';
		var odd_f_str = 'H,M,I,E';
		var lid_arr=new Array();
		top.lid_arr=lid_arr;

		top.today_gmt = '<?=$date?>';
		top.now_gmt = '<?=$date1?>';
		top.showtype = '<?=$showtype?>';
		top.SortType="T";
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
		var reloadFakeSec = 10;//秒數內做假更新
		var LastReloadSec;
		var ReloadTimeFake;
		var isHot_game = false;//是否為世足賽

		//網頁載入
		function onLoad(){
			LastReloadSec = 0;
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

			if(rtype=="rpd") parent.ShowType = 'RPD';
			if(rtype=="hrpd") parent.ShowType = 'HRPD';
			if(rtype=="rt") parent.ShowType = 'RT';
			if(rtype=="rf") parent.ShowType = 'RF';

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
			if(sel_gtype=="FU"){
				if (rtype!="r"){
					if(top.showtype!='hgft'){
						selgdate(rtype);
					}
				}
			}
			gameSort();
		}

//		window.onscroll = scroll;

		function scroll()
		{
//			var refresh_right= document.getElementById('refresh_right');
//			refresh_right.style.top=document.body.scrollTop+39;

			//var refresh_down= document.getElementById('refresh_down');


			//refresh_down.style.left=-100;
			//refresh_down.style.left=10+document.getElementById('myTable').clientWidth/2+refresh_down.style.width/2;
			//refresh_right.style.top=document.body.scrollTop+21+34+25+10;
			//refresh_right.style.top=document.body.scrollTop+(document.body.clientHeight-118)/2;
			// 捲軸位置              +( frame高度                -header高度)/2

			//alert("scroll event detected! "+document.body.scrollTop);
//
			//conscroll.style.display="block";
//conscroll.style.top=document.body.scrollTop;
			// note: you can use window.innerWidth and window.innerHeight to access the width and height of the viewing area
		}


		function reload_chk(time){
			if(ReloadTimeFake){
				clearTimeout(ReloadTimeFake);
			}

			var nowReloadSec = new Date().getTime();
			var nowSec = Math.round(nowReloadSec/1000);
			//console.log("now >> "+nowSec);

			if(LastReloadSec == 0){
				LastReloadSec = nowSec;
			}else{
				var lastSec = LastReloadSec;
				//console.log("last >> "+lastSec);
				//console.log(" > "+(nowSec-lastSec));

				if((nowSec - lastSec) >= time){
					//console.log(" over "+time+" ");
					//LastReloadSec = 0;
					LastReloadSec = nowSec;
					return true
				}else{
					return false;
				}
			}
		}

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
			//alert(homepage);
			//alert("parent.g_date==>"+parent.g_date)
			if (parent.sel_gtype=="FU"){
				homepage+="&g_date="+parent.g_date;
			}
			parent.body_var.location = homepage;
			//if(rtype=="r" || rtype=="re") document.getElementById('more_window').style.display='none';
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
			document.getElementById("live_num").innerHTML =gtypeNum;
			try{
				document.getElementById("showNull").style.display = "none";
				document.getElementById("showAll").style.display = "none";
				if(gtypeNum!=0){
					if(top.hot_game=="" && top.swShowLoveI){
						document.getElementById("showAll").style.display = "block";
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
			if(isHot_game){
				if(top.hot_game!=""){
					top.hot_game="";
//					document.getElementById("euro_btn").style.display='';
//					document.getElementById("euro_up").style.display='none';
				}
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
			tmp = now_gmt.split(":");
			var newgmt=tmp[0]+":"+tmp[1];
			var tmpgday = new Array(0,0);
			var bf = false;
			for (var i=0 ; i < top.ShowLoveIarray[gtype].length ; i++){
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
//						}else{
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
		if (top.keep_LoveI_array_FT==undefined) top.keep_LoveI_array_FT=new Array();
		// new array{球類 , new array {gid ,data time ,聯盟,H,C,sw}}
		function addShowLoveI(gid,getDateTime,getLid,team_h,team_c){
			var getGtype =getGtypeShowLoveI();
			var getnum =top.ShowLoveIarray[getGtype].length;
			var sw =true;
			for (var i=0 ; i < top.ShowLoveIarray[getGtype].length ; i++){
				if(top.ShowLoveIarray[getGtype][i][0]==gid && top.ShowLoveIarray[getGtype][i][1] == getDateTime)
					sw = false;
			}
			//alert(sw+",gid="+gid+",getDateTime="+getDateTime+",getLid="+getLid+",team_h="+team_h+",team_c="+team_c);
			if(sw){
				top.ShowLoveIarray[getGtype] = arraySort(top.ShowLoveIarray[getGtype] ,new Array(gid,getDateTime,getLid,team_h,team_c));
				//單式最愛帶進去滾球
				if(parent.rtype!="re"){
					loveI_has_in=true;
					for (i=0;i < top.keep_LoveI_array_FT.length;i++){
						if(top.keep_LoveI_array_FT[i][0]==gid){
							loveI_has_in=false;
							break;
						}
					}
					if(loveI_has_in){
						tmpd=getDateTime.split("<br>");
						tmpDateTime=tmpd[0]+"<br>"+tmpd[1];
						top.keep_LoveI_array_FT.push(new Array(gid,tmpDateTime,getLid,team_h,team_c));
					}
				}
				//alert("top.keep_LoveI_array_FT==>"+top.keep_LoveI_array_FT.length);
				chkOKshowLoveI();
			}

			document.getElementById("sp_"+MM_imgId(getDateTime,gid)).innerHTML = "<div class=\"bet_game_star_on\" style=\"cursor:hand\" title=\""+top.str_delShowLoveI+"\" onClick=\"chkDelshowLoveI('"+getDateTime+"','"+gid+"');\"></div>";
		}
		function auto_re_addShowLoveI(Game_Data){
			var getGtype =getGtypeShowLoveI();

			//var tmpAry = new Array();
			//for (var k=0;k < top.keep_LoveI_array_FT.length;k++){
			//tmpAry[tmpAry.length] = top.keep_LoveI_array_FT[k];
			//}
			//top.keep_LoveI_array_FT.toString();
			//if(top.keep_LoveI_array_FT instanceof Array) alert("true");
			//else alert("false");
			for (var i=top.keep_LoveI_array_FT.length-1;i >= 0;i--){
				var tmp=top.keep_LoveI_array_FT[i][1].split("<br>");
				newTime=parent.change_time(tmp[1])+":00";
				var tmp_today_gmt=top.today_gmt.split("-");
				chk_date_time=tmp_today_gmt[0]+"-"+tmp[0]+" "+newTime;
				var tmp_find=false;
				var tmp_gid=top.keep_LoveI_array_FT[i][0];
				if(chk_date_time < top.today_gmt+" "+top.now_gmt){
					//檢查賽程
					for(var a=0;a < Game_Data.length;a++){
						//alert(Game_FT[a][3]+"---"+tmp_gid);
						if(Game_Data[a][3]==tmp_gid){
							tmp_find=true;
							break;
						}
					}
					if(tmp_find){
						top.ShowLoveIarray[getGtype] = arraySort(top.ShowLoveIarray[getGtype] ,top.keep_LoveI_array_FT[i]);
					}
					//top.keep_LoveI_array_FT.splice(i,1);
					Array.prototype.splice.call(top.keep_LoveI_array_FT,i,1);

				}
			}
			chkOKshowLoveI();
			//top.keep_LoveI_array_FT = tmpAry;
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
			//top.keep_LoveI_array_FT.toString();//=type(top.keep_LoveI_array_FT);
			//top.keep_LoveI_array_FT=top.keep_LoveI_array_FT.toString().split(",");
			//if(top.keep_LoveI_array_FT instanceof Array) alert("true");
			//else alert("false");
			//alert("1 top.keep_LoveI_array_FT.length="+top.keep_LoveI_array_FT.length);
			for (var i=0 ; i < tmp.length ; i++){
				tmpdata1 =tmp[i][1].split("<br>")[0]+tmp[i][0];
				if(tmpdata1 == tmpdata){
					ary = tmp[i];
					for (var s=0;s < top.keep_LoveI_array_FT.length;s++){
						if(top.keep_LoveI_array_FT[s][0]==gid) Array.prototype.splice.call(top.keep_LoveI_array_FT,s,1); //top.keep_LoveI_array_FT.splice(s,1);
					}
					continue;
				}
				top.ShowLoveIarray[getGtype].push(tmp[i]);
			}
			//alert("2 top.keep_LoveI_array_FT.length="+top.keep_LoveI_array_FT.length);

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
			top.keep_LoveI_array_FT=new Array();
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
					//alert(tmpdata1+","+tmpdata);
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
//			document.getElementById("Ordertype").innerHTML=odd_show;

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

		function refreshReload(level,fake){
			if(fake && !reload_chk(reloadFakeSec)){
				reload_fake();
			}else{
				reload_var(level);
			}
		}

		function parseArray(gameHead,gameData){
			var gameObj=new Object();
			for (var i=0;i<gameHead.length;i++){
				if (gameHead[i]!=""){
					eval("gameObj."+gameHead[i]+"='"+gameData[i]+"'");
				}
			}
			return gameObj;
		}



		function get_timer(){return (new Date()).getTime();} // 計數器



		function Euro(){

			if(top.hot_game!=""){
				top.hot_game="";
				top.swShowLoveI=false;
			}else{
				top.hot_game="HOT_";
			}

			if(top.head_gtype=="FT"){
				try{
					parent.parent.mem_order.goEuro_HOT_btn(top.head_gtype+"_"+top.head_btn);
				}catch(E){}
			}

			parent.pg =0;
			parent.show_page();
			reload_var("");

		}

		function Eurover(act){
			//alert(act.className)
//			if(act.className=="euro_btn"){
//				act.className='euro_over';
//			}else if(act.className=="euro_up"){
//				act.className='euro_up_over';
//			}
		}

		function Eurout(act){
			//alert(act.className)
//			if(act.className=="euro_over"){
//				act.className='euro_btn';
//			}else if(act.className=="euro_up_over"){
//				act.className='euro_up';
//			}
		}


		function getObjAbsolute(obj){
			var abs = new Object();

			abs["left"] = obj.offsetLeft;
			abs["top"] = obj.offsetTop;

			while (obj = obj.offsetParent) {
				abs["left"] += obj.offsetLeft;
				abs["top"] += obj.offsetTop;
			}

			return abs;
		}

		function show_lego_sort(Obj,event){
			if(document.getElementById("SortTable").style.display=="none"){
				abs=getObjAbsolute(Obj);
				document.getElementById("SortTable").style.top=abs["top"]+20;
				document.getElementById("SortTable").style.left=abs["left"]+2;
				document.getElementById("SortTable").style.display ="";
				document.getElementById("uid").value=top.uid;
				document.getElementById("langx").value=top.langx;
				document.getElementById("SortForm").action="../setSortType.php";
			}else{
				document.getElementById("SortTable").style.display ="none";
			}
		}

		function saveSortType(){
			document.getElementById("SortType").value = document.getElementById("SortSel").value;
			document.getElementById("uid").value=top.uid;
			document.getElementById("langx").value=top.langx;
			//document.getElementById("SortForm").action="../setSortType.php";
			if(top.SortType == document.getElementById("SortSel").value ) {
				refreshReload();
				return;
			}
			//document.getElementById("SortForm").submit();
		}

		function gameSort(){
			if(top.SortType=="") top.SortType="T";
			document.getElementById("SortSel").value = top.SortType;
		}
	</script>
</head>

<body id="MFT" name="mft1" class="" onLoad="onLoad();" >

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
				<td rowspan="3" class="bet_game_time"><table><tr><td class="bet_time_live">*DATETIME*</td></tr></table></td>
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
		if($rtype=="re"){
			?>
			<!--SHOW LEGUAGE START-->
			<tr *ST* class="bet_game_league">
				<td colspan="9" onClick="parent.showLeg('*LEG*')">*LEG*</td>
			</tr>
			<!--SHOW LEGUAGE END-->
			<tr id="TR_*ID_STR*" *TR_EVENT* class="bet_game_tr_top">
				<td rowspan="3" class="bet_game_time">
					<span class="bet_time_live">*DATETIME*</span><br/>
					<span class="rb_score">*SCORE*</span>
				</td>
				<td rowspan="2" class="bet_team">
					<span class="re_team">*TEAM_H*</span><span class="red_card" *REDCARD_H_STYLE*>*REDCARD_H*</span><br/>
					<span class="re_team">*TEAM_C*</span><span class="red_card" *REDCARD_C_STYLE*>*REDCARD_C*</span>
				</td>
				<td class="bet_text">*RATIO_MH*</td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">*CON_RH*</tt></span><span class="bet_text_tdr">*RATIO_RH*</span></div></td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*CON_OUH*</tt></span><span class="bet_text_tdr">*RATIO_OUH*</span></div></td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdr"><tt class="bet_text_oue">*RATIO_RODD*</tt></span></div></td>
				<td id="TR_*ID_STR*_text_1" class="bet_text_left_bg">*RATIO_HMH*</td>
				<td id="TR_*ID_STR*_text_2" class="bet_text_bg"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg">*CON_HRH*</tt></span><span class="bet_text_tdr">*RATIO_HRH*</span></div></td>
				<td id="TR_*ID_STR*_text_3" class="bet_text_right_bg"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg">*CON_HOUH*</tt></span><span class="bet_text_tdr">*RATIO_HOUH*</span></div></td>
			</tr>
			<tr id="TR1_*ID_STR*" *TR_EVENT* class="bet_game_tr_other">
				<td class="bet_text">*RATIO_MC*</td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">*CON_RC*</tt></span><span class="bet_text_tdr">*RATIO_RC*</span></div></td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*CON_OUC*</tt></span><span class="bet_text_tdr">*RATIO_OUC*</span></div></td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdr"><tt class="bet_text_oue">*RATIO_REVEN*</tt></span></div></td>
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
			<tr *ST* class="bet_game_league">
				<td colspan="9" onClick="parent.showLeg('*LEG*')"><span>*LEG*</span><span class="bet_in_bg">*PORDER* 串 1</span></td>
			</tr>
			<!--SHOW LEGUAGE END-->
			<tr id="TR_*ID_STR*" *TR_EVENT* class="bet_game_tr_top">
				<td rowspan="3" class="bet_game_time"><table><tr><td class="bet_time_live">*DATETIME*</td></tr></table></td>
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
		?>
	</xmp>
</div>
<div id=NoDataTR style="display:none;">
	<xmp>
		<td colspan="20" class="bet_no_game"><?=$meisai?></td>
	</xmp>
</div>

<!--选择联赛-->

<div><iframe id="saveOrderFrame" name="saveOrderFrame" frameborder="no" border="0" allowtransparency="true"></iframe></div>

<div id="controlscroll"  style="position:absolute;"><table border="0" cellspacing="0" cellpadding="0" class="loadBox"><tr><td><!--loading--></td></tr></table></div>
</body>
</html>

<div  id=odd_f_window style="display: none;position:absolute">
	<table id="odd_group" width="100" border="0" cellspacing="1" cellpadding="1">
		<tr>
			<td class="b_hline" ><?=$ODDS['ODDS']?></td>
		</tr>
		<tr >
			<td class="b_cen" width="100">
				<span id="show_odd_f" ></span></td>
		</tr>
	</table>
</div>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8 "><script>
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-43753661-1']);
	_gaq.push(['_trackPageview']);

	// (function() {
	//   var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	//   ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	//  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	//})();
</script>
