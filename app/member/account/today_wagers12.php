<?

include "../include/library.mem.php";

echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";

require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
$mtype=$_REQUEST['mtype'];
$chk_cw=$_REQUEST['chk_cw'];
$chk_cw1=$_REQUEST['chk_cw'];
$mDate=date('Y-m-d');
$sql = "select * from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}else{

	$row = mysql_fetch_array($result);
	$memname=$row['Memname'];
	//$langx=$row['language'];
	require ("../include/traditional.$langx.inc.php");
	if ($chk_cw=='' or $chk_cw=='Y'){
		$chk_cw='N';
		$ncancel=" and (status=0 or status<>2 or status<>3) and result_type=0 ";
		$caption=$tod_cancel;
	}else{
		$chk_cw='Y';
		$ncancel=" and status>0 and status<>2 and status<>3 ";//and m_date='".date('Y-m-d')."'
		$caption=$tod_youxiao;
	}

	$tDate='';
	$sumnum=0;
	$sumbet=0;
	$sumwin=0;

	?>
	<html>
	<head>
		<title>today_wagers_fail</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="/style/member/reset.css" rel="stylesheet" type="text/css">
		<link href="/style/member/my_account.css" rel="stylesheet" type="text/css">
		<style type="text/css">
			<!--
			.b_rig_mor { background-color:#EDEDED; text-align:right }
			-->
		</style>

		<script>
			function wagers_sta(cw){
				self.location='./today_wagers.php?uid=<?=$uid?>&langx=<?=$langx?>&chk_cw='+cw;

			}

			function changePage(page){
				var pages=document.getElementById('page').length;
				var now_page=document.getElementById('page').selectedIndex;
				if (now_page+page+1 > pages || now_page+page < 0){
					//alert("Χ");
				}else{
					document.getElementById('page').selectedIndex=now_page+page;
					LAYOUTFORM.submit();
				}
			}
			function onLoad(){

				var pages=document.getElementById('page').length;
				if(pages <= 1){
					//alert(">>>>>>>>>");
					document.getElementById("no_page").style.display = "";

					document.getElementById("page_show").style.display = "none";


				}else{
					document.getElementById("no_page").style.display = "none";

					document.getElementById("page_show").style.display = "";

				}
			}
			function reload_var(){
//self.location.reload();
//window.location.href=window.location;
				var pages=document.getElementById('page').length;
				var now_page=document.getElementById('page').selectedIndex;
//self.location='./today_wagers.php?uid=5075ff92m6511302l52193697&langx=zh-cn&page='+now_page &chk_cw='+cw;
				self.location='./today_wagers.php?uid=<?=$uid?>&langx=<?=$langx?>&chk_cw=<?=$chk_cw1?>&page='+now_page;
			}
		</script>
	</head>
	<body id="MWAG" onLoad="onLoad();">
	<FORM NAME="LAYOUTFORM" ACTION="" METHOD=POST>
		<table border="0" cellpadding="0" cellspacing="0" id="box">
			<tr>
				<td class="top">
					<h1><em><?=$WagerCondition1?></em></h1>
				</td>
			</tr>
			<tr>
				<td class="mem">
					<h2>
						<table width="100%" border="0" cellpadding="0" cellspacing="0" id="fav_bar">
							<tr>
								<td id="page_no">&nbsp;&nbsp;1 / 1 <?=$page?> <select id="page" name="page" onChange="self.LAYOUTFORM.submit()">
										<option value="0" SELECTED>1</option>

									</select>
								</td>
								<td class="his_refresh" ><!--딵--><div onClick="javascript:reload_var()"><font id="refreshTime"></font></div></td>
								<td>&nbsp;</td>
								<td class="right">
									<?
									if($langx=="zh-cn"){
										$middle="middle";
										$bettype="BetType";
										$pankou="pankou";
									}
									if($langx=="zh-vn"){
										$middle="middle_tw";
										$bettype="BetType_tw";
										$pankou="pankou_tw";
									}
									if($langx=="en-us"){
										$middle="middle_en";
										$bettype="BetType_en";
										$pankou="pankou_en";
									}
									$sql1 = "select odd_type,status,danger,active,cancel,M_Date,date_format(BetTime,'%m-%d <br> %H:%i:%s') as BetTime,date_format(BetTime,'%m%d%H%i%s')+id as ID,LineType,$bettype as BetType,$middle as Middle,BetScore,Gwin from web_db_io where  hidden=0 and M_Name='$memname' and status>0 and status<>2 and status<>3  order by orderby,id desc";//m_date>='$mDate' and
									$result1 = mysql_db_query($dbname,$sql1);
									$cou1=mysql_num_rows($result1);
									if($cou1==0){
										?><span class="wag_btn2" ><?=$nyou?><span class="wag_none"> (<?=$cou1?>) </span><?=$quxiao?></span>
									<? }else{?>
										<span onClick="wagers_sta('<?=$chk_cw?>');"  class="wag_btn" ><?=$nyou?><span class="wag_none"> (<?=$cou1?>) </span><?=$quxiao?></span>

									<? }?>
								</td>

							</tr>
						</table>
					</h2>
					<table border="0" cellspacing="0" cellpadding="0" class="game">
						<?
						$sql = "select odd_type,status,danger,active,cancel,M_Date,date_format(BetTime,'%m-%d <br> %H:%i:%s') as BetTime,date_format(BetTime,'%m%d%H%i%s')+id as ID,LineType,$bettype as BetType,$middle as Middle,BetScore,Gwin,M_Rate from web_db_io where  hidden=0 and M_Name='$memname' ".$ncancel." order by BetTime desc";//m_date>='$mDate' and
						$result = mysql_db_query($dbname,$sql);
						$cou=mysql_num_rows($result);
						if($cou==0){
							?>
							<tr >
								<td height="70" class="his_even center"><?=$wager?></td>
							</tr>
							<?
						}else{
						?>
						<tr>
							<th width="5%"><?=$bianhao?></th>
							<th width="25%"><?=$zhudan1?></th>
							<th width="15%"><?=$leixin?></th>
							<th width="25%"><?=$xuanxiang?></th>
							<th width="10%"><?=$touzhu?></th>
							<th width="10%"><?=$key?></th>
							<th width="10%"><?=$zhudan?></th>
							<!--th width="12%">Ӯ</th>
                            <th width="12%">IP</th-->
						</tr>
						<?
						$m=1;
						while ($row = mysql_fetch_array($result))
						{
							if($row['M_Date']>$mDate){
								//$tDate='<b>'.$row['M_Date'].'</b>';
								if (($row['LineType']==7) or ($row['LineType']==8) or ($row['LineType']==17)){
									$middle=$row['Middle'];
								}else{
									if($row['active']<>6){
										$data1=explode("<br>",$row['Middle']);
										$middle=$data1[0].'<br>';
										$middle=$middle;
										for($j=1;$j<sizeof($data1);$j++){
											$middle=$middle.$data1[$j].'<br>';
										}
									}else{
										$data1=explode("<br>",$row['Middle']);

										$middle="<font color=#000000>$tDate</font>&nbsp;&nbsp;&nbsp;";
										for($j=0;$j<sizeof($data1);$j++){
											$middle=$middle.$data1[$j].'<br>';
										}
									}
								}
								$css='_mor';
							}else{
								$css='';
								$middle=$row['Middle'];
							}
							//.''. date("d",strtotime($row['BetTime'])).' '.date("H:i:s",strtotime($row['BetTime']))
							if($m%2==1){
								?>
								<tr class="his_even center">
								<?
							}else{?>
								<tr class="his_first center">
							<? }?>
							<td><?=$m?></td>
							<td class="left"><span class="his_wag"><?=show_voucher($row['LineType'],$row['ID'])?></span><BR>
								<?
								$dateee=explode("-",$row['BetTime']);
								$yy=explode("<br>",$dateee[1]);
								if($langx=='zh-cn'){
									echo $dateee[0].'月'.$yy[0].'日,'.$yy[1];
								}
								if($langx=='zh-vn'){
									echo $dateee[0].'Tháng'.$yy[0].'Ngày,'.$yy[1];
								}
								if($langx=='en-us'){
									echo $dateee[0].'-'.$yy[0].' ,'.$yy[1];
								}
								?><br>
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
								(<?=$pankou?>)</td>
							<td><?=$row['BetType'];?>
							</td>
							<td class="his_name">
								<?
								//$middle=str_replace("<b>","",$middle);
								//$middle=str_replace("</b>","",$middle);
								if (($row['LineType']==7) or ($row['LineType']==8) or ($row['LineType']==17)){

								}
								else{
									$mid=explode("<FONT color=red>",$middle);
									$mid=explode("</FONT>",$mid[1]);
									$mid=$mid[0];
									$mid=str_replace("<b>","",$mid);
									$mid=str_replace("</b>","",$mid);
									$old="<FONT color=red><b>".$mid."</b></FONT>";
									$new="<FONT color=red><b>(".$mid.")</FONT></b>";
									$middle;
									$middle=str_replace($old,$new,$middle);

									$midd=explode("<br>",$middle);
									$midd=$midd[2];
									$middl=$midd[2];
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
									$middle1=str_replace("<FONT COLOR=#cc0000><b>","<FONT COLOR=#cc0000>",$mid[1]);
									$middle1=str_replace("<FONT COLOR=#CC0000><b>","<FONT COLOR=#cc0000>",$middle1);
									$middle1=str_replace("</b></FONT>","</FONT>",$middle1);
									$middle=str_replace($mid[1],$middle1,$middle);
								}
								echo $middle;
								?>
								<?
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
							<td><span class="fin_gold"><?
									if($row['status']>0){
										echo '<s>'.number_format($row['BetScore'],0).'</s>';
									}else{
										echo number_format($row['BetScore'],0);
									}
									?></span></td>
							<td><?
								echo number_format($row['Gwin'],2);?></td>
							<td><?
								if($row['status']>0){
									echo '<b><font color=red>['.$wager_vars_re[$row['status']].']</td>';
								}else{
									echo $jiesuan;
								}?></td>
							<!--td>δ</td>
                            <td></td-->
							</tr>
							<?
							$sumwin=$sumwin+$row['Gwin'];
							$sumnum=$sumnum+1;
							$sumbet=$sumbet+$row['BetScore'];
							$tDate='';
							$m=$m+1;
						}
						?>
						<tr class="sum_bar center">
							<td colspan="4" class="right bold"><?=$yemian?>:</td>
							<td><?=number_format($sumbet,0)?></td>
							<td><?=number_format($sumwin,2)?></td>
							<td>&nbsp;</td>
							<!--td>112.7</td>
                            <td>&nbsp;</td-->
						</tr>
					</table>
					<?

					}
					?>
					<h3 id="page_bar">
						<div id="page_show" class="page_lis" style="display:none;">

							<span onClick="changePage(-1);"  class="preious_btn" style="cursor:hand; cursor:pointer;" ><?=$shangye?></span><span class="line">|</span><span onClick="changePage(1);" class="next_btn" style="cursor:hand; cursor:pointer;"><?=$xiaye?></span>
						</div>

						<div id="no_page" class="page_none" style="display:none;">
							<span  class="preious_btn" ><?=$shangye?></span><span class="line">|</span><span  class="next_btn" ><?=$xiaye?></span>

						</div>
					</h3>
				</td>
			</tr>
			<tr><td id="foot"><b>&nbsp;</b></td></tr>
		</table>
	</form>

	</body>
	</html>
	<?
}
?>
<iframe name='message' src='../readmsg.php?uid=<?=$uid?>&user=<?=$memname?>&langx=<?=$langx?>' style='width:0px;height:0px'>
