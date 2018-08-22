<?php
include "../include/library.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");

$uid=$_REQUEST['uid'];
$mtype=$_REQUEST['mtype'];
$rtype=trim($_REQUEST['rtype']);

$langx=$_REQUEST['langx'];
$date=date("Y-m-d");
$sql = "select language,memname from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	/*echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;*/
}
$row = mysql_fetch_array($result);
$memname=$row['memname'];
//userlog($memname);
require ("../include/traditional.$langx.inc.php");

$tab_id="id=game_table";
switch ($rtype){
	case "r_main":
	case "r_all":
	case "r_no":
	case "r_sub":
		$caption=$quanbu_all;
		$show="OU";
		$width=30;
		$body_id="MFT";
		$body_class="BKR";
		$upd_msg=$udpsecond;
		$table='<td colspan="2" id="mygtype"class="bet_game_name"><span class="bet_name_long">篮球 &amp; 美式足球 </span><br><tt class="bet_game">'.$jinri.'</tt></td>
				<td class="bet_title_1X2"><span><tt>'.$win.'</tt></span></td>
				<td class="bet_title_hdp"><span><tt>'.$rang.'</tt></span></td>
				<td class="bet_title_ou"><span><tt>'.$OverUnder2.'</tt></span></td>
				<td colspan="2" class="bet_title_tp"><tt>'.$jfdx.'</tt></td>';
		break;
	case "re_all":
	case "re_main":
	case "re_sub":
	case "re_no":
		$caption=$quanbu_all.$RunningBall;
		$show="OU";
		$width=30;
		$body_id="MBK";
		$body_class="BKRE";
		$upd_msg=$udpsecond;
		$table='<td colspan="2"  id="mygtype" class="bet_game_name"><span class="bet_name_long">篮球 &amp; 美式足球 </span><br><tt class="bet_game">'.$run.'</tt></td>
				<td class="bet_title_1X2"><span><tt>'.$win.'</tt></span></td>
				<td class="bet_title_hdp"><span><tt>'.$rang.'</tt></span></td>
				<td class="bet_title_ou"><span><tt>'.$OverUnder2.'</tt></span></td>
				<td colspan="2" class="bet_title_tp"><tt>'.$jfdx.'</tt></td>';

		break;
	case "p3":
		$caption=$quanbu_all.$zhgg;
		$show="PR";
		$body_id="MFT";
		$body_class="BKP3";
		$tab_id="";
		$upd_msg=$Paicai;
		$table='<td colspan="2"  id="mygtype" class="bet_game_name"><span class="bet_name_long">篮球 &amp; 美式足球 </span><br><tt class="bet_game">'.$zhgg.'</tt></td>
<td class="bet_title_hdp"><span><tt>'.$duyingpan.'</tt></span></td>
<td class="bet_title_hdp"><span><tt>'.$bk_pralayr.'</tt></span></td>
<td class="bet_title_ou"><span><tt>'.$OverUnder2.'</tt></span></td>
<td class="bet_title_tp"><tt>'.$Odd.'/'.$Even.'</tt></td>';
		break;
}
?>
<html>
<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link href="/style/member/reset.css" rel="stylesheet" type="text/css">
	<link href="/style/member/bet_maincortol.css" rel="stylesheet" type="text/css">

	<script>
		var rtype = '<?=$rtype?>';
		if (rtype=='p3'){var minlimit='0';var maxlimit='0';}
		top.today_gmt = '<?=$date?>';
		top.showtype = '<?=$showtype?>';
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
		var Market="";
		var Period="";

		//網頁載入
		function onLoad(){
			top.swShowLoveI=false;

			if((""+eval("parent."+sel_gtype+"_lname_ary"))=="undefined") eval("parent."+sel_gtype+"_lname_ary='ALL'");
			if((""+eval("parent."+sel_gtype+"_lid_ary"))=="undefined") eval("parent."+sel_gtype+"_lid_ary='ALL'");

			if(parent.ShowType==""||rtype=="r_main") parent.ShowType = 'OU';
			if(rtype=="re_main") parent.ShowType = 'RE';
			//alert(parent.parent.leg_flag);
			if(parent.parent.leg_flag=="Y"){
				parent.parent.leg_flag="N";
				parent.pg=0;
				reload_var("");
			}else{
				showPicLove();
			}
			parent.loading = 'N';
			//alert(parent.loading_var);
			if(parent.loading_var == 'N'){
				parent.ShowGameList();
			}
			if (parent.retime_flag == 'Y'){//alert(parent.retime_flag);
				count_down();
			}
			document.getElementById("odd_f_window").style.display = "none";
			if(sel_gtype=="BU"){
				if (rtype!="p3"){
					if(top.showtype!='hgft'){
						selgdate(rtype,parent.g_date);
					}
				}
				//futureShowGtypeTable();
			}
			if (""+top.BK_RE_session=="undefined"){
				top.BK_RE_session="all";
			}

			gameSort();
			if (rtype!="p3"){
				setMarketPeriod(rtype);
				MarketPeriod();
			}
		}

		window.onscroll = scroll;

		function scroll()
		{
//			var refresh_right= document.getElementById('refresh_right');
//			refresh_right.style.top=document.body.scrollTop+39;
			//refresh_right.style.top=document.body.scrollTop+21+34+25+10;
			//refresh_right.style.top=document.body.scrollTop+(document.body.clientHeight-118)/2;
			// 捲軸位置              +( frame高度                -header高度)/2

			//alert("scroll event detected! "+document.body.scrollTop);
//
			//conscroll.style.display="block";
//conscroll.style.top=document.body.scrollTop;
			// note: you can use window.innerWidth and window.innerHeight to access the width and height of the viewing area
		}

		function setleghi(leghight){
			var legview =document.getElementById('legFrame');

			if((leghight*1) > 95){
				legview.height = leghight;
			}else{

				legview.height = 95;
			}

		}

		function reload_var(Level){
			showPicLove();
			parent.loading_var = 'Y';
			if(Level=="up"){
				var tmp = "./"+parent.sel_gtype+"_browse/body_var.php";
				if (parent.sel_gtype=="BU"){
					tmp = "./BK_future/body_var.php";
				}
			}else{
				var tmp = "./body_var.php";
			}

			var l_id =eval("parent.parent."+sel_gtype+"_lid_type");
			if(top.showtype=='hgft'&&parent.sel_gtype=="BU"){
				l_id=3;
			}
			if(parent.rtype == "p3") top.hot_game="";
			var homepage = tmp+"?uid=<?=$uid?>&rtype="+parent.rtype+"&langx=<?=$langx?>&mtype=<?=$mtype?>&page_no="+parent.pg+"&league_id="+l_id+"&hot_game="+top.hot_game;
			//alert(homepage);
			if (parent.sel_gtype=="BU"){

				homepage+="&g_date="+parent.g_date;
			}

			parent.body_var.location = homepage;
			if(rtype=="r_main") document.getElementById('more_window').style.display='none';
		}



		//賽事換頁
		function chg_pg(pg){
			if (pg==parent.pg) {return;}
			parent.pg=pg;
			reload_var("");
		}

		function chg_wtype(wtype){
			var l_id =eval("parent.parent."+sel_gtype+"_lid_type");
			if(top.showtype=='hgft'&&parent.sel_gtype=="BU"){
				l_id=3;
			}
			parent.location.href="index.php?uid="+top.uid+"&langx="+top.langx+"&mtype="+parent.ltype+"&rtype="+wtype+"&showtype=&league_id="+l_id;

			//<frame name="body_var" scrolling="NO" noresize src="body_var.php?uid=<?echo $uid?>&rtype=<?echo $rtype?>&langx=<?echo $langx?>&mtype=<?echo $mtype;?>&delay=<?echo $delay;?>&league_id=<?echo $league_id?>">
			//<frame name="body_browse" src="body_browse.php?uid=<?echo $uid?>&rtype=<?echo $rtype?>&langx=<?echo $langx?>&mtype=<?echo $mtype;?>&delay=<?echo $delay;?>&showtype=<?echo $showtype?>">


		}

		//選擇聯盟



		function unload(){
			clearInterval(ReloadTimeID);
		}
		window.onunload=unload;

		//-----------------------------future------------------------
		function selgdate(rtype,cdate){
			//賽事分日期
			var date_opt = "";
			var arrDate =new Array();
			var year ='';
			var nowDate="";
			if(top.showtype=='hgft'){
				var tmpdate=DateAry[0].split("-");
				for (i = 0; i < parent.hotgdateArr.length; i++) {
					var tmpd =parent.hotgdateArr[i].split("-");
					if(tmpdate[1]*1 > tmpd[0]*1){
						year =tmpdate[0]*1+1;
					}else{
						year =tmpdate[0];
					}
					arrDate =arraySort1(arrDate,year+'-'+parent.hotgdateArr[i]);
				}
				if(cdate=='')cdate ='ALL';
				date_opt = '<select id="g_date" name="g_date" onChange="chg_gdate()">';
				date_opt+= '<option value="ALL" '+((cdate =='ALL')?'selected':'')+'>'+top.alldata+'</option>';
				for (i = 0; i < arrDate.length; i++) {
					nowDate=showdate(arrDate[i]);
					date_opt+= '<option value="'+arrDate[i]+'" '+((cdate ==arrDate[i])?'selected':'')+'>'+nowDate+'</option>';
				}
				date_opt+= "</select>";
			}else{
				arrDate=DateAry ;
				date_opt = "<select id=\"g_date\" name=\"g_date\" onChange=\"chg_gdate()\">";
				date_opt+= "<option value=\"ALL\">"+top.alldata+"</option>";
				//if (rtype == "r_no" ) {
				//	date_opt+= "<option value=\"1\" "+((cdate =='1')?'SELECTED':'')+" >"+top.S_EM+"</option>";
				//}
				for (i = 0; i < arrDate.length; i++) {
					nowDate=showdate(arrDate[i]);
					date_opt+= "<option value=\""+arrDate[i]+"\" "+((cdate == arrDate[i] )?'SELECTED':'')+">"+nowDate+"</option>";
				}
				date_opt+= "</select>";
			}

			document.getElementById("show_date_opt").innerHTML = date_opt;
		}
		function showdate(sdate){
			var showgdate=sdate.split("-");
			tmpsdate=showgdate[1]+"-"+showgdate[2];
			if(top.langx=="zh-tw"||top.langx=="zh-cn") {
				if((showgdate[1]*1)< 10) showgdate[1]=showgdate[1]*1;
				if((showgdate[2]*1)< 10) showgdate[2]=showgdate[2]*1;
				tmpsdate=showgdate[1]+top.showmonth+showgdate[2]+top.showday;
			}
			return tmpsdate;
		}
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
			eval("parent.parent."+parent.sel_gtype+"_lid_type=top."+parent.sel_gtype+"_lid['"+parent.sel_gtype+"_lid_type']");
			reload_var("");
		}

		//單式盤面點下我的最愛
		function showMyLove(gtype){
			top.swShowLoveI =true;
			//精選賽事導回
			if(top.hot_game!=""){
				top.hot_game="";
//				document.getElementById("euro_btn").style.display='';
//				document.getElementById("euro_up").style.display='none';
			}
			//
			parent.pg =0;
			//if (gtype=="FU"){
			eval("parent.parent."+parent.sel_gtype+"_lid_type='3'");
			//}
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
			if(sel_gtype=="FT"||sel_gtype=="OP"||sel_gtype=="BK"||sel_gtype=="BS"||sel_gtype=="VB"||sel_gtype=="TN"){
				if(rtype=="re_main"||rtype.match("re_main")){
					out=array[0];
				}else{
					out=array[1];
				}
			}else if(sel_gtype=="FU"||sel_gtype=="OM"||sel_gtype=="BU"||sel_gtype=="BSFU"||sel_gtype=="VU"||sel_gtype=="TU"){
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

		if (top.keep_LoveI_array_BK==undefined) top.keep_LoveI_array_BK=new Array();
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

				top.ShowLoveIarray[getGtype]= arraySort(top.ShowLoveIarray[getGtype] ,new Array(gid,getDateTime,getLid,team_h,team_c));
				//單式最愛帶進去滾球
				if(parent.rtype!="re"){
					loveI_has_in=true;
					for (i=0;i < top.keep_LoveI_array_BK.length;i++){
						if(top.keep_LoveI_array_BK[i][0]==gid){
							loveI_has_in=false;
							break;
						}
					}
					if(loveI_has_in){
						tmpd=getDateTime.split("<br>");
						tmpDateTime=tmpd[0]+"<br>"+tmpd[1];
						top.keep_LoveI_array_BK.push(new Array(gid,tmpDateTime,getLid,team_h,team_c));
					}
				}
				chkOKshowLoveI();
			}
			document.getElementById("sp_"+MM_imgId(getDateTime,gid)).innerHTML = "<div class=\"bet_game_star_on\" style=\"cursor:hand\" title=\""+top.str_delShowLoveI+"\" onClick=\"chkDelshowLoveI('"+getDateTime+"','"+gid+"');\"></div>";
		}

		function auto_re_addShowLoveI(Game_Data){
			var getGtype =getGtypeShowLoveI();

			//var tmpAry = new Array();
			//for (var k=0;k < top.keep_LoveI_array_BK.length;k++){
			//tmpAry[tmpAry.length] = top.keep_LoveI_array_BK[k];
			//}
			for (var i=top.keep_LoveI_array_BK.length-1;i >= 0;i--){
				var tmp=top.keep_LoveI_array_BK[i][1].split("<br>");
				newTime=parent.change_time(tmp[1])+":00";
				var tmp_today_gmt=top.today_gmt.split("-");
				chk_date_time=tmp_today_gmt[0]+"-"+tmp[0]+" "+newTime;
				var tmp_find=false;
				var tmp_gid=top.keep_LoveI_array_BK[i][0];
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
						top.ShowLoveIarray[getGtype] = arraySort(top.ShowLoveIarray[getGtype] ,top.keep_LoveI_array_BK[i]);
					}
					//tmpAry.splice(i,1);
					Array.prototype.splice.call(top.keep_LoveI_array_BK,i,1);

				}
			}
			chkOKshowLoveI();
			//top.keep_LoveI_array_BK = tmpAry;
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
			if(getRtype=="re_main"){
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


		function chkDelshowLoveI(data2,gid){
			var getGtype = getGtypeShowLoveI();
			var tmpdata = data2.split("<br>")[0]+gid;
			var tmpdata1 ="";
			var ary = new Array();
			var tmp = new Array();
			tmp = top.ShowLoveIarray[getGtype];
			top.ShowLoveIarray[getGtype]= new Array();
			for (var i=0 ; i < tmp.length ; i++){
				tmpdata1 =tmp[i][1].split("<br>")[0]+tmp[i][0];
				if(tmpdata1 == tmpdata){
					//alert("tmp[i]===>"+tmp[i]);
					ary = tmp[i];
					//var tmpAry = new Array();
					//for (var k=0;k < top.keep_LoveI_array_BK.length;k++){
					//	tmpAry[tmpAry.length] = top.keep_LoveI_array_BK[k];
					//}
					//alert(data);
					for (var s=0;s < top.keep_LoveI_array_BK.length;s++){
						//alert(top.keep_LoveI_array_BK[s][0]+"---"+gid);
						if(top.keep_LoveI_array_BK[s][0]==gid) Array.prototype.splice.call(top.keep_LoveI_array_BK,s,1);
					}
					//top.keep_LoveI_array_BK=tmpAry;
					continue;
				}
				top.ShowLoveIarray[getGtype].push(tmp[i]);
			}
			chkOKshowLoveI();
			var gtypeNum= StatisticsGty(top.today_gmt,top.now_gmt,getGtypeShowLoveI());
			if(top.swShowLoveI){

				var sw=false;
				//alert(top.swShowLoveI+"-"+gtypeNum);
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
				//tmpdata=GameArray[s].datetime.split("<br>")[0]+GameArray[s].gidm+"-"+GameArray[s].gnum_h;
				tmpdata=GameArray[s].datetime.split("<br>")[0]+GameArray[s].gidm;
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
				/*
				 else{
				 odd_show+="<option value="+Format[i][0]+tmp_check+">"+Format[i][1]+"</option>";
				 }
				 */
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

		function change_rtype(){
			top.hot_game="";
			var tmp_date_str="";
			//var myOddtype=document.getElementById("sel_rtype");
			var myG_date=document.getElementById("g_date");
			//rtype=myOddtype.options[myOddtype.selectedIndex].value;
			if(myG_date != null)tmp_date_str="&g_date="+myG_date.options[myG_date.selectedIndex].value;
			parent.location.href="index.php?uid="+top.uid+"&langx="+top.langx+"&mtype="+parent.ltype+"&rtype="+rtype+tmp_date_str;

		}
		function change_RE_session(){
			top.hot_game="";
			//var myOddtype=document.getElementById("sel_rtype");
			//rtype=myOddtype.options[myOddtype.selectedIndex].value;
			//top.BK_RE_session=rtype;
			reload_var("");
			// parent.location.href="index.php?uid="+top.uid+"&langx="+top.langx+"&mtype="+parent.ltype+"&rtype="+rtype;
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
			reload_var('');
		}

		function Euro(){

			if(top.hot_game!=""){
				top.hot_game="";
				top.swShowLoveI=false;
//				document.getElementById("euro_btn").style.display='';
//				document.getElementById("euro_up").style.display='none';
			}else{
				top.hot_game="HOT_";
//				document.getElementById("euro_btn").style.display='none';
//				document.getElementById("euro_up").style.display='';

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
			document.getElementById("SortForm").action="../setSortType.php";
			if(top.SortType == document.getElementById("SortSel").value ) {
				refreshReload();
				return;
			}
			document.getElementById("SortForm").submit();
		}

		function gameSort(){
			if(top.SortType=="") top.SortType="T";
			document.getElementById("SortSel").value = top.SortType;
		}
		function setMarketPeriod(aRtype){
			if(aRtype=="r_sub"|| aRtype=="re_sub"){Market="All";Period="Hide";}
			else if(aRtype=="all"){Market="Main";Period="View";}
			else if(aRtype=="r_no" || aRtype=="re_no"){Market="All";Period="View";}
			else if(aRtype=="r_main" || aRtype=="re_main"){Market="Main";Period="View";}
			else if(aRtype=="r_all" || aRtype=="re_all"){Market="Main";Period="Hide";}
		}
		function getRtype(aRtype){
			var tmp_str="r";
			if(aRtype.match("re")){
				tmp_str="re"
			}
			if(Market=="All" && Period=="Hide"){
				tmp_str= tmp_str+"_sub";
			}
			else if(Market=="All" && Period=="View"){
				tmp_str= tmp_str+"_no";
			}
			else if(Market=="Main" && Period=="View"){
				tmp_str= tmp_str+"_main";
			}
			else if(Market=="Main" && Period=="Hide"){
				tmp_str= tmp_str+"_all";
			}
			return tmp_str
		}
		function MarketPeriod(){
			var spanM=document.getElementById("SpanMarket");
			var spanP=document.getElementById("SpanPeriod");
			//alert("str_BK_Period_"+Period);
			spanM.innerHTML = top["str_BK_Market_"+Market];
			spanP.innerHTML = top["str_BK_Period_"+Period];
		}
		function chgMarket(event){//Main,All
			if(Market=="Main")Market="All";
			else Market="Main";
			if(Period=="")Period="View";
			MarketPeriod();
			parent.rtype = getRtype(rtype);
			//日期特早 切換帶回全部
			//if(parent.g_date==1 && parent.rtype != "r_no")parent.g_date="ALL"
			refreshReload();
		}

		function chgPeriod(event){//View,Hide
			if(Period=="View")Period="Hide";
			else Period="View";
			if(Market=="")Market="All";
			MarketPeriod();
			parent.rtype = getRtype(rtype);
			//日期特早 切換帶回全部
			//if(parent.g_date==1 && parent.rtype != "r_no")parent.g_date="ALL"
			refreshReload();
		}
	</script>

</head>

<body id="MFT"  class="bet_r_BKF" onLoad="onLoad();">

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
<div id=DataTR style="display:none;">
	<xmp>
		<!--SHOW LEGUAGE START-->
		<? if($rtype=='all' or $rtype=='r_sub' or $rtype=='r_no' or $rtype=='r_main'){?>
			<tr *ST* class="bet_game_league">
				<td colspan="8" onClick="parent.showLeg('*LEG*')">*LEG*</td>
			</tr>
			<!--SHOW LEGUAGE END-->
			<tr id="TR_*ID_STR*" *TR_EVENT* class="bet_game_tr_top">
				<td rowspan="2" class="bet_game_time"><div>*DATETIME*</div></td>
				<td class="bet_team">*TEAM_H*<span class="more_txt bk_more">*MORE*</span></span>
				</td>
				<td class="bet_text">*RATIO_MH*</td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">*CON_RH*</tt></span><span class="bet_text_tdr">*RATIO_RH*</span></div></td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*CON_OUH*</tt></span><span class="bet_text_tdr">*RATIO_OUH*</span></div></td>
				<td id="TR_*ID_STR*_text_1" class="bet_textbor_bg"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*CON_OUHO*</tt></span><span class="bet_text_tdr">*RATIO_OUHO*</span></div></td>
				<td id="TR_*ID_STR*_text_2" class="bet_textbor_bg_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*CON_OUHU*</tt></span><span class="bet_text_tdr">*RATIO_OUHU*</span></div></td>
			</tr>
			<tr id="TR1_*ID_STR*" *TR_EVENT* class="bet_game_tr_other">
				<td class="bet_team"><div class="bet_text_table"><span class="bet_text_tdl">*TEAM_C*</span><span class="bet_text_tdstar">*MYLOVE*</span></div></td>
				<td class="bet_text">*RATIO_MC*</td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">*CON_RC*</tt></span><span class="bet_text_tdr">*RATIO_RC*</span></div></td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*CON_OUC*</tt></span><span class="bet_text_tdr">*RATIO_OUC*</span></div></td>
				<td id="TR1_*ID_STR*_text_1"class="bet_textbor_color_bg"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*CON_OUCO*</tt></span><span class="bet_text_tdr">*RATIO_OUCO*</span></div></td>
				<td id="TR1_*ID_STR*_text_2"class="bet_textbor_color_bg_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*CON_OUCU*</tt></span><span class="bet_text_tdr">*RATIO_OUCU*</span></div></td>
			</tr>
		<? }
		if($rtype=='re_all' or $rtype=='re_sub' or $rtype=='re_no' or $rtype=='re_main'){
			?>
			<tr *ST* class="bet_game_league">
				<td colspan="8" onClick="parent.showLeg('*LEG*')">*LEG*</td>
			</tr>
			<!--SHOW LEGUAGE END-->
			<tr id="TR_*ID_STR*" *TR_EVENT* class="bet_game_tr_top">
				<td rowspan="2" class="bet_game_time"><div>*SE*&nbsp;<span class="rb_time_color">*RB_TIME*</span></div></td>
				<td class="bet_team">*TEAM_H*<span class="more_txt bk_more">*MORE*</span></span>
				</td>
				<td class="bet_text">*RATIO_MH*</td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">*CON_RH*</tt></span><span class="bet_text_tdr">*RATIO_RH*</span></div></td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*CON_OUH*</tt></span><span class="bet_text_tdr">*RATIO_OUH*</span></div></td>
				<td id="TR_*ID_STR*_text_1" class="bet_textbor_bg"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*CON_OUHO*</tt></span><span class="bet_text_tdr">*RATIO_OUHO*</span></div></td>
				<td id="TR_*ID_STR*_text_2" class="bet_textbor_bg_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*CON_OUHU*</tt></span><span class="bet_text_tdr">*RATIO_OUHU*</span></div></td>
			</tr>
			<tr id="TR1_*ID_STR*" *TR_EVENT* class="bet_game_tr_other">
				<td class="bet_team"><div class="bet_text_table"><span class="bet_text_tdl">*TEAM_C*</span><span class="bet_text_tdstar">*MYLOVE*</span></div></td>
				<td class="bet_text">*RATIO_MC*</td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">*CON_RC*</tt></span><span class="bet_text_tdr">*RATIO_RC*</span></div></td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*CON_OUC*</tt></span><span class="bet_text_tdr">*RATIO_OUC*</span></div></td>
				<td id="TR1_*ID_STR*_text_1"class="bet_textbor_color_bg"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*CON_OUCO*</tt></span><span class="bet_text_tdr">*RATIO_OUCO*</span></div></td>
				<td id="TR1_*ID_STR*_text_2"class="bet_textbor_color_bg_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*CON_OUCU*</tt></span><span class="bet_text_tdr">*RATIO_OUCU*</span></div></td>
			</tr>
		<? }
		if($rtype=='p3'){
			?>
			<tr *ST* class="bet_game_league">
				<td colspan="6" onClick="parent.showLeg('*LEG*')"><span>*LEG*</span><span class="bet_in_bg">*PORDER* 串 1</span></td>
			</tr>
			<tr id="TR_*ID_STR*" *TR_EVENT* class="bet_game_tr_top">
				<td rowspan="2" class="bet_game_time"><div>*DATETIME*</div></td>
				<td class="bet_team"><div class="bet_team_div_or">*TEAM_C*</div></td>
				<td class="bet_text">*RATIO_MH*</td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">*CON_RH*</tt></span><span class="bet_text_tdr">*RATIO_RH*</span></div></td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*CON_OUC*</tt></span><span class="bet_text_tdr">*RATIO_OUC*</span></div></td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*RATIO_EOO*</tt></span></div></td>
			</tr>
			<tr id="TR1_*ID_STR*" *TR_EVENT* class="bet_game_tr_other">
				<td class="bet_team"><div class="bet_team_div_or">*TEAM_H*</div></td>
				<td class="bet_text">*RATIO_MC*</td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">*CON_RC*</tt></span><span class="bet_text_tdr">*RATIO_RC*</span></div></td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*CON_OUH*</tt></span><span class="bet_text_tdr">*RATIO_OUH*</span></div></td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*RATIO_EOE*</tt></span></div></td>
			</tr>

		<? }?>
	</xmp>
</div>
<div id=NoDataTR style="display:none;">
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