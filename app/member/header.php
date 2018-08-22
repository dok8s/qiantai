<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Robots" contect="none">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link rel="stylesheet" href="../../../style/member/mem_header_ft_cn.css" type="text/css">
<SCRIPT language="JavaScript" src="/js/header.js"></SCRIPT>

 
</head>
<body id="HFT" class="bodyset" onLoad="SetRB('FT','89d33dfcd028cbl897344');onloaded();">
<div id="container">
	<input type="hidden" id="uid" name="uid" value="89d33dfcd028cbl897344">
	<input type="hidden" id="langx" name="langx" value="zh-cn">
	<div id="header"><span><h1></h1></span></div>
 <div id="welcome">
	<ul class="level1">
      <!--会员帐号-->
 
<script language="javascript" type="text/javascript"> 
<!--
window.onload=function (){
stime();
}
var c=0;
var Y=2012,M=8,D=30;
function stime() {
c++
sec=82765+c;
H=Math.floor(sec/3600)%24
I=Math.floor(sec/60)%60
S=sec%60
if(S<10) S='0'+S;
if(I<10) I='0'+I;
if(H<10) H='0'+H;
if (H=='00' & I=='00' & S=='00') D=D+1; //日进位
if (M==2) { //判断是否为二月份******
if (Y%4==0 && !Y%100==0 || Y%400==0) { //是闰年(二月有28天)
if (D==30){M+=1;D=1;} //月份进位
}
else { //非闰年(二月有29天)
if (D==29){M+=1;D=1;} //月份进位
}
}
else { //不是二月份的月份******
if (M==4 || M==6 || M==9 || M==11) { //小月(30天)
if (D==31) {M+=1;D=1;} //月份进位
}
else { //大月(31天)
if (D==32){M+=1;D=1;} //月份进位
}
}
if (M==13) {Y+=1;M=1;} //年份进位
//setInterval(stime,1000);
setTimeout("stime()", 1000);
document.getElementById("head_year").innerHTML = Y+'年'+M+'月'+D+'日 '+H+':'+I;
}
-->
</script>
      <li class="name">您好, <strong id="userid">arun20112</strong>
      	<div id="head_date"><span id="head_year"></span></div>
      </li>

      <li class="rb" id="rb_btn"><span id="rbType"></span><a href="#" onClick="chg_head('http://w148.hg3088.com/app/member/FT_browse/index.php?rtype=re&uid=10697e3bm6439161l260158&langx=zh-cn&mtype=4&showtype=',parent.FT_lid_type,'SI2'); chg_button_bg('FT','rb');" id="rbyshow" style="display:;">滚球</a>
      
        <!-- 滚球Menu Start -->
        
           <ul id="RB_MENU" class="level2">
               <li class="rb_bg_left"></li>
               <li id="RB_FT" class="rb_out"><span><a href="#" onClick="Go_RB_page('FT');">足球 (<strong class="game_sum" id="RB_FT_games"></strong>)</a></span></li>
               <li id="RB_BK" class="rb_out"><span><a href="#" onClick="Go_RB_page('BK');">篮球&amp;美式足球 (<strong class="game_sum" id="RB_BK_games"></strong>)</a></span></li>
               <li id="RB_TN" class="rb_out"><span><a href="#" onClick="Go_RB_page('TN');">网球 (<strong class="game_sum" id="RB_TN_games"></strong>)</a></span></li>
               <li id="RB_VB" class="rb_out"><span><a href="#" onClick="Go_RB_page('VB');">排球 (<strong class="game_sum" id="RB_VB_games"></strong>)</a></span></li>
               <li id="RB_BS" class="rb_out"><span><a href="#" onClick="Go_RB_page('BS');">棒球 (<strong class="game_sum" id="RB_BS_games"></strong>)</a></span></li>
               <li id="RB_OP" class="rb_out"><span><a href="#" onClick="Go_RB_page('OP');">其他 (<strong class="game_sum" id="RB_OP_games"></strong>)</a></span></li>
               <li class="rb_bg_right"></li>
           </ul>
 
        <!-- 滚球Menu End-->      
 
      
      </li>        
      <li class="today_on" id="today_btn" ><span id="todayType" style="display:none;">今日赛事</span><a href="#" onClick="chg_head('http://w148.hg3088.com/app/member/FT_browse/index.php?rtype=r&uid=10697e3bm6439161l260158&langx=zh-cn&mtype=4&showtype=',parent.FT_lid_type,'SI2');chg_button_bg('FT','today');" id="todayshow" style="display:;">今日赛事</a></li> 
      <li class="early" id="early_btn"><span id="earlyType" style="display:none;">早盘</span> <a href="javascript:chg_button_bg('FT','early');chg_index_head('http://w148.hg3088.com/app/member/FT_header.php?uid=10697e3bm6439161l260158&showtype=future&langx=zh-cn&mtype=4','http://w148.hg3088.com/app/member/FT_future/index.php?rtype=r&uid=10697e3bm6439161l260158&langx=zh-cn&mtype=4&showtype=',parent.FU_lid_type,'SI2','future');" id="earlyshow" style="display:'';cursor:hand;" >早盘</a></li> 
      <!--Live TV-->
      <li class="live_tv"><a href="#" onClick="OpenLive()" >&nbsp;</a></li>  
    </ul>
    <div class="pass"><a href="#" id="chg_pwd" onClick="Go_Chg_pass();" style="cursor:hand">更改密码</a></div>
  </div>
  <div id="nav">
    <ul class="level1">
 
      <li class="ft"><span class="ball"><a href="javascript:chg_button_bg('FT','today');chg_index('http://w148.hg3088.com/app/member/FT_header.php?uid=10697e3bm6439161l260158&showtype=&langx=zh-cn&mtype=4','http://w148.hg3088.com/app/member/FT_browse/index.php?rtype=r&uid=10697e3bm6439161l260158&langx=zh-cn&mtype=4&showtype=',parent.FT_lid_type,'SI2');">足球 (<strong class="game_sum" id="FT_games"></strong>)</a></span></li>
      <li class="bk"><span class="ball"><a href="javascript:chg_button_bg('BK','today');chg_index('http://w148.hg3088.com/app/member/BK_header.php?uid=10697e3bm6439161l260158&showtype=&langx=zh-cn&mtype=4','http://w148.hg3088.com/app/member/BK_browse/index.php?rtype=all&uid=10697e3bm6439161l260158&langx=zh-cn&mtype=4',parent.BK_lid_type,'SI2');">篮球 <span class="ball_nf"><img src="/images/member/head_ball_nf.gif" class="nf_icon"></span> 美式足球 (<strong class="game_sum" id="BK_games"></strong>)</a></span></li>                           
      <li class="tn"><span class="ball"><a href="javascript:chg_button_bg('TN','today');chg_index('http://w148.hg3088.com/app/member/TN_header.php?uid=10697e3bm6439161l260158&showtype=&langx=zh-cn&mtype=4','http://w148.hg3088.com/app/member/TN_browse/index.php?rtype=r&uid=10697e3bm6439161l260158&langx=zh-cn&mtype=4',parent.TN_lid_type,'SI2');">网球 (<strong class="game_sum" id="TN_games"></strong>)</a></span></li>
      <li class="vb"><span class="ball"><a href="javascript:chg_button_bg('VB','today');chg_index('http://w148.hg3088.com/app/member/VB_header.php?uid=10697e3bm6439161l260158&showtype=&langx=zh-cn&mtype=4','http://w148.hg3088.com/app/member/VB_browse/index.php?rtype=r&uid=10697e3bm6439161l260158&langx=zh-cn&mtype=4',parent.VB_lid_type,'SI2');">排球 (<strong class="game_sum" id="VB_games"></strong>)</a></span></li>
      <li class="bs"><span class="ball"><a href="javascript:chg_button_bg('BS','today');chg_index('http://w148.hg3088.com/app/member/BS_header.php?uid=10697e3bm6439161l260158&showtype=&langx=zh-cn&mtype=4','http://w148.hg3088.com/app/member/BS_browse/index.php?rtype=r&uid=10697e3bm6439161l260158&langx=zh-cn&mtype=4',parent.BS_lid_type,'SI2');">棒球 (<strong class="game_sum" id="BS_games"></strong>)</a></span></li>
      <li class="op"><span class="ball"><a href="javascript:chg_button_bg('OP','today');chg_index('http://w148.hg3088.com/app/member/OP_header.php?uid=10697e3bm6439161l260158&showtype=&langx=zh-cn&mtype=4','http://w148.hg3088.com/app/member/OP_browse/index.php?rtype=r&uid=10697e3bm6439161l260158&langx=zh-cn&mtype=4',parent.OP_lid_type,'SI2');">其他 (<strong class="game_sum" id="OP_games"></strong>)</a></span></li>
      <!--li class="om"><a href="javascript:void(0);" onClick="chg_index('{OM}',parent.OM_lid_type,'SI2');">其他早餐  (<span class="game_sum"></span>)</a></li-->
      <!--li class="early"><a href="#">早盘种类</a>
        <ul class="level2">
          <li class="tu"><a href="javascript:void(0);" onClick="chg_index('{TU}',parent.TU_lid_type,'SI2');">网球早盘</a></li>
          <li class="vu"><a href="javascript:void(0);" onClick="chg_index('{VU}',parent.VU_lid_type,'SI2');">排球早盘</a></li>
          <li class="be"><a href="javascript:void(0);" onClick="chg_index('{BSFU}',parent.BSFU_lid_type,'SI2');">棒球早盘</a></li>
          <li class="bu"><a href="javascript:void(0);" onClick="chg_index('{BU}',parent.BU_lid_type,'SI2');">篮球/美足早盘</a></li>
          <!--li class="box1"><a class="bbox1"></a></li-->
    </ul>
      </li>      
    </ul>
  </div>
  <div id="type">
    <ul>
      <li class="rb"><a id="rb_class" class="type_out" href="#" onClick="chg_type('http://w148.hg3088.com/app/member/FT_browse/index.php?rtype=re&uid=10697e3bm6439161l260158&langx=zh-cn&mtype=4&showtype=',parent.FT_lid_type,'SI2'); chg_button_bg('FT','rb');chg_type_class('rb_class');" >滚球<span class="rb_sum"> (<span class="game_sum" id="subRB_games"></span>)</span></a></li>
      <li class="re"><a id="re_class" class="type_out" href="javascript:void(0);" onClick="chg_button_bg('FT','today');chg_type('http://w148.hg3088.com/app/member/FT_browse/index.php?rtype=r&uid=10697e3bm6439161l260158&langx=zh-cn&mtype=4&showtype=',parent.FT_lid_type,'SI2');chg_type_class('re_class');">独赢 ＆ 让球 ＆ 大小 & 单 / 双</a></li>
      <!--li class="hr"><a href="javascript:void(0);" onClick="chg_type('http://w148.hg3088.com/app/member/FT_browse/index.php?rtype=hr&uid=10697e3bm6439161l260158&langx=zh-cn&mtype=4&showtype=',parent.FT_lid_type,'SI2');">上半场</a></li-->
      <!--li class="rb"><a href="http://w148.hg3088.com/app/member/FT_browse/index.php?rtype=re&uid=10697e3bm6439161l260158&langx=zh-cn&mtype=4&showtype=" target="body">滚球</a></li-->
      <li class="pd"><a id="pd_class" class="type_out" href="javascript:void(0);" onClick="chg_button_bg('FT','today');chg_type('http://w148.hg3088.com/app/member/FT_browse/index.php?rtype=pd&uid=10697e3bm6439161l260158&langx=zh-cn&mtype=4&showtype=',parent.FT_lid_type,'SI2');chg_type_class('pd_class');">波胆</a></li>
      <!--li class="hrp"><a href="javascript:void(0);" onClick="chg_type('http://w148.hg3088.com/app/member/FT_browse/index.php?rtype=hpd&uid=10697e3bm6439161l260158&langx=zh-cn&mtype=4&showtype=',parent.FT_lid_type,'SI2');">上半波胆</a></li-->
      <li class="to"><a id="to_class" class="type_out" href="javascript:void(0);" onClick="chg_button_bg('FT','today');chg_type('http://w148.hg3088.com/app/member/FT_browse/index.php?rtype=t&uid=10697e3bm6439161l260158&langx=zh-cn&mtype=4&showtype=',parent.FT_lid_type,'SI2');chg_type_class('to_class');">总入球</a></li>
      <li class="hf"><a id="hf_class" class="type_out" href="javascript:void(0);" onClick="chg_button_bg('FT','today');chg_type('http://w148.hg3088.com/app/member/FT_browse/index.php?rtype=f&uid=10697e3bm6439161l260158&langx=zh-cn&mtype=4&showtype=',parent.FT_lid_type,'SI2');chg_type_class('hf_class');">半场 / 全场</a></li>
      <!--<li class="par"><a href="http://w148.hg3088.com/app/member/FT_browse/index.php?rtype=p&uid=10697e3bm6439161l260158&langx=zh-cn&mtype=4&showtype=" target="body">标准过关</a></li>
			<li class="hpa"><a href="http://w148.hg3088.com/app/member/FT_browse/index.php?rtype=pr&uid=10697e3bm6439161l260158&langx=zh-cn&mtype=4&showtype=" target="body">让球过关</a></li>-->
      <li class="hp3"><a id="hp3_class" class="type_out" href="http://w148.hg3088.com/app/member/FT_browse/index.php?rtype=p3&uid=10697e3bm6439161l260158&langx=zh-cn&mtype=4&showtype=" target="body" onClick="chg_button_bg('FT','today');chg_type_class('hp3_class');">综合过关</a></li>
      <li class="fs"><a id="fs_class" class="type_out" href="http://w148.hg3088.com/app/member/browse_FS/loadgame_R.php?uid=10697e3bm6439161l260158&langx=zh-cn&FStype=FT&mtype=4" onClick="chg_button_bg('FT','today');parent.sel_league='';parent.sel_area='';chg_type_class('fs_class');top.hot_game='';"  target="body" >冠军</a></li>
      <li class="result"><a id="result_class" class="type_out" href="http://w148.hg3088.com/app/member/result/result.php?game_type=FT&uid=10697e3bm6439161l260158&langx=zh-cn" target="body" onClick="chg_button_bg('FT','today');chg_type_class('result_class');">赛果</a></li>
    </ul>
  </div>
  
  
</div>
<!--input  id=downloadBTN type=button style="width:80px;visibility:'hidden'"  onclick="onclickDown()" value="下载"-->
    <!--主选单-->
        <div id="back">
    	<ul>
   		  <li class="lang_top"><a href="#">简体<!--[if IE 7]><!--></a><!--<![endif]-->
			<!--[if lte IE 6]><table><tr><td><![endif]-->
 
                <ul class="pd">
                    <li class="cn" onClick="OnMouseOverEvent();"><a href="javascript:void(0);" onClick="changeLangx('zh-cn')">简体</a></li>
                    <li class="tw" onClick="OnMouseOverEvent();"><a href="javascript:void(0);" onClick="changeLangx('zh-tw')">繁體</a></li>
                    <li class="us" onClick="OnMouseOverEvent();"><a href="javascript:void(0);" onClick="changeLangx('en-us')">English</a></li>
       	    </ul>
             <!--[if lte IE 6]></td></tr></table></a><![endif]-->
          </li>
           <li class="mail" onClick="OnMouseOverEvent();"><a href="javascript:void(0);" OnClick="window.open('/tpl/member/zh-cn/QA_conn.html','QA','location=no,status=no,width=800,height=428,toolbar=no,top=0,left=0,scrollbars=yes,resizable=yes,personalbar=yes');">联系我们</a></li>
           <li class="qa" onClick="OnMouseOverEvent();"><a href="#">帮助<!--[if IE 7]><!--></a><!--<![endif]-->
			<!--[if lte IE 6]><table><tr><td><![endif]-->
 
                <ul class="pd">
                       <li class="qa_on"><a href="#">帮助</a></li>
                       <li class="msg"><a href="#" onClick="parent.mem_order.showMoreMsg();">公告栏</a></li>
                       <li class="roul"><a href="#" OnClick="window.open('/tpl/member/zh-cn/QA_sport.html','QA','location=no,status=no,width=800,height=428,toolbar=no,top=0,left=0,scrollbars=yes,resizable=yes,personalbar=yes');">体育规则</a></li>
                       <li class="wap"><a href="#" OnClick="window.open('/tpl/member/zh-cn/roul_mp.html','WAP','location=no,status=no,width=680,height=500,toolbar=no,top=0,left=0,scrollbars=no,resizable=no,personalbar=yes');">Wap指南</a></li>
                       <li class="odd"><a href="#" OnClick="window.open('/tpl/member/zh-cn/QA_way.html','QA','location=no,status=no,width=800,height=428,toolbar=no,top=0,left=0,scrollbars=yes,resizable=yes,personalbar=yes');">赔率计算列表</a></li>
         	 </ul>
             <!--[if lte IE 6]></td></tr></table></a><![endif]-->
          </li>
   		  <li class="home" onMouseOver="OnMouseOutEvent()"><a href="http://w148.hg3088.com/app/member/logout.php?uid=10697e3bm6439161l260158&langx=zh-cn" target="_top">退出</a></li>
	  </ul>
  </div> 
 
<div id="mem_box">
  <div id="mem_main"><span class="his"><a href="http://w148.hg3088.com/app/member/history/history_data.php?uid=10697e3bm6439161l260158&langx=zh-cn" target="body">帐户历史</a></span> | <span class="wag"><a href="http://w148.hg3088.com/app/member/today/today_wagers.php?uid=10697e3bm6439161l260158&langx=zh-cn" target="body">交易状况</a></span></div>
  <div id="credit_main"><span id="credit">&nbsp;</span><input name="" type="button" class="re_credit" value="" onClick="javascript:reloadCrditFunction();"></div>
</div>
 
<div id="extra2"><a href="http://live228.com/app/member/mem_add.php?langx=zh-cn" target="_blank"></a></div>
<iframe id="reloadPHP" name="reloadPHP"  width="0" height="0"></iframe>
<iframe id="reloadPHP" name="reloadPHP1" src="reloadCredit.php?uid=89d33dfcd028cbl897344&langx=zh-cn" width="0" height="0"></iframe>
<iframe id=memOnline name=memOnline  width=0 height=0></iframe>
</body>
</html>

