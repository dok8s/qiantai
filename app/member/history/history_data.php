<?

include "../include/library.mem.php";

echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../include/define_function_list.inc.php");
require ("../include/config.inc.php");
$uid=$_REQUEST["uid"];
$langx=$_REQUEST["langx"];
$mtype=$_REQUEST['mtype'];
require ("../include/traditional.$langx.inc.php");

$sumall=0;
$rsumall=0;
$sql = "select id,Memname from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}else{

	$row = mysql_fetch_array($result);
	$memname=$row['Memname'];
	$mid=$row['id'];
	$gtype=strtoupper($_REQUEST['gtype']);
//userlog($memname);
	if ($gtype=='' or $gtype=='ALL'){
		$gtype='ALL';
		$style='_fu';
		$active='';
	}else if($gtype=='FT'){
		$style='';
		$active=' and (active=1 or active=2)';
	}else{
		$style='_'.strtolower($gtype);
		switch($gtype){
		case 'BK':
			$active=' and active=3';
			break;
		case 'TN':
			$active=' and active=4';
			break;
		case 'VB':
			$active=' and active=5';
			break;
		case 'BS':
			$active=' and active=7';
			break;
		case 'FS':
			$active=' and active=6';
			break;
		default:
			$active=' and active=8';
			break;
		}
	}

	$s_gdate=$gdate=$_REQUEST['gdate'];
	$s_gdate1=$gdate1=$_REQUEST['gdate1'];
	if ($gdate=='' or $gdate1==''){
		$gdate1=date('Y-m-d');
		$gdate=date('Y-m-d',time()-24*60*60);
	}
	$xq = array("$week7","$week1","$week2","$week3","$week4","$week5","$week6");

	?>
<html>
<head>
<title>history_data</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_body_ft.css" type="text/css">
<link rel="stylesheet" href="/style/member/mem_body_his.css" type="text/css">

<script> 
function onLoad(){
	var select_object = document.getElementById("gtype");
	select_object.value = '<?php echo $gtype?>';	
}
function changeGtpye(){
	if(on_Submit())sel_gtype.submit();
}
function changeUrl(a){
 self.location=a;
//alert(a);
}
function overbars(obj,color){
  //alert(obj.cells["d_date"].className);
  var className=obj.cells["d_date"].className;
  if (className=="his_list_none") return;  
	obj.cells["d_date"].className=color;
 
}
function outbars(obj,color){
var className=obj.cells["d_date"].className;
  if (className=="his_list_none") return;
	obj.cells["d_date"].className=color;
	//alert("out--"+obj.cells["d_date"].className);
}
 
function on_Submit(){
	if (document.getElementById("gdate").value > document.getElementById("gdate1").value){
		alert("日期区间错误!");
		return false;
	}
	return true;
}
</script>
</head>

<body id="Mall" class="bodyset HIS" onLoad="onLoad()">
<table border="0" cellpadding="0" cellspacing="0" id="box">
  <tr>
    <td class="top">
  	  <h1><em><?=$AccountHistory1?></em></h1>
	</td>
  </tr>
  <tr>
    <td class="mem">
    <h2><form method="post" onSubmit="return on_Submit()" style="display:inline;">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" id="fav_bar">
              <tr>
                <td>
                <?=$jlu?>: 
                 
	      <select name="gtype">
           <option value="ALL" ><?=$sel_all?></option>
           <option value="FT" ><?=$Soccer?></option>
           <option value="BK" ><?=$BasketBall."&".$mszq?></option>
    	   <option value="TN" ><?=$Tennis?></option>
    	   <option value="BS" ><?=$bangqiu?></option>
    	   <option value="VB" ><?=$Voll?></option>
		   <option value="FS" ><?=$spmatch?></option>
      	    <option value="OP"><?=$qita?></option></select>
          <input type=submit value="<?=$tod_search?>">
     
                </td>
				 <td>日期: </td>
	                  <td>
	                  	<select id="gdate" name="gdate" class="za_select">
										
						<? for($i=-7;$i<=0;$i++){
							if($s_gdate==''){
								if($i==-7){ 
						?>
											<option value=<?=date('Y-m-d',strtotime("-7 day"))?>  SELECTED><?=date('Y-m-d',strtotime("-7 day"))?></option>
								<? }else{?>
											<option value=<?=date('Y-m-d',strtotime($i." day"))?> ><?=date('Y-m-d',strtotime($i." day"))?></option>
								<? }?>		
						<? }else{
						
							if($gdate==date('Y-m-d',strtotime($i." day"))){
						?>
							<option value=<?=date('Y-m-d',strtotime($i." day"))?> SELECTED><?=date('Y-m-d',strtotime($i." day"))?></option>
						<?	
							}else{
						?>
							<option value=<?=date('Y-m-d',strtotime($i." day"))?>><?=date('Y-m-d',strtotime($i." day"))?></option>
						<?	
							}
							}
						}
						?>
											</select>
										</td>
	                  <td>到</td>
	                  <td>
	                  	<select id="gdate1" name="gdate1" class="za_select">
						<? for($i=-7;$i<=0;$i++){
							if($s_gdate1==''){
								if($i==0){
						?>
											<option value=<?=date('Y-m-d')?>  SELECTED><?=date('Y-m-d')?></option>
								<? }else{?>
											<option value=<?=date('Y-m-d',strtotime($i." day"))?> ><?=date('Y-m-d',strtotime($i." day"))?></option>
								<? }?>		
						<? }else{
						
							if($gdate1==date('Y-m-d',strtotime($i." day"))){
						?>
							<option value=<?=date('Y-m-d',strtotime($i." day"))?> SELECTED><?=date('Y-m-d',strtotime($i." day"))?></option>
						<?	
							}else{
						?>
							<option value=<?=date('Y-m-d',strtotime($i." day"))?>><?=date('Y-m-d',strtotime($i." day"))?></option>
						<?	
							}
							}
						}
						?>
											</select>
	                  </td>
	                  <td><input type="submit" value="搜寻"></td>

              </tr>
            </table>
			</form>
          </h2>
    
    <table border="0" cellspacing="0" cellpadding="0" class="game">
      <tr> 
        <th class="his_time"><?=$his_date?></th>
        <th class="his_wag" ><?=$his_score?></th>
        <th class="his_wag"><?=$his_have?></th>
        <th class="his_wag"><?=$his_result?></th>
        <!--th width="25%">Ч~</th-->
      </tr>
	  <?
	if ($gdate>$gdate1){
		$t      = $gdate;
		$gdate  = $gdate1;
		$gdate1  = $t;
	}
	$Date_List_1=explode("-",$gdate1);
	$Date_List_2=explode("-",$gdate);
	$Date_List_3=explode("-",date('Y-m-d'));
	$d1=mktime(0,0,0,$Date_List_1[1],$Date_List_1[2],$Date_List_1[0]);
	$d2=mktime(0,0,0,$Date_List_2[1],$Date_List_2[2],$Date_List_2[0]);
	$d3=mktime(0,0,0,$Date_List_3[1],$Date_List_3[2],$Date_List_3[0]);
	if($s_gdate=='' and $s_gdate1==''){
		$days=7;
		$ff=0;
	}else{
		$days=round(($d1-$d2)/3600/24);
		$ff=0-round(($d3-$d1)/3600/24);
	}
	$ss=1;

	for($i=$days;$i>=0;$i--)
	{
	if($ff==0){
	$today=date("m".$his_month."d".$his_day.' ').$week.$xq[date("w",time())];
	}
	else
	{
	$today=date("m".$his_month."d".$his_day.' ',strtotime("$ff day")).$week.$xq[date("w",date(strtotime("$ff day")))];
	}

		//$t=$d2+$i*$dd;
		//date("Y-m-d",strtotime("-1 day")),
		//$today=date('m-d ',$t).$week.$xq[date("w",$t)];
		$sql="select sum(vgold) as vgold,sum(if((odd_type='I' and m_rate<0),abs(m_rate)*betscore,betscore)) as betscore,sum(m_result) as m_result from web_db_io where hidden=0 and result_type=1 and m_date='".date('Y-m-d',strtotime("$ff day"))."' and m_name='$memname'".$active;
		$result = mysql_db_query($dbname,$sql);
		$row = mysql_fetch_array($result);
		$sum=number_format($row['betscore']+0,0);


		$rsum=number_format($row['m_result']+0,2);
		$rsum1=number_format($row['vgold']+0,0);
		if($sum==0){$sum="-";}
		if($rsum==0){$rsum="-";}
		if($rsum1==0){$rsum1="-";}
		$aa=$aa+$row['betscore'];
		$bb=$bb+$row['m_result'];
		$vgold=$vgold+$row['vgold'];

		if($sum>0){
            $link='<span onClick=changeUrl("'."history_view.php?uid=$uid&member_id=$mid&tmp_flag=N&today_gmt=".date('Y-m-d',strtotime("$ff day"))."&gtype=$gtype&gdate=$gdate&gdate1=$gdate1&langx=$langx".'")><strong><a href="#">'.$today.'</a></strong></span>';
        }else{
		    $link='<span >'.$today.'</span>';
		}
		if($ss%2==0){
		$tt=2;
		}
		else{
		$tt=1;
		}
		$his1='his_over';
		$his2='his_list';

		echo '<tr class="color_bg'.$tt.'" onMouseOver="overbars(this,'.$his1.');" onMouseOut="outbars(this,'.$his2.')" >
        <td class="his_list_none" id="d_date">'.$link.'</td>
	    <td class="his_td"   ><span class="fin_gold">'.$sum.'</span></td>
		<td class="his_td" >'.$rsum1.'</td>
	    <td class="his_td" >'.$rsum.'</td>
		</tr>';
		$ss=$ss+1;
		$ff=$ff-1;
	}
	?>


      <tr class="sum_bar right">
        <td class="center his_total"><?=$his_count?></td>
        <td class="his_total"><?=number_format($aa,0)?></td>
        <td class="his_total"><?=number_format($vgold,0)?></td>
        <td class="his_total"><?=number_format($bb,0)?></td>
        <!--td>474</td-->
      </tr>
    </table> 
	</td>
  </tr>
  <tr><td id="foot"><b>&nbsp;</b></td></tr>
</table>
</body>
</html>
<?
}
?>
<iframe name='message' src='../readmsg.php?uid=<?=$uid?>&user=<?=$memname?>&langx=<?=$langx?>' style='width:0px;height:0px'>

