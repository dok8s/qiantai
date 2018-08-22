<?
include "../include/library.mem.php";

echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";

require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$mtype=$_REQUEST['mtype'];
$rtype=trim($_REQUEST['rtype']);
$langx=$_REQUEST['langx'];
$g_date=$_REQUEST['g_date'];
require ("../include/traditional.$langx.inc.php");

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
switch ($rtype){
	case "r":
		$caption=$paiqiuzp;
		$upd_msg=$udpsecond;
		$table='<td colspan="2" id="mygtype" class="bet_game_name">排球<br><tt class="bet_game">早盘</tt></td>
<td class="bet_title_hdp"><span><tt>'.$bk_pralayr.'</tt></span></td>
<td class="bet_title_ou"><span><tt>'.$OverUnder.'</tt></span></td>
<td class="bet_title_tp"><tt>'.$Odd.'/'.$Even.'</tt></td>';
		break;
	case "re":
		$caption=$RunningBall;
		$upd_msg=$udpsecond;
		$table='<th width="7%">'.$Score.'</th>
          <th class="time">'.$Times.'</th>
           <th width="39%">'.$HomeTeam.'</th>
           <th width="24%">'.$tn_parlayr.'</th>
           <th width="26%">'.$OverUnder.'</th>';
		break;
	case "pd":
		$caption=$paiqiuzp.':'.$saipan;
		$show="PD";
		$width=30;
		$upd_msg=$Paicai;
		$table='<td colspan="2" class="bet_game_name">排球<br><tt class="bet_game">早盘</tt></td>
				<td class="bet_title_point"><tt>2-0</tt></td>
				<td class="bet_title_point"><tt>2-1</tt></td>
				<td class="bet_title_point"><tt>3-0</tt></td>
				<td class="bet_title_point"><tt>3-1</tt></td>
				<td class="bet_title_point"><tt>3-2</tt></td>
				</tr><tr class="bet_correct_title">
				<td colspan="7"><span>波胆</span><span class="bet_corr_number">'.$paicai1.'</span></td>';
		break;
	case "pr":
		$caption=$paiqiuzp.':'.$zhgg;
		$show="PR";
		$width=55;
		$tab_id="";
		$upd_msg=$Paicai;
		$table='<th class="time">'.$Times.'</th>
              <th class="team">'.$HomeTeam.'</th>
              <th class="h_r">'.$tn_parlayr.'</th>
              <th class="h_ou">'.$OverUnder.'</th>
              <th class="h_oe">'.$Odd.'/'.$Even.'</th>';
		break;
	case "p":
		$caption=$Parlay;
		$tab_id="";
		$upd_msg=$Paicai;
		$table='<th class="time">'.$Times.'</th>
          <th width="156">'.$Home.'</th>
          <th width="55">&nbsp;</th>
          <th width="55">&nbsp;</th>
          <th width="160">'.$Away.'</th>';
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
		var DateAry = new Array('<?=date('Y-m-d',strtotime('1 day'))?>','<?=date('Y-m-d',strtotime('2 day'))?>','<?=date('Y-m-d',strtotime('3 day'))?>','<?=date('Y-m-d',strtotime('4 day'))?>','<?=date('Y-m-d',strtotime('5 day'))?>','<?=date('Y-m-d',strtotime('6 day'))?>','<?=date('Y-m-d',strtotime('7 day'))?>','<?=date('Y-m-d',strtotime('8 day'))?>','<?=date('Y-m-d',strtotime('9 day'))?>','<?=date('Y-m-d',strtotime('10 day'))?>','<?=date('Y-m-d',strtotime('11 day'))?>');
		top.today_gmt = '<?=date('Y-m-d')?>';
		top.today_gmt = '<?=date('Y-m-d')?>';
		var rtype = '<?=$rtype?>';
		var odd_f_str = 'H,M,I,E';
		var Format=new Array();
		Format[0]=new Array( 'H','香港盘','Y');
		Format[1]=new Array( 'M','马来盘','Y');
		Format[2]=new Array( 'I','印尼盘','Y');
		Format[3]=new Array( 'E','欧洲盘','Y');
	</script>
	<script>
		//在body_browse載入


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
			if(sel_gtype=="VU"){
				if (rtype=="r" || rtype=="pd"){
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
				if (parent.sel_gtype=="VU"){
					tmp = "./VB_future/body_var.php";
				}
			}else{
				var tmp = "./body_var.php";
			}

			var l_id =eval("parent.parent."+sel_gtype+"_lid_type");
			if(top.showtype=='hgft'&&parent.sel_gtype=="VU"){
				l_id=3;
			}

			var homepage = tmp+"?uid="+parent.uid+"&rtype="+parent.rtype+"&langx="+parent.langx+"&mtype="+parent.ltype+"&page_no="+parent.pg+"&league_id="+l_id;
			//alert("parent.g_date==>"+parent.g_date)
			if (parent.sel_gtype=="VU"){

				homepage+="&g_date="+parent.g_date;
			}
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
			if(top.showtype=='hgft'&&parent.sel_gtype=="VU"){
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
				if (rtype == "r") {
					date_opt+= "<option value=\"1\" >"+top.S_EM+"</option>";
				}
				for (i = 0; i < arrDate.length; i++) {
					nowDate=showdate(arrDate[i]);
					date_opt+= "<option value=\""+arrDate[i]+"\" >"+nowDate+"</option>";
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
				top.ShowLoveIarray[getGtype]= arraySort(top.ShowLoveIarray[getGtype] ,new Array(gid,getDateTime,getLid,team_h,team_c));
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


		function chkDelshowLoveI(data2,data){
			var getGtype = getGtypeShowLoveI();
			var tmpdata = data2.split("<br>")[0]+data;
			var tmpdata1 ="";
			var ary = new Array();
			var tmp = new Array();
			tmp = top.ShowLoveIarray[getGtype];
			top.ShowLoveIarray[getGtype]= new Array();
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
				//	if((odd_f_str.indexOf(Format[i][0])!=(-1))&&Format[i][2]=="Y"){
				if((odd_f_str.indexOf(Format[i][0])!=(-1))&&Format[i][2]=="Y"){

					if(top.odd_f_type==Format[i][0]){
						odd_show+="<option value="+Format[i][0]+tmp_check+" selected>"+Format[i][1]+"</option>";
					}else{
						odd_show+="<option value="+Format[i][0]+tmp_check+">"+Format[i][1]+"</option>";
					}
				}
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

		function refreshReload(){

//			document.getElementById("refresh_right").className='refresh_M_on';
//			document.getElementById("refresh_btn").className='refresh_on';
//			document.getElementById("refresh_down").className='refresh_M_on';
			reload_var("");
		}
	</script>
</head>

<body  id="MVU" class="bet_t_VBF" onLoad="onLoad();">

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
<div id=DataTR style="display:none;" >
	<xmp>
		<!--SHOW LEGUAGE START-->
		<?
		if ($rtype=='r'){
			?>
			<tr *ST* class="bet_game_league">
				<td colspan="6" onClick="parent.showLeg('*LEG*')">*LEG*</td>
			</tr>
			<!--SHOW LEGUAGE END-->
			<tr id="TR_*ID_STR*" *TR_EVENT* class="bet_game_tr_top">
				<td rowspan="2" class="bet_game_time"><div>*DATETIME*</div></td>
				<td class="bet_team"><div class="bet_team_div_or">*TEAM_H*</div></td>
				<td class="bet_text">*RATIO_MH*</td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">*CON_RH*</tt></span><span class="bet_text_tdr">*RATIO_RH*</span></div></td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*CON_OUH*</tt></span><span class="bet_text_tdr">*RATIO_OUH*</span></div></td>
				<td class="bet_text">*RATIO_EOO*</td>
			</tr>
			<tr id="TR1_*ID_STR*" *TR_EVENT* class="bet_game_tr_other">
				<td class="bet_team"><div class="bet_text_table"><span class="bet_text_tdl">*TEAM_C* </span><span class="bet_text_tdstar">*MYLOVE*</span></div></td>
				<td class="bet_text">*RATIO_MC*</td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">*CON_RC*</tt></span><span class="bet_text_tdr">*RATIO_RC*</span></div></td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*CON_OUC*</tt></span><span class="bet_text_tdr">*RATIO_OUC*</span></div></td>
				<td class="bet_text">*RATIO_EOE*</td>
			</tr>
		<? }
		if($rtype=="pd"){
			?>
			<tr *ST* class="bet_game_league">
				<td colspan="7" onClick="parent.showLeg('*LEG*')">*LEG*</td>
			</tr>
			<!--SHOW LEGUAGE END-->
			<tr id="TR_*ID_STR*" *TR_EVENT* class="bet_game_correct_top">
				<td rowspan="2" class="bet_game_time"><div>*DATETIME*</div></td>
				<td class="bet_team"><div class="bet_team_div_or">*TEAM_H*</div></td>
				<td class="bet_text">*RATIO_H2C0*</td>
				<td class="bet_text">*RATIO_H2C1*</td>
				<td class="bet_text">*RATIO_H3C0*</td>
				<td class="bet_text">*RATIO_H3C1*</td>
				<td class="bet_text">*RATIO_H3C2*</td>
			</tr>

			<tr id="TR1_*ID_STR*" *TR_EVENT* class="bet_game_correct_other">
				<td class="bet_team">*TEAM_C*</td>
				<td class="bet_text">*RATIO_H0C2*</td>
				<td class="bet_text">*RATIO_H1C2*</td>
				<td class="bet_text">*RATIO_H0C3*</td>
				<td class="bet_text">*RATIO_H1C3*</td>
				<td class="bet_text">*RATIO_H2C3*</td>
			</tr>
		<? }
		if($rtype=="pr"){
			?>
			<tr *ST* class="bet_game_league">
				<td colspan="11" onClick="parent.showLeg('*LEG*')">*LEG*</td>
			</tr>
			<!--SHOW LEGUAGE END-->
			<tr id="TR_*ID_STR*" *TR_EVENT* *CLASS*>
				<td rowspan="2" class="b_cen"><table><tr><td class="b_cen">*DATETIME*</td></tr></table></td>
				<td rowspan="2" class="team_name">*TEAM_H*<br>*TEAM_C*</td>
				<td class="b_rig">&nbsp;</td>
				<td class="b_rig"  id="*GID_RH*"><span class="con">*CON_RH*</span> <span class="ratio">*RATIO_RH*</span></td>
				<td class="b_rig"  id="*GID_OUC*"><span class="con">*CON_OUC*</span> <span class="ratio">*RATIO_OUC*</span></td>
				<td class="b_rig">&nbsp;</td>
			</tr>
			<tr id="TR1_*ID_STR*" *TR_EVENT* *CLASS*>
				<td class="b_rig">&nbsp;</td>
				<td class="b_rig"  id="*GID_RC*"><span class="con">*CON_RC*</span> <span class="ratio">*RATIO_RC*</span></td>
				<td class="b_rig"  id="*GID_OUH*"><span class="con">*CON_OUH*</span> <span class="ratio">*RATIO_OUH*</span></td>
				<td class="b_rig">&nbsp;</td>
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
