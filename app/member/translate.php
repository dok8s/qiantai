<?
$uid = !empty($_REQUEST['uid'])?$_REQUEST['uid']:'';
$langx=!empty($_REQUEST['set'])?$_REQUEST['set']:'';
$sw3=$_REQUEST["url"].'?uid='.$uid.'&langx='.$langx;
echo "<SCRIPT language='javascript'>self.location='$sw3';</script>";
//Header("Location:$sw3"); 
?>
