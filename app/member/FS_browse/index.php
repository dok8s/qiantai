<?
include "../include/library.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");



echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
$mtype=$_REQUEST['mtype'];
$rtype=ltrim(strtolower($_REQUEST['rtype']));

$sql = "select language from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}

if ($rtype==""){
	$rtype="r";
}
?>
<html>
<head>
<title>下注分割畫面</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script>
// --== 此 JS 與子站不同 , 不能互丟 ==--

var IDBuffer = new Array();		// 記錄所要開啟的冠軍盤面
var setLeague = "";				// 記錄盤面是否有選取聯盟, 做預設是否盤面全開功能用
var sorLeagID = "";				// 記錄目前所選擇的聯盟 ID
var defaultOpen = true;			// 預設盤面顯示全縮 或是 全打開
	
function ShowGameList(){
	if(loading == 'Y') return;
	obj_msg = body_browse.document.getElementById('real_msg');
	obj_msg.innerHTML = '<marquee scrolldelay=\"120\">'+msg+'</marquee>';
	game_table = body_browse.document.getElementById('game_table');
	setLeague = body_browse.document.getElementById('sel_lid').value;	// 盤面所選的聯盟 (未選取時所代入的值為空)
	
	// 當有指定或是更換選取的聯盟時, 預設將此聯盟的 ID 全加入 IDBuffer
	// 若聯盟選回全部時, 則將 IDBuffer 值清空, 預設不帶入任何聯盟 ID
	if(setLeague != sorLeagID) {
		sorLeagID = setLeague;
		IDBuffer.length = 0;
		if(setLeague && !defaultOpen) for(i=0; i<gamount; i++) IDBuffer.push(GameFT[i][0]);
	}
	ShowData_FS(game_table,GameFT,gamount);
}

//------特殊賽程顯示------
function ShowData_FS(obj_table,GameData,data_amount){
	var nowLeague = "";
	var nowDate = "";

	with(obj_table){
		//清除table資料
		while(rows.length > 1) {deleteRow(rows.length-1);}

		//開始顯示開放中賽程資料
		for(i=0; i<data_amount; i++){
			
			// 若無賠率時, 不顯示聯盟
			if(GameData[i][2] == 0) continue;
			
			//顯示聯盟
			gdate = GameData[i][1].substr(0,5);
			nowLeague = GameData[i][3];
			nowDate = gdate;
			nowTR = insertRow();
			with(nowTR){
				nowTD = insertCell();
				nowTD.colSpan = 18;
				nowTD.className = "b_hline";
				nowTD.innerHTML = "<font style='cursor: hand' onClick='parent.getID(\""+GameData[i][0]+"\", \""+setLeague+"\"); parent.ShowGameList();'>"+GameData[i][3]+"</font>";
			}
			
			if(chkShow(GameData[i][0])) {		// 判斷盤面所要顯示的類別
				for(t=0; t<GameData[i][2]; t++){
					_offset = t*3+4;
					nowTR = insertRow();
					nowTR.className = "b_cen";
					with(nowTR){
						nowTD = insertCell();
						nowTD.Align = "left";
						nowTD.innerHTML = GameData[i][_offset];
						nowTD = insertCell();
						nowTD.Align = "left";
						nowTD.innerHTML = "<a href=\"../FT_order/FT_order_fs.php?gametype="+GameData[i][(GameData[i].length-1)]+"&gid="+GameData[i][0]+"&uid="+uid+"&tid="+GameData[i][_offset+2]+"\" target=\"mem_order\">"+GameData[i][_offset+1]+"</A>";
					}//主隊TR結束
				}
			}
			nowTR = insertRow();
			with(nowTR){
				nowTD = insertCell();
				nowTD.colSpan = 18;
				nowTD.height = 1;
			}//分隔線TR
		}
	}//with(obj_table);
}//顯示特殊賽程結束

function getID(showID, LeagID) {
	var i, tmpFlag = false;
	var tmpArr = new Array();
	
	// 判斷值是否已含在陣列裡
	for(i=0; i<IDBuffer.length; i++) if(IDBuffer[i] == showID) tmpFlag = true;
	
	if(!tmpFlag) IDBuffer.push(showID);
	else {
		for(i=0; i<IDBuffer.length; i++) if(IDBuffer[i] != showID) tmpArr.push(IDBuffer[i]);
		IDBuffer = tmpArr;
	}
}

// 傳回是否開啟此聯盟的盤面, 當盤面有指定聯盟時, 將所記錄的值清空, 並預設全開盤
function chkShow(showID) {
	var i = 0, tmpFlag = (defaultOpen)? true: false;
	for(i=0; i<IDBuffer.length; i++) if(showID == IDBuffer[i]) {tmpFlag = (defaultOpen)? false: true; break;}
	return tmpFlag;
}</script>
<!--SCRIPT language=javaScript src="/js/FT_mem_showgame_fs.js" type=text/javascript></SCRIPT-->
<SCRIPT LANGUAGE="JAVASCRIPT">
<!--
 if(self == top) location='<?=BROWSER_IP?>/app/member/';

 var username='';
 var maxcredit='';
 var code='';

 var sel_league=''; //選擇顯示聯盟
 var uid=''; //user's sesSI2on ID
 var loading = 'Y'; //是否正在讀取瀏覽頁面
 var loading_var = 'Y'; //是否正在讀取變數值頁面
 var ShowType = ''; //目前顯示頁面
 var ltype = 1; //目前顯示line
 var retime_flag = 'N'; //自動更新旗標
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
 //for(var i=0; i<512; i++){
 //	GameFT[i] = new Array(34); //為各賽程宣告 34 個欄位
 //}
 
 // -->
</SCRIPT>

</head>
<frameset rows="0,*" frameborder="NO" border="0" framespacing="0">
  <frame name="body_var" scrolling="NO" noreSI2ze src="body_var.php?uid=<?=$uid?>&rtype=fs&langx=<?=$langx?>&mtype=<?=$mtype?>&delay=">
  <frame name="body_browse" src="body_browse.php?uid=<?=$uid?>&rtype=fs&langx=<?=$langx?>&mtype=<?=$mtype?>&delay=">
</frameset>
<noframes><body bgcolor="#000000">

</body></noframes>
</html>

