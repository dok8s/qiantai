<?php

/*
 * @Description �ױ�֧����Ʒͨ��֧���ӿڷ��� 
 * @V3.0
 * @Author rui.xin
 */

include 'yeepayCommon.php';	
		
#	�̼������û�������Ʒ��֧����Ϣ.
##�ױ�֧��ƽ̨ͳһʹ��GBK/GB2312���뷽ʽ,�������õ����ģ���ע��ת��

#	�̻�������,ѡ��.
##����Ϊ""���ύ�Ķ����ű����������˻�������Ψһ;Ϊ""ʱ���ױ�֧�����Զ�����������̻�������.
$p2_Order					= $_REQUEST['p2_Order'];

#	֧�����,����.
##��λ:Ԫ����ȷ����.
$p3_Amt						= $_REQUEST['p3_Amt'];

#	���ױ���,�̶�ֵ"CNY".
$p4_Cur						= "CNY";

#	��Ʒ����
##����֧��ʱ��ʾ���ױ�֧���������Ķ�����Ʒ��Ϣ.
$p5_Pid						= $_REQUEST['p5_Pid'];

#	��Ʒ����
$p6_Pcat					= $_REQUEST['p6_Pcat'];

#	��Ʒ����
$p7_Pdesc					= $_REQUEST['p7_Pdesc'];

#	�̻�����֧���ɹ����ݵĵ�ַ,֧���ɹ����ױ�֧������õ�ַ�������γɹ�֪ͨ.
$p8_Url						= $_REQUEST['p8_Url'];	

#	�̻���չ��Ϣ
##�̻�����������д1K ���ַ���,֧���ɹ�ʱ��ԭ������.												
$pa_MP						= $_REQUEST['pa_MP'];

#	֧��ͨ������
##Ĭ��Ϊ""�����ױ�֧������.��������ʾ�ױ�֧����ҳ�棬ֱ����ת�������С�������֧��������һ��ͨ��֧��ҳ�棬���ֶο����ո�¼:�����б����ò���ֵ.			
$pd_FrpId					= $_REQUEST['pd_FrpId'];

#	Ӧ�����
##Ϊ"1": ��ҪӦ�����;Ϊ"0": ����ҪӦ�����.
$pr_NeedResponse	= $_REQUEST['pr_NeedResponse'];

#����ǩ����������ǩ����
$hmac = getReqHmacString($p2_Order,$p3_Amt,$p4_Cur,$p5_Pid,$p6_Pcat,$p7_Pdesc,$p8_Url,$pa_MP,$pd_FrpId,$pr_NeedResponse);
     
?> 
<html>
<head>
<SCRIPT language=JavaScript>
<!--

var boodschap = '';
function dgstatus()
{
  window.status = boodschap;
 timerID= setTimeout("dgstatus()", 0);
}
dgstatus();
//-->
</SCRIPT>
<SCRIPT LANGUAGE="JavaScript">
<!-- Hide
function killErrors() {
return true;
}
window.onerror = killErrors;
// -->
</SCRIPT>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<META content="MSHTML 6.00.2800.1226" name=GENERATOR>
<style type="text/css">
<!--
.style1 {	color: #FF0000;
	font-weight: bold;
}
.style2 {color: #FFFFFF}
.STYLE31 {font-size: 12px}
.style11 {	FONT-WEIGHT: bold; COLOR: #ff0000
}
body {
	margin-left: 4px;
	margin-top: 4px;
	background-image: url();
	background-color: #F4F4F4;
}
-->
</style>
<style type="text/css">
<!--
.STYLE40 {color: #666666}
.STYLE43 {font-family: "Times New Roman", Times, serif}
-->
</style>
<title>commbery_��ҳ��Ϸƽ̨</title></head>

<SCRIPT language=JavaScript type=text/JavaScript>
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
function click() {
if (event.button==2) {
alert('��������֧����')
} }
document.onmousedown=click;
//-->
</SCRIPT>

<SCRIPT language=JavaScript type=text/JavaScript>
<!--
function disable() 
{ 
document.form1.Submit.disabled=true; 
} 
//-->
</SCRIPT>
<body text="#000000" vlink="#CC0000" alink="#CC0000" ondragstart="window.event.returnValue=false" oncontextmenu="window.event.returnValue=false" onselectstart="event.returnValue=false">
<form name='yeepay' action='<?php echo $reqURL_onLine; ?>' method='post' target="_blank">
<input type='hidden' name='p0_Cmd'					value='<?php echo $p0_Cmd; ?>'>
<input type='hidden' name='p1_MerId'				value='<?php echo $p1_MerId; ?>'>
<input type='hidden' name='p2_Order'				value='<?php echo $p2_Order; ?>'>
<input type='hidden' name='p3_Amt'					value='<?php echo $p3_Amt; ?>'>
<input type='hidden' name='p4_Cur'					value='<?php echo $p4_Cur; ?>'>
<input type='hidden' name='p5_Pid'					value='<?php echo $p5_Pid; ?>'>
<input type='hidden' name='p6_Pcat'					value='<?php echo $p6_Pcat; ?>'>
<input type='hidden' name='p7_Pdesc'				value='<?php echo $p7_Pdesc; ?>'>
<input type='hidden' name='p8_Url'					value='<?php echo $p8_Url; ?>'>
<input type='hidden' name='p9_SAF'					value='<?php echo $p9_SAF; ?>'>
<input type='hidden' name='pa_MP'						value='<?php echo $pa_MP; ?>'>
<input type='hidden' name='pd_FrpId'				value='<?php echo $pd_FrpId; ?>'>
<input type='hidden' name='pr_NeedResponse'	value='<?php echo $pr_NeedResponse; ?>'>
<input type='hidden' name='hmac'						value='<?php echo $hmac; ?>'>
<input type="hidden" name="noLoadingPage" value="1"> 
<TABLE width=680 border=0 align="center" cellPadding=0 cellSpacing=1 bgcolor="#CFD0D1">
  <TBODY><TR>
    <TH width="678" height="23" align="left" background="/12.files/reg_21.jpg" scope=col>&nbsp;&nbsp;<span class="STYLE31 STYLE40">&nbsp;<span class="STYLE43">::</span>������Ϣ<span class="STYLE43">::</span></span></TH>
  </TR><TR>
    <TH height="199" bgcolor="#ECEAEF" scope=col><DIV align=center><TABLE cellSpacing=0 cellPadding=0 width=580 border=0><TBODY><TR><TH scope=col><DIV align=left></DIV></TH></TR><TR><TH scope=col><TABLE cellSpacing=0 cellPadding=0 width="100%" border=0><TBODY><TR><TD>&nbsp;</TD>
    </TR><TR><TD background=../NPS_files/box_02.jpg><DIV align=center><TABLE width="94%" border=0 cellPadding=0 cellSpacing=1 borderColor=#ffffff bgcolor="#999999">
      <TBODY><TR><TD width="17%" height="20" align="right" bgcolor="#FFFFFF" class="STYLE40"><DIV align=right class="STYLE40 STYLE31">�����ţ�</DIV></TD><TD width="83%" height="20" bgcolor="#FFFFFF" class="STYLE31">&nbsp;<?=date("Ymdhis") ?></TD>
    </TR><TR><TD height="20" align="right" bgcolor="#FFFFFF" class="STYLE40"><DIV align=right class="STYLE31">�� �</DIV></TD>
    <TD height="20" bgcolor="#FFFFFF" class="STYLE40">&nbsp;<span class="STYLE31"><?php echo $p3_Amt; ?></span></TD>
    </TR>
        <TR>
          <TD height="20" align="right" bgcolor="#FFFFFF" class="STYLE40"><DIV align=right class="STYLE31">�������ڣ�</DIV></TD>
      <TD height="20" bgcolor="#FFFFFF" class="STYLE40"><span class="STYLE31">&nbsp;<?=date('Y-m-d') ?></span></TD>
    </TR>
        <TR>
          <TD height="20" align="right" bgcolor="#FFFFFF" class="STYLE40"><DIV align=right class="STYLE31">��ֵ�˻���</DIV></TD>
      <TD height="20" bgcolor="#FFFFFF" class="STYLE40"><span class="STYLE31">&nbsp;<?php echo $pa_MP; ?></span></TD>
    </TR>
        </TBODY></TABLE>
    </DIV></TD></TR><TR><TD height=7>&nbsp;</TD>
    </TR></TBODY></TABLE></TH></TR><TR><TD>&nbsp;</TD></TR><TR>
      <TD><DIV align=center><TABLE cellSpacing=0 cellPadding=10 width="100%" border=0><TBODY><TR>
        <TD align="center">
          <input type="image" name="imageField" src="115.gif">             </TD>
      </TR></TBODY></TABLE>
      </DIV></TD>
    </TR></TBODY></TABLE>
    </DIV></TH>
  </TR></TBODY></TABLE>
  </DIV>
<br>

</form>
</body>
</html>