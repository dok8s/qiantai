<?
include "../include/library.mem.php";

echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";

require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$mtype=$_REQUEST['mtype'];
$rtype=trim($_REQUEST['rtype']);
$langx=$_REQUEST['langx'];

$sql = "select * from web_member where Oid='$uid' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
$memname=$row['Memname'];$openwin=$row['openwin'];
//userlog($memname);
require ("../include/traditional.$langx.inc.php");
if ($langx=='en-us'){
	$css='_en';
}
$tab_id="id=game_table";

$table0='<td id="mygtype" colspan="2" class="bet_game_name">棒球<br><tt class="bet_game">'.$jinri.'</tt></td>
            <td class="bet_title_1X2"><span>'.$res_total.'<br><tt>'.$win.'</tt></span></td>
            <td class="bet_title_hdp"><span>'.$res_total.'<br><tt>'.$bask_letb.'</tt></span></td>
            <td class="bet_title_ou"><span>'.$res_total.'<br><tt>'.$OverUnder2.'</tt></span></td>
            <td class="bet_title_oe"><span>'.$res_total.'<br><tt>'.$Odd.'/'.$Even.'</tt></span></td>
            <td class="bet_title_1X2"><span>'.$qianwuju.'<br><tt>主客和</tt></span></td>
            <td class="bet_title_hdp"><span>'.$qianwuju.'<br>'.$bask_letb.'</span></td>
            <td class="bet_title_ou"><span>'.$qianwuju.'<br>'.$OverUnder2.'</span></td>';
$table1=' <th class="time">'.$Times.'</th>
          <th class="team">'.$HomeTeam.'</th>
          <th>'.$win.'</th>
          <th>'.$Handicap.'</th>
          <th>'.$OverUnder.'</th>';
$table2=' <td id="mygtype" colspan="2" class="bet_game_name"><span class="bet_name_long">棒球</span><br><tt class="bet_game">'.$run.'</tt></td>
				<td class="bet_title_hdp"><span><tt>'.$rang.'</tt></span></td>
				<td class="bet_title_ou"><span><tt>'.$OverUnder2.'</tt></span></td>';
$table3=' <th class="time">'.$Times.'</th>
          <th>'.$HomeTeam.'</th>
          <!--
          <th width="7%">'.$Odd.'</th>
          <th width="7%">'.$Even.'</th>
          -->
          <th width="7%">'.$win.'</th>
          <th width="7%">1~2</th>
          <th width="7%">3~4</th>
          <th width="7%">5~6</th>
          <th width="7%">7~8</th>
          <th width="7%">9~10</th>
          <th width="7%">11~12</th>
          <th width="7%">13~14</th>
          <th width="7%">15~16</th>
          <th width="7%">17~18</th>
          <th width="7%">19up</th>';

$table4='<th class="time">'.$Times.'</th>
          <th>'.$HomeTeam.'</th>
          <th>'.$HH.'</th>
          <th>'.$HD.'</th>
          <th>'.$HA.'</th>
          <th>'.$DH.'</th>
          <th>'.$DD.'</th>
          <th>'.$DA.'</th>
          <th>'.$AH.'</th>
          <th>'.$AD.'</th>
          <th>'.$AA.'</th>';

$table5='<th class="time">'.$Times.'</th>
          <th>'.$HomeTeam.'</th>
                 <th>+1</th>
          <th>+2</th>
          <th>+3</th>
          <th>+4</th>
          <th>+5</th>
          <th>+6</th>
          <th>+7</th>
          <th>+8</th>
          <th>+9up</th>';
$table6='<td colspan="2"  id="mygtype" class="bet_game_name"><span class="bet_name_long">棒球 </span><br><tt class="bet_game">'.$zhgg.'</tt></td>
<td class="bet_title_hdp"><span><tt>'.$win.'</tt></span></td>
<td class="bet_title_hdp"><span><tt>'.$bk_pralayr.'</tt></span></td>
<td class="bet_title_ou"><span><tt>'.$OverUnder2.'</tt></span></td>
<td class="bet_title_tp"><tt>'.$Odd.'/'.$Even.'</tt></td>';
$table7=' <th class="time">'.$Times.'</th>
          <th width="156">'.$Home.'</th>
          <th width="55">&nbsp;</th>
          <th width="57">'.$Draw.'</th>
          <th width="55">&nbsp;</th>
          <th width="160">'.$Away.'</th>';
switch ($rtype){
	case "r":
		$caption=$bangqiu1;
		$upd_msg=$udpsecond;
		$table=$table0;
		$body_id="MBS";
		$body_class="BSR";
		break;
	case "hr":
		$caption=$hsthalf;
		$upd_msg=$ManualUpdate;
		$table=$table1;
		break;
	case "re":
		$caption=$bangqiu.':'.$RunningBall;
		$upd_msg=$udpsecond;
		$table=$table2;
		$body_id="MBS";
		$body_class="BSRE";
		break;
	case "hre":
		$caption=substr($hsthalf,0,4).$RunningBall;
		$upd_msg=$udpsecond;
		$table=$table2;
		break;
	case "t":
		$caption=$TotalGoals;
		$upd_msg=$RqPaicai;
		$table=$table3;
		break;
	case "f":
		$caption=$HalfFullTime;
		$upd_msg=$Paicai;
		$table=$table4;
		break;
	case "pd":
		$caption=$Correctscore;
		$upd_msg=$BdPaicai;
		$table=$table5;
		break;
	case "hpd":
		$caption=substr($hsthalf,0,4).$Correctscore;
		$upd_msg=$BdPaicai;
		$table=$table5;
		break;
	case "pr":
		$caption=$bangqiu1.':'.$zhgg;
		$tab_id="";
		$body_id="MBS";
		$body_class="BSP3";
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
		$caption=$hungeguoguan;
		$tab_id='id="p3"';
		$upd_msg=$Paicai;
		$table=$table8;
		$id='P3';
		break;
}
?>
<? if($rtype=="pr"){?>
	<script>
		var minlimit='3';
		var maxlimit='10';
	</script>
<? }?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title></title>
	<link href="/style/member/reset.css" rel="stylesheet" type="text/css">
	<link href="/style/member/bet_maincortol.css" rel="stylesheet" type="text/css">
	<script>
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
//				obj_layer = document.getElementById('LoadLayer');
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
			if(sel_gtype=="BSFU"){
				if (rtype=="r" || rtype=="pd" || rtype=="t"){
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
			//var refresh_right= document.getElementById('refresh_right');
			//refresh_right.style.top=document.body.scrollTop+39;
			//refresh_right.style.top=document.body.scrollTop+21+34+25+10;
			//refresh_right.style.top=document.body.scrollTop+(document.body.clientHeight-118)/2;
			// 捲軸位置              +( frame高度                -header高度)/2

			//alert("scroll event detected! "+document.body.scrollTop);
//
			//conscroll.style.display="block";
//conscroll.style.top=document.body.scrollTop;
			// note: you can use window.innerWidth and window.innerHeight to access the width and height of the viewing area
		}

		function reload_var(Level){
			showPicLove();
			parent.loading_var = 'Y';
			if(Level=="up"){
				var tmp = "./"+parent.sel_gtype+"_browse/body_var.php";
				if (parent.sel_gtype=="BSFU"){
					tmp = "./BS_future/body_var.php";
				}
			}else{
				var tmp = "./body_var.php";
			}

			var l_id =eval("parent.parent."+sel_gtype+"_lid_type");
			if(top.showtype=='hgft'&&parent.sel_gtype=="BSFU"){
				l_id=3;
			}

			var homepage = tmp+"?uid="+parent.uid+"&rtype="+parent.rtype+"&langx="+parent.langx+"&mtype="+parent.ltype+"&page_no="+parent.pg+"&league_id="+l_id;
			//alert("parent.g_date==>"+parent.g_date)
			if (parent.sel_gtype=="BSFU"){

				homepage+="&g_date="+parent.g_date;
			}
			parent.body_var.location = homepage;
			//if(rtype=="r") document.getElementById('more_window').style.display='none';
		}

		function setleghi(leghight){
			var legview =document.getElementById('legFrame');

			if((leghight*1) > 95){
				legview.height = leghight;
			}else{

				legview.height = 95;
			}

		}



		//倒數自動更新時間
		function count_down(){
			var rt=document.getElementById('refreshTime');
			if(parent.retime=="" || parent.retime==0){
				rt.innerHTML="<?=$shuxin?>";
			}
			setTimeout('count_down()',1000);
			if (parent.retime_flag == 'Y'){
				if(parent.retime <= 0){
					//parent.parent.header.location.reload();
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
			if(top.showtype=='hgft'&&parent.sel_gtype=="BSFU"){
				l_id=3;
			}
			parent.location.href="index.php?uid=<?=$uid?>&rtype=<?=$rtype?>&langx=<?=$langx?>&mtype="+parent.ltype+"&showtype=&league_id="+l_id;

			//<frame name="body_var" scrolling="NO" noresize src="body_var.php?uid=<?echo $uid?>&rtype=<?echo $rtype?>&langx=<?echo $langx?>&mtype=<?echo $mtype;?>&delay=<?echo $delay;?>&league_id=<?echo $league_id?>">
			//<frame name="body_browse" src="body_browse.php?uid=<?echo $uid?>&rtype=<?echo $rtype?>&langx=<?echo $langx?>&mtype=<?echo $mtype;?>&delay=<?echo $delay;?>&showtype=<?echo $showtype?>">


		}

		//選擇聯盟



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
						console.log(newtoday+" "+newgmt);
						console.log(tmpday+" "+tmpgmt);
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
			reload_var("");
		}
	</script>
</head>

<body id="<?=$body_id?>" class="bodyset <?=$body_class?>" onLoad="onLoad();">

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
<div id="DataTR" style="display:none;">
	<xmp>
		<!--SHOW LEGUAGE START-->
		<? if($rtype=="r"){?>
			<tr *ST* class="bet_game_league">
				<td colspan="9" onClick="parent.showLeg('*LEG*')">*LEG*</td>
			</tr>
			<!--SHOW LEGUAGE END-->
			<tr id="TR_*ID_STR*" *TR_EVENT* class="bet_game_tr_top">
				<td rowspan="2" class="bet_game_time"><div>*DATETIME*</div></td>
				<td class="bet_team">*TEAM_H*</td>
				<td class="bet_text">*RATIO_MH*</td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">*CON_RH*</tt></span><span class="bet_text_tdr">*RATIO_RH*</span></div></td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*CON_OUH*</tt></span><span class="bet_text_tdr">*RATIO_OUH*</span></div></td>
				<td class="bet_text">*RATIO_ODD*</td>
				<td id="TR1_*ID_STR*_text_1" class="bet_text_left_bg"></td>
				<td id="TR_*ID_STR*_text_2" class="bet_text_bg"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg">*CON_HRH*</tt></span><span class="bet_text_tdr">*RATIO_HRH*</span></div></td>
				<td id="TR_*ID_STR*_text_3" class="bet_text_right_bg"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*CON_HOUH*</tt></span><span class="bet_text_tdr">*RATIO_HOUH*</span></div></td>
			</tr>
			<tr id="TR1_*ID_STR*" *CLASS* *TR_EVENT* class="bet_game_tr_other">
				<td class="bet_team"><div class="bet_text_table"><span class="bet_text_tdl">*TEAM_C* </span><span class="bet_text_tdstar">*MYLOVE*</span></div></td>
				<td class="bet_text">*RATIO_MC*</td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">*CON_RC*</tt></span><span class="bet_text_tdr">*RATIO_RC*</span></div></td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*CON_OUC*</tt></span><span class="bet_text_tdr">*RATIO_OUC*</span></div></td>
				<td class="bet_text">*RATIO_EVEN*</td>
				<td id="TR1_*ID_STR*_text_1" class="bet_text_left_bg"></td>
				<td id="TR1_*ID_STR*_text_2" class="bet_text_bg"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg">*CON_HRC*</tt></span><span class="bet_text_tdr">*RATIO_HRC*</span></div></td>
				<td id="TR1_*ID_STR*_text_3" class="bet_text_right_bg"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*CON_HOUC*</tt></span><span class="bet_text_tdr">*RATIO_HOUC*</span></div></td>
			</tr>
		<? }
		if($rtype=="re"){
			?>

			<tr *ST* class="bet_game_league">
				<td colspan="4" onClick="parent.showLeg('*LEG*')">*LEG*</td>
			</tr>
			<!--SHOW LEGUAGE END-->
			<tr id="TR_*ID_STR*" *TR_EVENT* class="bet_game_tr_top">
				<td rowspan="2" class=""><div>*SE*&nbsp;<br/><span class="rb_time_color">*SCORE*</span></div></td>
				<td class="bet_team">*TEAM_H*</td>

				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">*CON_RH*</tt></span><span class="bet_text_tdr">*RATIO_RH*</span></div></td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*CON_OUH*</tt></span><span class="bet_text_tdr">*RATIO_OUH*</span></div></td>
			</tr>
			<tr id="TR1_*ID_STR*" *TR_EVENT* class="bet_game_tr_other">
				<td class="bet_team"><div class="bet_text_table"><span class="bet_text_tdl">*TEAM_C* </span><span class="bet_text_tdstar">*MYLOVE*</span></div></td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">*CON_RC*</tt></span><span class="bet_text_tdr">*RATIO_RC*</span></div></td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*CON_OUC*</tt></span><span class="bet_text_tdr">*RATIO_OUC*</span></div></td>
			</tr>
		<? }
		if($rtype=="pr"){
			?>
			<tr *ST* class="bet_game_league">
				<td colspan="9" onClick="parent.showLeg('*LEG*')"><span>*LEG*</span><span class="bet_in_bg">*PORDER* 串 1</span></td>
			</tr>
			<!--SHOW LEGUAGE END-->
			<tr id="TR_*ID_STR*" *TR_EVENT* class="bet_game_tr_top">
				<td rowspan="*TR_NUM*" class="bet_game_time"><div>*DATETIME*</div></td>
				<td class="bet_team">*TEAM_H*</td>
				<td class="bet_text">&nbsp;</td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">*CON_RH*</tt></span><span class="bet_text_tdr">*RATIO_RH*</span></div></td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*CON_OUC*</tt></span><span class="bet_text_tdr">*RATIO_OUC*</span></div></td>
				<td class="bet_text">&nbsp;</td>
			</tr>
			<tr id="TR1_*ID_STR*" *CLASS* *TR_EVENT* class="bet_game_tr_other">
				<td class="bet_team"><div class="bet_text_table"><span class="bet_text_tdl">*TEAM_C* </span><span class="bet_text_tdstar">*MYLOVE*</span></div></td>
				<td class="bet_text">&nbsp;</td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">*CON_RC*</tt></span><span class="bet_text_tdr">*RATIO_RC*</span></div></td>
				<td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*CON_OUH*</tt></span><span class="bet_text_tdr">*RATIO_OUH*</span></div></td>
				<td class="bet_text">&nbsp;</td>
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