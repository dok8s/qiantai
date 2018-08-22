<?
$global_vars = array(
	"BROWSER_IP"		=>	"http://".$_SERVER['SERVER_NAME'],
	"CASINO"        =>      "SI2",
	"FILE_PATH"				=>	substr($_SERVER['DOCUMENT_ROOT'],0,strlen($_SERVER['DOCUMENT_ROOT'])-6),
	"WEB_PATH"	        	=>	$_SERVER['DOCUMENT_ROOT'],
	"REMOTE_ADDR"			=>	$_SERVER['REMOTE_ADDR'],
	"HTTP_USER_AGENT"		=>	$_SERVER['HTTP_USER_AGENT'],
	"HTTP_ACCEPT_LANGUAGE"	=>	$_SERVER['HTTP_ACCEPT_LANGUAGE'],
	"WEB_TIME_ZONE"         =>  -4,
);

while (list($key, $value) = each($global_vars)) {
  define($key, $value);
}

foreach ($_GET as $get_key=>$get_var)
{
    if (is_numeric($get_var))
 if (is_numeric($get_var)) {
  $get[strtolower($get_key)] = get_int($get_var);
 } else {
  $get[strtolower($get_key)] = get_str($get_var);
 }
}

/* POSTı */
foreach ($_POST as $post_key=>$post_var)
{
 if (is_numeric($post_var)) {
  $post[strtolower($post_key)] = get_int($post_var);
 } else {
  $post[strtolower($post_key)] = get_str($post_var);
 }
}


/* ˺ */
//͹˺
function get_int($number)
{
    return intval($number);
}
//ַ͹˺
function get_str($string)
{
    return addslashes($string);
}

// 分页
$offset = 15;
// 返回数据格式
$info=array(
    'state'=>0,
    'info'=>array(),
    'msg'=>'',
    'url'=>'',
    'do_cancel'=>0,
    'debug'=>null,
);

?>
