<?
include "../include/library.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/http.class.php");
$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
$mtype=$_REQUEST['mtype'];
if($mtype==""){
	$mtype=3;
}
include("../include/msg.inc.php");

$rtype=ltrim(strtolower($_REQUEST['rtype']));
if($rtype == 'all'){
	$rtype='r_main';
}
$league_id=$_REQUEST['league_id'];
$sql = "select language,memname,status from web_member where oid='$uid' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
$row = mysql_fetch_array($result);
$memname=$row['memname'];
//userlog($memname);
$status=$row['status'];
if($status==2)
{
	echo "此帐号以被暂停，请联系你的上级!";
	exit;
}

require ("../include/traditional.$langx.inc.php");
if ($rtype=="" or $rtype=='r'){
	$rtype="r_main";
}
if ($rtype=='re'){
	$rtype="re_main";
}
?>
<html>


<head>
	<script>var show_ior = '100';</script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>下注分割畫面</title>
	<script>
		var keepGameData=new Array();
		var gidData=new Array();
		parent.gamecount=0;
		//判斷賠率是否變動
		//包td
		var motherStr;
		try{
			if(frame_broke) motherStr = "";

		}catch(e){
			try{ console.log("error motherStr set from flash_ior_mem"); }catch(e){};
			motherStr = "parent.";
		}

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
			//play="Y";
			if (play == "Y") {
				//tmpStr+= "<img lowsrc=\"/images/member/video_1.gif\" onClick=\"parent.OpenLive('"+eventid+"','"+gtype+"')\" style=\"cursor:hand\">";
				tmpStr= "<span ><div style=\"cursor:hand\" class=\"tv_icon_on\" onClick=\""+motherStr+"OpenLive('"+eventid+"','"+gtype+"')\"></div></span>";
			} else {
				//tmpStr+= "<img lowsrc=\"/images/member/video_2.gif\">";
				tmpStr= "<span ><div  class=\"tv_icon_out\"></div></span>";
			}
			return tmpStr;
		}

		function MM_ShowLoveI(gid,getDateTime,getLid,team_h,team_c){
			var txtout="";
			//if(!top.swShowLoveI){
			//alert(chkRepeat(gid));
			if(!chkRepeat(gid,getDateTime)){
				//txtout = "<span id='sp_"+MM_imgId(getDateTime,gid)+"'><img id='"+MM_imgId(getDateTime,gid)+"' lowsrc=\"/images/member/icon_X2.gif\" vspace=\"0\" style=\"cursor:hand;display:none;\" title=\""+top.str_ShowMyFavorite+"\" onClick=\"addShowLoveI('"+gid+"','"+getDateTime+"','"+getLid+"','"+team_h+"','"+team_c+"'); \"></span>";
				txtout = "<span id='sp_"+MM_imgId(getDateTime,gid)+"'><div id='"+MM_imgId(getDateTime,gid)+"' class=\"fov_icon_out\" style=\"cursor:hand;display:none;\" title=\""+top.str_ShowMyFavorite+"\" onClick=\"addShowLoveI('"+gid+"','"+getDateTime+"','"+getLid+"','"+team_h+"','"+team_c+"'); \"></div></span>";
			}else{
				//txtout = "<span id='sp_"+MM_imgId(getDateTime,gid)+"'><img lowsrc=\"/images/member/love_small.gif\" style=\"cursor:hand\" title=\""+top.str_delShowLoveI+"\" onClick=\"chkDelshowLoveI('"+getDateTime+"','"+gid+"'); \"></span>";
				txtout = "<span id='sp_"+MM_imgId(getDateTime,gid)+"'><div class=\"fov_icon_on\" style=\"cursor:hand\" title=\""+top.str_delShowLoveI+"\" onClick=\"chkDelshowLoveI('"+getDateTime+"','"+gid+"'); \"></div></span>";
			}
			//}else{
			//txtout = "<img lowsrc=\"/images/member/love_small.gif\" style=\"cursor:hand\" title=\""+top.str_delShowLoveI+"\" onClick=\"chkDelshowLoveI('"+getDateTime+"','"+gid+"'); \">";
			//txtout = "<div class=\"fov_icon_on\" style=\"cursor:hand\" title=\""+top.str_delShowLoveI+"\" onClick=\"chkDelshowLoveI('"+getDateTime+"','"+gid+"'); \"></div>";
			//}
			return txtout;
		}


		function chkRepeat(gid,getDateTime){
			var getGtype =getGtypeShowLoveI();
			var sw =false;
			for (var i=0 ; i < top.ShowLoveIarray[getGtype].length ; i++){
				if(top.ShowLoveIarray[getGtype][i][0]==gid && top.ShowLoveIarray[getGtype][i][1] == getDateTime)
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
			//alert("tmp===>"+tmp+"==="+"gid===>"+gid+"===");
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
			//console.log("1. "+odd_f+"<>"+iorH+"<>"+iorC+"<>"+showior);
			iorH = Math.floor((iorH*1000)+0.001) / 1000;
			iorC = Math.floor((iorC*1000)+0.001) / 1000;

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
		}
	</script>


	<? if ($rtype=='r_all' or $rtype=='r_sub' or $rtype=='r_no' or $rtype=='r_main'){?>
		<script>
			var ObjDataFT=new Array();
			var oldObjDataFT=new Array();
			var keepleg="";
			var legnum=0;
			var NoshowLeg=new Array();
			var myLeg=new Array();
			var LeagueAry=new Array();

			function ShowGameList(){
				if(""+top.hot_game=="undefined"){
					top.hot_game="";
				}
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
				//body_browse.scroll(0,keepscroll);

				//設定右方重新整理位置
				//setRefreshPos();

				//顯示盤口
				//body_browse.ChkOddfDiv();

				parent.gamecount=gamount;

				//日期下拉霸
				if (sel_gtype=="BU"){
					if (""+body_browse.document.getElementById('g_date')!="undefined"){
						body_browse.selgdate(rtype,g_date);
						body_browse.document.getElementById('g_date').value=g_date;
					}
				}

				if (top.hot_game!=""){
					body_browse.document.getElementById('sel_league').style.display='none';
					show_page();
				}else{

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

				}
				conscroll.style.display="none";
				coun_Leagues();

				body_browse.showPicLove();

				loadingOK();

				//showHOT(gameCount);//alert(retime_flag);

				keep_show_more(show_more_gid,ObjDataFT,gamount);

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
						if (top.swShowLoveI&&tmp_Str!=""&&ObjDataFT[i].isMaster=="Y"){
							chk_Love_I.push(ObjDataFT[i]);
						}
					}

					if(showlayers=="")showlayers=notrdata;
					showtableData=showtableData.replace("*showDataTR*",showlayers);
				}else{
					showtableData=showtableData.replace("*showDataTR*",notrdata);
				}
				if (top.head_FU=="FT"){
					if (top.hot_game==""){
						if(top.swShowLoveI){
							body_browse.checkLoveCount(chk_Love_I);
						}
					}
				}
				showtable.innerHTML=showtableData;

			}

			//表格內容
			function getLayer(onelayer,gamerec,odd_f_type){
				var open_hot = false;
				if (top.hot_game==""){
					if(MM_IdentificationDisplay(ObjDataFT[gamerec].datetime,ObjDataFT[gamerec].gidm)) return "";
				}
				if (!top.swShowLoveI){
					if (top.hot_game==""){
						if(("|"+eval('parent.'+sel_gtype+'_lname_ary')).indexOf(("|"+ObjDataFT[gamerec].league+"|"),0)==-1&&eval('parent.'+sel_gtype+'_lname_ary')!='ALL') return "";
						if((""+LeagueAry).indexOf(ObjDataFT[gamerec].league)== -1)LeagueAry.push(ObjDataFT[gamerec].league);
					}
				}

				var tmp_date = ObjDataFT[gamerec].datetime.split("<br>")[0];
				onelayer=onelayer.replace(/\*ID_STR\*/g,tmp_date+ObjDataFT[gamerec].gidm+"-"+ObjDataFT[gamerec].gnum_h);
				onelayer=onelayer.replace(/\*TR_EVENT\*/g	,"onMouseOver='mouseEnter_pointer(\"TR_"+tmp_date+ObjDataFT[gamerec].gidm+"\");' onMouseOut='mouseOut_pointer(\"TR_"+tmp_date+ObjDataFT[gamerec].gidm+"\");'");
				if (""+myLeg[ObjDataFT[gamerec].league]=="undefined"){
					myLeg[ObjDataFT[gamerec].league]=ObjDataFT[gamerec].league;
					myLeg[ObjDataFT[gamerec].league]=new Array();
					myLeg[ObjDataFT[gamerec].league][0]=tmp_date+ObjDataFT[gamerec].gidm+"-"+ObjDataFT[gamerec].gnum_h;
				}else{
					myLeg[ObjDataFT[gamerec].league][myLeg[ObjDataFT[gamerec].league].length]=tmp_date+ObjDataFT[gamerec].gidm+"-"+ObjDataFT[gamerec].gnum_h;
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
				//var EO_ior =Array();
				var OUH_ior = Array();
				var OUC_ior = Array();
				R_ior  = get_other_ioratio(odd_f_type, ObjDataFT[gamerec].ior_RH   , ObjDataFT[gamerec].ior_RC   , show_ior);
				OU_ior = get_other_ioratio(odd_f_type, ObjDataFT[gamerec].ior_OUH  , ObjDataFT[gamerec].ior_OUC  , show_ior);
				OUH_ior = get_other_ioratio(odd_f_type,ObjDataFT[gamerec].ior_OUHO,ObjDataFT[gamerec].ior_OUHU,show_ior);
				OUC_ior = get_other_ioratio(odd_f_type,ObjDataFT[gamerec].ior_OUCO,ObjDataFT[gamerec].ior_OUCU,show_ior);
				/*
				 if((ObjDataFT[gamerec].ior_EOO != 0) && (ObjDataFT[gamerec].ior_EOE != 0)){
				 EO_ior= get_other_ioratio("H", ObjDataFT[gamerec].ior_EOO*1-1 , ObjDataFT[gamerec].ior_EOE*1-1 , show_ior);
				 ObjDataFT[gamerec].ior_EOO=EO_ior[0]*1+1;
				 ObjDataFT[gamerec].ior_EOE=EO_ior[1]*1+1;
				 }
				 */
				ObjDataFT[gamerec].ior_RH=R_ior[0];
				ObjDataFT[gamerec].ior_RC=R_ior[1];
				ObjDataFT[gamerec].ior_OUH=OU_ior[0];
				ObjDataFT[gamerec].ior_OUC=OU_ior[1];
				ObjDataFT[gamerec].ior_OUHO=OUH_ior[0];
				ObjDataFT[gamerec].ior_OUHU=OUH_ior[1];
				ObjDataFT[gamerec].ior_OUCO=OUC_ior[0];
				ObjDataFT[gamerec].ior_OUCU=OUC_ior[1];
				//盤口賠率 end


				//滾球字眼
				ObjDataFT[gamerec].datetime=ObjDataFT[gamerec].datetime.replace("Running Ball",top.str_RB);
				keepleg=ObjDataFT[gamerec].league;
				onelayer=onelayer.replace(/\*LEG\*/gi,ObjDataFT[gamerec].league);

				var tmp_date=ObjDataFT[gamerec].datetime.split("<br>");
				if (sel_gtype=="BU"){
					tmp_date_str=tmp_date[0]+"<br>"+change_time(tmp_date[1]);
				}else{
					tmp_date_str=change_time(tmp_date[1]);
				}
				if (tmp_date.length==3){
					tmp_date_str+="<br>"+tmp_date[2];
				}
				if(ObjDataFT[gamerec].isMaster=="Y"){
					onelayer=onelayer.replace("*DATETIME*",tmp_date_str);
				}else{
					onelayer=onelayer.replace("*DATETIME*","");
				}
				onelayer=onelayer.replace("*TEAM_H*",ObjDataFT[gamerec].team_h.replace("[Mid]","<font color=\"#005aff\">[N]</font>").replace("[中]","<font color=\"#005aff\">[中]</font>").replace("#FFFF99",""));
				onelayer=onelayer.replace("*TEAM_C*",ObjDataFT[gamerec].team_c.replace("#FFFF99",""));
				//全場

				//獨贏
				if ((ObjDataFT[gamerec].ior_MH*1 > 0) && (ObjDataFT[gamerec].ior_MC*1 > 0)){
					onelayer=onelayer.replace("*RATIO_MH*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"M"));
					onelayer=onelayer.replace("*RATIO_MC*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"M"));
				}else{
					onelayer=onelayer.replace("*RATIO_MH*","&nbsp;");
					onelayer=onelayer.replace("*RATIO_MC*","&nbsp;");
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
					onelayer=onelayer.replace("*CON_OUH*",ObjDataFT[gamerec].ratio_o.replace("O","o"));	/*大小球頭*/
					onelayer=onelayer.replace("*CON_OUC*",ObjDataFT[gamerec].ratio_u.replace("U","u"));
				}else{
					onelayer=onelayer.replace("*CON_OUH*",ObjDataFT[gamerec].ratio_o.replace("O",top.strOver));	/*大小球頭*/
					onelayer=onelayer.replace("*CON_OUC*",ObjDataFT[gamerec].ratio_u.replace("U",top.strUnder));
				}
				onelayer=onelayer.replace("*RATIO_OUH*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"OU"));/*大小賠率*/
				onelayer=onelayer.replace("*RATIO_OUC*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"OU"));
				//單雙
				//onelayer=onelayer.replace("*RATIO_EOO*",ObjDataFT[gamerec].str_odd+parseUrl(uid,odd_f_type,"O",ObjDataFT[gamerec],gamerec,"EO"));
				//onelayer=onelayer.replace("*RATIO_EOE*",ObjDataFT[gamerec].str_even+parseUrl(uid,odd_f_type,"E",ObjDataFT[gamerec],gamerec,"EO"));
				/*
				 if (top.langx=="en-us"){
				 onelayer=onelayer.replace("*RATIO_EOO*","<span class=\"con_oe\">"+ObjDataFT[gamerec].str_odd+"&nbsp</span>"+parseUrl(uid,odd_f_type,"O",ObjDataFT[gamerec],gamerec,"EO"));
				 onelayer=onelayer.replace("*RATIO_EOE*","<span class=\"con_oe\">"+ObjDataFT[gamerec].str_even+"&nbsp</span>"+parseUrl(uid,odd_f_type,"E",ObjDataFT[gamerec],gamerec,"EO"));
				 }else{
				 onelayer=onelayer.replace("*RATIO_EOO*","<span class=\"con_oe\">"+ObjDataFT[gamerec].str_odd+"&nbsp</span>"+parseUrl(uid,odd_f_type,"O",ObjDataFT[gamerec],gamerec,"EO"));
				 onelayer=onelayer.replace("*RATIO_EOE*","<span class=\"con_oe\">"+ObjDataFT[gamerec].str_even+"&nbsp</span>"+parseUrl(uid,odd_f_type,"E",ObjDataFT[gamerec],gamerec,"EO"));
				 }
				 */
				//全場總局數
				if(top.langx == "en-us"){
					onelayer = onelayer.replace("*CON_OUHO*",ObjDataFT[gamerec].ratio_ouho.replace("O","<font class=\"text_green\">o</font>"));/*大小球頭*/
					onelayer = onelayer.replace("*CON_OUHU*",ObjDataFT[gamerec].ratio_ouhu.replace("U","<font class=\"text_brown\">u</font>"));
					onelayer = onelayer.replace("*CON_OUCO*",ObjDataFT[gamerec].ratio_ouco.replace("O","<font class=\"text_green\">o</font>"));/*大小球頭*/
					onelayer = onelayer.replace("*CON_OUCU*",ObjDataFT[gamerec].ratio_oucu.replace("U","<font class=\"text_brown\">u</font>"));
				}else{
					onelayer = onelayer.replace("*CON_OUHO*",ObjDataFT[gamerec].ratio_ouho.replace("O","<font class=\"text_green\">"+top.strOver+"</font>"));/*大小球頭*/
					onelayer = onelayer.replace("*CON_OUHU*",ObjDataFT[gamerec].ratio_ouhu.replace("U","<font class=\"text_brown\">"+top.strUnder+"</font>"));
					onelayer = onelayer.replace("*CON_OUCO*",ObjDataFT[gamerec].ratio_ouco.replace("O","<font class=\"text_green\">"+top.strOver+"</font>"));/*大小球頭*/
					onelayer = onelayer.replace("*CON_OUCU*",ObjDataFT[gamerec].ratio_oucu.replace("U","<font class=\"text_brown\">"+top.strUnder+"</font>"));
				}
				onelayer = onelayer.replace("*RATIO_OUHO*",parseUrl(uid,odd_f_type,"O",ObjDataFT[gamerec],gamerec,"OUH"));/*大小賠率*/
				onelayer = onelayer.replace("*RATIO_OUHU*",parseUrl(uid,odd_f_type,"U",ObjDataFT[gamerec],gamerec,"OUH"));
				onelayer = onelayer.replace("*RATIO_OUCO*",parseUrl(uid,odd_f_type,"O",ObjDataFT[gamerec],gamerec,"OUC"));
				onelayer = onelayer.replace("*RATIO_OUCU*",parseUrl(uid,odd_f_type,"U",ObjDataFT[gamerec],gamerec,"OUC"));

				onelayer=onelayer.replace("*MORE*",parseAllBets(ObjDataFT[gamerec],game_more));
				//我的最愛
				onelayer=onelayer.replace("*MYLOVE*",parseMyLove(ObjDataFT[gamerec]));
				if (ObjDataFT[gamerec].eventid != "" && ObjDataFT[gamerec].eventid != "null" && ObjDataFT[gamerec].eventid != undefined) {	//判斷是否有轉播
					tmpStr= VideoFun(ObjDataFT[gamerec].eventid, ObjDataFT[gamerec].hot, ObjDataFT[gamerec].play, "BK");
					onelayer=onelayer.replace("*TV*",tmpStr);
				}
				onelayer=onelayer.replace("*TV*","");

				return onelayer;





			}

			//取得下注的url
			function parseUrl(uid,odd_f_type,betTeam,GameData,gamerec,wtype){
				var urlArray=new Array();
				urlArray['R']=new Array("../BK_order/BK_order_r.php",eval("GameData.team_"+betTeam.toLowerCase()));
				urlArray['OU']=new Array("../BK_order/BK_order_ou.php",(betTeam=="C" ? top.strOver : top.strUnder));
				urlArray['EO']=new Array("../BK_order/BK_order_t.php", (betTeam=="O"  ? top.str_o : top.str_e));
				urlArray['M']=new Array("../BK_order/BK_order_m.php",(betTeam=="N" ? top.str_irish_kiss : eval("GameData.team_"+betTeam.toLowerCase())));
				urlArray['OUH'] = new Array("../BK_order/BK_order_ouhc.php",(betTeam=="O"?top.strOver:top.strUnder));
				urlArray['OUC'] = new Array("../BK_order/BK_order_ouhc.php",(betTeam=="O"?top.strOver:top.strUnder));

				var param=getParam(uid,odd_f_type,betTeam,wtype,GameData);
				var order=urlArray[wtype][0];
				var team=urlArray[wtype][1].replace("<font color=gray>","").replace("</font>","").replace("[Mid]","[N]");;
				var tmp_rtype="ior_"+wtype+betTeam;
				var ioratio_str="GameData."+tmp_rtype;

				var ioratio=eval(ioratio_str);



				if(eval(ioratio_str)!=""){
					ioratio=Mathfloor(ioratio);
					ioratio=printf(ioratio,2);
				}
				//20121023 max新增 輸水盤 負值顯示藍色
				if (odd_f_type=="M" || odd_f_type=="I"){
					if (ioratio<0) ioratio="<font color=#1f497d>"+ioratio+"</font>";
				}

				var ret="<a href='javascript://' onclick=\"parent.parent.mem_order.betOrder('BK','"+wtype+"','"+param+"');\" title='"+team+"'><font "+check_ioratio(gamerec,tmp_rtype,GameData)+" class='bet_bg_color'>"+ioratio+"</font></a>";

				return ret;
			}
			function Mathfloor(z){
				var tmp_z;
				tmp_z=(Math.floor(z*100+0.01))/100;
				return tmp_z;
			}
			//--------------------------public function --------------------------------

			//取得下注參數
			function getParam(uid,odd_f_type,betTeam,wtype,GameData){
				var paramArray=new Array();
				paramArray['R']=new Array("gid","uid","odd_f_type","type","gnum","strong","langx");
				paramArray['OU']=new Array("gid","uid","odd_f_type","type","gnum","langx");
				paramArray['EO']=new Array("gid","uid","odd_f_type","rtype","langx");
				paramArray['M']=new Array("gid","uid","odd_f_type","type","gnum","langx");
				paramArray["OUH"] = new Array("gid","uid","odd_f_type","wtype","type","langx");
				paramArray["OUC"] = new Array("gid","uid","odd_f_type","wtype","type","langx");



				var param="";
				var gid=((wtype=="R"||wtype=="OU"||wtype=="M"||wtype=="EO"||wtype=="OUH"||wtype=="OUC") ? GameData.gid : GameData.hgid);
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

			function parsemore(GameData,g_more){
				var ret="";
				if(g_more=='0'||GameData.more=='0'){
					ret="&nbsp;";
				}else{
					ret="<A href=javascript: onClick=parent.show_more('"+GameData.gid+"',event);>"+"<font class='total_color'>+"+GameData.more+"&nbsp;</font>"+str_more+"</A>";
				}
				return ret;
			}
			function parseAllBets(GameData,g_more){
				var ret="";

				if(g_more=='0'||GameData.more=='0'){
					ret="&nbsp;";
				}else{
					ret="<A href=javascript: onClick=parent.show_allbets('"+GameData.gid+"',event);><font class='total_color'>"+top.str_all_bets+" ("+GameData.more+")</font></A>";
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
			function show_allbets(gid,evt){

				evt = evt ? evt : (window.event ? window.event : null);
				var mY = evt.pageY ? evt.pageY : evt.y;

				top.browse_ScrollY = getScroll(body_browse);//body_browse.scrollY;
				body_browse.document.getElementById('box').style.display="none";
//				body_browse.document.getElementById('refresh_right').style.display="none";
//				body_browse.document.getElementById('refresh_down').style.display="none";
				if(g_date == ""){
					body_browse.document.getElementById('MFT').className="more_bar";
				}
				else {
					body_browse.document.getElementById('MBU').className="more_bar";
				}


				body_browse.document.getElementById('more_window').style.position='absolute';
				body_browse.document.getElementById('more_window').style.top="0px";
				body_browse.document.getElementById('more_window').style.left="0px";
				show_more_gid = gid;
				retime_flag = "N";
				if(typeof(top.more_fave_wtype) == "undefined" ) top.more_fave_wtype = new Array();
				if(typeof(top.more_fave_wtype[show_more_gid]) == "undefined" ) top.more_fave_wtype[show_more_gid] = new Array();
				var  url="body_var_r_allbets.php?gid="+gid+"&uid="+uid+"&ltype="+ltype+"&langx="+top.langx+"&gtype=BK";

				body_browse.showdata.location.href = url;
			}
			function getScroll(frameObj){
				return body_browse.scrollY || body_browse.document.body.scrollTop ;
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

			function chk_half(str){
				if(str.indexOf("<font color=gray>") > -1) return true;
				return false;
			}
			function parseMore(GameData,g_more){
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
				body_browse.document.getElementById('more_window').style.left=body_browse.document.body.scrollLeft+10;
				show_more_gid = gid;
				var  url="body_var_r_more.php?gid="+gid+"&uid="+uid+"&ltype="+ltype+"&langx="+top.langx;
				body_browse.showdata.location.href = url;
			}</script>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8 "><script>
			var isHot_game = false;//是否為世足賽

			//that body_browse be self


			try{
				if(frame_broke) body_browse = this;
				else 			body_browse = body_browse;
			}catch(e){
				try{ console.log("error body_browse set from FT_mem_Function"); }catch(e){};
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
				if (rtype=="re"||rtype.match("^re")){
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
						if(isHot_game){
							if(top.hot_game!=""){
//								body_browse.document.getElementById("euro_btn").style.display="none";
//								body_browse.document.getElementById("euro_up").style.display="";
							}else{
//								body_browse.document.getElementById("euro_btn").style.display="";
//								body_browse.document.getElementById("euro_up").style.display="none";
							}
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
				alert(retime_flag);
			}

			//function getCountHOT(){
			//	return recordHash[top.head_gtype+"_HOT_FT"];
			//}
			function keep_show_more(gid,GameFT,gamount){
				if(gid!=''){
					show_more_gid = '';
					for (var j=0;j < gamount;j++){
						if(gid == GameFT[j].gid  && GameFT[j].more != 0){
							//body_browse.showdata.location.reload();
							show_more_gid = gid;
							return;
						}
					}
				}
				body_browse.document.getElementById('more_window').style.display='none';
			}

			function showCleanData(gtype,rtype,show){
				body_browse.location.href="../showCleanData.php?uid="+uid+"&ltype="+ltype+"&gtype="+gtype+"&rtype="+rtype+"&show="+show+"&langx="+langx;
			}
		</script>

	<? }
	if ($rtype=="p3"){
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

				//秀盤面
				showtables(GameFT,GameHead,gamount,top.odd_f_type);

				//顯示盤口
				//body_browse.ChkOddfDiv();


				parent.gamecount=gamount;
				//日期下拉霸

				if (sel_gtype=="BU"){
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
				if(top.ordergid.length != 0){
					for(var i=0;i < top.ordergid.length;i++){
						var obj=top.orderArray["G"+top.ordergid[i]];
						try{
							var classary=(body_browse.document.getElementById(obj.gid+"_"+obj.wtype).className).split("_");
							body_browse.document.getElementById(obj.gid+"_"+obj.wtype).className="pr_"+classary[1];
						}catch(E){}
					}
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


			//表格內容
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
					//--------------判斷聯盟顯示或隱藏----------------
					if (NoshowLeg[ObjDataFT[gamerec].league]==-1){
						//return "";
						onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: none;'");
						//聯盟的小圖
						onelayer=onelayer.replace("*LegMark*","<span id='LegClose'></span>");
					}else{
						onelayer=onelayer.replace("*LegMark*","<span id='LegOpen'></span>");
					}
					//---------------------------------------------------------------------
				}else{
					onelayer=onelayer.replace("*ST*","style='display:;'");

					//--------------判斷聯盟顯示或隱藏----------------
					if (NoshowLeg[ObjDataFT[gamerec].league]==-1){
						onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: none;'");
						onelayer=onelayer.replace("*LegMark*","<span id='LegClose'></span>");
					}else{
						//聯盟的小圖
						onelayer=onelayer.replace("*LegMark*","<span id='LegOpen'></span>");
					}
					//---------------------------------------------------------------------

				}

				var PR_ior =Array();
				var POU_ior =Array();


				PR_ior  = get_other_ioratio("", ObjDataFT[gamerec].ior_PRH   , ObjDataFT[gamerec].ior_PRC   , show_ior);
				POU_ior = get_other_ioratio("", ObjDataFT[gamerec].ior_POUH  , ObjDataFT[gamerec].ior_POUC  , show_ior);

				if((ObjDataFT[gamerec].ior_PO != 0) && (ObjDataFT[gamerec].ior_PE != 0)){
					PEO_ior= get_other_ioratio("H", ObjDataFT[gamerec].ior_PO*1-1 , ObjDataFT[gamerec].ior_PE*1-1 , show_ior);
					ObjDataFT[gamerec].ior_PO=PEO_ior[0]*1+1;
					ObjDataFT[gamerec].ior_PE=PEO_ior[1]*1+1;
				}


				ObjDataFT[gamerec].ior_PRH=PR_ior[0];
				ObjDataFT[gamerec].ior_PRC=PR_ior[1];
				ObjDataFT[gamerec].ior_POUH=POU_ior[0];
				ObjDataFT[gamerec].ior_POUC=POU_ior[1];


				//滾球字眼
				ObjDataFT[gamerec].datetime=ObjDataFT[gamerec].datetime.replace("Running Ball",top.str_RB);
				keepleg=ObjDataFT[gamerec].league;
				onelayer=onelayer.replace(/\*LEG\*/gi,ObjDataFT[gamerec].league);

				var tmp_date=ObjDataFT[gamerec].datetime.split("<br>");
				if (sel_gtype=="BU"){
					tmp_date_str=tmp_date[0]+"<br>"+change_time(tmp_date[1]);
				}else{
					tmp_date_str=change_time(tmp_date[1]);
				}

				onelayer=onelayer.replace("*DATETIME*",tmp_date_str);
				onelayer=onelayer.replace("*TEAM_H*",ObjDataFT[gamerec].team_h.replace("[Mid]","<font color=\"#005aff\">[N]</font>").replace("[中]","<font color=\"#005aff\">[中]</font>"));
				onelayer=onelayer.replace("*TEAM_C*",ObjDataFT[gamerec].team_c);
				//全場

				onelayer=onelayer.replace("*GID_RH*",ObjDataFT[gamerec].gid+"_PRH");
				onelayer=onelayer.replace("*GID_RC*",ObjDataFT[gamerec].gid+"_PRC");

				onelayer=onelayer.replace("*GID_OUH*",ObjDataFT[gamerec].gid+"_POUH");
				onelayer=onelayer.replace("*GID_OUC*",ObjDataFT[gamerec].gid+"_POUC");
				//獨贏
				onelayer=onelayer.replace("*GID_MH*",ObjDataFT[gamerec].gid+"_MH");
				onelayer=onelayer.replace("*GID_MC*",ObjDataFT[gamerec].gid+"_MC");
				if ((ObjDataFT[gamerec].ior_MH*1 > 0) && (ObjDataFT[gamerec].ior_MC*1 > 0)){
					onelayer=onelayer.replace("*RATIO_MH*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"M"));
					onelayer=onelayer.replace("*RATIO_MC*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"M"));
				}else{
					onelayer=onelayer.replace("*RATIO_MH*","&nbsp;");
					onelayer=onelayer.replace("*RATIO_MC*","&nbsp;");
				}
				//讓球
				if (ObjDataFT[gamerec].strong=="H"){
					onelayer=onelayer.replace("*CON_RH*",ObjDataFT[gamerec].ratio);	/*讓球球頭*/
					onelayer=onelayer.replace("*CON_RC*","");
				}else{
					onelayer=onelayer.replace("*CON_RH*","");
					onelayer=onelayer.replace("*CON_RC*",ObjDataFT[gamerec].ratio);
				}


				onelayer=onelayer.replace("*RATIO_RH*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"PR"));/*讓球賠率*/
				onelayer=onelayer.replace("*RATIO_RC*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"PR"));
				//大小
				if (top.langx=="en-us"){
					onelayer=onelayer.replace("*CON_OUC*",ObjDataFT[gamerec].ratio_o.replace("O","o"));	/*大小球頭*/
					onelayer=onelayer.replace("*CON_OUH*",ObjDataFT[gamerec].ratio_u.replace("U","u"));
				}else{
					onelayer=onelayer.replace("*CON_OUC*",ObjDataFT[gamerec].ratio_o.replace("O",top.strOver));	/*大小球頭*/
					onelayer=onelayer.replace("*CON_OUH*",ObjDataFT[gamerec].ratio_u.replace("U",top.strUnder));
				}

				onelayer=onelayer.replace("*RATIO_OUC*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"POU"));/*大小賠率*/
				onelayer=onelayer.replace("*RATIO_OUH*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"POU"));

				//單雙
				/*if (top.langx=="en-us"){
				 onelayer=onelayer.replace("*RATIO_EOO*","<span class=\"con_oe\">"+ObjDataFT[gamerec].str_odd+"&nbsp</span>"+parseUrl(uid,odd_f_type,"O",ObjDataFT[gamerec],gamerec,"EO"));
				 onelayer=onelayer.replace("*RATIO_EOE*","<span class=\"con_oe\">"+ObjDataFT[gamerec].str_even+"&nbsp</span>"+parseUrl(uid,odd_f_type,"E",ObjDataFT[gamerec],gamerec,"EO"));
				 }else{
				 onelayer=onelayer.replace("*RATIO_EOO*","<span class=\"con_oe\">"+ObjDataFT[gamerec].str_odd+"&nbsp</span>"+parseUrl(uid,odd_f_type,"O",ObjDataFT[gamerec],gamerec,"EO"));
				 onelayer=onelayer.replace("*RATIO_EOE*","<span class=\"con_oe\">"+ObjDataFT[gamerec].str_even+"&nbsp</span>"+parseUrl(uid,odd_f_type,"E",ObjDataFT[gamerec],gamerec,"EO"));
				 }*/




				//單雙
				var tmp_ior_po=eval("ObjDataFT[gamerec].ior_PO");
				var tmp_ior_pe=eval("ObjDataFT[gamerec].ior_PE");

				var rario_eoo="";
				var ratio_eoe="";
				onelayer=onelayer.replace("*GID_EOO*",ObjDataFT[gamerec].gid+"_PO");
				onelayer=onelayer.replace("*GID_EOE*",ObjDataFT[gamerec].gid+"_PE");
				if (tmp_ior_po*1 >0 && tmp_ior_pe*1 > 0){
					if (top.langx=="en-us"){
						var rario_eoo="<b>"+top.str_o+"</b>"+" "+parseUrl(uid,top.odd_f_type,"O",ObjDataFT[gamerec],gamerec,"P");
						var ratio_eoe="<b>"+top.str_e+"</b>"+" "+parseUrl(uid,top.odd_f_type,"E",ObjDataFT[gamerec],gamerec,"P");
					}else{
						var rario_eoo=top.strOdd+" "+parseUrl(uid,top.odd_f_type,"O",ObjDataFT[gamerec],gamerec,"P");
						var ratio_eoe=top.strEven+" "+parseUrl(uid,top.odd_f_type,"E",ObjDataFT[gamerec],gamerec,"P");
					}
					onelayer=onelayer.replace("*RATIO_EOO*",rario_eoo);
					onelayer=onelayer.replace("*RATIO_EOE*",ratio_eoe);
				}else{
					onelayer=onelayer.replace("*RATIO_EOO*","&nbsp;");
					onelayer=onelayer.replace("*RATIO_EOE*","&nbsp;");
				}

				//我的最愛
				onelayer=onelayer.replace("*MYLOVE*",parseMyLove(ObjDataFT[gamerec]));
				onelayer=onelayer.replace("*TV*",'');
				//alert(onelayer);
				return onelayer;

			}


			//取得下注的url
			function parseUrl(uid,odd_f_type,betTeam,GameData,gamerec,wtype){
				var urlArray=new Array();
				urlArray['PR']=new Array(eval("GameData.team_"+betTeam.toLowerCase()));
				urlArray['POU']=new Array((betTeam=="C" ? top.strOver : top.strUnder));
				var team="";
				var title_str="";
				if (urlArray[wtype]!=null){
					team=urlArray[wtype][0];
					title_str="title='"+team+"'";
				}
				var tmp_rtype="ior_"+wtype+betTeam;
				var ioratio_str="GameData."+tmp_rtype;
				var bet_rtype=wtype+betTeam;
				if (wtype.indexOf("T") > -1){
					bet_rtype=wtype.substr(1,1)+"~"+wtype.substr(2,1);
				}
				var ioratio=eval(ioratio_str);
				if(eval(ioratio_str)!=""){
					ioratio=Mathfloor(ioratio);
					ioratio=printf(ioratio,2);
				}
				var ret="<a href='javascript:void(0)'  onclick='parent.orderParlay(\""+GameData.gidm+"\",\""+GameData.gid+"\",\""+GameData.hgid+"\",\""+(bet_rtype)+"\",\""+GameData.par_minlimit+"\",\""+GameData.par_maxlimit+"\")' "+title_str+"><font "+check_ioratio(gamerec,tmp_rtype,GameData)+" class='bet_bg_color'>"+ioratio+"</font></a>";
				return ret;
			}
			function Mathfloor(z){
				var tmp_z;
				tmp_z=(Math.floor(z*100+0.01))/100;
				return tmp_z;
			}
			//------------------------新過關變色直接新增功能-------------------max 2010/10
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
				parent.mem_order.betOrder('BK','P3',"teamcount="+top.ordergid.length+"&uid="+top.uid+"&langx="+top.langx+"&"+param);
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

			//下注取得gidm
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
			}</script>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8 "><script>
			var isHot_game = false;//是否為世足賽

			//that body_browse be self


			try{
				if(frame_broke) body_browse = this;
				else 			body_browse = body_browse;
			}catch(e){
				try{ console.log("error body_browse set from FT_mem_Function"); }catch(e){};
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
				if (rtype=="re"||rtype.match("^re")){
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
						if(isHot_game){
							if(top.hot_game!=""){
//								body_browse.document.getElementById("euro_btn").style.display="none";
//								body_browse.document.getElementById("euro_up").style.display="";
							}else{
//								body_browse.document.getElementById("euro_btn").style.display="";
//								body_browse.document.getElementById("euro_up").style.display="none";
							}
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

			//function getCountHOT(){
			//	return recordHash[top.head_gtype+"_HOT_FT"];
			//}
			function keep_show_more(gid,GameFT,gamount){
				if(gid!=''){
					show_more_gid = '';
					for (var j=0;j < gamount;j++){
						if(gid == GameFT[j].gid  && GameFT[j].more != 0){
							//body_browse.showdata.location.reload();
							show_more_gid = gid;
							return;
						}
					}
				}
				body_browse.document.getElementById('more_window').style.display='none';
			}

			function showCleanData(gtype,rtype,show){
				body_browse.location.href="../showCleanData.php?uid="+uid+"&ltype="+ltype+"&gtype="+gtype+"&rtype="+rtype+"&show="+show+"&langx="+langx;
			}
		</script>
	<? }
	if($rtype=='re_all' or $rtype=='re_sub' or $rtype=='re_no' or $rtype=='re_main'){
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

				body_browse.auto_re_addShowLoveI(GameFT);//自動加入單式最愛

				//秀盤面
				showtables(GameFT,GameHead,gamount,top.odd_f_type);

				//body_browse.scroll(0,keepscroll);

				//設定右方重新整理位置
				//setRefreshPos();

				//顯示盤口
				//body_browse.ChkOddfDiv();

				parent.gamecount=gamount;

				//日期下拉霸
				if (sel_gtype=="BU"){
					if (""+body_browse.document.getElementById('g_date')!="undefined"){
						body_browse.selgdate("re",g_date);
						body_browse.document.getElementById('g_date').value=g_date;
					}
				}

				if (top.hot_game!=""){
					body_browse.document.getElementById('sel_league').style.display='none';
					show_page();
				}else{
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
				}
				conscroll.style.display="none";
				coun_Leagues();
				body_browse.showPicLove();
				loadingOK();
				//showHOT(gameCount);
				keep_show_more(show_more_gid,ObjDataFT,gamount);
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
						if (top.swShowLoveI&&tmp_Str!=""&&ObjDataFT[i].isMaster=="Y"){
							chk_Love_I.push(ObjDataFT[i]);
						}
					}
					if (top.hot_game==""){
						if (top.swShowLoveI){
							body_browse.checkLoveCount(chk_Love_I);
						}
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

				//我的最愛
				if (top.hot_game==""){
					if(MM_IdentificationDisplay(ObjDataFT[gamerec].datetime,ObjDataFT[gamerec].gidm)) return "";
				}

				//選擇時節
				//top.BK_RE_session="all/90/8/9/bq"
				if(ObjDataFT[gamerec].gnum_h.length== 6 ) var tmp_num=ObjDataFT[gamerec].gnum_h.charAt(0);
				else var tmp_num = "90";

				if(""+top.BK_RE_session=="undefined")	 top.BK_RE_session="all";

				if (top.BK_RE_session!="all"){

					if (top.BK_RE_session=="bq"){
						//取第一碼不為8 9 90
						if (tmp_num=="8"|| tmp_num=="9" || tmp_num=="90") return "";

					}else{

						//取第一碼相同者
						if (top.BK_RE_session!=tmp_num) return "";

					}
				}

				if (!top.swShowLoveI){

					if (top.hot_game==""){
						if(("|"+eval('parent.'+sel_gtype+'_lname_ary_RE')).indexOf(("|"+ObjDataFT[gamerec].league+"|"),0)==-1&&eval('parent.'+sel_gtype+'_lname_ary_RE')!='ALL') return "";

						if((""+LeagueAry).indexOf(ObjDataFT[gamerec].league)== -1)LeagueAry.push(ObjDataFT[gamerec].league);
					}
				}

				var tmp_date = ObjDataFT[gamerec].datetime.split("<br>")[0];
				onelayer=onelayer.replace(/\*ID_STR\*/g,tmp_date+ObjDataFT[gamerec].gidm+"-"+ObjDataFT[gamerec].gnum_h);
				onelayer=onelayer.replace(/\*TR_EVENT\*/g,"onMouseOver='mouseEnter_pointer(\"TR_"+tmp_date+ObjDataFT[gamerec].gidm+"\");' onMouseOut='mouseOut_pointer(\"TR_"+tmp_date+ObjDataFT[gamerec].gidm+"\");'");

				if (""+myLeg[ObjDataFT[gamerec].league]=="undefined"){
					myLeg[ObjDataFT[gamerec].league]=ObjDataFT[gamerec].league;
					myLeg[ObjDataFT[gamerec].league]=new Array();
					myLeg[ObjDataFT[gamerec].league][0]=tmp_date+ObjDataFT[gamerec].gidm+"-"+ObjDataFT[gamerec].gnum_h;
				}else{
					//if(!lib_inArray(myLeg[ObjDataFT[gamerec].league],tmp_date+ObjDataFT[gamerec].gidm)) myLeg[ObjDataFT[gamerec].league][myLeg[ObjDataFT[gamerec].league].length]=tmp_date+ObjDataFT[gamerec].gidm;+"-"+ObjDataFT[gamerec].gnum_h;
					myLeg[ObjDataFT[gamerec].league][myLeg[ObjDataFT[gamerec].league].length]=tmp_date+ObjDataFT[gamerec].gidm+"-"+ObjDataFT[gamerec].gnum_h;
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
				//var EO_ior =Array();
				var OUH_ior = Array();
				var OUC_ior = Array();

				R_ior  = get_other_ioratio(odd_f_type, ObjDataFT[gamerec].ior_RH   , ObjDataFT[gamerec].ior_RC   , show_ior);
				OU_ior = get_other_ioratio(odd_f_type, ObjDataFT[gamerec].ior_OUH  , ObjDataFT[gamerec].ior_OUC  , show_ior);
				OUH_ior = get_other_ioratio(odd_f_type,ObjDataFT[gamerec].ior_OUHO,ObjDataFT[gamerec].ior_OUHU,show_ior);
				OUC_ior = get_other_ioratio(odd_f_type,ObjDataFT[gamerec].ior_OUCO,ObjDataFT[gamerec].ior_OUCU,show_ior);
				/*
				 if((ObjDataFT[gamerec].ior_EOO != 0) && (ObjDataFT[gamerec].ior_EOE != 0)){
				 EO_ior= get_other_ioratio("H", ObjDataFT[gamerec].ior_EOO*1-1 , ObjDataFT[gamerec].ior_EOE*1-1 , show_ior);
				 ObjDataFT[gamerec].ior_EOO=(EO_ior[0]*1000+1000)/1000;
				 ObjDataFT[gamerec].ior_EOE=(EO_ior[1]*1000+1000)/1000;
				 }
				 */
				ObjDataFT[gamerec].ior_RH=R_ior[0];
				ObjDataFT[gamerec].ior_RC=R_ior[1];
				ObjDataFT[gamerec].ior_OUH=OU_ior[0];
				ObjDataFT[gamerec].ior_OUC=OU_ior[1];
				ObjDataFT[gamerec].ior_OUHO=OUH_ior[0];
				ObjDataFT[gamerec].ior_OUHU=OUH_ior[1];
				ObjDataFT[gamerec].ior_OUCO=OUC_ior[0];
				ObjDataFT[gamerec].ior_OUCU=OUC_ior[1];
				//盤口賠率 end

				//上、下半的賽程要有不同的底色
				if(chk_half(ObjDataFT[gamerec].team_h)){
					onelayer=onelayer.replace(/\*CLASS\*/g,"class='b_1st'");
				}

				//滾球字眼
				ObjDataFT[gamerec].datetime=ObjDataFT[gamerec].datetime.replace("Running Ball",top.str_RB);
				ObjDataFT[gamerec].timer=ObjDataFT[gamerec].timer.replace("<font style=background-color=red>","").replace("</font>","");
				keepleg=ObjDataFT[gamerec].league;
				onelayer=onelayer.replace(/\*LEG\*/gi,ObjDataFT[gamerec].league);



				onelayer=onelayer.replace("*DATETIME*",change_time(ObjDataFT[gamerec].timer));
				onelayer=onelayer.replace("*TEAM_H*",ObjDataFT[gamerec].team_h.replace("[Mid]","<font color=\"#005aff\">[N]</font>").replace("[中]","<font color=\"#005aff\">[中]</font>"));
				onelayer=onelayer.replace("*TEAM_C*",ObjDataFT[gamerec].team_c);


				if (ObjDataFT[gamerec].isMaster=="Y"){
					//Q1,Q2,Q3 se
					var se_now = ObjDataFT[gamerec].nowSession;
					var lastT = ObjDataFT[gamerec].lastTime*1;
					if(top.langx!="en-us" ){
						if(se_now=="HT")str_se_now =top.statu[se_now];
						else if(se_now=="OT")str_se_now=top.str_BK_OT;
						else if(se_now.charAt(0)=="H")str_se_now=top.str_BK_MS[se_now.charAt(1)*1];
						else {
							tmp_ms = se_now.charAt(1)*1+2;
							str_se_now = top.str_BK_MS[tmp_ms];
						}
					}
					else{
						if(se_now=="H1")str_se_now= "1H";
						else if(se_now=="H2")str_se_now= "2H";
						else str_se_now= se_now;
					}
					//00:00  rb_time

					if(isNaN(lastT)||lastT<0)lastT=0;
					var TimeM= Math.floor(lastT/60);
					var TimeS= lastT%60;
					if(TimeM<10)TimeM="0"+TimeM;
					if(TimeS<10)TimeS="0"+TimeS;
					rb_time = TimeM+":"+TimeS;
					if(se_now=="HT")rb_time="";
					//secore
					scoreH = (ObjDataFT[gamerec].lastGoal=="H")?createSpanClass(ObjDataFT[gamerec].scoreH,"bk_color"):ObjDataFT[gamerec].scoreH;
					scoreC = (ObjDataFT[gamerec].lastGoal=="A")?createSpanClass(ObjDataFT[gamerec].scoreC,"bk_color"):ObjDataFT[gamerec].scoreC;


					onelayer=onelayer.replace("*SE*",str_se_now);
					onelayer=onelayer.replace("*RB_TIME*",rb_time);
					onelayer=onelayer.replace("*SCORE*",scoreH+" - "+scoreC);
				}else{
					onelayer=onelayer.replace("*SE*","");
					onelayer=onelayer.replace("*RB_TIME*","");
					onelayer=onelayer.replace("*SCORE*","");
					onelayer=onelayer.replace("rb_box","");

				}

				//全場

				//獨贏
				if ((ObjDataFT[gamerec].ior_MH*1 > 0) && (ObjDataFT[gamerec].ior_MC*1 > 0)){
					onelayer=onelayer.replace("*RATIO_MH*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"M"));
					onelayer=onelayer.replace("*RATIO_MC*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"M"));
				}else{
					onelayer=onelayer.replace("*RATIO_MH*","&nbsp;");
					onelayer=onelayer.replace("*RATIO_MC*","&nbsp;");
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
					onelayer=onelayer.replace("*CON_OUH*",ObjDataFT[gamerec].ratio_o.replace("O","o"));	/*大小球頭*/
					onelayer=onelayer.replace("*CON_OUC*",ObjDataFT[gamerec].ratio_u.replace("U","u"));
				}else{
					onelayer=onelayer.replace("*CON_OUH*",ObjDataFT[gamerec].ratio_o.replace("O",top.strOver));	/*大小球頭*/
					onelayer=onelayer.replace("*CON_OUC*",ObjDataFT[gamerec].ratio_u.replace("U",top.strUnder));
				}

				onelayer=onelayer.replace("*RATIO_OUH*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"OU"));/*大小賠率*/
				onelayer=onelayer.replace("*RATIO_OUC*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"OU"));
				/*
				 if (top.langx=="en-us"){
				 onelayer=onelayer.replace("*RATIO_EOO*","<span class=\"con_oe\">"+ObjDataFT[gamerec].str_odd+"&nbsp</span>"+parseUrl(uid,odd_f_type,"O",ObjDataFT[gamerec],gamerec,"EO"));
				 onelayer=onelayer.replace("*RATIO_EOE*","<span class=\"con_oe\">"+ObjDataFT[gamerec].str_even+"&nbsp</span>"+parseUrl(uid,odd_f_type,"E",ObjDataFT[gamerec],gamerec,"EO"));
				 }else{
				 onelayer=onelayer.replace("*RATIO_EOO*","<span class=\"con_oe\">"+ObjDataFT[gamerec].str_odd+"&nbsp</span>"+parseUrl(uid,odd_f_type,"O",ObjDataFT[gamerec],gamerec,"EO"));
				 onelayer=onelayer.replace("*RATIO_EOE*","<span class=\"con_oe\">"+ObjDataFT[gamerec].str_even+"&nbsp</span>"+parseUrl(uid,odd_f_type,"E",ObjDataFT[gamerec],gamerec,"EO"));
				 }
				 */
				//全場總局數
				if(top.langx == "en-us"){
					onelayer = onelayer.replace("*CON_OUHO*",ObjDataFT[gamerec].ratio_ouho.replace("O","<font class=\"text_green\">o</font>"));/*大小球頭*/
					onelayer = onelayer.replace("*CON_OUHU*",ObjDataFT[gamerec].ratio_ouhu.replace("U","<font class=\"text_brown\">u</font>"));
					onelayer = onelayer.replace("*CON_OUCO*",ObjDataFT[gamerec].ratio_ouco.replace("O","<font class=\"text_green\">o</font>"));/*大小球頭*/
					onelayer = onelayer.replace("*CON_OUCU*",ObjDataFT[gamerec].ratio_oucu.replace("U","<font class=\"text_brown\">u</font>"));
				}else{
					onelayer = onelayer.replace("*CON_OUHO*",ObjDataFT[gamerec].ratio_ouho.replace("O","<font class=\"text_green\">"+top.strOver+"</font>"));/*大小球頭*/
					onelayer = onelayer.replace("*CON_OUHU*",ObjDataFT[gamerec].ratio_ouhu.replace("U","<font class=\"text_brown\">"+top.strUnder+"</font>"));
					onelayer = onelayer.replace("*CON_OUCO*",ObjDataFT[gamerec].ratio_ouco.replace("O","<font class=\"text_green\">"+top.strOver+"</font>"));/*大小球頭*/
					onelayer = onelayer.replace("*CON_OUCU*",ObjDataFT[gamerec].ratio_oucu.replace("U","<font class=\"text_brown\">"+top.strUnder+"</font>"));
				}

				onelayer = onelayer.replace("*RATIO_OUHO*",parseUrl(uid,odd_f_type,"O",ObjDataFT[gamerec],gamerec,"OUH"));/*大小賠率*/
				onelayer = onelayer.replace("*RATIO_OUHU*",parseUrl(uid,odd_f_type,"U",ObjDataFT[gamerec],gamerec,"OUH"));
				onelayer = onelayer.replace("*RATIO_OUCO*",parseUrl(uid,odd_f_type,"O",ObjDataFT[gamerec],gamerec,"OUC"));
				onelayer = onelayer.replace("*RATIO_OUCU*",parseUrl(uid,odd_f_type,"U",ObjDataFT[gamerec],gamerec,"OUC"));

				onelayer=onelayer.replace("*MORE*",parseAllBets(ObjDataFT[gamerec],game_more));

				//我的最愛
				onelayer=onelayer.replace("*MYLOVE*",parseMyLove(ObjDataFT[gamerec]));
				ObjDataFT[gamerec].eventid = "123456";ObjDataFT[gamerec].play = "Y";
				if (ObjDataFT[gamerec].eventid != "" && ObjDataFT[gamerec].eventid != "null" && ObjDataFT[gamerec].eventid != undefined) {	//判斷是否有轉播
					tmpStr= VideoFun(ObjDataFT[gamerec].eventid, ObjDataFT[gamerec].hot, ObjDataFT[gamerec].play, "BK");
					onelayer=onelayer.replace("*TV*",tmpStr);
				}
				onelayer=onelayer.replace("*TV*","");

				return onelayer;
			}

			//取得下注的url
			function parseUrl(uid,odd_f_type,betTeam,GameData,gamerec,wtype){
				var urlArray=new Array();
				urlArray['R']=new Array("../BK_order/BK_order_re.php",eval("GameData.team_"+betTeam.toLowerCase()));
				urlArray['OU']=new Array("../BK_order/BK_order_rou.php",(betTeam=="C" ? top.strOver : top.strUnder));
				urlArray['EO']=new Array("../BK_order/BK_order_rt.php", (betTeam=="O"  ? top.str_o : top.str_e));
				urlArray['M']=new Array("../BK_order/BK_order_m.php",(betTeam=="N" ? top.str_irish_kiss : eval("GameData.team_"+betTeam.toLowerCase())));
				urlArray['OUH'] = new Array("../BK_order/BK_order_rouhc.php",(betTeam=="O"?top.strOver:top.strUnder));
				urlArray['OUC'] = new Array("../BK_order/BK_order_rouhc.php",(betTeam=="O"?top.strOver:top.strUnder));

				var rewtype = new Array();
				rewtype['R'] = "RE";
				rewtype['OU'] = "ROU";
				rewtype['EO'] = "REO";
				rewtype['M'] = "RM";
				rewtype['OUH'] = "ROUH";
				rewtype['OUC'] = "ROUC";


				var param=getParam(uid,odd_f_type,betTeam,wtype,GameData);
				var order=urlArray[wtype][0];
				var team=urlArray[wtype][1].replace("<font color=gray>","").replace("</font>","").replace("[Mid]","[N]");
				var tmp_rtype="ior_"+wtype+betTeam;
				var ioratio_str="GameData."+tmp_rtype;

				var ioratio=eval(ioratio_str);


				if(eval(ioratio_str)!=""){
					ioratio=Mathfloor(ioratio);
					ioratio=printf(ioratio,2);
				}


				//20121023 max新增 輸水盤 負值顯示藍色
				if (odd_f_type=="M" || odd_f_type=="I"){
					if (ioratio<0) ioratio="<font color=#1f497d>"+ioratio+"</font>";
				}

				var ret="<a href='javascript://' onclick=\"parent.parent.mem_order.betOrder('BK','"+rewtype[wtype]+"','"+param+"');\" title='"+team+"'><font "+check_ioratio(gamerec,tmp_rtype,GameData)+" class='bet_bg_color'>"+ioratio+"</font></a>";

				return ret;
			}
			function Mathfloor(z){
				var tmp_z;
				tmp_z=(Math.floor(z*100+0.01))/100;
				return tmp_z;
			}
			//--------------------------public function --------------------------------

			//取得下注參數
			function getParam(uid,odd_f_type,betTeam,wtype,GameData){
				var paramArray=new Array();
				paramArray['R']=new Array("gid","uid","odd_f_type","type","gnum","strong","langx");
				paramArray['OU']=new Array("gid","uid","odd_f_type","type","gnum","langx");
				paramArray['EO']=new Array("gid","uid","odd_f_type","rtype","langx");
				paramArray['M']=new Array("gid","uid","odd_f_type","type","gnum","langx");
				paramArray["OUH"] = new Array("gid","uid","odd_f_type","wtype","type","langx");
				paramArray["OUC"] = new Array("gid","uid","odd_f_type","wtype","type","langx");


				var param="";
				var gid=((wtype=="R"||wtype=="OU"||wtype=="M"||wtype=="EO"||wtype=="OUH"||wtype=="OUC") ? GameData.gid : GameData.hgid);
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

			function parsemore(GameData,g_more){
				var ret="";
				if(g_more=='0'||GameData.more=='0'){
					ret="&nbsp;";
				}else{
					ret="<A href=javascript: onClick=parent.show_more('"+GameData.gid+"',event);>"+"<font class='total_color'>+"+GameData.more+"&nbsp;</font>"+str_more+"</A>";
				}
				return ret;
			}
			function parseAllBets(GameData,g_more){
				var ret="";
				if(g_more=='0'||GameData.more=='0'){
					ret="&nbsp;";
				}else{
					var datetime = GameData.datetime.split("<br>");
					ret="<A href=javascript: onClick=parent.show_allbets('"+GameData.gid+"',event,'"+datetime[0]+"');><font class='total_color'>"+top.str_all_bets+" ("+GameData.more+")</font></A>";
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

			function show_allbets(gid,evt,datetime){
				evt = evt ? evt : (window.event ? window.event : null);
				var mY = evt.pageY ? evt.pageY : evt.y;

				top.browse_ScrollY = getScroll(body_browse);//body_browse.scrollY;
				body_browse.document.getElementById('box').style.display="none";

//				body_browse.document.getElementById('refresh_right').style.display="none";
//				body_browse.document.getElementById('refresh_down').style.display="none";
				body_browse.document.getElementById('MBK').className="more_bar";

				body_browse.document.getElementById('more_window').style.position='absolute';
				body_browse.document.getElementById('more_window').style.top="0px";
				body_browse.document.getElementById('more_window').style.left="0px";
				show_more_gid = gid;
				retime_flag = "N";

				if(typeof(top.more_fave_wtype) == "undefined" ) top.more_fave_wtype = new Array();
				if(typeof(top.more_fave_wtype[show_more_gid]) == "undefined" ) top.more_fave_wtype[show_more_gid] = new Array();
				var gate = new Date();
				datetime = (gate.getFullYear())+"-"+datetime
				var  url="body_var_re_allbets.php?gid="+gid+"&uid="+uid+"&ltype="+ltype+"&langx="+top.langx+"&gtype=BK&date="+datetime;
				body_browse.showdata.location.href = url;

			}
			function getScroll(frameObj){
				return body_browse.scrollY || body_browse.document.body.scrollTop ;
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
			function chk_half(str){
				if(str.indexOf("<font color=gray>") > -1) return true;
				return false;
			}

			function parseMore(GameData,g_more){
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
				body_browse.document.getElementById('more_window').style.left=body_browse.document.body.scrollLeft+10;
				show_more_gid = gid;
				var  url="body_var_re_more.php?gid="+gid+"&uid="+uid+"&ltype="+ltype+"&langx="+top.langx;
				body_browse.showdata.location.href = url;
			}
			function createFontColor(str,aColor){
				return "<font color='"+aColor+"'>"+str+"</font>";
			}
			function createSpanClass(str,aclass){
				return "<span class='"+aclass+"'>"+str+"</span>";
			}
			function lib_inArray(arr,adata){
				for(keys in arr){
					if(arr[keys]==adata) return true;
				}
				return false;
			}</script>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8 "><script>
			var isHot_game = false;//是否為世足賽

			//that body_browse be self


			try{
				if(frame_broke) body_browse = this;
				else 			body_browse = body_browse;
			}catch(e){
				try{ console.log("error body_browse set from FT_mem_Function"); }catch(e){};
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
				if (rtype=="re"||rtype.match("^re")){
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
							body_browse.reload_var("");
						}
					}else{
						if(isHot_game){
							if(top.hot_game!=""){
//								body_browse.document.getElementById("euro_btn").style.display="none";
//								body_browse.document.getElementById("euro_up").style.display="";
							}else{
//								body_browse.document.getElementById("euro_btn").style.display="";
//								body_browse.document.getElementById("euro_up").style.display="none";
							}
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

			//function getCountHOT(){
			//	return recordHash[top.head_gtype+"_HOT_FT"];
			//}
			function keep_show_more(gid,GameFT,gamount){
				if(gid!=''){
					show_more_gid = '';
					for (var j=0;j < gamount;j++){
						if(gid == GameFT[j].gid  && GameFT[j].more != 0){
							//body_browse.showdata.location.reload();
							show_more_gid = gid;
							return;
						}
					}
				}
				body_browse.document.getElementById('more_window').style.display='none';
			}

			function showCleanData(gtype,rtype,show){
				body_browse.location.href="../showCleanData.php?uid="+uid+"&ltype="+ltype+"&gtype="+gtype+"&rtype="+rtype+"&show="+show+"&langx="+langx;
			}
		</script>

	<? }?>
	<SCRIPT LANGUAGE="JAVASCRIPT">
		<!--
		if(self == top) location='/app/member/';

		var username='';
		var maxcredit='';
		var code='';
		var uid='<?=$uid?>';
		var pg=0;
		var uid=''; //user's session ID
		var loading = 'Y'; //是否正在讀取瀏覽頁面
		var loading_var = 'Y'; //是否正在讀取變數值頁面
		var ShowType = ''; //目前顯示頁面
		var ltype = 1; //目前顯示line
		var retime_flag = 'Y'; //自動更新旗標
		var retime = 0; //自動更新時間

		var str_even = '和局';
		var str_renew = '秒自動更新';
		var str_submit = '確認';
		var str_reset = '重設';
		var num_page = 20; //設定20筆賽程一頁
		var now_page = 1; //目前顯示頁面
		var pages = 1; //總頁數
		var msg = ''; //即時資訊
		var gamount = 0; //目前顯示一般賽程數
		var GameFT = new Array(512); //最多設定顯示512筆開放賽程
		for(var i=0; i<512; i++){
			GameFT[i] = new Array(34); //為各賽程宣告 34 個欄位
		}
		var sel_gtype='BK';
		var iorpoints=2;
		var GameHead=new Array();
		var show_more_gid = '';


		//
		//
		// -->
	</SCRIPT>
</head>
<frameset rows="0,*" frameborder="NO" border="0" framespacing="0">
	<frame name="body_var" scrolling="NO" noresize src="body_var.php?uid=<?=$uid?>&rtype=<?php echo $rtype?>&langx=<?=$langx?>&mtype=<?=$mtype?>&league_id=<?=$league_id?>">
	<frame name="body_browse" src="body_browse.php?uid=<?=$uid?>&rtype=<?=$rtype?>&langx=<?=$langx?>&mtype=<?=$mtype?>">
</frameset>
<noframes>   <body bgcolor="#000000">

	</body></noframes>
</html>


