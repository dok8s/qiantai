<?php
function hour_option($selected)
{
	for($i=0;$i<=23;$i++){
		$select=($selected==$i)?'selected':'';
		if (strlen($i) < 2)
			$rs.= '<option '.$select.'>0'.$i;
		else
			$rs.= '<option '.$select.'>'.$i;
	}
	return $rs;
}
function minute_option($selected)
{
	for($i=0;$i<=59;$i++){
		$select=($selected==$i)?'selected':'';
		if (strlen($i) < 2)
			$rs.= '<option '.$select.'>0'.$i;
		else
			$rs.= '<option '.$select.'>'.$i;
	}
	return $rs;
}
function code($length){
   	$pattern = '1234567890'; //字符池
   	for($i=0;$i<$length;$i++)
    {
    	$key .= $pattern{mt_rand(0,10)}; //生成php随机数
	}
	if (strlen($key)<$length)
	{
		for($i=0;$i<($length-strlen($key));$i++)
		{
			$v.="0";
		}
	}
	return $v.$key;  //返回key值
}
?>