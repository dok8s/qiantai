<?
session_start();
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");          
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include "../include/address.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/curl_http.php");
$uid=$_REQUEST['uid'];
$langx=$_SESSION['langx'];
$FStype=$_REQUEST['FStype'];
$rtype=ltrim(strtolower($_REQUEST['rtype']));
$league_id=$_REQUEST['league_id'];
//require ("../include/traditional.$langx.inc.php");
if ($rtype==""){
	$rtype="FS";
}
$sql = "select * from web_member where Oid='$uid' and Status=0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
$username=$row['UserName'];
mysql_close();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<meta http-equiv='Page-Exit' content='revealTrans(Duration=0,Transition=5)'>
<link rel="stylesheet" href="/style/member/mem_body_ft.css" type="text/css">
<link rel="stylesheet" href="/style/member/mem_body_fs.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8 "><script>
top.str_input_pwd = "密碼請務必輸入!!";
top.str_input_repwd = "確認密碼請務必輸入!!";
top.str_err_pwd = "密碼確認錯誤,請重新輸入!!";
top.str_pwd_limit = "您的密碼必須至少6個字元長，最多12個字元長，並只能是數字，英文字母等符號，其他的符號都不能使用!!";
top.str_pwd_limit2 = "您的密碼需使用字母加上數字!!";
top.str_pwd_NoChg = "您的密碼未做任何變更!!";
top.str_input_longin_id = "登錄帳號請務必輸入!!";
top.str_longin_limit1 = "登錄帳號最少必須有2個英文大小寫字母和數字(0~9)組合輸入限制(6~12字元)";
top.str_longin_limit2 = "您的登錄帳號需使用字母加上數字!!";
top.str_o="單";
top.str_e="雙";
top.str_checknum="驗證碼錯誤,請重新輸入";
top.str_irish_kiss="和";
top.dPrivate="私域";
top.dPublic="公有";
top.grep="群組";
top.grepIP="群組IP";
top.IP_list="IP列表";
top.Group="組別";
top.choice="請選擇";
top.account="請輸入帳號!!";
top.password="請輸入密碼!!";
top.S_EM="特早";
top.alldata="全部";
top.webset="資訊網";
top.str_renew="更新";
top.outright="冠軍";
top.financial="金融";
top.str_HCN = new Array("主","客","無");

//====== Live TV
top.str_FT = "足球";
top.str_BK = "籃球";
top.str_TN = "網球";
top.str_VB = "排球";
top.str_BS = "棒球";
top.str_OP = "其他";

top.str_fs_FT = "足球 : ";
top.str_fs_BK = "籃球和美式足球 : ";
top.str_fs_TN = "網球 : ";
top.str_fs_VB = "排球 : ";
top.str_fs_BS = "棒球 : ";
top.str_fs_OP = "其他體育 : ";

top.str_game_list = "所有球類";
top.str_second = "秒";
top.str_demo = "樣本播放";
top.str_alone = "獨立";
top.str_back = "返回";
top.str_RB = "LIVE";

top.str_ShowMyFavorite="我的最愛";
top.str_ShowAllGame="全部賽事";
top.str_delShowLoveI="移出";


top.strRtypeSP = new Array();
top.strRtypeSP["PGF"]="最先進球";
top.strRtypeSP["OSF"]="最先越位";
top.strRtypeSP["STF"]="最先替補球員";
top.strRtypeSP["CNF"]="第一顆角球";
top.strRtypeSP["CDF"]="第一張卡";
top.strRtypeSP["RCF"]="會進球";
top.strRtypeSP["YCF"]="第一張黃卡";
top.strRtypeSP["GAF"]="有失球";
top.strRtypeSP["PGL"]="最後進球";
top.strRtypeSP["OSL"]="最後越位";
top.strRtypeSP["STL"]="最後替補球員";
top.strRtypeSP["CNL"]="最後一顆角球";
top.strRtypeSP["CDL"]="最後一張卡";
top.strRtypeSP["RCL"]="不會進球";
top.strRtypeSP["YCL"]="最後一張黃卡";
top.strRtypeSP["GAL"]="沒有失球";
top.strRtypeSP["PG"]="最先/最後進球球隊";
top.strRtypeSP["OS"]="最先/最後越位球隊";
top.strRtypeSP["ST"]="最先/最後替補球員球隊";
top.strRtypeSP["CN"]="第一顆/最後一顆角球";
top.strRtypeSP["CD"]="第一張/最後一張卡";
top.strRtypeSP["RC"]="會進球/不會進球";
top.strRtypeSP["YC"]="第一張/最後一張黃卡";
top.strRtypeSP["GA"]="有失球/沒有失球";


top.strOver="大";
top.strUnder="小";
top.strOdd="單";
top.strEven="雙";


//下注警語
top.message001="請輸入下注金額。";
top.message002="只能輸入數字!!";
top.message003="最低投注額是";
top.message004="對不起,本場有下注金額最高: ";
top.message005=" 元限制!!";
top.message006="最高投注額設在";
top.message007="總下注金額已超過單場限額。";
top.message008="本場累計下注共: ";
top.message009="\n總下注金額已超過單場限額";
top.message010="下注金額不可大於信用額度。";
top.message011="可贏金額：";
top.message012="<br>確定進行下注嗎?";
top.message013="確定進行下注嗎?<br>";
top.message014='未輸入下注金額!!!';
top.message015="下注金額只能輸入數字";
top.message016="\n\n確定進行下注嗎?";
top.message017="串1";
top.message018="隊聯碰";
top.message019="您必須選擇至少";
top.message020="個隊伍,否則不能下注!!";
top.message021="不接受";
top.message022="串過關投注!!";
top.message023="請輸入欲下注金額!!";
top.message024="已超過某場次之過關注單限額!!";
top.message025="下注金額不可大於信用額度。";
top.message026="請選擇下注隊伍!!";
top.message027="單式投注請至單式下注頁面下注!!";
top.message028="僅接受";
top.message029="串投注!!";
top.message030="確定要進行交易嗎？";


top.page="頁";
top.refreshTime="刷新";
top.showmonth="月";
top.showday="日";

top.str_RB ="滾球";
top.Half1st="上半滾球";
top.Half2nd="下半滾球";

top.mem_logut="您的帳號已登出";
top.retime1H="上";
top.retime2H="下";


top.str_otb_close="賽事已關閉。";</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8 "><script>

var Showtypes="R";
var ordersR=new Array();
var ordersOU=new Array();
var keep_rs_windows="";
var se="90";
var sessions="2";
var keep_action1="";
var keep_leg="";
var Ratio=new Array();
var defaultOpen = true;         // 預設盤面顯示全縮 或是 全打開
var NoshowLeg=new Array();
function showgame_table(){
    
    init();
    //obj_msg = document.getElementById('real_msg');
    //obj_msg.innerHTML = '<marquee scrolldelay=\"300\">'+msg+'</marquee>';
    var tmp_outright='';
    if(parent.rtype=='fs'){
        tmp_outright=eval("top.str_fs_"+FStype)+top.outright;
    }else{
        tmp_outright=top.financial;
    }
    obj_TMP_ITEM = document.getElementById('tmp_TMP_ITEM');
    obj_TMP_ITEM.innerHTML=tmp_outright;
    
    start_time=get_timer();
    var AllLayer="";
    var layers="";
    var shows=showlayers.innerHTML;
    var tr_data="";
    if(document.all){
        
            tr_data=document.getElementById('glist').innerText;
            notrdata=document.getElementById('NoDataTR').innerText;
    } else{

            tr_data=document.getElementById('glist').textContent;
            notrdata=document.getElementById('NoDataTR').textContent;
    }
    
//  var tr_data=document.getElementById('glist').innerHTML;
    doings="";
    keep_leg="";
    for (i=0;i<gamount;i++){
        gid=GameFT[i][0];
        AllLayer+=layer_screen(gid,tr_data);
        
    }
    if(AllLayer=="")AllLayer=notrdata;
    showgames.innerHTML=shows.replace("*ShowGame*",AllLayer);
    
    
    
    if (defaultOpen){
        for (i=0;i<gamount;i++){
            gid=GameFT[i][0];
            leg=GameFT[i][2];
            //alert(NoshowLeg[gid])
            if (NoshowLeg[gid+"_"+leg]*1==-1){
                document.getElementById('TR'+gid).style.display="none";
                document.getElementById('TR_1_'+gid).style.display="none";
                //document.getElementById(leg).innerHTML="<span id='LegClose'></span>";             

            }else{
                //document.getElementById(leg).innerHTML="<span id='LegOpen'></span>";
                document.getElementById('TR'+gid).style.display="";
//loadgame_R.php:214Uncaught TypeError: Cannot read property 'style' of null
                document.getElementById('TR_1_'+gid).style.display="";
            }
        }
    }
    
    var conscroll= document.getElementById('controlscroll');
    conscroll.style.display="none";
    //document.getElementById('pages').innerHTML=get_timer()-start_time;
    loadingOK();
}
function layer_screen(gid,layers){  
    //檢查賠率是否有變動
    changeRatio=check_ratio(gid).split(",");    
        param=getpararm('2');
        gno=gidx[gid];
        layers=layers.replace(/\*GID\*/g,GameFT[gno][0]);/*gid*/
        //layers=layers.replace("*GID*",GameFT[gno][0]);/*gid*/ 
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
        keep_leg=GameFT[gno][2]
        layers=layers.replace("*ITEM*",GameFT[gno][3]); /*場次*/
        if (parent.LegGame.indexOf((GameFT[gno][2]+"_").replace("<br>"," ").replace(" _","_"),0)<0 && parent.LegGame!="ALL" ) return ""; //select game
        if (GameFT[gno][4]=="N"){
            return "";
        }else{
            layers=layers.replace("*CLASS*",'bgcolor=#ffffff');
        }
        var teamdata=new Array();
        teamdata[0]="<table class='b_tab' cellpadding=0 cellspacing=0 border=0>";
        teamdata[1]="<table class='b_tab' cellpadding=0 cellspacing=0 border=0>";
        var countRec=0;
        result="";
        if (GameFT[gno][5]*1>0){
            for (k=0;k<GameFT[gno][5];k++){
                if (GameFT[gno][6+k*4]=="N") {
                    if (GameFT[gno][9+k*4]*1==0) {
                        GameFT[gno][9+k*4]="";
                    }else{
                        countRec++;
                        GameFT[gno][9+k*4]=printf(GameFT[gno][9+k*4],2);
                        teamdata[countRec%2]+="<tr><td bgcolor=white width=90% class='team_name'>"+result+GameFT[gno][8+k*4]+ "</td>";
                        //teamdata[countRec%2]+="<td "+getcolor(changeRatio,k)+" width=60 class='r_bold' bgcolor=white><font class='b_cen' title=\""+GameFT[gno][8+k*4]+"\" style='cursor:hand' onclick=parent.mem_order.location.href='../FT_order/FT_order_nfs.php?gametype="+GameFT[i][(GameFT[i].length-1)]+"&gid="+GameFT[i][0]+"&uid="+parent.uid+"&rtype="+GameFT[gno][7+k*4]+"&wtype="+parent.rtype.toUpperCase()+"'>"+GameFT[gno][9+k*4]+"</font></td></tr>";
                        param="gametype="+GameFT[i][(GameFT[i].length-1)]+"&gid="+GameFT[i][0]+"&uid="+parent.uid+"&rtype="+GameFT[gno][7+k*4]+"&wtype="+parent.rtype.toUpperCase()+"&langx="+top.langx;
                        teamdata[countRec%2]+="<td "+getcolor(changeRatio,k)+" width=60 class='r_bold' bgcolor=white><font class='b_cen' title=\""+GameFT[gno][8+k*4]+"\" style='cursor:hand' onclick=\"parent.mem_order.betOrder('FT','NFS','"+param+"');\">"+GameFT[gno][9+k*4]+"</font></td></tr>";
                        
                    }
                }
            }
        }
        
        if (countRec%2==1){
            teamdata[0]+="<tr><td bgcolor=white width=90% class='team_name'>&nbsp;</td>";
            teamdata[0]+="<td width=60 class='r_bold' bgcolor=white>&nbsp;</td></tr>";
        }
        teamdata[0]+="</table>";
        teamdata[1]+="</table>";
        orders="";
        //alert(teamdata);
        layers=layers.replace("*ORDER*",orders);
        layers=layers.replace("*TEAM1*",teamdata[1]);
        layers=layers.replace("*TEAM2*",teamdata[0]);
        //layers=layers.replace("*IORATIO*",teamdata_R);
        
        
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
//  var temparea = area.innerText;
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
//  var tempitem = item.innerText;
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
/*
function chg_league(){
    var obj_league = document.getElementById('sel_leagueid');
    sel_league=obj_league.value;
    parent.sel_league=sel_league;
    homepage="reloadgame_"+Showtypes+".php?"+get_pageparam();
    //alert(homepage);
    reloadPHP.location.href=homepage;

}
*/
function chg_league(){
//  var legframe= document.getElementById('legFrame');
    var legview =document.getElementById('legView');
    //alert("./body_var_lid.php?uid="+parent.uid+"&rtype="+parent.rtype+"&langx="+parent.langx+"&mtype="+parent.ltype;);
    legFrame.location.href="./body_var_lid.php?"+get_pageparam();
    legview.style.display='block';
    legview.style.top=  document.body.scrollTop+82; //21+34+25+10;
    legview.style.left=10; //100;
    //self.location="./body_var_lid.php?uid="+parent.uid+"&rtype="+parent.rtype+"&langx="+parent.langx+"&mtype="+parent.ltype;
}

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
    sel_leagues.innerHTML=txt_bodyI;
}

function loadingOK(){
    //alert("loadingOK")
    //try{
        document.getElementById("rsu_refresh").className="rsu_refresh";
    //}catch(E){}
    
}</script>
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

function mouseover_pointer(mouseTR){
    //alert("11111111");
    bgclass=mouseTR.bgColor;
    //mouseTR.className='tr_over';
    trid=(mouseTR.id).replace("C","");
    eval("document.getElementById('"+trid+"').bgColor='gold'");
    try{
    eval("document.getElementById('"+trid+"C').bgColor='gold'");
    }catch(E){}
}

function mouseout_pointer(mouseTR){
    if (bgclass!="")
        {
        //mouseTR.className=bgclass;
        trid=(mouseTR.id).replace("C","");
        eval("document.getElementById('"+trid+"').bgColor='"+bgclass+"'");
        try{
            eval("document.getElementById('"+trid+"C').bgColor='"+bgclass+"'");
        }catch(E){}
    }
}
/*
---------------reload time------------------
*/
var ReloadTimeID="";
var showtime=0;
var LeagueAry=new Array();
function set_reloadtime(){
    //showclass.innerHTML=shows.replace("*showclass*","class=\"FS"+FStype+"\"");
    //if((""+eval("parent.FS"+FStype+"_lname_ary"))=="undefined") eval("parent.FS"+FStype+"_lname_ary='ALL'");
    //if((""+eval("parent.FS"+FStype+"_lid_ary"))=="undefined") eval("parent.FS"+FStype+"_lid_ary='ALL'");
    //alert("try=>"+eval("top.FS"+FStype+"_lid['FS"+FStype+"_lid_ary']"));  
    document.getElementById("MNFS").className="FS"+FStype;
    document.getElementById("pg_txt").innerHTML ="&nbsp;";
    showtime=parent.retime;
    count_down();
    
    parent.sel_league=lidURL(eval("top.FS"+FStype+"_lid['FS"+FStype+"_lid_ary']"));
    if(parent.sel_league=="ALL")parent.sel_league="";   
    coun_Leagues();
    //alert('reloadgame_'+Showtypes+".php?mid="+parent.mid+"&"+get_pageparam());
    reloadPHP.location.href='reloadgame_'+Showtypes+".php?mid="+parent.mid+"&"+get_pageparam();
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
    //alert("try=>"+str_tmp);
    if(str_tmp=='-ALL'){
        document.getElementById("str_num").innerHTML =top.alldata;
    }else{
        var larray=str_tmp.split('-');
        //alert("===>"+str_tmp+":length=>"+larray.length);
        
        for(var i =0;i<larray.length;i++){
            if(larray[i]!=""){coun++}
        }
        //alert("try===>"+coun);
        //coun =LeagueAry.length;
        document.getElementById("str_num").innerHTML =coun;
    }
}
function count_down(){
    return;
    var rt=document.getElementById('refreshTime');
    setTimeout('count_down()',1000);
    if(showtime <= 1){
        
        reload_var();
        return;
    }
    showtime--;
    rt.innerHTML=showtime;
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
function reload_var(){
    showtime=parent.retime;
    parent.sel_league=lidURL(eval("top.FS"+FStype+"_lid['FS"+FStype+"_lid_ary']"));
    if(parent.sel_league=="ALL")parent.sel_league="";
    coun_Leagues();
	//alert('reloadgame_'+Showtypes+".php?mid="+parent.mid+"&"+get_pageparam());
    reloadPHP.location.href='reloadgame_'+Showtypes+".php?mid="+parent.mid+"&"+get_pageparam();

}
/*
----------------功能menu--------------
*/
//function change_game(gtype,vals,gid)
//{
//if ((gtype=="gopen" || gtype=="strong") && (vals!="all"))
//  a=confirm(eval("str_"+gtype+vals));
//else a=true;
//if (a==true){
//  alert('FT_Game_change.php?gid='+gid+"&"+gtype+"="+vals+"&ShowType="+Showtypes+"&"+get_pageparam());
//  self.location.href='FT_Game_change.php?gid='+gid+"&"+gtype+"="+vals+"&ShowType="+Showtypes+"&"+get_pageparam();
//  }
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
            alert(top.str_only_keyin_num);  /*僅能接受數字!!*/
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
        if(crs[0]=="0") word = top.str_ratio[0]+"&nbsp;/&nbsp;"+top.str_ratio[1];
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
function countdown(){
    if (keepsec!=""){
        if (Showtypes=="P1"||Showtypes=="P2"||Showtypes=="P3"){
            reload_time.innerHTML=keepsec+"&nbsp"+top.str_sec+top.str_auto_upgrade+"&nbsp"+"--"+par_min+"~"+par_max;
        }else{
            reload_time.innerHTML=keepsec+"&nbsp"+top.str_sec+top.str_auto_upgrade+"&nbsp";
        }
        keepsec--;
    }
}

var keepsec="";
cc=setInterval("countdown()",1000);
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
    return parent.base_url+"&choice="+choice+"&LegGame="+parent.LegGame+"&pages="+parent.pages+"&records="+parent.records+"&FStype="+FStype+"&area_id="+parent.sel_area+"&league_id="+parent.sel_league+"&rtype="+parent.rtype; //+"&item_id="+parent.sel_item
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



function setleghi(leghight){
    var legview =document.getElementById('legFrame');
    
    if((leghight*1) > 95){
        legview.height = leghight;
    }else{
        
        legview.height = 95;
    }
    
}

function LegBack(){
    var legview =document.getElementById('legView');
    legview.style.display='none';
    reload_var();
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

</script>
<script>
var FStype='<?=$FStype ?>';
parent.uid='<?=$uid ?> ';
parent.rtype='<?=$rtype ?>';
parent.username='<?=$username ?>';
parent.langx='<?=$langx ?>';
parent.base_url='uid=<?=$uid ?>&langx=<?=$langx ?>';
parent.mid='6686359';
parent.sel_gtype='<?=$rtype ?><?= $FStype?>';
parent.retime=180;
</script></head>
<body id="MNFS" onLoad="set_reloadtime();">
<!--body id="MNFS" class="bodyset" onLoad="set_reloadtime();" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false"-->
<table border="0" cellpadding="0" cellspacing="0" id="box">
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0"  >
        <tr>
          <td class="top"><h1><em id="tmp_TMP_ITEM"></em></h1></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td class="mem"><h2>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" id="fav_bar">
          <tr>
            <td id="page_no"><span id="pg_txt"></span></td>
                <td id="tool_td">
              
                  <table border="0" cellspacing="0" cellpadding="0" class="tool_box">
                    <tr>
                        <!--td class="sport_btn">選擇體育:<div id="sel_areas"></div></td-->
                        <!--<td class="leg_menu" nowrap>選擇聯賽:<div  id="sel_leagues"></div></td>-->
                        <td class="rsu_refresh" id="rsu_refresh" onClick="this.className='rsu_refresh_on';"><!--秒數更新--><div onClick="javascript:reload_var()"><font id="refreshTime" ></font></div></td>
                        <td class="leg_btn"><div onClick="javascript:chg_league();" id="sel_leagues">選擇聯賽 (<span id="str_num"></span>)</div></td>
                        <td class="OrderType"></td>
                     </tr>
                  </table>
              
                </td>
              </tr>
        </table>
      </h2>
      <!--     資料顯示的layer     -->
      <div id="showgames"></div>
      </td>
  </tr>
  <tr>
    <td id="foot"><b>&nbsp;</b></td>
  </tr>
</table>
<div id=showlayers style="display: none">
  <table id="glist_table"  border="0" cellpadding="0" cellspacing="1" class="game">
    <!--tr>
    <th class="time">時間</th>
    <th >項目</th>
     <th width="400">隊伍(球員)</th>
    <th  width="60">賠率</th>
  </tr-->
    *ShowGame*
  </table>
</div>
<div id="glist" style="display: none"-->
<xmp>
  <tr *ST*>
    <td nowrap colspan="2" class="b_hline">
    <table border="0" cellpadding="0" cellspacing="0" class="fs_leg"><tr><td class="legicon" onClick="showLEG('*GID*');">
    <span id="*GID*_*LEG*" class="showleg">
        *LegMark*
      <!--展開聯盟-符號-->
      <!--span id="LegOpen"></span-->
      <!--收合聯盟-符號-->
      <!--div id="LegClose"></div-->
      </span>
        </td><td onClick="showLEG('*GID*');" class="leg_bar">*LEG*</td>
        <td nowrap align="right">*TIME*</td>
        </tr></table>
      </td>
  </tr>
  <tr id="TR_1_*GID*"  style="display: none">
    <td colspan="2" class="sub_title">
    <table cellpadding="0" cellspacing="0">
        <tr>
          <td nowrap align="left">*ITEM*</td>
          
        </tr>
      </table></td>
  </tr>
  <tr id="TR*GID*" *CLASS* style="display: none">
    <td nowrap class="sub_tab">*TEAM1*</td>
    <td nowrap class="sub_tab">*TEAM2*</td>
  </tr>

</xmp>
</div>

<div id=NoDataTR style="display:none;">
    <xmp>
       <td colspan="20" class="no_game">您選擇的項目暫時沒有賽事。請修改您的選項或遲些再返回。</td>
     </xmp>
</div>

<!----------------------更改下拉視窗---------------------------->
<!--區域 START-->
<span id="area" style="position:absolute; display: none">
    <xmp>
<option value="*AREA_ID*" *SELECT_AREA*>*AREA_NAME*</option>
</xmp>
</span> <span id="bodyA" style="position:absolute; display: none">
<select id="sel_aid" name="sel_aid" onChange="chg_area();" class="za_select">
  <option value="">全部</option>
  
        *SHOW_A*
    
</select>
</span>
<!--區域 END-->
<!--類別 START-->
<span id="item" style="position:absolute; display: none">
    <xmp>
<option value="*ITEM_ID*" *SELECT_ITEM*>*ITEM_NAME*</option>
</xmp>
</span> 
<span id="bodyI" style="position:absolute; display: none">
<select id="sel_itemid" name="sel_itemid" onChange="chg_item();" class="za_select">
  <option value="">全部</option>
  
        *SHOW_I*
    
</select>
</span>
<!--類別 END-->
<!--聯盟 START-->
<span id="league" style="position:absolute; display: none">
    <xmp>
<option value="*LEAGUE_ID*" *SELECT_LEAGUE*>*LEAGUE_NAME*</option>
</xmp>
</span> 
<span id="bodyL" style="position:absolute; display: none">
<select id="sel_leagueid" name="sel_leagueid" onChange="chg_league();"  class="za_select">
  <option value="">全部</option>
  
        *SHOW_I*
    
</select>
</span>
<!--聯盟 END-->
<!--選擇聯賽-->
<div id="legView" style="display:none;" class="legView">
    <div class="leg_head" onMousedown="initializedragie('legView')"></div>
    
<div><iframe id="legFrame" frameborder="no" border="0" allowtransparency="true"></iframe></div>


    <div class="leg_foot"></div>
</div>
<iframe id=reloadPHP name=reloadPHP width=0 height=0 ></iframe>
<div id="controlscroll"  style="position:absolute;"><table border="0" cellspacing="0" cellpadding="0" class="loadBox"><tr><td><!--loading--></td></tr></table></div>
</body>
</html>