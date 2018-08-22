<?php
include "./include/library.mem.php";
require ("./include/define_function_list.inc.php");
require ("./include/config.inc.php");

$memname	=	htmlspecialchars( trim($_REQUEST['username']) );
$mempasd	=	htmlspecialchars( trim($_REQUEST['passwd']) );
$memname    =   addslashes( $memname );
$mempasd    =   addslashes( $mempasd );
$langx		=	$_REQUEST['langx'];
$uid = !empty($_REQUEST['uid'])?$_REQUEST['uid']:'';
$mtype = !empty($_REQUEST['mtype'])?$_REQUEST['mtype']:'';

$mysql = "select * from web_system";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$runball=$row['runball'];
$liveid=$row['liveid'];
if($uid==""){
	$sql = "select id from `web_member` where Memname='".$memname."' and loginname='' and Passwd = '".$mempasd."'";
	$result = mysql_query($sql);
	$cou=mysql_num_rows($result);
	if($cou>0){
// 200|100|asdasd|$uid|$mtype|$langx
		echo "200|104||$uid|$mtype|$langx";
		exit;
	}
	
	$sql = 'select id,memname, pay_type, passwd,setip, credit, lastpawd,if((time_to_sec(lastpawd)-time_to_sec(adddate)=0 or datediff(now(),lastpawd)>30),1,0) as chg_pawd,if(UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(logdate)>180,0,1) as timeout'
			. ' from `web_member` '
			. " where loginname = '".$memname."' and passwd = '".$mempasd."' and "
			. '(Status=1 or Status=2)';

	$result = mysql_query($sql);
	$cou=mysql_num_rows($result);
	if($cou==0){
		switch($langx){
			case 'zh-vn':
				$lang_err="Tài khoản hoặc mật khẩu bạn đã nhập không đúng. Vui lòng thử lại.";
				break;
			case 'zh-cn':
				$lang_err="您输入的帐号或密码不正确，请再尝试输入。";
				break;
			default:
				$lang_err="Invalid username or password try again!";
			break;
		}
		echo "100||$lang_err";
		exit;
	}else{
	
		$row = mysql_fetch_array($result);
		$credit		=	$row['credit'];
		$logdate	=	date("Y-m-d");
		$id			=	$row['id'];
		$memname	=	$row['memname'];
		$chg_pawd	=	$row['chg_pawd'];

		$str = time('s');
		$uid=substr(md5($str),0,14).'l'.(int)substr($id*rand(),1,6);
	
		$ip_addr = strlen($row['setip'])>6 ? $row['setip'] : $_SERVER['REMOTE_ADDR'];

		if($runball==1){
			$sql="update web_member set oid='' where logip='$ip_addr'";
			mysql_query($sql);
		}
		
		if ($row['pay_type']==0){
			$sql="select sum(betscore) as betscore from web_db_io where m_date>='$logdate' and m_name='".$memname."' and hidden=0";
			$result1 = mysql_query($sql);
			$row1 = mysql_fetch_array($result1);
			$credit=$credit-$row1['betscore'];
			if($credit<0){$credit=0;}
			$sql="update web_member set oid='$uid',logdate=now(),active=now(), money='$credit',logip='$ip_addr',domain='$_SERVER[HTTP_HOST]',language='$langx' where id='$id'";
		}else{
			$sql="update web_member set oid='$uid',logdate=now(),active=now(),logip='$ip_addr',domain='$_SERVER[HTTP_HOST]',language='$langx' where id=$id";
		}
		
		mysql_query($sql);
		if($mtype==""){
			$mtype=3;
		}
		//存放登录日志txt文件方式
		//userlog($memname);
		
		mysql_query("update message set readcount=readcount+1 where member='".$memname."' limit 1");
		$sql = "select message,message_tw from message where member='".$memname."' limit 0,1";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$cou=mysql_num_rows($result);

		if($chg_pawd==1){
			echo "200|106||$uid|$mtype|$langx";
			exit;
		}else{
			echo "200|100||$uid|$mtype|$langx";
			exit;
		}

	}
	
}else{//如果$uid不为空
	echo "200|100||$uid|$mtype|$langx";
	exit;
}
?>
