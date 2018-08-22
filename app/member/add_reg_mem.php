<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<?
include "include/address.mem.php";
require ("include/config.inc.php");
require ("include/define_function_list.inc.php");

$sql = "select setdata from web_system limit 0,1";
$result = mysql_query( $sql );
$rt = mysql_fetch_array( $result );
$setdata = @unserialize($rt['setdata']);

$default_agent=$setdata['default_agent'];
$setdata=$setdata['auto_check'];

$sql = "select * from web_agents where Agname='$default_agent'";

$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	exit;
}
$agname=$row['Agname'];
$agid=$row['ID'];
$super=$row['super'];
$corprator=$row['corprator'];
$world=$row['world'];
$credit=$row['Credit'];
$count=$row['count'];
$keys=$_REQUEST['keys'];


$type="C";


if ($keys=='add'){

	while (list($key, $value) = each($row)) {

		if (preg_match("/Scene/i",$key) || preg_match ("/Bet/i",$key) || preg_match ("/Turn/i",$key)){
			$tt=split('_',$key);
			$cou=count($tt);

			if (preg_match("/_Turn/i",$key)){

				if($cou==4 && $tt[3]=="$type"){
					$skey=$skey==''?str_replace("_$type",'',$key):$skey.','.str_replace("_$type",'',$key);
					$svalue=$svalue==''?$value:$svalue."','".$value;
				}else if($cou==3){
					$skey=$skey==''?$key:$skey.','.$key;
					$svalue=$svalue==''?$value:$svalue."','".$value;
				}else{
					//$skey=$skey==''?$key:$skey.','.$key;
					//$svalue=$svalue==''?$value:$svalue."','".$value;
				}
			}else{
				$skey=$skey==''?$key:$skey.','.$key;
				$svalue=$svalue==''?$value:$svalue."','".$value;
			}
		}

	}
	
	$AddDate=date('Y-m-d H:i:s');
	$memname=$_REQUEST['username'];
	$mempasd=$_REQUEST['password'];
	$currency=$_REQUEST['currency'];
	$address=$_REQUEST['address1'].$_REQUEST['address2'].$_REQUEST['address3'].$_REQUEST['address4'];
	$pay_type='1';
	$type='C';
	$alias=$_REQUEST['alias'];
	$maxcredit=0;
	$ratio=1;

	$chk=chk_pwd($mempasd);

	$mysql="select sum(Credit) as credit,count(*) as count from web_member where Agents='$agname'";//and status=1";
	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);
	



		$mysql="select * from web_member where memname='$memname'";
		$result = mysql_query($mysql);
		$count=mysql_num_rows($result);
		if ($count>0){
			echo "<script languag='JavaScript'>alert('您输入的帐号 $memname 已经有人使用了，请回上一页重新输入');history.go(-1);</script>";
			exit;
		}else{
			if ($pay_type==1){
				$maxcredit=0;
			}
			$mysql="insert into web_member(super,Memname,loginname,Passwd,Credit,Money,Alias,Agents,Opentype,addDate,lastpawd,corprator,world,pay_type,address,$skey) values ('$super','$memname','$memname','$mempasd','$maxcredit','$maxcredit','$alias','$agname','$type','$AddDate','$AddDate','$corprator','$world','$pay_type','$address','$svalue')";
			//echo $mysql;exit;
			mysql_query($mysql) or die ("操作失败11111!");
			$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','新增','$memname','会员',5)";
			mysql_query($mysql) or die ("操作失败!");
			echo "<script languag='JavaScript'>alert('会员注册成功！请登陆进入。');self.location='./index.php'</script>";
		}

}
?>
<body>
</body>
</html>
