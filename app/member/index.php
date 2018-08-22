<?
class Template
{
	private $args;
	private $file;

	public function __get($name)
	{
		return $this->args[$name];
	}

	public function __construct($file, $args = array())
	{
		$this->file = $file;
		$this->args = $args;
	}

	public function render()
	{
		include $this->file;
	}
}


include "./include/library.mem.php";



$str   = time();
$uid = !empty($_REQUEST['uid'])?$_REQUEST['uid']:'';
$mtype=!empty($_REQUEST['mtype'])?$_REQUEST['mtype']:'';
$langx=!empty($_REQUEST['langx'])?$_REQUEST['langx']:'';
if ($uid=='') {
	$uid = substr(md5($str), 0, 8);
}
if ($langx=='') {
	$langx = "zh-cn";
}

if($mtype=="") {
	echo "<script>if(self == top) parent.location='" . BROWSER_IP . "'</script>\n";
	if ($langx == 'zh-vn') {
		include('../../tpl/member/zh-vn/index.html');
	} else if ($langx == 'en-us') {
		include('../../tpl/member/en-us/index.html');
	} else if ($langx == 'th-tis') {
		include('../../tpl/member/th-tis/index.html');
	} else {
		include('../../tpl/member/zh-cn/index.html');
	}
}
else {
	header("Location:login.php?uid=$uid&mtype=$mtype&langx=$langx");
}
?>
<script>top.game_alert='';</script>
