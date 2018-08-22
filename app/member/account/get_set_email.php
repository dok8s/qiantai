<?php

include "../include/library.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
$time = time();
$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
$myVerify = !empty($_REQUEST['myVerify'])?$_REQUEST['myVerify']:'';
$setEmail = !empty($_REQUEST['setEmail'])?$_REQUEST['setEmail']:'';
$action = !empty($_REQUEST['action'])?$_REQUEST['action']:'';
$getEmail = !empty($_REQUEST['getEmail'])?$_REQUEST['getEmail']:'';

//判断用户登入状态
$memname=IsMemberAjax($uid);
//$langx=$row['language'];
require ("../include/traditional.$langx.inc.php");

$info['state'] = 1;
$info['langx'] = $langx;
$info['info']['action'] = $action;
// 发送邮件
if($getEmail == 1){
    $body='';
    $verifycode = randomCode(3);
    $sqlVerify = "INSERT INTO verifycode (email, value, time) VALUES ('$setEmail','$verifycode','$time')";
    mysql_query($sqlVerify);
    $body = $verifycode;
    // sendMail($setEmail,$memname,$pass_recovery,$body);
}
if($action == 'chkVerify'){
    $sql = "select * from verifycode where value='$myVerify' and email='$setEmail' and state=0";
    $result = mysql_query($sql);
    $cou=mysql_num_rows($result);

    if($cou == 0){
        $info['state'] = 0;
        $info['bug'] = $sql;
        $info['msg'] = $str_checknum;
        echo json_encode($info);
        exit;
    }
    $sqlUpdate = "UPDATE web_member SET email = '$setEmail' WHERE Oid='$uid'";
    mysql_query($sqlUpdate);
    $sql = "UPDATE verifycode SET state=1 where email='$setEmail' and state=0";
    mysql_query($sql);
}
mysql_close();
echo json_encode($info);exit;

?>

