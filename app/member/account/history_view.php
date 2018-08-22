<?
include "../include/library.mem.php";

echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";

require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
$uid=$_REQUEST["uid"];
$gtype=$_REQUEST['gtype'];
$langx=$_REQUEST["langx"];
$gtype1=$gtype;
if($gtype=='ALL'){$gtype1='FT';}
$gdate=$_REQUEST['gdate'];
$gdate1=$_REQUEST['gdate1'];
$sql = "select id,Memname,language from web_member where Oid='$uid' and oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}else{
	$row = mysql_fetch_array($result);
	$memname=$row['Memname'];
	//$langx  =$row['language'];
	require ("../include/traditional.$langx.inc.php");
//userlog($memname);
	$mDate=$_REQUEST['today_gmt'];
	$view_date=explode('-',$mDate);
	$abc=date('d')-$view_date[2];
	$t = time()-$abc*24*60*60;

	$xq = array("$week7","$week1","$week2","$week3","$week4","$week5","$week6");
	?>
<html>
<head>
<title>history_view</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_body_ft.css" type="text/css">
<link rel="stylesheet" href="/style/member/mem_body_his.css" type="text/css">
<link href="/style/member/my_account.css" rel="stylesheet" type="text/css">

<SCRIPT language="JavaScript" src="/js/history_view.js"></SCRIPT>
</head>
<body id="MWAG" class="bodyset" onLoad="onLoad();" style="padding:0">
<FORM NAME="LAYOUTFORM" ACTION="" METHOD=POST>

<div class="acc_leftMain">
		<!--header-->
		<div class="acc_header noFloat">
        	<span class="acc_backBTN" onClick="history.go(-1);">Quay lại tóm tắt lịch sử tài khoản</span>
        	<!--伸缩页码-->
            <div id="acc_pg" class="acc_pageDIV">页 <span id="now_page">1</span>/<span id="total_page">1</span>
                <div id="div_page" class="acc_pageG" style="display:none">
                <span class="acc_MINImenu_arr"></span>
                    <ul id="page">
                        <li id="page_0" class="acc_pageTitle">页</li>
                        <!--li>1</li>
                        <li>2</li>
                        <li>3</li-->
                    </ul>
                </div>
            </div>

        <h1 style="    font-weight: normal;padding:0;margin:0"><!--15 {MON} 2018--><?=$view_date[0]?><?=$his_year?><?=$view_date[1]?><?=$his_month?><?=$view_date[2]?><?=$his_day?></h1>
        </div>
<div id="div_show" style="" class="acc_openbetMain">

<table border="0" cellspacing="0" cellpadding="0" class="acc_openbetTB">
                        <tr>
                            <th width="30" nowrap><?=$bianhao?></th>
                            <th width="130" nowrap><?=$zhudan1?></th>
                            <th width="110" nowrap><?=$leixin?></th>
                            <th width="206"><?=$xuanxiang?></th>
                            <th width="80" nowrap><?=$touzhu?></th>
                            <th width="80" nowrap><?=$his_result?></th>
                            <th width="80" nowrap><?=$zhudan?></th>

                        </tr>
                        <?
                        if($langx=="zh-cn"){
                            $middle="middle";
                            $bettype="BetType";
                        }
                        if($langx=="zh-vn"){
                            $middle="middle_tw";
                            $bettype="BetType_tw";
                        }
                        if($langx=="en-us"){
                            $middle="middle_en";
                            $bettype="BetType_en";
                        }
                        $icount=0;
                        $score=0;
                        $m_res=0;
                        switch($gtype){
                            case 'FT':
                                $sql = "select MID,odd_type,status,danger,QQ526738 as ball,mid,active,showtype,date_format(BetTime,'%Y-%m-%d<br>%H:%i:%s') as BetTime,date_format(BetTime,'%m%d%H%i%s')+id as ID,$bettype as BetType,$middle as Middle,BetScore,M_Date,M_Result,M_Place,M_Rate,LineType,cancel,Q10000 from web_db_io where hidden=0 and active<3 and M_Name='$memname' and m_Date='$mDate' and result_type=1 order by orderby,bettime desc";
                                break;
                            case 'BK':
                                $sql = "select MID,odd_type,status,danger,QQ526738 as ball,mid,active,showtype,date_format(BetTime,'%Y-%m-%d<br>%H:%i:%s') as BetTime,date_format(BetTime,'%m%d%H%i%s')+id as ID,$bettype as BetType,$middle as Middle,BetScore,M_Date,M_Result,M_Place,M_Rate,LineType,cancel,Q10000 from web_db_io where hidden=0 and active=3 and M_Name='$memname' and m_Date='$mDate' and result_type=1 order by orderby,bettime desc";
                                break;
                            case 'TN':
                                $sql = "select MID,odd_type,status,danger,QQ526738 as ball,mid,active,showtype,date_format(BetTime,'%Y-%m-%d<br>%H:%i:%s') as BetTime,date_format(BetTime,'%m%d%H%i%s')+id as ID,$bettype as BetType,$middle as Middle,BetScore,M_Date,M_Result,M_Place,M_Rate,LineType,cancel,Q10000  from web_db_io where  hidden=0 and active=4 and M_Name='$memname' and m_Date='$mDate' and result_type=1 order by orderby,bettime desc";
                                break;
                            case 'VB':
                                $sql = "select MID,odd_type,status,danger,QQ526738 as ball,mid,active,showtype,date_format(BetTime,'%Y-%m-%d<br>%H:%i:%s') as BetTime,date_format(BetTime,'%m%d%H%i%s')+id as ID,$bettype as BetType,$middle as Middle,BetScore,M_Date,M_Result,M_Place,M_Rate,LineType,cancel,Q10000 from web_db_io where hidden=0 and active=5 and M_Name='$memname' and m_Date='$mDate' and result_type=1 order by orderby,bettime desc";
                                break;
                            case 'FS':
                                $sql = "select MID,odd_type,status,danger,QQ526738 as ball,mid,active,showtype,date_format(BetTime,'%Y-%m-%d<br>%H:%i:%s') as BetTime,date_format(BetTime,'%m%d%H%i%s')+id as ID,$bettype as BetType,$middle as Middle,BetScore,M_Date,M_Result,M_Place,M_Rate,LineType,cancel,Q10000 from web_db_io where hidden=0 and active=6 and M_Name='$memname' and m_Date='$mDate' and result_type=1 order by  orderby,bettime desc";
                                break;
                            default:
                                $sql = "select MID,odd_type,status,danger,QQ526738 as ball,mid,active,showtype,date_format(BetTime,'%Y-%m-%d<br>%H:%i:%s') as BetTime,date_format(BetTime,'%m%d%H%i%s')+id as ID,$bettype as BetType,$middle as Middle,BetScore,M_Date,M_Result,M_Place,M_Rate,LineType,cancel,Q10000 from web_db_io where hidden=0 and M_Name='$memname' and m_Date='$mDate' and result_type=1 order by orderby,bettime desc";
                                break;
                        }

                        $result = mysql_db_query($dbname,$sql);
                        //$row = mysql_fetch_array($result);
                        //$cou=mysql_num_rows($result);
                        $ss=1;
                        $jjj=0;
                        while ($row = mysql_fetch_array($result))
                        {
                            if($ss%2==1){
                                ?>
                                <tr class="his_even center">
                                <?
                            }else{?>
                                <tr class="his_first center">
                            <? }?>
                            <td align="center"><?=$ss?></td>
                            <td align="left"><?=show_voucher($row['LineType'],$row['ID'])?><br>
                                <?
                                $dateee=explode("-",$row['BetTime']);
                                $yy=explode("<br>",$dateee[2]);
                                if($langx=='zh-cn'){
                                    echo $dateee[1].'月'.$yy[0].'日,'.$yy[1];
                                }
                                if($langx=='zh-vn'){
                                    echo $dateee[1].'Tháng'.$yy[0].'Ngày,'.$yy[1];
                                }
                                if($langx=='en-us'){
                                    echo $dateee[1].'-'.$yy[0].' ,'.$yy[1];
                                }

                                ?>
                                <br>
                                <?
                                switch($row['odd_type']){
                                    case 'H':
                                        $pankou=$ODDS['HH'];
                                        break;
                                    case 'M':
                                        $pankou=$ODDS['MM'];
                                        break;
                                    case 'I':
                                        $pankou=$ODDS['II'];
                                        break;
                                    case 'E':
                                        $pankou=$ODDS['EE'];
                                        break;
                                }?>
                                (<?=$pankou?>)
                            </td>
                            <td align="center"><?=$row['BetType']?></td>
                            <td class="acc_oddDetailTD">
                                <?
                                //$middle=str_replace("<b>","",$row['Middle']);
                                //$middle=str_replace("</b>","",$middle);
                                if (($row['LineType']==7) or ($row['LineType']==8) or ($row['LineType']==17)){
                                    $middle=$row['Middle'];
                                }
                                else{
                                    $middle=$row['Middle'];
                                    $mid=explode("<FONT color=red>",$middle);
                                    $mid=explode("</FONT>",$mid[1]);
                                    $mid=$mid[0];
                                    $old="<FONT color=red>".$mid.'</FONT>';
                                    $new="<FONT color=red>(".$mid.')</FONT>';
                                    $middle=str_replace($old,$new,$middle);

                                    $midd=explode("<br>",$middle);
                                    $midd=$midd[2];
                                    $midd=explode("@",$midd);
                                    $midd=$midd[0];

                                    $midd1=str_replace("<b>","",$midd);
                                    $midd1=str_replace("</b>","",$midd1);
                                    $middle=str_replace($midd,$midd1,$middle);
                                    if($row['LineType']<>14 and $row['LineType']<>4 and $row['LineType']<>34 and $row['LineType']<>6){
                                        $m_rate=$row['M_Rate'];
                                        $m_rate1=number_format($m_rate,2);
                                        $m_rt=explode("<FONT color=#cc0000><b>",$middle);
                                        $m_rt=explode("<b></FONT>",$m_rt[1]);
                                        $m_rt=$m_rt[0];
                                        $middle=str_replace(trim($m_rt),$m_rate1,$middle);
                                    }

                                    $mid=explode("<br>",$middle);

                                    if($row['LineType']==101){//最先最后进球

                                        $mmmm=explode("&nbsp;&nbsp;vs.&nbsp;&nbsp",$mid[1]);
                                        switch($row['ball']){
                                            case "Away":
                                                $bb_ball=$mmmm[1];
                                                break;
                                            case "Home":
                                                $bb_ball=$mmmm[0];
                                                break;
                                            case "No":
                                                $bb_ball=$wujinqiu;
                                                break;
                                        }
                                        $mids=$mid[1]."<br><font color=\"#009900\"><b>".$bb_ball."</b></font> ";
                                        $middle=str_replace($mid[1]."<br>",$mids,$middle);
                                    }

                                    $middle1=str_replace("<FONT COLOR=#cc0000><b>","<FONT COLOR=#cc0000>",$mid[1]);
                                    $middle1=str_replace("<FONT COLOR=#CC0000><b>","<FONT COLOR=#cc0000>",$middle1);
                                    $middle1=str_replace("</b></FONT>","</FONT>",$middle1);
                                    $middle=str_replace($mid[1],$middle1,$middle);
                                }
                                echo $middle;
                                switch($row['danger']){
                                    case 1:
                                        echo '<div style="padding-left:20px; height:15px;color:#0033FF; font-weight:bold;background: url(/images/member/order_icon.gif) no-repeat  -220px 0px;">'.$weixian.'</div>';
                                        break;
                                    case 3:
                                        echo '<div style="padding-left:20px; height:15px;color:#009900; font-weight:bold;background: url(/images/member/order_icon.gif) no-repeat  -220px 0px;">'.$weixian1.'</div>';
                                        break;
                                    case 2:
                                        echo '<div style="padding-left:20px; height:15px;color:#FF0000; font-weight:bold;background: url(/images/member/order_icon.gif) no-repeat  -220px 0px;">'.$weixian2.'</div>';
                                        break;
                                    default:
                                        break;
                                }


                                ?>
                            </td>
                            <td><span class="fin_gold">
<?
if($row['status']>0){
    echo '<s>'.number_format($row['BetScore'],0).'</s>';
}else{
    echo number_format($row['BetScore'],0);
}
?>
</span>
                            </td>
                            <td>
                                <?
                                //print_r($wager_vars_re);
                                if($row['status']>0){
                                    echo '<font color=red>['.$wager_vars_re[$row['status']].']</font>';
                                }else{
                                    echo number_format($row['M_Result'],2);
                                }?>
                            </td>
                            <td>
                                <?
                                $ping1=$ping;
                                $ying1="<font color=green>".$ying."</font>";
                                $shu1=$shu;
                                $qq=str_replace("-1=",$shu1.'<br>',$row['Q10000']);
                                $qq=str_replace("1=",$ying1.'<br>',$qq);
                                $qq=str_replace("0=",$ping1.'<br>',$qq);
                                if ($row['LineType']==7 or $row['LineType']==8 or $row['LineType']==17){
                                    $mdiv=explode('<div class=statement_textbox2></div>',$qq);
                                    for($i=0;$i<sizeof($mdiv);$i++){

                                        $mqq=explode('<br>',$mdiv[$i]);
                                        $ma=$mqq[1];
                                        if($i==0){
                                            if(sizeof(explode(':',$mqq[1]))<=1){
                                                $div='<font color=red>['.$match_status[$ma].']</font><br>';
                                            }
                                            else{
                                                $div=$mqq[0].'<br>'.$res_half.$mqq[1].'<br>'.$res_total.$mqq[2].'<br>';
                                            }
                                        }
                                        else if($i==sizeof($mdiv)-1){
                                            if(sizeof(explode(':',$mqq[1]))<=1){
                                                $div='<font color=red>['.$match_status[$ma].']</font>';
                                            }else{
                                                $div='<br>'.$mqq[0].'<br>'.$res_half.$mqq[1].'<br>'.$res_total.$mqq[2];
                                            }
                                        }
                                        else{;
                                            if(sizeof(explode(':',$mqq[1]))<=1){
                                                $div='<br><font color=red>['.$match_status[$ma].']</font><br>';
                                            }else{
                                                $div='<br>'.$mqq[0].'<br>'.$res_half.$mqq[1].'<br>'.$res_total.$mqq[2].'<br>';
                                            }
                                        }

                                        $qq=str_replace($mdiv[$i],$div,$qq);
                                    }
                                }
                                else
                                {

                                    $mqq=explode('<br>',$qq);
                                    if(strlen($row['ball'])<3){
                                        $qq='<font color=red>['.$match_status[$row['ball']].']</font>';
                                    }else{
                                        if($mqq[1]==""){
                                            $q1="";
                                        }else{
                                            $q1='<br>'.$res_half.":".$mqq[1];
                                        }

                                        if($mqq[2]==""){
                                            $q2="";
                                        }else{
                                            $q2='<br>'.$res_total.":".$mqq[2];
                                        }
                                        $qq=$q1.$q2;

                                    }
                                    $qq=$mqq[0].$qq;
                                    //if($mqq[1]<>-1 and $mqq[2]<>-1){

                                    //}else{
                                    //	$qq=$mqq[0].'<br>'.'<font color=red>['.$wager_vars_re[$row['status']].']</font>';
                                    //}
                                }
                                echo $qq;
                                //echo "<br>".$res_half.":".$row1['MB_Inball']." - ".$row1['TG_Inball']."<br>".$res_total.":".$row1['MB_Inball_HR']." -".$row1['TG_Inball_HR'];
                                ?>
                            </td>
                            </tr>
                            <?
                            $icount+=1;
                            $score+=$row['BetScore'];
                            $m_res+=$row['M_Result'];
                            $ss=$ss+1;
                        }
                        ?>
                        <!--<tr class="sum_bar center">
                            <td colspan="4" class="right bold"><?=$yemian?>:</td>
                            <td><?=number_format($score,0)?></td>
                            <td><?=number_format($m_res,2)?></td>
                            <td>&nbsp;</td>
                            
                        </tr>
                        <tr class="sum_bar center">
                            <td colspan="4" class="right bold"><?=$his_count?>:</td>
                            <td><?=number_format($score,0)?></td>
                            <td><?=number_format($m_res,2)?></td>
                            <td>&nbsp;</td>
                            
                        </tr>-->
                    </table>
					<table cellspacing="0" cellpadding="0" class="acc_openbet_totalTB">

              <tbody><tr class="acc_openbet_total_top">
              	<td width="476" colspan="4" class="acc_openbet_total_txt"><?=$yemian?>:</td>
                <td width="84"><?=number_format($score,0)?></td>
                <td width="83"><?=number_format($m_res,2)?></td>
                <td width="83"></td>
              </tr>
              <tr class="acc_openbet_total_bottom">
              	<td colspan="4" class="acc_openbet_total_txt"><?=$his_count?>:</td>
                <td><?=number_format($score,0)?></td>
                <td><?=number_format($m_res,2)?></td>
                <td></td>
              </tr>
              <tr class="acc_openbet_page">
              	<td colspan="7"><div class="acc_openbet_pageDIV noFloat">
                	
					<div id="page_show" class="page_lis" style="display:none;">

                            <span onClick="changePage(-1);"  class="preious_btn" style="cursor:hand;" ><?=$shangye?></span><span class="line">|</span><span onClick="changePage(1);" class="next_btn" style="cursor:hand;"><?=$xiaye?></span>
                        </div>

                        <div id="no_page" class="page_none" style="display:none;">
                            <span  class="preious_btn" ><?=$shangye?></span><span class="line">|</span><span  class="next_btn" ><?=$xiaye?></span>

                        </div>
					</td>
              </tr>
            </tbody></table>
					


</div>
</div>



<!--
<table border="0" cellpadding="0" cellspacing="0" id="box">
  
  <tr>
    <td class="mem">
        <h2>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" id="fav_bar">
              <tr>
			  <td width="91" ><a href="./history_data.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=<?=$gtype?>&gdate=<?=$gdate?>&gdate1=<?=$gdate1?>" class="wag_btn_back"><?=$his_back_data?></a>
			  &nbsp;&nbsp;1 / 1 <?=$page?> <select id="page" name="page" onChange="self.LAYOUTFORM.submit()">
								<option value="0" SELECTED>1</option>

								</select>
                
                </td>
							<td class="right">
								<em><?=$view_date[0]?><?=$his_year?><?=$view_date[1]?><?=$his_month?><?=$view_date[2]?><?=$his_day?>  </em>
                </td>
                
              </tr>
            </table>
        </h2>
       <table border="0" cellspacing="0" cellpadding="0" class="game">
         <tr>
           <th width="30" nowrap><?=$bianhao?></th> 
          <th width="130" nowrap><?=$zhudan1?></th>
          <th width="110" nowrap><?=$leixin?></th>
          <th width="206"><?=$xuanxiang?></th>
          <th width="80" nowrap><?=$touzhu?></th>
          <th width="80" nowrap><?=$his_result?></th>
          <th width="80" nowrap><?=$zhudan?></th>
         
        </tr>
				<?
		if($langx=="zh-cn"){
$middle="middle";
$bettype="BetType";
}
if($langx=="zh-vn"){
$middle="middle_tw";
$bettype="BetType_tw";
}
if($langx=="en-us"){
$middle="middle_en";
$bettype="BetType_en";
}
$icount=0;
$score=0;
$m_res=0;
switch($gtype){
case 'FT':
	$sql = "select MID,odd_type,status,danger,QQ526738 as ball,mid,active,showtype,date_format(BetTime,'%Y-%m-%d<br>%H:%i:%s') as BetTime,date_format(BetTime,'%m%d%H%i%s')+id as ID,$bettype as BetType,$middle as Middle,BetScore,M_Date,M_Result,M_Place,M_Rate,LineType,cancel,Q10000 from web_db_io where hidden=0 and active<3 and M_Name='$memname' and m_Date='$mDate' and result_type=1 order by orderby,bettime desc";
	break;
case 'BK':
	$sql = "select MID,odd_type,status,danger,QQ526738 as ball,mid,active,showtype,date_format(BetTime,'%Y-%m-%d<br>%H:%i:%s') as BetTime,date_format(BetTime,'%m%d%H%i%s')+id as ID,$bettype as BetType,$middle as Middle,BetScore,M_Date,M_Result,M_Place,M_Rate,LineType,cancel,Q10000 from web_db_io where hidden=0 and active=3 and M_Name='$memname' and m_Date='$mDate' and result_type=1 order by orderby,bettime desc";
	break;
case 'TN':
	$sql = "select MID,odd_type,status,danger,QQ526738 as ball,mid,active,showtype,date_format(BetTime,'%Y-%m-%d<br>%H:%i:%s') as BetTime,date_format(BetTime,'%m%d%H%i%s')+id as ID,$bettype as BetType,$middle as Middle,BetScore,M_Date,M_Result,M_Place,M_Rate,LineType,cancel,Q10000  from web_db_io where  hidden=0 and active=4 and M_Name='$memname' and m_Date='$mDate' and result_type=1 order by orderby,bettime desc";
	break;
case 'VB':
	$sql = "select MID,odd_type,status,danger,QQ526738 as ball,mid,active,showtype,date_format(BetTime,'%Y-%m-%d<br>%H:%i:%s') as BetTime,date_format(BetTime,'%m%d%H%i%s')+id as ID,$bettype as BetType,$middle as Middle,BetScore,M_Date,M_Result,M_Place,M_Rate,LineType,cancel,Q10000 from web_db_io where hidden=0 and active=5 and M_Name='$memname' and m_Date='$mDate' and result_type=1 order by orderby,bettime desc";
	break;
case 'FS':
	$sql = "select MID,odd_type,status,danger,QQ526738 as ball,mid,active,showtype,date_format(BetTime,'%Y-%m-%d<br>%H:%i:%s') as BetTime,date_format(BetTime,'%m%d%H%i%s')+id as ID,$bettype as BetType,$middle as Middle,BetScore,M_Date,M_Result,M_Place,M_Rate,LineType,cancel,Q10000 from web_db_io where hidden=0 and active=6 and M_Name='$memname' and m_Date='$mDate' and result_type=1 order by  orderby,bettime desc";
	break;
default:
	$sql = "select MID,odd_type,status,danger,QQ526738 as ball,mid,active,showtype,date_format(BetTime,'%Y-%m-%d<br>%H:%i:%s') as BetTime,date_format(BetTime,'%m%d%H%i%s')+id as ID,$bettype as BetType,$middle as Middle,BetScore,M_Date,M_Result,M_Place,M_Rate,LineType,cancel,Q10000 from web_db_io where hidden=0 and M_Name='$memname' and m_Date='$mDate' and result_type=1 order by orderby,bettime desc";
	break;
}

$result = mysql_db_query($dbname,$sql);
//$row = mysql_fetch_array($result);
//$cou=mysql_num_rows($result);
$ss=1;
$jjj=0;
while ($row = mysql_fetch_array($result))
{
	if($ss%2==1){
?>
      <tr class="his_even center">
	  <?
	  }else{?>
	  <tr class="his_first center">
	  <? }?>
	 <td align="center"><?=$ss?></td>
	 <td align="left"><?=show_voucher($row['LineType'],$row['ID'])?><br>
<?
		$dateee=explode("-",$row['BetTime']);
		$yy=explode("<br>",$dateee[2]);
		if($langx=='zh-cn'){
		echo $dateee[1].'月'.$yy[0].'日,'.$yy[1];
		}
		if($langx=='zh-vn'){
		echo $dateee[1].'Tháng'.$yy[0].'Ngày,'.$yy[1];
		}
		if($langx=='en-us'){
		echo $dateee[1].'-'.$yy[0].' ,'.$yy[1];
		}
		
?>
		<br>
		<? 
	switch($row['odd_type']){
		case 'H':
			$pankou=$ODDS['HH'];
			break;
		case 'M':
			$pankou=$ODDS['MM'];
			break;
		case 'I':
			$pankou=$ODDS['II'];
			break;
		case 'E':
			$pankou=$ODDS['EE'];
			break;
	}?>
	(<?=$pankou?>)
	</td> 
	<td align="center"><?=$row['BetType']?></td>
	<td class="his_name">
<?
		//$middle=str_replace("<b>","",$row['Middle']);
		//$middle=str_replace("</b>","",$middle);
		if (($row['LineType']==7) or ($row['LineType']==8) or ($row['LineType']==17)){
			$middle=$row['Middle'];
		}
		else{
		$middle=$row['Middle'];
		$mid=explode("<FONT color=red>",$middle);
		$mid=explode("</FONT>",$mid[1]);
		$mid=$mid[0];
		$old="<FONT color=red>".$mid.'</FONT>';
		$new="<FONT color=red>(".$mid.')</FONT>';
		$middle=str_replace($old,$new,$middle);
		
		$midd=explode("<br>",$middle);
		$midd=$midd[2];
		$midd=explode("@",$midd);
		$midd=$midd[0];
		
		$midd1=str_replace("<b>","",$midd);
		$midd1=str_replace("</b>","",$midd1);
		$middle=str_replace($midd,$midd1,$middle);
		if($row['LineType']<>14 and $row['LineType']<>4 and $row['LineType']<>34 and $row['LineType']<>6){
			$m_rate=$row['M_Rate'];
			$m_rate1=number_format($m_rate,2);
			$m_rt=explode("<FONT color=#cc0000><b>",$middle);
			$m_rt=explode("<b></FONT>",$m_rt[1]);
			$m_rt=$m_rt[0];
			$middle=str_replace(trim($m_rt),$m_rate1,$middle);
		}
		
		$mid=explode("<br>",$middle);
		
		if($row['LineType']==101){//最先最后进球
		
			$mmmm=explode("&nbsp;&nbsp;vs.&nbsp;&nbsp",$mid[1]);
			switch($row['ball']){
				case "Away":
					$bb_ball=$mmmm[1];
					break;
				case "Home":
					$bb_ball=$mmmm[0];
					break;
				case "No":
					$bb_ball=$wujinqiu;
					break;
			}
			$mids=$mid[1]."<br><font color=\"#009900\"><b>".$bb_ball."</b></font> ";
			$middle=str_replace($mid[1]."<br>",$mids,$middle);
		}
		
		$middle1=str_replace("<FONT COLOR=#cc0000><b>","<FONT COLOR=#cc0000>",$mid[1]);
		$middle1=str_replace("<FONT COLOR=#CC0000><b>","<FONT COLOR=#cc0000>",$middle1);
		$middle1=str_replace("</b></FONT>","</FONT>",$middle1);
		$middle=str_replace($mid[1],$middle1,$middle);
		}
		echo $middle;
	switch($row['danger']){
case 1:
	echo '<div style="padding-left:20px; height:15px;color:#0033FF; font-weight:bold;background: url(/images/member/order_icon.gif) no-repeat  -220px 0px;">'.$weixian.'</div>';
	break;
case 3:
	echo '<div style="padding-left:20px; height:15px;color:#009900; font-weight:bold;background: url(/images/member/order_icon.gif) no-repeat  -220px 0px;">'.$weixian1.'</div>';
	break;
case 2:
	echo '<div style="padding-left:20px; height:15px;color:#FF0000; font-weight:bold;background: url(/images/member/order_icon.gif) no-repeat  -220px 0px;">'.$weixian2.'</div>';
	break;
default:
	break;
	}
	
	
	?>
	</td>
	<td><span class="fin_gold">
<?
	if($row['status']>0){
	echo '<s>'.number_format($row['BetScore'],0).'</s>';
}else{
	echo number_format($row['BetScore'],0);
}
?>
</span>
</td>
      <td>
      	<?
      	//print_r($wager_vars_re);
    	if($row['status']>0){
    		echo '<font color=red>['.$wager_vars_re[$row['status']].']</font>';
    	}else{
    		echo number_format($row['M_Result'],2);
    	}?>
		</td>
<td>
<? 
	$ping1=$ping;
	$ying1="<font color=green>".$ying."</font>";
	$shu1=$shu;
	$qq=str_replace("-1=",$shu1.'<br>',$row['Q10000']);
	$qq=str_replace("1=",$ying1.'<br>',$qq);
 	$qq=str_replace("0=",$ping1.'<br>',$qq);
	if ($row['LineType']==7 or $row['LineType']==8 or $row['LineType']==17){
		$mdiv=explode('<div class=statement_textbox2></div>',$qq);
		 for($i=0;$i<sizeof($mdiv);$i++){
		 	
		 	$mqq=explode('<br>',$mdiv[$i]);
			$ma=$mqq[1];
			if($i==0){ 
				if(sizeof(explode(':',$mqq[1]))<=1){
					$div='<font color=red>['.$match_status[$ma].']</font><br>';
				}
				else{
					$div=$mqq[0].'<br>'.$res_half.$mqq[1].'<br>'.$res_total.$mqq[2].'<br>';
				}
			}
			else if($i==sizeof($mdiv)-1){
				if(sizeof(explode(':',$mqq[1]))<=1){
					$div='<font color=red>['.$match_status[$ma].']</font>';
				}else{
					$div='<br>'.$mqq[0].'<br>'.$res_half.$mqq[1].'<br>'.$res_total.$mqq[2];
				}
			}
			else{;
				if(sizeof(explode(':',$mqq[1]))<=1){
					$div='<br><font color=red>['.$match_status[$ma].']</font><br>';
				}else{
					 $div='<br>'.$mqq[0].'<br>'.$res_half.$mqq[1].'<br>'.$res_total.$mqq[2].'<br>';
				}
			}
			
			$qq=str_replace($mdiv[$i],$div,$qq);
		 }
	}
	else
	{
	
		$mqq=explode('<br>',$qq);
		if(strlen($row['ball'])<3){
    		$qq='<font color=red>['.$match_status[$row['ball']].']</font>';
    	}else{
			if($mqq[1]==""){
				$q1="";
			}else{
				$q1='<br>'.$res_half.":".$mqq[1];
			}
			
			if($mqq[2]==""){
				$q2="";
			}else{
				$q2='<br>'.$res_total.":".$mqq[2];
			}
    		$qq=$q1.$q2;
			
    	}
		$qq=$mqq[0].$qq;
		//if($mqq[1]<>-1 and $mqq[2]<>-1){
			
		//}else{
		//	$qq=$mqq[0].'<br>'.'<font color=red>['.$wager_vars_re[$row['status']].']</font>';
		//}
	}
	echo $qq;
	//echo "<br>".$res_half.":".$row1['MB_Inball']." - ".$row1['TG_Inball']."<br>".$res_total.":".$row1['MB_Inball_HR']." -".$row1['TG_Inball_HR'];
?>
</td>
</tr>
	<?
	$icount+=1;
	$score+=$row['BetScore'];
	$m_res+=$row['M_Result'];
	$ss=$ss+1;
}
?>
<tr class="sum_bar center">
           <td colspan="4" class="right bold"><?=$yemian?>:</td>
          <td><?=number_format($score,0)?></td>
          <td><?=number_format($m_res,2)?></td>
          <td>&nbsp;</td>
         
        </tr>
        <tr class="sum_bar center">
           <td colspan="4" class="right bold"><?=$his_count?>:</td>
          <td><?=number_format($score,0)?></td>
          <td><?=number_format($m_res,2)?></td>
          <td>&nbsp;</td>
          
        </tr>
      </table> 
  <h3 id="page_bar">
        
            <div id="page_show" class="page_lis" style="display:none;">
          
              <span onClick="changePage(-1);"  class="preious_btn" style="cursor:hand;" ><?=$shangye?></span><span class="line">|</span><span onClick="changePage(1);" class="next_btn" style="cursor:hand;"><?=$xiaye?></span>
          </div>
          
           <div id="no_page" class="page_none" style="display:none;">
                <span  class="preious_btn" ><?=$shangye?></span><span class="line">|</span><span  class="next_btn" ><?=$xiaye?></span>
          
          </div>  
      </h3>-->	</td>
  </tr>
  <tr><td id="foot"><b>&nbsp;</b></td></tr>
</table>
</form>    
</body>
</html>
<?
}
mysql_close();
?>
