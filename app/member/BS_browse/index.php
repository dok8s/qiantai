<?
include "../include/library.mem.php";

require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/http.class.php");
$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
include("../include/msg.inc.php");
$rtype=ltrim(strtolower($_REQUEST['rtype']));
$mtype=$_REQUEST['mtype'];
if($mtype==""){
	$mtype=3;
}

$sql = "select language,memname,status from web_member where Oid='$uid' and oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}
$status=$row['status'];
if($status==2)
{
	echo "此帐号以被暂停，请联系你的上级!";
	exit;
}
mysql_close();
?><script>var show_ior = '100';</script>
<html>
<head>
	<title>下注分割畫面</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script>
		var keepGameData=new Array();
		var gidData=new Array();
		parent.gamecount=0;
		//判斷賠率是否變動
		//包td

		function checkRatio(rec,index){
			//alert(flash_ior_set);
			//return true;
			if (flash_ior_set =='Y'){

				if (""+keepGameData[rec]=="undefined"||keepGameData[rec]==""){
					keepGameData[rec]=new Array();
					keepGameData[rec][index]=GameFT[rec][index];
				}
				//判斷gid是否相同
				if (gidData[rec]!=GameFT[rec][0]||""+GameFT[rec][0]=="undefined"){
					keepGameData[rec]=new Array();
					gidData[rec]=new Array();
					keepGameData[rec][index]=GameFT[rec][index];
					gidData[rec][0]=GameFT[rec][0];
				}

				if (""+keepGameData[rec][index]=="undefined" ||keepGameData[rec][index]==""){
					keepGameData[rec][index]=GameFT[rec][index];
				}
				//alert("aaa==>"+keepGameData[rec][index]+"bbb==>"+GameFT[rec][index]);
				if (keepGameData[rec][index]!=GameFT[rec][index]&& keepGameData[rec][index] !=""&&GameFT[rec][index]!=""){
					//keepGameData[rec][index]=GameFT[rec][index];
					keepGameData[rec][index] = "";
					//keepGameData[rec]="";
					return " bgcolor=yellow ";
				}
				return true;
			}
		}
		//包font
		function checkRatio_font(rec,index){
//alert(flash_ior_set);
			//return true;
			//alert(GameFT.length+"----"+keepGameData.length)

			if (flash_ior_set =='Y'){
				if (""+keepGameData[rec]=="undefined"||keepGameData[rec]==""){
					keepGameData[rec]=new Array();
					keepGameData[rec][index]=GameFT[rec][index];
				}
				//判斷gid是否相同
				if (gidData[rec]!=GameFT[rec][0]||""+GameFT[rec][0]=="undefined"){
					keepGameData[rec]=new Array();
					gidData[rec]=new Array();
					keepGameData[rec][index]=GameFT[rec][index];
					gidData[rec][0]=GameFT[rec][0];
				}
				if (""+keepGameData[rec][index]=="undefined"||keepGameData[rec][index] ==""){
					keepGameData[rec][index]=GameFT[rec][index];
				}

				//alert("ccc==>"+keepGameData[rec][index]+"ddd==>"+GameFT[rec][index]);
				if (keepGameData[rec][index]!=GameFT[rec][index] && keepGameData[rec][index] !=""&&GameFT[rec][index]!="") {
					//keepGameData[rec][index]=GameFT[rec][index];
					keepGameData[rec][index] = "";
					//keepGameData[rec]="";
					return '  style=\"background-color : yellow\" ';
				}
				return true;
			}
		}
		function gethighlight(){
			return " style=\"color:red\" style=\"font-weight:bolder\" ";
		}
		//滑鼠移動帶出索引
		//function showMsg(msg, type) {
		//	var showHelpMsg = body_browse.document.getElementById("showHelpMsg");
		////	var showHelpMsg = parent.body_browse.document.getElementById('showHelpMsg');
		//	var helpMsg = body_browse.document.getElementById('helpMsg').innerHTML;
		//	var tmpHTML = "";
		//	if(type == 1) {
		//		tmpHTML = helpMsg;
		//		tmpHTML = tmpHTML.replace("*SHOWMSG*", msg);
		//		showHelpMsg.innerHTML = tmpHTML;
		//		showHelpMsg.style.display = "block";
		//		showHelpMsg.style.top = body_browse.document.body.scrollTop+body_browse.event.clientY-10;
		//		showHelpMsg.style.left = body_browse.document.body.scrollLeft+body_browse.event.clientX+10;
		//	} else showHelpMsg.style.display = "none";
		//}

		//====== 加入現場轉播功能 2009-04-09
		// 開啟轉播
		function OpenLive(eventid, gtype){
			if (top.liveid == undefined) {
				parent.self.location = "";
				return;
			}
			var paramObj=new Array();
			paramObj.eventlive="Y";
			paramObj.eventid=eventid;
			paramObj.gtype=gtype;
			parent.showLive(paramObj);
		}

		function VideoFun(eventid, hot, play, gtype) {
			var tmpStr = "";
			if (play == "Y") {
				//tmpStr+= "<img src=\"/images/member/video_1.gif\" onClick=\"parent.OpenLive('"+eventid+"','"+gtype+"')\" style=\"cursor:hand\">";
				tmpStr= "<span ><div style=\"cursor:hand\" class=\"tv_icon_on\" onClick=\"parent.OpenLive('"+eventid+"','"+gtype+"')\"></div></span>";
			} else {
				//tmpStr+= "<img lowsrc=\"/images/member/video_2.gif\">";
				tmpStr= "<span ><div  class=\"tv_icon_out\"></div></span>";
			}
			return tmpStr;
		}

		function MM_ShowLoveI(gid,getDateTime,getLid,team_h,team_c){
			var txtout="";
			if(!top.swShowLoveI){
				//alert(chkRepeat(gid));
				if(!chkRepeat(gid)){
					//txtout = "<span id='sp_"+MM_imgId(getDateTime,gid)+"'><img id='"+MM_imgId(getDateTime,gid)+"' lowsrc=\"/images/member/icon_X2.gif\" vspace=\"0\" style=\"cursor:hand;display:none;\" title=\""+top.str_ShowMyFavorite+"\" onClick=\"addShowLoveI('"+gid+"','"+getDateTime+"','"+getLid+"','"+team_h+"','"+team_c+"'); \"></span>";
					txtout = "<span id='sp_"+MM_imgId(getDateTime,gid)+"'><div id='"+MM_imgId(getDateTime,gid)+"' class=\"bet_game_star_out\" style=\"cursor:hand;display:none;\" title=\""+top.str_ShowMyFavorite+"\" onClick=\"addShowLoveI('"+gid+"','"+getDateTime+"','"+getLid+"','"+team_h+"','"+team_c+"'); \"></div></span>";
				}else{
					//txtout = "<span id='sp_"+MM_imgId(getDateTime,gid)+"'><img lowsrc=\"/images/member/love_small.gif\" style=\"cursor:hand\" title=\""+top.str_delShowLoveI+"\" onClick=\"chkDelshowLoveI('"+getDateTime+"','"+gid+"'); \"></span>";
					txtout = "<span id='sp_"+MM_imgId(getDateTime,gid)+"'><div class=\"bet_game_star_on\" style=\"cursor:hand\" title=\""+top.str_delShowLoveI+"\" onClick=\"chkDelshowLoveI('"+getDateTime+"','"+gid+"'); \"></div></span>";
				}
			}else{
				//txtout = "<img lowsrc=\"/images/member/love_small.gif\" style=\"cursor:hand\" title=\""+top.str_delShowLoveI+"\" onClick=\"chkDelshowLoveI('"+getDateTime+"','"+gid+"'); \">";
				txtout = "<div class=\"bet_game_star_on\" style=\"cursor:hand\" title=\""+top.str_delShowLoveI+"\" onClick=\"chkDelshowLoveI('"+getDateTime+"','"+gid+"'); \"></div>";
			}
			return txtout;
		}

		function chkRepeat(gid){
			var getGtype =getGtypeShowLoveI();
			var sw =false;
			for (var i=0 ; i < top.ShowLoveIarray[getGtype].length ; i++){
				if(top.ShowLoveIarray[getGtype][i][0]==gid)
					sw =true;
			}
			return sw;
		}

		function MM_IdentificationDisplay(time,gid){
			var getGtype = getGtypeShowLoveI();
			var txt_array = top.ShowLoveIOKarray[getGtype];
			if(top.swShowLoveI){
				var tmp = time.split("<br>")[0];
				if(txt_array.length==0)return true;
				if(txt_array.indexOf(tmp+gid +",",0)== -1)
					return true;
			}
		}
		function getGtypeShowLoveI(){
			var Gtype;
			var getGtype =sel_gtype;
			var getRtype =rtype;
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
		function MM_imgId(time,gid){
			var tmp = time.split("<br>")[0];
			//alert(tmp+gid);
			return tmp+gid;
		}

	</script>
	<script>

		/**
		 * 選擇多盤口時 轉換成該選擇賠率
		 * @param odd_type 	選擇盤口
		 * @param iorH		主賠率
		 * @param iorC		客賠率
		 * @param show		顯示位數
		 * @return		回傳陣列 0-->H  ,1-->C
		 */
		function  get_other_ioratio(odd_type, iorH, iorC , showior){
			var out=new Array();
			if(iorH!="" ||iorC!=""){
				out =chg_ior(odd_type,iorH,iorC,showior);
			}else{
				out[0]=iorH;
				out[1]=iorC;
			}
			return out;
		}
		/**
		 * 轉換賠率
		 * @param odd_f
		 * @param H_ratio
		 * @param C_ratio
		 * @param showior
		 * @return
		 */
		function chg_ior(odd_f,iorH,iorC,showior){
			var ior=new Array();
			if(iorH < 11) iorH *=1000;
			if(iorC < 11) iorC *=1000;
			iorH=parseFloat(iorH);
			iorC=parseFloat(iorC);
			switch(odd_f){
				case "H":	//香港變盤(輸水盤)
					ior = get_HK_ior(iorH,iorC);
					break;
				case "M":	//馬來盤
					ior = get_MA_ior(iorH,iorC);
					break;
				case "I" :	//印尼盤
					ior = get_IND_ior(iorH,iorC);
					break;
				case "E":	//歐洲盤
					ior = get_EU_ior(iorH,iorC);
					break;
				default:	//香港盤
					ior[0]=iorH ;
					ior[1]=iorC ;
			}
			ior[0]/=1000;
			ior[1]/=1000;

			ior[0]=printf(Decimal_point(ior[0],showior),iorpoints);
			ior[1]=printf(Decimal_point(ior[1],showior),iorpoints);
			//alert("odd_f="+odd_f+",iorH="+iorH+",iorC="+iorC+",ouH="+ior[0]+",ouC="+ior[1]);
			return ior;
		}

		/**
		 * 換算成輸水盤賠率
		 * @param H_ratio
		 * @param C_ratio
		 * @return
		 */
		function get_HK_ior( H_ratio, C_ratio){
			var out_ior=new Array();
			var line,lowRatio,nowRatio,highRatio;
			var nowType="";
			if (H_ratio <= 1000 && C_ratio <= 1000){
				out_ior[0]=H_ratio;
				out_ior[1]=C_ratio;
				return out_ior;
			}
			line=2000 - ( H_ratio + C_ratio );
			if (H_ratio > C_ratio){
				lowRatio=C_ratio;
				nowType = "C";
			}else{
				lowRatio = H_ratio;
				nowType = "H";
			}
			if (((2000 - line) - lowRatio) > 1000){
				//對盤馬來盤
				nowRatio = (lowRatio + line) * (-1);
			}else{
				//對盤香港盤
				nowRatio=(2000 - line) - lowRatio;
			}
			if (nowRatio < 0){
				highRatio = Math.floor(Math.abs(1000 / nowRatio) * 1000) ;
			}else{
				highRatio = (2000 - line - nowRatio) ;
			}
			if (nowType == "H"){
				out_ior[0]=lowRatio;
				out_ior[1]=highRatio;
			}else{
				out_ior[0]=highRatio;
				out_ior[1]=lowRatio;
			}
			return out_ior;
		}
		/**
		 * 換算成馬來盤賠率
		 * @param H_ratio
		 * @param C_ratio
		 * @return
		 */
		function get_MA_ior( H_ratio, C_ratio){
			var out_ior=new Array();
			var line,lowRatio,highRatio;
			var nowType="";
			if ((H_ratio <= 1000 && C_ratio <= 1000)){
				out_ior[0]=H_ratio;
				out_ior[1]=C_ratio;
				return out_ior;
			}
			line=2000 - ( H_ratio + C_ratio );
			if (H_ratio > C_ratio){
				lowRatio = C_ratio;
				nowType = "C";
			}else{
				lowRatio = H_ratio;
				nowType = "H";
			}
			highRatio = (lowRatio + line) * (-1);
			if (nowType == "H"){
				out_ior[0]=lowRatio;
				out_ior[1]=highRatio;
			}else{
				out_ior[0]=highRatio;
				out_ior[1]=lowRatio;
			}
			return out_ior;
		}
		/**
		 * 換算成印尼盤賠率
		 * @param H_ratio
		 * @param C_ratio
		 * @return
		 */
		function get_IND_ior( H_ratio, C_ratio){
			var out_ior=new Array();
			out_ior = get_HK_ior(H_ratio,C_ratio);
			H_ratio=out_ior[0];
			C_ratio=out_ior[1];
			H_ratio /= 1000;
			C_ratio /= 1000;
			if(H_ratio < 1){
				H_ratio=(-1) / H_ratio;
			}
			if(C_ratio < 1){
				C_ratio=(-1) / C_ratio;
			}
			out_ior[0]=H_ratio*1000;
			out_ior[1]=C_ratio*1000;
			return out_ior;
		}
		/**
		 * 換算成歐洲盤賠率
		 * @param H_ratio
		 * @param C_ratio
		 * @return
		 */
		function get_EU_ior(H_ratio, C_ratio){
			var out_ior=new Array();
			out_ior = get_HK_ior(H_ratio,C_ratio);
			H_ratio=out_ior[0];
			C_ratio=out_ior[1];
			out_ior[0]=H_ratio+1000;
			out_ior[1]=C_ratio+1000;
			return out_ior;
		}
		/*
		 去正負號做小數第幾位捨去
		 進來的值是小數值
		 */
		function Decimal_point(tmpior,show){
			var sign="";
			sign =((tmpior < 0)?"Y":"N");
			tmpior = (Math.floor(Math.abs(tmpior) * show + 1 / show )) / show;
			return (tmpior * ((sign =="Y")? -1:1)) ;
		}


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
		}</script>

	<? if($rtype=="r"){?>
		<script>
			var ObjDataFT=new Array();
			var oldObjDataFT=new Array();
			var keepleg="";
			var legnum=0;
			var NoshowLeg=new Array();
			var myLeg=new Array();
			var LeagueAry=new Array();

			function ShowGameList(){

				if(loading == 'Y') return;
				if (parent.gamecount!=gamount){
					oldObjDataFT=new Array();
				}
				if(top.odd_f_type==""||""+top.odd_f_type=="undefined") top.odd_f_type="H";
				keepscroll=body_browse.document.body.scrollTop;

				var conscroll= body_browse.document.getElementById('controlscroll');
				conscroll.style.display="";
				conscroll.style.top=keepscroll+1;
				//conscroll.focus();

				dis_ShowLoveI();

				//秀盤面
				showtables(GameFT,GameHead,gamount,top.odd_f_type);

				body_browse.scroll(0,keepscroll);

				//設定右方重新整理位置
				setRefreshPos();

				//顯示盤口
				body_browse.ChkOddfDiv();

				parent.gamecount=gamount;
				//日期下拉霸

				if (sel_gtype=="BSFU"){
					if (""+body_browse.document.getElementById('g_date')!="undefined"){
						body_browse.selgdate("r",g_date);
						body_browse.document.getElementById('g_date').value=g_date;
					}
				}

				if(top.showtype=='hgft'||top.showtype=='hgfu'){
					obj_sel = body_browse.document.getElementById('sel_league');
					obj_sel.style.display='none';
					try{
						var obj_date='';
						obj_date=body_browse.document.getElementById("g_date").value;
						body_browse.selgdate("",obj_date);
					}catch(E){}
				}else{
					show_page();
				}

				conscroll.style.display="none";
				coun_Leagues();
				body_browse.showPicLove();
				loadingOK();
			}
			var hotgdateArr =new Array();
			function hot_gdate(gdate){
				if((""+hotgdateArr).indexOf(gdate)==-1){
					hotgdateArr.push(gdate);
				}
			}
			function coun_Leagues(){
				var coun=0;
				var str_tmp ="|"+eval('parent.'+sel_gtype+'_lname_ary');
				if(str_tmp=='|ALL'){
					body_browse.document.getElementById("str_num").innerHTML =top.alldata;
				}else{
					var larray=str_tmp.split('|');
					for(var i =0;i<larray.length;i++){
						if(larray[i]!=""){coun++}
					}
					coun =LeagueAry.length;
					body_browse.document.getElementById("str_num").innerHTML =coun;
				}
			}
			//表格函數
			function showtables(GameData,Game_Head,data_amount,odd_f_type){
				ObjDataFT=new Array();
				myLeg=new Array();
				for (var j=0;j < data_amount;j++){
					if (GameData[j]!=null){
						ObjDataFT[j]=parseArray(Game_Head,GameData[j]);
					}
				}
				var trdata;//=body_browse.document.getElementById('DataTR').innerHTML;
				var showtableData;
				if(body_browse.document.all){
					showtableData=body_browse.document.getElementById('showtableData').innerText ;
					trdata=body_browse.document.getElementById('DataTR').innerText;
					notrdata=body_browse.document.getElementById('NoDataTR').innerText;
				} else{
					showtableData=body_browse.document.getElementById('showtableData').textContent ;
					trdata=body_browse.document.getElementById('DataTR').textContent;
					notrdata=body_browse.document.getElementById('NoDataTR').textContent;
				}
				var showtable=body_browse.document.getElementById('showtable');
				var showlayers="";
				keepleg="";
				legnum=0;
				LeagueAry =new Array();
				var chk_Love_I=new Array();
				if(ObjDataFT.length > 0){
					for ( i=0 ;i < ObjDataFT.length;i++){
						tmp_Str=getLayer(trdata,i,odd_f_type);
						showlayers+=tmp_Str;
						if (top.swShowLoveI&&tmp_Str!=""){
							chk_Love_I.push(ObjDataFT[i]);
						}
					}
					if (top.swShowLoveI){
						body_browse.checkLoveCount(chk_Love_I);
					}
					if(showlayers=="")showlayers=notrdata;
					showtableData=showtableData.replace("*showDataTR*",showlayers);
				}else{
					showtableData=showtableData.replace("*showDataTR*",notrdata);
				}

				showtable.innerHTML=showtableData;

			}


			//表格內容
			function getLayer(onelayer,gamerec,odd_f_type){
				var open_hot = false;
				if(MM_IdentificationDisplay(ObjDataFT[gamerec].datetime,ObjDataFT[gamerec].gnum_h)) return "";
				if(("|"+eval('parent.'+sel_gtype+'_lname_ary')).indexOf(("|"+ObjDataFT[gamerec].league+"|"),0)==-1&&eval('parent.'+sel_gtype+'_lname_ary')!='ALL') return "";
				if((""+LeagueAry).indexOf(ObjDataFT[gamerec].league)== -1)LeagueAry.push(ObjDataFT[gamerec].league);
				var tmp_date = ObjDataFT[gamerec].datetime.split("<br>")[0];
				onelayer=onelayer.replace(/\*ID_STR\*/g,tmp_date+ObjDataFT[gamerec].gnum_h);
				onelayer=onelayer.replace(/\*TR_EVENT\*/g,"onMouseOver='mouseEnter_pointer(this.id);' onMouseOut='mouseOut_pointer(this.id);'");

				if (""+myLeg[ObjDataFT[gamerec].league]=="undefined"){
					myLeg[ObjDataFT[gamerec].league]=ObjDataFT[gamerec].league;
					myLeg[ObjDataFT[gamerec].league]=new Array();
					myLeg[ObjDataFT[gamerec].league][0]=tmp_date+ObjDataFT[gamerec].gnum_h;
				}else{
					myLeg[ObjDataFT[gamerec].league][myLeg[ObjDataFT[gamerec].league].length]=tmp_date+ObjDataFT[gamerec].gnum_h;
				}


				//--------------判斷聯盟名稱列顯示或隱藏----------------
				if (ObjDataFT[gamerec].league==keepleg){
					onelayer=onelayer.replace("*ST*"," style='display: none;'");
				}else{
					onelayer=onelayer.replace("*ST*"," style='display: ;'");
				}
				//---------------------------------------------------------------------
				//--------------判斷聯盟底下的賽事顯示或隱藏----------------
				if (NoshowLeg[ObjDataFT[gamerec].league]==-1){
					onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: none;'");
					onelayer=onelayer.replace("*LegMark*","<span id='LegClose'></span>"); //聯盟的小圖
				}else{
					onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: ;'");
					onelayer=onelayer.replace("*LegMark*","<span id='LegOpen'></span>");  //聯盟的小圖
				}
				//---------------------------------------------------------------------
				//盤口賠率 start
				var R_ior =Array();
				var OU_ior =Array();
				var HR_ior =Array();
				var HOU_ior =Array();


				R_ior  = get_other_ioratio(odd_f_type, ObjDataFT[gamerec].ior_RH   , ObjDataFT[gamerec].ior_RC   , show_ior);
				OU_ior = get_other_ioratio(odd_f_type, ObjDataFT[gamerec].ior_OUH  , ObjDataFT[gamerec].ior_OUC  , show_ior);

				HR_ior  = get_other_ioratio(odd_f_type, ObjDataFT[gamerec].ior_HRH   , ObjDataFT[gamerec].ior_HRC   , show_ior);
				HOU_ior = get_other_ioratio(odd_f_type, ObjDataFT[gamerec].ior_HOUH  , ObjDataFT[gamerec].ior_HOUC  , show_ior);



				ObjDataFT[gamerec].ior_RH=R_ior[0];
				ObjDataFT[gamerec].ior_RC=R_ior[1];
				ObjDataFT[gamerec].ior_OUH=OU_ior[0];
				ObjDataFT[gamerec].ior_OUC=OU_ior[1];

				ObjDataFT[gamerec].ior_HRH=HR_ior[0];
				ObjDataFT[gamerec].ior_HRC=HR_ior[1];
				ObjDataFT[gamerec].ior_HOUH=HOU_ior[0];
				ObjDataFT[gamerec].ior_HOUC=HOU_ior[1];


				//盤口賠率 end
				//滾球字眼
				ObjDataFT[gamerec].datetime=ObjDataFT[gamerec].datetime.replace("Running Ball",top.str_RB);
				keepleg=ObjDataFT[gamerec].league;
				onelayer=onelayer.replace(/\*LEG\*/gi,ObjDataFT[gamerec].league);

				var tmp_date=ObjDataFT[gamerec].datetime.split("<br>");
				if (sel_gtype=="BSFU"){
					tmp_date_str=tmp_date[0]+"<br>"+change_time(tmp_date[1]);
				}else{
					tmp_date_str=change_time(tmp_date[1]);
				}
				if (tmp_date.length==3){
					tmp_date_str+="<br>"+tmp_date[2];
				}
				onelayer=onelayer.replace("*DATETIME*",tmp_date_str);
				onelayer=onelayer.replace("*TEAM_H*",ObjDataFT[gamerec].team_h.replace("[Mid]","<font color=\"#005aff\">[N]</font>").replace("[中]","<font color=\"#005aff\">[中]</font>"));
				onelayer=onelayer.replace("*TEAM_C*",ObjDataFT[gamerec].team_c);
				//全場
				//獨贏
				if ((ObjDataFT[gamerec].ior_MH*1 > 0) && (ObjDataFT[gamerec].ior_MC*1 > 0)){
					onelayer=onelayer.replace("*RATIO_MH*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"M"));
					onelayer=onelayer.replace("*RATIO_MC*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"M"));
					if ((ObjDataFT[gamerec].ior_MN*1) > 0){
						onelayer=onelayer.replace("*RATIO_MN*",parseUrl(uid,odd_f_type,"N",ObjDataFT[gamerec],gamerec,"M"));
					}else{
						onelayer=onelayer.replace("*RATIO_MN*","&nbsp;");
					}
				}else{
					onelayer=onelayer.replace("*RATIO_MH*","&nbsp;");
					onelayer=onelayer.replace("*RATIO_MC*","&nbsp;");
					onelayer=onelayer.replace("*RATIO_MN*","&nbsp;");
				}
				//讓球
				if (ObjDataFT[gamerec].strong=="H"){
					onelayer=onelayer.replace("*CON_RH*",ObjDataFT[gamerec].ratio);	/*讓球球頭*/
					onelayer=onelayer.replace("*CON_RC*","");
				}else{
					onelayer=onelayer.replace("*CON_RH*","");
					onelayer=onelayer.replace("*CON_RC*",ObjDataFT[gamerec].ratio);
				}
				onelayer=onelayer.replace("*RATIO_RH*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"R"));/*讓球賠率*/
				onelayer=onelayer.replace("*RATIO_RC*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"R"));
				//大小
				if (top.langx=="en-us"){
					onelayer=onelayer.replace("*CON_OUH*",ObjDataFT[gamerec].ratio_o.replace("O","<b>"+"o"+"</b>"));	/*大小球頭*/
					onelayer=onelayer.replace("*CON_OUC*",ObjDataFT[gamerec].ratio_u.replace("U","<b>"+"u"+"</b>"));
				}else{
					onelayer=onelayer.replace("*CON_OUH*",ObjDataFT[gamerec].ratio_o.replace("O",top.strOver));	/*大小球頭*/
					onelayer=onelayer.replace("*CON_OUC*",ObjDataFT[gamerec].ratio_u.replace("U",top.strUnder));
				}
				onelayer=onelayer.replace("*RATIO_OUH*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"OU"));/*大小賠率*/
				onelayer=onelayer.replace("*RATIO_OUC*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"OU"));

				//單雙
				if (top.langx=="en-us"){
					onelayer=onelayer.replace("*RATIO_ODD*","<span class=\"con_oe\">"+"<b>"+ObjDataFT[gamerec].str_odd+"</b>"+"&nbsp;</span>"+parseUrl(uid,odd_f_type,"O",ObjDataFT[gamerec],gamerec,"EO"));
					onelayer=onelayer.replace("*RATIO_EVEN*","<span class=\"con_oe\">"+"<b>"+ObjDataFT[gamerec].str_even+"</b>"+"&nbsp;</span>"+parseUrl(uid,odd_f_type,"E",ObjDataFT[gamerec],gamerec,"EO"));
				}else{
					onelayer=onelayer.replace("*RATIO_ODD*","<span class=\"con_oe\">"+ObjDataFT[gamerec].str_odd+"&nbsp;</span>"+parseUrl(uid,odd_f_type,"O",ObjDataFT[gamerec],gamerec,"EO"));
					onelayer=onelayer.replace("*RATIO_EVEN*","<span class=\"con_oe\">"+ObjDataFT[gamerec].str_even+"&nbsp;</span>"+parseUrl(uid,odd_f_type,"E",ObjDataFT[gamerec],gamerec,"EO"));
				}
				//上半場
				//獨贏
				if ((ObjDataFT[gamerec].ior_HMH*1 > 0) && (ObjDataFT[gamerec].ior_HMC*1 > 0)){
					onelayer=onelayer.replace("*RATIO_HMH*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"HM"));
					onelayer=onelayer.replace("*RATIO_HMC*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"HM"));
					if ((ObjDataFT[gamerec].ior_HMN*1) > 0){
						onelayer=onelayer.replace("*RATIO_HMN*",parseUrl(uid,odd_f_type,"N",ObjDataFT[gamerec],gamerec,"HM"));
					}else{
						onelayer=onelayer.replace("*RATIO_HMN*","&nbsp;");
					}
				}else{
					onelayer=onelayer.replace("*RATIO_HMH*","&nbsp;");
					onelayer=onelayer.replace("*RATIO_HMC*","&nbsp;");
					onelayer=onelayer.replace("*RATIO_HMN*","&nbsp;");
				}


				//讓球
				if (ObjDataFT[gamerec].hstrong=="H"){
					onelayer=onelayer.replace("*CON_HRH*",ObjDataFT[gamerec].hratio);	/*讓球球頭*/
					onelayer=onelayer.replace("*CON_HRC*","");
				}else{
					onelayer=onelayer.replace("*CON_HRH*","");
					onelayer=onelayer.replace("*CON_HRC*",ObjDataFT[gamerec].hratio);
				}
				onelayer=onelayer.replace("*RATIO_HRH*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"HR"));/*讓球賠率*/
				onelayer=onelayer.replace("*RATIO_HRC*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"HR"));
				//大小
				if (top.langx=="en-us"){
					onelayer=onelayer.replace("*CON_HOUH*",ObjDataFT[gamerec].hratio_o.replace("O","<b>"+"o"+"</b>"));	/*大小球頭*/
					onelayer=onelayer.replace("*CON_HOUC*",ObjDataFT[gamerec].hratio_u.replace("U","<b>"+"u"+"</b>"));
				}else{
					onelayer=onelayer.replace("*CON_HOUH*",ObjDataFT[gamerec].hratio_o.replace("O",top.strOver));	/*大小球頭*/
					onelayer=onelayer.replace("*CON_HOUC*",ObjDataFT[gamerec].hratio_u.replace("U",top.strUnder));
				}
				onelayer=onelayer.replace("*RATIO_HOUH*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"HOU"));/*大小賠率*/
				onelayer=onelayer.replace("*RATIO_HOUC*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"HOU"));
				onelayer=onelayer.replace("*MORE*",parsemore(ObjDataFT[gamerec],game_more));
				//我的最愛
				onelayer=onelayer.replace("*MYLOVE*",parseMyLove(ObjDataFT[gamerec]));
				if (ObjDataFT[gamerec].eventid != "" && ObjDataFT[gamerec].eventid != "null" && ObjDataFT[gamerec].eventid != undefined) {	//判斷是否有轉播
					tmpStr= VideoFun(ObjDataFT[gamerec].eventid, ObjDataFT[gamerec].hot, ObjDataFT[gamerec].play, "FT");
					onelayer=onelayer.replace("*TV*",tmpStr);
				}
				onelayer=onelayer.replace("*TV*","");

				return onelayer;
			}


			//取得下注的url
			function parseUrl(uid,odd_f_type,betTeam,GameData,gamerec,wtype){
				var urlArray=new Array();
				urlArray['R']=new Array("../BS_order/BS_order_r.php",eval("GameData.team_"+betTeam.toLowerCase()));
				urlArray['HR']=new Array("../BS_order/BS_order_hr.php",eval("GameData.team_"+betTeam.toLowerCase()));
				urlArray['OU']=new Array("../BS_order/BS_order_ou.php",(betTeam=="C" ? top.strOver : top.strUnder));
				urlArray['HOU']=new Array("../BS_order/BS_order_hou.php",(betTeam=="C" ? top.strOver : top.strUnder));
				urlArray['M']=new Array("../BS_order/BS_order_m.php",(betTeam=="N" ? top.str_irish_kiss : eval("GameData.team_"+betTeam.toLowerCase())));
				urlArray['HM']=new Array("../BS_order/BS_order_hm.php",(betTeam=="N" ? top.str_irish_kiss : eval("GameData.team_"+betTeam.toLowerCase())));
				urlArray['EO']=new Array("../FT_order/FT_order_t.php",(betTeam=="O" ? top.str_o : top.str_e));
				var param=getParam(uid,odd_f_type,betTeam,wtype,GameData);
				var order=urlArray[wtype][0];
				var team=urlArray[wtype][1].replace("<font color=#FF0000>","").replace("</font>","").replace("[Mid]","[N]");
				var tmp_rtype="ior_"+wtype+betTeam;

				var ioratio_str="GameData."+tmp_rtype;

				var ioratio=eval(ioratio_str);

				function Mathfloor(z){
					var tmp_z;
					tmp_z=(Math.floor(z*100+0.01))/100;
					return tmp_z;
				}

				if(eval(ioratio_str)!=""){
					ioratio=Mathfloor(ioratio);
					ioratio=printf(ioratio,2);
				}

				//var ret="<a href='"+order+"?"+param+"' target='mem_order' title='"+team+"'><font "+check_ioratio(gamerec,tmp_rtype,GameData)+">"+ioratio+"</font></a>";
				//alert(parent.name)
				var ret="<a href='javascript://' onclick=\"parent.parent.mem_order.betOrder('BS','"+wtype+"','"+param+"');\" title='"+team+"'><font "+check_ioratio(gamerec,tmp_rtype,GameData)+" class='bet_bg_color'>"+ioratio+"</font></a>";//ioratio

				return ret;

			}

			//--------------------------public function --------------------------------

			//取得下注參數
			function getParam(uid,odd_f_type,betTeam,wtype,GameData){
				var paramArray=new Array();
				paramArray['R']=new Array("gid","uid","odd_f_type","type","gnum","strong","langx");
				paramArray['HR']=new Array("gid","uid","odd_f_type","type","gnum","strong","langx");
				paramArray['OU']=new Array("gid","uid","odd_f_type","type","gnum","langx");
				paramArray['HOU']=new Array("gid","uid","odd_f_type","type","gnum","langx");
				paramArray['M']=new Array("gid","uid","odd_f_type","type","gnum","langx");
				paramArray['HM']=new Array("gid","uid","odd_f_type","type","gnum","langx");
				paramArray['EO']=new Array("gid","uid","odd_f_type","rtype","langx");
				var param="";
				var gid=((wtype=="R"||wtype=="OU"||wtype=="M"||wtype=="EO") ? GameData.gid : GameData.hgid);
				var gnum=eval("GameData.gnum_"+(betTeam=="N"? "c":betTeam.toLowerCase()));
				var strong=(wtype=="R" ? GameData.strong : GameData.hstrong);
				var type=betTeam;

				var rtype=(betTeam=="E" ? "EVEN" : "ODD");

				for (var i=0;i<paramArray[wtype].length;i++){
					if (i>0)  param+="&";
					param+=paramArray[wtype][i]+"="+eval(paramArray[wtype][i]);
				}
				return param;
			}

			function parsemore(GameData,g_more){
				var ret="";
				if(g_more=='0'||GameData.more=='0'){
					ret="&nbsp;";
				}else{
					ret="<A href=javascript: onClick=parent.show_more('"+GameData.gid+"',event);>"+"<font class='total_color'>+"+GameData.more+"&nbsp;</font>"+str_more+"</A>";
				}
				return ret;
			}
			function show_more(gid,evt){
				evt = evt ? evt : (window.event ? window.event : null);
				var mY = evt.pageY ? evt.pageY : evt.y;
				body_browse.document.getElementById('more_window').style.position='absolute';
				body_browse.document.getElementById('more_window').style.top=mY+30;
				body_browse.document.getElementById('more_window').style.left=body_browse.document.body.scrollLeft+7;
				var  url="body_var_r_more.php?gid="+gid+"&uid="+uid+"&ltype="+ltype;
				body_browse.showdata.location.href = url;
			}


			function parseMyLove(GameData){
				var tmpStr="";
				//====== 加入現場轉播功能 2009-04-09, VideoFun 放在 flash_ior_mem.js
				tmpStr=MM_ShowLoveI(GameData.gnum_h,GameData.datetime,GameData.league,GameData.team_h,GameData.team_c);
//	if (top.casino == "SI2") {
				if (GameData.eventid != "" && GameData.eventid != "null" && GameData.eventid != undefined) {	//判斷是否有轉播
					tmpStr+= VideoFun(GameData.eventid, GameData.hot, GameData.play, "FT");
				}
//	}

				return  tmpStr;
			}


		</script>
		<meta http-equiv="Content-Type" content="text/html; charset=<?=$charset?> "><script>

			//--------------------------------public function ----------------------------

			function setRefreshPos(){
//				var refresh_right= body_browse.document.getElementById('refresh_right');
//				refresh_right.style.left= body_browse.document.getElementById('myTable').clientWidth*1+20;
				//refresh_right.style.top= 39;
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


			function check_ioratio(rec,rtype,GameData){
//alert(flash_ior_set);
				//return true;
				//alert(GameFT.length+"----"+keepGameData.length)

				if (flash_ior_set =='Y'){
					//alert(oldObjDataFT[rec]);
					if (""+oldObjDataFT[rec]=="undefined" || oldObjDataFT[rec].gid != GameData.gid){
						var gameObj=new Object();
						gameObj.gid=GameData.gid;
						oldObjDataFT[rec]=gameObj;
					}

					var new_ioratio=eval("GameData."+rtype);
					var old_ioratio=eval("oldObjDataFT[rec]."+rtype);


					if (""+old_ioratio=="undefined"){
						eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
						old_ioratio=eval("oldObjDataFT[rec]."+rtype);
					}

					//alert("old_ioratio==>"+old_ioratio+",new_ioratio==>"+new_ioratio);
					if (""+new_ioratio=="undefined" || new_ioratio==""){
						eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
						return;
					}

					/*
					 if (parseFloat(old_ioratio)>parseFloat(new_ioratio) ){
					 eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
					 return "  style='border: 1px solid #FF0000;' ";
					 }
					 if (parseFloat(old_ioratio)<parseFloat(new_ioratio) ){
					 eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
					 return "  style='border: 1px solid #00FF00;' ";
					 }
					 */

					if (old_ioratio!=new_ioratio && old_ioratio !="" && new_ioratio!="") {
						eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
						return "  style='background-color : yellow' ";
					}

					return true;
				}

			}
			//--------------判斷聯盟顯示或隱藏----------------
			function showLeg(leg){
				for (var i=0;i<myLeg[leg].length;i++){
					if ( body_browse.document.getElementById("TR_"+myLeg[leg][i]).style.display!="none"){
						showLegIcon(leg,"LegClose",myLeg[leg][i],"none");

					}else{
						showLegIcon(leg,"LegOpen",myLeg[leg][i],"");
					}
				}
				if ((""+NoshowLeg[leg])=="undefined"){
					NoshowLeg[leg]=-1;
				}else{
					NoshowLeg[leg]=NoshowLeg[leg]*-1;
				}

			}
			function showLegIcon(leg,state,gnumH,display){
				var  ary=body_browse.document.getElementsByName(leg);

				for (var j=0;j<ary.length;j++){
					ary[j].innerHTML="<span id='"+state+"'></span>";
				}
				try{
					body_browse.document.getElementById("TR3_"+gnumH).style.display=display;
				}catch(E){}
				try{
					body_browse.document.getElementById("TR2_"+gnumH).style.display=display;
				}catch(E){}
				try{
					body_browse.document.getElementById("TR1_"+gnumH).style.display=display;
				}catch(E){}
				try{
					body_browse.document.getElementById("TR_"+gnumH).style.display=display;
				}catch(E){}
			}
			//----------------------

			//分頁
			function show_page(){
				//alert(rtype)
				pg_str='';
				obj_pg = body_browse.document.getElementById('pg_txt');
//	alert(t_page);
				if (t_page==0){
					t_page=1;
					//obj_pg.innerHTML = "";
					//return;
				}
				var tmp_lid="";
				if (rtype=="re"){
					tmp_lid=eval("parent."+sel_gtype+"_lid_ary_RE");
				}else{
					tmp_lid=eval("parent."+sel_gtype+"_lid_ary");
				}
				//alert(tmp_lid+"--"+top.swShowLoveI+"--"+t_page)
				if(tmp_lid=='ALL'&&!top.swShowLoveI){
					var disabled="";
					if (t_page==1){
						disabled="disabled";
					}
					var pghtml=(pg*1+1)+" / " +t_page+" "+top.page+"&nbsp;&nbsp; <select  onchange='chg_pg(this.options[this.selectedIndex].value)' "+disabled+">";
					for(var i=0;i<t_page;i++){
						if (pg==i){
							pghtml+="<option value='"+i+"' selected>"+(i+1)+"</option>";
						}else{
							pghtml+="<option value='"+i+"' >"+(i+1)+"</option>";
						}
					}
					pghtml+="</select>";
					obj_pg.innerHTML = pghtml;
				}else{
					obj_pg.innerHTML = "";
				}
			}

			//將時間 轉回 24小時//04:00p
			function  change_time(get_time){

				if (get_time.indexOf("font") > 0 ) return get_time;
				if (get_time.indexOf("p")>0 || get_time.indexOf("a")>0){
					gtime=get_time.split(":");
					if (gtime[1].indexOf("p")>0){

						if (gtime[0]!="12"){
							gtime[0]=gtime[0]*1+12;
						}
					}
					gtime[1]=gtime[1].replace("a","").replace("p","");

				}else{
					return get_time;
				}
				return gtime[0]+":"+gtime[1];

			}

			//隱藏我的最愛選擇聯賽
			function dis_ShowLoveI(){

				if(top.swShowLoveI){
					body_browse.document.getElementById("sel_league").style.display="none";
				}else{
					body_browse.document.getElementById("sel_league").style.display="";
				}

			}


			function changeTitleStr(s,at){
				if (s.charAt(at)=="H"){
					return "H";
				}else if(s.charAt(at)=="C"){
					return "A";
				}else if(s.charAt(at)=="N"){
					return "D";
				}
				return "";
			}
			function loadingOK(){
				//alert("loadingOK")
//				try{
//					body_browse.document.getElementById("refresh_btn").className="refresh_btn";
//				}catch(E){}
//				try{
//					body_browse.document.getElementById("refresh_right").className="refresh_M_btn";
//				}catch(E){}
//				try{
//					body_browse.document.getElementById("refresh_down").className="refresh_M_btn";
//				}catch(E){}
			}</script>
	<? }
	if($rtype=="re"){
		?>
		<script>
			var ObjDataFT=new Array();
			var oldObjDataFT=new Array();
			//var GameHead=new Array("gid","datetime","league","gnum_h","gnum_c","team_h","team_c","strong","ratio","ior_RH","ior_RC","ratio_o","ratio_u","ior_OUH","ior_OUC","ior_MH","ior_MC","ior_MN","str_odd","str_even","ior_EOO","ior_EOE","hgid","hstrong","hratio","ior_HRH","ior_HRC","hratio_o","hratio_u","ior_HOUH","ior_HOUC","ior_HMH","ior_HMC","ior_HMN","more","eventid","hot","play");
			var keepleg="";
			var legnum=0;
			var NoshowLeg=new Array();
			var myLeg=new Array();
			var LeagueAry=new Array();
			//var keepscroll=0;
			function ShowGameList(){

				if(loading == 'Y') return;
				if (parent.gamecount!=gamount){
					oldObjDataFT=new Array();
				}
				if(top.odd_f_type==""||""+top.odd_f_type=="undefined") top.odd_f_type="H";
				keepscroll=body_browse.document.body.scrollTop;

				var conscroll= body_browse.document.getElementById('controlscroll');
				conscroll.style.display="";
				conscroll.style.top=keepscroll+1;
				//	conscroll.style.width=800;
				//	conscroll.style.Height=600;
				//conscroll.focus();
				//conscroll.blur();

				dis_ShowLoveI();

				//秀盤面
				showtables(GameFT,GameHead,gamount,top.odd_f_type);
//conscroll.style.top=top.keepscroll;
				//conscroll.focus();

				body_browse.scroll(0,keepscroll);

				//設定右方重新整理位置
				setRefreshPos();

				//顯示盤口
				body_browse.ChkOddfDiv();
				//跑馬燈
//	obj_msg = body_browse.document.getElementById('real_msg');
//	obj_msg.innerHTML = '<marquee scrolldelay=\"300\">'+msg+'</marquee>';

				//更新秒數
				//只有 讓分/走地 才有更新時間
				//hr_info = body_browse.document.getElementById('hr_info');
				//if(retime){
				//	hr_info.innerHTML = retime+str_renew;
				//}else{
				//	hr_info.innerHTML = str_renew;
				//}

				parent.gamecount=gamount;
				//alert("top.showtype="+top.showtype+",top.showtype="+top.showtype);
				//日期下拉霸

				if (sel_gtype=="BSFU"){
					if (""+body_browse.document.getElementById('g_date')!="undefined"){
						body_browse.selgdate("r",g_date);
						body_browse.document.getElementById('g_date').value=g_date;
					}
				}

				if(top.showtype=='hgft'||top.showtype=='hgfu'){
					obj_sel = body_browse.document.getElementById('sel_league');
					obj_sel.style.display='none';
					try{
						var obj_date='';
						obj_date=body_browse.document.getElementById("g_date").value;
						body_browse.selgdate("",obj_date);
					}catch(E){}
				}else{
					show_page();
				}


				//var conscroll= body_browse.document.getElementById('controlscroll');
				conscroll.style.display="none";
				//conscroll.width=1;
				//	conscroll.Height=1;
				coun_Leagues();
				body_browse.showPicLove();
				loadingOK();
			}
			var hotgdateArr =new Array();
			function hot_gdate(gdate){
				if((""+hotgdateArr).indexOf(gdate)==-1){
					hotgdateArr.push(gdate);
				}
			}
			function coun_Leagues(){
				var coun=0;
				var str_tmp ="|"+eval('parent.'+sel_gtype+'_lname_ary_RE');
				if(str_tmp=='|ALL'){
					body_browse.document.getElementById("str_num").innerHTML =top.alldata;
				}else{
					var larray=str_tmp.split('|');
					for(var i =0;i<larray.length;i++){
						if(larray[i]!=""){coun++}
					}
					coun =LeagueAry.length;
					body_browse.document.getElementById("str_num").innerHTML =coun;
				}


			}
			//表格函數
			function showtables(GameData,Game_Head,data_amount,odd_f_type){
				ObjDataFT=new Array();
				myLeg=new Array();
				for (var j=0;j < data_amount;j++){
					if (GameData[j]!=null){
						ObjDataFT[j]=parseArray(Game_Head,GameData[j]);
					}
				}
				var trdata;//=body_browse.document.getElementById('DataTR').innerHTML;
				var showtableData;
				if(body_browse.document.all){
					showtableData=body_browse.document.getElementById('showtableData').innerText ;
					trdata=body_browse.document.getElementById('DataTR').innerText;
					notrdata=body_browse.document.getElementById('NoDataTR').innerText;
				} else{
					showtableData=body_browse.document.getElementById('showtableData').textContent ;
					trdata=body_browse.document.getElementById('DataTR').textContent;
					notrdata=body_browse.document.getElementById('NoDataTR').textContent;
				}
				var showtable=body_browse.document.getElementById('showtable');
				var showlayers="";
				keepleg="";
				legnum=0;
				LeagueAry =new Array();
				var chk_Love_I=new Array();
				if(ObjDataFT.length > 0){
					for ( i=0 ;i < ObjDataFT.length;i++){
						tmp_Str=getLayer(trdata,i,odd_f_type);
						showlayers+=tmp_Str;
						if (top.swShowLoveI&&tmp_Str!=""){
							chk_Love_I.push(ObjDataFT[i]);
						}
					}
					if (top.swShowLoveI){
						body_browse.checkLoveCount(chk_Love_I);
					}
					if(showlayers=="")showlayers=notrdata;
					showtableData=showtableData.replace("*showDataTR*",showlayers);
				}else{
					showtableData=showtableData.replace("*showDataTR*",notrdata);
				}

				showtable.innerHTML=showtableData;

			}

			//表格內容
			function getLayer(onelayer,gamerec,odd_f_type){
				var open_hot = false;
				if(MM_IdentificationDisplay(ObjDataFT[gamerec].datetime,ObjDataFT[gamerec].gnum_h)) return "";
				if(("|"+eval('parent.'+sel_gtype+'_lname_ary_RE')).indexOf(("|"+ObjDataFT[gamerec].league+"|"),0)==-1&&eval('parent.'+sel_gtype+'_lname_ary_RE')!='ALL') return "";
				if((""+LeagueAry).indexOf(ObjDataFT[gamerec].league)== -1)LeagueAry.push(ObjDataFT[gamerec].league);
				var tmp_date = ObjDataFT[gamerec].datetime.split("<br>")[0];
				onelayer=onelayer.replace(/\*ID_STR\*/g,tmp_date+ObjDataFT[gamerec].gnum_h);
				onelayer=onelayer.replace(/\*TR_EVENT\*/g,"onMouseOver='mouseEnter_pointer(this.id);' onMouseOut='mouseOut_pointer(this.id);'");
				//alert(ObjDataFT[gamerec].league+"==="+keepleg+"["+(ObjDataFT[gamerec].league==keepleg)+"]")

				if (""+myLeg[ObjDataFT[gamerec].league]=="undefined"){
					myLeg[ObjDataFT[gamerec].league]=ObjDataFT[gamerec].league;
					myLeg[ObjDataFT[gamerec].league]=new Array();
					myLeg[ObjDataFT[gamerec].league][0]=tmp_date+ObjDataFT[gamerec].gnum_h;
				}else{
					myLeg[ObjDataFT[gamerec].league][myLeg[ObjDataFT[gamerec].league].length]=tmp_date+ObjDataFT[gamerec].gnum_h;
				}

				//--------------判斷聯盟名稱列顯示或隱藏----------------
				if (ObjDataFT[gamerec].league==keepleg){
					onelayer=onelayer.replace("*ST*"," style='display: none;'");
				}else{
					onelayer=onelayer.replace("*ST*"," style='display: ;'");
				}
				//---------------------------------------------------------------------
				//--------------判斷聯盟底下的賽事顯示或隱藏----------------
				if (NoshowLeg[ObjDataFT[gamerec].league]==-1){
					onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: none;'");
					onelayer=onelayer.replace("*LegMark*","<span id='LegClose'></span>"); //聯盟的小圖
				}else{
					onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: ;'");
					onelayer=onelayer.replace("*LegMark*","<span id='LegOpen'></span>");  //聯盟的小圖
				}
				//---------------------------------------------------------------------

				//盤口賠率 start
				var R_ior =Array();
				var OU_ior =Array();


				R_ior  = get_other_ioratio(odd_f_type, ObjDataFT[gamerec].ior_RH   , ObjDataFT[gamerec].ior_RC   , show_ior);
				OU_ior = get_other_ioratio(odd_f_type, ObjDataFT[gamerec].ior_OUH  , ObjDataFT[gamerec].ior_OUC  , show_ior);


				ObjDataFT[gamerec].ior_RH=R_ior[0];
				ObjDataFT[gamerec].ior_RC=R_ior[1];
				ObjDataFT[gamerec].ior_OUH=OU_ior[0];
				ObjDataFT[gamerec].ior_OUC=OU_ior[1];
				//盤口賠率 end


				//滾球字眼
				ObjDataFT[gamerec].datetime=ObjDataFT[gamerec].datetime.replace("Running Ball","");
				ObjDataFT[gamerec].timer=ObjDataFT[gamerec].timer.replace("<font style=background-color=red>","").replace("</font>","");
				keepleg=ObjDataFT[gamerec].league;
				onelayer=onelayer.replace(/\*LEG\*/gi,ObjDataFT[gamerec].league);


//	onelayer=onelayer.replace(/\*LegID\*/g,"LEG_"+legnum);



				onelayer=onelayer.replace("*DATETIME*",change_time(ObjDataFT[gamerec].timer));
				onelayer=onelayer.replace("*SCORE*",ObjDataFT[gamerec].score_h+"&nbsp;-&nbsp;"+ObjDataFT[gamerec].score_c);
				onelayer=onelayer.replace("*TEAM_H*",ObjDataFT[gamerec].team_h.replace("[Mid]","<font color=\"#005aff\">[N]</font>").replace("[中]","<font color=\"#005aff\">[中]</font>"));
				onelayer=onelayer.replace("*TEAM_C*",ObjDataFT[gamerec].team_c);
				onelayer=onelayer.replace("*SE*",top.str_RB);
				//全場
				//讓球
				if (ObjDataFT[gamerec].strong=="H"){
					onelayer=onelayer.replace("*CON_RH*",ObjDataFT[gamerec].ratio);	/*讓球球頭*/
					onelayer=onelayer.replace("*CON_RC*","");
				}else{
					onelayer=onelayer.replace("*CON_RH*","");
					onelayer=onelayer.replace("*CON_RC*",ObjDataFT[gamerec].ratio);
				}


				//onelayer=onelayer.replace("*TD_RH_CLASS*",check_ioratio(gamerec,"ior_RH",ObjDataFT[gamerec]));/*讓球sytle*/
				//onelayer=onelayer.replace("*TD_RH_CLASS*","class='b_rig'");/*讓球sytle*/

				onelayer=onelayer.replace("*RATIO_RH*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"R"));/*讓球賠率*/
				onelayer=onelayer.replace("*RATIO_RC*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"R"));
				//大小
				if (top.langx=="en-us"){
					onelayer=onelayer.replace("*CON_OUH*",ObjDataFT[gamerec].ratio_o.replace("O","<b>"+"o"+"</b>"));	/*大小球頭*/
					onelayer=onelayer.replace("*CON_OUC*",ObjDataFT[gamerec].ratio_u.replace("U","<b>"+"u"+"</b>"));
				}else{
					onelayer=onelayer.replace("*CON_OUH*",ObjDataFT[gamerec].ratio_o.replace("O",top.strOver));	/*大小球頭*/
					onelayer=onelayer.replace("*CON_OUC*",ObjDataFT[gamerec].ratio_u.replace("U",top.strUnder));
				}
				onelayer=onelayer.replace("*RATIO_OUH*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"OU"));/*大小賠率*/
				onelayer=onelayer.replace("*RATIO_OUC*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"OU"));
				//我的最愛
				onelayer=onelayer.replace("*MYLOVE*",parseMyLove(ObjDataFT[gamerec]));
				/*
				 if (ObjDataFT[gamerec].play=="Y"){
				 onelayer=onelayer.replace("*TV_ST*","style='display:block;'");

				 }else{
				 onelayer=onelayer.replace("*TV_ST*","style='display:none;'");
				 }

				 */
				if (ObjDataFT[gamerec].eventid != "" && ObjDataFT[gamerec].eventid != "null" && ObjDataFT[gamerec].eventid != undefined) {	//判斷是否有轉播
					tmpStr= VideoFun(ObjDataFT[gamerec].eventid, ObjDataFT[gamerec].hot, ObjDataFT[gamerec].play, "FT");
					//alert(tmpStr);
					onelayer=onelayer.replace("*TV*",tmpStr);
				}
				onelayer=onelayer.replace("*TV*","");

				//alert(onelayer);
				return onelayer;
			}


			//取得下注的url
			function parseUrl(uid,odd_f_type,betTeam,GameData,gamerec,wtype){
				var urlArray=new Array();
				urlArray['R']=new Array("../FT_order/FT_order_re.php",eval("GameData.team_"+betTeam.toLowerCase()));
				urlArray['OU']=new Array("../FT_order/FT_order_rou.php",(betTeam=="C" ? top.strOver : top.strUnder));

				var rewtype = new Array();
				rewtype['R'] = "RE";
				rewtype['OU'] = "ROU";

				var param=getParam(uid,odd_f_type,betTeam,wtype,GameData);
				var order=urlArray[wtype][0];
				var team=urlArray[wtype][1].replace("<font color=#FF0000>","").replace("</font>","").replace("[Mid]","[N]");
				var tmp_rtype="ior_"+wtype+betTeam;
				var ioratio_str="GameData."+tmp_rtype;

				var ioratio=eval(ioratio_str);
				//var ret="<a href='"+order+"?"+param+"' target='mem_order' title='"+team+"'><font "+check_ioratio(gamerec,tmp_rtype,GameData)+">"+ioratio+"</font></a>";
				//alert(parent.name)
				var ret="<a href='javascript://' onclick=\"parent.parent.mem_order.betOrder('BS','"+rewtype[wtype]+"','"+param+"');\" title='"+team+"'><font "+check_ioratio(gamerec,tmp_rtype,GameData)+" class='bet_bg_color'>"+ioratio+"</font></a>";

				return ret;

			}

			//--------------------------public function --------------------------------

			//取得下注參數
			function getParam(uid,odd_f_type,betTeam,wtype,GameData){
				var paramArray=new Array();
				paramArray['R']=new Array("gid","uid","odd_f_type","type","gnum","strong","langx");
				paramArray['OU']=new Array("gid","uid","odd_f_type","type","gnum","langx");

				var param="";
				var gid=((wtype=="R"||wtype=="OU"||wtype=="M"||wtype=="EO") ? GameData.gid : GameData.hgid);
				var gnum=eval("GameData.gnum_"+(betTeam=="N"? "c":betTeam.toLowerCase()));
				var strong=(wtype=="R" ? GameData.strong : GameData.hstrong);
				var rtype=(betTeam=="O" ? "ODD" : "EVEN");
				var type=betTeam;

				for (var i=0;i<paramArray[wtype].length;i++){
					if (i>0)  param+="&";
					param+=paramArray[wtype][i]+"="+eval(paramArray[wtype][i]);
				}
				return param;
			}

			function parseMyLove(GameData){
				var tmpStr="";
				//====== 加入現場轉播功能 2009-04-09, VideoFun 放在 flash_ior_mem.js
				tmpStr=MM_ShowLoveI(GameData.gnum_h,GameData.datetime,GameData.league,GameData.team_h,GameData.team_c);
//	if (top.casino == "SI2") {
				if (GameData.eventid != "" && GameData.eventid != "null" && GameData.eventid != undefined) {	//判斷是否有轉播
					tmpStr+= VideoFun(GameData.eventid, GameData.hot, GameData.play, "FT");
				}
//	}

				return  tmpStr;
			}


		</script>
		<meta http-equiv="Content-Type" content="text/html; charset=<?=$charset?> "><script>

			//--------------------------------public function ----------------------------

			function setRefreshPos(){
//				var refresh_right= body_browse.document.getElementById('refresh_right');
//				refresh_right.style.left= body_browse.document.getElementById('myTable').clientWidth*1+20;
				//refresh_right.style.top= 39;
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


			function check_ioratio(rec,rtype,GameData){
//alert(flash_ior_set);
				//return true;
				//alert(GameFT.length+"----"+keepGameData.length)

				if (flash_ior_set =='Y'){
					//alert(oldObjDataFT[rec]);
					if (""+oldObjDataFT[rec]=="undefined" || oldObjDataFT[rec].gid != GameData.gid){
						var gameObj=new Object();
						gameObj.gid=GameData.gid;
						oldObjDataFT[rec]=gameObj;
					}

					var new_ioratio=eval("GameData."+rtype);
					var old_ioratio=eval("oldObjDataFT[rec]."+rtype);


					if (""+old_ioratio=="undefined"){
						eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
						old_ioratio=eval("oldObjDataFT[rec]."+rtype);
					}

					//alert("old_ioratio==>"+old_ioratio+",new_ioratio==>"+new_ioratio);
					if (""+new_ioratio=="undefined" || new_ioratio==""){
						eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
						return;
					}

					/*
					 if (parseFloat(old_ioratio)>parseFloat(new_ioratio) ){
					 eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
					 return "  style='border: 1px solid #FF0000;' ";
					 }
					 if (parseFloat(old_ioratio)<parseFloat(new_ioratio) ){
					 eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
					 return "  style='border: 1px solid #00FF00;' ";
					 }
					 */

					if (old_ioratio!=new_ioratio && old_ioratio !="" && new_ioratio!="") {
						eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
						return "  style='background-color : yellow' ";
					}

					return true;
				}

			}
			//--------------判斷聯盟顯示或隱藏----------------
			function showLeg(leg){
				for (var i=0;i<myLeg[leg].length;i++){
					if ( body_browse.document.getElementById("TR_"+myLeg[leg][i]).style.display!="none"){
						showLegIcon(leg,"LegClose",myLeg[leg][i],"none");

					}else{
						showLegIcon(leg,"LegOpen",myLeg[leg][i],"");
					}
				}
				if ((""+NoshowLeg[leg])=="undefined"){
					NoshowLeg[leg]=-1;
				}else{
					NoshowLeg[leg]=NoshowLeg[leg]*-1;
				}

			}
			function showLegIcon(leg,state,gnumH,display){
				var  ary=body_browse.document.getElementsByName(leg);

				for (var j=0;j<ary.length;j++){
					ary[j].innerHTML="<span id='"+state+"'></span>";
				}
				try{
					body_browse.document.getElementById("TR3_"+gnumH).style.display=display;
				}catch(E){}
				try{
					body_browse.document.getElementById("TR2_"+gnumH).style.display=display;
				}catch(E){}
				try{
					body_browse.document.getElementById("TR1_"+gnumH).style.display=display;
				}catch(E){}
				try{
					body_browse.document.getElementById("TR_"+gnumH).style.display=display;
				}catch(E){}
			}
			//----------------------

			//分頁
			function show_page(){
				//alert(rtype)
				pg_str='';
				obj_pg = body_browse.document.getElementById('pg_txt');
//	alert(t_page);
				if (t_page==0){
					t_page=1;
					//obj_pg.innerHTML = "";
					//return;
				}
				var tmp_lid="";
				if (rtype=="re"){
					tmp_lid=eval("parent."+sel_gtype+"_lid_ary_RE");
				}else{
					tmp_lid=eval("parent."+sel_gtype+"_lid_ary");
				}
				//alert(tmp_lid+"--"+top.swShowLoveI+"--"+t_page)
				if(tmp_lid=='ALL'&&!top.swShowLoveI){
					var disabled="";
					if (t_page==1){
						disabled="disabled";
					}
					var pghtml=(pg*1+1)+" / " +t_page+" "+top.page+"&nbsp;&nbsp; <select  onchange='chg_pg(this.options[this.selectedIndex].value)' "+disabled+">";
					for(var i=0;i<t_page;i++){
						if (pg==i){
							pghtml+="<option value='"+i+"' selected>"+(i+1)+"</option>";
						}else{
							pghtml+="<option value='"+i+"' >"+(i+1)+"</option>";
						}
					}
					pghtml+="</select>";
					obj_pg.innerHTML = pghtml;
				}else{
					obj_pg.innerHTML = "";
				}
			}

			//將時間 轉回 24小時//04:00p
			function  change_time(get_time){

				if (get_time.indexOf("font") > 0 ) return get_time;
				if (get_time.indexOf("p")>0 || get_time.indexOf("a")>0){
					gtime=get_time.split(":");
					if (gtime[1].indexOf("p")>0){

						if (gtime[0]!="12"){
							gtime[0]=gtime[0]*1+12;
						}
					}
					gtime[1]=gtime[1].replace("a","").replace("p","");

				}else{
					return get_time;
				}
				return gtime[0]+":"+gtime[1];

			}

			//隱藏我的最愛選擇聯賽
			function dis_ShowLoveI(){

				if(top.swShowLoveI){
					body_browse.document.getElementById("sel_league").style.display="none";
				}else{
					body_browse.document.getElementById("sel_league").style.display="";
				}

			}


			function changeTitleStr(s,at){
				if (s.charAt(at)=="H"){
					return "H";
				}else if(s.charAt(at)=="C"){
					return "A";
				}else if(s.charAt(at)=="N"){
					return "D";
				}
				return "";
			}
			function loadingOK(){
				//alert("loadingOK")
//				try{
//					body_browse.document.getElementById("refresh_btn").className="refresh_btn";
//				}catch(E){}
//				try{
//					body_browse.document.getElementById("refresh_right").className="refresh_M_btn";
//				}catch(E){}
//				try{
//					body_browse.document.getElementById("refresh_down").className="refresh_M_btn";
//				}catch(E){}
			}</script>
	<? }
	if($rtype=="pr"){
		?>
		<script>
			var ObjDataFT=new Array();
			var oldObjDataFT=new Array();
			var keepleg="";
			var legnum=0;
			var NoshowLeg=new Array();
			var myLeg=new Array();
			var LeagueAry=new Array();
			function ShowGameList(){

				if(loading == 'Y') return;
				if (parent.gamecount!=gamount){
					oldObjDataFT=new Array();
				}
				if(top.odd_f_type==""||""+top.odd_f_type=="undefined") top.odd_f_type="H";
				keepscroll=body_browse.document.body.scrollTop;

				var conscroll= body_browse.document.getElementById('controlscroll');
				conscroll.style.display="";
				conscroll.style.top=keepscroll+1;
				//conscroll.focus();

				dis_ShowLoveI();

				//凅屜醱
				showtables(GameFT,GameHead,gamount,top.odd_f_type);

				//笭陔腢綎腔赽凅堤
				orderShowSelALL();

				body_browse.scroll(0,keepscroll);

				//偞隅衵源笭陔淕燴弇离
				setRefreshPos();

				//鞞尨屜諳
				//body_browse.ChkOddfDiv();


				parent.gamecount=gamount;
				//狟嶺啪

				if (sel_gtype=="BSFU"){
					if (""+body_browse.document.getElementById('g_date')!="undefined"){
						body_browse.selgdate("pr",g_date);
						body_browse.document.getElementById('g_date').value=g_date;
					}
				}

				if(top.showtype=='hgft'||top.showtype=='hgfu'){
					//alert("111");
					obj_sel = body_browse.document.getElementById('sel_league');
					obj_sel.style.display='none';
					try{
						var obj_date='';
						obj_date=body_browse.document.getElementById("g_date").value;
						body_browse.selgdate("",obj_date);
					}catch(E){}
				}else{
					//alert("2222");
					show_page();
				}


				conscroll.style.display="none";

				coun_Leagues();
				body_browse.showPicLove();
				loadingOK();
				parent.mem_order.getCountHOT(gameCount);
			}
			var hotgdateArr =new Array();
			function hot_gdate(gdate){
				if((""+hotgdateArr).indexOf(gdate)==-1){
					hotgdateArr.push(gdate);
				}
			}
			function coun_Leagues(){
				var coun=0;
				var str_tmp ="|"+eval('parent.'+sel_gtype+'_lname_ary');
				if(str_tmp=='|ALL'){
					body_browse.document.getElementById("str_num").innerHTML =top.alldata;
				}else{
					var larray=str_tmp.split('|');
					for(var i =0;i<larray.length;i++){
						if(larray[i]!=""){coun++}
					}
					coun =LeagueAry.length;
					body_browse.document.getElementById("str_num").innerHTML =coun;
				}


			}
			function orderShowSelALL(){
				for(var i=0;i < top.ordergid.length;i++){
					var obj=top.orderArray["G"+top.ordergid[i]];
					try{
						var classary=(body_browse.document.getElementById(obj.gid+"_"+obj.wtype).className).split("_");
						body_browse.document.getElementById(obj.gid+"_"+obj.wtype).className="pr_"+classary[1];
					}catch(E){}
				}
			}

			//桶跡滲
			function showtables(GameData,Game_Head,data_amount,odd_f_type){
				ObjDataFT=new Array();
				myLeg=new Array();
				for (var j=0;j < data_amount;j++){
					if (GameData[j]!=null){
						ObjDataFT[j]=parseArray(Game_Head,GameData[j]);
					}
				}
				//alert("ObjDataFT===>"+ObjDataFT.length);
				var trdata;//=body_browse.document.getElementById('DataTR').innerHTML;
				var showtableData;
				if(body_browse.document.all){
					showtableData=body_browse.document.getElementById('showtableData').innerText ;
					trdata=body_browse.document.getElementById('DataTR').innerText;
					notrdata=body_browse.document.getElementById('NoDataTR').innerText;
				} else{
					showtableData=body_browse.document.getElementById('showtableData').textContent ;
					trdata=body_browse.document.getElementById('DataTR').textContent;
					notrdata=body_browse.document.getElementById('NoDataTR').textContent;
				}
				//alert(trdata);
				var showtable=body_browse.document.getElementById('showtable');
				var showlayers="";
				keepleg="";
				legnum=0;
				LeagueAry =new Array();
				if(ObjDataFT.length > 0){
					for ( i=0 ;i < ObjDataFT.length;i++){
						showlayers+=getLayer(trdata,i,odd_f_type);

					}
					if(showlayers=="")showlayers=notrdata;
					showtableData=showtableData.replace("*showDataTR*",showlayers);
				}else{
					showtableData=showtableData.replace("*showDataTR*",notrdata);

				}
				showtable.innerHTML=showtableData;
				//oldObjDataFT=ObjDataFT;

//	conscroll.style.display="none";
			}


			//桶跡
			function getLayer(onelayer,gamerec,odd_f_type){
				var open_hot = false;
				if(MM_IdentificationDisplay(ObjDataFT[gamerec].datetime,ObjDataFT[gamerec].gnum_h)) return "";
				if(("|"+eval('parent.'+sel_gtype+'_lname_ary')).indexOf(("|"+ObjDataFT[gamerec].league+"|"),0)==-1&&eval('parent.'+sel_gtype+'_lname_ary')!='ALL') return "";
				if((""+LeagueAry).indexOf(ObjDataFT[gamerec].league)== -1)LeagueAry.push(ObjDataFT[gamerec].league);
				var tmp_date = ObjDataFT[gamerec].datetime.split("<br>")[0];
				onelayer=onelayer.replace(/\*ID_STR\*/g,tmp_date+ObjDataFT[gamerec].gnum_h);
				onelayer=onelayer.replace(/\*TR_EVENT\*/g,"onMouseOver='mouseEnter_pointer(this.id);' onMouseOut='mouseOut_pointer(this.id);'");
				//alert(ObjDataFT[gamerec].league+"==="+keepleg+"["+(ObjDataFT[gamerec].league==keepleg)+"]")

				if (""+myLeg[ObjDataFT[gamerec].league]=="undefined"){
					myLeg[ObjDataFT[gamerec].league]=ObjDataFT[gamerec].league;
					myLeg[ObjDataFT[gamerec].league]=new Array();
					myLeg[ObjDataFT[gamerec].league][0]=tmp_date+ObjDataFT[gamerec].gnum_h;
				}else{
					myLeg[ObjDataFT[gamerec].league][myLeg[ObjDataFT[gamerec].league].length]=tmp_date+ObjDataFT[gamerec].gnum_h;
				}
				onelayer=onelayer.replace("*PORDER*",ObjDataFT[gamerec].par_minlimit);
				if (ObjDataFT[gamerec].league==keepleg){
					//alert(ObjDataFT[gamerec].league+"==="+keepleg+"["+(ObjDataFT[gamerec].league==keepleg)+"]")
					onelayer=onelayer.replace("*ST*"," style='display: none;'");
					//--------------瓚?襠鞞尨麼螛紲----------------
					if (NoshowLeg[ObjDataFT[gamerec].league]==-1){
						//return "";
						onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: none;'");
						//?襠腔苤
						onelayer=onelayer.replace("*LegMark*","<span id='LegClose'></span>");
					}else{
						onelayer=onelayer.replace("*LegMark*","<span id='LegOpen'></span>");
					}
					//---------------------------------------------------------------------
				}else{
					onelayer=onelayer.replace("*ST*","style='display:'';'");

					//--------------瓚?襠鞞尨麼螛紲----------------
					if (NoshowLeg[ObjDataFT[gamerec].league]==-1){
						onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: none;'");
						onelayer=onelayer.replace("*LegMark*","<span id='LegClose'></span>");
					}else{
						//?襠腔苤
						onelayer=onelayer.replace("*LegMark*","<span id='LegOpen'></span>");
					}
					//---------------------------------------------------------------------

				}

				var PR_ior =Array();
				var POU_ior =Array();


				PR_ior  = get_other_ioratio("", ObjDataFT[gamerec].ior_PRH   , ObjDataFT[gamerec].ior_PRC   , show_ior);
				POU_ior = get_other_ioratio("", ObjDataFT[gamerec].ior_POUH  , ObjDataFT[gamerec].ior_POUC  , show_ior);


				ObjDataFT[gamerec].ior_PRH=PR_ior[0];
				ObjDataFT[gamerec].ior_PRC=PR_ior[1];
				ObjDataFT[gamerec].ior_POUH=POU_ior[0];
				ObjDataFT[gamerec].ior_POUC=POU_ior[1];


				//趼桉
				ObjDataFT[gamerec].datetime=ObjDataFT[gamerec].datetime.replace("Running Ball",top.str_RB);
				keepleg=ObjDataFT[gamerec].league;
				onelayer=onelayer.replace(/\*LEG\*/gi,ObjDataFT[gamerec].league);


				var tmp_date=ObjDataFT[gamerec].datetime.split("<br>");
				if (sel_gtype=="BSFU"){
					tmp_date_str=tmp_date[0]+"<br>"+change_time(tmp_date[1]);
				}else{
					tmp_date_str=change_time(tmp_date[1]);
				}

				onelayer=onelayer.replace("*DATETIME*",tmp_date_str);
				onelayer=onelayer.replace("*TEAM_H*",ObjDataFT[gamerec].team_h.replace("[Mid]","<font color=\"#005aff\">[N]</font>").replace("[笢]","<font color=\"#005aff\">[笢]</font>"));
				onelayer=onelayer.replace("*TEAM_C*",ObjDataFT[gamerec].team_c);
				//

				onelayer=onelayer.replace("*GID_RH*",ObjDataFT[gamerec].gid+"_PRH");
				onelayer=onelayer.replace("*GID_RC*",ObjDataFT[gamerec].gid+"_PRC");

				onelayer=onelayer.replace("*GID_OUH*",ObjDataFT[gamerec].gid+"_POUH");
				onelayer=onelayer.replace("*GID_OUC*",ObjDataFT[gamerec].gid+"_POUC");

				//?
				if (ObjDataFT[gamerec].strong=="H"){
					onelayer=onelayer.replace("*CON_RH*",ObjDataFT[gamerec].ratio);	/*?螹*/
					onelayer=onelayer.replace("*CON_RC*","");
				}else{
					onelayer=onelayer.replace("*CON_RH*","");
					onelayer=onelayer.replace("*CON_RC*",ObjDataFT[gamerec].ratio);
				}


				onelayer=onelayer.replace("*RATIO_RH*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"PR"));/*?攲薹*/
				onelayer=onelayer.replace("*RATIO_RC*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"PR"));
				//湮苤
				if (top.langx=="en-us"){
					onelayer=onelayer.replace("*CON_OUC*",ObjDataFT[gamerec].ratio_o.replace("O","o"));	/*湮苤螹*/
					onelayer=onelayer.replace("*CON_OUH*",ObjDataFT[gamerec].ratio_u.replace("U","u"));
				}else{
					onelayer=onelayer.replace("*CON_OUC*",ObjDataFT[gamerec].ratio_o.replace("O",top.strOver));	/*湮苤螹*/
					onelayer=onelayer.replace("*CON_OUH*",ObjDataFT[gamerec].ratio_u.replace("U",top.strUnder));
				}
				onelayer=onelayer.replace("*RATIO_OUC*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"POU"));/*湮苤攲薹*/
				onelayer=onelayer.replace("*RATIO_OUH*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"POU"));

				//扂腔郔
				onelayer=onelayer.replace("*MYLOVE*",parseMyLove(ObjDataFT[gamerec]));
				onelayer=onelayer.replace("*TV*",'');
				//alert(onelayer);
				return onelayer;
			}


			//腕狟蛁腔url
			function parseUrl(uid,odd_f_type,betTeam,GameData,gamerec,wtype){
				var urlArray=new Array();
				urlArray['PR']=new Array(eval("GameData.team_"+betTeam.toLowerCase()));
				urlArray['POU']=new Array((betTeam=="C" ? top.strOver : top.strUnder));
				var team="";
				var title_str="";
				if (urlArray[wtype]!=null){
					team=urlArray[wtype][0].replace("<font color=#FF0000>","").replace("</font>","");
					title_str="title='"+team+"'";
				}
				var tmp_betTeam=betTeam;
				if (wtype=="POU"){
					if (tmp_betTeam=="C"){
						tmp_betTeam="H";
					}else{
						tmp_betTeam="C";
					}
				}
				var tmp_rtype="ior_"+wtype+tmp_betTeam;
				var ioratio_str="GameData."+tmp_rtype;
				var bet_rtype=wtype+betTeam;
				if (wtype.indexOf("T") > -1){
					bet_rtype=wtype.substr(1,1)+"~"+wtype.substr(2,1);
				}

				var ioratio=eval(ioratio_str);
				var ret="<a href='javascript:void(0)'  onclick='parent.orderParlay(\""+GameData.gidm+"\",\""+GameData.gid+"\",\""+GameData.hgid+"\",\""+(bet_rtype)+"\",\""+GameData.par_minlimit+"\",\""+GameData.par_maxlimit+"\")' "+title_str+"><font "+check_ioratio(gamerec,tmp_rtype,GameData)+"class='bet_bg_color'>"+ioratio+"</font></a>";
				return ret;
			}

			//------------------------陔綎燊?伎眻諉陔崝髡夔-------------------max 2010/10
			top.orderArray=new Array();
			top.ordergid=new Array();
			function resort(ary){
				var tempary=new Array();
				for(var i=0;i<ary.length;i++){
					if (ary[i]!=0){
						tempary[tempary.length]=ary[i];
					}
				}
				return tempary;
			}


			function orderRemoveALL(){

				for(var i=0;i<top.ordergid.length;i++){
					orderRemoveGidBgcolor(top.ordergid[i]);
				}
				top.orderArray=new Array();
				top.ordergid=new Array();
			}

			function orderRemoveGid(removeGid){
				for(var i=0;i<top.ordergid.length;i++){
					var obj=top.orderArray["G"+top.ordergid[i]];
					if (obj.gid==removeGid || obj.hgid==removeGid){
						orderRemoveGidBgcolor(top.ordergid[i]);
						top.orderArray["G"+top.ordergid[i]]="undefined";
						top.ordergid[i]=0;
					}
				}
				top.ordergid=resort(top.ordergid);
			}
			function orderRemoveGidBgcolor(gidm){
				var tmpobj=top.orderArray["G"+gidm];
				try{
					var classary=( body_browse.document.getElementById(tmpobj.gid+"_"+tmpobj.wtype).className).split("_");
					body_browse.document.getElementById(tmpobj.gid+"_"+tmpobj.wtype).className="b_"+classary[1];
				}catch(E){}
			}


			function orderParlay(gidm,gid,hgid,wtype,par_minlimit,par_maxlimit){
				if (""+top.orderArray["G"+gidm]=="undefined"){
					top.ordergid[top.ordergid.length]=gidm;
				}else{
					//orderRemoveGidBgcolor(gidm);
					orderRemoveGidBgcolor(gidm);

					var tmp_obj=top.orderArray["G"+gidm];
					if (tmp_obj.wtype==wtype&&tmp_obj.gid==gid){
						orderRemoveGid(gid);
						if (top.ordergid.length > 0){
							orderParlayParam();
						}else{

							try{
								parent.mem_order.close_bet();
							}catch(E){}
						}
						return;
					}
				}

				try{
					var classary=(body_browse.document.getElementById(gid+"_"+wtype).className).split("_");
					body_browse.document.getElementById(gid+"_"+wtype).className="pr_"+classary[1];
				}catch(E){
				}
				var orderobj=new Object();
				orderobj.wtype=wtype;
				orderobj.gid=gid;
				orderobj.hgid=hgid;
				orderobj.par_minlimit=par_minlimit;
				orderobj.par_maxlimit=par_maxlimit;
				top.orderArray["G"+gidm]=orderobj;
				orderParlayParam();

			}
			//------------------------------------------------------------------------------------
			function orderParlayParam(){
				var param="";
				for(var i=0;i<top.ordergid.length;i++){
					var obj=top.orderArray["G"+top.ordergid[i]];
					if (i!=0) param+="&";
					gameparam="game"+(i+1)+"="+obj.wtype+"&game_id"+(i+1)+"="+obj.gid+"&minlimit"+(i+1)+"="+obj.par_minlimit+"&maxlimit"+(i+1)+"="+obj.par_maxlimit;
					param+=gameparam;
				}
				parent.paramData=new Array();
				parent.mem_order.betOrder('BS','PR',"teamcount="+top.ordergid.length+"&uid="+top.uid+"&langx="+top.langx+"&"+param);
			}
			//--------------------------public function --------------------------------


			function parseMyLove(GameData){
				var tmpStr="";
				//====== 加入現場轉播功能 2009-04-09, VideoFun 放在 flash_ior_mem.js
				tmpStr=MM_ShowLoveI(GameData.gnum_h,GameData.datetime,GameData.league,GameData.team_h,GameData.team_c);
//	if (top.casino == "SI2") {
				if (GameData.eventid != "" && GameData.eventid != "null" && GameData.eventid != undefined) {	//判斷是否有轉播
					tmpStr+= VideoFun(GameData.eventid, GameData.hot, GameData.play, "FT");
				}
//	}

				return  tmpStr;
			}

			//狟蛁腕gidm
			function get_gidm(gid,ms){
				for ( i=0 ;i < ObjDataFT.length;i++){
					tmp_gid=ObjDataFT[i].gid;
					if (ms!=""){
						tmp_gid=ObjDataFT[i].hgid;
					}
					if (tmp_gid==gid){
						return 	ObjDataFT[i].gidm;
					}

				}
				return "";
			}
			function killgid(gids){
				//alert(gids);
				var gidary=gids.split("|");
				for (var i=0;i<gidary.length;i++){
					orderRemoveGid(gidary[i]);
				}
				alert(top.str_otb_close);
			}

			//--------------------------------public function ----------------------------

			function setRefreshPos(){
//				var refresh_right= body_browse.document.getElementById('refresh_right');
//				refresh_right.style.left= body_browse.document.getElementById('myTable').clientWidth*1+20;
				//refresh_right.style.top= 39;
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


			function check_ioratio(rec,rtype,GameData){
//alert(flash_ior_set);
				//return true;
				//alert(GameFT.length+"----"+keepGameData.length)

				if (flash_ior_set =='Y'){
					//alert(oldObjDataFT[rec]);
					if (""+oldObjDataFT[rec]=="undefined" || oldObjDataFT[rec].gid != GameData.gid){
						var gameObj=new Object();
						gameObj.gid=GameData.gid;
						oldObjDataFT[rec]=gameObj;
					}

					var new_ioratio=eval("GameData."+rtype);
					var old_ioratio=eval("oldObjDataFT[rec]."+rtype);


					if (""+old_ioratio=="undefined"){
						eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
						old_ioratio=eval("oldObjDataFT[rec]."+rtype);
					}

					//alert("old_ioratio==>"+old_ioratio+",new_ioratio==>"+new_ioratio);
					if (""+new_ioratio=="undefined" || new_ioratio==""){
						eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
						return;
					}

					/*
					 if (parseFloat(old_ioratio)>parseFloat(new_ioratio) ){
					 eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
					 return "  style='border: 1px solid #FF0000;' ";
					 }
					 if (parseFloat(old_ioratio)<parseFloat(new_ioratio) ){
					 eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
					 return "  style='border: 1px solid #00FF00;' ";
					 }
					 */

					if (old_ioratio!=new_ioratio && old_ioratio !="" && new_ioratio!="") {
						eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
						return "  style='background-color : yellow' ";
					}

					return true;
				}

			}
			//--------------瓚?襠鞞尨麼螛紲----------------
			function showLeg(leg){
				for (var i=0;i<myLeg[leg].length;i++){
					if ( body_browse.document.getElementById("TR_"+myLeg[leg][i]).style.display!="none"){
						showLegIcon(leg,"LegClose",myLeg[leg][i],"none");

					}else{
						showLegIcon(leg,"LegOpen",myLeg[leg][i],"");
					}
				}
				if ((""+NoshowLeg[leg])=="undefined"){
					NoshowLeg[leg]=-1;
				}else{
					NoshowLeg[leg]=NoshowLeg[leg]*-1;
				}

			}
			function showLegIcon(leg,state,gnumH,display){
				var  ary=body_browse.document.getElementsByName(leg);

				for (var j=0;j<ary.length;j++){
					ary[j].innerHTML="<span id='"+state+"'></span>";
				}
				try{
					body_browse.document.getElementById("TR3_"+gnumH).style.display=display;
				}catch(E){}
				try{
					body_browse.document.getElementById("TR2_"+gnumH).style.display=display;
				}catch(E){}
				try{
					body_browse.document.getElementById("TR1_"+gnumH).style.display=display;
				}catch(E){}
				try{
					body_browse.document.getElementById("TR_"+gnumH).style.display=display;
				}catch(E){}
			}
			//----------------------

			//煦?
			function show_page(){
				//alert(rtype)
				pg_str='';
				obj_pg = body_browse.document.getElementById('pg_txt');
//	alert(t_page);
				if (t_page==0){
					t_page=1;
					//obj_pg.innerHTML = "";
					//return;
				}
				var tmp_lid="";
				if (rtype=="re"){
					tmp_lid=eval("parent."+sel_gtype+"_lid_ary_RE");
				}else{
					tmp_lid=eval("parent."+sel_gtype+"_lid_ary");
				}
				//alert(tmp_lid+"--"+top.swShowLoveI+"--"+t_page)
				if(tmp_lid=='ALL'&&!top.swShowLoveI){
					var disabled="";
					if (t_page==1){
						disabled="disabled";
					}
					var pghtml=(pg*1+1)+" / " +t_page+" "+top.page+"&nbsp;&nbsp; <select  onchange='chg_pg(this.options[this.selectedIndex].value)' "+disabled+">";
					for(var i=0;i<t_page;i++){
						if (pg==i){
							pghtml+="<option value='"+i+"' selected>"+(i+1)+"</option>";
						}else{
							pghtml+="<option value='"+i+"' >"+(i+1)+"</option>";
						}
					}
					pghtml+="</select>";
					obj_pg.innerHTML = pghtml;
				}else{
					obj_pg.innerHTML = "";
				}
			}

			//嶲 滖隙 24苤//04:00p
			function  change_time(get_time){

				if (get_time.indexOf("font") > 0 ) return get_time;
				if (get_time.indexOf("p")>0 || get_time.indexOf("a")>0){
					gtime=get_time.split(":");
					if (gtime[1].indexOf("p")>0){

						if (gtime[0]!="12"){
							gtime[0]=gtime[0]*1+12;
						}
					}
					gtime[1]=gtime[1].replace("a","").replace("p","");

				}else{
					return get_time;
				}
				return gtime[0]+":"+gtime[1];

			}

			//螛紲扂腔郔腢??
			function dis_ShowLoveI(){

				if(top.swShowLoveI){
					body_browse.document.getElementById("sel_league").style.display="none";
				}else{
					body_browse.document.getElementById("sel_league").style.display="";
				}

			}


			function changeTitleStr(s,at){
				if (s.charAt(at)=="H"){
					return "H";
				}else if(s.charAt(at)=="C"){
					return "A";
				}else if(s.charAt(at)=="N"){
					return "D";
				}
				return "";
			}


			function loadingOK(){
//				//alert("loadingOK")
//				try{
//					body_browse.document.getElementById("refresh_btn").className="refresh_btn";
//				}catch(E){}
//				try{
//					body_browse.document.getElementById("refresh_right").className="refresh_M_btn";
//				}catch(E){}
//				try{
//					body_browse.document.getElementById("refresh_down").className="refresh_M_btn";
//				}catch(E){}
			}


			var gameCount="";
			var recordHash=new Array();
			function showHOT(countHOT){

				if( (""+countHOT=="") || (""+countHOT=="undefined") ){

//					body_browse.document.getElementById("euro_btn").style.display="none";
//					body_browse.document.getElementById("euro_up").style.display="none";

				}else{

					if(""+top.hot_game=="undefined"){
						top.hot_game="";
					}
					var gtypeHOT =new Array("FT","BK","TN","VB","OP");
					var countgames=countHOT.split(",");
					recordHash=new Array();
					var head_str="";

					if(rtype == "re"){
						head_str="RB";
					}else{
						head_str=top.head_FU;
					}
					//alert(head_str);

					for( var i=0;i<countgames.length;i++){
						var detailgame=countgames[i].split("|");
						recordHash[detailgame[0]+"_"+detailgame[1]]=detailgame[2]*1;
					}
					if(recordHash[top.head_gtype+"_HOT_"+head_str]*1==0){
//						body_browse.document.getElementById("euro_btn").style.display="none";
//						body_browse.document.getElementById("euro_up").style.display="none";
						//body_browse.document.getElementById("euro_close").style.display="";
						if(top.hot_game!=""){
							top.hot_game="";
							body_browse.reload_var();
						}
					}else{
						if(top.hot_game!=""){
//							body_browse.document.getElementById("euro_btn").style.display="none";
//							body_browse.document.getElementById("euro_up").style.display="";
						}else{
//							body_browse.document.getElementById("euro_btn").style.display="";
//							body_browse.document.getElementById("euro_up").style.display="none";
						}
						//body_browse.document.getElementById("euro_close").style.display="none";
					}
					//alert(recordHash[top.head_gtype+"_HOT_RB"]);
					//alert(recordHash[top.head_gtype+"_HOT_FT"]);
					//alert(recordHash[top.head_gtype+"_HOT_FU"]);
					//parent.mem_order.showHOT(recordHash[top.head_gtype+"_HOT_FT"],recordHash[top.head_gtype+"_HOT_FU"]);
					//parent.mem_order.showHOT(recordHash["FT_HOT_FT"],recordHash["FT_HOT_FU"]);
					/*
					 var today_hot=0;
					 var early_hot=0;
					 for( var i=0;i<gtypeHOT.length;i++){
					 try{
					 parent.mem_order.document.getElementById(gtypeHOT[i]+"_FT").innerHTML=eval("top.str_"+gtypeHOT[i]) + "("+recordHash[gtypeHOT[i]+"_HOT_FT"]+")";
					 parent.mem_order.document.getElementById(gtypeHOT[i]+"_FU").innerHTML=eval("top.str_"+gtypeHOT[i]) + "("+recordHash[gtypeHOT[i]+"_HOT_FU"]+")";
					 }catch(E){}

					 today_hot +=recordHash[gtypeHOT[i]+"_HOT_FT"];
					 early_hot +=recordHash[gtypeHOT[i]+"_HOT_FU"];
					 }

					 parent.mem_order.showHOT(today_hot,early_hot);
					 */
					try{
						parent.mem_order.getCountHOT(countHOT);
					}catch(e){}

				}

			}
		</script>
	<? }?>
	<SCRIPT LANGUAGE="JAVASCRIPT">
		<!--
		if(self == top) location='<?=BROWSER_IP?>/app/member/';

		var username='';
		var maxcredit='';
		var code='';
		var pg=0;
		var sel_league='';	//選擇顯示聯盟
		var uid='';		//user's session ID
		var loading = 'Y';	//是否正在讀取瀏覽頁面
		var loading_var = 'Y';	//是否正在讀取變數值頁面
		var ShowType = '';	//目前顯示頁面
		var ltype = 1;		//目前顯示line
		var retime_flag = 'Y';	//自動更新旗標
		var retime = 0;		//自動更新時間

		var str_even = '和局';
		var str_renew = '秒自動更新';
		var str_submit = '確認';
		var str_reset = '重設';

		var num_page = 20;	//設定20筆賽程一頁
		var now_page = 1;	//目前顯示頁面
		var pages = 1;		//總頁數
		var msg = '';		//即時資訊
		var gamount = 0;	//目前顯示一般賽程數
		var GameFT = new Array(512); //最多設定顯示512筆開放賽程
		var sel_gtype='BS';
		var iorpoints=3;
		// -->

	</SCRIPT>
</head>
<frameset rows="0,*" frameborder="NO" border="0" framespacing="0">
	<frame name="body_var" scrolling="NO" noresize src="body_var.php?uid=<?=$uid?>&rtype=<?=$rtype?>&langx=<?=$langx?>&mtype=<?=$mtype?>&delay=<?=$delay?>&league_id=<?=$league_id?>">
	<frame name="body_browse" src="body_browse.php?uid=<?=$uid?>&rtype=<?=$rtype?>&langx=<?=$langx?>&mtype=<?=$mtype?>&delay=<?=$delay?>">
</frameset>
<noframes><body bgcolor="#000000">
	</body></noframes>
</html>
